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
        echo('<div class="container-fluid" style="width: 93%;">
            <div class="w3-row table-responsive w3-padding-xlarge">
                    <table class="w3-table-all w3-small table-bordered">
                        <tr class="w3-theme-l1">
                            <th style="width: 30%"><span class="w3-text-dark-gray w3-medium"><center>FECHA</center></span></th>
                            <th style="width: 10%"><span class="w3-text-dark-gray w3-medium"><center>MODO</center></span></th>
                            <th style="width: 10%"><span class="w3-text-dark-gray w3-medium"><center>CANTIDAD</center></span></th>
                            <th style="width: 50%"><span class="w3-text-dark-gray w3-medium"><center>OBSERVACIONES</center></span></th>
                        </tr>
        ');
        foreach ($entidades as $inv) {
            $inv instanceof InventarioDTO;
            $modo = "";
            $date = $dater->stringToDate($inv->getFecha());
            $fecha = $dater->dateSpa2($date) . " - " . $dater->formatDate($date, DateManager::HORA_AM_PM);
            if ($inv->getPrecioMayor() == 0) {
                $modo = '<span class="w3-text-red"><center>Descuento</center></span>';
            } else {
                $modo = '<span class="w3-text-green"><center>Aumento</center></span>';
            }
            $cantidad = $inv->getCantidad();
            $observaciones = Validador::fixTexto($inv->getObservaciones());
            echo('
                 <tr class="w3-hover-light-blue">
                            <td>' . $fecha . '</td>
                            <td>' . $modo . '</td>
                            <td><center>' . $cantidad . '</center></td>
                            <td>' . $observaciones . '</td>
                        </tr>
            ');
        }
        echo('
                    </table>
                </div>
            </div>
        ');
    }

    public function maquetaObject(EntityDTO $entidad) {
        
    }

    public function maquetarFormNuevoInventario(ProductoDTO $pro) {
        $idProducto = $pro->getIdProducto();
        $nombre = Validador::fixTexto($pro->getNombre());
        $cantidad = $pro->getCantidad();
        echo('<form name="nuevo_invetario" method="POST" id="nuevo_inventario" class="form" action="controlador/negocio/inventario_nuevo.php">

                <div class="container-fluid w3-theme-d1">
                <br>
                <span class="w3-text-shadow w3-xlarge w3-block w3-center">Agregar/Disminiur Inventario</span>
                <br>
                    <div class="container-fluid w3-white is-Tamaño-ContainerXD">
                        <div class="container-fluid is-Tamaño-ContainerXD">
                        <br>
                            <ul class="w3-ul">
                                <li><span class="w3-text-theme">Id producto: </span>' . $idProducto . '</li>
                                <li><span class="w3-text-theme">Nombre: </span>' . $nombre . '</li>
                                <li><span class="w3-text-theme">Cantidad disponible: </span><span class="w3-tag w3-blue w3-round w3-large">' . $cantidad . '</span></li>
                            </ul>
                        <br>
                        </div>
                    </div>
                    <br><br>
                    <div class="container-fluid is-Tamaño-ContainerXD">
                        <div class="w3-container w3-half">
                            <div class="widget">
                                <fieldset>
                                    <label class="labels">Modo : </label>
                                    <input type="radio" id="modo_a" class="" name="inventario_modo" value="MAS" checked="true">
                                    <label for="modo_a">Aumentar</label>
                                    <br>
                                    <input type="radio" id="modo_d" class="" name="inventario_modo" value="MENOS"> 
                                    <label for="modo_d">Descontar</label>
                                                                 
                                </fieldset>
                            </div>
                            <label class="labels">Cantidad : </label>
                            <input type="number" class="input_number" min="1" max="9999999999" name="inventario_cantidad" id="inventario_cantidad" onblur="valida_simple_input(this)" required >
                        </div>
                        <div class="w3-container w3-half">
                            <label class="labels">Observaciones : </label>
                            <textarea class="m-textarea" id="inventario_observaciones" name="inventario_observaciones" required="true">Ninguno</textarea>
                        </div>
                    </div>
                    <br>
                    <div class="w3-center">
                        <button class="is-Button-CarritoXD-Inverted" type="submit" name="submit" value="OK">
                            Aplicar
                            <span class="glyphicon glyphicon-ok"></span>
                        </button>
                        <a href="gestion_inventarios.php">
                            <button class="is-Button-CancelarXD-Inverted">
                                Cancelar
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        </a>
                    </div>
                    <br>
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

    public function generarStringReporteA(array $inventario, $hojaCss, $IdPro) {
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
        $proMQT = new ProductoMaquetador();
        $proDAO = ProductoDAO::getInstancia();
        $proDAO instanceof ProductoDAO;
        $proSearch = new ProductoDTO();
        $proSearch->setIdProducto($IdPro);
        $proF = $proDAO->find($proSearch);
        $ProId = $proF->getIdProducto();
        $ProNom = $proF->getNombre();
        $ProCant = $proF->getCantidad();
        $ProUni = $proF->getPrecio();
        $ProPreUni = Validador::formatPesos($ProUni);
        $ProTot = Validador::formatPesos(($ProUni * $ProCant));
        $ProImg = $proMQT->urlFoto($proF->getFoto());
        $salida = '<style>' . $hojaCss . '</style>';
        $cantidad = count($inventario);
        $salida .= ('  
                <div class="is-Head-XD" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                    <p class="is-PXD" style="text-align: right;">
                    ' . $fecha . '
                    <p class="is-PXD">
                     <center><div class="is-Imgen-Logo-Report"><img src="../media/img/LogoCreaciones.png"></div></center> 
                     <p class="is-PXD">
                        Obtenidos ' . $cantidad . ' Registros de Inventario<br>
                        Perteneciente al Producto: <b>' . $ProNom . '</b>.<br>
                        Reporte solicitado por: ' . $nombreAdmin . ' (' . $idUser . ')
                     </p>     
                </div>
                <table class="is-Tabla-Heidy" style="border-radius: 15px;">
                    <tr class="lol">
                        <th class="is-Tabla-Heidy-Tr"><center>ID PRODUCTO</center></th>
                        <th class="is-Tabla-Heidy-Tr"><center>NOMBRE</center></th>
                        <th class="is-Tabla-Heidy-Tr"><center>EXISTENCIAS</center></th>
                        <th class="is-Tabla-Heidy-Tr"><center>VALOR UNIDAD</center></th>
                        <th class="is-Tabla-Heidy-Tr"><center>VALOR TOTAL</center></th>
                        <th class="is-Tabla-Heidy-Tr"><center>FOTO</center></th>
                    </tr>
                    <tr class="lol">
                        <th class="is-Tabla-Heidy-Th"><center>'.$ProId.'</center></th>
                        <th class="is-Tabla-Heidy-Th">'.$ProNom.'</center></th>
                        <th class="is-Tabla-Heidy-Th"><center>'.$ProCant.'</center></th>
                        <th class="is-Tabla-Heidy-Th"><center>'.$ProPreUni.'</center></th>
                        <th class="is-Tabla-Heidy-Th"><center>'.$ProTot.'</center></th>
                        <th class="is-Tabla-Heidy-Th"><center><img style="width: 70px; height: 70px;" src="' .$ProImg. '"></center></th>
                    </tr>
                </table>
                <br>
                <table class="is-Tabla-Heidy">
                    <tr class="lol">
                        <th class="is-Tabla-Heidy-Tr">ID INVENTARIO</th>
                        <th class="is-Tabla-Heidy-Tr">FECHA</th>
                        <th class="is-Tabla-Heidy-Tr">MODO</th>
                        <th class="is-Tabla-Heidy-Tr">CANTIDAD</th>
                        <th class="is-Tabla-Heidy-Tr">OBSERVACIONES</th>
                    </tr>');
        foreach ($inventario as $inv) {
            $inv instanceof InventarioDTO;
            $IdInv = $inv->getIdInventario();
            $modo = "";
            $date = $dater->stringToDate($inv->getFecha());
            $fecha = $dater->dateSpa2($date) . " - " . $dater->formatDate($date, DateManager::HORA_AM_PM);
            if ($inv->getPrecioMayor() == 0) {
                $modo = '<span style="color:#a93226;"><center>Descuento</center></span>';
            } else {
                $modo = '<span style="color:#28b463;"><center>Aumento</center></span>';
            }
            $cantidad = $inv->getCantidad();
            $observaciones = Validador::fixTexto($inv->getObservaciones());


            $salida .= '<tr class="lol">
                        <td class="is-Tabla-Heidy-Th"><center>' . $IdInv . '</center></td>
                        <td class="is-Tabla-Heidy-Th">' . $fecha . '</td>
                        <td class="is-Tabla-Heidy-Th">' . $modo . '</td>';
            $salida .= '<td class="is-Tabla-Heidy-Th"><center>' . $cantidad . '</center></td>';
            $salida .= '<td class="is-Tabla-Heidy-Th">' . $observaciones . '</td>';
            $salida .= '</tr>';
        }
        $salida .= '</table>';
        return $salida;
    }

}
