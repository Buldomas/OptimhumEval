<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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

    /**
     * Permet d'editer un utilisateur
     * 
     * @Route("/admin/account/{slug}/edit", name="admin_account_edit")
     * @IsGranted("ROLE_ADMIN")
     * 
     * @param ThemeRepository $repo
     * @param Request $request
     * @param ManagerRegistry $managerRegistry
     * 
     * @return Response
     */
    public function edit(User $user, Request $request, ManagerRegistry $managerRegistry)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            // Gestion des rôles
            // récupération des rôles définis dans la saisie
            $roles = $form['userRoles']->getData();
            // Si ajout d'un rôle
            foreach ($roles as $role) {
                $role->addUser($user);
                $manager->persist($role);
            }
            // Contrôle si suppression
            $listRole = $manager->getRepository(Role::class)->findAll();
            foreach ($listRole as $role) {
                if (!$roles->contains($role) & $role->getTitre() != "ROLE_USER") {
                    $role->RemoveUser($user);
                }
            }
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', "Vos modifications ont bien été prises en compte !");
            return $this->redirectToRoute('admin_accounts_index');
        }

        return $this->render('admin/account/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
    /**
     * Création d'un utilisateur
     * @Route("/admin/account/new", name="admin_account_create")
     * @IsGranted("ROLE_ADMIN")
     * 
     * @param Request $request
     * @param ManagerRegistry $managerRegistry
     
     * @return Response
     */
    public function create(Request $request, ManagerRegistry $managerRegistry, UserPasswordEncoderInterface $encoder, SluggerInterface $slugger)
    {
        $user = new User;
        $hash = $encoder->encodePassword($user, 'password');
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            // Gestion des rôles
            $roles = $form['userRoles']->getData();
            foreach ($roles as $role) {
                $role->addUser($user);
                // Persist du role
                $manager->persist($role);
            }
            $listRole = $manager->getRepository(Role::class)->findAll();
            foreach ($listRole as $role) {
                // Ajout du role user
                if ($role->getTitre() == "ROLE_USER") {
                    $role->addUser($user);
                    $manager->persist($role);
                }
            }

            // Gestion picture
            /*$directory = "./Images/";
            $file = $form['picture']->getData();
            $manager->persist($user);
            $manager->flush();
            if ($file) {
                $originalfilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safefilename = $slugger->slug($originalfilename);
                $newNamefile = $safefilename . "-" . $user->getId() . "." . $file->guessExtension();

                $file->move($directory, $newNamefile);
                $user->setPicture($directory . $newNamefile);
            } else {
                $user->setPicture("");
            }
            */
            $user->setHash($hash);
            $manager->persist($user);
            $manager->flush();


            $this->addFlash('success', "L'utilisateur a bien été enregistré !");
            return $this->redirectToRoute('admin_accounts_index');
        }
        return $this->render('admin/account/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
