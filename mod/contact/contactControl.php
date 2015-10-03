<?php

class contactControl extends Control {

    public function __construct() {
        parent::__construct();

    }

    public function contactPage() {
        $this->view()->loadTemplate('contact');
        $this->commitReplace($this->view()->render(), '#content');
    }
}