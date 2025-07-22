<?php

namespace App\Controller;

use App\Entity\CaveAVin;
use App\Form\SearchCaveType;
use App\Form\SearchCaveTypeForm;
use App\Repository\CaveAVinRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Repository\BouteilleDeVinRepository; // à ajouter si tu l'utilises
use Doctrine\ORM\EntityManagerInterface;

class ListeCaveController extends AbstractController
{
    #[Route('/liste-caves', name: 'app_liste_caves')]
    public function index(
        Request $request,
        CaveAVinRepository $caveRepo,
        BouteilleDeVinRepository $bouteilleDeVinRepository,
        PaginatorInterface $paginator
    ): Response {
        $queryBuilder = $caveRepo->createQueryBuilder('c');

        // Recherche par nom (champ texte "q")
        $q = $request->query->get('q');
        if (!empty($q)) {
            $queryBuilder->andWhere('c.nom LIKE :q')
                        ->setParameter('q', '%' . $q . '%');
        }

        // Filtre par vin (ID d’une bouteille)
        $vinId = $request->query->get('vin');
        if (!empty($vinId)) {
            $queryBuilder->join('c.bouteilles', 'b')
                        ->andWhere('b.id = :vinId')
                        ->setParameter('vinId', $vinId);
        }

        // Filtre par région (en supposant que c.region existe)
        $region = $request->query->get('region');
        if (!empty($region)) {
            $queryBuilder->andWhere('c.region = :region')
                        ->setParameter('region', $region);
        }

        // Pagination
        $pagination = $paginator->paginate(
            $queryBuilder->getQuery(),
            $request->query->getInt('page', 1),
            12
        );

        // Récupération des données à injecter dans le template
        $bouteilles = $bouteilleDeVinRepository->findAll();
        $regions = $caveRepo->createQueryBuilder('c')
                            ->select('DISTINCT c.region')
                            ->getQuery()
                            ->getSingleColumnResult();

        return $this->render('toutes_les_caves/caves_listes.html.twig', [
            'caves' => $pagination,
            'bouteille_de_vin' => $bouteilles,
            'regions' => $regions,
            'pagination' => $pagination,
            'query' => $request->query->all(),
        ]);

        if (!empty($q)) {
            $query->andWhere('c.nom LIKE :q')
                ->setParameter('q', '%' . $q . '%');
        }

        $pagination = $paginator->paginate(
            $query->getQuery(),
            $request->query->getInt('page', 1),
            9
        );

        // Liste unique des régions
        $regionList = array_column(
            $em->createQuery('SELECT DISTINCT c.region FROM App\Entity\CaveAVin c WHERE c.region IS NOT NULL')
               ->getArrayResult(),
            'region'
        );

        return $this->render('toutes_les_caves/caves_listes.html.twig', [
            'caves' => $pagination,
            'bouteille_de_vin' => $bouteilleDeVinRepository->findAll(),
            'regions' => $regionList,
            'pagination' => $pagination,
            'query' => $request->query->all(),
        ]);
    }
}
