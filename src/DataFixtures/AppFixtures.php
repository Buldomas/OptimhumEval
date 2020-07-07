<?php

namespace App\DataFixtures;

use App\Entity\Formation;
use Faker\Factory;
use App\Entity\Theme;
use App\Entity\Module;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // pensez à lancer php bin/console doctrine:fixtures:load
        $faker = Factory::create('FR-fr');

        // création des USERS */
        $prenom = "Laurent";
        $nom = "Soubigou";
        $email = "laurent.soubigou@gmail.com";
        $user = new User;
        $user->setPrenom($prenom)
            ->setNom($nom)
            ->setEmail($email)
            ->setHash('password');
        $manager->persist($user);
        /* création de 10 users aléatoires */
        for ($i = 1; $i <= 10; $i++) {
            $user = new User;
            $user->setPrenom($faker->firstname)
                ->setNom($faker->lastname)
                ->setEmail($faker->email)
                ->setHash('password');
            $manager->persist($user);
        }
        /* CREATION DES MODULES */
        $modules = []; // tableau des modules pour faire les liens avec formation
        $titre = "Php";
        $description = '<p>' . join('</p><p>', $faker->paragraphs(2)) . '</p>';
        $module = new Module;
        $module->setTitre($titre)
            ->setStitre("Le PHP !")
            ->setDescription($description);
        $manager->persist($module);
        $modules[] = $module;

        $titre = "Javascript";
        $description = '<p>' . join('</p><p>', $faker->paragraphs(2)) . '</p>';
        $module = new Module;
        $module->setTitre($titre)
            ->setStitre("Le Javascript")
            ->setDescription($description);
        $manager->persist($module);
        $modules[] = $module;

        $titre = "CSS3";
        $description = '<p>' . join('</p><p>', $faker->paragraphs(2)) . '</p>';
        $module = new Module;
        $module->setTitre($titre)
            ->setStitre("La mise en forme avec CSS3")
            ->setDescription($description);
        $manager->persist($module);
        $modules[] = $module;

        /* création de 20 modules aléatoires */
        for ($i = 1; $i <= 20; $i++) {
            $description = '<p>' . join('</p><p>', $faker->paragraphs(2)) . '</p>';
            $module = new Module;
            $module->setTitre($faker->sentence())
                ->setStitre($faker->sentence())
                ->setDescription($description);
            $manager->persist($user);
            $modules[] = $module;
        }

        /* CREATION DES THEMES */
        $themes = []; // tableau vide pour mémoriser les thèmes créés pour les formations
        //Création du thème Web
        $titre = "Web";
        $description = '<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>';
        $theme = new Theme;
        $theme->setTitre($titre)
            ->setStitre("Tout sur le WEB")
            ->setDescription($description);
        $manager->persist($theme);
        $themes[] = $theme;
        //Création du thème Bureautique
        $titre = "Bureautique";
        $description = '<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>';
        $theme = new Theme;
        $theme->setTitre($titre)
            ->setStitre("La magie de Office !")
            ->setDescription($description);
        $manager->persist($theme);
        $themes[] = $theme;
        //Création du thème Formateurs
        $titre = "Formateurs et GRH";
        $description = '<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>';
        $theme = new Theme;
        $theme->setTitre($titre)
            ->setStitre("c'est pour faire comme nous !")
            ->setDescription($description);
        $manager->persist($theme);
        $themes[] = $theme;

        //Création du thème Multimédias
        $titre = "Multimédias";
        $description = '<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>';
        $theme = new Theme;
        $theme->setTitre($titre)
            ->setStitre("jouer avec les photos et les vidéos")
            ->setDescription($description);
        $manager->persist($theme);
        $themes[] = $theme;

        //Création du thème Comptabilité
        $titre = "Comptabilité";
        $description = '<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>';
        $theme = new Theme;
        $theme->setTitre($titre)
            ->setStitre("La fiscalité et les paies")
            ->setDescription($description);
        $manager->persist($theme);
        $themes[] = $theme;
        $manager->flush();


        /* Création des Formations */
        // ATTENTION, il faut persister formation ET module
        for ($i = 1; $i <= 20; $i++) {
            $titre = "Formation " . $faker->sentence();
            $description = '<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>';
            $theme = $themes[mt_rand(0, count($themes) - 1)];
            $formation = new Formation;
            $formation->setTitre($titre)
                ->setStitre("Devenir " . $titre)
                ->setDescription($description)
                ->setTheme($theme)
                ->addModule($module);
            $manager->persist($formation);
            $nbmodule = mt_rand(0, 3);
            for ($j = 1; $j <= $nbmodule; $j++) {
                $module = $modules[mt_rand(0, count($modules) - 1)];
                $formation->addModule($module);
                $module->addFormation($formation);
                $manager->persist($module);
                $manager->persist($formation);
            }
            $manager->persist($formation);
        }
        $manager->flush();
    }
}
