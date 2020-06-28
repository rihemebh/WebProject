<?php

namespace App\Controller;


use App\Form\AddressType;
use App\Form\ResetType;
use App\Form\UserType;
use App\ServiceValidate\address;
use Couchbase\Document;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/account/editInfo", name="account")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function index1( Request $request, EntityManagerInterface $manager)
    {

        $user = $this->getUser();
        if ($user->getActivationToken()) return $this->redirectToRoute('confirm');
        else {
            $reset=$this->createForm(ResetType::class);
            $form = $this->createForm(UserType::class, $user);
            $form->remove('Register');
            $form->remove('Password');
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                {
                    $this->addFlash('success', 'Changes Saved !');
                    $manager->persist($user);
                    $manager->flush();
                }
            }
            return $this->render('account/account.html.twig', [
                'form' => $form->createView(),
                'reset' => $reset->createView()
            ]);
        }
    }


/**
 * @Route("/account/change", name="change")
 */
public function index2(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
{

    $user=$this->getUser();
    if(!$user) return $this->redirectToRoute('app_login');
    if ($user->getActivationToken())  return $this->redirectToRoute('confirm');
        $reset = $this->createForm(ResetType::class);
    $form = $this->createForm(UserType::class, $user);
    $form->remove('Register');
    $form->remove('Password');
    $reset->handleRequest($request);
    // pour pouvoir montrer l erreur Incorrect Password on doit le traiter en de hors du isValid puisqu'il n'y pas de contraintes
    //equalTo à l'interieur de ResetType
    // Aussi ce bloc de code sert à rendre l 'affichage des erreurs plus comprehensible
    if( $reset->get('oldPass')->getData())
    {
        $checkPass = $encoder->isPasswordValid($user, $reset->get('oldPass')->getData());
    if(!$checkPass)   $reset->get('oldPass')->addError(new FormError("Incorrect Password"));
    }

    if ($reset->isValid()) {
                $hash = $encoder->encodePassword($user, $reset->get('newPassword')->get('new')->getData());
                $user->setPassword($hash);
                $manager->persist($user);
                $manager->flush();
                $this->addFlash('success', 'Password Successfully Updated !');
        }
        return $this->render('account/account.html.twig', [
        'form' => $form->createView(),
        'reset' => $reset->createView()
    ]);
}


    /**
     * @Route("/account/address", name="address")
     */
    public function index5(address $make,Request $request, EntityManagerInterface $manager,address $ad)
    {
        $user = $this->getUser();
        if ($user->getActivationToken())  return $this->redirectToRoute('confirm');
        $form = $this->createForm(AddressType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setAddress($make->create($form));
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Address Updated  !');

        }
        $address = $user->getAddress();

        return $this->render('account/address.html.twig', [
            'form' => $form->createView(),
            'address' => $address
        ]);
    }


    /**
     * @Route("/account/deleteAddress", name="deleteAddress")
     */
    public function deleteAddress(EntityManagerInterface $manager)
    {
        $user = $this->getUser();
        if(!$user) return $this->redirectToRoute('app_login');
        if ($user->getActivationToken())  return $this->redirectToRoute('confirm');
        $user->setAddress(null);
        $manager->persist($user);
        $manager->flush();
        $this->addFlash('success', 'Address Deleted  !');
        return $this->redirectToRoute('address');

    }

}