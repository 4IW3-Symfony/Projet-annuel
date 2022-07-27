<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BrandFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $faker = \Faker\Factory::create('fr_FR');
        // for ($i = 0; $i < 10; $i++) {

        //     $object = (new Brand())
        //         ->setName($faker->word)
        //         ->setLogo($faker->imageUrl());
        //     $manager->persist($object);
        // }
        $object = (new Brand())
        ->setName("Aprilia")
        ->setLogo("images/brand/aprilia.png");
        $manager->persist($object);

        $object = (new Brand())
        ->setName("BMW")
        ->setLogo("images/brand/bm.png");
        $manager->persist($object);

        $object = (new Brand())
        ->setName("Ducati")
        ->setLogo("images/brand/ducati.png");
        $manager->persist($object);

        $object = (new Brand())
        ->setName("Harley")
        ->setLogo("images/brand/harley.png");
        $manager->persist($object);

        $object = (new Brand())
        ->setName("Honda")
        ->setLogo("images/brand/honda.jpeg");
        $manager->persist($object);

        $object = (new Brand())
        ->setName("Indian")
        ->setLogo("images/brand/indian.png");
        $manager->persist($object);

        $object = (new Brand())
        ->setName("Kawasaki")
        ->setLogo("images/brand/kawasaki.png");
        $manager->persist($object);

        $object = (new Brand())
        ->setName("KTM")
        ->setLogo("images/brand/KTM.png");
        $manager->persist($object);

        $object = (new Brand())
        ->setName("Suzuki")
        ->setLogo("images/brand/Suzuki.png");
        $manager->persist($object);

        $object = (new Brand())
        ->setName("Triumph")
        ->setLogo("images/brand/triumph.png");
        $manager->persist($object);

        $object = (new Brand())
        ->setName("Yamaha")
        ->setLogo("images/brand/yamaha.png");
        $manager->persist($object);

        $manager->flush();
    }
}
