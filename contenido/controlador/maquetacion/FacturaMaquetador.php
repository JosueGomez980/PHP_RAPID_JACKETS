<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FacturaMaquetador
 *
 * @author JosueFrancisco
 */
class FacturaMaquetador implements GenericMaquetador {

    private function formatTipoDocumento($tipoDoc) {
        $salida = "";
        switch ($tipoDoc) {
            case "CC":
                $salida = CuentaDAO::TD_CC;
                break;
            case "TI":
                $salida = CuentaDAO::TD_TI;
                break;
            case "CEX":
                $salida = CuentaDAO::TD_CEX;
                break;
            case "RC":
                $salida = CuentaDAO::TD_RC;
                break;
            case "PST":
                $salida = CuentaDAO::TD_RC;
                break;
            default :
                $salida = CuentaDAO::TD_CC;
                break;
        }
        return $salida;
    }

    // Maqueta varias facturas DTO
    public function maquetaArrayObject(array $entidades) {
        return null;
    }

    // Maqueta una sola facturaDTO 
    public function maquetaObject(EntityDTO $entidad) {
        $entidad instanceof FacturaDTO;
    }

    //Se requiere una factura DTo, una lista de items DTO  
    public function maquetarFacturaTipoA(FacturaDTO $factura, array $items) {
        $dater = new DateManager();
        $proDAO = ProductoDAO::getInstancia();
        $proDAO instanceof ProductoDAO;
        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;
        $cuentaDTO = $sesion->getEntidad(Session::CU_LOGED);
        $cuentaDTO instanceof CuentaDTO;
        $userDTO = $sesion->getEntidad(Session::US_LOGED);
        $userDTO instanceof UsuarioDTO;
        $iUser = Validador::fixTexto($userDTO->getIdUsuario());
        $nombres = Validador::fixTexto($cuentaDTO->getPrimerNombre() . " " . $cuentaDTO->getSegundoNombre() . " " . $cuentaDTO->getPrimerApellido() . " " . $cuentaDTO->getSegundoApellido());
        $fechaFac = $dater->stringToDate($factura->getFecha());
        $fechaToshow = $dater->dateSpa2($fechaFac);
        $tipoDocumento = $this->formatTipoDocumento($cuentaDTO->getTipoDocumento());
        $numeroDoc = $cuentaDTO->getNumDocumento();
        $telefono = $cuentaDTO->getTelefono();
        $idFactura = $factura->getIdFactura();
        //--------------------------------------
        $estadoFactura = $factura->getEstado();
        //-------------------------------------
        $direccion = $cuentaDTO->getTelefono();
        //-------------------------------------
        echo('        
            <div class="w3-container">
                    <h3>Hola id '.$iUser.' Aquí está tu factura</h3>
                    <div class="w3-row w3-white w3-padding-large">
                        <div class="w3-half w3-container">
                            <div class="w3-container">
                                <img src="../media/img/logo.png" class="w3-card-4 m-img-logo-2">
                                <div class="w3-container"><span class="w3-tiny w3-tag w3-light-gray w3-i">"Uniformesb Escolares Diario y Deportivo Dotaciones, Programación Bordados Screen </span></div>
                                <ul class="w3-ul">
                                    <li><span class="w3-large">Direccion:</span> Calle 38C Sur No. 79A-05 Kennedy Bogotá DC</li> 
                                    <li><span class="w3-large">Telefono: </span> 571 0604</li> 
                                    <li><span class="w3-large">Fecha de Expedición:</span>  ' . $fechaToshow . ' </li> 
                                </ul>
                            </div>
                        </div>
                        <div class="w3-half w3-container">
                            <h3 class="w3-text-blue">FACTURA ( ' . $idFactura . ' )</h3>

                            <div class="w3-text-blue-gray w3-responsive">
                                <ul class="w3-ul">
                                    <li><span class="w3-large">Cliente: </span> ' . $nombres . '</li> 
                                    <li><span class="w3-large">Documento: </span> (' . $tipoDocumento . ')  ' . $numeroDoc . '</li> 
                                    <li><span class="w3-large">Direccion: </span> ' . $direccion . '</li> 
                                    <li><span class="w3-large">Telefono: </span> ' . $telefono . '</li> 
                                    <li><span class="w3-large w3-text-amber">Estado: </span> <b>' . $estadoFactura . '</b></li> 
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="w3-row w3-theme-l5">
                        <div class="w3-padding-xlarge w3-responsive">
                            <table class="w3-table-all w3-responsive w3-small">
                                <tr class="w3-theme-d4 w3-hover-blue">
                                    <th style="width: 10%">CANTIDAD</th>
                                    <th style="width: 70%">DESCRIPCION</th>
                                    <th style="width: 10%">COSTO UNITARIO</th>
                                    <th style="width: 10%">TOTAL</th>
                                </tr>
        ');
        foreach ($items as $itt) {
            $itt instanceof ItemDTO;
            $ItCant = $itt->getCantidad();
            $ItUnit = Validador::formatPesos($itt->getCostoUnitario());
            $itTotal = Validador::formatPesos($itt->getCostoTotal());
            $proToFind = new ProductoDTO();
            $proToFind->setIdProducto($itt->getProductoIdProducto());
            $proFinded = $proDAO->find($proToFind);
            $namePro = Validador::fixTexto($proFinded->getNombre());
            echo('
                <tr>
                    <td>' . $ItCant . '</td>
                    <td>' . $namePro . '</td>
                    <td>' . $ItUnit . '</td>
                    <td>' . $itTotal . '</td>
                </tr>
            ');
        }
        $subtotalFactura = Validador::formatPesos($factura->getSubtotal());
        $impuestos = Validador::formatPesos($factura->getImpuestos());
        $totalPagar = Validador::formatPesos($factura->getTotal());
        echo('
            
            </tr></table></div></div>
             <div class="w3-row w3-white w3-padding-jumbo">
                        <div class="w3-container w3-quarter"></div>
                        <div class="w3-container w3-half w3-center">
                            <table class="w3-table-all w3-responsive">
                                <tr>
                                    <td class="w3-large">SUBTOTAL</td>
                                    <td class="w3-text-blue-grey">' . $subtotalFactura . '</td>
                                </tr>
                                <tr>
                                    <td class="w3-large">IMPUESTOS</td>
                                    <td class="w3-text-blue-grey">' . $impuestos . '</td>
                                </tr>
                                <tr>
                                    <td class="w3-large">TOTAL A PAGAR</td>
                                    <td class="w3-text-blue-grey">' . $totalPagar . '</td>
                                </tr>
                                <tr>
                                    <td class="w3-large">FORMA DE PAGO</td>
                                    <td class="w3-text-blue-grey">CONTRAENTREGA</td>
                                </tr>
                            </table>
                        </div>
                        <div class="w3-container w3-quarter"></div>
                    </div>
            </div>
        ');
    }

}
