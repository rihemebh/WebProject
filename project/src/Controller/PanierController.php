<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Services\ServicesPanier\ServicesPanier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @param ServicesPanier $pan
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/panier", name="panier")
     */
    public function index(ServicesPanier $service)
    {
        $service->prepareCart();
        return $this->render('panier/panier.html.twig');
    }

    /**
     * @param ServicesPanier $service
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/addpanier", name="add.panier")
     */
    public function addToPanier(ServicesPanier $service, Request $request)
    {
        $id = $request->get('id');
        $bol = $service->updateCart($id);
        if($bol){
            $this->addFlash('success', 'Book successfully added to cart. Go check it out ');
        } else {
            $this->addFlash('erreur', 'This is not the id of an existing book');
        }
        return $this->redirectToRoute('catalogue');
    }

    /**
     * @param ServicesPanier $service
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/deletepanier", name="delete.panier")
     */
    public function deleteFromPanier(ServicesPanier $service, Request $request)
    {
        $id = $request->get('id');
        $test = $service->deletion($id);
        if ($test == 1){
            $this->addFlash('success', 'Deletion succeded');
        }elseif ($test == 0){
            $this->addFlash('erreur', 'Book not Found');
        }elseif (($test == -1)){
            $this->addFlash('erreur', 'Empty Cart');
        }
        return $this->redirectToRoute('panier');
    }
}


