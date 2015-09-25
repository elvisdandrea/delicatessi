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

        $this->loadAthentication();

        $this->request->setURI('apilogin');

        $this->request->addParam('id',     $this->id);
        $this->request->addParam('secret', $this->secret);
        $this->request->execute();

        $result = json_decode($this->request->getContent(), true);

        if (isset($result['access_token'])) {
            $this->authentication = $result;
            Session::set('authentication', $this->authentication);
        }

    }

    private function loadAthentication() {

        $authFile = IFCDIR . '/data/' . md5(ORBIT_ID);
        if (!file_exists($authFile)) return;

        $content = file_get_contents($authFile);
        $content = CR::decrypt($content);
        $data    = json_decode($content, true);

        if (!$data) return;

        foreach (array('id', 'secret') as $item)
            if (!isset($data[$item])) return;
            else $this->$item = $data[$item];

    }

    private function checkTokenAlive() {
        //TODO: method to check if token is alive
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

    /**
     *
     *
     * @param   int         $page
     * @param   int         $rp
     * @param   bool|array  $filters
     * @param   bool|array  $order
     * @return  mixed
     */
    public function getProducts($page = 1, $rp = 10, $filters = false, $order = false) {

        $this->request->clearParams();
        $this->request->setURI('product');
        $this->request->addParam('token', $this->getToken());

        foreach (array('filters', 'order') as $operation) {
            if ($$operation) {
                foreach ($$operation as $opField => $opValue) {
                    $this->request->addParam($opField, $opValue);
                }
            }
        }

        $this->request->addParam('page', $page);
        $this->request->addParam('rp',   $rp);
        $this->request->execute();

        $content = json_decode($this->request->getContent(), true);
        return $content;
    }


}