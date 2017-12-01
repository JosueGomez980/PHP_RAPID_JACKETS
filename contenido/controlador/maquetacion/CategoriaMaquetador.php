<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CategoriaMaquetador
 *
 * @author Josué Francisco
 */
class CategoriaMaquetador implements GenericMaquetador {

    public function maquetaArrayObject(array $entidades) {
        $tablaCompleta = SimpleSession::getInstancia()->getEntidad(Session::PAGINADOR)->getTablaCompleta();
        $cantidadT = count($tablaCompleta);
        $cantidad = count($entidades);
        echo('<div class="container-fluid is-Tamaño-ContainerXD">
                <div class="w3-card-4">
                <div class="w3-round-large w3-xlarge w3-container is-Color28">
                    Registradas ' . $cantidadT . ' Categorias
                    <br><span class="w3-tag w3-round-medium w3-small is-Color29">Se muestran ' . $cantidad . ' Categorias</span>
                </div>  
                <table class="w3-table-all w3-small w3-responsive">');
        echo('<tr class="w3-light-green">
                        <th class="w3-center">NOMBRE DE LA CATEGORIA</th>
                        <th class="w3-center">ESTADO</th>
                        <th class="w3-center">MODIFICAR</th>
                        <th class="w3-center">ACCION</th>
                    </tr>');
        foreach ($entidades as $cat) {
            $cat instanceof CategoriaDTO;
            $idCatUrl = CriptManager::urlVarEncript($cat->getIdCategoria());
            $nombre = Validador::fixTexto($cat->getNombre());
            $estado = $cat->getActiva();
            $estado_S = "";
            if ($estado) {
                $estado_S = "ACTIVA";
                echo('<tr class="is-hover-Color30 w3-white">');
            } else {
                $estado_S = "INACTIVA";
                echo('<tr class="w3-hover-gray w3-gray">');
            }

            echo('<td>' . $nombre . '</td>
                    <td class="w3-center">' . $estado_S . '</td>
                    <td class="w3-center">
                        <img src="../media/img/ModificarXD Otra.png" class="m-crud_icons" onclick="mostrarFormUpdateCategoria(\'' . $idCatUrl . '\')"> 
                    </td>
                 <td class="w3-center">');
            if ($estado) {
                echo('<button class="w3-btn w3-tiny is-Button-CancelarXD-Inverted" onclick="disableEnableCategoria(\'' . $idCatUrl . '\');">Desactivar</button>');
            } else {
                echo('<button class="w3-btn w3-tiny is-Button-CarritoXD-Inverted" onclick="disableEnableCategoria(\'' . $idCatUrl . '\');">Activar</button>');
            }
            echo('</td></tr>');
        }

        echo('</table></div></div>');
    }

    public function maquetaObject(EntityDTO $entidad) {
        
    }

    public function maquetaCategoriasSelect(array $categorias, $name, $id, $selected) {
        echo('<select name="' . $name . '" id="' . $id . '" class="m-selects">\n');
        if (is_object($selected) && !is_null($selected)) {
            $selected instanceof CategoriaDTO;
            echo('\t<option value="' . CriptManager::urlVarEncript($selected->getIdCategoria()) . '" selected>' . Validador::fixTexto($selected->getNombre()) . '</option>\n');
        } else {
            echo('\t<option value="' . CriptManager::urlVarEncript(0) . '" selected>Seleccionar</option>\n');
        }
        foreach ($categorias as $cat) {
            $cat instanceof CategoriaDTO;
            $idCat = CriptManager::urlVarEncript($cat->getIdCategoria());
            $nombre = Validador::fixTexto($cat->getNombre());
            //No mostrar categorías 
            if ($cat->getActiva() && $cat->getIdCategoria() !== $cat->getCategoriaIdCategoria()) {
                echo('\t<option value="' . $idCat . '">' . $nombre . '</option>\n');
            }
        }
        echo('</select>');
    }

    public function maquetaFormularioUpdate(CategoriaDTO $categoria) {
        $modal = new ModalSimple();
        $categoriaDAO = CategoriaDAO::getInstancia();
        $categoriaDAO instanceof CategoriaDAO;
        $tablaCategorias = $categoriaDAO->findAll();
        $idCategoria = ($categoria->getIdCategoria());
        $nombre = Validador::fixTexto($categoria->getNombre());
        $descripcion = Validador::fixTexto($categoria->getDescripcion());
        $categoriaSearch = new CategoriaDTO();
        $categoriaSearch->setIdCategoria($categoria->getCategoriaIdCategoria());
        $categoriaPadre = $categoriaDAO->find($categoriaSearch);
        $modal->open();

        echo('<div class="container-fluid w3-theme-d1">
                <form action="controlador/negocio/categoria_update.php" method="POST" name="update_categoria_form" id="update_categoria_form">
                    <div class="container-fluid is-Tamaño-ContainerXD">
                        <br>
                        <input type="hidden" name="' . CategoriaRequest::id_cat . '" value="' . $idCategoria . '" id="' . CategoriaRequest::id_cat . '">
                        <span class="w3-text-shadow w3-xlarge w3-block w3-center">Actualizar Categoría</span><hr class="is-Color19"><br>
                        <div class="form-group">
                            <label class="labels col-lg-3 control-label">Nombre de la categoría </label>
                            <div class="col-lg-8">
                                <input type="text" class="input_texto" onblur="valida_simple_input(this)" name="' . CategoriaRequest::name_cat . '" id="' . CategoriaRequest::name_cat . '" value="' . $nombre . '">
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="labels col-lg-3 control-label">Descripcion de la categoría</label>
                            <div class="col-lg-8">
                            <textarea class="m-textarea" id="' . CategoriaRequest::desc_cat . '" name="' . CategoriaRequest::desc_cat . '">' . $descripcion . '</textarea>
                            </div>
                        </div>
                        <br><br><br><br><br>
                        <ul class="w3-ul w3-tiny w3-bordered w3-yellow">
                            <li>Se le sugiere que la categoria a la que pertenece no sea esta misma categoria</li>
                        </ul>
                        <div class="form-group">
                            <label class="labels col-lg-3 control-label">Categoría a la que pertenece</label>
                            <div class="col-lg-8">');
                                $this->maquetaCategoriasSelect($tablaCategorias, CategoriaRequest::cat_id_cat, CategoriaRequest::cat_id_cat, $categoriaPadre);
                        echo('</div>
                        </div>
                        <div class="w3-center">
                            <input type="submit" class="is-Button-CarritoXD-Inverted" value="Aplicar">
                            <input type="reset" class="is-Button-BorrarXD-Inverted" value="Borrar">
                        </div>
                        <br>
                    </div>
                </form>
            </div>');

        $closeBtn = new CloseBtn();
        $closeBtn->setValor("Cerrar");
        $modal->addElemento($closeBtn);
        $modal->maquetar();
        $modal->close();
    }

    public function maquetaFormularioInsert() {
        $categoriaDAO = CategoriaDAO::getInstancia();
        $categoriaDAO instanceof CategoriaDAO;
        $tablaCategorias = $categoriaDAO->findAll();

        echo('<div class="w3-row w3-container w3-padding-24 w3-light-green">
                <div class="container-fluid is-Tamaño-ContainerXD">
                <h3 class="w3-center" style="color: #fff; font-weight:bolder;">Insertar Categoria</h3><hr class="is-Color19">
                <br>
                <form action="controlador/negocio/categoria_insert.php" method="POST" name="categoria_insert" id="categoria_insert">
                    <div class="form-group">
                        <label class="labels col-lg-3 control-label">Nombre</label>
                    <div class="col-lg-8">
                    <input type="text" minlength="5" maxlength="150" required placeholder="Nombre de la categoria" id="' . CategoriaRequest::name_cat . '" name="' . CategoriaRequest::name_cat . '" class="input_texto" onblur="valida_simple_input2(this, 5, 150);">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="labels col-lg-3 control-label">Descripcion de la categoria</label>
                    <div class="col-lg-8">   
                        <textarea class="is-Textarea-OtraCosa" id="' . CategoriaRequest::desc_cat . '" name="' . CategoriaRequest::desc_cat . '" placeholder="Descripción - Opcional"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="labels col-lg-3 control-label">Categoría a la que pertenece</label>
                        <div class="col-lg-8">');
        $this->maquetaCategoriasSelect($tablaCategorias, CategoriaRequest::cat_id_cat, CategoriaRequest::cat_id_cat, null);
        echo('          </div>
                    </div>
                    <div class="w3-center">
                        <input type="submit" name="" id="" class="is-Button-CarritoXD-Inverted" value="Agregar">
                        <a href="gestion_categorias.php"><button class="w3-btn is-Button-CancelarXD-Inverted">Cancelar</button></a>
                    </div>
                </form>
                </div>
                <br>
            </div>');
    }
    
    public function generarStringReporteA(array $categorias, $hojaCss) {
        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;
        $cuentaAdmin = $sesion->getEntidad(Session::CU_ADMIN_LOGED);
        $cuentaAdmin instanceof CuentaDTO;
        $userAdmin = $sesion->getEntidad(Session::US_ADMIN_LOGED);
        $userAdmin instanceof UsuarioDTO;
        $idUser = utf8_decode($userAdmin->getIdUsuario());
        $nombreAdmin = utf8_decode($cuentaAdmin->getPrimerNombre() . " " . $cuentaAdmin->getPrimerApellido());
        $dater = new DateManager();
        $fecha = $dater->dateSpa1();
        $salida = null;
        $salida = '<style>' . $hojaCss . '</style>';
        $cantidad = count($categorias);
        $salida .= ('  
                <div class="is-Head-XD" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                    <p class="is-PXD" style="text-align: right;">
                    ' . $fecha . '
                    <p class="is-PXD">
                     <center><div class="is-Imgen-Logo-Report"><img src="../media/img/LogoCreaciones.png"></div></center> 
                     <p class="is-PXD">
                        Obtenidas ' . $cantidad . ' Categorias<br><br>
                        Reporte solicitado por: ' . $nombreAdmin . ' (' . $idUser . ')
                     </p>     
                </div>
               <table class="is-Tabla-Heidy" style="width: 100%;">
                    <tr class="lol">
                        <th class="is-Tabla-Heidy-Tr">ID de Categoria</th>
                        <th class="is-Tabla-Heidy-Tr">Nombre de Categoria</th>
                        <th class="is-Tabla-Heidy-Tr">Estado</th>
                        <th class="is-Tabla-Heidy-Tr">Categoria Asociada</th>
                    </tr>');
        $CateDAO = CategoriaDAO::getInstancia();
        $CateDAO instanceof CategoriaDAO;
        foreach ($categorias as $cat) {
            $catSearch = new CategoriaDTO();
            $catSearch->setIdCategoria($cat->getCategoriaIdCategoria());
            $cateFinded = $CateDAO->find($catSearch);
            $cat instanceof CategoriaDTO;
            $idCategoria = $cat->getIdCategoria();
            $nombre = $cat->getNombre();
            $CatgoriaAso = $cateFinded->getNombre();
            $estado = $cat->getActiva();

            $salida .= '<tr class="lol">
                        <td class="is-Tabla-Heidy-Th"><center>' . $idCategoria . '</center></td>
                        <td class="is-Tabla-Heidy-Th">' . $nombre . '</td>';
            if ($estado) {
                $salida .= '<td class="is-Tabla-Heidy-Th"><center>Activa</center></td>';
            } else {
                $salida .= '<td class="is-Tabla-Heidy-Th"><center>Inactiva</center></td>';
            }
            $salida .= '<td class="is-Tabla-Heidy-Th">' . $CatgoriaAso . '</td>'
                    . '</tr>';
        }
        $salida .= '</table>';
        return $salida;
    }

}
