<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BouteilleDeVinController extends AbstractController
{
    #[Route('/bouteille/de/vin', name: 'app_bouteille_de_vin')]
    public function index(): Response
    {
        return $this->render('bouteille_de_vin/index.html.twig', [
            'controller_name' => 'BouteilleDeVinController',
        ]);
    }
}
