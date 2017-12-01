<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CarritoComprasMaquetador implements GenericMaquetador {

    public function maquetaArrayObject(array $entidades) {
        return NULL;
    }

    //Este metodo para mostrar la ficha tecnica de un producto
    public function maquetaObject(EntityDTO $entidad) {
        $carrito = $entidad;
        $carrito instanceof CarritoComprasDTO;
        $items = $carrito->getItems();
        $totalCarrito = Validador::formatPesos($carrito->getTotal());
        $impuestosCarrito = Validador::formatPesos($carrito->getImpuestos());
        $subTotalCarrito = Validador::formatPesos($carrito->getSubtotal());
        echo('<br><br><br><div class="w3-row">
            <div class="container-fluid is-Tamaño-ContainerXD w3-white" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
            <br>
                <div class="w3-center w3-container w3-padding-8 w3-white">
                    <span class="is-LetraColor09">Tu Carrito de Compras</span>
                </div>
                <div class="w3-container"></div>
            </div></div>
            <div class="container-fluid is-Tamaño-ContainerXD w3-white" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
            <br>
            <div class="container-fluid" style="width: 70%;">
                <table class="w3-table-all w3-small is-Heidy-XD">
                    <tr class="w3-large is-Color16 w3-border-green w3-center">
                        <th style="width: 30%">PRODUCTO</th>
                        <th style="width: 10%">PRECIO</th>
                        <th style="width: 10%">CANTIDAD</th>
                        <th style="width: 10%">TOTAL</th>
                        <th style="width: 15%">ELIMINAR/EDITAR</th>
             </tr>');

        foreach ($items as $it) {
            $it instanceof ItemCarritoDTO;
            $pro = $it->getProducto();
            $pro instanceof ProductoDTO;
            $precioU = Validador::formatPesos($pro->getPrecio());
            $idProducto = CriptManager::urlVarEncript($it->getProductoIdProducto());
            $cantidad = $it->getCantidad();
            $total = Validador::formatPesos($it->getCostoTotal());
            $prodName = $pro->getNombre();

            echo('<tr class="is-Tamaño-LetraCarrito">
                    <td  style="width: 30%">' . $prodName . '</td>
                    <td  style="width: 10%">' . $precioU . '</td>
                    <td class="w3-center" style="width: 10%">' . $cantidad . '</td>
                    <td  style="width: 10%">' . $total . '</td>
                    <td class="w3-center" style="width: 15%">
                        <a href="controlador/negocio/delete_from_carrito.php?producto_id=' . $idProducto . '"><img src="../media/img/OtroCarritoEliminarXD.png" class="m-crud_icons"/></a>
                        <img src="../media/img/ModificarXD.png" class="m-crud_icons" onclick="mostrarItemCarritoInModal(\'' . $idProducto . '\');" />
                    </td>
                </tr>');
        }


        echo('<tr><td colspan = 5><b>SUBTOTAL : </b>' . $subTotalCarrito . '<br><b>IMPUESTOS : </b>' . $impuestosCarrito . '
        <br><b>TOTAL : </b>' . $totalCarrito . '</td></tr>');

        echo('</table><br><br></div></div></div>><br><br><br>');
    }

    public function maquetaItemCarrito(ItemCarritoDTO $item) {
        $proDAO = new ProductoDAO();
        $pro = $item->getProducto();
        $pro instanceof ProductoDTO;
        $proF = $proDAO->find($pro);
        $disponible = $proF->getCantidad();
        $prodName = $pro->getNombre();
        $precioU = Validador::formatPesos($pro->getPrecio());
        $cantidad = $item->getCantidad();
        $idPro = CriptManager::urlVarEncript($proF->getIdProducto());

        $modal = new ModalSimple();
        $modal->open();
        echo('<form method="GET" action="controlador/negocio/update_item_carrito.php"><div class="w3-row">
            <input type="hidden" name="producto_id" value="' . $idPro . '">
                <br>
                <div class="w3-center w3-container w3-padding-8 w3-white">
                <center><div class="w3-tag w3-round" style="width: 60%; background-color:#FFC300;">
                        <span class="is-Title01 w3-center">Cambia la Cantidad</span>
                    </div></center>
                <br>
                <div class="w3-container w3-white"></div>
                <br>
            </div>
            <div class="container-fluid w3-white">
                <table class="w3-table-all w3-small">
                    <tr class="is-Color27 w3-border-yellow w3-center">
                        <th style="width: 50%">PRODUCTO</th>
                        <th style="width: 25%">PRECIO</th>
                        <th style="width: 25%">CANTIDAD</th>
             </tr>');

        echo('<tr class="w3-white">
                    <td  style="width: 50%">' . $prodName . '</td>
                    <td  style="width: 25%">' . $precioU . '</td>
                    <td  style="width: 25%">
                         <input type="number" style="border:1px solid #000" name="producto_cantidad" value="' . $cantidad . '" min="1" max="' . $disponible . '" class="input_number">
                    </td>
                </tr>');
        echo('</table><br></div>');
        echo('<div class="w3-center">
                    <input type="submit" name="submit" value="Aplicar" class="w3-btn is-Button-CarritoXD"></form>
                </div><br>');
        $closeBtn = new CloseBtn();
        $closeBtn->setValor("Cancelar");
        $modal->addElemento($closeBtn);
        $modal->maquetar();
        $modal->close();
    }

    public function maquetaCarritoInModal(CarritoComprasDTO $carrito) {
        $botones = FALSE;
        $modal = new ModalSimple();
        $items = $carrito->getItems();
        $totalCarrito = Validador::formatPesos($carrito->getTotal());
        $impuestosCarrito = Validador::formatPesos($carrito->getImpuestos());
        $subTotalCarrito = Validador::formatPesos($carrito->getSubtotal());

        $modal->open();
        if (empty($items)) {
            echo ('<div class="container-fluid is-Tamaño-ContainerXD">');
            $vacio = new Neutral();
            $vacio->setValor("No has agregado productos al carrito ;)");
            $modal->addElemento($vacio);
            echo ('</div');
        } else {
            $botones = TRUE;
            echo('<div class = "w3-card-8">
        <div class = "w3-row is-Color16">
            <div class = "container-fluid" style="width: 70%;">
                <br>
                <div class="col-md-9">
                    <span class= "w3-large is-LetraColor07">Esto es lo que deseas comprar</span>
                </div>
                <div class="col-md-3" style="padding-bottom: 2%;">
                        <img src = "../media/img/boton-de-carrito-de-la-compra.png" style = "width: 30px; height: auto;">
                    </div>
                </div>
                <br>
            </div>
            
            <table class = "w3-table-all w3-small">
                <tr>
                    <th>PRODUCTO</th>
                    <th>PRECIO U.</th>
                    <th>CANTIDAD</th>
                    <th>TOTAL</th>
                    <th>VER PRODUCTO</th>
                </tr>');
                foreach ($items as $it) {
                    $it instanceof ItemCarritoDTO;
                    $pro = $it->getProducto();
                    $pro instanceof ProductoDTO;
                    $precioU = Validador::formatPesos($pro->getPrecio());
                    $idProducto = CriptManager::urlVarEncript($it->getProductoIdProducto());
                    $cantidad = $it->getCantidad();
                    $total = Validador::formatPesos($it->getCostoTotal());
                    $prodName = ($pro->getNombre());

           echo('<tr>
                    <td>' . $prodName . '</td>
                    <td>' . $precioU . '</td>
                    <td>' . $cantidad . '</td>
                    <td>' . $total . '</td>
                    <td><a href = "producto_ficha_tecnica.php?producto_id=' . $idProducto . '"><button class = "is-Button-CarritoXD w3-tiny">Ver Producto</button></a></td>
                </tr>');
                    }
                    if ($botones) {
               echo('<tr><td colspan = 5><span class = "is-Tamaño-Letra04"><b>SUBTOTAL</b> : ' . $subTotalCarrito . '</span><span class = "is-Tamaño-Letra04"><br><b>IMPUESTOS</b> : ' . $impuestosCarrito . '</span>
                     <br><span class = "is-Tamaño-Letra04"><b>TOTAL</b> : ' . $totalCarrito . '</span></td></tr>');
                    }
                }
       echo('</table>');
                if ($botones) {
                    echo('<div class = "w3-center w3-padding-8">
                            <a href = "gestion_carrito.php"><button class = "w3-btn is-Button-AdminCarr w3-round-large">Administrar Carrito</button></a>
                            <a href = "comprar_productos.php"><button class = "w3-btn is-Button-CompraCarr w3-round-large">Realizar Compra</button></a>
                         </div>');
                }
        echo('</div>');
        $closeBtn = new CloseBtn();
        $closeBtn->setValor("Cerrar");
        $modal->addElemento($closeBtn);
        $modal->maquetar();
        $modal->close();
    }

}
