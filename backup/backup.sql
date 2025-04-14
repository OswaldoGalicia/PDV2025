DROP TABLE caja;

CREATE TABLE `caja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `inicio` decimal(10,2) NOT NULL,
  `ventas` decimal(10,2) NOT NULL,
  `abonos` decimal(10,2) NOT NULL,
  `egresos` decimal(10,2) NOT NULL,
  `creditos` decimal(10,2) NOT NULL,
  `total_efectivo` decimal(10,2) NOT NULL,
  `usuario` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

INSERT INTO caja VALUES("6","2021-11-25 20:47:04","500.00","0.00","0.00","0.00","0.00","0.00","1","1");



DROP TABLE cliente;

CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL AUTO_INCREMENT,
  `nit` varchar(20) DEFAULT NULL,
  `nombre` varchar(80) DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idcliente`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;

INSERT INTO cliente VALUES("1","","Cliente natural","0","","2021-12-05 15:47:39","1","1");
INSERT INTO cliente VALUES("66","9060609","zddsdfsd","99999999","rama","2021-12-05 16:00:57","1","1");
INSERT INTO cliente VALUES("67","6030609900003x","wilmer","99999999","rama","2021-12-05 16:02:18","1","1");



DROP TABLE compras;

CREATE TABLE `compras` (
  `nocompra` bigint(11) NOT NULL AUTO_INCREMENT,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuario` int(20) NOT NULL,
  `caja` int(11) NOT NULL,
  `codproveedor` int(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `totalcompra` decimal(10,2) NOT NULL,
  `abono` decimal(10,2) NOT NULL,
  PRIMARY KEY (`nocompra`),
  KEY `usuario` (`usuario`),
  KEY `codproveedor` (`codproveedor`),
  KEY `caja` (`caja`),
  CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`codproveedor`) REFERENCES `proveedor` (`codproveedor`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `compras_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `compras_ibfk_3` FOREIGN KEY (`caja`) REFERENCES `caja` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4;

INSERT INTO compras VALUES("34","2021-12-03 20:53:35","1","6","1","2","200.00","0.00");
INSERT INTO compras VALUES("36","2021-12-03 20:53:31","1","6","1","2","80.00","0.00");
INSERT INTO compras VALUES("37","2021-12-03 20:55:09","1","6","1","1","25.00","0.00");
INSERT INTO compras VALUES("38","2021-12-03 20:55:32","1","6","1","1","25.00","0.00");
INSERT INTO compras VALUES("39","2021-12-03 20:56:28","1","6","1","2","25.00","0.00");
INSERT INTO compras VALUES("40","2021-12-03 20:58:30","1","6","1","1","25.00","0.00");



DROP TABLE configuracion;

CREATE TABLE `configuracion` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nit` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `razon_social` varchar(100) NOT NULL,
  `telefono` bigint(20) NOT NULL,
  `email` varchar(200) NOT NULL,
  `direccion` text NOT NULL,
  `iva` decimal(10,2) NOT NULL,
  `foto` varchar(200) NOT NULL,
  `moneda` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

INSERT INTO configuracion VALUES("1","60306999855b","El Cumpa","Venta productos abarrotes","70003249","elcumpa@gmail.com","Centro comercial ","0.00","logo_1ecbba73a7d407977168efe6aa146e4c.jpg","C$");



DROP TABLE detalle_recibo;

CREATE TABLE `detalle_recibo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `noventa` bigint(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `saldo_anterior` decimal(10,2) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `saldo_actual` decimal(10,2) NOT NULL,
  `usuario` int(11) NOT NULL,
  `caja` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `noventa` (`noventa`),
  KEY `usuario` (`usuario`),
  KEY `caja` (`caja`),
  CONSTRAINT `detalle_recibo_ibfk_1` FOREIGN KEY (`noventa`) REFERENCES `venta` (`noventa`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detalle_recibo_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detalle_recibo_ibfk_3` FOREIGN KEY (`caja`) REFERENCES `caja` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4;

INSERT INTO detalle_recibo VALUES("50","199","2021-12-05 16:12:20","90.00","40.50","49.50","1","6");
INSERT INTO detalle_recibo VALUES("52","202","2021-12-05 16:37:03","99.00","9.50","89.50","1","6");
INSERT INTO detalle_recibo VALUES("54","204","2021-12-05 16:43:32","89.00","9.50","79.50","1","6");
INSERT INTO detalle_recibo VALUES("56","210","2021-12-05 16:46:49","94.50","44.50","50.00","1","6");
INSERT INTO detalle_recibo VALUES("58","212","2021-12-05 16:47:27","30.00","10.00","20.00","1","6");



DROP TABLE detalle_recibo_compra;

CREATE TABLE `detalle_recibo_compra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nocompra` bigint(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `saldo_anterior` decimal(10,2) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `saldo_actual` decimal(10,2) NOT NULL,
  `usuario` int(11) NOT NULL,
  `caja` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nocompra` (`nocompra`),
  KEY `usuario` (`usuario`),
  KEY `caja` (`caja`),
  CONSTRAINT `detalle_recibo_compra_ibfk_1` FOREIGN KEY (`nocompra`) REFERENCES `compras` (`nocompra`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detalle_recibo_compra_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detalle_recibo_compra_ibfk_3` FOREIGN KEY (`caja`) REFERENCES `caja` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;




DROP TABLE detalle_temp;

CREATE TABLE `detalle_temp` (
  `correlativo` int(11) NOT NULL AUTO_INCREMENT,
  `token_user` varchar(50) NOT NULL,
  `codproducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  PRIMARY KEY (`correlativo`),
  KEY `codproducto` (`codproducto`),
  KEY `token_user` (`token_user`),
  CONSTRAINT `detalle_temp_ibfk_1` FOREIGN KEY (`codproducto`) REFERENCES `producto` (`codproducto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=623 DEFAULT CHARSET=latin1;




DROP TABLE detalle_temp_compra;

CREATE TABLE `detalle_temp_compra` (
  `correlativo` int(11) NOT NULL AUTO_INCREMENT,
  `token_user` varchar(50) CHARACTER SET latin1 NOT NULL,
  `codproducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  PRIMARY KEY (`correlativo`),
  KEY `token_user` (`token_user`),
  KEY `codproducto` (`codproducto`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;




DROP TABLE detalleventa;

CREATE TABLE `detalleventa` (
  `correlativo` bigint(11) NOT NULL AUTO_INCREMENT,
  `noventa` bigint(11) DEFAULT NULL,
  `codproducto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_venta` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`correlativo`),
  KEY `codproducto` (`codproducto`),
  KEY `noventa` (`noventa`),
  CONSTRAINT `detalleventa_ibfk_1` FOREIGN KEY (`noventa`) REFERENCES `venta` (`noventa`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detalleventa_ibfk_2` FOREIGN KEY (`codproducto`) REFERENCES `producto` (`codproducto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=224 DEFAULT CHARSET=latin1;




DROP TABLE egresos;

CREATE TABLE `egresos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `descripcion` text NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `usuario` int(11) NOT NULL,
  `caja` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `caja` (`caja`),
  CONSTRAINT `egresos_ibfk_1` FOREIGN KEY (`caja`) REFERENCES `caja` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4;

INSERT INTO egresos VALUES("26","2021-12-05 16:03:10","pago de luz","150.00","1","6");
INSERT INTO egresos VALUES("27","2021-12-11 14:47:06","cable","200.00","1","6");
INSERT INTO egresos VALUES("28","2021-12-11 14:47:16","gaseosa","20.00","1","6");
INSERT INTO egresos VALUES("29","2021-12-11 14:48:36","pago de internet","150.50","1","6");



DROP TABLE entradas;

CREATE TABLE `entradas` (
  `correlativo` bigint(11) NOT NULL AUTO_INCREMENT,
  `nocompra` bigint(11) DEFAULT NULL,
  `codproducto` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`correlativo`),
  KEY `codproducto` (`codproducto`),
  KEY `usuario_id` (`usuario_id`),
  KEY `nocompra` (`nocompra`),
  CONSTRAINT `entradas_ibfk_2` FOREIGN KEY (`codproducto`) REFERENCES `producto` (`codproducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `entradas_ibfk_3` FOREIGN KEY (`nocompra`) REFERENCES `compras` (`nocompra`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=latin1;




DROP TABLE producto;

CREATE TABLE `producto` (
  `codproducto` int(20) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(20) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `proveedor` int(11) DEFAULT NULL,
  `costo` decimal(10,2) NOT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `existencia` int(11) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT 1,
  `usuario_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`codproducto`),
  KEY `proveedor` (`proveedor`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`proveedor`) REFERENCES `proveedor` (`codproveedor`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1013 DEFAULT CHARSET=latin1;




DROP TABLE proveedor;

CREATE TABLE `proveedor` (
  `codproveedor` int(11) NOT NULL AUTO_INCREMENT,
  `proveedor` varchar(100) DEFAULT NULL,
  `contacto` varchar(100) DEFAULT NULL,
  `telefono` bigint(11) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT 1,
  `usuario_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`codproveedor`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `proveedor_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

INSERT INTO proveedor VALUES("1","Mercado","Mercado","99999999","Managua","2021-09-21 15:52:42","1","1");



DROP TABLE rol;

CREATE TABLE `rol` (
  `idrol` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idrol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO rol VALUES("1","Administrador");
INSERT INTO rol VALUES("2","Supervisor");
INSERT INTO rol VALUES("3","Vendedor");



DROP TABLE usuario;

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `usuario` varchar(15) DEFAULT NULL,
  `clave` varchar(100) DEFAULT NULL,
  `rol` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  PRIMARY KEY (`idusuario`),
  KEY `rol` (`rol`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `rol` (`idrol`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

INSERT INTO usuario VALUES("1","admin","admin@gmail.com","admin","81dc9bdb52d04dc20036dbd8313ed055","1","1");
INSERT INTO usuario VALUES("2","Vendedor","vend@gmail.com","vendedor","81dc9bdb52d04dc20036dbd8313ed055","3","1");



DROP TABLE venta;

CREATE TABLE `venta` (
  `noventa` bigint(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario` int(11) DEFAULT NULL,
  `caja` int(11) NOT NULL,
  `codcliente` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `totalventa` decimal(10,2) DEFAULT NULL,
  `abono` decimal(10,2) NOT NULL,
  PRIMARY KEY (`noventa`),
  KEY `usuario` (`usuario`),
  KEY `codcliente` (`codcliente`),
  KEY `caja` (`caja`),
  CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `venta_ibfk_2` FOREIGN KEY (`codcliente`) REFERENCES `cliente` (`idcliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `venta_ibfk_3` FOREIGN KEY (`caja`) REFERENCES `caja` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=215 DEFAULT CHARSET=latin1;

INSERT INTO venta VALUES("196","2021-12-05 16:07:01","1","6","1","1","50.00","0.00");
INSERT INTO venta VALUES("197","2021-12-05 16:09:25","1","6","1","1","30.00","0.00");
INSERT INTO venta VALUES("198","2021-12-05 16:11:23","1","6","67","3","90.00","0.00");
INSERT INTO venta VALUES("199","2021-12-05 16:12:20","1","6","67","3","","41.00");
INSERT INTO venta VALUES("201","2021-12-05 16:36:41","1","6","67","3","50.00","0.00");
INSERT INTO venta VALUES("202","2021-12-05 16:37:03","1","6","67","3","","10.00");
INSERT INTO venta VALUES("204","2021-12-05 16:43:32","1","6","67","3","","9.50");
INSERT INTO venta VALUES("206","2021-12-05 16:44:40","1","6","1","3","15.00","0.00");
INSERT INTO venta VALUES("207","2021-12-05 16:45:21","1","6","1","3","15.00","0.00");
INSERT INTO venta VALUES("209","2021-12-05 16:46:28","1","6","67","3","15.00","0.00");
INSERT INTO venta VALUES("210","2021-12-05 16:46:49","1","6","67","3","","44.50");
INSERT INTO venta VALUES("212","2021-12-05 16:47:27","1","6","1","3","","10.00");
INSERT INTO venta VALUES("213","2021-12-05 16:57:42","1","6","1","1","50.00","0.00");
INSERT INTO venta VALUES("214","2021-12-05 21:11:15","1","6","1","1","1200.00","0.00");



