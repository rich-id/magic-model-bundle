<?php declare(strict_types=1);

namespace RichId\MagicModelBundle\Binder;

/**
 * Interface BinderManagerInterface
 *
 * @package    RichId\MagicModelBundle\Builder
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 RichID (https://www.rich-id.fr)
 */
interface BinderManagerInterface
{
    /**
     * @param object $object
     * @param mixed  $value
     *
     * @return object
     */
    public function bind($object, string $propertyName, $value);
}
