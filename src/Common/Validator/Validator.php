<?php
namespace App\Common\Validator;

use App\Common\Exception\ValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface as CoreValidator;

class Validator implements ValidatorInterface
{
    /**
     * @var CoreValidator
     */
    private $coreValidator;

    /**
     * Validator constructor.
     * @param CoreValidator $coreValidator
     */
    public function __construct(CoreValidator $coreValidator)
    {
        $this->coreValidator = $coreValidator;
    }

    /**
     * @param $object
     * @param array $groups
     */
    public function validate($object, array $groups = []): void
    {
        $violations = $this->coreValidator->validate($object, null, $groups);
        if (!$violations->count()) {
            return;
        }

        $ex = new ValidationException();
        $ex->setConstraintViolationList($violations);

        throw $ex;
    }
}
