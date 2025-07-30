<?php
// src/Controller/StaticController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaticController extends AbstractController
{
    #[Route('/a-propos', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('static/about.html.twig');
    }

    #[Route('/politique-confidentialite', name: 'app_privacy')]
    public function privacy(): Response
    {
        return $this->render('static/privacy.html.twig');
    }

    #[Route('/conditions-utilisation', name: 'app_terms')]
    public function terms(): Response
    {
        return $this->render('static/terms.html.twig');
    }
}
