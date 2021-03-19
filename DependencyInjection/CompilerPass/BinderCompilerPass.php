<?php declare(strict_types=1);

namespace RichId\MagicModelBundle\DependencyInjection\CompilerPass;

use RichCongress\BundleToolbox\Configuration\AbstractCompilerPass;
use RichId\MagicModelBundle\Binder\BinderManager;
use RichId\MagicModelBundle\TypeGuesser\TypeGuesserManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class TypeGuesserCompilerPass
 *
 * @package    RichId\MagicModelBundle\DependencyInjection\CompilerPass
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 RichID (https://www.rich-id.fr)
 */
final class BinderCompilerPass extends AbstractCompilerPass
{
    public const MANDATORY_SERVICES = [BinderManager::class];
    public const BINDER_TAG = 'rich_id.magic_model.binder';

    public function process(ContainerBuilder $container): void
    {
        $taggedServices = $container->findTaggedServiceIds(self::BINDER_TAG);
        $references = array_map(
            static function (string $serviceId): Reference {
                return new Reference($serviceId);
            },
            array_keys($taggedServices)
        );

        $manager = $container->getDefinition(BinderManager::class);
        $manager->addMethodCall('setBinders', [$references]);
    }
}
