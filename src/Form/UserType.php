<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use App\Entity\Level;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UserType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'prenom',
                TextType::class,
                $this->getConfiguration("Prénom", "Prénom de l'utilisateur")
            )
            ->add(
                'nom',
                TextType::class,
                $this->getConfiguration("Nom", "Nom de l'utilisateur")
            )
            ->add(
                'niv',
                EntityType::class,
                [
                    'class' => Level::class,
                    'choice_label' => 'titre',
                    'multiple' => false,
                    'expanded' => true
                ]
            )
            ->add(
                'userRoles',
                EntityType::class,
                [
                    'class' => Role::class,
                    'choice_label' => 'titre',
                    'multiple' => true,
                    'expanded' => true
                ]
            )
            ->add(
                'email',
                EmailType::class,
                $this->getConfiguration("Email principal", "Saisir le mail principal")
            )
            ->add(
                'email2',
                EmailType::class,
                $this->getConfiguration("Email secondaire", "Saisir un email secondaire", [
                    'required' => false
                ])
            )
            ->add(
                'telephone',
                TelType::class,
                $this->getConfiguration("Téléphone fixe", "Téléphone fixe", [
                    'required' => false
                ])
            )
            ->add(
                'mobile',
                TelType::class,
                $this->getConfiguration("Téléphone Mobile", "Téléphone mobile", [
                    'required' => false
                ])
            )
            ->add(
                'adresse',
                TextType::class,
                $this->getConfiguration("Adresse1", "Adresse 1ere partie ...", [
                    'required' => false
                ])
            )
            ->add(
                'adresse2',
                TextType::class,
                $this->getConfiguration("Adresse2", "Adresse 2eme partie ...", [
                    'required' => false
                ])
            )
            ->add(
                'postal',
                TextType::class,
                $this->getConfiguration("Code postal", "Code postal", [
                    'required' => false
                ])
            )
            ->add(
                'ville',
                TextType::class,
                $this->getConfiguration("Ville", "Ville ...", [
                    'required' => false
                ])
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
