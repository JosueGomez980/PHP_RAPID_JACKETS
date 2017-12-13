<?php

include_once 'cargar_clases2.php';
AutoCarga2::init();

$userManager = UsuarioController::getInstancia();
$userManager instanceof UsuarioController;
$acceso = AccesoPagina::getInstacia();
$acceso instanceof AccesoPagina;
$acceso->validaEnviode(UsuarioRequest::us_id, AccesoPagina::NEG_TO_IN_SESION);
$acceso->validaEnviode(UsuarioRequest::us_estado, AccesoPagina::NEG_TO_IN_SESION);

$criptador = new CriptManager();
$userRequest = new UsuarioRequest();
$userDTO = $userRequest->getUsuarioDTO();
$userDTO instanceof UsuarioDTO;
$userDTO->setEstado(base64_decode($userDTO->getEstado()));
$userDTO->setIdUsuario(base64_decode($userDTO->getIdUsuario()));

$modal = $userManager->activarCuentaUsuario($userDTO);
$sesion = SimpleSession::getInstancia();
$sesion instanceof SimpleSession;
$sesion->add(Session::NEGOCIO_RTA, $modal);
$acceso->irPagina(AccesoPagina::NEG_TO_IN_SESION);