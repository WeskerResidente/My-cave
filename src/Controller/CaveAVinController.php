<?php

namespace App\Controller;

use App\Repository\CaveAVinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CaveAVinController extends AbstractController
{
    #[Route('/cave/a/vin', name: 'app_cave_a_vin')]
    public function index(CaveAvinRepository $caveAvinRepository): Response
    {
        // Récupère les caves liées à l'utilisateur connecté
        $user = $this->getUser();
        $caves = $caveAvinRepository->findBy(['utilisateur' => $user]);

        return $this->render('cave_a_vin/cave_a_vin.html.twig', [
            'caves' => $caves,
        ]);
    }
}
