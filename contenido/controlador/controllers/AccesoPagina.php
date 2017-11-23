<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccesoPagina
 *
 * @author Josué Francisco
 */
final class AccesoPagina {

    public static $instancia = NULL;

    const INICIO = "inicio.php";
    const IN_SESION = "iniciar_sesion.php";
    const PRODUCTOS = "productos.php";
    const ABT_US = "sobre_nosotros.php";
    const US_SIGN_IN = "registro_usuarios.php";
    const CONTC = "contacto.php";
    const PER_DATA = "configurar_cuenta.php";
    const GES_INVT = "gestion_inventarios.php";
    const NEG_TO_INICIO = "../../inicio.php";
    const NEG_TO_IN_SESION = "../../iniciar_sesion.php";
    const NEG_TO_PRODUCTOS = "../../productos.php";
    const NEG_TO_ABT_US = "../../sobre_nosotros.php";
    const NEG_TO_CONTC = "../../registro_usuarios.php";
    const NEG_TO_PER_DATA = "../../configurar_cuenta.php";
    const NEG_TO_CART_GES = "../../gestion_carrito.php";
    const NEG_TO_ADM_PN_GST_PRO = "../../gestion_productos.php";
    const NEG_TO_ADM_PN_GST_CAT = "../../gestion_categorias.php";
    const NEG_TO_ADM_PN_GST_USR = "../../gestion_usuarios_crud.php";
    const NEG_TO_ADM_PN_GST_INV = "../../gestion_inventarios.php";

    public static function getInstacia() {
        if (is_null(self::$instancia)) {
            self::$instancia = new AccesoPagina();
        }
        return self::$instancia;
    }

    public function comprobarSesion($destino) {
        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;
        if (!$sesion->existe(Session::US_LOGED)) {
            $modal = new ModalSimple();
            $neutral = new Neutral();
            $neutral->setValor("No has iniciado Sesión. Debes iniciar Sesion para acceder");
            $modal->addElemento($neutral);
            $modal->setClosebtn("Aceptar");
            $sesion->add(Session::NEGOCIO_RTA, $modal);
            $this->irPagina($destino);
        }
    }

    public function comprobarUserInAccountRecovery($destino) {
        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;
        $ok = true;
        if (!$sesion->existe(Session::USER_RESCUE)) {
            $ok = FALSE;
        } else {
            $userRescue = $sesion->getEntidad(Session::USER_RESCUE);
            $userRescue instanceof UsuarioDTO;
            $userRescue->setIdUsuario(CriptManager::urlVarDecript($userRescue->getIdUsuario()));
            $userDAO = UsuarioDAO::getInstancia();
            $userDAO instanceof UsuarioDAO;
            if (is_null($userDAO->find($userRescue))) {
                $ok = FALSE;
            }
        }
        if (!$ok) {
            $modal = new ModalSimple();
            $neutral = new Neutral();
            $neutral->setValor("No tienes permiso para acceder a este módulo");
            $modal->addElemento($neutral);
            $modal->setClosebtn("Aceptar");
            $sesion->add(Session::NEGOCIO_RTA, $modal);
            $this->irPagina($destino);
        }
    }
    

    public function comprobarSesionAdmin($destino) {
        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;
        if (!$sesion->existe(Session::US_ADMIN_LOGED) && !$sesion->existe(Session::US_SUB_ADMIN_LOGED)) {
            $this->irPagina($destino);
        }
    }

    public function comprobarSesionMainAdmin($destino) {
        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;
        if ($sesion->existe(Session::US_ADMIN_LOGED)) {
            $admin = $sesion->getEntidad(Session::US_ADMIN_LOGED);
            $admin instanceof UsuarioDTO;
            if ($admin->getRol() !== UsuarioDAO::ROL_MAIN_ADMIN) {
                $this->irPagina($destino);
            }
        } else {
            $this->irPagina($destino);
        }
    }

    public function comprobarCarritoInSession() {
        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;
        if (!$sesion->existe(Session::CART_USER)) {
            $this->irPagina(self::INICIO);
        }
    }

    public function comprobarCarritoTieneItems() {
        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;
        if (!$sesion->existe(Session::CART_USER)) {
            $modal = new ModalSimple();
            $neutral = new Errado();
            $neutral->setValor("No hay nada en el carrito");
            $modal->addElemento($neutral);
            $modal->setClosebtn("Aceptar");
            $sesion->add(Session::NEGOCIO_RTA, $modal);
            $this->irPagina(self::INICIO);
        } else {
            $carrito = $sesion->getEntidad(Session::CART_USER);
            $carrito instanceof CarritoComprasDTO;
            $items = $carrito->getItems();
            if (count($items) <= 0 || empty($items)) {
                $modal = new ModalSimple();
                $neutral = new Neutral();
                $neutral->setValor("No puedes comprar pues no tienes productos en el carrito de compras");
                $modal->addElemento($neutral);
                $modal->setClosebtn("Aceptar");
                $sesion->add(Session::NEGOCIO_RTA, $modal);
                $this->irPagina(self::INICIO);
            }
        }
    }

    public function comprobarLimiteFacturas($redir) {
        $modal = new ModalSimple();
        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;
        $cooker = CookieManager::getInstancia();
        $cooker instanceof CookieManager;
        if ($cooker->existe(CookieManager::LIMIT_FAC)) {
            $limit = $cooker->get(CookieManager::LIMIT_FAC);
            if ($limit >= 5) {
                $neutral = new Neutral();
                $neutral->setValor("No puedes comprar realizar más de 5 compras en un mismo día.");
                $modal->addElemento($neutral);
                $modal->setClosebtn("Aceptar");
                $sesion->add(Session::NEGOCIO_RTA, $modal);
                $this->irPagina($redir);
            } else {
                $cooker->add(CookieManager::LIMIT_FAC, ($limit + 1), CookieManager::$DIA);
            }
        } else {
            $cooker->add(CookieManager::LIMIT_FAC, 1, CookieManager::$DIA);
        }
    }

    public function irPagina($pagina) {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $pagina);
        exit();
    }

    public function validaEnviode($varName, $destino) {
        if (!isset($_REQUEST[$varName])) {
            $this->irPagina($destino);
        }
    }

}
