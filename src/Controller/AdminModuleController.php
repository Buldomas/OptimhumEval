<?php

namespace App\Controller;

use App\Entity\Module;
use App\Entity\QModule;
use App\Form\ModuleType;
use App\Repository\ModuleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
        return $this->render("admin/module/index.html.twig", [
            'controller_name' => 'AdminModuleController',
            'modules' => $repo->findAll()
        ]);
    }
    /**
     * Permet d'editer un module
     * 
     * @Route("/admin/module/{slug}/edit", name="admin_module_edit")
     * @IsGranted("ROLE_ADMIN")
     * 
     * @param ThemeRepository $repo
     * @param Request $request
     * @param ManagerRegistry $managerRegistry
     * 
     * @return Response
     */
    public function edit(Module $module, Request $request, ManagerRegistry $managerRegistry)
    {
        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            foreach ($module->getQModules() as $qmodule) {
                $qmodule->setModuleId($module);
                $manager->persist($qmodule);
            }
            $manager->persist($module);
            $manager->flush();
            $this->addFlash('success', "Vos modifications ont bien été prises en compte !");
            return $this->redirectToRoute('admin_modules_index');
        }

        return $this->render('admin/module/edit.html.twig', [
            'form' => $form->createView(),
            'module' => $module
        ]);
    }

    /**
     * Création d'un module
     * @Route("/admin/module/new", name="admin_module_create")
     * @IsGranted("ROLE_ADMIN")
     * 
     * @param Request $request
     * @param ManagerRegistry $managerRegistry
     
     * @return Response
     */
    public function create(Request $request, ManagerRegistry $managerRegistry)
    {
        $module = new Module;

        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();

            foreach ($module->getQModules() as $qmodule) {
                // on précise que la question est rattachée au module $module
                $qmodule->setModuleId($module);
                // Persist de la question
                $manager->persist($qmodule);
            }

            $manager->persist($module);
            $manager->flush();
            $this->addFlash('success', "Votre création a bien été enregistrée !");
            return $this->redirectToRoute('admin_modules_index');
        }
        return $this->render('admin/module/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
