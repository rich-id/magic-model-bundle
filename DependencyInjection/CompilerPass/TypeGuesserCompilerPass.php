<?php declare(strict_types=1);

namespace RichId\MagicModelBundle\DependencyInjection\CompilerPass;

use RichCongress\BundleToolbox\Configuration\AbstractCompilerPass;
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
final class TypeGuesserCompilerPass extends AbstractCompilerPass
{
    public const MANDATORY_SERVICES = [TypeGuesserManager::class];
    public const TYPE_GUESSER_TAG = 'rich_id.magic_model.type_guesser';

    public function process(ContainerBuilder $container): void
    {
        $taggedServices = $container->findTaggedServiceIds(self::TYPE_GUESSER_TAG);
        $references = array_map(
            static function (string $serviceId): Reference {
                return new Reference($serviceId);
            },
            array_keys($taggedServices)
        );

        $manager = $container->getDefinition(TypeGuesserManager::class);
        $manager->addMethodCall('setTypeGuessers', [$references]);
    }
}
