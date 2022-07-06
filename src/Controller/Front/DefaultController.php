<?php

namespace App\Controller\Front;

use App\Entity\Motorcycle;
use App\Repository\MotorcycleRepository;
use App\Form\Motorcycle\MotorcycleSearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default')]
    public function index(MotorcycleRepository $motorcyleRepository,Request $request): Response
    {
        $form = $this->createForm(MotorcycleSearchType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            

            $date = $form->get('Start')->getData();
            var_dump($date->format('Y-m-d'));
            return $this->redirectToRoute('resultat_search', ['ville'=> $form->get('ville')->getData(),'date_start'=> $form->get('Start')->getData()->format('Y-m-d'),'date_end'=> $form->get('End')->getData()->format('Y-m-d')]);
        }
        $motorcycles = $motorcyleRepository->findBy(["status" => Motorcycle::STATUS_AVAILABLE]);
        return $this->render('front/index.html.twig', [
            'motorcycles' => $motorcycles,
            'controller_name' => 'DefaultController',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/resultat-search', name: 'resultat_search', methods: ['GET','POST'])]
    public function resultat_search(MotorcycleRepository $motorcyleRepository,Request $request): Response 
    {
        $ville = $_GET['ville'];
        $date_start = $_GET['date_start'];
        $date_end = $_GET['date_end'];
        $form = $this->createForm(MotorcycleSearchType::class,null,[
            'ville' => $ville,
            'date_start' => date( "Y-m-d", strtotime( $date_start) ),
            'date_end' => date( "Y-m-d", strtotime( $date_end) ),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            

            $date = $form->get('Start')->getData();
            return $this->redirectToRoute('resultat_search', ['ville'=> $form->get('ville')->getData(),'date_start'=> $form->get('Start')->getData()->format('Y-m-d'),'date_end'=> $form->get('End')->getData()->format('Y-m-d')]);
        }
        $search = array();
        $autre = array();
        $supp = 0 ;
        $motorcycles = $motorcyleRepository->findAll();
        foreach ($motorcycles as $motorcycle) {
            foreach($motorcycle->getRentals() as $rental)
            {
                if(($rental->getDateStart() < $date_end && $rental->getDateStart()> $date_start())  || ($rental->getDateEnd() < $date_end && $rental->getDateEnd()> $date_start() ))
                {
                    $supp = 1 ;
                }


            }
            if ($supp == 0) {
                if(strtolower($motorcycle->getCity()) == strtolower($ville))
                {
                    array_push($search,$motorcycle);
                }
                else
                {
                    array_push($autre,$motorcycle);
                }
                
            }
            else{
                $supp = 0;
            }

        }



        return $this->render('front/search.html.twig', [
            'motorcycles' => $search,
            'autresmotos' => $autre,
            'form' => $form->createView(),
        ]);

    }
    #[Route('/map', name: 'map')]
    public function map(MotorcycleRepository $motorcyleRepository): Response
    {
        
        $motorcycles = $motorcyleRepository->findBy(["status" => Motorcycle::STATUS_AVAILABLE]);
        return $this->render('front/map.html.twig', [
            'motorcycles' => $motorcycles,
            'controller_name' => 'DefaultController',
        ]);
    }
}
