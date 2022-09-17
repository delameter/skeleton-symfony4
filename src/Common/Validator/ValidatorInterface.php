<?php
namespace App\Common\Validator;

interface ValidatorInterface
{
    public function validate($object, array $groups = []): void;
}
