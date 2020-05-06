<?php

namespace App\Controller;

use App\Entity\Livre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LivreController extends AbstractController
{


    /**
     * @Route("/livre", name="livre")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Livre::class);
        $livres=$repo->findAll();
        return $this->render('catalogue/catalogue.html.twig', [
            'livres' => $livres,
        ]);
    }
}
