<?php

include_once 'cargar_clases2.php';
AutoCarga2::init();
$sesion = SimpleSession::getInstancia();
$sesion instanceof SimpleSession;

$acceso = AccesoPagina::getInstacia();
$acceso instanceof AccesoPagina;
$acceso->comprobarSesionAdmin(AccesoPagina::INICIO);

$tablaUsuariosPaginada = NULL;
//Validar que se ha enviado el formulario
if (!isset($_GET["page"])) {
    $acceso->irPagina(AccesoPagina::NEG_TO_ADM_PN_GST_PRO);
}
//Validar que la instancia del paginador esté cargada en memoria
if (!$sesion->existe(Session::PAGINADOR)) {
    $acceso->irPagina(AccesoPagina::NEG_TO_ADM_PN_GST_PRO);
}

$paginaRequest = filter_input(INPUT_GET, "page");

$paginador = $sesion->getEntidad(Session::PAGINADOR);
$paginador instanceof PaginadorMemoria;

if (Validador::validaInteger($paginaRequest)) {
    $paginaRequest = (int) $paginaRequest;
    if ($paginaRequest <= $paginador->getNumeroPaginas()) {
        $tablaUsuariosPaginada = $paginador->getPage($paginaRequest);
    } else {
        $tablaUsuariosPaginada = $paginador->getTablaActual();
    }
} else {
    switch ($paginaRequest) {
        case "NEXT":
            $tablaUsuariosPaginada = $paginador->nextPage();
            break;
        case "PREV":
            $tablaUsuariosPaginada = $paginador->prevPage();
            break;
        case "LAST":
            $tablaUsuariosPaginada = $paginador->lastPage();
            break;
        case "FIRST":
            $tablaUsuariosPaginada = $paginador->firstPage();
            break;
        default :
            $tablaUsuariosPaginada = $paginador->getTablaActual();
            break;
    }
}
$userManager = new ProductoController();
$sesion->add(Session::PAGINADOR, $paginador);

$userManager->mostrarCrudTableForInventario($tablaUsuariosPaginada);

