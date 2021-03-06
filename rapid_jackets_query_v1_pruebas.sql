-- -------EJECUTANDO PRUEBAS		
-- -------- SELECT TODO
SELECT * FROM CATEGORIA;
SELECT * FROM CATALOGO;
SELECT * FROM PRODUCTO;
SELECT * FROM INVENTARIO;
SELECT * FROM USUARIO;
SELECT * FROM CUENTA;
SELECT * FROM CUENTA_RESCUE;
SELECT * FROM DOMICILIO_CUENTA;
SELECT * FROM FACTURA;
SELECT * FROM ITEM_FACTURA ORDER BY FACTURA_ID_FACTURA;
SELECT * FROM PEDIDO_ENTREGA;
SELECT * FROM PAGO;

-- -------------joins-------------
SELECT u.ID_USUARIO, u.EMAIL, c.TIPO_DOCUMENTO, c.NUM_DOCUMENTO FROM
USUARIO u INNER JOIN CUENTA c
ON u.ID_USUARIO = c.USUARIO_ID_USUARIO
ORDER BY u.ID_USUARIO ASC; 
-- -----------------------
SELECT (NOMBRE, DESCRIPCION, CATEGORIA_ID_CATEGORIA) FROM CATEGORIA WHERE ID_CATEGORIA = ?;
SELECT * FROM CATALOGO WHERE ACTIVO = TRUE;
DELETE FROM CATEGORIA WHERE ID_CATEGORIA = 1;
UPDATE PRODUCTO SET NOMBRE = 'TOSTADAS FRANCESAS', PRECIO = 2500 WHERE ID_PRODUCTO = 'PRO#000010';

SELECT * FROM FACTURA WHERE DATE(FECHA) = '2015-04-04';

select convert('2010-10-10 22:30:10', datetime);
SELECT WEEK(f.FECHA)		 FROM FACTURA f;
DELETE FROM FACTURA WHERE ID_FACTURA = 'F#00000001';

SELECT COUNT(*) FROM producto;

SELECT c.NOMBRE, c.CATEGORIA_ID_CATEGORIA FROM CATEGORIA c -- LEFT JOIN CATEGORIA b ON b.ID_CATEGORIA = c.CATEGORIA_ID_CATEGORIA
WHERE c.ID_CATEGORIA != c.CATEGORIA_ID_CATEGORIA;

SELECT * FROM PRODUCTO WHERE ID_PRODUCTO = 'pro0000017';

SELECT * FROM CATEGORIA LIMIT 4 OFFSET 6;
SELECT * FROM CATEGORIA LIMIT 4 , 6;

-- ---------------PUEBas para iniciar la construccion de una funcion para autoincrementar un id de producto y logra que sea autoincremental y alfanumerico
SELECT ID_PRODUCTO FROM producto ORDER BY ID_PRODUCTO;

SELECT LEFT(p.ID_PRODUCTO, 3) FROM PRODUCTO p;

SELECT * FROM PRODUCTO LIMIT 0 , 10;
SELECT * FROM PRODUCTO LIMIT 1 , 5;
SELECT * FROM PRODUCTO LIMIT 10 , 10;
SELECT * FROM PRODUCTO LIMIT 12 , 10;
SELECT * FROM PRODUCTO LIMIT 18 , 10;
SELECT * FROM PRODUCTO LIMIT 2 , 12;
SELECT * FROM PRODUCTO LIMIT 0 , 12;

SELECT COUNT(p.ID_PRODUCTO) AS 'NPRO' FROM PRODUCTO p;

SELECT GET_NEW_ID_PRODUCTO();
SELECT GET_NEW_ID_INVENTARIO();
SELECT GET_NEW_ID_FACTURA();

UPDATE USUARIO SET ROL = 'DISABLED' WHERE ID_USUARIO = 'jfgomez9095'; 

SELECT * FROM USUARIO LIMIT 1;
SHOW TABLES LIKE 'USUARIO';

INSERT INTO CUENTA_RESCUE VALUES ('josue.gomez', 'LOST_PASSWORD', '636s476d5', 'fdskjfhsdfkjghsdkjgsdfg', now());

UPDATE CUENTA_RESCUE cr SET cr.ESTADO = '', cr.CODIGO = '', TOKEN = '', LAST_RECOVER = '' WHERE cr.USUARIO_ID_USUARIO = '';

SELECT * FROM PRODUCTO WHERE CATEGORIA_ID_CATEGORIA = 5 AND CATALOGO_ID_CATALOGO = 1 AND LOWER(DESCRIPCION) LIKE '%cha%' AND PRECIO BETWEEN 100  AND 500000; 

SELECT timestamp(FECHA) FROM inventario;

SELECT COUNT(i.ID_INVENTARIO) AS 'NINV' FROM INVENTARIO i;

SELECT MAX(FECHA) FROM inventario;

SELECT * FROM inventario WHERE PRODUCTO_ID_PRODUCTO = 'pro0000001';

SELECT f.ID_FACTURA FROM FACTURA f WHERE f.FECHA = MAX(f.FECHA);

SELECT MAX(ID_FACTURA) AS 'MAX_ID' FROM FACTURA;

SELECT * FROM PRODUCTO WHERE CANTIDAD < 0;

SELECT (ADDDATE(CURDATE(), INTERVAL -1 DAY));

SELECT * FROM PEDIDO_ENTREGA WHERE DATE(FECHA_SOLICITUD) = (ADDDATE(CURDATE(), INTERVAL -1 DAY)) ORDER BY FECHA_SOLICITUD DESC ;




-- Encontrar pedidos quew tengan la fecha de hoy;
SELECT * FROM PEDIDO_ENTREGA WHERE DATE(FECHA_SOLICITUD) = DATE(NOW());
-- Encontrar pedidos solicitados este mes
SELECT * FROM PEDIDO_ENTREGA WHERE MONTH(FECHA_SOLICITUD) = MONTH(NOW());
-- Por semana
SELECT * FROM PEDIDO_ENTREGA WHERE WEEK(FECHA_SOLICITUD) = WEEK(NOW());

SELECT * FROM PEDIDO_ENTREGA WHERE YEAR(FECHA_SOLICITUD) = YEAR(NOW()) ORDER BY FECHA_SOLICITUD DESC ;

-- ----------------------- JOINS -------------------------

