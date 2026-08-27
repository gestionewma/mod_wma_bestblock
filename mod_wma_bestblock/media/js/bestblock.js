/**
 * WMA BestBlock · Script — mod_wma_bestblock
 * Gestisce la navigazione tra i Set del bento-grid.
 * Supporta istanze multiple sulla stessa pagina.
 *
 * @version 1.0.21
 */

const ANIM_CLASSES = [
    'anim-scale', 'anim-up1', 'anim-up2', 'anim-up3', 'anim-up4',
    'anim-up5', 'anim-up6', 'anim-up7', 'anim-left', 'anim-right',
    'anim-slide-right', 'anim-slide-down', 'anim-slide-left', 'anim-slide-up',
    'anim-text-slide-right', 'anim-text-slide-down', 'anim-text-slide-left', 'anim-text-slide-up',
];

function hexToRgba(hex, alpha) {
    const r = parseInt(hex.slice(1, 3), 16);
    const g = parseInt(hex.slice(3, 5), 16);
    const b = parseInt(hex.slice(5, 7), 16);
    return `rgba(${r}, ${g}, ${b}, ${alpha})`;
}

function normalizeImageSrc(src) {
    if (!src) return '';

    let clean = String(src).trim();
    if (!clean) return '';

    clean = clean.split('#')[0];
    clean = clean.split('?')[0];

    if (/^(?:[a-z][a-z0-9+.-]*:)?\/\//i.test(clean) || /^[a-z][a-z0-9+.-]*:/i.test(clean)) {
        return clean;
    }

    return clean.startsWith('/') ? clean : '/' + clean.replace(/^\/+/, '');
}

function setImgEl(el, src, alt) {
    if (!el) return;
    el.src           = normalizeImageSrc(src);
    el.alt           = alt || '';
    el.style.display = normalizeImageSrc(src) ? '' : 'none';
}

function setTextEl(el, text) {
    if (!el) return;
    el.textContent = text || '';
}

function initBestblock(wrapper) {
    const moduleId = wrapper.id.replace('wma-bestblock-', '');
    const dataEl   = document.getElementById('wma-bestblock-' + moduleId + '-data');
    const grid     = document.getElementById('wma-bestblock-' + moduleId + '-grid');

    if (!dataEl || !grid) return;

    let sets;
    try {
        sets = JSON.parse(dataEl.textContent);
    } catch (e) {
        return;
    }

    if (!sets || !sets.length) return;

    const autoplay       = grid.dataset.autoplay === '1';
    const delay          = parseInt(grid.dataset.delay, 10) || 6000;
    const showMouseGlow  = wrapper.dataset.mouseGlow === '1';
    const setCount       = sets.length;

    let current = 0;
    let busy    = false;
    let timer   = null;

    // ── Riferimenti DOM ──────────────────────────────────────────────────
    const q = (sel) => grid.querySelector(sel);

    const dom = {
        imgB1:      q('[data-block="b1"] .cell-cover'),
        imgB2:      q('[data-block="b2"] .cell-cover'),
        imgB3:      q('[data-block="b3"] .cell-cover'),
        // B3 overlay
        b3Title:    q('[data-block="b3"] .b3-overlay .bb-title'),
        b3Subtitle: q('[data-block="b3"] .b3-overlay .bb-subtitle'),
        b3Paragraph:q('[data-block="b3"] .b3-overlay .bb-paragraph'),
        b3Link:     q('[data-block="b3"] .b3-overlay .bb-link'),
        imgB4:      q('[data-block="b4"] .cell-cover'),
        imgB5:      q('[data-block="b5"] .cell-cover'),
        // B5 overlay
        b5Title:    q('[data-block="b5"] .b5-overlay .bb-title'),
        b5Subtitle: q('[data-block="b5"] .b5-overlay .bb-subtitle'),
        b5Paragraph:q('[data-block="b5"] .b5-overlay .bb-paragraph'),
        b5Link:     q('[data-block="b5"] .b5-overlay .bb-link'),
        imgB6:      q('[data-block="b6"] .cell-cover'),
        // B6 overlay
        b6Title:    q('[data-block="b6"] .b6-overlay .bb-title'),
        b6Subtitle: q('[data-block="b6"] .b6-overlay .bb-subtitle'),
        b6Paragraph:q('[data-block="b6"] .b6-overlay .bb-paragraph'),
        b6Link:     q('[data-block="b6"] .b6-overlay .bb-link'),
        imgB7:      q('[data-block="b7"] .cell-cover'),
        imgB8:      q('[data-block="b8"] .cell-cover'),
        // B1 overlay text
        b1Subtitle: q('[data-block="b1"] .hero-overlay .bb-subtitle'),
        b1Title:    q('[data-block="b1"] .hero-overlay .bb-title'),
        b1Paragraph:q('[data-block="b1"] .hero-overlay .bb-paragraph'),
        counter:    q('[data-block="b1"] .hero-counter'),
        // B1 link
        b1Link:     q('[data-block="b1"] .hero-overlay .bb-link'),
        // B2
        b2Subtitle: q('[data-block="b2"] .bb-subtitle'),
        b2Title:    q('[data-block="b2"] .bb-title'),
        b2Paragraph:q('[data-block="b2"] .bb-paragraph'),
        b2Link:     q('[data-block="b2"] .bb-link'),
        // B4
        b4Subtitle: q('[data-block="b4"] .bb-subtitle'),
        b4Title:    q('[data-block="b4"] .bb-title'),
        b4Paragraph:q('[data-block="b4"] .bb-paragraph'),
        b4Link:     q('[data-block="b4"] .bb-link'),
        // B7
        b7Subtitle: q('[data-block="b7"] .bb-subtitle'),
        b7Title:    q('[data-block="b7"] .bb-title'),
        b7Paragraph:q('[data-block="b7"] .bb-paragraph'),
        b7Link:     q('[data-block="b7"] .bb-link'),
        // B8 overlay
        b8Subtitle: q('[data-block="b8"] .food-overlay .bb-subtitle'),
        b8Title:    q('[data-block="b8"] .food-overlay .bb-title'),
        b8Paragraph:q('[data-block="b8"] .food-overlay .bb-paragraph'),
        b8Link:     q('[data-block="b8"] .food-overlay .bb-link'),
        // B9
        b9Label:    q('[data-block="b9"] .bb-b9-label'),
        // B10, B11
        b10Label:   q('[data-block="b10"] .bb-b10-label'),
        b11Label:   q('[data-block="b11"] .bb-b11-label'),
        // Pulsanti navigazione
        btnPrev:    q('[data-block="b10"]'),
        btnNext:    q('[data-block="b11"]'),
        // Bagliore
        glow:       wrapper.querySelector('.wma-bestblock-glow'),
    };

    // ── Applica i dati di un set ────────────────────────────────────────
    function applySet(set) {
        // Immagini
        setImgEl(dom.imgB1, set.b1_image_src, set.b1_image_alt);
        setImgEl(dom.imgB2, set.b2_image_src, set.b2_image_alt);
        setImgEl(dom.imgB3, set.b3_image_src, set.b3_image_alt);
        setTextEl(dom.b3Title,    set.b3_title);
        setTextEl(dom.b3Subtitle, set.b3_subtitle);
        setTextEl(dom.b3Paragraph,set.b3_paragraph);
        updateLink(dom.b3Link, set.b3_link_href);
        setImgEl(dom.imgB4, set.b4_image_src, set.b4_image_alt);
        setImgEl(dom.imgB5, set.b5_image_src, set.b5_image_alt);
        setTextEl(dom.b5Title,    set.b5_title);
        setTextEl(dom.b5Subtitle, set.b5_subtitle);
        setTextEl(dom.b5Paragraph,set.b5_paragraph);
        updateLink(dom.b5Link, set.b5_link_href);
        setImgEl(dom.imgB6, set.b6_image_src, set.b6_image_alt);
        setTextEl(dom.b6Title,    set.b6_title);
        setTextEl(dom.b6Subtitle, set.b6_subtitle);
        setTextEl(dom.b6Paragraph,set.b6_paragraph);
        updateLink(dom.b6Link, set.b6_link_href);
        setImgEl(dom.imgB7, set.b7_image_src, set.b7_image_alt);
        setImgEl(dom.imgB8, set.b8_image_src, set.b8_image_alt);

        // Counter
        if (dom.counter) {
            const cur = String(current + 1).padStart(2, '0');
            const tot = String(setCount).padStart(2, '0');
            dom.counter.textContent = cur + ' / ' + tot;
        }

        // B1 testi
        setTextEl(dom.b1Subtitle,  set.b1_subtitle);
        setTextEl(dom.b1Title,     set.b1_title);
        setTextEl(dom.b1Paragraph, set.b1_paragraph);
        updateLink(dom.b1Link, set.b1_link_href);

        // B2
        setTextEl(dom.b2Subtitle,  set.b2_subtitle);
        setTextEl(dom.b2Title,     set.b2_title);
        setTextEl(dom.b2Paragraph, set.b2_paragraph);
        updateLink(dom.b2Link, set.b2_link_href);

        // B4
        setTextEl(dom.b4Subtitle,  set.b4_subtitle);
        setTextEl(dom.b4Title,     set.b4_title);
        setTextEl(dom.b4Paragraph, set.b4_paragraph);
        updateLink(dom.b4Link, set.b4_link_href);

        // B7
        setTextEl(dom.b7Subtitle,  set.b7_subtitle);
        setTextEl(dom.b7Title,     set.b7_title);
        setTextEl(dom.b7Paragraph, set.b7_paragraph);
        updateLink(dom.b7Link, set.b7_link_href);

        // B8 overlay
        setTextEl(dom.b8Subtitle,  set.b8_subtitle);
        setTextEl(dom.b8Title,     set.b8_title);
        setTextEl(dom.b8Paragraph, set.b8_paragraph);
        updateLink(dom.b8Link, set.b8_link_href);

        // Pulsanti
        setTextEl(dom.b9Label,  set.b9_label);
        setTextEl(dom.b10Label, set.b10_label);
        setTextEl(dom.b11Label, set.b11_label);

        // Aggiorna href di B9 se è un <a>
        if (dom.b9Label && dom.b9Label.tagName === 'A') {
            dom.b9Label.href = set.b9_link_href || '#';
        }
    }

    // ── Aggiorna href di un elemento link (se esiste) ──────────────────
    function updateLink(el, href) {
        if (!el || el.tagName !== 'A') return;
        el.href = href || '#';
    }

    // ── Applica schema colori ───────────────────────────────────────────
    function applyColors(set) {
        const bg        = set.color_bg        || '#2a2218';
        const secondary = set.color_secondary  || '#6b5344';
        const textColor = set.color_text       || '#ffffff';

        wrapper.style.setProperty('--bg-main', bg);
        wrapper.style.background = bg;
        grid.style.setProperty('--block-bg',    hexToRgba(secondary, 0.85));
        grid.style.setProperty('--text-color',  textColor);
        grid.style.setProperty('--text-shadow', set.text_shadow || 'none');
    }

    // ── Replay animazioni (rimuovi + riaggiunge le classi CSS) ──────────
    function replayAnimations() {
        grid.querySelectorAll('.cell, .hero-overlay, .food-overlay, .cell-nav-pair').forEach((el) => {
            const active = ANIM_CLASSES.filter((c) => el.classList.contains(c));
            if (!active.length) return;
            active.forEach((c) => el.classList.remove(c));
            void el.offsetWidth; // reflow per resettare l'animazione
            active.forEach((c) => el.classList.add(c));
        });
    }

    // ── Naviga a un set (direzione: +1 avanti, -1 indietro) ────────────
    function goTo(direction) {
        if (busy || setCount <= 1) return;
        busy = true;

        grid.style.transition = 'opacity 0.22s ease';
        grid.style.opacity    = '0';

        setTimeout(() => {
            current = (current + direction + setCount) % setCount;
            applySet(sets[current]);
            applyColors(sets[current]);
            grid.style.opacity = '1';

            setTimeout(() => {
                grid.style.transition = '';
                replayAnimations();
                busy = false;
            }, 30);
        }, 240);
    }

    // ── Autoplay ─────────────────────────────────────────────────────────
    function startAutoplay() {
        if (!autoplay || setCount <= 1) return;
        timer = setInterval(() => goTo(1), delay);
    }

    function stopAutoplay() {
        if (timer) {
            clearInterval(timer);
            timer = null;
        }
    }

    // ── Event listener navigazione ───────────────────────────────────────
    if (dom.btnPrev) {
        dom.btnPrev.addEventListener('click', () => { stopAutoplay(); goTo(-1); startAutoplay(); });
        dom.btnPrev.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); stopAutoplay(); goTo(-1); startAutoplay(); }
        });
    }

    if (dom.btnNext) {
        dom.btnNext.addEventListener('click', () => { stopAutoplay(); goTo(1); startAutoplay(); });
        dom.btnNext.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); stopAutoplay(); goTo(1); startAutoplay(); }
        });
    }

    wrapper.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowRight' || e.key === 'ArrowDown') { stopAutoplay(); goTo(1);  startAutoplay(); }
        if (e.key === 'ArrowLeft'  || e.key === 'ArrowUp')   { stopAutoplay(); goTo(-1); startAutoplay(); }
    });

    // ── Bagliore mouse ───────────────────────────────────────────────────
    if (dom.glow && showMouseGlow) {
        dom.glow.style.display = '';
        wrapper.addEventListener('mousemove', (e) => {
            const rect = wrapper.getBoundingClientRect();
            const x    = e.clientX - rect.left;
            const y    = e.clientY - rect.top;
            dom.glow.style.transform = `translate(${x}px, ${y}px)`;
        });
    }

    // ── Inizializzazione ─────────────────────────────────────────────────
    applyColors(sets[0]);
    startAutoplay();
}

// Inizializza tutte le istanze presenti nella pagina
document.querySelectorAll('.wma-bestblock-wrapper').forEach(initBestblock);
