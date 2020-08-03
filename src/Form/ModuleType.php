<?php

namespace App\Form;

use App\Entity\Module;
use App\Form\QModuleType;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ModuleType extends ApplicationType
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
                'qModules',
                CollectionType::class,
                [
                    'entry_type' => QModuleType::class,
                    'allow_add' => true,
                    'allow_delete' => true
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Module::class,
        ]);
    }
}
