<?php

namespace App\Controller\Admin;

use App\Entity\Rental;
use App\Form\RentalType;
use App\Repository\RentalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', requirements: ['back' => "admin|dashboard"])]
class RentalController extends AbstractController
{
    #[Route('admin/rental/', name: 'admin_rental_index', methods: ['GET'])]
    public function admin_index(RentalRepository $rentalRepository): Response
    {
        return $this->render('admin/rental/index.html.twig', [
            'rentals' => $rentalRepository->findAll(),
        ]);
    }

    #[Route('dashboard/rental/', name: 'dashboard_rental_index', methods: ['GET'])]
    public function dashboard_index(RentalRepository $rentalRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        return $this->render('dashboard/rental/index.html.twig', [
            'rentals' => $rentalRepository->findBy(["user" => $user->getId()]),
        ]);
    }

    #[Route('admin/rental/new', name: 'admin_rental_new', methods: ['GET', 'POST'], defaults: ['back' => "admin"])]
    #[Route('dashboard/rental/new', name: 'dashboard_rental_new', methods: ['GET', 'POST'], defaults: ['back' => "dashboard"])]
    public function new(Request $request, EntityManagerInterface $entityManager, $back): Response
    {
        $rental = new Rental();
        $form = $this->createForm(RentalType::class, $rental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \App\Entity\User $user */
            $user = $this->getUser();
            $rental->setUser($user);
            $entityManager->persist($rental);
            $entityManager->flush();
            return $this->redirectToRoute("{$back}_rental_index", [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm("{$back}/rental/new.html.twig", [
            'rental' => $rental,
            'form' => $form,
        ]);
    }

    #[Route('admin/rental/{id}', name: 'admin_rental_show', methods: ['GET'], defaults: ['back' => "admin"])]
    #[Route('dashboard/rental/{id}', name: 'dashboard_rental_show', methods: ['GET'], defaults: ['back' => "dashboard"])]
    public function show(Rental $rental, $back): Response
    {
        return $this->render("{$back}/rental/show.html.twig", [
            'rental' => $rental,
        ]);
    }

    #[Route('admin/rental/{id}/edit', name: 'admin_rental_edit', methods: ['GET', 'POST'], defaults: ['back' => "admin"])]
    #[Route('dashboard/rental/{id}/edit', name: 'dashboard_rental_edit', methods: ['GET', 'POST'], defaults: ['back' => "dashboard"])]
    public function edit(Request $request, Rental $rental, EntityManagerInterface $entityManager, $back): Response
    {
        $form = $this->createForm(RentalType::class, $rental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute("{$back}_rental_index", [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm("{$back}/rental/edit.html.twig", [
            'rental' => $rental,
            'form' => $form,
        ]);
    }

    #[Route('admin/rental/{id}', name: 'admin_rental_delete', methods: ['POST'], defaults: ['back' => "admin"])]
    #[Route('dashboard/rental/{id}', name: 'dashboard_rental_delete', methods: ['POST'], defaults: ['back' => "dashboard"])]
    public function delete(Request $request, Rental $rental, EntityManagerInterface $entityManager, $back): Response
    {
        if ($this->isCsrfTokenValid('delete' . $rental->getId(), $request->request->get('_token'))) {
            $entityManager->remove($rental);
            $entityManager->flush();
        }

        return $this->redirectToRoute("{$back}_rental_index", [], Response::HTTP_SEE_OTHER);
    }
}
