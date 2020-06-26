<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Services\ServicesPanier\ServicesPanier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @param ServicesPanier $service
     * @return Response
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
     * @Route("/addpanier", name="add.panier")
     * @return JsonResponse
     */
    public function addToPanier(ServicesPanier $service, Request $request)
    {
        $id = $request->get('id');
        $bol = $service->updateCart($id);
        if($bol){
            return $this->json(['code' => 200, 'message' => "book successfully added to cart"], 200);
        } else {
            return $this->json(['code' => 200, 'message' => "This is not the id of an existing book"], 200);
        }

    }

    /**
     * @param ServicesPanier $service
     * @param Request $request
     * @return RedirectResponse
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


