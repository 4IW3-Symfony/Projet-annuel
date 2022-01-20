<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BrandFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {

            $object = (new Brand())
                ->setName($faker->word)
                ->setLogo($faker->imageUrl());
            $manager->persist($object);
        }

        $manager->flush();
    }
}
