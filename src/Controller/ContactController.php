<?php


// src/Controller/ContactController.php
namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactTypeForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;     // on peut rester sur Email simple
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(
        Request $request,
        MailerInterface $mailer
    ): Response {
        $contact = new Contact();
        $form    = $this->createForm(ContactTypeForm::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Construire le mail
            $email = (new Email())
                // expéditeur (vous pouvez laisser votre adresse ou en créer une no‑reply)
                ->from(new Address('no-reply@votre-domaine.com', 'Site Web'))
                // destination : votre boîte Gmail testée via Mailtrap
                ->to('normanbelaid@gmail.com')
                // mettre en Reply-To l’adresse saisie par l’utilisateur
                ->replyTo($contact->getMail())
                ->subject('[Contact] ' . $contact->getSujet())
                ->text(
                    "Nom    : " . ($contact->getNom()   ?: '—') . "\n" .
                    "Email  : " . $contact->getMail()   . "\n" .
                    "Message:\n" . $contact->getMessage()
                )
            ;

            // envoyer
            $mailer->send($email);

            $this->addFlash('success', 'Votre message a bien été envoyé !');
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
