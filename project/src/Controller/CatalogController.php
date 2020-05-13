<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\LivreRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController{

private $repository;
private $request;

 public function __construct(LivreRepository $repository)
{   $this->repository=$repository;}



    /**
     * @Route("/catalogue", name="catalogue")
     */
    public function index(PaginatorInterface $paginator,Request $request)
    {   $search=new PropertySearch();
        $form=$this->createForm(PropertySearchType::class,$search);
        $form->handleRequest($request);
        $repo = $this->getDoctrine()->getRepository(Livre::class);
        $nbPage= ($repo->count(array())%16)? ($repo->count(array())/16)+1 : ($repo->count(array())/16) ;
         $livres_filtre=$paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page',1),16
        );



        return $this->render('catalogue/catalogue.html.twig',[

            'nbPage'=>$nbPage,
            'filtre'=> $livres_filtre,
            'form'=>$form->createView(),
            ]);
    }

    /**
     * @Route("/livre/{id}",name="livre.name")
     */

    public function afficherlivre($id) {

        $livre = $this->getDoctrine()->getRepository(Livre::class)->find($id);

        return $this->render('catalogue/livre/livre.html.twig', [
            'livre'=>$livre]);
    }
}
