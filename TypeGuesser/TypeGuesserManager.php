<?php declare(strict_types=1);

namespace RichId\MagicModelBundle\TypeGuesser;

use RichId\MagicModelBundle\TypeGuesser\Guessers\TypeGuesserInterface;

/**
 * Class TypeGuesserManager
 *
 * @package    RichId\MagicModelBundle\TypeGuesser
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 RichID (https://www.rich-id.fr)
 */
class TypeGuesserManager implements TypeGuesserManagerInterface
{
    /** @var TypeGuesserInterface[] */
    protected $typeGuessers = [];

    /**
     * @param TypeGuesserInterface[] $typeGuessers
     */
    public function setTypeGuessers(array $typeGuessers): void
    {
        $this->typeGuessers = $typeGuessers;
        $this->sortTypeGuessers();
    }

    public function guess(\ReflectionProperty $reflectionProperty): ?GuessedType
    {
        foreach ($this->typeGuessers as $typeGuesser) {
            if ($typeGuesser->supports($reflectionProperty)) {
                return $typeGuesser->guess($reflectionProperty);
            }
        }

        return null;
    }

    protected function sortTypeGuessers(): void
    {
        usort(
            $this->typeGuessers,
            static function (TypeGuesserInterface $left, TypeGuesserInterface $right): int {
                $leftPriority = $left->priority();
                $rightPriority = $right->priority();

                if ($leftPriority === $rightPriority) {
                    return 0;
                }

                return ($leftPriority < $rightPriority) ? -1 : 1;
            }
        );
    }
}
