DROP DATABASE IF EXISTS RAPID_JACKETS;

CREATE DATABASE IF NOT EXISTS RAPID_JACKETS;

ALTER SCHEMA RAPID_JACKETS DEFAULT CHARACTER SET utf8;
ALTER SCHEMA RAPID_JACKETS  DEFAULT COLLATE utf8_bin;

USE RAPID_JACKETS;

CREATE TABLE RAPID_JACKETS.CATEGORIA (
  ID_CATEGORIA INT NOT NULL AUTO_INCREMENT COMMENT 'Este campo es la llave primaria de la tabla categoría. Es entero para hacer búsquedas más rapidas',
  NOMBRE VARCHAR(150) NOT NULL COMMENT 'Este campo es para almacenar el nombre de la categoria. Es obligatorio',
  ACTIVA BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Este campo es para hacer una activacion o desactivación de una categoría, por medio de este se verifica si los productos dentro de esta categoria deben mostrarse o no.',
  DESCRIPCION TEXT NULL COMMENT 'Este campo es para añadir una descripción adicional de la categoría ',
  CATEGORIA_ID_CATEGORIA INT NOT NULL COMMENT 'Este campo es la llave foránea hacia esta misma tabla para la relación reflexiva. Se usará para hacer categorías que a su vez pertenescan a otras categorías',
  PRIMARY KEY (ID_CATEGORIA), 
  FOREIGN KEY (CATEGORIA_ID_CATEGORIA)
  REFERENCES RAPID_JACKETS.CATEGORIA (ID_CATEGORIA)
  ON DELETE CASCADE 
  ON UPDATE CASCADE
) COMMENT 'Es esta tabla es para almacenar las categorias a las que están ligados los productos';

CREATE TABLE RAPID_JACKETS.CATALOGO (
  ID_CATALOGO INT NOT NULL AUTO_INCREMENT COMMENT 'Esta es la llave primaria de esta tabla, será autoincremental debido a que no se estima una gran cantidade de registros para esta tabla',
  NOMBRE VARCHAR(100) NOT NULL COMMENT 'Este es el nombre del catalogo. No se admitiran nombres de más de 100 caracteres',
  DESCRIPCION VARCHAR(200) NULL COMMENT 'Este es el campo para la descripcion de cada catalogo. Será un texto corto pues no se estima que el usuario digite un texto tan complejo pára describir un catalogo',
  ACTIVO BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Este es el campo que servirá para verificar si un catalogo debe estar disponible a la vista para el cliente, en funcion de si está activo o no',
  FOTO VARCHAR(250) DEFAULT 'SIN_ASIGNAR' NULL COMMENT 'La foto será opcional, si no está asignada tomará el valor de SIN_ASIGNAR. Este campo almacenará la direccion relativa de la ubicacion del archivo despues de ser subido a la carpeta de subidas del serrvidor',
  PRIMARY KEY (ID_CATALOGO) 
)COMMENT 'Esta tabla almaccena los catalogos a los que se ligan algunos productos. Un catalogo hace referencia a una clasificacion temporal que tendran algunos productos. Ejemplo de esto son productos en descuento o en liquidacion';

CREATE TABLE RAPID_JACKETS.PRODUCTO (
  ID_PRODUCTO VARCHAR(50) NOT NULL COMMENT 'Esta es la llave primaria de cada producto. Se determina que esta será alfanumerica',
  CATEGORIA_ID_CATEGORIA INT NOT NULL COMMENT 'Esta es una llave foranea del producto. Un producto puede petenecer a una categoria para agilizar las búsquedas',
  CATALOGO_ID_CATALOGO INT NOT NULL COMMENT 'Esta es una llave foranea del producto. Un producto puede petenecer a un catalogo para agilizar las búsquedas',
  NOMBRE VARCHAR(250) NOT NULL COMMENT 'Este campo es para el nombre del producto. Es obligatorio pues una de las funcionalidades del sistema será la busqueda de productos según el nombre.',
  PRECIO DOUBLE NOT NULL COMMENT 'Campo numerico real para almacenar el precio unitario de un producto',
  ACTIVO BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Este campo booleano es para deteminar si un producto ha sido activado o desactivado. Si está activado estará disponible en el catalogo al que se encuentre realacionado',
  CANTIDAD INT NOT NULL COMMENT 'Campo entero para almacena la cantidad de productos disponibles para la venta. Este campo será actulizado tras actualizarse correctamente la tabla de inventarios del producto',
  DESCRIPCION TEXT NULL COMMENT 'Este campo se reservará para la descripcion de un producto. Admitirá textos largos debido a que va a contener formato con css y html',
  FOTO VARCHAR(250) NOT NULL DEFAULT 'SIN_ASIGNAR' COMMENT 'La foto será opcional, si no está asignada tomará el valor de SIN_ASIGNAR. Este campo almacenará la direccion relativa de la ubicacion del archivo despues de ser subido a la carpeta de subidas del serrvidor',
  PRIMARY KEY (ID_PRODUCTO),
  FOREIGN KEY (CATEGORIA_ID_CATEGORIA)
  REFERENCES RAPID_JACKETS.CATEGORIA (ID_CATEGORIA),
  FOREIGN KEY (CATALOGO_ID_CATALOGO)
  REFERENCES RAPID_JACKETS.CATALOGO (ID_CATALOGO)
)COMMENT 'Esta tabla es esencial para guardar los productos del sistema';

CREATE TABLE RAPID_JACKETS.USUARIO (
  ID_USUARIO VARCHAR(255) NOT NULL COMMENT 'Esta es la llave promaria de la tabla usuario. Corresponde al nombre digitado por el usuario que se reguistre como cliente en el sistema. Se optará por mantener este campo encriptado por seguridad',
  CONTRASENA VARCHAR(255) NOT NULL COMMENT 'Esta campo es para la contraseña del usuario. ',
  ROL VARCHAR(50) NOT NULL DEFAULT 'USER' COMMENT 'Este espacio es para que el usuario diga su rol.',
  ESTADO TEXT NULL COMMENT 'Este campo es para que el usuario tenga conocimiento de su estado bien sea activo o inactivo.',
  EMAIL VARCHAR(255) UNIQUE NOT NULL COMMENT 'Este campo es para el correo electronico del usuario,donde se le enviara la informacion de la empresa.',
  PRIMARY KEY (ID_USUARIO)
)COMMENT 'Esta tabla almacena todos los usuarios del sistema, tanto clientes como administradores';

CREATE TABLE RAPID_JACKETS.CUENTA_RESCUE (
	USUARIO_ID_USUARIO VARCHAR(255) NOT NULL,
    ESTADO VARCHAR(150) NOT NULL DEFAULT 'LOST_PASSWORD',
    CODIGO VARCHAR(10) NOT NULL,
    TOKEN TEXT NOT NULL,
    LAST_RECOVER DATETIME NOT NULL DEFAULT NOW(),
    PRIMARY KEY (USUARIO_ID_USUARIO),
    FOREIGN KEY (USUARIO_ID_USUARIO) REFERENCES RAPID_JACKETS.USUARIO (ID_USUARIO),
    CONSTRAINT CHK_ESTADO CHECK(ESTADO IN('LOST_PASSWORD', 'RESCUED_PASSWORD', 'ACCOUNT_TIME_OUT'))
)COMMENT '';

CREATE TABLE RAPID_JACKETS.CUENTA (
  TIPO_DOCUMENTO VARCHAR(10) NOT NULL COMMENT 'Este campo es para el tipo de documento que tiene el usuario.Este dato es no nulo',
  NUM_DOCUMENTO VARCHAR(60) NOT NULL COMMENT 'Este campo es donde el usuario ingresara el numero de su documento.',
  USUARIO_ID_USUARIO VARCHAR(255) NOT NULL COMMENT 'Este campo es donde el usuario ingresara un nombre con el cual sera identificado.',
  PRIMER_NOMBRE VARCHAR(100) NOT NULL COMMENT 'Este campo es para que el usuario ingrese su primer nombre correctamente.',
  SEGUNDO_NOMBRE VARCHAR(100) NULL COMMENT 'Este campo es para que el usuario ingrese su segundo nombre correctamente.',
  PRIMER_APELLIDO VARCHAR(100) NOT NULL COMMENT 'Este campo es para que el usuario ingrese su primer apellido correctamente.',
  SEGUNDO_APELLIDO VARCHAR(100) NULL COMMENT 'Este campo es para que el usuario ingrese su sewgundo apellido correctamente',
  TELEFONO VARCHAR(50) NOT NULL COMMENT 'Este campo es para que el usuario ingrese un numero telefonico con el cual se pueda contactar.',
  PRIMARY KEY (TIPO_DOCUMENTO, NUM_DOCUMENTO),
  FOREIGN KEY (USUARIO_ID_USUARIO)
  REFERENCES RAPID_JACKETS.USUARIO (ID_USUARIO)
)COMMENT 'Esta tabla esta designada a guarda ls datos de informacion personal de un usuario. Ha de existir un registro por usuario';

CREATE TABLE RAPID_JACKETS.DOMICILIO_CUENTA (
  CUENTA_TIPO_DOCUMENTO VARCHAR(10) NOT NULL COMMENT '',
  CUENTA_NUM_DOCUMENTO VARCHAR(60) NOT NULL COMMENT '',
  DIRECCION TEXT NOT NULL COMMENT 'En este campo se el usuario ingresara la direccion a la cual sera llevado el domicilio.',
  TELEFONO VARCHAR(50) NULL COMMENT 'En este campo el usuario ingresara el telefono de contacto de la recidencia a donde sera llevado el domicilio.',
  BARRIO TEXT NULL COMMENT 'En este campo se ingresara el lugar o bario a donde se llevara el domicilio.',
  LOCALIDAD TEXT NULL COMMENT 'En este campo se ingresara la localidad a la cual pertenece el barrio a el cual se llevara el domicilio.',
  CORREO_POSTAL TEXT NULL COMMENT 'En este campo se ingresara un correo a el cual se enviara la confirmacion de su domicilio con su dia de entrega.',
  PRIMARY KEY (CUENTA_TIPO_DOCUMENTO, CUENTA_NUM_DOCUMENTO),
  FOREIGN KEY (CUENTA_TIPO_DOCUMENTO , CUENTA_NUM_DOCUMENTO)
  REFERENCES RAPID_JACKETS.CUENTA (TIPO_DOCUMENTO , NUM_DOCUMENTO)
)COMMENT 'Esta tabla es para almacenar informacion sobre el domicilio de un cliente. Ha de existir solo un domicilio por cada cuenta de usuario';

CREATE TABLE RAPID_JACKETS.INVENTARIO (
  ID_INVENTARIO VARCHAR(20) NOT NULL COMMENT 'Esta es la llave primaria de la tabla  Inventario.',
  PRODUCTO_ID_PRODUCTO VARCHAR(50) NOT NULL COMMENT '',
  FECHA DATETIME NOT NULL COMMENT 'En este campo se ingresara la fecha en la cual fue creado el inventario.',
  CANTIDAD INT NOT NULL COMMENT 'En este campo se digitara la cantidad de productos que contiene el inventario.',
  PRECIO_MAYOR DOUBLE NOT NULL COMMENT 'En este campo se ingresara el p`recio total de los productos que tiene el invetario.',
  OBSERVACIONES TEXT NULL COMMENT 'Este campo guardara las observaciones que tengan cada uno de los productos que tiene el producto.',
  PRIMARY KEY (ID_INVENTARIO, PRODUCTO_ID_PRODUCTO),
  FOREIGN KEY (PRODUCTO_ID_PRODUCTO)
  REFERENCES RAPID_JACKETS.PRODUCTO (ID_PRODUCTO)
) COMMENT 'Esta tabla es para generar un historico de las actulizaciones que se le hacen al campo de cantidad de la tabla producto. De esta forma el adminstrado puede aumentar o disminuir  la catidad de elementos disponibles de un producto';

CREATE TABLE RAPID_JACKETS.FACTURA (
  ID_FACTURA VARCHAR(30) NOT NULL COMMENT 'Esta es la llave primaria de la tabla Factura.',
  CUENTA_TIPO_DOCUMENTO VARCHAR(10) NOT NULL COMMENT 'En este campo se guardara el tipo de documento que el usuario ingreso en la cuenta.',
  CUENTA_NUM_DOCUMENTO VARCHAR(60) NOT NULL COMMENT 'En este campo se guardara el numero de documento que el usuario ingreso en la cuenta.',
  FECHA DATETIME NOT NULL COMMENT 'En este campo le dara a conocer a el usuario la fecha en la cual el usuario adquirio la factura.',
  ESTADO VARCHAR(45) NOT NULL DEFAULT 'SIN_PAGAR' COMMENT 'En este campo se le dira en el cual se entrega la factura si es PAGO o NO',
  OBSERVACIONES TEXT NULL COMMENT 'En este campo se guardaran las observaciones que tenga la factura.',
  SUBTOTAL DOUBLE NOT NULL COMMENT 'En este campo se le dara a conocer a el usuario lo que va ha pagar por su compra.',
  IMPUESTOS DOUBLE NULL COMMENT 'En este campo se le dara a conocer a el usuario el impuesto que tiene la compra.',
  TOTAL DOUBLE NOT NULL COMMENT 'En este campo se le dara a conocer a el usuario el costo total lo que debera pagar por su compra.',
  PRIMARY KEY (ID_FACTURA),
  FOREIGN KEY (CUENTA_TIPO_DOCUMENTO , CUENTA_NUM_DOCUMENTO)
  REFERENCES RAPID_JACKETS.CUENTA (TIPO_DOCUMENTO , NUM_DOCUMENTO)
) COMMENT 'Esta tabla es para guardar informacion acerca de una factura. Solo el cliente puede hacer una compra y hacer que el sistema le genere una factura';

CREATE TABLE RAPID_JACKETS.ITEM_FACTURA (
  PRODUCTO_ID_PRODUCTO VARCHAR(50) NOT NULL COMMENT 'Esta es la llave primaria de la tabla.',
  FACTURA_ID_FACTURA VARCHAR(30) NOT NULL COMMENT 'Esta es la llave foranea de la tabla.',
  CANTIDAD INT NOT NULL COMMENT 'En este campo se le da a conocer a el administrador la cantidad de productos que adquirio el usuario. ',
  COSTO_UNITARIO DOUBLE NOT NULL COMMENT 'En este campo se le dara a conocer a el administrador el costo que tiene cada uno de los productos que adquirio el usuario.',
  COSTO_TOTAL DOUBLE NOT NULL COMMENT 'Este campo se le dara a conocer a el administrador el costo total de la compra que realizo el usuario.',
  PRIMARY KEY (PRODUCTO_ID_PRODUCTO, FACTURA_ID_FACTURA),
  FOREIGN KEY (PRODUCTO_ID_PRODUCTO)
  REFERENCES RAPID_JACKETS.PRODUCTO (ID_PRODUCTO),
  FOREIGN KEY (FACTURA_ID_FACTURA)
  REFERENCES RAPID_JACKETS.FACTURA (ID_FACTURA)
)COMMENT 'Esta tabla guardará los subcomponentes de una factura';


CREATE TABLE RAPID_JACKETS.PEDIDO_ENTREGA(
  FACTURA_ID_FACTURA VARCHAR(30) NOT NULL COMMENT 'Esta es a llave foranea de la tabla Pedido_Entrega.',
  CUENTA_TIPO_DOCUMENTO VARCHAR(10) NOT NULL COMMENT 'En este campo se dara a conocer el tipo de documento que el usuario ingreso en la cuenta.',
  CUENTA_NUM_DOCUMENTO VARCHAR(60) NOT NULL COMMENT 'En este campo se dara a conocer el numero del documento que el usuario ingreso en la cuenta.',
  DOMICILIO TEXT NOT NULL COMMENT 'En este campo se guardaran los datos de entrga del pedido.',
  FECHA_SOLICITUD DATETIME NOT NULL COMMENT 'En este campo se ingresara la fecha en la cual el usuario hizo la solicitud de el pedido.',
  FECHA_ENTREGA DATETIME NULL COMMENT 'En este campo se ingresara la fecha en la cual sera entregado el pedido',
  ESTADO VARCHAR(50) NOT NULL DEFAULT 'PEDIDO SOLICITADO' COMMENT 'En este campo se dara a conocer el estado en el cual esta el pedido.si el pedido es SOLICITADO o NO.',
  OBSERVACIONES TEXT NULL COMMENT 'En este campo se daran a conocer las observaciones que tiene estre pedido.',
  SUBTOTAL DOUBLE NOT NULL COMMENT 'En este campo se observara el costo que tienen los productos que se solicitaron en el pedido.',
  IMPUESTOS DOUBLE NULL COMMENT 'En este campo se dara a conocer el impuesto que tiene por la compra de los productos del pedido. ',
  TOTAL DOUBLE NOT NULL COMMENT 'En este campo se observara el costo total que tiene el perdido.',
  PRIMARY KEY (FACTURA_ID_FACTURA),
  FOREIGN KEY (FACTURA_ID_FACTURA)
  REFERENCES RAPID_JACKETS.FACTURA (ID_FACTURA),
  FOREIGN KEY (CUENTA_TIPO_DOCUMENTO , CUENTA_NUM_DOCUMENTO)
  REFERENCES RAPID_JACKETS.CUENTA (TIPO_DOCUMENTO , NUM_DOCUMENTO)
)COMMENT 'Esta tabla guardara informacion acerca de a quien, cuando y donde se hara entrega de los productos comprados por el cliente en el sistema';



CREATE TABLE RAPID_JACKETS.PAGO (
  FACTURA_ID_FACTURA VARCHAR(30) NOT NULL COMMENT 'Llave foranea primaria que procede de la la tabla FACTURA. Identifica a la factura a la que pertenece este pago.',
  TIPO_PAGO VARCHAR(50) NOT NULL COMMENT 'En este campos el administrador tendra conocimiento sobre el medio de pago que utilizara el cliente.',
  VALOR DOUBLE NOT NULL COMMENT 'En este campo el administrador tendra conocimiento sobre la cantidad que pagara el  usuario. ',
  NUMERO_CUENTA VARCHAR(100) NULL COMMENT 'En este campo el ausuario visualizara su numero de cuenta.',
  NUMERO_TARJETA VARCHAR(100) NULL COMMENT 'En este campo el usuario visualizara el numero de la targeta con la cual hara el pago de los productos.',
  PRIMARY KEY (FACTURA_ID_FACTURA),
  FOREIGN KEY (FACTURA_ID_FACTURA)
  REFERENCES RAPID_JACKETS.FACTURA (ID_FACTURA)
) COMMENT 'Esta tabla es para guardar informacion acerca del tipo de pago que efectua el cliente para un determinado pedido.';

-- --------------------PROCEDIMIENTOS Y FUNCIONES-----------------------------
-- AUTO incrmentar el id de un producto. Permitirá inicicialmente hasta 9.999.999 de productos
DROP FUNCTION IF EXISTS RAPID_JACKETS.GET_NEW_ID_PRODUCTO;
DELIMITER $$
CREATE FUNCTION RAPID_JACKETS.GET_NEW_ID_PRODUCTO()
RETURNS VARCHAR(50)
BEGIN
	DECLARE PREV_ID VARCHAR(50);
    DECLARE NEW_ID VARCHAR(50);
    DECLARE N_PRO BIGINT UNSIGNED;
    SELECT COUNT(*) INTO @N_PRO FROM RAPID_JACKETS.PRODUCTO;
    SELECT MAX(ID_PRODUCTO) INTO @PREV_ID FROM RAPID_JACKETS.PRODUCTO;
    SET @ID_SIZE = LENGTH(@PREV_ID);
    SET @ZEROS = 7-LENGTH(@N_PRO+1);
    SET @NEW_ID = 'pro';
    SET @NEW_ID = CONCAT(@NEW_ID, REPEAT(0, @ZEROS));
    SET @NEW_ID = CONCAT(@NEW_ID, (@N_PRO+1));
RETURN @NEW_ID;
END
$$

DROP FUNCTION IF EXISTS RAPID_JACKETS.GET_NEW_ID_INVENTARIO;
DELIMITER //
CREATE FUNCTION RAPID_JACKETS.GET_NEW_ID_INVENTARIO()
RETURNS VARCHAR(50)
BEGIN
	DECLARE PREV_ID VARCHAR(20);
    DECLARE NEW_ID VARCHAR(20);
    DECLARE N_PRO BIGINT UNSIGNED;
    SELECT COUNT(*) INTO @N_PRO FROM RAPID_JACKETS.INVENTARIO;
    SELECT MAX(ID_INVENTARIO) INTO @PREV_ID FROM RAPID_JACKETS.INVENTARIO;
    SET @ID_SIZE = LENGTH(@PREV_ID);
    SET @ZEROS = 17-LENGTH(@N_PRO+1);
    SET @NEW_ID = 'inv';
    SET @NEW_ID = CONCAT(@NEW_ID, REPEAT(0, @ZEROS));
    SET @NEW_ID = CONCAT(@NEW_ID, (@N_PRO+1));
RETURN @NEW_ID;
END
//


DROP FUNCTION IF EXISTS RAPID_JACKETS.GET_NEW_ID_FACTURA;
DELIMITER %%
CREATE FUNCTION RAPID_JACKETS.GET_NEW_ID_FACTURA()
RETURNS VARCHAR(30)
BEGIN
	DECLARE PREV_ID VARCHAR(30);
    DECLARE NEW_ID VARCHAR(30);
    DECLARE N_FAC BIGINT UNSIGNED;
    SELECT COUNT(*) INTO @N_FAC FROM RAPID_JACKETS.FACTURA;
    SELECT MAX(ID_FACTURA) INTO @PREV_ID FROM RAPID_JACKETS.FACTURA;
    SET @ID_SIZE = LENGTH(@PREV_ID);
    SET @ZEROS = 18-LENGTH(@N_FAC+1);
    SET @NEW_ID = 'F#';
    SET @NEW_ID = CONCAT(@NEW_ID, REPEAT(0, @ZEROS));
    SET @NEW_ID = CONCAT(@NEW_ID, (@N_FAC+1));
RETURN @NEW_ID;
END
%%


