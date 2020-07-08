<?php

namespace App\Controller;

use App\Form\AccountType;
use App\Entity\PasswordUpdate;
use App\Form\PasswordUpdateType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * Affiche et gère la connexion
     * @Route("/login", name="account_login")
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();
        return $this->render('account/login.html.twig', [
            'controller_name' => 'AccountController',
            'hasError' => $error != null,
            'username'  => $username
        ]);
    }

    /**
     * Permet de se déconnecter
     * @Route("/loggout", name="account_loggout")
     * 
     * @return void
     */
    public function logout()
    {
        // rien
    }

    /**
     * Permet d'afficher et de traiter le profile de l'utilisater User
     * 
     * @Route("/account/profile", name="account_profile")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function profile(Request $request, ManagerRegistry $managerRegistry)
    {
        $user = $this->getUser();
        $form = $this->createForm(AccountType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', "Vos modifications ont bien été prises en compte !");
            return $this->redirectToRoute('homepage');
        }

        return $this->render('account/profile.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de modifier le mot de passe.
     * 
     * @Route("/account/password-update", name="account_password")
     * Vérifie que l'utilisateur est connecté
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function updatePassword(Request $request, ManagerRegistry $managerRegistry, UserPasswordEncoderInterface $encoder)
    {
        $passwordUpdate = new PasswordUpdate();
        $user = $this->getUser();

        $form = $this->createform(PasswordUpdateType::class, $passwordUpdate);
        $form->handleRequest($request);

        /* Si soumis et valide */
        if ($form->isSubmitted() && $form->isValid()) {
            if (!password_verify($passwordUpdate->getOldPassword(), $user->getHash())) {
                // mauvais ancien mot de passe
                $form->get('oldPassword')->addError(new FormError("Le mot de passe saisi n'est pas le bon"));
            } else {
                // C'est bon et contrôle OK
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($user, $newPassword);
                $user->setHash($hash);
                $manager = $managerRegistry->getManager();
                $manager->persist($user);
                $manager->flush();
                /* success peut être changé mais ici il correspond aux couleurs du Bootstrap */
                $this->addFlash(
                    'success',
                    "Le changement de mot de passe a bien été enregistré !"
                );
                return $this->redirectToRoute('homepage');
            }
        }
        return $this->render('account/password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
