<header>

    <span class="w3-opennav w3-xxxlarge w3-hide-large w3-theme-light w3-display-topleft" style="position: fixed; z-index: 1;" onclick="show_sidebar('admin_main_menu')">
        ☰
    </span>
    <div class="w3-sidenav w3-theme-d5 w3-card-4 w3-animate-left" id="admin_main_menu" style="display: none">
        <a href="javascript:void(0)" onclick="hide_sidebar('admin_main_menu')" class="w3-closenav w3-large w3-hide-large w3-hover-red">Cerrar ×</a>
        <a href="gestion_productos.php" class="w3-padding-4 w3-hover-blue">Gestión de Productos</a>
        <a href="gestion_categorias.php" class="w3-padding-4 w3-hover-light-blue">Gestión de Categorías</a>
        <!--<a href="#" class="w3-padding-4 w3-hover-gray">Gestión de Catalogos</a>-->
        <a href="gestion_inventarios.php" class="w3-padding-4 w3-hover-amber">Gestión de Inventarios</a>
        <a href="gestion_usuarios_crud.php" class="w3-padding-4 w3-hover-yellow">Gestión de Usuarios</a>
        <!--<a href="#" class="w3-padding-4 w3-hover-green">Gestión de Pedidos</a>-->
        <!--<a href="#" class="w3-padding-4 w3-hover-lime">Gestión de Facturas</a>-->
        <a href="gestion_reportes.php" class="w3-padding-4 w3-hover-black">Gestión de Reportes</a>
        <a href="inicio.php" class="w3-padding-4 w3-hover-aqua">Pagina de Inicio</a>
    </div>

    <a name="UP"></a>
    <div class="m-header2 w3-theme-d1">
        <div class="w3-row">
            <div class="w3-quarter w3-container">
                <img class="m-logo" src="../media/img/logo.png" alt="Logo de Creaciones Julieth" title="Creaciones Julieth">
            </div>
            <div class="w3-threequarter w3-container">
                <div class="tit1">Creaciones Juliet</div>
                <span class="tit2">Panel de <i>Administrador</i></span>
            </div>
        </div>
    </div>

    <a name="UP"></a>
    <a href="#UP"><button class="m-boton-go-up">&uparrow;</button></a>

    <nav class="m-nav">
        <ul class="w3-navbar w3-theme-dark w3-hide-medium w3-hide-small w3-small">
            <li><a href="gestion_productos.php" class="w3-padding-4 w3-hover-blue">Gestión de Productos</a></li>
            <li><a href="gestion_categorias.php" class="w3-padding-4 w3-hover-light-blue">Gestión de Categorías</a></li>
            <!--<li><a href="#" class="w3-padding-4 w3-hover-gray">Gestión de Catalogos</a></li>-->
            <li><a href="gestion_inventarios.php" class="w3-padding-4 w3-hover-amber">Gestión de Inventarios</a></li>
            <li><a href="gestion_usuarios_crud.php" class="w3-padding-4 w3-hover-yellow">Gestión de Usuarios</a></li>
            <!--<li><a href="#" class="w3-padding-4 w3-hover-green">Gestión de Pedidos</a></li>-->
            <!--<li><a href="#" class="w3-padding-4 w3-hover-lime">Gestión de Facturas</a></li>-->
            <li><a href="gestion_reportes.php" class="w3-padding-4 w3-hover-black">Gestión de Reportes</a></li>
            <li><a href="inicio.php" class="w3-padding-4 w3-hover-aqua">Pagina de Inicio</a></li>
        </ul>
    </nav>

</header>