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
$productoPost->setIdProducto($productoId);
//Validar que la catidad a actualizar sea menor o igual a la disponible en la base de datos

if ($carritoManager->validaCantidadToUpdateItem($carritoCompras, $productoPost)) {
    $itemToReplace = $carritoManager->findItemByIdProducto($carritoCompras, $productoId);
    $indexToReplace = $carritoManager->getIndxOf($carritoCompras, $itemToReplace);
    $newItem = $itemToReplace;
    $newItem->setCantidad($productoPost->getCantidad());

    $newListaItems = $carritoCompras->getItems();
    $newListaItems[$indexToReplace] = $newItem;

    $carritoCompras->setItems($newListaItems);
    $newCarritoCompras = $carritoManager->calcularCarrito($carritoCompras, true);

    $sesion->addEntidad($newCarritoCompras, Session::CART_USER);
} else {
    $modal = new ModalSimple();
    $error = new Errado();
    $error->setValor("La cantidad de unidades ingresada es incorrecta.");
    $modal->addElemento($error);
    $modal->setClosebtn("Aceptar");
    $sesion->add(Session::NEGOCIO_RTA, $modal);
}


$acceso->irPagina(AccesoPagina::NEG_TO_CART_GES);
