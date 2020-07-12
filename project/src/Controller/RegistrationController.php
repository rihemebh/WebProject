<?php

namespace App\Controller;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Swift_Attachment;
use Swift_Image;
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

        if($SignUp->isSubmitted() && $SignUp->isValid()) {

            //generation du token d'activation
            $user->setActivationToken(md5(uniqid()));
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();

            $message = (new \Swift_Message('Confirm Your Account'));
            $message->setFrom('cheikh@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView('registration/activate.html.twig',
                        [
                            'token' => $user->getActivationToken(),
                            'username' => $user->getUserName(),
                            'image_src' => $message->embed(Swift_Image::fromPath('C:\xampp\htdocs\WebProject\WebProject\project\public\mail3.jpg'))

                        ]),
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

        //check if the user has the token
        $user=$rep->findOneBy(['activation_token' => $token]);

        if(!$user) throw $this->createNotFoundException("User not Found");


            $user->setActivationToken(null);
            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success','Account Activated !');
           return  $this->redirectToRoute('account');
    }

    /**
     * @Route("/confirm", name="confirm")
     */
    public function confirmAccount()
    {
        if(!$this->getUser()) return $this->redirectToRoute('register');
        elseif(!$this->getUser()->getActivationToken() )
            return $this->redirectToRoute('account');
        else return $this->render('registration/confirm.html.twig');

    }
}
?>