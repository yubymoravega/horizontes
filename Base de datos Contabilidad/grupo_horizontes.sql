-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2020 at 05:08 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grupo_horizontes`
--

-- --------------------------------------------------------

--
-- Table structure for table `activo_fijo`
--

CREATE TABLE `activo_fijo` (
  `id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `id_grupo_activo_id` int(11) NOT NULL,
  `id_tipo_movimiento_baja_id` int(11) DEFAULT NULL,
  `nro_inventario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor_inicial` double NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_alta` date NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `fecha_baja` date DEFAULT NULL,
  `pais` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_tipo_movimiento_id` int(11) DEFAULT NULL,
  `id_area_responsabilidad_id` int(11) NOT NULL,
  `nro_consecutivo` int(11) NOT NULL,
  `nro_documento_baja` int(11) DEFAULT NULL,
  `depreciacion_acumulada` double DEFAULT NULL,
  `valor_real` double DEFAULT NULL,
  `annos_vida_util` double NOT NULL,
  `modelo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marca` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nro_motor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nro_serie` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nro_chapa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nro_chasis` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `combustible` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_ultima_depreciacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `activo_fijo_cuentas`
--

CREATE TABLE `activo_fijo_cuentas` (
  `id` int(11) NOT NULL,
  `id_activo_id` int(11) NOT NULL,
  `id_cuenta_activo_id` int(11) NOT NULL,
  `id_subcuenta_activo_id` int(11) NOT NULL,
  `id_centro_costo_activo_id` int(11) NOT NULL,
  `id_area_responsabilidad_activo_id` int(11) NOT NULL,
  `id_cuenta_depreciacion_id` int(11) NOT NULL,
  `id_subcuenta_depreciacion_id` int(11) NOT NULL,
  `id_cuenta_gasto_id` int(11) NOT NULL,
  `id_subcuenta_gasto_id` int(11) NOT NULL,
  `id_centro_costo_gasto_id` int(11) NOT NULL,
  `id_elemento_gasto_gasto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `activo_fijo_movimiento_activo_fijo`
--

CREATE TABLE `activo_fijo_movimiento_activo_fijo` (
  `id` int(11) NOT NULL,
  `id_activo_fijo_id` int(11) NOT NULL,
  `id_movimiento_activo_fijo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ajuste`
--

CREATE TABLE `ajuste` (
  `id` int(11) NOT NULL,
  `id_documento_id` int(11) NOT NULL,
  `nro_cuenta_inventario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `observacion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_subcuenta_inventario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_cuenta_acreedora` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_concecutivo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anno` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `entrada` tinyint(1) NOT NULL,
  `nro_subcuenta_acreedora` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ajuste`
--

INSERT INTO `ajuste` (`id`, `id_documento_id`, `nro_cuenta_inventario`, `observacion`, `nro_subcuenta_inventario`, `nro_cuenta_acreedora`, `nro_concecutivo`, `anno`, `activo`, `entrada`, `nro_subcuenta_acreedora`) VALUES
(5, 64, '696', 'Reunificando codigos en el alamcen por productos de igual embalaje', '0099', '', '1', 2020, 1, 0, ''),
(6, 65, '', 'Contabilizando unificacion de codigos de productos de igual embalaje', '', '697', '1', 2020, 1, 1, '0099'),
(7, 72, '696', 'Cambiando los productos que entraron a la cuenta 183  de materias primas para la cuenta 189 Mercancias para la Venta', '0099', '', '1', 2020, 1, 0, ''),
(8, 73, '', 'REGISTRANDO  SOBRANTE EN CONTEO FISICO', '', '332', '2', 2020, 1, 1, '0020'),
(9, 74, '332', 'REgistrando faltante detectado en conteo fisico al almacen', '0020', '', '2', 2020, 1, 0, ''),
(10, 75, '', 'Cambio de cuenta contable', '', '697', '1', 2020, 1, 1, '0099'),
(11, 76, '696', 'Rectificando código del producto', '0099', '', '2', 2020, 1, 0, ''),
(12, 77, '696', 'Ajustando cuentas', '0099', '', '3', 2020, 1, 0, ''),
(13, 78, '', 'Ajustando cuentas', '', '697', '2', 2020, 1, 1, '0099');

-- --------------------------------------------------------

--
-- Table structure for table `almacen`
--

CREATE TABLE `almacen` (
  `id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `almacen`
--

INSERT INTO `almacen` (`id`, `id_unidad_id`, `descripcion`, `activo`, `codigo`) VALUES
(1, 1, 'Almacen de Matriales y Mercancias', 1, '01'),
(2, 1, 'Almacen Mercancias para la Venta', 1, '02'),
(3, 1, 'Almacen de Productos Terminados', 1, '03');

-- --------------------------------------------------------

--
-- Table structure for table `almacen_ocupado`
--

CREATE TABLE `almacen_ocupado` (
  `id` int(11) NOT NULL,
  `id_almacen_id` int(11) NOT NULL,
  `id_usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `almacen_ocupado`
--

INSERT INTO `almacen_ocupado` (`id`, `id_almacen_id`, `id_usuario_id`) VALUES
(138, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `area_responsabilidad`
--

CREATE TABLE `area_responsabilidad` (
  `id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cargo`
--

CREATE TABLE `cargo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salario_base` double NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cargo`
--

INSERT INTO `cargo` (`id`, `nombre`, `salario_base`, `activo`) VALUES
(1, 'Administrador del Sistema', 1000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `carrito`
--

CREATE TABLE `carrito` (
  `id` int(11) NOT NULL,
  `json` varchar(1500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empleado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `centro_costo`
--

CREATE TABLE `centro_costo` (
  `id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `centro_costo`
--

INSERT INTO `centro_costo` (`id`, `id_unidad_id`, `activo`, `codigo`, `nombre`) VALUES
(1, 1, 1, '01', 'Recargas'),
(2, 1, 1, '02', 'Combo de Aseo'),
(3, 1, 1, '03', 'Combo de Medicina'),
(4, 1, 1, '04', 'Combo de Comida'),
(5, 1, 1, '05', 'Articulos de Ferreteria'),
(6, 1, 1, '06', 'Direccion de la Unidad'),
(7, 1, 1, '07', 'Produccion y Venta');

-- --------------------------------------------------------

--
-- Table structure for table `cierre`
--

CREATE TABLE `cierre` (
  `id` int(11) NOT NULL,
  `id_almacen_id` int(11) NOT NULL,
  `id_usuario_id` int(11) DEFAULT NULL,
  `diario` tinyint(1) NOT NULL,
  `mes` int(11) DEFAULT NULL,
  `anno` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `saldo` double NOT NULL,
  `abierto` tinyint(1) DEFAULT NULL,
  `debito` double NOT NULL,
  `credito` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cierre`
--

INSERT INTO `cierre` (`id`, `id_almacen_id`, `id_usuario_id`, `diario`, `mes`, `anno`, `fecha`, `saldo`, `abierto`, `debito`, `credito`) VALUES
(17, 1, 1, 1, 10, 2020, '2020-10-20', 6353.89, 0, 7312.19, 958.3),
(18, 1, 1, 1, 10, 2020, '2020-10-21', 6353.89, 0, 95.21, 2168.97),
(20, 1, 1, 1, 10, 2020, '2020-10-22', 4280.13, 0, 0, 0),
(21, 2, 1, 1, 10, 2020, '2020-10-21', 0, 0, 2073.76, 0),
(22, 2, 1, 1, 10, 2020, '2020-10-22', 2073.76, 0, 0, 0),
(23, 2, 1, 1, 11, 2020, '2020-10-23', 2073.76, 0, 44647.52, 4147.52),
(24, 1, 1, 1, 11, 2020, '2020-10-23', 4280.13, 0, 580.56, 32.88),
(27, 2, 1, 1, 11, 2020, '2020-10-24', 42573.76, 1, 0, 0),
(28, 1, 1, 1, 10, 2020, '2020-10-25', 4827.81, 1, 0, 0),
(29, 3, 1, 1, 11, 2020, '2020-10-23', 0, 0, 378.26, 0),
(30, 3, 1, 1, 11, 2020, '2020-10-25', 378.26, 0, 1325, 0),
(31, 3, 1, 1, 11, 2020, '2020-10-26', 1703.26, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cierre_diario`
--

CREATE TABLE `cierre_diario` (
  `id` int(11) NOT NULL,
  `id_almacen_id` int(11) NOT NULL,
  `id_usuario_id` int(11) NOT NULL,
  `fecha_cerrado` date NOT NULL,
  `fecha_cerrado_real` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  `comentario` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cliente_beneficiario`
--

CREATE TABLE `cliente_beneficiario` (
  `id` int(11) NOT NULL,
  `id_cliente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `primer_nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono_casa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `primer_apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `segundo_apellido` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternativo_nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternativo_apellido` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternativo_segundo_apellido` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `identificacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `calle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `y` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edificio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reparto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provincia` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `municipio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cliente_contabilidad`
--

CREATE TABLE `cliente_contabilidad` (
  `id` int(11) NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefonos` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correos` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cliente_contabilidad`
--

INSERT INTO `cliente_contabilidad` (`id`, `codigo`, `nombre`, `direccion`, `telefonos`, `fax`, `correos`, `activo`) VALUES
(1, '1123', 'sdffdsfds', 'dsadasdsa', '444444-55555-5555', NULL, 'aaa@aa.aa', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cliente_reporte`
--

CREATE TABLE `cliente_reporte` (
  `id` int(11) NOT NULL,
  `user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `id_cliente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bram` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last4` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `monto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comercio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auth` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `efectivo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comprobante_cierre`
--

CREATE TABLE `comprobante_cierre` (
  `id` int(11) NOT NULL,
  `id_comprobante_id` int(11) NOT NULL,
  `id_cierre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comprobante_cierre`
--

INSERT INTO `comprobante_cierre` (`id`, `id_comprobante_id`, `id_cierre_id`) VALUES
(1, 3, 21),
(2, 3, 22),
(3, 3, 23),
(4, 4, 17),
(5, 4, 18),
(6, 4, 20),
(7, 4, 24),
(8, 5, 29),
(9, 5, 30);

-- --------------------------------------------------------

--
-- Table structure for table `configuracion_inicial`
--

CREATE TABLE `configuracion_inicial` (
  `id` int(11) NOT NULL,
  `id_modulo_id` int(11) NOT NULL,
  `id_tipo_documento_id` int(11) NOT NULL,
  `deudora` tinyint(1) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `str_cuentas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `str_subcuentas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `str_elemento_gasto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `str_cuentas_contrapartida` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `str_subcuentas_contrapartida` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contratos_cliente`
--

CREATE TABLE `contratos_cliente` (
  `id` int(11) NOT NULL,
  `id_cliente_id` int(11) NOT NULL,
  `id_moneda_id` int(11) NOT NULL,
  `nro_contrato` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anno` int(11) NOT NULL,
  `fecha_aprobado` date NOT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `activo` tinyint(1) NOT NULL,
  `importe` double NOT NULL,
  `resto` double DEFAULT NULL,
  `id_padre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `criterio_analisis`
--

CREATE TABLE `criterio_analisis` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abreviatura` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `criterio_analisis`
--

INSERT INTO `criterio_analisis` (`id`, `nombre`, `abreviatura`, `activo`) VALUES
(1, 'ALMACéN', 'ALM', 1),
(2, 'UNIDADES', 'UNID', 1),
(3, 'CENTROS DE COSTO', 'CCT', 1),
(4, 'OBJETOS DE OBRAS', 'OBO', 1),
(5, 'ELEMENTOS DE GASTOS', 'EG', 1),
(6, 'CLIENTES Y PROVEEDORES', 'CLIPRO', 1),
(7, 'TARJETAS MAGNETICAS', 'TM', 1),
(8, 'TRABAJADORES', 'TRAB', 1),
(9, 'PROYECTOS', 'PRO', 1),
(10, 'ORDEN DE TRABAJO', 'OT', 1),
(11, 'EXPEDIENTE', 'EXP', 1),
(12, 'AREAS DE RESPONSABILIDAD', 'AR', 1),
(13, 'GRUPOS DE ACTIVOS FIJOS', 'GA', 1),
(14, 'CREDITOS  BANCARIOS', 'CRB', 1),
(15, 'ACCIONISTAS', 'ACC', 1),
(16, 'CUENTAS DE INGRESOS', 'ING', 1),
(17, 'CUENTAS DE GASTOS', 'GAT', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cuadre_diario`
--

CREATE TABLE `cuadre_diario` (
  `id` int(11) NOT NULL,
  `id_cuenta_id` int(11) NOT NULL,
  `id_subcuenta_id` int(11) NOT NULL,
  `id_cierre_id` int(11) NOT NULL,
  `id_almacen_id` int(11) NOT NULL,
  `str_analisis` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` date NOT NULL,
  `saldo` decimal(10,2) NOT NULL,
  `debito` double NOT NULL,
  `credito` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cuadre_diario`
--

INSERT INTO `cuadre_diario` (`id`, `id_cuenta_id`, `id_subcuenta_id`, `id_cierre_id`, `id_almacen_id`, `str_analisis`, `fecha`, `saldo`, `debito`, `credito`) VALUES
(4, 10, 65, 17, 1, '01', '2020-10-20', '0.00', 367.41, 44.35),
(5, 10, 66, 17, 1, '01', '2020-10-20', '0.00', 175.03, 40.05),
(6, 10, 67, 17, 1, '01', '2020-10-20', '0.00', 6769.75, 873.9),
(7, 10, 65, 18, 1, '01', '2020-10-21', '323.06', 91.25, 143.41),
(8, 10, 66, 18, 1, '01', '2020-10-21', '134.98', 3.96, 14.36),
(9, 10, 67, 18, 1, '01', '2020-10-21', '5895.85', 0, 2011.2),
(10, 10, 65, 21, 2, '02', '2020-10-21', '0.00', 52.16, 0),
(11, 10, 66, 21, 2, '02', '2020-10-21', '0.00', 10.4, 0),
(12, 10, 67, 21, 2, '02', '2020-10-21', '0.00', 2011.2, 0),
(25, 10, 65, 23, 2, '02', '2020-10-23', '52.16', 52.16, 104.32),
(26, 10, 66, 23, 2, '02', '2020-10-23', '10.40', 10.4, 20.8),
(27, 10, 67, 23, 2, '02', '2020-10-23', '2011.20', 204, 2215.2),
(28, 15, 59, 23, 2, '02', '2020-10-23', '0.00', 10500, 0),
(29, 15, 60, 23, 2, '02', '2020-10-23', '0.00', 52.16, 0),
(30, 15, 61, 23, 2, '02', '2020-10-23', '0.00', 10.4, 0),
(31, 15, 62, 23, 2, '02', '2020-10-23', '0.00', 33818.4, 1807.2),
(32, 10, 65, 24, 1, '01', '2020-10-23', '270.90', 0, 8.29),
(33, 10, 66, 24, 1, '01', '2020-10-23', '124.58', 18.77, 2.95),
(34, 10, 67, 24, 1, '01', '2020-10-23', '3884.65', 561.79, 21.64),
(35, 14, 4, 29, 3, '03', '2020-10-23', '0.00', 378.26, 0),
(36, 14, 4, 30, 3, '03', '2020-10-25', '378.26', 1325, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cuenta`
--

CREATE TABLE `cuenta` (
  `id` int(11) NOT NULL,
  `id_tipo_cuenta_id` int(11) NOT NULL,
  `nro_cuenta` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deudora` tinyint(1) NOT NULL,
  `obligacion_deudora` tinyint(1) NOT NULL,
  `obligacion_acreedora` tinyint(1) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `produccion` tinyint(1) NOT NULL,
  `mixta` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cuenta`
--

INSERT INTO `cuenta` (`id`, `id_tipo_cuenta_id`, `nro_cuenta`, `nombre`, `deudora`, `obligacion_deudora`, `obligacion_acreedora`, `activo`, `produccion`, `mixta`) VALUES
(1, 1, 103, 'Efectivo en Caja', 1, 0, 0, 1, 0, 0),
(2, 1, 109, 'Efectivo en Banco', 1, 0, 0, 1, 0, 0),
(3, 1, 131, 'Efectos por Cobrar a Corto Plazo', 1, 1, 0, 1, 0, 0),
(4, 1, 134, 'Cuenta en Participacion', 1, 1, 0, 1, 0, 0),
(5, 1, 142, 'Prestamos y Otras Operaciones Crediticias', 1, 0, 0, 1, 0, 0),
(6, 1, 146, 'Pagos Anticipados a Suministradores', 1, 0, 0, 1, 0, 0),
(7, 1, 160, 'Anticipos a Justificar', 1, 0, 0, 1, 0, 0),
(8, 1, 135, 'Cuentas por Cobrar', 1, 1, 0, 1, 0, 0),
(9, 1, 164, 'Adeudos con el  Estado', 1, 0, 0, 1, 0, 0),
(10, 1, 183, 'Materias Primas y Materiales', 1, 0, 0, 1, 0, 0),
(11, 1, 184, 'Combustible  Lubricantes', 1, 0, 0, 1, 0, 0),
(12, 1, 185, 'Partes  y  Piezas de  Repuesto', 1, 0, 0, 1, 0, 0),
(13, 1, 187, 'Utiles y Herramientas', 1, 0, 0, 1, 0, 0),
(14, 1, 188, 'Produccion Terminada', 1, 0, 0, 1, 0, 0),
(15, 1, 189, 'Mercancias para la Venta', 1, 0, 0, 1, 0, 0),
(16, 1, 190, 'Medicamentos', 1, 0, 0, 1, 0, 0),
(17, 1, 193, 'Alimentos', 1, 0, 0, 1, 0, 0),
(18, 2, 216, 'Efectos por Cobrar a Largo Plazo', 1, 1, 0, 1, 0, 0),
(19, 2, 220, 'Cuentas por Cobrar a Largo Plazo', 1, 1, 0, 1, 0, 0),
(20, 2, 225, 'Prestamos Concedidos a Largo Plazo', 1, 1, 0, 1, 0, 0),
(21, 2, 227, 'Inversiones a Largo Plazo', 1, 0, 0, 1, 0, 0),
(22, 3, 240, 'Activos Fijos', 1, 0, 0, 1, 0, 0),
(23, 3, 255, 'Activos Fijos Intangibles', 1, 0, 0, 1, 0, 0),
(24, 3, 265, 'Inversiones en Proceso', 1, 0, 0, 1, 0, 0),
(25, 3, 290, 'Compra de Activos Fijos', 1, 1, 0, 1, 0, 0),
(26, 3, 292, 'Compra de Activos Fijos Intangibles', 1, 1, 0, 1, 0, 0),
(27, 4, 300, 'Gastos de Produccion y Servicios Diferidos', 1, 0, 0, 1, 0, 0),
(28, 4, 306, 'Gastos Financieros Diferidos', 1, 0, 0, 1, 0, 0),
(29, 5, 330, 'Perdida en Investigacion', 1, 0, 0, 1, 0, 0),
(30, 5, 332, 'Faltantes de Bienes', 1, 0, 0, 1, 0, 0),
(31, 2, 335, 'Cuentas por Cobrar Diversas', 1, 1, 0, 1, 0, 0),
(32, 6, 373, 'Desgaste de Utiles y Herramientas', 0, 0, 0, 1, 0, 0),
(33, 6, 375, 'Depreciacion de Activos Fijos Tangibles', 0, 0, 0, 1, 0, 0),
(34, 6, 390, 'Amortizacion de Activos Fijos Intangibles', 0, 0, 0, 1, 0, 0),
(35, 7, 401, 'Efectos por pagar a Corto Plazo', 0, 0, 1, 1, 0, 0),
(36, 7, 405, 'Cuentas por pagar a Corto Plazo', 0, 0, 1, 1, 0, 0),
(37, 7, 421, 'Cuentas por Pagar - Activos Fijos', 0, 0, 1, 1, 0, 0),
(38, 7, 425, 'Cuentas por Pagar del Proceso Inversionista', 0, 0, 1, 1, 0, 0),
(39, 7, 430, 'Cobros Anticipados', 0, 0, 1, 1, 0, 0),
(40, 7, 435, 'Depositos Recibidos', 0, 0, 1, 1, 0, 0),
(41, 7, 440, 'Obligacion con el Estado', 0, 0, 1, 1, 0, 0),
(42, 7, 455, 'Nominas por Pagar', 0, 0, 0, 1, 0, 0),
(43, 7, 470, 'Prestamos Recibidos', 0, 0, 1, 1, 0, 0),
(44, 7, 492, 'Provision para Vacaciones', 0, 0, 0, 1, 0, 0),
(45, 8, 510, 'Efectos por pagar a largo plazo', 0, 0, 1, 1, 0, 0),
(46, 8, 515, 'Cuentas por Pagar a Largo Plazo', 0, 0, 1, 1, 0, 0),
(47, 8, 520, 'Prestamos Recibidos a Largo Plazo', 0, 0, 1, 1, 0, 0),
(48, 8, 540, 'Bonos por Pagar', 0, 0, 1, 1, 0, 0),
(49, 9, 545, 'Ingresos Diferidos', 0, 0, 0, 1, 0, 0),
(50, 10, 555, 'Sobrantes en Investigacion', 0, 0, 0, 1, 0, 0),
(51, 10, 565, 'Cuentas por Pagar Diversas', 0, 0, 0, 1, 0, 0),
(52, 10, 569, 'Cuentas por Pagar Compra de Monedas', 0, 0, 0, 1, 0, 0),
(53, 10, 570, 'Ingresos de Periodos Futuros', 0, 0, 0, 1, 0, 0),
(54, 11, 600, 'Patrimonio', 0, 0, 0, 1, 0, 0),
(55, 11, 605, 'Acciones por Emitir', 1, 0, 0, 1, 0, 0),
(56, 11, 608, 'Acciones Suscritas', 0, 0, 0, 1, 0, 0),
(57, 11, 615, 'Revalorizacion de Activos Fijos Tangibles', 1, 0, 0, 1, 0, 0),
(58, 11, 620, 'Donaciones Recibidas', 0, 0, 0, 1, 0, 0),
(59, 11, 630, 'Utilidades Retenidas', 0, 0, 0, 1, 0, 0),
(60, 11, 640, 'Perdidas', 1, 0, 0, 1, 0, 0),
(61, 11, 696, 'Operaciones entre Dependencias Activos', 1, 0, 0, 1, 0, 0),
(62, 11, 697, 'Operaciones entre Dependencia Pasivo', 0, 0, 0, 1, 0, 0),
(63, 2, 700, 'Producciones en Proceso', 1, 0, 0, 1, 1, 0),
(64, 12, 730, 'Reparaciones Capitales con Medios Propios', 1, 0, 0, 1, 0, 0),
(65, 13, 800, 'Devoluciones en Ventas', 1, 0, 0, 1, 0, 0),
(66, 13, 806, 'Impuestos por las Ventas', 1, 0, 0, 1, 0, 0),
(67, 2, 810, 'Costo de Ventas de Produccion', 1, 0, 0, 1, 0, 0),
(68, 13, 815, 'Costo de Ventas de Mercancias', 1, 0, 0, 1, 0, 0),
(69, 13, 823, 'Gastos de Administracion', 1, 0, 0, 1, 0, 0),
(70, 13, 819, 'Gastos de Distribucion y Ventas', 1, 0, 0, 1, 0, 0),
(71, 13, 839, 'Gastos por Perdidas en Tasas de Cambio', 1, 0, 0, 1, 0, 0),
(72, 13, 845, 'Gastos por Perdidas', 1, 0, 0, 1, 0, 0),
(73, 13, 850, 'Gastos por Faltantes', 1, 0, 0, 1, 0, 0),
(74, 13, 855, 'Otros Impuestos y Contribuciones', 1, 0, 0, 1, 0, 0),
(75, 14, 901, 'Ventas de Mercancias', 0, 0, 0, 1, 0, 0),
(76, 14, 900, 'Ventas de Produccion', 0, 0, 0, 1, 0, 0),
(77, 14, 920, 'Ingresos Financieros', 0, 0, 0, 1, 0, 0),
(78, 14, 924, 'Ingresos por Variacion de Tasas de Cambio', 0, 0, 0, 1, 0, 0),
(79, 14, 930, 'Ingresos por Sobrantes de Bienes', 0, 0, 0, 1, 0, 0),
(80, 14, 950, 'Otros Ingresos', 0, 0, 0, 1, 0, 0),
(81, 14, 953, 'Ingresos por Donaciones Recibidas', 0, 0, 0, 1, 0, 0),
(82, 15, 999, 'Resultados', 0, 0, 0, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cuentas_cliente`
--

CREATE TABLE `cuentas_cliente` (
  `id` int(11) NOT NULL,
  `id_moneda_id` int(11) NOT NULL,
  `id_cliente_id` int(11) NOT NULL,
  `nro_cuenta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cuentas_cliente`
--

INSERT INTO `cuentas_cliente` (`id`, `id_moneda_id`, `id_cliente_id`, `nro_cuenta`, `activo`) VALUES
(1, 1, 1, 'fdsfsdfds', 1),
(2, 2, 1, 'dfsdfdsfd', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cuenta_criterio_analisis`
--

CREATE TABLE `cuenta_criterio_analisis` (
  `id` int(11) NOT NULL,
  `id_cuenta_id` int(11) NOT NULL,
  `id_criterio_analisis_id` int(11) NOT NULL,
  `orden` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cuenta_criterio_analisis`
--

INSERT INTO `cuenta_criterio_analisis` (`id`, `id_cuenta_id`, `id_criterio_analisis_id`, `orden`) VALUES
(10, 3, 6, NULL),
(11, 5, 14, NULL),
(13, 6, 6, NULL),
(14, 4, 15, NULL),
(15, 7, 8, NULL),
(16, 8, 6, NULL),
(18, 10, 1, NULL),
(19, 11, 1, NULL),
(21, 13, 1, NULL),
(23, 12, 1, NULL),
(26, 14, 1, NULL),
(28, 16, 1, NULL),
(29, 17, 1, NULL),
(30, 18, 6, NULL),
(31, 19, 6, NULL),
(32, 20, 6, NULL),
(33, 21, 4, NULL),
(36, 23, 2, NULL),
(37, 24, 4, NULL),
(38, 25, 6, NULL),
(39, 26, 6, NULL),
(43, 35, 6, NULL),
(48, 38, 6, NULL),
(51, 36, 6, NULL),
(52, 37, 6, NULL),
(54, 39, 6, NULL),
(55, 40, 6, NULL),
(57, 43, 6, NULL),
(58, 44, 8, NULL),
(59, 45, 6, NULL),
(60, 46, 6, NULL),
(65, 48, 6, NULL),
(66, 50, 11, NULL),
(67, 51, 6, NULL),
(68, 52, 6, NULL),
(69, 55, 15, NULL),
(74, 15, 1, NULL),
(79, 27, 5, NULL),
(80, 28, 11, NULL),
(81, 29, 11, NULL),
(82, 30, 11, NULL),
(83, 31, 6, NULL),
(84, 31, 8, NULL),
(85, 56, 15, NULL),
(96, 64, 4, NULL),
(97, 64, 5, NULL),
(134, 22, 13, 1),
(135, 22, 12, 2),
(136, 61, 2, 1),
(137, 61, 1, 2),
(138, 63, 3, 1),
(139, 63, 10, 2),
(140, 63, 5, 3),
(141, 62, 2, 1),
(142, 62, 1, 2),
(143, 67, 3, 1),
(148, 70, 3, 1),
(149, 70, 5, 2),
(151, 69, 5, 1),
(153, 76, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `custom_user`
--

CREATE TABLE `custom_user` (
  `id` int(11) NOT NULL,
  `id_user_id` int(11) NOT NULL,
  `nombre_completo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `depreciacion`
--

CREATE TABLE `depreciacion` (
  `id` int(11) NOT NULL,
  `id_activo_fijo_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `anno` int(11) NOT NULL,
  `mes` int(11) NOT NULL,
  `importe_depreciacion` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `devolucion`
--

CREATE TABLE `devolucion` (
  `id` int(11) NOT NULL,
  `id_documento_id` int(11) DEFAULT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `id_almacen_id` int(11) NOT NULL,
  `nro_cuenta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_subcuenta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anno` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `nro_concecutivo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_centro_costo_id` int(11) DEFAULT NULL,
  `id_elemento_gasto_id` int(11) DEFAULT NULL,
  `id_orden_tabajo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `devolucion`
--

INSERT INTO `devolucion` (`id`, `id_documento_id`, `id_unidad_id`, `id_almacen_id`, `nro_cuenta`, `nro_subcuenta`, `anno`, `activo`, `nro_concecutivo`, `id_centro_costo_id`, `id_elemento_gasto_id`, `id_orden_tabajo_id`) VALUES
(3, 81, 1, 1, '700', '0020', 2020, 1, '1', 4, 3, 2),
(4, 82, 1, 1, '700', '0020', 2020, 1, '2', 3, 7, 6);

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20201108220959', '2020-11-08 23:10:19', 2306);

-- --------------------------------------------------------

--
-- Table structure for table `documento`
--

CREATE TABLE `documento` (
  `id` int(11) NOT NULL,
  `id_almacen_id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `id_moneda_id` int(11) NOT NULL,
  `importe_total` double NOT NULL,
  `fecha` date NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `id_tipo_documento_id` int(11) DEFAULT NULL,
  `anno` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documento`
--

INSERT INTO `documento` (`id`, `id_almacen_id`, `id_unidad_id`, `id_moneda_id`, `importe_total`, `fecha`, `activo`, `id_tipo_documento_id`, `anno`) VALUES
(52, 1, 1, 1, 238.91, '2020-10-20', 1, 1, 2020),
(53, 1, 1, 1, 128.5, '2020-10-20', 1, 1, 2020),
(54, 1, 1, 1, 129.3, '2020-10-20', 1, 1, 2020),
(55, 1, 1, 1, 45.73, '2020-10-20', 1, 1, 2020),
(56, 1, 1, 1, 4399.35, '2020-10-20', 1, 1, 2020),
(57, 1, 1, 1, 2370.4, '2020-10-20', 1, 1, 2020),
(58, 1, 1, 1, 26.09, '2020-10-20', 1, 7, 2020),
(59, 1, 1, 1, 18.25, '2020-10-20', 1, 7, 2020),
(60, 1, 1, 1, 312.11, '2020-10-20', 1, 7, 2020),
(61, 1, 1, 1, 18.26, '2020-10-20', 1, 7, 2020),
(62, 1, 1, 1, 21.8, '2020-10-20', 1, 7, 2020),
(63, 1, 1, 1, 561.79, '2020-10-20', 1, 7, 2020),
(64, 1, 1, 1, 95.21, '2020-10-21', 1, 4, 2020),
(65, 1, 1, 1, 95.21, '2020-10-21', 1, 3, 2020),
(66, 1, 1, 1, 2073.76, '2020-10-21', 1, 6, 2020),
(67, 2, 1, 1, 2073.76, '2020-10-21', 1, 5, 2020),
(68, 2, 1, 1, 30000, '2020-10-23', 1, 1, 2020),
(69, 2, 1, 1, 3000, '2020-10-23', 1, 1, 2020),
(70, 2, 1, 1, 6000, '2020-10-23', 1, 1, 2020),
(71, 2, 1, 1, 1500, '2020-10-23', 1, 1, 2020),
(72, 2, 1, 1, 2073.76, '2020-10-23', 1, 4, 2020),
(73, 1, 1, 1, 0.52, '2020-10-23', 1, 3, 2020),
(74, 1, 1, 1, 2.85, '2020-10-23', 1, 4, 2020),
(75, 2, 1, 1, 2073.76, '2020-10-23', 1, 3, 2020),
(76, 2, 1, 1, 1807.2, '2020-10-23', 1, 4, 2020),
(77, 2, 1, 1, 266.56, '2020-10-23', 1, 4, 2020),
(78, 2, 1, 1, 2073.76, '2020-10-23', 1, 3, 2020),
(81, 1, 1, 1, 18.25, '2020-10-23', 1, 9, 2020),
(82, 1, 1, 1, 561.79, '2020-10-23', 1, 9, 2020),
(83, 1, 1, 1, 30.03, '2020-10-23', 1, 7, 2020),
(84, 1, 1, 1, 83.59, '2020-10-25', 1, 7, 2020),
(85, 1, 1, 1, 1241.41, '2020-10-25', 1, 7, 2020),
(86, 3, 1, 1, 338.2, '2020-10-23', 1, 2, 2020),
(87, 3, 1, 1, 40.06, '2020-10-23', 1, 2, 2020),
(88, 3, 1, 1, 1048.86, '2020-10-25', 1, 2, 2020),
(89, 3, 1, 1, 276.14, '2020-10-25', 1, 2, 2020);

-- --------------------------------------------------------

--
-- Table structure for table `elemento_gasto`
--

CREATE TABLE `elemento_gasto` (
  `id` int(11) NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `elemento_gasto`
--

INSERT INTO `elemento_gasto` (`id`, `codigo`, `descripcion`, `activo`) VALUES
(1, '1001', 'Materiales de Oficina', 1),
(2, '1002', 'Materiales y Productos de Aseo', 1),
(3, '1003', 'Alimentos', 1),
(4, '1004', 'Materiales de Limpieza', 1),
(5, '1005', 'Desgaste de Utiles y Herramientas', 1),
(6, '1006', 'Piezas de Repuestos', 1),
(7, '1007', 'Otros Materiales', 1),
(8, '3001', 'Gasolina', 1),
(9, '3002', 'Diesel', 1),
(10, '3003', 'Grasas y Lubricantes', 1),
(11, '3004', 'Otros Combustibles', 1),
(12, '4001', 'Energia Electrica', 1),
(13, '5001', 'Salario', 1),
(14, '5002', 'Seguridad Social', 1),
(15, '5003', 'Vacaciones', 1),
(16, '6001', 'Impuestos Utilizacion Fuerza de Trabajo', 1),
(17, '7001', 'Depreciacion de Activos Fijos', 1),
(18, '7002', 'Amortizacion de Gastos Diferidos', 1),
(19, '8001', 'Servicios de Reparacion y Mantenimiento', 1),
(20, '8002', 'Servicios de Comunicaciones', 1),
(21, '8003', 'Servicios de Transportacion', 1),
(22, '8004', 'Viaticos', 1),
(23, '8005', 'Otros Servicios', 1),
(24, 'Traspasos de Gastos Indirectos', '9000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `empleado`
--

CREATE TABLE `empleado` (
  `id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `id_cargo_id` int(11) DEFAULT NULL,
  `id_usuario_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salario_x_hora` double DEFAULT NULL,
  `fecha_alta` date DEFAULT NULL,
  `baja` tinyint(1) NOT NULL,
  `fecha_baja` date DEFAULT NULL,
  `direccion_particular` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acumulado_tiempo_vacaciones` double DEFAULT NULL,
  `acumulado_dinero_vacaciones` double DEFAULT NULL,
  `rol` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `empleado`
--

INSERT INTO `empleado` (`id`, `id_unidad_id`, `id_cargo_id`, `id_usuario_id`, `nombre`, `correo`, `salario_x_hora`, `fecha_alta`, `baja`, `fecha_baja`, `direccion_particular`, `telefono`, `acumulado_tiempo_vacaciones`, `acumulado_dinero_vacaciones`, `rol`, `activo`) VALUES
(1, 1, 1, 1, 'root', 'admin@solyag.com', 100, '2020-10-28', 0, NULL, 'Calle A', '555555555', NULL, NULL, 'ROLE_ADMIN', 1);

-- --------------------------------------------------------

--
-- Table structure for table `expediente`
--

CREATE TABLE `expediente` (
  `id` int(11) NOT NULL,
  `id_unidad_id` int(11) DEFAULT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `anno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expediente`
--

INSERT INTO `expediente` (`id`, `id_unidad_id`, `codigo`, `descripcion`, `activo`, `anno`) VALUES
(1, 1, '01', 'Faltante de Shampu', 1, 2020);

-- --------------------------------------------------------

--
-- Table structure for table `factura`
--

CREATE TABLE `factura` (
  `id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `id_usuario_id` int(11) NOT NULL,
  `fecha_factura` date NOT NULL,
  `tipo_cliente` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `nro_factura` int(11) NOT NULL,
  `anno` int(11) NOT NULL,
  `id_contrato_id` int(11) NOT NULL,
  `cuenta_obligacion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subcuenta_obligacion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grupo_activos`
--

CREATE TABLE `grupo_activos` (
  `id` int(11) NOT NULL,
  `porciento_deprecia_anno` double NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `informe_recepcion`
--

CREATE TABLE `informe_recepcion` (
  `id` int(11) NOT NULL,
  `id_documento_id` int(11) NOT NULL,
  `id_proveedor_id` int(11) DEFAULT NULL,
  `nro_cuenta_inventario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_subcuenta_inventario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_cuenta_acreedora` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_subcuenta_acreedora` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_concecutivo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anno` int(11) NOT NULL,
  `codigo_factura` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_factura` date DEFAULT NULL,
  `activo` tinyint(1) NOT NULL,
  `producto` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `informe_recepcion`
--

INSERT INTO `informe_recepcion` (`id`, `id_documento_id`, `id_proveedor_id`, `nro_cuenta_inventario`, `nro_subcuenta_inventario`, `nro_cuenta_acreedora`, `nro_subcuenta_acreedora`, `nro_concecutivo`, `anno`, `codigo_factura`, `fecha_factura`, `activo`, `producto`) VALUES
(31, 52, 1, '', '', '405', '0010', '1', 2020, '25', '2020-10-20', 1, 0),
(32, 53, 2, '', '', '405', '0010', '2', 2020, '152', '2020-10-20', 1, 0),
(33, 54, 3, '', '', '405', '0010', '3', 2020, '68', '2020-10-01', 1, 0),
(34, 55, 4, '', '', '405', '0010', '4', 2020, '189', '2020-10-13', 1, 0),
(35, 56, 5, '', '', '405', '0010', '5', 2020, '1095', '2020-10-16', 1, 0),
(36, 57, 6, '', '', '405', '0010', '6', 2020, '20381', '2020-10-17', 1, 0),
(37, 68, 9, '', '', '405', '0010', '1', 2020, '31', '2020-10-02', 1, 0),
(38, 69, 7, '', '', '405', '0010', '2', 2020, '250', '2020-10-09', 1, 0),
(39, 70, 8, '', '', '405', '0010', '3', 2020, '1025', '2020-10-08', 1, 0),
(40, 71, 7, '', '', '405', '0010', '4', 2020, '295', '2020-10-15', 1, 0),
(41, 86, NULL, '', '', '700', '0050', '1', 2020, NULL, NULL, 1, 1),
(42, 87, NULL, '', '', '700', '0050', '2', 2020, NULL, NULL, 1, 1),
(43, 88, NULL, '', '', '700', '0050', '3', 2020, NULL, NULL, 1, 1),
(44, 89, NULL, '', '', '700', '0050', '4', 2020, NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `instrumento_cobro`
--

CREATE TABLE `instrumento_cobro` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mercancia`
--

CREATE TABLE `mercancia` (
  `id` int(11) NOT NULL,
  `id_amlacen_id` int(11) NOT NULL,
  `id_unidad_medida_id` int(11) NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cuenta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `existencia` double NOT NULL,
  `importe` double NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `nro_subcuenta_inventario` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nro_cuenta_acreedora` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nro_subcuenta_acreedora` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mercancia`
--

INSERT INTO `mercancia` (`id`, `id_amlacen_id`, `id_unidad_medida_id`, `codigo`, `cuenta`, `descripcion`, `existencia`, `importe`, `activo`, `nro_subcuenta_inventario`, `nro_cuenta_acreedora`, `nro_subcuenta_acreedora`) VALUES
(49, 1, 13, '104601', '183', 'Detergente', 90, 15.43, 1, '0010', '405', '0010'),
(50, 1, 13, '104651', '183', 'Jabon', 195, 19.6, 1, '0010', '405', '0010'),
(51, 1, 13, '104612', '183', 'Shampu', 0, 0, 0, '0010', '405', '0010'),
(52, 1, 13, '108051', '183', 'Jabon', 200, 28.4, 1, '0010', '405', '0010'),
(53, 1, 13, '1075-23', '183', 'Shampu', 405, 115.59, 1, '0010', '405', '0010'),
(54, 1, 13, '108001', '183', 'Jamon 250 grs', 120, 60.3, 1, '0020', '405', '0010'),
(55, 1, 8, '1080010', '183', 'Arroz', 560, 29.12, 1, '0020', '405', '0010'),
(56, 1, 10, '1080025', '183', 'Aceite', 185, 27.26, 1, '0020', '405', '0010'),
(57, 1, 13, '107002', '183', 'Jamon de 300grs', 45, 20.34, 1, '0020', '405', '0010'),
(58, 1, 8, '1070015', '183', 'Arroz', 75, 3.38, 1, '0020', '405', '0010'),
(59, 1, 10, '1070030', '183', 'Aceite', 0, 0, 0, '0020', '405', '0010'),
(60, 1, 13, '257102', '183', 'Dipirona', 325, 331.5, 1, '0030', '405', '0010'),
(61, 1, 13, '263543', '183', 'Omeprazol', 200, 1807.07, 1, '0030', '405', '0010'),
(62, 1, 13, '1070040', '183', 'Vitamina C', 395, 959.32, 1, '0030', '405', '0010'),
(63, 1, 13, '2571002', '183', 'Dipirona', 90, 85.5, 1, '0030', '405', '0010'),
(64, 2, 13, '104601', '183', 'Detergente', 0, 0, 0, '0010', '697', '0020'),
(65, 2, 8, '1080010', '183', 'Arroz', 0, 0, 0, '0020', '697', '0020'),
(66, 2, 13, '257102', '183', 'Dipiroma', 0, 0, 0, '0030', '697', '0020'),
(67, 2, 13, '263543', '183', 'Omeprazol', 0, 0, 0, '0030', '697', '0020'),
(68, 2, 13, '2013151', '189', 'Split de 2.0 t', 50, 12500, 1, '0040', '405', '0010'),
(69, 2, 13, '20131453', '189', 'Split de 1.5 t', 50, 10000, 1, '0040', '405', '0010'),
(70, 2, 13, '20131452', '189', 'Split de 1.0 t', 50, 7500, 1, '0040', '405', '0010'),
(71, 2, 13, '2018340', '189', 'Reacrgas 20 usd', 250, 4500, 1, '0010', '405', '0010'),
(72, 2, 13, '2018342', '189', 'Reacarga 30 usd', 200, 6000, 1, '0010', '405', '0010'),
(73, 2, 13, '2635.43', '189', 'Omeprazol', 0, 0, 0, '0040', '697', '0099'),
(74, 2, 13, '104601', '189', 'Detergente', 305, 52.16, 1, '0020', '697', '0020'),
(75, 2, 8, '1080010', '189', 'Arroz', 200, 10.4, 1, '0030', '697', '0020'),
(76, 2, 13, '257102', '189', 'Dipiroma', 200, 204, 1, '0040', '697', '0020'),
(77, 2, 13, '263543', '189', 'Omeprazol', 200, 1807.2, 1, '0040', '697', '0020');

-- --------------------------------------------------------

--
-- Table structure for table `mercancia_producto`
--

CREATE TABLE `mercancia_producto` (
  `id` int(11) NOT NULL,
  `id_mercancia_id` int(11) NOT NULL,
  `id_producto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modulo`
--

CREATE TABLE `modulo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `moneda`
--

CREATE TABLE `moneda` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `moneda`
--

INSERT INTO `moneda` (`id`, `nombre`, `activo`) VALUES
(1, 'USD', 1),
(2, 'EUR', 1);

-- --------------------------------------------------------

--
-- Table structure for table `movimiento`
--

CREATE TABLE `movimiento` (
  `id` int(11) NOT NULL,
  `id_tipo_documento_activo_fijo_id` int(11) NOT NULL,
  `id_tipo_movimiento_id` int(11) NOT NULL,
  `id_unidad_origen_id` int(11) NOT NULL,
  `id_unidad_destino_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movimiento_activo_fijo`
--

CREATE TABLE `movimiento_activo_fijo` (
  `id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `id_activo_fijo_id` int(11) NOT NULL,
  `id_tipo_movimiento_id` int(11) NOT NULL,
  `id_cuenta_id` int(11) NOT NULL,
  `id_subcuenta_id` int(11) NOT NULL,
  `id_usuario_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `fundamentacion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entrada` tinyint(1) NOT NULL,
  `nro_consecutivo` int(11) NOT NULL,
  `anno` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movimiento_mercancia`
--

CREATE TABLE `movimiento_mercancia` (
  `id` int(11) NOT NULL,
  `id_mercancia_id` int(11) NOT NULL,
  `id_documento_id` int(11) NOT NULL,
  `id_tipo_documento_id` int(11) NOT NULL,
  `id_usuario_id` int(11) DEFAULT NULL,
  `id_centro_costo_id` int(11) DEFAULT NULL,
  `id_elemento_gasto_id` int(11) DEFAULT NULL,
  `cantidad` double NOT NULL,
  `importe` double NOT NULL,
  `existencia` double NOT NULL,
  `fecha` date NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `entrada` tinyint(1) NOT NULL,
  `id_almacen_id` int(11) DEFAULT NULL,
  `id_expediente_id` int(11) DEFAULT NULL,
  `id_orden_trabajo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movimiento_mercancia`
--

INSERT INTO `movimiento_mercancia` (`id`, `id_mercancia_id`, `id_documento_id`, `id_tipo_documento_id`, `id_usuario_id`, `id_centro_costo_id`, `id_elemento_gasto_id`, `cantidad`, `importe`, `existencia`, `fecha`, `activo`, `entrada`, `id_almacen_id`, `id_expediente_id`, `id_orden_trabajo_id`) VALUES
(113, 49, 52, 1, 1, NULL, NULL, 450, 81.18, 450, '2020-10-20', 1, 1, 1, NULL, NULL),
(114, 50, 52, 1, 1, NULL, NULL, 450, 45.23, 450, '2020-10-20', 1, 1, 1, NULL, NULL),
(115, 51, 52, 1, 1, NULL, NULL, 450, 112.5, 450, '2020-10-20', 1, 1, 1, NULL, NULL),
(116, 49, 53, 1, 1, NULL, NULL, 200, 30.1, 650, '2020-10-20', 1, 1, 1, NULL, NULL),
(117, 52, 53, 1, 1, NULL, NULL, 200, 28.4, 200, '2020-10-20', 1, 1, 1, NULL, NULL),
(118, 53, 53, 1, 1, NULL, NULL, 200, 70, 200, '2020-10-20', 1, 1, 1, NULL, NULL),
(119, 54, 54, 1, 1, NULL, NULL, 120, 60.3, 120, '2020-10-20', 1, 1, 1, NULL, NULL),
(120, 55, 54, 1, 1, NULL, NULL, 750, 39, 750, '2020-10-20', 1, 1, 1, NULL, NULL),
(121, 56, 54, 1, 1, NULL, NULL, 200, 30, 200, '2020-10-20', 1, 1, 1, NULL, NULL),
(122, 57, 55, 1, 1, NULL, NULL, 70, 31.64, 70, '2020-10-20', 1, 1, 1, NULL, NULL),
(123, 58, 55, 1, 1, NULL, NULL, 225, 10.13, 225, '2020-10-20', 1, 1, 1, NULL, NULL),
(124, 59, 55, 1, 1, NULL, NULL, 30, 3.96, 30, '2020-10-20', 1, 1, 1, NULL, NULL),
(125, 60, 56, 1, 1, NULL, NULL, 550, 561, 550, '2020-10-20', 1, 1, 1, NULL, NULL),
(126, 61, 56, 1, 1, NULL, NULL, 325, 3073.3, 325, '2020-10-20', 1, 1, 1, NULL, NULL),
(127, 62, 56, 1, 1, NULL, NULL, 325, 765.05, 325, '2020-10-20', 1, 1, 1, NULL, NULL),
(128, 61, 57, 1, 1, NULL, NULL, 200, 1670.4, 525, '2020-10-20', 1, 1, 1, NULL, NULL),
(129, 63, 57, 1, 1, NULL, NULL, 200, 190, 200, '2020-10-20', 1, 1, 1, NULL, NULL),
(130, 62, 57, 1, 1, NULL, NULL, 200, 510, 525, '2020-10-20', 1, 1, 1, NULL, NULL),
(131, 49, 58, 7, 1, 2, 2, 50, 8.56, 600, '2020-10-20', 1, 0, 1, NULL, 1),
(132, 50, 58, 7, 1, 2, 2, 50, 5.03, 400, '2020-10-20', 1, 0, 1, NULL, 1),
(133, 51, 58, 7, 1, 2, 2, 50, 12.5, 400, '2020-10-20', 1, 0, 1, NULL, 1),
(134, 54, 59, 7, 1, 4, 3, 20, 10.05, 100, '2020-10-20', 1, 0, 1, NULL, 2),
(135, 55, 59, 7, 1, 4, 3, 100, 5.2, 650, '2020-10-20', 1, 0, 1, NULL, 2),
(136, 56, 59, 7, 1, 4, 3, 20, 3, 180, '2020-10-20', 1, 0, 1, NULL, 2),
(137, 60, 60, 7, 1, 3, 7, 25, 25.5, 525, '2020-10-20', 1, 0, 1, NULL, 3),
(138, 61, 60, 7, 1, 3, 7, 25, 225.89, 500, '2020-10-20', 1, 0, 1, NULL, 3),
(139, 62, 60, 7, 1, 3, 7, 25, 60.72, 500, '2020-10-20', 1, 0, 1, NULL, 3),
(140, 49, 61, 7, 1, 2, 2, 35, 5.99, 565, '2020-10-20', 1, 0, 1, NULL, 4),
(141, 50, 61, 7, 1, 2, 2, 35, 3.52, 365, '2020-10-20', 1, 0, 1, NULL, 4),
(142, 51, 61, 7, 1, 2, 2, 35, 8.75, 365, '2020-10-20', 1, 0, 1, NULL, 4),
(143, 57, 62, 7, 1, 4, 3, 25, 11.3, 45, '2020-10-20', 1, 0, 1, NULL, 5),
(144, 58, 62, 7, 1, 4, 3, 150, 6.75, 75, '2020-10-20', 1, 0, 1, NULL, 5),
(145, 56, 62, 7, 1, 4, 3, 25, 3.75, 155, '2020-10-20', 1, 0, 1, NULL, 5),
(146, 60, 63, 7, 1, 3, 7, 45, 45.9, 480, '2020-10-20', 1, 0, 1, NULL, 6),
(147, 61, 63, 7, 1, 3, 7, 45, 406.6, 455, '2020-10-20', 1, 0, 1, NULL, 6),
(148, 62, 63, 7, 1, 3, 7, 45, 109.29, 455, '2020-10-20', 1, 0, 1, NULL, 6),
(149, 51, 64, 4, 1, NULL, NULL, 365, 91.25, 0, '2020-10-21', 1, 0, 1, NULL, NULL),
(150, 59, 64, 4, 1, NULL, NULL, 30, 3.96, 0, '2020-10-21', 1, 0, 1, NULL, NULL),
(151, 53, 65, 3, 1, NULL, NULL, 365, 91.25, 565, '2020-10-21', 1, 1, 1, NULL, NULL),
(152, 56, 65, 3, 1, NULL, NULL, 30, 3.96, 185, '2020-10-21', 1, 1, 1, NULL, NULL),
(153, 49, 66, 6, 1, NULL, NULL, 305, 52.16, 260, '2020-10-21', 1, 0, 1, NULL, NULL),
(154, 55, 66, 6, 1, NULL, NULL, 200, 10.4, 450, '2020-10-21', 1, 0, 1, NULL, NULL),
(155, 60, 66, 6, 1, NULL, NULL, 200, 204, 280, '2020-10-21', 1, 0, 1, NULL, NULL),
(156, 61, 66, 6, 1, NULL, NULL, 200, 1807.2, 255, '2020-10-21', 1, 0, 1, NULL, NULL),
(157, 64, 67, 5, 1, NULL, NULL, 305, 52.16, 305, '2020-10-21', 1, 1, 2, NULL, NULL),
(158, 65, 67, 5, 1, NULL, NULL, 200, 10.4, 200, '2020-10-21', 1, 1, 2, NULL, NULL),
(159, 66, 67, 5, 1, NULL, NULL, 200, 204, 200, '2020-10-21', 1, 1, 2, NULL, NULL),
(160, 67, 67, 5, 1, NULL, NULL, 200, 1807.2, 200, '2020-10-21', 1, 1, 2, NULL, NULL),
(161, 68, 68, 1, 1, NULL, NULL, 50, 12500, 50, '2020-10-23', 1, 1, 2, NULL, NULL),
(162, 69, 68, 1, 1, NULL, NULL, 50, 10000, 50, '2020-10-23', 1, 1, 2, NULL, NULL),
(163, 70, 68, 1, 1, NULL, NULL, 50, 7500, 50, '2020-10-23', 1, 1, 2, NULL, NULL),
(164, 71, 69, 1, 1, NULL, NULL, 150, 3000, 150, '2020-10-23', 1, 1, 2, NULL, NULL),
(165, 72, 70, 1, 1, NULL, NULL, 200, 6000, 200, '2020-10-23', 1, 1, 2, NULL, NULL),
(166, 71, 71, 1, 1, NULL, NULL, 100, 1500, 250, '2020-10-23', 1, 1, 2, NULL, NULL),
(167, 64, 72, 4, 1, NULL, NULL, 305, 52.16, 0, '2020-10-23', 1, 0, 2, NULL, NULL),
(168, 65, 72, 4, 1, NULL, NULL, 200, 10.4, 0, '2020-10-23', 1, 0, 2, NULL, NULL),
(169, 66, 72, 4, 1, NULL, NULL, 200, 204, 0, '2020-10-23', 1, 0, 2, NULL, NULL),
(170, 67, 72, 4, 1, NULL, NULL, 200, 1807.2, 0, '2020-10-23', 1, 0, 2, NULL, NULL),
(171, 55, 73, 3, 1, NULL, NULL, 10, 0.52, 460, '2020-10-23', 1, 1, 1, NULL, NULL),
(172, 53, 74, 4, 1, NULL, NULL, 10, 2.85, 555, '2020-10-23', 1, 0, 1, 1, NULL),
(173, 64, 75, 3, 1, NULL, NULL, 305, 52.16, 305, '2020-10-23', 1, 1, 2, NULL, NULL),
(174, 65, 75, 3, 1, NULL, NULL, 200, 10.4, 200, '2020-10-23', 1, 1, 2, NULL, NULL),
(175, 66, 75, 3, 1, NULL, NULL, 200, 204, 200, '2020-10-23', 1, 1, 2, NULL, NULL),
(176, 73, 75, 3, 1, NULL, NULL, 200, 1807.2, 200, '2020-10-23', 1, 1, 2, NULL, NULL),
(177, 73, 76, 4, 1, NULL, NULL, 200, 1807.2, 0, '2020-10-23', 1, 0, 2, NULL, NULL),
(178, 64, 77, 4, 1, NULL, NULL, 305, 52.16, 0, '2020-10-23', 1, 0, 2, NULL, NULL),
(179, 65, 77, 4, 1, NULL, NULL, 200, 10.4, 0, '2020-10-23', 1, 0, 2, NULL, NULL),
(180, 66, 77, 4, 1, NULL, NULL, 200, 204, 0, '2020-10-23', 1, 0, 2, NULL, NULL),
(181, 74, 78, 3, 1, NULL, NULL, 305, 52.16, 305, '2020-10-23', 1, 1, 2, NULL, NULL),
(182, 75, 78, 3, 1, NULL, NULL, 200, 10.4, 200, '2020-10-23', 1, 1, 2, NULL, NULL),
(183, 76, 78, 3, 1, NULL, NULL, 200, 204, 200, '2020-10-23', 1, 1, 2, NULL, NULL),
(184, 77, 78, 3, 1, NULL, NULL, 200, 1807.2, 200, '2020-10-23', 1, 1, 2, NULL, NULL),
(185, 54, 81, 9, 1, NULL, NULL, 20, 10.05, 120, '2020-10-23', 1, 1, 1, NULL, NULL),
(186, 55, 81, 9, 1, NULL, NULL, 100, 5.2, 560, '2020-10-23', 1, 1, 1, NULL, NULL),
(187, 56, 81, 9, 1, NULL, NULL, 20, 3, 205, '2020-10-23', 1, 1, 1, NULL, NULL),
(188, 60, 82, 9, 1, NULL, NULL, 45, 45.9, 325, '2020-10-23', 1, 1, 1, NULL, NULL),
(189, 61, 82, 9, 1, NULL, NULL, 45, 406.6, 300, '2020-10-23', 1, 1, 1, NULL, NULL),
(190, 62, 82, 9, 1, NULL, NULL, 45, 109.29, 500, '2020-10-23', 1, 1, 1, NULL, NULL),
(191, 49, 83, 7, 1, 6, 2, 20, 3.43, 240, '2020-10-23', 1, 0, 1, NULL, NULL),
(192, 50, 83, 7, 1, 6, 2, 20, 2.01, 345, '2020-10-23', 1, 0, 1, NULL, NULL),
(193, 62, 83, 7, 1, 6, 7, 5, 12.14, 495, '2020-10-23', 1, 0, 1, NULL, NULL),
(194, 63, 83, 7, 1, 6, 7, 10, 9.5, 190, '2020-10-23', 1, 0, 1, NULL, NULL),
(195, 56, 83, 7, 1, 6, 3, 20, 2.95, 185, '2020-10-23', 1, 0, 1, NULL, NULL),
(196, 49, 84, 7, 1, 2, 2, 150, 25.71, 90, '2020-10-25', 1, 0, 1, NULL, 7),
(197, 50, 84, 7, 1, 2, 2, 150, 15.07, 195, '2020-10-25', 1, 0, 1, NULL, 7),
(198, 53, 84, 7, 1, 2, 2, 150, 42.81, 405, '2020-10-25', 1, 0, 1, NULL, 7),
(199, 61, 85, 7, 1, 3, 7, 100, 903.54, 200, '2020-10-25', 1, 0, 1, NULL, 8),
(200, 62, 85, 7, 1, 3, 7, 100, 242.87, 395, '2020-10-25', 1, 0, 1, NULL, 8),
(201, 63, 85, 7, 1, 3, 7, 100, 95, 90, '2020-10-25', 1, 0, 1, NULL, 8);

-- --------------------------------------------------------

--
-- Table structure for table `movimiento_producto`
--

CREATE TABLE `movimiento_producto` (
  `id` int(11) NOT NULL,
  `id_producto_id` int(11) NOT NULL,
  `id_documento_id` int(11) NOT NULL,
  `id_tipo_documento_id` int(11) NOT NULL,
  `id_usuario_id` int(11) DEFAULT NULL,
  `id_centro_costo_id` int(11) DEFAULT NULL,
  `id_elemento_gasto_id` int(11) DEFAULT NULL,
  `cantidad` double NOT NULL,
  `importe` double NOT NULL,
  `existencia` double NOT NULL,
  `fecha` date NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `entrada` tinyint(1) NOT NULL,
  `id_almacen_id` int(11) DEFAULT NULL,
  `id_orden_trabajo_id` int(11) DEFAULT NULL,
  `id_expediente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movimiento_producto`
--

INSERT INTO `movimiento_producto` (`id`, `id_producto_id`, `id_documento_id`, `id_tipo_documento_id`, `id_usuario_id`, `id_centro_costo_id`, `id_elemento_gasto_id`, `cantidad`, `importe`, `existencia`, `fecha`, `activo`, `entrada`, `id_almacen_id`, `id_orden_trabajo_id`, `id_expediente_id`) VALUES
(1, 1, 86, 2, 1, 2, NULL, 50, 26.09, 50, '2020-10-23', 1, 1, 3, 1, NULL),
(2, 2, 86, 2, 1, 3, NULL, 25, 312.11, 25, '2020-10-23', 1, 1, 3, 3, NULL),
(3, 3, 87, 2, 1, 2, NULL, 35, 18.26, 35, '2020-10-23', 1, 1, 3, 4, NULL),
(4, 4, 87, 2, 1, 4, NULL, 25, 21.8, 25, '2020-10-23', 1, 1, 3, 5, NULL),
(5, 5, 88, 2, 1, 2, NULL, 100, 55.73, 100, '2020-10-25', 1, 1, 3, 7, NULL),
(6, 6, 88, 2, 1, 3, NULL, 80, 993.13, 80, '2020-10-25', 1, 1, 3, 8, NULL),
(7, 5, 89, 2, 1, 2, NULL, 50, 27.86, 150, '2020-10-25', 1, 1, 3, 7, NULL),
(8, 6, 89, 2, 1, 3, NULL, 20, 248.28, 100, '2020-10-25', 1, 1, 3, 8, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `movimiento_venta`
--

CREATE TABLE `movimiento_venta` (
  `id` int(11) NOT NULL,
  `id_factura_id` int(11) NOT NULL,
  `mercancia` tinyint(1) NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` double NOT NULL,
  `precio` double NOT NULL,
  `descuento_recarga` double DEFAULT NULL,
  `existencia` double DEFAULT NULL,
  `cuenta_deudora` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subcuenta_deudora` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cuenta_acreedora` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subcuenta_acreedora` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL,
  `id_almacen_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `municipios`
--

CREATE TABLE `municipios` (
  `id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `obligacion_cobro`
--

CREATE TABLE `obligacion_cobro` (
  `id` int(11) NOT NULL,
  `id_factura_id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `tipo_cliente` int(11) NOT NULL,
  `fecha_factura` date NOT NULL,
  `importe_factura` double NOT NULL,
  `cuenta_obligacion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subcuenta_obligacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resto_pagar` double NOT NULL,
  `liquidada` tinyint(1) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `obligacion_pago`
--

CREATE TABLE `obligacion_pago` (
  `id` int(11) NOT NULL,
  `id_proveedor_id` int(11) NOT NULL,
  `id_documento_id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `nro_cuenta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_subcuenta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor_pagado` double DEFAULT NULL,
  `resto` double NOT NULL,
  `liquidado` tinyint(1) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `codigo_factura` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_factura` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orden_trabajo`
--

CREATE TABLE `orden_trabajo` (
  `id` int(11) NOT NULL,
  `id_unidad_id` int(11) DEFAULT NULL,
  `id_almacen_id` int(11) DEFAULT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `anno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orden_trabajo`
--

INSERT INTO `orden_trabajo` (`id`, `id_unidad_id`, `id_almacen_id`, `codigo`, `descripcion`, `activo`, `anno`) VALUES
(1, 1, 1, '01', 'Combo de Aseo 1era Clase', 1, 2020),
(2, 1, 1, '02', 'Combo de Alimento 2da Clase', 1, 2020),
(3, 1, 1, '03', 'Combo de Medicamentos Clase 1', 1, 2020),
(4, 1, 1, '04', 'Combo de Aseo 2da Clase', 1, 2020),
(5, 1, 1, '05', 'Combo de Alimento Clase 2', 1, 2020),
(6, 1, 1, '06', 'Combo de Medicina Clase 1', 1, 2020),
(7, 1, 1, '7', 'Combo de Aseo', 1, 2020),
(8, 1, 1, '9', 'Combo de Medicina', 1, 2020);

-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `id_amlacen_id` int(11) NOT NULL,
  `id_unidad_medida_id` int(11) NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cuenta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `existencia` double NOT NULL,
  `importe` double NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `nro_subcuenta_inventario` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nro_cuenta_acreedora` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nro_subcuenta_acreedora` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `producto`
--

INSERT INTO `producto` (`id`, `id_amlacen_id`, `id_unidad_medida_id`, `codigo`, `cuenta`, `descripcion`, `existencia`, `importe`, `activo`, `nro_subcuenta_inventario`, `nro_cuenta_acreedora`, `nro_subcuenta_acreedora`) VALUES
(1, 3, 13, 'OT-01', '188', 'Combo de Aseo', 50, 26.09, 1, '0020', '700', '0050'),
(2, 3, 13, 'OT-03', '188', 'Combo de Medicamento', 25, 312.11, 1, '0020', '700', '0050'),
(3, 3, 13, 'OT-04', '188', 'Combo de Aseo', 35, 18.26, 1, '0020', '700', '0050'),
(4, 3, 13, 'OT-05', '188', 'Combo de Alimento', 25, 21.8, 1, '0020', '700', '0050'),
(5, 3, 13, 'OT-07', '188', 'Combo de Aseo', 150, 83.59, 1, '0020', '700', '0050'),
(6, 3, 13, 'OT-09', '188', 'Combo de Medicamento', 100, 1241.41, 1, '0020', '700', '0050');

-- --------------------------------------------------------

--
-- Table structure for table `proveedor`
--

CREATE TABLE `proveedor` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `proveedor`
--

INSERT INTO `proveedor` (`id`, `nombre`, `codigo`, `activo`) VALUES
(1, 'Fabrica de Productos de Aseo Colombia', '4051', 1),
(2, 'Fabrica de Productos de Aseo China', '2715', 1),
(3, 'Almacenes de Alimentos del Puerto', '2780', 1),
(4, 'Almacenes de Alimentos Ecuador', '3520', 1),
(5, 'Laboratorio de Medicamentos de Cartagena', '45-152', 1),
(6, 'Laboratorio de Medicamentos de Mexixo', '45-1523', 1),
(7, 'Empresa Telecomunicaciones Mexico', '6225', 1),
(8, 'Empresa Telecomunicaciones Dominicana', '6314', 1),
(9, 'Empresa Artculos Domesticos Honduras', '27801', 1),
(10, 'Empresa Articulos Domesticos Mexico', '20381', 1);

-- --------------------------------------------------------

--
-- Table structure for table `provincias`
--

CREATE TABLE `provincias` (
  `id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registro_comprobantes`
--

CREATE TABLE `registro_comprobantes` (
  `id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `id_tipo_comprobante_id` int(11) NOT NULL,
  `id_usuario_id` int(11) NOT NULL,
  `id_almacen_id` int(11) NOT NULL,
  `nro_consecutivo` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `debito` double NOT NULL,
  `credito` double NOT NULL,
  `anno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `registro_comprobantes`
--

INSERT INTO `registro_comprobantes` (`id`, `id_unidad_id`, `id_tipo_comprobante_id`, `id_usuario_id`, `id_almacen_id`, `nro_consecutivo`, `fecha`, `descripcion`, `debito`, `credito`, `anno`) VALUES
(3, 1, 2, 1, 2, 1, '2020-10-24', 'CONTABILIZANDO MOVIMIENTOS DE INVENTARIOS DEL ALMACEN 02 DE MERACANCIAS PARA LA VENTA DESDE EL 21 AL 23 DE OCTUBRE DE 2020', 50868.8, 50868.8, 2020),
(4, 1, 2, 1, 1, 2, '2020-10-25', 'Contabilizazando Movimientos de Inventarios del Almacen de Materias Primas desde el 20 al 23 de Octubre de 2020', 11148.11, 11148.11, 2020),
(5, 1, 2, 1, 3, 3, '2020-10-26', 'Contabilizando movimientos de inventarios del almacen de produccion terminada desde el 23 al 25 de Octubre de 2020', 1703.26, 1703.26, 2020);

-- --------------------------------------------------------

--
-- Table structure for table `reset_password_request`
--

CREATE TABLE `reset_password_request` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saldo_cuentas`
--

CREATE TABLE `saldo_cuentas` (
  `id` int(11) NOT NULL,
  `id_cuenta_id` int(11) NOT NULL,
  `id_subcuenta_id` int(11) NOT NULL,
  `id_centro_costo_id` int(11) DEFAULT NULL,
  `id_elemento_gasto_id` int(11) DEFAULT NULL,
  `id_almacen_id` int(11) DEFAULT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `id_proveedor_id` int(11) DEFAULT NULL,
  `id_expediente_id` int(11) DEFAULT NULL,
  `id_orden_trabajo_id` int(11) DEFAULT NULL,
  `mes` int(11) NOT NULL,
  `anno` int(11) NOT NULL,
  `saldo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stripe_factura`
--

CREATE TABLE `stripe_factura` (
  `id` int(11) NOT NULL,
  `auth` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estatus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cliente_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_empleado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `monto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subcuenta`
--

CREATE TABLE `subcuenta` (
  `id` int(11) NOT NULL,
  `id_cuenta_id` int(11) NOT NULL,
  `nro_subcuenta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deudora` tinyint(1) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `elemento_gasto` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcuenta`
--

INSERT INTO `subcuenta` (`id`, `id_cuenta_id`, `nro_subcuenta`, `descripcion`, `deudora`, `activo`, `elemento_gasto`) VALUES
(1, 1, '0001', 'Efectivo', 1, 1, 0),
(2, 13, '00001', 'En Almacen', 1, 1, 0),
(3, 13, '0002', 'En Uso', 1, 1, 0),
(4, 14, '0020', 'Produccion', 1, 1, 0),
(5, 14, '0030', 'Ventas', 0, 1, 0),
(6, 14, '0040', 'Otros Aumentos', 1, 1, 0),
(7, 14, '0050', 'Otras Disminuciones', 0, 1, 0),
(8, 24, '01', 'Saldo de Inico', 1, 1, 0),
(9, 24, '0010', 'Construccion y Montaje', 1, 1, 0),
(10, 24, '00020', 'Equipos', 1, 1, 0),
(11, 24, '00030', 'Otros Gastos', 1, 1, 0),
(12, 24, '0999', 'Traspaso a Activos Fijos', 0, 1, 0),
(13, 25, '0100', 'Compras del Periodo', 1, 1, 0),
(14, 25, '0300', 'Adquisicion del Periodo por Donaciones', 1, 1, 0),
(15, 25, '0999', 'Traspaso a Activos Fijos Tangibles', 0, 1, 0),
(16, 2, '001', 'fkldjskfljdslkf', 1, 0, 0),
(17, 9, '0001', 'Impuesto sobre las ventas', 1, 1, 0),
(18, 9, '0002', 'Aranceles de Aduana', 1, 1, 0),
(19, 9, '0004', 'Impuesto sobre Utilidades', 1, 1, 0),
(20, 26, '0100', 'Compras del Periodo', 1, 1, 0),
(21, 26, '0999', 'Traspaso a activos fijos intangibles', 0, 1, 0),
(22, 27, '0010', 'Saldo al Incio', 1, 1, 0),
(23, 27, '0020', 'Gastos por Elementos del Periodo', 1, 1, 1),
(24, 27, '0030', 'Amortizacion de Gastos', 0, 1, 0),
(25, 28, '0010', 'Saldo al Inicio', 1, 1, 0),
(26, 28, '0020', 'Gastos del Periodo', 1, 1, 0),
(27, 28, '0030', 'Amortizacion de Gastos', 0, 1, 0),
(28, 29, '0010', 'Perdidas por Deterioros', 1, 1, 0),
(29, 29, '0020', 'Perdidas de Cuentas por Cobrar', 1, 1, 0),
(30, 30, '0010', 'Medios Monetarios', 1, 1, 0),
(31, 30, '0020', 'Medios  Materiales', 1, 1, 0),
(32, 31, '0010', 'Ventas a Entidades', 1, 1, 0),
(33, 31, '0020', 'Ventas a Trabajadores', 1, 1, 0),
(34, 41, '0001', 'Impuesto sobre Ventas', 0, 1, 0),
(35, 41, '0003', 'Aranceles de Aduana', 0, 1, 0),
(36, 41, '0004', 'Impuesto sobre Utilidades', 0, 1, 0),
(37, 41, '0005', 'Impuesto sobre ingresos personales', 0, 1, 0),
(38, 54, '0010', 'Activos Fijos Tangibles', 0, 1, 0),
(39, 54, '0020', 'Activos Fijos Intangibles', 0, 1, 0),
(40, 54, '0030', 'Recursos Monetarios', 0, 1, 0),
(41, 54, '0040', 'Recursos Materiales-Inventarios', 0, 1, 0),
(42, 47, '0010', 'Prestamos Recibidos de Entidades', 0, 1, 0),
(43, 47, '0020', 'Prestamos Recibidos de Bancos', 0, 1, 0),
(44, 61, '0010', 'Transferencias Recibidas de Unidades', 1, 1, 0),
(45, 61, '0020', 'Transferencias entre Almacenes', 1, 1, 0),
(46, 61, '0099', 'Operaciones de Ajustes en Inventarios', 1, 1, 0),
(47, 62, '0010', 'Transferencias entre Unidades', 0, 1, 0),
(48, 62, '0020', 'Transferencias de Inventarios entre almacenes', 0, 1, 0),
(49, 62, '0099', 'Operaciones de Ajustes de Inventarios', 0, 1, 0),
(50, 63, '0010', 'Saldo Inicio', 1, 1, 0),
(51, 63, '0020', 'Gastos del Periodo', 1, 1, 1),
(52, 63, '0030', 'Aumentos', 1, 1, 0),
(53, 63, '0040', 'Disminuciones', 0, 1, 0),
(54, 63, '0050', 'Traspaso a Produccion Terminada', 0, 1, 0),
(55, 64, '0010', 'Con Terceros', 1, 1, 0),
(56, 64, '0020', 'Con Medios Propios', 1, 1, 1),
(57, 65, '0010', 'Produccion', 1, 1, 0),
(58, 65, '0020', 'Mercancias', 1, 1, 0),
(59, 15, '0010', 'Recargas', 1, 1, 0),
(60, 15, '0020', 'Productos de Aseo y Perfumeria', 1, 1, 0),
(61, 15, '0030', 'Productos Alimenticios', 1, 1, 0),
(62, 15, '0040', 'Otros Productos', 1, 1, 0),
(63, 36, '0010', 'Proveedores Principales', 0, 1, 0),
(64, 36, '0020', 'Otros Proveedores', 0, 1, 0),
(65, 10, '0010', 'Materiales y Productos Aseo', 1, 1, 0),
(66, 10, '0020', 'Materiales y Produtos de Alimentos', 1, 1, 0),
(67, 10, '0030', 'Materiales y Productos de Medicamentos', 1, 1, 0),
(68, 10, '0999', 'Otros Materiales', 1, 1, 0),
(69, 50, '0010', 'Medios Monetarios', 0, 1, 0),
(70, 50, '0020', 'Recursos Materiales', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `subcuenta_criterio_analisis`
--

CREATE TABLE `subcuenta_criterio_analisis` (
  `id` int(11) NOT NULL,
  `id_subcuenta_id` int(11) NOT NULL,
  `id_criterio_analisis_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcuenta_criterio_analisis`
--

INSERT INTO `subcuenta_criterio_analisis` (`id`, `id_subcuenta_id`, `id_criterio_analisis_id`) VALUES
(1, 16, 2),
(2, 16, 3),
(3, 16, 4),
(4, 16, 5),
(5, 22, 11),
(7, 24, 11),
(8, 27, 11),
(9, 25, 11),
(10, 26, 11),
(11, 28, 11),
(12, 29, 11),
(13, 30, 11),
(14, 31, 11),
(15, 32, 6),
(16, 33, 8),
(17, 23, 11),
(24, 42, 6),
(25, 43, 14),
(26, 44, 2),
(27, 45, 1),
(28, 46, 1),
(29, 47, 2),
(30, 48, 1),
(31, 49, 1),
(38, 52, 11),
(39, 53, 11),
(41, 55, 4),
(42, 55, 6),
(43, 56, 4),
(44, 59, 1),
(45, 60, 1),
(46, 61, 1),
(47, 62, 1),
(50, 63, 6),
(51, 64, 6),
(54, 66, 1),
(55, 67, 1),
(56, 68, 1),
(57, 65, 1),
(58, 50, 3),
(59, 50, 10),
(64, 69, 11),
(65, 70, 11),
(66, 51, 3),
(67, 51, 5),
(68, 51, 10),
(69, 54, 3),
(70, 54, 10);

-- --------------------------------------------------------

--
-- Table structure for table `subcuenta_proveedor`
--

CREATE TABLE `subcuenta_proveedor` (
  `id` int(11) NOT NULL,
  `id_subcuenta_id` int(11) NOT NULL,
  `id_proveedor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcuenta_proveedor`
--

INSERT INTO `subcuenta_proveedor` (`id`, `id_subcuenta_id`, `id_proveedor_id`) VALUES
(1, 63, 1),
(2, 63, 2),
(3, 63, 3),
(4, 63, 4),
(5, 63, 5),
(6, 63, 6),
(7, 63, 9),
(8, 63, 7),
(9, 63, 8),
(10, 63, 10);

-- --------------------------------------------------------

--
-- Table structure for table `tasa_cambio`
--

CREATE TABLE `tasa_cambio` (
  `id` int(11) NOT NULL,
  `id_moneda_origen_id` int(11) NOT NULL,
  `id_moneda_destino_id` int(11) NOT NULL,
  `anno` int(11) NOT NULL,
  `mes` int(11) NOT NULL,
  `valor` double NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test_crud`
--

CREATE TABLE `test_crud` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_comprobante`
--

CREATE TABLE `tipo_comprobante` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `abreviatura` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tipo_comprobante`
--

INSERT INTO `tipo_comprobante` (`id`, `descripcion`, `activo`, `abreviatura`) VALUES
(1, 'COMPROBANTE DE APERTURA', 1, 'AP'),
(2, 'COMPROBANTE DE OPERACIONES', 1, '00');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_cuenta`
--

CREATE TABLE `tipo_cuenta` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tipo_cuenta`
--

INSERT INTO `tipo_cuenta` (`id`, `nombre`, `activo`) VALUES
(1, 'Activos Circulantes', 1),
(2, 'Activos a Largo Plazo', 1),
(3, 'Activos Fijos', 1),
(4, 'Activos Diferidos', 1),
(5, 'Otros Activos', 1),
(6, 'Cuentas Reguladoras de Activos', 1),
(7, 'Pasivos Circulantes', 1),
(8, 'Pasivos a Largo Plazo', 1),
(9, 'Pasivos Diferidos', 1),
(10, 'Otros Pasivos', 1),
(11, 'Capital Contable', 1),
(12, 'Gastos de Produccion', 1),
(13, 'Cuentas Nominales Deudoras', 1),
(14, 'Cuentas Nominales Acreedoras', 1),
(15, 'Cuenta de Resultado', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tipo_documento`
--

INSERT INTO `tipo_documento` (`id`, `nombre`, `activo`) VALUES
(1, 'INFORME DE RECECIÓN MERCANCIA', 1),
(2, 'INFORME DE RECECIÓN PRODUCTO', 1),
(3, 'AJUSTE DE ENTRADA', 1),
(4, 'AJUSTE DE SALIDA', 1),
(5, 'TRANSFERENCIA DE ENTRADA', 1),
(6, 'TRANSFERENCIA DE SALIDA', 1),
(7, 'VALE DE SALIDA MERCANCIA', 1),
(8, 'VALE DE SALIDA PRODUCTO', 1),
(9, 'DEVOLUCION', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tipo_documento_activo_fijo`
--

CREATE TABLE `tipo_documento_activo_fijo` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_movimiento`
--

CREATE TABLE `tipo_movimiento` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transferencia`
--

CREATE TABLE `transferencia` (
  `id` int(11) NOT NULL,
  `id_documento_id` int(11) NOT NULL,
  `id_unidad_id` int(11) DEFAULT NULL,
  `id_almacen_id` int(11) DEFAULT NULL,
  `nro_cuenta_inventario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_subcuenta_inventario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_cuenta_acreedora` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_concecutivo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anno` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `entrada` tinyint(1) NOT NULL,
  `nro_subcuenta_acreedora` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transferencia`
--

INSERT INTO `transferencia` (`id`, `id_documento_id`, `id_unidad_id`, `id_almacen_id`, `nro_cuenta_inventario`, `nro_subcuenta_inventario`, `nro_cuenta_acreedora`, `nro_concecutivo`, `anno`, `activo`, `entrada`, `nro_subcuenta_acreedora`) VALUES
(2, 66, NULL, 2, '696', '0020', '', '1', 2020, 1, 0, ''),
(3, 67, NULL, 1, '', '', '697', '1', 2020, 1, 1, '0020');

-- --------------------------------------------------------

--
-- Table structure for table `unidad`
--

CREATE TABLE `unidad` (
  `id` int(11) NOT NULL,
  `id_padre_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `unidad`
--

INSERT INTO `unidad` (`id`, `id_padre_id`, `nombre`, `activo`, `codigo`) VALUES
(1, NULL, 'Grupo Horizontes Admin', 1, '01');

-- --------------------------------------------------------

--
-- Table structure for table `unidad_medida`
--

CREATE TABLE `unidad_medida` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `abreviatura` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `unidad_medida`
--

INSERT INTO `unidad_medida` (`id`, `nombre`, `activo`, `abreviatura`) VALUES
(1, 'Centímetro', 1, 'cm'),
(2, 'Metro', 1, 'm'),
(3, 'Milímetro', 1, 'mm'),
(4, 'Kilómetro', 1, 'km'),
(5, 'Gramo', 1, 'g'),
(6, 'Miligramo', 1, 'mg'),
(7, 'Libra', 1, 'lb'),
(8, 'Kilogramo', 1, 'kg'),
(9, 'Mililitro', 1, 'ml'),
(10, 'Litro', 1, 'l'),
(11, 'Metro cuadrado', 1, 'm²'),
(12, 'Metro cúbico', 1, 'm³'),
(13, 'Unidad', 1, 'u'),
(14, 'Blister', 1, 'Blister');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `status` tinyint(1) NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `status`, `password`) VALUES
(1, 'root', '[\"ROLE_ADMIN\"]', 1, '$argon2id$v=19$m=65536,t=4,p=1$Z1dpQjlQeG1LLnB2SVpZbA$OPsXOk93GwXrcXJsCH5ARKvyWoGVJX5aZLfCoUSjMm0');

-- --------------------------------------------------------

--
-- Table structure for table `vale_salida`
--

CREATE TABLE `vale_salida` (
  `id` int(11) NOT NULL,
  `id_documento_id` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `nro_consecutivo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anno` int(11) NOT NULL,
  `fecha_solicitud` date NOT NULL,
  `nro_solicitud` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_cuenta_deudora` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_subcuenta_deudora` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `producto` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vale_salida`
--

INSERT INTO `vale_salida` (`id`, `id_documento_id`, `activo`, `nro_consecutivo`, `anno`, `fecha_solicitud`, `nro_solicitud`, `nro_cuenta_deudora`, `nro_subcuenta_deudora`, `producto`) VALUES
(15, 58, 1, '1', 2020, '2020-10-20', '1', '700', '0020', 0),
(16, 59, 1, '2', 2020, '2020-10-20', '2', '700', '0020', 0),
(17, 60, 1, '3', 2020, '2020-10-20', '3', '700', '0020', 0),
(18, 61, 1, '4', 2020, '2020-10-20', '4', '700', '0020', 0),
(19, 62, 1, '5', 2020, '2020-10-20', '5', '700', '0020', 0),
(20, 63, 1, '6', 2020, '2020-10-20', '6', '700', '0020', 0),
(21, 83, 1, '7', 2020, '2020-10-23', '7', '823', '', 0),
(22, 84, 1, '8', 2020, '2020-10-25', '8', '700', '0020', 0),
(23, 85, 1, '9', 2020, '2020-10-25', '9', '700', '0020', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activo_fijo`
--
ALTER TABLE `activo_fijo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EBC93E1D34FA6B` (`id_unidad_id`),
  ADD KEY `IDX_75EBC93E4A667A2B` (`id_grupo_activo_id`),
  ADD KEY `IDX_75EBC93EDB763453` (`id_tipo_movimiento_id`),
  ADD KEY `IDX_75EBC93E6FBA0327` (`id_tipo_movimiento_baja_id`),
  ADD KEY `IDX_75EBC93ED410562` (`id_area_responsabilidad_id`);

--
-- Indexes for table `activo_fijo_cuentas`
--
ALTER TABLE `activo_fijo_cuentas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E0DF2901C84BDE84` (`id_activo_id`),
  ADD KEY `IDX_E0DF290186762CC7` (`id_cuenta_activo_id`),
  ADD KEY `IDX_E0DF29014476721E` (`id_subcuenta_activo_id`),
  ADD KEY `IDX_E0DF29012955A16D` (`id_centro_costo_activo_id`),
  ADD KEY `IDX_E0DF29014C675596` (`id_area_responsabilidad_activo_id`),
  ADD KEY `IDX_E0DF290174A5FFBA` (`id_cuenta_depreciacion_id`),
  ADD KEY `IDX_E0DF2901549C81D9` (`id_subcuenta_depreciacion_id`),
  ADD KEY `IDX_E0DF290180C608FA` (`id_cuenta_gasto_id`),
  ADD KEY `IDX_E0DF290157677646` (`id_subcuenta_gasto_id`),
  ADD KEY `IDX_E0DF2901A950EE53` (`id_centro_costo_gasto_id`),
  ADD KEY `IDX_E0DF2901A752F04B` (`id_elemento_gasto_gasto_id`);

--
-- Indexes for table `activo_fijo_movimiento_activo_fijo`
--
ALTER TABLE `activo_fijo_movimiento_activo_fijo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2FA61FF25832E72E` (`id_activo_fijo_id`),
  ADD KEY `IDX_2FA61FF27786CA71` (`id_movimiento_activo_fijo_id`);

--
-- Indexes for table `ajuste`
--
ALTER TABLE `ajuste`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DD35BD326601BA07` (`id_documento_id`);

--
-- Indexes for table `almacen`
--
ALTER TABLE `almacen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D5B2D25020332D99` (`codigo`),
  ADD KEY `IDX_D5B2D2501D34FA6B` (`id_unidad_id`);

--
-- Indexes for table `almacen_ocupado`
--
ALTER TABLE `almacen_ocupado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_AA53605839161EBF` (`id_almacen_id`),
  ADD KEY `IDX_AA5360587EB2C349` (`id_usuario_id`);

--
-- Indexes for table `area_responsabilidad`
--
ALTER TABLE `area_responsabilidad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F469C2BA1D34FA6B` (`id_unidad_id`);

--
-- Indexes for table `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `centro_costo`
--
ALTER TABLE `centro_costo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_749608CE1D34FA6B` (`id_unidad_id`);

--
-- Indexes for table `cierre`
--
ALTER TABLE `cierre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D0DCFCC739161EBF` (`id_almacen_id`),
  ADD KEY `IDX_D0DCFCC77EB2C349` (`id_usuario_id`);

--
-- Indexes for table `cierre_diario`
--
ALTER TABLE `cierre_diario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F3D0CD8939161EBF` (`id_almacen_id`),
  ADD KEY `IDX_F3D0CD897EB2C349` (`id_usuario_id`);

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cliente_beneficiario`
--
ALTER TABLE `cliente_beneficiario`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cliente_contabilidad`
--
ALTER TABLE `cliente_contabilidad`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cliente_reporte`
--
ALTER TABLE `cliente_reporte`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comprobante_cierre`
--
ALTER TABLE `comprobante_cierre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D03EA4C51800963C` (`id_comprobante_id`),
  ADD KEY `IDX_D03EA4C545F8C94C` (`id_cierre_id`);

--
-- Indexes for table `configuracion_inicial`
--
ALTER TABLE `configuracion_inicial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8521BE24404AE9D2` (`id_modulo_id`),
  ADD KEY `IDX_8521BE247A4F962` (`id_tipo_documento_id`);

--
-- Indexes for table `contratos_cliente`
--
ALTER TABLE `contratos_cliente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_29A5BB477BF9CE86` (`id_cliente_id`),
  ADD KEY `IDX_29A5BB47374388F5` (`id_moneda_id`);

--
-- Indexes for table `criterio_analisis`
--
ALTER TABLE `criterio_analisis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cuadre_diario`
--
ALTER TABLE `cuadre_diario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_60ABEFD91ADA4D3F` (`id_cuenta_id`),
  ADD KEY `IDX_60ABEFD92D412F53` (`id_subcuenta_id`),
  ADD KEY `IDX_60ABEFD945F8C94C` (`id_cierre_id`),
  ADD KEY `IDX_60ABEFD939161EBF` (`id_almacen_id`);

--
-- Indexes for table `cuenta`
--
ALTER TABLE `cuenta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_31C7BFCF45E7F350` (`id_tipo_cuenta_id`);

--
-- Indexes for table `cuentas_cliente`
--
ALTER TABLE `cuentas_cliente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_64653310374388F5` (`id_moneda_id`),
  ADD KEY `IDX_646533107BF9CE86` (`id_cliente_id`);

--
-- Indexes for table `cuenta_criterio_analisis`
--
ALTER TABLE `cuenta_criterio_analisis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_AF040B091ADA4D3F` (`id_cuenta_id`),
  ADD KEY `IDX_AF040B095ABBE5F6` (`id_criterio_analisis_id`);

--
-- Indexes for table `custom_user`
--
ALTER TABLE `custom_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8CE51EB479F37AE5` (`id_user_id`);

--
-- Indexes for table `depreciacion`
--
ALTER TABLE `depreciacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D618AE145832E72E` (`id_activo_fijo_id`);

--
-- Indexes for table `devolucion`
--
ALTER TABLE `devolucion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_524D9F676601BA07` (`id_documento_id`),
  ADD KEY `IDX_524D9F671D34FA6B` (`id_unidad_id`),
  ADD KEY `IDX_524D9F6739161EBF` (`id_almacen_id`),
  ADD KEY `IDX_524D9F67C59B01FF` (`id_centro_costo_id`),
  ADD KEY `IDX_524D9F67F66372E9` (`id_elemento_gasto_id`),
  ADD KEY `IDX_524D9F675074DD86` (`id_orden_tabajo_id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B6B12EC739161EBF` (`id_almacen_id`),
  ADD KEY `IDX_B6B12EC71D34FA6B` (`id_unidad_id`),
  ADD KEY `IDX_B6B12EC7374388F5` (`id_moneda_id`),
  ADD KEY `IDX_B6B12EC77A4F962` (`id_tipo_documento_id`);

--
-- Indexes for table `elemento_gasto`
--
ALTER TABLE `elemento_gasto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D9D9BF527EB2C349` (`id_usuario_id`),
  ADD KEY `IDX_D9D9BF521D34FA6B` (`id_unidad_id`),
  ADD KEY `IDX_D9D9BF52D1E12F15` (`id_cargo_id`);

--
-- Indexes for table `expediente`
--
ALTER TABLE `expediente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D59CA4131D34FA6B` (`id_unidad_id`);

--
-- Indexes for table `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F9EBA0091D34FA6B` (`id_unidad_id`),
  ADD KEY `IDX_F9EBA0097EB2C349` (`id_usuario_id`),
  ADD KEY `IDX_F9EBA00968BCB606` (`id_contrato_id`);

--
-- Indexes for table `grupo_activos`
--
ALTER TABLE `grupo_activos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `informe_recepcion`
--
ALTER TABLE `informe_recepcion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_62A4EBD6601BA07` (`id_documento_id`),
  ADD KEY `IDX_62A4EBDE8F12801` (`id_proveedor_id`);

--
-- Indexes for table `instrumento_cobro`
--
ALTER TABLE `instrumento_cobro`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mercancia`
--
ALTER TABLE `mercancia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9D094AE0E2C70A62` (`id_amlacen_id`),
  ADD KEY `IDX_9D094AE0E16A5625` (`id_unidad_medida_id`);

--
-- Indexes for table `mercancia_producto`
--
ALTER TABLE `mercancia_producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3F705CF59F287F54` (`id_mercancia_id`),
  ADD KEY `IDX_3F705CF56E57A479` (`id_producto_id`);

--
-- Indexes for table `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moneda`
--
ALTER TABLE `moneda`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movimiento`
--
ALTER TABLE `movimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C8FF107AD1CE493D` (`id_tipo_documento_activo_fijo_id`),
  ADD KEY `IDX_C8FF107ADB763453` (`id_tipo_movimiento_id`),
  ADD KEY `IDX_C8FF107A873C7FC7` (`id_unidad_origen_id`),
  ADD KEY `IDX_C8FF107A4F781EA` (`id_unidad_destino_id`);

--
-- Indexes for table `movimiento_activo_fijo`
--
ALTER TABLE `movimiento_activo_fijo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A985A0DA1D34FA6B` (`id_unidad_id`),
  ADD KEY `IDX_A985A0DA5832E72E` (`id_activo_fijo_id`),
  ADD KEY `IDX_A985A0DADB763453` (`id_tipo_movimiento_id`),
  ADD KEY `IDX_A985A0DA1ADA4D3F` (`id_cuenta_id`),
  ADD KEY `IDX_A985A0DA2D412F53` (`id_subcuenta_id`),
  ADD KEY `IDX_A985A0DA7EB2C349` (`id_usuario_id`);

--
-- Indexes for table `movimiento_mercancia`
--
ALTER TABLE `movimiento_mercancia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_44876BD79F287F54` (`id_mercancia_id`),
  ADD KEY `IDX_44876BD76601BA07` (`id_documento_id`),
  ADD KEY `IDX_44876BD77A4F962` (`id_tipo_documento_id`),
  ADD KEY `IDX_44876BD77EB2C349` (`id_usuario_id`),
  ADD KEY `IDX_44876BD7C59B01FF` (`id_centro_costo_id`),
  ADD KEY `IDX_44876BD7F66372E9` (`id_elemento_gasto_id`),
  ADD KEY `IDX_44876BD739161EBF` (`id_almacen_id`),
  ADD KEY `IDX_44876BD7F5DBAF2B` (`id_expediente_id`),
  ADD KEY `IDX_44876BD771381BB3` (`id_orden_trabajo_id`);

--
-- Indexes for table `movimiento_producto`
--
ALTER TABLE `movimiento_producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FFC0EDFC6E57A479` (`id_producto_id`),
  ADD KEY `IDX_FFC0EDFC6601BA07` (`id_documento_id`),
  ADD KEY `IDX_FFC0EDFC7A4F962` (`id_tipo_documento_id`),
  ADD KEY `IDX_FFC0EDFC7EB2C349` (`id_usuario_id`),
  ADD KEY `IDX_FFC0EDFCC59B01FF` (`id_centro_costo_id`),
  ADD KEY `IDX_FFC0EDFCF66372E9` (`id_elemento_gasto_id`),
  ADD KEY `IDX_FFC0EDFC39161EBF` (`id_almacen_id`),
  ADD KEY `IDX_FFC0EDFC71381BB3` (`id_orden_trabajo_id`),
  ADD KEY `IDX_FFC0EDFCF5DBAF2B` (`id_expediente_id`);

--
-- Indexes for table `movimiento_venta`
--
ALTER TABLE `movimiento_venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8E3F7AE555C5F988` (`id_factura_id`),
  ADD KEY `IDX_8E3F7AE539161EBF` (`id_almacen_id`);

--
-- Indexes for table `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `obligacion_cobro`
--
ALTER TABLE `obligacion_cobro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_807C726D55C5F988` (`id_factura_id`);

--
-- Indexes for table `obligacion_pago`
--
ALTER TABLE `obligacion_pago`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_403C9B3BE8F12801` (`id_proveedor_id`),
  ADD KEY `IDX_403C9B3B6601BA07` (`id_documento_id`),
  ADD KEY `IDX_403C9B3B1D34FA6B` (`id_unidad_id`);

--
-- Indexes for table `orden_trabajo`
--
ALTER TABLE `orden_trabajo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4158A0241D34FA6B` (`id_unidad_id`),
  ADD KEY `IDX_4158A02439161EBF` (`id_almacen_id`);

--
-- Indexes for table `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A7BB0615E2C70A62` (`id_amlacen_id`),
  ADD KEY `IDX_A7BB0615E16A5625` (`id_unidad_medida_id`);

--
-- Indexes for table `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provincias`
--
ALTER TABLE `provincias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registro_comprobantes`
--
ALTER TABLE `registro_comprobantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B2D1B2B21D34FA6B` (`id_unidad_id`),
  ADD KEY `IDX_B2D1B2B2EF5F7851` (`id_tipo_comprobante_id`),
  ADD KEY `IDX_B2D1B2B27EB2C349` (`id_usuario_id`),
  ADD KEY `IDX_B2D1B2B239161EBF` (`id_almacen_id`);

--
-- Indexes for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saldo_cuentas`
--
ALTER TABLE `saldo_cuentas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BB2B71AE1ADA4D3F` (`id_cuenta_id`),
  ADD KEY `IDX_BB2B71AE2D412F53` (`id_subcuenta_id`),
  ADD KEY `IDX_BB2B71AEC59B01FF` (`id_centro_costo_id`),
  ADD KEY `IDX_BB2B71AEF66372E9` (`id_elemento_gasto_id`),
  ADD KEY `IDX_BB2B71AE39161EBF` (`id_almacen_id`),
  ADD KEY `IDX_BB2B71AE1D34FA6B` (`id_unidad_id`),
  ADD KEY `IDX_BB2B71AEE8F12801` (`id_proveedor_id`),
  ADD KEY `IDX_BB2B71AEF5DBAF2B` (`id_expediente_id`),
  ADD KEY `IDX_BB2B71AE71381BB3` (`id_orden_trabajo_id`);

--
-- Indexes for table `stripe_factura`
--
ALTER TABLE `stripe_factura`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcuenta`
--
ALTER TABLE `subcuenta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_57BB37EA1ADA4D3F` (`id_cuenta_id`);

--
-- Indexes for table `subcuenta_criterio_analisis`
--
ALTER TABLE `subcuenta_criterio_analisis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_52A4A7682D412F53` (`id_subcuenta_id`),
  ADD KEY `IDX_52A4A7685ABBE5F6` (`id_criterio_analisis_id`);

--
-- Indexes for table `subcuenta_proveedor`
--
ALTER TABLE `subcuenta_proveedor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5C22E4B82D412F53` (`id_subcuenta_id`),
  ADD KEY `IDX_5C22E4B8E8F12801` (`id_proveedor_id`);

--
-- Indexes for table `tasa_cambio`
--
ALTER TABLE `tasa_cambio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DAB48606FA5CADE9` (`id_moneda_origen_id`),
  ADD KEY `IDX_DAB48606D85CECF7` (`id_moneda_destino_id`);

--
-- Indexes for table `test_crud`
--
ALTER TABLE `test_crud`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipo_comprobante`
--
ALTER TABLE `tipo_comprobante`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipo_cuenta`
--
ALTER TABLE `tipo_cuenta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipo_documento_activo_fijo`
--
ALTER TABLE `tipo_documento_activo_fijo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipo_movimiento`
--
ALTER TABLE `tipo_movimiento`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transferencia`
--
ALTER TABLE `transferencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_EDC227306601BA07` (`id_documento_id`),
  ADD KEY `IDX_EDC227301D34FA6B` (`id_unidad_id`),
  ADD KEY `IDX_EDC2273039161EBF` (`id_almacen_id`);

--
-- Indexes for table `unidad`
--
ALTER TABLE `unidad`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_F3E6D02F3A909126` (`nombre`),
  ADD UNIQUE KEY `UNIQ_F3E6D02F20332D99` (`codigo`),
  ADD KEY `IDX_F3E6D02F31E700CD` (`id_padre_id`);

--
-- Indexes for table `unidad_medida`
--
ALTER TABLE `unidad_medida`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`);

--
-- Indexes for table `vale_salida`
--
ALTER TABLE `vale_salida`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_90C265C86601BA07` (`id_documento_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activo_fijo`
--
ALTER TABLE `activo_fijo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `activo_fijo_cuentas`
--
ALTER TABLE `activo_fijo_cuentas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `activo_fijo_movimiento_activo_fijo`
--
ALTER TABLE `activo_fijo_movimiento_activo_fijo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ajuste`
--
ALTER TABLE `ajuste`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `almacen`
--
ALTER TABLE `almacen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `almacen_ocupado`
--
ALTER TABLE `almacen_ocupado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `area_responsabilidad`
--
ALTER TABLE `area_responsabilidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `centro_costo`
--
ALTER TABLE `centro_costo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cierre`
--
ALTER TABLE `cierre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `cierre_diario`
--
ALTER TABLE `cierre_diario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cliente_beneficiario`
--
ALTER TABLE `cliente_beneficiario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cliente_contabilidad`
--
ALTER TABLE `cliente_contabilidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cliente_reporte`
--
ALTER TABLE `cliente_reporte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comprobante_cierre`
--
ALTER TABLE `comprobante_cierre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `configuracion_inicial`
--
ALTER TABLE `configuracion_inicial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contratos_cliente`
--
ALTER TABLE `contratos_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `criterio_analisis`
--
ALTER TABLE `criterio_analisis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `cuadre_diario`
--
ALTER TABLE `cuadre_diario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `cuenta`
--
ALTER TABLE `cuenta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `cuentas_cliente`
--
ALTER TABLE `cuentas_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cuenta_criterio_analisis`
--
ALTER TABLE `cuenta_criterio_analisis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `custom_user`
--
ALTER TABLE `custom_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `depreciacion`
--
ALTER TABLE `depreciacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `devolucion`
--
ALTER TABLE `devolucion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `documento`
--
ALTER TABLE `documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `elemento_gasto`
--
ALTER TABLE `elemento_gasto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expediente`
--
ALTER TABLE `expediente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `factura`
--
ALTER TABLE `factura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grupo_activos`
--
ALTER TABLE `grupo_activos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `informe_recepcion`
--
ALTER TABLE `informe_recepcion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `instrumento_cobro`
--
ALTER TABLE `instrumento_cobro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mercancia`
--
ALTER TABLE `mercancia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `mercancia_producto`
--
ALTER TABLE `mercancia_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `moneda`
--
ALTER TABLE `moneda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `movimiento`
--
ALTER TABLE `movimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movimiento_activo_fijo`
--
ALTER TABLE `movimiento_activo_fijo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movimiento_mercancia`
--
ALTER TABLE `movimiento_mercancia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT for table `movimiento_producto`
--
ALTER TABLE `movimiento_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `movimiento_venta`
--
ALTER TABLE `movimiento_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `municipios`
--
ALTER TABLE `municipios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `obligacion_cobro`
--
ALTER TABLE `obligacion_cobro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `obligacion_pago`
--
ALTER TABLE `obligacion_pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orden_trabajo`
--
ALTER TABLE `orden_trabajo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `provincias`
--
ALTER TABLE `provincias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registro_comprobantes`
--
ALTER TABLE `registro_comprobantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saldo_cuentas`
--
ALTER TABLE `saldo_cuentas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stripe_factura`
--
ALTER TABLE `stripe_factura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subcuenta`
--
ALTER TABLE `subcuenta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `subcuenta_criterio_analisis`
--
ALTER TABLE `subcuenta_criterio_analisis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `subcuenta_proveedor`
--
ALTER TABLE `subcuenta_proveedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tasa_cambio`
--
ALTER TABLE `tasa_cambio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_crud`
--
ALTER TABLE `test_crud`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipo_cuenta`
--
ALTER TABLE `tipo_cuenta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tipo_documento_activo_fijo`
--
ALTER TABLE `tipo_documento_activo_fijo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipo_movimiento`
--
ALTER TABLE `tipo_movimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transferencia`
--
ALTER TABLE `transferencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `unidad`
--
ALTER TABLE `unidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vale_salida`
--
ALTER TABLE `vale_salida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activo_fijo`
--
ALTER TABLE `activo_fijo`
  ADD CONSTRAINT `FK_75EBC93E1D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_75EBC93E4A667A2B` FOREIGN KEY (`id_grupo_activo_id`) REFERENCES `grupo_activos` (`id`),
  ADD CONSTRAINT `FK_75EBC93E6FBA0327` FOREIGN KEY (`id_tipo_movimiento_baja_id`) REFERENCES `tipo_movimiento` (`id`),
  ADD CONSTRAINT `FK_75EBC93ED410562` FOREIGN KEY (`id_area_responsabilidad_id`) REFERENCES `area_responsabilidad` (`id`),
  ADD CONSTRAINT `FK_75EBC93EDB763453` FOREIGN KEY (`id_tipo_movimiento_id`) REFERENCES `tipo_movimiento` (`id`);

--
-- Constraints for table `activo_fijo_cuentas`
--
ALTER TABLE `activo_fijo_cuentas`
  ADD CONSTRAINT `FK_E0DF29012955A16D` FOREIGN KEY (`id_centro_costo_activo_id`) REFERENCES `centro_costo` (`id`),
  ADD CONSTRAINT `FK_E0DF29014476721E` FOREIGN KEY (`id_subcuenta_activo_id`) REFERENCES `subcuenta` (`id`),
  ADD CONSTRAINT `FK_E0DF29014C675596` FOREIGN KEY (`id_area_responsabilidad_activo_id`) REFERENCES `area_responsabilidad` (`id`),
  ADD CONSTRAINT `FK_E0DF2901549C81D9` FOREIGN KEY (`id_subcuenta_depreciacion_id`) REFERENCES `subcuenta` (`id`),
  ADD CONSTRAINT `FK_E0DF290157677646` FOREIGN KEY (`id_subcuenta_gasto_id`) REFERENCES `subcuenta` (`id`),
  ADD CONSTRAINT `FK_E0DF290174A5FFBA` FOREIGN KEY (`id_cuenta_depreciacion_id`) REFERENCES `cuenta` (`id`),
  ADD CONSTRAINT `FK_E0DF290180C608FA` FOREIGN KEY (`id_cuenta_gasto_id`) REFERENCES `cuenta` (`id`),
  ADD CONSTRAINT `FK_E0DF290186762CC7` FOREIGN KEY (`id_cuenta_activo_id`) REFERENCES `cuenta` (`id`),
  ADD CONSTRAINT `FK_E0DF2901A752F04B` FOREIGN KEY (`id_elemento_gasto_gasto_id`) REFERENCES `elemento_gasto` (`id`),
  ADD CONSTRAINT `FK_E0DF2901A950EE53` FOREIGN KEY (`id_centro_costo_gasto_id`) REFERENCES `centro_costo` (`id`),
  ADD CONSTRAINT `FK_E0DF2901C84BDE84` FOREIGN KEY (`id_activo_id`) REFERENCES `activo_fijo` (`id`);

--
-- Constraints for table `activo_fijo_movimiento_activo_fijo`
--
ALTER TABLE `activo_fijo_movimiento_activo_fijo`
  ADD CONSTRAINT `FK_2FA61FF25832E72E` FOREIGN KEY (`id_activo_fijo_id`) REFERENCES `activo_fijo` (`id`),
  ADD CONSTRAINT `FK_2FA61FF27786CA71` FOREIGN KEY (`id_movimiento_activo_fijo_id`) REFERENCES `movimiento` (`id`);

--
-- Constraints for table `ajuste`
--
ALTER TABLE `ajuste`
  ADD CONSTRAINT `FK_DD35BD326601BA07` FOREIGN KEY (`id_documento_id`) REFERENCES `documento` (`id`);

--
-- Constraints for table `almacen`
--
ALTER TABLE `almacen`
  ADD CONSTRAINT `FK_D5B2D2501D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`);

--
-- Constraints for table `almacen_ocupado`
--
ALTER TABLE `almacen_ocupado`
  ADD CONSTRAINT `FK_AA53605839161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_AA5360587EB2C349` FOREIGN KEY (`id_usuario_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `area_responsabilidad`
--
ALTER TABLE `area_responsabilidad`
  ADD CONSTRAINT `FK_F469C2BA1D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`);

--
-- Constraints for table `centro_costo`
--
ALTER TABLE `centro_costo`
  ADD CONSTRAINT `FK_749608CE1D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`);

--
-- Constraints for table `cierre`
--
ALTER TABLE `cierre`
  ADD CONSTRAINT `FK_D0DCFCC739161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_D0DCFCC77EB2C349` FOREIGN KEY (`id_usuario_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `cierre_diario`
--
ALTER TABLE `cierre_diario`
  ADD CONSTRAINT `FK_F3D0CD8939161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_F3D0CD897EB2C349` FOREIGN KEY (`id_usuario_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `comprobante_cierre`
--
ALTER TABLE `comprobante_cierre`
  ADD CONSTRAINT `FK_D03EA4C51800963C` FOREIGN KEY (`id_comprobante_id`) REFERENCES `registro_comprobantes` (`id`),
  ADD CONSTRAINT `FK_D03EA4C545F8C94C` FOREIGN KEY (`id_cierre_id`) REFERENCES `cierre` (`id`);

--
-- Constraints for table `configuracion_inicial`
--
ALTER TABLE `configuracion_inicial`
  ADD CONSTRAINT `FK_8521BE24404AE9D2` FOREIGN KEY (`id_modulo_id`) REFERENCES `modulo` (`id`),
  ADD CONSTRAINT `FK_8521BE247A4F962` FOREIGN KEY (`id_tipo_documento_id`) REFERENCES `tipo_documento` (`id`);

--
-- Constraints for table `contratos_cliente`
--
ALTER TABLE `contratos_cliente`
  ADD CONSTRAINT `FK_29A5BB47374388F5` FOREIGN KEY (`id_moneda_id`) REFERENCES `moneda` (`id`),
  ADD CONSTRAINT `FK_29A5BB477BF9CE86` FOREIGN KEY (`id_cliente_id`) REFERENCES `cliente_contabilidad` (`id`);

--
-- Constraints for table `cuadre_diario`
--
ALTER TABLE `cuadre_diario`
  ADD CONSTRAINT `FK_60ABEFD91ADA4D3F` FOREIGN KEY (`id_cuenta_id`) REFERENCES `cuenta` (`id`),
  ADD CONSTRAINT `FK_60ABEFD92D412F53` FOREIGN KEY (`id_subcuenta_id`) REFERENCES `subcuenta` (`id`),
  ADD CONSTRAINT `FK_60ABEFD939161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_60ABEFD945F8C94C` FOREIGN KEY (`id_cierre_id`) REFERENCES `cierre` (`id`);

--
-- Constraints for table `cuenta`
--
ALTER TABLE `cuenta`
  ADD CONSTRAINT `FK_31C7BFCF45E7F350` FOREIGN KEY (`id_tipo_cuenta_id`) REFERENCES `tipo_cuenta` (`id`);

--
-- Constraints for table `cuentas_cliente`
--
ALTER TABLE `cuentas_cliente`
  ADD CONSTRAINT `FK_64653310374388F5` FOREIGN KEY (`id_moneda_id`) REFERENCES `moneda` (`id`),
  ADD CONSTRAINT `FK_646533107BF9CE86` FOREIGN KEY (`id_cliente_id`) REFERENCES `cliente_contabilidad` (`id`);

--
-- Constraints for table `cuenta_criterio_analisis`
--
ALTER TABLE `cuenta_criterio_analisis`
  ADD CONSTRAINT `FK_AF040B091ADA4D3F` FOREIGN KEY (`id_cuenta_id`) REFERENCES `cuenta` (`id`),
  ADD CONSTRAINT `FK_AF040B095ABBE5F6` FOREIGN KEY (`id_criterio_analisis_id`) REFERENCES `criterio_analisis` (`id`);

--
-- Constraints for table `custom_user`
--
ALTER TABLE `custom_user`
  ADD CONSTRAINT `FK_8CE51EB479F37AE5` FOREIGN KEY (`id_user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `depreciacion`
--
ALTER TABLE `depreciacion`
  ADD CONSTRAINT `FK_D618AE145832E72E` FOREIGN KEY (`id_activo_fijo_id`) REFERENCES `activo_fijo` (`id`);

--
-- Constraints for table `devolucion`
--
ALTER TABLE `devolucion`
  ADD CONSTRAINT `FK_524D9F671D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_524D9F6739161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_524D9F675074DD86` FOREIGN KEY (`id_orden_tabajo_id`) REFERENCES `orden_trabajo` (`id`),
  ADD CONSTRAINT `FK_524D9F676601BA07` FOREIGN KEY (`id_documento_id`) REFERENCES `documento` (`id`),
  ADD CONSTRAINT `FK_524D9F67C59B01FF` FOREIGN KEY (`id_centro_costo_id`) REFERENCES `centro_costo` (`id`),
  ADD CONSTRAINT `FK_524D9F67F66372E9` FOREIGN KEY (`id_elemento_gasto_id`) REFERENCES `elemento_gasto` (`id`);

--
-- Constraints for table `documento`
--
ALTER TABLE `documento`
  ADD CONSTRAINT `FK_B6B12EC71D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_B6B12EC7374388F5` FOREIGN KEY (`id_moneda_id`) REFERENCES `moneda` (`id`),
  ADD CONSTRAINT `FK_B6B12EC739161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_B6B12EC77A4F962` FOREIGN KEY (`id_tipo_documento_id`) REFERENCES `tipo_documento` (`id`);

--
-- Constraints for table `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `FK_D9D9BF521D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_D9D9BF527EB2C349` FOREIGN KEY (`id_usuario_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_D9D9BF52D1E12F15` FOREIGN KEY (`id_cargo_id`) REFERENCES `cargo` (`id`);

--
-- Constraints for table `expediente`
--
ALTER TABLE `expediente`
  ADD CONSTRAINT `FK_D59CA4131D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`);

--
-- Constraints for table `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `FK_F9EBA0091D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_F9EBA00968BCB606` FOREIGN KEY (`id_contrato_id`) REFERENCES `contratos_cliente` (`id`),
  ADD CONSTRAINT `FK_F9EBA0097EB2C349` FOREIGN KEY (`id_usuario_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `informe_recepcion`
--
ALTER TABLE `informe_recepcion`
  ADD CONSTRAINT `FK_62A4EBD6601BA07` FOREIGN KEY (`id_documento_id`) REFERENCES `documento` (`id`),
  ADD CONSTRAINT `FK_62A4EBDE8F12801` FOREIGN KEY (`id_proveedor_id`) REFERENCES `proveedor` (`id`);

--
-- Constraints for table `mercancia`
--
ALTER TABLE `mercancia`
  ADD CONSTRAINT `FK_9D094AE0E16A5625` FOREIGN KEY (`id_unidad_medida_id`) REFERENCES `unidad_medida` (`id`),
  ADD CONSTRAINT `FK_9D094AE0E2C70A62` FOREIGN KEY (`id_amlacen_id`) REFERENCES `almacen` (`id`);

--
-- Constraints for table `mercancia_producto`
--
ALTER TABLE `mercancia_producto`
  ADD CONSTRAINT `FK_3F705CF56E57A479` FOREIGN KEY (`id_producto_id`) REFERENCES `producto` (`id`),
  ADD CONSTRAINT `FK_3F705CF59F287F54` FOREIGN KEY (`id_mercancia_id`) REFERENCES `mercancia` (`id`);

--
-- Constraints for table `movimiento`
--
ALTER TABLE `movimiento`
  ADD CONSTRAINT `FK_C8FF107A4F781EA` FOREIGN KEY (`id_unidad_destino_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_C8FF107A873C7FC7` FOREIGN KEY (`id_unidad_origen_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_C8FF107AD1CE493D` FOREIGN KEY (`id_tipo_documento_activo_fijo_id`) REFERENCES `tipo_documento_activo_fijo` (`id`),
  ADD CONSTRAINT `FK_C8FF107ADB763453` FOREIGN KEY (`id_tipo_movimiento_id`) REFERENCES `tipo_movimiento` (`id`);

--
-- Constraints for table `movimiento_activo_fijo`
--
ALTER TABLE `movimiento_activo_fijo`
  ADD CONSTRAINT `FK_A985A0DA1ADA4D3F` FOREIGN KEY (`id_cuenta_id`) REFERENCES `cuenta` (`id`),
  ADD CONSTRAINT `FK_A985A0DA1D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_A985A0DA2D412F53` FOREIGN KEY (`id_subcuenta_id`) REFERENCES `subcuenta` (`id`),
  ADD CONSTRAINT `FK_A985A0DA5832E72E` FOREIGN KEY (`id_activo_fijo_id`) REFERENCES `activo_fijo` (`id`),
  ADD CONSTRAINT `FK_A985A0DA7EB2C349` FOREIGN KEY (`id_usuario_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_A985A0DADB763453` FOREIGN KEY (`id_tipo_movimiento_id`) REFERENCES `tipo_movimiento` (`id`);

--
-- Constraints for table `movimiento_mercancia`
--
ALTER TABLE `movimiento_mercancia`
  ADD CONSTRAINT `FK_44876BD739161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_44876BD76601BA07` FOREIGN KEY (`id_documento_id`) REFERENCES `documento` (`id`),
  ADD CONSTRAINT `FK_44876BD771381BB3` FOREIGN KEY (`id_orden_trabajo_id`) REFERENCES `orden_trabajo` (`id`),
  ADD CONSTRAINT `FK_44876BD77A4F962` FOREIGN KEY (`id_tipo_documento_id`) REFERENCES `tipo_documento` (`id`),
  ADD CONSTRAINT `FK_44876BD77EB2C349` FOREIGN KEY (`id_usuario_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_44876BD79F287F54` FOREIGN KEY (`id_mercancia_id`) REFERENCES `mercancia` (`id`),
  ADD CONSTRAINT `FK_44876BD7C59B01FF` FOREIGN KEY (`id_centro_costo_id`) REFERENCES `centro_costo` (`id`),
  ADD CONSTRAINT `FK_44876BD7F5DBAF2B` FOREIGN KEY (`id_expediente_id`) REFERENCES `expediente` (`id`),
  ADD CONSTRAINT `FK_44876BD7F66372E9` FOREIGN KEY (`id_elemento_gasto_id`) REFERENCES `elemento_gasto` (`id`);

--
-- Constraints for table `movimiento_producto`
--
ALTER TABLE `movimiento_producto`
  ADD CONSTRAINT `FK_FFC0EDFC39161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_FFC0EDFC6601BA07` FOREIGN KEY (`id_documento_id`) REFERENCES `documento` (`id`),
  ADD CONSTRAINT `FK_FFC0EDFC6E57A479` FOREIGN KEY (`id_producto_id`) REFERENCES `producto` (`id`),
  ADD CONSTRAINT `FK_FFC0EDFC71381BB3` FOREIGN KEY (`id_orden_trabajo_id`) REFERENCES `orden_trabajo` (`id`),
  ADD CONSTRAINT `FK_FFC0EDFC7A4F962` FOREIGN KEY (`id_tipo_documento_id`) REFERENCES `tipo_documento` (`id`),
  ADD CONSTRAINT `FK_FFC0EDFC7EB2C349` FOREIGN KEY (`id_usuario_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_FFC0EDFCC59B01FF` FOREIGN KEY (`id_centro_costo_id`) REFERENCES `centro_costo` (`id`),
  ADD CONSTRAINT `FK_FFC0EDFCF5DBAF2B` FOREIGN KEY (`id_expediente_id`) REFERENCES `expediente` (`id`),
  ADD CONSTRAINT `FK_FFC0EDFCF66372E9` FOREIGN KEY (`id_elemento_gasto_id`) REFERENCES `elemento_gasto` (`id`);

--
-- Constraints for table `movimiento_venta`
--
ALTER TABLE `movimiento_venta`
  ADD CONSTRAINT `FK_8E3F7AE539161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_8E3F7AE555C5F988` FOREIGN KEY (`id_factura_id`) REFERENCES `factura` (`id`);

--
-- Constraints for table `obligacion_cobro`
--
ALTER TABLE `obligacion_cobro`
  ADD CONSTRAINT `FK_807C726D55C5F988` FOREIGN KEY (`id_factura_id`) REFERENCES `factura` (`id`);

--
-- Constraints for table `obligacion_pago`
--
ALTER TABLE `obligacion_pago`
  ADD CONSTRAINT `FK_403C9B3B1D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_403C9B3B6601BA07` FOREIGN KEY (`id_documento_id`) REFERENCES `documento` (`id`),
  ADD CONSTRAINT `FK_403C9B3BE8F12801` FOREIGN KEY (`id_proveedor_id`) REFERENCES `proveedor` (`id`);

--
-- Constraints for table `orden_trabajo`
--
ALTER TABLE `orden_trabajo`
  ADD CONSTRAINT `FK_4158A0241D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_4158A02439161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`);

--
-- Constraints for table `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `FK_A7BB0615E16A5625` FOREIGN KEY (`id_unidad_medida_id`) REFERENCES `unidad_medida` (`id`),
  ADD CONSTRAINT `FK_A7BB0615E2C70A62` FOREIGN KEY (`id_amlacen_id`) REFERENCES `almacen` (`id`);

--
-- Constraints for table `registro_comprobantes`
--
ALTER TABLE `registro_comprobantes`
  ADD CONSTRAINT `FK_B2D1B2B21D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_B2D1B2B239161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_B2D1B2B27EB2C349` FOREIGN KEY (`id_usuario_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_B2D1B2B2EF5F7851` FOREIGN KEY (`id_tipo_comprobante_id`) REFERENCES `tipo_comprobante` (`id`);

--
-- Constraints for table `saldo_cuentas`
--
ALTER TABLE `saldo_cuentas`
  ADD CONSTRAINT `FK_BB2B71AE1ADA4D3F` FOREIGN KEY (`id_cuenta_id`) REFERENCES `cuenta` (`id`),
  ADD CONSTRAINT `FK_BB2B71AE1D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_BB2B71AE2D412F53` FOREIGN KEY (`id_subcuenta_id`) REFERENCES `subcuenta` (`id`),
  ADD CONSTRAINT `FK_BB2B71AE39161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_BB2B71AE71381BB3` FOREIGN KEY (`id_orden_trabajo_id`) REFERENCES `orden_trabajo` (`id`),
  ADD CONSTRAINT `FK_BB2B71AEC59B01FF` FOREIGN KEY (`id_centro_costo_id`) REFERENCES `centro_costo` (`id`),
  ADD CONSTRAINT `FK_BB2B71AEE8F12801` FOREIGN KEY (`id_proveedor_id`) REFERENCES `proveedor` (`id`),
  ADD CONSTRAINT `FK_BB2B71AEF5DBAF2B` FOREIGN KEY (`id_expediente_id`) REFERENCES `expediente` (`id`),
  ADD CONSTRAINT `FK_BB2B71AEF66372E9` FOREIGN KEY (`id_elemento_gasto_id`) REFERENCES `elemento_gasto` (`id`);

--
-- Constraints for table `subcuenta`
--
ALTER TABLE `subcuenta`
  ADD CONSTRAINT `FK_57BB37EA1ADA4D3F` FOREIGN KEY (`id_cuenta_id`) REFERENCES `cuenta` (`id`);

--
-- Constraints for table `subcuenta_criterio_analisis`
--
ALTER TABLE `subcuenta_criterio_analisis`
  ADD CONSTRAINT `FK_52A4A7682D412F53` FOREIGN KEY (`id_subcuenta_id`) REFERENCES `subcuenta` (`id`),
  ADD CONSTRAINT `FK_52A4A7685ABBE5F6` FOREIGN KEY (`id_criterio_analisis_id`) REFERENCES `criterio_analisis` (`id`);

--
-- Constraints for table `subcuenta_proveedor`
--
ALTER TABLE `subcuenta_proveedor`
  ADD CONSTRAINT `FK_5C22E4B82D412F53` FOREIGN KEY (`id_subcuenta_id`) REFERENCES `subcuenta` (`id`),
  ADD CONSTRAINT `FK_5C22E4B8E8F12801` FOREIGN KEY (`id_proveedor_id`) REFERENCES `proveedor` (`id`);

--
-- Constraints for table `tasa_cambio`
--
ALTER TABLE `tasa_cambio`
  ADD CONSTRAINT `FK_DAB48606D85CECF7` FOREIGN KEY (`id_moneda_destino_id`) REFERENCES `moneda` (`id`),
  ADD CONSTRAINT `FK_DAB48606FA5CADE9` FOREIGN KEY (`id_moneda_origen_id`) REFERENCES `moneda` (`id`);

--
-- Constraints for table `transferencia`
--
ALTER TABLE `transferencia`
  ADD CONSTRAINT `FK_EDC227301D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_EDC2273039161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_EDC227306601BA07` FOREIGN KEY (`id_documento_id`) REFERENCES `documento` (`id`);

--
-- Constraints for table `unidad`
--
ALTER TABLE `unidad`
  ADD CONSTRAINT `FK_F3E6D02F31E700CD` FOREIGN KEY (`id_padre_id`) REFERENCES `unidad` (`id`);

--
-- Constraints for table `vale_salida`
--
ALTER TABLE `vale_salida`
  ADD CONSTRAINT `FK_90C265C86601BA07` FOREIGN KEY (`id_documento_id`) REFERENCES `documento` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
