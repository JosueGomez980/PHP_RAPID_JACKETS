<?php

require_once 'cargar_clases3.php';
AutoCarga3::init();

class EmailManager {

    const DEFAULT_EMAIL = "creacionesjulieth123@gmail.com";
    const DEFAULT_PASS = "losjaponeses123";
    const DEFAULT_NAME_FROM = "Creaciones Julieth -- RapidJackets";
    const DEFAULT_HOST = "smtp.gmail.com";
    const SMTP_OPTS = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
    ));
    public static $instancia = null;
    private $mail;
    private $userAccount;
    private $password;
    private $addressList = array();
    private $nameFrom;
    
    public static function getInstancia(){
        if(is_null(self::$instancia)){
            self::$instancia = new EmailManager();
        }
        return self::$instancia;
    }
}
