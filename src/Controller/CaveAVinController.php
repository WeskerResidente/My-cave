<?php

namespace App\Controller;

use App\Entity\CaveAVin;
use App\Form\CaveAVinTypeForm;
use App\Repository\CaveAVinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

final class CaveAVinController extends AbstractController
{
    #[Route('/cave/a/vin', name: 'app_cave_a_vin')]
    public function index(CaveAVinRepository $caveAvinRepository): Response
    {
        $user = $this->getUser();
        $caves = $caveAvinRepository->findBy(['utilisateur' => $user]);

        return $this->render('cave_a_vin/cave_a_vin.html.twig', [
            'caves' => $caves,
        ]);
    }

    #[Route('/cave/new', name: 'app_new_cave')]
    public function new(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $cave = new CaveAVin();
        $form = $this->createForm(CaveAVinTypeForm::class, $cave);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $cave->setUtilisateur($user);
            $cave->setCreePar($user);
            $cave->setDateAjout(new \DateTimeImmutable());
            $cave->setDateModification(new \DateTimeImmutable());

            // Récupération de l'image (non mappée)
            /** @var UploadedFile|null $imageFile */
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('cave_images_directory'), // à définir dans services.yaml
                    $newFilename
                );

                $cave->setImage($newFilename);
            } else {
                $cave->setImage('default-cave.jpg');
            }

            $em->persist($cave);
            $em->flush();

            $this->addFlash('success', 'Cave créée avec succès !');
            return $this->redirectToRoute('app_cave_a_vin');
        }

        return $this->render('cave_a_vin/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/cave/{id}', name: 'app_cave_show')]
    public function show(CaveAVin $cave): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('cave_a_vin/show.html.twig', [
            'cave' => $cave,
        ]);
    }
    #[Route('/cave/{id}/ajouter-vin', name: 'app_ajouter_vin')]
    public function ajouterVin(CaveAVin $cave): Response
    {
        // Logique pour ajouter un vin dans cette cave
        // Par exemple : afficher un formulaire de création de vin
        return $this->render('vin/ajouter.html.twig', [
            'cave' => $cave,
        ]);
    }
}
