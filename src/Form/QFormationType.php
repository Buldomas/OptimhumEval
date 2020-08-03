<?php

namespace App\Form;

use App\Entity\QFormation;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class QFormationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'libelle',
                TextType::class,
                $this->getConfiguration('Libellé', "Saisir votre question ...")
            )
            ->add(
                'note',
                IntegerType::class,
                $this->getConfiguration('Note', "Note sur ...")
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => QFormation::class,
        ]);
    }
}
