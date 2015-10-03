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
        $asoption = '';
        if ($this->getQueryString('asoption')) $asoption = '?asoption=1';
        $this->view()->loadTemplate('resultzip');
        $this->view()->setVariable('address', $address);
        $this->view()->setVariable('asoption', $asoption);
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

        $asOption = $this->getQueryString('asoption');

        if ($asOption) {
            $tpl = 'addressoption';
        } else {
            $tpl = 'addressitem';
        }

        $this->view()->loadTemplate($tpl);
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

        $orbit      = new Orbit();
        $shipping   = UID::get('shipping_options', $this->getPost('shipping_option'));
        $address_id = $this->getPost('address_id');

        $hash = String::generateHash();

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

        $clientAddr = $orbit->get('client/address/' . $address_id);
        $address    = $clientAddr['address'];

        $request    = $orbit->get('request/cart', 1, 1, array('client_id' => UID::get('id')));

        if (!isset($request['cart']) || $request['cart'] === 0) {
            //TODO: retornar erro no carrinho
        }

        $cart       = $request['cart'];

        $purchaseData = array();
        foreach ($shipping_fields as $key => $field) {
            $purchaseData[$field] = $shipping[$key];
        }

        $purchaseData = array_merge($purchaseData, array(
            'client_id'     => UID::get('id'),
            'request_id'    => $cart['id'],
            'address_id'    => $address_id
        ));

        $requestItems = $orbit->get('client/cartitems', 1, 100, array('id' => UID::get('id')));
        //TODO: validar erro na request
        $cartItems    = $requestItems['cart'];

        $pagSeguro = new PagSeguro();

        foreach ($cartItems as $item) {
            //TODO: Quantidade variável
            $pagSeguro->addItem($item['id'], $item['product_name'], $item['price'], '1', $item['weight']);
        }

        $pagSeguro->addSender('Bruna Conter', 'atendimento@delicatessi.com.br','51', '31150338');

        $pagSeguro->addShipping(
            PagSeguro::getShippingType($purchaseData['shipping_code']),
            $purchaseData['shipping_value'],
            $address['street_addr'],
            $address['street_number'],
            $address['street_additional'],
            $address['hood'],
            $address['city'],
            $address['zip_code'],
            $address['state']
        );

        $pagSeguro->setReference($hash);
        $pagSeguro->setRedirectURL('http://localhost/delicatessi/cart/confirmed?order=' . $hash);
        $pagSeguro->setAccountEmail('brunaconter@hotmail.com');
        $pagSeguro->setToken('807795BB8CBE4C2F98B4ED804C352EA0');


        UID::set('purchase_data', $hash, $purchaseData);
        $orbit->put('request/' . $cart['id'], array('pay_hash' => $hash));

        $pagSeguro->submit();

    }

    public function confirmed() {

        $hash = $this->getQueryString('order');

        $orbit = new Orbit();
        $purchaseData = UID::get('purchase_data', $hash);
        $purchase   = $orbit->post('request/purchase', $purchaseData);

        $this->view()->loadTemplate('confirmed');
        $this->commitReplace($this->view()->render(), '#content');
    }

    public function remove() {

        $orbit  = new Orbit();

    }

}