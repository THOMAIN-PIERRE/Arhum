<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
// use ReCaptcha\ReCaptcha;
use App\Form\RegisterType;
use App\Service\Recaptcha;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
 
    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder)
    {
        // initialisation d'une variable $notification pour l'affichage de message sur ma page
        $notification = null;

        $user = new User(); //J'instancie ma classe User (= je l'ouvre). j'obtiens donc un nouvel objet utilisateur dans la variable $user

        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user =$form->getData();

            $user->setCreatedAt(new \DateTime());


            // Vérification que l'utilisateur n'est pas déjà existant en BDD
            $search_email = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());

            if (!$search_email){
                $password = $encoder->encodePassword($user, $user->getPassword($user->getEmail()));
    
                $user-> setPassword($password);
    
                // dd($user);

                // persist = fige la donnée et la prépare à être créé en BDD (= création de l'entité).
                $this->entityManager->persist($user); 
                $this->entityManager->flush();

                $mail = new Mail();
                $content = "Bonjour ".$user->getFirstname()."<br/>Bienvenue sur la boutique en ligne Rhuma Sug. Toutes nos produits d'exception sont désormais disponibles en ligne.<br/><br/>Harum trium sententiarum nulli prorsus assentior. Nec enim illa prima vera est, ut, quem ad modum in se quisque sit, sic in amicum sit animatus. Quam multa enim, quae nostra causa numquam faceremus, facimus causa amicorum! precari ab indigno, supplicare, tum acerbius in aliquem invehi insectarique vehementius, quae in nostris rebus non satis honeste, in amicorum fiunt honestissime; multaeque res sunt in quibus de suis commodis viri boni multa detrahunt detrahique patiuntur, ut iis amici potius quam ipsi fruantur.";
                $mail->send($user->getEmail(), $user->getFirstname(), 'Bienvenue sur la boutique en ligne Rhuma Sug', $content);

                $notification = "Votre inscription s'est bien passée ! Vous pouvez dès à présent vous connecter à votre compte.";
            }else{ 
                $notification = "L'email que vous avez renseigné existe déjà !";
            }    

        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }

}


