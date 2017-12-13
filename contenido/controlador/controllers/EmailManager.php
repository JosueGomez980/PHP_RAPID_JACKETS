<?php

//require_once 'cargar_clases3.php';
//AutoCarga3::init();

class EmailManager {

    const SJ_PASS_RE = "Recuperación de Contraseña";
    const SJ_ACC_VERIF = "Verificación de Correo Electrónico";
    const SJ_ACC_ACT = "Activación de cuenta";
    const SJ_FACT_PDF = "Envío de Factura electronica.";
    const SJ_PED_UPDATE = "Información acerca de tu pedido";
    const SJ_PED_OK = "Tu pedido se completó. Gracias por tu compra";
    const DEFAULT_EMAIL = "creacionesjulieth123@gmail.com";
    const DEFAULT_PASS = "losjaponeses123";
    const DEFAULT_NAME_FROM = "Creaciones Julieth -- RapidJackets";
    const DEFAULT_HOST = "smtp.gmail.com";
    const ADR_LIMIT = 99;
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
    private $subjet;
    private $addressList = array();
    private $nameFrom;
    private $contenido;
    private $address;
    private $htmlCont;
    private $altCont;

    public static function getInstancia() {
        if (is_null(self::$instancia)) {
            self::$instancia = new EmailManager();
        }
        return self::$instancia;
    }

    public function __construct() {
        $this->mail = new PHPMailer();
        $this->initDefault(self::SMTP_OPTS);
    }

    public function html($htmlText) {
        $this->mail->isHTML(true);
        $this->htmlCont = $htmlText;
        $this->contenido = $htmlText;
        $this->mail->Body = $htmlText;
        $this->mail->msgHTML($htmlText);
    }

    public function initDefault(array $smtpOps) {
        $this->mail->isSMTP();
        $this->mail->CharSet = "UTF-8";
        $this->userAccount = $this->mail->Username = self::DEFAULT_EMAIL;
        $this->password = $this->mail->Password = self::DEFAULT_PASS;
        $this->mail->Host = self::DEFAULT_HOST;
        $this->mail->SMTPAuth = true;
        if (is_null($smtpOps) || empty($smtpOps)) {
            $this->mail->SMTPSecure = "tls";
            $this->mail->Port = 587;
        } else {
            $this->mail->SMTPSecure = "tls";
            $this->mail->Port = 587;
            $this->mail->SMTPOptions = self::SMTP_OPTS;
        }
        $this->nameFrom = $this->mail->setFrom(self::DEFAULT_EMAIL, self::DEFAULT_NAME_FROM);
    }

    public function addAddress($email) {
        if (count($this->addressList) < self::ADR_LIMIT) {
            $this->addressList[] = $email;
            return $this->mail->addAddress($email);
        }
        return false;
    }

    public function oneAddress($email) {
        $this->mail->clearAddresses();
        $this->mail->addAddress($email);
        $this->address = $email;
    }

    public function colocarListaEmails(array $emails) {
        $this->mail->clearAddresses();
        $numEmails = count($emails);
        $numOk = 0;
        foreach ($emails as $em) {
            if ($this->mail->addAddress($em)) {
                $numOk++;
            }
        }
        return ($numEmails == $numOk);
    }

    public function getUserAccount() {
        return $this->userAccount;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getSubjet() {
        return $this->subjet;
    }

    public function getAddressList() {
        return $this->addressList;
    }

    public function getNameFrom() {
        return $this->nameFrom;
    }

    public function getContenido() {
        return $this->contenido;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getHtmlCont() {
        return $this->htmlCont;
    }

    public function getAltCont() {
        return $this->altCont;
    }

    public function setUserAccount($userAccount) {
        $this->userAccount = $userAccount;
        $this->mail->Username = $userAccount;
    }

    public function setPassword($password) {
        $this->password = $password;
        $this->mail->Password = $password;
    }

    public function setSubjet($subjet) {
        $this->subjet = $subjet;
        $this->mail->Subject = $subjet;
    }

    public function setAddressList(array $addressList) {
        $this->addressList = $addressList;
        return $this->colocarListaEmails($addressList);
    }

    public function setNameFrom($nameFrom) {
        $this->nameFrom = $nameFrom;
        $this->mail->setFrom($this->userAccount, $nameFrom);
    }

    public function setContenido($contenido) {
        $this->contenido = $contenido;
        $this->mail->Body = $contenido;
    }

    public function setHtmlCont($htmlCont) {
        $this->htmlCont = $htmlCont;
        $this->mail->msgHTML($htmlCont);
    }

    public function setAltCont($altCont) {
        $this->altCont = $altCont;
        $this->mail->AltBody = $altCont;
    }

    public function enviar() {
        $ok = false;
        try {
            if ($this->mail->send()) {
                $ok = true;
            } else {
                echo($this->mail->ErrorInfo);
                $ok = false;
            }
        } catch (phpmailerException $exc) {
            echo $exc->getMessage();
            $ok = false;
        } catch (Exception $ec) {
            echo($exc->getMessage());
            $ok = false;
        }
        return $ok;
    }

}
