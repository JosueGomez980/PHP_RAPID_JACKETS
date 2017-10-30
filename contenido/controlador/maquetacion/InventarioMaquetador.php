<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InventarioMaquetador
 *
 * @author JosueFrancisco
 */
class InventarioMaquetador implements GenericMaquetador {

    //put your code here
    public function maquetaArrayObject(array $entidades) {
        $dater = new DateManager();
        echo('
            <div class="w3-row table-responsive w3-padding-xlarge">
                    <table class="w3-table-all w3-small table-bordered">
                        <tr class="w3-theme-l1">
                            <th style="width: 30%"><span class="w3-text-dark-gray w3-medium">FECHA</span></th>
                            <th style="width: 10%"><span class="w3-text-dark-gray w3-medium">MODO</span></th>
                            <th style="width: 10%"><span class="w3-text-dark-gray w3-medium">CANTIDAD</span></th>
                            <th style="width: 50%"><span class="w3-text-dark-gray w3-medium">OBSERVACIONES</span></th>
                        </tr>
        ');
        foreach ($entidades as $inv){
            $inv instanceof InventarioDTO;
            $modo = "";
            $date = $dater->stringToDate($inv->getFecha());
            $fecha = $dater->dateSpa2($date). " - ". $dater->formatDate($date, DateManager::HORA_AM_PM);
            if($inv->getPrecioMayor() == 0){
                $modo = '<span class="w3-text-red">Descuento</span>';
            }else{
                $modo = '<span class="w3-text-green">Aumento</span>';
            }
            $cantidad = $inv->getCantidad();
            $observaciones = Validador::fixTexto($inv->getObservaciones());
            echo('
                 <tr class="w3-hover-light-blue">
                            <td>'.$fecha.'</td>
                            <td>'.$modo.'</td>
                            <td>'.$cantidad.'</td>
                            <td>'.$observaciones.'</td>
                        </tr>
            ');
        }
        echo('
            </table>
                </div>
        ');
    }

    public function maquetaObject(EntityDTO $entidad) {
        
    }

    public function maquetarFormNuevoInventario(ProductoDTO $pro) {
        $idProducto = $pro->getIdProducto();
        $nombre = Validador::fixTexto($pro->getNombre());
        $cantidad = $pro->getCantidad();
        echo('
            <form name="nuevo_invetario" method="POST" id="nuevo_inventario" class="form" action="controlador/negocio/inventario_nuevo.php">

                <div class="w3-container w3-theme-d1">
                    <div class="w3-row w3-white">
                        <div class="w3-half">
                            <ul class="w3-ul w3-small">
                                <li><span class="w3-text-theme">Id producto: </span>' . $idProducto . '</li>
                                <li><span class="w3-text-theme">Nombre: </span>' . $nombre . '</li>
                                <li><span class="w3-text-theme">Cantidad disponible: </span><span class="w3-tag w3-gray w3-round w3-large">' . $cantidad . '</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="w3-row">
                        <div class="w3-container w3-half">
                            <div class="widget">
                                <fieldset>
                                    <label class="labels">Modo</label>
                                    <label for="modo_a">Aumentar</label>
                                    <input type="radio" id="modo_a" class="" name="inventario_modo" value="MAS" checked="true">
                                    <label for="modo_d">Descontar</label>
                                    <input type="radio" id="modo_d" class="" name="inventario_modo" value="MENOS">                              
                                </fieldset>
                            </div>
                            <label class="labels">Cantidad</label>
                            <input type="number" class="input_number" min="1" max="9999999999" name="inventario_cantidad" id="inventario_cantidad" onblur="valida_simple_input(this)" required >
                        </div>
                        <div class="w3-container w3-half">
                            <label class="labels">Observaciones</label>
                            <textarea class="form-control" id="inventario_observaciones" name="inventario_observaciones" required="true">Ninguno</textarea>
                        </div>
                    </div>
                    <div class="w3-center">
                        <button class="btn btn-success" type="submit" name="submit" value="OK">
                            Aplicar
                            <span class="glyphicon glyphicon-ok"></span>
                        </button>
                        <a href="gestion_inventarios.php">
                            <button class="btn btn-danger">
                                Cancelar
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        </a>
                    </div>
                </div>
                <script type="text/javascript">
                    $(function () {
                        $("input[type=radio]").checkboxradio();
                        $("fieldset").controlgroup();
                    });
                </script>
            </form>
        ');
    }

}
