<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/check-email', name: 'check_email', methods: ['POST'])]
    public function checkEmail(Request $request, UserRepository $userRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? null;

        if (!$email) {
            return new JsonResponse(['error' => 'Email manquant'], 400);
        }

        $user = $userRepository->findOneBy(['email' => $email]);

        return new JsonResponse(['exists' => $user !== null]);
    }
    #[Route('/check-pseudo', name: 'check_pseudo', methods: ['POST'])]
    public function checkPseudo(Request $request, UserRepository $userRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $pseudo = $data['pseudo'] ?? null;

        if (!$pseudo) {
            return new JsonResponse(['error' => 'Pseudo manquant'], 400);
        }

        $user = $userRepository->findOneBy(['pseudo' => $pseudo]);

        return new JsonResponse(['exists' => $user !== null]);
    }
}
