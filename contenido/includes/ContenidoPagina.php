<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ContenidoPagina
 *
 * @author SOPORTE
 */
final class ContenidoPagina {

    public static $inst = NULL;
    private $head;
    private $footer;
    private $nav;
    private $header;
    private $slider;

    function __construct() {
        
    }

    public static function getInstancia() {
        if (is_null(self::$inst)) {
            self::$inst = new ContenidoPagina();
        }
        return self::$inst;
    }

    public function mostrarRespuestaNegocio() {
        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;
        if ($sesion->existe(Session::NEGOCIO_RTA)) {
            if ($sesion->get(Session::NEGOCIO_RTA) instanceof ModalSimple) {
                $modal = $sesion->getEntidad(Session::NEGOCIO_RTA);
                $modal instanceof ModalSimple;
                $modal->open();
                $modal->maquetar();
                $modal->close();
                $sesion->removeEntidad(Session::NEGOCIO_RTA);
            }
        }
    }

    public function getHead() {
        $this->head = include 'head.inc';
        return $this->head;
    }

    public function getHead2() {
        include 'head2.inc';
    }

    public function getHead3() {
        include 'head3.inc';
    }

    public function getHeaderPre() {
        include 'headerPre.inc';
    }

    public function getFooter() {
        $this->footer = include 'footer.inc';
        return $this->footer;
    }

    public function getFooter2() {
        $this->footer = include 'footer2.inc';
        return $this->footer;
    }

    public function getNav() {
        return $this->nav;
    }

    public function getHeader() {
        $this->header = include 'header.inc';
        return $this->header;
    }

    public function getHeader2() {
        $this->header = include 'header2.inc';
        return $this->header;
    }

    public function setHead($head) {
        $this->head = $head;
    }

    public function setFooter($footer) {
        $this->footer = $footer;
    }

    public function setNav($nav) {
        $this->nav = $nav;
    }

    public function setHeader($header) {
        $this->header = $header;
    }

    public function getSlider() {
        return $this->slider;
    }

    public function setSlider($slider) {
        $this->slider = $slider;
    }

}
