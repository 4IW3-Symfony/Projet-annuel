<?php

namespace App\DataFixtures;

use App\Entity\LicenceType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LicenceTypeFixtures extends Fixture
{     
    public function load(ObjectManager $manager): void
    {

        $object = (new LicenceType())
            ->setType('A');
        $manager->persist($object);

        $object = (new LicenceType())
            ->setType('A1');
        $manager->persist($object);

        $object = (new LicenceType())
            ->setType('A2');
        $manager->persist($object);

        $manager->flush();
    }
}
