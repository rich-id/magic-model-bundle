<?php declare(strict_types=1);

namespace RichId\MagicModelBundle\TypeGuesser;

/**
 * Interface TypeGuesserManagerInterface
 *
 * @package    RichId\MagicModelBundle\TypeGuesser
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 RichID (https://www.rich-id.fr)
 */
interface TypeGuesserManagerInterface
{
    public function guess(\ReflectionProperty $reflectionProperty): ?GuessedType;
}
