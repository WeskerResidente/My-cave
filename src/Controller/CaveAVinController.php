<?php

namespace App\Controller;

use App\Entity\CaveAVin;
use App\Entity\BouteilleDeVin;
use App\Form\CaveAVinTypeForm;
use App\Form\BouteilleDeVinType;
use App\Form\BouteilleDeVinTypeForm;
use App\Repository\CaveAVinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CaveAVinController extends AbstractController
{
    #[Route('/cave/a/vin', name: 'app_cave_a_vin')]
    public function index(CaveAVinRepository $caveAvinRepository): Response
    {
        $user = $this->getUser();
        $caves = $caveAvinRepository->findBy(
            ['utilisateur' => $user],
            ['dateAjout' => 'DESC']);

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

        #[Route('/cave/{id}/ajouter-vin', name: 'app_cave_ajouter_vin')]
        public function ajouterVinDansCave(Request $request, CaveAVin $cave, EntityManagerInterface $em): Response
        {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

            if ($this->getUser() !== $cave->getCreePar()) {
                throw $this->createAccessDeniedException("Vous ne pouvez pas ajouter de vin dans cette cave.");
            }

            $vin = new BouteilleDeVin();
            $form = $this->createForm(BouteilleDeVinTypeForm::class, $vin);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $vin->setCreePar($this->getUser());
                $vin->setCave($cave);

                $em->persist($vin);
                $em->flush();

                $this->addFlash('success', 'Vin ajouté à la cave avec succès !');

                return $this->redirectToRoute('app_cave_show', ['id' => $cave->getId()]);
            }

            return $this->render('vin/ajouter.html.twig', [
                'form' => $form->createView(),
                'cave' => $cave
            ]);
}

        #[Route('/cave/{id}/edit', name: 'app_cave_edit')]
    public function edit(Request $request, CaveAVin $cave, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // ⚠️ Seul le créateur peut modifier
        if ($cave->getCreePar() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Vous n'avez pas le droit de modifier cette cave.");
        }

        $form = $this->createForm(CaveAVinTypeForm::class, $cave);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cave->setDateModification(new \DateTimeImmutable());

            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move($this->getParameter('cave_images_directory'), $newFilename);
                $cave->setImage($newFilename);
            }

            $em->flush();
            $this->addFlash('success', 'Cave mise à jour avec succès.');
            return $this->redirectToRoute('app_cave_show', ['id' => $cave->getId()]);
        }

        return $this->render('cave_a_vin/edit.html.twig', [
            'form' => $form->createView(),
            'cave' => $cave,
        ]);
    }
    #[Route('/cave/{id}/inline-update', name: 'app_cave_inline_update', methods: ['POST'])]
    public function inlineUpdate(Request $request, CaveAVin $cave, EntityManagerInterface $em): JsonResponse
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if ($cave->getCreePar() !== $this->getUser()) {
            return new JsonResponse(['error' => 'Unauthorized'], 403);
        }

        $data = json_decode($request->getContent(), true);
        $cave->setNom($data['nom'] ?? $cave->getNom());
        $cave->setDescription($data['description'] ?? $cave->getDescription());
        $cave->setDateModification(new \DateTimeImmutable());

        $em->flush();

        return new JsonResponse(['success' => true]);
    }
        #[Route('/cave/{id}/update-image', name: 'app_cave_update_image', methods: ['POST'])]
        public function updateImage(Request $request, CaveAVin $cave, EntityManagerInterface $em, SluggerInterface $slugger): JsonResponse
        {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

            if ($this->getUser() !== $cave->getCreePar()) {
                return new JsonResponse(['success' => false, 'error' => 'Non autorisé.'], 403);
            }

            $file = $request->files->get('image');

            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

                try {
                    $file->move($this->getParameter('caves_directory'), $newFilename);
                } catch (\Exception $e) {
                    return new JsonResponse([
                        'success' => false,
                        'error' => 'Erreur lors du déplacement du fichier : ' . $e->getMessage()
                    ], 500);
                }

                $cave->setImage($newFilename);
                $em->flush();

                return new JsonResponse([
                    'success' => true,
                    'newImagePath' => '/uploads/caves/' . $newFilename
                ]);
            }

            return new JsonResponse(['success' => false, 'error' => 'Aucun fichier.'], 400);

        }

}
