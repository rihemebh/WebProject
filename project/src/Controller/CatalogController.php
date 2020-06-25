<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Entity\PropertySearch;
use App\Entity\SearchCategory;
use App\Entity\User;
use App\Form\PropertySearchType;
use App\Repository\LivreRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ObjectManager;


class CatalogController extends AbstractController
{

    private $repository;

    public function __construct(LivreRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @Route("/catalogue", name="catalogue")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(PaginatorInterface $paginator,Request $request)
    {
        $search=new PropertySearch();
        $form=$this->createForm(PropertySearchType::class,$search);
        $form->handleRequest($request);
        $books=$this->getDoctrine()->getRepository(Livre::class)->findAll();
        $livres_filtre=$paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
             $request->query->getInt('page', 1), 20
        );


        return $this->render('catalogue/catalogue.html.twig',[
            'filtre'=> $livres_filtre,
            'form'=>$form->createView(),
            'books'=>$books,
            ]);
    }

    /**
     * @Route("/livre/{id}",name="livre.name")
     */

    public function afficherlivre($id)
    {

        $livre = $this->getDoctrine()->getRepository(Livre::class)->find($id);
        $filtre = $this->getDoctrine()->getRepository(livre::class)
            ->findBookBy($livre->getCategories(), $id);
        return $this->render('catalogue/livre/livre.html.twig', [
            'filtre' => $filtre,
            'livre' => $livre]);
    }


    /**
     * @Route("/livre/{id}/like", name="booklike")
     * @param Livre $livre
     * @param EntityManagerInterface $manager
     * @return JsonResponse
     */

    public function like(Livre $livre, EntityManagerInterface $manager)
    {
        $user = $this->getUser();

        if (!$user) return $this->json([
            'code' => 403,
            'message' => "you have to be connected"
        ], 403);

        if ($livre->isLiked($user)) {
            $livre->removeLike($user);
            $manager->persist($livre);
            $manager->flush();
            return $this->json(['code' => 200, 'likes' => $livre->getLikes()->count()], 200);

        } else {
            $livre->addLike($user);
            $manager->persist($livre);
            $manager->flush();


          return $this->json(['code' => 200,'likes' => $livre->getLikes()->count()], 200);

        }
    }
}

