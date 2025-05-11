-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 22-04-2025 a las 02:41:22
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_ventas`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_precio_producto` (IN `n_cantidad` INT, IN `n_precio` DECIMAL(10,2), IN `codigo` INT)   BEGIN
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
        
     END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_detalle_temp` (IN `codigo` INT, IN `cantidad` DECIMAL(10,2), IN `token_user` VARCHAR(50), IN `precio_ingresado` INT)   BEGIN
    
    	DECLARE precio_actual decimal(10,2);
        DECLARE costo_actual decimal(10,2);
        DECLARE existencia_actual decimal(10,2);
        DECLARE nueva_existencia decimal(10,2);
        
SELECT costo,precio INTO costo_actual,precio_actual FROM producto WHERE codproducto = codigo;
        
        INSERT INTO detalle_temp(token_user,codproducto,cantidad,costo,precio_venta) VALUES(token_user,codigo,cantidad,costo_actual,precio_ingresado);
        
        SELECT existencia INTO existencia_actual FROM producto WHERE codproducto = codigo;

                SET nueva_existencia = existencia_actual - cantidad;
                UPDATE producto SET existencia = nueva_existencia WHERE codproducto = codigo;
        
        SELECT tmp.correlativo, tmp.codproducto,p.descripcion,tmp.cantidad,tmp.precio_venta FROM detalle_temp tmp
        INNER JOIN producto p 
        ON tmp.codproducto = p.codproducto
        WHERE tmp.token_user = token_user;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_detalle_temp_compra` (IN `codigo` INT, IN `cantidad` INT, IN `token_user` VARCHAR(50), IN `costo` DECIMAL(10,2))   BEGIN 
	    DECLARE precio_actual decimal(10,2);
        DECLARE existencia_actual int;
        DECLARE nueva_existencia int;
        
        INSERT INTO detalle_temp_compra(token_user,codproducto,cantidad,precio_venta) VALUES(token_user,codigo,cantidad,costo);
        
        SELECT tmp.correlativo, tmp.codproducto,p.descripcion,tmp.cantidad,tmp.precio_venta FROM detalle_temp_compra tmp
        INNER JOIN producto p 
        ON tmp.codproducto = p.codproducto
        WHERE tmp.token_user = token_user;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `anular_compra` (IN `no_venta` INT)   BEGIN
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
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `anular_venta` (IN `no_venta` INT)   BEGIN
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
    
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cancelar_compra` (IN `token` INT)   BEGIN
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
    
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cancelar_venta` (IN `token` INT)   BEGIN
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
    
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `dataDashboard` (IN `caja_id` INT)   BEGIN
    	
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
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `del_detalle_temp` (IN `id_detalle` INT, IN `token` VARCHAR(50))   BEGIN    
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
        END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `del_detalle_temp_compra` (IN `id_detalle` INT, IN `token` VARCHAR(50))   BEGIN  	
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
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `procesar_compra` (IN `cod_usuario` INT, IN `cod_cliente` INT, IN `token` VARCHAR(50), IN `tipo_pago` INT, IN `id_caja` INT)   BEGIN
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
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `procesar_venta` (IN `cod_usuario` INT, IN `cod_cliente` INT, IN `token` VARCHAR(50), IN `tipo_pago` INT, IN `id_caja` INT, IN `descuento` INT)   BEGIN
    	DECLARE venta INT;
        
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
            
            INSERT INTO venta(usuario,caja,codcliente,status,descuento) VALUES(cod_usuario,id_caja,cod_cliente,tipo_pago,descuento);
            SET venta = LAST_INSERT_ID();
            
            INSERT INTO detalleventa(noventa,codproducto,cantidad,costo,precio_venta) SELECT(venta) as noventa, codproducto,cantidad,costo,precio_venta FROM detalle_temp WHERE token_user = token;
            
            WHILE a <= registros DO
            	SELECT cod_prod,cant_prod INTO tmp_cod_producto,tmp_cant_producto FROM tbl_tmp_tokenuser WHERE id = a;
                
                SET a=a+1;
           
            END WHILE;
            
            SET subtotal = (SELECT SUM(cantidad * precio_venta) FROM detalle_temp WHERE token_user = token);
            SET total = subtotal - descuento;
            UPDATE venta SET totalventa = total WHERE noventa = venta;
            DELETE FROM detalle_temp WHERE token_user = token;
            TRUNCATE TABLE tbl_tmp_tokenuser;
            SELECT * FROM venta WHERE noventa = venta;
            
        ELSE
        	SELECT 0;
        END IF;
    END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

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
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`id`, `fecha`, `inicio`, `ventas`, `abonos`, `egresos`, `creditos`, `total_efectivo`, `usuario`, `status`) VALUES
(161, '2025-04-14 19:11:41', 500.00, NULL, NULL, NULL, NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL,
  `nit` varchar(20) DEFAULT NULL,
  `nombre` varchar(80) DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idcliente`, `nit`, `nombre`, `telefono`, `direccion`, `date_add`, `usuario_id`, `status`) VALUES
(1, '6031807920003k', 'Cliente regular', 88888888, 'EL RAMA', '2021-12-05 15:47:39', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `nocompra` bigint(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuario` int(20) NOT NULL,
  `caja` int(11) NOT NULL,
  `codproveedor` int(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `totalcompra` decimal(10,2) NOT NULL,
  `abono` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`nocompra`, `fecha`, `usuario`, `caja`, `codproveedor`, `status`, `totalcompra`, `abono`) VALUES
(152, '2025-04-21 07:35:59', 1, 161, 1, 1, 250.00, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

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
  `moneda` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `nit`, `nombre`, `razon_social`, `telefono`, `email`, `direccion`, `iva`, `foto`, `moneda`) VALUES
(1, '6232912905005C', 'Lubricentro', 'Aceites y lubricantes', 85289255, 'lubricentro@gmail.com', 'Ciudad Rama', 0.00, ' ', '$');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleventa`
--

CREATE TABLE `detalleventa` (
  `correlativo` bigint(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `noventa` bigint(11) DEFAULT NULL,
  `codproducto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `costo` decimal(10,2) NOT NULL,
  `precio_venta` decimal(10,2) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `detalleventa`
--

INSERT INTO `detalleventa` (`correlativo`, `fecha`, `noventa`, `codproducto`, `cantidad`, `costo`, `precio_venta`, `status`) VALUES
(1543, '2025-04-16 19:53:09', 1188, 2012, 1, 110.00, 13.00, 2),
(1544, '2025-04-16 19:59:09', 1189, 1326, 1, 207.00, 235.00, 1),
(1545, '2025-04-16 19:59:09', 1189, 1327, 1, 193.50, 200.00, 1),
(1546, '2025-04-18 20:26:58', 1190, 1326, 1, 207.00, 235.00, 1),
(1547, '2025-04-21 01:35:15', 1191, 2087, 1, 250.00, 300.00, 1),
(1548, '2025-04-21 04:36:01', 1192, 2012, 2, 110.00, 135.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_recibo`
--

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_recibo_compra`
--

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_temp`
--

CREATE TABLE `detalle_temp` (
  `correlativo` int(11) NOT NULL,
  `token_user` varchar(50) NOT NULL,
  `codproducto` int(11) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `costo` decimal(10,2) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_temp_compra`
--

CREATE TABLE `detalle_temp_compra` (
  `correlativo` int(11) NOT NULL,
  `token_user` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `codproducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egresos`
--

CREATE TABLE `egresos` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `descripcion` text NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `usuario` int(11) NOT NULL,
  `caja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

CREATE TABLE `entradas` (
  `correlativo` bigint(11) NOT NULL,
  `nocompra` bigint(11) NOT NULL,
  `codproducto` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `entradas`
--

INSERT INTO `entradas` (`correlativo`, `nocompra`, `codproducto`, `fecha`, `cantidad`, `precio`, `usuario_id`) VALUES
(897, 152, 2087, '2025-04-21 01:35:59', 1, 250.00, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `codproducto` int(20) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `proveedor` int(11) DEFAULT NULL,
  `costo` decimal(10,2) NOT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `existencia` decimal(10,2) NOT NULL,
  `foto` text DEFAULT NULL,
  `date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT 1,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`codproducto`, `codigo`, `descripcion`, `proveedor`, `costo`, `precio`, `existencia`, `foto`, `date_add`, `status`, `usuario_id`) VALUES
(1325, 'DTSI20W5012', 'ACEITE 20W50 1.2 LTS', 1, 247.50, 280.00, 10.00, 'img_378a975b453639d824d34353a99bacbe.jpg', '2022-01-13 20:23:17', 1, 1),
(1326, 'DTSI20W502R', 'ACEITE 20W50 1 LTS', 1, 207.00, 235.00, 14.00, 'img_dc399ccd8b13e81ce0326821c3b42ae9.jpg', '2022-01-13 20:24:46', 1, 1),
(1327, 'DTSI20W503R', 'ACEITE 20W50 3R 1 LTS', 1, 193.50, 220.00, 6.00, 'img_08b718c6b302e9e9462e8a1a4449bc3c.jpg', '2022-01-13 20:25:52', 1, 1),
(1552, '7042292656', 'ACEITE RALLYE 140', 1, 155.00, 175.00, 9.00, 'img_ffd0cdeb3006a16c5073673d846a5a39.jpg', '2022-02-11 16:11:35', 1, 1),
(1553, 'MO402', 'ACEITE LION SAE 40', 1, 123.35, 155.00, 15.00, 'img_ea10e057fb6c6c85d052180b61762702.jpg', '2022-02-11 16:17:41', 1, 1),
(1554, '15C9BF', 'ACEITE CASTROL CRB MAX 15W-40', 1, 960.74, 1080.00, 0.00, 'img_ec5afd5d4f512d8b6ccdf3838852fc29.jpg', '2022-02-11 16:19:04', 1, 1),
(1555, '15D9C1', 'ACEITE CASTROL ACTEVO 4T 20W-50', 1, 237.46, 260.00, 8.00, 'img_b2adf96d67c8e73f4023fb450ae7f656.jpg', '2022-02-11 16:20:17', 1, 1),
(1556, 'MN7104-1', 'ACEITE MANNOL MNTS4 15W-40 ', 1, 124.71, 165.00, 15.00, 'img_7eab08200a0eac1198a184f47a5ed9eb.jpg', '2022-02-11 16:22:20', 1, 1),
(1557, '1030SNGF5BL', 'ACEITE ULTRA PLUS 10W-30', 1, 145.00, 170.00, 11.00, 'img_9005a00d6bfcebe68ac554e4d4a1e7e4.jpg', '2022-02-11 16:23:36', 1, 1),
(1558, '800-10-4', 'LIQUIDO DE FRENO FREE ROJO', 1, 53.69, 65.00, 11.00, 'img_2d3f21673b30a6dcbdd75e36865f23f1.jpg', '2022-02-11 16:24:59', 1, 1),
(1559, '800-10-3', 'LIQUIDO DE FRENO BLANCO', 1, 53.69, 65.00, 0.00, 'img_9bef084aa68a55d1b0476f89fab85543.jpg', '2022-02-11 16:25:43', 1, 1),
(1560, '15D2C4', 'Aceite Castrol Essential 4T 20W-50', 1, 189.29, 230.00, 5.00, 'img_cc0f017a87be402fae0d8837ef3926d0.jpg', '2022-02-11 16:26:49', 1, 1),
(2011, '1349', 'LUBRICANTE DE CADENA LIQUI MOLI', 1, 305.00, 360.00, 3.00, 'img_producto.png', '2022-07-08 18:54:38', 1, 1),
(2012, 'ACEITE HIDRAULICO RO', '1350', 1, 110.00, 135.00, 0.50, 'img_producto.png', '2022-07-08 18:55:49', 1, 1),
(2087, '1351', 'Aceite 2 tiempo', 1, 0.00, 300.00, 0.00, 'img_producto.png', '2022-09-15 15:04:09', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `codproveedor` int(11) NOT NULL,
  `proveedor` varchar(100) DEFAULT NULL,
  `contacto` varchar(100) DEFAULT NULL,
  `telefono` bigint(11) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT 1,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`codproveedor`, `proveedor`, `contacto`, `telefono`, `direccion`, `date_add`, `status`, `usuario_id`) VALUES
(1, 'Mercado', 'Mercado', 99999999, 'Managua', '2021-09-21 15:52:42', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` int(11) NOT NULL,
  `rol` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `rol`) VALUES
(1, 'Administrador'),
(2, 'Supervisor'),
(3, 'Vendedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `usuario` varchar(15) DEFAULT NULL,
  `clave` varchar(100) DEFAULT NULL,
  `rol` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `correo`, `usuario`, `clave`, `rol`, `status`) VALUES
(1, 'Admin', 'admin@gmail.com', 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `noventa` bigint(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario` int(11) DEFAULT NULL,
  `caja` int(11) NOT NULL,
  `codcliente` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `totalventa` decimal(10,2) NOT NULL,
  `descuento` decimal(10,2) NOT NULL,
  `abono` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`noventa`, `fecha`, `usuario`, `caja`, `codcliente`, `status`, `totalventa`, `descuento`, `abono`) VALUES
(1188, '2025-04-16 19:53:09', 1, 161, 1, 2, 13.00, 0.00, 0.00),
(1189, '2025-04-16 19:59:09', 1, 161, 1, 1, 435.00, 0.00, 0.00),
(1190, '2025-04-18 20:26:58', 1, 161, 1, 1, 235.00, 0.00, 0.00),
(1191, '2025-04-21 01:35:15', 1, 161, 1, 1, 300.00, 0.00, 0.00),
(1192, '2025-04-21 04:36:01', 1, 161, 1, 1, 202.50, 0.00, 0.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario` (`usuario`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`nocompra`),
  ADD KEY `usuario` (`usuario`),
  ADD KEY `codproveedor` (`codproveedor`),
  ADD KEY `caja` (`caja`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalleventa`
--
ALTER TABLE `detalleventa`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `codproducto` (`codproducto`),
  ADD KEY `noventa` (`noventa`);

--
-- Indices de la tabla `detalle_recibo`
--
ALTER TABLE `detalle_recibo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `noventa` (`noventa`),
  ADD KEY `usuario` (`usuario`),
  ADD KEY `caja` (`caja`);

--
-- Indices de la tabla `detalle_recibo_compra`
--
ALTER TABLE `detalle_recibo_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nocompra` (`nocompra`),
  ADD KEY `usuario` (`usuario`),
  ADD KEY `caja` (`caja`);

--
-- Indices de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `codproducto` (`codproducto`),
  ADD KEY `token_user` (`token_user`);

--
-- Indices de la tabla `detalle_temp_compra`
--
ALTER TABLE `detalle_temp_compra`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `token_user` (`token_user`),
  ADD KEY `codproducto` (`codproducto`);

--
-- Indices de la tabla `egresos`
--
ALTER TABLE `egresos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `caja` (`caja`);

--
-- Indices de la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `codproducto` (`codproducto`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `nocompra` (`nocompra`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`codproducto`),
  ADD KEY `proveedor` (`proveedor`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`codproveedor`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD KEY `rol` (`rol`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`noventa`),
  ADD KEY `usuario` (`usuario`),
  ADD KEY `codcliente` (`codcliente`),
  ADD KEY `caja` (`caja`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `nocompra` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalleventa`
--
ALTER TABLE `detalleventa`
  MODIFY `correlativo` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1549;

--
-- AUTO_INCREMENT de la tabla `detalle_recibo`
--
ALTER TABLE `detalle_recibo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de la tabla `detalle_recibo_compra`
--
ALTER TABLE `detalle_recibo_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2109;

--
-- AUTO_INCREMENT de la tabla `detalle_temp_compra`
--
ALTER TABLE `detalle_temp_compra`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT de la tabla `egresos`
--
ALTER TABLE `egresos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT de la tabla `entradas`
--
ALTER TABLE `entradas`
  MODIFY `correlativo` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=898;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `codproducto` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2088;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `codproveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `noventa` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1193;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `caja`
--
ALTER TABLE `caja`
  ADD CONSTRAINT `caja_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`codproveedor`) REFERENCES `proveedor` (`codproveedor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compras_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compras_ibfk_3` FOREIGN KEY (`caja`) REFERENCES `caja` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalleventa`
--
ALTER TABLE `detalleventa`
  ADD CONSTRAINT `detalleventa_ibfk_1` FOREIGN KEY (`noventa`) REFERENCES `venta` (`noventa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalleventa_ibfk_2` FOREIGN KEY (`codproducto`) REFERENCES `producto` (`codproducto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_recibo`
--
ALTER TABLE `detalle_recibo`
  ADD CONSTRAINT `detalle_recibo_ibfk_1` FOREIGN KEY (`noventa`) REFERENCES `venta` (`noventa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_recibo_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_recibo_ibfk_3` FOREIGN KEY (`caja`) REFERENCES `caja` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_recibo_compra`
--
ALTER TABLE `detalle_recibo_compra`
  ADD CONSTRAINT `detalle_recibo_compra_ibfk_1` FOREIGN KEY (`nocompra`) REFERENCES `compras` (`nocompra`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_recibo_compra_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_recibo_compra_ibfk_3` FOREIGN KEY (`caja`) REFERENCES `caja` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD CONSTRAINT `detalle_temp_ibfk_1` FOREIGN KEY (`codproducto`) REFERENCES `producto` (`codproducto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `egresos`
--
ALTER TABLE `egresos`
  ADD CONSTRAINT `egresos_ibfk_1` FOREIGN KEY (`caja`) REFERENCES `caja` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD CONSTRAINT `entradas_ibfk_2` FOREIGN KEY (`codproducto`) REFERENCES `producto` (`codproducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `entradas_ibfk_3` FOREIGN KEY (`nocompra`) REFERENCES `compras` (`nocompra`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`proveedor`) REFERENCES `proveedor` (`codproveedor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `proveedor_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `rol` (`idrol`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_ibfk_2` FOREIGN KEY (`codcliente`) REFERENCES `cliente` (`idcliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_ibfk_3` FOREIGN KEY (`caja`) REFERENCES `caja` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
