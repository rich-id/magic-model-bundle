<?php declare(strict_types=1);

namespace RichId\MagicModelBundle\Tests;

use RichCongress\TestTools\TestCase\TestCase;
use RichId\MagicModelBundle\RichIdMagicModelBundle;

/**
 * Class DummyTest
 *
 * @package   RichId\MagicModelBundle\Tests
 * @author    Nicolas Guilloux <nguilloux@rich-id.com>
 * @copyright 2014 - 2020 RichId (https://www.rich-id.com)
 */
class DummyTest extends TestCase
{
    public function testInstanciateBundle(): void
    {
        $bundle = new RichIdMagicModelBundle();

        self::assertInstanceOf(RichIdMagicModelBundle::class, $bundle);
    }
}
