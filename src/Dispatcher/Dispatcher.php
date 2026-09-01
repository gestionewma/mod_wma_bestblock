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
 * @file        src/Dispatcher/Dispatcher.php
 */

namespace Wma\Module\WmaBestblock\Site\Dispatcher;

defined('_JEXEC') or die;

use Joomla\CMS\Dispatcher\AbstractModuleDispatcher;
use Wma\Module\WmaBestblock\Site\Helper\WmaBestblockHelper;

class Dispatcher extends AbstractModuleDispatcher
{
    protected function getLayoutData(): array
    {
        $data = parent::getLayoutData();

        $wa = $this->app->getDocument()->getWebAssetManager();
        $wa->getRegistry()->addExtensionRegistryFile('mod_wma_bestblock');
        $wa->useStyle('mod_wma_bestblock.style');
        $wa->useScript('mod_wma_bestblock.script');

        $helper = new WmaBestblockHelper();
        $data['sets'] = $helper->getSets($data['params']);

        $data['heightValue']       = (int) $data['params']->get('height_value', 100);
        $data['heightUnit']        = $data['params']->get('height_unit', 'vh');
        $data['autoplay']          = (bool) $data['params']->get('autoplay', false);
        $data['delay']             = (int) $data['params']->get('delay', 6000);
        $data['showMouseGlow']     = (bool) $data['params']->get('show_mouse_glow', true);
        $data['showBlockNumbers']  = (bool) $data['params']->get('show_block_numbers', false);
        $data['lightboxEnable']    = (bool) $data['params']->get('lightbox_enable', true);
        $data['lightboxBgColor']   = (string) $data['params']->get('lightbox_bg_color', '#000000');
        $data['lightboxBgOpacity'] = (int) $data['params']->get('lightbox_bg_opacity', 85);

        return $data;
    }
}
