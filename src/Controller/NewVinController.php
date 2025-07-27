<?php

namespace App\Controller;

use App\Repository\PaysRepository;
use App\Repository\RegionRepository;
use App\Repository\CepageRepository;
use App\Repository\TypeDeVinRepository;
use App\Repository\AppelationRepository;
use App\Entity\BouteilleDeVin;
use App\Form\BouteilleDeVinTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class NewVinController extends AbstractController
{
    #[Route('/vin/new', name: 'app_vin_new')]
    public function new(
        Request $request,
        EntityManagerInterface $em,
        SluggerInterface $slugger,
        PaysRepository $paysRepo,
        RegionRepository $regionRepo,
        CepageRepository $cepageRepo,
        TypeDeVinRepository $typeRepo,
        AppelationRepository $appelationRepo,
    ): Response {
        // ✅ Sécurité : s'assurer que toutes les entités requises existent
        if (
            $paysRepo->count([]) === 0 ||
            $regionRepo->count([]) === 0 ||
            $cepageRepo->count([]) === 0 ||
            $typeRepo->count([]) === 0 ||
            $appelationRepo->count([]) === 0
        ) {
            $this->addFlash('error', "Impossible d'ajouter un vin : certaines données de base (pays, région, cépage...) sont manquantes.");
            return $this->redirectToRoute('app_vin_listes');
        }

        $vin = new BouteilleDeVin();
        $form = $this->createForm(BouteilleDeVinTypeForm::class, $vin);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile|null $imageFile */
            $imageFile = $form->get('images')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('vins_images_directory'),
                        $newFilename
                    );
                    $vin->setImages($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors de l’upload de l’image.');
                    return $this->redirectToRoute('app_vin_new');
                }
            } else {
                $this->addFlash('error', 'Veuillez ajouter une image.');
                return $this->redirectToRoute('app_vin_new');
            }

            $vin->setCreePar($this->getUser());

            $em->persist($vin);
            $em->flush();

            return $this->redirectToRoute('app_vin_listes');
        }

        return $this->render('vin/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
