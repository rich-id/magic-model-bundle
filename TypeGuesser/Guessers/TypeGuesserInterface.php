<?php declare(strict_types=1);

namespace RichId\MagicModelBundle\TypeGuesser\Guessers;

use RichId\MagicModelBundle\TypeGuesser\GuessedType;

/**
 * Interface TypeGuesserInterface
 *
 * @package    RichId\MagicModelBundle\TypeGuesser\Guessers
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 RichID (https://www.rich-id.fr)
 */
interface TypeGuesserInterface
{
    public function guess(\ReflectionProperty $reflectionProperty): GuessedType;
    public function supports(\ReflectionProperty $reflectionProperty): bool;
    public function priority(): int;
}
