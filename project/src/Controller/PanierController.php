<?php

namespace App\Controller;

use App\Entity\Livre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     */
    public function index(SessionInterface $session)
    {
        if (!$session->has('panier')) {
            $panier = null;
            $session->set('panier', $panier);
            $tot = 0;
        } else {
            $panier = $session->get('panier');
            $tot = 0;
            foreach ($panier as $id => $livre) {
                $tot += $livre->getPrix();
            }
        }
        $session->set('total', $tot);
        return $this->render('panier/panier.html.twig');
    }

    /**
     * @param SessionInterface $session
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/addpanier", name="add.panier")
     */
    public function addToPanier(SessionInterface $session, Request $request)
    {
        $id = $request->get('id');

        if ($id) {
            $rep = $this->getDoctrine()->getRepository(Livre::class);
            $livre = $rep->find($id);
            $panier = ($session->has('panier')) ? $session->get('panier') : null;
            $panier["$id"] = $livre;
            $session->set('panier', $panier);
            $this->addFlash('success', 'Le Livre choisi est ajouté à votre panier avec succé. Veuillez la consulter');
        } else {
            $this->addFlash('erreur', 'Livre inexistant');
        }
        return $this->redirectToRoute('catalogue');
    }

    /**
     * @param SessionInterface $session
     * @param Request $request
     * @Route("/deletepanier", name="delete.panier")
     */
    public function deleteFromPanier(SessionInterface $session, Request $request)
    {
        $id = $request->get('id');
        if ($session->has('panier')) {
            $panier = $session->get('panier');
            if (isset($panier["$id"])) {
                unset($panier["$id"]);
                $session->set('panier', $panier);
                $this->addFlash('success', 'La suppression du livre de la panier est éffectuée avec succé');
            } else {
                $this->addFlash('erreur', 'Livre inéxistant dans la panier');
            }
        } else {
            $this->addFlash('erreur', 'Votre panier est vide');
        }
        return $this->redirectToRoute('panier');
    }

    /**
     * @Route("/payement",name= "payement")
     */
    public function index2()
    {
        if ($this->getUser()) {
            return $this->render('panier/payement.html.twig');
        } else {
            $this->addFlash('warning', 'You need to be connected to continue this process');
            return $this->redirectToRoute('app_login');
        }

    }


}


