<?php

namespace App\Controller\Admin;

use App\Entity\Motorcycle;
use App\Form\MotorcycleType;
use App\Repository\MotorcycleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/motorcycle')]
class MotorcycleController extends AbstractController
{
    #[Route('/', name: 'motorcycle_index', methods: ['GET'])]
    public function index(MotorcycleRepository $motorcycleRepository): Response
    {
        return $this->render('admin/motorcycle/index.html.twig', [
            'motorcycles' => $motorcycleRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'motorcycle_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $motorcycle = new Motorcycle();
        $form = $this->createForm(MotorcycleType::class, $motorcycle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($motorcycle);
            $entityManager->flush();

            return $this->redirectToRoute('motorcycle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/motorcycle/new.html.twig', [
            'motorcycle' => $motorcycle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'motorcycle_show', methods: ['GET'])]
    public function show(Motorcycle $motorcycle): Response
    {
        return $this->render('admin/motorcycle/show.html.twig', [
            'motorcycle' => $motorcycle,
        ]);
    }

    #[Route('/{id}/edit', name: 'motorcycle_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Motorcycle $motorcycle, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MotorcycleType::class, $motorcycle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('motorcycle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/motorcycle/edit.html.twig', [
            'motorcycle' => $motorcycle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'motorcycle_delete', methods: ['POST'])]
    public function delete(Request $request, Motorcycle $motorcycle, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $motorcycle->getId(), $request->request->get('_token'))) {
            $entityManager->remove($motorcycle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('motorcycle_index', [], Response::HTTP_SEE_OTHER);
    }
}
