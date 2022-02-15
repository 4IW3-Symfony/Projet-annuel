<?php

namespace App\Controller\Admin;

use App\Entity\LicenceType;
use App\Form\LicenceTypeType;
use App\Repository\LicenceTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/licence/type')]
class LicenceTypeController extends AbstractController
{
    #[Route('/', name: 'admin_licence_type_index', methods: ['GET'])]
    public function index(LicenceTypeRepository $licenceTypeRepository): Response
    {
        return $this->render('admin/licence_type/index.html.twig', [
            'licence_types' => $licenceTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_licence_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $licenceType = new LicenceType();
        $form = $this->createForm(LicenceTypeType::class, $licenceType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($licenceType);
            $entityManager->flush();

            return $this->redirectToRoute('admin_licence_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/licence_type/new.html.twig', [
            'licence_type' => $licenceType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_licence_type_show', methods: ['GET'])]
    public function show(LicenceType $licenceType): Response
    {
        return $this->render('admin/licence_type/show.html.twig', [
            'licence_type' => $licenceType,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_licence_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LicenceType $licenceType, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LicenceTypeType::class, $licenceType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_licence_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/licence_type/edit.html.twig', [
            'licence_type' => $licenceType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_licence_type_delete', methods: ['POST'])]
    public function delete(Request $request, LicenceType $licenceType, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$licenceType->getId(), $request->request->get('_token'))) {
            $entityManager->remove($licenceType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_licence_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
