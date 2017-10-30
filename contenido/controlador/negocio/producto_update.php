<?php

include_once 'cargar_clases2.php';
AutoCarga2::init();

$acceso = AccesoPagina::getInstacia();
$acceso instanceof AccesoPagina;
$acceso->comprobarSesionAdmin(AccesoPagina::INICIO);
//Validar que se ha enviado el formulario
if (!isset($_POST["envio"])) {
    $acceso->irPagina(AccesoPagina::NEG_TO_ADM_PN_GST_PRO);
}
//Instancia de las clases para manejar los controladores hacia el modelo}
$sesion = SimpleSession::getInstancia();
$sesion instanceof SimpleSession;
$productoDAO = ProductoDAO::getInstancia();
$productoDAO instanceof ProductoDAO;
$userManager = new ProductoController();
$productoRequest = new ProductoRequest();
$productoPost = $productoRequest->getProductoDTO();
$productoPost instanceof ProductoDTO;
$modal = new ModalSimple();


$productoPost->setIdProducto(CriptManager::urlVarDecript($productoPost->getIdProducto()));
$productoPost->setCategoriaIdCategoria(CriptManager::urlVarDecript(filter_input(INPUT_POST, ProductoRequest::pro_id_cat)));

$proFinded = $productoDAO->find($productoPost);

$productoPost->setCatalogoIdCatalogo($proFinded->getCatalogoIdCatalogo());

$fileImage = new FileUploadImage("producto_image");
$fileImage->setAllowedSize(FileUpload::DOS_MB);

$ok = TRUE;
$foto = FALSE;

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

$foto = TRUE;

//Validacion de las restricciones de la foto para el producto y valida que no haya errores en la subida temporal de la imagen
if ($fileImage->existeFileToUpload()) {
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
    if ($fileImage->getErrorNumber() != UPLOAD_ERR_OK) {
        $foto = FALSE;
        $error = new Errado();
        $error->setValor("No se puede usar esta imagen para el producto  <br> ERROR = " . $fileImage->getErrorMessage());
        $modal->addElemento($error);
        //Si falla la carga de la nueva imagen, se pondrá denuevo la ruta de la imagen ya existente
        $productoPost->setFoto($proFinded->getFoto());
    }
} else {
    //Si falla la carga de la nueva imagen, se pondrá denuevo la ruta de la imagen ya existente
    $foto = FALSE;
    $productoPost->setFoto($proFinded->getFoto());
}

if ($ok) {
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
            $error->setValor("No se pudo guardar la imagen del producto  <br> ERROR = " . $fileImage->getErrorMessage());
            $modal->addElemento($error);
            $productoPost->setFoto($proFinded->getFoto());
        }
    }
    if ($userManager->actualizar($productoPost)) {
        $exito = new Exito();
        $exito->setValor("El producto se modificó correctamente.");
        $modal->addElemento($exito);
    } else {
        $error = new Errado();
        $error->setValor("No se pudo modificar. Por favor verfique la información e intente de nuevo.");
        $modal->addElemento($error);
    }
} else {
    $error = new Errado();
    $error->setValor("No se pudo modificar. Por favor verfique la información e intente de nuevo.");
    $modal->addElemento($error);
}



$closeBtn = new CloseBtn();
$closeBtn->setValor("Aceptar");
$modal->addElemento($closeBtn);
$sesion->add(Session::NEGOCIO_RTA, $modal);

$acceso->irPagina(AccesoPagina::NEG_TO_ADM_PN_GST_PRO);
