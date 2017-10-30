<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CategoriaController
 *
 * @author Josué Francisco
 */
include_once 'cargar_clases3.php';
AutoCarga3::init();

class CategoriaController implements Validable, GenericController {

    private $categoriaDAO;
    private $categoriaMQT;
    private $contentMGR;

    public function __construct() {
        $this->categoriaDAO = new CategoriaDAO();
        $this->contentMGR = new ContentManager();
        $this->categoriaMQT = new CategoriaMaquetador();
    }

    public function mostrarCategoriaSelect($nameForm, $idForm, $selected) {
        $tablaCategorias = $this->categoriaDAO->findAll();
        $this->categoriaMQT->maquetaCategoriasSelect($tablaCategorias, $nameForm, $idForm, $selected);
    }

    public function mostrarCategoriasCrudTable($tablaCtegorias) {
        $this->categoriaMQT->maquetaArrayObject($tablaCtegorias);
    }

    public function mostrarCategoriaFormUpdate(CategoriaDTO $categoria) {
        $categoriaFinded = $this->categoriaDAO->find($categoria);
        $this->categoriaMQT->maquetaFormularioUpdate($categoriaFinded);
    }

    public function mostrarCategoriaFormInsert() {
        $this->categoriaMQT->maquetaFormularioInsert();
    }

    public function disableEnable(CategoriaDTO $categoria) {
        $ok = FALSE;
        $accion = "";
        if ($categoria->getActiva()) {
            $accion = "ACTIVADA";
        } else {
            $accion = "DESACTIVADA";
        }
        $rta = $this->categoriaDAO->disable_enable($categoria);
        switch ($rta) {
            case 1:
                $this->contentMGR->setFormato(new Exito());
                $this->contentMGR->setContenido("La categoria " . Validador::fixTexto($categoria->getNombre()) . " fue " . $accion);
                $ok = TRUE;
                break;
            case 0:
                $this->contentMGR->setFormato(new Neutral());
                $this->contentMGR->setContenido("La categoria ya se encontraba " . $accion);
                $ok = TRUE;
                break;
            case -1:
                $this->contentMGR->setFormato(new Errado());
                $this->contentMGR->setContenido("Hubo un error grave en la base de datos.");
                break;
        }
        return $ok;
    }

    public function actualizar(EntityDTO $entidad) {
        $ok = FALSE;
        $entidad instanceof CategoriaDTO;
        $rta = $this->categoriaDAO->update($entidad);
        switch ($rta) {
            case 1:
                $this->contentMGR->setFormato(new Exito());
                $this->contentMGR->setContenido("La categoría fue actualizada correctamente");
                $ok = TRUE;
                break;
            case 0:
                $this->contentMGR->setFormato(new Neutral());
                $this->contentMGR->setContenido("No se registraron cambios en la categoria");
                $ok = TRUE;
                break;
            case -1:
                $this->contentMGR->setFormato(new Errado());
                $this->contentMGR->setContenido("Hubo un error grave. Verifique los datos e intente de nuevo.");
                break;
        }
        return $ok;
    }

    public function eliminar(EntityDTO $entidad) {
        $ok = FALSE;
        $rta = $this->categoriaDAO->update($entidad);
        switch ($rta) {
            case 1:
                $this->contentMGR->setFormato(new Exito());
                $this->contentMGR->setContenido("La categoría fue eliminada correctamente");
                $ok = TRUE;
                break;
            case 0:
                $this->contentMGR->setFormato(new Neutral());
                $this->contentMGR->setContenido("No se encontró dicha categoria para ser eliminada");
                $ok = TRUE;
                break;
            case -1:
                $this->contentMGR->setFormato(new Errado());
                $this->contentMGR->setContenido("Hubo un error grave. Verifique los datos e intente de nuevo.");
                break;
        }
        return $ok;
    }

    public function encontrar(EntityDTO $entidad) {
        $cateFinded = $this->categoriaDAO->find($entidad);
        return $cateFinded;;
    }

    public function encontrarTodos() {
        $tablaCategorias = $this->categoriaDAO->findAll();
        return $tablaCategorias;
    }

    public function insertar(EntityDTO $entidad) {
        $ok = FALSE;
        $entidad instanceof CategoriaDTO;
        $rta = $this->categoriaDAO->insert($entidad);
        switch ($rta) {
            case 1:
                $this->contentMGR->setFormato(new Exito());
                $this->contentMGR->setContenido("La categoría fue guardada correctamente");
                $ok = TRUE;
                break;
            case 0:
                $this->contentMGR->setFormato(new Errado());
                $this->contentMGR->setContenido("No se guardó la nueva categoría. Intente de nuevo");
                break;
            case -1:
                $this->contentMGR->setFormato(new Errado());
                $this->contentMGR->setContenido("Hubo un error grave. Verifique los datos e intente de nuevo.");
                break;
        }
        return $ok;
    }

    public function validaFK(EntityDTO $entidad) {
        $entidad instanceof CategoriaDTO;
        $entidad->setIdCategoria($entidad->getCategoriaIdCategoria());
        if (is_null($this->categoriaDAO->find($entidad))) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function validaPK(EntityDTO $entidad) {
        if (is_null($this->categoriaDAO->find($entidad))) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

class CategoriaRequest extends Request {

    const id_cat = "categoria_id";
    const name_cat = "categoria_nombre";
    const act_cat = "categoria_activa";
    const desc_cat = "categoria_descripcion";
    const cat_id_cat = "categoria_id_categoria";

    private $categoriaDTO = NULL;

    public function __construct() {
        parent::__construct();
    }

    public function getCategoriaDTO() {
        return $this->categoriaDTO;
    }

    public function setCategoriaDTO($categoriaDTO) {
        $this->categoriaDTO = $categoriaDTO;
    }

    public function doDelete() {
        return NULL;
    }

    public function doGet() {
        $catTemp = new CategoriaDTO();
        if (isset($_GET[self::id_cat])) {
            $catTemp->setIdCategoria(filter_input(INPUT_GET, self::id_cat));
        }
        if (isset($_GET[self::name_cat])) {
            $catTemp->setNombre(filter_input(INPUT_GET, self::name_cat));
        }
        if (isset($_GET[self::act_cat])) {
            $catTemp->setActiva(filter_input(INPUT_GET, self::act_cat));
        }
        if (isset($_GET[self::desc_cat])) {
            $catTemp->setDescripcion(filter_input(INPUT_GET, self::desc_cat));
        }
        if (isset($_GET[self::cat_id_cat])) {
            $catTemp->setCategoriaIdCategoria(filter_input(INPUT_GET, self::cat_id_cat));
        }
        $this->categoriaDTO = $catTemp;
    }

    public function doHead() {
        return NULL;
    }

    public function doPost() {
        $catTemp = new CategoriaDTO();
        if (isset($_POST[self::id_cat])) {
            $catTemp->setIdCategoria(filter_input(INPUT_POST, self::id_cat));
        }
        if (isset($_POST[self::name_cat])) {
            $catTemp->setNombre(filter_input(INPUT_POST, self::name_cat));
        }
        if (isset($_POST[self::act_cat])) {
            $catTemp->setActiva(filter_input(INPUT_POST, self::act_cat));
        }
        if (isset($_POST[self::desc_cat])) {
            $catTemp->setDescripcion(filter_input(INPUT_POST, self::desc_cat));
        }
        if (isset($_POST[self::cat_id_cat])) {
            $catTemp->setCategoriaIdCategoria(filter_input(INPUT_POST, self::cat_id_cat));
        }
        $this->categoriaDTO = $catTemp;
    }

    public function doPut() {
        return NULL;
    }

    public function doRequest() {
        $catTemp = new CategoriaDTO();
        if (isset($_REQUEST[self::id_cat])) {
            $catTemp->setIdCategoria(filter_input(INPUT_REQUEST, self::id_cat));
        }
        if (isset($_REQUEST[self::name_cat])) {
            $catTemp->setNombre(filter_input(INPUT_REQUEST, self::name_cat));
        }
        if (isset($_REQUEST[self::act_cat])) {
            $catTemp->setActiva(filter_input(INPUT_REQUEST, self::act_cat));
        }
        if (isset($_REQUEST[self::desc_cat])) {
            $catTemp->setDescripcion(filter_input(INPUT_REQUEST, self::desc_cat));
        }
        if (isset($_REQUEST[self::cat_id_cat])) {
            $catTemp->setCategoriaIdCategoria(filter_input(INPUT_REQUEST, self::cat_id_cat));
        }
        $this->categoriaDTO = $catTemp;
    }

}
