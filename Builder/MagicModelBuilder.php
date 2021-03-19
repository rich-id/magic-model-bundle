<?php declare(strict_types=1);

namespace RichId\MagicModelBundle\Builder;

use RichId\MagicModelBundle\Binder\BinderManagerInterface;

/**
 * Class MagicModelBuilder
 *
 * @package    RichId\MagicModelBundle\Builder
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 RichID (https://www.rich-id.fr)
 */
class MagicModelBuilder
{
    /** @var BinderManagerInterface */
    protected $binderManager;

    public function __construct(BinderManagerInterface $binderManager)
    {
        $this->binderManager = $binderManager;
    }

    /**
     * @return object
     */
    public function build(string $class, array $data)
    {
        $object = new $class();

        foreach ($data as $propertyName => $value) {
            $this->binderManager->bind($object, $propertyName, $value);
        }

        return $object;
    }
}
