<?php


class PagSeguro {

    const PAGSEGURO_URL = 'https://ws.pagseguro.uol.com.br/v2/checkout';
    //const  PAGSEGURO_URL = 'https://ws.sandbox.pagseguro.uol.com.br/v2/checkout';   // Sandbox
    const  PAYMENT_URL = 'https://pagseguro.uol.com.br/v2/checkout/payment.html';
    //const  PAYMENT_URL   = 'https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html'; //Sandbox

    private $xml;

    private $items    = array();

    private $sender   = array();

    private $shipping = array();

    private $currency  = 'BRL';

    private $reference = '';

    private $redirectUrl;

    private $notificationURL;

    private $email = '';

    private $token = '';

    private $code;

    private $response;

    public function __construct() {

        $this->xml   = new SimpleXMLElement('<checkout/>');
    }

    public function setRedirectURL($url) {

        $this->redirectUrl = $url;
    }

    public function setNotificationURL($url) {

        $this->notificationURL = $url;
    }

    public function setReference($reference) {

        $this->reference = $reference;
    }

    public function setAccountEmail($email) {

        $this->email = $email;
    }

    public function setToken($token) {

        $this->token = $token;
    }

    public function addItem($id, $description, $amount, $quantity, $weight) {

        $this->items[] = array(
            'id'            => $id,
            'description'   => $description,
            'amount'        => number_format($amount, 2),
            'quantity'      => $quantity,
            'weight'        => intval($weight)
        );

    }

    public function addSender($name, $email, $areacode, $number) {

        $this->sender = array(
            'name'      => $name,
            'email'     => $email,
            'phone'     => array(
                'areacode'  => $areacode,
                'number'    => $number
            )
        );
    }

    public function addShipping($type, $cost, $street, $number, $complement, $hood, $city, $postal_code, $state, $country = 'BRA') {

        $this->shipping = array(
            'type'      => $type,
            'cost'      => floatval(str_replace(',', '.', $cost)),
            'address'  => array(
                'street'     => $street,
                'number'     => $number,
                'complement' => $complement,
                'district'   => $hood,
                'postalcode' => $postal_code,
                'city'       => $city,
                'state'      => $state,
                'country'    => $country
            )
        );
    }

    public static function getShippingType($shipping_code) {

        $shipping_types = array(

            // SEDEX
            '40010' => '2',
            '40045' => '2',
            '40126' => '2',
            '40215' => '2',
            '40290' => '2',
            '40096' => '2',
            '40436' => '2',
            '40444' => '2',
            '40568' => '2',
            '40606' => '2',
            '81019' => '2',
            '81027' => '2',
            '81035' => '2',
            '81868' => '2',
            '81833' => '2',
            '81850' => '2',

            // PAC
            '41106' => '1',
            '41068' => '1'

        );

        $type =  '3';

        !isset($shipping_types[$shipping_code]) || $type = $shipping_types[$shipping_code];

        return $type;

    }

    public function getResponse() {

        return $this->response;
    }

    public function getCode() {

        return $this->code;
    }

    public function getXML() {

        $this->xml->addChild('currency', $this->currency);
        $items = $this->xml->addChild('items');
        foreach ($this->items as $item) {
            $itemnode = $items->addChild('item');
            foreach ($item as $node => $value) $itemnode->addChild($node, $value);
        }

        $this->xml->addChild('reference', $this->reference);

        $sender = $this->xml->addChild('sender');
        $sender->addChild('name',  $this->sender['name']);
        $sender->addChild('email', $this->sender['email']);
        $phone = $sender->addChild('phone');
        $phone->addChild('areacode', $this->sender['phone']['areacode']);
        $phone->addChild('number',   $this->sender['phone']['number']);

        $shipping = $this->xml->addChild('shipping');
        $shipping->addChild('type', $this->shipping['type']);
        $shipping->addChild('cost', $this->shipping['cost']);

        $address = $shipping->addChild('address');
        foreach ($this->shipping['address'] as $addrField => $value) {
            $address->addChild($addrField, $value);
        }

        $this->xml->addChild('redirectURL', $this->redirectUrl);
        $this->xml->addChild('notificationURL', $this->notificationURL);

        return $this->xml->asXML();

    }

    public function submit() {

        $request = new HttpHandler(self::PAGSEGURO_URL . '?email=' . $this->email . '&token=' . $this->token);
        $request->setMethod('post');
        $request->addHeader('Content-type', 'application/xml');
        $request->setBody($this->getXML());
        $request->execute();
        $response = $request->getContent(true);

        if (isset($response['code'])) {
            $this->code = $response['code'];
            return $this->code;
        } else {
            $this->response = $response;
        }

    }

    public function redirect() {

        echo Html::SetLocation(self::PAYMENT_URL . '?code=' . $this->code);
    }


}