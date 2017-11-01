<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductoDAOTest
 *
 * @author SOPORTE
 */
use PHPUnit\Framework\TestCase;

require_once '../../contenido/modelo/dao/EntityDTO.php';
require_once '../../contenido/modelo/dao/PreparedSQL.php';
require_once '../../contenido/modelo/dao/Conexion.php';
require_once '../../contenido/modelo/dao/ProductoDTO.php';
require_once '../../contenido/modelo/dao/ProductoDAO.php';
require_once '../../contenido/modelo/dao/ItemDAO.php';
require_once '../../contenido/modelo/dao/ItemDTO.php';
require_once '../../contenido/modelo/dao/ProductoDTO.php';

//Pruebas de una entidad dto y su relacion con el DAO para persistir en la base de datos
class ProductoDAOTest extends TestCase {

    private $proDTO;

    public function tesNum1() {
        $this->proDTO = new ProductoDTO();
        $this->proDTO->setIdProducto("PRO001");
        $this->proDTO->setNombre("Elkinsiquejode");
        $this->proDTO->setCantidad(12);
        //echo(json_encode($this->proDTO));
    }

    public function tesNum2() {
        $this->proDTO = new ProductoDTO();
        $this->proDTO->setIdProducto("PRO001");
        $this->proDTO->setNombre("Elkinsiquejode");
        $this->proDTO->setCantidad(12);
        $this->proDTO->setActivo(true);
        $this->proDTO->setCatalogoIdCatalogo(1);
        $this->proDTO->setPrecio(200);
        $this->proDTO->setCategoriaIdCategoria(2);
        $this->proDTO->setFoto("dgdsgdfgdfg");
        $this->proDTO->setDescripcion("Este producto ha sido pasado de objeto a json. luego a stdClass y de nuevo a la Instancia inicial");
        $json = (json_encode($this->proDTO));
        $obj = json_decode($json);
        //echo(var_dump($json));
        //echo(var_dump($obj));
        $neP = ProductoDTO::stdClassToDTO($obj);
        //echo (var_dump($neP));
    }

    public function tesInsert() {
        $proDAO = new ProductoDAO();
        $proDTO = new ProductoDTO();
        $proDTO->setIdProducto($proDAO->generateIdInDB());
        $proDTO->setNombre("Nuevo Producto");
        $proDTO->setCatalogoIdCatalogo(1);
        $proDTO->setCategoriaIdCategoria(5);
        $proDTO->setCantidad(10);
        $proDTO->setActivo(true);
        $proDTO->setFoto($proDAO->generateProductoImageUrl());
        $proDTO->setDescripcion("BasuraBasura de pruebaBasura de pruebaBasura de pruebaBasura de pruebade prueba");
        $proDTO->setPrecio(5500);
        $rta = $proDAO->insert($proDTO);
        $this->assertEquals(1, $rta);
    }

    public function tesUpdate() {
        $proDAO = new ProductoDAO();
        $proDTO = new ProductoDTO();
        $proDTO->setIdProducto("pro0000034");
        $proDTO->setNombre("Nuevo producto Actualizado");
        $proDTO->setCatalogoIdCatalogo(1);
        $proDTO->setCategoriaIdCategoria(6);
        $proDTO->setCantidad(9699);
        $proDTO->setActivo(true);
        $proDTO->setFoto($proDAO->generateProductoImageUrl());
        $proDTO->setDescripcion("SADASDASGHfjhgdf}AASDSFSDfsdjghslkdjfhKJDFHGJKAHÑkjdhlgkjHLFKJlkjHlkjldkjLJKEHGL");
        $proDTO->setPrecio(123456);
        $rta = $proDAO->update($proDTO);
        $this->assertEquals(1, $rta);
    }

    public function tesCambiarCantidad() {
        echo("Test del metodo update cantidad");
        $proDAO = new ProductoDAO();
        $proDTO = new ProductoDTO();
        $proDTO->setIdProducto("pro0000030");
        $proDTO->setCantidad(9);
        $rta = $proDAO->updateCantidad($proDTO);
        $this->assertEquals(1, $rta);
        echo(var_dump($proDTO));
    }

    public function tesDelete() {
        echo("\n Test del metodo update cantidad.\n");
        $proDAO = new ProductoDAO();
        $proDTO = new ProductoDTO();
        $proDTO->setIdProducto("pro0000040");
        $proDTO->setCantidad(9);
        $proF = $proDAO->find($proDTO);
        $this->assertInstanceOf(ProductoDTO::class, $proF);
        $rta = $proDAO->delete($proDTO);
        $this->assertEquals(1, $rta);
        echo(var_dump($proF));
    }

    public function tesDisableEnable() {
        echo("\n Test del metodo disableEnable.\n");
        $proDAO = new ProductoDAO();
        $proDTO = new ProductoDTO();
        $proDTO->setIdProducto("pro0000030");
        $rta = $proDAO->disable_enable($proDTO, true);
        $proF = $proDAO->find($proDTO);
        $this->assertInstanceOf(ProductoDTO::class, $proF);
        $this->assertEquals(1, $rta);
        echo(var_dump($proF));
    }

    public function testFind() {
        echo("\n Test del metodo find para buscar por Id.\n");
        $proDAO = new ProductoDAO();
        $proDTO = new ProductoDTO();
        $proDTO->setIdProducto("pro0000010");
        $proF = $proDAO->find($proDTO);
        $this->assertInstanceOf(ProductoDTO::class, $proF);
        echo(var_dump($proF));
    }
    
}

//$test = new ProductoDAOTest();
//$test->tesNum3();
