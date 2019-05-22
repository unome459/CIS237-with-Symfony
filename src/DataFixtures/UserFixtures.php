<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture {
    public function load(ObjectManager $manager) {
        $user = new User();
        $user->setUsername('joe');
        $user->setEmail('joe@example.com');
        $user->setPlainPassword('test123');
        $user->addRole('ROLE_ADMIN');
        $user->setEnabled(true);

        $manager->persist($user);

        $user = new User();
        $user->setUsername('jameson');
        $user->setEmail('jameson@example.com');
        $user->setPlainPassword('password');
        $user->addRole('ROLE_ADMIN');
        $user->setEnabled(true);

        $manager->persist($user);
        $manager->flush();
    }
}