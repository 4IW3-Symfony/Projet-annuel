<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\Rental;
use App\Entity\Motorcycle;
use App\Form\MotorcycleType;
use App\Form\RetalReservationType;
use App\Repository\BrandRepository;
use App\Repository\ModelRepository;
use App\Form\ReservationMotorcycleType;
use App\Security\Voter\MotorcycleVoter;
use Doctrine\Persistence\ObjectManager;
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
    public function new(ModelRepository $model,BrandRepository $brandrepository ,Request $request, EntityManagerInterface $entityManager, $back): Response
    {
    
        

        if (isset($_GET['marque'])){
            $motorcycle = new Motorcycle();
            $modele_moto = $brandrepository->findOneBy(['name' => $_GET['marque']]);
            $form = $this->createForm(MotorcycleType::class, $motorcycle,['group' => $modele_moto]);
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
        }
        else{
            $motorcycle = "";
            $form ="";

        }

            return $this->renderForm("{$back}/motorcycle/new.html.twig", [
                'motorcycle' => $motorcycle,
                'form' => $form,
                'brands' => $brandrepository->findAll(),
                'back' => $back,
            ]);
        
        
        
    }
    #[Route('motorcycle/{id}', name: 'motorcycle_show', methods: ['GET','POST'], defaults: ['back' => "front"])]
    #[Route('admin/motorcycle/{id}', name: 'admin_motorcycle_show', methods: ['GET','POST'], defaults: ['back' => "admin"])]
    #[Route('dashboard/motorcycle/{id}', name: 'dashboard_motorcycle_show', methods: ['GET','POST'], defaults: ['back' => "dashboard"])]
    public function show(Motorcycle $motorcycle, $back, Request $request): Response
    {
        if( isset($_GET['date_end']) && isset($_GET['date_start']) )
        {
            $date_end = $_GET["date_end"];
            $date_start = $_GET["date_start"];
        }
        else{
            $date_end = null ;
            $date_start = null;
            
        }
        $form = $this->createForm(ReservationMotorcycleType::class, null);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            return $this->redirectToRoute('motorcycle_show',['id' => $motorcycle->getId(),'date_end' => $form->get('date_end')->getData()->format('Y-m-d'), 'date_start' => $form->get('date_start')->getData()->format('Y-m-d') ]);
        }
        
        return $this->render("{$back}/motorcycle/show.html.twig", [
            'motorcycle' => $motorcycle,
            'date_end' => $date_end,
            'date_start' => $date_start,
            'form' => $form->createView(),
        ]);
    }

    #[Route('admin/motorcycle/{id}/edit', name: 'admin_motorcycle_edit', methods: ['GET', 'POST'], defaults: ['back' => "admin"])]
    #[Route('dashboard/motorcycle/{id}/edit', name: 'dashboard_motorcycle_edit', methods: ['GET', 'POST'], defaults: ['back' => "dashboard"])]
    #[IsGranted(MotorcycleVoter::EDIT, subject: 'motorcycle')]
    public function edit(Request $request, Motorcycle $motorcycle, EntityManagerInterface $entityManager, $back): Response
    {

        $form = $this->createForm(MotorcycleType::class, $motorcycle,['group'=> $motorcycle->getModel()->getBrand()]);
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
            $date_start = $_GET['date_start'];
            $date_end = $_GET['date_end'];
            /** @var \App\Entity\User $user */
            if( $this->getUser() == null){
                return $this->redirectToRoute("app_login");
            }

            if(new DateTime($date_end) <= new DateTime($date_start)){
                $this->addFlash('error', 'Votre demande de location a été refusé, veuillez contacter le support Easyloc pour plus d information');

                return $this->redirectToRoute("motorcycle_show", ['id' => $motorcycle->getId()], Response::HTTP_SEE_OTHER);

            }

            foreach($motorcycle->getRentals() as $location)
            {   
                
                if($motorcycle->getStatus() == 1)
                {
    
                    if(($location->getDateStart() <= new DateTime($date_end) && $location->getDateStart() >= new DateTime($date_start) ) || ($location->getDateEnd() <= new DateTime($date_end) && $location->getDateEnd() >= new DateTime($date_start) ))
                    {
                        $this->addFlash('error', 'Votre demande de location a été refusé, veuillez contacter le support Easyloc pour plus d information');

                        return $this->redirectToRoute("motorcycle_show", ['id' => $motorcycle->getId()], Response::HTTP_SEE_OTHER);

                    }
                }
                else
                {
                    $this->addFlash('error', 'Votre demande de location a été refusé, veuillez contacter le support Easyloc pour plus d information');

                    return $this->redirectToRoute("motorcycle_show", ['id' => $motorcycle->getId()], Response::HTTP_SEE_OTHER);

                }


            }

                $rental->setDateStart(new DateTime($date_start));
                $rental->setDateEnd(new DateTime($date_end));

                /** @var \App\Entity\User $user */
                $rental->setUser($this->getUser());
                $diff = (array) date_diff(new DateTime($date_start),new DateTime($date_end));
                $date = $diff['days'];
                $rental->setPrice(($date * $motorcycle->getPrice()));
                $rental->setStatus(1);
                $rental->setMotorcycle($motorcycle);
                $rental->setKmStart($motorcycle->getKm());
                $entityManager->persist($rental);
                $entityManager->flush();
                $this->addFlash('Success','La demande de location a été crée , vous recevra un mail de confirmation .');
                return $this->redirectToRoute("rental_success");
               
        
    
        
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

    // public function validation_date(Motorcycle $motorcycle,$date_start,$date_end): Booleen
    // {
    //     foreach($motorcycle->getRentals() as $rental)
    //         {
    //             if($motorcycle->getStatus() == 1)
    //             {
    //                 if(($rental->getDateStart() < $date_end && $rental->getDateStart()> $date_start())  || ($rental->getDateEnd() < $date_end && $rental->getDateEnd()> $date_start() ))
    //                 {
    //                     return false;
    //                 }
    //             }
    //             else
    //             {
    //                 return false;
    //             }


    //         }
    //     return true; 

    // }
}
