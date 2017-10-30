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

$itemToDelete = $carritoManager->findItemByIdProducto($carritoCompras, $productoId);
$indexTodelete = $carritoManager->getIndxOf($carritoCompras, $itemToDelete);
$newListaItems = array();
$oldItems = $carritoCompras->getItems();
$inx = 0;
foreach ($oldItems as $item) {
    if ($indexTodelete !== $inx) {
        $newListaItems[] = $item;
    }
    $inx++;
}
$carritoCompras->setItems($newListaItems);
$newCarritoCompras = $carritoManager->calcularCarrito($carritoCompras, true);

$sesion->addEntidad($newCarritoCompras, Session::CART_USER);

$acceso->irPagina(AccesoPagina::NEG_TO_CART_GES);
