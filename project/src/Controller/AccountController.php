<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\User;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AccountType;
class AccountController extends AbstractController
{
    /**
     * @Route("/account/editInfo", name="account")
     */
    public function index1(Request $request, EntityManagerInterface $manager )
    {
        $user=$this->getUser();
        $form=$this->createForm(AccountType::class,$user);
        $formView=$form->createView();
        $form->handleRequest( $request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($user);
            $manager->flush();
        }
        return $this->render('account/account.html.twig', [
            'form' => $formView
        ]);
    }

    /**
     * @Route("/account/address", name="address")
     */
    public function index2(Request $request,EntityManagerInterface $manager)
    {
        $user=$this->getUser();
        $address= $user->getAddress();
        if(!$address){
            $address=new Address();
        }
        $form=$this->createForm(AddressType::class,$address);
        $form->handleRequest( $request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $address->addUser($user);
            $manager->persist($address);
            $manager->flush();

        }
        return $this->render('account/address.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/account/purchases", name="purchases")
     */
    public function index3()
    {
        $user=$this->getUser();
        return $this->render('account/myPurchases.html.twig');
    }
}
