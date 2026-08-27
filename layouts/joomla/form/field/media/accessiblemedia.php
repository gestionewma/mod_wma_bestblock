<?php

/**
 * @package     Wma.Module.WmaBestblock
 * @subpackage  mod_wma_bestblock
 *
 * @author      Team Developer by WMA Web Maker Agency <wmaextension@gmail.com>
 * @copyright   (C) 2026 WMA Web Maker Agency. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 * @link        https://www.wma.ovh
 * @version     1.0.23
 * @date        27/08/2026
 * @file        layouts/joomla/form/field/media/accessiblemedia.php
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

extract($displayData);

$form = $forms[0];
$formfields = $form->getGroup('');

$imageField = null;
$altField   = null;

foreach ($formfields as $field) {
    if ((string) $field->fieldname === 'imagefile') {
        $imageField = $field;
    }

    if ((string) $field->fieldname === 'alt_text') {
        $altField = $field;
    }
}

?>

<div class="subform-wrapper bb-accessiblemedia-stack">
    <div class="bb-accessiblemedia-cell bb-accessiblemedia-imagefile">
        <?php echo $imageField ? $imageField->renderField() : ''; ?>
    </div>
    <div class="bb-accessiblemedia-cell bb-accessiblemedia-alt_text">
        <?php echo $altField ? $altField->renderField(['label' => Text::_('MOD_WMA_BESTBLOCK_IMAGE_ALT')]) : ''; ?>
    </div>
</div>
