<?php

include_once 'cargar_clases2.php';
AutoCarga2::init();

$modal = new ModalSimple();
$sesion = new SimpleSession();
$crip = CriptManager::getInstacia();
$crip instanceof CriptManager;

$userManager = new UsuarioController();
$userRequest = new UsuarioRequest();

$userDAO = UsuarioDAO::getInstancia();
$cuentaDAO = CuentaDAO::getInstancia();

$userDTO = $userRequest->getUsuarioDTO();
$userDTO instanceof UsuarioDTO;
$userDAO instanceof UsuarioDAO;
$cuentaDAO instanceof CuentaDAO;

$modal->open();

$ok = TRUE;
$logeo = TRUE;
$modo = "USERID";
if (Validador::validaEmail($userDTO->getIdUsuario())) {
    $modo = "EMAIL";
    if (!Validador::validaEmail($userDTO->getIdUsuario())) {
        $error = new Errado();
        $error->setValor("El email digitado (" . Validador::fixTexto($userDTO->getIdUsuario()) . ") no cumple con los parámetros");
        $modal->addElemento($error);
        $ok = FALSE;
    }
} else {
    if (!Validador::validaUserName($userDTO->getIdUsuario())) {
        $error = new Errado();
        $error->setValor("El nombre de usuario no es correcto. No cumple con los parámetros");
        $modal->addElemento($error);
        $ok = FALSE;
    }
}

if (!Validador::validaPassword($userDTO->getPassword())) {
    $error = new Errado();
    $error->setValor("La contraseña es incorrecta. No cumple con los parámetros");
    $modal->addElemento($error);
    $ok = FALSE;
}
$userFinded = NULL;
if ($ok) {
    switch ($modo) {
        case "EMAIL": {
                $userDTO->setEmail($userDTO->getIdUsuario());
                if (is_null($userManager->encontrarByEmail($userDTO))) {
                    $error = new Errado();
                    $error->setValor("El email digitado (" . Validador::fixTexto($userDTO->getEmail()) . ") no existe.");
                    $modal->addElemento($error);
                    $logeo = FALSE;
                } else {
                    $userFinded = $userManager->encontrarByEmail($userDTO);
                }
                break;
            }
        case "USERID": {
                if ($userManager->validaPK($userDTO)) {
                    
                } else {
                    $userFinded = $userDAO->find($userDTO);
                }
                break;
            }
    }
    if (!is_null($userFinded)) {
        if ($userFinded->getEstado() == UsuarioDAO::EST_INACTIVO || $userFinded->getEstado() == UsuarioDAO::EST_ELIMINADO) {
            $error = new Errado();
            $error->setValor("El usuario digitado (" . Validador::fixTexto($userDTO->getIdUsuario()) . ") ha sido retirado del sistema. Por favor contacte al administrador.");
            $modal->addElemento($error);
            $logeo = FALSE;
        }
        if ($logeo) {
            $hashedPassword = $userFinded->getPassword();
            if ($crip->verificaPassword($hashedPassword, $userDTO->getPassword())) {
                $exito = new Exito();
                $exito->setValor("Logeo Exitoso <br>");
                $modal->addElemento($exito);
                $enlace = new Neutral();
                $enlace->setValor("<a href='inicio.php'><span class='w3-tag w3-teal w3-large w3-round-large'>Continuar</span></a>");
                $modal->addElemento($enlace);

                //Colocar en sesion los elementos 
                $userFinded->setPassword(NULL);
                $cuDTO = new CuentaDTO();
                $cuDTO->setUsuarioIdUsuario($userFinded->getIdUsuario());
                $cuentaFinded = $cuentaDAO->findByUsuario($cuDTO);
                //Verificar que el usuario logeado es un manager o subManager;
                if ($userManager->validaManagerLogin($userFinded)) {
                    $sesion->addEntidad($userFinded, Session::US_ADMIN_LOGED);
                    $sesion->addEntidad($cuentaFinded, Session::CU_ADMIN_LOGED);
                } else if ($userManager->validaSubManagerLogin($userFinded)) {
                    $sesion->addEntidad($userFinded, Session::US_SUB_ADMIN_LOGED);
                    $sesion->addEntidad($cuentaFinded, Session::CU_SUB_ADMIN_LOGED);
                }
                //Pasar a session
                $sesion->addEntidad($userFinded, Session::US_LOGED);
                $sesion->addEntidad($cuentaFinded, Session::CU_LOGED);
            } else {
                $error = new Errado();
                $error->setValor("La contraseña de este usuario es incorrecta.");
                $modal->addElemento($error);

                $closeBtn = new CloseBtn();
                $closeBtn->setValor("Aceptar");
                $modal->addElemento($closeBtn);
            }
        } else {
            $closeBtn = new CloseBtn();
            $closeBtn->setValor("Aceptar");
            $modal->addElemento($closeBtn);
        }
    } else {
        $error = new Errado();
        $error->setValor("El usuario o el correo digitado no existe.");
        $modal->addElemento($error);
        $closeBtn = new CloseBtn();
        $closeBtn->setValor("Aceptar");
        $modal->addElemento($closeBtn);
    }
    //Validar que el usuario no esté activo para autorizar el login
} else {
    $error = new Errado();
    $error->setValor("No se pudo iniciar sesion :(");
    $modal->addElemento($error);

    $closeBtn = new CloseBtn();
    $closeBtn->setValor("Aceptar");
    $modal->addElemento($closeBtn);
}

$modal->maquetar();
$modal->close();

