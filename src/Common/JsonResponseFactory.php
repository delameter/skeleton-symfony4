<?php
namespace App\Common;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

final class JsonResponseFactory
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(
        SerializerInterface $serializer,
        RequestStack $requestStack
    ) {
        $this->serializer = $serializer;
        $this->requestStack = $requestStack;
    }

    public function create(
        $data,
        ?SerializationContext $context = null,
        $statusCode = JsonResponse::HTTP_OK,
        $headers = []
    ): JsonResponse {
        if (is_null($data)) {
            $serializedData = '';
        } else {
            if (is_null($context)) {
                $context = new SerializationContext();
                $context->setSerializeNull(true);
            }
            $serializedData = $this->serializer->serialize($data, 'json', $context);
        }

        $response = new JsonResponse($serializedData, $statusCode, $headers, true);

        $callback = $this->requestStack->getCurrentRequest()->get('callback');
        if (!empty($callback)) {
            $response->setCallback($callback);
        }

        return $response;
    }
}
