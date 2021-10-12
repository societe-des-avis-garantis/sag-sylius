<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $configuration = $menu->getChild('configuration');

        if (null !== $configuration) {
            $configuration
                ->addChild('sag_api_key_config', ['route' => 'dedi_sylius_sag_plugin_admin_api_key_config_index'])
                ->setLabel('dedi_sylius_sag_plugin.ui.sag_configuration')
                ->setLabelAttribute('icon', 'comment alternate')
            ;
        }
    }

}
