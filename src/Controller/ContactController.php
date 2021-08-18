<?php

namespace App\Controller;

use Mailjet\Client;
use App\Classe\Mail;
use Mailjet\Resources;
use App\Classe\Contact;
use App\Entity\Carousel;
use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
   /**
    * Formulaire de contact
    *
    * @Route("/nous-contacter", name="contact")
    */
    public function index(Request $request, MailerInterface $mailer)
    {
        $user = $this->getUser();

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        

        if ($form->isSubmitted() && $form->isValid()) {

            $contact = $form->getData();
            // dd($contact);

        //     //ici, nous envoyons le mail
        //     // dd($contact);
        //     $content = new Email();
        //     //On attribue l'expéditeur
        //     $content->From($contact["email"])
        //     //On attribue le destinataire
        //     ->To("contact.rhumasug@gmail.com")
        //     //On créé le message avec la vue Twig
        //       ->html(
        //           $this->renderView(
        //               "emails/contact.html.twig", compact('contact')

        //           ),
        //           'text/html'
        //       )
        // ;


        //ici, nous envoyons le mail
            // dd($contact);
            $email = new Email();
            //On attribue l'expéditeur
            $email->from($contact["email"])
                  //On attribue le destinataire
                  ->to("contact.rhumasug@gmail.com")
                  ->subject($contact["subject"])
                  ->text("Mail de test")
                  //On créé le message avec la vue Twig
                //   ->html($contact["content"])
                  ->html(
                    $this->renderView(
                        "emails/contact.html.twig", compact('contact')

                    ),
                    'text/html'
                )
        ;
            
              
        //On envoie le message      
        $mailer->send($email);  


            $this->addFlash('notice', 'Merci de nous avoir contacté ! Notre équipe reviendra vers vous dans les plus brefs délais.');
        }

        // Possibilité de brancher ici un envoi d'email, d'API d'assistance client, un envoi en BDD ... 
        //(en fonction de l'endroit ou je souhaite enregistrer ces infos de contact)

        $mail = new Mail();
        $content = "Bonjour ".$user->getFirstname().", <br/>Nous vous remercions pour votre message.<br/><br/>Toutes nos équipes sont mobilisées pour vous répondre. Nous reviendrons très prochainement vers vous.";
        $mail->send($user->getEmail(), $user->getFirstname(), 'Confirmation de réception de votre message', $content);

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

