<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CuentaController
 *
 * @author SOPORTE
 */
include_once 'cargar_clases3.php';

class CuentaRequest extends Request {

    private $cuentaDTO;

    const cu_tip_doc = "cuenta_tip_doc";
    const cu_num_doc = "cuenta_num_doc";
    const cu_prim_name = "cuenta_prim_name";
    const cu_sec_name = "cuenta_sec_name";
    const cu_pri_ape = "cuenta_prim_ape";
    const cu_sec_ape = "cuenta_sec_ape";
    const cu_tel = "cuenta_tel";

    public function getCuentaDTO() {
        return $this->cuentaDTO;
    }

    public function setCuentaDTO(CuentaDTO $cuentaDTO) {
        $this->cuentaDTO = $cuentaDTO;
    }

    public function __construct() {
        parent::__construct();
    }

    public function doDelete() {
        return NULL;
    }

    public function doGet() {
        $cuentaTemp = new CuentaDTO();
        if (isset($_GET[self::cu_tip_doc])) {
            $cuentaTemp->setTipoDocumento($_GET[self::cu_tip_doc]);
        }
        if (isset($_GET[self::cu_num_doc])) {
            $cuentaTemp->setNumDocumento($_GET[self::cu_num_doc]);
        }
        if (isset($_GET[self::cu_prim_name])) {
            $cuentaTemp->setPrimerNombre($_GET[self::cu_prim_name]);
        }
        if (isset($_GET[self::cu_sec_name])) {
            $cuentaTemp->setSegundoNombre($_GET[self::cu_sec_name]);
        }
        if (isset($_GET[self::cu_pri_ape])) {
            $cuentaTemp->setPrimerApellido($_GET[self::cu_pri_ape]);
        }
        if (isset($_GET[self::cu_sec_ape])) {
            $cuentaTemp->setSegundoApellido($_GET[self::cu_sec_ape]);
        }
        if (isset($_GET[self::cu_tel])) {
            $cuentaTemp->setTelefono($_GET[self::cu_tel]);
        }
        $this->cuentaDTO = $cuentaTemp;
    }

    public function doHead() {
        return NULL;
    }

    public function doPost() {
        $cuentaTemp = new CuentaDTO();
        if (isset($_POST[self::cu_tip_doc])) {
            $cuentaTemp->setTipoDocumento($_POST[self::cu_tip_doc]);
        }
        if (isset($_POST[self::cu_num_doc])) {
            $cuentaTemp->setNumDocumento($_POST[self::cu_num_doc]);
        }
        if (isset($_POST[self::cu_prim_name])) {
            $cuentaTemp->setPrimerNombre($_POST[self::cu_prim_name]);
        }
        if (isset($_POST[self::cu_sec_name])) {
            $cuentaTemp->setSegundoNombre($_POST[self::cu_sec_name]);
        }
        if (isset($_POST[self::cu_pri_ape])) {
            $cuentaTemp->setPrimerApellido($_POST[self::cu_pri_ape]);
        }
        if (isset($_POST[self::cu_sec_ape])) {
            $cuentaTemp->setSegundoApellido($_POST[self::cu_sec_ape]);
        }
        if (isset($_POST[self::cu_tel])) {
            $cuentaTemp->setTelefono($_POST[self::cu_tel]);
        }
        $this->cuentaDTO = $cuentaTemp;
    }

    public function doPut() {
        return NULL;
    }

    public function doRequest() {
        return NULL;
    }

}

class CuentaController implements Validable, GenericController {

    public static $instancia;
    private $cuentaDAO;
    private $domicilioDAO;
    private $content;

    public function __construct() {
        $this->cuentaDAO = new CuentaDAO();
        $this->content = new ContentManager();
        $this->domicilioDAO = new DomicilioCuentaDAO();
    }

    public static function getInstancia() {
        if (is_null(self::$instancia)) {
            self::$instancia = new CuentaController();
        }
        return self::$instancia;
    }

    public function actualizar(EntityDTO $entidad) {
        $ok = FALSE;
        $entidad instanceof CuentaDTO;
        $rta = $this->cuentaDAO->update($entidad);
        switch ($rta) {
            case 1: {
                    $this->content->setFormato(new Exito());
                    $this->content->setContenido("La información personal se guardó correctamente. Se aplicaron los cambios");
                    $ok = TRUE;
                    break;
                }
            case 0: {
                    $this->content->setFormato(new Neutral());
                    $this->content->setContenido("No se registraron cambios en los datos de cueta");
                    $ok = TRUE;
                    break;
                }
            case -1: {
                    $this->content->setFormato(new Errado());
                    $this->content->setContenido("Hubo un error grave al momento de realizar la operacion :( Por favor revise los datos e intente de nuevo.");
                    break;
                }
        }
        return $ok;
    }

    public function eliminar(EntityDTO $entidad) {
        $entidad instanceof CuentaDTO;
        $rta = $this->cuentaDAO->delete($entidad);
        return $rta;
    }

    public function encontrar(EntityDTO $entidad) {
        $entidad instanceof CuentaDTO;
        return $this->cuentaDAO->find($entidad);
    }

    public function encontrarTodos() {
        return $this->cuentaDAO->findAll();
    }

    public function encontrarPorNumeroDocumento(CuentaDTO $cuenta) {
        if (Validador::validaNumDoc($cuenta->getNumDocumento())) {
            return $this->cuentaDAO->findByNumDoc($cuenta->getNumDocumento());
        } else {
            return null;
        }
    }

    public function insertar(EntityDTO $entidad) {
        $rta = FALSE;
        $entidad instanceof CuentaDTO;
        if ($this->validaPK($entidad)) {
            $this->content->setFormato(new Errado);
            $this->content->setContenido("El numero de documento " . $entidad->getNumDocumento() . " ya existe. Por favor digite uno diferente.");
        } else {
            $rta = $this->cuentaDAO->insert($entidad);
            switch ($rta) {
                case 1: {
                        $this->content->setFormato(new Exito());
                        $this->content->setContenido("La información personal se guardó correctamente.");
                        $rta = TRUE;
                        break;
                    }
                case 0: {
                        $this->content->setFormato(new Errado());
                        $this->content->setContenido("No se pudo registrar la información personal correctamente. Intente de nuevo.");
                        break;
                    }
                case -1: {
                        $this->content->setFormato(new Errado());
                        $this->content->setContenido("Hubo un error grave al momento de realizar la operacion :(");
                        break;
                    }
            }
        }
        return $rta;
    }

    public function encontrarDomicilioporCuenta(CuentaDTO $cuenta) {
        $domiS = new DomicilioCuentaDTO();
        $domiS->setCuentaNumDocumento($cuenta->getNumDocumento());
        $domiS->setCuentaTipoDocumento($cuenta->getTipoDocumento());
        return $this->domicilioDAO->find($domiS);
    }

    public function validaFK(EntityDTO $entidad) {
        $entidad instanceof UsuarioDTO;
        $userDAO = UsuarioDAO::getInstancia(); // <<<--
        if (is_null($userDAO->find($entidad))) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function validaPK(EntityDTO $entidad) {
        $entidad instanceof CuentaDTO;
        if (is_null($this->cuentaDAO->find($entidad))) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function validaPKDomicilio(DomicilioCuentaDTO $domi) {
        if (is_null($this->domicilioDAO->find($domi))) {
            //No existe un domicilio tal
            return false;
        } else {
            //Existe un domicilio tal
            return true;
        }
    }

    public function insertarDomicilioCuenta(DomicilioCuentaDTO $newDomicilio) {
        $ok = true;
        $modal = new ModalSimple();
        if ($this->validaPKDomicilio($newDomicilio)) {
            $err = new Errado();
            $err->setValor("Ya existe información del domicilio de este usuario.");
            $modal->addElemento($err);
            $ok = false;
        } else {
            if (!Validador::validaText($newDomicilio->getDireccion(), 10, 250)) {
                $ok = false;
                $err = new Errado();
                $err->setValor("La dirección debe tener un mínimo de 10 letras y máximo 250");
                $modal->addElemento($err);
            }
            if (!Validador::validaTel($newDomicilio->getTelefono(), 7, 10)) {
                $ok = false;
                $err = new Errado();
                $err->setValor("El teléfono digitado no se reconoce como un teléfono móvil o fijo.");
                $modal->addElemento($err);
            }
            if (!Validador::validaText($newDomicilio->getBarrio(), 3, 250)) {
                $ok = false;
                $err = new Errado();
                $err->setValor("El barrio digitado es muy corto o muy largo !!");
                $modal->addElemento($err);
            }
        }
        if ($ok) {
            $newDomicilio->setDireccion(CriptManager::urlVarEncript($newDomicilio->getDireccion()));
            $newDomicilio->setBarrio(CriptManager::urlVarEncript($newDomicilio->getBarrio()));
            $newDomicilio->setTelefono(CriptManager::urlVarEncript($newDomicilio->getTelefono()));
            $newDomicilio->setCorreoPostal(CriptManager::urlVarEncript($newDomicilio->getCorreoPostal()));
            $rta = $this->domicilioDAO->insert($newDomicilio);
            switch ($rta) {
                case 1:
                    $err = new Exito();
                    $err->setValor("Los datos del domicilio fueron guardados correctamente. ");
                    $modal->addElemento($err);
                    break;
                case 0:
                    $err = new Neutral();
                    $err->setValor("Los datos del domicilio no fueron guardados correctamente.");
                    $modal->addElemento($err);
                    break;
                case -1:
                    $err = new Errado();
                    $err->setValor("Hubo un error grave al realizar la operación. Intente de nuevo.");
                    $modal->addElemento($err);
                    break;
            }
        } else {
            $err = new Errado();
            $err->setValor("No se pudieron guardar los datos de tu domicilio. Verifica los datos e intenta de nuevo");
            $modal->addElemento($err);
        }

        $modal->setClosebtn("Aceptar");
        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;
        $sesion->add(Session::NEGOCIO_RTA, $modal);
        $acceso = AccesoPagina::getInstacia();
        $acceso instanceof AccesoPagina;
        $acceso->irPagina(AccesoPagina::NEG_TO_PER_DATA);

        //return $modal;
    }

    public function modificarDomicilioCuenta(DomicilioCuentaDTO $newDomicilio) {
        $ok = true;
        $modal = new ModalSimple();
        if (!$this->validaPKDomicilio($newDomicilio)) {
            $err = new Errado();
            $err->setValor("No existe información del domicilio de este usuario.");
            $modal->addElemento($err);
            $ok = false;
        } else {
            if (!Validador::validaText($newDomicilio->getDireccion(), 10, 250)) {
                $ok = false;
                $err = new Errado();
                $err->setValor("La dirección debe tener un mínimo de 10 letras y máximo 250");
                $modal->addElemento($err);
            }
            if (!Validador::validaTel($newDomicilio->getTelefono(), 7, 10)) {
                $ok = false;
                $err = new Errado();
                $err->setValor("El teléfono digitado no se reconoce como un teléfono móvil o fijo.");
                $modal->addElemento($err);
            }
            if (!Validador::validaText($newDomicilio->getBarrio(), 3, 250)) {
                $ok = false;
                $err = new Errado();
                $err->setValor("El barrio digitado es muy corto o muy largo !!");
                $modal->addElemento($err);
            }
        }
        if ($ok) {
            $newDomicilio->setDireccion(CriptManager::urlVarEncript($newDomicilio->getDireccion()));
            $newDomicilio->setBarrio(CriptManager::urlVarEncript($newDomicilio->getBarrio()));
            $newDomicilio->setTelefono(CriptManager::urlVarEncript($newDomicilio->getTelefono()));
            $newDomicilio->setCorreoPostal(CriptManager::urlVarEncript($newDomicilio->getCorreoPostal()));
            $rta = $this->domicilioDAO->update($newDomicilio);
            switch ($rta) {
                case 1:
                    $err = new Exito();
                    $err->setValor("Los datos del domicilio fueron modificados correctamente. ");
                    $modal->addElemento($err);
                    break;
                case 0:
                    $err = new Neutral();
                    $err->setValor("No se registraron cambios en la información");
                    $modal->addElemento($err);
                    break;
                case -1:
                    $err = new Errado();
                    $err->setValor("Hubo un error grave al realizar la operación. Intente de nuevo.");
                    $modal->addElemento($err);
                    break;
            }
        } else {
            $err = new Errado();
            $err->setValor("No se pudieron modificar los datos de tu domicilio. Verifica los datos e intenta de nuevo");
            $modal->addElemento($err);
        }
        $modal->setClosebtn("Aceptar");
//        $sesion = SimpleSession::getInstancia();
//        $sesion instanceof SimpleSession;
//        $sesion->add(Session::NEGOCIO_RTA, $modal);
//        $acceso = AccesoPagina::getInstacia();
//        $acceso instanceof AccesoPagina;
//        $acceso->irPagina(AccesoPagina::NEG_TO_PER_DATA);

        return $modal;
    }

    public function mostrarSelectLocalidades($selected) {
        $localidades = array("Usaquen", "Chapinero", "Santa Fe", "San Cristobal", "Usme",
            "Tunjuelito", "Bosa", "Kennedy", "Fontibon", "Engativa", "Suba",
            "Barrios Unidos", "Teusaquillo", "Los Martires", "Antonio Nariño",
            "Puente Aranda", "La Candelaria", "Rafael Uribe Uribe", "Simon Bolivar",
            "Sumapaz");

        echo('<select name="domi_localidad" id="domi_localidad" style="border:1px solid #000000; width: 80%;padding: 10px 15px;border-radius: 8px;" required="true">  \n ');
        if (!empty($selected) && $selected !== "") {
            echo('<option value="' . ($selected) . '" selected >' . CriptManager::urlVarDecript($selected) . '</option>');
        }
        for ($i = 0; $i < count($localidades); $i++) {
            $value = CriptManager::urlVarEncript($localidades[$i]);
            echo ('<option value="' . $value . '">' . $localidades[$i] . '</option> \n');
        }
        echo('</select>');
    }

    public function mostrarFormularioDomicilioCuenta() {
        require_once 'controlador/negocio/vistas/vista_form_domi_cuenta.php';
    }

}
