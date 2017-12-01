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
    public function maquetarFullInfoPedido(PedidoEntregaDTO $pedido, array $items){
        
    }
    public function maquetaObject(EntityDTO $entidad) {
        $entidad instanceof PedidoEntregaDTO;
        return null;
    }

}
