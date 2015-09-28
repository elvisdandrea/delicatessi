<?php

/**
 * Class homeControl
 *
 * This is the Home Controller
 *
 * This controller will handle the first execution.
 * This will automatically identify if the request
 * is running over ajax and will render exactly
 * what's necessary.
 *
 * In other words, if you call an action by URL,
 * this will render the whole site along with the
 * content of the action. But when the home page
 * is already loaded and you call the actions,
 * this will render the action content only and
 * will add/replace where it should.
 *
 * This is also an scaffold for you other modules.
 *
 * @author  Elvis D'Andrea
 * @email   <elvis.vista@gmail.com.br>
 */

class productsControl extends Control {

    private $orbitClient;

    /**
     * The constructor
     *
     * The parent constructor is the
     * base for the controller functionality
     *
     * This will automatically handle the instantiation
     * of the module Model and View
     */
    public function __construct() {
        parent::__construct();

        $this->orbitClient = new Orbit();
    }

    public function getRecentProducts() {

        $products = $this->orbitClient->get('product', 1, 3, false, array('sdate:desc'));
        $this->view()->loadTemplate('productresult');
        $this->view()->setVariable('products', $products['items']);
        $this->view()->setVariable('title', 'Novos Produtos');
        $this->view()->setVariable('see_all', true);

        return $this->view()->render();
    }

    public function getBestSellers() {

        $products = $this->orbitClient->get('product', 1, 3, false, array('sdate:desc'));
        $this->view()->loadTemplate('productresult');
        $this->view()->setVariable('products', $products['items']);
        $this->view()->setVariable('title', 'Mais Vendidos');
        $this->view()->setVariable('see_all', true);

        return $this->view()->render();
    }

    public function getSlider() {

        $products = $this->orbitClient->get('product', 1, 3, array('featured' => 1), false);
        $this->view()->loadTemplate('slider');
        $this->view()->setVariable('featured', $products['items']);
        return $this->view()->render();
    }

    public function getCategories() {
        return $this->orbitClient->get('category', 1, 3, false, false);

    }

    public function productsPage() {

        if ($this->getId() > 0) {
            $this->viewProduct();
            return;
        }

        $page = $this->getQueryString('page');
        $page || $page = 1;
        $rp   = $this->getQueryString('rp');
        $rp   || $rp   = 6;

        $filters = array();
        $query_filters = array(
            'category_name'
        );

        foreach($query_filters as $filterField) {
            $filtered = $this->getQueryString($filterField);
            if ($filtered) $filters[$filterField] = $filtered;
        }

        $products = $this->orbitClient->get('product', $page, $rp, $filters, array('sdate:desc'));

        $this->view()->loadTemplate('productresult');
        $this->view()->setVariable('products', $products['items']);


        $title = $products['total']['total'] . ' Produtos';
        if (intval($products['total']['total']) == 0) $title = 'Nenhum produto encontrado para esta pesquisa';
        $this->view()->setVariable('title', $title);

        $this->newView('content');
        $this->view('content')->loadTemplate('content');
        $this->view('content')->setVariable('content', $this->view()->render());
        $title = $this->getQueryString('category_name');
        $title || $title = 'Nossos Produtos';
        $this->view('content')->setVariable('title', $title);

        $this->commitReplace($this->view('content')->render(), '#content');
        $this->scrollToElement('#content');

    }

    public function getGadget($filters, $curId = '0') {

        $this->newView('gadget');
        $this->view('gadget')->loadTemplate('gadget');

        $products = $this->orbitClient->get('product', 1, 3, $filters, array('sdate:desc'));
        $this->view('gadget')->setVariable('products', $products['items']);


        $featured = $this->orbitClient->get('product', 1, 3, array('featured' => '1', 'id' => '!=' . $curId), array('sdate:desc'));
        $this->view('gadget')->setVariable('featured', $featured['items']);

        return $this->view('gadget')->render();
    }

    public function viewProduct() {

        $result  = $this->orbitClient->get('product/' . $this->getId());
        $product = $result['items'];

        $this->view()->loadTemplate('detail');
        $this->view()->setVariable('product', $product);


        $filters = array(
            'category_name' => $product['category_name'],
            'id'            => '!=' . $product['id']
        );

        $this->view()->setVariable('gadget', $this->getGadget($filters, $product['id']));

        $this->newView('content');
        $this->view('content')->loadTemplate('content');
        $this->view('content')->setVariable('title', $product['product_name']);
        $this->view('content')->setVariable('content', $this->view()->render());
        $this->commitReplace($this->view('content')->render(), '#content');
        $this->scrollToElement('#content');
    }

    public function addToCart() {

        if (!UID::isLoggedIn()) {
            $client = Services::get('client');
            $client->register();
            return;
        }

        $orbit   = new Orbit();
        $request = $orbit->get('request/cart', 1, 1, array('client_id' => UID::get('id')));


        if (!isset($cart['cart']) || $cart['cart'] == 0 ) {
            $request = $orbit->post('request/addcart', array(
                'client_id' => UID::get('id')
            ));

            if ($request['status'] != 200) {
                //TODO: validar erro de criação de carrinho
            }
        }

        $cart = $request['cart'];

        $item = $orbit->post('request/additem', array(
            'request_id'    => $cart['id'],
            'product_id'    => $this->getQueryString('product_id')
        ));

        $cartPage = Services::get('cart');
        $cartPage->updateCounter();
        $cartPage->cartPage();

    }

}