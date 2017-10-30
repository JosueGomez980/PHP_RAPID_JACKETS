<?php

require_once 'cargar_clases2.php';
AutoCarga2::init();

$dater = new DateManager();
$fechaActual = $dater->getSQLDateTime();
$acceso = AccesoPagina::getInstacia();
$acceso instanceof AccesoPagina;
$acceso->comprobarSesionAdmin(AccesoPagina::INICIO);
$sesion = SimpleSession::getInstancia();
$sesion instanceof SimpleSession;
$modalRTA = new ModalSimple();
AccesoPagina::validaEnviode("submit", AccesoPagina::NEG_TO_ADM_PN_GST_INV);
if (!$sesion->existe(Session::PRO_DTO)) {
    $acceso->irPagina(AccesoPagina::NEG_TO_ADM_PN_GST_INV);
}
$ok = true;

$nuevaCantidad = 0;
$proDTOSesion = $sesion->getEntidad(Session::PRO_DTO);
$proDTOSesion instanceof ProductoDTO;
$inventarioControl = new InventarioController();
$inventarioRequest = new InventarioRequest();
$inventarioPost = $inventarioRequest->getInventarioDTO();
$inventarioPost instanceof InventarioDTO;
$inventarioDAO = new InventarioDAO();

$inventarioPost->setProductoIdProducto($proDTOSesion->getIdProducto());
$inventarioPost->setFecha($fechaActual);
$inventarioPost->setObservaciones(Validador::fixTexto($inventarioPost->getObservaciones()));

if (Validador::validaInteger($inventarioPost->getCantidad()) && $inventarioPost->getCantidad() >= 1) {

    $modo = filter_input(INPUT_POST, "inventario_modo");

    switch ($modo) {
        case "MAS":
            $inventarioPost->setPrecioMayor(($proDTOSesion->getPrecio()) * ($inventarioPost->getCantidad()));
            $nuevaCantidad = ($proDTOSesion->getCantidad() + $inventarioPost->getCantidad());
            break;
        case "MENOS";
            $inventarioPost->setPrecioMayor(0);
            if ($inventarioPost->getCantidad() > $proDTOSesion->getCantidad()) {
                $error = new Errado();
                $error->setValor("La cantidad a restar del producto no puede ser mayor a la existente");
                $modalRTA->addElemento($error);
                $ok = false;
            } else {
                $nuevaCantidad = ($proDTOSesion->getCantidad() - $inventarioPost->getCantidad());
            }
            break;
        default :
            $error = new Errado();
            $error->setValor("¡Error en el formato del modo a ingresar!");
            $modalRTA->addElemento($error);
            $ok = false;
            break;
    }
    $proDTOSesion->setCantidad($nuevaCantidad);
} else {
    $ok = false;
    $error = new Errado();
    $error->setValor("La cantidad ingresada debe ser un numero y debe ser mínimo de  1 unidad");
    $modalRTA->addElemento($error);
}
if ($ok) {
    if ($inventarioControl->insertar($inventarioPost)) {
        $proDAO = new ProductoDAO();
        $proDAO->updateCantidad($proDTOSesion);
        $error = new Exito();
        $error->setValor("La cantidad fue cambiada correctamente. Nueva cantidad : ".$proDTOSesion->getCantidad());
        $modalRTA->addElemento($error);
    } else {
        $error = new Errado();
        $error->setValor("La cantidad no se pudo cambiar. Verifique los datos e intente de nuevo. ");
        $modalRTA->addElemento($error);
    }
} else {
    $error = new Errado();
    $error->setValor("No se pudo guardar la nueva cantidad para el producto :(");
    $modalRTA->addElemento($error);
}

$btnCls = new CloseBtn();
$btnCls->setValor("Aceptar");
$modalRTA->addElemento($btnCls);
$sesion->add(Session::NEGOCIO_RTA, $modalRTA);

$acceso->irPagina(AccesoPagina::NEG_TO_ADM_PN_GST_INV);

