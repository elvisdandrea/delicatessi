<?php


class Orbit {

    private $id;

    private $secret;

    private $authentication;

    private $url;

    private $request;

    public function __construct() {

        $this->url      = 'http://api.orbit.gravi.com.br/';
        $this->request  = new HttpHandler($this->url);
        $this->request->addHeader('accept', 'application/json');
        $this->LoadApi();
    }

    private function LoadApi() {

        $this->authentication = Session::get('authentication');

        if (!isset($this->authentication['access_token'])) $this->apiLogin();

        $expires = new DateTime($this->getTokenExpire());
        $now     = new DateTime();

        if ($now > $expires) $this->apiLogin();

    }

    private function apiLogin() {

        $this->request->setURI('apilogin');

        $this->request->addParam('id', '2');
        $this->request->addParam('secret', '66273c23bc4a31c3291148d9d704165d');
        $this->request->execute();

        $result = json_decode($this->request->getContent(), true);

        if (isset($result['access_token'])) {
            $this->authentication = $result;
            Session::set('authentication', $this->authentication);
        }

        return false;

    }

    public function getToken() {

        if (isset($this->authentication['access_token']))
            return $this->authentication['access_token'];

        return false;
    }

    public function getTokenExpire() {

        if (isset($this->authentication['expires']))
            return $this->authentication['expires'];

        return false;
    }

    public function getUid() {

        if (isset($this->authentication['uid']))
            return $this->authentication['uid'];

        return false;
    }

    public function getCompanyId() {

        if (isset($this->authentication['company_id']))
            return $this->authentication['company_id'];

        return false;
    }

    public function getProducts() {
        
    }


}