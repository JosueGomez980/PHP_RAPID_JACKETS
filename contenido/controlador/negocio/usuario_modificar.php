<?php
include_once 'cargar_clases2.php';
AutoCarga2::init();

$acceso = AccesoPagina::getInstacia();
$acceso instanceof AccesoPagina;
$acceso->comprobarSesionMainAdmin(AccesoPagina::NEG_TO_INICIO);
$sesion = SimpleSession::getInstancia();
$sesion instanceof SimpleSession;
//Clases de controladores que se necesitan para empezar
$userDrawer = new UsuarioMaquetador();
$modal = new ModalSimple();
$userManager = new UsuarioController();
$userRequest = new UsuarioRequest(); //Clase para obtener los datos enviados por POST y para setearlos en un objeto de la clase UsuarioDTO
$cuetaManager = new CuentaController();
$cuentaRequest = new CuentaRequest();
$userDAO = new UsuarioDAO();
$cuentaDAO = new CuentaDAO();
//Igual que la aterior, pero esta maneja objetos CuentaDTO
$encripter = new CriptManager(); // Clase para encriptar contrasenias o cualquier otro dato
$userDTO = $userRequest->getUsuarioDTO(); //La instanciacio de un UsuarioDTO se hace con el geter de la clase request
$cuentaDTO = $cuentaRequest->getCuentaDTO(); //Aqui se obtiene la instancia de CuentaDTO generada en Request
$cuentaDTO instanceof CuentaDTO;
$userDTO instanceof UsuarioDTO;

$ok = TRUE;

$cuentaDTO->setSegundoNombre(Validador::nullable($cuentaDTO->getSegundoNombre()));
$cuentaDTO->setSegundoApellido(Validador::nullable($cuentaDTO->getSegundoApellido()));
$cuentaDTO->setUsuarioIdUsuario($userDTO->getIdUsuario());

//Obtener usuario y cuenta originales de la bd
$userDTOFinded = $userDAO->find($userDTO);
$cuentaDTOFinded = $cuentaDAO->findByUsuario($cuentaDTO);


if (isset($_POST['user_passwordB'])) {
    $passB = $_POST['user_passwordB'];
}
if (isset($_POST["rol_user"])) {
    $numRol = (int) filter_input(INPUT_POST, "rol_user");
    if ($userManager->formatRolUser($numRol) != "NONE") {
        //Parte critica para la asignación del rol  
        $rolFinalUser = $userManager->formatRolUser($numRol);
        $userDTO->setRol($rolFinalUser);
    } else {
        $ok = FALSE;
        $error = new Errado();
        $error->setValor("El rol del Usuario no tiene el formato correcto");
        $modal->addElemento($error);
    }
}
//Validacion de la existencia de una nueva contraseña
if (Validador::validaText($userDTO->getPassword(), 8, 150) && Validador::validaText($passB, 8, 150)) {
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
} else {
    $userDTO->setPassword($userDTOFinded->getPassword());
}


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
//Validar que el nuevo email digitado no exista y que sea diferente al ya existente
if (!is_null($userManager->encontrarByEmail($userDTO)) && $userDTOFinded->getEmail() != $userDTO->getEmail()) {
    $error = new Errado();
    $error->setValor("El correo electrónico digitado (" . Validador::fixTexto($userDTO->getEmail()) . ") ya está en uso. Por favor digite otro");
    $modal->addElemento($error);
    $ok = FALSE;
}
$userDTO->setEmail(Validador::fixTexto($userDTO->getEmail())); //Arregla el email
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
if ($cuetaManager->validaPK($cuentaDTO) && ($cuentaDTO->getNumDocumento() != $cuentaDTOFinded->getNumDocumento())) {
    $error = new Errado();
    $error->setValor("El numero de documento digitado ya está en uso. No puedes enviar este: " . $cuentaDTO->getNumDocumento());
    $modal->addElemento($error);
    $ok = FALSE;
}

$cuentaDTO->setPrimerNombre(Validador::fixTexto($cuentaDTO->getPrimerNombre()));
$cuentaDTO->setSegundoNombre(Validador::fixTexto($cuentaDTO->getSegundoNombre()));
$cuentaDTO->setPrimerApellido(Validador::fixTexto($cuentaDTO->getPrimerApellido()));
$cuentaDTO->setSegundoApellido(Validador::fixTexto($cuentaDTO->getSegundoApellido()));

if ($ok) {
    if ($userManager->actualizar($userDTO) && ($userDAO->putRol($userDTO) != -1)) {
        $exito = new Exito();
        $exito->setValor("Los datos del usuario (" . $userDTOFinded->getIdUsuario() . ") fueron actualizados correctamente");
        $modal->addElemento($exito);
    }
    if ($cuetaManager->actualizar($cuentaDTO)) {
        $exito = new Exito();
        $exito->setValor("Los datos personales del usuario (" . $userDTOFinded->getIdUsuario() . ") fueron actualizados correctamente");
        $modal->addElemento($exito);
    }
} else {
    $error = new Errado();
    $error->setValor("No se pudo hacer la modificacion de los datos correctamente.");
    $modal->addElemento($error);
}
$closeBtn = new CloseBtn();
$closeBtn->setValor("Aceptar");
$modal->addElemento($closeBtn);
$sesion->add(Session::NEGOCIO_RTA, $modal);

$acceso->irPagina(AccesoPagina::NEG_TO_ADM_PN_GST_USR);



