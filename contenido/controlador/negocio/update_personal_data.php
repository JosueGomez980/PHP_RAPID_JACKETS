<?php

include_once 'cargar_clases2.php';
AutoCarga2::init();

$acceso = AccesoPagina::getInstacia();
$acceso instanceof AccesoPagina;
$acceso->comprobarSesion(AccesoPagina::NEG_TO_INICIO);

//Instanciacion de las clases controlador y manejador de sesion
$userManager = new UsuarioController();
$userRequest = new UsuarioRequest();
$cuetaManager = new CuentaController();
$cuentaRequest = new CuentaRequest();

$sesion = SimpleSession::getInstancia();
$sesion instanceof SimpleSession;

//Declaracion del objeto para manejar el modal.
$modal = new ModalSimple();
$elementoModal = NULL;

//Instancia de usuario en sesion y usuario obtenido por datos en metodo POST
$userPost = $userRequest->getUsuarioDTO();
$userDAO = UsuarioDAO::getInstancia();
$userDAO instanceof UsuarioDAO;
$userPost instanceof UsuarioDTO;
$userSession = $sesion->getEntidad(Session::US_LOGED);
$userSession instanceof UsuarioDTO;

////Instancia de cuenta en sesion y cuenta obtenido por datos en metodo POST
$cuentaPost = $cuentaRequest->getCuentaDTO();
$cuentaPost instanceof CuentaDTO;
$cuentaSession = $sesion->getEntidad(Session::CU_LOGED);
$cuentaSession instanceof CuentaDTO;

$ok = TRUE;

$modal->open();

if (!Validador::validaEmail($userPost->getEmail())) {
    $ok = FALSE;
    $elementoModal = new Errado();
    $elementoModal->setValor("El email digitado (" . Validador::fixTexto($userPost->getEmail()) . ") no cumple con los parámetros");
    $modal->addElemento($elementoModal);
}
//Validar que si el correo electronico es cambiado, siga siendo unico
$userByEmail = $userDAO->findByEmail($userPost);
if (!is_null($userByEmail)) {
    if ($userByEmail->getIdUsuario() !== $userSession->getIdUsuario()) {
        $error = new Errado();
        $error->setValor("El email digitado (" . Validador::fixTexto($userPost->getEmail()) . ") ya está en uso. Debe elegir otro");
        $modal->addElemento($error);
        $ok = FALSE;
    }
}


if (!Validador::validaText($cuentaPost->getPrimerNombre(), 2, 100)) {
    $error = new Errado();
    $error->setValor("El primer nombre no puede estar vacío. No puede ser muy corto ni muy largo");
    $modal->addElemento($error);
    $ok = FALSE;
}
if (!Validador::validaText($cuentaPost->getPrimerApellido(), 2, 100)) {
    $error = new Errado();
    $error->setValor("El apellido no puede estar vacío. No puede ser muy corto ni muy largo");
    $modal->addElemento($error);
    $ok = FALSE;
}
if (!Validador::validaTel($cuentaPost->getTelefono(), 7, 12)) {
    $error = new Errado();
    $error->setValor("El telefono solo debe tener numeros. Entre 7 y 12 números.");
    $modal->addElemento($error);
    $ok = FALSE;
}


if ($ok) {
    //Asignar a la cuenta que viene del post la llave primaria presente en cuenta que viene de los datos de session
    $cuentaPost->setUsuarioIdUsuario($cuentaSession->getUsuarioIdUsuario());
    $cuentaPost->setTipoDocumento($cuentaSession->getTipoDocumento());
    $cuentaPost->setNumDocumento($cuentaSession->getNumDocumento());
    $newEmail = $userPost->getEmail();
    $userPost = $userSession;
    $userPost->setEmail($newEmail);

    //Reasignar la contraseña guardada en la base de datos para evitar que se resetee
    $userDTO = $userDAO->find($userSession);
    $userPost->setPassword($userDTO->getPassword());

    //Se procede a ejecutar el metodo de actualizar tabla usuario
    $rta1 = $userManager->actualizar($userPost);
    //Se procede a ejecutar el metodo de actualizar la tabla cuenta
    $rta2 = $cuetaManager->actualizar($cuentaPost);

    if ($rta1 && $rta2) {

        //Quitar la contrasena del usuario que será alojado en sesion de nuevo
        $userPost->setPassword(NULL);
        //Cambiar los datos de la sesion (Para cuenta y para usuario);

        $sesion->addEntidad($userPost, Session::US_LOGED);
        $sesion->addEntidad($cuentaPost, Session::CU_LOGED);

        $elementoModal = new Exito();
        $elementoModal->setValor("Tus datos fueron actualizados correctamente.");
        $modal->addElemento($elementoModal);
    } else {
        $elementoModal = new Errado();
        $elementoModal->setValor("No se pudo hacer la modificación de los datos correctamente. Intente de nuevo");
        $modal->addElemento($elementoModal);
    }
} else {
    $elementoModal = new Errado();
    $elementoModal->setValor("No se pudo hacer la modificación de los datos correctamente");
    $modal->addElemento($elementoModal);
}
//Agregar el boton de aceptar para cerrar el modal y maquetarlo 
$closeBtn = new CloseBtn();
$closeBtn->setValor("Aceptar");
$modal->addElemento($closeBtn);
$modal->maquetar();
$modal->close();









