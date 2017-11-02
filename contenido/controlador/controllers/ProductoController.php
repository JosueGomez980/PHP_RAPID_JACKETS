<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductoController
 *
 * @author Josué Francisco
 */
include_once 'cargar_clases3.php';
AutoCarga3::init();

class ProductoRequest extends Request {

    private $productoDTO = NULL;

    const pro_id = "producto_id";
    const pro_name = "producto_name";
    const pro_id_cat = "producto_id_categoria";
    const pro_id_cag = "producto_id_catalogo";
    const pro_des = "producto_descripcion";
    const pro_prec = "producto_precio";
    const pro_act = "producto_activo";
    const pro_ctd = "producto_cantidad";
    const pro_foto = "producto_foto";

    public function __construct() {
        parent::__construct();
    }

    public function getProductoDTO() {
        return $this->productoDTO;
    }

    public function doDelete() {
        return NULL;
    }

    public function doGet() {
        $proTemp = new ProductoDTO();
        if (isset($_GET[self::pro_id])) {
            $proTemp->setIdProducto(filter_input(INPUT_GET, self::pro_id, FILTER_SANITIZE_STRING));
        }
        if (isset($_GET[self::pro_id_cat])) {
            $proTemp->setCategoriaIdCategoria(filter_input(INPUT_GET, self::pro_id_cat));
        }
        if (isset($_GET[self::pro_id_cag])) {
            $proTemp->setCatalogoIdCatalogo(filter_input(INPUT_GET, self::pro_id_cag));
        }
        if (isset($_GET[self::pro_name])) {
            $proTemp->setNombre(filter_input(INPUT_GET, self::pro_name, FILTER_SANITIZE_STRING));
        }
        if (isset($_GET[self::pro_des])) {
            $proTemp->setDescripcion(filter_input(INPUT_GET, self::pro_des, FILTER_SANITIZE_STRING));
        }
        if (isset($_GET[self::pro_prec])) {
            $proTemp->setPrecio(filter_input(INPUT_GET, self::pro_prec, FILTER_SANITIZE_NUMBER_FLOAT));
        }
        if (isset($_GET[self::pro_ctd])) {
            $proTemp->setCantidad(filter_input(INPUT_GET, self::pro_ctd));
        }
        $this->productoDTO = $proTemp;
    }

    public function doHead() {
        return NULL;
    }

    public function doPost() {
        $proTemp = new ProductoDTO();
        if (isset($_POST[self::pro_id])) {
            $proTemp->setIdProducto(filter_input(INPUT_POST, self::pro_id, FILTER_SANITIZE_STRING));
        }
        if (isset($_POST[self::pro_id_cat])) {
            $proTemp->setCategoriaIdCategoria(filter_input(INPUT_POST, self::pro_id_cat));
        }
        if (isset($_POST[self::pro_id_cag])) {
            $proTemp->setCatalogoIdCatalogo(filter_input(INPUT_POST, self::pro_id_cag));
        }
        if (isset($_POST[self::pro_name])) {
            $proTemp->setNombre(filter_input(INPUT_POST, self::pro_name, FILTER_SANITIZE_STRING));
        }
        if (isset($_POST[self::pro_des])) {
            $proTemp->setDescripcion(filter_input(INPUT_POST, self::pro_des, FILTER_SANITIZE_STRING));
        }
        if (isset($_POST[self::pro_prec])) {
            $proTemp->setPrecio(filter_input(INPUT_POST, self::pro_prec, FILTER_SANITIZE_NUMBER_FLOAT));
        }
        if (isset($_POST[self::pro_ctd])) {
            $proTemp->setCantidad(filter_input(INPUT_POST, self::pro_ctd));
        }
        $this->productoDTO = $proTemp;
    }

    public function doPut() {
        return NULL;
    }

    public function doRequest() {
        $proTemp = new ProductoDTO();
        if (isset($_REQUEST[self::pro_id])) {
            $proTemp->setIdProducto(filter_input(INPUT_REQUEST, self::pro_id, FILTER_SANITIZE_STRING));
        }
        if (isset($_REQUEST[self::pro_id_cat])) {
            $proTemp->setCategoriaIdCategoria(filter_input(INPUT_REQUEST, self::pro_id_cat));
        }
        if (isset($_REQUEST[self::pro_id_cag])) {
            $proTemp->setCatalogoIdCatalogo(filter_input(INPUT_REQUEST, self::pro_id_cag));
        }
        if (isset($_REQUEST[self::pro_name])) {
            $proTemp->setNombre(filter_input(INPUT_REQUEST, self::pro_name, FILTER_SANITIZE_STRING));
        }
        if (isset($_REQUEST[self::pro_des])) {
            $proTemp->setDescripcion(filter_input(INPUT_REQUEST, self::pro_des, FILTER_SANITIZE_STRING));
        }
        if (isset($_REQUEST[self::pro_prec])) {
            $proTemp->setPrecio(filter_input(INPUT_REQUEST, self::pro_prec, FILTER_SANITIZE_NUMBER_FLOAT));
        }
        if (isset($_REQUEST[self::pro_ctd])) {
            $proTemp->setCantidad(filter_input(INPUT_REQUEST, self::pro_ctd));
        }
        $this->productoDTO = $proTemp;
    }

}

class ProductoController implements GenericController, Validable {

    private $productoDAO;
    private $productoMQT;
    private $contentMGR;
    public static $instance = null;

    public function __construct() {
        $this->productoDAO = new ProductoDAO();
        $this->contentMGR = new ContentManager();
        $this->productoMQT = new ProductoMaquetador();
    }

    public static function getInstancia() {
        if (is_null(self::$instance)) {
            self::$instance = new ProductoController();
        }
        return self::$instance;
    }

    public function actualizar(EntityDTO $entidad) {
        $entidad instanceof ProductoDTO;
        $ok = FALSE;
        if ($this->validaPK($entidad)) {
            $rta = $this->productoDAO->update($entidad);
            switch ($rta) {
                case 1:
                    $this->contentMGR->setFormato(new Exito());
                    $this->contentMGR->setContenido("El producto " . $entidad->getNombre() . " fue actualizado correctamente. Se detectaron cambios");
                    $ok = TRUE;
                    break;
                case 0:
                    $this->contentMGR->setFormato(new Neutral());
                    $this->contentMGR->setContenido("No se detectaron cambios");
                    $ok = TRUE;
                    break;
                case -1:
                    $this->contentMGR->setFormato(new Errado());
                    $this->contentMGR->setContenido("Hubo un error grave al actualizar el producto. Intente de nuevo.");
                    break;
            }
        } else {
            $this->contentMGR->setFormato(new Errado());
            $this->contentMGR->setContenido("No existe el producto. No puede ser actualizado");
        }
        return $ok;
    }

    public function eliminar(EntityDTO $entidad) {
        $ok = FALSE;
        $entidad instanceof ProductoDTO;
        if ($this->validaPK($entidad)) {
            $rta = $this->productoDAO->delete($entidad);
            switch ($rta) {
                case 0:
                    $this->contentMGR->setFormato(new Errado());
                    $this->contentMGR->setContenido("No se pudo eliminar el producto. Procedimiento fallido");
                    break;
                case 1:
                    $this->contentMGR->setFormato(new Exito());
                    $this->contentMGR->setContenido("El producto fue eliminado correctamente de la base datos");
                    $ok = TRUE;
                    break;
                case -1:
                    $this->contentMGR->setFormato(new Errado());
                    $this->contentMGR->setContenido("El producto no puede ser eliminado. Ya está en uso y se han generado procesos con su información.");
                    break;
            }
        } else {
            $this->contentMGR->setFormato(new Errado());
            $this->contentMGR->setContenido("Este producto no existe.");
        }
        return $ok;
    }

    public function encontrar(EntityDTO $entidad) {
        $entidad instanceof ProductoDTO;
        $this->productoMQT->maquetaObject($entidad);
    }

    public function encontrarTodos() {
        $tablaProductos = $this->productoDAO->findAll();
        return $tablaProductos;
    }

    public function mostrarUpdateFormulario(ProductoDTO $producto) {
        $this->productoMQT->maquetaUpdateFormProducto($producto);
    }

    public function insertar(EntityDTO $entidad) {
        $ok = FALSE;
        $entidad instanceof ProductoDTO;
        $entidad->setIdProducto($this->productoDAO->generateIdInDB());
        $rta = $this->productoDAO->insert($entidad);

        switch ($rta) {
            case 0:
                $this->contentMGR->setFormato(new Errado());
                $this->contentMGR->setContenido("No se pudo registrar el producto. Verifique los datos e intente de nuevo");
                break;
            case 1:
                $this->contentMGR->setFormato(new Exito());
                $this->contentMGR->setContenido("El producto se registró correctamente.");
                $ok = TRUE;
                break;
            case -1:
                $this->contentMGR->setFormato(new Errado());
                $this->contentMGR->setContenido("Hubo un error grave al momento de insertar el producto :( .");
                break;
        }
        return $ok;
    }

    public function listarByCategoria(ProductoDTO $prodPost) {
        $productos = $this->productoDAO->findByCategoria($prodPost);
        if (!is_null($productos)) {
            $cantidad = count($productos);
            $this->contentMGR->setFormato(new Exito());
            $this->contentMGR->setContenido("Encontrados $cantidad productos");
            $this->productoMQT->maquetaArrayObject($productos);
        } else {
            $this->contentMGR->setFormato(new Neutral());
            $this->contentMGR->setContenido("No se encontraron productos de esta categoría.");
        }
    }

    public function listarPorDefecto() {
        $productos = $this->productoDAO->findAll();
        $pros = array();
        if (!is_null($productos)) {
            $limite = (int) (ceil(rand(1, count($productos))));
            for ($i = 0; $i < $limite; $i++) {
                $pros[$i] = $productos[$i];
            }
            $this->productoMQT->maquetaArrayObject($pros);
        } else {
            $this->contentMGR->setFormato(new Neutral());
            $this->contentMGR->setContenido("No existe ningún producto aún.");
            echo($this->contentMGR->maquetar());
        }
    }

    public function listarPorNombreLike(ProductoDTO $proFind) {
        $nombreAbuscar = Validador::textoParaBuscar($proFind->getNombre());
        $arrayProductos = $this->productoDAO->findByNameLike($nombreAbuscar);
        if (!is_null($arrayProductos) && count($arrayProductos) >= 1) {
            $this->contentMGR->setFormato(new Exito());
            $this->contentMGR->setContenido("Encontrados " . count($arrayProductos) . " productos que coinciden con tu búsqueda.");
            $this->productoMQT->maquetaArrayObject($arrayProductos);
        } else {
            $neu = new Neutral();
            $neu->setValor("No se encontró ningun producto que coincida con el nombre que has escrito :( ");
            echo($neu->toString($neu->getValor()));
        }
    }

    public function listarPorNombreLikeAdmin(ProductoDTO $proFind) {
        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;
        $pager = $sesion->get(Session::PAGINADOR);
        $pager instanceof PaginadorMemoria;
        $nombreAbuscar = Validador::textoParaBuscar($proFind->getNombre());
        $arrayProductos = $this->productoDAO->findByNameLike($nombreAbuscar);
        if (!is_null($arrayProductos) && count($arrayProductos) >= 1) {
            $this->contentMGR->setFormato(new Exito());
            $this->contentMGR->setContenido("Encontrados " . count($arrayProductos) . " productos que coinciden con tu búsqueda.");
            $this->productoMQT->maquetaProductoTablaCrud($arrayProductos);
        } else {
            $neu = new Neutral();
            $neu->setValor("No se encontró ningun producto que coincida con el nombre que has escrito :( ");
            echo($neu->toString($neu->getValor()));
        }
    }

    public function mostrarFormDisEnable(ProductoDTO $producto) {
        $this->productoMQT->maquetaProductoDisableEnable($producto);
    }

    public function mostrarCrudTable(array $productos) {
        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;
        $pager = $sesion->get(Session::PAGINADOR);
        $pager instanceof PaginadorMemoria;
        $pager->maquetarBarraPaginacion();
        $this->productoMQT->maquetaProductoTablaCrud($productos);
        $pager->maquetarBarraPaginacion();
    }

    public function mostrarCrudTableForInventario(array $productos) {
        $this->productoMQT->maquetaProductoTablaCrudInventario($productos);
    }

    public function disableEnable(ProductoDTO $pro, $yn) {
        $ok = TRUE;
        $rta = $this->productoDAO->disable_enable($pro, $yn);
        $msg = "";
        $activo = "";
        $activo2 = "";
        if ($pro->getActivo()) {
            $activo = "HABILITADO";
        } else {
            $activo = "DESABILITADO";
        }
        if ($yn) {
            $activo2 = "HABILITADO";
        } else {
            $activo2 = "DESABILITADO";
        }
        switch ($rta) {
            case 0:
                $msg = "EL PRODUCTO YA ESTABA " . $activo;
                $this->contentMGR->setFormato(new Neutral());
                $this->contentMGR->setContenido($msg);
                break;
            case 1:
                $msg = "EL PRODUCTO FUE " . $activo2;
                $this->contentMGR->setFormato(new Exito());
                $this->contentMGR->setContenido($msg);
                break;
            case -1:
                $msg = "HUBO UN ERROR. INTENTE DE NUEVO";
                $this->contentMGR->setFormato(new Errado());
                $this->contentMGR->setContenido($msg);
                $ok = FALSE;
                break;
        }
    }

    public function mostrarModalBusquedaAvanzada($idRta, $method) {
        $this->productoMQT->maquetarBusquedaAvanzada($idRta, $method);
    }

    public function encontrarPorBusquedaAvanzadaByUser(ProductoDTO $profind, array $rangoPrecio) {
        $profind->setDescripcion(Validador::textoParaBuscar($profind->getDescripcion()));
        if ($rangoPrecio["MAX"] < $rangoPrecio["MIN"]) {
            $err = new Errado();
            $err->setValor("Datos del precio incorrectos");
            echo($err->toString($err->getValor()));
        } else {
            $tablaProductos = $this->productoDAO->findDinamic($profind, $rangoPrecio);
            if (is_null($tablaProductos) || count($tablaProductos) <= 0) {
                $err = new Neutral();
                $err->setValor("No se encontró ningun producto con los parámetros que estableciste.");
                echo($err->toString($err->getValor()));
            } else {
                $err = new Exito();
                $err->setValor("Encontrados " . count($tablaProductos) . " productos con los parámetros indicados.");
                echo($err->toString($err->getValor()));

                $this->productoMQT->maquetaArrayObject($tablaProductos);
            }
        }
    }

    public function encontrarPorBusquedaAvanzadaByAdmin(ProductoDTO $profind, array $rangoPrecio) {
        $profind->setDescripcion(Validador::textoParaBuscar($profind->getDescripcion()));
        if ($rangoPrecio["MAX"] < $rangoPrecio["MIN"]) {
            $err = new Errado();
            $err->setValor("Datos del precio incorrectos");
            echo($err->toString($err->getValor()));
        } else {
            $tablaProductos = $this->productoDAO->findDinamic($profind, $rangoPrecio);
            if (is_null($tablaProductos) || count($tablaProductos) <= 0) {
                $err = new Neutral();
                $err->setValor("No se encontró ningun producto con los parámetros que estableciste.");
                echo($err->toString($err->getValor()));
            } else {
                $err = new Exito();
                $err->setValor("Encontrados " . count($tablaProductos) . " productos con los parámetros indicados.");
                echo($err->toString($err->getValor()));

                $this->mostrarCrudTable($tablaProductos);
            }
        }
    }

    public function newIdProductoDB() {
        return $this->productoDAO->generateIdInDB();
    }

    public function newIdProductoCORE() {
        return $this->productoDAO->generateIdInCore();
    }

    public function validaFK(EntityDTO $entidad) {
        if (is_null($this->productoDAO->findByFK($entidad))) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function validaPK(EntityDTO $entidad) {
        if (is_null($this->productoDAO->find($entidad))) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

//put your code here
}
