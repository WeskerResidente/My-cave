<?php 
namespace App\Controller;

use App\Repository\BouteilleDeVinRepository;
use App\Repository\RegionRepository;
use App\Repository\PaysRepository;
use App\Repository\CepageRepository;
use App\Repository\TypeDeVinRepository;
use App\Repository\CaveAVinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        CepageRepository $cepageRepo,
        TypeDeVinRepository $typeDeVinRepo,
        CaveAVinRepository $caveRepo,
    ): Response {
        $query = $vinRepo->createQueryBuilder('v')
            ->leftJoin('v.region', 'r')
            ->leftJoin('v.pays', 'p')
            ->leftJoin('v.cepage', 'c')
            ->leftJoin('v.typeDeVin', 't')
            ->addSelect('r', 'p', 'c', 't')
            ->where('v.isValide = true');
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

        if ($type = $request->query->get('type')) {
            $query->andWhere('t.id = :type')->setParameter('type', $type);
        }

        if ($prixMax = $request->query->get('prix_max')) {
            $query->andWhere('v.prix <= :prix')->setParameter('prix', $prixMax);
        }

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            12
        );

        $user = $this->getUser();
        $caves = $user ? $caveRepo->findBy(['utilisateur' => $user]) : [];

        return $this->render('vin/listes.html.twig', [
            'vins' => $pagination,
            'regions' => $regionRepo->findAll(),
            'pays' => $paysRepo->findAll(),
            'cepages' => $cepageRepo->findAll(),
            'types' => $typeDeVinRepo->findAll(), 
            'caves' => $caves,
        ]);
    }

    #[Route('/vin/{vinId}/ajouter-a-cave', name: 'app_ajouter_vin_a_cave', methods: ['POST'])]
    public function ajouterVinACave(
        int $vinId,
        Request $request,
        EntityManagerInterface $em,
        BouteilleDeVinRepository $vinRepo,
        CaveAVinRepository $caveRepo
    ): Response {
        $caveId = $request->request->get('cave_id');
        $vin = $vinRepo->find($vinId);
        $cave = $caveRepo->find($caveId);

        if (!$vin || !$cave || $cave->getUtilisateur() !== $this->getUser()) {
            $this->addFlash('error', 'Erreur : cave ou vin invalide.');
            return $this->redirectToRoute('app_vin_listes');
        }

        $cave->addBouteille($vin);
        $em->flush();

        $this->addFlash('success', 'Vin ajouté à la cave.');
        return $this->redirectToRoute('app_cave_show', ['id' => $cave->getId()]);
    }
    #[Route('/cave/{caveId}/retirer-vin', name: 'app_retirer_vin', methods: ['POST'])]
    public function retirerVin(
        int $caveId,
        Request $request,
        EntityManagerInterface $em,
        CaveAVinRepository $caveRepo,
        BouteilleDeVinRepository $vinRepo
    ): Response {
        $vinId = $request->request->get('vin_id');
        $cave = $caveRepo->find($caveId);
        $vin = $vinRepo->find($vinId);

        if (!$cave || !$vin || $vin->getCave()?->getId() !== $cave->getId()) {
            $this->addFlash('error', 'Erreur lors de la suppression.');
            return $this->redirectToRoute('app_cave_show', ['id' => $caveId]);
        }

        $vin->setCave(null);
        $em->flush();

        $this->addFlash('success', 'Vin retiré avec succès.');
        return $this->redirectToRoute('app_cave_show', ['id' => $caveId]);
    }

}
