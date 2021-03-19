<?php declare(strict_types=1);

namespace RichId\MagicModelBundle\Exception;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class MagicModelValidationException
 *
 * @package    RichId\MagicModelBundle\Exception
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 RichID (https://www.rich-id.fr)
 */
class MagicModelValidationException extends \LogicException
{
    /** @var string */
    protected $validationRound;

    /** @var ConstraintViolationListInterface|ConstraintViolationInterface[] */
    protected $violations;

    public function __construct(ConstraintViolationListInterface $violations, string $validationRound = null)
    {
        $this->violations = $violations;
        $this->validationRound = $validationRound;

        parent::__construct();
    }

    /**
     * @return ConstraintViolationListInterface|ConstraintViolationInterface[]
     */
    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }

    public function getValidationRound(): ?string
    {
        return $this->validationRound;
    }

    /**
     * @return array
     */
    public function getViolationsArray(): array
    {
        $errors = [];

        foreach ($this->violations as $violation) {
            $errors[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $errors;
    }
}
