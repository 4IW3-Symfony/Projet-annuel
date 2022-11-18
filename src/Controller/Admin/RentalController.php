<?php

namespace App\Controller\Admin;

use App\Entity\Rental;
use App\Form\NewmessageType;
use App\Form\RentalType;
use App\Form\TriStatusType;
use App\Verification\VerificationAccess;
use App\Form\Rental\RestitutionType;
use App\Repository\RentalRepository;
use App\Repository\MotorcycleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


#[Route('/', requirements: ['back' => "admin|dashboard"])]
class RentalController extends AbstractController
{
    #[Route('admin/rental/', name: 'admin_rental_index', methods: ['GET','POST'])]
    public function admin_index(RentalRepository $rentalRepository,Request $request): Response
    {
        if (empty($_GET['status'])){
            $status = 0;
        }
        else{
            $status = $_GET['status'];
        }
        // $form = $this->createFormBuilder()->add('status',ChoiceType::class,[
        //     'choices' => [
        //         'Tout' =>0,
        //         'Location Crée' => 1,
        //         'Location Validée par propriétaire' => 2,
        //         'Véhicule remis au locataire' => 3,
        //         'Véhicule restitué' =>4,
        //         'Location Clos' =>5,
        //         'Location SAV' => 6,
        //     ],
        // ])
        // ->getForm();

        $rental= $rentalRepository->findBy([], ["date_start" => "DESC"]);
        // $form->handleRequest($request);

       
            if ($status != 0){
                $rental = $rentalRepository->findBy(['status' => $status], ["date_start" => "DESC"]);
            }
            
        
      
        return $this->render('admin/rental/index.html.twig', [
            'rentals' => $rental,
            'status' => $status,
        ]);
    }

    #[Route('dashboard/rental/', name: 'dashboard_rental_index', methods: ['GET'])]
    public function dashboard_index(RentalRepository $rentalRepository, MotorcycleRepository $motorcycleRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $mesmotos = $motorcycleRepository->findBy(["user" => $user->getId()]);
        return $this->render('dashboard/rental/index.html.twig', [
            'mesmotos' => $mesmotos,
        ]);
    }

    #[Route('dashboard/reservation/', name: 'dashboard_reservation', methods: ['GET'])]
    public function dashboard_reservation(RentalRepository $rentalRepository): Response
    {

        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        return $this->render('dashboard/rental/reservation.html.twig', [
            'rentals' => $rentalRepository->findBy(["user" => $user->getId()],['createdAt' =>'DESC']),
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
        if($back == "dashboard")
        {
            /** @var User $user */
            $user = $this->getUser()->getId();
            if($rental->getUser()->getId() != $user && $rental->getMotorcycle()->getUser()->getId() != $user)
            {
                
                throw new AccessDeniedException("Vous n'avez pas l'accès !! ");
            }
        }
        return $this->render("{$back}/rental/show.html.twig", [
            'rental' => $rental,
        ]);
    }

    #[Route('admin/rental/{id}/edit', name: 'admin_rental_edit', methods: ['GET', 'POST'], defaults: ['back' => "admin"])]
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
            if ($back =="dashboard")
            {
                $rental->setStatus(7);
                $entityManager->flush();
                return $this->redirectToRoute("{$back}_rental_index", [], Response::HTTP_SEE_OTHER);
            }
            $entityManager->remove($rental);
            $entityManager->flush();
        }

        return $this->redirectToRoute("{$back}_rental_index", [], Response::HTTP_SEE_OTHER);
    }

    #[Route('dashboard/rental/validation-reservation/{id}', name: 'dashboard_valider_reservation', methods: ['GET'], defaults: ['back' => "dashboard"])]
    #[Route('admin/rental/validation-reservation/{id}', name: 'valider_reservation', methods: ['GET'], defaults: ['back' => "admin"])]
    public function validation_reservation(Request $request, Rental $rental, EntityManagerInterface $entityManager, $back,VerificationAccess $verification){

        if($back == "dashboard")
        {
            $verification->Verification_edit_moto($rental->getMotorcycle()->getUser()->getId(),$this->getUser());
            if($rental->getStatus() != 1){
                throw new AccessDeniedException("Vous n avez pas l accès !!!");
            }
        }
        $rental->setStatus(2);
        $entityManager->flush();
        return $this->redirectToRoute("{$back}_rental_index", [], Response::HTTP_SEE_OTHER);
    }

    #[Route('dashboard/rental/remis-client/{id}', name: 'dashboard_remis_client', methods: ['GET'], defaults: ['back' => "dashboard"])]
    #[Route('admin/rental/remis-client/{id}', name: 'remis_client', methods: ['GET'], defaults: ['back' => "admin"])]
    public function remis_client(Request $request, Rental $rental, EntityManagerInterface $entityManager, $back,VerificationAccess $verification){
        if($back == "dashboard")
        {
            $verification->Verification_edit_moto($rental->getMotorcycle()->getUser()->getId(),$this->getUser());
            if($rental->getStatus() != 2){
                throw new AccessDeniedException("Vous n avez pas l accès !!");
            }
            if($rental->getDateStart()->format('Y-m-d') != date('Y-m-d'))
            {
                $this->addFlash('error',"La date de location n'a pas comencé ! Veuillé contacter l'Administrateur en cas de probleme. ");
                return $this->redirectToRoute("{$back}_rental_index", [], Response::HTTP_SEE_OTHER);
            }
        }
        $rental->setStatus(3);
        $rental->getMotorcycle()->setStatus(2);
        $entityManager->flush();
        $this->addFlash('message',"Le véhicule a été remis au client.");
        return $this->redirectToRoute("{$back}_rental_index", [], Response::HTTP_SEE_OTHER);
    }

    #[Route('admin/rental/restitution/{id}', name: 'admin_restitution', methods: ['GET','POST'], defaults: ['back' => "admin"])]
    #[Route('dashboard/rental/restitution/{id}', name: 'dashboard_restitution', methods: ['GET','POST'], defaults: ['back' => "dashboard"])]
    public function restitution(Request $request, Rental $rental, EntityManagerInterface $entityManager, $back,VerificationAccess $verification): Response
    {
        if($back == "dashboard")
        {
            $verification->Verification_edit_moto($rental->getMotorcycle()->getUser()->getId(),$this->getUser());
            if($rental->getStatus() != 3){
                throw new AccessDeniedException("Vous n avez pas l accès !!!");
            }
        }
        $form = $this->createForm(RestitutionType::class, $rental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rental->setStatus(4);
            $rental->getMotorcycle()->setKm($form->get('km_end')->getData());
            $rental->setDateEnd(new \DateTime('now'));
            $entityManager->flush();

            $this->addFlash('message',"Le véhicule a été restituer, Veuillé vérifier la moto s'il n'y a pas de problème. Vous pouvez cloturer la location.");
            return $this->redirectToRoute("{$back}_rental_index", [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm("{$back}/rental/restitution.html.twig", [
            'rental' => $rental,
            'form' => $form,
            'back' => $back,
        ]);
    }

    #[Route('dashboard/rental/cloturation/{id}', name: 'dashboard_cloturation', methods: ['GET'], defaults: ['back' => "dashboard"])]
    #[Route('admin/rental/cloturation/{id}', name: 'cloturation', methods: ['GET'], defaults: ['back' => "admin"])]
    public function cloturation(Request $request, Rental $rental, EntityManagerInterface $entityManager, $back,VerificationAccess $verification){
        if($back == "dashboard")
        {
            $verification->Verification_edit_moto($rental->getMotorcycle()->getUser()->getId(),$this->getUser());
            if($rental->getStatus() != 4){
                throw new AccessDeniedException("Vous n avez pas l accès !!!");
            }
        }
        $rental->setStatus(5);
        $rental->getMotorcycle()->setStatus(1);
        $entityManager->flush();
        $this->addFlash('message',"Le dossier a été cloturé.");
        return $this->redirectToRoute("{$back}_rental_index", [], Response::HTTP_SEE_OTHER);
    }

    #[Route('dashboard/rental/sav/{id}', name: 'dashboard_sav', methods: ['GET'], defaults: ['back' => "dashoboard"])]
    #[Route('admin/rental/sav/{id}', name: 'sav', methods: ['GET'], defaults: ['back' => "admin"])]
    public function location_sav(Request $request, Rental $rental, EntityManagerInterface $entityManager, $back,VerificationAccess $verification){
        if($back == "dashboard")
        {
            $verification->Verification_edit_moto($rental->getMotorcycle()->getUser()->getId(),$this->getUser());
            if($rental->getStatus() != 5){
                throw new AccessDeniedException("Vous n avez pas l accès !!!");
            }
        }
        $rental->setStatus(6);
        $entityManager->flush();
        return $this->redirectToRoute("{$back}_rental_index", [], Response::HTTP_SEE_OTHER);
    }

    #[Route('dashboard/rental/annule/{id}', name: 'dashboard_annule', methods: ['GET'], defaults: ['back' => "dashoboard"])]
    #[Route('admin/rental/annule/{id}', name: 'admin_rental_annule', methods: ['GET'], defaults: ['back' => "admin"])]
    public function location_annule(Request $request, Rental $rental, EntityManagerInterface $entityManager, $back,VerificationAccess $verification){
        if($back == "dashboard")
        {
            $verification->Verification_edit_moto($rental->getMotorcycle()->getUser()->getId(),$this->getUser());
            if($rental->getStatus() != 1){
                throw new AccessDeniedException("Vous n avez pas l accès !!!");
            }
        }
        $this->addFlash('message',"La location a bien été annulé.");

        $rental->setStatus(7);
        $entityManager->flush();
        return $this->redirectToRoute("{$back}_rental_index", [], Response::HTTP_SEE_OTHER);
    }

    #[Route('demande-location-success', name: 'rental_success', methods: ['GET'])]
    public function rental_success()
    {
        return $this->renderForm("front/rental/demande-success.html.twig");
    }

    
}
