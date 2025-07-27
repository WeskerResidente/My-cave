<?php

namespace App\Controller;

use App\Entity\Notation;
use App\Entity\Commentaire;
use App\Entity\BouteilleDeVin;
use App\Form\NotationTypeForm;
use App\Form\CommentaireTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class BouteilleDeVinController extends AbstractController
{
    #[Route('/bouteille/de/vin', name: 'app_bouteille_de_vin')]
    public function index(): Response
    {
        return $this->render('bouteille_de_vin/index.html.twig', [
            'controller_name' => 'BouteilleDeVinController',
        ]);
    }

   #[Route('/vin/{id<\d+>}', name: 'vin_show')]
    public function show(BouteilleDeVin $vin, Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $userHasRated = false;

        // 🔍 Chercher la note existante de l'utilisateur pour ce vin
        $existingNote = null;
        if ($user) {
            $existingNote = $em->getRepository(Notation::class)->findOneBy([
                'user' => $user,
                'vin' => $vin,
            ]);
            $userHasRated = $existingNote !== null;
        }

        // 🛠️ Réutiliser la note existante ou créer une nouvelle
        $notation = $existingNote ?? new Notation();
        $notation->setVin($vin);
        $notation->setUser($user);

        $formNote = $this->createForm(NotationTypeForm::class, $notation);
        $formNote->handleRequest($request);

        if ($formNote->isSubmitted() && $formNote->isValid()) {
            $em->persist($notation); // persist fonctionne aussi pour update
            $em->flush();

            $this->addFlash('success', 'Votre note a été enregistrée.');
            return $this->redirectToRoute('vin_show', ['id' => $vin->getId()]);
        }

        // === Commentaire ===
        $commentaire = new Commentaire();
        $commentaire->setVin($vin);
        $commentaire->setUser($user);

        $formCommentaire = $this->createForm(CommentaireTypeForm::class, $commentaire);
        $formCommentaire->handleRequest($request);

        if ($formCommentaire->isSubmitted() && $formCommentaire->isValid()) {
            $em->persist($commentaire);
            $em->flush();

            $this->addFlash('success', 'Commentaire ajouté.');
            return $this->redirectToRoute('vin_show', ['id' => $vin->getId()]);
        }

        return $this->render('vin/show.html.twig', [
            'vin' => $vin,
            'formNote' => $formNote->createView(),
            'userHasRated' => $userHasRated,
            'form' => $formCommentaire->createView(),
        ]);
    }

}
