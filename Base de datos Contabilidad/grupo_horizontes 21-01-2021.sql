-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2021 at 12:02 PM
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

--
-- Dumping data for table `activo_fijo`
--

INSERT INTO `activo_fijo` (`id`, `id_unidad_id`, `id_grupo_activo_id`, `id_tipo_movimiento_baja_id`, `nro_inventario`, `valor_inicial`, `descripcion`, `fecha_alta`, `activo`, `fecha_baja`, `pais`, `id_tipo_movimiento_id`, `id_area_responsabilidad_id`, `nro_consecutivo`, `nro_documento_baja`, `depreciacion_acumulada`, `valor_real`, `annos_vida_util`, `modelo`, `tipo`, `marca`, `nro_motor`, `nro_serie`, `nro_chapa`, `nro_chasis`, `combustible`, `fecha_ultima_depreciacion`) VALUES
(22, 1, 1, NULL, '214', 100, 'Monitor de Computadora', '2021-01-01', 1, NULL, 'CUBA', NULL, 1, 1, NULL, 20.83, 79.17, 10, 'ViewSonic', 'Monitor', 'Sonic', '', '', '', '', '', '2020-12-03'),
(23, 1, 1, 6, '91', 500, 'Torre de PC', '2021-01-04', 0, '2021-01-05', 'CUBA', NULL, 1, 1, 2, 0, 500, 10, 'ASUS-PG421', 'PC de Escritorio', 'ASUS', '', '', '', '', '', NULL),
(24, 1, 1, 6, '091', 55, 'Mouse y Teclado', '2021-01-04', 0, '2021-01-04', 'CUBA', NULL, 1, 1, 1, 15, 40, 2, ' Logitech-950', 'Mouse y Teclado', 'Logitech', '', '', '', '', '', '2021-01-04'),
(25, 1, 2, NULL, '19233', 250, 'Buro de Trabajo', '2021-01-04', 0, NULL, 'CUBA', NULL, 1, 1, NULL, 0, 250, 10, 'Convencional', 'Buro de Trabjo', 'Artesanal', '', '', '', '', '', NULL),
(26, 1, 2, 6, '192', 2500, 'Buro de Trabjo', '2021-01-04', 0, '2021-01-06', 'CUBA', NULL, 1, 1, 3, 0, 2500, 10, 'Convensional', 'Buro de Trabajo', 'ArtexProductions', '', '', '', '', '', NULL),
(27, 1, 1, NULL, 'kmilo', 100, 'kamilo inc.', '2021-01-11', 1, NULL, 'CUBA', NULL, 1, 1, NULL, 0, 100, 10, 'k.inc', 'personal', 'kmilo', '', '', '', '', '', NULL);

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
  `id_elemento_gasto_gasto_id` int(11) NOT NULL,
  `id_cuenta_acreedora_id` int(11) DEFAULT NULL,
  `id_subcuenta_acreedora_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activo_fijo_cuentas`
--

INSERT INTO `activo_fijo_cuentas` (`id`, `id_activo_id`, `id_cuenta_activo_id`, `id_subcuenta_activo_id`, `id_centro_costo_activo_id`, `id_area_responsabilidad_activo_id`, `id_cuenta_depreciacion_id`, `id_subcuenta_depreciacion_id`, `id_cuenta_gasto_id`, `id_subcuenta_gasto_id`, `id_centro_costo_gasto_id`, `id_elemento_gasto_gasto_id`, `id_cuenta_acreedora_id`, `id_subcuenta_acreedora_id`) VALUES
(22, 22, 22, 138, 25, 1, 33, 134, 69, 97, 25, 1, 54, 38),
(23, 23, 22, 138, 25, 1, 33, 134, 69, 97, 25, 1, 54, 38),
(24, 24, 22, 138, 25, 1, 33, 134, 69, 97, 25, 1, 54, 38),
(25, 25, 22, 138, 25, 1, 33, 134, 69, 97, 25, 1, NULL, NULL),
(26, 26, 22, 138, 5, 1, 33, 134, 69, 97, 25, 1, 54, 38),
(27, 27, 22, 138, 9, 1, 33, 134, 69, 97, 9, 1, 54, 38);

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
-- Table structure for table `acumulado_vacaciones`
--

CREATE TABLE `acumulado_vacaciones` (
  `id` int(11) NOT NULL,
  `id_empleado_id` int(11) NOT NULL,
  `dias` double NOT NULL,
  `dinero` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `agencias`
--

CREATE TABLE `agencias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
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
(16, 150, '696', 'UNIFICANDO CODIGOS', '0099', '', '1', 2020, 1, 0, ''),
(17, 151, '', 'UNIFICANDO CODIGOS', '', '697', '1', 2020, 1, 1, '0099'),
(18, 154, '', 'Sobrante en conteo fisico', '', '555', '2', 2020, 1, 1, '0020'),
(19, 155, '332', 'Faltante en conteo fisico', '0020', '', '2', 2020, 1, 0, '');

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
(1, 1, 'Almacén de Matriales y Mercancias', 1, '01'),
(2, 1, 'Almacén Mercancias para la Venta', 1, '02'),
(3, 1, 'Almacén de Productos Terminados', 1, '03');

-- --------------------------------------------------------

--
-- Table structure for table `almacen_ocupado`
--

CREATE TABLE `almacen_ocupado` (
  `id` int(11) NOT NULL,
  `id_almacen_id` int(11) NOT NULL,
  `id_usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

--
-- Dumping data for table `area_responsabilidad`
--

INSERT INTO `area_responsabilidad` (`id`, `id_unidad_id`, `codigo`, `nombre`, `activo`) VALUES
(1, 1, '0010', 'Area 1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `asiento`
--

CREATE TABLE `asiento` (
  `id` int(11) NOT NULL,
  `id_cuenta_id` int(11) NOT NULL,
  `id_subcuenta_id` int(11) NOT NULL,
  `id_documento_id` int(11) DEFAULT NULL,
  `id_almacen_id` int(11) DEFAULT NULL,
  `id_centro_costo_id` int(11) DEFAULT NULL,
  `id_elemento_gasto_id` int(11) DEFAULT NULL,
  `id_orden_trabajo_id` int(11) DEFAULT NULL,
  `id_expediente_id` int(11) DEFAULT NULL,
  `id_proveedor_id` int(11) DEFAULT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `tipo_cliente` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `anno` int(11) NOT NULL,
  `credito` double DEFAULT NULL,
  `debito` double DEFAULT NULL,
  `nro_documento` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_tipo_comprobante_id` int(11) DEFAULT NULL,
  `id_comprobante_id` int(11) DEFAULT NULL,
  `id_factura_id` int(11) DEFAULT NULL,
  `id_activo_fijo_id` int(11) DEFAULT NULL,
  `id_area_responsabilidad_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asiento`
--

INSERT INTO `asiento` (`id`, `id_cuenta_id`, `id_subcuenta_id`, `id_documento_id`, `id_almacen_id`, `id_centro_costo_id`, `id_elemento_gasto_id`, `id_orden_trabajo_id`, `id_expediente_id`, `id_proveedor_id`, `id_unidad_id`, `tipo_cliente`, `id_cliente`, `fecha`, `anno`, `credito`, `debito`, `nro_documento`, `id_tipo_comprobante_id`, `id_comprobante_id`, `id_factura_id`, `id_activo_fijo_id`, `id_area_responsabilidad_id`) VALUES
(67, 10, 65, 138, 1, NULL, NULL, NULL, NULL, 1, 1, 0, 0, '2020-12-13', 2020, 0, 81.18, 'IRM-1', 2, 26, NULL, NULL, NULL),
(68, 10, 65, 138, 1, NULL, NULL, NULL, NULL, 1, 1, 0, 0, '2020-12-13', 2020, 0, 45.23, 'IRM-1', 2, 26, NULL, NULL, NULL),
(69, 10, 65, 138, 1, NULL, NULL, NULL, NULL, 1, 1, 0, 0, '2020-12-13', 2020, 0, 112.5, 'IRM-1', 2, 26, NULL, NULL, NULL),
(70, 36, 63, 138, 1, NULL, NULL, NULL, NULL, 1, 1, 0, 0, '2020-12-13', 2020, 238.91, 0, 'IRM-1', 2, 26, NULL, NULL, NULL),
(71, 10, 65, 139, 1, NULL, NULL, NULL, NULL, 2, 1, 0, 0, '2020-12-13', 2020, 0, 30.1, 'IRM-2', 2, 26, NULL, NULL, NULL),
(72, 10, 65, 139, 1, NULL, NULL, NULL, NULL, 2, 1, 0, 0, '2020-12-13', 2020, 0, 28.4, 'IRM-2', 2, 26, NULL, NULL, NULL),
(73, 10, 65, 139, 1, NULL, NULL, NULL, NULL, 2, 1, 0, 0, '2020-12-13', 2020, 0, 70, 'IRM-2', 2, 26, NULL, NULL, NULL),
(74, 36, 63, 139, 1, NULL, NULL, NULL, NULL, 2, 1, 0, 0, '2020-12-13', 2020, 128.5, 0, 'IRM-2', 2, 26, NULL, NULL, NULL),
(75, 10, 66, 140, 1, NULL, NULL, NULL, NULL, 3, 1, 0, 0, '2020-12-13', 2020, 0, 60.3, 'IRM-3', 2, 26, NULL, NULL, NULL),
(76, 10, 66, 140, 1, NULL, NULL, NULL, NULL, 3, 1, 0, 0, '2020-12-13', 2020, 0, 39, 'IRM-3', 2, 26, NULL, NULL, NULL),
(77, 10, 66, 140, 1, NULL, NULL, NULL, NULL, 3, 1, 0, 0, '2020-12-13', 2020, 0, 30, 'IRM-3', 2, 26, NULL, NULL, NULL),
(78, 36, 63, 140, 1, NULL, NULL, NULL, NULL, 3, 1, 0, 0, '2020-12-13', 2020, 129.3, 0, 'IRM-3', 2, 26, NULL, NULL, NULL),
(79, 10, 66, 141, 1, NULL, NULL, NULL, NULL, 4, 1, 0, 0, '2020-12-13', 2020, 0, 10.13, 'IRM-4', 2, 26, NULL, NULL, NULL),
(80, 10, 66, 141, 1, NULL, NULL, NULL, NULL, 4, 1, 0, 0, '2020-12-13', 2020, 0, 3.96, 'IRM-4', 2, 26, NULL, NULL, NULL),
(81, 10, 66, 141, 1, NULL, NULL, NULL, NULL, 4, 1, 0, 0, '2020-12-13', 2020, 0, 31.64, 'IRM-4', 2, 26, NULL, NULL, NULL),
(82, 36, 63, 141, 1, NULL, NULL, NULL, NULL, 4, 1, 0, 0, '2020-12-13', 2020, 45.73, 0, 'IRM-4', 2, 26, NULL, NULL, NULL),
(83, 10, 67, 142, 1, NULL, NULL, NULL, NULL, 5, 1, 0, 0, '2020-11-20', 2020, 0, 3073.3, 'IRM-5', 2, 26, NULL, NULL, NULL),
(84, 10, 67, 142, 1, NULL, NULL, NULL, NULL, 5, 1, 0, 0, '2020-11-20', 2020, 0, 561, 'IRM-5', 2, 26, NULL, NULL, NULL),
(85, 10, 67, 142, 1, NULL, NULL, NULL, NULL, 5, 1, 0, 0, '2020-11-20', 2020, 0, 765.05, 'IRM-5', 2, 26, NULL, NULL, NULL),
(86, 36, 63, 142, 1, NULL, NULL, NULL, NULL, 5, 1, 0, 0, '2020-11-20', 2020, 4399.35, 0, 'IRM-5', 2, 26, NULL, NULL, NULL),
(87, 10, 67, 143, 1, NULL, NULL, NULL, NULL, 6, 1, 0, 0, '2020-11-20', 2020, 0, 190, 'IRM-6', 2, 26, NULL, NULL, NULL),
(88, 10, 67, 143, 1, NULL, NULL, NULL, NULL, 6, 1, 0, 0, '2020-11-20', 2020, 0, 1670.4, 'IRM-6', 2, 26, NULL, NULL, NULL),
(89, 10, 67, 143, 1, NULL, NULL, NULL, NULL, 6, 1, 0, 0, '2020-11-20', 2020, 0, 510, 'IRM-6', 2, 26, NULL, NULL, NULL),
(90, 36, 63, 143, 1, NULL, NULL, NULL, NULL, 6, 1, 0, 0, '2020-11-20', 2020, 2370.4, 0, 'IRM-6', 2, 26, NULL, NULL, NULL),
(91, 63, 51, 144, 1, 22, 2, NULL, NULL, NULL, 1, 0, 0, '2020-11-20', 2020, 0, 26.09, 'VSM-1', 2, 26, NULL, NULL, NULL),
(92, 10, 65, 144, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-20', 2020, 8.56, 0, 'VSM-1', 2, 26, NULL, NULL, NULL),
(93, 10, 65, 144, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-20', 2020, 5.03, 0, 'VSM-1', 2, 26, NULL, NULL, NULL),
(94, 10, 65, 144, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-20', 2020, 12.5, 0, 'VSM-1', 2, 26, NULL, NULL, NULL),
(95, 63, 51, 145, 1, 24, 3, 10, NULL, NULL, 1, 0, 0, '2020-11-20', 2020, 0, 15.25, 'VSM-2', 2, 26, NULL, NULL, NULL),
(96, 63, 51, 145, 1, 24, 7, 10, NULL, NULL, 1, 0, 0, '2020-11-20', 2020, 0, 3, 'VSM-2', 2, 26, NULL, NULL, NULL),
(97, 10, 66, 145, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-20', 2020, 10.05, 0, 'VSM-2', 2, 26, NULL, NULL, NULL),
(98, 10, 66, 145, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-20', 2020, 5.2, 0, 'VSM-2', 2, 26, NULL, NULL, NULL),
(99, 10, 66, 145, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-20', 2020, 3, 0, 'VSM-2', 2, 26, NULL, NULL, NULL),
(100, 63, 51, 146, 1, 23, 7, 11, NULL, NULL, 1, 0, 0, '2020-11-20', 2020, 0, 312.11, 'VSM-3', 2, 26, NULL, NULL, NULL),
(101, 10, 67, 146, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-20', 2020, 25.5, 0, 'VSM-3', 2, 26, NULL, NULL, NULL),
(102, 10, 67, 146, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-20', 2020, 225.89, 0, 'VSM-3', 2, 26, NULL, NULL, NULL),
(103, 10, 67, 146, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-20', 2020, 60.72, 0, 'VSM-3', 2, 26, NULL, NULL, NULL),
(104, 63, 51, 147, 1, 22, 2, 12, NULL, NULL, 1, 0, 0, '2020-11-20', 2020, 0, 18.26, 'VSM-4', 2, 26, NULL, NULL, NULL),
(105, 10, 65, 147, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-20', 2020, 5.99, 0, 'VSM-4', 2, 26, NULL, NULL, NULL),
(106, 10, 65, 147, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-20', 2020, 3.52, 0, 'VSM-4', 2, 26, NULL, NULL, NULL),
(107, 10, 65, 147, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-20', 2020, 8.75, 0, 'VSM-4', 2, 26, NULL, NULL, NULL),
(108, 63, 51, 148, 1, 24, 3, 13, NULL, NULL, 1, 0, 0, '2020-11-20', 2020, 0, 21.8, 'VSM-5', 2, 26, NULL, NULL, NULL),
(109, 10, 66, 148, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-20', 2020, 11.3, 0, 'VSM-5', 2, 26, NULL, NULL, NULL),
(110, 10, 66, 148, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-20', 2020, 6.75, 0, 'VSM-5', 2, 26, NULL, NULL, NULL),
(111, 10, 66, 148, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-20', 2020, 3.75, 0, 'VSM-5', 2, 26, NULL, NULL, NULL),
(112, 63, 51, 149, 1, 23, 7, 14, NULL, NULL, 1, 0, 0, '2020-11-20', 2020, 0, 561.79, 'VSM-6', 2, 26, NULL, NULL, NULL),
(113, 10, 67, 149, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-20', 2020, 45.9, 0, 'VSM-6', 2, 26, NULL, NULL, NULL),
(114, 10, 67, 149, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-20', 2020, 406.6, 0, 'VSM-6', 2, 26, NULL, NULL, NULL),
(115, 10, 67, 149, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-20', 2020, 109.29, 0, 'VSM-6', 2, 26, NULL, NULL, NULL),
(116, 10, 65, 150, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-21', 2020, 91.25, 0, 'AS-1', 2, 26, NULL, NULL, NULL),
(117, 10, 66, 150, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-21', 2020, 3.96, 0, 'AS-1', 2, 26, NULL, NULL, NULL),
(118, 61, 46, 150, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-21', 2020, 0, 95.21, 'AS-1', 2, 26, NULL, NULL, NULL),
(119, 10, 65, 151, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-21', 2020, 0, 91.25, 'AE-1', 2, 26, NULL, NULL, NULL),
(120, 10, 66, 151, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-21', 2020, 0, 3.96, 'AE-1', 2, 26, NULL, NULL, NULL),
(121, 62, 49, 151, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-21', 2020, 95.21, 0, 'AE-1', 2, 26, NULL, NULL, NULL),
(122, 10, 65, 152, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-21', 2020, 52.16, 0, 'TS-1', 2, 26, NULL, NULL, NULL),
(123, 10, 66, 152, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-21', 2020, 10.4, 0, 'TS-1', 2, 26, NULL, NULL, NULL),
(124, 10, 67, 152, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-21', 2020, 204, 0, 'TS-1', 2, 26, NULL, NULL, NULL),
(125, 10, 67, 152, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-21', 2020, 1807.2, 0, 'TS-1', 2, 26, NULL, NULL, NULL),
(126, 61, 45, 152, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-21', 2020, 0, 2073.76, 'TS-1', 2, 26, NULL, NULL, NULL),
(127, 15, 60, 153, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-21', 2020, 0, 52.16, 'TE-1', 2, 28, NULL, NULL, NULL),
(128, 15, 61, 153, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-21', 2020, 0, 10.4, 'TE-1', 2, 28, NULL, NULL, NULL),
(129, 15, 62, 153, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-21', 2020, 0, 204, 'TE-1', 2, 28, NULL, NULL, NULL),
(130, 15, 62, 153, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-21', 2020, 0, 1807.2, 'TE-1', 2, 28, NULL, NULL, NULL),
(131, 62, 48, 153, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-21', 2020, 2073.76, 0, 'TE-1', 2, 28, NULL, NULL, NULL),
(132, 10, 66, 154, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-27', 2020, 0, 0.52, 'AE-2', 2, 26, NULL, NULL, NULL),
(133, 50, 70, 154, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-27', 2020, 0.52, 0, 'AE-2', 2, 26, NULL, NULL, NULL),
(134, 10, 65, 155, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-27', 2020, 2.85, 0, 'AS-2', 2, 26, NULL, NULL, NULL),
(135, 30, 31, 155, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-27', 2020, 0, 2.85, 'AS-2', 2, 26, NULL, NULL, NULL),
(136, 69, 97, 156, 1, 25, 2, NULL, NULL, NULL, 1, 0, 0, '2020-11-27', 2020, 0, 5.44, 'VSM-7', 2, 26, NULL, NULL, NULL),
(137, 69, 97, 156, 1, 25, 7, NULL, NULL, NULL, 1, 0, 0, '2020-11-27', 2020, 0, 21.64, 'VSM-7', 2, 26, NULL, NULL, NULL),
(138, 69, 97, 156, 1, 24, 3, NULL, NULL, NULL, 1, 0, 0, '2020-11-27', 2020, 0, 2.94, 'VSM-7', 2, 26, NULL, NULL, NULL),
(139, 10, 65, 156, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-27', 2020, 2.01, 0, 'VSM-7', 2, 26, NULL, NULL, NULL),
(140, 10, 65, 156, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-27', 2020, 3.43, 0, 'VSM-7', 2, 26, NULL, NULL, NULL),
(141, 10, 67, 156, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-27', 2020, 12.14, 0, 'VSM-7', 2, 26, NULL, NULL, NULL),
(142, 10, 67, 156, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-27', 2020, 9.5, 0, 'VSM-7', 2, 26, NULL, NULL, NULL),
(143, 10, 66, 156, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-27', 2020, 2.94, 0, 'VSM-7', 2, 26, NULL, NULL, NULL),
(144, 10, 66, 157, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-27', 2020, 0, 10.05, 'D-1', 2, 26, NULL, NULL, NULL),
(145, 10, 66, 157, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-27', 2020, 0, 5.2, 'D-1', 2, 26, NULL, NULL, NULL),
(146, 10, 66, 157, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-27', 2020, 0, 3, 'D-1', 2, 26, NULL, NULL, NULL),
(147, 63, 51, 157, 1, 4, 3, 10, NULL, NULL, 1, 0, 0, '2020-11-27', 2020, 18.25, 0, 'D-1', 2, 26, NULL, NULL, NULL),
(148, 10, 67, 158, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-27', 2020, 0, 45.9, 'D-2', 2, 26, NULL, NULL, NULL),
(149, 10, 67, 158, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-27', 2020, 0, 406.6, 'D-2', 2, 26, NULL, NULL, NULL),
(150, 10, 67, 158, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-27', 2020, 0, 109.29, 'D-2', 2, 26, NULL, NULL, NULL),
(151, 63, 51, 158, 1, 3, 7, 14, NULL, NULL, 1, 0, 0, '2020-11-27', 2020, 561.79, 0, 'D-2', 2, 26, NULL, NULL, NULL),
(152, 15, 62, 159, 2, NULL, NULL, NULL, NULL, 9, 1, 0, 0, '2020-11-23', 2020, 0, 12500, 'IRM-1', 2, 28, NULL, NULL, NULL),
(153, 15, 62, 159, 2, NULL, NULL, NULL, NULL, 9, 1, 0, 0, '2020-11-23', 2020, 0, 10000, 'IRM-1', 2, 28, NULL, NULL, NULL),
(154, 15, 62, 159, 2, NULL, NULL, NULL, NULL, 9, 1, 0, 0, '2020-11-23', 2020, 0, 7500, 'IRM-1', 2, 28, NULL, NULL, NULL),
(155, 36, 63, 159, 2, NULL, NULL, NULL, NULL, 9, 1, 0, 0, '2020-11-23', 2020, 30000, 0, 'IRM-1', 2, 28, NULL, NULL, NULL),
(156, 15, 59, 160, 2, NULL, NULL, NULL, NULL, 7, 1, 0, 0, '2020-11-23', 2020, 0, 3000, 'IRM-2', 2, 28, NULL, NULL, NULL),
(157, 36, 63, 160, 2, NULL, NULL, NULL, NULL, 7, 1, 0, 0, '2020-11-23', 2020, 3000, 0, 'IRM-2', 2, 28, NULL, NULL, NULL),
(158, 15, 59, 161, 2, NULL, NULL, NULL, NULL, 8, 1, 0, 0, '2020-11-23', 2020, 0, 6000, 'IRM-3', 2, 28, NULL, NULL, NULL),
(159, 36, 63, 161, 2, NULL, NULL, NULL, NULL, 8, 1, 0, 0, '2020-11-23', 2020, 6000, 0, 'IRM-3', 2, 28, NULL, NULL, NULL),
(160, 15, 59, 162, 2, NULL, NULL, NULL, NULL, 7, 1, 0, 0, '2020-11-23', 2020, 0, 1500, 'IRM-4', 2, 28, NULL, NULL, NULL),
(161, 36, 63, 162, 2, NULL, NULL, NULL, NULL, 7, 1, 0, 0, '2020-11-23', 2020, 1500, 0, 'IRM-4', 2, 28, NULL, NULL, NULL),
(162, 14, 4, 163, 3, 22, NULL, 15, NULL, NULL, 1, 0, 0, '2020-11-24', 2020, 0, 26.09, 'IRP-1', 2, 27, NULL, NULL, NULL),
(163, 14, 4, 163, 3, 23, NULL, 11, NULL, NULL, 1, 0, 0, '2020-11-24', 2020, 0, 312.11, 'IRP-1', 2, 27, NULL, NULL, NULL),
(164, 63, 54, 163, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-24', 2020, 338.2, 0, 'IRP-1', 2, 27, NULL, NULL, NULL),
(165, 14, 4, 164, 3, 22, NULL, 12, NULL, NULL, 1, 0, 0, '2020-11-24', 2020, 0, 18.26, 'IRP-2', 2, 27, NULL, NULL, NULL),
(166, 14, 4, 164, 3, 24, NULL, 13, NULL, NULL, 1, 0, 0, '2020-11-24', 2020, 0, 21.8, 'IRP-2', 2, 27, NULL, NULL, NULL),
(167, 63, 54, 164, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-24', 2020, 40.06, 0, 'IRP-2', 2, 27, NULL, NULL, NULL),
(168, 63, 51, 165, 1, 22, 2, NULL, NULL, NULL, 1, 0, 0, '2020-11-28', 2020, 0, 83.59, 'VSM-8', 2, 26, NULL, NULL, NULL),
(169, 10, 65, 165, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-28', 2020, 25.71, 0, 'VSM-8', 2, 26, NULL, NULL, NULL),
(170, 10, 65, 165, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-28', 2020, 15.07, 0, 'VSM-8', 2, 26, NULL, NULL, NULL),
(171, 10, 65, 165, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-28', 2020, 42.81, 0, 'VSM-8', 2, 26, NULL, NULL, NULL),
(172, 63, 51, 166, 1, 23, 7, NULL, NULL, NULL, 1, 0, 0, '2020-11-28', 2020, 0, 1241.41, 'VSM-9', 2, 26, NULL, NULL, NULL),
(173, 10, 67, 166, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-28', 2020, 903.54, 0, 'VSM-9', 2, 26, NULL, NULL, NULL),
(174, 10, 67, 166, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-28', 2020, 242.87, 0, 'VSM-9', 2, 26, NULL, NULL, NULL),
(175, 10, 67, 166, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-28', 2020, 95, 0, 'VSM-9', 2, 26, NULL, NULL, NULL),
(176, 14, 4, 167, 3, 22, NULL, 16, NULL, NULL, 1, 0, 0, '2020-11-28', 2020, 0, 55.73, 'IRP-3', 2, 27, NULL, NULL, NULL),
(177, 14, 4, 167, 3, 23, NULL, 17, NULL, NULL, 1, 0, 0, '2020-11-28', 2020, 0, 993.13, 'IRP-3', 2, 27, NULL, NULL, NULL),
(178, 63, 54, 167, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-28', 2020, 1048.86, 0, 'IRP-3', 2, 27, NULL, NULL, NULL),
(179, 14, 4, 168, 3, 22, NULL, 16, NULL, NULL, 1, 0, 0, '2020-11-28', 2020, 0, 27.86, 'IRP-4', 2, 27, NULL, NULL, NULL),
(180, 14, 4, 168, 3, 22, NULL, 16, NULL, NULL, 1, 0, 0, '2020-11-28', 2020, 0, 248.28, 'IRP-4', 2, 27, NULL, NULL, NULL),
(181, 63, 54, 168, 3, 22, NULL, 16, NULL, NULL, 1, 0, 0, '2020-11-28', 2020, 276.14, 0, 'IRP-4', 2, 27, NULL, NULL, NULL),
(182, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-11-29', 2020, 0, 158.12, 'FACT-1', 2, 67, 37, NULL, NULL),
(183, 67, 73, NULL, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 558.6345, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(184, 76, 79, NULL, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 67.5, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(185, 67, 73, NULL, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 13.931675, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(186, 76, 79, NULL, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 31.25, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(187, 67, 74, NULL, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 17.44, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(188, 76, 81, NULL, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 45, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(189, 41, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 14.37, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(190, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 5, '2020-11-29', 2020, 0, 3973.74, 'FACT-2', 2, 67, 38, NULL, NULL),
(191, 67, 73, NULL, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 682.7755, 0, 'FACT-2', 2, 67, 38, NULL, NULL),
(192, 76, 79, NULL, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 825, 0, 'FACT-2', 2, 67, 38, NULL, NULL),
(193, 67, 73, NULL, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 69.658375, 0, 'FACT-2', 2, 67, 38, NULL, NULL),
(194, 76, 79, NULL, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 3125, 0, 'FACT-2', 2, 67, 38, NULL, NULL),
(195, 67, 74, NULL, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 4.36, 0, 'FACT-2', 2, 67, 38, NULL, NULL),
(196, 76, 81, NULL, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 11.25, 0, 'FACT-2', 2, 67, 38, NULL, NULL),
(197, 41, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 12.49, 0, 'FACT-2', 2, 67, 38, NULL, NULL),
(198, 8, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, '2020-11-29', 2020, 0, 10100, 'FACT-3', 2, 67, 39, NULL, NULL),
(199, 68, 87, NULL, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 6000, 0, 'FACT-3', 2, 67, 39, NULL, NULL),
(200, 75, 82, NULL, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 7200, 0, 'FACT-3', 2, 67, 39, NULL, NULL),
(201, 68, 87, NULL, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 1800, 0, 'FACT-3', 2, 67, 39, NULL, NULL),
(202, 75, 82, NULL, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 3000, 0, 'FACT-3', 2, 67, 39, NULL, NULL),
(203, 41, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 100, 0, 'FACT-3', 2, 67, 39, NULL, NULL),
(204, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-11-29', 2020, 0, 10907, 'FACT-4', 2, 67, 40, NULL, NULL),
(205, 68, 90, NULL, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 5000, 0, 'FACT-4', 2, 67, 40, NULL, NULL),
(206, 75, 85, NULL, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 6000, 0, 'FACT-4', 2, 67, 40, NULL, NULL),
(207, 68, 90, NULL, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 3000, 0, 'FACT-4', 2, 67, 40, NULL, NULL),
(208, 75, 85, NULL, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 4125, 0, 'FACT-4', 2, 67, 40, NULL, NULL),
(209, 67, 73, NULL, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 15.654, 0, 'FACT-4', 2, 67, 40, NULL, NULL),
(210, 76, 79, NULL, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 45, 0, 'FACT-4', 2, 67, 40, NULL, NULL),
(211, 67, 75, NULL, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 312.11, 0, 'FACT-4', 2, 67, 40, NULL, NULL),
(212, 76, 80, NULL, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 625, 0, 'FACT-4', 2, 67, 40, NULL, NULL),
(213, 41, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-11-29', 2020, 112, 0, 'FACT-4', 2, 67, 40, NULL, NULL),
(214, 8, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, '2020-12-01', 2020, 0, 217, 'FACT-5', 2, 67, 41, NULL, NULL),
(215, 75, 84, NULL, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-01', 2020, 200, 0, 'FACT-5', 2, 67, 41, NULL, NULL),
(216, 76, 79, NULL, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-01', 2020, 15, 0, 'FACT-5', 2, 67, 41, NULL, NULL),
(217, 41, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-01', 2020, 2, 0, 'FACT-5', 2, 67, 41, NULL, NULL),
(218, 68, 89, 174, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-01', 2020, 0.052, 0, 'FACT-5', 2, 29, 41, NULL, NULL),
(219, 67, 73, 175, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-01', 2020, 0.5218, 0, 'FACT-5', 2, 30, 41, NULL, NULL),
(220, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-17', 2020, 0, 100, 'FACT-1', 2, 67, 37, NULL, NULL),
(221, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-17', 2020, 100, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(222, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-17', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(223, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-17', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(224, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-17', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(225, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-17', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(226, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-17', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(227, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-17', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(228, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(229, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(230, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(231, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(232, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(233, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(234, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(235, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(236, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(237, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(238, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(239, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(240, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(241, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(242, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(243, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(244, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(245, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(246, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(247, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(248, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(249, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(250, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(251, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(252, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(253, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(254, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(255, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(256, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(257, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(258, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(259, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(260, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(261, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(262, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(263, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(264, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(265, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(266, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(267, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(268, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(269, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(270, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(271, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(272, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(273, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(274, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 0, 20, 'FACT-1', 2, 67, 37, NULL, NULL),
(275, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-18', 2020, 20, 0, 'FACT-1', 2, 67, 37, NULL, NULL),
(276, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-22', 2020, 10158.12, 0, '', 2, 63, NULL, NULL, NULL),
(277, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, '2020-12-22', 2020, 0, 10158.12, '', 2, 63, NULL, NULL, NULL),
(278, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2020-12-22', 2020, 0, 10158.12, '', 2, 64, NULL, NULL, NULL),
(279, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-22', 2020, 10158.12, 0, '', 2, 64, NULL, NULL, NULL),
(280, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '2020-12-22', 2020, 0, 200, '-', 2, 65, NULL, NULL, NULL),
(281, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2020-12-22', 2020, 200, 0, '-', 2, 65, NULL, NULL, NULL),
(282, 8, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-02', 2020, 0, 2000, 'FACT-6', 2, 67, 42, NULL, NULL),
(283, 75, 85, NULL, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-02', 2020, 1000, 0, 'FACT-6', 2, 67, 42, NULL, NULL),
(284, 76, 79, NULL, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-02', 2020, 1000, 0, 'FACT-6', 2, 67, 42, NULL, NULL),
(285, 41, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-02', 2020, 0, 0, 'FACT-6', 2, 67, 42, NULL, NULL),
(286, 15, 62, 176, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-02', 2020, 0, 0, 'FACT-6', 2, 68, 42, NULL, NULL),
(287, 68, 90, 176, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-02', 2020, 0, 250, 'FACT-6', 2, 68, 42, NULL, NULL),
(288, 14, 4, 177, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-02', 2020, 0, 0, 'FACT-6', NULL, NULL, 42, NULL, NULL),
(289, 67, 73, 177, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-02', 2020, 0, 0.52171428571429, 'FACT-6', NULL, NULL, 42, NULL, NULL),
(290, 8, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 4, '2020-12-02', 2020, 0, 1200, 'FACT-7', 2, 67, 43, NULL, NULL),
(291, 75, 83, NULL, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-02', 2020, 1000, 0, 'FACT-7', 2, 67, 43, NULL, NULL),
(292, 76, 79, NULL, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-02', 2020, 200, 0, 'FACT-7', 2, 67, 43, NULL, NULL),
(293, 41, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-02', 2020, 0, 0, 'FACT-7', 2, 67, 43, NULL, NULL),
(294, 15, 60, 178, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-02', 2020, 0, 0, 'FACT-7', 2, 68, 43, NULL, NULL),
(295, 68, 88, 178, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-02', 2020, 0, 0.17101639344262, 'FACT-7', 2, 68, 43, NULL, NULL),
(296, 14, 4, 179, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-02', 2020, 0, 0, 'FACT-7', NULL, NULL, 43, NULL, NULL),
(297, 67, 73, 179, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-02', 2020, 0, 0.52171428571428, 'FACT-7', NULL, NULL, 43, NULL, NULL),
(298, 8, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 5, '2020-12-02', 2020, 0, 1300, 'FACT-8', 2, 67, 44, NULL, NULL),
(299, 75, 85, NULL, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-02', 2020, 1000, 0, 'FACT-8', 2, 67, 44, NULL, NULL),
(300, 76, 79, NULL, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-02', 2020, 300, 0, 'FACT-8', 2, 67, 44, NULL, NULL),
(301, 41, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-02', 2020, 0, 0, 'FACT-8', 2, 67, 44, NULL, NULL),
(302, 15, 62, 180, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-02', 2020, 102, 0, 'FACT-8', 2, 68, 44, NULL, NULL),
(303, 68, 90, 180, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-02', 2020, 0, 1.02, 'FACT-8', 2, 68, 44, NULL, NULL),
(304, 14, 4, 181, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-02', 2020, 1.5651428571428, 0, 'FACT-8', NULL, NULL, 44, NULL, NULL),
(305, 67, 73, 181, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-02', 2020, 0, 0.52171428571426, 'FACT-8', NULL, NULL, 44, NULL, NULL),
(306, 24, 9, NULL, NULL, 23, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-25', 2020, 0, 100, 'AP-7', NULL, NULL, NULL, NULL, NULL),
(307, 33, 134, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-25', 2020, 20, 0, 'AP-7', NULL, NULL, NULL, NULL, NULL),
(308, 76, 80, NULL, NULL, 13, 15, NULL, NULL, NULL, 1, 0, 0, '2020-12-25', 2020, 80, 0, 'AP-7', NULL, NULL, NULL, NULL, NULL),
(309, 24, 8, NULL, NULL, 21, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-25', 2020, 0, 1000, 'AP-8', NULL, NULL, NULL, NULL, NULL),
(310, 76, 79, NULL, NULL, 22, 17, NULL, NULL, NULL, 1, 0, 0, '2020-12-25', 2020, 1000, 0, 'AP-8', NULL, NULL, NULL, NULL, NULL),
(311, 24, 9, NULL, NULL, 20, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-25', 2020, 0, 5000, 'AP-9', NULL, NULL, NULL, NULL, NULL),
(312, 33, 134, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-25', 2020, 500, 0, 'AP-9', NULL, NULL, NULL, NULL, NULL),
(313, 75, 82, NULL, NULL, 20, 18, NULL, NULL, NULL, 1, 0, 0, '2020-12-25', 2020, 4500, 0, 'AP-9', NULL, NULL, NULL, NULL, NULL),
(314, 24, 10, NULL, NULL, 23, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-25', 2020, 0, 250, 'A-1', NULL, NULL, NULL, NULL, NULL),
(315, 33, 134, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-25', 2020, 50, 0, 'A-1', NULL, NULL, NULL, NULL, NULL),
(316, 76, 81, NULL, NULL, 21, 17, NULL, NULL, NULL, 1, 0, 0, '2020-12-25', 2020, 200, 0, 'A-1', NULL, NULL, NULL, NULL, NULL),
(317, 24, 8, NULL, NULL, 21, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-25', 2020, 0, 120, 'A-2', NULL, NULL, NULL, NULL, NULL),
(318, 76, 80, NULL, NULL, 24, 15, NULL, NULL, NULL, 1, 0, 0, '2020-12-25', 2020, 120, 0, 'A-2', NULL, NULL, NULL, NULL, NULL),
(319, 24, 9, NULL, NULL, 21, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-25', 2020, 0, 10, 'TR-1', NULL, NULL, NULL, NULL, NULL),
(320, 33, 134, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-25', 2020, 2, 0, 'TR-1', NULL, NULL, NULL, NULL, NULL),
(321, 76, 80, NULL, NULL, 23, 16, NULL, NULL, NULL, 1, 0, 0, '2020-12-25', 2020, 8, 0, 'TR-1', NULL, NULL, NULL, NULL, NULL),
(322, 24, 9, NULL, NULL, 22, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-25', 2020, 0, 450, 'TR-2', NULL, NULL, NULL, NULL, NULL),
(323, 76, 79, NULL, NULL, 23, 16, NULL, NULL, NULL, 1, 0, 0, '2020-12-25', 2020, 450, 0, 'TR-2', NULL, NULL, NULL, NULL, NULL),
(324, 24, 9, NULL, NULL, 23, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 100, 0, 'AP-7', NULL, NULL, NULL, NULL, NULL),
(325, 33, 134, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 0, 20, 'AP-7', NULL, NULL, NULL, NULL, NULL),
(326, 76, 80, NULL, NULL, 13, 15, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 0, 80, 'AP-7', NULL, NULL, NULL, NULL, NULL),
(327, 24, 8, NULL, NULL, 21, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 1000, 0, 'AP-8', NULL, NULL, NULL, NULL, NULL),
(328, 76, 79, NULL, NULL, 22, 17, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 0, 1000, 'AP-8', NULL, NULL, NULL, NULL, NULL),
(329, 24, 8, NULL, NULL, 21, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 1000, 0, 'AP-8', NULL, NULL, NULL, NULL, NULL),
(330, 76, 79, NULL, NULL, 22, 17, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 0, 1000, 'AP-8', NULL, NULL, NULL, NULL, NULL),
(331, 24, 8, NULL, NULL, 21, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 0, 1000, 'AP-8', NULL, NULL, NULL, NULL, NULL),
(332, 76, 79, NULL, NULL, 22, 17, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 1000, 0, 'AP-8', NULL, NULL, NULL, NULL, NULL),
(333, 24, 8, NULL, NULL, 21, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 1000, 0, 'AP-8', NULL, NULL, NULL, NULL, NULL),
(334, 76, 79, NULL, NULL, 22, 17, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 0, 1000, 'AP-8', NULL, NULL, NULL, NULL, NULL),
(335, 24, 8, NULL, NULL, 21, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 0, 1000, 'AP-8', NULL, NULL, NULL, NULL, NULL),
(336, 76, 79, NULL, NULL, 22, 17, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 1000, 0, 'AP-8', NULL, NULL, NULL, NULL, NULL),
(337, 24, 8, NULL, NULL, 21, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 0, 1000, 'AP-8', NULL, NULL, NULL, NULL, NULL),
(338, 76, 79, NULL, NULL, 22, 17, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 1000, 0, 'AP-8', NULL, NULL, NULL, NULL, NULL),
(339, 24, 8, NULL, NULL, 21, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 1000, 0, 'AP-8', NULL, NULL, NULL, NULL, NULL),
(340, 76, 79, NULL, NULL, 22, 17, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 0, 1000, 'AP-8', NULL, NULL, NULL, NULL, NULL),
(341, 24, 8, NULL, NULL, 21, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 120, 0, 'A-2', NULL, NULL, NULL, NULL, NULL),
(342, 76, 80, NULL, NULL, 24, 15, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 0, 120, 'A-2', NULL, NULL, NULL, NULL, NULL),
(343, 24, 8, NULL, NULL, 21, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 120, 0, 'A-2', NULL, NULL, NULL, NULL, NULL),
(344, 76, 80, NULL, NULL, 24, 15, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 0, 120, 'A-2', NULL, NULL, NULL, NULL, NULL),
(345, 24, 8, NULL, NULL, 21, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 0, 120, 'A-2', NULL, NULL, NULL, NULL, NULL),
(346, 76, 80, NULL, NULL, 24, 15, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 120, 0, 'A-2', NULL, NULL, NULL, NULL, NULL),
(347, 24, 9, NULL, NULL, 21, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 10, 0, 'TR-1', NULL, NULL, NULL, NULL, NULL),
(348, 33, 134, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 0, 2, 'TR-1', NULL, NULL, NULL, NULL, NULL),
(349, 76, 80, NULL, NULL, 23, 16, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 0, 8, 'TR-1', NULL, NULL, NULL, NULL, NULL),
(350, 24, 9, NULL, NULL, 21, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 10, 0, 'TR-1', NULL, NULL, NULL, NULL, NULL),
(351, 33, 134, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 0, 2, 'TR-1', NULL, NULL, NULL, NULL, NULL),
(352, 76, 80, NULL, NULL, 23, 16, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 0, 8, 'TR-1', NULL, NULL, NULL, NULL, NULL),
(353, 24, 9, NULL, NULL, 21, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 0, 10, 'TR-1', NULL, NULL, NULL, NULL, NULL),
(354, 33, 134, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 2, 0, 'TR-1', NULL, NULL, NULL, NULL, NULL),
(355, 76, 80, NULL, NULL, 23, 16, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 8, 0, 'TR-1', NULL, NULL, NULL, NULL, NULL),
(356, 24, 9, NULL, NULL, 21, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 10, 0, 'TR-1', NULL, NULL, NULL, NULL, NULL),
(357, 33, 134, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 0, 2, 'TR-1', NULL, NULL, NULL, NULL, NULL),
(358, 76, 80, NULL, NULL, 23, 16, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 0, 8, 'TR-1', NULL, NULL, NULL, NULL, NULL),
(359, 24, 9, NULL, NULL, 21, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 0, 10, 'TR-1', NULL, NULL, NULL, NULL, NULL),
(360, 33, 134, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 2, 0, 'TR-1', NULL, NULL, NULL, NULL, NULL),
(361, 76, 80, NULL, NULL, 23, 16, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 8, 0, 'TR-1', NULL, NULL, NULL, NULL, NULL),
(362, 24, 9, NULL, NULL, 21, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 0, 10, 'TR-1', NULL, NULL, NULL, NULL, NULL),
(363, 33, 134, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 2, 0, 'TR-1', NULL, NULL, NULL, NULL, NULL),
(364, 76, 80, NULL, NULL, 23, 16, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 8, 0, 'TR-1', NULL, NULL, NULL, NULL, NULL),
(365, 24, 9, NULL, NULL, 21, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 10, 0, 'TR-1', NULL, NULL, NULL, NULL, NULL),
(366, 33, 134, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 0, 2, 'TR-1', NULL, NULL, NULL, NULL, NULL),
(367, 76, 80, NULL, NULL, 23, 16, NULL, NULL, NULL, 1, 0, 0, '2020-12-29', 2020, 0, 8, 'TR-1', NULL, NULL, NULL, NULL, NULL),
(368, 22, 138, NULL, NULL, 25, NULL, NULL, NULL, NULL, 1, 0, 0, '2021-01-01', 2021, 0, 100, 'AP-1', 2, 69, NULL, 22, NULL),
(369, 33, 134, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2021-01-01', 2021, 20, 0, 'AP-1', 2, 69, NULL, 22, NULL),
(370, 54, 38, NULL, NULL, 25, 1, NULL, NULL, NULL, 1, 0, 0, '2021-01-01', 2021, 80, 0, 'AP-1', 2, 69, NULL, 22, NULL),
(371, 22, 138, NULL, NULL, 25, NULL, NULL, NULL, NULL, 1, 0, 0, '2021-01-04', 2021, 0, 500, 'A-1', 2, 70, NULL, 23, NULL),
(372, 54, 38, NULL, NULL, 25, 1, NULL, NULL, NULL, 1, 0, 0, '2021-01-04', 2021, 500, 0, 'A-1', 2, 70, NULL, 23, NULL),
(373, 85, 38, NULL, NULL, 25, 1, NULL, NULL, NULL, 1, 0, 0, '2021-01-04', 2021, 0, 500, 'A-1', 2, 70, NULL, 23, NULL),
(374, 37, 38, NULL, NULL, 25, 1, NULL, NULL, 7, 1, 0, 0, '2021-01-04', 2021, 500, 0, 'A-1', 2, 70, NULL, 23, NULL),
(375, 22, 138, NULL, NULL, 25, NULL, NULL, NULL, NULL, 1, 0, 0, '2021-01-04', 2021, 0, 55, 'TR-1', 2, 69, NULL, 24, NULL),
(376, 33, 134, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2021-01-04', 2021, 15, 0, 'TR-1', 2, 69, NULL, 24, NULL),
(377, 54, 38, NULL, NULL, 25, 1, NULL, NULL, NULL, 1, 0, 0, '2021-01-04', 2021, 40, 0, 'TR-1', 2, 69, NULL, 24, NULL),
(378, 22, 138, NULL, NULL, 25, NULL, NULL, NULL, NULL, 1, 0, 0, '2021-01-04', 2021, 0, 2500, 'AP-2', 2, 74, NULL, 26, NULL),
(379, 54, 38, NULL, NULL, 25, 1, NULL, NULL, NULL, 1, 0, 0, '2021-01-04', 2021, 2500, 0, 'AP-2', 2, 74, NULL, 26, NULL),
(382, 33, 134, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2021-01-04', 2021, 0, 15, 'BA-1', 2, 69, NULL, 24, NULL),
(383, 69, 97, NULL, NULL, 25, 1, NULL, NULL, NULL, 1, 0, 0, '2021-01-04', 2021, 0, 40, 'BA-1', 2, 69, NULL, 24, NULL),
(384, 22, 138, NULL, NULL, 25, NULL, NULL, NULL, NULL, 1, 0, 0, '2021-01-04', 2021, 55, 0, 'BA-1', 2, 69, NULL, 24, NULL),
(385, 69, 97, NULL, NULL, 25, 1, NULL, NULL, NULL, 1, 0, 0, '2021-01-04', 2021, 0, 500, 'BA-2', 2, 70, NULL, 23, NULL),
(386, 22, 138, NULL, NULL, 25, NULL, NULL, NULL, NULL, 1, 0, 0, '2021-01-04', 2021, 500, 0, 'BA-2', 2, 70, NULL, 23, NULL),
(387, 22, 138, NULL, NULL, 5, NULL, NULL, NULL, NULL, 1, 0, 0, '2021-01-04', 2021, 0, 2500, 'TI-1', 2, 74, NULL, 26, 1),
(388, 22, 138, NULL, NULL, 25, NULL, NULL, NULL, NULL, 1, 0, 0, '2021-01-04', 2021, 2500, 0, 'TI-1', 2, 74, NULL, 26, 1),
(389, 69, 97, NULL, NULL, 25, 1, NULL, NULL, NULL, 1, 0, 0, '2021-01-04', 2021, 0, 2500, 'BA-3', 2, 74, NULL, 26, NULL),
(390, 22, 138, NULL, NULL, 5, NULL, NULL, NULL, NULL, 1, 0, 0, '2021-01-04', 2021, 2500, 0, 'BA-3', 2, 74, NULL, 26, NULL),
(391, 69, 97, NULL, NULL, 25, 1, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 0.83, '0', 2, 75, NULL, NULL, NULL),
(392, 33, 134, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0.83, 0, '0', 2, 75, NULL, NULL, NULL),
(393, 22, 138, NULL, NULL, 9, NULL, NULL, NULL, NULL, 1, 0, NULL, '2021-01-11', 2021, 0, 100, 'A-2', NULL, NULL, NULL, 27, 1),
(394, 54, 38, NULL, NULL, 9, 1, NULL, NULL, NULL, 1, 0, NULL, '2021-01-11', 2021, 100, 0, 'A-2', NULL, NULL, NULL, 27, NULL),
(395, 85, 38, NULL, NULL, 9, 1, NULL, NULL, NULL, 1, 0, NULL, '2021-01-11', 2021, 0, 100, 'A-2', NULL, NULL, NULL, 27, NULL),
(396, 37, 38, NULL, NULL, 9, 1, NULL, NULL, 1, 1, 0, NULL, '2021-01-11', 2021, 100, 0, 'A-2', NULL, NULL, NULL, 27, NULL),
(397, 36, 63, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '2020-12-03', 2020, 0, 138.91, '-', 2, 76, NULL, NULL, NULL),
(398, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2020-12-03', 2020, 138.91, 0, '-', 2, 76, NULL, NULL, NULL),
(399, 36, 63, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '2020-12-03', 2020, 0, 138.91, '-', 2, 77, NULL, NULL, NULL),
(400, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2020-12-03', 2020, 138.91, 0, '-', 2, 77, NULL, NULL, NULL),
(401, 69, 97, NULL, NULL, NULL, 13, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 2708873, '', 2, 78, NULL, NULL, NULL),
(402, 74, 139, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 191992.73, '', 2, 78, NULL, NULL, NULL),
(403, 74, 140, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 191722.32, '', 2, 78, NULL, NULL, NULL),
(404, 74, 141, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 29744.13, '', 2, 78, NULL, NULL, NULL),
(405, 74, 142, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 27040.12, '', 2, 78, NULL, NULL, NULL),
(406, 42, 152, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 1892045.79, '', 2, 78, NULL, NULL, NULL),
(407, 41, 37, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 585248.24, '', 2, 78, NULL, NULL, NULL),
(408, 41, 143, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 82205.34, '', 2, 78, NULL, NULL, NULL),
(409, 41, 144, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 77608.33, '', 2, 78, NULL, NULL, NULL),
(410, 41, 145, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 67600.3, '', 2, 78, NULL, NULL, NULL),
(411, 41, 146, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 1669, '', 2, 78, NULL, NULL, NULL),
(412, 41, 147, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 3622, '', 2, 78, NULL, NULL, NULL),
(413, 41, 149, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 191992.73, '', 2, 78, NULL, NULL, NULL),
(414, 41, 148, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 191722.32, '', 2, 78, NULL, NULL, NULL),
(415, 41, 150, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 29744.13, '', 2, 78, NULL, NULL, NULL),
(416, 41, 151, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 27040.12, '', 2, 78, NULL, NULL, NULL),
(417, 69, 97, NULL, NULL, NULL, 13, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 2708873, '', 2, 79, NULL, NULL, NULL),
(418, 74, 139, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 191992.73, '', 2, 79, NULL, NULL, NULL),
(419, 74, 140, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 191722.32, '', 2, 79, NULL, NULL, NULL),
(420, 74, 141, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 29744.13, '', 2, 79, NULL, NULL, NULL),
(421, 74, 142, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 27040.12, '', 2, 79, NULL, NULL, NULL),
(422, 42, 152, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 1892045.79, 0, '', 2, 79, NULL, NULL, NULL),
(423, 41, 37, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 585248.24, 0, '', 2, 79, NULL, NULL, NULL),
(424, 41, 143, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 82205.34, 0, '', 2, 79, NULL, NULL, NULL),
(425, 41, 144, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 77608.33, 0, '', 2, 79, NULL, NULL, NULL),
(426, 41, 145, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 67600.3, 0, '', 2, 79, NULL, NULL, NULL),
(427, 41, 146, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 1669, 0, '', 2, 79, NULL, NULL, NULL),
(428, 41, 147, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 3622, 0, '', 2, 79, NULL, NULL, NULL),
(429, 41, 149, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 191992.73, 0, '', 2, 79, NULL, NULL, NULL),
(430, 41, 148, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 191722.32, 0, '', 2, 79, NULL, NULL, NULL),
(431, 41, 150, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 29744.13, 0, '', 2, 79, NULL, NULL, NULL),
(432, 41, 151, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 27040.12, 0, '', 2, 79, NULL, NULL, NULL),
(433, 69, 97, NULL, NULL, NULL, 13, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 107900, '', 2, 80, NULL, NULL, NULL),
(434, 74, 139, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 7483.4, '', 2, 80, NULL, NULL, NULL),
(435, 74, 140, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 7472.86, '', 2, 80, NULL, NULL, NULL),
(436, 74, 141, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 1159.4, '', 2, 80, NULL, NULL, NULL),
(437, 74, 142, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 1054, '', 2, 80, NULL, NULL, NULL),
(438, 42, 152, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 91067.41, 0, '', 2, 80, NULL, NULL, NULL),
(439, 41, 37, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 5368.45, 0, '', 2, 80, NULL, NULL, NULL),
(440, 41, 143, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 3204.16, 0, '', 2, 80, NULL, NULL, NULL),
(441, 41, 144, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 3024.98, 0, '', 2, 80, NULL, NULL, NULL),
(442, 41, 145, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 2635, 0, '', 2, 80, NULL, NULL, NULL),
(443, 41, 146, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 1000, 0, '', 2, 80, NULL, NULL, NULL),
(444, 41, 147, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 1600, 0, '', 2, 80, NULL, NULL, NULL),
(445, 41, 149, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 7483.4, 0, '', 2, 80, NULL, NULL, NULL),
(446, 41, 148, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 7472.86, 0, '', 2, 80, NULL, NULL, NULL),
(447, 41, 150, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 1159.4, 0, '', 2, 80, NULL, NULL, NULL),
(448, 41, 151, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 1054, 0, '', 2, 80, NULL, NULL, NULL),
(449, 69, 97, NULL, NULL, NULL, 13, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 107900, '', 2, 81, NULL, NULL, NULL),
(450, 74, 139, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 7483.4, '', 2, 81, NULL, NULL, NULL),
(451, 74, 140, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 7472.86, '', 2, 81, NULL, NULL, NULL),
(452, 74, 141, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 1159.4, '', 2, 81, NULL, NULL, NULL),
(453, 74, 142, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 1054, '', 2, 81, NULL, NULL, NULL),
(454, 42, 152, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 91067.41, 0, '', 2, 81, NULL, NULL, NULL),
(455, 41, 37, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 5368.45, 0, '', 2, 81, NULL, NULL, NULL),
(456, 41, 143, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 3204.16, 0, '', 2, 81, NULL, NULL, NULL),
(457, 41, 144, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 3024.98, 0, '', 2, 81, NULL, NULL, NULL),
(458, 41, 145, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 2635, 0, '', 2, 81, NULL, NULL, NULL),
(459, 41, 146, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 1000, 0, '', 2, 81, NULL, NULL, NULL),
(460, 41, 147, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 1600, 0, '', 2, 81, NULL, NULL, NULL),
(461, 41, 149, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 7483.4, 0, '', 2, 81, NULL, NULL, NULL),
(462, 41, 148, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 7472.86, 0, '', 2, 81, NULL, NULL, NULL),
(463, 41, 150, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 1159.4, 0, '', 2, 81, NULL, NULL, NULL),
(464, 41, 151, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 1054, 0, '', 2, 81, NULL, NULL, NULL),
(465, 69, 97, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 107900, 0, '', 2, 82, NULL, NULL, NULL),
(466, 74, 139, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 7483.4, 0, '', 2, 82, NULL, NULL, NULL),
(467, 74, 140, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 7472.86, 0, '', 2, 82, NULL, NULL, NULL);
INSERT INTO `asiento` (`id`, `id_cuenta_id`, `id_subcuenta_id`, `id_documento_id`, `id_almacen_id`, `id_centro_costo_id`, `id_elemento_gasto_id`, `id_orden_trabajo_id`, `id_expediente_id`, `id_proveedor_id`, `id_unidad_id`, `tipo_cliente`, `id_cliente`, `fecha`, `anno`, `credito`, `debito`, `nro_documento`, `id_tipo_comprobante_id`, `id_comprobante_id`, `id_factura_id`, `id_activo_fijo_id`, `id_area_responsabilidad_id`) VALUES
(468, 74, 141, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 1159.4, 0, '', 2, 82, NULL, NULL, NULL),
(469, 74, 142, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 1054, 0, '', 2, 82, NULL, NULL, NULL),
(470, 42, 152, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 91067.41, '', 2, 82, NULL, NULL, NULL),
(471, 41, 37, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 5368.45, '', 2, 82, NULL, NULL, NULL),
(472, 41, 143, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 3204.16, '', 2, 82, NULL, NULL, NULL),
(473, 41, 144, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 3024.98, '', 2, 82, NULL, NULL, NULL),
(474, 41, 145, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 2635, '', 2, 82, NULL, NULL, NULL),
(475, 41, 146, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 1000, '', 2, 82, NULL, NULL, NULL),
(476, 41, 147, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 1600, '', 2, 82, NULL, NULL, NULL),
(477, 41, 149, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 7483.4, '', 2, 82, NULL, NULL, NULL),
(478, 41, 148, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 7472.86, '', 2, 82, NULL, NULL, NULL),
(479, 41, 150, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 1159.4, '', 2, 82, NULL, NULL, NULL),
(480, 41, 151, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 1054, '', 2, 82, NULL, NULL, NULL),
(481, 69, 97, NULL, NULL, NULL, 13, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 107900, '', 2, 83, NULL, NULL, NULL),
(482, 74, 139, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 7483.4, '', 2, 83, NULL, NULL, NULL),
(483, 74, 140, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 7472.86, '', 2, 83, NULL, NULL, NULL),
(484, 74, 141, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 1159.4, '', 2, 83, NULL, NULL, NULL),
(485, 74, 142, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 0, 1054, '', 2, 83, NULL, NULL, NULL),
(486, 42, 152, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 91067.41, 0, '', 2, 83, NULL, NULL, NULL),
(487, 41, 37, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 5368.45, 0, '', 2, 83, NULL, NULL, NULL),
(488, 41, 143, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 3204.16, 0, '', 2, 83, NULL, NULL, NULL),
(489, 41, 144, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 3024.98, 0, '', 2, 83, NULL, NULL, NULL),
(490, 41, 145, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 2635, 0, '', 2, 83, NULL, NULL, NULL),
(491, 41, 146, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 1000, 0, '', 2, 83, NULL, NULL, NULL),
(492, 41, 147, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 1600, 0, '', 2, 83, NULL, NULL, NULL),
(493, 41, 149, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 7483.4, 0, '', 2, 83, NULL, NULL, NULL),
(494, 41, 148, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 7472.86, 0, '', 2, 83, NULL, NULL, NULL),
(495, 41, 150, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 1159.4, 0, '', 2, 83, NULL, NULL, NULL),
(496, 41, 151, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2020-12-03', 2021, 1054, 0, '', 2, 83, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cargo`
--

CREATE TABLE `cargo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cargo`
--

INSERT INTO `cargo` (`id`, `nombre`, `activo`) VALUES
(1, 'Administrador del Sistema', 1);

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
-- Table structure for table `categoria_cliente`
--

CREATE TABLE `categoria_cliente` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prefijo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categoria_cliente`
--

INSERT INTO `categoria_cliente` (`id`, `nombre`, `prefijo`) VALUES
(1, 'Facturas de Crédito Fiscal', 'B01'),
(2, 'Facturas de Consumo', 'B02'),
(3, 'Notas de Débito', 'B03'),
(4, 'Notas de Crédito', 'B04'),
(5, 'Comprobantes de Compras', 'B11'),
(6, 'Registro Único de Ingresos', 'B12'),
(7, 'Comprobante para Gastos Menores', 'B13'),
(8, 'Comprobante para Regímenes Especiales', 'B14'),
(9, 'Comprobantes Gubernamentales', 'B15'),
(10, 'Comprobantes para Exportaciones', 'B16'),
(11, 'Comprobantes de Pagos al Exterior', 'B17'),
(13, 'Comprobante para Gastos Menores', 'B13'),
(14, 'Facturas de Crédito Fiscal', 'B01'),
(15, 'Comprobante para Gastos Menores', 'B13');

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
(1, 1, 0, '01', 'Recargas'),
(2, 1, 0, '0020', 'Combo de Aseo'),
(3, 1, 0, '03', 'Combo de Medicina'),
(4, 1, 0, '04', 'Combo de Comida'),
(5, 1, 0, '05', 'Articulos de Ferreteria'),
(6, 1, 0, '06', 'Direccion de la Unidad'),
(7, 1, 0, '07', 'Produccion y Venta'),
(8, 1, 1, '0010', 'Recarga Cubacell'),
(9, 1, 1, '0020', 'Recarga Nauta'),
(10, 1, 1, '0030', 'Larga Distancia'),
(11, 1, 1, '0040', 'Envio de Remesas'),
(12, 1, 1, '0050', 'Boletos Aéreos'),
(13, 1, 1, '0060', 'Boletos Aéreos'),
(14, 1, 1, '0070', 'Renta de Autos'),
(15, 1, 1, '0080', 'Excursiones'),
(16, 1, 1, '0090', 'Envio de paquetes'),
(17, 1, 1, '0100', 'Paquetes Turísticos'),
(18, 1, 1, '0110', 'Trámites Migratorios'),
(19, 1, 1, '0120', 'Desarrollo de Software'),
(20, 1, 1, '0130', 'Diseño'),
(21, 1, 1, '0140', 'Marketing y redes Sociales'),
(22, 1, 1, '0150', 'Combo de aseo'),
(23, 1, 1, '0160', 'Combo de Medicamento'),
(24, 1, 1, '0170', 'Combo de Alimento'),
(25, 1, 1, '0180', 'Otros'),
(26, 1, 0, 'ds', 'sds'),
(27, 1, 0, '2323213213213', 'sdsadasdasdas');

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
(44, 1, 1, 1, 12, 2020, '2020-11-20', 0, 0, 7312.19, 958.3),
(45, 1, 1, 1, 12, 2020, '2020-11-21', 6353.89, 0, 95.21, 2168.97),
(46, 1, 1, 1, 12, 2020, '2020-11-27', 4280.13, 0, 580.56, 32.87),
(47, 1, 1, 1, 12, 2020, '2020-11-28', 4827.82, 0, 0, 1325),
(48, 2, 1, 1, 12, 2020, '2020-11-21', 0, 0, 2073.76, 0),
(49, 2, 1, 1, 12, 2020, '2020-11-23', 2073.76, 0, 40500, 0),
(50, 2, 1, 1, 12, 2020, '2020-11-29', 42573.76, 0, 0, 15800),
(51, 3, 1, 1, 12, 2020, '2020-11-24', 0, 0, 378.26, 0),
(52, 3, 1, 1, 12, 2020, '2020-11-28', 378.26, 0, 1325, 0),
(53, 1, 1, 1, 12, 2020, '2020-11-29', 3502.82, 0, 0, 0),
(54, 3, 1, 1, 12, 2020, '2020-11-29', 1703.26, 0, 0, 1674.564),
(55, 1, 1, 1, 12, 2020, '2020-11-30', 3502.82, 0, 0, 0),
(56, 2, 1, 1, 12, 2020, '2020-12-01', 26773.76, 0, 0, 0.52),
(57, 1, 1, 1, 12, 2020, '2020-12-01', 3502.82, 1, 0, 0),
(58, 3, 1, 1, 12, 2020, '2020-12-01', 28.696, 0, 0, 0.5218),
(59, 2, 1, 1, 12, 2020, '2020-12-02', 26773.24, 0, 0, 2603.7101639344),
(60, 3, 1, 1, 12, 2020, '2020-12-02', 28.1742, 1, 0, 0),
(61, 2, 1, 1, 12, 2020, '2020-12-03', 24169.529836066, 1, 0, 0);

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

--
-- Dumping data for table `cliente`
--

INSERT INTO `cliente` (`id`, `nombre`, `apellidos`, `correo`, `direccion`, `token`, `fecha`, `usuario`, `comentario`, `telefono`) VALUES
(1, 'Eduardo', 'Cabrera Montano', 'aaa@aaa.com', 'nmmmmm', NULL, NULL, NULL, 'vvvvv', '59552053');

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
(2, '1142', 'Rolando Perez Hernandez', 'mmmm', '2584', '233', 'mmm', 1),
(3, '1143', 'Dagorberto Robaina Valdes', '00', '00', '00', '00', 1),
(4, '6225', 'Empresa Telecomunicaciones', '223', '111', '000', 'xvxv', 1),
(5, '45-152', 'Laboratorios de Medicamentos', 'cvv', '11111', '1111', ',,,', 1),
(7, '6314', 'Empresa Cosntructora', 'sss', '11111', '000', 'mmm', 1);

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
-- Table structure for table `cobros_pagos`
--

CREATE TABLE `cobros_pagos` (
  `id` int(11) NOT NULL,
  `id_factura_id` int(11) DEFAULT NULL,
  `id_informe_id` int(11) DEFAULT NULL,
  `id_proveedor_id` int(11) DEFAULT NULL,
  `debito` double DEFAULT NULL,
  `credito` double DEFAULT NULL,
  `id_tipo_cliente` int(11) DEFAULT NULL,
  `id_cliente_venta` int(11) DEFAULT NULL,
  `id_movimiento_activo_fijo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cobros_pagos`
--

INSERT INTO `cobros_pagos` (`id`, `id_factura_id`, `id_informe_id`, `id_proveedor_id`, `debito`, `credito`, `id_tipo_cliente`, `id_cliente_venta`, `id_movimiento_activo_fijo_id`) VALUES
(32, 37, NULL, NULL, 0, 20, 3, 4, NULL),
(33, 37, NULL, NULL, 0, 20, 3, 4, NULL),
(34, 37, NULL, NULL, 158.12, 0, 3, 4, NULL),
(35, 40, NULL, NULL, 10000, 0, 3, 4, NULL),
(38, NULL, 52, 1, 0, 200, NULL, NULL, NULL);

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
(23, 26, 44),
(24, 26, 45),
(25, 26, 46),
(26, 26, 47),
(27, 26, 53),
(28, 26, 55),
(29, 27, 51),
(30, 27, 52),
(31, 28, 48),
(32, 28, 49),
(33, 28, 50),
(34, 29, 56),
(35, 30, 54),
(36, 30, 58),
(37, 68, 59);

-- --------------------------------------------------------

--
-- Table structure for table `comprobante_movimiento_activo_fijo`
--

CREATE TABLE `comprobante_movimiento_activo_fijo` (
  `id` int(11) NOT NULL,
  `id_registro_comprobante_id` int(11) NOT NULL,
  `id_movimiento_activo_id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `anno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comprobante_movimiento_activo_fijo`
--

INSERT INTO `comprobante_movimiento_activo_fijo` (`id`, `id_registro_comprobante_id`, `id_movimiento_activo_id`, `id_unidad_id`, `anno`) VALUES
(1, 69, 30, 1, 2021),
(2, 69, 31, 1, 2021),
(3, 69, 32, 1, 2021),
(4, 69, 33, 1, 2021),
(5, 69, 35, 1, 2021),
(6, 70, 36, 1, 2021),
(7, 71, 37, 1, 2020),
(8, 72, 37, 1, 2020),
(9, 72, 38, 1, 2020),
(10, 73, 37, 1, 2020),
(11, 73, 38, 1, 2020),
(12, 74, 37, 1, 2020),
(13, 74, 38, 1, 2020);

-- --------------------------------------------------------

--
-- Table structure for table `comprobante_salario`
--

CREATE TABLE `comprobante_salario` (
  `id` int(11) NOT NULL,
  `id_registro_comprobante_id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `mes` int(11) NOT NULL,
  `anno` int(11) NOT NULL,
  `quincena` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comprobante_salario`
--

INSERT INTO `comprobante_salario` (`id`, `id_registro_comprobante_id`, `id_unidad_id`, `mes`, `anno`, `quincena`) VALUES
(1, 83, 1, 12, 2020, 2);

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
-- Table structure for table `cotizacion`
--

CREATE TABLE `cotizacion` (
  `id` int(11) NOT NULL,
  `edit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `json` varchar(10000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empleado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datetime` datetime NOT NULL,
  `total` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_cliente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_cliente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_moneda` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
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
(73, 15, 59, 50, 2, '02', '2020-11-29', '0.00', 0, 7800),
(74, 15, 62, 50, 2, '02', '2020-11-29', '0.00', 0, 8000),
(75, 14, 4, 54, 3, '03', '2020-11-29', '0.00', 0, 1674.564),
(76, 15, 61, 56, 2, '02', '2020-12-01', '0.00', 0, 0.52),
(77, 14, 4, 58, 3, '03', '2020-12-01', '-1674.56', 0, 0.5218),
(78, 15, 60, 59, 2, '02', '2020-12-02', '0.00', 0, 1.7101639344262),
(79, 15, 62, 59, 2, '02', '2020-12-02', '-8000.00', 0, 2602);

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
(67, 13, 810, 'Costo de Ventas de Produccion', 1, 0, 0, 1, 0, 0),
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
(82, 15, 999, 'Resultados', 0, 0, 0, 1, 0, 1),
(83, 14, 903, 'Venta de Servicios Prestados', 0, 0, 0, 1, 0, 0),
(84, 13, 816, 'Costo de Venta de Servicios Prestados', 1, 0, 0, 1, 0, 0),
(85, 11, 646, 'Reservas para Inversiones', 0, 0, 0, 1, 0, 0);

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
(148, 70, 3, 1),
(149, 70, 5, 2),
(155, 69, 3, 1),
(156, 69, 5, 2);

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
  `fecha` date NOT NULL,
  `anno` int(11) NOT NULL,
  `total` double NOT NULL,
  `unidad_id` int(11) NOT NULL,
  `fundamentacion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `depreciacion`
--

INSERT INTO `depreciacion` (`id`, `fecha`, `anno`, `total`, `unidad_id`, `fundamentacion`) VALUES
(1, '2020-12-03', 2020, 0.83, 1, 'depreciacion de diciembre 2020');

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
(5, 157, 1, 1, '700', '0020', 2020, 1, '1', 24, 3, 10),
(6, 158, 1, 1, '700', '0020', 2020, 1, '2', 23, 7, 14);

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
('DoctrineMigrations\\Version20201216141446', '2020-12-16 15:15:18', 287993),
('DoctrineMigrations\\Version20201217024046', '2020-12-17 03:41:15', 98),
('DoctrineMigrations\\Version20201229034951', '2020-12-29 15:27:24', 2906),
('DoctrineMigrations\\Version20201229044306', '2020-12-29 15:27:27', 2571),
('DoctrineMigrations\\Version20201229165926', '2020-12-29 17:59:37', 1160),
('DoctrineMigrations\\Version20201229181830', '2020-12-29 19:18:50', 1385),
('DoctrineMigrations\\Version20210105183802', '2021-01-05 19:38:08', 1947),
('DoctrineMigrations\\Version20210105193527', '2021-01-05 20:35:33', 2162),
('DoctrineMigrations\\Version20210108133157', '2021-01-08 14:32:11', 1935),
('DoctrineMigrations\\Version20210111133527', '2021-01-11 14:35:33', 114),
('DoctrineMigrations\\Version20210111174841', '2021-01-11 18:48:50', 1442),
('DoctrineMigrations\\Version20210111202157', '2021-01-11 21:22:02', 2113),
('DoctrineMigrations\\Version20210114135215', '2021-01-14 14:52:56', 545),
('DoctrineMigrations\\Version20210114152157', '2021-01-14 16:22:21', 202),
('DoctrineMigrations\\Version20210114171301', '2021-01-14 18:13:06', 273),
('DoctrineMigrations\\Version20210114174501', '2021-01-14 18:45:06', 114),
('DoctrineMigrations\\Version20210114174606', '2021-01-14 18:46:11', 131),
('DoctrineMigrations\\Version20210114175816', '2021-01-14 18:59:56', 87),
('DoctrineMigrations\\Version20210114192725', '2021-01-14 20:27:30', 1322),
('DoctrineMigrations\\Version20210114194055', '2021-01-14 20:41:01', 2163),
('DoctrineMigrations\\Version20210116154937', '2021-01-16 16:49:44', 3510),
('DoctrineMigrations\\Version20210117023401', '2021-01-17 03:34:44', 361),
('DoctrineMigrations\\Version20210117051230', '2021-01-17 06:12:35', 2059),
('DoctrineMigrations\\Version20210118165534', '2021-01-18 17:55:55', 329),
('DoctrineMigrations\\Version20210118165752', '2021-01-18 17:57:57', 142),
('DoctrineMigrations\\Version20210121103943', '2021-01-21 11:40:04', 1881);

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
  `anno` int(11) DEFAULT NULL,
  `id_documento_cancelado_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documento`
--

INSERT INTO `documento` (`id`, `id_almacen_id`, `id_unidad_id`, `id_moneda_id`, `importe_total`, `fecha`, `activo`, `id_tipo_documento_id`, `anno`, `id_documento_cancelado_id`) VALUES
(138, 1, 1, 1, 238.91, '2020-11-20', 1, 1, 2020, NULL),
(139, 1, 1, 1, 128.5, '2020-11-20', 1, 1, 2020, NULL),
(140, 1, 1, 1, 129.3, '2020-11-20', 1, 1, 2020, NULL),
(141, 1, 1, 1, 45.73, '2020-11-20', 1, 1, 2020, NULL),
(142, 1, 1, 1, 4399.35, '2020-11-20', 1, 1, 2020, NULL),
(143, 1, 1, 1, 2370.4, '2020-11-20', 1, 1, 2020, NULL),
(144, 1, 1, 1, 26.09, '2020-11-20', 1, 7, 2020, NULL),
(145, 1, 1, 1, 18.25, '2020-11-20', 1, 7, 2020, NULL),
(146, 1, 1, 1, 312.11, '2020-11-20', 1, 7, 2020, NULL),
(147, 1, 1, 1, 18.26, '2020-11-20', 1, 7, 2020, NULL),
(148, 1, 1, 1, 21.8, '2020-11-20', 1, 7, 2020, NULL),
(149, 1, 1, 1, 561.79, '2020-11-20', 1, 7, 2020, NULL),
(150, 1, 1, 1, 95.21, '2020-11-21', 1, 4, 2020, NULL),
(151, 1, 1, 1, 95.21, '2020-11-21', 1, 3, 2020, NULL),
(152, 1, 1, 1, 2073.76, '2020-11-21', 1, 6, 2020, NULL),
(153, 2, 1, 1, 2073.76, '2020-11-21', 1, 5, 2020, NULL),
(154, 1, 1, 1, 0.52, '2020-11-27', 1, 3, 2020, NULL),
(155, 1, 1, 1, 2.85, '2020-11-27', 1, 4, 2020, NULL),
(156, 1, 1, 1, 30.02, '2020-11-27', 1, 7, 2020, NULL),
(157, 1, 1, 1, 18.25, '2020-11-27', 1, 9, 2020, NULL),
(158, 1, 1, 1, 561.79, '2020-11-27', 1, 9, 2020, NULL),
(159, 2, 1, 1, 30000, '2020-11-23', 1, 1, 2020, NULL),
(160, 2, 1, 1, 3000, '2020-11-23', 1, 1, 2020, NULL),
(161, 2, 1, 1, 6000, '2020-11-23', 1, 1, 2020, NULL),
(162, 2, 1, 1, 1500, '2020-11-23', 1, 1, 2020, NULL),
(163, 3, 1, 1, 338.2, '2020-11-24', 1, 2, 2020, NULL),
(164, 3, 1, 1, 40.06, '2020-11-24', 1, 2, 2020, NULL),
(165, 1, 1, 1, 83.59, '2020-11-28', 1, 7, 2020, NULL),
(166, 1, 1, 1, 1241.41, '2020-11-28', 1, 7, 2020, NULL),
(167, 3, 1, 1, 1048.86, '2020-11-28', 1, 2, 2020, NULL),
(168, 3, 1, 1, 276.14, '2020-11-28', 1, 2, 2020, NULL),
(169, 3, 1, 1, 590.00616666667, '2020-11-29', 1, 10, 2020, NULL),
(170, 3, 1, 1, 756.79383333333, '2020-11-29', 1, 10, 2020, NULL),
(171, 2, 1, 1, 7800, '2020-11-29', 1, 10, 2020, NULL),
(172, 2, 1, 1, 8000, '2020-11-29', 1, 10, 2020, NULL),
(173, 3, 1, 1, 327.764, '2020-11-29', 1, 10, 2020, NULL),
(174, 2, 1, 1, 0.52, '2020-12-01', 1, 10, 2020, NULL),
(175, 3, 1, 1, 0.5218, '2020-12-01', 1, 10, 2020, NULL),
(176, 2, 1, 1, 2500, '2020-12-02', 1, 10, 2020, NULL),
(177, 3, 1, 1, 5.2171428571429, '2020-12-02', 1, 10, 2020, NULL),
(178, 2, 1, 1, 1.7101639344262, '2020-12-02', 1, 10, 2020, NULL),
(179, 3, 1, 1, 1.0434285714286, '2020-12-02', 1, 10, 2020, NULL),
(180, 2, 1, 1, 102, '2020-12-02', 1, 10, 2020, NULL),
(181, 3, 1, 1, 1.5651428571428, '2020-12-02', 1, 10, 2020, NULL);

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
(13, '5001', 'Gasto de Sueldo', 1),
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
  `fecha_alta` date DEFAULT NULL,
  `baja` tinyint(1) NOT NULL,
  `fecha_baja` date DEFAULT NULL,
  `direccion_particular` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rol` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL,
  `identificacion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sueldo_bruto_mensual` double DEFAULT NULL,
  `salario_x_hora` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `empleado`
--

INSERT INTO `empleado` (`id`, `id_unidad_id`, `id_cargo_id`, `id_usuario_id`, `nombre`, `correo`, `fecha_alta`, `baja`, `fecha_baja`, `direccion_particular`, `telefono`, `rol`, `activo`, `identificacion`, `sueldo_bruto_mensual`, `salario_x_hora`) VALUES
(1, 1, 1, 1, 'Alberto hernandez Correa', 'admin@solyag.com', '2020-10-28', 0, NULL, 'Calle A', '555555555', 'ROLE_ADMIN', 1, '123', NULL, 1000),
(2, 1, 1, NULL, 'Maria Maire Valdes Llende', 'aaa@gmal.cd', '2021-01-14', 0, NULL, 'sdsdasasdas', '2112121', NULL, 1, '23213123', NULL, 15000),
(3, 1, 1, 2, 'Marlon Hernandez Valdes', 'sss@aasas.ass', '2021-01-08', 0, NULL, 'fdsfdsfdsfdsd', '323123223', 'ROLE_USER', 1, '12365', 25000, NULL),
(4, 1, 1, NULL, 'Camilo Alberto Hernandez', 'ccc@cc.cc', '2021-01-14', 0, NULL, 'Pepe Portilla', '+5355816826', NULL, 1, '89102815009', 65000, NULL),
(5, 1, 1, NULL, 'Leidiana Delgado Prado', 'aaaa@aaa.aa', '2021-01-14', 0, NULL, 'dsfdsfds', '45896544', NULL, 1, '8815896523', 330000, NULL);

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
(2, 1, '01', 'Faltante de Shampu', 1, 2020);

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
  `id_contrato_id` int(11) DEFAULT NULL,
  `cuenta_obligacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subcuenta_obligacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL,
  `id_centro_costo_id` int(11) DEFAULT NULL,
  `id_orden_trabajo_id` int(11) DEFAULT NULL,
  `id_elemento_gasto_id` int(11) DEFAULT NULL,
  `id_expediente_id` int(11) DEFAULT NULL,
  `importe` double NOT NULL,
  `contabilizada` tinyint(1) DEFAULT NULL,
  `id_categoria_cliente_id` int(11) DEFAULT NULL,
  `id_termino_pago_id` int(11) DEFAULT NULL,
  `id_moneda_id` int(11) DEFAULT NULL,
  `id_factura_cancela_id` int(11) DEFAULT NULL,
  `ncf` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelada` tinyint(1) DEFAULT NULL,
  `motivo_cancelacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `servicio` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `factura`
--

INSERT INTO `factura` (`id`, `id_unidad_id`, `id_usuario_id`, `fecha_factura`, `tipo_cliente`, `id_cliente`, `nro_factura`, `anno`, `id_contrato_id`, `cuenta_obligacion`, `subcuenta_obligacion`, `activo`, `id_centro_costo_id`, `id_orden_trabajo_id`, `id_elemento_gasto_id`, `id_expediente_id`, `importe`, `contabilizada`, `id_categoria_cliente_id`, `id_termino_pago_id`, `id_moneda_id`, `id_factura_cancela_id`, `ncf`, `cancelada`, `motivo_cancelacion`, `servicio`) VALUES
(37, 1, 1, '2020-11-29', 3, 4, 1, 2020, NULL, '135', '0030', 1, NULL, NULL, NULL, NULL, 158.12, 1, 1, 4, 1, NULL, 'B0100000001', 0, NULL, NULL),
(38, 1, 1, '2020-11-29', 3, 5, 2, 2020, NULL, '135', '0030', 1, NULL, NULL, NULL, NULL, 3973.74, 1, 1, 4, 1, NULL, 'B0100000002', 0, NULL, NULL),
(39, 1, 1, '2020-11-29', 1, 1, 3, 2020, NULL, '135', '0010', 1, NULL, NULL, NULL, NULL, 10100, 1, 1, 4, 1, NULL, 'B0100000003', 0, NULL, NULL),
(40, 1, 1, '2020-11-29', 3, 4, 4, 2020, NULL, '135', '0030', 1, NULL, NULL, NULL, NULL, 10907, 1, 1, 4, 1, NULL, 'B0100000004', 0, NULL, NULL),
(41, 1, 1, '2020-12-01', 1, 1, 5, 2020, NULL, '135', '0010', 1, NULL, NULL, NULL, NULL, 217, 1, 1, 1, 1, NULL, 'B0100000005', 0, NULL, NULL),
(42, 1, 1, '2020-12-02', 3, 4, 6, 2020, NULL, '135', '0030', 1, NULL, NULL, NULL, NULL, 2000, 1, 2, 2, 1, NULL, 'B0200000001', 0, NULL, NULL),
(43, 1, 1, '2020-12-02', 3, 4, 7, 2020, NULL, '135', '0030', 1, NULL, NULL, NULL, NULL, 1200, 1, 3, 1, 1, NULL, 'B0300000001', 0, NULL, NULL),
(44, 1, 1, '2020-12-02', 3, 5, 8, 2020, NULL, '135', '0030', 1, NULL, NULL, NULL, NULL, 1300, 1, 3, 1, 1, NULL, 'B0300000002', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `facturas_comprobante`
--

CREATE TABLE `facturas_comprobante` (
  `id` int(11) NOT NULL,
  `id_factura_id` int(11) NOT NULL,
  `id_comprobante_id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `anno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `facturas_comprobante`
--

INSERT INTO `facturas_comprobante` (`id`, `id_factura_id`, `id_comprobante_id`, `id_unidad_id`, `anno`) VALUES
(35, 37, 31, 1, 2020),
(36, 38, 31, 1, 2020),
(37, 39, 31, 1, 2020),
(38, 40, 31, 1, 2020),
(39, 41, 31, 1, 2020),
(40, 42, 66, 1, 2020),
(41, 43, 67, 1, 2020),
(42, 44, 67, 1, 2020);

-- --------------------------------------------------------

--
-- Table structure for table `factura_documento`
--

CREATE TABLE `factura_documento` (
  `id` int(11) NOT NULL,
  `id_factura_id` int(11) NOT NULL,
  `id_documento_id` int(11) NOT NULL,
  `id_movimiento_venta_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `factura_documento`
--

INSERT INTO `factura_documento` (`id`, `id_factura_id`, `id_documento_id`, `id_movimiento_venta_id`) VALUES
(42, 37, 169, NULL),
(43, 37, 169, NULL),
(44, 37, 169, NULL),
(45, 38, 170, NULL),
(46, 38, 170, NULL),
(47, 38, 170, NULL),
(48, 39, 171, NULL),
(49, 39, 171, NULL),
(50, 40, 172, NULL),
(51, 40, 172, NULL),
(52, 40, 173, NULL),
(53, 40, 173, NULL),
(54, 41, 174, NULL),
(55, 41, 175, NULL),
(56, 42, 176, NULL),
(57, 42, 177, NULL),
(58, 43, 178, NULL),
(59, 43, 179, NULL),
(60, 44, 180, NULL),
(61, 44, 181, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `factura_imposdom`
--

CREATE TABLE `factura_imposdom` (
  `id` int(11) NOT NULL,
  `id_cliente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cedula` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `casillero` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ciudad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `sh` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cierre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pago` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `json` varchar(5000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lb` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `factura_no_contable`
--

CREATE TABLE `factura_no_contable` (
  `id` int(11) NOT NULL,
  `json` varchar(10000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_moneda` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empleado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datetime` datetime NOT NULL,
  `total` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_cliente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_cliente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
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

--
-- Dumping data for table `grupo_activos`
--

INSERT INTO `grupo_activos` (`id`, `porciento_deprecia_anno`, `descripcion`, `activo`, `codigo`) VALUES
(1, 10, 'Grupo 1', 1, '0010'),
(2, 5, 'Grupo 2', 1, '0020'),
(3, 0, 'Grupo 3', 1, '0030');

-- --------------------------------------------------------

--
-- Table structure for table `hotel_destino`
--

CREATE TABLE `hotel_destino` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hotel_origen`
--

CREATE TABLE `hotel_origen` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `impuesto_sobre_renta`
--

CREATE TABLE `impuesto_sobre_renta` (
  `id` int(11) NOT NULL,
  `id_empleado_id` int(11) NOT NULL,
  `id_nomina_pago_id` int(11) NOT NULL,
  `id_rango_escala_id` int(11) NOT NULL,
  `seguridad_social_mensual` double DEFAULT NULL,
  `salario_bruto_anual` double NOT NULL,
  `seguridad_social_anual` double DEFAULT NULL,
  `salario_despues_seguridad_social` double NOT NULL,
  `monto_segun_rango` double DEFAULT NULL,
  `monto_segun_rango_escala` double DEFAULT NULL,
  `excedente_segun_rango_escala` double DEFAULT NULL,
  `por_ciento_impuesto_excedente` double DEFAULT NULL,
  `monto_adicional_rango_escala` double DEFAULT NULL,
  `impuesto_renta_pagar_anual` double DEFAULT NULL,
  `impuesto_renta_pagar_mensual` double DEFAULT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `impuesto_sobre_renta`
--

INSERT INTO `impuesto_sobre_renta` (`id`, `id_empleado_id`, `id_nomina_pago_id`, `id_rango_escala_id`, `seguridad_social_mensual`, `salario_bruto_anual`, `seguridad_social_anual`, `salario_despues_seguridad_social`, `monto_segun_rango`, `monto_segun_rango_escala`, `excedente_segun_rango_escala`, `por_ciento_impuesto_excedente`, `monto_adicional_rango_escala`, `impuesto_renta_pagar_anual`, `impuesto_renta_pagar_mensual`, `fecha`) VALUES
(10, 4, 11, 3, 4137, 840000, 49644, 790356, 624329.01, 624329.01, 166026.99, 33205.4, 31216, 64421.4, 5368.45, '2020-12-03'),
(11, 3, 12, 1, 1654.8, 336000, 19857.6, 316142.4, 0, 0, 316142.4, 0, 0, 0, 0, '2020-12-03'),
(12, 5, 13, 4, 22458, 4560000, 269496, 4290504, 867123.01, 867123.01, 3423380.99, 855845.25, 79776, 935621.25, 77968.44, '2020-12-03'),
(13, 2, 14, 4, 257209.11, 52224000, 3086509.32, 49137490.68, 867123.01, 867123.01, 48270367.67, 12067591.92, 79776, 12147367.92, 1012280.66, '2020-12-03'),
(14, 1, 15, 1, 1442.04, 290400, 17304.48, 273095.52, 0, 0, 273095.52, 0, 0, 0, 0, '2020-12-03'),
(20, 4, 21, 3, 4137, 840000, 49644, 790356, 624329.01, 624329.01, 166026.99, 33205.4, 31216, 64421.4, 5368.45, '2020-12-03'),
(21, 5, 22, 1, 2092.14, 424800, 25105.68, 399694.32, 0, 0, 399694.32, 0, 0, 0, 0, '2020-12-03');

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
(52, 138, 1, '', '', '405', '0010', '1', 2020, '25', '2020-11-02', 1, 0),
(53, 139, 2, '', '', '405', '0010', '2', 2020, '152', '2020-11-03', 1, 0),
(54, 140, 3, '', '', '405', '0010', '3', 2020, '68', '2020-11-09', 1, 0),
(55, 141, 4, '', '', '405', '0010', '4', 2020, '189', '2020-11-10', 1, 0),
(56, 142, 5, '', '', '405', '0010', '5', 2020, '1095', '2020-11-10', 1, 0),
(57, 143, 6, '', '', '405', '0010', '6', 2020, '20381', '2020-11-17', 1, 0),
(58, 159, 9, '', '', '405', '0010', '1', 2020, '31', '2020-11-17', 1, 0),
(59, 160, 7, '', '', '405', '0010', '2', 2020, '250', '2020-11-17', 1, 0),
(60, 161, 8, '', '', '405', '0010', '3', 2020, '1025', '2020-11-18', 1, 0),
(61, 162, 7, '', '', '405', '0010', '4', 2020, '295', '2020-11-18', 1, 0),
(62, 163, NULL, '', '', '700', '0050', '1', 2020, NULL, NULL, 1, 1),
(63, 164, NULL, '', '', '700', '0050', '2', 2020, NULL, NULL, 1, 1),
(64, 167, NULL, '', '', '700', '0050', '3', 2020, NULL, NULL, 1, 1),
(65, 168, NULL, '', '', '700', '0050', '4', 2020, NULL, NULL, 1, 1);

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
(92, 1, 13, '1046-01', '183', 'Detergente', 90, 15.43, 1, '0010', '405', '0010'),
(93, 1, 13, '1046-51', '183', 'Jabon', 195, 19.6, 1, '0010', '405', '0010'),
(94, 1, 13, '1046-12', '183', 'Shampu', 0, 0, 0, '0010', '405', '0010'),
(95, 1, 13, '108051', '183', 'Jabon', 200, 28.4, 1, '0010', '405', '0010'),
(96, 1, 13, '1075-23', '183', 'Shampu', 405, 115.59, 1, '0010', '405', '0010'),
(97, 1, 13, '1080-01', '183', 'Jamon 250 grs', 120, 60.3, 1, '0020', '405', '0010'),
(98, 1, 8, '1080-010', '183', 'Arroz', 560, 29.12, 1, '0020', '405', '0010'),
(99, 1, 10, '1080-025', '183', 'Aceite', 185, 27.27, 1, '0020', '405', '0010'),
(100, 1, 8, '1070-015', '183', 'Arroz', 75, 3.38, 1, '0020', '405', '0010'),
(101, 1, 10, '1070-030', '183', 'Aceite', 0, 0, 0, '0020', '405', '0010'),
(102, 1, 13, '1070-02', '183', 'Jamon 300 grs', 45, 20.34, 1, '0020', '405', '0010'),
(103, 1, 13, '263543', '183', 'Omeprazol', 200, 1807.07, 1, '0030', '405', '0010'),
(104, 1, 14, '2571-02', '183', 'Dipirona', 325, 331.5, 1, '0030', '405', '0010'),
(105, 1, 13, '1070-040', '183', 'Vitamina C', 395, 959.32, 1, '0030', '405', '0010'),
(106, 1, 14, '2571-002', '183', 'Dipirona', 90, 85.5, 1, '0030', '405', '0010'),
(107, 2, 13, '1046-01', '189', 'Detergentes', 295, 50.449836065574, 1, '0020', '697', '0020'),
(108, 2, 8, '1080-010', '189', 'Arroz', 190, 9.88, 1, '0030', '697', '0020'),
(109, 2, 14, '2571-02', '189', 'Dipirona', 100, 102, 1, '0040', '697', '0020'),
(110, 2, 13, '263543', '189', 'Omeprazol', 200, 1807.2, 1, '0040', '697', '0020'),
(111, 2, 13, '2013151', '189', 'Split 2.0 T', 20, 5000, 1, '0040', '405', '0010'),
(112, 2, 13, '20131453', '189', 'Split 1.5 Ton', 35, 7000, 1, '0040', '405', '0010'),
(113, 2, 13, '20131452', '189', 'Split de 1.0 Ton', 50, 7500, 1, '0040', '405', '0010'),
(114, 2, 13, '2018340', '189', 'Recargas', 150, 2700, 1, '0010', '405', '0010'),
(115, 2, 13, '2018342', '189', 'Recarga 30 USD', 0, 0, 0, '0010', '405', '0010');

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
-- Table structure for table `moneda_pais`
--

CREATE TABLE `moneda_pais` (
  `id` int(11) NOT NULL,
  `id_pais` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_moneda` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `activo` tinyint(1) NOT NULL,
  `id_unidad_destino_origen_id` int(11) DEFAULT NULL,
  `id_proveedor_id` int(11) DEFAULT NULL,
  `id_tipo_cliente` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_movimiento_cancelado_id` int(11) DEFAULT NULL,
  `cancelado` tinyint(1) DEFAULT NULL,
  `fecha_factura` date DEFAULT NULL,
  `nro_factura` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movimiento_activo_fijo`
--

INSERT INTO `movimiento_activo_fijo` (`id`, `id_unidad_id`, `id_activo_fijo_id`, `id_tipo_movimiento_id`, `id_cuenta_id`, `id_subcuenta_id`, `id_usuario_id`, `fecha`, `fundamentacion`, `entrada`, `nro_consecutivo`, `anno`, `activo`, `id_unidad_destino_origen_id`, `id_proveedor_id`, `id_tipo_cliente`, `id_cliente`, `id_movimiento_cancelado_id`, `cancelado`, `fecha_factura`, `nro_factura`) VALUES
(30, 1, 22, 1, 22, 138, 1, '2021-01-01', 'Monitor de PC de Escritorio', 1, 1, 2021, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 1, 23, 2, 22, 138, 1, '2021-01-04', 'Compra de PC para Programadores', 1, 1, 2021, 1, NULL, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 1, 24, 5, 22, 138, 1, '2021-01-04', 'Mouse y Teclado para armar completamente la computadore de los programadores, proveniento de la Unidad 002', 1, 1, 2021, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 1, 26, 1, 22, 138, 1, '2021-01-04', 'Buro de trabajo para los programadores, tamanno estandar', 1, 2, 2021, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 1, 24, 6, 22, 138, 1, '2021-01-04', 'DEVOLUCION POR PROBLEMAS TECNICOS', 0, 1, 2021, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 1, 23, 6, 22, 138, 1, '2021-01-05', 'vaja del centro, pro problemas tecnicos', 0, 2, 2021, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 1, 26, 3, 22, 138, 1, '2021-01-04', 'fdfdfdf', 0, 1, 2021, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 1, 26, 6, 22, 138, 1, '2021-01-06', 'sasa', 0, 3, 2021, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 1, 27, 2, 22, 138, 1, '2021-01-11', 'cccxxxcxc', 1, 2, 2021, 1, NULL, 1, NULL, NULL, NULL, NULL, '2021-01-11', '123');

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
  `id_orden_trabajo_id` int(11) DEFAULT NULL,
  `id_factura_id` int(11) DEFAULT NULL,
  `cuenta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nro_subcuenta_deudora` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_movimiento_cancelado_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movimiento_mercancia`
--

INSERT INTO `movimiento_mercancia` (`id`, `id_mercancia_id`, `id_documento_id`, `id_tipo_documento_id`, `id_usuario_id`, `id_centro_costo_id`, `id_elemento_gasto_id`, `cantidad`, `importe`, `existencia`, `fecha`, `activo`, `entrada`, `id_almacen_id`, `id_expediente_id`, `id_orden_trabajo_id`, `id_factura_id`, `cuenta`, `nro_subcuenta_deudora`, `id_movimiento_cancelado_id`) VALUES
(266, 92, 138, 1, 1, NULL, NULL, 450, 81.18, 450, '2020-11-20', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(267, 93, 138, 1, 1, NULL, NULL, 450, 45.23, 450, '2020-11-20', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(268, 94, 138, 1, 1, NULL, NULL, 450, 112.5, 450, '2020-11-20', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(269, 92, 139, 1, 1, NULL, NULL, 200, 30.1, 650, '2020-11-20', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(270, 95, 139, 1, 1, NULL, NULL, 200, 28.4, 200, '2020-11-20', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(271, 96, 139, 1, 1, NULL, NULL, 200, 70, 200, '2020-11-20', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(272, 97, 140, 1, 1, NULL, NULL, 120, 60.3, 120, '2020-11-20', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(273, 98, 140, 1, 1, NULL, NULL, 750, 39, 750, '2020-11-20', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(274, 99, 140, 1, 1, NULL, NULL, 200, 30, 200, '2020-11-20', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(275, 100, 141, 1, 1, NULL, NULL, 225, 10.13, 225, '2020-11-20', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(276, 101, 141, 1, 1, NULL, NULL, 30, 3.96, 30, '2020-11-20', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(277, 102, 141, 1, 1, NULL, NULL, 70, 31.64, 70, '2020-11-20', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(278, 103, 142, 1, 1, NULL, NULL, 325, 3073.3, 325, '2020-11-20', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(279, 104, 142, 1, 1, NULL, NULL, 550, 561, 550, '2020-11-20', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(280, 105, 142, 1, 1, NULL, NULL, 325, 765.05, 325, '2020-11-20', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(281, 106, 143, 1, 1, NULL, NULL, 200, 190, 200, '2020-11-20', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(282, 103, 143, 1, 1, NULL, NULL, 200, 1670.4, 525, '2020-11-20', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(283, 105, 143, 1, 1, NULL, NULL, 200, 510, 525, '2020-11-20', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(284, 92, 144, 7, 1, 22, 2, 50, 8.56, 600, '2020-11-20', 1, 0, 1, NULL, 15, NULL, NULL, NULL, NULL),
(285, 93, 144, 7, 1, 22, 2, 50, 5.03, 400, '2020-11-20', 1, 0, 1, NULL, 15, NULL, NULL, NULL, NULL),
(286, 94, 144, 7, 1, 22, 2, 50, 12.5, 400, '2020-11-20', 1, 0, 1, NULL, 15, NULL, NULL, NULL, NULL),
(287, 97, 145, 7, 1, 24, 3, 20, 10.05, 100, '2020-11-20', 1, 0, 1, NULL, 10, NULL, NULL, NULL, NULL),
(288, 98, 145, 7, 1, 24, 3, 100, 5.2, 650, '2020-11-20', 1, 0, 1, NULL, 10, NULL, NULL, NULL, NULL),
(289, 99, 145, 7, 1, 24, 7, 20, 3, 180, '2020-11-20', 1, 0, 1, NULL, 10, NULL, NULL, NULL, NULL),
(290, 104, 146, 7, 1, 23, 7, 25, 25.5, 525, '2020-11-20', 1, 0, 1, NULL, 11, NULL, NULL, NULL, NULL),
(291, 103, 146, 7, 1, 23, 7, 25, 225.89, 500, '2020-11-20', 1, 0, 1, NULL, 11, NULL, NULL, NULL, NULL),
(292, 105, 146, 7, 1, 23, 7, 25, 60.72, 500, '2020-11-20', 1, 0, 1, NULL, 11, NULL, NULL, NULL, NULL),
(293, 92, 147, 7, 1, 22, 2, 35, 5.99, 565, '2020-11-20', 1, 0, 1, NULL, 12, NULL, NULL, NULL, NULL),
(294, 93, 147, 7, 1, 22, 2, 35, 3.52, 365, '2020-11-20', 1, 0, 1, NULL, 12, NULL, NULL, NULL, NULL),
(295, 94, 147, 7, 1, 22, 2, 35, 8.75, 365, '2020-11-20', 1, 0, 1, NULL, 12, NULL, NULL, NULL, NULL),
(296, 102, 148, 7, 1, 24, 3, 25, 11.3, 45, '2020-11-20', 1, 0, 1, NULL, 13, NULL, NULL, NULL, NULL),
(297, 100, 148, 7, 1, 24, 3, 150, 6.75, 75, '2020-11-20', 1, 0, 1, NULL, 13, NULL, NULL, NULL, NULL),
(298, 99, 148, 7, 1, 24, 3, 25, 3.75, 155, '2020-11-20', 1, 0, 1, NULL, 13, NULL, NULL, NULL, NULL),
(299, 104, 149, 7, 1, 23, 7, 45, 45.9, 480, '2020-11-20', 1, 0, 1, NULL, 14, NULL, NULL, NULL, NULL),
(300, 103, 149, 7, 1, 23, 7, 45, 406.6, 455, '2020-11-20', 1, 0, 1, NULL, 14, NULL, NULL, NULL, NULL),
(301, 105, 149, 7, 1, 23, 7, 45, 109.29, 455, '2020-11-20', 1, 0, 1, NULL, 14, NULL, NULL, NULL, NULL),
(302, 94, 150, 4, 1, NULL, NULL, 365, 91.25, 0, '2020-11-21', 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(303, 101, 150, 4, 1, NULL, NULL, 30, 3.96, 0, '2020-11-21', 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(304, 96, 151, 3, 1, NULL, NULL, 365, 91.25, 565, '2020-11-21', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(305, 99, 151, 3, 1, NULL, NULL, 30, 3.96, 185, '2020-11-21', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(306, 92, 152, 6, 1, NULL, NULL, 305, 52.16, 260, '2020-11-21', 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(307, 98, 152, 6, 1, NULL, NULL, 200, 10.4, 450, '2020-11-21', 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(308, 104, 152, 6, 1, NULL, NULL, 200, 204, 280, '2020-11-21', 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(309, 103, 152, 6, 1, NULL, NULL, 200, 1807.2, 255, '2020-11-21', 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(310, 107, 153, 5, 1, NULL, NULL, 305, 52.16, 305, '2020-11-21', 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(311, 108, 153, 5, 1, NULL, NULL, 200, 10.4, 200, '2020-11-21', 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(312, 109, 153, 5, 1, NULL, NULL, 200, 204, 200, '2020-11-21', 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(313, 110, 153, 5, 1, NULL, NULL, 200, 1807.2, 200, '2020-11-21', 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(314, 98, 154, 3, 1, NULL, NULL, 10, 0.52, 460, '2020-11-27', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(315, 96, 155, 4, 1, NULL, NULL, 10, 2.85, 555, '2020-11-27', 1, 0, 1, 2, NULL, NULL, NULL, NULL, NULL),
(316, 93, 156, 7, 1, 25, 2, 20, 2.01, 345, '2020-11-27', 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(317, 92, 156, 7, 1, 25, 2, 20, 3.43, 240, '2020-11-27', 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(318, 105, 156, 7, 1, 25, 7, 5, 12.14, 450, '2020-11-27', 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(319, 106, 156, 7, 1, 25, 7, 10, 9.5, 190, '2020-11-27', 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(320, 99, 156, 7, 1, 24, 3, 20, 2.94, 165, '2020-11-27', 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(321, 97, 157, 9, 1, NULL, NULL, 20, 10.05, 120, '2020-11-27', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(322, 98, 157, 9, 1, NULL, NULL, 100, 5.2, 560, '2020-11-27', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(323, 99, 157, 9, 1, NULL, NULL, 20, 3, 185, '2020-11-27', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(324, 104, 158, 9, 1, NULL, NULL, 45, 45.9, 325, '2020-11-27', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(325, 103, 158, 9, 1, NULL, NULL, 45, 406.6, 300, '2020-11-27', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(326, 105, 158, 9, 1, NULL, NULL, 45, 109.29, 495, '2020-11-27', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(327, 111, 159, 1, 1, NULL, NULL, 50, 12500, 50, '2020-11-23', 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(328, 112, 159, 1, 1, NULL, NULL, 50, 10000, 50, '2020-11-23', 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(329, 113, 159, 1, 1, NULL, NULL, 50, 7500, 50, '2020-11-23', 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(330, 114, 160, 1, 1, NULL, NULL, 150, 3000, 150, '2020-11-23', 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(331, 115, 161, 1, 1, NULL, NULL, 200, 6000, 200, '2020-11-23', 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(332, 114, 162, 1, 1, NULL, NULL, 100, 1500, 250, '2020-11-23', 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(333, 92, 165, 7, 1, 22, 2, 150, 25.71, 90, '2020-11-28', 1, 0, 1, NULL, 16, NULL, NULL, NULL, NULL),
(334, 93, 165, 7, 1, 22, 2, 150, 15.07, 195, '2020-11-28', 1, 0, 1, NULL, 16, NULL, NULL, NULL, NULL),
(335, 96, 165, 7, 1, 22, 2, 150, 42.81, 405, '2020-11-28', 1, 0, 1, NULL, 16, NULL, NULL, NULL, NULL),
(336, 103, 166, 7, 1, 23, 7, 100, 903.54, 200, '2020-11-28', 1, 0, 1, NULL, 17, NULL, NULL, NULL, NULL),
(337, 105, 166, 7, 1, 23, 7, 100, 242.87, 395, '2020-11-28', 1, 0, 1, NULL, 17, NULL, NULL, NULL, NULL),
(338, 106, 166, 7, 1, 23, 7, 100, 95, 90, '2020-11-28', 1, 0, 1, NULL, 17, NULL, NULL, NULL, NULL),
(339, 115, 171, 10, 1, NULL, NULL, 200, 6000, 0, '2020-11-29', 1, 0, 2, NULL, NULL, 39, '815', '0010', NULL),
(340, 114, 171, 10, 1, NULL, NULL, 100, 1800, 150, '2020-11-29', 1, 0, 2, NULL, NULL, 39, '815', '0010', NULL),
(341, 111, 172, 10, 1, NULL, NULL, 20, 5000, 30, '2020-11-29', 1, 0, 2, NULL, NULL, 40, '815', '0040', NULL),
(342, 112, 172, 10, 1, NULL, NULL, 15, 3000, 35, '2020-11-29', 1, 0, 2, NULL, NULL, 40, '815', '0040', NULL),
(343, 108, 174, 10, 1, NULL, NULL, 10, 0.52, 190, '2020-12-01', 1, 0, 2, NULL, NULL, 41, '815', '0030', NULL),
(344, 111, 176, 10, 1, NULL, NULL, 10, 2500, 20, '2020-12-02', 1, 0, 2, NULL, NULL, 42, '815', '0040', NULL),
(345, 107, 178, 10, 1, NULL, NULL, 10, 1.7101639344262, 295, '2020-12-02', 1, 0, 2, NULL, NULL, 43, '815', '0020', NULL),
(346, 109, 180, 10, 1, NULL, NULL, 100, 102, 100, '2020-12-02', 1, 0, 2, NULL, NULL, 44, '815', '0040', NULL);

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
  `id_expediente_id` int(11) DEFAULT NULL,
  `id_factura_id` int(11) DEFAULT NULL,
  `cuenta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nro_subcuenta_deudora` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_movimiento_cancelado_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movimiento_producto`
--

INSERT INTO `movimiento_producto` (`id`, `id_producto_id`, `id_documento_id`, `id_tipo_documento_id`, `id_usuario_id`, `id_centro_costo_id`, `id_elemento_gasto_id`, `cantidad`, `importe`, `existencia`, `fecha`, `activo`, `entrada`, `id_almacen_id`, `id_orden_trabajo_id`, `id_expediente_id`, `id_factura_id`, `cuenta`, `nro_subcuenta_deudora`, `id_movimiento_cancelado_id`) VALUES
(32, 7, 163, 2, 1, 22, NULL, 50, 26.09, 50, '2020-11-24', 1, 1, 3, 15, NULL, NULL, NULL, NULL, NULL),
(33, 8, 163, 2, 1, 23, NULL, 25, 312.11, 25, '2020-11-24', 1, 1, 3, 11, NULL, NULL, NULL, NULL, NULL),
(34, 9, 164, 2, 1, 22, NULL, 35, 18.26, 35, '2020-11-24', 1, 1, 3, 12, NULL, NULL, NULL, NULL, NULL),
(35, 10, 164, 2, 1, 24, NULL, 25, 21.8, 25, '2020-11-24', 1, 1, 3, 13, NULL, NULL, NULL, NULL, NULL),
(36, 11, 167, 2, 1, 22, NULL, 100, 55.73, 100, '2020-11-28', 1, 1, 3, 16, NULL, NULL, NULL, NULL, NULL),
(37, 12, 167, 2, 1, 23, NULL, 80, 993.13, 80, '2020-11-28', 1, 1, 3, 17, NULL, NULL, NULL, NULL, NULL),
(38, 11, 168, 2, 1, 22, NULL, 50, 27.86, 150, '2020-11-28', 1, 1, 3, 16, NULL, NULL, NULL, NULL, NULL),
(39, 12, 168, 2, 1, 22, NULL, 20, 248.28, 100, '2020-11-28', 1, 1, 3, 16, NULL, NULL, NULL, NULL, NULL),
(40, 12, 169, 10, 1, NULL, NULL, 45, 558.6345, 55, '2020-11-29', 1, 0, 3, NULL, NULL, 37, '810', '0160', NULL),
(41, 11, 169, 10, 1, NULL, NULL, 25, 13.931666666667, 125, '2020-11-29', 1, 0, 3, NULL, NULL, 37, '810', '0150', NULL),
(42, 10, 169, 10, 1, NULL, NULL, 20, 17.44, 5, '2020-11-29', 1, 0, 3, NULL, NULL, 37, '810', '0170', NULL),
(43, 12, 170, 10, 1, NULL, NULL, 55, 682.7755, 0, '2020-11-29', 1, 0, 3, NULL, NULL, 38, '810', '0160', NULL),
(44, 11, 170, 10, 1, NULL, NULL, 125, 69.658333333333, 0, '2020-11-29', 1, 0, 3, NULL, NULL, 38, '810', '0150', NULL),
(45, 10, 170, 10, 1, NULL, NULL, 5, 4.36, 0, '2020-11-29', 1, 0, 3, NULL, NULL, 38, '810', '0170', NULL),
(46, 7, 173, 10, 1, NULL, NULL, 30, 15.654, 20, '2020-11-29', 1, 0, 3, NULL, NULL, 40, '810', '0150', NULL),
(47, 8, 173, 10, 1, NULL, NULL, 25, 312.11, 0, '2020-11-29', 1, 0, 3, NULL, NULL, 40, '810', '0160', NULL),
(48, 7, 175, 10, 1, NULL, NULL, 1, 0.5218, 19, '2020-12-01', 1, 0, 3, NULL, NULL, 41, '810', '0150', NULL),
(49, 9, 177, 10, 1, NULL, NULL, 10, 5.2171428571429, 25, '2020-12-02', 1, 0, 3, NULL, NULL, 42, '810', '0150', NULL),
(50, 9, 179, 10, 1, NULL, NULL, 2, 1.0434285714286, 23, '2020-12-02', 1, 0, 3, NULL, NULL, 43, '810', '0150', NULL),
(51, 9, 181, 10, 1, NULL, NULL, 3, 1.5651428571428, 20, '2020-12-02', 1, 0, 3, NULL, NULL, 44, '810', '0150', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `movimiento_servicio`
--

CREATE TABLE `movimiento_servicio` (
  `id` int(11) NOT NULL,
  `id_factura_id` int(11) NOT NULL,
  `servicio_id` int(11) NOT NULL,
  `cantidad` double NOT NULL,
  `precio` double NOT NULL,
  `impuesto` double DEFAULT NULL,
  `activo` tinyint(1) NOT NULL,
  `cuenta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_subcuenta_deudora` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cuenta_nominal_acreedora` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subcuenta_nominal_acreedora` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `costo` double DEFAULT NULL,
  `anno` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `activo` tinyint(1) NOT NULL,
  `id_almacen_id` int(11) NOT NULL,
  `cuenta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_subcuenta_deudora` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `costo` double DEFAULT NULL,
  `anno` int(11) DEFAULT NULL,
  `id_centro_costo_acreedor_id` int(11) DEFAULT NULL,
  `id_orden_trabajo_acreedor_id` int(11) DEFAULT NULL,
  `id_elemento_gasto_acreedor_id` int(11) DEFAULT NULL,
  `id_expediente_acreedor_id` int(11) DEFAULT NULL,
  `cuenta_nominal_acreedora` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subcuenta_nominal_acreedora` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_mercancia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movimiento_venta`
--

INSERT INTO `movimiento_venta` (`id`, `id_factura_id`, `mercancia`, `codigo`, `cantidad`, `precio`, `descuento_recarga`, `existencia`, `activo`, `id_almacen_id`, `cuenta`, `nro_subcuenta_deudora`, `costo`, `anno`, `id_centro_costo_acreedor_id`, `id_orden_trabajo_acreedor_id`, `id_elemento_gasto_acreedor_id`, `id_expediente_acreedor_id`, `cuenta_nominal_acreedora`, `subcuenta_nominal_acreedora`, `descripcion`, `id_mercancia`) VALUES
(42, 37, 0, 'OT-09', 45, 1.5, 6.75, 55, 1, 3, '810', '0150', 12.4141, 2020, NULL, NULL, NULL, NULL, '900', '0150', 'VENTAS DE PRODUCTOS', 12),
(43, 37, 0, 'OT-07', 25, 1.25, 3.12, 125, 1, 3, '810', '0150', 0.557267, 2020, NULL, NULL, NULL, NULL, '900', '0160', 'VENTAS DE PRODUCTOS', 11),
(44, 37, 0, 'OT-05', 20, 2.25, 4.5, 5, 1, 3, '810', '0170', 0.872, 2020, NULL, NULL, NULL, NULL, '900', '0170', 'VENTAS DE PRODUCTOS', 10),
(45, 38, 0, 'OT-09', 55, 15, 8.25, 0, 1, 3, '810', '0150', 12.4141, 2020, NULL, NULL, NULL, NULL, '900', '0150', 'VENTAS DE PRODUCCION', 12),
(46, 38, 0, 'OT-07', 125, 25, 3.12, 0, 1, 3, '810', '0150', 0.557267, 2020, NULL, NULL, NULL, NULL, '900', '0150', 'VENTAS DE PRODUCCION', 11),
(47, 38, 0, 'OT-05', 5, 2.25, 1.12, 0, 1, 3, '810', '0170', 0.872, 2020, NULL, NULL, NULL, NULL, '900', '0170', 'VENTAS DE PRODUCCION', 10),
(48, 39, 1, '2018342', 200, 36, 70, 0, 1, 2, '815', '0010', 30, 2020, NULL, NULL, NULL, NULL, '901', '0010', 'VENTAS DE  MERCANCIAS', 115),
(49, 39, 1, '2018340', 100, 30, 30, 150, 1, 2, '815', '0010', 18, 2020, NULL, NULL, NULL, NULL, '901', '0010', 'VENTAS DE  MERCANCIAS', 114),
(50, 40, 1, '2013151', 20, 300, 60, 30, 1, 2, '815', '0040', 250, 2020, NULL, NULL, NULL, NULL, '901', '0040', 'VENTAS DE  MERCANCIAS', 111),
(51, 40, 1, '20131453', 15, 275, 41.25, 35, 1, 2, '815', '0040', 200, 2020, NULL, NULL, NULL, NULL, '901', '0040', 'VENTAS DE  MERCANCIAS', 112),
(52, 40, 0, 'OT-01', 30, 1.5, 4.5, 20, 1, 3, '810', '0150', 0.5218, 2020, NULL, NULL, NULL, NULL, '900', '0150', 'VENTAS DE  MERCANCIAS', 7),
(53, 40, 0, 'OT-03', 25, 25, 6.25, 0, 1, 3, '810', '0160', 12.4844, 2020, NULL, NULL, NULL, NULL, '900', '0160', 'VENTAS DE  MERCANCIAS', 8),
(54, 41, 1, '1080-010', 10, 20, 2, 190, 1, 2, '815', '0030', 0.052, 2020, NULL, NULL, NULL, NULL, '901', '0030', 'arroz para cuba', 108),
(55, 41, 0, 'OT-01', 1, 15, 0, 19, 1, 3, '810', '0150', 0.5218, 2020, NULL, NULL, NULL, NULL, '900', '0150', 'aseo para el personal', 7),
(56, 42, 1, '2013151', 10, 100, 0, 20, 1, 2, '815', '0040', 250, 2020, NULL, NULL, NULL, NULL, '901', '0040', 'split 2.0T', 111),
(57, 42, 0, 'OT-04', 10, 100, 0, 25, 1, 3, '810', '0150', 0.521714, 2020, NULL, NULL, NULL, NULL, '900', '0150', 'aseos cuba', 9),
(58, 43, 1, '1046-01', 10, 100, 0, 295, 1, 2, '815', '0020', 0.171016, 2020, NULL, NULL, NULL, NULL, '901', '0020', 'fffff', 107),
(59, 43, 0, 'OT-04', 2, 100, 0, 23, 1, 3, '810', '0150', 0.521714, 2020, NULL, NULL, NULL, NULL, '900', '0150', '.,.,', 9),
(60, 44, 1, '2571-02', 100, 10, 0, 100, 1, 2, '815', '0040', 1.02, 2020, NULL, NULL, NULL, NULL, '901', '0040', 'fgfgfg', 109),
(61, 44, 0, 'OT-04', 3, 100, 0, 20, 1, 3, '810', '0150', 0.521714, 2020, NULL, NULL, NULL, NULL, '900', '0150', 'gggg', 9);

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
-- Table structure for table `nomina_pago`
--

CREATE TABLE `nomina_pago` (
  `id` int(11) NOT NULL,
  `id_empleado_id` int(11) NOT NULL,
  `id_usuario_aprueba_id` int(11) DEFAULT NULL,
  `comision` double DEFAULT NULL,
  `vacaciones` double DEFAULT NULL,
  `horas_extra` double DEFAULT NULL,
  `otros` double DEFAULT NULL,
  `total_ingresos` double NOT NULL,
  `ingresos_cotizables_tss` double NOT NULL,
  `isr` double DEFAULT NULL,
  `ars` double DEFAULT NULL,
  `afp` double DEFAULT NULL,
  `cooperativa` double DEFAULT NULL,
  `plan_medico_complementario` double DEFAULT NULL,
  `restaurant` double DEFAULT NULL,
  `total_deducido` double DEFAULT NULL,
  `sueldo_neto_pagar` double DEFAULT NULL,
  `afp_empleador` double DEFAULT NULL,
  `sfs_empleador` double DEFAULT NULL,
  `srl_empleador` double DEFAULT NULL,
  `infotep_empleador` double DEFAULT NULL,
  `mes` int(11) NOT NULL,
  `anno` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `elaborada` tinyint(1) DEFAULT NULL,
  `aprobada` tinyint(1) DEFAULT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `quincena` int(11) NOT NULL,
  `salario_bruto` double DEFAULT NULL,
  `cant_horas_trabajadas` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nomina_pago`
--

INSERT INTO `nomina_pago` (`id`, `id_empleado_id`, `id_usuario_aprueba_id`, `comision`, `vacaciones`, `horas_extra`, `otros`, `total_ingresos`, `ingresos_cotizables_tss`, `isr`, `ars`, `afp`, `cooperativa`, `plan_medico_complementario`, `restaurant`, `total_deducido`, `sueldo_neto_pagar`, `afp_empleador`, `sfs_empleador`, `srl_empleador`, `infotep_empleador`, `mes`, `anno`, `fecha`, `elaborada`, `aprobada`, `id_unidad_id`, `quincena`, `salario_bruto`, `cant_horas_trabajadas`) VALUES
(11, 4, 1, 5000, 0, 1250, 0, 71250, 70000, 5368.45, 2128, 2009, 1750, 500, 800, 12555.45, 58694.55, 4970, 4963, 770, 700, 12, 2020, '2020-12-03', 1, 1, 1, 1, 65000, 0),
(12, 3, 1, 3000, 0, 2120, 0, 30120, 28000, 0, 851.2, 803.6, 700, 500, 800, 3654.8, 26465.2, 1988, 1985.2, 308, 280, 12, 2020, '2020-12-03', 1, 1, 1, 1, 25000, 0),
(13, 5, 1, 50000, 0, 1250, 0, 381250, 380000, 77968.44, 11552, 10906, 9500, 300, 600, 110826.44, 270423.56, 26980, 26942, 4180, 3800, 12, 2020, '2020-12-03', 1, 1, 1, 1, 330000, 0),
(14, 2, 1, 2000, 100, 120, 0, 4352220, 4352100, 1012280.66, 132303.84, 124905.27, 108800, 1000, 800, 1380089.77, 2972130.23, 308999.1, 308563.89, 47872, 43520, 12, 2020, '2020-12-03', 1, 1, 1, 1, 4350000, 290),
(15, 1, 1, 1200, 200, 0, 0, 24400, 24400, 0, 741.76, 700.28, 605, 120, 250, 2417.04, 21982.96, 1732.4, 1729.96, 266.2, 242, 12, 2020, '2020-12-03', 1, 1, 1, 1, 23000, 23),
(21, 4, 1, 5000, 0, 1250, 0, 71250, 70000, 5368.45, 2128, 2009, 1750, 500, 800, 12555.45, 58694.55, 4970, 4963, 770, 700, 12, 2020, '2020-12-03', 1, 1, 1, 2, 65000, 0),
(22, 5, 1, 2400, 0, 1250, 0, 36650, 35400, 0, 1076.16, 1015.98, 885, 500, 800, 4277.14, 32372.86, 2513.4, 2509.86, 389.4, 354, 12, 2020, '2020-12-03', 1, 1, 1, 2, 33000, 0);

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
-- Table structure for table `operaciones_comprobante_operaciones`
--

CREATE TABLE `operaciones_comprobante_operaciones` (
  `id` int(11) NOT NULL,
  `id_cuenta_id` int(11) NOT NULL,
  `id_subcuenta_id` int(11) NOT NULL,
  `id_centro_costo_id` int(11) DEFAULT NULL,
  `id_orden_trabajo_id` int(11) DEFAULT NULL,
  `id_elemento_gasto_id` int(11) DEFAULT NULL,
  `id_expediente_id` int(11) DEFAULT NULL,
  `id_proveedor_id` int(11) DEFAULT NULL,
  `id_registro_comprobantes_id` int(11) NOT NULL,
  `id_almacen_id` int(11) DEFAULT NULL,
  `id_unidad_id` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_tipo_cliente` int(11) DEFAULT NULL,
  `credito` double NOT NULL,
  `debito` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `operaciones_comprobante_operaciones`
--

INSERT INTO `operaciones_comprobante_operaciones` (`id`, `id_cuenta_id`, `id_subcuenta_id`, `id_centro_costo_id`, `id_orden_trabajo_id`, `id_elemento_gasto_id`, `id_expediente_id`, `id_proveedor_id`, `id_registro_comprobantes_id`, `id_almacen_id`, `id_unidad_id`, `id_cliente`, `id_tipo_cliente`, `credito`, `debito`) VALUES
(11, 1, 1, NULL, NULL, NULL, NULL, NULL, 32, NULL, 1, 4, 3, 0, 100),
(12, 8, 71, NULL, NULL, NULL, NULL, NULL, 32, NULL, 1, 4, 3, 0, 100),
(13, 2, 133, NULL, NULL, NULL, NULL, NULL, 33, NULL, 1, 4, 3, 0, 20),
(14, 8, 71, NULL, NULL, NULL, NULL, NULL, 33, NULL, 1, 4, 3, 0, 20),
(15, 2, 133, NULL, NULL, NULL, NULL, NULL, 34, NULL, 1, 4, 3, 0, 20),
(16, 8, 71, NULL, NULL, NULL, NULL, NULL, 34, NULL, 1, 4, 3, 0, 20),
(17, 2, 133, NULL, NULL, NULL, NULL, NULL, 35, NULL, 1, 4, 3, 0, 20),
(18, 8, 71, NULL, NULL, NULL, NULL, NULL, 35, NULL, 1, 4, 3, 20, 0),
(19, 2, 133, NULL, NULL, NULL, NULL, NULL, 36, NULL, 1, 4, 3, 0, 20),
(20, 8, 71, NULL, NULL, NULL, NULL, NULL, 36, NULL, 1, 4, 3, 20, 0),
(21, 2, 133, NULL, NULL, NULL, NULL, NULL, 37, NULL, 1, 4, 3, 0, 20),
(22, 8, 71, NULL, NULL, NULL, NULL, NULL, 37, NULL, 1, 4, 3, 20, 0),
(23, 2, 133, NULL, NULL, NULL, NULL, NULL, 38, NULL, 1, 4, 3, 0, 20),
(24, 8, 71, NULL, NULL, NULL, NULL, NULL, 38, NULL, 1, 4, 3, 20, 0),
(25, 2, 133, NULL, NULL, NULL, NULL, NULL, 39, NULL, 1, 4, 3, 0, 20),
(26, 8, 71, NULL, NULL, NULL, NULL, NULL, 39, NULL, 1, 4, 3, 20, 0),
(27, 2, 133, NULL, NULL, NULL, NULL, NULL, 40, NULL, 1, 4, 3, 0, 20),
(28, 8, 71, NULL, NULL, NULL, NULL, NULL, 40, NULL, 1, 4, 3, 20, 0),
(29, 2, 133, NULL, NULL, NULL, NULL, NULL, 41, NULL, 1, 4, 3, 0, 20),
(30, 8, 71, NULL, NULL, NULL, NULL, NULL, 41, NULL, 1, 4, 3, 20, 0),
(31, 2, 133, NULL, NULL, NULL, NULL, NULL, 42, NULL, 1, 4, 3, 0, 20),
(32, 8, 71, NULL, NULL, NULL, NULL, NULL, 42, NULL, 1, 4, 3, 20, 0),
(33, 2, 133, NULL, NULL, NULL, NULL, NULL, 43, NULL, 1, 4, 3, 0, 20),
(34, 8, 71, NULL, NULL, NULL, NULL, NULL, 43, NULL, 1, 4, 3, 20, 0),
(35, 2, 133, NULL, NULL, NULL, NULL, NULL, 44, NULL, 1, 4, 3, 0, 20),
(36, 8, 71, NULL, NULL, NULL, NULL, NULL, 44, NULL, 1, 4, 3, 20, 0),
(37, 2, 133, NULL, NULL, NULL, NULL, NULL, 45, NULL, 1, 4, 3, 0, 20),
(38, 8, 71, NULL, NULL, NULL, NULL, NULL, 45, NULL, 1, 4, 3, 20, 0),
(39, 2, 133, NULL, NULL, NULL, NULL, NULL, 46, NULL, 1, 4, 3, 0, 20),
(40, 8, 71, NULL, NULL, NULL, NULL, NULL, 46, NULL, 1, 4, 3, 20, 0),
(41, 2, 133, NULL, NULL, NULL, NULL, NULL, 47, NULL, 1, 4, 3, 0, 20),
(42, 8, 71, NULL, NULL, NULL, NULL, NULL, 47, NULL, 1, 4, 3, 20, 0),
(43, 2, 133, NULL, NULL, NULL, NULL, NULL, 48, NULL, 1, 4, 3, 0, 20),
(44, 8, 71, NULL, NULL, NULL, NULL, NULL, 48, NULL, 1, 4, 3, 20, 0),
(45, 2, 133, NULL, NULL, NULL, NULL, NULL, 49, NULL, 1, 4, 3, 0, 20),
(46, 8, 71, NULL, NULL, NULL, NULL, NULL, 49, NULL, 1, 4, 3, 20, 0),
(47, 2, 133, NULL, NULL, NULL, NULL, NULL, 50, NULL, 1, 4, 3, 0, 20),
(48, 8, 71, NULL, NULL, NULL, NULL, NULL, 50, NULL, 1, 4, 3, 20, 0),
(49, 2, 133, NULL, NULL, NULL, NULL, NULL, 51, NULL, 1, 4, 3, 0, 20),
(50, 8, 71, NULL, NULL, NULL, NULL, NULL, 51, NULL, 1, 4, 3, 20, 0),
(51, 2, 133, NULL, NULL, NULL, NULL, NULL, 52, NULL, 1, 4, 3, 0, 20),
(52, 8, 71, NULL, NULL, NULL, NULL, NULL, 52, NULL, 1, 4, 3, 20, 0),
(53, 2, 133, NULL, NULL, NULL, NULL, NULL, 53, NULL, 1, 4, 3, 0, 20),
(54, 8, 71, NULL, NULL, NULL, NULL, NULL, 53, NULL, 1, 4, 3, 20, 0),
(55, 2, 133, NULL, NULL, NULL, NULL, NULL, 54, NULL, 1, 4, 3, 0, 20),
(56, 8, 71, NULL, NULL, NULL, NULL, NULL, 54, NULL, 1, 4, 3, 20, 0),
(57, 2, 133, NULL, NULL, NULL, NULL, NULL, 55, NULL, 1, 4, 3, 0, 20),
(58, 8, 71, NULL, NULL, NULL, NULL, NULL, 55, NULL, 1, 4, 3, 20, 0),
(59, 2, 133, NULL, NULL, NULL, NULL, NULL, 56, NULL, 1, 4, 3, 0, 20),
(60, 8, 71, NULL, NULL, NULL, NULL, NULL, 56, NULL, 1, 4, 3, 20, 0),
(61, 2, 133, NULL, NULL, NULL, NULL, NULL, 57, NULL, 1, 4, 3, 0, 20),
(62, 8, 71, NULL, NULL, NULL, NULL, NULL, 57, NULL, 1, 4, 3, 20, 0),
(63, 2, 133, NULL, NULL, NULL, NULL, NULL, 58, NULL, 1, 4, 3, 0, 20),
(64, 8, 71, NULL, NULL, NULL, NULL, NULL, 58, NULL, 1, 4, 3, 20, 0),
(65, 2, 133, NULL, NULL, NULL, NULL, NULL, 59, NULL, 1, 4, 3, 0, 20),
(66, 8, 71, NULL, NULL, NULL, NULL, NULL, 59, NULL, 1, 4, 3, 20, 0),
(67, 1, 1, NULL, NULL, NULL, NULL, NULL, 60, NULL, NULL, 0, NULL, 0, 1158.12),
(68, 8, 71, NULL, NULL, NULL, NULL, NULL, 60, NULL, NULL, 4, 3, 1158.12, 0),
(73, 8, 71, NULL, NULL, NULL, NULL, NULL, 63, NULL, 1, 4, 3, 10158.12, 0),
(74, 1, 1, NULL, NULL, NULL, NULL, NULL, 63, NULL, 1, 0, NULL, 0, 10158.12),
(75, 1, 1, NULL, NULL, NULL, NULL, NULL, 64, NULL, 1, NULL, NULL, 0, 10158.12),
(76, 8, 71, NULL, NULL, NULL, NULL, NULL, 64, NULL, 1, 4, 3, 10158.12, 0),
(77, 8, 71, NULL, NULL, NULL, NULL, 1, 65, NULL, 1, NULL, NULL, 0, 200),
(78, 2, 133, NULL, NULL, NULL, NULL, NULL, 65, NULL, 1, NULL, NULL, 200, 0),
(79, 36, 63, NULL, NULL, NULL, NULL, 1, 76, NULL, 1, NULL, NULL, 0, 138.91),
(80, 2, 133, NULL, NULL, NULL, NULL, NULL, 76, NULL, 1, NULL, NULL, 138.91, 0),
(81, 36, 63, NULL, NULL, NULL, NULL, 1, 77, NULL, 1, NULL, NULL, 0, 138.91),
(82, 2, 133, NULL, NULL, NULL, NULL, NULL, 77, NULL, 1, NULL, NULL, 138.91, 0);

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
(2, 1, 1, '02', 'Combo de Alimento 2da Clase', 1, 2020),
(3, 1, 1, '03', 'Combo de Medicamentos Clase 1', 1, 2020),
(4, 1, 1, '04', 'Combo de Aseo 2da Clase', 1, 2020),
(5, 1, 1, '05', 'Combo de Alimento Clase 2', 1, 2020),
(6, 1, 1, '06', 'Combo de Medicina Clase 1', 1, 2020),
(7, 1, 1, '7', 'Combo de Aseo', 1, 2020),
(8, 1, 1, '9', 'Combo de Medicina', 1, 2020),
(9, 1, 1, '01', 'Combo de Aseo', 1, 2020),
(10, 1, 1, 'OT-02', 'Combo de Alimento', 1, 2020),
(11, 1, 1, 'OT-03', 'Combo de Medicamento', 1, 2020),
(12, 1, 1, 'OT-04', 'Combo de Aseo', 1, 2020),
(13, 1, 1, 'OT-05', 'Combo de Alimento', 1, 2020),
(14, 1, 1, 'OT-06', 'Combo de Medicamento', 1, 2020),
(15, 1, 1, 'OT-01', 'Combo de Aseo', 1, 2020),
(16, 1, 1, 'OT-07', 'Combo de Aseo', 1, 2020),
(17, 1, 1, 'OT-09', 'Combo de Medicamento', 1, 2020);

-- --------------------------------------------------------

--
-- Table structure for table `pais`
--

CREATE TABLE `pais` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `periodo_sistema`
--

CREATE TABLE `periodo_sistema` (
  `id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `id_almacen_id` int(11) DEFAULT NULL,
  `id_usuario_id` int(11) NOT NULL,
  `mes` int(11) NOT NULL,
  `anno` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cerrado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `periodo_sistema`
--

INSERT INTO `periodo_sistema` (`id`, `id_unidad_id`, `id_almacen_id`, `id_usuario_id`, `mes`, `anno`, `tipo`, `fecha`, `cerrado`) VALUES
(1, 1, NULL, 1, 12, 2020, 2, '2021-01-13', 1),
(2, 1, NULL, 1, 1, 2021, 2, '2021-01-13', 1),
(3, 1, NULL, 1, 2, 2021, 2, '2021-01-16', 0);

-- --------------------------------------------------------

--
-- Table structure for table `por_ciento_nominas`
--

CREATE TABLE `por_ciento_nominas` (
  `id` int(11) NOT NULL,
  `por_ciento` double NOT NULL,
  `criterio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `denominacion` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `por_ciento_nominas`
--

INSERT INTO `por_ciento_nominas` (`id`, `por_ciento`, `criterio`, `denominacion`, `activo`) VALUES
(1, 3.04, 'ARS', 1, 1),
(2, 2.87, 'AFP', 1, 1),
(3, 2.5, 'COOPERATIVA', 1, 1),
(4, 7.1, 'AFP', 2, 1),
(5, 7.09, 'SFS', 2, 1),
(6, 1.1, 'SRL', 2, 1),
(7, 1, 'Infotep', 2, 1);

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
(7, 3, 13, 'OT-01', '188', 'Combo de Aseo', 19, 9.9142, 1, '0020', '700', '0050'),
(8, 3, 13, 'OT-03', '188', 'Combo de Medicamento', 0, 0, 0, '0020', '700', '0050'),
(9, 3, 13, 'OT-04', '188', 'Combo de Aseo', 20, 10.434285714285, 1, '0020', '700', '0050'),
(10, 3, 13, 'OT-05', '188', 'Combo de Alimento', 0, 0, 0, '0020', '700', '0050'),
(11, 3, 13, 'OT-07', '188', 'Combo de Aseo', 0, 0, 0, '0020', '700', '0050'),
(12, 3, 13, 'OT-09', '188', 'Combo de Medicamento', 0, 0, 0, '0020', '700', '0050');

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
-- Table structure for table `rango_escala_dgii`
--

CREATE TABLE `rango_escala_dgii` (
  `id` int(11) NOT NULL,
  `anno` int(11) NOT NULL,
  `escala` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `por_ciento` double NOT NULL,
  `minimo` double DEFAULT NULL,
  `maximo` double NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `valor_fijo` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rango_escala_dgii`
--

INSERT INTO `rango_escala_dgii` (`id`, `anno`, `escala`, `por_ciento`, `minimo`, `maximo`, `activo`, `valor_fijo`) VALUES
(1, 2020, '​Rentas hasta RD$416,220.00', 0, 0, 416220, 1, 0),
(2, 2020, '​Rentas desde RD$416,220.01 hasta RD$624,329.00', 15, 416220.01, 624329, 1, 0),
(3, 2020, '​Rentas desde RD$624,329.01 hasta RD$867,123.00', 20, 624329.01, 867123, 1, 31216),
(4, 2020, 'Rentas desde  RD$867,123.01 en adelante', 25, 867123.01, 1000000000, 1, 79776);

-- --------------------------------------------------------

--
-- Table structure for table `registro_comprobantes`
--

CREATE TABLE `registro_comprobantes` (
  `id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `id_tipo_comprobante_id` int(11) NOT NULL,
  `id_usuario_id` int(11) NOT NULL,
  `id_almacen_id` int(11) DEFAULT NULL,
  `nro_consecutivo` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `debito` double NOT NULL,
  `credito` double NOT NULL,
  `anno` int(11) NOT NULL,
  `tipo` int(11) DEFAULT NULL,
  `documento` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `registro_comprobantes`
--

INSERT INTO `registro_comprobantes` (`id`, `id_unidad_id`, `id_tipo_comprobante_id`, `id_usuario_id`, `id_almacen_id`, `nro_consecutivo`, `fecha`, `descripcion`, `debito`, `credito`, `anno`, `tipo`, `documento`) VALUES
(26, 1, 2, 1, 1, 1, '2020-12-01', 'Comprobante de operaciones del mes de noviembre dia 30', 12473.1, 12473.1, 2020, 1, NULL),
(27, 1, 2, 1, 3, 2, '2020-11-29', 'Comprobante de operaciones del almacen 3 correspondiente al mes de noviembre dia 30', 1703.26, 1703.26, 2020, 1, NULL),
(28, 1, 2, 1, 2, 3, '2020-11-30', 'comprobante de operaciones en el almacen 2 con la venta incluida', 58373.76, 58373.76, 2020, 1, NULL),
(29, 1, 2, 1, 2, 4, '2020-12-02', 'zzz', 0.52, 0.52, 2020, 1, NULL),
(30, 1, 2, 1, 3, 5, '2020-12-02', 'ventas', 1675.08, 1675.08, 2020, 1, NULL),
(31, 1, 2, 1, NULL, 6, '2020-12-16', 'comprobante de ventas', 25355.86, 25355.86, 2020, 2, NULL),
(32, 1, 2, 1, NULL, 7, '2020-12-17', 'Pagando factura de servicio, número FACT-1', 100, 100, 2020, 3, 'cheque'),
(33, 1, 2, 1, NULL, 8, '2020-12-17', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(34, 1, 2, 1, NULL, 9, '2020-12-17', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(35, 1, 2, 1, NULL, 10, '2020-12-17', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(36, 1, 2, 1, NULL, 11, '2020-12-18', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(37, 1, 2, 1, NULL, 12, '2020-12-18', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(38, 1, 2, 1, NULL, 13, '2020-12-18', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(39, 1, 2, 1, NULL, 14, '2020-12-18', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(40, 1, 2, 1, NULL, 15, '2020-12-18', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(41, 1, 2, 1, NULL, 16, '2020-12-18', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(42, 1, 2, 1, NULL, 17, '2020-12-18', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(43, 1, 2, 1, NULL, 18, '2020-12-18', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(44, 1, 2, 1, NULL, 19, '2020-12-18', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(45, 1, 2, 1, NULL, 20, '2020-12-18', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(46, 1, 2, 1, NULL, 21, '2020-12-18', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(47, 1, 2, 1, NULL, 22, '2020-12-18', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(48, 1, 2, 1, NULL, 23, '2020-12-18', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(49, 1, 2, 1, NULL, 24, '2020-12-18', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(50, 1, 2, 1, NULL, 25, '2020-12-18', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(51, 1, 2, 1, NULL, 26, '2020-12-18', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(52, 1, 2, 1, NULL, 27, '2020-12-18', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(53, 1, 2, 1, NULL, 28, '2020-12-18', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(54, 1, 2, 1, NULL, 29, '2020-12-18', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(55, 1, 2, 1, NULL, 30, '2020-12-18', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(56, 1, 2, 1, NULL, 31, '2020-12-18', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(57, 1, 2, 1, NULL, 32, '2020-12-18', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(58, 1, 2, 1, NULL, 33, '2020-12-18', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(59, 1, 2, 1, NULL, 34, '2020-12-18', 'Pagando factura de servicio, número FACT-1', 20, 20, 2020, 3, 'transferencia'),
(60, 1, 2, 1, NULL, 35, '2020-12-20', 'invento', 1158.12, 1158.12, 2020, 3, 'invento'),
(63, 1, 2, 1, NULL, 36, '2020-12-22', 'pagando facturas', 10158.12, 10158.12, 2020, 3, 'cheque'),
(64, 1, 2, 1, NULL, 37, '2020-12-22', 'pago', 10158.12, 10158.12, 2020, 3, 'cheque'),
(65, 1, 2, 1, NULL, 38, '2020-12-22', 'pagando mercancia', 200, 200, 2020, 3, 'transferencia'),
(66, 1, 2, 1, NULL, 39, '2020-12-23', 'generando comprobate de venta de 23-12-2020', 2000, 2000, 2020, 2, NULL),
(67, 1, 2, 1, NULL, 40, '2020-12-23', 'zzxzxzxzx', 2500, 2500, 2020, 2, NULL),
(68, 1, 2, 1, 2, 41, '2020-12-03', 'sdsdsd', 2603.71, 2603.71, 2020, 1, NULL),
(69, 1, 2, 1, NULL, 1, '2021-01-05', 'comprobante de operaciones activo fijo 5-1-2021', 3210, 3210, 2021, 5, NULL),
(70, 1, 2, 1, NULL, 2, '2021-01-05', 'comprobante de operaciones del dia 5-1-2021 en la tarde', 500, 500, 2021, 5, NULL),
(71, 1, 2, 1, NULL, 42, '2021-01-06', 'fdddfdfd', 2500, 2500, 2020, 5, NULL),
(72, 1, 2, 1, NULL, 43, '2020-12-03', 'xzzxzxz', 5000, 5000, 2020, 5, NULL),
(73, 1, 2, 1, NULL, 44, '2020-12-03', 'cdsfdsfdsfdsdfsdfsdsf', 5000, 5000, 2020, 5, NULL),
(74, 1, 2, 1, NULL, 45, '2020-12-03', 'cdsfdsfdsfdsdfsdfsdsf', 5000, 5000, 2020, 5, NULL),
(75, 1, 2, 1, NULL, 46, '2020-12-03', 'Depreciación de activo fijo', 0.83, 0.83, 2020, 4, NULL),
(76, 1, 2, 1, NULL, 47, '2020-12-03', 'qasw', 138.91, 138.91, 2020, 3, 'cheque'),
(77, 1, 2, 1, NULL, 48, '2020-12-03', 'qasw', 138.91, 138.91, 2020, 3, 'cheque'),
(78, 1, 2, 1, NULL, 49, '2020-12-03', 'PAGO DE SALARIO DEL MES DE DICIMBRE, SEGUNDA QUINCENA', 3149372.3, 3149372.3, 2020, 6, NULL),
(79, 1, 2, 1, NULL, 50, '2020-12-03', 'RECTIFICANDO PAGO DE SALARIO DE DICIMEBRE SEGUNDA QUINCENA.(2020)', 3149372.3, 3149372.3, 2020, 6, NULL),
(80, 1, 2, 1, NULL, 51, '2020-12-03', 'PAGO SEGUNDA QUINCENA 12/2020', 125069.66, 125069.66, 2020, 6, NULL),
(81, 1, 2, 1, NULL, 52, '2020-12-03', 'revisando una ultima vez', 125069.66, 125069.66, 2020, 6, NULL),
(82, 1, 2, 1, NULL, 53, '2020-12-03', 'errores en la nomina', 125069.66, 125069.66, 2020, 6, NULL),
(83, 1, 2, 1, NULL, 54, '2020-12-03', 'sasasasasas', 125069.66, 125069.66, 2020, 6, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reglas_remesas`
--

CREATE TABLE `reglas_remesas` (
  `id` int(11) NOT NULL,
  `id_moneda_pais` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desde` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hasta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tarifa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rent_entrega`
--

CREATE TABLE `rent_entrega` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rent_recogida`
--

CREATE TABLE `rent_recogida` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reporte_efectivo`
--

CREATE TABLE `reporte_efectivo` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `empleado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `monto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cambio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_cotizacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `moneda` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `saldo` double NOT NULL,
  `tipo_cliente` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `servicios`
--

INSERT INTO `servicios` (`id`, `nombre`, `codigo`) VALUES
(1, 'Recarga Cubacell', '0010'),
(2, 'Recarga Nauta', '0020'),
(3, 'Larga Distancia', '0030'),
(4, 'Envio de Remesas', '0040'),
(5, 'Boletos Aéreos', '0050'),
(6, 'Renta de Hoteles', '0060'),
(7, 'Renta de Autos', '0070'),
(8, 'Excursiones', '0080'),
(9, 'Envio de paquetes', '0090'),
(10, 'Paquetes Turísticos', '0100'),
(11, 'Trámites Migratorios', '0110'),
(12, 'Desarrollo de Software', '0120'),
(13, 'Diseño', '0130'),
(14, 'Marketing y redes Sociales', '0140'),
(15, 'Envio de Remesas', '0040');

-- --------------------------------------------------------

--
-- Table structure for table `solicitud_turismo`
--

CREATE TABLE `solicitud_turismo` (
  `id` int(11) NOT NULL,
  `vuelo_cantidad_adultos` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vuelo_cantidad_ninos` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vuelo_origen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vuelo_destino` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vuelo_ida` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vuelo_vuelta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vuelo_comentario` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hotel_destino` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hotel_nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hotel_categoria` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hotel_plan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hotel_comentario` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tranfer_llegada` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tramfer_salida` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tramfer_lugar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tramfer_destino` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tramfer_vehiculo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tramfer_comentario` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tour_nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tour_fecha` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tour_comentario` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rent_tipo_vehiculo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rent_lugar_recogida` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rent_lugar_entrega` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rent_comentario` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rent_fecha_desde` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hotel_desde` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hotel_hasta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rent_fecha_hasta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empleado` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_cliente` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_solicitud` datetime DEFAULT NULL,
  `stado` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_cliente` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hotel_adultos` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hotel_ninos` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tramfer_adultos` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tramfer_ninos` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tramfer_ida_vuelta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tour_ninos` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tour_adultos` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rent_cantidad_personas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empleado_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `solicitud_turismo_comentario`
--

CREATE TABLE `solicitud_turismo_comentario` (
  `id` int(11) NOT NULL,
  `id_solicitud_turismo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `comentario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empleado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
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
(37, 41, '0005', 'Impuesto Sobre la Renta', 0, 1, 0),
(38, 54, '0010', 'Compra o Adquisición de Activos Fijos', 0, 1, 0),
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
(70, 50, '0020', 'Recursos Materiales', 0, 1, 0),
(71, 8, '0030', 'Clientes Externos', 1, 1, 0),
(72, 8, '0010', 'Personas Naturales', 1, 1, 0),
(73, 67, '0150', 'Combo de Aseo', 1, 1, 0),
(74, 67, '0170', 'Combo de Alimentos', 1, 1, 0),
(75, 67, '0160', 'Combo de Medicamentos', 1, 1, 0),
(76, 76, '0020', 'Combo de Alimento', 1, 0, 0),
(77, 76, '0010', 'Combo de Aseo', 1, 0, 0),
(78, 76, '0030', 'Combo de Medicamentos', 1, 0, 0),
(79, 76, '0150', 'Combo de Aseo', 1, 1, 0),
(80, 76, '0160', 'Combo de Medicamento', 1, 1, 0),
(81, 76, '0170', 'Combo de Alimento', 1, 1, 0),
(82, 75, '0010', 'Recargas', 0, 1, 0),
(83, 75, '0020', 'Articulos Domesticos', 0, 1, 0),
(84, 75, '0030', 'Articulos de Aseo', 0, 1, 0),
(85, 75, '0040', 'Alimentos', 0, 1, 0),
(86, 75, '0050', 'Medicamentos', 0, 1, 0),
(87, 68, '0010', 'Recargas', 1, 1, 0),
(88, 68, '0020', 'Ariculos Domesticos', 1, 1, 0),
(89, 68, '0030', 'Articulos de Aseo', 1, 1, 0),
(90, 68, '0040', 'Alimentos', 1, 1, 0),
(91, 68, '0050', 'Medicamentos', 1, 1, 0),
(92, 66, '0010', 'Mercancias', 1, 1, 0),
(93, 66, '0020', 'Produccion', 1, 1, 0),
(94, 70, '0010', '0010 Distribucion', 1, 0, 0),
(95, 70, '0010', 'Ventas', 1, 1, 1),
(96, 70, '0020', 'Distribucion', 1, 1, 1),
(97, 69, '0010', 'Agencia Horizontes', 1, 1, 1),
(98, 83, '0010', 'Venta de boletos de avion', 0, 0, 0),
(99, 83, '0020', 'Servicio de Remesas', 0, 0, 0),
(100, 83, '0030', 'Servicio de paqueteria', 0, 0, 0),
(101, 84, '0010', 'Costo de Venta de Boletos de Avion', 1, 0, 0),
(102, 84, '0020', 'Costo de Servicios de Remesa', 1, 0, 0),
(103, 84, '0030', 'Costo de Paqueteria', 1, 0, 0),
(104, 8, '0020', 'Clientes Internos', 1, 1, 0),
(105, 84, '0010', 'Recarga Cubacell', 1, 1, 0),
(106, 84, '0020', 'Recarga Nauta', 1, 1, 0),
(107, 84, '0030', 'Larga Distancia', 1, 1, 0),
(108, 84, '0040', 'Envio de Remesas', 1, 1, 0),
(109, 84, '0050', 'Boletos Aéreos', 1, 1, 0),
(110, 84, '0060', 'Renta de Hoteles', 1, 1, 0),
(111, 84, '0070', 'Renta de Autos', 1, 1, 0),
(112, 84, '0080', 'Excursiones', 1, 1, 0),
(113, 84, '0090', 'Envio de paquetes', 1, 1, 0),
(114, 84, '0100', 'Paquetes Turísticos', 1, 1, 0),
(115, 84, '0110', 'Trámites Migratorios', 1, 1, 0),
(116, 84, '0120', 'Desarrollo de Software', 1, 1, 0),
(117, 84, '0130', 'Diseño', 1, 1, 0),
(118, 84, '0140', 'Marketing y redes Sociales', 1, 1, 0),
(119, 83, '0010', 'Recarga Cubacell', 0, 1, 0),
(120, 83, '0020', 'Recarga Nauta', 0, 1, 0),
(121, 83, '0030', 'Larga Distancia', 0, 1, 0),
(122, 83, '0040', 'Envio de Remesas', 0, 1, 0),
(123, 83, '0050', 'Boletos Aéreos', 0, 1, 0),
(124, 83, '0060', 'Renta de Hoteles', 0, 1, 0),
(125, 83, '0070', 'Renta de Autos', 0, 1, 0),
(126, 83, '0080', 'Excursiones', 0, 1, 0),
(127, 83, '0090', 'Envio de paquetes', 0, 1, 0),
(128, 83, '0100', 'Paquetes Turísticos', 0, 1, 0),
(129, 83, '0110', 'Trámites Migratorios', 0, 1, 0),
(130, 83, '0120', 'Desarrollo de Software', 0, 1, 0),
(131, 83, '0130', 'Diseño', 0, 1, 0),
(132, 83, '0140', 'Marketing y redes Sociales', 0, 1, 0),
(133, 2, '0001', 'Efectivo', 1, 1, 0),
(134, 33, '0010', 'Depreciacion de Activos Fijos Tangibles', 0, 1, 0),
(135, 80, '0010', 'Otros ingresos', 1, 1, 0),
(136, 85, '0010', 'Compra de Activo Fijo', 0, 1, 0),
(137, 54, '0050', 'Entrega o Vaja de Activos Fijos', 1, 1, 0),
(138, 22, '0010', 'Activo Fijos', 1, 1, 0),
(139, 74, '0010', 'Gastos de ARS Patrimonial', 1, 1, 0),
(140, 74, '0020', 'Gastos AFP Patrimonial', 1, 1, 0),
(141, 74, '0030', 'Gastos  SRL-1.1%', 1, 1, 0),
(142, 74, '0040', 'Gastos Infotep-1%', 1, 1, 0),
(143, 41, '0006', 'ARS por Pagar', 0, 1, 0),
(144, 41, '0007', 'AFP por Pagar', 0, 1, 0),
(145, 41, '0008', 'Cooperativa por Pagar', 0, 1, 0),
(146, 41, '0009', 'Plan Médico Adicional  por Pagar', 0, 1, 0),
(147, 41, '0010', 'Restaurant por Pagar', 0, 1, 0),
(148, 41, '0011', 'ARS Patrimonial por Pagar', 0, 1, 0),
(149, 41, '0012', 'AFP Patrimonial por Pagar', 0, 1, 0),
(150, 41, '0013', 'SRL-1.1% por Pagar', 0, 1, 0),
(151, 41, '0014', 'Infotep-1.1% por Pagar', 0, 1, 0),
(152, 42, '0010', 'Nominas por Pagar', 0, 1, 0);

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
(70, 54, 10),
(73, 95, 3),
(74, 95, 5),
(75, 96, 3),
(76, 96, 5),
(77, 97, 3),
(78, 97, 5),
(81, 72, 6),
(82, 104, 6),
(83, 71, 6);

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
-- Table structure for table `tasa_de_cambio`
--

CREATE TABLE `tasa_de_cambio` (
  `id` int(11) NOT NULL,
  `id_moneda` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tasa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tasa_sugerida` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `termino_pago`
--

CREATE TABLE `termino_pago` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `termino_pago`
--

INSERT INTO `termino_pago` (`id`, `nombre`) VALUES
(1, 'Contra servicio'),
(2, 'A 7 días'),
(3, 'A 15 días'),
(4, 'A 30 días'),
(5, 'A 45 días');

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
(9, 'DEVOLUCION', 1),
(10, 'VENTA', 1),
(11, 'DEVOLUCION VENTA', 1);

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

--
-- Dumping data for table `tipo_movimiento`
--

INSERT INTO `tipo_movimiento` (`id`, `descripcion`, `activo`, `codigo`) VALUES
(1, 'APERTURA', 1, 'AP'),
(2, 'COMPRA', 1, 'A'),
(3, 'TRASLADO INTERNO', 1, 'TI'),
(4, 'TRASLADOS ENVIADOS', 1, 'TE'),
(5, 'TRASLADOS RECIBIDOS', 1, 'TR'),
(6, 'BAJAS DE ACTIVOS', 1, 'BA'),
(7, 'VENTA DE ACTIVOS', 1, 'VA');

-- --------------------------------------------------------

--
-- Table structure for table `tour_nombre`
--

CREATE TABLE `tour_nombre` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
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
(5, 152, NULL, 2, '696', '0020', '', '1', 2020, 1, 0, ''),
(6, 153, NULL, 1, '', '', '697', '1', 2020, 1, 1, '0020');

-- --------------------------------------------------------

--
-- Table structure for table `transfer_destino`
--

CREATE TABLE `transfer_destino` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transfer_origen`
--

CREATE TABLE `transfer_origen` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trasacciones`
--

CREATE TABLE `trasacciones` (
  `id` int(11) NOT NULL,
  `transaccion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_cotizacion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `monto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banco` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empleado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `cuenta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `moneda` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_transaccion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nota` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unidad`
--

CREATE TABLE `unidad` (
  `id` int(11) NOT NULL,
  `id_padre_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `unidad`
--

INSERT INTO `unidad` (`id`, `id_padre_id`, `nombre`, `activo`, `codigo`, `direccion`, `telefono`, `correo`) VALUES
(1, NULL, 'Grupo Horizontes Admin', 1, '01', 'asasasas', '1111112', 'www@ww.ww'),
(2, NULL, 'xxx', 1, '002', 'asasasas', '1111111', 'aaa@aa.aa'),
(3, NULL, 'dssds', 1, '1234444', 'dsdasdsa', '2121', 'ccc@cc.cc'),
(4, 1, 'subordinado 1', 1, '0101', 'qfefw', '121212', 'empre@asd.cu'),
(5, 1, 'subordinado 2', 1, '0102', 'asdasd', '1213231', 'sub@nas.sdas'),
(6, 4, 'subordinado 1- 1', 1, '010101', 'dqwdqwd', '123123', 'sub11@ass.su');

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
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_moneda` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_agencia` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `status`, `password`, `id_moneda`, `id_agencia`) VALUES
(1, 'root', '[\"ROLE_ADMIN\"]', 1, '$argon2id$v=19$m=65536,t=4,p=1$Z1dpQjlQeG1LLnB2SVpZbA$OPsXOk93GwXrcXJsCH5ARKvyWoGVJX5aZLfCoUSjMm0', '1', NULL),
(2, 'sss@aasas.ass', '[\"ROLE_USER\"]', 1, '$argon2id$v=19$m=65536,t=4,p=1$b1BPeGM2MjVTMlR1dG0wQw$iSCLKc3DQXdNAmPJnvmd31pMCtYNsLlUfHLNMslPlTQ', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vacaciones_disfrutadas`
--

CREATE TABLE `vacaciones_disfrutadas` (
  `id` int(11) NOT NULL,
  `id_empleado_id` int(11) NOT NULL,
  `cantidad_dias` int(11) NOT NULL,
  `cantidad_pagada` double NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(31, 144, 1, '1', 2020, '2020-11-20', '1', '700', '0020', 0),
(32, 145, 1, '2', 2020, '2020-11-20', '2', '700', '0020', 0),
(33, 146, 1, '3', 2020, '2020-11-20', '3', '700', '0020', 0),
(34, 147, 1, '4', 2020, '2020-11-20', '4', '700', '0020', 0),
(35, 148, 1, '5', 2020, '2020-11-20', '5', '700', '0020', 0),
(36, 149, 1, '6', 2020, '2020-11-20', '6', '700', '0020', 0),
(37, 156, 1, '7', 2020, '2020-11-27', '7', '823', '0010', 0),
(38, 165, 1, '8', 2020, '2020-11-28', '8', '700', '0020', 0),
(39, 166, 1, '9', 2020, '2020-11-28', '9', '700', '0020', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vuelo_destino`
--

CREATE TABLE `vuelo_destino` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vuelo_origen`
--

CREATE TABLE `vuelo_origen` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vuelo_origen`
--

INSERT INTO `vuelo_origen` (`id`, `nombre`) VALUES
(1, 'cuba');

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
  ADD KEY `IDX_E0DF2901A752F04B` (`id_elemento_gasto_gasto_id`),
  ADD KEY `IDX_E0DF29014D7B4AB9` (`id_cuenta_acreedora_id`),
  ADD KEY `IDX_E0DF2901EB1B341E` (`id_subcuenta_acreedora_id`);

--
-- Indexes for table `activo_fijo_movimiento_activo_fijo`
--
ALTER TABLE `activo_fijo_movimiento_activo_fijo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2FA61FF25832E72E` (`id_activo_fijo_id`),
  ADD KEY `IDX_2FA61FF27786CA71` (`id_movimiento_activo_fijo_id`);

--
-- Indexes for table `acumulado_vacaciones`
--
ALTER TABLE `acumulado_vacaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_246B9D168D392AC7` (`id_empleado_id`);

--
-- Indexes for table `agencias`
--
ALTER TABLE `agencias`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `asiento`
--
ALTER TABLE `asiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_71D6D35C1ADA4D3F` (`id_cuenta_id`),
  ADD KEY `IDX_71D6D35C2D412F53` (`id_subcuenta_id`),
  ADD KEY `IDX_71D6D35C6601BA07` (`id_documento_id`),
  ADD KEY `IDX_71D6D35C39161EBF` (`id_almacen_id`),
  ADD KEY `IDX_71D6D35CC59B01FF` (`id_centro_costo_id`),
  ADD KEY `IDX_71D6D35CF66372E9` (`id_elemento_gasto_id`),
  ADD KEY `IDX_71D6D35C71381BB3` (`id_orden_trabajo_id`),
  ADD KEY `IDX_71D6D35CF5DBAF2B` (`id_expediente_id`),
  ADD KEY `IDX_71D6D35CE8F12801` (`id_proveedor_id`),
  ADD KEY `IDX_71D6D35C1D34FA6B` (`id_unidad_id`),
  ADD KEY `IDX_71D6D35CEF5F7851` (`id_tipo_comprobante_id`),
  ADD KEY `IDX_71D6D35C1800963C` (`id_comprobante_id`),
  ADD KEY `IDX_71D6D35C55C5F988` (`id_factura_id`),
  ADD KEY `IDX_71D6D35C5832E72E` (`id_activo_fijo_id`),
  ADD KEY `IDX_71D6D35CD410562` (`id_area_responsabilidad_id`);

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
-- Indexes for table `categoria_cliente`
--
ALTER TABLE `categoria_cliente`
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
-- Indexes for table `cobros_pagos`
--
ALTER TABLE `cobros_pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D9581D1655C5F988` (`id_factura_id`),
  ADD KEY `IDX_D9581D1626990C38` (`id_informe_id`),
  ADD KEY `IDX_D9581D16E8F12801` (`id_proveedor_id`),
  ADD KEY `IDX_D9581D167786CA71` (`id_movimiento_activo_fijo_id`);

--
-- Indexes for table `comprobante_cierre`
--
ALTER TABLE `comprobante_cierre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D03EA4C51800963C` (`id_comprobante_id`),
  ADD KEY `IDX_D03EA4C545F8C94C` (`id_cierre_id`);

--
-- Indexes for table `comprobante_movimiento_activo_fijo`
--
ALTER TABLE `comprobante_movimiento_activo_fijo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_81F5096A1399A3CF` (`id_registro_comprobante_id`),
  ADD KEY `IDX_81F5096A9D00B230` (`id_movimiento_activo_id`),
  ADD KEY `IDX_81F5096A1D34FA6B` (`id_unidad_id`);

--
-- Indexes for table `comprobante_salario`
--
ALTER TABLE `comprobante_salario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8C5550701399A3CF` (`id_registro_comprobante_id`),
  ADD KEY `IDX_8C5550701D34FA6B` (`id_unidad_id`);

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
-- Indexes for table `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `IDX_D618AE149D01464C` (`unidad_id`);

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
  ADD KEY `IDX_B6B12EC77A4F962` (`id_tipo_documento_id`),
  ADD KEY `IDX_B6B12EC74832F387` (`id_documento_cancelado_id`);

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
  ADD KEY `IDX_F9EBA00968BCB606` (`id_contrato_id`),
  ADD KEY `IDX_F9EBA009C59B01FF` (`id_centro_costo_id`),
  ADD KEY `IDX_F9EBA00971381BB3` (`id_orden_trabajo_id`),
  ADD KEY `IDX_F9EBA009F66372E9` (`id_elemento_gasto_id`),
  ADD KEY `IDX_F9EBA009F5DBAF2B` (`id_expediente_id`),
  ADD KEY `IDX_F9EBA0094F4C4E26` (`id_categoria_cliente_id`),
  ADD KEY `IDX_F9EBA009C37A5552` (`id_termino_pago_id`),
  ADD KEY `IDX_F9EBA009374388F5` (`id_moneda_id`),
  ADD KEY `IDX_F9EBA00999274826` (`id_factura_cancela_id`);

--
-- Indexes for table `facturas_comprobante`
--
ALTER TABLE `facturas_comprobante`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6FD2F19B55C5F988` (`id_factura_id`),
  ADD KEY `IDX_6FD2F19B1800963C` (`id_comprobante_id`),
  ADD KEY `IDX_6FD2F19B1D34FA6B` (`id_unidad_id`);

--
-- Indexes for table `factura_documento`
--
ALTER TABLE `factura_documento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CCC060C155C5F988` (`id_factura_id`),
  ADD KEY `IDX_CCC060C16601BA07` (`id_documento_id`),
  ADD KEY `IDX_CCC060C1EC34F77F` (`id_movimiento_venta_id`);

--
-- Indexes for table `factura_imposdom`
--
ALTER TABLE `factura_imposdom`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `factura_no_contable`
--
ALTER TABLE `factura_no_contable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grupo_activos`
--
ALTER TABLE `grupo_activos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotel_destino`
--
ALTER TABLE `hotel_destino`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotel_origen`
--
ALTER TABLE `hotel_origen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `impuesto_sobre_renta`
--
ALTER TABLE `impuesto_sobre_renta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5EF11EF48D392AC7` (`id_empleado_id`),
  ADD KEY `IDX_5EF11EF4E9DBC8E8` (`id_nomina_pago_id`),
  ADD KEY `IDX_5EF11EF4A9ECE748` (`id_rango_escala_id`);

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
-- Indexes for table `moneda_pais`
--
ALTER TABLE `moneda_pais`
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
  ADD KEY `IDX_A985A0DA7EB2C349` (`id_usuario_id`),
  ADD KEY `IDX_A985A0DA4B1CE99D` (`id_unidad_destino_origen_id`),
  ADD KEY `IDX_A985A0DAE8F12801` (`id_proveedor_id`),
  ADD KEY `IDX_A985A0DA571159DE` (`id_movimiento_cancelado_id`);

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
  ADD KEY `IDX_44876BD771381BB3` (`id_orden_trabajo_id`),
  ADD KEY `IDX_44876BD755C5F988` (`id_factura_id`),
  ADD KEY `IDX_44876BD7571159DE` (`id_movimiento_cancelado_id`);

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
  ADD KEY `IDX_FFC0EDFCF5DBAF2B` (`id_expediente_id`),
  ADD KEY `IDX_FFC0EDFC55C5F988` (`id_factura_id`),
  ADD KEY `IDX_FFC0EDFC571159DE` (`id_movimiento_cancelado_id`);

--
-- Indexes for table `movimiento_servicio`
--
ALTER TABLE `movimiento_servicio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_93FD19C355C5F988` (`id_factura_id`),
  ADD KEY `IDX_93FD19C371CAA3E7` (`servicio_id`);

--
-- Indexes for table `movimiento_venta`
--
ALTER TABLE `movimiento_venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8E3F7AE555C5F988` (`id_factura_id`),
  ADD KEY `IDX_8E3F7AE539161EBF` (`id_almacen_id`),
  ADD KEY `IDX_8E3F7AE5D8F8B0AD` (`id_centro_costo_acreedor_id`),
  ADD KEY `IDX_8E3F7AE5FA3DF5CD` (`id_orden_trabajo_acreedor_id`),
  ADD KEY `IDX_8E3F7AE5F0821C98` (`id_elemento_gasto_acreedor_id`),
  ADD KEY `IDX_8E3F7AE56EA527F2` (`id_expediente_acreedor_id`);

--
-- Indexes for table `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nomina_pago`
--
ALTER TABLE `nomina_pago`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5CB8BD338D392AC7` (`id_empleado_id`),
  ADD KEY `IDX_5CB8BD33AC6A6301` (`id_usuario_aprueba_id`),
  ADD KEY `IDX_5CB8BD331D34FA6B` (`id_unidad_id`);

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
-- Indexes for table `operaciones_comprobante_operaciones`
--
ALTER TABLE `operaciones_comprobante_operaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E7EA17E1ADA4D3F` (`id_cuenta_id`),
  ADD KEY `IDX_E7EA17E2D412F53` (`id_subcuenta_id`),
  ADD KEY `IDX_E7EA17EC59B01FF` (`id_centro_costo_id`),
  ADD KEY `IDX_E7EA17E71381BB3` (`id_orden_trabajo_id`),
  ADD KEY `IDX_E7EA17EF66372E9` (`id_elemento_gasto_id`),
  ADD KEY `IDX_E7EA17EF5DBAF2B` (`id_expediente_id`),
  ADD KEY `IDX_E7EA17EE8F12801` (`id_proveedor_id`),
  ADD KEY `IDX_E7EA17EECB9FBA7` (`id_registro_comprobantes_id`),
  ADD KEY `IDX_E7EA17E39161EBF` (`id_almacen_id`),
  ADD KEY `IDX_E7EA17E1D34FA6B` (`id_unidad_id`);

--
-- Indexes for table `orden_trabajo`
--
ALTER TABLE `orden_trabajo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4158A0241D34FA6B` (`id_unidad_id`),
  ADD KEY `IDX_4158A02439161EBF` (`id_almacen_id`);

--
-- Indexes for table `pais`
--
ALTER TABLE `pais`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `periodo_sistema`
--
ALTER TABLE `periodo_sistema`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_AEF0BAAD1D34FA6B` (`id_unidad_id`),
  ADD KEY `IDX_AEF0BAAD39161EBF` (`id_almacen_id`),
  ADD KEY `IDX_AEF0BAAD7EB2C349` (`id_usuario_id`);

--
-- Indexes for table `por_ciento_nominas`
--
ALTER TABLE `por_ciento_nominas`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `rango_escala_dgii`
--
ALTER TABLE `rango_escala_dgii`
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
-- Indexes for table `reglas_remesas`
--
ALTER TABLE `reglas_remesas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rent_entrega`
--
ALTER TABLE `rent_entrega`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rent_recogida`
--
ALTER TABLE `rent_recogida`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reporte_efectivo`
--
ALTER TABLE `reporte_efectivo`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `solicitud_turismo`
--
ALTER TABLE `solicitud_turismo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `solicitud_turismo_comentario`
--
ALTER TABLE `solicitud_turismo_comentario`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `tasa_de_cambio`
--
ALTER TABLE `tasa_de_cambio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `termino_pago`
--
ALTER TABLE `termino_pago`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `tour_nombre`
--
ALTER TABLE `tour_nombre`
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
-- Indexes for table `transfer_destino`
--
ALTER TABLE `transfer_destino`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfer_origen`
--
ALTER TABLE `transfer_origen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trasacciones`
--
ALTER TABLE `trasacciones`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `vacaciones_disfrutadas`
--
ALTER TABLE `vacaciones_disfrutadas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F02817318D392AC7` (`id_empleado_id`);

--
-- Indexes for table `vale_salida`
--
ALTER TABLE `vale_salida`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_90C265C86601BA07` (`id_documento_id`);

--
-- Indexes for table `vuelo_destino`
--
ALTER TABLE `vuelo_destino`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vuelo_origen`
--
ALTER TABLE `vuelo_origen`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activo_fijo`
--
ALTER TABLE `activo_fijo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `activo_fijo_cuentas`
--
ALTER TABLE `activo_fijo_cuentas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `activo_fijo_movimiento_activo_fijo`
--
ALTER TABLE `activo_fijo_movimiento_activo_fijo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acumulado_vacaciones`
--
ALTER TABLE `acumulado_vacaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agencias`
--
ALTER TABLE `agencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ajuste`
--
ALTER TABLE `ajuste`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `almacen`
--
ALTER TABLE `almacen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `almacen_ocupado`
--
ALTER TABLE `almacen_ocupado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;

--
-- AUTO_INCREMENT for table `area_responsabilidad`
--
ALTER TABLE `area_responsabilidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `asiento`
--
ALTER TABLE `asiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=497;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `cierre`
--
ALTER TABLE `cierre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `cierre_diario`
--
ALTER TABLE `cierre_diario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cliente_beneficiario`
--
ALTER TABLE `cliente_beneficiario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cliente_contabilidad`
--
ALTER TABLE `cliente_contabilidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cliente_reporte`
--
ALTER TABLE `cliente_reporte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cobros_pagos`
--
ALTER TABLE `cobros_pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `comprobante_cierre`
--
ALTER TABLE `comprobante_cierre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `comprobante_movimiento_activo_fijo`
--
ALTER TABLE `comprobante_movimiento_activo_fijo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `comprobante_salario`
--
ALTER TABLE `comprobante_salario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `cotizacion`
--
ALTER TABLE `cotizacion`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `cuenta`
--
ALTER TABLE `cuenta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `cuentas_cliente`
--
ALTER TABLE `cuentas_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cuenta_criterio_analisis`
--
ALTER TABLE `cuenta_criterio_analisis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `custom_user`
--
ALTER TABLE `custom_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `depreciacion`
--
ALTER TABLE `depreciacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `devolucion`
--
ALTER TABLE `devolucion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `documento`
--
ALTER TABLE `documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT for table `elemento_gasto`
--
ALTER TABLE `elemento_gasto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `expediente`
--
ALTER TABLE `expediente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `factura`
--
ALTER TABLE `factura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `facturas_comprobante`
--
ALTER TABLE `facturas_comprobante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `factura_documento`
--
ALTER TABLE `factura_documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `factura_imposdom`
--
ALTER TABLE `factura_imposdom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `factura_no_contable`
--
ALTER TABLE `factura_no_contable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grupo_activos`
--
ALTER TABLE `grupo_activos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hotel_destino`
--
ALTER TABLE `hotel_destino`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hotel_origen`
--
ALTER TABLE `hotel_origen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `impuesto_sobre_renta`
--
ALTER TABLE `impuesto_sobre_renta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `informe_recepcion`
--
ALTER TABLE `informe_recepcion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `instrumento_cobro`
--
ALTER TABLE `instrumento_cobro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mercancia`
--
ALTER TABLE `mercancia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

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
-- AUTO_INCREMENT for table `moneda_pais`
--
ALTER TABLE `moneda_pais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movimiento`
--
ALTER TABLE `movimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movimiento_activo_fijo`
--
ALTER TABLE `movimiento_activo_fijo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `movimiento_mercancia`
--
ALTER TABLE `movimiento_mercancia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=347;

--
-- AUTO_INCREMENT for table `movimiento_producto`
--
ALTER TABLE `movimiento_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `movimiento_servicio`
--
ALTER TABLE `movimiento_servicio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `movimiento_venta`
--
ALTER TABLE `movimiento_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `municipios`
--
ALTER TABLE `municipios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nomina_pago`
--
ALTER TABLE `nomina_pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
-- AUTO_INCREMENT for table `operaciones_comprobante_operaciones`
--
ALTER TABLE `operaciones_comprobante_operaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `orden_trabajo`
--
ALTER TABLE `orden_trabajo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pais`
--
ALTER TABLE `pais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `periodo_sistema`
--
ALTER TABLE `periodo_sistema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
-- AUTO_INCREMENT for table `rango_escala_dgii`
--
ALTER TABLE `rango_escala_dgii`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `registro_comprobantes`
--
ALTER TABLE `registro_comprobantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `reglas_remesas`
--
ALTER TABLE `reglas_remesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rent_entrega`
--
ALTER TABLE `rent_entrega`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rent_recogida`
--
ALTER TABLE `rent_recogida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reporte_efectivo`
--
ALTER TABLE `reporte_efectivo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `solicitud_turismo`
--
ALTER TABLE `solicitud_turismo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `solicitud_turismo_comentario`
--
ALTER TABLE `solicitud_turismo_comentario`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `subcuenta_criterio_analisis`
--
ALTER TABLE `subcuenta_criterio_analisis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

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
-- AUTO_INCREMENT for table `tasa_de_cambio`
--
ALTER TABLE `tasa_de_cambio`
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
-- AUTO_INCREMENT for table `tour_nombre`
--
ALTER TABLE `tour_nombre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transferencia`
--
ALTER TABLE `transferencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transfer_destino`
--
ALTER TABLE `transfer_destino`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transfer_origen`
--
ALTER TABLE `transfer_origen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trasacciones`
--
ALTER TABLE `trasacciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unidad`
--
ALTER TABLE `unidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vacaciones_disfrutadas`
--
ALTER TABLE `vacaciones_disfrutadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vale_salida`
--
ALTER TABLE `vale_salida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `vuelo_destino`
--
ALTER TABLE `vuelo_destino`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vuelo_origen`
--
ALTER TABLE `vuelo_origen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  ADD CONSTRAINT `FK_E0DF29014D7B4AB9` FOREIGN KEY (`id_cuenta_acreedora_id`) REFERENCES `cuenta` (`id`),
  ADD CONSTRAINT `FK_E0DF2901549C81D9` FOREIGN KEY (`id_subcuenta_depreciacion_id`) REFERENCES `subcuenta` (`id`),
  ADD CONSTRAINT `FK_E0DF290157677646` FOREIGN KEY (`id_subcuenta_gasto_id`) REFERENCES `subcuenta` (`id`),
  ADD CONSTRAINT `FK_E0DF290174A5FFBA` FOREIGN KEY (`id_cuenta_depreciacion_id`) REFERENCES `cuenta` (`id`),
  ADD CONSTRAINT `FK_E0DF290180C608FA` FOREIGN KEY (`id_cuenta_gasto_id`) REFERENCES `cuenta` (`id`),
  ADD CONSTRAINT `FK_E0DF290186762CC7` FOREIGN KEY (`id_cuenta_activo_id`) REFERENCES `cuenta` (`id`),
  ADD CONSTRAINT `FK_E0DF2901A752F04B` FOREIGN KEY (`id_elemento_gasto_gasto_id`) REFERENCES `elemento_gasto` (`id`),
  ADD CONSTRAINT `FK_E0DF2901A950EE53` FOREIGN KEY (`id_centro_costo_gasto_id`) REFERENCES `centro_costo` (`id`),
  ADD CONSTRAINT `FK_E0DF2901C84BDE84` FOREIGN KEY (`id_activo_id`) REFERENCES `activo_fijo` (`id`),
  ADD CONSTRAINT `FK_E0DF2901EB1B341E` FOREIGN KEY (`id_subcuenta_acreedora_id`) REFERENCES `subcuenta` (`id`);

--
-- Constraints for table `activo_fijo_movimiento_activo_fijo`
--
ALTER TABLE `activo_fijo_movimiento_activo_fijo`
  ADD CONSTRAINT `FK_2FA61FF25832E72E` FOREIGN KEY (`id_activo_fijo_id`) REFERENCES `activo_fijo` (`id`),
  ADD CONSTRAINT `FK_2FA61FF27786CA71` FOREIGN KEY (`id_movimiento_activo_fijo_id`) REFERENCES `movimiento` (`id`);

--
-- Constraints for table `acumulado_vacaciones`
--
ALTER TABLE `acumulado_vacaciones`
  ADD CONSTRAINT `FK_246B9D168D392AC7` FOREIGN KEY (`id_empleado_id`) REFERENCES `empleado` (`id`);

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
-- Constraints for table `asiento`
--
ALTER TABLE `asiento`
  ADD CONSTRAINT `FK_71D6D35C1800963C` FOREIGN KEY (`id_comprobante_id`) REFERENCES `registro_comprobantes` (`id`),
  ADD CONSTRAINT `FK_71D6D35C1ADA4D3F` FOREIGN KEY (`id_cuenta_id`) REFERENCES `cuenta` (`id`),
  ADD CONSTRAINT `FK_71D6D35C1D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_71D6D35C2D412F53` FOREIGN KEY (`id_subcuenta_id`) REFERENCES `subcuenta` (`id`),
  ADD CONSTRAINT `FK_71D6D35C39161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_71D6D35C55C5F988` FOREIGN KEY (`id_factura_id`) REFERENCES `factura` (`id`),
  ADD CONSTRAINT `FK_71D6D35C5832E72E` FOREIGN KEY (`id_activo_fijo_id`) REFERENCES `activo_fijo` (`id`),
  ADD CONSTRAINT `FK_71D6D35C6601BA07` FOREIGN KEY (`id_documento_id`) REFERENCES `documento` (`id`),
  ADD CONSTRAINT `FK_71D6D35C71381BB3` FOREIGN KEY (`id_orden_trabajo_id`) REFERENCES `orden_trabajo` (`id`),
  ADD CONSTRAINT `FK_71D6D35CC59B01FF` FOREIGN KEY (`id_centro_costo_id`) REFERENCES `centro_costo` (`id`),
  ADD CONSTRAINT `FK_71D6D35CD410562` FOREIGN KEY (`id_area_responsabilidad_id`) REFERENCES `area_responsabilidad` (`id`),
  ADD CONSTRAINT `FK_71D6D35CE8F12801` FOREIGN KEY (`id_proveedor_id`) REFERENCES `proveedor` (`id`),
  ADD CONSTRAINT `FK_71D6D35CEF5F7851` FOREIGN KEY (`id_tipo_comprobante_id`) REFERENCES `tipo_comprobante` (`id`),
  ADD CONSTRAINT `FK_71D6D35CF5DBAF2B` FOREIGN KEY (`id_expediente_id`) REFERENCES `expediente` (`id`),
  ADD CONSTRAINT `FK_71D6D35CF66372E9` FOREIGN KEY (`id_elemento_gasto_id`) REFERENCES `elemento_gasto` (`id`);

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
-- Constraints for table `cobros_pagos`
--
ALTER TABLE `cobros_pagos`
  ADD CONSTRAINT `FK_D9581D1626990C38` FOREIGN KEY (`id_informe_id`) REFERENCES `informe_recepcion` (`id`),
  ADD CONSTRAINT `FK_D9581D1655C5F988` FOREIGN KEY (`id_factura_id`) REFERENCES `factura` (`id`),
  ADD CONSTRAINT `FK_D9581D167786CA71` FOREIGN KEY (`id_movimiento_activo_fijo_id`) REFERENCES `movimiento_activo_fijo` (`id`),
  ADD CONSTRAINT `FK_D9581D16E8F12801` FOREIGN KEY (`id_proveedor_id`) REFERENCES `proveedor` (`id`);

--
-- Constraints for table `comprobante_cierre`
--
ALTER TABLE `comprobante_cierre`
  ADD CONSTRAINT `FK_D03EA4C51800963C` FOREIGN KEY (`id_comprobante_id`) REFERENCES `registro_comprobantes` (`id`),
  ADD CONSTRAINT `FK_D03EA4C545F8C94C` FOREIGN KEY (`id_cierre_id`) REFERENCES `cierre` (`id`);

--
-- Constraints for table `comprobante_movimiento_activo_fijo`
--
ALTER TABLE `comprobante_movimiento_activo_fijo`
  ADD CONSTRAINT `FK_81F5096A1399A3CF` FOREIGN KEY (`id_registro_comprobante_id`) REFERENCES `registro_comprobantes` (`id`),
  ADD CONSTRAINT `FK_81F5096A1D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_81F5096A9D00B230` FOREIGN KEY (`id_movimiento_activo_id`) REFERENCES `movimiento_activo_fijo` (`id`);

--
-- Constraints for table `comprobante_salario`
--
ALTER TABLE `comprobante_salario`
  ADD CONSTRAINT `FK_8C5550701399A3CF` FOREIGN KEY (`id_registro_comprobante_id`) REFERENCES `registro_comprobantes` (`id`),
  ADD CONSTRAINT `FK_8C5550701D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`);

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
  ADD CONSTRAINT `FK_D618AE149D01464C` FOREIGN KEY (`unidad_id`) REFERENCES `unidad` (`id`);

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
  ADD CONSTRAINT `FK_B6B12EC74832F387` FOREIGN KEY (`id_documento_cancelado_id`) REFERENCES `documento` (`id`),
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
  ADD CONSTRAINT `FK_F9EBA009374388F5` FOREIGN KEY (`id_moneda_id`) REFERENCES `moneda` (`id`),
  ADD CONSTRAINT `FK_F9EBA0094F4C4E26` FOREIGN KEY (`id_categoria_cliente_id`) REFERENCES `categoria_cliente` (`id`),
  ADD CONSTRAINT `FK_F9EBA00968BCB606` FOREIGN KEY (`id_contrato_id`) REFERENCES `contratos_cliente` (`id`),
  ADD CONSTRAINT `FK_F9EBA00971381BB3` FOREIGN KEY (`id_orden_trabajo_id`) REFERENCES `orden_trabajo` (`id`),
  ADD CONSTRAINT `FK_F9EBA0097EB2C349` FOREIGN KEY (`id_usuario_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_F9EBA00999274826` FOREIGN KEY (`id_factura_cancela_id`) REFERENCES `factura` (`id`),
  ADD CONSTRAINT `FK_F9EBA009C37A5552` FOREIGN KEY (`id_termino_pago_id`) REFERENCES `termino_pago` (`id`),
  ADD CONSTRAINT `FK_F9EBA009C59B01FF` FOREIGN KEY (`id_centro_costo_id`) REFERENCES `centro_costo` (`id`),
  ADD CONSTRAINT `FK_F9EBA009F5DBAF2B` FOREIGN KEY (`id_expediente_id`) REFERENCES `expediente` (`id`),
  ADD CONSTRAINT `FK_F9EBA009F66372E9` FOREIGN KEY (`id_elemento_gasto_id`) REFERENCES `elemento_gasto` (`id`);

--
-- Constraints for table `facturas_comprobante`
--
ALTER TABLE `facturas_comprobante`
  ADD CONSTRAINT `FK_6FD2F19B1800963C` FOREIGN KEY (`id_comprobante_id`) REFERENCES `registro_comprobantes` (`id`),
  ADD CONSTRAINT `FK_6FD2F19B1D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_6FD2F19B55C5F988` FOREIGN KEY (`id_factura_id`) REFERENCES `factura` (`id`);

--
-- Constraints for table `factura_documento`
--
ALTER TABLE `factura_documento`
  ADD CONSTRAINT `FK_CCC060C155C5F988` FOREIGN KEY (`id_factura_id`) REFERENCES `factura` (`id`),
  ADD CONSTRAINT `FK_CCC060C16601BA07` FOREIGN KEY (`id_documento_id`) REFERENCES `documento` (`id`),
  ADD CONSTRAINT `FK_CCC060C1EC34F77F` FOREIGN KEY (`id_movimiento_venta_id`) REFERENCES `movimiento_venta` (`id`);

--
-- Constraints for table `impuesto_sobre_renta`
--
ALTER TABLE `impuesto_sobre_renta`
  ADD CONSTRAINT `FK_5EF11EF48D392AC7` FOREIGN KEY (`id_empleado_id`) REFERENCES `empleado` (`id`),
  ADD CONSTRAINT `FK_5EF11EF4A9ECE748` FOREIGN KEY (`id_rango_escala_id`) REFERENCES `rango_escala_dgii` (`id`),
  ADD CONSTRAINT `FK_5EF11EF4E9DBC8E8` FOREIGN KEY (`id_nomina_pago_id`) REFERENCES `nomina_pago` (`id`);

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
  ADD CONSTRAINT `FK_A985A0DA4B1CE99D` FOREIGN KEY (`id_unidad_destino_origen_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_A985A0DA571159DE` FOREIGN KEY (`id_movimiento_cancelado_id`) REFERENCES `movimiento_activo_fijo` (`id`),
  ADD CONSTRAINT `FK_A985A0DA5832E72E` FOREIGN KEY (`id_activo_fijo_id`) REFERENCES `activo_fijo` (`id`),
  ADD CONSTRAINT `FK_A985A0DA7EB2C349` FOREIGN KEY (`id_usuario_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_A985A0DADB763453` FOREIGN KEY (`id_tipo_movimiento_id`) REFERENCES `tipo_movimiento` (`id`),
  ADD CONSTRAINT `FK_A985A0DAE8F12801` FOREIGN KEY (`id_proveedor_id`) REFERENCES `proveedor` (`id`);

--
-- Constraints for table `movimiento_mercancia`
--
ALTER TABLE `movimiento_mercancia`
  ADD CONSTRAINT `FK_44876BD739161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_44876BD755C5F988` FOREIGN KEY (`id_factura_id`) REFERENCES `factura` (`id`),
  ADD CONSTRAINT `FK_44876BD7571159DE` FOREIGN KEY (`id_movimiento_cancelado_id`) REFERENCES `movimiento_mercancia` (`id`),
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
  ADD CONSTRAINT `FK_FFC0EDFC55C5F988` FOREIGN KEY (`id_factura_id`) REFERENCES `factura` (`id`),
  ADD CONSTRAINT `FK_FFC0EDFC571159DE` FOREIGN KEY (`id_movimiento_cancelado_id`) REFERENCES `movimiento_producto` (`id`),
  ADD CONSTRAINT `FK_FFC0EDFC6601BA07` FOREIGN KEY (`id_documento_id`) REFERENCES `documento` (`id`),
  ADD CONSTRAINT `FK_FFC0EDFC6E57A479` FOREIGN KEY (`id_producto_id`) REFERENCES `producto` (`id`),
  ADD CONSTRAINT `FK_FFC0EDFC71381BB3` FOREIGN KEY (`id_orden_trabajo_id`) REFERENCES `orden_trabajo` (`id`),
  ADD CONSTRAINT `FK_FFC0EDFC7A4F962` FOREIGN KEY (`id_tipo_documento_id`) REFERENCES `tipo_documento` (`id`),
  ADD CONSTRAINT `FK_FFC0EDFC7EB2C349` FOREIGN KEY (`id_usuario_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_FFC0EDFCC59B01FF` FOREIGN KEY (`id_centro_costo_id`) REFERENCES `centro_costo` (`id`),
  ADD CONSTRAINT `FK_FFC0EDFCF5DBAF2B` FOREIGN KEY (`id_expediente_id`) REFERENCES `expediente` (`id`),
  ADD CONSTRAINT `FK_FFC0EDFCF66372E9` FOREIGN KEY (`id_elemento_gasto_id`) REFERENCES `elemento_gasto` (`id`);

--
-- Constraints for table `movimiento_servicio`
--
ALTER TABLE `movimiento_servicio`
  ADD CONSTRAINT `FK_93FD19C355C5F988` FOREIGN KEY (`id_factura_id`) REFERENCES `factura` (`id`),
  ADD CONSTRAINT `FK_93FD19C371CAA3E7` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`);

--
-- Constraints for table `movimiento_venta`
--
ALTER TABLE `movimiento_venta`
  ADD CONSTRAINT `FK_8E3F7AE539161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_8E3F7AE555C5F988` FOREIGN KEY (`id_factura_id`) REFERENCES `factura` (`id`),
  ADD CONSTRAINT `FK_8E3F7AE56EA527F2` FOREIGN KEY (`id_expediente_acreedor_id`) REFERENCES `expediente` (`id`),
  ADD CONSTRAINT `FK_8E3F7AE5D8F8B0AD` FOREIGN KEY (`id_centro_costo_acreedor_id`) REFERENCES `centro_costo` (`id`),
  ADD CONSTRAINT `FK_8E3F7AE5F0821C98` FOREIGN KEY (`id_elemento_gasto_acreedor_id`) REFERENCES `elemento_gasto` (`id`),
  ADD CONSTRAINT `FK_8E3F7AE5FA3DF5CD` FOREIGN KEY (`id_orden_trabajo_acreedor_id`) REFERENCES `orden_trabajo` (`id`);

--
-- Constraints for table `nomina_pago`
--
ALTER TABLE `nomina_pago`
  ADD CONSTRAINT `FK_5CB8BD331D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_5CB8BD338D392AC7` FOREIGN KEY (`id_empleado_id`) REFERENCES `empleado` (`id`),
  ADD CONSTRAINT `FK_5CB8BD33AC6A6301` FOREIGN KEY (`id_usuario_aprueba_id`) REFERENCES `user` (`id`);

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
-- Constraints for table `operaciones_comprobante_operaciones`
--
ALTER TABLE `operaciones_comprobante_operaciones`
  ADD CONSTRAINT `FK_E7EA17E1ADA4D3F` FOREIGN KEY (`id_cuenta_id`) REFERENCES `cuenta` (`id`),
  ADD CONSTRAINT `FK_E7EA17E1D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_E7EA17E2D412F53` FOREIGN KEY (`id_subcuenta_id`) REFERENCES `subcuenta` (`id`),
  ADD CONSTRAINT `FK_E7EA17E39161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_E7EA17E71381BB3` FOREIGN KEY (`id_orden_trabajo_id`) REFERENCES `orden_trabajo` (`id`),
  ADD CONSTRAINT `FK_E7EA17EC59B01FF` FOREIGN KEY (`id_centro_costo_id`) REFERENCES `centro_costo` (`id`),
  ADD CONSTRAINT `FK_E7EA17EE8F12801` FOREIGN KEY (`id_proveedor_id`) REFERENCES `proveedor` (`id`),
  ADD CONSTRAINT `FK_E7EA17EECB9FBA7` FOREIGN KEY (`id_registro_comprobantes_id`) REFERENCES `registro_comprobantes` (`id`),
  ADD CONSTRAINT `FK_E7EA17EF5DBAF2B` FOREIGN KEY (`id_expediente_id`) REFERENCES `expediente` (`id`),
  ADD CONSTRAINT `FK_E7EA17EF66372E9` FOREIGN KEY (`id_elemento_gasto_id`) REFERENCES `elemento_gasto` (`id`);

--
-- Constraints for table `orden_trabajo`
--
ALTER TABLE `orden_trabajo`
  ADD CONSTRAINT `FK_4158A0241D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_4158A02439161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`);

--
-- Constraints for table `periodo_sistema`
--
ALTER TABLE `periodo_sistema`
  ADD CONSTRAINT `FK_AEF0BAAD1D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_AEF0BAAD39161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_AEF0BAAD7EB2C349` FOREIGN KEY (`id_usuario_id`) REFERENCES `user` (`id`);

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
-- Constraints for table `vacaciones_disfrutadas`
--
ALTER TABLE `vacaciones_disfrutadas`
  ADD CONSTRAINT `FK_F02817318D392AC7` FOREIGN KEY (`id_empleado_id`) REFERENCES `empleado` (`id`);

--
-- Constraints for table `vale_salida`
--
ALTER TABLE `vale_salida`
  ADD CONSTRAINT `FK_90C265C86601BA07` FOREIGN KEY (`id_documento_id`) REFERENCES `documento` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
