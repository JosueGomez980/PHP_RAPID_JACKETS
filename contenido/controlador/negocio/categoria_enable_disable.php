<?php

include_once 'cargar_clases2.php';
AutoCarga2::init();

$acceso = AccesoPagina::getInstacia();
$acceso instanceof AccesoPagina;
$acceso->comprobarSesionAdmin(AccesoPagina::INICIO);
$categoriaDAO = CategoriaDAO::getInstancia();
$categoriaDAO instanceof CategoriaDAO;
$modal = new ModalSimple();
$paginador = SimpleSession::getInstancia()->getEntidad(Session::PAGINADOR);
$paginador instanceof PaginadorMemoria;
$inxPaginaActual = $paginador->getPaginaActual();

//Instancia de las clases para manejar los controladores hacia el modelo

$categoriaManager = new CategoriaController();
$categoriaUpdate = new CategoriaDTO();

if (isset($_POST[CategoriaRequest::id_cat])) {
    $categoriaUpdate->setIdCategoria(CriptManager::urlVarDecript($_POST[CategoriaRequest::id_cat]));
}
$modal->open();
if ($categoriaManager->validaPK($categoriaUpdate)) {
    $categoriaFinded = $categoriaDAO->find($categoriaUpdate);
    $categoriaFinded->setActiva(!$categoriaFinded->getActiva());
    $categoriaManager->disableEnable($categoriaFinded);
} else {
    $neutro = new Neutral();
    $neutro->setValor("No se encontró ninguna categoría con ese Id");
    $modal->addElemento($neutro);
}
$closeBtn = new CloseBtn();
$closeBtn->setValor("Aceptar");
$modal->addElemento($closeBtn);
$modal->maquetar();
$modal->close();

$paginador->setTablaCompleta($categoriaDAO->findAll());
$tablaUsuariosPaginada = $paginador->getPage($inxPaginaActual);
//Maquetar de nuevo las categorias de la tabla para Observar el cambio
$categoriaManager->mostrarCategoriasCrudTable($tablaUsuariosPaginada);
SimpleSession::getInstancia()->add(Session::PAGINADOR, $paginador);
