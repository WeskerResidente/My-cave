<?php
namespace App\Controller\Admin;
use App\Entity\BouteilleDeVin;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
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
use Symfony\Component\Routing\Annotation\Route;
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
            ->setBasePath('/uploads/vins') // adapte à ton chemin public
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
    public function configureActions(Actions $actions): Actions
    {
        $valider = Action::new('valider', '✅ Valider')
            ->linkToCrudAction('validerVin');

        return $actions
              
                    ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                        return $action; // ou ->setLabel('Modifier') etc.
                    })
                    ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                        return $action; // ou ->setLabel('Supprimer') etc.
    });
    }
    public function validerVin(AdminContext $context): Response
    {
            $vin = $context->getEntity()->getInstance();

            $vin->setIsValide(true);

            $this->addFlash('success', 'Vin validé avec succès.');

            return $this->redirect($context->getReferrer());
        }
        public function configureCrud(Crud $crud): Crud
        {
            return $crud
                ->setEntityLabelInSingular('Vin à valider')
                ->setEntityLabelInPlural('Vins à valider')
                ->setDefaultSort(['dateAjout' => 'DESC'])
                ->setSearchFields(['nom', 'description'])
                ->setPageTitle(Crud::PAGE_INDEX, 'Modération des vins')
                ->overrideTemplate('crud/index', 'admin/vins_a_valider.html.twig')
                ->showEntityActionsInlined()
                ->setEntityPermission('ROLE_ADMIN');
        }
        public function refuserVin(BouteilleDeVin $vin, EntityManagerInterface $em): Response
        {
            $em->remove($vin);
            $em->flush();

            $this->addFlash('danger', 'Le vin a été refusé et supprimé.');
            return $this->redirectToRoute('admin_vins_a_valider');
        }
        #[Route('/admin/vin/{id}/valider', name: 'admin_valider_vin')]
    public function valider(BouteilleDeVin $vin, EntityManagerInterface $em): RedirectResponse
    {
        $vin->setIsValide(true);
        $em->flush();

        $this->addFlash('success', 'Vin validé avec succès.');
        return $this->redirectToRoute('admin_vins_a_valider');
    }

}
