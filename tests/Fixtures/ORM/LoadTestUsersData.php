<?php

namespace tests\fixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Tests\Fixtures\ORM\Fixture;

class LoadTestUsersData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // todo
    }

    public function getOrder()
    {
        return self::FIRST;
    }
}
