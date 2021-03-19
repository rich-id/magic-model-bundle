<?php declare(strict_types=1);

namespace RichId\MagicModelBundle\Tests\TypeGuesser;

use RichCongress\TestSuite\TestCase\TestCase;
use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichId\MagicModelBundle\Tests\Resources\Model\DummyModel;
use RichId\MagicModelBundle\TypeGuesser\TypeGuesserManagerInterface;

/**
 * Class StringTypeGuesserTest
 *
 * @package    RichId\MagicModelBundle\Tests\TypeGuesser
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 RichID (https://www.rich-id.fr)
 *
 * @TestConfig("container")
 * @covers \RichId\MagicModelBundle\TypeGuesser\TypeGuesserManager
 */
final class StringTypeGuesserTest extends TestCase
{
    /** @var TypeGuesserManagerInterface */
    private $typeGuesserManager;

    protected function beforeTest(): void
    {
        $this->typeGuesserManager = $this->getService(TypeGuesserManagerInterface::class);
    }

    /**
     * @covers \RichId\MagicModelBundle\TypeGuesser\Guessers\PropertyTypeTypeGuesser
     */
    public function testPropertyTypeTypeGuesser(): void
    {
        $reflectionProperty = new \ReflectionProperty(DummyModel::class, 'stringTypedProperty');
        $guessedType = $this->typeGuesserManager->guess($reflectionProperty);

        self::assertSame('string', $guessedType->type);
        self::assertFalse($guessedType->isNullable);
    }

    /**
     * @covers \RichId\MagicModelBundle\TypeGuesser\Guessers\PropertyTypeTypeGuesser
     */
    public function testPHPDocTypeGuesser(): void
    {
        $reflectionProperty = new \ReflectionProperty(DummyModel::class, 'stringPHPDocProperty');
        $guessedType = $this->typeGuesserManager->guess($reflectionProperty);

        self::assertSame('string', $guessedType->type);
        self::assertFalse($guessedType->isNullable);
    }
}
