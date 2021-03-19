<?php declare(strict_types=1);

namespace RichId\MagicModelBundle\Binder\Binders;

use RichId\MagicModelBundle\TypeGuesser\GuessedType;

/**
 * Class StringBinder
 *
 * @package    RichId\MagicModelBundle\Binder\Binders
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 RichID (https://www.rich-id.fr)
 */
class StringBinder implements BinderInterface
{
    public function bind(GuessedType $guessedType, $value)
    {
        return (string) $value;
    }

    public function supports(GuessedType $guessedType, $value): bool
    {
        return $guessedType->type === 'string';
    }

    public function priority(): int
    {
        return 0;
    }
}
