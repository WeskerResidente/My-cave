<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\CaveAVin;
use App\Entity\NoteDeVin;
use App\Entity\Commentaire;
use App\Entity\BouteilleCave;
use App\Entity\BouteilleDeVin;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BouteilleDeVinRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // Redirige vers une section par défaut (par exemple les utilisateurs)
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Panneau d\'administration');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Accueil Admin', 'fa fa-home');

        yield MenuItem::section('Utilisateurs');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class);

        yield MenuItem::section('Caves à vin');
        yield MenuItem::linkToCrud('Caves', 'fas fa-warehouse', CaveAVin::class);
        yield MenuItem::linkToCrud('Bouteilles dans les caves', 'fas fa-boxes', BouteilleCave::class);

        yield MenuItem::section('Vins');
        yield MenuItem::linkToCrud('Vins', 'fas fa-wine-bottle', BouteilleDeVin::class);
        yield MenuItem::linkToCrud('Notes de vin', 'fas fa-star', NoteDeVin::class);
        yield MenuItem::linkToCrud('Commentaires', 'fas fa-comments', Commentaire::class);
        yield MenuItem::section('Modération');
        yield MenuItem::linkToRoute('Vins à valider', 'fa fa-wine-glass', 'admin_vins_a_valider');
        // yield MenuItem::section('MODÉRATION');
        // yield MenuItem::linkToCrud('Vins à valider', 'fas fa-key', BouteilleDeVin::class)
        //     ->setController(VinModerationCrudController::class);
        // MenuItem::linkToCrud('Vins à valider', 'fa fa-wine-glass', BouteilleDeVin::class)
        // ->setController(VinModerationCrudController::class)
        // ->setPermission('ROLE_ADMIN');
        }
        #[Route('/admin/vins-a-valider', name: 'admin_vins_a_valider')]
        public function vinsAValider(
            AdminUrlGenerator $urlGenerator,
            BouteilleDeVinRepository $repo
        ): Response {
            $vins = $repo->findBy(['isValide' => false]);

            $urls = [];
            foreach ($vins as $vin) {
                $urls[$vin->getId()] = $urlGenerator
                    ->setController(VinModerationCrudController::class)
                    ->setAction('valider')
                    ->setEntityId($vin->getId())
                    ->generateUrl();
            }

            return $this->render('admin/vins_a_valider.html.twig', [
                'vins' => $vins,
                'urls' => $urls,
            ]);
        }
        #[Route('/admin/vin/{id}/refuser', name: 'admin_refuser_vin')]
        public function refuserVin(BouteilleDeVin $vin, EntityManagerInterface $em): RedirectResponse
        {
            $em->remove($vin);
            $em->flush();

            $this->addFlash('danger', 'Le vin a été refusé et supprimé.');
            return $this->redirectToRoute('admin_vins_a_valider');
        }
}

