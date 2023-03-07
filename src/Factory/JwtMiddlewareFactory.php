<?php

namespace Project4\Factory;

use Tuupola\Middleware\JwtAuthentication;

class JwtMiddlewareFactory
{
    public static function make(): JwtAuthentication
    {
        return new JwtAuthentication(
            [
            'secret' => $_ENV['JWT_SECRET']
            ]
        );
    }
}
