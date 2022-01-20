<?php

namespace App\DataFixtures;


use App\Entity\User;
use App\Entity\LicenceType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        // Admin
        // $admin = (new User())
        //     ->setEmail('admin@admin')
        //     ->setRoles(['ROLE_ADMIN']);
        // $adminPassword = $this->passwordEncoder->encodePassword("admin", $admin->getSalt());
        // $admin->setPassword($adminPassword);
        // $manager->persist($admin);

        $licenceTypes = $manager->getRepository(LicenceType::class)->findAll();
        // user
        for ($i = 0; $i < 5; $i++) {
            $dt = $faker->dateTimeBetween($startDate = '-60 years', $endDate = '-18 years');
            $date = $dt->format("Y-m-d");
            $user = (new User())
                ->setEmail("user$i@test.com")
                ->setRoles(['ROLE_USER'])
                ->setIsVerified(true)
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setDateOfBirth($dt)
                ->setLicenceType($faker->randomElement($licenceTypes))
                ->setDrivingLicence($faker->imageUrl())
                ->setIdCard($faker->imageUrl())
                ->setAddress($faker->streetAddress)
                ->setCity($faker->city)
                ->setZip($faker->postcode);
            $userPassword = $this->passwordHasher->hashPassword($user, "user");
            $user->setPassword($userPassword);

            $manager->persist($user);
        }

        //
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            LicenceTypeFixtures::class
        ];
    }
}
