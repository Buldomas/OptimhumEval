<?php

namespace App\Controller;

use App\Repository\ThemeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Controleur de theme niveau Admin
 * 
 */
class AdminThemeController extends AbstractController
{
    /**
     * @Route("/admin/themes", name="admin_themes_index")
     * 
     * @return Response
     */
    public function index(ThemeRepository $repo)
    {
        return $this->render("admin/theme/index.html.twig", [
            'controller_name' => 'AdminThemeController',
            'themes' => $repo->findAll()
        ]);
    }
}
