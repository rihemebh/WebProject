<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Comment;
use App\Entity\Livre;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommentRepository;
use Faker\Factory;


class AcceuilController extends AbstractController
{

    private $repository;
    public function __construct(CommentRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
    * @Route("/", name="acceuil")
    */
    public function index(Request $request,Request $requestSearch, EntityManagerInterface $manager, PaginatorInterface $paginator)
    {
        /*Categories DB*/
        $repositoryCategories = $this->getDoctrine()->getRepository(Categorie::class);
        $category=$repositoryCategories->findAll();
        $nbreCategories=$repositoryCategories->count([]);

        /*Comments DB*/
        $page = $request->query->get('page') ?? 1;
        $repository = $this->getDoctrine()->getRepository(Comment::class);
        $nbEnregistrements = $repository->count(array());
        //$nbPages = ($nbEnregistrements % 5) ? ($nbEnregistrements / 5) + 1 : ($nbEnregistrements / 5);
        //$messages = $repository->findBy([], array('id' => 'desc'),5, ($page - 1) *5);
        $messages=$paginator->paginate(
            $this->repository->findAll(),
            $request->query->getInt('page', 1), 20
        );

        /*Comment form*/
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $now = new \DateTime();
            $comment->setDate($now);

            /*Generate Random String*/
            $input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $strength = 8;
            $input_length = strlen($input);
            $random_string = '';
            for ($i = 0; $i < $strength; $i++) {
                $random_character = $input[mt_rand(0, $input_length - 1)];
                $random_string .= $random_character;
            }

            /*************************/
            $faker = Factory::create();
            $comment->setPublisher("user" . "#" . $random_string);
            $comment->setLikes(0);
            $comment->setAvatar($faker->imageUrl($width = 640, $height = 480));
            $manager->persist($comment);
            $manager->flush();
        }

        /*Search*/
        $repository=$this->getDoctrine()->getRepository(Livre::class);
        if (($requestSearch->isMethod('post'))&&$requestSearch->get('search_input')) {
            $input = $requestSearch->get('search_input');
            $books=$repository->search($input);
            return $this->render('acceuil/acceuil.html.twig', [
                'book' => $books,
                'input' => $input,

                'msg' => $messages,
                'form' => $form->createView(),

                'catogory'=>$category,
                'nbrCategories'=>$nbreCategories
            ]);
        }
        else{
            return $this->render('acceuil/acceuil.html.twig', [
                'msg' => $messages,

                'form' => $form->createView(),

                'catogory'=>$category,
                'nbrCategories'=>$nbreCategories
            ]);
        }
    }


//    /**
//     * @Route("/search", name="search")
//     */
//    public function search(Request $requestSearch)
//    {
//        $repository=$this->getDoctrine()->getRepository(Livre::class);
//        if ($requestSearch->isMethod('post')) {
//            $input = $requestSearch->get('search_input');
//            $books=$repository->search($input);
//            return $this->render('acceuil/acceuil.html.twig', [
//                'book' => $books,
//                'input' => $input
//            ]);
//        }
//        else{
//            return $this->redirectToRoute('acceuil');
//        }
//    }
}
