<?php declare(strict_types=1);

namespace RichId\MagicModelBundle\Tests\Builder;

use RichCongress\TestSuite\TestCase\TestCase;
use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichId\MagicModelBundle\Builder\MagicModelBuilder;
use RichId\MagicModelBundle\Tests\Resources\Model\DummyModel;

/**
 * Class StringMagicModelBuilderTest
 *
 * @package    RichId\MagicModelBundle\Tests\Builder
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 RichID (https://www.rich-id.fr)
 *
 * @TestConfig("container")
 * @covers \RichId\MagicModelBundle\Binder\MagicModelBuilder
 */
final class StringMagicModelBuilderTest extends TestCase
{
    /** @var MagicModelBuilder */
    private $builder;

    protected function beforeTest(): void
    {
        $this->builder = $this->getService(MagicModelBuilder::class);
    }

    public function testStringBinding(): void
    {
        $data = [
            'stringPHPDocProperty'          => 'test phpdoc',
            'stringTypedProperty'           => 'test typed property',
            'stringAssertProperty'          => 'test assert type',
            'stringMagicAnnotationProperty' => 'test magic annotation',
        ];

        $model = $this->builder->build(DummyModel::class, $data);

        self::assertInstanceOf(DummyModel::class, $model);
        self::assertSame('test phpdoc', $model->stringPHPDocProperty);
        self::assertSame('test typed property', $model->stringTypedProperty);
        self::assertSame('test assert type', $model->stringAssertProperty);
        self::assertSame('test magic annotation', $model->stringMagicAnnotationProperty);
    }

    public function testStringBindingWithCasting(): void
    {
        $data = [
            'stringPHPDocProperty'          => 1,
            'stringTypedProperty'           => 2,
            'stringAssertProperty'          => 3,
            'stringMagicAnnotationProperty' => 4,
        ];

        $model = $this->builder->build(DummyModel::class, $data);

        self::assertInstanceOf(DummyModel::class, $model);
        self::assertSame('1', $model->stringPHPDocProperty);
        self::assertSame('2', $model->stringTypedProperty);
        self::assertSame('3', $model->stringAssertProperty);
        self::assertSame('4', $model->stringMagicAnnotationProperty);
    }
}
