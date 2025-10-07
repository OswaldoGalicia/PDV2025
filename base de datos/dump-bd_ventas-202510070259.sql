/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.8.2-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: bd_ventas
-- ------------------------------------------------------
-- Server version	11.8.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `caja`
--

DROP TABLE IF EXISTS `caja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `caja` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `inicio` decimal(10,2) DEFAULT NULL,
  `ventas` decimal(10,2) DEFAULT NULL,
  `abonos` decimal(10,2) DEFAULT NULL,
  `egresos` decimal(10,2) DEFAULT NULL,
  `creditos` decimal(10,2) DEFAULT NULL,
  `total_efectivo` decimal(10,2) DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `usuario` (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `caja`
--

LOCK TABLES `caja` WRITE;
/*!40000 ALTER TABLE `caja` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `caja` VALUES
(161,'2025-04-14 19:11:41',500.00,NULL,NULL,NULL,NULL,NULL,1,1);
/*!40000 ALTER TABLE `caja` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `categorias` VALUES
(1,'No asignado'),
(2,'Aceites'),
(8,'Lacteos'),
(10,'fghjk');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL,
  `nit` varchar(20) DEFAULT NULL,
  `nombre` varchar(80) DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idcliente`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `cliente` VALUES
(1,'6031807920003k','Cliente regular',88888888,'EL RAMA','2021-12-05 15:47:39',1,1);
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `compras`
--

DROP TABLE IF EXISTS `compras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `compras` (
  `nocompra` bigint(11) NOT NULL AUTO_INCREMENT,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuario` int(20) DEFAULT NULL,
  `caja` int(11) NOT NULL,
  `codproveedor` int(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `totalcompra` decimal(10,2) DEFAULT NULL,
  `abono` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`nocompra`),
  KEY `usuario` (`usuario`),
  KEY `codproveedor` (`codproveedor`),
  KEY `caja` (`caja`)
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compras`
--

LOCK TABLES `compras` WRITE;
/*!40000 ALTER TABLE `compras` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `compras` VALUES
(1,'2025-07-26 05:10:23',1,161,1,1,0.00,0.00),
(152,'2025-04-21 07:35:59',1,161,1,1,250.00,0.00),
(153,'2025-07-26 08:24:08',1,161,1,1,NULL,NULL),
(154,'2025-07-26 08:25:16',1,161,1,1,NULL,NULL),
(155,'2025-07-26 08:26:37',1,161,1,1,247.50,NULL),
(156,'2025-07-26 08:27:22',1,161,1,1,2475.00,NULL),
(157,'2025-07-26 08:28:27',1,161,1,3,207.00,NULL);
/*!40000 ALTER TABLE `compras` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `configuracion`
--

DROP TABLE IF EXISTS `configuracion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `configuracion` (
  `id` bigint(20) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuracion`
--

LOCK TABLES `configuracion` WRITE;
/*!40000 ALTER TABLE `configuracion` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `configuracion` VALUES
(1,'6232912905005C','Lubricentro','Aceites y lubricantes',85289255,'lubricentro@gmail.com','Ciudad Rama',0.00,' ','$');
/*!40000 ALTER TABLE `configuracion` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `detalle_recibo`
--

DROP TABLE IF EXISTS `detalle_recibo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_recibo` (
  `id` int(11) NOT NULL,
  `noventa` bigint(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `saldo_anterior` decimal(10,2) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `saldo_actual` decimal(10,2) NOT NULL,
  `usuario` int(11) NOT NULL,
  `caja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_recibo`
--

LOCK TABLES `detalle_recibo` WRITE;
/*!40000 ALTER TABLE `detalle_recibo` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `detalle_recibo` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `detalle_recibo_compra`
--

DROP TABLE IF EXISTS `detalle_recibo_compra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_recibo_compra` (
  `id` int(11) NOT NULL,
  `nocompra` bigint(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `saldo_anterior` decimal(10,2) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `saldo_actual` decimal(10,2) NOT NULL,
  `usuario` int(11) NOT NULL,
  `caja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_recibo_compra`
--

LOCK TABLES `detalle_recibo_compra` WRITE;
/*!40000 ALTER TABLE `detalle_recibo_compra` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `detalle_recibo_compra` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `detalle_temp`
--

DROP TABLE IF EXISTS `detalle_temp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_temp` (
  `correlativo` int(11) NOT NULL AUTO_INCREMENT,
  `token_user` varchar(50) NOT NULL,
  `codproducto` int(11) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `costo` decimal(10,2) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `cotizacion` varchar(100) DEFAULT '1',
  PRIMARY KEY (`correlativo`)
) ENGINE=InnoDB AUTO_INCREMENT=2151 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_temp`
--

LOCK TABLES `detalle_temp` WRITE;
/*!40000 ALTER TABLE `detalle_temp` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `detalle_temp` VALUES
(2149,'c4ca4238a0b923820dcc509a6f75849b',1325,1.00,247.50,280.00,NULL),
(2150,'c4ca4238a0b923820dcc509a6f75849b',1554,1.00,960.74,1080.00,NULL);
/*!40000 ALTER TABLE `detalle_temp` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `detalle_temp_compra`
--

DROP TABLE IF EXISTS `detalle_temp_compra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_temp_compra` (
  `correlativo` int(11) NOT NULL AUTO_INCREMENT,
  `token_user` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `codproducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  PRIMARY KEY (`correlativo`)
) ENGINE=InnoDB AUTO_INCREMENT=183 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_temp_compra`
--

LOCK TABLES `detalle_temp_compra` WRITE;
/*!40000 ALTER TABLE `detalle_temp_compra` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `detalle_temp_compra` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `detalleventa`
--

DROP TABLE IF EXISTS `detalleventa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalleventa` (
  `correlativo` bigint(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `noventa` bigint(11) NOT NULL,
  `codproducto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `costo` decimal(10,2) NOT NULL,
  `precio_venta` decimal(10,2) DEFAULT NULL,
  `formaDPago` varchar(25) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`correlativo`),
  KEY `codproducto` (`codproducto`),
  KEY `noventa` (`noventa`)
) ENGINE=InnoDB AUTO_INCREMENT=1583 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalleventa`
--

LOCK TABLES `detalleventa` WRITE;
/*!40000 ALTER TABLE `detalleventa` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `detalleventa` VALUES
(1543,'2025-04-16 19:53:09',1188,2012,1,110.00,13.00,'',0.00,2),
(1544,'2025-04-16 19:59:09',1189,1326,1,207.00,235.00,'',0.00,1),
(1545,'2025-04-16 19:59:09',1189,1327,1,193.50,200.00,'',0.00,1),
(1546,'2025-04-18 20:26:58',1190,1326,1,207.00,235.00,'',0.00,1),
(1547,'2025-04-21 01:35:15',1191,2087,1,250.00,300.00,'',0.00,1),
(1548,'2025-04-21 04:36:01',1192,2012,2,110.00,135.00,'',0.00,1),
(1550,'2025-05-06 03:18:35',1197,1326,2,207.00,235.00,'efectivo',1200.00,1),
(1551,'2025-05-06 03:18:35',1197,2012,1,110.00,135.00,'efectivo',1200.00,1),
(1552,'2025-05-06 12:25:44',1198,1326,1,207.00,235.00,'efectivo',1200.00,1),
(1553,'2025-05-06 12:25:44',1198,2087,2,0.00,300.00,'efectivo',1200.00,1),
(1554,'2025-05-07 21:37:12',1199,1326,1,207.00,235.00,'tarjeta',1200.00,1),
(1555,'2025-05-07 21:40:42',1200,1326,1,207.00,235.00,'tarjeta',1.00,1),
(1556,'2025-05-15 03:23:58',1201,1326,1,207.00,235.00,'tarjeta',1.00,1),
(1557,'2025-07-03 06:43:27',1202,1325,1,247.50,280.00,'efectivo',300.00,1),
(1558,'2025-07-11 13:08:16',1203,1325,1,247.50,280.00,'tarjeta',1.00,1),
(1559,'2025-07-11 13:08:16',1203,1554,1,960.74,1080.00,'tarjeta',1.00,1),
(1561,'2025-07-11 13:09:14',1204,1325,1,247.50,280.00,'efectivo',300.00,1),
(1562,'2025-07-11 13:59:35',1205,1325,1,247.50,280.00,'efectivo',300.00,1),
(1563,'2025-07-11 14:00:33',1206,1325,1,247.50,280.00,'efectivo',300.00,1),
(1564,'2025-07-11 14:19:29',1207,1325,1,247.50,280.00,'efectivo',350.00,1),
(1565,'2025-07-11 14:19:49',1208,1325,2,247.50,280.00,'tarjeta',1.00,1),
(1566,'2025-07-11 14:20:02',1209,1325,1,247.50,280.00,'efectivo',300.00,1),
(1567,'2025-07-11 14:26:52',1210,1325,1,247.50,280.00,'tarjeta',1.00,1),
(1568,'2025-07-11 14:26:52',1210,1326,1,207.00,235.00,'tarjeta',1.00,1),
(1570,'2025-07-11 15:59:36',1211,1325,1,247.50,280.00,'efectivo',300.00,1),
(1571,'2025-07-11 16:01:03',1212,1325,1,247.50,280.00,'tarjeta',1.00,1),
(1572,'2025-07-13 02:46:38',1213,1325,2,247.50,280.00,'credito',1.00,1),
(1573,'2025-07-13 02:48:29',1214,1325,1,247.50,280.00,'credito',1.00,1),
(1574,'2025-07-13 02:48:42',1215,1326,1,207.00,235.00,'credito',1.00,1),
(1575,'2025-07-13 02:49:55',1216,1325,1,247.50,280.00,'efectivo',1.00,1),
(1576,'2025-07-13 02:53:25',1217,1325,1,247.50,280.00,'credito',1.00,1),
(1577,'2025-07-13 02:55:05',1218,1325,1,247.50,280.00,'credito',1.00,1),
(1578,'2025-07-13 02:55:43',1219,1325,1,247.50,280.00,'credito',1.00,1),
(1579,'2025-07-25 18:35:10',1220,1325,1,247.50,280.00,'tarjeta',1.00,1),
(1580,'2025-07-25 18:35:10',1220,2087,1,0.00,300.00,'tarjeta',1.00,1),
(1581,'2025-07-25 18:35:10',1220,1555,2,237.46,260.00,'tarjeta',1.00,1),
(1582,'2025-07-26 02:34:22',1221,1325,5,247.50,280.00,'efectivo',1600.00,1);
/*!40000 ALTER TABLE `detalleventa` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `egresos`
--

DROP TABLE IF EXISTS `egresos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `egresos` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `descripcion` text NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `usuario` int(11) NOT NULL,
  `caja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `egresos`
--

LOCK TABLES `egresos` WRITE;
/*!40000 ALTER TABLE `egresos` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `egresos` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `entradas`
--

DROP TABLE IF EXISTS `entradas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `entradas` (
  `correlativo` bigint(11) NOT NULL AUTO_INCREMENT,
  `nocompra` bigint(11) NOT NULL,
  `codproducto` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`correlativo`)
) ENGINE=InnoDB AUTO_INCREMENT=902 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entradas`
--

LOCK TABLES `entradas` WRITE;
/*!40000 ALTER TABLE `entradas` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `entradas` VALUES
(897,152,2087,'2025-04-21 01:35:59',1,250.00,0),
(898,1,1325,'2025-07-25 19:07:52',10,247.50,0),
(899,155,1325,'2025-07-26 02:26:37',1,247.50,NULL),
(900,156,1325,'2025-07-26 02:27:22',10,247.50,NULL),
(901,157,1326,'2025-07-26 02:28:27',1,207.00,NULL);
/*!40000 ALTER TABLE `entradas` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto` (
  `codproducto` int(20) NOT NULL,
  `codigo` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `descripcion` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `categoria` int(11) DEFAULT NULL,
  `proveedor` int(11) DEFAULT NULL,
  `costo` decimal(10,2) NOT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `existencia` decimal(10,2) NOT NULL,
  `foto` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT 1,
  `usuario_id` int(11) DEFAULT NULL,
  KEY `fk_categoria` (`categoria`),
  CONSTRAINT `fk_categoria` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `producto` VALUES
(1325,'DTSI20W5012','ACEITE 20W50 1.2 LTS',1,1,247.50,280.00,7.00,'img_378a975b453639d824d34353a99bacbe.jpg','2022-01-13 20:23:17',1,1),
(1326,'DTSI20W502R','ACEITE 20W50 1 LTS',1,1,207.00,235.00,9.00,'img_dc399ccd8b13e81ce0326821c3b42ae9.jpg','2022-01-13 20:24:46',1,1),
(1327,'DTSI20W503R','ACEITE 20W50 3R 1 LTS',1,1,193.50,220.00,6.00,'img_08b718c6b302e9e9462e8a1a4449bc3c.jpg','2022-01-13 20:25:52',1,1),
(1552,'7042292656','ACEITE RALLYE 140',1,1,155.00,175.00,9.00,'img_ffd0cdeb3006a16c5073673d846a5a39.jpg','2022-02-11 16:11:35',1,1),
(1553,'MO402','ACEITE LION SAE 40',1,1,123.35,155.00,15.00,'img_ea10e057fb6c6c85d052180b61762702.jpg','2022-02-11 16:17:41',1,1),
(1554,'15C9BF','ACEITE CASTROL CRB MAX 15W-40',1,1,960.74,1080.00,-2.00,'img_ec5afd5d4f512d8b6ccdf3838852fc29.jpg','2022-02-11 16:19:04',1,1),
(1555,'15D9C1','ACEITE CASTROL ACTEVO 4T 20W-50',1,1,237.46,260.00,6.00,'img_b2adf96d67c8e73f4023fb450ae7f656.jpg','2022-02-11 16:20:17',1,1),
(1556,'MN7104-1','ACEITE MANNOL MNTS4 15W-40 ',1,1,124.71,165.00,15.00,'img_7eab08200a0eac1198a184f47a5ed9eb.jpg','2022-02-11 16:22:20',1,1),
(1557,'1030SNGF5BL','ACEITE ULTRA PLUS 10W-30',1,1,145.00,170.00,11.00,'img_9005a00d6bfcebe68ac554e4d4a1e7e4.jpg','2022-02-11 16:23:36',1,1),
(1558,'800-10-4','LIQUIDO DE FRENO FREE ROJO',1,1,53.69,65.00,11.00,'img_2d3f21673b30a6dcbdd75e36865f23f1.jpg','2022-02-11 16:24:59',1,1),
(1559,'800-10-3','LIQUIDO DE FRENO BLANCO',1,1,53.69,65.00,0.00,'img_9bef084aa68a55d1b0476f89fab85543.jpg','2022-02-11 16:25:43',1,1),
(1560,'15D2C4','Aceite Castrol Essential 4T 20W-50',1,1,189.29,230.00,4.00,'img_cc0f017a87be402fae0d8837ef3926d0.jpg','2022-02-11 16:26:49',1,1),
(2011,'1349','LUBRICANTE DE CADENA LIQUI MOLI',8,1,305.00,360.00,3.00,'img_producto.png','2022-07-08 18:54:38',1,1),
(2012,'1350','ACEITE HIDRAULICO RO',2,1,110.00,135.00,1.00,'img_producto.png','2022-07-08 18:55:49',1,1),
(2087,'1351','Aceite 2 tiempo',10,1,0.00,300.00,-2.00,'img_producto.png','2022-09-15 15:04:09',1,1);
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `proveedor` (
  `codproveedor` int(11) NOT NULL,
  `proveedor` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `contacto` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `telefono` bigint(11) DEFAULT NULL,
  `direccion` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT 1,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedor`
--

LOCK TABLES `proveedor` WRITE;
/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `proveedor` VALUES
(1,'Mercado','Mercado',99999999,'Managua','2021-09-21 15:52:42',1,1);
/*!40000 ALTER TABLE `proveedor` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `rol` (
  `idrol` int(11) NOT NULL,
  `rol` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `rol` VALUES
(1,'Administrador'),
(2,'Supervisor'),
(3,'Vendedor');
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `correo` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `usuario` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `clave` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `rol` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `usuario` VALUES
(1,'Admin','admin@gmail.com','admin','81dc9bdb52d04dc20036dbd8313ed055',1,1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `venta`
--

DROP TABLE IF EXISTS `venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `venta` (
  `noventa` bigint(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario` int(11) DEFAULT NULL,
  `caja` int(11) NOT NULL,
  `codcliente` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `totalventa` decimal(10,2) DEFAULT NULL,
  `formaDPago` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `descuento` decimal(10,2) NOT NULL,
  `abono` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`noventa`)
) ENGINE=InnoDB AUTO_INCREMENT=1222 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venta`
--

LOCK TABLES `venta` WRITE;
/*!40000 ALTER TABLE `venta` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `venta` VALUES
(1188,'2025-04-16 19:53:09',1,161,1,2,13.00,'',0.00,0.00,0.00),
(1189,'2025-04-16 19:59:09',1,161,1,1,435.00,'',0.00,0.00,0.00),
(1190,'2025-04-18 20:26:58',1,161,1,1,235.00,'',0.00,0.00,0.00),
(1191,'2025-04-21 01:35:15',1,161,1,1,300.00,'',0.00,0.00,0.00),
(1192,'2025-04-21 04:36:01',1,161,1,1,202.50,'',0.00,0.00,0.00),
(1197,'2025-05-06 03:18:35',1,161,1,1,605.00,'efectivo',1200.00,0.00,0.00),
(1198,'2025-05-06 12:25:44',1,161,1,1,835.00,'efectivo',1200.00,0.00,0.00),
(1199,'2025-05-07 21:37:12',1,161,1,1,235.00,'tarjeta',1200.00,0.00,0.00),
(1210,'2025-07-11 14:26:52',1,161,1,1,515.00,'tarjeta',1.00,0.00,0.00),
(1211,'2025-07-11 15:59:36',1,161,1,1,280.00,'efectivo',300.00,0.00,0.00),
(1212,'2025-07-11 16:01:03',1,161,1,1,280.00,'tarjeta',1.00,0.00,0.00),
(1213,'2025-07-13 02:46:38',1,161,1,1,560.00,'credito',1.00,0.00,0.00),
(1214,'2025-07-13 02:48:29',1,161,1,1,280.00,'credito',1.00,0.00,0.00),
(1215,'2025-07-13 02:48:42',1,161,1,1,235.00,'credito',1.00,0.00,0.00),
(1216,'2025-07-13 02:49:55',1,161,1,1,280.00,'efectivo',1.00,0.00,0.00),
(1217,'2025-07-13 02:53:25',1,161,1,1,280.00,'credito',1.00,0.00,0.00),
(1218,'2025-07-13 02:55:05',1,161,1,1,280.00,'credito',1.00,0.00,0.00),
(1219,'2025-07-13 02:55:43',1,161,1,3,280.00,'credito',1.00,0.00,0.00),
(1220,'2025-07-25 18:35:10',1,161,1,1,1100.00,'tarjeta',1.00,0.00,0.00),
(1221,'2025-07-26 02:34:22',1,161,1,1,1400.00,'efectivo',1600.00,0.00,0.00);
/*!40000 ALTER TABLE `venta` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping routines for database 'bd_ventas'
--
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `actualizar_precio_producto` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_uca1400_ai_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_precio_producto`(IN `n_cantidad` INT, IN `n_precio` DECIMAL(10,2), IN `codigo` INT)
BEGIN
    	DECLARE nueva_existencia int;
        DECLARE nuevo_total decimal(10,2);
        DECLARE nuevo_precio decimal(10,2);
        
        DECLARE cant_actual int;
        DECLARE pre_actual decimal(10,2);
        
        DECLARE actual_existencia int;
        DECLARE actual_precio decimal(10,2);
        
        SELECT precio,existencia INTO actual_precio,actual_existencia FROM producto WHERE codproducto = codigo;
        SET nueva_existencia = actual_existencia + n_cantidad;
        
        UPDATE producto SET existencia = nueva_existencia, precio = n_precio WHERE codproducto = codigo;
        
        SELECT nueva_existencia,nuevo_precio;
        
     END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `add_detalle_temp` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_detalle_temp`(IN `codigo` INT, IN `cantidad` DECIMAL(10,2), IN `token_user` VARCHAR(50), IN `precio_ingresado` INT, IN `cotizacion` VARCHAR(100))
BEGIN
    
    	DECLARE precio_actual decimal(10,2);
        DECLARE costo_actual decimal(10,2);
        DECLARE existencia_actual decimal(10,2);
        DECLARE nueva_existencia decimal(10,2);
        
SELECT costo,precio INTO costo_actual,precio_actual FROM producto WHERE codproducto = codigo;
        
        INSERT INTO detalle_temp(token_user,codproducto,cantidad,costo,precio_venta, cotizacion) VALUES(token_user,codigo,cantidad,costo_actual,precio_ingresado,cotizacion);
        
        SELECT existencia INTO existencia_actual FROM producto WHERE codproducto = codigo;

                SET nueva_existencia = existencia_actual - cantidad;
                UPDATE producto SET existencia = nueva_existencia WHERE codproducto = codigo;
        
        SELECT tmp.correlativo, tmp.codproducto,p.descripcion,tmp.cantidad,tmp.precio_venta FROM detalle_temp tmp
        INNER JOIN producto p 
        ON tmp.codproducto = p.codproducto
        WHERE tmp.token_user = token_user;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `add_detalle_temp_compra` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_uca1400_ai_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_detalle_temp_compra`(IN `codigo` INT, IN `cantidad` INT, IN `token_user` VARCHAR(50), IN `costo` DECIMAL(10,2))
BEGIN 
	    DECLARE precio_actual decimal(10,2);
        DECLARE existencia_actual int;
        DECLARE nueva_existencia int;
        
        INSERT INTO detalle_temp_compra(token_user,codproducto,cantidad,precio_venta) VALUES(token_user,codigo,cantidad,costo);
        
        SELECT tmp.correlativo, tmp.codproducto,p.descripcion,tmp.cantidad,tmp.precio_venta FROM detalle_temp_compra tmp
        INNER JOIN producto p 
        ON tmp.codproducto = p.codproducto
        WHERE tmp.token_user = token_user;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `anular_compra` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_uca1400_ai_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `anular_compra`(IN `no_venta` INT)
BEGIN
	DECLARE existe_venta int;
        DECLARE registros int;
        DECLARE a int;
        
        DECLARE cod_producto int;
        DECLARE cant_producto int;
        DECLARE existencia_actual int;
        DECLARE nueva_existencia int;
        
        SET existe_venta = (SELECT COUNT(*) FROM compras WHERE nocompra = no_venta and status != 2);
        
        IF existe_venta > 0 THEN
        	CREATE TEMPORARY TABLE tbl_tmp (
                id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                cod_prod BIGINT,
                cant_prod int);
                
                SET a = 1;
                
                SET registros = (SELECT COUNT(*)FROM entradas WHERE nocompra = no_venta);
                
                IF registros > 0 THEN
                	INSERT INTO tbl_tmp(cod_prod,cant_prod) SELECT codproducto,cantidad FROM entradas WHERE nocompra = no_venta;
                    
                    WHILE a <= registros DO
                    	SELECT cod_prod,cant_prod INTO cod_producto,cant_producto FROM tbl_tmp WHERE id = a;
                        SELECT existencia INTO existencia_actual FROM producto WHERE codproducto = cod_producto;
                        SET nueva_existencia = existencia_actual - cant_producto;
                        UPDATE producto SET existencia = nueva_existencia WHERE codproducto = cod_producto;
                        
                        SET a=a+1;
                    
                    END WHILE;
                    UPDATE compras SET status = 2 WHERE nocompra = no_venta;
                    DROP TABLE tbl_tmp;
                    SELECT * FROM compras WHERE nocompra = no_venta;
                
                END IF;
        
        ELSE
        	SELECT 0 compras;
        END IF;
    
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `anular_venta` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_uca1400_ai_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `anular_venta`(IN `no_venta` INT)
BEGIN
    	DECLARE existe_venta int;
        DECLARE registros int;
        DECLARE a int;
        
        DECLARE cod_producto int;
        DECLARE cant_producto int;
        DECLARE existencia_actual int;
        DECLARE nueva_existencia int;
        
        SET existe_venta = (SELECT COUNT(*) FROM venta WHERE noventa = no_venta and status != 2);
        
        IF existe_venta > 0 THEN
        	CREATE TEMPORARY TABLE tbl_tmp (
                id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                cod_prod BIGINT,
                cant_prod int);
                
                SET a = 1;
                
                SET registros = (SELECT COUNT(*)FROM detalleventa WHERE noventa = no_venta);
                
                IF registros > 0 THEN
                	INSERT INTO tbl_tmp(cod_prod,cant_prod) SELECT codproducto,cantidad FROM detalleventa WHERE noventa = no_venta;
                    
                    WHILE a <= registros DO
                    	SELECT cod_prod,cant_prod INTO cod_producto,cant_producto FROM tbl_tmp WHERE id = a;
                        SELECT existencia INTO existencia_actual FROM producto WHERE codproducto = cod_producto;
                        SET nueva_existencia = existencia_actual + cant_producto;
                        UPDATE producto SET existencia = nueva_existencia WHERE codproducto = cod_producto;
           UPDATE detalleventa SET status = 2 WHERE noventa = no_venta;
                        
                        SET a=a+1;
                    
                    END WHILE;
                    UPDATE venta SET status = 2 WHERE noventa = no_venta;
                    DROP TABLE tbl_tmp;
                    SELECT * FROM venta WHERE noventa = no_venta;
                
                END IF;
        
        ELSE
        	SELECT 0 venta;
        END IF;
    
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `cancelar_compra` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_uca1400_ai_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `cancelar_compra`(IN `token` INT)
BEGIN
    	DECLARE existe_venta int;
        DECLARE registros int;
        DECLARE a int;
        
        DECLARE cod_producto int; 
        DECLARE cant_producto int;
        DECLARE existencia_actual int;
        DECLARE nueva_existencia int;
        
        SET existe_venta = (SELECT COUNT(*) FROM detalle_temp_compra WHERE token_user = token);
        
        IF existe_venta > 0 THEN
        	CREATE TEMPORARY TABLE tbl_tmp (
                id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                cod_prod BIGINT,
                cant_prod int);
                
                SET a = 1;
                
                SET registros = (SELECT COUNT(*)FROM detalle_temp_compra WHERE token_user = token);
                
                IF registros > 0 THEN
                	INSERT INTO tbl_tmp(cod_prod,cant_prod) SELECT codproducto,cantidad FROM detalle_temp_compra WHERE token_user = token;
                    
                    WHILE a <= registros DO
                    	SELECT cod_prod,cant_prod INTO cod_producto,cant_producto FROM tbl_tmp WHERE id = a;
                        SELECT existencia INTO existencia_actual FROM producto WHERE codproducto = cod_producto;
                        SET nueva_existencia = existencia_actual + cant_producto;
                        UPDATE producto SET existencia = nueva_existencia WHERE codproducto = cod_producto;
                        
                        SET a=a+1;
                    
                    END WHILE;
       DELETE FROM detalle_temp_compra WHERE token_user = token;
              DROP TABLE tbl_tmp;
       SELECT * FROM detalle_temp_compra WHERE token_user = token;
                
                END IF;
        
        ELSE
        	SELECT 0 detalle_temp_compra;
        END IF;
    
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `cancelar_venta` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_uca1400_ai_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `cancelar_venta`(IN `token` INT)
BEGIN
    	DECLARE existe_venta int;
        DECLARE registros int;
        DECLARE a int;
        
        DECLARE cod_producto int; 
        DECLARE cant_producto int;
        DECLARE existencia_actual int;
        DECLARE nueva_existencia int;
        
        SET existe_venta = (SELECT COUNT(*) FROM detalle_temp WHERE token_user = token);
        
        IF existe_venta > 0 THEN
        	CREATE TEMPORARY TABLE tbl_tmp (
                id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                cod_prod BIGINT,
                cant_prod int);
                
                SET a = 1;
                
                SET registros = (SELECT COUNT(*)FROM detalle_temp WHERE token_user = token);
                
                IF registros > 0 THEN
                	INSERT INTO tbl_tmp(cod_prod,cant_prod) SELECT codproducto,cantidad FROM detalle_temp WHERE token_user = token;
                    
                    WHILE a <= registros DO
                    	SELECT cod_prod,cant_prod INTO cod_producto,cant_producto FROM tbl_tmp WHERE id = a;
                        SELECT existencia INTO existencia_actual FROM producto WHERE codproducto = cod_producto;
                        SET nueva_existencia = existencia_actual + cant_producto;
                        UPDATE producto SET existencia = nueva_existencia WHERE codproducto = cod_producto;
                        
                        SET a=a+1;
                    
                    END WHILE;
       DELETE FROM detalle_temp WHERE token_user = token;
              DROP TABLE tbl_tmp;
       SELECT * FROM detalle_temp WHERE token_user = token;
                
                END IF;
        
        ELSE
        	SELECT 0 detalle_temp;
        END IF;
    
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `dataDashboard` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_uca1400_ai_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `dataDashboard`(IN `caja_id` INT)
BEGIN
    	
        DECLARE usuarios int;
        DECLARE clientes int;
        DECLARE proveedores int;
        DECLARE productos int;
        DECLARE ventas decimal(10,2);
        DECLARE abonos decimal(10,2);
        DECLARE pagos decimal(10,2);
        DECLARE compra decimal(10,2);
        DECLARE cobrar decimal(10,2);
        DECLARE pagar decimal(10,2);
        DECLARE egreso decimal(10,2);
        DECLARE credito decimal(10,2);
        DECLARE inicios decimal(10,2);
        
        SELECT COUNT(*) INTO usuarios FROM usuario WHERE status !=10;
        SELECT COUNT(*) INTO clientes FROM cliente WHERE status !=10;
        SELECT COUNT(*) INTO proveedores FROM proveedor WHERE status !=10;
        SELECT COUNT(*) INTO productos FROM producto WHERE status !=10;
        SELECT SUM(totalventa) INTO ventas FROM venta WHERE caja = caja_id AND status =1;
        SELECT SUM(totalventa) INTO credito FROM venta WHERE caja = caja_id AND status =3;
        SELECT SUM(cantidad) INTO abonos FROM detalle_recibo WHERE caja = caja_id;
        SELECT SUM(cantidad) INTO pagos FROM detalle_recibo_compra WHERE caja = caja_id;
        SELECT SUM(totalcompra) INTO compra FROM compras WHERE caja = caja_id AND status =1;
        SELECT SUM(cantidad) INTO egreso FROM egresos WHERE caja = caja_id;
        SELECT SUM(totalventa-abono) INTO cobrar FROM venta WHERE status =3;
        SELECT SUM(totalcompra-abono) INTO pagar FROM compras WHERE status =3;
        SELECT inicio INTO inicios FROM caja WHERE status =1;
        
        SELECT usuarios,clientes,proveedores,productos,ventas,abonos,pagos,compra,cobrar,pagar,egreso,credito,inicios;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `del_detalle_temp` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_uca1400_ai_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `del_detalle_temp`(IN `id_detalle` INT, IN `token` VARCHAR(50))
BEGIN    
		DECLARE existe_venta int;
        DECLARE registros int;
        DECLARE a int;
        
        DECLARE cod_producto int;
        DECLARE cant_producto int;
        DECLARE existencia_actual int;
        DECLARE nueva_existencia int;
        

        	CREATE TEMPORARY TABLE tbl_tmp (id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                cod_prod BIGINT,
                cant_prod int);
                
                SET a = 1;
                
                SET registros = (SELECT COUNT(*)FROM detalle_temp WHERE correlativo = id_detalle);
                

                	INSERT INTO tbl_tmp(cod_prod,cant_prod) SELECT codproducto,cantidad FROM detalle_temp WHERE correlativo = id_detalle;
                    
                    	SELECT cod_prod,cant_prod INTO cod_producto,cant_producto FROM tbl_tmp WHERE id = a;
                        SELECT existencia INTO existencia_actual FROM producto WHERE codproducto = cod_producto;
                        SET nueva_existencia = existencia_actual + cant_producto;
                        UPDATE producto SET existencia = nueva_existencia WHERE codproducto = cod_producto;

            DELETE FROM detalle_temp WHERE correlativo = id_detalle;
  
            SELECT tmp.correlativo, tmp.codproducto,p.descripcion,tmp.cantidad,tmp.precio_venta FROM detalle_temp tmp
            INNER JOIN producto p 
            ON tmp.codproducto = p.codproducto
            WHERE tmp.token_user = token;
        END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `del_detalle_temp_compra` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_uca1400_ai_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `del_detalle_temp_compra`(IN `id_detalle` INT, IN `token` VARCHAR(50))
BEGIN  	
  		DECLARE existe_venta int;
        DECLARE registros int;
        DECLARE a int;
        
        DECLARE cod_producto int;
        DECLARE cant_producto int;
        DECLARE existencia_actual int;
        DECLARE nueva_existencia int;
        

        CREATE TEMPORARY TABLE tbl_tmp (id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                cod_prod BIGINT,
                cant_prod int);
                
                SET a = 1;
                
         SET registros = (SELECT COUNT(*)FROM detalle_temp_compra WHERE correlativo = id_detalle);
                

         INSERT INTO tbl_tmp(cod_prod,cant_prod) SELECT codproducto,cantidad FROM detalle_temp_compra WHERE correlativo = id_detalle;
                    
         SELECT cod_prod,cant_prod INTO cod_producto,cant_producto FROM tbl_tmp WHERE id = a;

            DELETE FROM detalle_temp_compra WHERE correlativo = id_detalle;
  
            SELECT tmp.correlativo, tmp.codproducto,p.descripcion,tmp.cantidad,tmp.precio_venta FROM detalle_temp_compra tmp
            INNER JOIN producto p 
            ON tmp.codproducto = p.codproducto
            WHERE tmp.token_user = token;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `edit_detalle_temp` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_uca1400_ai_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `edit_detalle_temp`(IN `correlativo` INT, IN `cantanterior` DECIMAL(10,2), IN `codprod` INT, IN `cantidad` DECIMAL(10,2), IN `precio` DECIMAL(10,2))
BEGIN
    
    	DECLARE precio_actual decimal(10,2);
        DECLARE costo_actual decimal(10,2);
        DECLARE existencia_actual decimal(10,2);
        DECLARE nueva_existencia decimal(10,2);
                
        UPDATE detalle_temp SET cantidad = cantidad ,precio_venta = precio WHERE codproducto = codprod;
        
        SELECT existencia INTO existencia_actual FROM producto WHERE codproducto = codprod;
	
    	IF (cantanterior- cantidad) >= 0 THEN
    		SET nueva_existencia = existencia_actual + cantanterior - cantidad;
       	ELSE
        	SET nueva_existencia = existencia_actual - (cantanterior - cantidad);
        END IF;
        UPDATE producto SET existencia = nueva_existencia WHERE codproducto = codprod;
        
        SELECT tmp.correlativo, tmp.codproducto,p.descripcion,tmp.cantidad,tmp.precio_venta FROM detalle_temp tmp
        INNER JOIN producto p 
        ON tmp.codproducto = p.codproducto
        WHERE tmp.token_user = token_user;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `procesar_compra` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `procesar_compra`(IN `cod_usuario` INT, IN `cod_cliente` INT, IN `token` VARCHAR(50), IN `tipo_pago` INT, IN `id_caja` INT)
BEGIN
        DECLARE venta INT;
        
        DECLARE registros INT;        
        DECLARE total DECIMAL(10,2);
        
        DECLARE nueva_existencia int;
        DECLARE nuevo_costo DECIMAL(10,2);
        DECLARE nuevo_total DECIMAL(10,2);
        
        DECLARE existencia_actual int;
        DECLARE costo_actual DECIMAL(10,2);
        
        DECLARE tmp_cod_prod int;
        DECLARE tmp_cant_prod int;
        DECLARE tmp_cost_prod DECIMAL(10,2);
        DECLARE a INT;
        SET a = 1;
        
        CREATE TEMPORARY TABLE tbl_tmp_tokenuser(
                id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                cod_prod BIGINT,
                cant_prod int,
                cost_prod DECIMAL(10,2));
                
SET registros = (SELECT COUNT(*) FROM detalle_temp_compra WHERE token_user = token);
        
        IF registros > 0 THEN
  INSERT INTO tbl_tmp_tokenuser(cod_prod,cant_prod,cost_prod) SELECT codproducto,cantidad,precio_venta FROM detalle_temp_compra WHERE token_user = token;
            
INSERT INTO compras(usuario,caja,codproveedor,status) VALUES(cod_usuario,id_caja,cod_cliente,tipo_pago);
            SET venta = LAST_INSERT_ID();
            
INSERT INTO entradas(nocompra,codproducto,cantidad,precio) SELECT(venta) as nocompra, codproducto,cantidad,precio_venta FROM detalle_temp_compra WHERE token_user = token;
            
            WHILE a <= registros DO
 SELECT cod_prod,cant_prod,cost_prod INTO tmp_cod_prod,tmp_cant_prod,tmp_cost_prod FROM tbl_tmp_tokenuser WHERE id = a;
       
 SELECT costo,existencia INTO costo_actual,existencia_actual FROM producto WHERE codproducto = tmp_cod_prod;
                
SET nueva_existencia = existencia_actual + tmp_cant_prod;
SET nuevo_total = (existencia_actual * costo_actual) + (tmp_cant_prod * tmp_cost_prod);
SET nuevo_costo = nuevo_total / nueva_existencia;

UPDATE producto SET existencia = nueva_existencia,costo = nuevo_costo WHERE codproducto = tmp_cod_prod;
                
                SET a=a+1;
           
            END WHILE;
            
 SET total = (SELECT SUM(cantidad * precio_venta) FROM detalle_temp_compra WHERE token_user = token);
UPDATE compras SET totalcompra = total WHERE nocompra = venta;
DELETE FROM detalle_temp_compra WHERE token_user = token;
            TRUNCATE TABLE tbl_tmp_tokenuser;
            SELECT * FROM compras WHERE nocompra = venta;
            
        ELSE
            SELECT 0;
        END IF;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `procesar_venta` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_uca1400_ai_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `procesar_venta`(IN `cod_usuario` INT, IN `cod_cliente` INT, IN `token` VARCHAR(50), IN `tipo_pago` INT, IN `id_caja` INT, IN `descuento` INT, IN `formaDP` VARCHAR(25), IN `mon` DECIMAL(10,2))
BEGIN
    	DECLARE venta_id INT;
        
        DECLARE registros INT;
        DECLARE subtotal DECIMAL(10,2);
        DECLARE total DECIMAL(10,2);
        
        DECLARE nueva_existencia int;
        DECLARE existencia_actual int;
        
        DECLARE tmp_cod_producto int;
        DECLARE tmp_cant_producto int;
        DECLARE a INT;
        SET a = 1;
        
        CREATE TEMPORARY TABLE tbl_tmp_tokenuser(
        		id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        		cod_prod BIGINT,
        		cant_prod int);
                
        SET registros = (SELECT COUNT(*) FROM detalle_temp WHERE token_user = token);
        
        IF registros > 0 THEN
        	INSERT INTO tbl_tmp_tokenuser(cod_prod,cant_prod) SELECT codproducto,cantidad FROM detalle_temp WHERE token_user = token;
            
            INSERT INTO venta(usuario,caja,codcliente,status,descuento,formaDPago,monto, abono) VALUES(cod_usuario,id_caja,cod_cliente,tipo_pago,descuento,formaDP,mon, 0);
            SET venta_id = LAST_INSERT_ID();
            
            INSERT INTO detalleventa(noventa,codproducto,cantidad,costo,precio_venta, formaDPago, monto) SELECT venta_id, codproducto,cantidad,costo,precio_venta, formaDP, mon FROM detalle_temp WHERE token_user = token;
            
            WHILE a <= registros DO
            	SELECT cod_prod,cant_prod INTO tmp_cod_producto,tmp_cant_producto FROM tbl_tmp_tokenuser WHERE id = a;
                
                SET a=a+1;
           
            END WHILE;
            
            SET subtotal = (SELECT SUM(cantidad * precio_venta) FROM detalle_temp WHERE token_user = token);
            SET total = subtotal - descuento;
            UPDATE venta SET totalventa = total WHERE noventa = venta_id;
            DELETE FROM detalle_temp WHERE token_user = token;
            TRUNCATE TABLE tbl_tmp_tokenuser;
            SELECT * FROM venta WHERE noventa = venta_id;
            
        ELSE
        	SELECT 0;
        END IF;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2025-10-07  2:59:27
