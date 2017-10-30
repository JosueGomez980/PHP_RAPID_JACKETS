<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FileUploadImage
 *
 * @author Josué Francisco
 */
include_once 'cargar_clases3.php';
AutoCarga3::init();

class FileUploadImage extends FileUpload {
    protected $allowedSize;
    
    public function getAllowedSize() {
        return $this->allowedSize;
    }

    public function setAllowedSize($allowedSize) {
        $this->allowedSize = $allowedSize;
    }

    
    public function __construct($nameOFInputFile) {
        parent::__construct($nameOFInputFile);
    }
    
    public function validaTodo(){
        $ok = FALSE;
        $ok = $this->validaTamanio($this->allowedSize);
        $ok = $this->validaTipo(FileUpload::$ALL_IMG);
        $ok = $this->validaUnico();
        return $ok;
    }
    

}
