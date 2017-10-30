<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'cargar_clases2.php';
AutoCarga2::init();

//Clases de controladores que se necesitan para empezar
$userDrawer = new UsuarioMaquetador();
$modal = new ModalSimple();
$userManager = new UsuarioController();
$userRequest = new UsuarioRequest(); //Clase para obtener los datos enviados por POST y para setearlos en un objeto de la clase UsuarioDTO
$cuetaManager = new CuentaController();
$cuentaRequest = new CuentaRequest();
//Igual que la aterior, pero esta maneja objetos CuentaDTO
$encripter = new CriptManager(); // Clase para encriptar contrasenias o cualquier otro dato
$userDTO = $userRequest->getUsuarioDTO(); //La instanciacio de un UsuarioDTO se hace con el geter de la clase request
$cuentaDTO = $cuentaRequest->getCuentaDTO(); //Aqui se obtiene la instancia de CuentaDTO generada en Request
$cuentaDTO instanceof CuentaDTO;
$userDTO instanceof UsuarioDTO;

$ok = TRUE; //Esta variable es la que al final del flujo dirá si se hace o no la insercion del usuario en la base de datos
//-------------------------------------
//-------------------------------------
//Completar campos de cada entidad (Aquellos que no debe ser gestionables por el usuario simple) //Ok??
$userDTO->setEstado(UsuarioDAO::EST_ACTIVO); //Esos dos puntos signican acceso a una constante o propiedad estatica de la clase
$userDTO->setRol(UsuarioDAO::ROL_USER);
//Validador es una clase con metodos estaticos que hice para validar basicamente cualquier dato.

$cuentaDTO->setSegundoNombre(Validador::nullable($cuentaDTO->getSegundoNombre()));
$cuentaDTO->setSegundoApellido(Validador::nullable($cuentaDTO->getSegundoApellido()));
$cuentaDTO->setUsuarioIdUsuario($userDTO->getIdUsuario()); //Cuenta y Usuario comparten el mismo ID
//Validacion de datos de la entidad UsuarioDTO

if (isset($_POST['user_passwordB'])) {
    $passB = $_POST['user_passwordB'];
}

if ($passB != $userDTO->getPassword()) {
    $error = new Errado();
    $error->setValor("Las contraseñas no coinciden");
    $modal->addElemento($error);
    $ok = FALSE;
}

if (!Validador::validaPassword($userDTO->getPassword())) {
    $error = new Errado();
    $error->setValor("La contraseña digitada es incorrecta. No cumple con los parámetros");
    $modal->addElemento($error);
    $ok = FALSE;
}

$userDTO->setPassword($encripter->complexEncriptDF($userDTO->getPassword()));

if (!Validador::validaUserName($userDTO->getIdUsuario())) {
    $error = new Errado();
    $error->setValor("El nombre usuario no cumple con los parámetros. O el formato no es admitido");
    $modal->addElemento($error);
    $ok = FALSE;
}
//$userDTO->setIdUsuario(Validador::fixTexto($userDTO->getIdUsuario())); //Arregla el idUsuario

if (!Validador::validaEmail($userDTO->getEmail())) {
    $error = new Errado();
    $error->setValor("¡El correo electronico digitado (" . $userDTO->getEmail() . ") es incorrecto!");
    $modal->addElemento($error);
    $ok = FALSE;
}
if (!is_null($userManager->encontrarByEmail($userDTO))) {
    $error = new Errado();
    $error->setValor("El correo electrónico digitado (" . Validador::fixTexto($userDTO->getEmail()) . ") ya está en uso. Por favor digite otro");
    $modal->addElemento($error);
    $ok = FALSE;
}
//$userDTO->setEmail(Validador::fixTexto($userDTO->getEmail())); //Arregla el email
//
//Validacion de datos de la entidad CuentaDTO

if (!Validador::validaNumDoc($cuentaDTO->getNumDocumento())) {
    $error = new Errado();
    $error->setValor("El Número de Documento ingresado no cumple con los parámetros.");
    $modal->addElemento($error);
    $ok = FALSE;
}
if (!Validador::validaText($cuentaDTO->getPrimerNombre(), 2, 100)) {
    $error = new Errado();
    $error->setValor("El nombre no puede estar vacío. No puede ser muy corto ni muy largo");
    $modal->addElemento($error);
    $ok = FALSE;
}
if (!Validador::validaText($cuentaDTO->getPrimerApellido(), 2, 100)) {
    $error = new Errado();
    $error->setValor("El apellido no puede estar vacío. No puede ser muy corto ni muy largo");
    $modal->addElemento($error);
    $ok = FALSE;
}
if (!Validador::validaTel($cuentaDTO->getTelefono(), 7, 12)) {
    $error = new Errado();
    $error->setValor("El telefono solo debe tener numeros. Entre 7 y 12 números.");
    $modal->addElemento($error);
    $ok = FALSE;
}
if ($cuetaManager->validaPK($cuentaDTO)) {
    $error = new Errado();
    $error->setValor("El numero de documento digitado ya está en uso. No puedes enviar este: " . $cuentaDTO->getNumDocumento());
    $modal->addElemento($error);
    $ok = FALSE;
}

//$cuentaDTO->setPrimerNombre(Validador::fixTexto($cuentaDTO->getPrimerNombre()));
//$cuentaDTO->setSegundoNombre(Validador::fixTexto($cuentaDTO->getSegundoNombre()));
//$cuentaDTO->setPrimerApellido(Validador::fixTexto($cuentaDTO->getPrimerApellido()));
//$cuentaDTO->setSegundoApellido(Validador::fixTexto($cuentaDTO->getSegundoApellido()));


$modal->open();
$modal->maquetar();
if ($ok) {
    if ($userManager->insertar($userDTO)) {
        $cuetaManager->insertar($cuentaDTO);
    }
} else {
    $error = new Errado();
    $error->setValor("No se pudo hacer el registro de los datos correctamente.");
    echo ($error->toString($error->getValor()));
}
$closeBtn = new CloseBtn();
$closeBtn->setValor("Aceptar");
echo($closeBtn->toString($closeBtn->getValor()));
$modal->close();
//Procesado de los datos informacion Personal



    