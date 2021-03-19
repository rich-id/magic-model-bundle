<?php declare(strict_types=1);

namespace RichId\MagicModelBundle\TypeGuesser;

/**
 * Class GuessedType
 *
 * @package    RichId\MagicModelBundle\TypeGuesser
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 RichID (https://www.rich-id.fr)
 */
final class GuessedType
{
    /** @var string */
    public $type;

    /** @var bool */
    public $isNullable;
}
