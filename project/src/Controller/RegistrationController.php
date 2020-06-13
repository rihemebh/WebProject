<?php

namespace App\Controller;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;


class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function adduser(Request $request, EntityManagerInterface $manager ,UserPasswordEncoderInterface $encoder, GuardAuthenticatorHandler $guardHandler, UserAuthenticator $formAuthenticator, \Swift_Mailer $mailer)
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('account');
        }

        $user=new User();
        $SignUp=$this->createForm(UserType::class,$user);
        $SignUp->remove('Save_Changes');
        try {
            $SignUp->handleRequest($request);
        } catch (\Exception $e) {
            echo "failed : " . $e->getMessage();
        }

        if($SignUp->isSubmitted() && $SignUp->isValid()){

            //generation du token d'activation
            $user->setActivationToken(md5(uniqid()));
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();

            $message=(new \Swift_Message('Confirm Your Account'))
            ->setFrom('cheikh@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView('registration/activate.html.twig',['token'=>$user->getActivationToken()]),
                'text/html'
                );
            $mailer->send($message);


            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $formAuthenticator,
                'main'
            );
        }
        return $this->render('registration/SignUp.html.twig', [
            'signup' => $SignUp->createView()

        ]);
    }

    /**
     * @Route("/activation/{token}", name="activation")
     */
    public function activation ($token,UserRepository $rep){

        //on verifie si l utilisateur a le token
        $user=$rep->findOneBy(['activation_token' => $token]);

        if(!$user) throw $this->createNotFoundException("cet Utilisateur n'existe pas");


            $user->setActivationToken(null);
            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success','Account Activated !');
           return  $this->redirectToRoute('account');
    }
}
?>