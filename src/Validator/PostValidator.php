<?php

namespace Project4\Validator;

use Project4\Exception\InvalidDataException;

class PostValidator
{
    public static function validate(array $inputs): void
    {
        $errors = [];
        $title = $inputs['title'] ?? '';
        if (trim($title) === '') {
            $errors[] = 'Title should not be empty';
        }
        if (strlen($title) < 3) {
            $errors[] = 'Title should not have less than 3 characters';
        }
        if (strlen($title) > 30) {
            $errors[] = 'Title should not have over 30 characters';
        }

        $content = $inputs['content'] ?? '';
        if (trim($content) === '') {
            $errors[] = 'Content should not be empty';
        }
        if (strlen($content) < 3) {
            $errors[] = 'Content should not have less than 3 characters';
        }

        $thumbnail = $inputs['thumbnail'] ?? '';
        if (trim($thumbnail) === '') {
            $errors[] = 'Thumbnail should not be empty';
        }
        if (strlen($thumbnail) < 3) {
            $errors[] = 'Thumbnail should not have less than 3 characters';
        }

        $author = $inputs['author'] ?? '';
        if (trim($author) === '') {
            $errors[] = 'Author should not be empty';
        }
        if (strlen($author) < 3) {
            $errors[] = 'Author should not have less than 3 characters';
        }
        if (strlen($title) > 255) {
            $errors[] = 'Author should not have over 255 characters';
        }

        if (count($errors) > 0) {
            throw InvalidDataException::fromErrors($errors);
        }
    }
}
