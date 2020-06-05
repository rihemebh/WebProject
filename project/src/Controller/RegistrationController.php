<?php

namespace App\Controller;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
        $SignUp=$this->createFormBuilder($user)
            ->add('First_Name',TextType::class , array(
                'attr' => array(
                    'class' => 'form-control',
                    'Placeholder'=>'First Name')))

            ->add('Last_Name',TextType::class,array(
                'attr'=>array(
                    'class' => 'form-control',
                    'Placeholder'=>'Last Name'
                )
            ))
            ->add('User_Name',TextType::class,array(
                'attr'=>array(
                    'class' => 'form-control adjust',
                    'Placeholder'=>'UserName'
                )
            ))
            ->add('Email',EmailType::class,array(
                'attr'=>array(
                    'class' => 'form-control',
                    'Placeholder'=>'Email'
                )
            ))
            ->add('Password', RepeatedType::class, [
                'type' =>PasswordType::class,
                'first_options'  => array(
                    'attr'=>array(
                        'class' => 'form-control',
                        'Placeholder'=>'Password'
                    ),
                ),
                'second_options' => array(
                    'attr'=>array(
                        'class' => 'form-control',
                        'Placeholder'=>'Password Check'
                    )
                ),
                'invalid_message' => 'Passwords Do Not Match',
                'second_name'=>'confirm',
                'first_name'=>'password'
            ])

            ->add('Phone_Number',IntegerType::class,array(
                'attr'=>array(
                    'class' => 'form-control adjust',
                    'Placeholder'=>'Phone Number'
                )
            ))
            ->add('Register',SubmitType::class,array(
                'attr'=>array(
                    'class' => 'btn btn-primary',
                )
            ))
            ->getForm();
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