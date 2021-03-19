<?php declare(strict_types=1);

namespace RichId\MagicModelBundle\DependencyInjection;

use RichCongress\BundleToolbox\Configuration\AbstractExtension;
use RichId\MagicModelBundle\Binder\Binders\BinderInterface;
use RichId\MagicModelBundle\DependencyInjection\CompilerPass\BinderCompilerPass;
use RichId\MagicModelBundle\DependencyInjection\CompilerPass\TypeGuesserCompilerPass;
use RichId\MagicModelBundle\TypeGuesser\Guessers\TypeGuesserInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class RichIdMagicModelExtension extends AbstractExtension
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @return void
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $this->parseConfiguration(
            $container,
            new Configuration(),
            $configs
        );

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources'));
        $loader->load('services.xml');

        $this->autoConfiguration($container);
    }

    protected function autoConfiguration(ContainerBuilder $container): void
    {
        $container
            ->registerForAutoconfiguration(TypeGuesserInterface::class)
            ->addTag(TypeGuesserCompilerPass::TYPE_GUESSER_TAG);

        $container
            ->registerForAutoconfiguration(BinderInterface::class)
            ->addTag(BinderCompilerPass::BINDER_TAG);
    }
}
