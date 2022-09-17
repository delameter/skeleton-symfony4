<?php
namespace App\Common\Event;

use App\Common\Exception\ValidationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * @package App\Common\Event
 */
class ExceptionKernelSubscriber implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        /** @var \Throwable $ex */
        $ex = $event->getThrowable();

        $response = $this->getJsonResponse($ex);
        if (empty($response)) {
            return;
        }

        $response->setEncodingOptions(JsonResponse::DEFAULT_ENCODING_OPTIONS | JSON_UNESCAPED_UNICODE);
        $event->setResponse($response);
    }

    /**
     * @param \Throwable $exception
     *
     * @return JsonResponse|null
     */
    public function getJsonResponse($exception): ?JsonResponse
    {
        if ($exception instanceof ValidationException) {
            $violations = $exception->getConstraintViolationList();
            $messages = [];
            /** @var ConstraintViolation $violation */
            foreach ($violations as $violation) {
                $messages[] = sprintf('%s: %s', $violation->getPropertyPath(), $violation->getMessage());
            }
            return new JsonResponse([
                'message' => implode(', ', $messages),
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        return null;
    }
}
