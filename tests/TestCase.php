<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public static $API_PREFIX = "api/v1/";

    /**
     * Log in a user and return the authentication token.
     *
     * @param string $email
     * @param string $password
     * @return string|null
     */
    protected function login(string $email, string $password): ?string
    {
        $response = $this->postJson(self::$API_PREFIX . 'login', [
            'email' => $email,
            'password' => $password,
        ]);

        $response->assertStatus(200); 
        return $response->json('token');
    }
}
