<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('dedi_sylius_sag_plugin');
        $rootNode = $treeBuilder->getRootNode();

        return $treeBuilder;
    }
}
