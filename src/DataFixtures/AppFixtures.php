<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Level;
use App\Entity\Theme;
use App\Entity\Module;
use App\Entity\Formation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // pensez à lancer php bin/console doctrine:fixtures:load
        $faker = Factory::create('FR-fr');

        // création des roles
        $adminRole = new Role();
        $adminRole->setTitre('ROLE_ADMIN');
        $manager->persist($adminRole);

        $formateurRole = new Role();
        $formateurRole->setTitre('ROLE_USER');
        $manager->persist($formateurRole);

        // Création des levels
        $level0 = new Level;
        $level0->setTitre("Administrateur")
            ->setNiveau(1);
        $manager->persist($level0);
        $level1 = new Level;
        $level1->setTitre("Formateur")
            ->setNiveau(2);
        $manager->persist($level1);
        $level = new Level;
        $level->setTitre("Administratif")
            ->setNiveau(4);
        $manager->persist($level);
        $level = new Level;
        $level->setTitre("Stagiaire")
            ->setNiveau(10);
        $manager->persist($level);

        // création des USERS */

        // création de l'administrateur (Laurent Soubigou)
        $adminUser = new User;
        $adminUser->setPrenom("Laurent")
            ->setNom("Soubigou")
            ->setEmail("laurent.soubigou@gmail.com")
            ->setHash($this->encoder->encodePassword($adminUser, 'password'))
            ->setNiv($level0)
            ->addUserRole($adminRole)
            ->addUserRole($formateurRole);
        $manager->persist($adminUser);

        // création de l'administrateur (Nicolas Galas)
        $adminUser = new User;
        $adminUser->setPrenom("Nicolas")
            ->setNom("Galas")
            ->setEmail("nicolas.galas@free.fr")
            ->setHash($this->encoder->encodePassword($adminUser, 'password'))
            ->setNiv($level0)
            ->addUserRole($adminRole)
            ->addUserRole($formateurRole);
        $manager->persist($adminUser);

        // création d'un formateur (Guillaume Ferrari)
        $formateurUser = new User;
        $formateurUser->setPrenom("Guillaume")
            ->setNom("Ferrari")
            ->setEmail("guillaume.ferrari@gmail.com")
            ->setHash($this->encoder->encodePassword($formateurUser, 'password'))
            ->setNiv($level1)
            ->addUserRole($formateurRole);
        $manager->persist($formateurUser);

        /* création de 10 users aléatoires */
        for ($i = 1; $i <= 10; $i++) {
            $user = new User;
            $hash = $this->encoder->encodePassword($user, 'password');
            $user->setPrenom($faker->firstname)
                ->setNom($faker->lastname)
                ->setEmail($faker->email)
                ->setNiv($level)
                ->addUserRole($formateurRole)
                ->setHash($hash);
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
                ->setTheme($theme);
            $nbmodule = mt_rand(0, 3);
            for ($j = 1; $j <= $nbmodule; $j++) {
                $module = $modules[mt_rand(0, count($modules) - 1)];
                $formation->addModule($module);
                $module->addFormation($formation);
                $manager->persist($module);
            }
            $manager->persist($formation);
        }
        $manager->flush();
    }
}
