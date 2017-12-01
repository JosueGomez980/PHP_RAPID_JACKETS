<?php

include_once 'cargar_clases2.php';
AutoCarga2::init();

$acceso = AccesoPagina::getInstacia();
$acceso instanceof AccesoPagina;
$acceso->comprobarSesionAdmin(AccesoPagina::INICIO);
//Validar que se ha enviado el formulario
//Instancia de las clases para manejar los controladores hacia el modelo}
$modal = new ModalSimple();
$sesion = SimpleSession::getInstancia();
$sesion instanceof SimpleSession;
$productoDAO = ProductoDAO::getInstancia();
$productoDAO instanceof ProductoDAO;
$userManager = new ProductoController();
$productoRequest = new ProductoRequest();
$productoPost = $productoRequest->getProductoDTO();
$productoPost instanceof ProductoDTO;

$acceso->validaEnviode(ProductoRequest::pro_id, AccesoPagina::NEG_TO_ADM_PN_GST_PRO);

$productoPost->setIdProducto(Validador::fixTexto($productoPost->getIdProducto()));
$productoPost->setIdProducto(strtolower($productoPost->getIdProducto()));

$ok = TRUE;
if (!Validador::validaText($productoPost->getIdProducto(), 10, 50)) {
    $ok = FALSE;
    $error = new Errado();
    $error->setValor("El código del producto debe tener minimo 10 letras y máximo 50");
    $modal->addElemento($error);

    $closeBtn = new CloseBtn();
    $closeBtn->setValor("Aceptar");
    $modal->addElemento($closeBtn);

    $modal->open();
    $modal->maquetar();
    $modal->close();
}
if ($ok) {
    $proFinded = $productoDAO->find($productoPost);
    if (!is_null($proFinded)) {
        $modal->open();
        $modal->maquetar();
        $userManager->mostrarFormDisEnable($proFinded);
        $sesion->addEntidad($proFinded, "PRO_ENABLE_DISABLE");
        $modal->close();
    } else {
        $neutro = new Neutral();
        $neutro->setValor("No se encotró nigún producto con ese código");
        $modal->addElemento($neutro);

        $closeBtn = new CloseBtn();
        $closeBtn->setValor("Aceptar");
        $modal->addElemento($closeBtn);

        $modal->open();
        $modal->maquetar();
        $modal->close();
    }
}

