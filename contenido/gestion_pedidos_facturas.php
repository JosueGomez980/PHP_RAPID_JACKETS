<?php
include_once 'includes/ContenidoPagina.php';
include_once 'cargar_clases.php';

AutoCarga::init();
$acceso = AccesoPagina::getInstacia();
$acceso instanceof AccesoPagina;
$userManager = new UsuarioController();
$acceso->comprobarSesionAdmin(AccesoPagina::INICIO);
$contenido = ContenidoPagina::getInstancia();
$contenido instanceof ContenidoPagina;

$sesion = SimpleSession::getInstancia();
$sesion instanceof SimpleSession;
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <?php
    $contenido->getHead2();
    ?>
    <body>
        <?php
        $contenido->getHeader2();
        $contenido->mostrarRespuestaNegocio();
        ?>
        <section class="is-Fondo-03">
            <div id="RESPUESTA"></div>
            <?php
            $userManager->mostrarNavAdminUsuario();
//            $smtpOpt = array(
//                'ssl' => array(
//                    'verify_peer' => false,
//                    'verify_peer_name' => false,
//                    'allow_self_signed' => true
//            ));
//            $mail = new PHPMailer();
//            $mail->isSMTP();
//            $mail->Host = gethostbyname('smtp.gmail.com');
//            $mail->SMTPOptions = $smtpOpt;
//            $mail->SMTPSecure = 'tls';
//            $mail->SMTPAuth = true;
//            $mail->Port = 587;
//            $mail->Username = 'creacionesjulieth123@gmail.com';
//            $mail->Password = 'losjaponeses123';
//            $mail->setFrom('creacionesjulieth123@gmail.com', 'Creaciones Julieth');
//            $mail->addAddress('creacionesjulieth123@gmail.com');
//            $mail->Subject = 'Hello from PHPMailer!';
////            $mail->Body = 'This is a test.';
//            $mail->isHTML(true);
//            $mail->Body = "<h1>Hola mano</h1>";
//            if (!$mail->send()) {
//                echo "ERROR: " . $mail->ErrorInfo;
//            } else {
//                echo "SUCCESS";
//            }
            ?>
            <br><br>
            <div class="container-fluid is-Tamaño-ContainerXD w3-white" style="border-radius: 20px;">
                <br><br><center><h1><b>Este XDXD</b></h1></center><br><br>
            </div>
            <br><br>
        </section>
        <?php
        $contenido->getFooter2();
        ?>
    </body>
</html>

