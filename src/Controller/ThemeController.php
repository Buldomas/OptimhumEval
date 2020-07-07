<?php

namespace App\Controller;

use App\Entity\Theme;
use App\Repository\ThemeRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ThemeController extends AbstractController
{
    /**
     * @Route("/themes", name="theme_index")
     * 
     * @param ThemeRepository $repo
     * @return Response
     */
    public function index(ThemeRepository $repo)
    {
        $themes = $repo->findAll();
        return $this->render('theme/index.html.twig', [
            'controller_name' => 'ThemeController',
            'themes' => $themes
        ]);
    }

    /**
     * Affichage d'un theme
     * @Route("/themes/{slug}", name="theme_show")
     * @return Response
     */
    public function show(Theme $theme)
    {
        return $this->render('theme/show.html.twig', [
            'theme' => $theme,
            'formations' => $theme->getThemeFormations()
        ]);
    }
}
