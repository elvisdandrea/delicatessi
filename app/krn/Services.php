<?php


class Services {

    private static $services = array();


    public static function get($service) {

        if (isset(self::$services[$service])) return self::$services[$service];

        $class = $service . 'Control';

        if (class_exists($class)) {
            self::$services[$service] = new $class();
            return self::$services[$service];
        }

        throw new ExceptionHandler('Service ' . $service . ' not found');

    }

}