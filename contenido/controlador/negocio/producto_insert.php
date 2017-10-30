<?php

include_once 'cargar_clases2.php';
AutoCarga2::init();

$acceso = AccesoPagina::getInstacia();
$acceso instanceof AccesoPagina;
$acceso->comprobarSesionAdmin(AccesoPagina::INICIO);
//Instancia de las clases para manejar los controladores hacia el modelo}
$sesion = SimpleSession::getInstancia();
$sesion instanceof SimpleSession;
$userManager = new ProductoController();
$productoRequest = new ProductoRequest();
$productoPost = $productoRequest->getProductoDTO();
$productoPost instanceof ProductoDTO;
$productoPost->setCategoriaIdCategoria(CriptManager::urlVarDecript($_POST[ProductoRequest::pro_id_cat]));
$productoPost->setCatalogoIdCatalogo(1);
//Linea que bien puede tener limpiado del texto o no. Si lo tiene las busquedas por nombre saldran incorrectas
$productoPost->setNombre(($productoPost->getNombre()));
$modal = new ModalSimple();
$productoPost->setDescripcion(trim($productoPost->getDescripcion()));


$fileImage = new FileUploadImage("producto_image");
$fileImage->setAllowedSize(FileUpload::DOS_MB);

$ok = TRUE;

if (!Validador::validaText($productoPost->getNombre(), 4, 250)) {
    $ok = FALSE;
    $error = new Errado();
    $error->setValor("El nombre del producto no debe ser muy largo o muy corto");
    $modal->addElemento($error);
}
if (!is_int($productoPost->getCategoriaIdCategoria()) || $productoPost->getCategoriaIdCategoria() == 0) {
    $ok = FALSE;
    $error = new Errado();
    $error->setValor("La categoria es incorrecta");
    $modal->addElemento($error);
}
if (is_null($productoPost->getDescripcion() || $productoPost->getDescripcion() == "")) {
    $productoPost->setDescripcion("SIN DESCRIPCION DISPONIBLE");
}
if (!Validador::validaInteger($productoPost->getPrecio())) {
    $ok = FALSE;
    $error = new Errado();
    $error->setValor("El precio del producto debe ser numérico");
    $modal->addElemento($error);
}

//Validacion de las restricciones de la foto para el producto
if ($fileImage->existeFileToUpload()) {
    $foto = TRUE;
    if (!$fileImage->validaTipo(FileUpload::$ALL_IMG)) {
        $ok = $foto = FALSE;
        $error = new Errado();
        $error->setValor("El tipo de archivo para la foto debe ser una imagen");
        $modal->addElemento($error);
    }
    if (!$fileImage->validaTamanio(FileUpload::DOS_MB)) {
        $ok = $foto = FALSE;
        $error = new Errado();
        $error->setValor("El tamaño de la imagen debe ser maximo de 2MB");
        $modal->addElemento($error);
    }
} else {
    $productoPost->setFoto("SIN_ASIGNAR");
}
if ($ok) {
    $productoPost->setActivo(TRUE);
    $productoPost->setCantidad(1);
    $productoPost->setIdProducto($userManager->newIdProductoDB());
    if ($foto) {
        $fileImage->setFinalNombre("pro_img_" . $productoPost->getIdProducto());
        $fileImage->setRutaFinal(FileUpload::PRO_IMG_DIR_B);
        if ($fileImage->subir()) {
            $exito = new Exito();
            $exito->setValor("La imagen para el producto se guardó correctamente.");
            $modal->addElemento($exito);
            $fileImage->setRutaParaMostrar(FileUpload::PRO_IMG_DIR_A);
            $productoPost->setFoto($fileImage->getRutaCompletaParaMostrar());
        } else {
            $error = new Errado();
            $error->setValor("No se pudo guardar la imagen del producto <br> ERROR = ".$fileImage->getErrorMessage());
            $modal->addElemento($error);
            $productoPost->setFoto("SIN_ASIGNAR");
        }
    }
    if ($userManager->insertar($productoPost)) {
        $exito = new Exito();
        $exito->setValor("El producto se guardo y se registró correctamente.");
        $modal->addElemento($exito);
    } else {
        $error = new Errado();
        $error->setValor("No se pudo guardar el producto. Por favor verfique la información e intente de nuevo.");
        $modal->addElemento($error);
    }
}
$closeBtn = new CloseBtn();
$closeBtn->setValor("Aceptar");
$modal->addElemento($closeBtn);
$sesion->add(Session::NEGOCIO_RTA, $modal);

$acceso->irPagina(AccesoPagina::NEG_TO_ADM_PN_GST_PRO);




