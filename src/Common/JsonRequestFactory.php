<?php
namespace App\Common;

use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class JsonRequestFactory
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param RequestStack $requestStack
     * @param SerializerInterface $serializer
     */
    public function __construct(RequestStack $requestStack, SerializerInterface $serializer)
    {
        $this->requestStack = $requestStack;
        $this->serializer = $serializer;
    }

    /**
     * @param string $className
     * @throws BadRequestHttpException
     * @return object
     */
    public function getRequestBodyAsObject(string $className): object
    {
        return $this->deserializeRequestContents($className);
    }

    /**
     * @param string $className
     * @throws BadRequestHttpException
     * @return \stdClass[]
     */
    public function getRequestBodyAsObjectArray(string $className): array
    {
        $dataFormat = sprintf('array<%s>', $className);
        return $this->deserializeRequestContents($dataFormat);
    }

    /**
     * @param string $formatDescription
     * @throws BadRequestHttpException
     * @return mixed
     */
    private function deserializeRequestContents(string $formatDescription)
    {
        try {
            return $this->serializer->deserialize(
                $this->requestStack->getMasterRequest()->getContent(),
                $formatDescription,
                'json'
            );
        } catch (\Throwable $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    /**
     * @param string $className
     * @return object
     */
    public function getQueryParametersAsObject(string $className): object
    {
        $data = iterator_to_array($this->requestStack->getMasterRequest()->query->getIterator());

        $json = json_encode($data);

        try {
            return $this->serializer->deserialize($json, $className, 'json');
        } catch (\Throwable $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
