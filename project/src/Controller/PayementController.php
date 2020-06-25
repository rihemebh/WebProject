<?php

namespace App\Controller;

use App\Form\PayementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PayementController extends AbstractController
{
    /**
     * @Route("/payement",name= "payement")
     */
    public function index()
    {
        if ($this->getUser()) {
            return $this->render('payement/payement.html.twig');
        } else {
            $this->addFlash('warning', 'You need to be connected to continue this process');
            return $this->redirectToRoute('app_login');
        }

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/meeting",name="aafat")
     */
    public function timePicking(){
        $user = $this->getUser();
        if($user){
            $form = $this->createForm(PayementType::class);
            $view = $form->createView();
        } else {
            $this->addFlash('erreur', 'You should be loged into an account');
            return $this->redirectToRoute('app_login');
        }
        return $this->render('payement/meeting.html.twig' , [
            'formview' => $view
            ]);
}
}
