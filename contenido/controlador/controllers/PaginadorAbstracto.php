<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PaginadorAbstracto
 *
 * @author SOPORTE
 */
include_once 'cargar_clases3.php';
AutoCarga3::init();

interface Paginable {

    public function obtenerTuplas();

    public function maquetarBarraPaginacion();

    public function nextPage();

    public function prevPage();

    public function lastPage();

    public function firstPage();

    public function getPage($numeroPagina);

    public function calcularNumeroPaginas();

    public function generarListaBotones($urlNegocio, $targetRta);
}

abstract class PaginadorAbstracto implements Paginable {

    protected $paginaActual;
    protected $numeroPaginas;
    protected $numeroElementosPorPagina = 20;
    protected $tablaActual = array();
    protected $tablaCompleta = array();
    protected $listaBotones = array();
    protected $btnFirstPage;
    protected $btnNext;
    protected $btnPrev;
    protected $btnLastPage;
    protected $btnNextPaginacion;
    protected $cabeceraResultados;
    protected $elemento;
    protected $limiteBotones = 7;

    public function __construct($incremento, $limiteBotones) {
        $this->numeroElementosPorPagina = $incremento;
        $this->limiteBotones = $limiteBotones;
    }

    public function getBtnNext() {
        return $this->btnNext;
    }

    public function getBtnPrev() {
        return $this->btnPrev;
    }

    public function setBtnNext(BtnPaginacion $btnNext) {
        $this->btnNext = $btnNext;
    }

    public function setBtnPrev(BtnPaginacion $btnPrev) {
        $this->btnPrev = $btnPrev;
    }

    public function getPaginaActual() {
        return $this->paginaActual;
    }

    public function getNumeroPaginas() {
        return $this->numeroPaginas;
    }

    public function getIncremento() {
        return $this->numeroElementosPorPagina;
    }

    public function getTablaActual() {
        return $this->tablaActual;
    }

    public function getTablaCompleta() {
        return $this->tablaCompleta;
    }

    public function getListaBotones() {
        return $this->listaBotones;
    }

    public function getBtnFirstPage() {
        return $this->btnFirstPage;
    }

    public function getBtnLastPage() {
        return $this->btnLastPage;
    }

    public function getBtnNextPaginacion() {
        return $this->btnNextPaginacion;
    }

    public function getCabeceraResultados() {
        return $this->cabeceraResultados;
    }

    public function getElemento() {
        return $this->elemento;
    }

    public function getLimiteBotones() {
        return $this->limiteBotones;
    }

    public function setPaginaActual($paginaActual) {
        $this->paginaActual = (int) $paginaActual;
    }

    public function setNumeroPaginas($numeroPaginas) {
        $this->numeroPaginas = (int) $numeroPaginas;
    }

    public function setIncremento($incremento) {
        $this->numeroElementosPorPagina = (int) $incremento;
    }

    public function setTablaActual($tablaActual) {
        $this->tablaActual = (array) $tablaActual;
    }

    public function setTablaCompleta($tablaCompleta) {
        $this->tablaCompleta = (array) $tablaCompleta;
    }

    public function setListaBotones($listaBotones) {
        $this->listaBotones = (array) $listaBotones;
    }

    public function setBtnFirstPage(BtnPaginacion $btnFirstPage) {
        $this->btnFirstPage = $btnFirstPage;
    }

    public function setBtnLastPage(BtnPaginacion $btnLastPage) {
        $this->btnLastPage = $btnLastPage;
    }

    public function setBtnNextPaginacion(BtnPaginacion $btnNextPaginacion) {
        $this->btnNextPaginacion = $btnNextPaginacion;
    }

    public function setCabeceraResultados($cabeceraResultados) {
        $this->cabeceraResultados = $cabeceraResultados;
    }

    public function setElemento(EntityDTO $elemento) {
        $this->elemento = $elemento;
        $this->tablaActual[] = $elemento;
    }

    public function setLimiteBotones($limiteBotones) {
        $this->limiteBotones = (int) $limiteBotones;
    }

}
