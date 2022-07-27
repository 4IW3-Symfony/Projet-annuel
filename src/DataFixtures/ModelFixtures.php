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

        $aprilia = $manager->getRepository(Brand::class)->findOneBy(['name' => 'Aprilia']);
        $bmw = $manager->getRepository(Brand::class)->findOneBy(['name' => 'BMW']);
        $ducati = $manager->getRepository(Brand::class)->findOneBy(['name' => 'Ducati']);
        $harley = $manager->getRepository(Brand::class)->findOneBy(['name' => 'Harley']);
        $honda = $manager->getRepository(Brand::class)->findOneBy(['name' => 'Honda']);
        $indian = $manager->getRepository(Brand::class)->findOneBy(['name' => 'Indian']);
        $kawasaki = $manager->getRepository(Brand::class)->findOneBy(['name' => 'Kawasaki']);
        $ktm = $manager->getRepository(Brand::class)->findOneBy(['name' => 'KTM']);
        $suzuki = $manager->getRepository(Brand::class)->findOneBy(['name' => 'Suzuki']);
        $triumph = $manager->getRepository(Brand::class)->findOneBy(['name' => 'Triumph']);
        $yamaha = $manager->getRepository(Brand::class)->findOneBy(['name' => 'Yamaha']);

        // --------------------------------------------------------
        $object = (new Model())
            ->setName("RS 660")
            ->setBrand($aprilia);
        $manager->persist($object);
        
        $object = (new Model())
            ->setName("TUAREG 660")
            ->setBrand($aprilia);
        $manager->persist($object);

        $object = (new Model())
            ->setName("TUONO 660")
            ->setBrand($aprilia);
        $manager->persist($object);

        $object = (new Model())
            ->setName("RSV4")
            ->setBrand($aprilia);
        $manager->persist($object);
        
        $object = (new Model())
            ->setName("TUONO V4")
            ->setBrand($aprilia);
        $manager->persist($object);

        $object = (new Model())
            ->setName("TUONO")
            ->setBrand($aprilia);
        $manager->persist($object);

        $object = (new Model())
            ->setName("RX 125")
            ->setBrand($aprilia);
        $manager->persist($object);

        $object = (new Model())
            ->setName("SX 125")
            ->setBrand($aprilia);
        $manager->persist($object);

        $object = (new Model())
            ->setName("RS 125")
            ->setBrand($aprilia);
        $manager->persist($object);

// --------------------------------------------------------
        $object = (new Model())
        ->setName("M 1000 RR")
        ->setBrand($bmw);
        $manager->persist($object);

        $object = (new Model())
        ->setName("S 1000 RR")
        ->setBrand($bmw);
        $manager->persist($object);

        $object = (new Model())
        ->setName("R 1250 RS")
        ->setBrand($bmw);
        $manager->persist($object);

        $object = (new Model())
        ->setName("R 1250 RT")
        ->setBrand($bmw);
        $manager->persist($object);

        $object = (new Model())
        ->setName("K 1600")
        ->setBrand($bmw);
        $manager->persist($object);

        $object = (new Model())
        ->setName("R 1250 R")
        ->setBrand($bmw);
        $manager->persist($object);

        $object = (new Model())
        ->setName("S 1000 R")
        ->setBrand($bmw);
        $manager->persist($object);

        $object = (new Model())
        ->setName("F 900 R")
        ->setBrand($bmw);
        $manager->persist($object);

        $object = (new Model())
        ->setName("G 310 R")
        ->setBrand($bmw);
        $manager->persist($object);

        $object = (new Model())
        ->setName("S 1000 XR")
        ->setBrand($bmw);
        $manager->persist($object);

        $object = (new Model())
        ->setName("F 900 XR")
        ->setBrand($bmw);
        $manager->persist($object);

        $object = (new Model())
        ->setName("R 1250 GS")
        ->setBrand($bmw);
        $manager->persist($object);

// --------------------------------------------------------

        $object = (new Model())
        ->setName("Diavel 1260")
        ->setBrand($ducati);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Hypermotard 950 RVE")
        ->setBrand($ducati);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Monster")
        ->setBrand($ducati);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Streetfighter V2")
        ->setBrand($ducati);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Streetfighter V4")
        ->setBrand($ducati);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Multistrada V2")
        ->setBrand($ducati);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Multistrada V4")
        ->setBrand($ducati);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Panigale V2")
        ->setBrand($ducati);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Panigale V4")
        ->setBrand($ducati);
        $manager->persist($object);

        $object = (new Model())
        ->setName("SuperSport 950")
        ->setBrand($ducati);
        $manager->persist($object);
// --------------------------------------------------------
        $object = (new Model())
        ->setName("Nighter")
        ->setBrand($harley);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Cruiser")
        ->setBrand($harley);
        $manager->persist($object);
        
        $object = (new Model())
        ->setName("Grand American Touring")
        ->setBrand($harley);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Adventure Touring")
        ->setBrand($harley);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Trike")
        ->setBrand($harley);
        $manager->persist($object);

    
// --------------------------------------------------------

        $object = (new Model())
        ->setName("CBR 1000 RR-R")
        ->setBrand($honda);
        $manager->persist($object);

        $object = (new Model())
        ->setName("CBR650R")
        ->setBrand($honda);
        $manager->persist($object);

        $object = (new Model())
        ->setName("CBR500R")
        ->setBrand($honda);
        $manager->persist($object);

        $object = (new Model())
        ->setName("GLOD WING")
        ->setBrand($honda);
        $manager->persist($object);

        $object = (new Model())
        ->setName("CRF1100L")
        ->setBrand($honda);
        $manager->persist($object);

        $object = (new Model())
        ->setName("NC750X DCT")
        ->setBrand($honda);
        $manager->persist($object);

        $object = (new Model())
        ->setName("X-ADV")
        ->setBrand($honda);
        $manager->persist($object);

        $object = (new Model())
        ->setName("CB500X")
        ->setBrand($honda);
        $manager->persist($object);

        $object = (new Model())
        ->setName("CB1000R")
        ->setBrand($honda);
        $manager->persist($object);

        $object = (new Model())
        ->setName("CB650R")
        ->setBrand($honda);
        $manager->persist($object);

        $object = (new Model())
        ->setName("CB500F")
        ->setBrand($honda);
        $manager->persist($object);

        $object = (new Model())
        ->setName("CMX1000")
        ->setBrand($honda);
        $manager->persist($object);

        $object = (new Model())
        ->setName("CMX500")
        ->setBrand($honda);
        $manager->persist($object);

        $object = (new Model())
        ->setName("FORZA 750")
        ->setBrand($honda);
        $manager->persist($object);

        $object = (new Model())
        ->setName("CRF")
        ->setBrand($honda);
        $manager->persist($object);

// --------------------------------------------------------

        $object = (new Model())
        ->setName("FTR")
        ->setBrand($indian);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Scout")
        ->setBrand($indian);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Chief")
        ->setBrand($indian);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Indian Challenger")
        ->setBrand($indian);
        $manager->persist($object);

        $object = (new Model())
        ->setName("RoadMaster")
        ->setBrand($indian);
        $manager->persist($object);

// --------------------------------------------------------

        $object = (new Model())
        ->setName("Ninja H2")
        ->setBrand($kawasaki);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Ninja ZX-10 R")
        ->setBrand($kawasaki);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Ninja 650")
        ->setBrand($kawasaki);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Ninja 400")
        ->setBrand($kawasaki);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Z H2")
        ->setBrand($kawasaki);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Z900")
        ->setBrand($kawasaki);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Z650")
        ->setBrand($kawasaki);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Z400")
        ->setBrand($kawasaki);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Z900 RS")
        ->setBrand($kawasaki);
        $manager->persist($object);

        $object = (new Model())
        ->setName("W800")
        ->setBrand($kawasaki);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Versys 1000")
        ->setBrand($kawasaki);
        $manager->persist($object);

// --------------------------------------------------------


        $object = (new Model())
        ->setName("1290 Super Duke GT")
        ->setBrand($ktm);
        $manager->persist($object);

        $object = (new Model())
        ->setName("1290 Super Duke R")
        ->setBrand($ktm);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Duke 890")
        ->setBrand($ktm);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Duke 390")
        ->setBrand($ktm);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Duke 125")
        ->setBrand($ktm);
        $manager->persist($object);

        $object = (new Model())
        ->setName("RC 8C")
        ->setBrand($ktm);
        $manager->persist($object);

        $object = (new Model())
        ->setName("RC 390")
        ->setBrand($ktm);
        $manager->persist($object);

        $object = (new Model())
        ->setName("RC 125")
        ->setBrand($ktm);
        $manager->persist($object);

        $object = (new Model())
        ->setName("1290 Super Adventure")
        ->setBrand($ktm);
        $manager->persist($object);

        $object = (new Model())
        ->setName("890 Adventure")
        ->setBrand($ktm);
        $manager->persist($object);

        $object = (new Model())
        ->setName("690 Adventure")
        ->setBrand($ktm);
        $manager->persist($object);

        $object = (new Model())
        ->setName("390 Adventure")
        ->setBrand($ktm);
        $manager->persist($object);


// --------------------------------------------------------

        $object = (new Model())
        ->setName("V-Strom 1050")
        ->setBrand($suzuki);
        $manager->persist($object);

        $object = (new Model())
        ->setName("V-Strom 650")
        ->setBrand($suzuki);
        $manager->persist($object);

        $object = (new Model())
        ->setName("HAYUBUSA")
        ->setBrand($suzuki);
        $manager->persist($object);

        $object = (new Model())
        ->setName("GSX-S100GT")
        ->setBrand($suzuki);
        $manager->persist($object);

        $object = (new Model())
        ->setName("KATANA")
        ->setBrand($suzuki);
        $manager->persist($object);

        $object = (new Model())
        ->setName("GSX-S1000")
        ->setBrand($suzuki);
        $manager->persist($object);

        $object = (new Model())
        ->setName("GSX-S950")
        ->setBrand($suzuki);
        $manager->persist($object);

        $object = (new Model())
        ->setName("SV-650")
        ->setBrand($suzuki);
        $manager->persist($object);

// --------------------------------------------------------


        $object = (new Model())
        ->setName("Tiger 1200")
        ->setBrand($triumph);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Tiger 900")
        ->setBrand($triumph);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Tiger 850")
        ->setBrand($triumph);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Tiger 660")
        ->setBrand($triumph);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Street Triple")
        ->setBrand($triumph);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Rocket")
        ->setBrand($triumph);
        $manager->persist($object);


// --------------------------------------------------------

        $object = (new Model())
        ->setName("R1")
        ->setBrand($yamaha);
        $manager->persist($object);

        $object = (new Model())
        ->setName("R7")
        ->setBrand($yamaha);
        $manager->persist($object);

        $object = (new Model())
        ->setName("R6")
        ->setBrand($yamaha);
        $manager->persist($object);

        $object = (new Model())
        ->setName("R3")
        ->setBrand($yamaha);
        $manager->persist($object);

        $object = (new Model())
        ->setName("R125")
        ->setBrand($yamaha);
        $manager->persist($object);

        $object = (new Model())
        ->setName("MT 10")
        ->setBrand($yamaha);
        $manager->persist($object);

        $object = (new Model())
        ->setName("MT 09")
        ->setBrand($yamaha);
        $manager->persist($object);

        $object = (new Model())
        ->setName("MT 07")
        ->setBrand($yamaha);
        $manager->persist($object);

        $object = (new Model())
        ->setName("MT 03")
        ->setBrand($yamaha);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Tracer 900")
        ->setBrand($yamaha);
        $manager->persist($object);

        $object = (new Model())
        ->setName("Tracer 700")
        ->setBrand($yamaha);
        $manager->persist($object);

        
        

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            BrandFixtures::class
        ];
    }
}
