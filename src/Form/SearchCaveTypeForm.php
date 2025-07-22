<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchCaveTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('motcle', TextType::class, [
                'label' => '🔍 Recherche :',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Cave à vin...',
                    'class' => 'search-input',
                ],
            ])
            ->add('region', ChoiceType::class, [
                'label' => false,
                'required' => false,
                'choices' => [
                    'Toutes les régions' => '',
                    'Bordeaux' => 'Bordeaux',
                    'Bourgogne' => 'Bourgogne',
                    'Alsace' => 'Alsace',
                    'Rhône' => 'Rhône',
                    'Loire' => 'Loire',
                    'Champagne' => 'Champagne',
                ],
                'placeholder' => 'Régions',
                'attr' => [
                    'class' => 'select-region',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
