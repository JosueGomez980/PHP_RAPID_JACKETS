<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PedidoEntrega
 *
 * @author Josué Francisco
 */
//include_once 'EntityDTO.php';

final class PedidoEntregaDTO implements EntityDTO {

    private $facturaIdFactura;
    private $cuentaTipoDocumento;
    private $cuentaNumDocumento;
    private $domicilio;
    private $fechaSolicitud;
    private $fechaEntrega;
    private $estado;
    private $observaciones;
    private $subtotal;
    private $impuestos;
    private $total;

    public function __construct() {
        
    }

    public function getFacturaIdFactura() {
        return $this->facturaIdFactura;
    }

    public function getCuentaTipoDocumento() {
        return $this->cuentaTipoDocumento;
    }

    public function getCuentaNumDocumento() {
        return $this->cuentaNumDocumento;
    }

    public function getDomicilio() {
        return $this->domicilio;
    }

    public function getFechaSolicitud() {
        return $this->fechaSolicitud;
    }

    public function getFechaEntrega() {
        return $this->fechaEntrega;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getObservaciones() {
        return $this->observaciones;
    }

    public function getSubtotal() {
        return $this->subtotal;
    }

    public function getImpuestos() {
        return $this->impuestos;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setFacturaIdFactura($facturaIdFactura) {
        $this->facturaIdFactura = (string) $facturaIdFactura;
    }

    public function setCuentaTipoDocumento($cuentaTipoDocumento) {
        $this->cuentaTipoDocumento = (string) $cuentaTipoDocumento;
    }

    public function setCuentaNumDocumento($cuentaNumDocumento) {
        $this->cuentaNumDocumento = (string) $cuentaNumDocumento;
    }

    public function setDomicilio($domicilio) {
        $this->domicilio = (string) $domicilio;
    }

    public function setFechaSolicitud($fechaSolicitud) {
        $this->fechaSolicitud = (string) $fechaSolicitud;
    }

    public function setFechaEntrega($fechaEntrega) {
        $this->fechaEntrega = (string) $fechaEntrega;
    }

    public function setEstado($estado) {
        $this->estado = (string) $estado;
    }

    public function setObservaciones($observaciones) {
        $this->observaciones = (string) $observaciones;
    }

    public function setSubtotal($subtotal) {
        $this->subtotal = (double) $subtotal;
    }

    public function setImpuestos($impuestos) {
        $this->impuestos = (double) $impuestos;
    }

    public function setTotal($total) {
        $this->total = (double) $total;
    }

    public function jsonSerialize() {
        $array = array(
            "FACTURA_ID_FACTURA" => $this->facturaIdFactura,
            "CUENTA_TIPO_DOCUMENTO" => $this->cuentaTipoDocumento,
            "CUENTA_NUM_DOCUMENTO" => $this->cuentaNumDocumento,
            "DOMICILIO" => $this->domicilio,
            "FECHA_SOLICITUD" => $this->fechaSolicitud,
            "FECHA_ENTREGA" => $this->fechaEntrega,
            "ESTADO" => $this->estado,
            "SUBTOTAL" => $this->subtotal,
            "IMPUESTOS" => $this->impuestos,
            "TOTAL" => $this->total
        );
        return $array;
    }

    public static function stdClassToDTO(\stdClass $obj) {
        try {
            $pedido = new PedidoEntregaDTO();
            $pedido->setFacturaIdFactura($obj->FACTURA_ID_FACTURA);
            $pedido->setCuentaTipoDocumento($obj->CUENTA_TIPO_DOCUMENTO);
            $pedido->setCuentaNumDocumento($obj->CUENTA_NUM_DOCUMENTO);
            $pedido->setDomicilio($obj->DOMICILIO);
            $pedido->setFechaSolicitud($obj->FECHA_SOLICITUD);
            $pedido->setFechaEntrega($obj->FECHA_ENTREGA);
            $pedido->setEstado($obj->ESTADO);
            $pedido->setSubtotal($obj->SUBTOTAL);
            $pedido->setImpuestos($obj->IMPUESTOS);
            $pedido->setTotal($obj->TOTAL);
            return $pedido;
        } catch (ErrorException $exc) {
            echo $exc->getTraceAsString();
        }
        return null;
    }

}
