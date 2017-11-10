<?php

namespace Tests\Fixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker\Factory;

abstract class Fixture extends AbstractFixture implements OrderedFixtureInterface
{
    // here is order of all fixtures
    // Please place here some marks to make fixtures readable
    const FIRST = 5;
    const AFTER_USERS = 10;

    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }
}
