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
class PHPDocTypeGuesser implements TypeGuesserInterface
{
    /** @var PhpDocReader|null */
    protected $reader;

    public function guess(\ReflectionProperty $reflectionProperty): GuessedType
    {
        $guessedType = new GuessedType();
        $guessedType->type = $this->getType($reflectionProperty);
        $guessedType->isNullable = false;

        return $guessedType;
    }

    public function supports(\ReflectionProperty $reflectionProperty): bool
    {
        try {
            return $this->getType($reflectionProperty) !== null;
        } catch (AnnotationException $_) {
            return false;
        }
    }

    public function priority(): int
    {
        return -100;
    }

    protected function getReader(): PhpDocReader
    {
        if ($this->reader === null) {
            $this->reader = new PhpDocReader();
        }

        return $this->reader;
    }

    /**
     * @throws AnnotationException
     */
    protected function getType(\ReflectionProperty $reflectionProperty): ?string
    {
        return $this->getReader()->getPropertyClass($reflectionProperty)
            ?? $this->getReader()->getPropertyType($reflectionProperty);
    }
}
