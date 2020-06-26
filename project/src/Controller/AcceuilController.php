<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Comment;
use App\Entity\Livre;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AcceuilController extends AbstractController
{
    /**
     * @Route("/", name="acceuil")
     */
    public function index(Request $request,Request $requestSearch, EntityManagerInterface $manager)
    {
        /*Categories DB*/
        $repositoryCategories = $this->getDoctrine()->getRepository(Categorie::class);
        $category=$repositoryCategories->findAll();
        $nbreCategories=$repositoryCategories->count([]);

        /*Comments DB*/
        $page = $request->query->get('page') ?? 1;
        $repository = $this->getDoctrine()->getRepository(Comment::class);
        $nbEnregistrements = $repository->count(array());
        $nbPages = ($nbEnregistrements % 2) ? ($nbEnregistrements / 2) + 1 : ($nbEnregistrements / 2);
        $messages = $repository->findBy([], array('id' => 'desc'), 2, ($page - 1) * 2);

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
            $comment->setPublisher("user" . "#" . $random_string);
            $comment->setLikes(0);
            $comment->setAvatar('avatar');
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
                'nbPage' => $nbPages,
                'form' => $form->createView(),

                'catogory'=>$category,
                'nbrCategories'=>$nbreCategories
            ]);
        }
        else{
            return $this->render('acceuil/acceuil.html.twig', [
                'msg' => $messages,
                'nbPage' => $nbPages,
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
