<?php

include_once 'cargar_clases2.php';
AutoCarga2::init();

$sesion = SimpleSession::getInstancia();
$sesion instanceof SimpleSession;
if ($sesion->existe(Session::US_LOGED)) {
    $sesion->destroy();
}
$acesso = AccesoPagina::getInstacia();
$acesso instanceof AccesoPagina;
$acesso->irPagina(AccesoPagina::NEG_TO_INICIO);



