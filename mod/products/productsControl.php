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

        $products = $this->orbitClient->getProducts(1, 3, false, array('sdate:desc'));
        $this->view()->loadTemplate('productresult');
        $this->view()->setVariable('products', $products['items']);
        $this->view()->setVariable('title', 'Novos Produtos');
        return $this->view()->render();
    }

    public function getBestSellers() {

        $products = $this->orbitClient->getProducts(1, 3, false, array('sdate:desc'));
        $this->view()->loadTemplate('productresult');
        $this->view()->setVariable('products', $products['items']);
        $this->view()->setVariable('title', 'Mais Vendidos');
        return $this->view()->render();
    }

    public function getSlider() {

        $this->view()->loadTemplate('slider');
        return $this->view()->render();
    }



}