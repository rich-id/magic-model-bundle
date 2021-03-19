<?php declare(strict_types=1);

namespace RichId\MagicModelBundle\Binder\Binders;

use RichId\MagicModelBundle\TypeGuesser\GuessedType;

/**
 * Interface BinderInterface
 *
 * @package    RichId\MagicModelBundle\Builder\Builders
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 RichID (https://www.rich-id.fr)
 */
interface BinderInterface
{
    public function bind(GuessedType $guessedType, $value);
    public function supports(GuessedType $guessedType, $value): bool;
    public function priority(): int;
}
