<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ContentManager
 *
 * @author Josué Francisco
 */
interface Maquetable {

    public function maquetar();
}

interface Formato {

    public function setValor($txt);

    public function getValor();

    public function toString($valor);
}

interface Boton extends Formato {

    public function setValor($txt);

    public function setLink($link);

    public function setEvento($evento, $accion);
}

class Alerta implements Formato {

    private $valor;

    public function setValor($txt) {
        $this->valor = $txt;
    }

    public function getValor() {
        return $this->valor;
    }

    public function toString($valor) {
        $salida = '<div class="w3-container w3-yellow w3-card-8">
                    <span class="w3-closebtn" onclick="hide_closebtn(this);">&Chi;</span>
                    <p>' . $valor . '</p>
                  </div>';
        return $salida;
    }

}

class Neutral implements Formato {

    private $valor;

    public function setValor($txt) {
        $this->valor = $txt;
    }

    public function getValor() {
        return $this->valor;
    }

    public function toString($valor) {
        $salida = '<div class="w3-container w3-theme w3-card-8">
                    <span class="w3-closebtn" onclick="hide_closebtn(this);">&Chi;</span>
                    <p>' . $valor . '</p>
                  </div>';
        return $salida;
    }

}

class Exito implements Formato {

    private $valor;

    public function setValor($txt) {
        $this->valor = $txt;
    }

    public function getValor() {
        return $this->valor;
    }

    public function toString($valor) {
        $salida = '<div class="w3-container w3-green w3-card-8">
                    <span class="w3-closebtn" onclick="hide_closebtn(this);">&Chi;</span>
                    <p>' . $valor . '</p>
                  </div>';
        return $salida;
    }

}

class Errado implements Formato {

    private $valor;

    public function setValor($txt) {
        $this->valor = $txt;
    }

    public function getValor() {
        return $this->valor;
    }

    public function toString($valor) {
        $salida = '<div class="w3-container w3-red w3-card-8">
                    <span class="w3-closebtn" onclick="hide_closebtn(this);">&Chi;</span>
                    <p>' . $valor . '</p>
                  </div>';
        return $salida;
    }

}

class CloseBtn implements Formato {

    private $valor;

    public function __construct() {
        
    }

    public function getValor() {
        return $this->valor;
    }

    public function setValor($txt) {
        $this->valor = $txt;
    }

    public function toString($valor) {
        $salida = '<button class="w3-btn w3-white w3-border w3-border-blue w3-round w3-large w3-block w3-center" onclick="close_modal(this)">' . $valor . '</button>';
        return $salida;
    }

}

class BtnPaginacion implements Formato, Maquetable {

    private $valor;
    private $onclick;
    private $enlace;
    private $estado = true;

    public function __construct($valor, $onclick) {
        $this->valor = $valor;
        $this->onclick = $onclick;
    }

    public function getOnclick() {
        return $this->onclick;
    }

    public function getEnlace() {
        return $this->enlace;
    }

    public function setOnclick($onclick) {
        $this->onclick = $onclick;
    }

    public function setEnlace($enlace) {
        $this->enlace = $enlace;
    }

    public function getValor() {
        return $this->valor;
    }

    public function setValor($txt) {
        $this->valor = $txt;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function toString($valor) {
        return null;
    }

    public function maquetar() {
        $salidaBtn = "";
        if ($this->enlace != "" && !is_null($this->enlace)) {
            $salidaBtn .= '<a href="' . $this->enlace . '">';
        }

        $salidaBtn .= '<button class="w3-btn w3-theme-dark  w3-round-medium w3-hover-blue-gray" onclick="' . $this->onclick . '">' . $this->valor . '</button></a>';

        if ($this->enlace != "" && !is_null($this->enlace)) {
            $salidaBtn .= '</a>';
        }
        echo($salidaBtn);
    }

}

interface Modal extends Maquetable {

    public function addElemento(Formato $element);

    public function getElementos();

    public function open();

    public function close();
}

interface DialogModal extends Modal {

    public function setBotonAcept(Formato $boton);

    public function setBotonCancel(Formato $boton);

    public function addBoton(Boton $btn);
}

class ModalSimple implements Modal {

    protected $elementos = array();

    public function open() {
        echo('<div class="w3-modal" style="display: block" id="modal">
            <div class="w3-modal-content w3-animate-top">');
    }

    public function close() {
        echo('</div></div>');
    }

    public function addElemento(Formato $element) {
        $this->elementos[] = $element;
    }

    public function getElementos() {
        return $this->elementos;
    }

    public function maquetar() {

        foreach ($this->elementos as $elem) {
            $elem instanceof Formato;
            echo($elem->toString($elem->getValor()));
        }
    }
    public function addError($valor){
        $err = new Errado();
        $err->setValor($valor);
        $this->addElemento($err);
    }
    public function addExito($valor){
        $err = new Exito();
        $err->setValor($valor);
        $this->addElemento($err);
    }
    public function addNeutral($valor){
        $err = new Neutral();
        $err->setValor($valor);
        $this->addElemento($err);
    }
    public function show(){
        $this->open();
        $this->maquetar();
        $this->close();
    }

    public function setClosebtn($value){
        $clBtn = new CloseBtn();
        $clBtn->setValor($value);
        $this->addElemento($clBtn);
    }

}

interface Content extends Maquetable {

    public function setFormato(Formato $formato);

    public function getFormato();

    public function getContenido();

    public function setContenido($contenido);
}

class ContentManager implements Content {

    private $formato;
    private $contenido = "";
    private static $instancia = NULL;

    public function __construct() {
        
    }

    public function getFormato() {
        return $this->formato;
    }

    public function getContenido() {
        return $this->contenido;
    }

    public function setFormato(Formato $formato) {
        $this->formato = $formato;
    }

    public function setContenido($contenido) {
        $this->contenido = $contenido;
        $this->maquetar();
    }

    public static function getInstancia() {
        if (is_null(self::$instancia)) {
            self::$instancia = new ContentManager();
        }
        return self::$instancia;
    }

    public function maquetar() {
        $salida = $this->formato->toString($this->contenido);
        //echo($salida);
        return $salida;
    }
    public function mostrar() {
        $salida = $this->formato->toString($this->contenido);
        echo($salida);
        return $salida;
    }

}
