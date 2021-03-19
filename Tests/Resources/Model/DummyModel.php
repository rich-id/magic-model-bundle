<?php declare(strict_types=1);

namespace RichId\MagicModelBundle\Tests\Resources\Model;

use RichId\MagicModelBundle\Annotation\MagicModelProperty;
use RichId\MagicModelBundle\Model\MagicModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class DummyModel
 *
 * @package    RichId\MagicModelBundle\Tests\Resources\Model
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 RichID (https://www.rich-id.fr)
 */
final class DummyModel implements MagicModelInterface
{
    /** @var string */
    public $stringPHPDocProperty;

    public string $stringTypedProperty;

    /**
     * @Assert\Type("string")
     */
    public $stringAssertProperty;

    /**
     * @MagicModelProperty("string")
     */
    public $stringMagicAnnotationProperty;

    /** @var float|int */
    public $numericPHPDocProperty;
}
