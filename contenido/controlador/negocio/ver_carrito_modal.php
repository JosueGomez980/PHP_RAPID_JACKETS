<?php
include_once 'cargar_clases2.php';
AutoCarga2::init();

$sesion = SimpleSession::getInstancia();
$sesion instanceof SimpleSession;
$carritoManager = new CarritoComprasController();

if (!$sesion->existe(Session::CART_USER)) {
    $sesion->addEntidad(new CarritoComprasDTO(), Session::CART_USER);
}
$carrito = $sesion->getEntidad(Session::CART_USER);
$carritoManager->mostrarCarrito($carrito);
