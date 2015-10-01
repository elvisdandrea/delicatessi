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
        $addresses = $orbit->get('client/addresslist/' . UID::get('id'), 1, 100);

        $this->view()->setVariable('cartItems', $cartItems['cart']);
        $this->view()->setVariable('addresses', $addresses['address']);
        $this->view()->loadTemplate('cart');
        $this->commitReplace($this->view()->render(), '#content');
    }

    public function updateCounter() {
        $orbit = new Orbit();
        $cartRequest = $orbit->get('client/countcart', 1, 1, array('id' => UID::get('id')));
        $cartItems   = $cartRequest['cart'];

        $this->commitReplace($cartItems, '#cartitems');

    }

    public function getZipAddress() {
        $address = Correios::SearchByZip($this->getPost('cep'));
        $this->view()->loadTemplate('resultzip');
        $this->view()->setVariable('address', $address);
        $this->commitReplace($this->view()->render(), '#resultzip');
    }

    public function addAddress() {

        $post = $this->getPost();

        $post['address_type'] = 'Residencial';

        $orbit = new Orbit();
        $result = $orbit->post('client/addclientaddr/' . UID::get('id'), $post);

        $address = $post;
        $address['id'] = $result['address_id'];
        $this->commitReplace('', '#resultzip');
        $this->view()->loadTemplate('addressoption');
        $this->view()->setVariable('address', $address);
        $this->commitAdd($this->view()->render(), '#addresslist');
    }

    public function shippingPrice() {

        if (intval($this->getQueryString('id')) == 0) {
            $this->commitReplace('', '#shippingoptions');
            $this->commitReplace('(escolha um endereço para entrega)', '#totalprice');
            $this->commitReplace('(escolha um endereço para entrega)', '#shippingprice');
            return;
        }

        $orbit   = new Orbit();
        $result  = $orbit->get('client/address/' . $this->getQueryString('id'));
        $address = $result['address'];
        $zip_to  = $address['zip_code'];

        $source    = $orbit->get('stations');
        $station   = current($source['station']);
        $zip_from  = $station['zip_code'];

        $shipping = Correios::GetShippingPrice($zip_from, $zip_to, 1, 20, 20, 20);

        $shipping_options = $shipping['cServico'];
        UID::set('shipping_options', $shipping_options);

        $this->view()->loadTemplate('shippingoptions');
        $this->view()->setVariable('shipping_options', $shipping_options);
        $this->commitReplace($this->view()->render(), '#shippingoptions');

    }

    public function selshipping() {
        $ship   = $this->getQueryString('id');

        $option         = UID::get('shipping_options', $ship);
        $shippingPrice  = $option['Valor'];

        $orbit     = new Orbit();
        $request   = $orbit->get('client/cartitems', 1, 100, array('id' => UID::get('id')));
        $cartItems = $request['cart'];

        $orderPrice = 0;

        foreach ($cartItems as $item) {
            $orderPrice += $item['price'];
        }

        $totalPrice = $orderPrice + $shippingPrice;

        $this->commitReplace(String::convertTextFormat($totalPrice, 'currency'), '#totalprice');
        $this->commitReplace(String::convertTextFormat($shippingPrice, 'currency'), '#shippingprice');


    }

    public function purchase() {

        $shipping   = UID::get('shipping_options', $this->getPost('shipping_option'));
        $address_id = $this->getPost('address_id');

        if (!$shipping) {
            //TODO: Retornar mensagem shipping error
        }

        $shipping_fields = array(
            'Codigo'            => 'shipping_code',
            'Valor'             => 'shipping_value',
            'PrazoEntrega'      => 'delivery_time',
            'ValorMaoPropria'   => 'hand_value',
            'ValorAvisoRecebimento' => 'notify_value',
            'ValorValorDeclarado'   => 'recover_value',
            'EntregaDomiciliar'     => 'home_delivery',
            'EntregaSabado'         => 'weekend_delivery'
        );

        $orbit      = new Orbit();
        $request    = $orbit->get('request/cart', 1, 1, array('client_id' => UID::get('id')));

        if (!isset($request['cart']) || $request['cart'] === 0) {
            //TODO: retornar erro no carrinho
        }

        $cart       = $request['cart'];

        foreach ($shipping_fields as $key => $field) {
            $purchase[$field] = $shipping[$key];
        }

        $purchase   = $orbit->post('request/purchase', array(
            'client_id'     => UID::get('id'),
            'request_id'    => $cart['id'],
            'address_id'    => $address_id
        ));

        debug($purchase);

        //TODO: direcionar para pagSeguro

    }

    public function remove() {

        $orbit  = new Orbit();

    }

}