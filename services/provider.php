<?php

/**
 * @package     Wma.Module.WmaBestblock
 * @subpackage  mod_wma_bestblock
 *
 * @author      Team Developer by WMA Web Maker Agency <wmaextension@gmail.com>
 * @copyright   (C) 2026 WMA Web Maker Agency. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 * @link        https://www.wma.ovh
 * @version     1.0.25
 * @date        27/08/2026
 * @file        services/provider.php
 */

defined('_JEXEC') or die;

\JLoader::registerNamespace('Wma\\Module\\WmaBestblock\\Site', dirname(__DIR__) . '/src');

use Joomla\CMS\Extension\Service\Provider\HelperFactory;
use Joomla\CMS\Extension\Service\Provider\Module as ModuleServiceProvider;
use Joomla\CMS\Extension\Service\Provider\ModuleDispatcherFactory;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

return new class implements ServiceProviderInterface
{
    public function register(Container $container): void
    {
        $container->registerServiceProvider(
            new ModuleDispatcherFactory('\\Wma\\Module\\WmaBestblock')
        );
        $container->registerServiceProvider(
            new HelperFactory('\\Wma\\Module\\WmaBestblock\\Site\\Helper')
        );
        $container->registerServiceProvider(new ModuleServiceProvider());
    }
};
