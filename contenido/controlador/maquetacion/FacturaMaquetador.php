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
                <div class="container-fluid is-Tamaño-ContainerXD">
                    <br>
                    <center><div class="w3-tag w3-round w3-text-white w3-hover-black" style="width: 60%; background-color:#244063;">
                        <span class="is-Title01 w3-center">Hola '.$iUser.' Aquí está tu factura</span>
                    </div></center>
                    <br>
                    <div class="container-fluid w3-white" style="width: 80%; border-top-right-radius:20px; border-top-left-radius:20px;">
                    <center><div class="container-fluid is-Tamaño-ContainerXD">
                        <div class="col-md-6">
                        <br><br>
                            <div class="container-fluid w3-center">
                                <img src="../media/img/LogoCreaciones.png" class="w3-card-4 m-img-logo-2"><br><br>
                                <div class="container-fluid w3-center"><div class="container-fluid w3-tiny w3-blue-gray w3-text-white w3-i" style="border-radius:10px; width: 70%;">"Uniformes Escolares Diario y Deportivo Dotaciones, <br>Programación Bordados Screen </div></div>
                                <br>
                                <ul class="w3-ul">
                                    <li><span class="w3-large">Direccion:</span> Calle 38C Sur No. 79A-05 Kennedy Bogotá DC</li> 
                                    <li><span class="w3-large">Telefono: </span> 571 0604</li> 
                                    <li><span class="w3-large">Fecha de Expedición:</span>  ' . $fechaToshow . ' </li> 
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6" style="padding-right:4%;">
                        <br><br><br>
                            <h3 style="color: #244063;"><b>FACTURA - ' . $idFactura . '</b></h3>

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
                    </div></center>
                    </div>
                    <div class="container-fluid w3-white" style="width: 80%; border-bottom-right-radius:20px; border-bottom-left-radius:20px;">
                        <div class="w3-padding-xlarge w3-responsive">
                        <br>
                            <center><table class="w3-table-all w3-responsive w3-small" style="width: 90%">
                                <tr class="w3-theme-d4 w3-hover-black">
                                    <th style="width: 10%">CANTIDAD</th>
                                    <th style="width: 70%">DESCRIPCION</th>
                                    <th style="width: 10%"><center>COSTO UNITARIO</center></th>
                                    <th style="width: 10%"><center>TOTAL</center></th>
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
                    <td><center>' . $ItCant . '</center></td>
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
            
            </tr></table></center></div>
            <div class="w3-center">
            <div class="container-fluid w3-white">
                        <br>
                        <div class="container-fluid w3-center w3-small" style="width: 40%">
                            <table class="w3-table-all w3-responsive">
                                <tr>
                                    <td style="font-weight: bold;">SUBTOTAL</td>
                                    <td class="w3-text-blue-grey w3-center">' . $subtotalFactura . '</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">IMPUESTOS</td>
                                    <td class="w3-text-blue-grey w3-center">' . $impuestos . '</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">TOTAL A PAGAR</td>
                                    <td class="w3-text-blue-grey w3-center">' . $totalPagar . '</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">FORMA DE PAGO</td>
                                    <td class="w3-text-blue-grey w3-center">CONTRAENTREGA</td>
                                </tr>
                            </table>
                        </div>
                        <br><br>
                    </div>
            </div>
            
        </div>
        ');
    }

}
