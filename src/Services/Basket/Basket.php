<?php

namespace App\Services\Basket;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Basket implements BasketInterface
{

    public function __construct(
        private SessionInterface $session
    )
    {}
    public function add($id)
    {
        $cart = $this->session->get('cart', []);
        if(!empty($cart[$id])){
            $cart[$id] ++;
        }else{
            $cart[$id]  = 1;
        }
        $this->session->set('cart',$cart);
    }
    public function get()
    {
        return $this->session->get('cart');
    }
    public function remove()
    {
        return $this->session->remove('cart');
    }
    public function delete($id)
    {
        $cart = $this->session->get('cart' , []);
        unset($cart[$id]);
        return $this->session->set('cart' , $cart);
    }
    public function decrease($id)
    {
        $cart = $this->session->get('cart',[]);
        if($cart[$id] >  1){
            //retirer une quantité
            $cart[$id]--;
        }else{
            //suprimer totalement le produit du panier
            unset($cart[$id]);
        }
        return  $this -> session -> set('cart' , $cart);
    }


}