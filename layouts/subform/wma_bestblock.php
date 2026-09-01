<?php

/**
 * @package     Wma.Module.WmaBestblock
 * @subpackage  mod_wma_bestblock
 *
 * @author      Team Developer by WMA Web Maker Agency <wmaextension@gmail.com>
 * @copyright   (C) 2026 WMA Web Maker Agency. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 * @link        https://www.wma.ovh
 * @version     1.0.26
 * @date        01/09/2026
 * @file        layouts/subform/wma_bestblock.php
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

$data = $displayData;

$forms   = $data['forms']   ?? [];
$tmpl    = $data['tmpl']    ?? null;
$fieldId = $data['fieldId'] ?? '';
$buttons = $data['buttons'] ?? [];

$btnAdd    = !empty($buttons['add']);
$btnRemove = !empty($buttons['remove']) || !empty($buttons['delete']);
$btnMove   = !empty($buttons['move']);

$control = $data['field']->fieldname ?? 'sets';

$doc = Factory::getApplication()->getDocument();

$doc->addStyleDeclaration('
    .wma-bb-subform-wrapper .subform-repeatable-group {
        border: 1px solid #dee2e6;
        border-radius: 6px;
        margin-bottom: 14px;
        background: #fff;
    }
    .wma-bb-subform-wrapper .bb-set-header {
        background: #343a40;
        color: #fff;
        border-radius: 6px 6px 0 0;
        padding: 8px 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        font-size: 13px;
    }
    .wma-bb-subform-wrapper .bb-set-header .subform-collapse-row .icon-chevron-down {
        transition: transform .2s ease;
    }
    .wma-bb-subform-wrapper .bb-set-header .subform-collapse-row.collapsed .icon-chevron-down {
        transform: rotate(-90deg);
    }
    .wma-bb-subform-wrapper .bb-set-body {
        padding: 10px 14px 14px;
    }
    .wma-bb-subform-wrapper .bb-block-section {
        border: 1px solid #e9ecef;
        border-radius: 4px;
        margin-bottom: 8px;
    }
    .wma-bb-subform-wrapper .bb-block-header {
        border-bottom: 1px solid #e9ecef;
        padding: 5px 10px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #fff;
        background: #919191;
    }
    .wma-bb-subform-wrapper .bb-block-fields {
        padding: 8px 10px;
    }
    .wma-bb-subform-wrapper .bb-colors-row,
    .wma-bb-subform-wrapper .bb-row-2col,
    .wma-bb-subform-wrapper .bb-row-3col,
    .wma-bb-subform-wrapper .bb-row-4col {
        display: grid;
        gap: 8px;
        margin-bottom: 6px;
    }
    .wma-bb-subform-wrapper .bb-colors-row { grid-template-columns: repeat(3, 1fr); }
    .wma-bb-subform-wrapper .bb-row-2col   { grid-template-columns: repeat(2, 1fr); }
    .wma-bb-subform-wrapper .bb-row-3col   { grid-template-columns: repeat(3, 1fr); }
    .wma-bb-subform-wrapper .bb-row-4col   { grid-template-columns: repeat(4, 1fr); }
    .wma-bb-subform-wrapper .bb-row-2col > div,
    .wma-bb-subform-wrapper .bb-row-3col > div,
    .wma-bb-subform-wrapper .bb-row-4col > div { display: flex; flex-direction: column; }
    .wma-bb-subform-wrapper .bb-img-compact joomla-field-media .field-media-preview {
        height: 100px;
    }
    .wma-bb-subform-wrapper .bb-img-compact joomla-field-media .field-media-preview img {
        max-height: 100px !important;
        max-width: 100px !important;
        object-fit: cover !important;
    }
    .wma-bb-subform-wrapper .bb-blocks-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }
    .wma-bb-subform-wrapper .bb-blocks-grid > .bb-block-section {
        background: #fff;
    }
    .wma-bb-subform-wrapper .bb-blocks-grid > .bb-block-section:nth-child(4n + 1),
    .wma-bb-subform-wrapper .bb-blocks-grid > .bb-block-section:nth-child(4n + 4) {
        background: #d9d9d9;
    }
    .wma-bb-subform-wrapper .bb-buttons-row {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 8px;
    }
    .wma-bb-subform-wrapper .bb-block-columns {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 8px;
        align-items: start;
    }
    .wma-bb-subform-wrapper .bb-column-stack {
        display: grid;
        gap: 8px;
        min-width: 0;
        align-content: start;
    }
    .wma-bb-subform-wrapper .bb-accessiblemedia-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 8px;
        align-items: start;
    }
    .wma-bb-subform-wrapper .bb-accessiblemedia-cell .control-group {
        margin-bottom: 0;
    }
    .wma-bb-subform-wrapper .control-group { margin-bottom: 4px; }
    .wma-bb-subform-wrapper .control-label,
    .wma-bb-subform-wrapper .form-label {
        display: block;
        width: 100%;
        font-size: 11px !important;
        text-align: right;
        justify-content: flex-end;
    }
    .wma-bb-subform-wrapper .form-text {
        color: var(--secondary-color);
        margin-top: .25rem;
        font-size: 0.8em;
    }
    .wma-bb-subform-wrapper .subform-add { margin-top: 10px; }
    .wma-bb-subform-wrapper .subform-move-row { cursor: grab; }
    .wma-bb-subform-wrapper .subform-repeatable-group.bb-dragging { opacity: 0.45; }
    .wma-bb-subform-wrapper .subform-repeatable-group.bb-drag-over-top { border-top: 3px solid #0d6efd !important; }
    .wma-bb-subform-wrapper .subform-repeatable-group.bb-drag-over-bottom { border-bottom: 3px solid #0d6efd !important; }
    @media (max-width: 1600px) {
        .wma-bb-subform-wrapper .bb-blocks-grid,
        .wma-bb-subform-wrapper .bb-buttons-row,
        .wma-bb-subform-wrapper .bb-block-columns,
        .wma-bb-subform-wrapper .bb-accessiblemedia-grid { grid-template-columns: 1fr; }
        .wma-bb-subform-wrapper .bb-colors-row,
        .wma-bb-subform-wrapper .bb-row-2col,
        .wma-bb-subform-wrapper .bb-row-3col,
        .wma-bb-subform-wrapper .bb-row-4col { grid-template-columns: 1fr; }
    }
');

/**
 * Renderizza il layout completo di un Set con tutti gli 11 blocchi.
 */
function renderSetLayout(object $form): string
{
    ob_start();

    $buildFieldMap = static function (object $fieldsetForm, string $fieldsetName): array {
        $map = [];

        foreach ($fieldsetForm->getFieldset($fieldsetName) as $field) {
            $map[(string) $field->fieldname] = $field;
        }

        return $map;
    };

    $renderField = static function (array $fields, string $fieldName, ?string $defaultValue = null): string {
        if (!isset($fields[$fieldName])) {
            return '';
        }

        if ($defaultValue !== null && trim((string) $fields[$fieldName]->value) === '') {
            $fields[$fieldName]->value = $defaultValue;
        }

        return $fields[$fieldName]->renderField(['class' => 'control-group']);
    };

    $renderBlock = static function (object $fieldsetForm, string $prefix, string $label, string $collapseId) use ($buildFieldMap, $renderField): string {
        $fields = $buildFieldMap($fieldsetForm, $prefix);
        $headerText = trim((string) ($fields[$prefix . '_paragraph']->value ?? '')) ?: Text::_($label);

        ob_start();
        ?>
        <div class="bb-block-section" data-badge-field="<?php echo htmlspecialchars($prefix . '_paragraph', ENT_QUOTES, 'UTF-8'); ?>">
            <div class="bb-block-header"><?php echo $headerText; ?></div>
            <div class="bb-block-fields">
                <div class="bb-block-columns">
                    <div class="bb-column-stack">
                        <?php echo $renderField($fields, $prefix . '_title'); ?>
                        <?php echo $renderField($fields, $prefix . '_title_tag'); ?>
                        <?php echo $renderField($fields, $prefix . '_title_size'); ?>
                        <?php echo $renderField($fields, $prefix . '_link_article'); ?>
                        <?php echo $renderField($fields, $prefix . '_link_url'); ?>
                        <?php echo $renderField($fields, $prefix . '_paragraph', $headerText); ?>
                    </div>
                    <div class="bb-column-stack">
                        <?php echo $renderField($fields, $prefix . '_subtitle'); ?>
                        <?php echo $renderField($fields, $prefix . '_subtitle_tag'); ?>
                        <?php echo $renderField($fields, $prefix . '_subtitle_size'); ?>
                        <?php echo $renderField($fields, $prefix . '_image'); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php

        return ob_get_clean();
    };

    // ── Colori set ──────────────────────────────────────────────────────
    echo '<div class="bb-block-section">';
    echo '<div class="bb-block-header">' . Text::_('MOD_WMA_BESTBLOCK_FIELDSET_COLORS') . '</div>';
    echo '<div class="bb-block-fields bb-colors-row">';
    foreach ($form->getFieldset('colors') as $field) {
        echo '<div>' . $field->renderField(['class' => 'control-group']) . '</div>';
    }
    echo '</div></div>';

    // ── Blocchi B1-B8 in griglia 2 colonne ──────────────────────────────
    echo '<div class="bb-blocks-grid">';
    echo $renderBlock($form, 'b1', 'MOD_WMA_BESTBLOCK_FIELDSET_B1', '');
    echo $renderBlock($form, 'b2', 'MOD_WMA_BESTBLOCK_FIELDSET_B2', '');
    echo $renderBlock($form, 'b3', 'MOD_WMA_BESTBLOCK_FIELDSET_B3', '');
    echo $renderBlock($form, 'b4', 'MOD_WMA_BESTBLOCK_FIELDSET_B4', '');
    echo $renderBlock($form, 'b5', 'MOD_WMA_BESTBLOCK_FIELDSET_B5', '');
    echo $renderBlock($form, 'b6', 'MOD_WMA_BESTBLOCK_FIELDSET_B6', '');
    echo $renderBlock($form, 'b7', 'MOD_WMA_BESTBLOCK_FIELDSET_B7', '');
    echo $renderBlock($form, 'b8', 'MOD_WMA_BESTBLOCK_FIELDSET_B8', '');
    echo '</div>';

    // ── Pulsanti (B9, B10, B11) ──────────────────────────────────────────
    $btnBlocks = [
        'b9'  => 'MOD_WMA_BESTBLOCK_FIELDSET_B9',
        'b10' => 'MOD_WMA_BESTBLOCK_FIELDSET_B10',
        'b11' => 'MOD_WMA_BESTBLOCK_FIELDSET_B11',
    ];

    echo '<div class="bb-buttons-row">';
    foreach ($btnBlocks as $fieldset => $label) {
        $headerText = Text::_($label);

        echo '<div class="bb-block-section">';
        echo '<div class="bb-block-header">' . $headerText . '</div>';
        echo '<div class="bb-block-fields">';
        foreach ($form->getFieldset($fieldset) as $field) {
            echo $field->renderField(['class' => 'control-group']);
        }
        echo '</div></div>';
    }
    echo '</div>';

    return ob_get_clean();
}

?>

<div id="<?php echo htmlspecialchars($fieldId, ENT_QUOTES, 'UTF-8'); ?>-wrapper" class="wma-bb-subform-wrapper">

    <div class="subform-repeatable" id="<?php echo htmlspecialchars($fieldId, ENT_QUOTES, 'UTF-8'); ?>-rows">

        <?php foreach ($forms as $groupName => $form) : ?>
        <?php $groupIndex = is_numeric($groupName) ? (int) $groupName : 0; ?>

        <div class="subform-repeatable-group"
             data-group="<?php echo $control; ?>[<?php echo $groupIndex; ?>]"
             data-index="<?php echo $groupIndex; ?>">
            <div class="bb-set-header">
                <span><?php echo Text::_('MOD_WMA_BESTBLOCK_SET') . ' ' . ($groupIndex + 1); ?></span>
                <div class="d-flex gap-2 align-items-center">
                    <button type="button"
                            class="btn btn-sm btn-secondary subform-collapse-row collapsed"
                            data-bs-toggle="collapse"
                            data-bs-target="#<?php echo htmlspecialchars($fieldId, ENT_QUOTES, 'UTF-8'); ?>-collapse-<?php echo $groupIndex; ?>"
                            aria-expanded="false"
                            aria-controls="<?php echo htmlspecialchars($fieldId, ENT_QUOTES, 'UTF-8'); ?>-collapse-<?php echo $groupIndex; ?>"
                            title="<?php echo Text::_('JTOGGLE'); ?>">
                        <span class="icon-chevron-down" aria-hidden="true"></span>
                    </button>
                    <?php if ($btnMove) : ?>
                    <button type="button" class="btn btn-sm btn-secondary subform-move-row" title="<?php echo Text::_('JMOVE'); ?>">
                        <span class="icon-move" aria-hidden="true"></span>
                    </button>
                    <?php endif; ?>
                    <button type="button" class="btn btn-sm btn-secondary subform-copy-row" title="<?php echo Text::_('MOD_WMA_BESTBLOCK_COPY'); ?>">
                        <span class="icon-copy" aria-hidden="true"></span>
                    </button>
                    <?php if ($btnRemove) : ?>
                    <button type="button" class="btn btn-sm btn-danger subform-remove-row" title="<?php echo Text::_('JGLOBAL_DELETE'); ?>">
                        <span class="icon-trash" aria-hidden="true"></span>
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="bb-set-body collapse" id="<?php echo htmlspecialchars($fieldId, ENT_QUOTES, 'UTF-8'); ?>-collapse-<?php echo $groupIndex; ?>">
                <?php echo renderSetLayout($form); ?>
            </div>
        </div>

        <?php endforeach; ?>
    </div>

    <?php if ($tmpl !== null) : ?>
    <template id="<?php echo htmlspecialchars($fieldId, ENT_QUOTES, 'UTF-8'); ?>-tmpl">
        <div class="subform-repeatable-group"
             data-group="<?php echo $control; ?>[__INDEX__]"
             data-index="__INDEX__">
            <div class="bb-set-header">
                <span><?php echo Text::_('MOD_WMA_BESTBLOCK_SET'); ?> __NUM__</span>
                <div class="d-flex gap-2 align-items-center">
                    <button type="button"
                            class="btn btn-sm btn-secondary subform-collapse-row"
                            data-bs-toggle="collapse"
                            data-bs-target="#<?php echo htmlspecialchars($fieldId, ENT_QUOTES, 'UTF-8'); ?>-collapse-__INDEX__"
                            aria-expanded="true"
                            aria-controls="<?php echo htmlspecialchars($fieldId, ENT_QUOTES, 'UTF-8'); ?>-collapse-__INDEX__"
                            title="<?php echo Text::_('JTOGGLE'); ?>">
                        <span class="icon-chevron-down" aria-hidden="true"></span>
                    </button>
                    <?php if ($btnMove) : ?>
                    <button type="button" class="btn btn-sm btn-secondary subform-move-row" title="<?php echo Text::_('JMOVE'); ?>">
                        <span class="icon-move" aria-hidden="true"></span>
                    </button>
                    <?php endif; ?>
                    <button type="button" class="btn btn-sm btn-secondary subform-copy-row" title="<?php echo Text::_('MOD_WMA_BESTBLOCK_COPY'); ?>">
                        <span class="icon-copy" aria-hidden="true"></span>
                    </button>
                    <?php if ($btnRemove) : ?>
                    <button type="button" class="btn btn-sm btn-danger subform-remove-row" title="<?php echo Text::_('JGLOBAL_DELETE'); ?>">
                        <span class="icon-trash" aria-hidden="true"></span>
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="bb-set-body collapse show" id="<?php echo htmlspecialchars($fieldId, ENT_QUOTES, 'UTF-8'); ?>-collapse-__INDEX__">
                <?php echo renderSetLayout($tmpl); ?>
            </div>
        </div>
    </template>
    <?php endif; ?>

    <?php if ($btnAdd) : ?>
    <button type="button" class="btn btn-success subform-add"
            id="<?php echo htmlspecialchars($fieldId, ENT_QUOTES, 'UTF-8'); ?>-add">
        <span class="icon-plus" aria-hidden="true"></span>
        <?php echo Text::_('MOD_WMA_BESTBLOCK_ADD_SET'); ?>
    </button>
    <?php endif; ?>

</div>

<script>
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        var FIELD_ID  = '<?php echo htmlspecialchars($fieldId, ENT_QUOTES, 'UTF-8'); ?>';
        var GROUP     = '<?php echo htmlspecialchars($control, ENT_QUOTES, 'UTF-8'); ?>';   // es. "sets"
        var TMPL_TOKEN = GROUP + 'X';                                                        // segnaposto Joomla nel template (es. "setsX")
        var SET_LABEL = '<?php echo htmlspecialchars(Text::_('MOD_WMA_BESTBLOCK_SET'), ENT_QUOTES, 'UTF-8'); ?>';

        var wrapper = document.getElementById(FIELD_ID + '-wrapper');
        if (!wrapper) return;

        var rowsContainer = document.getElementById(FIELD_ID + '-rows');
        var tmplEl        = document.getElementById(FIELD_ID + '-tmpl');
        var btnAdd        = document.getElementById(FIELD_ID + '-add');
        var form          = wrapper.closest('form');

        var rowCount = rowsContainer.querySelectorAll('.subform-repeatable-group').length;

        // Attributi che contengono identificatori (mai dati inseriti dall'utente)
        var ID_ATTRS = ['name', 'id', 'for', 'aria-describedby', 'aria-controls', 'aria-labelledby', 'data-bs-target', 'list', 'headers', 'form'];

        function escapeRegExp(value) {
            return String(value).replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }

        // Sostituisce un token letterale in tutti gli attributi (e opzionalmente nel testo) del sottoalbero.
        function replaceToken(rootEl, from, to, includeText) {
            var els = [rootEl].concat(Array.prototype.slice.call(rootEl.querySelectorAll('*')));
            els.forEach(function (el) {
                for (var i = 0; i < el.attributes.length; i++) {
                    var attr = el.attributes[i];
                    if (attr.value.indexOf(from) !== -1) {
                        el.setAttribute(attr.name, attr.value.split(from).join(to));
                    }
                }
            });

            if (!includeText) return;

            var walker = document.createTreeWalker(rootEl, NodeFilter.SHOW_TEXT, null);
            var node;
            while ((node = walker.nextNode())) {
                if (node.nodeValue.indexOf(from) !== -1) {
                    node.nodeValue = node.nodeValue.split(from).join(to);
                }
            }
        }

        // Crea una nuova riga dal <template>, con nomi/ID già indicizzati correttamente.
        function buildRowFromTemplate(index) {
            var frag    = tmplEl.content.cloneNode(true);
            var groupEl = frag.querySelector('.subform-repeatable-group');

            // Token del markup custom del layout
            replaceToken(groupEl, '__INDEX__', String(index), true);
            replaceToken(groupEl, '__NUM__', String(index + 1), true);

            // Segnaposto dei nomi campo generati da Joomla: setsX -> sets{index}
            replaceToken(groupEl, TMPL_TOKEN, GROUP + index, false);

            groupEl.setAttribute('data-index', String(index));
            groupEl.setAttribute('data-group', GROUP + '[' + index + ']');

            return groupEl;
        }

        // Copia i valori da una riga sorgente a una riga target (per la duplicazione).
        function copyRowValues(sourceRow, targetRow) {
            var srcTok = GROUP + String(sourceRow.dataset.index);
            var dstTok = GROUP + String(targetRow.dataset.index);

            // 1. Tutti i campi con name (input/select/textarea): immagini, alt, titoli,
            //    dimensione font, tag, link, paragrafo/badge.
            sourceRow.querySelectorAll('input, select, textarea').forEach(function (srcEl) {
                if (!srcEl.name || srcEl.type === 'file') return;

                var targetName = srcEl.name.split(srcTok).join(dstTok);
                var dstEl = targetRow.querySelector('[name="' + targetName + '"]');
                if (!dstEl) return;

                if (srcEl.type === 'checkbox' || srcEl.type === 'radio') {
                    dstEl.checked = srcEl.checked;
                } else {
                    dstEl.value = srcEl.value;
                }
            });

            // 2. Campi di sola visualizzazione senza name (es. titolo articolo selezionato).
            sourceRow.querySelectorAll('input[id]:not([name])').forEach(function (srcEl) {
                var targetId = srcEl.id.split(srcTok).join(dstTok);
                if (targetId === srcEl.id) return;
                var dstEl = targetRow.querySelector('[id="' + targetId + '"]');
                if (dstEl) dstEl.value = srcEl.value;
            });

            // 3. Web component media: allinea l'attributo value (l'anteprima viene ricostruita
            //    da refreshMediaPreviews dopo l'inserimento nel DOM).
            var mediaValues = {};
            sourceRow.querySelectorAll('joomla-field-media').forEach(function (srcMedia) {
                var input = srcMedia.querySelector('input[name]');
                if (input) {
                    mediaValues[input.name.split(srcTok).join(dstTok)] = (input.value || '').trim();
                }
            });
            targetRow.querySelectorAll('joomla-field-media').forEach(function (dstMedia) {
                var input = dstMedia.querySelector('input[name]');
                if (!input || mediaValues[input.name] === undefined) return;
                input.value = mediaValues[input.name];
                dstMedia.setAttribute('value', mediaValues[input.name]);
            });
        }

        // Ricostruisce l'anteprima visiva dei campi media di una riga leggendo il valore dell'input.
        function refreshMediaPreviews(row) {
            var rootUrl = (window.Joomla && Joomla.getOptions && Joomla.getOptions('system.paths') && Joomla.getOptions('system.paths').rootFull)
                ? Joomla.getOptions('system.paths').rootFull
                : (window.location.origin + '/');
            rootUrl = rootUrl.replace(/\/+$/, '');

            row.querySelectorAll('joomla-field-media').forEach(function (media) {
                var input = media.querySelector('input[name$="[imagefile]"]');
                var val   = input ? (input.value || '').trim() : '';
                var preview = media.querySelector('.field-media-preview');
                if (!preview) return;

                // Ricostruzione via API DOM: 'url' non viene mai interpretato come HTML.
                preview.textContent = '';

                if (!val) {
                    return;
                }

                var clean = normalizeMediaValue(val);
                var url = /^(?:[a-z][a-z0-9+.-]*:)?\/\//i.test(clean)
                    ? clean
                    : (rootUrl + '/' + clean.replace(/^\/+/, ''));

                var img = document.createElement('img');
                img.src = url;
                img.alt = '';
                img.style.maxHeight = '100px';
                img.style.maxWidth = '100px';
                img.style.objectFit = 'cover';

                preview.appendChild(img);
                preview.style.display = '';
            });
        }

        // Riallinea nomi/ID/collapse di una riga all'indice desiderato (dopo aggiunta, rimozione, riordino).
        function applyRowIndex(row, newIndex) {
            var oldIndex = (row.dataset.index !== undefined && row.dataset.index !== '')
                ? String(row.dataset.index)
                : String(newIndex);
            newIndex = String(newIndex);

            if (oldIndex !== newIndex) {
                var oldTok = GROUP + oldIndex;
                var newTok = GROUP + newIndex;

                var els = [row].concat(Array.prototype.slice.call(row.querySelectorAll('*')));
                els.forEach(function (el) {
                    ID_ATTRS.forEach(function (name) {
                        if (!el.hasAttribute(name)) return;
                        var v = el.getAttribute(name);
                        if (v.indexOf(oldTok) !== -1) {
                            el.setAttribute(name, v.split(oldTok).join(newTok));
                        }
                    });
                });

                // ID / target del collapse: "{FIELD_ID}-collapse-{index}"
                var reCollapse = new RegExp('-collapse-' + escapeRegExp(oldIndex) + '(?=$|[^0-9])', 'g');
                ['id', 'data-bs-target', 'aria-controls'].forEach(function (name) {
                    row.querySelectorAll('[' + name + ']').forEach(function (el) {
                        var v = el.getAttribute(name);
                        if (v.indexOf('-collapse-') !== -1) {
                            el.setAttribute(name, v.replace(reCollapse, '-collapse-' + newIndex));
                        }
                    });
                });
            }

            row.dataset.index = newIndex;
            row.dataset.group = GROUP + '[' + newIndex + ']';

            var header = row.querySelector('.bb-set-header span');
            if (header) {
                header.textContent = SET_LABEL + ' ' + (parseInt(newIndex, 10) + 1);
            }
        }

        function normalizeMediaValue(value) {
            if (!value) return '';

            var clean = String(value).trim();
            if (!clean) return '';

            clean = clean.split('#')[0];
            clean = clean.split('?')[0];

            if (/^(?:[a-z][a-z0-9+.-]*:)?\/\//i.test(clean) || /^[a-z][a-z0-9+.-]*:/i.test(clean)) {
                return clean;
            }

            return clean.replace(/^\/+/, '');
        }

        function altFromImageSrc(src) {
            var clean = normalizeMediaValue(src);
            if (!clean) return '';

            var fileName = clean.split('/').pop() || '';
            try {
                fileName = decodeURIComponent(fileName);
            } catch (e) {
                // leave filename as-is
            }
            return fileName.replace(/\.[^.]+$/, '').replace(/[_-]+/g, ' ').trim();
        }

        function normalizeAllMediaFields() {
            wrapper.querySelectorAll('input[name$="[imagefile]"]').forEach(function (input) {
                input.value = normalizeMediaValue(input.value);
            });

            wrapper.querySelectorAll('input[name$="[alt_text]"]').forEach(function (input) {
                if (input.value && input.value.trim()) {
                    return;
                }

                var baseName = input.name.replace(/\[alt_text\]$/, '');
                var imageInput = null;

                wrapper.querySelectorAll('input[name$="[imagefile]"]').forEach(function (candidate) {
                    if (candidate.name.replace(/\[imagefile\]$/, '') === baseName) {
                        imageInput = candidate;
                    }
                });

                if (imageInput) {
                    input.value = altFromImageSrc(imageInput.value);
                }
            });

            wrapper.querySelectorAll('input[name$="[alt_empty]"]').forEach(function (input) {
                input.checked = false;
                input.disabled = true;

                var row = input.closest('.control-group, .form-group, .mb-3, .form-check, .field-media');
                if (row) {
                    row.style.display = 'none';
                } else {
                    input.style.display = 'none';
                }
            });
        }

        function syncBadgeHeaders() {
            wrapper.querySelectorAll('.bb-block-section[data-badge-field]').forEach(function (section) {
                var fieldName = section.getAttribute('data-badge-field');
                var header = section.querySelector('.bb-block-header');
                if (!fieldName || !header) return;

                var input = section.querySelector('[name$="[' + fieldName + ']"]');
                if (!input) return;

                var value = (input.value || '').trim();
                if (value) {
                    header.textContent = value;
                }
            });
        }

        if (form) {
            form.addEventListener('submit', function () {
                normalizeAllMediaFields();
            }, true);
        }

        normalizeAllMediaFields();
        syncBadgeHeaders();

        wrapper.addEventListener('input', function (e) {
            if (!e.target.name || !/_paragraph\]$/.test(e.target.name)) return;
            syncBadgeHeaders();
        });

        wrapper.addEventListener('change', function (e) {
            if (!e.target.name || !/_paragraph\]$/.test(e.target.name)) return;
            syncBadgeHeaders();
        });

        if (btnAdd && tmplEl) {
            btnAdd.addEventListener('click', function () {
                var newRow = buildRowFromTemplate(rowCount);
                rowsContainer.appendChild(newRow);
                reindexRows();
                normalizeAllMediaFields();
                syncBadgeHeaders();
                newRow.dispatchEvent(new CustomEvent('joomla:updated', { bubbles: true, cancelable: true }));
            });
        }

        rowsContainer.addEventListener('click', function (e) {
            var copyBtn = e.target.closest('.subform-copy-row');
            if (copyBtn) {
                var sourceGroup = copyBtn.closest('.subform-repeatable-group');
                if (!sourceGroup || !tmplEl) return;

                var newRow = buildRowFromTemplate(rowCount);
                // Copia i valori sul nodo ancora staccato: i web component si inizializzano
                // con il valore corretto all'inserimento nel DOM.
                copyRowValues(sourceGroup, newRow);
                rowsContainer.appendChild(newRow);
                reindexRows();
                normalizeAllMediaFields();
                refreshMediaPreviews(newRow);
                syncBadgeHeaders();
                newRow.dispatchEvent(new CustomEvent('joomla:updated', { bubbles: true, cancelable: true }));
                return;
            }

            var btn = e.target.closest('.subform-remove-row');
            if (!btn) return;
            var group = btn.closest('.subform-repeatable-group');
            if (group) {
                group.remove();
                reindexRows();
            }
        });

        // ── Drag-and-drop per riordino set ──────────────────────────────
        var dragSrc    = null;
        var dropTarget = null;
        var dropBefore = false;

        rowsContainer.addEventListener('mousedown', function (e) {
            var btn = e.target.closest('.subform-move-row');
            if (!btn) return;
            var group = btn.closest('.subform-repeatable-group');
            if (group) { group.draggable = true; }
        });

        rowsContainer.addEventListener('dragstart', function (e) {
            var group = e.target.closest('.subform-repeatable-group');
            if (!group || !group.draggable) { e.preventDefault(); return; }
            dragSrc = group;
            e.dataTransfer.effectAllowed = 'move';
            setTimeout(function () { group.classList.add('bb-dragging'); }, 0);
        });

        rowsContainer.addEventListener('dragover', function (e) {
            e.preventDefault();
            var group = e.target.closest('.subform-repeatable-group');
            if (!group || group === dragSrc) return;
            rowsContainer.querySelectorAll('.bb-drag-over-top, .bb-drag-over-bottom').forEach(function (el) {
                el.classList.remove('bb-drag-over-top', 'bb-drag-over-bottom');
            });
            var rect = group.getBoundingClientRect();
            dropBefore = e.clientY < rect.top + rect.height / 2;
            dropTarget = group;
            group.classList.add(dropBefore ? 'bb-drag-over-top' : 'bb-drag-over-bottom');
        });

        rowsContainer.addEventListener('drop', function (e) {
            e.preventDefault();
            if (!dragSrc || !dropTarget || dragSrc === dropTarget) return;
            rowsContainer.insertBefore(dragSrc, dropBefore ? dropTarget : dropTarget.nextSibling);
        });

        rowsContainer.addEventListener('dragend', function () {
            rowsContainer.querySelectorAll('.bb-dragging, .bb-drag-over-top, .bb-drag-over-bottom').forEach(function (el) {
                el.classList.remove('bb-dragging', 'bb-drag-over-top', 'bb-drag-over-bottom');
                el.draggable = false;
            });
            reindexRows();
            dragSrc = null;
            dropTarget = null;
        });

        function reindexRows() {
            var rows = rowsContainer.querySelectorAll('.subform-repeatable-group');
            rowCount = 0;
            rows.forEach(function (row, i) {
                applyRowIndex(row, i);
                rowCount++;
            });
        }
    });
}());
</script>
