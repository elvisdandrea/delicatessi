<?php


class clientControl extends Control {

    public function __construct() {
        parent::__construct();
    }

    public function clientPage() {

        if (!UID::isLoggedIn()) {
            $this->loginPage();
            return;
        }

        $orbit  = new Orbit();
        $address = $orbit->get('client/addresslist/' . UID::get('id'));

        $phones  = $orbit->get('client/phones/' . UID::get('id'));

        $this->view()->setVariable('profile', UID::get());
        $this->view()->loadTemplate('profile');
        $this->view()->setVariable('addressList', $address['address']);
        $this->view()->setVariable('phoneList', $phones['phones']);

        $this->commitReplace($this->view()->render(), '#content');
    }

    public function loginPage() {

        $this->view()->setVariable('product_id', $this->getQueryString('product_id'));
        $this->view()->loadTemplate('login');
        $this->commitReplace($this->view()->render(), '#content');
    }

    public function login($email = false, $passwd = false) {

        $email  || $email  = $this->getPost('email');
        $passwd || $passwd = $this->getPost('passwd');

        $orbit = new Orbit();
        $client = $orbit->get('client/login', 1, 1, array(
            'email'     => $email,
            'passwd'    => $passwd
        ));

        if ($client['status'] == 200) {

            $phones = $orbit->get('client/phones/' . $client['uid']['id']);
            UID::set($client['uid']);
            UID::set('phones', $phones['phones']);


            $orbit = new Orbit();
            $favRequest  = $orbit->get('client/countfav', 1, 1, array('id' => UID::get('id')));
            $favs        = $favRequest['fav'];
            $cartRequest = $orbit->get('client/countcart', 1, 1, array('id' => UID::get('id')));
            $carts       = $cartRequest['cart'];

            $this->commitReplace($carts, '#cartitems');
            $this->commitReplace($favs,  '#favitems');

            $product_id = $this->getQueryString('product_id');

            if ($product_id) {
                $productPage = Services::get('products');
                $productPage->setId($product_id);
                $productPage->viewProduct();
                return;
            }

            $home = Services::get('home');
            $home->homePage();
            return;
        }

        $this->commitReplace('O e-mail e senha não foram encontrados', '#loginmsg');
        $this->commitShow('#loginmsg');
    }

    public function register() {


        $this->view()->setVariable('product_id', $this->getQueryString('product_id'));
        $this->view()->loadTemplate('register');
        $this->commitReplace($this->view()->render(), '#content');
    }

    public function registerClient() {

        if (!$this->validatePost('client_name', 'phone_number', 'email', 'passwd', 'retype_passwd')) {
            $this->commitFormInvalid('#registration_form');
        }

        $fields = array(
            'client_name', 'client_lastname', 'phone_number', 'email', 'passwd'
        );

        $data = array();
        foreach ($fields as $field)
            $data[$field] = $this->getPost($field);

        $data['phone_type']  = 'Residencial';
        $data['client_type'] = 'F';

        $orbit  = new Orbit();
        $client = $orbit->post('client/addclient', $data);

        if ($client['status'] != 200) {
            $this->commitReplace($client['message'], '#loginmsg');
            $this->commitShow('#loginmsg');
        }

        $this->login();

    }

    public function removeAddr() {
        $id = $this->getQueryString('id');

        $orbit = new Orbit();
        $orbit->delete('client/address/' . $id);

        $this->clientPage();

    }

    public function favs() {

        if (!UID::isLoggedIn()) {
            $this->loginPage();
            return;
        }

        $orbit    = new Orbit();
        $result   = $orbit->get('client/favouriteitems/' . UID::get('id'));
        $favItems = $result['favourites'];

        $this->view()->loadTemplate('favs');
        $this->view()->setVariable('favItems', $favItems);
        $this->commitReplace($this->view()->render(), '#content');
    }

    public function orders() {

        if (!UID::isLoggedIn()) {
            $this->loginPage();
            return;
        }

        $orbit    = new Orbit();
        $result   = $orbit->get('client/orders/' . UID::get('id'));
        $orders   = $result['orders'];

        $this->view()->loadTemplate('orders');
        $this->view()->setVariable('orders', $orders);

        $this->commitReplace($this->view()->render(), '#content');

    }

}