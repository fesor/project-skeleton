<?php

namespace Tests\Support;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;
use Symfony\Component\DependencyInjection\ContainerInterface;

trait FixturesTrait
{
    private static $fixtureLoaded = false;
    private static $loadedFixtures;

    public static function setUpBeforeClass()
    {
        self::$fixtureLoaded = false;
        self::$loadedFixtures = [];

        parent::setUpBeforeClass();
    }

    public function loadFixtures($fixtures)
    {
        if (self::$fixtureLoaded) {
            return self::$loadedFixtures;
        }

        $fixtures = $this->normalizeFixtures($fixtures);

        $container = $this->getContainer();
        $loader = new ContainerAwareLoader($container);
        foreach ($fixtures as $fixture) {
            $loader->addFixture($fixture);
        }

        $em = $container->get('doctrine.orm.default_entity_manager');
        $purger = new ORMPurger($em);
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);
        $executor = new ORMExecutor($em, $purger);
        $executor->execute($loader->getFixtures());

        self::$fixtureLoaded = true;
        self::$loadedFixtures = $fixtures;

        return self::$loadedFixtures;
    }

    /**
     * @param mixed $fixtures
     * @return AbstractFixture[]
     */
    private function normalizeFixtures($fixtures)
    {
        if (is_callable($fixtures)) {
            $fixtures = $this->addFixtureFromClosure($fixtures);
        }
        if (!is_array($fixtures)) {
            $fixtures = [$fixtures];
        }

        return array_map(function ($fixture) {
            if (is_string($fixture)) {
                return new $fixture();
            }

            return $fixture;
        }, $fixtures);
    }

    private function addFixtureFromClosure(callable $fixture)
    {
        return new AnonymousFixture($fixture);
    }

    abstract protected function getContainer(): ContainerInterface;
}
