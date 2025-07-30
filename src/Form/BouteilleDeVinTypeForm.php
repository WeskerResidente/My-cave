<?php

namespace App\Form;

use App\Entity\Pays;
use App\Entity\Cepage;
use App\Entity\Region;
use App\Entity\TypeDeVin;
use App\Entity\Appelation;
use App\Entity\BouteilleDeVin;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BouteilleDeVinTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom du vin'
            ])
            ->add('pays', EntityType::class, [
                'class' => Pays::class,
                'choice_label' => 'nom',
                'label' => 'Pays',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                              ->orderBy('p.nom', 'ASC');
                },
            ])
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'choice_label' => 'nom',
                'label' => 'Région',
                'placeholder' => 'Sélectionnez une région',
                'required' => true,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                              ->orderBy('r.nom', 'ASC');
                },
            ])
            ->add('cepage', EntityType::class, [
                'class' => Cepage::class,
                'choice_label' => 'nom',
                'label' => 'Cépage',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                              ->orderBy('c.nom', 'ASC');
                },
            ])
            ->add('typeDeVin', EntityType::class, [
                'class' => TypeDeVin::class,
                'choice_label' => 'nom',
                'label' => 'Type de vin',
                'placeholder' => 'Sélectionnez un type',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                              ->orderBy('t.nom', 'ASC');
                },
            ])
            ->add('annee', TextType::class, [
                'label' => 'Année'
            ])
            ->add('prix', MoneyType::class, [
                'label' => 'Prix',
                'currency' => 'EUR'
            ])
            ->add('images', FileType::class, [
                'label' => 'Image (JPG, PNG)',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Veuillez téléverser une image valide (JPG ou PNG)',
                    ])
                ]
            ])
            ->add('appelation', EntityType::class, [
                'class' => Appelation::class,
                'choice_label' => 'nom',
                'label' => 'Appellation',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('a')
                              ->orderBy('a.nom', 'ASC');
                },
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['maxlength' => 500],
                'required' => false,
            ])
        ;
    }
}
