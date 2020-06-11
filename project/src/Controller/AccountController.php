<?php

namespace App\Controller;


use App\Form\AddressType;
use App\Form\ResetType;
use App\Form\UserType;
use App\ServiceValidate\address;
use App\ServiceValidate\newValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/account/editInfo", name="account")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function index1( Request $request, EntityManagerInterface $manager,newValidator $validator)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->remove('Register');
        $form->remove('Password');
        $validator->validform($form);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()  ) {
            {
                dd($form->isValid());
                $this->addFlash('success', 'Changes Saved !');
                $manager->persist($user);
                $manager->flush();
            }
        }
        return $this->render('account/account.html.twig', [
            'form' => $form->createView(),
        ]);
    }


/**
 * @Route("/account/change", name="change")
 */
public function index2(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
{

    $user=$this->getUser();
    $reset=$request->request;
    $checkPass = $encoder->isPasswordValid($user, $reset->get('old'));

    if ($checkPass === true) {
        if($reset->get('new')=== $reset->get('confirm'))
            if($reset->get('new')>=8){
            $hash = $encoder->encodePassword($user, $reset->get('new'));
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Password Successfully Updated !');
        }
        else{
            $this->addFlash('alert', 'Password Too Short  !');
        }
        else{ $this->addFlash('alert', 'Passwords Do Not Match  !');}
    } else {
        $this->addFlash('alert', 'Password Incorrect !');
    }
    return $this->redirectToRoute('account');

}


    /**
     * @Route("/account/address", name="address")
     */
    public function index5(address $make,Request $request, EntityManagerInterface $manager)
    {
        $user = $this->getUser();
        $form = $this->createForm(AddressType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() ) {
            if ($make->create($form) === "")
                 $this->addFlash('warning', 'Please Enter An Address Before Saving !');
            else{
                $user->setAddress($make->create($form));
                $manager->persist($user);
                $manager->flush();
                $this->addFlash('success', 'Address Updated  !');
            }
        }
        $address = $user->getAddress();

        return $this->render('account/address.html.twig', [
            'form' => $form->createView(),
            'address' => $address
        ]);
    }

    /**
     * @Route("/account/purchases", name="purchases")
     */
    public function index3()
    {
        $user = $this->getUser();
        return $this->render('account/myPurchases.html.twig');
    }


    /**
     * @Route("/deleteAddress", name="deleteAddress")
     */
    public function deleteAddress(EntityManagerInterface $manager)
    {
        $user = $this->getUser();
        $user->setAddress(null);
        $manager->persist($user);
        $manager->flush();
        $this->addFlash('success', 'Address Deleted  !');
        return $this->redirectToRoute('address');

    }

}