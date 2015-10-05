<?php

class contactControl extends Control {

    public function __construct() {
        parent::__construct();

    }

    public function contactPage() {

        $this->view()->loadTemplate('contact');
        $this->commitReplace($this->view()->render(), '#content');

        $location = Geolocation::getCoordinates('Evaristo da Veiga', '582', 'Canoas', '92420080', 'BR');
        Html::initGMap('map', $location['lat'], $location['lng'], 14);
        Html::addGMapMarker('map', $location['lat'], $location['lng'], '', '');

    }


    public function submit() {

        $post = $this->getPost();

        require_once LIBDIR . '/class.phpmailer.php';
        require_once LIBDIR . '/class.smtp.php';
        $mail = new PHPMailer();

        $mail->isSMTP();

        $mail->CharSet = 'utf-8';
        $mail->isHTML(true);
        $mail->SMTPDebug = 0;
        $mail->Port = 587;
        $mail->Host = 'smtp.mandrillapp.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'elvis@gravi.com.br';
        $mail->Password = 'rw4zOEmiBDFJDaGuS28hjA';
        $mail->FromName = $post['nome'];
        $mail->From = $post['email'];
        $mail->addReplyTo($post['email']);

        $mail->Subject = 'Contato delicatessi.com.br: ' . $post['nome'];
        $mail->Body =
            'Fone: ' . $post['phone'] . PHP_EOL .
            'Mensagem: ' . $post['message'];

        $mail->addAddress('atendimento@delicatessi.com.br');

        if ($mail->send()) {
            $this->commitReplace('Em breve entraremos em contato. Obrigado!', '#mailmsg');
            $this->commitShow('#mailmsg');
        } else {
            $this->commitReplace('Oh não, o serviço de e-mail está lotado! Por favor, envie um e-mail para atendimento@delicatessi.com.br e nos informe sobre isso!', '#mailmsg');
            $this->commitShow('#mailmsg');
        }



    }

}