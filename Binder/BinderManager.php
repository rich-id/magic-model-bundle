<?php declare(strict_types=1);

namespace RichId\MagicModelBundle\Binder;

use RichId\MagicModelBundle\Binder\Binders\BinderInterface;
use RichId\MagicModelBundle\TypeGuesser\GuessedType;
use RichId\MagicModelBundle\TypeGuesser\TypeGuesserManagerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * Class BinderManager
 *
 * @package    RichId\MagicModelBundle\Builder
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 RichID (https://www.rich-id.fr)
 */
class BinderManager implements BinderManagerInterface
{
    /** @var BinderInterface[] */
    protected $binders = [];

    /** @var TypeGuesserManagerInterface */
    protected $typeGuesserManager;

    /** @var PropertyAccessor */
    protected $propertyAccessor;

    public function __construct(TypeGuesserManagerInterface $typeGuesserManager)
    {
        $this->typeGuesserManager = $typeGuesserManager;
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * @param object $object
     * @param mixed  $value
     *
     * @return object
     */
    public function bind($object, string $propertyName, $value)
    {
        $reflectionProperty = new \ReflectionProperty($object, $propertyName);
        $guessedType = $this->typeGuesserManager->guess($reflectionProperty);
        $newValue = $this->getProcessedValue($guessedType, $value);
        $this->propertyAccessor->setValue($object, $propertyName, $newValue);

        return $object;
    }


    /**
     * @param BinderInterface[] $builders
     */
    public function setBinders(array $builders): void
    {
        $this->binders = $builders;
        $this->sortBinders();
    }

    protected function sortBinders(): void
    {
        usort(
            $this->binders,
            static function (BinderInterface $left, BinderInterface $right): int {
                $leftPriority = $left->priority();
                $rightPriority = $right->priority();

                if ($leftPriority === $rightPriority) {
                    return 0;
                }

                return ($leftPriority < $rightPriority) ? -1 : 1;
            }
        );
    }

    protected function getProcessedValue(?GuessedType $guessedType, $value)
    {
        if ($guessedType === null) {
            return $value;
        }

        foreach ($this->binders as $binder) {
            if ($binder->supports($guessedType, $value)) {
                return $binder->bind($guessedType, $value);
            }
        }

        return $value;
    }
}
