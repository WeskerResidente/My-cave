<?php

namespace App\Controller;

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
    #[Route('/vin/new', name: 'vin_new')]
    public function new(
        Request $request,
        EntityManagerInterface $em,
        SluggerInterface $slugger
    ): Response {
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
                    return $this->redirectToRoute('vin_new');
                }
            } else {
                $this->addFlash('error', 'Veuillez ajouter une image.');
                return $this->redirectToRoute('vin_new');
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
