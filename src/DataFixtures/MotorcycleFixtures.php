<?php

namespace App\DataFixtures;

use App\Entity\Model;
use App\Entity\LicenceType;
use App\Entity\Motorcycle;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MotorcycleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $licenceTypes = $manager->getRepository(LicenceType::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();
        $models = $manager->getRepository(Model::class)->findAll();

        for ($i = 0; $i < 10; $i++) {

            $object = (new Motorcycle())
                ->setName($faker->word)
                ->setPower($faker->numberBetween($min = 30, $max = 300))
                ->setNumberplate("AA-1285$i")
                // ->setNumberplate($faker->regexify(['[A-Z]{2}[0-9]{5}']))
                ->setDescription($faker->sentence(7))
                ->setKm($faker->numberBetween($min = 1000, $max = 15000))
                ->setYear($faker->numberBetween($min = 2010, $max = 2021))
                ->setVisibility($faker->randomElement([TRUE, FALSE]))
                ->setLicenceType($faker->randomElement($licenceTypes))
                ->setUser($faker->randomElement($users))
                ->setModel($faker->randomElement($models));
            $manager->persist($object);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            LicenceTypeFixtures::class,
            UserFixtures::class,
            ModelFixtures::class
        ];
    }
}
