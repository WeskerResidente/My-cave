<?php

namespace App\Controller\Admin;

use App\Entity\BouteilleDeVin;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BouteilleDeVinRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class VinModerationCrudController extends AbstractCrudController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getEntityFqcn(): string
    {
        return BouteilleDeVin::class;
    }

    public function createIndexQueryBuilder(
        SearchDto $searchDto,
        EntityDto $entityDto,
        FieldCollection $fields,
        FilterCollection $filters
    ): QueryBuilder {
        $alias = $entityDto->getName();

        return $this->em->createQueryBuilder()
            ->select($alias)
            ->from($entityDto->getFqcn(), $alias)
            ->where("$alias.isValide = false");
    }

    public function configureFields(string $pageName): iterable
    {
        yield ImageField::new('images')
            ->setBasePath('/uploads/vins')
            ->setLabel('Image');

        yield TextField::new('nom');
        yield AssociationField::new('pays');
        yield AssociationField::new('region');
        yield AssociationField::new('cepage');
        yield AssociationField::new('typeDeVin');
        yield AssociationField::new('appelation');
        yield TextareaField::new('description');
        yield MoneyField::new('prix')->setCurrency('EUR');
        yield BooleanField::new('isValide')->setLabel('Vin validé ?');
    }


    #[Route('/admin/moderation/vins', name: 'admin_moderation_vins')]
    public function liste(BouteilleDeVinRepository $repo): Response
    {
        return $this->render('admin/vins_a_valider.html.twig', [
            'vins' => $repo->findBy(['isValide'=>false]),
        ]);
    }

    #[Route('/admin/valider-vin/{entityId}', name: 'validerVin')]
    public function validerVin(int $entityId, BouteilleDeVinRepository $repo): RedirectResponse
    {
        $vin = $repo->find($entityId);
        if (!$vin) throw $this->createNotFoundException();
        $vin->setIsValide(true);
        $this->em->flush();
        return $this->redirectToRoute('admin_moderation_vins');
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Vin à valider')
            ->setEntityLabelInPlural('Vins à valider')
            ->setDefaultSort(['dateAjout' => 'DESC'])
            ->setSearchFields(['nom', 'description'])
            ->setPageTitle(Crud::PAGE_INDEX, 'Modération des vins')
            ->showEntityActionsInlined()
            ->setEntityPermission('ROLE_ADMIN');
    }
    

}
