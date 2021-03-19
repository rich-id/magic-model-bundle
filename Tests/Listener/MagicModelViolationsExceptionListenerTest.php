<?php declare(strict_types=1);

namespace RichId\MagicModelBundle\Tests\Listener;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\MagicModelBundle\Exception\MagicModelValidationException;
use RichId\MagicModelBundle\Listener\MagicModelViolationsExceptionListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * Class MagicModelViolationsExceptionListenerTest
 *
 * @package    RichId\MagicModelBundle\Tests\Listener
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 RichID (https://www.rich-id.fr)
 *
 * @TestConfig("container")
 * @covers \RichId\MagicModelBundle\Exception\MagicModelValidationException
 * @covers \RichId\MagicModelBundle\Listener\MagicModelViolationsExceptionListener
 */
final class MagicModelViolationsExceptionListenerTest extends TestCase
{
    /** @var MagicModelViolationsExceptionListener */
    private $listener;

    protected function beforeTest(): void
    {
        $this->listener = $this->getService(MagicModelViolationsExceptionListener::class);
    }

    public function testWithDefaultValidationRound(): void
    {
        $violation1 = new ConstraintViolation('Bad Value 1', null, [], 'badValue1', 'violation1', 'badValue1');
        $violation2 = new ConstraintViolation('Bad Value 2', null, [], 'badValue2', 'violation2', 'badValue2');
        $violations = new ConstraintViolationList([$violation1, $violation2]);
        $exception = new MagicModelValidationException($violations, 'default');

        $event = new ExceptionEvent(
            \Mockery::mock(HttpKernelInterface::class),
            new Request(),
            0,
            $exception
        );

        $this->listener->onKernelException($event);

        $response = $event->getResponse();
        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertSame('{"violation1":"Bad Value 1","violation2":"Bad Value 2"}', $response->getContent());
    }

    public function testWithConflictValidationRound(): void
    {
        $violation1 = new ConstraintViolation('Bad Value 1', null, [], 'badValue1', 'violation1', 'badValue1');
        $violation2 = new ConstraintViolation('Bad Value 2', null, [], 'badValue2', 'violation2', 'badValue2');
        $violations = new ConstraintViolationList([$violation1, $violation2]);
        $exception = new MagicModelValidationException($violations, 'conflict');

        $event = new ExceptionEvent(
            \Mockery::mock(HttpKernelInterface::class),
            new Request(),
            0,
            $exception
        );

        $this->listener->onKernelException($event);

        $response = $event->getResponse();
        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertSame(Response::HTTP_CONFLICT, $response->getStatusCode());
        self::assertSame('{"violation1":"Bad Value 1","violation2":"Bad Value 2"}', $response->getContent());
    }

    public function testWithNoValidationRound(): void
    {
        $violation1 = new ConstraintViolation('Bad Value 1', null, [], 'badValue1', 'violation1', 'badValue1');
        $violation2 = new ConstraintViolation('Bad Value 2', null, [], 'badValue2', 'violation2', 'badValue2');
        $violations = new ConstraintViolationList([$violation1, $violation2]);
        $exception = new MagicModelValidationException($violations);

        $event = new ExceptionEvent(
            \Mockery::mock(HttpKernelInterface::class),
            new Request(),
            0,
            $exception
        );

        $this->listener->onKernelException($event);

        $response = $event->getResponse();
        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertSame('{"violation1":"Bad Value 1","violation2":"Bad Value 2"}', $response->getContent());
    }
}
