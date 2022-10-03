<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contact")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/", name="app_contact")
     */
    public function index(Request $request, ContactRepository $contactRepository, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $oldContact = $contactRepository->findOneBy(['email'=>$contact->getEmail()]);
            if (!$oldContact) {
                $contactRepository->add($contact, true);
                $this->addFlash('success', 'Votre message a été bien envoyer');
                return $this->redirectToRoute('app_contact', [], Response::HTTP_SEE_OTHER);
            }
            $oldContact->setQuestion($contact->getQuestion()[0]);
            $entityManager->persist($oldContact);
            $entityManager->flush();
            $this->addFlash('success', 'Votre message a été bien envoyer');
            return $this->redirectToRoute('app_contact', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/istreated/{var}", name="app_validation")
     */
    public function isTreated(Contact $contact, $var, EntityManagerInterface $entityManager): Response
    { 
        if ($var == 'false') {
            $contact->setIsTreated(false);
        }
        if($var == 'true'){
            $contact->setIsTreated(true);

        }
        $entityManager->persist($contact);
        $entityManager->flush();
        return $this->json(['id'=>$contact->getId(), 'isTreated' => $var]);        

    }
}
