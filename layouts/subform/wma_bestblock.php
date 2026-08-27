<?php

/**
 * @package     Wma.Module.WmaBestblock
 * @subpackage  mod_wma_bestblock
 *
 * @author      Team Developer by WMA Web Maker Agency <wmaextension@gmail.com>
 * @copyright   (C) 2026 WMA Web Maker Agency. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 * @link        https://www.wma.ovh
 * @version     1.0.21
 * @date        27/08/2026
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
    .wma-bb-subform-wrapper .control-label { font-size: 11px !important; }
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
    @media (max-width: 900px) {
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
        $fields = $buildFieldMap($form, $fieldset);
        $headerText = Text::_($label);

        echo '<div class="bb-block-section" data-badge-field="' . htmlspecialchars($fieldset . '_paragraph', ENT_QUOTES, 'UTF-8') . '">';
        echo '<div class="bb-block-header">' . $headerText . '</div>';
        echo '<div class="bb-block-fields">';
        foreach ($form->getFieldset($fieldset) as $field) {
            if ((string) $field->fieldname === $fieldset . '_paragraph') {
                continue;
            }
            echo $field->renderField(['class' => 'control-group']);
        }
        echo $renderField($fields, $fieldset . '_paragraph', $headerText);
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
                            class="btn btn-sm btn-secondary subform-collapse-row"
                            data-bs-toggle="collapse"
                            data-bs-target="#<?php echo htmlspecialchars($fieldId, ENT_QUOTES, 'UTF-8'); ?>-collapse-<?php echo $groupIndex; ?>"
                            aria-expanded="true"
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
            <div class="bb-set-body collapse show" id="<?php echo htmlspecialchars($fieldId, ENT_QUOTES, 'UTF-8'); ?>-collapse-<?php echo $groupIndex; ?>">
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
        var wrapperId   = '<?php echo htmlspecialchars($fieldId, ENT_QUOTES, 'UTF-8'); ?>-wrapper';
        var wrapper     = document.getElementById(wrapperId);
        if (!wrapper) return;

        var rowsContainer = document.getElementById('<?php echo htmlspecialchars($fieldId, ENT_QUOTES, 'UTF-8'); ?>-rows');
        var tmplEl        = document.getElementById('<?php echo htmlspecialchars($fieldId, ENT_QUOTES, 'UTF-8'); ?>-tmpl');
        var btnAdd        = document.getElementById('<?php echo htmlspecialchars($fieldId, ENT_QUOTES, 'UTF-8'); ?>-add');
        var form          = wrapper.closest('form');

        var rowCount = rowsContainer.querySelectorAll('.subform-repeatable-group').length;

        function escapeRegExp(value) {
            return String(value).replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }

        function replaceIndexTokens(value, fromIndex, toIndex) {
            var output = String(value || '');
            var from = escapeRegExp(fromIndex);
            var to = String(toIndex);

            output = output
                .replace(new RegExp('\\[' + from + '\\]', 'g'), '[' + to + ']')
                .replace(new RegExp('_' + from + '_', 'g'), '_' + to + '_')
                .replace(new RegExp('-collapse-' + from + '(?=$|[^0-9])', 'g'), '-collapse-' + to)
                .replace(/__INDEX__/g, to)
                .replace(/__NUM__/g, String(Number(to) + 1));

            return output;
        }

        function getFieldKey(name) {
            var match = String(name || '').match(/\[([^\[\]]+)\]$/);
            return match ? match[1] : '';
        }

        function copyRowValues(sourceRow, targetRow) {
            sourceRow.querySelectorAll('input, select, textarea').forEach(function (sourceEl) {
                var key = getFieldKey(sourceEl.name);
                if (!key) return;

                var targetEl = targetRow.querySelector('[name$="[' + key + ']"]');
                if (!targetEl) return;

                if (sourceEl.type === 'checkbox' || sourceEl.type === 'radio') {
                    targetEl.checked = sourceEl.checked;
                    return;
                }

                if (sourceEl.tagName === 'SELECT') {
                    targetEl.value = sourceEl.value;
                    return;
                }

                targetEl.value = sourceEl.value;
            });
        }

        function applyRowIndex(row, index) {
            var currentIndex = row.dataset.index !== undefined ? String(row.dataset.index) : '';

            row.dataset.index = String(index);
            row.dataset.group = '<?php echo $control; ?>[' + index + ']';

            row.querySelectorAll('[name]').forEach(function (el) {
                el.name = replaceIndexTokens(el.name, currentIndex, index);
            });

            row.querySelectorAll('[id]').forEach(function (el) {
                el.id = replaceIndexTokens(el.id, currentIndex, index);
            });

            row.querySelectorAll('[for]').forEach(function (el) {
                el.setAttribute('for', replaceIndexTokens(el.getAttribute('for'), currentIndex, index));
            });

            row.querySelectorAll('[data-bs-target]').forEach(function (el) {
                el.setAttribute('data-bs-target', replaceIndexTokens(el.getAttribute('data-bs-target'), currentIndex, index));
            });

            row.querySelectorAll('[aria-controls]').forEach(function (el) {
                el.setAttribute('aria-controls', replaceIndexTokens(el.getAttribute('aria-controls'), currentIndex, index));
            });

            var collapseBody = row.querySelector('.bb-set-body');
            if (collapseBody && collapseBody.id) {
                collapseBody.id = replaceIndexTokens(collapseBody.id, currentIndex, index);
            }

            var header = row.querySelector('.bb-set-header span');
            if (header) {
                header.textContent = '<?php echo Text::_('MOD_WMA_BESTBLOCK_SET'); ?> ' + (index + 1);
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
                var index = rowCount;
                var num   = rowCount + 1;

                var clone = tmplEl.content.cloneNode(true);
                var html  = clone.querySelector('.subform-repeatable-group').outerHTML;
                html = html.replace(/__INDEX__/g, String(index));
                html = html.replace(/__NUM__/g, String(num));

                var tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;
                var groupEl = tempDiv.querySelector('.subform-repeatable-group');

                groupEl.querySelectorAll('[name]').forEach(function (el) {
                    el.name = el.name.replace(/\[__INDEX__\]/g, '[' + index + ']');
                });
                groupEl.querySelectorAll('[id]').forEach(function (el) {
                    el.id = el.id.replace(/__INDEX__/g, String(index));
                });
                groupEl.querySelectorAll('[for]').forEach(function (el) {
                    el.setAttribute('for', el.getAttribute('for').replace(/__INDEX__/g, String(index)));
                });
                groupEl.querySelectorAll('[data-bs-target]').forEach(function (el) {
                    el.setAttribute('data-bs-target', el.getAttribute('data-bs-target').replace(/__INDEX__/g, String(index)));
                });
                groupEl.querySelectorAll('[aria-controls]').forEach(function (el) {
                    el.setAttribute('aria-controls', el.getAttribute('aria-controls').replace(/__INDEX__/g, String(index)));
                });

                rowsContainer.insertAdjacentHTML('beforeend', groupEl.outerHTML);
                rowCount++;
                normalizeAllMediaFields();
                syncBadgeHeaders();
            });
        }

        rowsContainer.addEventListener('click', function (e) {
            var copyBtn = e.target.closest('.subform-copy-row');
            if (copyBtn) {
                var sourceGroup = copyBtn.closest('.subform-repeatable-group');
                if (!sourceGroup) return;

                var index = rowCount;
                var num   = rowCount + 1;

                var clone = tmplEl.content.cloneNode(true);
                var html  = clone.querySelector('.subform-repeatable-group').outerHTML;
                html = html.replace(/__INDEX__/g, String(index));
                html = html.replace(/__NUM__/g, String(num));

                var tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;
                var groupEl = tempDiv.querySelector('.subform-repeatable-group');

                groupEl.querySelectorAll('[name]').forEach(function (el) {
                    el.name = el.name.replace(/\[__INDEX__\]/g, '[' + index + ']');
                });
                groupEl.querySelectorAll('[id]').forEach(function (el) {
                    el.id = el.id.replace(/__INDEX__/g, String(index));
                });
                groupEl.querySelectorAll('[for]').forEach(function (el) {
                    el.setAttribute('for', el.getAttribute('for').replace(/__INDEX__/g, String(index)));
                });
                groupEl.querySelectorAll('[data-bs-target]').forEach(function (el) {
                    el.setAttribute('data-bs-target', el.getAttribute('data-bs-target').replace(/__INDEX__/g, String(index)));
                });
                groupEl.querySelectorAll('[aria-controls]').forEach(function (el) {
                    el.setAttribute('aria-controls', el.getAttribute('aria-controls').replace(/__INDEX__/g, String(index)));
                });

                rowsContainer.appendChild(groupEl);
                copyRowValues(sourceGroup, rowsContainer.lastElementChild);
                reindexRows();
                normalizeAllMediaFields();
                syncBadgeHeaders();
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
