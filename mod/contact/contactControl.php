<?php

class contactControl extends Control {

    public function __construct() {
        parent::__construct();

    }

    public function contactPage() {

        $this->view()->loadTemplate('contact');
        $this->commitReplace($this->view()->render(), '#content');

        $location = Geolocation::getCoordinates('Evaristo da Veiga', '582', 'Canoas', '92420080', 'BR');
        Html::initGMap('map', $location['lat'], $location['lng'], 8);

    }
}