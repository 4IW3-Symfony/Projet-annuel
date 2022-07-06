<?php

namespace App\Controller\Admin;

use App\Entity\Rental;
use App\Entity\Motorcycle;
use App\Form\MotorcycleType;
use App\Form\RetalReservationType;
use App\Security\Voter\MotorcycleVoter;
use App\Repository\MotorcycleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/', requirements: ['back' => "admin|dashboard"])]
class MotorcycleController extends AbstractController
{
    // public function __construct($back)
    // {

    // }

    #[Route('admin/motorcycle/', name: 'admin_motorcycle_index', methods: ['GET'])]
    public function admin_index(MotorcycleRepository $motorcycleRepository): Response
    {
        return $this->render('admin/motorcycle/index.html.twig', [
            'motorcycles' => $motorcycleRepository->findAll(),
        ]);
    }

    #[Route('dashboard/motorcycle/', name: 'dashboard_motorcycle_index', methods: ['GET'])]
    public function dashboard_index(MotorcycleRepository $motorcycleRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        return $this->render('dashboard/motorcycle/index.html.twig', [
            'motorcycles' => $motorcycleRepository->findBy(["user" => $user->getId()]),
        ]);
    }


    #[Route('admin/motorcycle/new', name: 'admin_motorcycle_new', methods: ['GET', 'POST'], defaults: ['back' => "admin"])]
    #[Route('dashboard/motorcycle/new', name: 'dashboard_motorcycle_new', methods: ['GET', 'POST'], defaults: ['back' => "dashboard"])]
    public function new(Request $request, EntityManagerInterface $entityManager, $back): Response
    {
        $motorcycle = new Motorcycle();
        $form = $this->createForm(MotorcycleType::class, $motorcycle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Image upload
            $motorcycleImages = $motorcycle->getMotorcycleImages();
            foreach ($motorcycleImages as $key => $motorcycleImage) {
                // dd($motorcycleImages);
                if ($motorcycleImage->getImageFile() !== null || $motorcycleImage->getId() !== null) {
                    $motorcycleImage->setMotorcycle($motorcycle);
                    $motorcycleImages->set($key, $motorcycleImage);
                } else {
                    //to avoid null element to database
                    $motorcycle->removeMotorcycleImage($motorcycleImage);
                }
            }
            /** @var \App\Entity\User $user */
            $user = $this->getUser();
            $motorcycle->setStatus(0);
            $motorcycle->setUser($user);
            $entityManager->persist($motorcycle);
            $entityManager->flush();
            return $this->redirectToRoute("{$back}_motorcycle_index", [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm("{$back}/motorcycle/new.html.twig", [
            'motorcycle' => $motorcycle,
            'form' => $form,
        ]);
    }
    #[Route('motorcycle/{id}', name: 'motorcycle_show', methods: ['GET'], defaults: ['back' => "front"])]
    #[Route('admin/motorcycle/{id}', name: 'admin_motorcycle_show', methods: ['GET'], defaults: ['back' => "admin"])]
    #[Route('dashboard/motorcycle/{id}', name: 'dashboard_motorcycle_show', methods: ['GET'], defaults: ['back' => "dashboard"])]
    public function show(Motorcycle $motorcycle, $back): Response
    {
        return $this->render("{$back}/motorcycle/show.html.twig", [
            'motorcycle' => $motorcycle,
        ]);
    }

    #[Route('admin/motorcycle/{id}/edit', name: 'admin_motorcycle_edit', methods: ['GET', 'POST'], defaults: ['back' => "admin"])]
    #[Route('dashboard/motorcycle/{id}/edit', name: 'dashboard_motorcycle_edit', methods: ['GET', 'POST'], defaults: ['back' => "dashboard"])]
    #[IsGranted(MotorcycleVoter::EDIT, subject: 'motorcycle')]
    public function edit(Request $request, Motorcycle $motorcycle, EntityManagerInterface $entityManager, $back): Response
    {
        $form = $this->createForm(MotorcycleType::class, $motorcycle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Image upload
            $motorcycleImages = $motorcycle->getMotorcycleImages();
            foreach ($motorcycleImages as $key => $motorcycleImage) {
                // dd($motorcycleImages);
                if ($motorcycleImage->getImageFile() !== null || $motorcycleImage->getId() !== null) {
                    $motorcycleImage->setMotorcycle($motorcycle);
                    $motorcycleImages->set($key, $motorcycleImage);
                } else {
                    //to avoid null element to database
                    $motorcycle->removeMotorcycleImage($motorcycleImage);
                }
            }
            $entityManager->flush();

            return $this->redirectToRoute("{$back}_motorcycle_index", [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm("{$back}/motorcycle/edit.html.twig", [
            'motorcycle' => $motorcycle,
            'form' => $form,
        ]);
    }

    #[Route('admin/motorcycle/{id}', name: 'admin_motorcycle_delete', methods: ['POST'], defaults: ['back' => "admin"])]
    #[Route('dashboard/motorcycle/{id}', name: 'dashboard_motorcycle_delete', methods: ['POST'], defaults: ['back' => "dashboard"])]
    #[IsGranted(MotorcycleVoter::DELETE, subject: 'motorcycle')]
    public function delete(Request $request, Motorcycle $motorcycle, EntityManagerInterface $entityManager, $back): Response
    {
        if ($this->isCsrfTokenValid('delete' . $motorcycle->getId(), $request->request->get('_token'))) {
            $entityManager->remove($motorcycle);
            $entityManager->flush();
        }

        return $this->redirectToRoute("{$back}_motorcycle_index", [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/dashboard/demande/motorcycle/{id}', name: 'dashboard_demande_location', methods: ['POST','GET'], defaults: ['back' => "dashboard"])]   
    #[Route('demande/motorcycle/{id}', name: 'demande_location', methods: ['POST','GET'], defaults: ['back' => "front"])]
    public function demande_location(Motorcycle $motorcycle,Request $request,EntityManagerInterface $entityManager,$back): Response
    {
        
            $rental = new Rental();
            $form = $this->createForm(RetalReservationType::class, $rental);
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()){
                $rental->setUser(UserInterface::class);
                $rental->setMotorcycle($motorcycle);
                $rental->setStatus(1);
                $rental->setKmStart($motorcycle->getKm());
                $entityManager->persist($rental);
                $entityManager->flush();
                
                $this->addFlash('Success','La demande de location à été crée , vous recevra un mail de confirmation .');
            }
        
        return $this->render("{$back}/motorcycle/demande_location.twig", [
            'form' => $form->createView(),

        ]);
    }

    #[Route('/admin/validation_moto', name: 'validation_index', methods: ['POST','GET'], defaults: ['back' => "back"])]
    public function validation_moto_index(MotorcycleRepository $motorcycleRepository): Response
    {
        return $this->render('admin/motorcycle/validation.html.twig', [
            'motorcycles' => $motorcycleRepository->findBy(['status' => 0]),
        ]);

    }

    #[Route('/admin/validation_moto/{id}', name: 'validation_moto', methods: ['POST','GET'], defaults: ['back' => "back"])]
    public function validation_moto(Request $request, Motorcycle $moto, EntityManagerInterface $entityManager, $back): Response
    {
        $moto->setStatus(1);
        $entityManager->flush();
        return $this->redirectToRoute("validation_index", [], Response::HTTP_SEE_OTHER);

    }
}
