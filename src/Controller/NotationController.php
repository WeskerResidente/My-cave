<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class NotationController extends AbstractController
{
    #[Route('/notation', name: 'app_notation')]
    public function index(): Response
    {
        return $this->render('notation/index.html.twig', [
            'controller_name' => 'NotationController',
        ]);
    }
}
