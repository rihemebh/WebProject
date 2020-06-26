<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Entity\Payement;
use App\Form\PayementType;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Swift_Image;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
     * @param LivreRepository $liv
     * @param Request $req
     * @param SessionInterface $session
     * @param EntityManagerInterface $manager
     * @param Swift_Mailer $mailer
     * @return RedirectResponse|Response
     * @Route("/payement/meeting",name="set_meeting")
     */
    public function timePicking(LivreRepository $liv, Request $req, SessionInterface $session, EntityManagerInterface $manager, Swift_Mailer $mailer)
    {
        $user = $this->getUser();
        if ($user) {
            $panier = $session->get('panier');
            $total = $session->get('total');
            if ($total != 0) {
                $pay = new Payement();
                $form = $this->createForm(PayementType::class, $pay);
                $view = $form->createView();
                try {
                    $form->handleRequest($req);
                } catch (\Exception $e) {
                    echo "failed : " . $e->getMessage();
                }
                if ($form->isSubmitted() and $form->isValid()) {
                    $ident = md5(uniqid());
                    $pay->setNumPayement($ident);
                    $pay->setForUser($user);
                    $pay->setTypePayement('meeting');
                    $books = [];
                    foreach ($session->get('panier') as $id => $livre) {
                        $book = $liv->find($id);
                        $namebook = $book->getNomLivre();
                        $prix = $book->getPrix();
                        $books[] = [
                            'prix' => $prix,
                            'nom' => $namebook
                        ];
                        $manager->remove($book);
                    }
                    $pay->setBooks($books);
                    $manager->persist($pay);
                    $manager->flush();

                    $session->remove('panier');
                    $session->remove('total');

                    $message = (new \Swift_Message('Meeting Reminder'));
                    $message->setFrom('cheikh@gmail.com')
                        ->setTo($user->getEmail())
                        ->setBody(
                            $this->renderView('payement/mailremainder.html.twig',
                                [
                                    'username' => $user->getUserName(),
                                    'image_src' => $message->embed(Swift_Image::fromPath('C:\xampp\htdocs\WebProject\project\public\mail3.jpg'))

                                ]),
                            'text/html'
                        );

                    $mailer->send($message);

                    $this->addFlash('success', 'Check you Email! the Meeting is confirmed');
                    return $this->redirectToRoute('acceuil');
                }

            } else {
                $this->addFlash('erreur', 'your Cart is Empty');
                return $this->redirectToRoute('catalogue');
            }

        } else {
            $this->addFlash('erreur', 'You should be loged into an account');
            return $this->redirectToRoute('app_login');
        }
        return $this->render('payement/meeting.html.twig', [
            'formview' => $view
        ]);
    }

    /**
     * @return Response
     * @Route("/payement/confirm_adress", name="confirmad")
     */
    public function confirmadress(Swift_Mailer $mailer)
    {
        return $this->render('payement/mailremainder.html.twig');

    }
}
