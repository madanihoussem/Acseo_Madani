<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(ContactRepository $contactRepository, PaginatorInterface $paginator, Request $request): Response
    {   
        return $this->render('admin/index.html.twig', [
            'contacts' => $paginator->paginate(
                $contactRepository->findBy([],['isTreated' => 'asc', 'createdAt' => 'desc']),
                $request->query->get('page', 1),
                4
            ),

        ]);
    }
}
