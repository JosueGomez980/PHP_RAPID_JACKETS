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

require_once '../../contenido/modelo/dao/ProductoDTO.php';

class ProductoDTOTest extends TestCase {

    private $proDTO;
    
    public function testNum1() {
        $this->proDTO = new ProductoDTO();
        $this->proDTO->setIdProducto("PRO001");
        $this->proDTO->setNombre("Elkinsiquejode");
        $this->proDTO->setCantidad(12);
        echo(json_encode($this->proDTO));
    }
    public function testNum2(){
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
        echo(var_dump($json));
        echo(var_dump($obj));
        $neP = ProductoDTO::stdClassToDTO($obj);
        echo (var_dump($neP));
    }
    public function testNum3(){
        $itemDAO = new ItemDAO();
        $itemDTO = new ItemDTO();
    }

}

$test = new ProductoDTOTest();
$test->testNum1();
$test->testNum2();
