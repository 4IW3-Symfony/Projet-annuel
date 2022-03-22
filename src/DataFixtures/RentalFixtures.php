<?php

namespace App\DataFixtures;

use App\Entity\Motorcycle;
use App\Entity\Rental;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RentalFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $users = $manager->getRepository(User::class)->findAll();
        $motorcycles = $manager->getRepository(Motorcycle::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            $motorcycle = $faker->randomElement($motorcycles);
            $km = $motorcycle->getKm();
            $object = (new Rental())
                ->setDateStart($faker->dateTimeBetween('-2 weeks', '-1 week'))
                ->setDateEnd($faker->dateTimeBetween('-5 days'))
                ->setStatus($faker->randomDigit)
                ->setKmStart($km)
                ->setKmEnd($km + $faker->numberBetween(100, 1000))
                ->setUser($faker->randomElement($users))
                ->setMotorcycle($motorcycle);
            $manager->persist($object);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            MotorcycleFixtures::class
        ];
    }
}
