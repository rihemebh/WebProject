<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Livre;
use App\Entity\Payement;
use App\Entity\PropertySearch;
use App\Entity\User;
use App\Form\BookSearchType;
use App\Form\CategoryType;
use App\Form\LivreType;
use App\Form\PayementType;
use App\Form\PropertySearchType;
use App\Form\SearchType;
use App\Form\UserType;
use App\Repository\CategorieRepository;
use App\Repository\PayementRepository;
use App\Repository\UserRepository;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;


/**
 * Class AdminController
 * @package App\Controller
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{

    private $bookRepository;
    private $userRepository;
    private $categoryRepository;
    private $orderRepository;

    public function __construct(LivreRepository $repository1,UserRepository $repository2,CategorieRepository $repository3,PayementRepository $repository4)
    {
        $this->bookRepository = $repository1;
        $this->userRepository = $repository2;
        $this->categoryRepository = $repository3;
        $this->orderRepository = $repository4;
    }


    /**
     * @Route("/", name="")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @route("/users", name="users")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */

    public function userList(PaginatorInterface $paginator,Request $request)
    {   $search=new PropertySearch();
        $form=$this->createForm(SearchType::class,$search);
        $form->handleRequest($request);
        $users=$this->getDoctrine()->getRepository(User::class)->findAll();
        $users_filter=$paginator->paginate(
            $this->userRepository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1), 20
        );


        return $this->render('admin/user/user.html.twig',[
            'filtre'=> $users_filter,
            'form'=>$form->createView(),
            'users'=>$users,
        ]);
   }
    /**
     * @Route("/users/edit/{id?0}", name="edit_user")
     */
    public function editUser(Request $request, User $user = null, EntityManagerInterface $manager) {
        if (!$user) {
            $user=  new User();
        }
        $form = $this->createForm(UserType::class, $user);
        $form->remove('Password');
        $form->remove('Register');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'User edited successfully');
            return $this->redirectToRoute('admin_users');
        }
        return $this->render('admin/user/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }
    /**
     * @Route("/users/delete/{id}", name="delete_user")
     */
    public function deleteUser(User $user = null)
    {
        if (!$user) {
            $this->addFlash('error', "this user doesn't exist");
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($user);
            $manager->flush();
            $this->addFlash('success', 'User deleted successfully');
        }
        return $this->redirectToRoute('admin_users');
    }

    /**
     * @route("/livres", name="livres")
     *
     */
    public function booksList(PaginatorInterface $paginator,Request $request)
    {

        $search=new PropertySearch();
        $form=$this->createForm(BookSearchType::class,$search);
        $form->handleRequest($request);
        $books=$this->getDoctrine()->getRepository(Livre::class)->findAll();
        $livres_filtre=$paginator->paginate(
            $this->bookRepository->findAllByTitle($search),
            $request->query->getInt('page', 1), 20
        );


        return $this->render('admin/livre/livre.html.twig',[
            'filter'=> $livres_filtre,
            'form'=>$form->createView(),
            'books'=>$books,
        ]);
    }
    /**
     * @Route("/livres/edit/{id?0}", name="livres_edit")
     */
   public function editLivre(Request $request, Livre $livre = null, EntityManagerInterface $manager) {
       if (!$livre) {
           $livre=  new Livre();
       }

       $form = $this->createForm(LivreType::class, $livre);
       $form->remove('DatePub');
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
           $image =$form['image']->getData();
           if($form['image']){
               $imagePath = md5(uniqid()).$image->getClientOriginalName();
               $destination = __DIR__.'/../../../public/assets/uploads';
               $image->move($destination,$imagePath);
               try {
                   $image->move($destination,$imagePath);
                   $livre->setPath('public/assets/uploads/'.$imagePath);
               } catch (FileException $exception) {
                   echo $exception;
               }
           }
           $manager->persist($livre);
           $manager->flush();
           return $this->redirectToRoute('admin_livres');
       }
       return $this->render('admin/livre/ajout.html.twig', array(
           'Livreform' => $form->createView()
       ));
    }
    /**
     * @Route("livres/delete/{id}", name="livres_delete")
     */
    public function deleteLivre(Livre $livre = null)
    {
        if (!$livre) {
            $this->addFlash('error', "this book doesn't exist");
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($livre);
            $manager->flush();
            $this->addFlash('success', 'the book is deleted');
        }
        return $this->redirectToRoute('admin_livres');
    }

    /**
     * @route("/categories", name="categories")
     *
     */
    public function categoriesList(PaginatorInterface $paginator,Request $request)
    {   $search=new PropertySearch();
        $form=$this->createForm(PropertySearchType::class,$search);
        $form->handleRequest($request);
        $categories=$paginator->paginate(
            $this->categoryRepository->findAll(),
            $request->query->getInt('page', 1), 20
        );


        return $this->render('admin/category/category.html.twig', [
            'categories' => $categories,
            'form'=>$form->createView(),
        ]);
   }
    /**
     * @Route("categories/edit/{id?0}", name="categories_edit")
     */
    public function editCategory(Request $request,Categorie $category = null, EntityManagerInterface $manager)
    {

        if (!$category) {
            $category=  new Categorie();
        }

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $image =$form['image']->getData();
            if($form['image']){
                $imagePath = md5(uniqid()).$image->getClientOriginalName();
                $destination = __DIR__.'/../../../public/assets/uploads';
                $image->move($destination,$imagePath);
                try {
                    $image->move($destination,$imagePath);
                    $category->setPath('public/assets/uploads/'.$imagePath);
                } catch (FileException $exception) {
                    echo $exception;
                }
            }
            $manager->persist($category);
            $manager->flush();
            return $this->redirectToRoute('admin_categories');
        }
        return $this->render('admin/category/edit.html.twig', array(
            'Categoryform' => $form->createView()
        ));
    }
    /**
     * @Route("categories/delete/{id}", name="categories_delete")
     */
    public function deleteCategory(Categorie $category = null)
    {
        if (!$category) {
            $this->addFlash('error', "this category doesn't exist");
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($category);
            $manager->flush();
            $this->addFlash('success', 'the category is deleted');
        }
        return $this->redirectToRoute('admin_categories');
    }
//    /**
//     * @route("/bills", name="bills")
//     *
//     */
//    public function billsList(PaginatorInterface $paginator,Request $request)
//    {   $search=new PropertySearch();
//        $form=$this->createForm(PropertySearchType::class,$search);
//        $form->handleRequest($request);
//        $bills=$paginator->paginate(
//            $this->FactureRepository->findAll(),
//            $request->query->getInt('page', 1), 20
//        );
//
//
//        return $this->render('admin/order/order.html.twig', [
//            'order' => $bills,
//            'form'=>$form->createView(),
//        ]);
//    }
    /**
    //     * @route("/orders", name="orders")
    //     *
    //     */
    public function ordersList(PaginatorInterface $paginator,Request $request)
    {
        $search=new PropertySearch();
        $form=$this->createForm(PropertySearchType::class,$search);
        $form->handleRequest($request);
        $orders = $paginator
            ->paginate($this
                ->getDoctrine()
                ->getRepository(Payement::class)
                ->findAll(),
                $request->query->getInt('page', 1), 20
            );

        return $this->render('admin/order/order.html.twig', [
            'orders' => $orders,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("orders/delete/{id}", name="orders_delete")
     */
    public function deleteBill(Bill $order = null)
    {
        if (!$order) {
            $this->addFlash('error', "this order doesn't exist");
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($order);
            $manager->flush();
            $this->addFlash('success', 'the order is deleted');
        }
        return $this->redirectToRoute('admin_orders');
    }
}

