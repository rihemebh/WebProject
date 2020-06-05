<?php

namespace App\Controller;
use App\Form\UserType;
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
    public function adduser(Request $request, EntityManagerInterface $manager ,UserPasswordEncoderInterface $encoder, GuardAuthenticatorHandler $guardHandler, UserAuthenticator $formAuthenticator)
    {
        $user=new User();
        $SignUp=$this->createForm(UserType::class,$user);
        try {
            $SignUp->handleRequest($request);
        } catch (\Exception $e) {
            echo "failed : " . $e->getMessage();
        }

        if($SignUp->isSubmitted() && $SignUp->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();
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
     * @Route("/log", name="logout")
     */
    public function logout()
    {
        return $this->render('acceuil/acceuil.html.twig');
    }
}
?>