<?php declare(strict_types=1);

namespace RichId\MagicModelBundle\TypeGuesser\Guessers;

use PhpDocReader\AnnotationException;
use PhpDocReader\PhpDocReader;
use RichId\MagicModelBundle\TypeGuesser\GuessedType;

/**
 * Class PHPDocTypeGuesser
 *
 * @package    RichId\MagicModelBundle\TypeGuesser\Guessers
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 RichID (https://www.rich-id.fr)
 */
class PropertyTypeTypeGuesser implements TypeGuesserInterface
{
    public function guess(\ReflectionProperty $reflectionProperty): GuessedType
    {
        /** @var \ReflectionNamedType $reflectionType */
        $reflectionType = $reflectionProperty->getType();

        $guessedType = new GuessedType();
        $guessedType->type = $reflectionType->getName();
        $guessedType->isNullable = false;

        return $guessedType;
    }

    public function supports(\ReflectionProperty $reflectionProperty): bool
    {
        return $reflectionProperty->getType() !== null;
    }

    public function priority(): int
    {
        return 100;
    }
}
