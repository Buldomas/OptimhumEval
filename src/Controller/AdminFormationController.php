<?php

namespace App\Controller;

use App\Repository\FormationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Controleur de formation niveau Admin
 * 
 */
class AdminFormationController extends AbstractController
{
    /**
     * @Route("/admin/formations", name="admin_formations_index")
     * 
     * @return Response
     */
    public function index(FormationRepository $repo)
    {
        return $this->render('admin/formation/index.html.twig', [
            'controller_name' => 'AdminFormationController',
            'formations' => $repo->findAll()
        ]);
    }
}
