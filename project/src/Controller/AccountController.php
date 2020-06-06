<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AccountType;
use App\Entity\User;
class AccountController extends AbstractController
{
    /**
     * @Route("/account/editInfo", name="account")
     */
    public function index1()
    {
        $user=$this->getUser();
        $form=$this->createForm(AccountType::class,$user);
        $formView=$form->createView();
        return $this->render('account/account.html.twig', [
            'form' => $formView
        ]);
    }

    /**
     * @Route("/account/address", name="address")
     */
    public function index2()
    {
        $user=$this->getUser();
        return $this->render('account/address.html.twig');
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
