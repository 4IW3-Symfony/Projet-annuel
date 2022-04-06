<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Motorcycle;
use App\Entity\Rental;

#[Route('/admin', name: 'admin_')]
class DefaultController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    #[Route('/', name: 'default')]
    public function index(): Response
    {
        $totalUsers = $this->getCount(User::class);
        $totalOwners = $this->getCountOwners();
        $totalMotorcycles = $this->getCount(Motorcycle::class);
        $totalRentals = $this->getCount(Rental::class);

        return $this->render('admin/index.html.twig', [
            'totalUsers' => $totalUsers,
            'totalOwners' => $totalOwners,
            'totalMotorcycles' => $totalMotorcycles,
            'totalRentals' => $totalRentals,
        ]);
    }

    public function getCount($class)
    {
        $items = $this->em->getRepository($class)->findAll();
        if ($items) return count($items);
        return 0;
    }
    public function getCountOwners()
    {
        $items = $this->em->getRepository(User::class)->findByRole("ROLE_OWNER");
        if ($items) return count($items);
        return 0;
    }
}
