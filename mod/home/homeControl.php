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

class homeControl extends Control {

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
    }


    /**
     * The home page
     *
     * This is where the "magic" happens
     *
     * Always drop a $page_content in your templates
     * so this function can manage to put the content
     * of the action when it's not an ajax request.
     *
     * Prefer a different variable name? Just rename it.
     *
     * @param   array   $uri        - The URI array
     */
    public function itStarts($uri = array()) {

        $this->view()->loadTemplate('home');

        if (count($uri) == 0)
            $uri = array(MAIN);

        $this->view()->setVariable('page_header', $this->getHeader());

        $content = Core::getMethodContent($uri);
        $this->view()->setVariable('page_content', $content);

        $this->view()->appendJs('home');

        echo $this->view()->render();
        echo $this->view()->injectJSFiles();
        
        $this->terminate();
    }

    private function getHeader() {

        $products = Services::get('products');
        $favs  = '0';
        $carts = '0';
        if (UID::isLoggedIn()) {
            $orbit = new Orbit();
            $favRequest  = $orbit->get('client/countfav', 1, 1, array('id' => UID::get('id')));
            $favs        = $favRequest['fav'];
            $cartRequest = $orbit->get('client/countcart', 1, 1, array('id' => UID::get('id')));
            $carts       = $cartRequest['cart'];
        }

        $this->newView('header');
        $this->view('header')->loadTemplate('header');
        $this->view('header')->setVariable('favs',  $favs);
        $this->view('header')->setVariable('carts', $carts);
        $categories = $products->getCategories();
        $this->view('header')->setVariable('categories', $categories['items']);

        return $this->view('header')->render();
    }

    /**
     * When returning the home page, loads the inner content only
     *
     * You can always create a modulePage function that
     * is called when the module is called without an action.
     */
    public function homePage() {

        $products = Services::get('products');

        $blocks = array(
            'slider'        => $products->getSlider(),
            'recent'        => $products->getRecentProducts(),
            'bestsellers'   => $products->getBestSellers()
        );

        $products->view()->loadTemplate('home');
        foreach ($blocks as $var => $block)
            $products->view()->setVariable($var, $block);


        $products->view()->appendJs('home');
        $products->commitReplace($products->view()->render(), '#content', true);
    }

    /**
     * When an ajax Method is not found
     *
     * @param   array       $url        - The URL in case you need
     */
    public function notFound($url) {

        $this->view()->setVariable('url', $url);
        $this->commitReplace($this->view()->get404(), '#content');
    }


}