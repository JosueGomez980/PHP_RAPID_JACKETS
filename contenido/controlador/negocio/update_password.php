<?php

include_once 'cargar_clases2.php';
AutoCarga2::init();

$acceso = AccesoPagina::getInstacia();
$acceso instanceof AccesoPagina;
$acceso->comprobarSesion(AccesoPagina::NEG_TO_INICIO);

$passwordR = $_POST['user_passwordB'];
//Instanciacion de las clases controlador y manejador de sesion
$userManager = new UsuarioController();
$userRequest = new UsuarioRequest();
$cripter = CriptManager::getInstacia();
$cripter instanceof CriptManager;

$sesion = SimpleSession::getInstancia();
$sesion instanceof SimpleSession;

//Declaracion del objeto para manejar el modal.
$modal = new ModalSimple();
$elementoModal = NULL;

//Instancia de usuario en sesion y usuario obtenido por datos en metodo POST
$userPost = $userRequest->getUsuarioDTO();
$userPost instanceof UsuarioDTO;
$userSession = $sesion->getEntidad(Session::US_LOGED);
$userSession instanceof UsuarioDTO;

$ok = TRUE;
$modal->open();

$userPost->setIdUsuario($userSession->getIdUsuario());

if (!Validador::validaPassword($userPost->getPassword())) {
    $ok = FALSE;
    $elementoModal = new Errado();
    $elementoModal->setValor("La contraseña digitada debe tener mínimo 8 caracteres y 3 dígitos");
    $modal->addElemento($elementoModal);
}
if ($passwordR !== $userPost->getPassword()) {
    $ok = FALSE;
    $elementoModal = new Errado();
    $elementoModal->setValor("La contraseñas no coinciden");
    $modal->addElemento($elementoModal);
}

if ($ok) {
    $userPost->setPassword($cripter->simpleEncriptDF($userPost->getPassword()));
    $rta = $userManager->cambiarContrasena($userPost);
    if ($rta) {
        $elementoModal = new Exito();
        $elementoModal->setValor("Tu contraseña ha sido actualizada. ");
        $modal->addElemento($elementoModal);
    } else {
        $elementoModal = new Errado();
        $elementoModal->setValor("Error al cambiar la contraseña");
        $modal->addElemento($elementoModal);
    }
} else {
    $elementoModal = new Errado();
    $elementoModal->setValor("No se pudo cambiar tu contraseña");
    $modal->addElemento($elementoModal);
}

$closeBtn = new CloseBtn();
$closeBtn->setValor("Aceptar");
$modal->addElemento($closeBtn);
$modal->maquetar();
$modal->close();
