<?php

namespace App\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use Symfony\Component\Security\Core\Security;

class DefaultController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/', name: 'default')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route('dashboard/profile', name: 'dashboard_profile', methods: ['GET', 'POST'])]
    public function profile(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->security->getUser();
        $form = $this->createForm(UserType::class, $user, ['method' => 'PATCH']);
        // $form = $this->createForm(UserType::class, $user);
        // $form->handleRequest($request);
        //  $form->handleRequest($request,false);
        $form->submit($request->request->get($form->getName()), false);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('dashboard_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/profile/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
