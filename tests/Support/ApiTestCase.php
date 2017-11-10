<?php

namespace Tests\Support;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class ApiTestCase extends KernelTestCase
{
    use ApiClientTrait;
    use ApiAssertionsTrait;

    protected function getContainer(): ContainerInterface
    {
        return $this->getKernel()->getContainer();
    }

    protected function getKernel(): KernelInterface
    {
        if (!self::$kernel) {
            self::$kernel = self::createKernel();
        }
        self::$kernel->boot();

        return self::$kernel;
    }

    protected function getFileFixturesPath(): string
    {
        return __DIR__.'/../Fixtures/files';
    }
}
