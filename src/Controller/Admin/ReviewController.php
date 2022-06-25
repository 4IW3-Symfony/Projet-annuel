<?php

namespace App\Controller\Admin;

use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Security\Voter\ReviewVoter;

#[Route('/', requirements: ['back' => "admin|dashboard"])]
class ReviewController extends AbstractController
{
    #[Route('admin/review/', name: 'admin_review_index', methods: ['GET'])]
    public function admin_index(ReviewRepository $reviewRepository): Response
    {
        return $this->render('admin/review/index.html.twig', [
            'reviews' => $reviewRepository->findAll(),
        ]);
    }

    #[Route('dashboard/review/', name: 'dashboard_review_index', methods: ['GET'])]
    public function dashboard_index(ReviewRepository $reviewRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        return $this->render('dashboard/review/index.html.twig', [
            'reviews' => $reviewRepository->findBy(["customer" => $user->getId()]),
        ]);
    }

    #[Route('admin/review/new', name: 'admin_review_new', methods: ['GET', 'POST'], defaults: ['back' => "admin"])]
    #[Route('dashboard/review/new', name: 'dashboard_review_new', methods: ['GET', 'POST'], defaults: ['back' => "dashboard"])]
    public function new(Request $request, EntityManagerInterface $entityManager, $back): Response
    {
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \App\Entity\User $user */
            $user = $this->getUser();
            $review->setCustomer($user);
            $review->setDate(new \DateTime("now"));
            
            $entityManager->persist($review);
            $entityManager->flush();
            return $this->redirectToRoute("{$back}_review_index", [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm("{$back}/review/new.html.twig", [
            'review' => $review,
            'form' => $form,
        ]);
    }

    #[Route('admin/review/{id}', name: 'admin_review_show', methods: ['GET'], defaults: ['back' => "admin"])]
    #[Route('dashboard/review/{id}', name: 'dashboard_review_show', methods: ['GET'], defaults: ['back' => "dashboard"])]
    public function show(Review $review, $back): Response
    {
        return $this->render("{$back}/review/show.html.twig", [
            'review' => $review,
        ]);
    }

    #[Route('admin/review/{id}/edit', name: 'admin_review_edit', methods: ['GET', 'POST'], defaults: ['back' => "admin"])]
    #[Route('dashboard/review/{id}/edit', name: 'dashboard_review_edit', defaults: ['back' => "dashboard"], methods: ['GET', 'POST'])]
    //#[IsGranted(ReviewVoter::EDIT, subject: 'review')]
    public function edit(Request $request, Review $review, EntityManagerInterface $entityManager, $back): Response
    {
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute("{$back}_review_index", [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm("{$back}/review/edit.html.twig", [
            'review' => $review,
            'form' => $form,
        ]);
    }

    #[Route('admin/review/{id}', name: 'admin_review_delete', methods: ['POST'], defaults: ['back' => "admin"])]
    #[Route('dashboard/review/{id}', name: 'dashboard_review_delete', methods: ['POST'], defaults: ['back' => "dashboard"])]
    #[IsGranted(ReviewVoter::DELETE, subject: 'review')]
    public function delete(Request $request, Review $review, EntityManagerInterface $entityManager, $back): Response
    {
        if ($this->isCsrfTokenValid('delete' . $review->getId(), $request->request->get('_token'))) {
            $entityManager->remove($review);
            $entityManager->flush();
        }

        return $this->redirectToRoute("{$back}_review_index", [], Response::HTTP_SEE_OTHER);
    }
}
