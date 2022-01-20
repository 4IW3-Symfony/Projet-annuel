<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Motorcycle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AdFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $motorcycles = $manager->getRepository(Motorcycle::class)->findAll();

        for ($i = 0; $i < 10; $i++) {

            $object = (new Ad())
                ->setStatus($faker->randomElement(["available", "not available"]))
                ->setDescription($faker->sentence(10))
                ->setMotorcycle($faker->randomElement($motorcycles));
            $manager->persist($object);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            MotorcycleFixtures::class
        ];
    }
}
