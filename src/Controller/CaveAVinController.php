<?php

namespace App\Controller;

use App\Entity\CaveAVin;
use App\Entity\BouteilleDeVin;
use App\Form\CaveAVinTypeForm;
use App\Form\BouteilleDeVinType;
use App\Form\BouteilleDeVinTypeForm;
use App\Repository\CaveAVinRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BouteilleDeVinRepository;
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
        $caves = $caveAvinRepository->findCavesPubliques();
        // Affiche toutes les caves de l'utilisateur, publiques ou privées
        $caves = $caveAvinRepository->findBy(['utilisateur' => $this->getUser()]);

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

        if ($cave->isPrivee() && $cave->getUtilisateur() !== $this->getUser()) {
            $this->addFlash('warning', 'Cette cave est privée.');
            return $this->redirectToRoute('app_cave_a_vin');
        }

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

        //  Seul le créateur peut modifier
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
        #[Route('/cave/{id}/supprimer', name: 'app_cave_supprimer', methods: ['POST'])]
        public function supprimer(int $id, Request $request, CaveAVinRepository $repo, EntityManagerInterface $em): Response
        {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

            $cave = $repo->find($id);

            if (!$cave) {
                throw $this->createNotFoundException("Cave introuvable.");
            }

            if ($cave->getUtilisateur() !== $this->getUser()) {
                throw $this->createAccessDeniedException("Vous ne pouvez pas supprimer cette cave.");
            }

            if ($this->isCsrfTokenValid('delete-cave-' . $cave->getId(), $request->request->get('_token'))) {
                $em->remove($cave);
                $em->flush();
                $this->addFlash('success', 'Cave supprimée avec succès.');
            }

            return $this->redirectToRoute('app_liste_caves');
        }

        #[Route('/cave/{caveId}/retirer-vin/{vinId}', name: 'retirer_vin_de_cave', methods: ['POST'])]
        public function retirerVinDeCave(int $caveId, int $vinId, EntityManagerInterface $em): Response
        {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

            $cave = $em->getRepository(CaveAVin::class)->find($caveId);
            $vin = $em->getRepository(BouteilleDeVin::class)->find($vinId);

            if (!$cave || !$vin || $vin->getCave()?->getId() !== $cave->getId()) {
                throw $this->createNotFoundException("Vin ou cave introuvable.");
            }

            if ($cave->getCreePar() !== $this->getUser()) {
                throw $this->createAccessDeniedException("Vous n'avez pas le droit de modifier cette cave.");
            }

            $vin->setCave(null); // on détache la bouteille
            $em->flush();

            $this->addFlash('success', 'Vin retiré de la cave avec succès.');

            return $this->redirectToRoute('app_cave_show', ['id' => $caveId]);
        }
    #[Route('/vin/{vinId}/ajouter-a-ma-cave', name: 'app_ajouter_vin_a_ma_cave', methods: ['POST'])]
    public function ajouterVinAMaCave(
        int $vinId,
        EntityManagerInterface $em,
        BouteilleDeVinRepository $vinRepo,
        CaveAVinRepository $caveRepo
    ): Response {
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour ajouter un vin à votre cave.');
            return $this->redirectToRoute('app_login');
        }

        $vin = $vinRepo->find($vinId);

        if (!$vin) {
            $this->addFlash('error', 'Vin introuvable.');
            return $this->redirectToRoute('app_vin_listes');
        }

        if (!$vin->getRegion() || !$vin->getPays() || !$vin->getPrix()) {
            $this->addFlash('error', 'Ce vin est incomplet et ne peut pas être ajouté à votre cave.');
            return $this->redirectToRoute('app_vin_listes');
        }

        $cave = $caveRepo->findOneBy([
            'utilisateur' => $user,
            'nom' => $user->getNomCavePersonnelle(),
            'isPrivee' => true
        ]);

        if (!$cave) {
            $cave = new CaveAVin();
            $cave->setNom($user->getNomCavePersonnelle());
            $cave->setUtilisateur($user);
            $cave->setCreePar($user);
            $cave->setIsPrivee(true);
            $cave->setDateAjout(new \DateTimeImmutable());
            $cave->setDateModification(new \DateTimeImmutable());
            $cave->setImage('default-cave.jpg');
            $em->persist($cave);
            $em->flush();
        }

        if ($cave->getBouteilles()->contains($vin)) {
            $this->addFlash('info', 'Ce vin est déjà dans votre cave personnelle.');
        } else {
            $cave->addBouteille($vin);
            $cave->setDateModification(new \DateTimeImmutable());
            $em->flush();
            $this->addFlash('success', 'Vin ajouté à votre cave personnelle.');
        }

        return $this->redirectToRoute('app_mes_vins');
    }

    #[Route('/mes-vins', name: 'app_mes_vins')]
    public function mesVins(EntityManagerInterface $em, CaveAVinRepository $caveRepo): Response
    {
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté.');
            return $this->redirectToRoute('app_login');
        }

        $cave = $caveRepo->findOneBy([
            'utilisateur' => $user,
            'nom' => $user->getNomCavePersonnelle(),
            'isPrivee' => true
        ]);

        if (!$cave) {
            $cave = new CaveAVin();
            $cave->setNom($user->getNomCavePersonnelle());
            $cave->setUtilisateur($user);
            $cave->setCreePar($user);
            $cave->setIsPrivee(true);
            $cave->setDateAjout(new \DateTimeImmutable());
            $cave->setDateModification(new \DateTimeImmutable());
            $cave->setImage('default-cave.jpg');
            $em->persist($cave);
            $em->flush();
        }

        return $this->redirectToRoute('app_cave_show', ['id' => $cave->getId()]);
    }
        #[Route('/caves', name: 'app_liste_caves')]
    public function toutesCaves(Request $request, CaveAVinRepository $caveRepo): Response
    {
        $query = $request->query->get('q');

        if ($query) {
            $caves = $caveRepo->searchCavesPubliques($query);
        } else {
            $caves = $caveRepo->findCavesPubliques();
        }

        return $this->render('cave_a_vin/app_liste-caves', [
            'caves' => $caves,
            'pagination' => [
                'currentPageNumber' => 1,
                'pageCount' => 1
            ],
            'query' => $request->query->all()
        ]);
    }
        #[Route('/cave/{id}/toggle-privacy', name: 'app_toggle_cave_privacy', methods: ['POST'])]
    public function togglePrivacy(CaveAVin $cave, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($cave->getUtilisateur() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Vous ne pouvez pas modifier cette cave.");
        }

        $cave->setIsPrivee(!$cave->isPrivee());
        $cave->setDateModification(new \DateTimeImmutable());
        $em->flush();

        $this->addFlash('success', 'La visibilité de la cave a été mise à jour.');

        return $this->redirectToRoute('app_cave_show', ['id' => $cave->getId()]);
    }
    #[Route('/cave/{id}/toggle-privee', name: 'app_cave_toggle_privee', methods: ['POST'])]
    public function togglePrivee(Request $request, CaveAVin $cave, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($cave->getUtilisateur() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Vous ne pouvez pas modifier cette cave.");
        }

        if ($this->isCsrfTokenValid('toggle-privee-' . $cave->getId(), $request->request->get('_token'))) {
            $cave->setIsPrivee(!$cave->isPrivee());
            $cave->setDateModification(new \DateTimeImmutable());
            $em->flush();

            $this->addFlash('success', $cave->isPrivee() 
                ? 'La cave est maintenant privée.' 
                : 'La cave est maintenant publique.');
        }

        return $this->redirectToRoute('app_cave_show', ['id' => $cave->getId()]);
    }
    #[Route('/cave/{id}/toggle-visibilite', name: 'app_toggle_visibilite_cave', methods: ['POST'])]
    public function toggleVisibilite(
        CaveAVin $cave,
        EntityManagerInterface $em,
        Request $request
    ): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($cave->getUtilisateur() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Vous n'avez pas le droit de modifier cette cave.");
        }

        if ($this->isCsrfTokenValid('toggle-cave-' . $cave->getId(), $request->request->get('_token'))) {
            $cave->setIsPrivee(!$cave->isPrivee());
            $em->flush();

            $this->addFlash('success', 'La visibilité de la cave a été modifiée.');
        }

        return $this->redirectToRoute('app_cave_show', ['id' => $cave->getId()]);
    }

}
