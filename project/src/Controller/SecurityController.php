<?php

namespace App\Controller;

use App\Form\ResetPassType;
use App\Form\ResetType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            if(!$this->getUser()->getActivationToken())
            return $this->redirectToRoute('account');
            else return $this->redirectToRoute('confirm');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
    }

    /**
     * @Route("/PasswordForgotten", name="app_forgot")
     */

    public function forgottenpassword(Request $request,UserRepository $rep, \Swift_Mailer $mailer , TokenGeneratorInterface $tokengenerator)
    {
        if ($this->getUser()) {
            if(!$this->getUser()->getActivationToken())
                return $this->redirectToRoute('account');
            else return $this->redirectToRoute('confirm');
        }

        $form=$this->createForm(ResetPassType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $email=$form->get('Email_Address')->getData();
            $user=$rep->findOneBy(['Email' => $email]);
            if(!$user)
            {
                $this->addFlash('alert','Email Not Found');
            return $this->redirectToRoute('app_login');
            }
            $token=$tokengenerator->generateToken();
            try{
                $user->setResetToken($token);
                $em=$this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
            }
            catch(\Exception $ex){
                $this->addFlash('alert','Unable to Generate Token :'.$ex->getMessage());
                return $this->redirectToRoute('app_login');
            }

            $message=(new \Swift_Message('Reset Your Password'))
                ->setFrom('cheikh@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView('security/EmailResetPassword.html.twig',['token'=>$token,'username'=>$user->getUserName()]),
                    'text/html'
                );
            $mailer->send($message);
           return  $this->render('security/confirmforgot.html.twig', [
               'Email'=>$email
           ]);
        }

        return $this->render('security/requestPassword.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/ResetPassword/{token}", name="ResetPassword")
     */

    public function resetpassword(Request $request,$token,UserPasswordEncoderInterface $encoder)
    {

        $user=$this->getDoctrine()->getRepository(User::class)->findOneBy(['reset_token'=>$token]);

        if(!$user) {
            $this->addFlash('alert', 'Token Inconnu');
            return $this->redirectToRoute('app_login');
        }

        $reset=$this->createForm(ResetType::class);
        $reset->remove('oldPass');
        $reset->handleRequest($request);
        if($reset->isSubmitted() && $reset->isValid()){
            $user->setResetToken(null);
            $user->setPassword($encoder->encodePassword($user,$reset->get('newPassword')->get('new')->getData()));
            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success','Password Successfully Changed');
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/ResetPassword.html.twig',[
            'reset'=>$reset->createView()
        ]);
    }
}
