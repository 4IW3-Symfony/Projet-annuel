<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Model;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ModelFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $brand = $manager->getRepository(Brand::class)->findAll();

        for ($i = 0; $i < 10; $i++) {

            $object = (new Model())
                ->setName($faker->word)
                ->setBrand($faker->randomElement($brand));
            $manager->persist($object);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            BrandFixtures::class
        ];
    }
}
