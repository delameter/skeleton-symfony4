<?php
namespace App\Controller;

use App\Common\JsonResponseFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TestController
{
    /**
     * @var JsonResponseFactory
     */
    private $responseFactory;

    /**
     * @param JsonResponseFactory $responseFactory
     */
    public function __construct(
        JsonResponseFactory $responseFactory
    ) {
        $this->responseFactory = $responseFactory;
    }

    /**
     * @Route("/", methods={Request::METHOD_GET})
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->responseFactory->create(['ok?' => 'ok']);
    }

    /**
     * @Route("/test400", methods={Request::METHOD_GET})
     *
     * @return JsonResponse
     */
    public function test400(): JsonResponse
    {
        return $this->responseFactory->create(
            null,
            null,
            JsonResponse::HTTP_BAD_REQUEST
        );
    }
}
