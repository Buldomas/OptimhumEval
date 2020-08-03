<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\QFormation;
use App\Form\FormationType;

use App\Repository\FormationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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
        return $this->render("admin/formation/index.html.twig", [
            'controller_name' => 'AdminFormationController',
            'formations' => $repo->findAll()
        ]);
    }
    /**
     * Permet d'editer une formation
     * 
     * @Route("/admin/formation/{slug}/edit", name="admin_formation_edit")
     * @IsGranted("ROLE_ADMIN")
     * 
     * @param ThemeRepository $repo
     * @param Request $request
     * @param ManagerRegistry $managerRegistry
     * 
     * @return Response
     */
    public function edit(Formation $formation, Request $request, ManagerRegistry $managerRegistry)
    {
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            foreach ($formation->getQFormations() as $qFormation) {
                $qFormation->setFormation($formation);
                $manager->persist($qFormation);
            }
            $manager->persist($formation);
            $manager->flush();
            $this->addFlash('success', "Vos modifications ont bien été prises en compte !");
            return $this->redirectToRoute('admin_formations_index');
        }

        return $this->render('admin/formation/edit.html.twig', [
            'form' => $form->createView(),
            'formation' => $formation
        ]);
    }

    /**
     * Création d'une formation
     * @Route("/admin/formation/new", name="admin_formation_create")
     * @IsGranted("ROLE_ADMIN")
     * 
     * @param Request $request
     * @param ManagerRegistry $managerRegistry
     
     * @return Response
     */
    public function create(Request $request, ManagerRegistry $managerRegistry)
    {
        $formation = new Formation;

        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            // Gestion des rôles
            foreach ($formation->getQFormations() as $qformation) {
                // on précise que la question est rattachée au module $module
                $qformation->setFormation($formation);
                // Persist de la question
                $manager->persist($qformation);
            }

            $manager->persist($formation);
            $manager->flush();
            $this->addFlash('success', "Votre création a bien été enregistrée !");
            return $this->redirectToRoute('admin_formations_index');
        }
        return $this->render('admin/formation/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
