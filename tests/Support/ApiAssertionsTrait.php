<?php

namespace Tests\Support;

use Symfony\Component\HttpFoundation\Response;

trait ApiAssertionsTrait
{
    protected function assertStatusCode(int $expectedStatus, Response $response, $message = '')
    {
        \PHPUnit_Framework_Assert::assertEquals($expectedStatus, $response->getStatusCode(), $message);
    }
}
