<?php

/**
 * @package     Wma.Module.WmaBestblock
 * @subpackage  mod_wma_bestblock
 *
 * @author      Team Developer by WMA Web Maker Agency <wmaextension@gmail.com>
 * @copyright   (C) 2026 WMA Web Maker Agency. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 * @link        https://www.wma.ovh
 * @version     1.0.22
 * @date        27/08/2026
 * @file        tmpl/default.php
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

/** @var \Joomla\CMS\Module\Module  $module */
/** @var \Joomla\Registry\Registry $params */
/** @var array                     $sets */
/** @var int                       $heightValue */
/** @var string                    $heightUnit */
/** @var bool                      $autoplay */
/** @var int                       $delay */
/** @var bool                      $showMouseGlow */
/** @var bool                      $showBlockNumbers */

if (empty($sets)) {
    return;
}

$modId       = (int) $module->id;
$heightStyle = (int) $heightValue . htmlspecialchars($heightUnit, ENT_QUOTES, 'UTF-8');
$setCount    = count($sets);

// Prima slide da pre-renderizzare nell'HTML
$s = $sets[0];

// Colori iniziali come CSS custom properties inline
$bgMain     = htmlspecialchars($s->color_bg, ENT_QUOTES, 'UTF-8');
$blockBg    = htmlspecialchars($s->color_secondary, ENT_QUOTES, 'UTF-8');
$textColor  = htmlspecialchars($s->color_text, ENT_QUOTES, 'UTF-8');
$textShadow = htmlspecialchars($s->text_shadow, ENT_QUOTES, 'UTF-8');

// JSON di tutti i set per il JS (sicuro: flag HTML-safe)
$setsJson = json_encode($sets, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE);

// Closure: costruisce un link wrapper opzionale (closure per evitare redeclare su istanze multiple)
$bbLink = static function (string $href, string $content): string {
    if ($href === '') {
        return $content;
    }
    return '<a href="' . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') . '" class="bb-link">' . $content . '</a>';
};

// Closure: rende testo con tag dinamico e stile opzionale (i tag vengono sanificati nel Helper)
$bbText = static function (string $tag, string $cssClass, string $text, string $style = ''): string {
    $styleAttr = $style !== '' ? ' style="' . htmlspecialchars($style, ENT_QUOTES, 'UTF-8') . '"' : '';

    return '<' . $tag . ' class="' . $cssClass . '"' . $styleAttr . '>'
        . htmlspecialchars($text, ENT_QUOTES, 'UTF-8')
        . '</' . $tag . '>';
};

// Closure: restituisce l'href solo se il tag è h2, altrimenti stringa vuota (nessun link)
$h2Link = static function (string $tag, string $href): string {
    return $tag === 'h2' ? $href : '';
};

?>

<!-- JSON dati set per il JS — nascosto nel DOM -->
<script type="application/json" id="wma-bestblock-<?php echo $modId; ?>-data"><?php echo $setsJson; ?></script>

<div class="wma-bestblock-wrapper"
     id="wma-bestblock-<?php echo $modId; ?>"
     style="height:<?php echo $heightStyle; ?>;--bg-main:<?php echo $bgMain; ?>;background:<?php echo $bgMain; ?>"
     data-mouse-glow="<?php echo $showMouseGlow ? '1' : '0'; ?>">

    <!-- Bagliore interattivo al mouse -->
    <div class="wma-bestblock-glow"<?php echo $showMouseGlow ? '' : ' style="display:none"'; ?>></div>

    <div class="bento-wrapper">
        <div class="bento-grid"
             id="wma-bestblock-<?php echo $modId; ?>-grid"
             style="--block-bg:<?php echo $blockBg; ?>;--text-color:<?php echo $textColor; ?>;--text-shadow:<?php echo $textShadow; ?>"
             data-module-id="<?php echo $modId; ?>"
             data-autoplay="<?php echo $autoplay ? '1' : '0'; ?>"
             data-delay="<?php echo (int) $delay; ?>"
             data-set-count="<?php echo $setCount; ?>">

            <!-- ── B1 · HERO — col 1-2, righe 1-2 ──────────────────── -->
            <div class="cell cell-b1 anim-slide-right" data-block="b1">
                <img class="cell-cover"
                     src="<?php echo htmlspecialchars($s->b1_image_src, ENT_QUOTES, 'UTF-8'); ?>"
                     alt="<?php echo htmlspecialchars($s->b1_image_alt, ENT_QUOTES, 'UTF-8'); ?>"
                     loading="eager"<?php echo $s->b1_image_src === '' ? ' style="display:none"' : ''; ?>>
                <?php if ($showBlockNumbers) : ?><div class="block-num"><?php echo htmlspecialchars($s->b1_paragraph, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
                <div class="hero-overlay anim-text-slide-right">
                    <?php echo $bbLink($h2Link($s->b1_title_tag, $s->b1_link_href), $bbText($s->b1_title_tag, 'bb-title', $s->b1_title, $s->b1_title_size !== '' ? 'font-size:' . $s->b1_title_size . 'rem' : '')); ?>
                    <?php echo $bbLink($h2Link($s->b1_subtitle_tag, $s->b1_link_href), $bbText($s->b1_subtitle_tag, 'tag bb-subtitle', $s->b1_subtitle, $s->b1_subtitle_size !== '' ? 'font-size:' . $s->b1_subtitle_size . 'rem' : '')); ?>
                </div>
            </div>

            <!-- ── B2 · CARD TESTO — col 3, riga 1 ─────────────────── -->
            <div class="cell cell-b2 anim-slide-down" data-block="b2">
                <img class="cell-cover"
                     src="<?php echo htmlspecialchars($s->b2_image_src, ENT_QUOTES, 'UTF-8'); ?>"
                     alt="<?php echo htmlspecialchars($s->b2_image_alt, ENT_QUOTES, 'UTF-8'); ?>"
                     loading="lazy"<?php echo $s->b2_image_src === '' ? ' style="display:none"' : ''; ?>>
                <?php if ($showBlockNumbers) : ?><div class="block-num"><?php echo htmlspecialchars($s->b2_paragraph, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
                <div class="card-label anim-text-slide-down">
                    <?php echo $bbLink($h2Link($s->b2_title_tag, $s->b2_link_href), $bbText($s->b2_title_tag, 'bb-title', $s->b2_title, $s->b2_title_size !== '' ? 'font-size:' . $s->b2_title_size . 'rem' : '')); ?>
                    <?php echo $bbLink($h2Link($s->b2_subtitle_tag, $s->b2_link_href), $bbText($s->b2_subtitle_tag, 'tag bb-subtitle', $s->b2_subtitle, $s->b2_subtitle_size !== '' ? 'font-size:' . $s->b2_subtitle_size . 'rem' : '')); ?>
                </div>
            </div>

            <!-- ── B3 · IMMAGINE + OVERLAY — col 4, righe 1-2 ─────── -->
            <div class="cell cell-b3 anim-slide-down" data-block="b3">
                <img class="cell-cover"
                     src="<?php echo htmlspecialchars($s->b3_image_src, ENT_QUOTES, 'UTF-8'); ?>"
                     alt="<?php echo htmlspecialchars($s->b3_image_alt, ENT_QUOTES, 'UTF-8'); ?>"
                     loading="lazy"<?php echo $s->b3_image_src === '' ? ' style="display:none"' : ''; ?>>
                <?php if ($showBlockNumbers) : ?><div class="block-num"><?php echo htmlspecialchars($s->b3_paragraph, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
                <div class="b3-overlay anim-text-slide-up">
                    <?php echo $bbLink($h2Link($s->b3_title_tag, $s->b3_link_href), $bbText($s->b3_title_tag, 'bb-title', $s->b3_title, $s->b3_title_size !== '' ? 'font-size:' . $s->b3_title_size . 'rem' : '')); ?>
                    <?php echo $bbLink($h2Link($s->b3_subtitle_tag, $s->b3_link_href), $bbText($s->b3_subtitle_tag, 'tag bb-subtitle', $s->b3_subtitle, $s->b3_subtitle_size !== '' ? 'font-size:' . $s->b3_subtitle_size . 'rem' : '')); ?>
                </div>
            </div>

            <!-- ── B4 · TESTO — col 1, riga 3 ──────────────────────── -->
            <div class="cell cell-b4 anim-slide-left" data-block="b4">
                <img class="cell-cover"
                     src="<?php echo htmlspecialchars($s->b4_image_src, ENT_QUOTES, 'UTF-8'); ?>"
                     alt="<?php echo htmlspecialchars($s->b4_image_alt, ENT_QUOTES, 'UTF-8'); ?>"
                     loading="lazy"<?php echo $s->b4_image_src === '' ? ' style="display:none"' : ''; ?>>
                <?php if ($showBlockNumbers) : ?><div class="block-num"><?php echo htmlspecialchars($s->b4_paragraph, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
                <div class="block-label anim-text-slide-left">
                    <?php echo $bbLink($h2Link($s->b4_title_tag, $s->b4_link_href), $bbText($s->b4_title_tag, 'bb-title', $s->b4_title, $s->b4_title_size !== '' ? 'font-size:' . $s->b4_title_size . 'rem' : '')); ?>
                    <?php echo $bbLink($h2Link($s->b4_subtitle_tag, $s->b4_link_href), $bbText($s->b4_subtitle_tag, 'tag bb-subtitle', $s->b4_subtitle, $s->b4_subtitle_size !== '' ? 'font-size:' . $s->b4_subtitle_size . 'rem' : '')); ?>
                </div>
            </div>

            <!-- ── B5 · IMMAGINE — col 2, riga 3 ───────────────────── -->
            <div class="cell cell-b5 anim-slide-up" data-block="b5">
                <img class="cell-cover"
                     src="<?php echo htmlspecialchars($s->b5_image_src, ENT_QUOTES, 'UTF-8'); ?>"
                     alt="<?php echo htmlspecialchars($s->b5_image_alt, ENT_QUOTES, 'UTF-8'); ?>"
                     loading="lazy"<?php echo $s->b5_image_src === '' ? ' style="display:none"' : ''; ?>>
                <?php if ($showBlockNumbers) : ?><div class="block-num"><?php echo htmlspecialchars($s->b5_paragraph, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
                <div class="b5-overlay anim-text-slide-up">
                    <?php echo $bbLink($h2Link($s->b5_title_tag, $s->b5_link_href), $bbText($s->b5_title_tag, 'bb-title', $s->b5_title, $s->b5_title_size !== '' ? 'font-size:' . $s->b5_title_size . 'rem' : '')); ?>
                    <?php echo $bbLink($h2Link($s->b5_subtitle_tag, $s->b5_link_href), $bbText($s->b5_subtitle_tag, 'tag bb-subtitle', $s->b5_subtitle, $s->b5_subtitle_size !== '' ? 'font-size:' . $s->b5_subtitle_size . 'rem' : '')); ?>
                </div>
            </div>

            <!-- ── B6 · IMMAGINE — col 3, righe 2-3 ────────────────── -->
            <div class="cell cell-b6 anim-slide-right" data-block="b6">
                <img class="cell-cover"
                     src="<?php echo htmlspecialchars($s->b6_image_src, ENT_QUOTES, 'UTF-8'); ?>"
                     alt="<?php echo htmlspecialchars($s->b6_image_alt, ENT_QUOTES, 'UTF-8'); ?>"
                     loading="lazy"<?php echo $s->b6_image_src === '' ? ' style="display:none"' : ''; ?>>
                <?php if ($showBlockNumbers) : ?><div class="block-num"><?php echo htmlspecialchars($s->b6_paragraph, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
                <div class="b6-overlay anim-text-slide-up">
                    <?php echo $bbLink($h2Link($s->b6_title_tag, $s->b6_link_href), $bbText($s->b6_title_tag, 'bb-title', $s->b6_title, $s->b6_title_size !== '' ? 'font-size:' . $s->b6_title_size . 'rem' : '')); ?>
                    <?php echo $bbLink($h2Link($s->b6_subtitle_tag, $s->b6_link_href), $bbText($s->b6_subtitle_tag, 'tag bb-subtitle', $s->b6_subtitle, $s->b6_subtitle_size !== '' ? 'font-size:' . $s->b6_subtitle_size . 'rem' : '')); ?>
                </div>
            </div>

            <!-- ── B7 · CARD TESTO — col 3, riga 4 ─────────────────── -->
            <div class="cell cell-b7 anim-slide-up" data-block="b7">
                <img class="cell-cover"
                     src="<?php echo htmlspecialchars($s->b7_image_src, ENT_QUOTES, 'UTF-8'); ?>"
                     alt="<?php echo htmlspecialchars($s->b7_image_alt, ENT_QUOTES, 'UTF-8'); ?>"
                     loading="lazy"<?php echo $s->b7_image_src === '' ? ' style="display:none"' : ''; ?>>
                <?php if ($showBlockNumbers) : ?><div class="block-num"><?php echo htmlspecialchars($s->b7_paragraph, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
                <div class="card-label anim-text-slide-up">
                    <?php echo $bbLink($h2Link($s->b7_title_tag, $s->b7_link_href), $bbText($s->b7_title_tag, 'bb-title', $s->b7_title, $s->b7_title_size !== '' ? 'font-size:' . $s->b7_title_size . 'rem' : '')); ?>
                    <?php echo $bbLink($h2Link($s->b7_subtitle_tag, $s->b7_link_href), $bbText($s->b7_subtitle_tag, 'tag bb-subtitle', $s->b7_subtitle, $s->b7_subtitle_size !== '' ? 'font-size:' . $s->b7_subtitle_size . 'rem' : '')); ?>
                </div>
            </div>

            <!-- ── B8 · IMMAGINE + OVERLAY — col 4, righe 3-4 ──────── -->
            <div class="cell cell-b8 anim-slide-left" data-block="b8">
                <img class="cell-cover"
                     src="<?php echo htmlspecialchars($s->b8_image_src, ENT_QUOTES, 'UTF-8'); ?>"
                     alt="<?php echo htmlspecialchars($s->b8_image_alt, ENT_QUOTES, 'UTF-8'); ?>"
                     loading="lazy"<?php echo $s->b8_image_src === '' ? ' style="display:none"' : ''; ?>>
                <?php if ($showBlockNumbers) : ?><div class="block-num"><?php echo htmlspecialchars($s->b8_paragraph, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
                <div class="food-overlay anim-text-slide-up">
                    <?php echo $bbLink($h2Link($s->b8_title_tag, $s->b8_link_href), $bbText($s->b8_title_tag, 'bb-title', $s->b8_title, $s->b8_title_size !== '' ? 'font-size:' . $s->b8_title_size . 'rem' : '')); ?>
                    <?php echo $bbLink($h2Link($s->b8_subtitle_tag, $s->b8_link_href), $bbText($s->b8_subtitle_tag, 'tag bb-subtitle', $s->b8_subtitle, $s->b8_subtitle_size !== '' ? 'font-size:' . $s->b8_subtitle_size . 'rem' : '')); ?>
                </div>
            </div>

            <!-- ── B9 · PULSANTE AZIONE — col 1, riga 4 ─────────────── -->
            <div class="cell cell-b9 anim-slide-right" data-block="b9">
                <?php if (!empty($s->b9_link_href)) : ?>
                    <a href="<?php echo htmlspecialchars($s->b9_link_href, ENT_QUOTES, 'UTF-8'); ?>" class="btn-label bb-b9-label">
                        <?php echo htmlspecialchars($s->b9_label, ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                <?php else : ?>
                    <button type="button" class="btn-label bb-b9-label">
                        <?php echo htmlspecialchars($s->b9_label, ENT_QUOTES, 'UTF-8'); ?>
                    </button>
                <?php endif; ?>
            </div>

            <!-- ── B10 + B11 · PREV / NEXT — col 2, riga 4 ──────────── -->
            <div class="cell-nav-pair anim-slide-down">
                <div class="cell cell-b10" data-block="b10" role="button" tabindex="0"
                     aria-label="<?php echo Text::_('MOD_WMA_BESTBLOCK_PREV'); ?>">
                    <span class="btn-label bb-b10-label">
                        <?php echo htmlspecialchars($s->b10_label, ENT_QUOTES, 'UTF-8'); ?>
                    </span>
                </div>
                <div class="cell cell-b11" data-block="b11" role="button" tabindex="0"
                     aria-label="<?php echo Text::_('MOD_WMA_BESTBLOCK_NEXT'); ?>">
                    <span class="btn-label bb-b11-label">
                        <?php echo htmlspecialchars($s->b11_label, ENT_QUOTES, 'UTF-8'); ?>
                    </span>
                </div>
            </div>

        </div><!-- /bento-grid -->
    </div><!-- /bento-wrapper -->
</div><!-- /wma-bestblock-wrapper -->
