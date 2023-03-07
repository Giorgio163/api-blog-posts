<?php

namespace Project4\Validator;

use Project4\Exception\InvalidDataException;
use Ramsey\Uuid\Uuid;

class CategoryValidator
{
    public static function validate(array $inputs): void
    {
        $errors = [];
        $name = $inputs['name'] ?? '';
        if (trim($name) === '') {
            $errors[] = 'Name should not be empty';
        }
        if (strlen($name) < 3) {
            $errors[] = 'Name should not have less than 3 characters';
        }
        if (strlen($name) > 30) {
            $errors[] = 'Name should not have over 30 characters';
        }

        $description = $inputs['description'] ?? '';
        if (trim($description) === '') {
            $errors[] = 'Description should not be empty';
        }
        if (strlen($description) < 3) {
            $errors[] = 'Description should not have less than 3 characters';
        }

        if (count($errors) > 0) {
            throw InvalidDataException::fromErrors($errors);
        }
    }
    public static function validateCategoryId(array $jsonParams): void
    {
        $errors = [];

        foreach ($jsonParams as $id) {
            if (trim($id) === '') {
                $errors[] = 'Category Id should not be empty';
            } elseif (! Uuid::isValid($id)) {
                $errors[] = "Category Id: [$id] needs to be a UUID";
            }
        }
        if (count($errors) > 0) {
            throw InvalidDataException::fromErrors($errors);
        }
    }
}
