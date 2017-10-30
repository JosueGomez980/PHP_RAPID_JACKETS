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
        echo('<div class="w3-theme-l4 w3-card-4">
                <div class="w3-round-large w3-teal w3-xlarge w3-container">
                    Registradas ' . $cantidadT . ' Categorias
                    <br><span class="w3-tag w3-round-medium w3-small w3-blue-gray">Se muestran ' . $cantidad . ' Categorias</span>
                </div>  
                <table class="w3-table-all w3-small w3-responsive">');
        echo('<tr class="w3-light-green">
                        <th>NOMBRE DE LA CATEGORIA</th>
                        <th>ESTADO</th>
                        <th>MODIFICAR</th>
                        <th>ACCION</th>
                    </tr>');
        foreach ($entidades as $cat) {
            $cat instanceof CategoriaDTO;
            $idCatUrl = CriptManager::urlVarEncript($cat->getIdCategoria());
            $nombre = Validador::fixTexto($cat->getNombre());
            $estado = $cat->getActiva();
            $estado_S = "";
            if ($estado) {
                $estado_S = "ACTIVA";
                echo('<tr class="w3-hover-light-blue w3-white">');
            } else {
                $estado_S = "INACTIVA";
                echo('<tr class="w3-hover-light-blue w3-gray">');
            }

            echo('<td>' . $nombre . '</td>
                    <td>' . $estado_S . '</td>
                    <td>
                        <img src="../media/img/update_icon.png" class="m-crud_icons" onclick="mostrarFormUpdateCategoria(\'' . $idCatUrl . '\')"> 
                    </td>
                 <td>');
            if ($estado) {
                echo('<button class="w3-btn w3-tiny w3-red w3-round w3-hover-gray" onclick="disableEnableCategoria(\'' . $idCatUrl . '\');">Desactivar</button>');
            } else {
                echo('<button class="w3-btn w3-tiny w3-green w3-round w3-hover-gray" onclick="disableEnableCategoria(\'' . $idCatUrl . '\');">Activar</button>');
            }
            echo('</td></tr>');
        }

        echo('</table></div>');
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

        echo('<div class="w3-row w3-theme-d1">
                <form action="controlador/negocio/categoria_update.php" method="POST" name="update_categoria_form" id="update_categoria_form">
                    <div class="w3-card-8 w3-padding-4">
                        <input type="hidden" name="' . CategoriaRequest::id_cat . '" value="' . $idCategoria . '" id="' . CategoriaRequest::id_cat . '">
                        <span class="w3-text-shadow w3-xlarge w3-block w3-center">Actualizar Categoría</span><br>
                        <label class="labels">Nombre de la categoría </label>
                        <input type="text" class="input_texto" onblur="valida_simple_input(this)" name="' . CategoriaRequest::name_cat . '" id="' . CategoriaRequest::name_cat . '" value="' . $nombre . '">
                        <br>
                        <label class="labels">Descripcion de la categoría</label>
                        <textarea class="m-textarea" id="' . CategoriaRequest::desc_cat . '" name="' . CategoriaRequest::desc_cat . '">
                            ' . $descripcion . '
                        </textarea>
                        <br>
                        <label class="labels">Categoría a la que pertenece</label>
                        <br>
                         <ul class="w3-ul w3-tiny w3-bordered w3-yellow">
                <li>Se le sugiere que la categoria a la que pertenece no sea esta misma categoria</li>
            </ul>');
        $this->maquetaCategoriasSelect($tablaCategorias, CategoriaRequest::cat_id_cat, CategoriaRequest::cat_id_cat, $categoriaPadre);

        echo('<div class="w3-center">
                            <input type="submit" class="w3-btn w3-green w3-small w3-round-medium" value="Aplicar">
                            <input type="reset" class="w3-btn w3-gray w3-small w3-round-medium" value="Borrar">
                        </div>
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
                <form action="controlador/negocio/categoria_insert.php" method="POST" name="categoria_insert" id="categoria_insert">
                    <label class="labels">Nombre</label>
                    <input type="text" minlength="5" maxlength="150" required placeholder="Nombre de la categoria" id="' . CategoriaRequest::name_cat . '" name="' . CategoriaRequest::name_cat . '" class="input_texto" onblur="valida_simple_input2(this, 5, 150);">
                    <br>
                    <label class="labels">Descripcion de la categoria</label>
                    <textarea class="m-textarea" id="' . CategoriaRequest::desc_cat . '" name="' . CategoriaRequest::desc_cat . '">
                        Descripción (es opcional)
                    </textarea>
                    <br>
                    <label class="labels">Categoría a la que pertenece</label>');
        $this->maquetaCategoriasSelect($tablaCategorias, CategoriaRequest::cat_id_cat, CategoriaRequest::cat_id_cat, null);
        echo('<div class="w3-center">
                        <input type="submit" name="" id="" class="m-boton-a w3-small" value="Agregar">
                        <a href="gestion_categorias.php"><button class="w3-btn w3-small w3-red w3-round-jumbo w3-large">Cancelar</button></a>
                    </div>
                </form>
            </div>');
    }

}
