<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class NewVinController extends AbstractController
{
    #[Route('/new/vin', name: 'app_new_vin')]
    public function index(): Response
    {
        return $this->render('new_vin/new_vin.html.twig', [
            'controller_name' => 'NewVinController',
        ]);
    }
}
