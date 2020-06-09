<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\User;
use App\Form\AddressType;
use App\Form\ResetType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AccountType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/account/editInfo", name="account")
     */
    public function index1(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = $this->getUser();
        $form = $this->createForm(AccountType::class, $user);
        $reset = $this->createForm(ResetType::class, $user);
        $reset->handleRequest($request);
        $form->handleRequest($request);
        if ($reset->isSubmitted()) {
            $old_pwd = $reset->get('oldPassword')->getData();
            $new_pwd = $reset->get('Password')->get('New')->getData();
            $checkPass = $encoder->isPasswordValid($user, $old_pwd);
            if ($checkPass === true) {
                $hash = $encoder->encodePassword($user, $new_pwd);
                $user->setPassword($hash);
                $manager->persist($user);
                $manager->flush();
                $this->addFlash('notice', 'Password Successfully Updated !');

            } else {
                $reset->get('oldPassword')->addError(new FormError('Incorrect Password'));
            }
        }

        if ($form->isSubmitted()) {
            {
                if ($form->isValid()) {
                    $manager->persist($user);
                    $manager->flush();
                }
            }
        }
        return $this->render('account/account.html.twig', [
            'form' => $form->createView(),
            'reset' => $reset->createView()
        ]);
    }

    /**
     * @Route("/account/address", name="address")
     */
    public function index2(Request $request, EntityManagerInterface $manager)
    {
        $user = $this->getUser();
        $form = $this->createForm(AddressType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $ad = '';
            foreach ($data as $key => $value) {
                $ad = $ad . $value . ' ';
            }
            $ad = trim($ad);
            $user->setAddress($ad);
            $manager->persist($user);
            $manager->flush();

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
    public function deleteAddress( EntityManagerInterface $manager)
    {
        $user = $this->getUser();;
        $form = $this->createForm(AddressType::class);
            $user->setAddress(null);
            $manager->persist($user);
            $manager->flush();
         return $this->redirectToRoute('address');

    }
}