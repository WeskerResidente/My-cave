<?php

namespace App\Form;

use App\Entity\CaveAVin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\File;
class CaveAVinTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
                ->add('nom')
                ->add('image', FileType::class, [
                    'label' => 'Image de la cave',
                    'mapped' => false, // important si l'entité ne contient pas d'objet File
                    'required' => false,
                    'constraints' => [
                        new File([
                            'maxSize' => '2M',
                            'mimeTypes' => ['image/jpeg', 'image/png', 'image/webp'],
                            'mimeTypesMessage' => 'Veuillez uploader une image valide',
                        ])
                    ],
                ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CaveAVin::class,
        ]);
    }
}
