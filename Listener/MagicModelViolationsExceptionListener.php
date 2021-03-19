<?php declare(strict_types=1);

namespace RichId\MagicModelBundle\Listener;

use RichId\MagicModelBundle\DependencyInjection\Configuration;
use RichId\MagicModelBundle\Exception\MagicModelValidationException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

/**
 * Class MagicModelViolationsExceptionListener
 *
 * @package    RichId\MagicModelBundle\Listener
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 RichID (https://www.rich-id.fr)
 */
class MagicModelViolationsExceptionListener
{
    /** @var ParameterBagInterface */
    protected $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof MagicModelValidationException) {
            return;
        }

        $validationRoundConfig = $this->findValidationRoundConfig($exception);
        $statusCode = $validationRoundConfig['http_status_code'] ?? Response::HTTP_BAD_REQUEST;

        // TODO: Change JsonResponse to a proper factory, and fix the status code
        $response = new JsonResponse(
            $exception->getViolationsArray(),
            $statusCode
        );

        $response->headers->set('Content-Type', 'application/problem+json');

        $event->setResponse($response);
    }

    protected function findValidationRoundConfig(MagicModelValidationException $exception): array
    {
        $validationRound = $exception->getValidationRound();

        if ($validationRound === null) {
            return [];
        }

        $configurations = Configuration::get('validation_rounds', $this->parameterBag);

        foreach ($configurations as $configuration) {
            if ($configuration['keyname'] === $validationRound) {
                return $configuration;
            }
        }

        return [];
    }
}
