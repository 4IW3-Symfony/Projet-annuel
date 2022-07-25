<?php

namespace App\Controller\Front;

use DateTime;
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
            'isHome' => true,
            'motorcycles' => $motorcycles,
            'controller_name' => 'DefaultController',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/resultat-search', name: 'resultat_search', methods: ['GET'])]
    public function resultat_search(MotorcycleRepository $motorcyleRepository,Request $request): Response 
    {
        dump($_GET);
        $ville = null;
        $date_start = null;
        $date_end = null;
        if($_GET !=null){
            $ville = $_GET['motorcycle_search']['ville'];
            $date_start = $_GET['motorcycle_search']['Start'];
            $date_end = $_GET['motorcycle_search']['End'];
        }
        
        $min_price = $motorcyleRepository->findPriceMin();
        $max_price = $motorcyleRepository->findPriceMax();
        $min_year = $motorcyleRepository->findYearMin();
        $max_year = $motorcyleRepository->findYearMax();
        $min_power =$motorcyleRepository->findPowerMin();
        $max_power = $motorcyleRepository->findPowerMax();
        $form = $this->createForm(MotorcycleSearchType::class,null,[
            'ville' => $ville,
            'date_start' => date( "Y-m-d", strtotime( $date_start) ),
            'date_end' => date( "Y-m-d", strtotime( $date_end) ),
            'marque' => isset($_GET['motorcycle_search']['marque']) ?:null,
            'prix_min' => isset($_GET['motorcycle_search']['prix_min']) ?:null,
            'prix_max' => isset($_GET['motorcycle_search']['prix_max']) ?:null,
            'year_min' => isset($_GET['motorcycle_search']['year_min']) ?:null,
            'year_max' => isset($_GET['motorcycle_search']['year_max']) ?:null,
            'power_min' => isset($_GET['motorcycle_search']['power_min']) ?:null,
            'power_max' => isset($_GET['motorcycle_search']['power_max']) ?:null,
            'prix_minimun' => $min_price[0][1],
            'prix_maximun' => $max_price[0][1],
            'year_minimun' => $min_year[0][1],
            'year_maximun' => $max_year[0][1],
            'power_minimun' => $min_power[0][1],
            'power_maximun' => $max_power[0][1],

        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            foreach($_GET['motorcycle_search'] as $key => $value)
            {
                if($value == null )
                {
                    unset($_GET['motorcycle_search'][$key]);
                }
            }
            $motorcycles = $motorcyleRepository->searchMotorcycle($_GET['motorcycle_search']);
            dump($motorcycles);
            
        }

        $search = array();
        $autre = array();
        $supp = 0 ;
        if(!isset($motorcycles)){
            $motorcycles = $motorcyleRepository->findAll();
        }

        if (!empty($ville) && !empty($date_end) && !empty($date_start))
        {
            foreach ($motorcycles as $motorcycle) {
                foreach($motorcycle->getRentals() as $rental)
                {
                    if(($rental->getDateStart() <= new DateTime($date_end) && $rental->getDateStart() >= new DateTime($date_start) ) || ($rental->getDateEnd() <= new DateTime($date_end) && $rental->getDateEnd() >= new DateTime($date_start) ))
                    {
                        $supp = 1 ;
                    }


                }
            if ($motorcycle->getStatus() == 3)
            {
                $supp = 1 ;
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
        }
        else{
            $search = $motorcycles;
            dump($search);
        }
        



        return $this->render('front/search.html.twig', [
            'motorcycles' => $search,
            'autresmotos' => $autre,
            'form' => $form->createView(),
            'date_start' => $date_start,
            'date_end' => $date_end,
        ]);

    }
}
