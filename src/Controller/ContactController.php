<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Rental;
use App\Entity\Contact;
use App\Form\Contact1Type;
use App\Entity\ContactMessage;
use App\Form\ContactMessageType;
use App\Repository\RentalRepository;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/dashboard/contact')]
class ContactController extends AbstractController
{
    #[Route('/', name: 'app_contact_index', methods: ['GET'])]
    public function index(ContactRepository $contactRepository): Response
    {
        return $this->render('contact/index.html.twig', [
            'contacts' => $contactRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_contact_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contact();
        $form = $this->createForm(Contact1Type::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }
    
    #[Route('/newmessage', name: 'dashboard_contact_create', methods: ['POST','GET'])]
    public function newmessage( RentalRepository $rentalrepository,EntityManagerInterface $entityManager) :Response
    {
        $contact = new Contact();
        if (empty($_GET['rental']))
        {
            throw $this->createNotFoundException("Page Not Found Error 404");
        }
        $rental = $rentalrepository->find($_GET['rental']);
        if(empty($rental))
        {
            throw $this->createNotFoundException("Page Not Found Error 404");
        }
        /** @var User $user */
        $user = $this->getUser();
        $contact->setType(1);
        $contact->addUser($user);
        $contact->addUser($rental->getMotorcycle()->getUser());
        $entityManager->persist($contact);
        $entityManager->flush();

        return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
      
    }

    #[Route('/{id}', name: 'app_contact_show', methods: ['GET','POST'])]
    public function show(Contact $contact,Request $request, EntityManagerInterface $entityManager): Response
    {

        foreach($contact->getUsers() as $utilisateur){
            if($utilisateur->getId() == $this->getUser()->getId())
            {

            }
            else{
                $personne = $utilisateur;
            }
        }
        $contactMessage = new ContactMessage();
        $form = $this->createForm(ContactMessageType::class, $contactMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactMessage->setIdUser($this->getUser());
            $contactMessage->setContact($contact);
            $time = new \DateTime();
            
            $contactMessage->setDate(new DateTime($time->format('Y-m-d H:i:s')));
            $entityManager->persist($contactMessage);
            $entityManager->flush();

        }
        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
            'monid' => $this->getUser()->getId(),
            'personne' => $personne,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contact_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contact $contact, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Contact1Type::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    

    

    #[Route('/{id}', name: 'app_contact_delete', methods: ['POST'])]
    public function delete(Request $request, Contact $contact, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
    }
}
