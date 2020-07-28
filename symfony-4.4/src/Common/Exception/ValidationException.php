<?php
namespace App\Common\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends \RuntimeException
{
    public const MESSAGE = 'Validation exception';

    /**
     * @var ConstraintViolationListInterface
     */
    private $constraintViolationList;

    public function __construct(string $message = self::MESSAGE, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getConstraintViolationList(): ConstraintViolationListInterface
    {
        return $this->constraintViolationList;
    }

    /**
     * @param ConstraintViolationListInterface $constraintViolationList
     */
    public function setConstraintViolationList(ConstraintViolationListInterface $constraintViolationList): void
    {
        $this->constraintViolationList = $constraintViolationList;
    }
}
