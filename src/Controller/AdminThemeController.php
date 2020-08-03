<?php

namespace App\Controller;

use App\Entity\Theme;
use App\Entity\QTheme;
use App\Form\ThemeType;
use App\Repository\ThemeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Controleur de theme niveau Admin
 * Affiche la liste de tout les themes
 */
class AdminThemeController extends AbstractController
{
    /**
     * @Route("/admin/themes", name="admin_themes_index")
     * 
     * @param ThemeRepository $repo
     
     * @return Response
     */
    public function index(ThemeRepository $repo)
    {
        return $this->render("admin/theme/index.html.twig", [
            'controller_name' => 'AdminThemeController',
            'themes' => $repo->findAll()
        ]);
    }


    /**
     * Permet d'editer un thème
     * 
     * @Route("/admin/theme/{slug}/edit", name="admin_theme_edit")
     * @IsGranted("ROLE_ADMIN")
     * 
     * @param ThemeRepository $repo
     * @param Request $request
     * @param ManagerRegistry $managerRegistry
     * 
     * @return Response
     */
    public function edit(Theme $theme, Request $request, ManagerRegistry $managerRegistry)
    {
        $form = $this->createForm(ThemeType::class, $theme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            foreach ($theme->getQuestions() as $qtheme) {
                $qtheme->setTheme($theme);
                $manager->persist($qtheme);
            }
            $manager->persist($theme);
            $manager->flush();
            $this->addFlash('success', "Vos modifications ont bien été prises en compte !");
            return $this->redirectToRoute('admin_themes_index');
        }

        return $this->render('admin/theme/edit.html.twig', [
            'form' => $form->createView(),
            'theme' => $theme
        ]);
    }
    /**
     * Création d'un thème
     * @Route("/admin/theme/new", name="admin_theme_create")
     * @IsGranted("ROLE_ADMIN")
     * 
     * @param Request $request
     * @param ManagerRegistry $managerRegistry
     
     * @return Response
     */
    public function create(Request $request, ManagerRegistry $managerRegistry)
    {
        $theme = new Theme;

        $form = $this->createForm(ThemeType::class, $theme);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();

            foreach ($theme->getQuestions() as $qtheme) {
                // on précise que la question est rattachée au thème $theme
                $qtheme->setTheme($theme);
                // Persist de la question
                $manager->persist($qtheme);
            }

            $manager->persist($theme);
            $manager->flush();
            $this->addFlash('success', "Votre création a bien été enregistrée !");
            return $this->redirectToRoute('admin_themes_index');
        }
        return $this->render('admin/theme/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
