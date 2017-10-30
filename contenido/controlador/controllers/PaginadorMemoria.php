<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PaginadorMemoria
 *
 * @author SOPORTE
 */
include_once 'cargar_clases3.php';
AutoCarga3::init();

class PaginadorMemoria extends PaginadorAbstracto {

    private $subTablas = array();

    public function __construct($numElementsByPage, $limiteBotones, array $tablaCompletaEntidades) {
        parent::__construct($numElementsByPage, $limiteBotones);
        $this->tablaCompleta = $tablaCompletaEntidades;
        $this->calcularNumeroPaginas();
        $this->calcularSubTablas();
    }

    public function init($urlServer, $targetRta) {
        $this->generarListaBotones($urlServer, $targetRta);
        $this->setBtnFirstPage(new BtnPaginacion("<<", "firstPage('" . $urlServer . "', '" . $targetRta . "');"));
        $this->setBtnLastPage(new BtnPaginacion(">>", "lastPage('" . $urlServer . "', '" . $targetRta . "');"));
        $this->setBtnNext(new BtnPaginacion(">", "nextPage('" . $urlServer . "', '" . $targetRta . "');"));
        $this->setBtnPrev(new BtnPaginacion("<", "prevPage('" . $urlServer . "', '" . $targetRta . "');"));
    }

    public final function calcularSubTablas() {
        $totalElementos = count($this->tablaCompleta);
        $contador = 0;
        for ($i = 0; $i < $this->numeroPaginas; $i++) {
            $arrayTemporal = array();
            for ($j = 0; $j < $this->numeroElementosPorPagina; $j++) {
                $contador++;
                if ($contador <= $totalElementos) {
                    $arrayTemporal[] = $this->tablaCompleta[$contador - 1];
                } else {
                    break;
                }
            }
            $this->subTablas[$i] = $arrayTemporal;
        }
    }

    public function calcularNumeroPaginas() {
        $this->numeroPaginas = (int) ceil(count($this->tablaCompleta) / $this->numeroElementosPorPagina);
    }

    public function firstPage() {
        $this->tablaActual = $this->subTablas[0];
        $this->paginaActual = 1;
        return $this->tablaActual;
    }

    public function getPage($numeroPagina) {
        if (is_int($numeroPagina) && $numeroPagina <= $this->numeroPaginas) {
            $this->tablaActual = $this->subTablas[$numeroPagina - 1];
            $this->paginaActual = $numeroPagina;
            return $this->tablaActual;
        } else {
            return null;
        }
    }

    public function lastPage() {
        $this->paginaActual = (count($this->subTablas));
        $this->tablaActual = $this->subTablas[$this->paginaActual - 1];
        return $this->tablaActual;
    }

    public function maquetarBarraPaginacion() {
        echo('<div class="w3-container w3-theme-l1 w3-center w3-card-8 w3-padding-8 w3-tiny">');
        $this->btnFirstPage->maquetar();
        $this->btnPrev->maquetar();
        foreach ($this->listaBotones as $btn) {
            $btn instanceof BtnPaginacion;
            $btn->maquetar();
        }
        $this->btnNext->maquetar();
        $this->btnLastPage->maquetar();
        echo('</div>');
    }

    public function nextPage() {
        if ($this->paginaActual + 1 < $this->numeroPaginas) {
            $this->paginaActual++;
            $this->tablaActual = $this->subTablas[$this->paginaActual];
            return $this->tablaActual;
        } else {
            return $this->tablaActual;
        }
    }

    public function obtenerTuplas() {
        return $this->tablaActual;
    }

    public function prevPage() {
        if ($this->paginaActual - 1 > 0) {
            $this->paginaActual--;
            $this->tablaActual = $this->subTablas[$this->paginaActual - 1];
            return $this->tablaActual;
        } else {
            return $this->tablaActual;
        }
    }

    public function generarListaBotones($urlNegocio, $targetRta) {
        for ($index = 1; $index <= $this->numeroPaginas; $index++) {
            $eventoOnclick = 'goPage(\'' . $urlNegocio . '\', \'' . $targetRta . '\', ' . $index . ');';
            $boton = new BtnPaginacion($index, $eventoOnclick);
            $this->listaBotones[] = $boton;
        }
    }

    public function setTablaCompleta($tablaCompleta) {
        parent::setTablaCompleta($tablaCompleta);
        $this->calcularNumeroPaginas();
        $this->calcularSubTablas();
    }

}
