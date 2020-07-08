<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Controleur de Users [accounts] niveau Admin
 * 
 */
class AdminAccountController extends AbstractController
{
    /**
     * @Route("/admin/accounts", name="admin_accounts_index")
     * 
     * @return Response
     */
    public function index(UserRepository $repo)
    {
        return $this->render('admin/account/index.html.twig', [
            'controller_name' => 'AdminAccountController',
            'users' => $repo->findAll()
        ]);
    }
}
