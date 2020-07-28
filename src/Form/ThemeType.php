<?php

namespace App\Form;

use App\Entity\Theme;
use App\Form\QThemeType;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ThemeType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'titre',
                TextType::class,
                $this->getConfiguration("Titre", "Titre du thème ...")
            )
            ->add(
                'stitre',
                TextType::class,
                $this->getConfiguration("Sous Titre", "Le sous Titre ...")
            )
            ->add(
                'description',
                TextType::class,
                $this->getConfiguration("Description", "Description du thème ...")
            )
            ->add(
                'questions',
                CollectionType::class,
                [
                    'entry_type' => QThemeType::class,
                    'allow_add' => true,
                    'allow_delete' => true
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Theme::class,
        ]);
    }
}
