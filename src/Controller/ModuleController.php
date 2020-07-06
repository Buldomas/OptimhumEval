<?php

namespace App\Controller;

use App\Entity\Module;
use App\Repository\ModuleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModuleController extends AbstractController
{
    /**
     * @Route("/modules", name="module_index")
     * 
     * @param ModuleRepository $modules
     * @return Response
     */
    public function index(ModuleRepository $repo)
    {
        $modules = $repo->findAll();
        return $this->render('module/index.html.twig', [
            'controller_name' => 'ModuleController',
            'modules' => $modules
        ]);
    }

    /**
     * Affichage d'un module
     * @Route("/modules/{slug}", name="module_show")
     * @return Response
     */
    public function show(Module $module)
    {
        //$module = $repo->findOneBySlug($slug);

        return $this->render('module/show.html.twig', [
            'module' => $module,
        ]);
    }
}
