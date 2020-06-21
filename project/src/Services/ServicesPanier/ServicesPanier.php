<?php


namespace App\Services\ServicesPanier;


use App\Repository\LivreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ServicesPanier
{

    protected $session;

    protected $livreRep;


    public function __construct(SessionInterface $ses, LivreRepository $liv)
    {
        $this->session = $ses;
        $this->livreRep = $liv;
    }

    public function prepareCart (){
        if (!$this->session->has('panier')) {
            $panier = [];
            $this->session->set('panier', $panier);
            $tot = 0;
        } else {
            $panier = $this->session->get('panier');
            if($panier != null)
            {
                $tot = 0;
                foreach ($panier as $id => $liv){
                    $tot += $liv->getPrix();
                }
            }
            else{
                $tot = 0;
            }
        }
        $this->session->set('total', $tot);
    }

    public function updateCart($id)
    {
        if ($id) {
            $livre = $this->livreRep->find($id);
            $panier = ($this->session->has('panier')) ? $this->session->get('panier') : null;
            $panier["$id"] = $livre;
            $this->session->set('panier', $panier);
            return true;
        } else {
            return false;
        }
    }

    public function deletion ($id){
        if ($this->session->has('panier')) {
            $panier = $this->session->get('panier');
            if (isset($panier["$id"])) {
                unset($panier["$id"]);
                $this->session->set('panier', $panier);
                return 1;
            } else {
                return 0;
            }
        } else {
            return -1;
        }
    }

}