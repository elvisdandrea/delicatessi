<?php

class cartControl extends Control {

    public function __construct() {
        parent::__construct();
    }

    public function cartPage() {

        if (!UID::isLoggedIn()) {
            $login = Services::get('client');
            $login->loginPage();
            return;
        }

        $orbit = new Orbit();
        $cartItems = $orbit->get('client/cartitems', 1, 100, array('id' => UID::get('id')));
        $this->view()->setVariable('cartItems', $cartItems['cart']);
        $this->view()->loadTemplate('cart');
        $this->commitReplace($this->view()->render(), '#content');
    }

    public function updateCounter() {
        $orbit = new Orbit();
        $cartRequest = $orbit->get('client/countcart', 1, 1, array('id' => UID::get('id')));
        $cartItems   = $cartRequest['cart'];

        $this->commitReplace($cartItems, '#cartitems');

    }

}