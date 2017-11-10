<?php

namespace Tests\Support;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class AnonymousFixture extends AbstractFixture
{
    private $fn;

    /**
     * AnonymousFixture constructor.
     * @param $fn
     */
    public function __construct($fn)
    {
        $this->fn = $fn;
    }

    public function load(ObjectManager $manager)
    {
        call_user_func($this->fn, $manager);
    }
}
