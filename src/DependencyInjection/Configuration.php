<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\DependencyInjection;

use Dedi\SyliusSAGPlugin\Entity\ApiKeyConfig;
use Dedi\SyliusSAGPlugin\Entity\ApiKeyConfigInterface;
use Dedi\SyliusSAGPlugin\Entity\RepartitionOfScores;
use Dedi\SyliusSAGPlugin\Entity\RepartitionOfScoresInterface;
use Dedi\SyliusSAGPlugin\Factory\RepartitionOfScoresFactory;
use Dedi\SyliusSAGPlugin\Form\Type\ApiKeyConfigType;
use Dedi\SyliusSAGPlugin\Repository\Config\ApiKeyConfigRepository;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Bundle\ResourceBundle\Form\Type\DefaultResourceType;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Sylius\Component\Resource\Factory\Factory;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * @psalm-suppress UnusedVariable
     * @psalm-suppress UnusedMethodCall
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('dedi_sylius_sag_plugin');
        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('driver')->defaultValue(SyliusResourceBundle::DRIVER_DOCTRINE_ORM)->end()
            ->end()
        ;

        $this->addResourcesSection($rootNode);

        return $treeBuilder;
    }

    private function addResourcesSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('resources')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('api_key_config')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('options')->end()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(ApiKeyConfig::class)->cannotBeEmpty()->end()
                                        ->scalarNode('interface')->defaultValue(ApiKeyConfigInterface::class)->cannotBeEmpty()->end()
                                        ->scalarNode('controller')->defaultValue(ResourceController::class)->end()
                                        ->scalarNode('repository')->defaultValue(ApiKeyConfigRepository::class)->end()
                                        ->scalarNode('factory')->defaultValue(Factory::class)->end()
                                        ->scalarNode('form')->defaultValue(ApiKeyConfigType::class)->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('repartition_of_scores')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('options')->end()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(RepartitionOfScores::class)->cannotBeEmpty()->end()
                                        ->scalarNode('interface')->defaultValue(RepartitionOfScoresInterface::class)->cannotBeEmpty()->end()
                                        ->scalarNode('controller')->defaultValue(ResourceController::class)->end()
                                        ->scalarNode('repository')->defaultValue(EntityRepository::class)->end()
                                        ->scalarNode('factory')->defaultValue(RepartitionOfScoresFactory::class)->end()
                                        ->scalarNode('form')->defaultValue(DefaultResourceType::class)->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
