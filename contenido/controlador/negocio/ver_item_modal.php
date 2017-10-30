<?php

include_once 'cargar_clases2.php';
AutoCarga2::init();

$acceso = AccesoPagina::getInstacia();
$acceso instanceof AccesoPagina;
$acceso->comprobarCarritoInSession();

$userManager = new ProductoController();
$carritoManager = new CarritoComprasController();
$productoRequest = new ProductoRequest();
$productoPost = $productoRequest->getProductoDTO();
$productoPost instanceof ProductoDTO;
$sesion = SimpleSession::getInstancia();
$sesion instanceof SimpleSession;

$carritoCompras = $sesion->getEntidad(Session::CART_USER);
$productoId = CriptManager::urlVarDecript($productoPost->getIdProducto());

$itemToDisplay = $carritoManager->findItemByIdProducto($carritoCompras, $productoId);
$carritoManager->mostrarItemCarritoToEdit($itemToDisplay);