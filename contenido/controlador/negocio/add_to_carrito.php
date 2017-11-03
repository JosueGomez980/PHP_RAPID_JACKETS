<?php

include_once 'cargar_clases2.php';
AutoCarga2::init();

$modal = new ModalSimple();
$proDAO = ProductoDAO::getInstancia();
$proDAO instanceof ProductoDAO;
$sesion = SimpleSession::getInstancia();
$sesion instanceof SimpleSession;

if (!$sesion->existe(Session::CART_USER)) {
    $sesion->addEntidad(new CarritoComprasDTO(), Session::CART_USER);
}

$userManager = new ProductoController();
$carritoManager = new CarritoComprasController();
$productoRequest = new ProductoRequest();
$procustoPost = $productoRequest->getProductoDTO();
$procustoPost instanceof ProductoDTO;
$procustoPost->setIdProducto(base64_decode($procustoPost->getIdProducto()));
$productoTemp = $proDAO->find($procustoPost);
$procustoPost->setNombre($productoTemp->getNombre());
$procustoPost->setPrecio($productoTemp->getPrecio());


$carrito = $sesion->getEntidad(Session::CART_USER);
$carrito instanceof CarritoComprasDTO;
$modal->open();
if ($carritoManager->existeEnCarrito($carrito, $procustoPost)) {
    if ($carritoManager->validaCantidadToAddCarrito($carrito, $procustoPost)) {
        $nuevaListaItems = $carrito->getItems();
        $itemExistente = $carritoManager->findItemByIdProducto($carrito, $productoTemp->getIdProducto());
        $indexToReplace = $carritoManager->getIndxOf($carrito, $itemExistente);
        $newItem = new ItemCarritoDTO($procustoPost);
        $newItem->setCantidad($itemExistente->getCantidad() + $procustoPost->getCantidad());
        $newItem->setCostoUnitario($procustoPost->getPrecio());
        $newItem->setCostoTotal($procustoPost->getPrecio() * $procustoPost->getCantidad());
        $nuevaListaItems[$indexToReplace] = $newItem;
        $carrito->setItems($nuevaListaItems);
        $msg = new Exito();
        $msg->setValor("Agregaste a tu carrito " . $procustoPost->getCantidad() . "  unidades para el producto: " . Validador::fixTexto($productoTemp->getNombre()) . " Actual (" . $newItem->getCantidad() . ") ");
        $modal->addElemento($msg);
    } else {
        $msg = new Errado();
        $msg->setValor("La cantidad ingresada supera la cantidad disponible actual");
        $modal->addElemento($msg);
    }
} else {
    if ($carritoManager->validaCantidadToAddCarrito($carrito, $procustoPost)) {
        $newItem = new ItemCarritoDTO($procustoPost);
        $newItem->setCantidad($procustoPost->getCantidad());
        $newItem->setCostoUnitario($procustoPost->getPrecio());
        $newItem->setCostoTotal($procustoPost->getPrecio() * $procustoPost->getCantidad());
        $carrito->setItem($newItem);
        $msg = new Exito();
        $msg->setValor("Añadiste un producto al carrito. Para ver el carrito ve al botón de carrito");
        $modal->addElemento($msg);
    } else {
        $msg = new Errado();
        $msg->setValor("La cantidad ingresada supera la cantidad disponible actual");
        $modal->addElemento($msg);
    }
}

//Actualizar la variable de sesion con el nuevo carrito de Compras
$nuevoCarrito = $carritoManager->calcularCarrito($carrito, true);
$sesion->addEntidad($nuevoCarrito, Session::CART_USER);

$btnClose = new CloseBtn();
$btnClose->setValor("OK");
$modal->addElemento($btnClose);
//---
$modal->maquetar();
$modal->close();
