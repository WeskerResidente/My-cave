<?php 
namespace App\Controller;

use App\Repository\BouteilleDeVinRepository;
use App\Repository\RegionRepository;
use App\Repository\PaysRepository;
use App\Repository\CepageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class VinController extends AbstractController
{
    #[Route('/vins', name: 'app_vin_listes')]
    public function index(
        Request $request,
        BouteilleDeVinRepository $vinRepo,
        PaginatorInterface $paginator,
        RegionRepository $regionRepo,
        PaysRepository $paysRepo,
        CepageRepository $cepageRepo
    ) {
        $query = $vinRepo->createQueryBuilder('v')
            ->leftJoin('v.region', 'r')
            ->leftJoin('v.pays', 'p')
            ->leftJoin('v.cepage', 'c')
            ->addSelect('r', 'p', 'c');

        if ($q = $request->query->get('q')) {
            $query->andWhere('v.nom LIKE :q')->setParameter('q', '%' . $q . '%');
        }

        if ($region = $request->query->get('region')) {
            $query->andWhere('r.id = :region')->setParameter('region', $region);
        }

        if ($pays = $request->query->get('pays')) {
            $query->andWhere('p.id = :pays')->setParameter('pays', $pays);
        }

        if ($cepage = $request->query->get('cepage')) {
            $query->andWhere('c.id = :cepage')->setParameter('cepage', $cepage);
        }

        if ($prixMax = $request->query->get('prix_max')) {
            $query->andWhere('v.prix <= :prix')->setParameter('prix', $prixMax);
        }

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('vin/listes.html.twig', [
            'vins' => $pagination,
            'regions' => $regionRepo->findAll(),
            'pays' => $paysRepo->findAll(),
            'cepages' => $cepageRepo->findAll(),
        ]);
    }
}
