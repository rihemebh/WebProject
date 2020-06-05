<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AccountType;
use App\Entity\User;
class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     */
    public function index()
    {
        $user=new User();
        $form=$this->createForm(AccountType::class,$user);
        $formView=$form->createView();
        return $this->render('account/account.html.twig', [
            'form' => $formView,
        ]);
    }
}
