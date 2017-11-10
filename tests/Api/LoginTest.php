<?php

namespace Tests\Api;

use Tests\Support\ApiTestCase;

class LoginTest extends ApiTestCase
{
    public function testLogin()
    {
        $response = $this->request('POST', '/api/v1/sessions', [
            'email' => 'testuser@example.com',
            'password' => 'password',
        ]);

        $this->assertStatusCode(201, $response);
    }
}
