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

        $cartItems = $orbit->get('client/cartitems', 1, 100, array('id' => UID::get('id')));
        $cart      = $cartItems['cart'];

        $weigth   = 0;
        $width    = 0;
        $height   = 0;
        $diameter = 0;
        $length   = 0;

        foreach ($cart as $item) {
            $width    += $item['width'];
            $height   += $item['height'];
            $diameter += $item['diameter'];
            $length   += $item['length'];
            $weigth   += $item['weight'];
        }

        $height > 20 || $height = 20;
        $width  > 20 || $width  = 20;
        $length > 20 || $length = 20;
        $diameter || $diameter = 0;

//        debug(array(
//            $height,
//            $width,
//            $length,
//            $weigth,
//            $diameter
//        ));

        $shipping = Correios::GetShippingPrice($zip_from, $zip_to, 1, $length, $height, $width, $diameter);

        $shipping_options = $shipping['cServico'];
        UID::set('shipping_options', $shipping_options);

        $this->view()->loadTemplate('shippingoptions');
        $this->view()->setVariable('shipping_options', $shipping_options);
        $this->commitReplace($this->view()->render(), '#shippingoptions');

    }

    public function selshipping() {

        $ship   = $this->getQueryString('id');

        $option         = UID::get('shipping_options', $ship);
        $shippingPrice  = floatval(str_replace(',','.',$option['Valor']));

        $orbit     = new Orbit();
        $request   = $orbit->get('client/cartitems', 1, 100, array('id' => UID::get('id')));
        $cartItems = $request['cart'];

        $orderPrice = 0.0;

        foreach ($cartItems as $item) {
            $orderPrice += floatval($item['price']);
        }

        $totalPrice = $orderPrice + $shippingPrice;

        $this->commitReplace(String::convertTextFormat($totalPrice, 'currency'), '#totalprice');
        $this->commitReplace(String::convertTextFormat($shippingPrice, 'currency'), '#shippingprice');


    }

    public function purchase() {

        $orbit      = new Orbit();
        $shipping   = UID::get('shipping_options', $this->getPost('shipping_option'));
        $address_id = $this->getPost('address_id');

        if (!$address_id) {
            $this->commitReplace('Informe o endereço de entrega', '#submitmsg');
            $this->commitShow('#submitmsg');
            return;
        }

        $hash = String::generateHash();

        if (!$shipping) {
            $this->commitReplace('Informe o tipo de envio', '#submitmsg');
            $this->commitShow('#submitmsg');
            return;
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
            $this->commitReplace('Ocorreu um problema na sua sessão. Faça o login novamente.', '#submitmsg');
            $this->commitShow('#submitmsg');
            return;
        }

        $cart       = $request['cart'];

        $purchaseData = array();
        foreach ($shipping_fields as $key => $field) {
            $purchaseData[$field] = $shipping[$key];
        }

        $requestItems = $orbit->get('client/cartitems', 1, 100, array('id' => UID::get('id')));
        //TODO: validar erro na request
        $cartItems    = $requestItems['cart'];

        $pagSeguro = new PagSeguro();
        $totalPrice = 0;

        foreach ($cartItems as $item) {
            //TODO: Quantidade variável
            $pagSeguro->addItem($item['id'], $item['product_name'], $item['price'], '1', $item['weight']);
            $totalPrice += $item['price'];
        }

        $totalPrice +=  floatval(str_replace(',', '.', $shipping['Valor']));

        $purchaseData['client_id'] = UID::get('id');
        $purchaseData['request_id'] = $cart['id'];
        $purchaseData['address_id'] = $address_id;
        $purchaseData['pay_hash'] = $hash;
        $purchaseData['price'] = $totalPrice;

        $config = $orbit->get('config');
        $config = current($config['config']);

        $pagSeguro->addSender($config['sender_name'], $config['sender_email'],$config['sender_area_code'], $config['sender_phone']);

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
        $pagSeguro->setRedirectURL(MAINURL . '/cart/confirmed?order=' . $hash);
        $pagSeguro->setAccountEmail($config['payment_account']);
        $pagSeguro->setToken($config['token']);


        UID::set('purchase_data', $hash, $purchaseData);

        $code = $pagSeguro->submit();

        if ($code) {
            $response = $orbit->put('request/' . $cart['id'], array('pay_hash' => $hash, 'pay_token' => $code));
            $pagSeguro->redirect();
        }

        $submit = $pagSeguro->getResponse();

        if (isset($submit['error'])) {
            $this->commitReplace('Não foi possível iniciar a transação. Por favor, entre em contato conosco e nos informe: ' . $submit['error']['message'],'#submitmsg');
            $this->commitShow('#submitmsg');
        }

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

        $item_id = $this->getQueryString('item_id');

        $orbit  = new Orbit();
        $orbit->delete('request/item/' . $item_id);

        $this->cartPage();

    }

}