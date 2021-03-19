<?php declare(strict_types=1);

namespace RichId\MagicModelBundle\DependencyInjection;

use RichCongress\BundleToolbox\Configuration\AbstractConfiguration;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\HttpFoundation\Response;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration extends AbstractConfiguration
{
    public const CONFIG_NODE = 'rich_id_magic_model';

    /**
     * @param ArrayNodeDefinition $rootNode
     *
     * @return void
     */
    protected function buildConfiguration(ArrayNodeDefinition $rootNode): void
    {
        $children = $rootNode->children();
        $this->buildConfig($children);
        $children->end();
    }

    /**
     * @param NodeBuilder $nodeBuilder
     *
     * @return void
     */
    protected function buildConfig(NodeBuilder $nodeBuilder): void
    {
        $nodeBuilder
            ->arrayNode('validation_rounds')
                ->info('Validate DTO with the the group and throw a HTTP exception with the mentioned status code in case of violations')
                ->defaultValue([
                    [
                        'keyname'          => 'default',
                        'validation_group' => 'Default',
                        'http_status_code' => Response::HTTP_BAD_REQUEST,
                    ]
                ])
                ->arrayPrototype()
                    ->children()
                        ->scalarNode('keyname')->defaultNull()->end()
                        ->scalarNode('validation_group')->defaultNull()->end()
                        ->integerNode('http_status_code')->defaultNull()->end()
                        ->integerNode('priority')->defaultValue(0)->end()
                    ->end()
                ->end()
            ->end();
    }
}
