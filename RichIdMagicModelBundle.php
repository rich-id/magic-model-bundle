<?php declare(strict_types=1);

namespace RichId\MagicModelBundle;

use RichCongress\BundleToolbox\Configuration\AbstractBundle;
use RichId\MagicModelBundle\DependencyInjection\CompilerPass\BinderCompilerPass;
use RichId\MagicModelBundle\DependencyInjection\CompilerPass\TypeGuesserCompilerPass;

/**
 * Class RichIdMagicModelBundle
 *
 * @package    RichId\MagicModelBundle
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 RichID (https://www.rich-id.fr)
 */
class RichIdMagicModelBundle extends AbstractBundle
{
    public const COMPILER_PASSES = [
        BinderCompilerPass::class,
        TypeGuesserCompilerPass::class,
    ];
}
