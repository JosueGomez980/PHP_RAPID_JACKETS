<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Factura
 *
 * @author Josué Francisco
 */
//include_once 'EntityDTO.php';

final class FacturaDTO implements EntityDTO {

    private $idFactura;
    private $cuentaTipoDocumento;
    private $cuentaNumDocumento;
    private $fecha;
    private $estado;
    private $observaciones;
    private $subtotal;
    private $impuestos;
    private $total;

    public function __construct() {
        
    }

    public function getIdFactura() {
        return $this->idFactura;
    }

    public function getCuentaTipoDocumento() {
        return $this->cuentaTipoDocumento;
    }

    public function getCuentaNumDocumento() {
        return $this->cuentaNumDocumento;
    }

    public function getFecha() {
        return $this->fecha;
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

    public function setIdFactura($idFactura) {
        $this->idFactura = (string) $idFactura;
    }

    public function setCuentaTipoDocumento($cuentaTipoDocumento) {
        $this->cuentaTipoDocumento = (string) $cuentaTipoDocumento;
    }

    public function setCuentaNumDocumento($cuentaNumDocumento) {
        $this->cuentaNumDocumento = (string) $cuentaNumDocumento;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
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
        $obj = array(
            'ID_FACTURA' => $this->idFactura,
            'CUENTA_TIPO_DOCUMENTO' => $this->cuentaTipoDocumento,
            'CUENTA_NUM_DOCUMENTO' => $this->cuentaNumDocumento,
            'FECHA' => $this->fecha,
            'ESTADO' => $this->estado,
            'OBSERVACIONES' => $this->observaciones,
            'SUBTOTAL' => $this->subtotal,
            'IMPUESTOS' => $this->impuestos,
            'TOTAL' => $this->total,
        );
        return $obj;
    }

    public static function stdClassToDTO(stdClass $obj) {
        try {
            $factura = new FacturaDTO();
            $factura->setIdFactura($obj->ID_FACTURA);
            $factura->setCuentaTipoDocumento($obj->CUENTA_TIPO_DOCUMENTO);
            $factura->setCuentaNumDocumento($obj->CUENTA_NUM_DOCUMENTO);
            $factura->setFecha($obj->FECHA);
            $factura->setEstado($obj->ESTADO);
            $factura->setObservaciones($obj->OBSERVACIONES);
            $factura->setSubtotal($obj->SUBTOTAL);
            $factura->setImpuestos($obj->IMPUESTOS);
            $factura->setTotal($obj->TOTAL);
            return $factura;
        } catch (ErrorException $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
