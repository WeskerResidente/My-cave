<?php

namespace App\Controller\Admin;

use App\Entity\BouteilleDeVin;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\{
    BooleanField, TextField, MoneyField, AssociationField, IntegerField, ImageField, TextareaField
};
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
class BouteilleDeVinCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BouteilleDeVin::class;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            AssociationField::new('pays'),
            AssociationField::new('region'),
            AssociationField::new('cepage'),
            IntegerField::new('annee'),
            MoneyField::new('prix')->setCurrency('EUR'),
            AssociationField::new('typeDeVin'),
            AssociationField::new('appelation'),
            TextareaField::new('description'),
            BooleanField::new('isValide', 'Vin validé ?'),
        ];
    }
    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
