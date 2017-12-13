INSERT INTO RAPID_JACKETS.CATEGORIA (NOMBRE, DESCRIPCION, CATEGORIA_ID_CATEGORIA) VALUES
('Categoria por Defecto','Categoria realizada pra las categorias que son independientes(Por favor, nunca la elimine ni la desactive)',1),
('Uniformes Aprendices SENA','Categoria que abarca todos los uniformes SENA para aprendices',1),
('Uniformes Instructores SENA','Categoria que abarca todos los uniformes SENA para instructores',1),
('Uniformes Intituciones Educativas','Categoria que abarca todos los uniformes de instituciones educativas',1),
('Chaquetas','Categoria que abarca especificamente chaquetas para aprendices SENA',2),
('Overoles','Categoria que abarca especificamente overoles para aprendices SENA',2),
('Sudaderas SENA','Categoria que abarca especificamente sudaderas para aprendices SENA',2),
('Batas','Categoria que abarca especificamente batas para instructores SENA o profesores de Instituciones educativas',3),
('Uniformes Comunes','Categoria que abarca especificamente uniformes para Instituciones Educativas',4);

INSERT INTO RAPID_JACKETS.CATALOGO (NOMBRE, DESCRIPCION) VALUES
('Aprendices SENA','Catalogo para productos dedicados a los aprendices SENA'),
('Instructores SENA','Catalogo para productos dedicados a los instructores SENA'),
('Instituciones Educativas','Catalogo para productos dedicados a los aprendices SENA');

INSERT INTO RAPID_JACKETS.PRODUCTO (ID_PRODUCTO, CATEGORIA_ID_CATEGORIA, CATALOGO_ID_CATALOGO, NOMBRE, PRECIO, CANTIDAD, DESCRIPCION, FOTO) VALUES
('pro0000001',5,1,'Chaqueta Aprendices SENA',40000,10,'Chaqueta Jean para Aprendices SENA/Teleinformatica.','../uploads/productos_img/pro_img_pro0000001.jpg'),
('pro0000002',2,1,'Pantalon Aprendices SENA',50000,20,'Pantalon Jean para Aprendices SENA/Teleinformatica.','../uploads/productos_img/pro_img_pro0000002.jpg'),
('pro0000002',2,1,'Camisa Polo SENA',50000,20,'Camisa estilo polo azul claro para Aprendices SENA/Teleinformatica.','../uploads/productos_img/pro_img_pro0000003.jpg'),
('pro0000004',6,1,'Overol Aprendices SENA/Electronica',40000,15,'Overol Azul oscuro para Aprendices SENA/Electronica.','../uploads/productos_img/pro_img_pro0000004.jpg'),
('pro0000005',6,1,'Overol Aprendices SENA/Electricidad',45000,22,'Overol caqui para Aprendices SENA/Electricidad.','../uploads/productos_img/pro_img_pro0000005.jpg'),
('pro0000006',2,1,'Gafas de Seguridad Aprendices SENA',10000,36,'Gafas de seguridad de seguridad tipo dieléctrica con protección uv para Aprendices SENA/Electricidad.','../uploads/productos_img/pro_img_pro0000006.jpg'),
('pro0000007',2,1,'Protectores de Oido',5000,17,'Protectores de oido hechos en espuma con cordón para Aprendices SENA','../uploads/productos_img/pro_img_pro0000007.jpg'),
('pro0000008',2,1,'Casco de Seguridad',25000,62,'Casco Rojo para Aprendices SENA','../uploads/productos_img/pro_img_pro0000008.jpg'),
('pro0000009',2,1,'Guantes Aislantes',15000,85,'Guantes Aislantes para Aprendices SENA','../uploads/productos_img/pro_img_pro0000009.jpg'),
('pro0000010',8,1,'Bata AntiEstatica',20000,10,'Bata antiestatica para Aprendices SENA/Teleinformática','../uploads/productos_img/pro_img_pro0000010.jpg'),
('pro0000011',2,1,'Botas Dieléctricas',30000,28,'Botas dieléctricas con suela antideslizante, puntera no metálica para Aprendices SENA','../uploads/productos_img/pro_img_pro0000011.jpg'),
('pro0000012',2,1,'Botas Antideslizantes',20000,28,'Botas Antideslizantes para Aprendices SENA/Electricidad','../uploads/productos_img/pro_img_pro0000012.jpg'),
('pro0000013',2,1,'Cofia ',5000,28,'Cofia para Aprendices SENA/Electronica','../uploads/productos_img/pro_img_pro0000013.jpg'),
('pro0000014',2,1,'Camisa Antifluido',20000,28,'Camisa antifluido para Aprendices SENA/Electronica','../uploads/productos_img/prpro_img_pro0000014.jpg'),
('pro0000015',8,1,'Bata Instructores SENA',15000,28,'Bata blanca para Instructores SENA o Profesores de Instituciones Educativas','../uploads/productos_img/pro_img_pro0000016.jpg'),
('pro0000016',7,1,'Sudadera SENA',40000,28,'Sudadera para Aprendices SENA','../uploads/productos_img/pro_img_pro0000017.jpg'),
('pro0000017',9,1,'Pantalon Antifluido',25000,28,'Pantalon hecho con material antifluido para Aprendices SENA','../uploads/productos_img/pro_img_pro0000015.jpg');

INSERT INTO RAPID_JACKETS.INVENTARIO VALUES 
('INV#000001','pro0000001',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000002','pro0000001',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000003','pro0000002',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000004','pro0000002',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000005','pro0000003',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000006','pro0000003',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000007','pro0000004',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000008','pro0000004',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000009','pro0000005',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000010','pro0000005',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000011','pro0000006',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000012','pro0000006',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000013','pro0000007',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000014','pro0000007',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000015','pro0000008',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000016','pro0000008',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000017','pro0000009',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000018','pro0000009',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000019','pro0000010',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000020','pro0000010',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000021','pro0000011',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000022','pro0000011',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000023','pro0000012',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000024','pro0000012',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000025','pro0000013',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000026','pro0000013',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000027','pro0000014',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000028','pro0000014',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000029','pro0000015',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000030','pro0000015',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000031','pro0000016',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000032','pro0000016',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000033','pro0000017',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000'),
('INV#000034','pro0000017',NOW(),10,450000,'EL PROVEEDOR ME ROBO $1000');

INSERT INTO RAPID_JACKETS.USUARIO VALUES
('jfgomez9095','$2y$10$BbPxUPQy9PrYgMf0L9E3W.r9zbWrhUx9SX4HZQtlmNjIf8jX1hgra', 'MANAGER', 'ENABLED', 'aviondejosue12@gmail.com'),
('IsseiXD321','$2y$10$.5KQ/xrTprQaMSVoJ/DCheMYlfUlCZz4UkGpoWyMmW9bw6gt3bdNu', 'MANAGER', 'ENABLED', 'asgarcia20@misena.edu.co'),
('efalaguna123','$2y$10$BbPxUPQy9PrYgMf0L9E3W.r9zbWrhUx9SX4HZQtlmNjIf8jX1hgra', 'MANAGER', 'ENABLED', 'efalaguna@misena.edu.co');

INSERT INTO RAPID_JACKETS.CUENTA VALUES
('CC','1026300983','jfgomez9095','Josue','Francisco','Gomez','Bernal','3203091723'),
('CC','1031178392','Issei_XD12345','Issei','Yuuto','Hyoudou','Kiba','3204483107'),
('CC','6546516574','efalaguna123','Elkin','Fernando','Alaguna','Gutierrez','3204483107');
