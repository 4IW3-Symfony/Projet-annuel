<?php

namespace App\Controller\Dashboard;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProfileType;
use Symfony\Component\Form\FormError;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
    public function profile(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {

        $user = $this->security->getUser();
        // $userId = $user->getId();
        // dd($user);
        // $user = $entityManager->getRepository(User::class)->find($userId);
        $form = $this->createForm(ProfileType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get("plainPassword")->getData() != null) {
                if ($form->get("oldPassword")->getData() != null) {


                    // $hashedOldPassword = $userPasswordHasherInterface->hashPassword(
                    //     $user,
                    //     $form->get('oldPassword')->getData()
                    // );
                    //  $userPasswordHasherInterface->isV

                    if ($userPasswordHasherInterface->isPasswordValid($user, $form->get('oldPassword')->getData())) {
                        $user->setPassword(
                            $userPasswordHasherInterface->hashPassword(
                                $user,
                                $form->get('plainPassword')->getData()
                            )
                        );
                    } else {
                        $form->get('oldPassword')->addError(new FormError("wrong password"));
                        $this->addFlash('error', 'incorrect oldPassword ');
                        return $this->redirectToRoute('dashboard_profile', [], Response::HTTP_SEE_OTHER);
                    }
                } else {
                    $form->get('oldPassword')->addError(new FormError("can't be null"));
                    $this->addFlash('error', 'oldPassword field can\'t be null');
                    return $this->redirectToRoute('dashboard_profile', [], Response::HTTP_SEE_OTHER);
                }
            }
            /** @var \App\Entity\User $user */
            $entityManager->flush();
            $this->addFlash('success', 'Profile updated successfully');
            return $this->redirectToRoute('dashboard_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/profile/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
