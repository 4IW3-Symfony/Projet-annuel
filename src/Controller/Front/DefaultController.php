<?php

namespace App\Controller\Front;

use App\Entity\Motorcycle;
use App\Repository\MotorcycleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default')]
    public function index(MotorcycleRepository $motorcyleRepository): Response
    {
        $motorcycles = $motorcyleRepository->findBy(["status" => Motorcycle::STATUS_AVAILABLE]);
        return $this->render('front/index.html.twig', [
            'motorcycles' => $motorcycles,
            'controller_name' => 'DefaultController',
        ]);
    }
}
