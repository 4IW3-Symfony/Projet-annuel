<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\MotorcycleImage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MotorcycleImageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $ads = $manager->getRepository(Ad::class)->findAll();

        for ($i = 0; $i < 30; $i++) {

            $object = (new MotorcycleImage())
                ->setImage($faker->imageUrl())
                ->setAd($faker->randomElement($ads));
            $manager->persist($object);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            AdFixtures::class
        ];
    }
}
