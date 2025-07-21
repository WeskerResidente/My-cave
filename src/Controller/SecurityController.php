<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
            // Message personnalisé
            $customError = null;
            if ($error) {
                $message = $error->getMessageKey();

                if ($message === 'Invalid credentials.') {
                    $customError = 'Email ou mot de passe incorrect.';
                } elseif ($message === 'User could not be found.') {
                    $customError = 'Cet email est introuvable.';
                } else {
                    $customError = 'Une erreur est survenue lors de la connexion.';
                }
            }
                return $this->render('security/login.html.twig', [

                    'error' => $customError,
                ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
