<?php

namespace App\Model\User;

use Doctrine\ORM\EntityManagerInterface;

class UserRepository
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
}

