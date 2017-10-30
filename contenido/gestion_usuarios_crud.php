<?php
require_once 'includes/ContenidoPagina.php';
require_once 'cargar_clases.php';
AutoCarga::init();
$acceso = AccesoPagina::getInstacia();
$acceso instanceof AccesoPagina;
$sesion = SimpleSession::getInstancia();
$sesion instanceof SimpleSession;
$acceso->comprobarSesionMainAdmin(AccesoPagina::INICIO);
$userManager = new UsuarioController();
$userDAO = UsuarioDAO::getInstancia();
$userDAO instanceof UsuarioDAO;
$fullTablaUsuarios = $userDAO->findAll();
$numUsers = count($fullTablaUsuarios);

$paginador = new PaginadorMemoria(10, 0, $fullTablaUsuarios);
$tablaUsuariosPaginada = $paginador->firstPage();
$paginador->init("usuario_paginacion.php", "USUARIOS_CRUD");
$sesion->add(Session::PAGINADOR, $paginador);
?>

<!DOCTYPE html>

<html>

    <?php
    $contenido = ContenidoPagina::getInstancia();
    $contenido instanceof ContenidoPagina;
    $contenido->getHead2();
    ?>
    <body>
        <?php
        $contenido->getHeader2();
        $contenido->mostrarRespuestaNegocio();
        ?>
        <section class="m-section">
            <div class="w3-row w3-padding-4">
                <div class="w3-half w3-container">

                    <div class="w3-block w3-center">
                        <button class="btn btn-success" onclick="mostrarFormularioAgregarUsuario()">
                            <span class="glyphicon glyphicon-plus"></span>
                            <span class="glyphicon glyphicon-user"></span> Nuevo usuario
                        </button>
                    </div>

                    <label for="user_rol" class="labels">Mostrar: </label>
                    <select name="rol_user" id="rol_user" class="form-control">
                        <option value="1" selected>Rol - Cliente Corriente</option>
                        <option value="2">Rol - Cliente Particular</option>
                        <option value="3">Rol - Institucion Educativa</option>                          
                        <option value="4">Rol - Administrador</option>                          
                        <option value="6" selected>Todos</option>                          
                    </select>
                    <label class="labels">Según estado</label>
                    <label class="radio-inline"><input type="radio" id="us_est_ena" checked name="user_estado" value="<?php echo(UsuarioDAO::EST_ACTIVO); ?>">Activo</label>
                    <label class="radio-inline"><input type="radio" id="us_est_dis" name="user_estado" value="<?php echo(UsuarioDAO::EST_INACTIVO); ?>">Desactivado</label>
                    <br><br>
                    <button class="btn btn-info btn-sm" onclick="mostrarUsuariosPorRolyEstado();">
                        Buscar  <span class="glyphicon glyphicon-search"></span>
                    </button>
                    <span id="loading_gif"></span>
                </div>
                <div class="w3-half w3-container">                
                    <label class="labels">Buscar por documento</label>
                    <div class="input-group col-xs-10">
                        <input type="number" class="form-control" name="cuenta_num_doc" id="cuenta_num_doc" placeholder="Num Documento">            
                        <span class="input-group-addon"><i class="glyphicon glyphicon-search btn btn-xs" onclick="mostrarUsuariosPorNumDoc();"></i></span>
                    </div>  
                    <label class="labels">Buscar por Id de Usuario</label>
                    <div class="input-group col-xs-10">
                        <input type="text" class="form-control" name="user_id" id="user_id" placeholder="Id a buscar" onkeyup="mostrarUsuariosPorIdLike();">            
                        <span class="input-group-addon"><i class="glyphicon glyphicon-search btn btn-xs" onclick="mostrarUsuariosPorIdLike():"></i></span>
                    </div>
                </div>
            </div>
            <div id="RESPUESTA"></div>
            <div id="USUARIOS_CRUD_ALL">
                <div id="USUARIOS_CRUD">
                    <div id="BARRA_PAGINACION_A">
                        <?php
                        $paginador->maquetarBarraPaginacion();
                        ?>
                    </div>
                    <?php
                    $userManager->mostrarTablaCrudUsuarios($tablaUsuariosPaginada, $numUsers);
                    ?>
                    <div id="BARRA_PAGINACION_B">
                        <?php
                        $paginador->maquetarBarraPaginacion();
                        ?>
                    </div>
                </div>
            </div>

            <div class="cleaner"></div>
        </section>  
        <?php
        $contenido->getFooter2();
        ?>
    </body>

</html>


