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
        $form = $this->createForm(PayementType::class);
        $view = $form->createView();
        return $this->render('payement/meeting.html.twig' , [
            'formview' => $view
            ]);
}
}
