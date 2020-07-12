<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Entity\Payement;
use App\Form\AddressType;
use App\Form\PayementType;
use App\Repository\LivreRepository;
use App\ServiceValidate\address;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Css\Stylesheet;
use Dompdf\Dompdf;
use Dompdf\Options;
use Swift_Image;
use Swift_Mailer;
use Swift_Message;
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
                    $totallll= 0;
                    foreach ($session->get('panier') as $id => $livre) {
                        $book = $liv->find($id);
                        $namebook = $book->getNomLivre();
                        $prix = $book->getPrix();
                        $pathBook= $book->getPath();
                        $authorBook = $book->getAuteur();
                        $books[] = [
                            'author' => $authorBook,
                            'path'=> $pathBook,
                            'prix' => $prix,
                            'nom' => $namebook
                        ];
                        $totallll+=$prix;
                        $manager->remove($book);
                    }
                    $pay->setBooks($books);
                    $manager->persist($pay);
                    $manager->flush();

                    $session->remove('panier');
                    $session->remove('total');

                    $message = (new Swift_Message('Meeting Reminder'));
                    $message->setFrom('cheikh@gmail.com')
                        ->setTo($user->getEmail())
                        ->setBody(
                            $this->renderView('payement/mailremainder.html.twig',
                                [
                                    'username' => $user->getUserName(),
                                    'image_src' => $message->embed(Swift_Image::fromPath('D:\xampp\htdocs\Final\WebProject\project\public\mail3.jpg'))

                                ]),
                            'text/html'
                        );

                    $mailer->send($message);
                    //pdf making
                    $pdfOptions = new Options();
                    $pdfOptions->set('defaultFont', 'Arial');

                    // Instantiate Dompdf with our options
                    $dompdf = new Dompdf($pdfOptions);

                    // Retrieve the HTML generated in our twig file
                    $html = $this->renderView('payement/facturepdf.html.twig',
                        [
                            'payement' => $pay,
                            'total' => $totallll,
                            'type' => 'By Meating'
                        ]);

                    // Load HTML to Dompdf
                    $dompdf->loadHtml($html);

                    // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
                    $dompdf->setPaper('A4', 'portrait');

                    // Render the HTML as PDF
                    $dompdf->render();

                    // Output the generated PDF to Browser (force download)
                    $dompdf->stream("facture.pdf", [
                        "Attachment" => true
                    ]);

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
    public function confirmadress(address $make, Request $request, EntityManagerInterface $manager,
                                  Swift_Mailer $mailer, LivreRepository $liv, SessionInterface $session)
    {
        $user = $this->getUser();
        if(!$user){
            $this->addFlash('erreur', 'You should be loged into an account');
            return $this->redirectToRoute('app_login');
        } else{
            $form = $this->createForm(AddressType::class);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $user->setAddress($make->create($form));
                $manager->persist($user);

                $pay = new Payement();

                $ident = md5(uniqid());
                $pay->setNumPayement($ident);
                $pay->setForUser($user);
                $pay->setTypePayement('Par Post');
                $books = [];
                $totallll= 0;
                foreach ($session->get('panier') as $id => $livre) {
                    $book = $liv->find($id);
                    $namebook = $book->getNomLivre();
                    $prix = $book->getPrix();
                    $pathBook= $book->getPath();
                    $authorBook = $book->getAuteur();
                    $books[] = [
                        'author' => $authorBook,
                        'path'=> $pathBook,
                        'prix' => $prix,
                        'nom' => $namebook
                    ];
                    $totallll+=$prix;
                    $manager->remove($book);
                }
                $pay->setBooks($books);
                $date = date('d/m/Y');
                $time = date('H:i');
                $pay->setDatePayement($date);
                $pay->setTimePayement($time);
                $manager->persist($pay);
                $this->addFlash('success', 'Address Updated  !');
                $manager->flush();

                $session->remove('panier');
                $session->remove('total');

                $message = (new Swift_Message('Meeting Reminder'));
                $message->setFrom('cheikh@gmail.com')
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->renderView('payement/mailremainder2.html.twig',
                            [
                                'username' => $user->getUserName(),
                                'image_src' => $message->embed(Swift_Image::fromPath('C:\xampp\htdocs\WebProject\project\public\mail3.jpg'))

                            ]),
                        'text/html'
                    );

                $mailer->send($message);

                //pdf making
                $pdfOptions = new Options();
                $pdfOptions->set('defaultFont', 'Arial');

                // Instantiate Dompdf with our options
                $dompdf = new Dompdf($pdfOptions);

                // Retrieve the HTML generated in our twig file
                $html = $this->renderView('payement/facturepdf.html.twig',
                [
                    'payement' => $pay,
                    'total' => $totallll,
                    'type' => 'By Post'
                ]);

                // Load HTML to Dompdf
                $dompdf->loadHtml($html);

                // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
                $dompdf->setPaper('A4', 'portrait');

                // Render the HTML as PDF
                $dompdf->render();

                // Output the generated PDF to Browser (force download)
                $dompdf->stream("facture.pdf", [
                    "Attachment" => true
                ]);
                $this->addFlash('success', 'Check you Email! the Meeting is confirmed');
                return $this->redirectToRoute('acceuil');
            }

        }

        $address = $user->getAddress();
        return $this->render('payement/confirmad.html.twig', [
            'form' => $form->createView(),
            'address' => $address
        ]);
    }

    /**
     * @return Response
     * @Route("/fac", name="fact")
     */
    public function testingpdf(){
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html =$this->renderView('payement/facturepdf.html.twig',
            ['field' =>'field1',
                'books'=>[1,2]]
        );


        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A3', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();


        // Output the generated PDF to Browser (force download)
        $dompdf->stream('facture.pdf', [
            "Attachment" => false
        ]);
        dd();
    }

}
