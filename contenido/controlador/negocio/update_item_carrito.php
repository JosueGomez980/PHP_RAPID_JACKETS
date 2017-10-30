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
$carritoCompras instanceof CarritoComprasDTO;
$productoId = CriptManager::urlVarDecript($productoPost->getIdProducto());

$itemToReplace = $carritoManager->findItemByIdProducto($carritoCompras, $productoId);
$indexToReplace = $carritoManager->getIndxOf($carritoCompras, $itemToReplace);
$newItem = $itemToReplace;
$newItem->setCantidad($productoPost->getCantidad());

$newListaItems = $carritoCompras->getItems();
$newListaItems[$indexToReplace] = $newItem;

$carritoCompras->setItems($newListaItems);
$newCarritoCompras = $carritoManager->calcularCarrito($carritoCompras, true);

$sesion->addEntidad($newCarritoCompras, Session::CART_USER);

$acceso->irPagina(AccesoPagina::NEG_TO_CART_GES);
