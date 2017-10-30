<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PreparedSQL
 *
 * @author Josué Francisco
 */
final class PreparedSQL {

    // Querys de DML preparados
    // 
    //-------- Inntalacion de la base de datos----------------
    
    // -------Tabla CATEGORIA -----------
    const categoria_insert = "INSERT INTO CATEGORIA (NOMBRE, DESCRIPCION, CATEGORIA_ID_CATEGORIA) VALUES (?,?,?) ;";
    const categoria_update = "UPDATE CATEGORIA SET NOMBRE = ?, DESCRIPCION = ?, CATEGORIA_ID_CATEGORIA = ? WHERE ID_CATEGORIA = ? ;";
    const categoria_delete = "DELETE FROM CATEGORIA WHERE ID_CATEGORIA = ? ;";
    const categoria_find_pk = "SELECT * FROM CATEGORIA WHERE ID_CATEGORIA = ? ;";
    const categoria_find_all = "SELECT * FROM CATEGORIA;";
    const categoria_find_all_limit = "SELECT * FROM CATEGORIA LIMIT ? , ?;";
    const categoria_find_by_fk = "SELECT * FROM CATEGORIA WHERE CATEGORIA_ID_CATEGORIA = ? AND ID_CATEGORIA != ? ;";
    const categoria_disable = "UPDATE CATEGORIA SET ACTIVA = ? WHERE ID_CATEGORIA = ? ;";
    // -------Tabla CATALOGO ------------
    const catalogo_insert = "INSERT INTO CATALOGO (NOMBRE, DESCRIPCION, FOTO) VALUES (?,?,?);";
    const catalogo_delete = "DELETE FROM CATALOGO WHERE ID_CATALOGO = ? ;";
    const catalogo_update = "UPDATE CATALOGO SET NOMBRE = ?, DESCRIPCION = ?, FOTO = ? WHERE ID_CATALOGO = ? ;";
    const catalogo_find_pk = "SELECT * FROM CATALOGO WHERE ID_CATALOGO = ? ;";
    const catalogo_find_all = "SELECT * FROM CATALOGO ;";
    const catalogo_find_all_limit = "SELECT * FROM CATALOGO LIMIT ? , ?;";
    const catalogo_enable_disable = "UPDATE CATALOGO SET ACTIVO = ? WHERE ID_CATALOGO = ? ;";
    //--------Tabla Producto ------------
    const producto_insert = "INSERT INTO PRODUCTO (ID_PRODUCTO, CATEGORIA_ID_CATEGORIA, CATALOGO_ID_CATALOGO, NOMBRE, PRECIO, CANTIDAD, DESCRIPCION, FOTO) VALUES (?, ?, ?, ?, ?, ?, ?, ?) ;";
    const producto_update = "UPDATE PRODUCTO SET CATEGORIA_ID_CATEGORIA = ?, CATALOGO_ID_CATALOGO = ?, NOMBRE = ?, PRECIO = ?, DESCRIPCION = ?, FOTO = ? WHERE ID_PRODUCTO = ? ;";
    const producto_update_ctd = "UPDATE PRODUCTO SET CANTIDAD = ? WHERE ID_PRODUCTO = ? ;";
    const producto_delete = "DELETE FROM PRODUCTO WHERE ID_PRODUCTO = ? ;";
    const producto_find = "SELECT * FROM PRODUCTO WHERE ID_PRODUCTO = ? ;";
    const producto_find_all = "SELECT * FROM PRODUCTO;";
    const producto_find_all_limit = "SELECT * FROM PRODUCTO LIMIT ? , ?;";
    const producto_find_by_fk = "SELECT * FROM PRODUCTO WHERE CATALOGO_ID_CATALOGO = ? AND CATEGORIA_ID_CATEGORIA = ? ;";
    const producto_find_by_categoria = "SELECT * FROM PRODUCTO WHERE CATEGORIA_ID_CATEGORIA = ? ;";
    const producto_enable_disable = "UPDATE PRODUCTO SET ACTIVO = ? WHERE ID_PRODUCTO = ? ;";
    const producto_update_cantidad = "UPDATE PRODUCTO SET CANTIDAD = ? WHERE ID_PRODUCTO = ? ;";
    //--------Busquedas Avanzadas de producto ------------------
    //-- Por nombres
    const producto_find_by_name_like = "SELECT * FROM PRODUCTO WHERE LOWER(NOMBRE) LIKE ? ;";
    //-- Por precios-fijo
    const producto_find_by_precio = "SELECT * FROM PRODUCTO WHERE PRECIO = ? ;";
    //-- Por precios-rango
    const producto_find_by_precio_rango = "SELECT * FROM PRODUCTO WHERE PRECIO BETWEEN ? AND ? ;";
    //-- Por precio-max-min
    const producto_order_by_precio_asc = "SELECT * FROM PRODUCTO ORDER BY PRECIO ASC;";
    const producto_order_by_precio_desc = "SELECT * FROM PRODUCTO ORDER BY PRECIO DESC;";
    
    //--- Seleccionar datos escalares relacionados con busquedas especificas de la tabla product
    const producto_get_max_price = "SELECT MAX(p.PRECIO) AS 'MAX_PRICE' FROM PRODUCTO p;";
    const producto_get_min_price = "SELECT MIN(p.PRECIO) AS 'MIN_PRICE' FROM PRODUCTO p;";
    //
    //
    //-------Tabla Inventario del producto
    
    const inventario_insert = "INSERT INTO INVENTARIO VALUES (?, ?, ?, ?, ?, ?) ; ";
    const inventario_update = "UPDATE INVENTARIO SET FECHA = ?, CANTIDAD = ?, PRECIO_MAYOR = ?, OBSERVACIONES = ? WHERE ID_INVENTARIO = ? AND PRODUCTO_ID_PRODUCTO = ? ;";
    const inventario_delete = "DELETE FROM INVENTARIO WHERE ID_INVENTARIO = ? AND PRODUCTO_ID_PRODUCTO = ? ;";
    const inventario_find = "SELECT * FROM INVENTARIO WHERE ID_INVENTARIO = ? AND PRODUCTO_ID_PRODUCTO = ? ;";
    const inventario_find_all = "SELECT * FROM INVENTARIO ;";
    const inventario_find_all_limit = "SELECT * FROM INVENTARIO LIMIT ? , ?;";
    const inventario_find_by_producto = "SELECT * FROM INVENTARIO WHERE PRODUCTO_ID_PRODUCTO = ? ;";
    
    
    //-------Tabla Usuario----------
    const usuario_insert = "INSERT INTO USUARIO (ID_USUARIO, CONTRASENA, ROL, EMAIL) VALUES (?, ?, ?, ?) ; ";
    const usuario_update = "UPDATE USUARIO SET CONTRASENA = ?, EMAIL = ? WHERE ID_USUARIO = ? ;";
    const usuario_update_password = "UPDATE USUARIO SET CONTRASENA = ? WHERE ID_USUARIO = ? ;";
    const usuario_find_all = "SELECT * FROM USUARIO;";
    const usuario_find_all_limit = "SELECT * FROM USUARIO LIMIT ? , ? ;";
    const usuario_find = "SELECT * FROM USUARIO WHERE ID_USUARIO = ? ;";
    const usuario_find_by_id_like = "SELECT * FROM USUARIO WHERE LOWER(ID_USUARIO) LIKE ? ;";
    const usuario_find_by_rol_and_estado = "SELECT * FROM USUARIO WHERE ROL = ? AND ESTADO = ? ;";
    const usuario_by_email = "SELECT * FROM USUARIO WHERE EMAIL = ? ;";
    const usuario_delete = "DELETE FROM USUARIO WHERE ID_USUARIO = ? ;";
    const usuario_put_rol = "UPDATE USUARIO SET ROL = ? WHERE ID_USUARIO = ? ;";
    const usuario_put_estado = "UPDATE USUARIO SET ESTADO = ? WHERE ID_USUARIO = ? ;";
    //-------Tabla Cuenta-------------
    const cuenta_insert = "INSERT INTO CUENTA VALUES (?, ?, ?, ?, ?, ?, ?, ?) ;";
    const cuenta_find = "SELECT * FROM CUENTA WHERE TIPO_DOCUMENTO = ? AND NUM_DOCUMENTO = ? ;";
    const cuenta_find_by_num_doc = "SELECT * FROM CUENTA WHERE NUM_DOCUMENTO = ? ;";
    const cuenta_find_by_usuario = "SELECT * FROM CUENTA WHERE USUARIO_ID_USUARIO = ? ;";
    const cuenta_find_all = "SELECT * FROM CUENTA ;";
    const cuenta_find_all_limit = "SELECT * FROM CUENTA LIMIT ? , ? ;";
    const cuenta_update = "UPDATE CUENTA SET PRIMER_NOMBRE = ?, SEGUNDO_NOMBRE = ?, PRIMER_APELLIDO = ?, SEGUNDO_APELLIDO = ?, TELEFONO = ? WHERE TIPO_DOCUMENTO = ? AND NUM_DOCUMENTO = ? ;";
    const cuenta_delete = "DELETE FROM CUENTA WHERE TIPO_DOCUMENTO = ? AND NUM_DOCUMENTO = ? ;";
    //-------Busquedas avanzadas de Cuenta----------
    //Por nombres
    const cuenta_find_by_nombre_like = "SELECT * FROM CUENTA WHERE PRIMER_NOMBRE LIKE ? ;";
    const cuenta_find_by_nombre = "SELECT * FROM CUENTA WHERE PRIMER_NOMBRE = ? ;";
    //Por apellidos
    const cuenta_find_by_apellido_like = "SELECT * FROM CUENTA WHERE PRIMER_APELLIDO LIKE ? ;";
    const cuenta_find_by_apellido = "SELECT * FROM CUENTA WHERE PRIMER_APELLIDO = ? ;";
    //Por telefono
    const cuenta_find_by_telefono = "SELECT * FROM CUENTA WHERE TELEFONO = ? ;";
    //-------Tabla DomicilioCuenta
    const domicilio_insert = "INSERT INTO DOMICILIO_CUENTA VALUES (?, ?, ?, ?, ?, ?, ?) ;";
    const domicilio_update = "UPDATE DOMICILIO_CUENTA SET DIRECCION = ?, TELEFONO = ?, BARRIO = ?, LOCALIDAD = ?, CORREO_POSTAL = ? WHERE CUENTA_TIPO_DOCUMENTO = ? AND CUENTA_NUM_DOCUMENTO = ? ;";
    const domicilio_delete = "DELETE FROM DOMICILIO_CUENTA WHERE CUENTA_TIPO_DOCUMENTO = ? AND CUENTA_NUM_DOCUMENTO = ? ;";
    const domicilio_find = "SELECT * FROM DOMICILIO_CUENTA WHERE CUENTA_TIPO_DOCUMENTO = ? AND CUENTA_NUM_DOCUMENTO = ? ;";
    const domicilio_find_all = "SELECT * FROM DOMICILIO_CUENTA;";
    const domicilio_find_all_limit = "SELECT * FROM DOMICILIO_CUENTA LIMIT ? , ? ;";
    //---------Tabla Factura
    const factura_insert = "INSERT INTO FACTURA (ID_FACTURA, CUENTA_TIPO_DOCUMENTO, CUENTA_NUM_DOCUMENTO, FECHA, OBSERVACIONES, SUBTOTAL, IMPUESTOS, TOTAL) VALUES (?, ?, ?, ?, ?, ?, ?, ?) ;";
    const factura_update = "UPDATE FACTURA SET OBSERVACIONES = ?, SUBTOTAL = ?, IMPUESTOS = ?, TOTAL = ?, FECHA = ? WHERE ID_FACTURA = ? ;";
    const factura_put_estado = "UPDATE FACTURA SET ESTADO = ? WHERE ID_FACTURA = ? ;";
    const factura_delete = "DELETE FROM FACTURA WHERE ID_FACTURA = ? ;";
    const factura_find = "SELECT * FROM FACTURA WHERE ID_FACTURA = ? ;";
    const factura_find_all = "SELECT * FROM FACTURA;";
    const factura_find_all_limit = "SELECT * FROM FACTURA LIMIT ? , ? ;";
    const factura_find_by_cuenta = "SELECT * FROM FACTURA WHERE CUENTA_TIPO_DOCUMENTO = ? AND CUENTA_NUM_DOCUMENTO = ? ;";
    //-------Busquedas Avanzadas de Factura
    //---Por fecha acs (Admin, user), desc (Admin, user), rango (Admin, user), fija (Admin, User)
    //Fija
    const factura_find_by_date = "SELECT * FROM FACTURA WHERE DATE(FECHA) = ? ;";
    //ascendente
//    const factura_find_by_date_asc = "SELECT * FROM FACTURA ORDER BY FECHA ASC";
//    //descendente
//    const factura_find_by_date_desc = "SELECT * FROM FACTURA ORDER BY FECHA DESC";
//    //rango
//    const factura_find_by_date_range = "SELECT * FROM FACTURA WHERE FECHA BETWEEN ? AND ? ;";
//    //---Por Estado (SIN PAGAR, CANCELADA, ANULADA, ABONADA)
//    const factura_find_by_estado = "SELECT * FROM FACTURA WHERE ESTADO = ? ;";
// ------------Tabla Item_Factura
    const item_insert = "INSERT INTO ITEM_FACTURA VALUES (?, ?, ?, ?, ?) ;";
    const item_delete = "DELETE FROM ITEM_FACTURA WHERE FACTURA_ID_FACTURA = ? AND PRODUCTO_ID_PRODUCTO = ? ;";
    const item_update = "UPDATE ITEM_FACTURA SET CANTIDAD = ?, COSTO_UNITARIO = ?, COSTO_TOTAL = ? WHERE FACTURA_ID_FACTURA = ? AND PRODUCTO_ID_PRODUCTO = ? ;";
    const item_find = "SELECT * FROM ITEM_FACTURA WHERE FACTURA_ID_FACTURA = ? AND PRODUCTO_ID_PRODUCTO = ? ;";
    const item_find_by_factura = "SELECT * FROM ITEM_FACTURA WHERE FACTURA_ID_FACTURA = ? ;";
    const item_find_all = "SELECT * FROM ITEM_FACTURA ;";
    const item_find_all_limit = "SELECT * FROM ITEM_FACTURA LIMIT ? , ? ;";
    //---------Tabla Pago
    const pago_insert = "INSERT INTO PAGO (FACTURA_ID_FACTURA, TIPO_PAGO, VALOR, NUMERO_CUENTA, NUMERO_TARJETA) VALUES (?, ?, ?, ?, ?) ;";
    const pago_update = "UPDATE PAGO SET TIPO_PAGO = ?, VALOR = ?, NUMERO_CUENTA = ?, NUMERO_TARJETA = ? WHERE FACTURA_ID_FACTURA = ? ;";
    const pago_delete = "DELETE FROM PAGO WHERE FACTURA_ID_FACTURA = ? ;";
    const pago_find = "SELECT * FROM PAGO WHERE FACTURA_ID_FACTURA = ? ;";
    const pago_find_all = "SELECT * FROM PAGO ;";
    const pago_find_all_limit = "SELECT * FROM PAGO LIMIT ? , ? ;";
    //----------Tabla PedidoEntrega
    // --USER/ADMIN
    const pedido_insert = "INSERT INTO PEDIDO_ENTREGA VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ;";
    // --USER/ADMIN
    const pedido_update = "UPDATE PEDIDO_ENTREGA SET DOMICILIO = ?, FECHA_ENTREGA = ?, OBSERVACIONES = ?, SUBTOTAL = ?, IMPUESTOS = ?, TOTAL = ? WHERE FACTURA_ID_FACTURA = ? AND CUENTA_TIPO_DOCUMENTO = ? AND CUENTA_NUM_DOCUMENTO = ? ;";
    // --ADMIN
    const pedido_delete = "DELETE FROM PEDIDO_ENTREGA WHERE FACTURA_ID_FACTURA = ? ;";
    // --ADMIN
    const pedido_put_estado = "UPDATE PEDIDO_ENTREGA SET ESTADO = ? WHERE FACTURA_ID_FACTURA = ? ;";
    // --ADMIN
    const pedido_find = "SELECT * FROM PEDIDO_ENTREGA WHERE FACTURA_ID_FACTURA = ? AND CUENTA_TIPO_DOCUMENTO = ? AND CUENTA_NUM_DOCUMENTO = ? ;";
    // --ADMIN
    const pedido_find_all = "SELECT * FROM PEDIDO_ENTREGA ;";
    const pedido_find_all_limit = "SELECT * FROM PEDIDO_ENTREGA LIMIT ? , ? ;";
    // --USER/ADMIN
    const pedido_find_by_cuenta = "SELECT * FROM PEDIDO_ENTREGA WHERE CUENTA_TIPO_DOCUMENTO = ? AND CUENTA_NUM_DOCUMENTO = ? ;";
    // --ADMIN
    const pedido_find_by_estado = "SELECT * FROM PEDIDO_ENTREGA WHERE ESTADO = ? ORDER BY ESTADO ;";
    // --ADMIN
    const pedido_find_by_fecha_entrega = "SELECT * FROM PEDIDO_ENTREGA WHERE DATE(FECHA_ENTREGA) = ? ORDER BY FECHA_ENTREGA DESC;";
    // --ADMIN
    const pedido_find_by_fecha_solicitud = "SELECT * FROM PEDIDO_ENTREGA WHERE DATE(FECHA_SOLICITUD) = ? ORDER BY FECHA_SOLICITUD DESC ;";
    
    //----------------QUERY PARA LLAMAR FUNCIONES Y PROCEDIMIENTOS
    const get_new_producto_id = "SELECT GET_NEW_ID_PRODUCTO() AS 'NEW_ID';";
    const get_new_inventario_id = "SELECT GET_NEW_ID_INVENTARIO() AS 'NEW_ID';";
    const get_new_factura_id = "SELECT GET_NEW_ID_FACTURA() AS 'NEW_ID';";
}
