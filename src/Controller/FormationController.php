<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FormationController extends AbstractController
{
    /**
     * @Route("/formations", name="formation_index")
     * 
     * @param FormationRepository $repo
     * @return Response
     */
    public function index(FormationRepository $repo)
    {
        $formations = $repo->findAll();
        return $this->render('formation/index.html.twig', [
            'controller_name' => 'FormationController',
            'formations' => $formations
        ]);
    }

    /**
     * Affichage d'une formation
     * @Route("/formations/{slug}", name="formation_show")
     * @return Response
     */
    public function show(Formation $formation)
    {
        return $this->render('formation/show.html.twig', [
            'formation' => $formation,
            'theme' => $formation->getTheme(),
            'modules' => $formation->getModules()
        ]);
    }
}
