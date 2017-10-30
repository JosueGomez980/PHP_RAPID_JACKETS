<?php

include_once 'cargar_clases2.php';
AutoCarga2::init();

$acceso = AccesoPagina::getInstacia();
$acceso instanceof AccesoPagina;
$acceso->comprobarSesionAdmin(AccesoPagina::INICIO);

//Instancia de las clases para manejar los controladores hacia el modelo
$modal = new ModalSimple();
$modal->open();

$categoriaManager = new CategoriaController();
$categoriaManager->mostrarCategoriaFormInsert();

$closeBtn = new CloseBtn();
$closeBtn->setValor("Cerrar");
$modal->addElemento($closeBtn);
$modal->maquetar();
$modal->close();
