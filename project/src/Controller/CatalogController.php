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

    public function afficherlivre (Livre $livre)
    {
        $books=$this->getDoctrine()->getRepository(Livre::class)->findAll();
        $filtre = $this->getDoctrine()->getRepository(livre::class)
            ->findBookBy($livre->getCategories(), $livre->getId());
        return $this->render('catalogue/livre/livre.html.twig', [
            'filtre' => $filtre,
            'livre' => $livre,
            'books'=>$books,
            ]);
    }

    /**
     * @Route("/wishlist/{id}")
     * @param User $user
     * @return Response
     */
    public function wishlist (User $user){
        $books=$this->getDoctrine()->getRepository(Livre::class)->findAll();
<<<<<<< HEAD
        //$user1=$this->getUser()->getUsername();
        //$user=$this->getDoctrine()->getRepository(User::class)->findOneBy(["User_Name"=>$user1]);
        return $this->render('wishlist.html.twig', [
=======
        return $this->render('account/wishlist.html.twig', [
>>>>>>> 541b21871f6e3c0020440098b032e91fc4ed5c47
            'books'=>$books,
            'user'=>$user,

        ]);
}
    /**
     * @param Livre $livre
     * @param EntityManagerInterface $manager
     * @route("/wishlist/remove/{id}")
     * @return JsonResponse
     */
public function RemoveWishList (Livre $livre, EntityManagerInterface $manager){

    $user = $this->getUser();

    $livre->removeLike($user);
    $manager->persist($livre);
    $manager->flush();

    return $this->json(['code' => 200, "message" => "card deleted"], 200);

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

