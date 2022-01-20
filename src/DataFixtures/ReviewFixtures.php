<?php

namespace App\DataFixtures;

use App\Entity\Rental;
use App\Entity\Review;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReviewFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $users = $manager->getRepository(User::class)->findAll();
        $rentals = $manager->getRepository(Rental::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            $object = (new Review())
                ->setDate($faker->dateTime)
                ->setTitle($faker->word)
                ->setReview($faker->sentence(3))
                ->setCustomer($faker->randomElement($users))
                ->setRental($faker->randomElement($rentals));
            $manager->persist($object);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            RentalFixtures::class
        ];
    }
}
