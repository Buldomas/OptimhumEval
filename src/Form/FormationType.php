<?php

namespace App\Form;

use App\Entity\Theme;
use App\Form\ThemeType;
use App\Entity\Formation;
use App\Entity\Module;
use App\Form\QFormationType;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class FormationType extends ApplicationType
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
                TextareaType::class,
                $this->getConfiguration("Description", "Description du thème ...")
            )
            ->add(
                'theme',
                EntityType::class,
                [
                    'class' => Theme::class,
                    'choice_label' => 'titre',
                    'multiple' => false
                ]
            )
            ->add(
                'modules',
                EntityType::class,
                [
                    'class' => Module::class,
                    'choice_label' => 'titre',
                    'multiple' => true,
                    'expanded' => true
                ]
            )
            ->add(
                'qFormations',
                CollectionType::class,
                [
                    'entry_type' => QFormationType::class,
                    'allow_add' => true,
                    'allow_delete' => true
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
