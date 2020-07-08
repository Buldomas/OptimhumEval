<?php

namespace App\Controller;

use App\Repository\ModuleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Controleur de module niveau Admin
 * 
 */
class AdminModuleController extends AbstractController
{
    /**
     * @Route("/admin/modules", name="admin_modules_index")
     * 
     * @return Response
     */
    public function index(ModuleRepository $repo)
    {
        return $this->render('admin/module/index.html.twig', [
            'controller_name' => 'AdminModuleController',
            'modules' => $repo->findAll()
        ]);
    }
}
