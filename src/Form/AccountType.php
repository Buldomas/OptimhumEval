<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AccountType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class, $this->getConfiguration("Prénom", "Votre prénom ..."))
            ->add('nom', TextType::class, $this->getConfiguration("Nom", "Votre Nom de famille ..."))
            ->add('email', EmailType::class, $this->getConfiguration("Email", "Votre Email principal (Identifiant) ..."))
            ->add('email2', EmailType::class, $this->getConfiguration("Email2", "Deuxième Email si vous le souhaitez ...", ['required' => false]))
            ->add('picture', UrlType::class, $this->getConfiguration("Photo de profil", "Adresse de votre profil ...", ['required' => false]))
            ->add('telephone', TelType::class, $this->getConfiguration("Téléphone", "Votre N° de téléphone fixe ...", ['required' => false]))
            ->add('mobile', TelType::class, $this->getConfiguration("Mobile", "Votre N° de mobile ...", ['required' => false]))
            ->add('adresse', TextType::class, $this->getConfiguration("Adresse", "Votre adresse ...", ['required' => false]))
            ->add('adresse2', TextType::class, $this->getConfiguration("Complément", "Votre adresse complément ...", ['required' => false]))
            ->add('postal', IntegerType::class, $this->getConfiguration("Code Postal", "Votre code postal ...", ['required' => false]))
            ->add('ville', TextType::class, $this->getConfiguration("Ville", "Votre commune ...", ['required' => false]));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
