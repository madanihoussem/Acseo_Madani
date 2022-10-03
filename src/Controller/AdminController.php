<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(ContactRepository $contactRepository): Response
    {   

        return $this->render('admin/index.html.twig', [
            'contacts' => $contactRepository->findBy([],['isTreated' => 'desc']),
        ]);
    }

    
}
