<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Theme;
use App\Entity\Module;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // pensez à lancer php bin/console doctrine:fixtures:load
        $faker = Factory::create('FR-fr');

        /* CREATION DES MODULES */
        $titre = "Php";
        $description = '<p>' . join('</p><p>', $faker->paragraphs(2)) . '</p>';
        $module = new Module;
        $module->setTitre($titre)
            ->setStitre("Le PHP !")
            ->setDescription($description);
        $manager->persist($module);

        $titre = "Javascript";
        $description = '<p>' . join('</p><p>', $faker->paragraphs(2)) . '</p>';
        $module = new Module;
        $module->setTitre($titre)
            ->setStitre("Le Javascript")
            ->setDescription($description);
        $manager->persist($module);

        $titre = "CSS3";
        $description = '<p>' . join('</p><p>', $faker->paragraphs(2)) . '</p>';
        $module = new Module;
        $module->setTitre($titre)
            ->setStitre("La mise en forme avec CSS3")
            ->setDescription($description);
        $manager->persist($module);


        /* CREATION DES THEMES */
        //Création du thème Web
        $titre = "Web";
        $description = '<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>';
        $theme = new Theme;
        $theme->setTitre($titre)
            ->setStitre("Tout sur le WEB")
            ->setDescription($description);
        $manager->persist($theme);
        //Création du thème Bureautique
        $titre = "Bureautique";
        $description = '<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>';
        $theme = new Theme;
        $theme->setTitre($titre)
            ->setStitre("La magie de Office !")
            ->setDescription($description);
        $manager->persist($theme);
        //Création du thème Formateurs
        $titre = "Formateurs et GRH";
        $description = '<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>';
        $theme = new Theme;
        $theme->setTitre($titre)
            ->setStitre("c'est pour faire comme nous !")
            ->setDescription($description);
        $manager->persist($theme);
        //Création du thème Multimédias
        $titre = "Multimédias";
        $description = '<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>';
        $theme = new Theme;
        $theme->setTitre($titre)
            ->setStitre("jouer avec les photos et les vidéos")
            ->setDescription($description);
        $manager->persist($theme);
        //Création du thème Comptabilité
        $titre = "Comptabilité";
        $description = '<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>';
        $theme = new Theme;
        $theme->setTitre($titre)
            ->setStitre("La fiscalité et les paies")
            ->setDescription($description);
        $manager->persist($theme);

        $manager->flush();
    }
}
