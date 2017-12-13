<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PedidoMaquetador
 *
 * @author JosueFrancisco
 */
class PedidoMaquetador implements GenericMaquetador {

    public function maquetaArrayObject(array $entidades) {
        return null;
    }

    private function formatEstado($estado) {
        $estadoS = '';
        switch ($estado) {
            case PedidoEntregaDAO::$DEVUELTO:
                $estadoS = '<td class="w3-text-amber"><b>Devuelto / Regresado</b></td>';
                break;
            case PedidoEntregaDAO::$ELIMINADO:
                $estadoS = '<td class="w3-text-red"><b>Cancelado/Eliminado</b></td>';
                break;
            case PedidoEntregaDAO::$ENTREGADO:
                $estadoS = '<td class="w3-text-blue"><b>Entregado</b></td>';
                break;
            case PedidoEntregaDAO::$ENVIADO:
                $estadoS = '<td class="w3-text-gray"><b>Enviado</b></td>';
                break;
            case PedidoEntregaDAO::$FINALIZADO:
                $estadoS = '<td class="w3-text-green"><b>Finalizado/Completado</b></td>';
                break;
            case PedidoEntregaDAO::$NO_PUDO_ENTREGAR:
                $estadoS = '<td class="w3-text-orange"><b>No pudo ser entregado</b></td>';
                break;
            case PedidoEntregaDAO::$POR_LLEGAR:
                $estadoS = '<td class="w3-text-light-green"><b>A punto de llegar</b></td>';
                break;
            case PedidoEntregaDAO::$RETRASADO:
                $estadoS = '<td class="w3-text-light-blue"><b>Se ha retrasado</b></td>';
                break;
            case PedidoEntregaDAO::$SIN_PAGO:
                $estadoS = '<td class="w3-text-red"><b>Sin pagar</b></td>';
                break;
            case PedidoEntregaDAO::$SOLICITADO:
                $estadoS = '<td class="w3-text-blue-gray"><strong>Solicitado</strong></td>';
                break;
            case PedidoEntregaDAO::$ACEPTADO:
                $estadoS = '<td class="w3-text-green"><strong>Aceptado</strong></td>';
                break;
            case PedidoEntregaDAO::$DENIED:
                $estadoS = '<td class="w3-text-orange"><strong>Cancelado/Denegado</strong></td>';
                break;
        }
        return $estadoS;
    }

    public function maquetaTablaCrudAdmin(array $entidades) {
        $dater = DateManager::getInstance();
        $dater instanceof DateManager;
        echo('
            <table class="w3-table-all w3-responsive w3-text-black">
                        <tr class="w3-blue-gray w3-hover-blue">
                            <th style="width: 30%">FECHA DE SOLICITUD</th>
                            <th style="width: 30%">ESTADO</th>
                            <th style="width: 20%">TOTAL</th>
                            <th style="width: 20%">ACCIONES</th>
                        </tr>
        ');
        foreach ($entidades as $pedido) {
            $idPedFact = CriptManager::urlVarEncript($pedido->getFacturaIdFactura());
            $pedido instanceof PedidoEntregaDTO;
            $date = $dater->stringToDate($pedido->getFechaSolicitud());
            $fechaShow = $dater->dateSpa2($date) . " - " . $dater->formatDate($date, DateManager::HORA_AM_PM);
            $estado = $this->formatEstado($pedido->getEstado());

            $totalPedido = Validador::formatPesos($pedido->getTotal());
            echo('
                <tr>
                    <td><strong>' . $fechaShow . '</strong></td>
                    ' . $estado . '
                    <td><strong>' . $totalPedido . '</strong></td>
                    <td class="w3-left">
                        <button class="btn btn-primary btn-sm" onclick="verPedidoFull(\'' . $idPedFact . '\')"  data-toggle="tooltip" data-placement="top" title="Ver info completa">
                            <span class="glyphicon glyphicon-tasks"></span>
                        </button>

                        <button class="btn btn-success btn-sm" onclick=""  data-toggle="tooltip" data-placement="top" title="Gestionar">
                            <span class="glyphicon glyphicon-cog"></span>
                        </button>
                    </td>
                </tr>
            ');
        }
        echo('
            </table>
        ');
    }

    // Para maqueta un pedido completo
    public function maquetarFullInfoPedido(PedidoEntregaDTO $pedido, array $items) {
        $dater = new DateManager();
        $proDAO = ProductoDAO::getInstancia();
        $proDAO instanceof ProductoDAO;
        $userDAO = UsuarioDAO::getInstancia();
        $userDAO instanceof UsuarioDAO;
        $cuetaDAO = CuentaDAO::getInstancia();
        $cuetaDAO instanceof CuentaDAO;
        $cuToFind = new CuentaDTO();
        $cuToFind->setNumDocumento($pedido->getCuentaNumDocumento());
        $cuToFind->setTipoDocumento($pedido->getCuentaTipoDocumento());
        $cuentaDTO = $cuetaDAO->find($cuToFind);
        $nombres = Validador::fixTexto($cuentaDTO->getPrimerNombre() . " " . $cuentaDTO->getSegundoNombre() . " " . $cuentaDTO->getPrimerApellido() . " " . $cuentaDTO->getSegundoApellido());
        $fechaSoliciPedido = $dater->stringToDate($pedido->getFechaSolicitud());
        $fechaEntregaPedido = $pedido->getFechaEntrega();
        if ((is_null($fechaEntregaPedido)) || ($fechaEntregaPedido == DateManager::NO_DATE) || ($fechaEntregaPedido == "")) {
            $fechaEntregaToShow = "FECHA SIN ASIGNAR";
        } else {
            $fechaEntregaPedido = $dater->stringToDate($fechaEntregaPedido);
            $fechaEntregaToShow = $dater->dateSpa2($fechaEntregaPedido);
        }
        $fechaToshow = $dater->dateSpa2($fechaSoliciPedido);
        $tipoDocumento = $cuentaDTO->getTipoDocumento();
        $numeroDoc = $cuentaDTO->getNumDocumento();
        $telefono = $cuentaDTO->getTelefono();
        $idFactura = $pedido->getFacturaIdFactura();
        $idCripted = CriptManager::urlVarEncript($idFactura);

        //--------------------------------------
        $pedidoEstado = $pedido->getEstado();
        //-------------------------------------
        $domicilioJson = $pedido->getDomicilio();
        //-------------------------------------
        $direccionDomi = "SIN ASIGNAR";
        $telefonoDomi = "SIN ASIGNAR";
        $localidadDomi = "SIN ASIGNAR";
        $barriDomi = "SIN ASIGNAR";
        if ($domicilioJson != PedidoEntregaDAO::DOM_NOT && !is_null($domicilioJson)) {
            $domicilioDTO = DomicilioCuentaDTO::stdClassToDTO(json_decode($domicilioJson));
            $domicilioDTO instanceof DomicilioCuentaDTO;
            $direccionDomi = Validador::fixTexto(CriptManager::urlVarDecript($domicilioDTO->getDireccion()));
            $telefonoDomi = Validador::fixTexto(CriptManager::urlVarDecript($domicilioDTO->getTelefono()));
            $localidadDomi = Validador::fixTexto(CriptManager::urlVarDecript($domicilioDTO->getLocalidad()));
            $barriDomi = Validador::fixTexto(CriptManager::urlVarDecript($domicilioDTO->getBarrio()));
        }
        $btnDownloadPDF = '<div class="w3-display-container">
                    <a href="controlador/controllers/ControlVistas.php?' . FacturaRequest::fac_id . '=' . $idCripted . '&m=imprimir_pedido_pdf_admin" target="_blank">
                        <button class="w3-display-topright w3-btn w3-red w3-round-medium" data-toggle="tooltip" data-placement="top" title="Descargar PDF">
                            <span class="glyphicon glyphicon-download"></span> Generar pdf
                        </button>
                    </a>
            </div>
            <br><br>';

        $btnEliminar = '<form action="controlador/controllers/ControlVistas.php?m=eliminar_pedido_admin" method="POST" name="formDeletePedido">
                    <input type="hidden" value="' . $idCripted . '" name="' . FacturaRequest::fac_id . '">
                    <button class="btn btn-danger" type="submit" name="btnDeletePedido">
                        <span class="glyphicon glyphicon-trash"></span> Eliminar Definitivo
                    </button>
                </form>';
        $btnAceptar = '<button class="btn btn-success" onclick="accionesRapidasPedidoAdmin(\'' . $idCripted . '\', \'ACEPTAR\')">
                    <span class="glyphicon glyphicon-ok"></span> Aceptar Pedido
                </button>';
        $btnDenie = '<button class="btn btn-warning" onclick="accionesRapidasPedidoAdmin(\'' . $idCripted . '\', \'CANCELAR\')">
                    <span class="glyphicon glyphicon-remove"></span> Cancelar/Denegar Pedido
                </button>';
        switch ($pedido->getEstado()) {
            case PedidoEntregaDAO::$ELIMINADO:
                $btnEliminar = '';
                $btnDenie = '';
                $btnAceptar = '';
                break;
            case PedidoEntregaDAO::$ACEPTADO:
                $btnAceptar = '';
                break;
            case PedidoEntregaDAO::$DENIED:
                $btnDenie = '';
                break;
        }
        echo('
            ' . $btnDownloadPDF . '
            <div class="w3-center w3-padding-large">
                <div class="w3-center">
                    <span class="w3-tag w3-theme-d2 w3-large">ACCIONES RÁPIDAS</span>
                </div>
               ' . $btnAceptar . $btnDenie . $btnEliminar . '
                
            </div>
              
            <div class="w3-container">
                    <div class="w3-row w3-white w3-padding-large">
                        <div class="w3-half w3-container w3-responsive"> 
                        <h3 class="w3-text-blue-gray">
                            Información del Domicilio
                            <button type="button" class="btn btn-default">
                                <span class="glyphicon glyphicon-home"></span>
                            </button>
                        </h3>
                            <div class="w3-container">
                                <ul class="w3-ul">
                                    <li><span class="w3-large">Direccion Domicilio:</span> ' . $direccionDomi . '</li> 
                                    <li><span class="w3-large">Telefono Domicilio: </span> ' . $telefonoDomi . '</li> 
                                    <li><span class="w3-large">Localidad: </span> ' . $localidadDomi . '</li> 
                                    <li><span class="w3-large">Barrio: </span> ' . $barriDomi . '</li> 
                                    <li class="w3-theme-l3"><span class="w3-large">Fecha de Solicitud del pedido:</span>  ' . $fechaToshow . ' </li> 
                                    <li class="w3-theme-d5"><span class="w3-large">Fecha de Entrega del pedido:</span>  ' . $fechaEntregaToShow . ' </li> 
                                </ul>
                            </div>
                        </div>
                        <div class="w3-half w3-container">
                            <h3 class="w3-text-blue">FACTURA ( ' . $idFactura . ' )</h3>

                            <div class="w3-text-blue-gray w3-responsive">
                                <ul class="w3-ul">
                                    <li><span class="w3-large">Cliente: </span> ' . $nombres . '</li> 
                                    <li><span class="w3-large">Documento: </span> (' . $tipoDocumento . ')  ' . $numeroDoc . '</li> 
                                    <li><span class="w3-large">Telefono: </span> ' . $telefono . '</li> 
                                    <li class="w3-theme-l3"><span class="w3-large">Estado: </span> <b>' . $pedidoEstado . '</b></li> 
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
            $namePro = utf8_encode($proFinded->getNombre());
            echo('
                <tr>
                    <td>' . $ItCant . '</td>
                    <td>' . $namePro . '</td>
                    <td>' . $ItUnit . '</td>
                    <td>' . $itTotal . '</td>
                </tr>
            ');
        }
        $subtotalPedido = Validador::formatPesos($pedido->getSubtotal());
        $impuestos = Validador::formatPesos($pedido->getImpuestos());
        $totalPagar = Validador::formatPesos($pedido->getTotal());
        echo('
             </table></div></div>
             <div class="w3-row w3-white w3-padding-large">
                        <div class="w3-container w3-threequarter w3-responsive">
                            <table class="w3-table-all">
                                <tr>
                                    <td class="w3-large">SUBTOTAL</td>
                                    <td class="w3-text-black">' . $subtotalPedido . '</td>
                                </tr>
                                <tr>
                                    <td class="w3-large">IMPUESTOS</td>
                                    <td class="w3-text-black">' . $impuestos . '</td>
                                </tr>
                                <tr>
                                    <td class="w3-large">TOTAL A PAGAR</td>
                                    <td class="w3-text-black">' . $totalPagar . '</td>
                                </tr>
                                <tr>
                                    <td class="w3-large">FORMA DE PAGO</td>
                                    <td class="w3-text-black">CONTRAENTREGA</td>
                                </tr>
                            </table>
                        </div>
                        <div class="w3-container w3-quarter"></div>
                    </div>
            </div>
        ');
    }

    public function generarHtmlPedidoPDF(PedidoEntregaDTO $pedido, array $items, $hojaCss) {
        $stringHTML = '
            <!DOCTYPE html>
            <html>
                <style>' . $hojaCss . '</style>
                <body>
                ';

        $dater = new DateManager();
        $proDAO = ProductoDAO::getInstancia();
        $proDAO instanceof ProductoDAO;
        $userDAO = UsuarioDAO::getInstancia();
        $userDAO instanceof UsuarioDAO;
        $cuetaDAO = CuentaDAO::getInstancia();
        $cuetaDAO instanceof CuentaDAO;
        $cuToFind = new CuentaDTO();
        $cuToFind->setNumDocumento($pedido->getCuentaNumDocumento());
        $cuToFind->setTipoDocumento($pedido->getCuentaTipoDocumento());
        $cuentaDTO = $cuetaDAO->find($cuToFind);
        $nombres = Validador::fixTexto($cuentaDTO->getPrimerNombre() . " " . $cuentaDTO->getSegundoNombre() . " " . $cuentaDTO->getPrimerApellido() . " " . $cuentaDTO->getSegundoApellido());
        $fechaSoliciPedido = $dater->stringToDate($pedido->getFechaSolicitud());
        $fechaEntregaPedido = $pedido->getFechaEntrega();
        if ((is_null($fechaEntregaPedido)) || ($fechaEntregaPedido == DateManager::NO_DATE) || ($fechaEntregaPedido == "")) {
            $fechaEntregaToShow = "FECHA SIN ASIGNAR";
        } else {
            $fechaEntregaPedido = $dater->stringToDate($fechaEntregaPedido);
            $fechaEntregaToShow = $dater->dateSpa2($fechaEntregaPedido);
        }
        $fechaToshow = $dater->dateSpa2($fechaSoliciPedido);
        $tipoDocumento = $cuentaDTO->getTipoDocumento();
        $numeroDoc = $cuentaDTO->getNumDocumento();
        $telefono = $cuentaDTO->getTelefono();
        $idFactura = $pedido->getFacturaIdFactura();

        //--------------------------------------
        $pedidoEstado = $pedido->getEstado();
        //-------------------------------------
        $domicilioJson = $pedido->getDomicilio();
        //-------------------------------------
        $direccionDomi = "SIN ASIGNAR";
        $telefonoDomi = "SIN ASIGNAR";
        $localidadDomi = "SIN ASIGNAR";
        $barriDomi = "SIN ASIGNAR";
        if ($domicilioJson != PedidoEntregaDAO::DOM_NOT && !is_null($domicilioJson)) {
            $domicilioDTO = DomicilioCuentaDTO::stdClassToDTO(json_decode($domicilioJson));
            $domicilioDTO instanceof DomicilioCuentaDTO;
            $direccionDomi = Validador::fixTexto(CriptManager::urlVarDecript($domicilioDTO->getDireccion()));
            $telefonoDomi = Validador::fixTexto(CriptManager::urlVarDecript($domicilioDTO->getTelefono()));
            $localidadDomi = Validador::fixTexto(CriptManager::urlVarDecript($domicilioDTO->getLocalidad()));
            $barriDomi = Validador::fixTexto(CriptManager::urlVarDecript($domicilioDTO->getBarrio()));
        }
        $stringHTML .= '
            <div style="padding: 7px; ">
            <div class="head2">
                <table class="tablaFacturaHead">
                    <tr>
                        <td style="width: 20%; height: 50px; font-size: 0.85em;">
                            <img class="img-logo"  src="../../../media/img/logo.png" /><br>
                            <b>Teléfono: </b>5710604<br><br>
                            <b>Email: </b>creacionesjuliethuniformes@hotmail.com<br><br>
                            <b>Dirección: </b><br>Localidad de Kennedy(Diag. al INEM) Bogotá DC <br> Calle 38C Sur No. 79A-05
                        </td>
                        <td style="vertical-align: top; text-align: left; width: 40%">
                            <h2>Factura (' . $idFactura . ')</h2>
                            <div style="font-size: 1.25em; border-bottom: 1px black solid; padding: 10px;">
                                <b>Cliente:</b> <span style="font-size: 0.9em;">' . $nombres . '</span>
                            </div>
                            <div style="font-size: 1.25em; border-bottom: 1px black solid; padding: 10px;">
                                <b>Documento:</b> <span style="font-size: 0.9em;">(' . $tipoDocumento . ') ' . $numeroDoc . '</span>
                            </div>
                            <div style="font-size: 1.25em; border-bottom: 1px black solid; padding: 10px;">
                                <b>Teléfono:</b> <span style="font-size: 0.9em;">' . $telefono . '</span>
                            </div>
                            <div style="font-size: 1.25em; border-bottom: 1px black solid; padding: 10px; background-color: #ccccff">
                                <b>Estado:</b> <b><span style="font-size: 0.9em;">' . $pedidoEstado . '</span></b>
                            </div>
                        </td>
                        <td style="vertical-align: top; text-align: left; width: 40%">
                            <h2>Información del domicilio</h2>
                            <div style="font-size: 1.25em; border-bottom: 1px black solid; padding: 10px;">
                                <b>Direccion:</b> <span style="font-size: 0.9em;">' . $direccionDomi . '</span>
                            </div>
                            <div style="font-size: 1.25em; border-bottom: 1px black solid; padding: 10px;">
                                <b>Teléfono:</b> <span style="font-size: 0.9em;">' . $telefonoDomi . '</span>
                            </div>
                            <div style="font-size: 1.25em; border-bottom: 1px black solid; padding: 10px;">
                                <b>Localidad:</b> <span style="font-size: 0.9em;">' . $localidadDomi . '</span>
                            </div>
                            <div style="font-size: 1.25em; border-bottom: 1px black solid; padding: 10px;">
                                <b>Barrio:</b> <b><span style="font-size: 0.9em;">' . $barriDomi . '</span></b>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; text-align: left;" colspan="3">
                            <div style="font-size: 1.125em; border-bottom: 1px black solid; padding: 10px; background-color: #ffffcc;">
                                <b>Fecha de Solicitud:</b> <b><span style="font-size: 0.825em;">' . $fechaToshow . '</span></b>
                            </div>
                            <div style="font-size: 1.125em; border-bottom: 1px black solid; padding: 10px; background-color: #ffffcc;">
                                <b>Fecha de Entrega:</b> <b><span style="font-size: 0.825em;">' . $fechaEntregaToShow . '</span></b>
                            </div>   
                        </td>
                    </tr>

                </table>
            </div>
        </div>
        ';
        $stringHTML .= '
            <div style="padding: 10px;">
            <table class="tablaFacturaHead">
                <tr>
                    <th style="width: 10%">CANTIDAD</th>
                    <th style="width: 60%">DESCRIPCION</th>
                    <th style="width: 15%">COSTO UNITARIO</th>
                    <th style="width: 15%">TOTAL</th>
                </tr>
        ';
        foreach ($items as $itt) {
            $itt instanceof ItemDTO;
            $ItCant = $itt->getCantidad();
            $ItUnit = Validador::formatPesos($itt->getCostoUnitario());
            $itTotal = Validador::formatPesos($itt->getCostoTotal());
            $proToFind = new ProductoDTO();
            $proToFind->setIdProducto($itt->getProductoIdProducto());
            $proFinded = $proDAO->find($proToFind);
            $namePro = utf8_encode($proFinded->getNombre());
            $stringHTML .= '
                 <tr>
                    <td>' . $ItCant . '</td>
                    <td>' . $namePro . '</td>
                    <td>' . $ItUnit . '</td>
                    <td>' . $itTotal . '</td>
                </tr>
            ';
        }
        $subtotalPedido = Validador::formatPesos($pedido->getSubtotal());
        $impuestos = Validador::formatPesos($pedido->getImpuestos());
        $totalPagar = Validador::formatPesos($pedido->getTotal());
        $stringHTML .= '
            </table>
        </div>
            <div style="padding: 7px; ">
                <div class="head2">
                    <div style="width: 50%; float: right;">
                        <div style="font-size: 1.125em; border-bottom: 1px black solid; padding: 10px;">
                            <b>Subtotal: </b> <b><span style="font-size: 0.825em;">' . $subtotalPedido . '</span></b>
                        </div>
                        <div style="font-size: 1.125em; border-bottom: 1px black solid; padding: 10px;">
                            <b>Impuestos: </b> <b><span style="font-size: 0.825em;">' . $impuestos . '</span></b>
                        </div>
                        <div style="font-size: 1.125em; border-bottom: 1px black solid; padding: 10px; background-color: #9999ff">
                            <b>Total a Pagar: </b> <b><span style="font-size: 0.825em;">' . $totalPagar . '</span></b>
                        </div>

                    </div>
                    <div class="clear"></div>

                </div>
            </div>
        </body>
    </html>
        ';
        return $stringHTML;
    }

    public function maquetaObject(EntityDTO $entidad) {
        $entidad instanceof PedidoEntregaDTO;
        return null;
    }

}
