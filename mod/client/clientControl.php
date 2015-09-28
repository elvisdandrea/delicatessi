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

        $cart = Services::get('cart');
        $cart->cartPage();
    }

    public function loginPage() {

        $this->view()->setVariable('product_id', $this->getQueryString('product_id'));
        $this->view()->loadTemplate('login');
        $this->commitReplace($this->view()->render(), '#content');
    }

    public function login() {

        $orbit = new Orbit();
        $client = $orbit->get('client/login', 1, 1, array(
            'email'     => $this->getPost('email'),
            'passwd'    => $this->getPost('passwd')
        ));

        if ($client['status'] == 200) {
            UID::set($client['uid']);
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

        //TODO: message login invalid
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
            //TODO: validar erro da API
        }

        $product_id = $this->getQueryString('product_id');

        if ($product_id) {
            $productPage = Services::get('products');
            $productPage->setId($product_id);
            $productPage->viewProduct();
            return;
        }

        $home = Services::get('home');
        $home->homePage();

    }

}