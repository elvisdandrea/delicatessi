<?php


class Correios {

    const CORREIOS_API_URL      = 'https://viacep.com.br/ws/';

    const CORREIOS_API_FORMAT   = '/json';

    const CORREIOS_SHIPPING_URL = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx';

    private static $request;


    public static function SearchByZip($cep) {

        $url = self::CORREIOS_API_URL . $cep . self::CORREIOS_API_FORMAT;
        self::$request = new HttpHandler($url);
        self::$request->execute();

        return json_decode(self::$request->getContent(), true);

    }

    public static function SearchByAddress($logradouro, $cidade, $uf) {

        $endereco = $uf . '/' . $cidade . $logradouro;
        $url = self::CORREIOS_API_URL . $endereco . self::CORREIOS_API_FORMAT;
        self::$request = new HttpHandler($url);
        self::$request->execute();

        return json_decode(self::$request->getContent(), true);

    }

    public static function GetShippingPrice($zip_from, $zip_to, $weight, $length, $height, $width, $diameter = 0, $onHands = false, $notify = false, $recoverValue = 0) {


        $data = array(
            'sCepOrigem'        => $zip_from,
            'sCepDestino'       => $zip_to,
            'nVlPeso'           => intval($weight),
            'nCdFormato'        => 1,
            'nVlComprimento'    => $length,
            'nVlAltura'         => $height,
            'nVlLargura'        => $width,
            'nVlDiametro'       => $diameter,
            'sCdMaoPropria'     => $onHands ? 's' : 'n',
            'nVlValorDeclarado'     => intval($recoverValue),
            'sCdAvisoRecebimento'   => $notify ? 's' : 'n',
            'nCdServico'            => '40010, 41106',
            'StrRetorno'            => 'xml'
        );

        #debug(self::CORREIOS_SHIPPING_URL . '?' . http_build_query($data));

        self::$request = new HttpHandler(self::CORREIOS_SHIPPING_URL);
        self::$request->setParams($data);
        self::$request->execute();

        $response = json_decode(json_encode(simplexml_load_string(self::$request->getContent())), true);

        return $response;

    }

    public static function GetService($service) {

        $services = array(

            '40010' => 'SEDEX',
            '40045' => 'SEDEX a Cobrar, sem contrato.',
            '40126' => 'SEDEX a Cobrar, com contrato.',
            '40215' => 'SEDEX 10',
            '40290' => 'SEDEX Hoje, sem contrato.',
            '40096' => 'SEDEX com contrato.',
            '40436' => 'SEDEX com contrato.',
            '40444' => 'SEDEX com contrato.',
            '40568' => 'SEDEX com contrato.',
            '40606' => 'SEDEX com contrato.',
            '41106' => 'PAC',
            '41068' => 'PAC com contrato.',
            '81019' => 'e-SEDEX, com contrato.',
            '81027' => 'e-SEDEX Prioritário, com conrato.',
            '81035' => 'e-SEDEX Express, com contrato.',
            '81868' => '(Grupo 1) e-SEDEX, com contrato.',
            '81833' => '(Grupo 2) e-SEDEX, com contrato.',
            '81850' => '(Grupo 3) e-SEDEX, com contrato.'

        );

        if (isset($services[$service]))
            return $services[$service];

        return '';

    }

}