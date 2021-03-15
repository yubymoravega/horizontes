-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-03-2021 a las 22:11:37
-- Versión del servidor: 10.4.13-MariaDB
-- Versión de PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `trabajo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activo_fijo`
--

CREATE TABLE `activo_fijo` (
  `id` int(11) NOT NULL,
  `id_tipo_movimiento_id` int(11) DEFAULT NULL,
  `id_tipo_movimiento_baja_id` int(11) DEFAULT NULL,
  `id_area_responsabilidad_id` int(11) NOT NULL,
  `id_grupo_activo_id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `nro_inventario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_consecutivo` int(11) NOT NULL,
  `fecha_alta` date NOT NULL,
  `nro_documento_baja` int(11) DEFAULT NULL,
  `fecha_baja` date DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor_inicial` double NOT NULL,
  `depreciacion_acumulada` double DEFAULT NULL,
  `valor_real` double DEFAULT NULL,
  `annos_vida_util` double NOT NULL,
  `pais` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modelo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marca` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nro_motor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nro_serie` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nro_chapa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nro_chasis` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `combustible` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL,
  `fecha_ultima_depreciacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `activo_fijo`
--

INSERT INTO `activo_fijo` (`id`, `id_tipo_movimiento_id`, `id_tipo_movimiento_baja_id`, `id_area_responsabilidad_id`, `id_grupo_activo_id`, `id_unidad_id`, `nro_inventario`, `nro_consecutivo`, `fecha_alta`, `nro_documento_baja`, `fecha_baja`, `descripcion`, `valor_inicial`, `depreciacion_acumulada`, `valor_real`, `annos_vida_util`, `pais`, `modelo`, `tipo`, `marca`, `nro_motor`, `nro_serie`, `nro_chapa`, `nro_chasis`, `combustible`, `activo`, `fecha_ultima_depreciacion`) VALUES
(1, NULL, NULL, 1, 1, 1, '2550', 1, '2021-02-13', NULL, NULL, 'Buro', 500, 4.17, 495.83, 10, 'BANGLADESH', '122', 'mm', 'mm', '1255', '122', '', '', '', 1, '2021-02-17'),
(2, NULL, NULL, 1, 2, 1, '2551', 1, '2021-02-13', NULL, NULL, 'Edificio Administrativo', 50000, 208.33, 49791.67, 12, 'AUSTRIA', 'bn', '222', 'bnn', '', '', '', '', '', 1, '2021-02-17'),
(3, NULL, NULL, 1, 1, 1, '2553', 1, '2021-02-13', NULL, NULL, 'Silla Giratoria', 150, 1.25, 148.75, 10, 'ALEMANIA', '12', '12', '21', '', '', '', '', '', 1, '2021-02-17'),
(4, NULL, NULL, 1, 2, 1, '2718', 1, '2021-02-13', NULL, NULL, 'Computadora', 500, 2.08, 497.92, 5, 'ALEMANIA', '-', '-', '-', '-', '-', '-', '-', '', 1, '2021-02-17'),
(5, NULL, NULL, 1, 1, 1, '1325', 1, '2021-02-10', NULL, NULL, 'Auto Gely', 11500, 95.83, 11404.17, 10, 'ARMENIA', '11', '0', '0', '0', '', '', '', '', 1, '2021-02-17'),
(6, NULL, NULL, 1, 2, 1, '2355', 1, '2021-02-20', NULL, NULL, 'Nevera', 1000, 0, 1000, 5, 'ANGOLA', '23', '2', '2', '', '', '', '', '', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activo_fijo_cuentas`
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
-- Volcado de datos para la tabla `activo_fijo_cuentas`
--

INSERT INTO `activo_fijo_cuentas` (`id`, `id_activo_id`, `id_cuenta_activo_id`, `id_subcuenta_activo_id`, `id_centro_costo_activo_id`, `id_area_responsabilidad_activo_id`, `id_cuenta_depreciacion_id`, `id_subcuenta_depreciacion_id`, `id_cuenta_gasto_id`, `id_subcuenta_gasto_id`, `id_centro_costo_gasto_id`, `id_elemento_gasto_gasto_id`, `id_cuenta_acreedora_id`, `id_subcuenta_acreedora_id`) VALUES
(1, 1, 22, 138, 25, 1, 33, 134, 69, 97, 25, 17, 54, 38),
(2, 2, 22, 138, 25, 1, 33, 134, 69, 97, 25, 17, 54, 38),
(3, 3, 22, 138, 25, 1, 33, 134, 69, 97, 25, 17, 54, 38),
(4, 4, 22, 138, 25, 1, 33, 134, 69, 97, 25, 17, 54, 38),
(5, 5, 22, 138, 25, 1, 33, 134, 69, 97, 25, 17, 54, 38),
(6, 6, 22, 138, 25, 1, 33, 134, 69, 97, 25, 17, 54, 38);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activo_fijo_movimiento_activo_fijo`
--

CREATE TABLE `activo_fijo_movimiento_activo_fijo` (
  `id` int(11) NOT NULL,
  `id_activo_fijo_id` int(11) NOT NULL,
  `id_movimiento_activo_fijo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acumulado_vacaciones`
--

CREATE TABLE `acumulado_vacaciones` (
  `id` int(11) NOT NULL,
  `id_empleado_id` int(11) NOT NULL,
  `dias` double NOT NULL,
  `dinero` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aeropuerto`
--

CREATE TABLE `aeropuerto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `aeropuerto`
--

INSERT INTO `aeropuerto` (`id`, `nombre`, `activo`) VALUES
(1, 'sdsadasd', 1),
(2, 'dsadsadsa', 1),
(3, 'yuyuyuy', 0),
(4, 'nuevo aeropuerto 111', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agencias`
--

CREATE TABLE `agencias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agencias_img`
--

CREATE TABLE `agencias_img` (
  `id` int(11) NOT NULL,
  `id_unidad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agencias_tv`
--

CREATE TABLE `agencias_tv` (
  `id` int(11) NOT NULL,
  `url` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_tv` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_unidad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ajuste`
--

CREATE TABLE `ajuste` (
  `id` int(11) NOT NULL,
  `id_documento_id` int(11) NOT NULL,
  `nro_cuenta_inventario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `observacion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_subcuenta_inventario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_cuenta_acreedora` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_subcuenta_acreedora` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_concecutivo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anno` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `entrada` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ajuste`
--

INSERT INTO `ajuste` (`id`, `id_documento_id`, `nro_cuenta_inventario`, `observacion`, `nro_subcuenta_inventario`, `nro_cuenta_acreedora`, `nro_subcuenta_acreedora`, `nro_concecutivo`, `anno`, `activo`, `entrada`) VALUES
(1, 16, '696', 'ajuste de cuenta', '0099', '', '', '1', 2021, 1, 0),
(2, 17, '', 'ajuste de cuenta', '', '696', '0099', '1', 2021, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen`
--

CREATE TABLE `almacen` (
  `id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `almacen`
--

INSERT INTO `almacen` (`id`, `id_unidad_id`, `descripcion`, `activo`, `codigo`) VALUES
(1, 1, 'Almacén de Materiales y Mercancias', 1, '01'),
(2, 1, 'Almacén Mercancias para la Venta', 1, '02'),
(3, 1, 'Almacén de Productos Terminados', 1, '03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen_ocupado`
--

CREATE TABLE `almacen_ocupado` (
  `id` int(11) NOT NULL,
  `id_almacen_id` int(11) NOT NULL,
  `id_usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apertura`
--

CREATE TABLE `apertura` (
  `id` int(11) NOT NULL,
  `id_documento_id` int(11) NOT NULL,
  `nro_cuenta_inventario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `observacion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_subcuenta_inventario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_cuenta_acreedora` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_subcuenta_acreedora` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_concecutivo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anno` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `entrada` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `apertura`
--

INSERT INTO `apertura` (`id`, `id_documento_id`, `nro_cuenta_inventario`, `observacion`, `nro_subcuenta_inventario`, `nro_cuenta_acreedora`, `nro_subcuenta_acreedora`, `nro_concecutivo`, `anno`, `activo`, `entrada`) VALUES
(2, 2, '', 'Apertura del Negocio', '', '600', '0040', '1', 2021, 1, 1),
(3, 3, '', 'Apertura del negocio', '', '600', '0040', '1', 2021, 1, 1),
(8, 8, '', 'Apertura de Negocio', '', '600', '0040', '1', 2021, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area_responsabilidad`
--

CREATE TABLE `area_responsabilidad` (
  `id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `area_responsabilidad`
--

INSERT INTO `area_responsabilidad` (`id`, `id_unidad_id`, `codigo`, `nombre`, `activo`) VALUES
(1, 1, '0010', 'Dirección', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asiento`
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
  `id_tipo_comprobante_id` int(11) DEFAULT NULL,
  `id_comprobante_id` int(11) DEFAULT NULL,
  `id_factura_id` int(11) DEFAULT NULL,
  `id_activo_fijo_id` int(11) DEFAULT NULL,
  `id_area_responsabilidad_id` int(11) DEFAULT NULL,
  `tipo_cliente` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `anno` int(11) NOT NULL,
  `credito` double DEFAULT NULL,
  `debito` double DEFAULT NULL,
  `nro_documento` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_cotizacion_id` int(11) DEFAULT NULL,
  `id_elemento_visa_id` int(11) DEFAULT NULL,
  `orden_operacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `asiento`
--

INSERT INTO `asiento` (`id`, `id_cuenta_id`, `id_subcuenta_id`, `id_documento_id`, `id_almacen_id`, `id_centro_costo_id`, `id_elemento_gasto_id`, `id_orden_trabajo_id`, `id_expediente_id`, `id_proveedor_id`, `id_unidad_id`, `id_tipo_comprobante_id`, `id_comprobante_id`, `id_factura_id`, `id_activo_fijo_id`, `id_area_responsabilidad_id`, `tipo_cliente`, `id_cliente`, `fecha`, `anno`, `credito`, `debito`, `nro_documento`, `id_cotizacion_id`, `id_elemento_visa_id`, `orden_operacion`) VALUES
(3, 10, 65, 2, 1, 25, NULL, NULL, NULL, NULL, 1, 2, 2, NULL, NULL, NULL, 0, NULL, '2021-02-13', 2021, 0, 10000, 'AP-1', NULL, NULL, NULL),
(4, 10, 65, 2, 1, 25, NULL, NULL, NULL, NULL, 1, 2, 2, NULL, NULL, NULL, 0, NULL, '2021-02-13', 2021, 0, 5000, 'AP-1', NULL, NULL, NULL),
(5, 10, 65, 2, 1, 25, NULL, NULL, NULL, NULL, 1, 2, 2, NULL, NULL, NULL, 0, NULL, '2021-02-13', 2021, 0, 8000, 'AP-1', NULL, NULL, NULL),
(6, 54, 41, 2, 1, NULL, NULL, NULL, NULL, NULL, 1, 2, 2, NULL, NULL, NULL, 0, NULL, '2021-02-13', 2021, 23000, 0, 'AE-1', NULL, NULL, NULL),
(7, 15, 62, 3, 2, 25, NULL, NULL, NULL, NULL, 1, 2, 3, NULL, NULL, NULL, 0, NULL, '2021-02-13', 2021, 0, 3000, 'AP-1', NULL, NULL, NULL),
(8, 54, 41, 3, 2, NULL, NULL, NULL, NULL, NULL, 1, 2, 3, NULL, NULL, NULL, 0, NULL, '2021-02-13', 2021, 3000, 0, 'AE-1', NULL, NULL, NULL),
(17, 14, 6, 8, 3, 25, NULL, NULL, NULL, NULL, 1, 2, 1, NULL, NULL, NULL, 0, NULL, '2021-02-13', 2021, 0, 3000, 'IRP-1', NULL, NULL, NULL),
(18, 54, 41, 8, 3, NULL, NULL, NULL, NULL, NULL, 1, 2, 1, NULL, NULL, NULL, 0, NULL, '2021-02-13', 2021, 3000, 0, 'AE-1', NULL, NULL, NULL),
(19, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, '2021-02-14', 2021, 0, 2550000, '-', NULL, NULL, NULL),
(20, 54, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, '2021-02-14', 2021, 2550000, 0, '-', NULL, NULL, NULL),
(21, 22, 138, NULL, NULL, 25, NULL, NULL, NULL, NULL, 1, 2, 10, NULL, 1, 1, 0, NULL, '2021-02-13', 2021, 0, 500, 'AP-1', NULL, NULL, NULL),
(22, 54, 38, NULL, NULL, 25, 17, NULL, NULL, NULL, 1, 2, 10, NULL, 1, NULL, 0, NULL, '2021-02-13', 2021, 500, 0, 'AP-1', NULL, NULL, NULL),
(23, 22, 138, NULL, NULL, 25, NULL, NULL, NULL, NULL, 1, 2, 10, NULL, 2, 1, 0, NULL, '2021-02-13', 2021, 0, 50000, 'AP-2', NULL, NULL, NULL),
(24, 54, 38, NULL, NULL, 25, 17, NULL, NULL, NULL, 1, 2, 10, NULL, 2, NULL, 0, NULL, '2021-02-13', 2021, 50000, 0, 'AP-2', NULL, NULL, NULL),
(25, 22, 138, NULL, NULL, 25, NULL, NULL, NULL, NULL, 1, 2, 10, NULL, 3, 1, 0, NULL, '2021-02-13', 2021, 0, 150, 'AP-3', NULL, NULL, NULL),
(26, 54, 38, NULL, NULL, 25, 17, NULL, NULL, NULL, 1, 2, 10, NULL, 3, NULL, 0, NULL, '2021-02-13', 2021, 150, 0, 'AP-3', NULL, NULL, NULL),
(27, 10, 65, 9, 1, NULL, NULL, NULL, NULL, 3, 1, 2, 5, NULL, NULL, NULL, 0, NULL, '2021-02-14', 2021, 0, 18000, 'IRM-1', NULL, NULL, NULL),
(28, 10, 65, 9, 1, NULL, NULL, NULL, NULL, 3, 1, 2, 5, NULL, NULL, NULL, 0, NULL, '2021-02-14', 2021, 0, 15000, 'IRM-1', NULL, NULL, NULL),
(29, 36, 63, 9, 1, NULL, NULL, NULL, NULL, 3, 1, 2, 5, NULL, NULL, NULL, 0, NULL, '2021-02-14', 2021, 33000, 0, 'IRM-1', NULL, NULL, NULL),
(30, 10, 66, 10, 1, NULL, NULL, NULL, NULL, 2, 1, 2, 5, NULL, NULL, NULL, 0, NULL, '2021-02-14', 2021, 0, 2000, 'IRM-2', NULL, NULL, NULL),
(31, 10, 66, 10, 1, NULL, NULL, NULL, NULL, 2, 1, 2, 5, NULL, NULL, NULL, 0, NULL, '2021-02-14', 2021, 0, 1500, 'IRM-2', NULL, NULL, NULL),
(32, 10, 66, 10, 1, NULL, NULL, NULL, NULL, 2, 1, 2, 5, NULL, NULL, NULL, 0, NULL, '2021-02-14', 2021, 0, 3000, 'IRM-2', NULL, NULL, NULL),
(33, 36, 63, 10, 1, NULL, NULL, NULL, NULL, 2, 1, 2, 5, NULL, NULL, NULL, 0, NULL, '2021-02-14', 2021, 6500, 0, 'IRM-2', NULL, NULL, NULL),
(34, 63, 51, 11, 1, 24, 3, NULL, NULL, NULL, 1, 2, 5, NULL, NULL, NULL, 0, NULL, '2021-02-14', 2021, 0, 3250, 'VSM-1', NULL, NULL, NULL),
(35, 10, 66, 11, 1, NULL, NULL, NULL, NULL, NULL, 1, 2, 5, NULL, NULL, NULL, 0, NULL, '2021-02-14', 2021, 1000, 0, 'VSM-1', NULL, NULL, NULL),
(36, 10, 66, 11, 1, NULL, NULL, NULL, NULL, NULL, 1, 2, 5, NULL, NULL, NULL, 0, NULL, '2021-02-14', 2021, 750, 0, 'VSM-1', NULL, NULL, NULL),
(37, 10, 66, 11, 1, NULL, NULL, NULL, NULL, NULL, 1, 2, 5, NULL, NULL, NULL, 0, NULL, '2021-02-14', 2021, 1500, 0, 'VSM-1', NULL, NULL, NULL),
(38, 14, 4, 12, 3, 24, NULL, 1, NULL, NULL, 1, 2, 6, NULL, NULL, NULL, 0, NULL, '2021-02-14', 2021, 0, 3250, 'IRP-1', NULL, NULL, NULL),
(39, 63, 54, 12, 3, NULL, NULL, NULL, NULL, NULL, 1, 2, 6, NULL, NULL, NULL, 0, NULL, '2021-02-14', 2021, 3250, 0, 'IRP-1', NULL, NULL, NULL),
(40, 15, 62, 13, 2, NULL, NULL, NULL, NULL, 4, 1, 2, 7, NULL, NULL, NULL, 0, NULL, '2021-02-14', 2021, 0, 25000, 'IRM-1', NULL, NULL, NULL),
(41, 36, 63, 13, 2, NULL, NULL, NULL, NULL, 4, 1, 2, 7, NULL, NULL, NULL, 0, NULL, '2021-02-14', 2021, 25000, 0, 'IRM-1', NULL, NULL, NULL),
(42, 8, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, 9, 1, NULL, NULL, 3, 1, '2021-02-15', 2021, 0, 16535, 'FACT-1', NULL, NULL, NULL),
(43, 75, 85, NULL, 2, NULL, NULL, NULL, NULL, NULL, 1, 2, 9, 1, NULL, NULL, 0, NULL, '2021-02-15', 2021, 14000, 0, 'FACT-1', NULL, NULL, NULL),
(44, 76, 81, NULL, 3, NULL, NULL, NULL, NULL, NULL, 1, 2, 9, 1, NULL, NULL, 0, NULL, '2021-02-15', 2021, 2500, 0, 'FACT-1', NULL, NULL, NULL),
(45, 41, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, 9, 1, NULL, NULL, 0, NULL, '2021-02-15', 2021, 35, 0, 'FACT-1', NULL, NULL, NULL),
(46, 15, 62, 14, 2, NULL, NULL, NULL, NULL, NULL, 1, 2, 8, 1, NULL, NULL, 0, NULL, '2021-02-15', 2021, 10000, 0, 'FACT-1', NULL, NULL, NULL),
(47, 68, 90, 14, 2, NULL, NULL, NULL, NULL, NULL, 1, 2, 8, 1, NULL, NULL, 0, NULL, '2021-02-15', 2021, 0, 10000, 'FACT-1', NULL, NULL, NULL),
(48, 14, 4, 15, 3, NULL, NULL, NULL, NULL, NULL, 1, 2, 17, 1, NULL, NULL, 0, NULL, '2021-02-15', 2021, 1625, 0, 'FACT-1', NULL, NULL, NULL),
(49, 67, 74, 15, 3, NULL, NULL, NULL, NULL, NULL, 1, 2, 17, 1, NULL, NULL, 0, NULL, '2021-02-15', 2021, 0, 1625, 'FACT-1', NULL, NULL, NULL),
(50, 22, 138, NULL, NULL, 25, NULL, NULL, NULL, NULL, 1, 2, 10, NULL, 4, 1, 0, NULL, '2021-02-13', 2021, 0, 500, 'A-1', NULL, NULL, NULL),
(51, 54, 38, NULL, NULL, 25, 17, NULL, NULL, NULL, 1, 2, 10, NULL, 4, NULL, 0, NULL, '2021-02-13', 2021, 500, 0, 'A-1', NULL, NULL, NULL),
(52, 85, 136, NULL, NULL, 25, 17, NULL, NULL, NULL, 1, 2, 10, NULL, 4, NULL, 0, NULL, '2021-02-13', 2021, 0, 500, 'A-1', NULL, NULL, NULL),
(53, 37, 38, NULL, NULL, 25, 17, NULL, NULL, 4, 1, 2, 10, NULL, 4, NULL, 0, NULL, '2021-02-13', 2021, 500, 0, 'A-1', NULL, NULL, NULL),
(54, 85, 136, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, 11, NULL, NULL, NULL, NULL, NULL, '2021-02-17', 2021, 0, 25000, '-', NULL, NULL, NULL),
(55, 54, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, 11, NULL, NULL, NULL, NULL, NULL, '2021-02-17', 2021, 25000, 0, '-', NULL, NULL, NULL),
(56, 54, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, 12, NULL, NULL, NULL, NULL, NULL, '2021-02-17', 2021, 0, 25000, '-', NULL, NULL, NULL),
(57, 85, 136, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, 12, NULL, NULL, NULL, NULL, NULL, '2021-02-17', 2021, 25000, 0, '-', NULL, NULL, NULL),
(58, 54, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, 13, NULL, NULL, NULL, NULL, NULL, '2021-02-17', 2021, 0, 25000, '-', NULL, NULL, NULL),
(59, 85, 136, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, 13, NULL, NULL, NULL, NULL, NULL, '2021-02-17', 2021, 25000, 0, '-', NULL, NULL, NULL),
(60, 22, 138, NULL, NULL, 25, NULL, NULL, NULL, NULL, 1, 2, 14, NULL, 5, 1, 0, NULL, '2021-02-10', 2021, 0, 11500, 'A-2', NULL, NULL, NULL),
(61, 54, 38, NULL, NULL, 25, 17, NULL, NULL, NULL, 1, 2, 14, NULL, 5, NULL, 0, NULL, '2021-02-10', 2021, 11500, 0, 'A-2', NULL, NULL, NULL),
(62, 85, 136, NULL, NULL, 25, 17, NULL, NULL, NULL, 1, 2, 14, NULL, 5, NULL, 0, NULL, '2021-02-10', 2021, 0, 11500, 'A-2', NULL, NULL, NULL),
(63, 37, 38, NULL, NULL, 25, 17, NULL, NULL, 1, 1, 2, 14, NULL, 5, NULL, 0, NULL, '2021-02-10', 2021, 11500, 0, 'A-2', NULL, NULL, NULL),
(64, 69, 97, NULL, NULL, 25, 17, NULL, NULL, NULL, 1, 2, 15, NULL, NULL, NULL, 0, NULL, '2021-02-17', 2021, 0, 311.66, '0', NULL, NULL, NULL),
(65, 33, 134, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, 15, NULL, NULL, NULL, 0, NULL, '2021-02-17', 2021, 311.66, 0, '0', NULL, NULL, NULL),
(66, 14, 6, 16, 3, NULL, NULL, NULL, NULL, NULL, 1, 2, 17, NULL, NULL, NULL, 0, NULL, '2021-02-17', 2021, 3000, 0, 'AS-1', NULL, NULL, NULL),
(67, 61, 46, 16, 3, NULL, NULL, NULL, NULL, NULL, 1, 2, 17, NULL, NULL, NULL, 0, NULL, '2021-02-17', 2021, 0, 3000, 'AS-1', NULL, NULL, NULL),
(68, 15, 62, 17, 2, NULL, NULL, NULL, NULL, NULL, 1, 2, 16, NULL, NULL, NULL, 0, NULL, '2021-02-16', 2021, 0, 3000, 'AE-1', NULL, NULL, NULL),
(69, 61, 46, 17, 2, NULL, NULL, NULL, NULL, NULL, 1, 2, 16, NULL, NULL, NULL, 0, NULL, '2021-02-16', 2021, 3000, 0, 'AE-1', NULL, NULL, NULL),
(70, 22, 138, NULL, NULL, 25, NULL, NULL, NULL, NULL, 1, 2, 18, NULL, 6, 1, 0, NULL, '2021-02-20', 2021, 0, 1000, 'A-3', NULL, NULL, NULL),
(71, 54, 38, NULL, NULL, 25, 17, NULL, NULL, NULL, 1, 2, 18, NULL, 6, NULL, 0, NULL, '2021-02-20', 2021, 1000, 0, 'A-3', NULL, NULL, NULL),
(72, 85, 136, NULL, NULL, 25, 17, NULL, NULL, NULL, 1, 2, 18, NULL, 6, NULL, 0, NULL, '2021-02-20', 2021, 0, 1000, 'A-3', NULL, NULL, NULL),
(73, 37, 38, NULL, NULL, 25, 17, NULL, NULL, 2, 1, 2, 18, NULL, 6, NULL, 0, NULL, '2021-02-20', 2021, 1000, 0, 'A-3', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avisos_pagos`
--

CREATE TABLE `avisos_pagos` (
  `id` int(11) NOT NULL,
  `id_plazo_pago_id` int(11) NOT NULL,
  `id_cotizacion_id` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banco`
--

CREATE TABLE `banco` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `beneficiarios_clientes`
--

CREATE TABLE `beneficiarios_clientes` (
  `id` int(11) NOT NULL,
  `id_cliente_id` int(11) NOT NULL,
  `id_pais_id` int(11) NOT NULL,
  `id_provincia_id` int(11) NOT NULL,
  `id_municipio_id` int(11) NOT NULL,
  `primer_nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `primer_apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `segundo_apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_alternativo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `primer_apellido_alternativo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `segundo_apellido_alternativo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `primer_telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `segundo_telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identificacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `calle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `y` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nro_casa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edificio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reparto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `beneficiarios_clientes`
--

INSERT INTO `beneficiarios_clientes` (`id`, `id_cliente_id`, `id_pais_id`, `id_provincia_id`, `id_municipio_id`, `primer_nombre`, `primer_apellido`, `segundo_apellido`, `nombre_alternativo`, `primer_apellido_alternativo`, `segundo_apellido_alternativo`, `primer_telefono`, `segundo_telefono`, `identificacion`, `calle`, `entre`, `y`, `nro_casa`, `edificio`, `apto`, `reparto`, `activo`) VALUES
(1, 1, 1, 1, 2, 'Camilo Alberto', 'Hernandez', 'Valdes', NULL, NULL, NULL, '48769307', '48774398', '89102815009', 'Antonio Rubio', 'M. Capote', 'G. Lache', '313', NULL, NULL, 'Celso Maragoto', 1),
(2, 1, 1, 1, 3, 'Leidi', 'Prado', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(3, 1, 1, 1, 3, 'Alberto', 'Hernandez', 'Correa', '', '', '', '52698986', '', '', 'A', 'B', 'C', '313', '', '', '', 1),
(4, 1, 1, 1, 2, 'marlon', 'hernandez', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(5, 1, 1, 1, 3, 'lolo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(6, 1, 1, 1, 2, 'Maria Mayre', 'Valdes', 'Llenade', '', '', '', '52698986', '', '89102815009', 'Antonio Rubio', 'M. Capote', 'G. Lache', '313', '', '', '', 1),
(7, 1, 1, 1, 2, 'kjk', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(8, 1, 1, 1, 2, 'Evellyn', 'Hernandez', 'Delgado', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(9, 1, 1, 1, 3, 'cklvcxklvklxc', 'vxcvxcvxcv', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`id`, `nombre`, `activo`) VALUES
(1, 'Administrador del Sistema', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id` int(11) NOT NULL,
  `json` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `empleado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id`, `json`, `empleado`) VALUES
(179, '{\"id_empleado\":1,\"id_cliente\":1,\"id_servicio\":4,\"nombre_servicio\":\"Envio de Remesas\",\"precio_servicio\":60.00000000000265,\"id_moneda\":2,\"total\":60.00000000000265,\"data\":[{\"actualizar\":false,\"id_banaficiario_\":\"1\",\"nombre_\":\"Camilo Alberto\",\"id_pais_\":\"1\",\"id_moneda_\":\"1\",\"id_provincia_\":\"1\",\"id_municipio_\":\"2\",\"primer_apellido_\":\"Hernandez\",\"segundo_apellido_\":\"Valdes\",\"nombre_alternativo_\":\"\",\"primer_apellido_alternativo_\":\"\",\"segundo_apellido_alternativo_\":\"\",\"primer_telefono_\":\"48769307\",\"segundo_telefono_\":\"48774398\",\"identificacion_\":\"89102815009\",\"calle_\":\"Antonio Rubio\",\"entre_\":\"M. Capote\",\"y_\":\"G. Lache\",\"nro_casa_\":\"313\",\"edificio_\":\"\",\"apto_\":\"\",\"reparto_\":\"Celso Maragoto\",\"monto_entregar_\":60.00000000000265,\"monto_recibir_\":\"59\",\"id_moneda_select_\":2,\"nombre_moneda_recibir\":\"EUR\",\"id_regla\":2,\"idCarrito\":0,\"nombreMostrar\":\"Camilo Alberto Hernandez\",\"montoMostrar\":60.00000000000265}]}', 'root'),
(180, '{\"id_empleado\":1,\"id_cliente\":1,\"id_servicio\":11,\"nombre_servicio\":\"Paquete Tur\\u00edstico B\\u00e1sico\",\"precio_servicio\":304.1666666666655,\"id_moneda\":2,\"total\":304.1666666666655,\"data\":[{\"nombre\":\"Camilo Alberto\",\"primer_apellido\":\"Hernandez\",\"segundo_apellido\":\"Valdes\",\"telefono_celular\":\"55816826\",\"telefono_fijo\":\"\",\"idCarrito\":0,\"nombreMostrar\":\"Camilo Alberto Hernandez\",\"montoMostrar\":304.1666666666655}]}', 'root');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_cliente`
--

CREATE TABLE `categoria_cliente` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prefijo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categoria_cliente`
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
(11, 'Comprobantes de Pagos al Exterior', 'B17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centro_costo`
--

CREATE TABLE `centro_costo` (
  `id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `centro_costo`
--

INSERT INTO `centro_costo` (`id`, `id_unidad_id`, `activo`, `codigo`, `nombre`) VALUES
(22, 1, 1, '0150', 'Combo de aseo'),
(23, 1, 1, '0160', 'Combo de Medicamento'),
(24, 1, 1, '0170', 'Combo de Alimento'),
(25, 1, 1, '0180', 'Otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cierre`
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
-- Volcado de datos para la tabla `cierre`
--

INSERT INTO `cierre` (`id`, `id_almacen_id`, `id_usuario_id`, `diario`, `mes`, `anno`, `fecha`, `saldo`, `abierto`, `debito`, `credito`) VALUES
(1, 3, 1, 1, 2, 2021, '2021-02-13', 0, 0, 3000, 0),
(2, 3, 1, 1, 2, 2021, '2021-02-14', 3000, 0, 3250, 0),
(3, 1, 1, 1, 2, 2021, '2021-02-13', 0, 0, 23000, 0),
(4, 1, 1, 1, 2, 2021, '2021-02-14', 23000, 0, 39500, 3250),
(5, 2, 1, 1, 2, 2021, '2021-02-13', 0, 0, 3000, 0),
(6, 2, 1, 1, 2, 2021, '2021-02-14', 3000, 0, 25000, 0),
(7, 1, 1, 1, 2, 2021, '2021-02-15', 59250, 0, 0, 0),
(8, 3, 1, 1, 2, 2021, '2021-02-15', 6250, 0, 0, 1625),
(9, 2, 1, 1, 2, 2021, '2021-02-15', 28000, 0, 0, 10000),
(10, 2, 1, 1, 2, 2021, '2021-02-16', 18000, 0, 3000, 0),
(11, 3, 1, 1, 2, 2021, '2021-02-16', 4625, 0, 0, 0),
(12, 3, 1, 1, 2, 2021, '2021-02-17', 4625, 0, 0, 3000),
(13, 1, 1, 1, 2, 2021, '2021-02-16', 59250, 1, 0, 0),
(14, 2, 1, 1, 2, 2021, '2021-02-17', 21000, 1, 0, 0),
(15, 3, 1, 1, 2, 2021, '2021-02-18', 1625, 1, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cierre_diario`
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
-- Estructura de tabla para la tabla `cliente`
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
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `nombre`, `apellidos`, `correo`, `direccion`, `token`, `fecha`, `usuario`, `comentario`, `telefono`) VALUES
(1, 'Camilo Alberto', 'Hernandez Valdes', 'kahveahd@gmail.com', 'Alle Antonio Rubio #313 e/ M. Capote & G. Lache', NULL, NULL, NULL, NULL, '55816826');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente_beneficiario`
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
  `municipio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_pais` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cliente_beneficiario`
--

INSERT INTO `cliente_beneficiario` (`id`, `id_cliente`, `primer_nombre`, `telefono_casa`, `primer_apellido`, `segundo_apellido`, `alternativo_nombre`, `alternativo_apellido`, `alternativo_segundo_apellido`, `telefono`, `identificacion`, `calle`, `no`, `entre`, `y`, `apto`, `edificio`, `reparto`, `provincia`, `municipio`, `id_pais`) VALUES
(1, '55816826', 'aaaaaa', '43434343434', 'aaaa', 'aaa', 'aaa', 'aASAS', 'sasasa', '34343434343', '43434343', 'dsadsadasdas', '34', NULL, NULL, NULL, NULL, NULL, 'Pinar del Rio', 'Pinar del Rio', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente_contabilidad`
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
-- Volcado de datos para la tabla `cliente_contabilidad`
--

INSERT INTO `cliente_contabilidad` (`id`, `codigo`, `nombre`, `direccion`, `telefonos`, `fax`, `correos`, `activo`) VALUES
(1, '121.5.2015', 'Continental SA', 'asasasas', '1122', '12', 'aa@aa.aa', 1),
(2, '132-13041-3', 'CAISA', 'asasasas', '1111112', '1212s', ',,,', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente_reporte`
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
-- Estructura de tabla para la tabla `cliente_solicitudes`
--

CREATE TABLE `cliente_solicitudes` (
  `id` int(11) NOT NULL,
  `id_cliente_id` int(11) NOT NULL,
  `id_solicitud_id` int(11) NOT NULL,
  `id_unidad_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cobros_pagos`
--

CREATE TABLE `cobros_pagos` (
  `id` int(11) NOT NULL,
  `id_factura_id` int(11) DEFAULT NULL,
  `id_informe_id` int(11) DEFAULT NULL,
  `id_proveedor_id` int(11) DEFAULT NULL,
  `id_movimiento_activo_fijo_id` int(11) DEFAULT NULL,
  `debito` double DEFAULT NULL,
  `credito` double DEFAULT NULL,
  `id_tipo_cliente` int(11) DEFAULT NULL,
  `id_cliente_venta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobante_cierre`
--

CREATE TABLE `comprobante_cierre` (
  `id` int(11) NOT NULL,
  `id_comprobante_id` int(11) NOT NULL,
  `id_cierre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `comprobante_cierre`
--

INSERT INTO `comprobante_cierre` (`id`, `id_comprobante_id`, `id_cierre_id`) VALUES
(1, 1, 1),
(2, 2, 3),
(3, 3, 5),
(4, 5, 4),
(5, 6, 2),
(6, 7, 6),
(7, 8, 9),
(8, 16, 10),
(9, 17, 8),
(10, 17, 11),
(11, 17, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobante_movimiento_activo_fijo`
--

CREATE TABLE `comprobante_movimiento_activo_fijo` (
  `id` int(11) NOT NULL,
  `id_registro_comprobante_id` int(11) NOT NULL,
  `id_movimiento_activo_id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `anno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `comprobante_movimiento_activo_fijo`
--

INSERT INTO `comprobante_movimiento_activo_fijo` (`id`, `id_registro_comprobante_id`, `id_movimiento_activo_id`, `id_unidad_id`, `anno`) VALUES
(1, 10, 1, 1, 2021),
(2, 10, 2, 1, 2021),
(3, 10, 3, 1, 2021),
(4, 10, 4, 1, 2021),
(5, 14, 5, 1, 2021),
(6, 18, 6, 1, 2021);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobante_salario`
--

CREATE TABLE `comprobante_salario` (
  `id` int(11) NOT NULL,
  `id_registro_comprobante_id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `mes` int(11) NOT NULL,
  `anno` int(11) NOT NULL,
  `quincena` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion_inicial`
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
-- Estructura de tabla para la tabla `configuracion_reglas_remesas`
--

CREATE TABLE `configuracion_reglas_remesas` (
  `id` int(11) NOT NULL,
  `id_pais_id` int(11) NOT NULL,
  `id_proveedor_id` int(11) NOT NULL,
  `id_unidad_id` int(11) DEFAULT NULL,
  `minimo` double NOT NULL,
  `maximo` double NOT NULL,
  `valor_fijo_costo` double DEFAULT NULL,
  `porciento_costo` double DEFAULT NULL,
  `valor_fijo_venta` double DEFAULT NULL,
  `porciento_venta` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `configuracion_reglas_remesas`
--

INSERT INTO `configuracion_reglas_remesas` (`id`, `id_pais_id`, `id_proveedor_id`, `id_unidad_id`, `minimo`, `maximo`, `valor_fijo_costo`, `porciento_costo`, `valor_fijo_venta`, `porciento_venta`) VALUES
(2, 1, 2, 1, 1, 100, 2, 0, 0, 2),
(3, 1, 4, 1, 1, 100, 1, 0, 0, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config_precio_venta_servicio`
--

CREATE TABLE `config_precio_venta_servicio` (
  `id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `identificador_servicio` int(11) NOT NULL,
  `prociento` double DEFAULT NULL,
  `valor_fijo` double DEFAULT NULL,
  `precio_venta_total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `config_precio_venta_servicio`
--

INSERT INTO `config_precio_venta_servicio` (`id`, `id_unidad_id`, `identificador_servicio`, `prociento`, `valor_fijo`, `precio_venta_total`) VALUES
(1, 1, 11, 10, 0, 365);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config_servicios`
--

CREATE TABLE `config_servicios` (
  `id` int(11) NOT NULL,
  `id_servicio_id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `minimo` double NOT NULL,
  `porciento` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `config_servicios`
--

INSERT INTO `config_servicios` (`id`, `id_servicio_id`, `id_unidad_id`, `minimo`, `porciento`) VALUES
(1, 1, 1, 100, 1),
(2, 3, 1, 444, 0),
(3, 2, 1, 20, 1),
(4, 5, 1, 10, 0),
(5, 4, 1, 100, 1),
(6, 6, 1, 90, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratos_cliente`
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
-- Estructura de tabla para la tabla `cotizacion`
--

CREATE TABLE `cotizacion` (
  `id` int(11) NOT NULL,
  `edit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `json` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `empleado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datetime` datetime NOT NULL,
  `total` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_cliente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_cliente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_moneda` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pagado` tinyint(1) DEFAULT NULL,
  `id_factura` int(11) DEFAULT NULL,
  `fecha_factura` datetime DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cotizacion`
--

INSERT INTO `cotizacion` (`id`, `edit`, `json`, `empleado`, `datetime`, `total`, `id_cliente`, `nombre_cliente`, `id_moneda`, `pagado`, `id_factura`, `fecha_factura`, `activo`) VALUES
(13, '1', '[{\"id_empleado\":1,\"id_cliente\":1,\"id_servicio\":4,\"nombre_servicio\":\"Envio de Remesas\",\"precio_servicio\":66.66666666667227,\"id_moneda\":2,\"total\":66.66666666667227,\"data\":[{\"actualizar\":false,\"id_banaficiario_\":\"6\",\"nombre_\":\"Maria Mayre\",\"id_pais_\":\"1\",\"id_moneda_\":\"1\",\"id_provincia_\":\"1\",\"id_municipio_\":\"2\",\"primer_apellido_\":\"Valdes\",\"segundo_apellido_\":\"Llenade\",\"nombre_alternativo_\":\"\",\"primer_apellido_alternativo_\":\"\",\"segundo_apellido_alternativo_\":\"\",\"primer_telefono_\":\"52698986\",\"segundo_telefono_\":\"\",\"identificacion_\":\"89102815009\",\"calle_\":\"Antonio Rubio\",\"entre_\":\"M. Capote\",\"y_\":\"G. Lache\",\"nro_casa_\":\"313\",\"edificio_\":\"\",\"apto_\":\"\",\"reparto_\":\"\",\"monto_entregar_\":66.66666666667227,\"monto_recibir_\":\"65\",\"id_moneda_select_\":2,\"nombre_moneda_recibir\":\"EUR\",\"id_regla\":2,\"idCarrito\":0,\"nombreMostrar\":\"Maria Mayre Valdes\",\"montoMostrar\":66.66666666667227}]},{\"id_empleado\":1,\"id_cliente\":1,\"id_servicio\":11,\"nombre_servicio\":\"Paquete Tur\\u00edstico B\\u00e1sico\",\"precio_servicio\":304.1666666666655,\"id_moneda\":2,\"total\":304.1666666666655,\"data\":[{\"nombre\":\"Camilo Alberto\",\"primer_apellido\":\"Hernandez\",\"segundo_apellido\":\"Valdes\",\"telefono_celular\":\"55816826\",\"telefono_fijo\":\"\",\"idCarrito\":0,\"nombreMostrar\":\"Camilo Alberto Hernandez\",\"montoMostrar\":304.1666666666655}]}]', 'root', '2021-03-09 04:56:24', '370.83', '1', 'Camilo Alberto', '2', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `creditos_precio_venta`
--

CREATE TABLE `creditos_precio_venta` (
  `id` int(11) NOT NULL,
  `id_config_precio_venta_id` int(11) NOT NULL,
  `identificador_servicio` int(11) NOT NULL,
  `credito` tinyint(1) DEFAULT NULL,
  `importe` double NOT NULL,
  `id_unidad_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `creditos_precio_venta`
--

INSERT INTO `creditos_precio_venta` (`id`, `id_config_precio_venta_id`, `identificador_servicio`, `credito`, `importe`, `id_unidad_id`) VALUES
(5, 1, 5, 1, 100, NULL),
(6, 1, 6, 1, 100, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `criterio_analisis`
--

CREATE TABLE `criterio_analisis` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abreviatura` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `criterio_analisis`
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
-- Estructura de tabla para la tabla `cuadre_diario`
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
-- Volcado de datos para la tabla `cuadre_diario`
--

INSERT INTO `cuadre_diario` (`id`, `id_cuenta_id`, `id_subcuenta_id`, `id_cierre_id`, `id_almacen_id`, `str_analisis`, `fecha`, `saldo`, `debito`, `credito`) VALUES
(1, 14, 6, 1, 3, '03', '2021-02-13', '0.00', 3000, 0),
(2, 10, 65, 3, 1, '01', '2021-02-13', '0.00', 23000, 0),
(3, 15, 62, 5, 2, '02', '2021-02-13', '0.00', 3000, 0),
(4, 10, 65, 4, 1, '01', '2021-02-14', '23000.00', 33000, 0),
(5, 10, 66, 4, 1, '01', '2021-02-14', '0.00', 6500, 3250),
(6, 14, 4, 2, 3, '03', '2021-02-14', '0.00', 3250, 0),
(7, 15, 62, 6, 2, '02', '2021-02-14', '3000.00', 25000, 0),
(8, 15, 62, 9, 2, '02', '2021-02-15', '28000.00', 0, 10000),
(9, 14, 4, 8, 3, '03', '2021-02-15', '3250.00', 0, 1625),
(10, 15, 62, 10, 2, '02', '2021-02-16', '18000.00', 3000, 0),
(11, 14, 6, 12, 3, '03', '2021-02-17', '3000.00', 0, 3000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta`
--

CREATE TABLE `cuenta` (
  `id` int(11) NOT NULL,
  `id_tipo_cuenta_id` int(11) NOT NULL,
  `nro_cuenta` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deudora` tinyint(1) NOT NULL,
  `mixta` tinyint(1) NOT NULL,
  `obligacion_deudora` tinyint(1) NOT NULL,
  `obligacion_acreedora` tinyint(1) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `produccion` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cuenta`
--

INSERT INTO `cuenta` (`id`, `id_tipo_cuenta_id`, `nro_cuenta`, `nombre`, `deudora`, `mixta`, `obligacion_deudora`, `obligacion_acreedora`, `activo`, `produccion`) VALUES
(1, 1, 103, 'Efectivo en Caja', 1, 0, 0, 0, 1, 0),
(2, 1, 109, 'Efectivo en Banco', 1, 0, 0, 0, 1, 0),
(3, 1, 131, 'Efectos por Cobrar a Corto Plazo', 1, 0, 1, 0, 1, 0),
(4, 1, 134, 'Cuenta en Participacion', 1, 0, 1, 0, 1, 0),
(5, 1, 142, 'Prestamos y Otras Operaciones Crediticias', 1, 0, 0, 0, 1, 0),
(6, 1, 146, 'Pagos Anticipados a Suministradores', 1, 0, 0, 0, 1, 0),
(7, 1, 160, 'Anticipos a Justificar', 1, 0, 0, 0, 1, 0),
(8, 1, 135, 'Cuentas por Cobrar', 1, 0, 1, 0, 1, 0),
(9, 1, 164, 'Adeudos con el  Estado', 1, 0, 0, 0, 1, 0),
(10, 1, 183, 'Materias Primas y Materiales', 1, 0, 0, 0, 1, 0),
(11, 1, 184, 'Combustible  Lubricantes', 1, 0, 0, 0, 1, 0),
(12, 1, 185, 'Partes  y  Piezas de  Repuesto', 1, 0, 0, 0, 1, 0),
(13, 1, 187, 'Utiles y Herramientas', 1, 0, 0, 0, 1, 0),
(14, 1, 188, 'Produccion Terminada', 1, 0, 0, 0, 1, 0),
(15, 1, 189, 'Mercancias para la Venta', 1, 0, 0, 0, 1, 0),
(16, 1, 190, 'Medicamentos', 1, 0, 0, 0, 1, 0),
(17, 1, 193, 'Alimentos', 1, 0, 0, 0, 1, 0),
(18, 2, 216, 'Efectos por Cobrar a Largo Plazo', 1, 0, 1, 0, 1, 0),
(19, 2, 220, 'Cuentas por Cobrar a Largo Plazo', 1, 0, 1, 0, 1, 0),
(20, 2, 225, 'Prestamos Concedidos a Largo Plazo', 1, 0, 1, 0, 1, 0),
(21, 2, 227, 'Inversiones a Largo Plazo', 1, 0, 0, 0, 1, 0),
(22, 3, 240, 'Activos Fijos', 1, 0, 0, 0, 1, 0),
(23, 3, 255, 'Activos Fijos Intangibles', 1, 0, 0, 0, 1, 0),
(24, 3, 265, 'Inversiones en Proceso', 1, 0, 0, 0, 1, 0),
(25, 3, 290, 'Compra de Activos Fijos', 1, 0, 1, 0, 1, 0),
(26, 3, 292, 'Compra de Activos Fijos Intangibles', 1, 0, 1, 0, 1, 0),
(27, 4, 300, 'Gastos de Produccion y Servicios Diferidos', 1, 0, 0, 0, 1, 0),
(28, 4, 306, 'Gastos Financieros Diferidos', 1, 0, 0, 0, 1, 0),
(29, 5, 330, 'Perdida en Investigacion', 1, 0, 0, 0, 1, 0),
(30, 5, 332, 'Faltantes de Bienes', 1, 0, 0, 0, 1, 0),
(31, 2, 335, 'Cuentas por Cobrar Diversas', 1, 0, 1, 0, 1, 0),
(32, 6, 373, 'Desgaste de Utiles y Herramientas', 0, 0, 0, 0, 1, 0),
(33, 6, 375, 'Depreciacion de Activos Fijos Tangibles', 0, 0, 0, 0, 1, 0),
(34, 6, 390, 'Amortizacion de Activos Fijos Intangibles', 0, 0, 0, 0, 1, 0),
(35, 7, 401, 'Efectos por pagar a Corto Plazo', 0, 0, 0, 1, 1, 0),
(36, 7, 405, 'Cuentas por pagar a Corto Plazo', 0, 0, 0, 1, 1, 0),
(37, 7, 421, 'Cuentas por Pagar - Activos Fijos', 0, 0, 0, 1, 1, 0),
(38, 7, 425, 'Cuentas por Pagar del Proceso Inversionista', 0, 0, 0, 1, 1, 0),
(39, 7, 430, 'Cobros Anticipados', 0, 0, 0, 1, 1, 0),
(40, 7, 435, 'Depositos Recibidos', 0, 0, 0, 1, 1, 0),
(41, 7, 440, 'Obligacion con el Estado', 0, 0, 0, 1, 1, 0),
(42, 7, 455, 'Nominas por Pagar', 0, 0, 0, 1, 1, 0),
(43, 7, 470, 'Prestamos Recibidos', 0, 0, 0, 1, 1, 0),
(44, 7, 492, 'Provision para Vacaciones', 0, 0, 0, 0, 1, 0),
(45, 8, 510, 'Efectos por pagar a largo plazo', 0, 0, 0, 1, 1, 0),
(46, 8, 515, 'Cuentas por Pagar a Largo Plazo', 0, 0, 0, 1, 1, 0),
(47, 8, 520, 'Prestamos Recibidos a Largo Plazo', 0, 0, 0, 1, 1, 0),
(48, 8, 540, 'Bonos por Pagar', 0, 0, 0, 1, 1, 0),
(49, 9, 545, 'Ingresos Diferidos', 0, 0, 0, 0, 1, 0),
(50, 10, 555, 'Sobrantes en Investigacion', 0, 0, 0, 0, 1, 0),
(51, 10, 565, 'Cuentas por Pagar Diversas', 0, 0, 0, 0, 1, 0),
(52, 10, 569, 'Cuentas por Pagar Compra de Monedas', 0, 0, 0, 0, 1, 0),
(53, 10, 570, 'Ingresos de Periodos Futuros', 0, 0, 0, 0, 1, 0),
(54, 11, 600, 'Capital Contable', 0, 0, 0, 0, 1, 0),
(55, 11, 605, 'Acciones por Emitir', 1, 0, 0, 0, 1, 0),
(56, 11, 608, 'Acciones Suscritas', 0, 0, 0, 0, 1, 0),
(57, 11, 615, 'Revalorizacion de Activos Fijos Tangibles', 1, 0, 0, 0, 1, 0),
(58, 11, 620, 'Donaciones Recibidas', 0, 0, 0, 0, 1, 0),
(59, 11, 630, 'Utilidades Retenidas', 0, 0, 0, 0, 1, 0),
(60, 11, 640, 'Perdidas', 1, 0, 0, 0, 1, 0),
(61, 11, 696, 'Operaciones entre Dependencias Activos', 1, 0, 0, 0, 1, 0),
(62, 11, 697, 'Operaciones entre Dependencia Pasivo', 0, 0, 0, 0, 1, 0),
(63, 2, 700, 'Producciones en Proceso', 1, 0, 0, 0, 1, 1),
(64, 12, 730, 'Reparaciones Capitales con Medios Propios', 1, 0, 0, 0, 1, 0),
(65, 13, 800, 'Devoluciones en Ventas', 1, 0, 0, 0, 1, 0),
(66, 13, 806, 'Impuestos por las Ventas', 1, 0, 0, 0, 1, 0),
(67, 13, 810, 'Costo de Ventas de Produccion', 1, 0, 0, 0, 1, 0),
(68, 13, 815, 'Costo de Ventas de Mercancias', 1, 0, 0, 0, 1, 0),
(69, 13, 823, 'Gastos de Administracion', 1, 0, 0, 0, 1, 0),
(70, 13, 819, 'Gastos de Distribucion y Ventas', 1, 0, 0, 0, 1, 0),
(71, 13, 839, 'Gastos por Perdidas en Tasas de Cambio', 1, 0, 0, 0, 1, 0),
(72, 13, 845, 'Gastos por Perdidas', 1, 0, 0, 0, 1, 0),
(73, 13, 850, 'Gastos por Faltantes', 1, 0, 0, 0, 1, 0),
(74, 13, 855, 'Otros Impuestos y Contribuciones', 1, 0, 0, 0, 1, 0),
(75, 14, 901, 'Ventas de Mercancias', 0, 0, 0, 0, 1, 0),
(76, 14, 900, 'Ventas de Produccion', 0, 0, 0, 0, 1, 0),
(77, 14, 920, 'Ingresos Financieros', 0, 0, 0, 0, 1, 0),
(78, 14, 924, 'Ingresos por Variacion de Tasas de Cambio', 0, 0, 0, 0, 1, 0),
(79, 14, 930, 'Ingresos por Sobrantes de Bienes', 0, 0, 0, 0, 1, 0),
(80, 14, 950, 'Otros Ingresos', 0, 0, 0, 0, 1, 0),
(81, 14, 953, 'Ingresos por Donaciones Recibidas', 0, 0, 0, 0, 1, 0),
(82, 15, 999, 'Resultados', 0, 1, 0, 0, 1, 0),
(83, 14, 903, 'Venta de Servicios Prestados', 0, 0, 0, 0, 1, 0),
(84, 13, 816, 'Costo de Venta de Servicios Prestados', 1, 0, 0, 0, 1, 0),
(85, 11, 646, 'Reservas para Inversiones', 0, 0, 0, 0, 1, 0),
(86, 8, 526, 'Obligaciones a Largo Plazo', 0, 0, 0, 1, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas_cliente`
--

CREATE TABLE `cuentas_cliente` (
  `id` int(11) NOT NULL,
  `id_moneda_id` int(11) NOT NULL,
  `id_cliente_id` int(11) NOT NULL,
  `nro_cuenta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `id_banco_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas_unidad`
--

CREATE TABLE `cuentas_unidad` (
  `id` int(11) NOT NULL,
  `id_banco_id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `id_moneda_id` int(11) NOT NULL,
  `nro_cuenta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta_criterio_analisis`
--

CREATE TABLE `cuenta_criterio_analisis` (
  `id` int(11) NOT NULL,
  `id_cuenta_id` int(11) NOT NULL,
  `id_criterio_analisis_id` int(11) NOT NULL,
  `orden` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cuenta_criterio_analisis`
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
(156, 69, 5, 2),
(160, 22, 12, 2),
(161, 22, 3, 3),
(162, 86, 6, 1),
(164, 42, 8, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_user`
--

CREATE TABLE `custom_user` (
  `id` int(11) NOT NULL,
  `id_user_id` int(11) NOT NULL,
  `nombre_completo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `depreciacion`
--

CREATE TABLE `depreciacion` (
  `id` int(11) NOT NULL,
  `unidad_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `anno` int(11) NOT NULL,
  `fundamentacion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `depreciacion`
--

INSERT INTO `depreciacion` (`id`, `unidad_id`, `fecha`, `anno`, `fundamentacion`, `total`) VALUES
(1, 1, '2021-02-17', 2021, 'Depreciacion del mes de Febrero', 311.66);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devolucion`
--

CREATE TABLE `devolucion` (
  `id` int(11) NOT NULL,
  `id_documento_id` int(11) DEFAULT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `id_almacen_id` int(11) NOT NULL,
  `id_centro_costo_id` int(11) DEFAULT NULL,
  `id_elemento_gasto_id` int(11) DEFAULT NULL,
  `id_orden_tabajo_id` int(11) DEFAULT NULL,
  `nro_cuenta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_subcuenta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anno` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `nro_concecutivo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210204142319', '2021-02-04 15:23:42', 287611),
('DoctrineMigrations\\Version20210213195449', '2021-02-13 20:55:26', 14494),
('DoctrineMigrations\\Version20210216162705', '2021-02-23 20:14:06', 933),
('DoctrineMigrations\\Version20210223191444', '2021-02-23 20:14:50', 4698),
('DoctrineMigrations\\Version20210226130819', '2021-02-26 14:08:52', 9357),
('DoctrineMigrations\\Version20210226202455', '2021-02-26 21:25:05', 7086),
('DoctrineMigrations\\Version20210301141756', '2021-03-01 15:19:10', 2737),
('DoctrineMigrations\\Version20210301233426', '2021-03-02 00:34:33', 9985),
('DoctrineMigrations\\Version20210302000005', '2021-03-02 01:00:51', 27427),
('DoctrineMigrations\\Version20210304144308', '2021-03-04 15:43:53', 1599),
('DoctrineMigrations\\Version20210304144455', '2021-03-04 15:45:02', 709),
('DoctrineMigrations\\Version20210305033758', '2021-03-05 04:38:59', 1789),
('DoctrineMigrations\\Version20210310134051', '2021-03-10 14:41:09', 1063),
('DoctrineMigrations\\Version20210310134450', '2021-03-10 14:44:59', 2005),
('DoctrineMigrations\\Version20210310153948', '2021-03-10 16:40:07', 3035),
('DoctrineMigrations\\Version20210310192136', '2021-03-10 20:24:47', 1387),
('DoctrineMigrations\\Version20210312130336', '2021-03-12 14:03:55', 3568),
('DoctrineMigrations\\Version20210312134928', '2021-03-12 14:49:52', 344);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento`
--

CREATE TABLE `documento` (
  `id` int(11) NOT NULL,
  `id_almacen_id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `id_moneda_id` int(11) NOT NULL,
  `id_tipo_documento_id` int(11) DEFAULT NULL,
  `id_documento_cancelado_id` int(11) DEFAULT NULL,
  `importe_total` double NOT NULL,
  `fecha` date NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `anno` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `documento`
--

INSERT INTO `documento` (`id`, `id_almacen_id`, `id_unidad_id`, `id_moneda_id`, `id_tipo_documento_id`, `id_documento_cancelado_id`, `importe_total`, `fecha`, `activo`, `anno`) VALUES
(2, 1, 1, 1, 12, NULL, 23000, '2021-02-13', 1, 2021),
(3, 2, 1, 1, 12, NULL, 3000, '2021-02-13', 1, 2021),
(8, 3, 1, 1, 13, NULL, 3000, '2021-02-13', 1, 2021),
(9, 1, 1, 1, 1, NULL, 33000, '2021-02-14', 1, 2021),
(10, 1, 1, 1, 1, NULL, 6500, '2021-02-14', 1, 2021),
(11, 1, 1, 1, 7, NULL, 3250, '2021-02-14', 1, 2021),
(12, 3, 1, 1, 2, NULL, 3250, '2021-02-14', 1, 2021),
(13, 2, 1, 1, 1, NULL, 25000, '2021-02-14', 1, 2021),
(14, 2, 1, 1, 10, NULL, 10000, '2021-02-15', 1, 2021),
(15, 3, 1, 1, 10, NULL, 1625, '2021-02-15', 1, 2021),
(16, 3, 1, 1, 4, NULL, 3000, '2021-02-17', 1, 2021),
(17, 2, 1, 1, 3, NULL, 3000, '2021-02-16', 1, 2021);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `elementos_visa`
--

CREATE TABLE `elementos_visa` (
  `id` int(11) NOT NULL,
  `id_proveedor_id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `costo` double NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_servicio_id` int(11) DEFAULT NULL,
  `id_unidad_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `elementos_visa`
--

INSERT INTO `elementos_visa` (`id`, `id_proveedor_id`, `descripcion`, `costo`, `activo`, `codigo`, `id_servicio_id`, `id_unidad_id`) VALUES
(1, 1, 'Documentos migratorios', 100, 1, '0010', NULL, NULL),
(2, 4, 'Sellos de Consulado', 50, 1, '0020', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `elemento_gasto`
--

CREATE TABLE `elemento_gasto` (
  `id` int(11) NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `elemento_gasto`
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
-- Estructura de tabla para la tabla `empleado`
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
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id`, `id_unidad_id`, `id_cargo_id`, `id_usuario_id`, `nombre`, `correo`, `fecha_alta`, `baja`, `fecha_baja`, `direccion_particular`, `telefono`, `rol`, `activo`, `identificacion`, `sueldo_bruto_mensual`, `salario_x_hora`) VALUES
(6, 1, 1, 1, 'Anibal Valdes Llende', 'anibal@solyag.com', '2020-11-01', 0, NULL, 'Calle 2da', '55816826', 'ROLE_ADMIN', 1, '89102815009', 65000, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_solicitudes`
--

CREATE TABLE `estado_solicitudes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expediente`
--

CREATE TABLE `expediente` (
  `id` int(11) NOT NULL,
  `id_unidad_id` int(11) DEFAULT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `anno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id` int(11) NOT NULL,
  `id_contrato_id` int(11) DEFAULT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `id_usuario_id` int(11) NOT NULL,
  `id_centro_costo_id` int(11) DEFAULT NULL,
  `id_orden_trabajo_id` int(11) DEFAULT NULL,
  `id_elemento_gasto_id` int(11) DEFAULT NULL,
  `id_expediente_id` int(11) DEFAULT NULL,
  `id_categoria_cliente_id` int(11) DEFAULT NULL,
  `id_termino_pago_id` int(11) DEFAULT NULL,
  `id_moneda_id` int(11) DEFAULT NULL,
  `id_factura_cancela_id` int(11) DEFAULT NULL,
  `fecha_factura` date NOT NULL,
  `tipo_cliente` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `nro_factura` int(11) NOT NULL,
  `anno` int(11) NOT NULL,
  `cuenta_obligacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subcuenta_obligacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL,
  `importe` double NOT NULL,
  `contabilizada` tinyint(1) DEFAULT NULL,
  `ncf` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelada` tinyint(1) DEFAULT NULL,
  `motivo_cancelacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `servicio` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`id`, `id_contrato_id`, `id_unidad_id`, `id_usuario_id`, `id_centro_costo_id`, `id_orden_trabajo_id`, `id_elemento_gasto_id`, `id_expediente_id`, `id_categoria_cliente_id`, `id_termino_pago_id`, `id_moneda_id`, `id_factura_cancela_id`, `fecha_factura`, `tipo_cliente`, `id_cliente`, `nro_factura`, `anno`, `cuenta_obligacion`, `subcuenta_obligacion`, `activo`, `importe`, `contabilizada`, `ncf`, `cancelada`, `motivo_cancelacion`, `servicio`) VALUES
(1, NULL, 1, 1, NULL, NULL, NULL, NULL, 2, 4, 1, NULL, '2021-02-15', 3, 1, 1, 2021, '135', '0030', 1, 16535, 1, 'B0200000001', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_comprobante`
--

CREATE TABLE `facturas_comprobante` (
  `id` int(11) NOT NULL,
  `id_factura_id` int(11) NOT NULL,
  `id_comprobante_id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `anno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `facturas_comprobante`
--

INSERT INTO `facturas_comprobante` (`id`, `id_factura_id`, `id_comprobante_id`, `id_unidad_id`, `anno`) VALUES
(1, 1, 9, 1, 2021);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_documento`
--

CREATE TABLE `factura_documento` (
  `id` int(11) NOT NULL,
  `id_factura_id` int(11) NOT NULL,
  `id_documento_id` int(11) NOT NULL,
  `id_movimiento_venta_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `factura_documento`
--

INSERT INTO `factura_documento` (`id`, `id_factura_id`, `id_documento_id`, `id_movimiento_venta_id`) VALUES
(1, 1, 14, NULL),
(2, 1, 15, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_imposdom`
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
-- Estructura de tabla para la tabla `factura_no_contable`
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
-- Estructura de tabla para la tabla `grupo_activos`
--

CREATE TABLE `grupo_activos` (
  `id` int(11) NOT NULL,
  `porciento_deprecia_anno` double NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `grupo_activos`
--

INSERT INTO `grupo_activos` (`id`, `porciento_deprecia_anno`, `descripcion`, `activo`, `codigo`) VALUES
(1, 10, 'Depreciación 10% anual', 1, '0010'),
(2, 5, 'Depreciación 5% anual', 1, '0020'),
(3, 0, 'Activos Fijos que no deprecian', 1, '0030');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hotel_destino`
--

CREATE TABLE `hotel_destino` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hotel_origen`
--

CREATE TABLE `hotel_origen` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impuesto`
--

CREATE TABLE `impuesto` (
  `id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` double NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `impuesto`
--

INSERT INTO `impuesto` (`id`, `id_unidad_id`, `nombre`, `valor`, `activo`) VALUES
(1, 1, 'Impuesto del 21%', 21, 1),
(2, 1, 's', 2, 0),
(3, 1, 'Impuesto del 30%', 30, 1),
(4, 1, 'Impuesto del 15%', 15, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impuesto_sobre_renta`
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informe_recepcion`
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
-- Volcado de datos para la tabla `informe_recepcion`
--

INSERT INTO `informe_recepcion` (`id`, `id_documento_id`, `id_proveedor_id`, `nro_cuenta_inventario`, `nro_subcuenta_inventario`, `nro_cuenta_acreedora`, `nro_subcuenta_acreedora`, `nro_concecutivo`, `anno`, `codigo_factura`, `fecha_factura`, `activo`, `producto`) VALUES
(1, 9, 3, '', '', '405', '0010', '1', 2021, '2515', '2021-02-01', 1, 0),
(2, 10, 2, '', '', '405', '0010', '2', 2021, '1814', '2021-02-11', 1, 0),
(3, 12, NULL, '', '', '700', '0050', '1', 2021, NULL, NULL, 1, 1),
(4, 13, 4, '', '', '405', '0010', '1', 2021, '025', '2021-02-05', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instrumento_cobro`
--

CREATE TABLE `instrumento_cobro` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `instrumento_cobro`
--

INSERT INTO `instrumento_cobro` (`id`, `nombre`, `activo`) VALUES
(1, 'Cheque', 1),
(2, 'Transferencia', 1),
(3, 'Efectivo', 1),
(4, 'aaa', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lugares`
--

CREATE TABLE `lugares` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `habilitado` tinyint(1) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `zona_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `lugares`
--

INSERT INTO `lugares` (`id`, `nombre`, `habilitado`, `activo`, `zona_id`) VALUES
(1, 'dsdsdsds', 1, 1, 1),
(2, 'sasasas', 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mercancia`
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
-- Volcado de datos para la tabla `mercancia`
--

INSERT INTO `mercancia` (`id`, `id_amlacen_id`, `id_unidad_medida_id`, `codigo`, `cuenta`, `descripcion`, `existencia`, `importe`, `activo`, `nro_subcuenta_inventario`, `nro_cuenta_acreedora`, `nro_subcuenta_acreedora`) VALUES
(2, 1, 13, '104612', '183', 'Detergente', 150, 28000, 1, '0010', '600', '0040'),
(3, 1, 13, '104651', '183', 'Jabon', 100, 5000, 1, '0010', '600', '0040'),
(4, 1, 13, '107523', '183', 'Shampu', 100, 8000, 1, '0010', '600', '0040'),
(5, 2, 13, '2013151', '189', 'Split', 10, 3000, 1, '0040', '600', '0040'),
(6, 1, 13, '107524', '183', 'Shampu', 250, 15000, 1, '0010', '405', '0010'),
(7, 1, 8, '107013', '183', 'Arroz', 100, 1000, 1, '0020', '405', '0010'),
(8, 1, 13, '107018', '183', 'Aceite', 50, 750, 1, '0020', '405', '0010'),
(9, 1, 13, '107114', '183', 'Jamon', 50, 1500, 1, '0020', '405', '0010'),
(10, 2, 13, '2013156', '189', 'Split 2.0 t', 30, 15000, 1, '0040', '405', '0010'),
(11, 2, 13, 'ap-00', '189', 'Split de 1.0 t', 10, 3000, 1, '0040', '696', '0099');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mercancia_producto`
--

CREATE TABLE `mercancia_producto` (
  `id` int(11) NOT NULL,
  `id_mercancia_id` int(11) NOT NULL,
  `id_producto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

CREATE TABLE `modulo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moneda`
--

CREATE TABLE `moneda` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `moneda`
--

INSERT INTO `moneda` (`id`, `nombre`, `activo`) VALUES
(1, 'USD', 1),
(2, 'EUR', 1),
(3, 'RD$', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moneda_pais`
--

CREATE TABLE `moneda_pais` (
  `id` int(11) NOT NULL,
  `id_pais` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_moneda` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `moneda_pais`
--

INSERT INTO `moneda_pais` (`id`, `id_pais`, `id_moneda`, `status`) VALUES
(1, '1', '2', '1'),
(2, '1', '1', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento`
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
-- Estructura de tabla para la tabla `movimiento_activo_fijo`
--

CREATE TABLE `movimiento_activo_fijo` (
  `id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `id_activo_fijo_id` int(11) NOT NULL,
  `id_tipo_movimiento_id` int(11) NOT NULL,
  `id_cuenta_id` int(11) NOT NULL,
  `id_subcuenta_id` int(11) NOT NULL,
  `id_usuario_id` int(11) NOT NULL,
  `id_unidad_destino_origen_id` int(11) DEFAULT NULL,
  `id_proveedor_id` int(11) DEFAULT NULL,
  `id_movimiento_cancelado_id` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `fundamentacion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entrada` tinyint(1) NOT NULL,
  `nro_consecutivo` int(11) NOT NULL,
  `anno` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `id_tipo_cliente` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `cancelado` tinyint(1) DEFAULT NULL,
  `fecha_factura` date DEFAULT NULL,
  `nro_factura` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `movimiento_activo_fijo`
--

INSERT INTO `movimiento_activo_fijo` (`id`, `id_unidad_id`, `id_activo_fijo_id`, `id_tipo_movimiento_id`, `id_cuenta_id`, `id_subcuenta_id`, `id_usuario_id`, `id_unidad_destino_origen_id`, `id_proveedor_id`, `id_movimiento_cancelado_id`, `fecha`, `fundamentacion`, `entrada`, `nro_consecutivo`, `anno`, `activo`, `id_tipo_cliente`, `id_cliente`, `cancelado`, `fecha_factura`, `nro_factura`) VALUES
(1, 1, 1, 1, 22, 138, 1, NULL, NULL, NULL, '2021-02-13', 'Apertura del NEGOCIO', 1, 1, 2021, 1, NULL, NULL, NULL, NULL, NULL),
(2, 1, 2, 1, 22, 138, 1, NULL, NULL, NULL, '2021-02-13', 'Contabilizando apertura de activos fijos', 1, 2, 2021, 1, NULL, NULL, NULL, NULL, NULL),
(3, 1, 3, 1, 22, 138, 1, NULL, NULL, NULL, '2021-02-13', 'Contabilizando apertura de activos fijos', 1, 3, 2021, 1, NULL, NULL, NULL, NULL, NULL),
(4, 1, 4, 2, 22, 138, 1, NULL, 4, NULL, '2021-02-13', 'Compra de Computadora', 1, 1, 2021, 1, NULL, NULL, NULL, '2021-02-03', '325'),
(5, 1, 5, 2, 22, 138, 1, NULL, 1, NULL, '2021-02-10', 'Comprea de auto', 1, 2, 2021, 1, NULL, NULL, NULL, '2021-02-12', '12354'),
(6, 1, 6, 2, 22, 138, 1, NULL, 2, NULL, '2021-02-20', 'compra de activo fijo', 1, 3, 2021, 1, NULL, NULL, NULL, '2021-02-12', '255');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento_mercancia`
--

CREATE TABLE `movimiento_mercancia` (
  `id` int(11) NOT NULL,
  `id_mercancia_id` int(11) NOT NULL,
  `id_documento_id` int(11) NOT NULL,
  `id_tipo_documento_id` int(11) NOT NULL,
  `id_usuario_id` int(11) DEFAULT NULL,
  `id_centro_costo_id` int(11) DEFAULT NULL,
  `id_elemento_gasto_id` int(11) DEFAULT NULL,
  `id_almacen_id` int(11) DEFAULT NULL,
  `id_expediente_id` int(11) DEFAULT NULL,
  `id_orden_trabajo_id` int(11) DEFAULT NULL,
  `id_factura_id` int(11) DEFAULT NULL,
  `id_movimiento_cancelado_id` int(11) DEFAULT NULL,
  `cantidad` double NOT NULL,
  `importe` double NOT NULL,
  `existencia` double NOT NULL,
  `fecha` date NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `entrada` tinyint(1) NOT NULL,
  `cuenta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nro_subcuenta_deudora` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `movimiento_mercancia`
--

INSERT INTO `movimiento_mercancia` (`id`, `id_mercancia_id`, `id_documento_id`, `id_tipo_documento_id`, `id_usuario_id`, `id_centro_costo_id`, `id_elemento_gasto_id`, `id_almacen_id`, `id_expediente_id`, `id_orden_trabajo_id`, `id_factura_id`, `id_movimiento_cancelado_id`, `cantidad`, `importe`, `existencia`, `fecha`, `activo`, `entrada`, `cuenta`, `nro_subcuenta_deudora`) VALUES
(2, 2, 2, 12, 1, 25, NULL, 1, NULL, NULL, NULL, NULL, 50, 10000, 50, '2021-02-13', 1, 1, NULL, NULL),
(3, 3, 2, 12, 1, 25, NULL, 1, NULL, NULL, NULL, NULL, 100, 5000, 100, '2021-02-13', 1, 1, NULL, NULL),
(4, 4, 2, 12, 1, 25, NULL, 1, NULL, NULL, NULL, NULL, 100, 8000, 100, '2021-02-13', 1, 1, NULL, NULL),
(5, 5, 3, 12, 1, 25, NULL, 2, NULL, NULL, NULL, NULL, 10, 3000, 10, '2021-02-13', 1, 1, NULL, NULL),
(7, 2, 9, 1, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, 100, 18000, 150, '2021-02-14', 1, 1, NULL, NULL),
(8, 6, 9, 1, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, 250, 15000, 250, '2021-02-14', 1, 1, NULL, NULL),
(9, 7, 10, 1, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, 200, 2000, 200, '2021-02-14', 1, 1, NULL, NULL),
(10, 8, 10, 1, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, 100, 1500, 100, '2021-02-14', 1, 1, NULL, NULL),
(11, 9, 10, 1, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, 100, 3000, 100, '2021-02-14', 1, 1, NULL, NULL),
(12, 7, 11, 7, 1, 24, 3, 1, NULL, 1, NULL, NULL, 100, 1000, 100, '2021-02-14', 1, 0, NULL, NULL),
(13, 8, 11, 7, 1, 24, 3, 1, NULL, 1, NULL, NULL, 50, 750, 50, '2021-02-14', 1, 0, NULL, NULL),
(14, 9, 11, 7, 1, 24, 3, 1, NULL, 1, NULL, NULL, 50, 1500, 50, '2021-02-14', 1, 0, NULL, NULL),
(15, 10, 13, 1, 1, NULL, NULL, 2, NULL, NULL, NULL, NULL, 50, 25000, 50, '2021-02-14', 1, 1, NULL, NULL),
(16, 10, 14, 10, 1, NULL, NULL, 2, NULL, NULL, 1, NULL, 20, 10000, 30, '2021-02-15', 1, 0, '815', '0040'),
(17, 11, 17, 3, 1, NULL, NULL, 2, NULL, NULL, NULL, NULL, 10, 3000, 10, '2021-02-16', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento_producto`
--

CREATE TABLE `movimiento_producto` (
  `id` int(11) NOT NULL,
  `id_producto_id` int(11) NOT NULL,
  `id_documento_id` int(11) NOT NULL,
  `id_tipo_documento_id` int(11) NOT NULL,
  `id_usuario_id` int(11) DEFAULT NULL,
  `id_centro_costo_id` int(11) DEFAULT NULL,
  `id_elemento_gasto_id` int(11) DEFAULT NULL,
  `id_almacen_id` int(11) DEFAULT NULL,
  `id_orden_trabajo_id` int(11) DEFAULT NULL,
  `id_expediente_id` int(11) DEFAULT NULL,
  `id_factura_id` int(11) DEFAULT NULL,
  `id_movimiento_cancelado_id` int(11) DEFAULT NULL,
  `cantidad` double NOT NULL,
  `importe` double NOT NULL,
  `existencia` double NOT NULL,
  `fecha` date NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `entrada` tinyint(1) NOT NULL,
  `cuenta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nro_subcuenta_deudora` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `movimiento_producto`
--

INSERT INTO `movimiento_producto` (`id`, `id_producto_id`, `id_documento_id`, `id_tipo_documento_id`, `id_usuario_id`, `id_centro_costo_id`, `id_elemento_gasto_id`, `id_almacen_id`, `id_orden_trabajo_id`, `id_expediente_id`, `id_factura_id`, `id_movimiento_cancelado_id`, `cantidad`, `importe`, `existencia`, `fecha`, `activo`, `entrada`, `cuenta`, `nro_subcuenta_deudora`) VALUES
(4, 4, 8, 13, 1, 25, NULL, 3, NULL, NULL, NULL, NULL, 10, 3000, 10, '2021-02-13', 1, 1, NULL, NULL),
(5, 5, 12, 2, 1, 24, NULL, 3, 1, NULL, NULL, NULL, 50, 3250, 50, '2021-02-14', 1, 1, NULL, NULL),
(6, 5, 15, 10, 1, NULL, NULL, 3, NULL, NULL, 1, NULL, 25, 1625, 25, '2021-02-15', 1, 0, '810', '0170'),
(7, 4, 16, 4, 1, NULL, NULL, 3, NULL, NULL, NULL, NULL, 10, 3000, 0, '2021-02-17', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento_servicio`
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
-- Estructura de tabla para la tabla `movimiento_venta`
--

CREATE TABLE `movimiento_venta` (
  `id` int(11) NOT NULL,
  `id_factura_id` int(11) NOT NULL,
  `id_almacen_id` int(11) NOT NULL,
  `id_centro_costo_acreedor_id` int(11) DEFAULT NULL,
  `id_orden_trabajo_acreedor_id` int(11) DEFAULT NULL,
  `id_elemento_gasto_acreedor_id` int(11) DEFAULT NULL,
  `id_expediente_acreedor_id` int(11) DEFAULT NULL,
  `mercancia` tinyint(1) NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` double NOT NULL,
  `precio` double NOT NULL,
  `descuento_recarga` double DEFAULT NULL,
  `existencia` double DEFAULT NULL,
  `activo` tinyint(1) NOT NULL,
  `cuenta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_subcuenta_deudora` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `costo` double DEFAULT NULL,
  `anno` int(11) DEFAULT NULL,
  `cuenta_nominal_acreedora` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subcuenta_nominal_acreedora` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_mercancia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `movimiento_venta`
--

INSERT INTO `movimiento_venta` (`id`, `id_factura_id`, `id_almacen_id`, `id_centro_costo_acreedor_id`, `id_orden_trabajo_acreedor_id`, `id_elemento_gasto_acreedor_id`, `id_expediente_acreedor_id`, `mercancia`, `codigo`, `cantidad`, `precio`, `descuento_recarga`, `existencia`, `activo`, `cuenta`, `nro_subcuenta_deudora`, `costo`, `anno`, `cuenta_nominal_acreedora`, `subcuenta_nominal_acreedora`, `descripcion`, `id_mercancia`) VALUES
(1, 1, 2, NULL, NULL, NULL, NULL, 1, '2013156', 20, 700, 20, 30, 1, '815', '0040', 500, 2021, '901', '0040', 'Venta de Split', 10),
(2, 1, 3, NULL, NULL, NULL, NULL, 0, 'OT-01', 25, 100, 15, 25, 1, '810', '0170', 65, 2021, '900', '0170', 'Venta de Combo', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

CREATE TABLE `municipios` (
  `id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `municipios`
--

INSERT INTO `municipios` (`id`, `code`, `nombre`) VALUES
(2, 'Pinar del Rio', 'San Luis'),
(3, 'Pinar del Rio', 'Pinar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nominas_consecutivos`
--

CREATE TABLE `nominas_consecutivos` (
  `id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `mes` int(11) NOT NULL,
  `anno` int(11) NOT NULL,
  `nro_consecutivo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nomina_pago`
--

CREATE TABLE `nomina_pago` (
  `id` int(11) NOT NULL,
  `id_empleado_id` int(11) NOT NULL,
  `id_usuario_aprueba_id` int(11) DEFAULT NULL,
  `id_unidad_id` int(11) NOT NULL,
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
  `quincena` int(11) NOT NULL,
  `salario_bruto` double DEFAULT NULL,
  `cant_horas_trabajadas` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `nomina_pago`
--

INSERT INTO `nomina_pago` (`id`, `id_empleado_id`, `id_usuario_aprueba_id`, `id_unidad_id`, `comision`, `vacaciones`, `horas_extra`, `otros`, `total_ingresos`, `ingresos_cotizables_tss`, `isr`, `ars`, `afp`, `cooperativa`, `plan_medico_complementario`, `restaurant`, `total_deducido`, `sueldo_neto_pagar`, `afp_empleador`, `sfs_empleador`, `srl_empleador`, `infotep_empleador`, `mes`, `anno`, `fecha`, `elaborada`, `aprobada`, `quincena`, `salario_bruto`, `cant_horas_trabajadas`) VALUES
(1, 6, NULL, 1, NULL, NULL, NULL, NULL, 10833.33, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10833.33, NULL, NULL, NULL, NULL, 2, 2021, '2021-02-20', 1, 0, 4, 10833.33, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nomina_tercero_comprobante`
--

CREATE TABLE `nomina_tercero_comprobante` (
  `id` int(11) NOT NULL,
  `id_nomina_id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `id_comprobante_id` int(11) DEFAULT NULL,
  `mes` int(11) NOT NULL,
  `anno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obligacion_cobro`
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
-- Estructura de tabla para la tabla `obligacion_pago`
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
-- Estructura de tabla para la tabla `operaciones_comprobante_operaciones`
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
  `id_instrumento_cobro_id` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_tipo_cliente` int(11) DEFAULT NULL,
  `credito` double NOT NULL,
  `debito` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `operaciones_comprobante_operaciones`
--

INSERT INTO `operaciones_comprobante_operaciones` (`id`, `id_cuenta_id`, `id_subcuenta_id`, `id_centro_costo_id`, `id_orden_trabajo_id`, `id_elemento_gasto_id`, `id_expediente_id`, `id_proveedor_id`, `id_registro_comprobantes_id`, `id_almacen_id`, `id_unidad_id`, `id_instrumento_cobro_id`, `id_cliente`, `id_tipo_cliente`, `credito`, `debito`) VALUES
(1, 2, 133, NULL, NULL, NULL, NULL, NULL, 4, NULL, 1, NULL, NULL, NULL, 0, 2550000),
(2, 54, 40, NULL, NULL, NULL, NULL, NULL, 4, NULL, 1, NULL, NULL, NULL, 2550000, 0),
(3, 85, 136, NULL, NULL, NULL, NULL, NULL, 11, NULL, 1, NULL, NULL, NULL, 0, 25000),
(4, 54, 40, NULL, NULL, NULL, NULL, NULL, 11, NULL, 1, NULL, NULL, NULL, 25000, 0),
(5, 54, 40, NULL, NULL, NULL, NULL, NULL, 12, NULL, 1, NULL, NULL, NULL, 0, 25000),
(6, 85, 136, NULL, NULL, NULL, NULL, NULL, 12, NULL, 1, NULL, NULL, NULL, 25000, 0),
(7, 54, 40, NULL, NULL, NULL, NULL, NULL, 13, NULL, 1, NULL, NULL, NULL, 0, 25000),
(8, 85, 136, NULL, NULL, NULL, NULL, NULL, 13, NULL, 1, NULL, NULL, NULL, 25000, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_trabajo`
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
-- Volcado de datos para la tabla `orden_trabajo`
--

INSERT INTO `orden_trabajo` (`id`, `id_unidad_id`, `id_almacen_id`, `codigo`, `descripcion`, `activo`, `anno`) VALUES
(1, 1, 1, 'OT-01', 'Combo de Alimento', 1, 2021);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos_cotizacion`
--

CREATE TABLE `pagos_cotizacion` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `monto` double NOT NULL,
  `cambio` int(11) DEFAULT NULL,
  `id_cotizacion` int(11) NOT NULL,
  `id_moneda` int(11) NOT NULL,
  `id_tipo_de_pago` int(11) NOT NULL,
  `id_banco` int(11) DEFAULT NULL,
  `id_cuenta_bancaria` int(11) DEFAULT NULL,
  `numero_confirmacion_deposito` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last4_tarjeta` int(11) DEFAULT NULL,
  `codigo_confirmacion_tarjeta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_de_tarjeta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nota` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_transaccion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE `pais` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pais`
--

INSERT INTO `pais` (`id`, `nombre`, `activo`) VALUES
(1, 'Cuba', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodo_sistema`
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
-- Volcado de datos para la tabla `periodo_sistema`
--

INSERT INTO `periodo_sistema` (`id`, `id_unidad_id`, `id_almacen_id`, `id_usuario_id`, `mes`, `anno`, `tipo`, `fecha`, `cerrado`) VALUES
(1, 1, 1, 1, 2, 2021, 1, '2021-02-05', 0),
(2, 1, 2, 1, 2, 2021, 1, '2021-02-13', 0),
(3, 1, 3, 1, 2, 2021, 1, '2021-02-13', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plazos_pago_cotizacion`
--

CREATE TABLE `plazos_pago_cotizacion` (
  `id` int(11) NOT NULL,
  `id_cotizacion_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cuota` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `por_ciento_nominas`
--

CREATE TABLE `por_ciento_nominas` (
  `id` int(11) NOT NULL,
  `por_ciento` double NOT NULL,
  `criterio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `denominacion` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `por_ciento_nominas`
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
-- Estructura de tabla para la tabla `precio_venta`
--

CREATE TABLE `precio_venta` (
  `id` int(11) NOT NULL,
  `tramo` int(11) DEFAULT NULL,
  `poerciento` double DEFAULT NULL,
  `fijo` double DEFAULT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `precio_venta`
--

INSERT INTO `precio_venta` (`id`, `tramo`, `poerciento`, `fijo`, `activo`) VALUES
(1, 1, 0, 0, 1),
(2, 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
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
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `id_amlacen_id`, `id_unidad_medida_id`, `codigo`, `cuenta`, `descripcion`, `existencia`, `importe`, `activo`, `nro_subcuenta_inventario`, `nro_cuenta_acreedora`, `nro_subcuenta_acreedora`) VALUES
(4, 3, 13, 'AP-00', '188', 'Split de 1.0 t', 0, 0, 0, '0040', '600', '0040'),
(5, 3, 13, 'OT-01', '188', 'Combo de Alimentos', 25, 1625, 1, '0020', '700', '0050');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id`, `nombre`, `codigo`, `activo`) VALUES
(1, 'Empresa de Migración', '2021', 1),
(2, 'Comvinado Lacteo Pinar del Rio', '2022', 1),
(3, 'Fabrica de Productos de aseo Colombia', '2023', 1),
(4, 'Empresa de Soluciones  Electronicas', '2024', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincias`
--

CREATE TABLE `provincias` (
  `id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_pais` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `provincias`
--

INSERT INTO `provincias` (`id`, `code`, `nombre`, `id_pais`) VALUES
(1, 'Pinar del Rio', 'Pinar del Rio', 1),
(2, 'Habana', 'Habana', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rango_escala_dgii`
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_comprobantes`
--

CREATE TABLE `registro_comprobantes` (
  `id` int(11) NOT NULL,
  `id_unidad_id` int(11) NOT NULL,
  `id_tipo_comprobante_id` int(11) NOT NULL,
  `id_usuario_id` int(11) NOT NULL,
  `id_almacen_id` int(11) DEFAULT NULL,
  `id_instrumento_cobro_id` int(11) DEFAULT NULL,
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
-- Volcado de datos para la tabla `registro_comprobantes`
--

INSERT INTO `registro_comprobantes` (`id`, `id_unidad_id`, `id_tipo_comprobante_id`, `id_usuario_id`, `id_almacen_id`, `id_instrumento_cobro_id`, `nro_consecutivo`, `fecha`, `descripcion`, `debito`, `credito`, `anno`, `tipo`, `documento`) VALUES
(1, 1, 2, 1, 3, NULL, 1, '2021-02-14', 'Contabilizando comprobante de apertura del negocio', 3000, 3000, 2021, 1, NULL),
(2, 1, 2, 1, 1, NULL, 2, '2021-02-14', 'Contabilizndo  comprobante de apertura del negocio', 23000, 23000, 2021, 1, NULL),
(3, 1, 2, 1, 2, NULL, 3, '2021-02-14', 'Contabilizando comprobante de apertura del negocio', 3000, 3000, 2021, 1, NULL),
(4, 1, 1, 1, NULL, 3, 4, '2021-02-14', 'Creando efectivo en el momento de apertura de negocio', 2550000, 2550000, 2021, 3, '123'),
(5, 1, 2, 1, 1, NULL, 5, '2021-02-15', 'Contabilizando Movimientos de Inventarios del almacen de materias primas del dia 14', 42750, 42750, 2021, 1, NULL),
(6, 1, 2, 1, 3, NULL, 6, '2021-02-15', 'Contabilizando movimientos de Inventarios del almacen de productos terminados del dia 14 de febrero de 2021', 3250, 3250, 2021, 1, NULL),
(7, 1, 2, 1, 2, NULL, 7, '2021-02-15', 'Contabilizando movimientos de inventarios almacen de mercancias ', 25000, 25000, 2021, 1, NULL),
(8, 1, 2, 1, 2, NULL, 8, '2021-02-16', 'Contabilizando ostos de ventas', 10000, 10000, 2021, 1, NULL),
(9, 1, 2, 1, NULL, NULL, 9, '2021-02-17', 'Contabilizando factura de ventas', 16535, 16535, 2021, 2, NULL),
(10, 1, 2, 1, NULL, NULL, 9, '2021-02-17', 'Contabilizando movimientos de activos fijos', 51150, 51150, 2021, 5, NULL),
(11, 1, 2, 1, NULL, 1, 11, '2021-02-17', 'Creacion de Reservas Para Inversiones', 25000, 25000, 2021, 3, '123'),
(12, 1, 2, 1, NULL, 1, 12, '2021-02-17', 'revirtiendo comprobante', 25000, 25000, 2021, 3, '12'),
(13, 1, 2, 1, NULL, 1, 13, '2021-02-17', 'crenado reserva', 25000, 25000, 2021, 3, '255'),
(14, 1, 2, 1, NULL, NULL, 13, '2021-02-17', 'Contabilizando compra de activos', 11500, 11500, 2021, 5, NULL),
(15, 1, 2, 1, NULL, NULL, 14, '2021-02-17', 'Depreciación de activo fijo', 311.66, 311.66, 2021, 4, NULL),
(16, 1, 2, 1, 2, NULL, 16, '2021-02-17', 'vbbbb', 3000, 3000, 2021, 1, NULL),
(17, 1, 2, 1, 3, NULL, 17, '2021-02-18', 'nnnnnn', 4625, 4625, 2021, 1, NULL),
(18, 1, 2, 1, NULL, NULL, 17, '2021-02-18', 'nnm,,', 1000, 1000, 2021, 5, NULL),
(19, 1, 2, 1, NULL, NULL, 18, '2021-02-23', 'Pagando cotizacionCamilo Alberto', 100, 100, 2021, 8, NULL),
(20, 1, 2, 1, NULL, NULL, 19, '2021-02-23', 'Pagando cotizacionCamilo Alberto', 100, 100, 2021, 8, NULL),
(21, 1, 2, 1, NULL, NULL, 20, '2021-02-23', 'Pagando cotizacionCamilo Alberto', 530, 530, 2021, 8, NULL),
(22, 1, 2, 1, NULL, NULL, 21, '2021-02-23', 'Pagando cotización Camilo Alberto', 730, 730, 2021, 8, NULL),
(23, 1, 2, 1, NULL, NULL, 22, '2021-02-23', 'Pagando cotización Camilo Alberto', 100, 100, 2021, 8, NULL),
(24, 1, 2, 1, NULL, NULL, 23, '2021-02-23', 'Pagando cotización Camilo Alberto', 100, 100, 2021, 8, NULL),
(25, 1, 2, 1, NULL, NULL, 24, '2021-02-23', 'Pagando cotización Camilo Alberto', 100, 100, 2021, 8, NULL),
(26, 1, 2, 1, NULL, NULL, 25, '2021-02-23', 'Pagando cotización Camilo Alberto', 430, 430, 2021, 8, NULL),
(27, 1, 2, 1, NULL, NULL, 26, '2021-02-23', 'Pagando cotización Camilo Alberto', 730, 730, 2021, 8, NULL),
(28, 1, 2, 1, NULL, NULL, 27, '2021-02-23', 'Pagando cotización Camilo Alberto', 730, 730, 2021, 8, NULL),
(29, 1, 2, 1, NULL, NULL, 28, '2021-02-23', 'Pagando cotización Camilo Alberto', 730, 730, 2021, 8, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reglas_remesas`
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
-- Estructura de tabla para la tabla `rent_entrega`
--

CREATE TABLE `rent_entrega` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rent_recogida`
--

CREATE TABLE `rent_recogida` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte_efectivo`
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
-- Estructura de tabla para la tabla `reset_password_request`
--

CREATE TABLE `reset_password_request` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `saldo_cuentas`
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
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicios`
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
(11, 'Paquete Turístico Básico', '0110'),
(12, 'Desarrollo de Software', '0120'),
(13, 'Diseño', '0130'),
(14, 'Marketing y redes Sociales', '0140');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud`
--

CREATE TABLE `solicitud` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `primer_apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `segundo_apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono_fijo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_celular` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_unidad_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_turismo`
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
  `empleado_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urgente` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_turismo_comentario`
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
-- Estructura de tabla para la tabla `stripe_factura`
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
-- Estructura de tabla para la tabla `subcuenta`
--

CREATE TABLE `subcuenta` (
  `id` int(11) NOT NULL,
  `id_cuenta_id` int(11) NOT NULL,
  `nro_subcuenta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `elemento_gasto` tinyint(1) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deudora` tinyint(1) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `subcuenta`
--

INSERT INTO `subcuenta` (`id`, `id_cuenta_id`, `nro_subcuenta`, `elemento_gasto`, `descripcion`, `deudora`, `activo`) VALUES
(1, 1, '0001', 0, 'Efectivo', 1, 1),
(2, 13, '00001', 0, 'En Almacen', 1, 1),
(3, 13, '0002', 0, 'En Uso', 1, 1),
(4, 14, '0020', 0, 'Produccion', 1, 1),
(5, 14, '0030', 0, 'Ventas', 0, 1),
(6, 14, '0040', 0, 'Otros Aumentos', 1, 1),
(7, 14, '0050', 0, 'Otras Disminuciones', 0, 1),
(8, 24, '01', 0, 'Saldo de Inico', 1, 1),
(9, 24, '0010', 0, 'Construccion y Montaje', 1, 1),
(10, 24, '00020', 0, 'Equipos', 1, 1),
(11, 24, '00030', 0, 'Otros Gastos', 1, 1),
(12, 24, '0999', 0, 'Traspaso a Activos Fijos', 0, 1),
(13, 25, '0100', 0, 'Compras del Periodo', 1, 1),
(14, 25, '0300', 0, 'Adquisicion del Periodo por Donaciones', 1, 1),
(15, 25, '0999', 0, 'Traspaso a Activos Fijos Tangibles', 0, 1),
(16, 2, '001', 0, 'fkldjskfljdslkf', 1, 0),
(17, 9, '0001', 0, 'Impuesto sobre las ventas', 1, 1),
(18, 9, '0002', 0, 'Aranceles de Aduana', 1, 1),
(19, 9, '0004', 0, 'Impuesto sobre Utilidades', 1, 1),
(20, 26, '0100', 0, 'Compras del Periodo', 1, 1),
(21, 26, '0999', 0, 'Traspaso a activos fijos intangibles', 0, 1),
(22, 27, '0010', 0, 'Saldo al Incio', 1, 1),
(23, 27, '0020', 1, 'Gastos por Elementos del Periodo', 1, 1),
(24, 27, '0030', 0, 'Amortizacion de Gastos', 0, 1),
(25, 28, '0010', 0, 'Saldo al Inicio', 1, 1),
(26, 28, '0020', 0, 'Gastos del Periodo', 1, 1),
(27, 28, '0030', 0, 'Amortizacion de Gastos', 0, 1),
(28, 29, '0010', 0, 'Perdidas por Deterioros', 1, 1),
(29, 29, '0020', 0, 'Perdidas de Cuentas por Cobrar', 1, 1),
(30, 30, '0010', 0, 'Medios Monetarios', 1, 1),
(31, 30, '0020', 0, 'Medios  Materiales', 1, 1),
(32, 31, '0010', 0, 'Ventas a Entidades', 1, 1),
(33, 31, '0020', 0, 'Ventas a Trabajadores', 1, 1),
(34, 41, '0001', 0, 'Impuesto sobre Ventas', 0, 1),
(35, 41, '0003', 0, 'Aranceles de Aduana', 0, 1),
(36, 41, '0004', 0, 'Impuesto sobre Utilidades', 0, 1),
(37, 41, '0005', 0, 'Impuesto Sobre la Renta', 0, 1),
(38, 54, '0010', 0, 'Compra o Adquisición de Activos Fijos', 0, 1),
(39, 54, '0020', 0, 'Activos Fijos Intangibles', 0, 1),
(40, 54, '0030', 0, 'Recursos Monetarios', 0, 1),
(41, 54, '0040', 0, 'Recursos Materiales-Inventarios', 0, 1),
(42, 47, '0010', 0, 'Prestamos Recibidos de Entidades', 0, 1),
(43, 47, '0020', 0, 'Prestamos Recibidos de Bancos', 0, 1),
(44, 61, '0010', 0, 'Transferencias Recibidas de Unidades', 1, 1),
(45, 61, '0020', 0, 'Transferencias entre Almacenes', 1, 1),
(46, 61, '0099', 0, 'Operaciones de Ajustes en Inventarios', 1, 1),
(47, 62, '0010', 0, 'Transferencias entre Unidades', 0, 1),
(48, 62, '0020', 0, 'Transferencias de Inventarios entre almacenes', 0, 1),
(49, 62, '0099', 0, 'Operaciones de Ajustes de Inventarios', 0, 1),
(50, 63, '0010', 0, 'Saldo Inicio', 1, 1),
(51, 63, '0020', 1, 'Gastos del Periodo', 1, 1),
(52, 63, '0030', 0, 'Aumentos', 1, 1),
(53, 63, '0040', 0, 'Disminuciones', 0, 1),
(54, 63, '0050', 0, 'Traspaso a Produccion Terminada', 0, 1),
(55, 64, '0010', 0, 'Con Terceros', 1, 1),
(56, 64, '0020', 1, 'Con Medios Propios', 1, 1),
(57, 65, '0010', 0, 'Produccion', 1, 1),
(58, 65, '0020', 0, 'Mercancias', 1, 1),
(59, 15, '0010', 0, 'Recargas', 1, 1),
(60, 15, '0020', 0, 'Productos de Aseo y Perfumeria', 1, 1),
(61, 15, '0030', 0, 'Productos Alimenticios', 1, 1),
(62, 15, '0040', 0, 'Otros Productos', 1, 1),
(63, 36, '0010', 0, 'Proveedores Principales', 0, 1),
(64, 36, '0020', 0, 'Otros Proveedores', 0, 1),
(65, 10, '0010', 0, 'Materiales y Productos Aseo', 1, 1),
(66, 10, '0020', 0, 'Materiales y Produtos de Alimentos', 1, 1),
(67, 10, '0030', 0, 'Materiales y Productos de Medicamentos', 1, 1),
(68, 10, '0999', 0, 'Otros Materiales', 1, 1),
(69, 50, '0010', 0, 'Medios Monetarios', 0, 1),
(70, 50, '0020', 0, 'Recursos Materiales', 0, 1),
(71, 8, '0030', 0, 'Clientes Externos', 1, 1),
(72, 8, '0010', 0, 'Personas Naturales', 1, 1),
(73, 67, '0150', 0, 'Combo de Aseo', 1, 1),
(74, 67, '0170', 0, 'Combo de Alimentos', 1, 1),
(75, 67, '0160', 0, 'Combo de Medicamentos', 1, 1),
(76, 76, '0020', 0, 'Combo de Alimento', 1, 0),
(77, 76, '0010', 0, 'Combo de Aseo', 1, 0),
(78, 76, '0030', 0, 'Combo de Medicamentos', 1, 0),
(79, 76, '0150', 0, 'Combo de Aseo', 0, 1),
(80, 76, '0160', 0, 'Combo de Medicamento', 0, 1),
(81, 76, '0170', 0, 'Combo de Alimento', 0, 1),
(82, 75, '0010', 0, 'Recargas', 0, 1),
(83, 75, '0020', 0, 'Producción', 0, 1),
(84, 75, '0030', 0, 'Alimento', 0, 1),
(85, 75, '0040', 0, 'Otros Productos', 0, 1),
(86, 75, '0050', 0, 'Medicamentos', 0, 0),
(87, 68, '0010', 0, 'Recargas', 1, 1),
(88, 68, '0020', 0, 'Producción', 1, 1),
(89, 68, '0030', 0, 'Alimento', 1, 1),
(90, 68, '0040', 0, 'Otros Productos', 1, 1),
(91, 68, '0050', 0, 'Medicamentos', 1, 0),
(92, 66, '0010', 0, 'Mercancias', 1, 1),
(93, 66, '0020', 0, 'Produccion', 1, 1),
(94, 70, '0010', 0, '0010 Distribucion', 1, 0),
(95, 70, '0010', 1, 'Ventas', 1, 1),
(96, 70, '0020', 1, 'Distribucion', 1, 1),
(97, 69, '0010', 1, 'Agencia Horizontes', 1, 1),
(98, 83, '0010', 0, 'Venta de boletos de avion', 0, 0),
(99, 83, '0020', 0, 'Servicio de Remesas', 0, 0),
(100, 83, '0030', 0, 'Servicio de paqueteria', 0, 0),
(101, 84, '0010', 0, 'Costo de Venta de Boletos de Avion', 1, 0),
(102, 84, '0020', 0, 'Costo de Servicios de Remesa', 1, 0),
(103, 84, '0030', 0, 'Costo de Paqueteria', 1, 0),
(104, 8, '0020', 0, 'Clientes Internos', 1, 1),
(105, 84, '0010', 0, 'Recarga Cubacell', 1, 1),
(106, 84, '0020', 0, 'Recarga Nauta', 1, 1),
(107, 84, '0030', 0, 'Larga Distancia', 1, 1),
(108, 84, '0040', 0, 'Envio de Remesas', 1, 1),
(109, 84, '0050', 0, 'Boletos Aéreos', 1, 1),
(110, 84, '0060', 0, 'Renta de Hoteles', 1, 1),
(111, 84, '0070', 0, 'Renta de Autos', 1, 1),
(112, 84, '0080', 0, 'Excursiones', 1, 1),
(113, 84, '0090', 0, 'Envio de paquetes', 1, 1),
(114, 84, '0100', 0, 'Paquetes Turísticos', 1, 1),
(115, 84, '0110', 0, 'Trámites Migratorios', 1, 1),
(116, 84, '0120', 0, 'Desarrollo de Software', 1, 1),
(117, 84, '0130', 0, 'Diseño', 1, 1),
(118, 84, '0140', 0, 'Marketing y redes Sociales', 1, 1),
(119, 83, '0010', 0, 'Recarga Cubacell', 0, 1),
(120, 83, '0020', 0, 'Recarga Nauta', 0, 1),
(121, 83, '0030', 0, 'Larga Distancia', 0, 1),
(122, 83, '0040', 0, 'Envio de Remesas', 0, 1),
(123, 83, '0050', 0, 'Boletos Aéreos', 0, 1),
(124, 83, '0060', 0, 'Renta de Hoteles', 0, 1),
(125, 83, '0070', 0, 'Renta de Autos', 0, 1),
(126, 83, '0080', 0, 'Excursiones', 0, 1),
(127, 83, '0090', 0, 'Envio de paquetes', 0, 1),
(128, 83, '0100', 0, 'Paquetes Turísticos', 0, 1),
(129, 83, '0110', 0, 'Trámites Migratorios', 0, 1),
(130, 83, '0120', 0, 'Desarrollo de Software', 0, 1),
(131, 83, '0130', 0, 'Diseño', 0, 1),
(132, 83, '0140', 0, 'Marketing y redes Sociales', 0, 1),
(133, 2, '0001', 0, 'Efectivo', 1, 1),
(134, 33, '0010', 0, 'Depreciacion de Activos Fijos Tangibles', 0, 1),
(135, 80, '0010', 0, 'Otros ingresos', 1, 1),
(136, 85, '0010', 0, 'Compra de Activo Fijo', 0, 1),
(137, 54, '0050', 0, 'Entrega o Vaja de Activos Fijos', 1, 1),
(138, 22, '0010', 0, 'Activo Fijos', 1, 1),
(139, 74, '0010', 0, 'Gastos de ARS Patrimonial', 1, 1),
(140, 74, '0020', 0, 'Gastos AFP Patrimonial', 1, 1),
(141, 74, '0030', 0, 'Gastos  SRL-1.1%', 1, 1),
(142, 74, '0040', 0, 'Gastos Infotep-1%', 1, 1),
(143, 41, '0006', 0, 'ARS por Pagar', 0, 1),
(144, 41, '0007', 0, 'AFP por Pagar', 0, 1),
(145, 41, '0008', 0, 'Cooperativa por Pagar', 0, 1),
(146, 41, '0009', 0, 'Plan Médico Adicional  por Pagar', 0, 1),
(147, 41, '0010', 0, 'Restaurant por Pagar', 0, 1),
(148, 41, '0011', 0, 'ARS Patrimonial por Pagar', 0, 1),
(149, 41, '0012', 0, 'AFP Patrimonial por Pagar', 0, 1),
(150, 41, '0013', 0, 'SRL-1.1% por Pagar', 0, 1),
(151, 41, '0014', 0, 'Infotep-1.1% por Pagar', 0, 1),
(152, 42, '0010', 0, 'Nominas por Pagar', 0, 1),
(153, 86, '0010', 0, 'Recarga Cubacell', 0, 1),
(154, 86, '0020', 0, 'Recarga Nauta', 0, 1),
(155, 86, '0030', 0, 'Larga Distancia', 0, 1),
(156, 86, '0040', 0, 'Envio de Remesas', 0, 1),
(157, 86, '0050', 0, 'Boletos Aéreos', 0, 1),
(158, 86, '0060', 0, 'Renta de Hoteles', 0, 1),
(159, 86, '0070', 0, 'Renta de Autos', 0, 1),
(160, 86, '0080', 0, 'Excursiones', 0, 1),
(161, 86, '0090', 0, 'Envio de paquetes', 0, 1),
(162, 86, '0100', 0, 'Paquetes Turísticos', 0, 1),
(163, 86, '0110', 0, 'Trámites Migratorios', 0, 1),
(164, 86, '0120', 0, 'Desarrollo de Software', 0, 1),
(165, 86, '0130', 0, 'Diseño', 0, 1),
(166, 86, '0140', 0, 'Marketing y redes Sociales', 0, 1),
(167, 39, '0010', 0, 'Cobros Anticipados', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcuenta_criterio_analisis`
--

CREATE TABLE `subcuenta_criterio_analisis` (
  `id` int(11) NOT NULL,
  `id_subcuenta_id` int(11) NOT NULL,
  `id_criterio_analisis_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `subcuenta_criterio_analisis`
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
(83, 71, 6),
(88, 153, 6),
(89, 154, 6),
(91, 155, 6),
(92, 156, 6),
(93, 157, 6),
(94, 158, 6),
(95, 159, 6),
(96, 160, 6),
(97, 161, 6),
(98, 162, 6),
(99, 163, 6),
(100, 164, 6),
(101, 165, 6),
(102, 166, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcuenta_proveedor`
--

CREATE TABLE `subcuenta_proveedor` (
  `id` int(11) NOT NULL,
  `id_subcuenta_id` int(11) NOT NULL,
  `id_proveedor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `subcuenta_proveedor`
--

INSERT INTO `subcuenta_proveedor` (`id`, `id_subcuenta_id`, `id_proveedor_id`) VALUES
(1, 63, 3),
(2, 63, 2),
(3, 63, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tasa_cambio`
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

--
-- Volcado de datos para la tabla `tasa_cambio`
--

INSERT INTO `tasa_cambio` (`id`, `id_moneda_origen_id`, `id_moneda_destino_id`, `anno`, `mes`, `valor`, `activo`) VALUES
(18, 2, 1, 2021, 3, 1.2, 0),
(19, 1, 2, 2021, 3, 0.8333, 0),
(20, 1, 3, 2021, 3, 54, 0),
(21, 3, 1, 2021, 3, 0.0185, 0),
(22, 1, 3, 2021, 3, 54, 1),
(23, 3, 1, 2021, 3, 0.018518518518519, 1),
(24, 2, 1, 2021, 3, 1.2, 1),
(25, 1, 2, 2021, 3, 0.83333333333333, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tasa_de_cambio`
--

CREATE TABLE `tasa_de_cambio` (
  `id` int(11) NOT NULL,
  `id_moneda` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tasa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tasa_sugerida` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `termino_pago`
--

CREATE TABLE `termino_pago` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `termino_pago`
--

INSERT INTO `termino_pago` (`id`, `nombre`) VALUES
(1, 'Contra servicio'),
(2, 'A 7 días'),
(3, 'A 15 días'),
(4, 'A 30 días'),
(5, 'A 45 días');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `test_crud`
--

CREATE TABLE `test_crud` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_comprobante`
--

CREATE TABLE `tipo_comprobante` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `abreviatura` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_comprobante`
--

INSERT INTO `tipo_comprobante` (`id`, `descripcion`, `activo`, `abreviatura`) VALUES
(1, 'COMPROBANTE DE APERTURA', 1, 'AP'),
(2, 'COMPROBANTE DE OPERACIONES', 1, '00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cuenta`
--

CREATE TABLE `tipo_cuenta` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_cuenta`
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
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_documento`
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
(11, 'DEVOLUCION VENTA', 1),
(12, 'APERTURA', 1),
(13, 'APERTURA PRODUCTO', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento_activo_fijo`
--

CREATE TABLE `tipo_documento_activo_fijo` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_movimiento`
--

CREATE TABLE `tipo_movimiento` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_movimiento`
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
-- Estructura de tabla para la tabla `tipo_traslado`
--

CREATE TABLE `tipo_traslado` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_traslado`
--

INSERT INTO `tipo_traslado` (`id`, `nombre`, `activo`) VALUES
(1, 'dfdsfd', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_vehiculo`
--

CREATE TABLE `tipo_vehiculo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad_ini_persona` int(11) NOT NULL,
  `cantidad_fin_persona` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_vehiculo`
--

INSERT INTO `tipo_vehiculo` (`id`, `nombre`, `cantidad_ini_persona`, `cantidad_fin_persona`, `activo`, `picture`) VALUES
(1, '222', 12, 18, 1, '01-222.jpg'),
(2, 'wewew', 21, 1111, 1, '.jpg'),
(3, 'pp', 22, 33, 1, '.jpg'),
(4, 'anitaRoca', 1, 222, 1, '01-anitaRoca.jpg'),
(5, 'leo', 222, 22222, 1, '01-leo.jpg'),
(6, 'ererer', 232, 1, 1, '01-ererer.jpg'),
(7, 'ererer', 232, 1, 1, '01-ererer.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tour_nombre`
--

CREATE TABLE `tour_nombre` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tramo`
--

CREATE TABLE `tramo` (
  `id` int(11) NOT NULL,
  `proveedor` int(11) NOT NULL,
  `origen` int(11) NOT NULL,
  `destino` int(11) NOT NULL,
  `ida_vuelta` tinyint(1) NOT NULL,
  `vehiculo` int(11) NOT NULL,
  `precio` double NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `traslado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tramo`
--

INSERT INTO `tramo` (`id`, `proveedor`, `origen`, `destino`, `ida_vuelta`, `vehiculo`, `precio`, `activo`, `traslado`) VALUES
(1, 1, 2, 1, 0, 4, 10, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transferencia`
--

CREATE TABLE `transferencia` (
  `id` int(11) NOT NULL,
  `id_documento_id` int(11) NOT NULL,
  `id_unidad_id` int(11) DEFAULT NULL,
  `id_almacen_id` int(11) DEFAULT NULL,
  `nro_cuenta_inventario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_subcuenta_inventario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_cuenta_acreedora` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_subcuenta_acreedora` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_concecutivo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anno` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `entrada` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transfer_destino`
--

CREATE TABLE `transfer_destino` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transfer_origen`
--

CREATE TABLE `transfer_origen` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trasacciones`
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

--
-- Volcado de datos para la tabla `trasacciones`
--

INSERT INTO `trasacciones` (`id`, `transaccion`, `id_cotizacion`, `monto`, `banco`, `empleado`, `fecha`, `cuenta`, `moneda`, `no_transaccion`, `nota`) VALUES
(1, 'Deposito', 'reporte', '100', 'asas', 'root', '2021-03-04 13:41:25', 'asasasa', 'USD', 'asasa', 'asa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad`
--

CREATE TABLE `unidad` (
  `id` int(11) NOT NULL,
  `id_padre_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_moneda_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `unidad`
--

INSERT INTO `unidad` (`id`, `id_padre_id`, `nombre`, `activo`, `codigo`, `direccion`, `telefono`, `correo`, `id_moneda_id`) VALUES
(1, NULL, 'Grupo Horizontes Admin', 1, '01', 'asasasas', '1111112', 'www@ww.ww', NULL),
(2, 1, 'subordinado 1', 1, '0101', 'qfefw', '121212', 'empre@asd.cu', NULL),
(3, 1, 'subordinado 2', 1, '0102', 'asdasd', '1213231', 'sub@nas.sdas', NULL),
(4, 1, 'subordinado 1- 1', 1, '010101', 'dqwdqwd', '123123', 'sub11@ass.su', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_medida`
--

CREATE TABLE `unidad_medida` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abreviatura` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `unidad_medida`
--

INSERT INTO `unidad_medida` (`id`, `nombre`, `abreviatura`, `activo`) VALUES
(1, 'Centímetro', 'cm', 1),
(2, 'Metro', 'm', 1),
(3, 'Milímetro', 'mm', 1),
(4, 'Kilómetro', 'km', 1),
(5, 'Gramo', 'g', 1),
(6, 'Miligramo', 'mg', 1),
(7, 'Libra', 'lb', 1),
(8, 'Kilogramo', 'kg', 1),
(9, 'Mililitro', 'ml', 1),
(10, 'Litro', 'l', 1),
(11, 'Metro cuadrado', 'm²', 1),
(12, 'Metro cúbico', 'm³', 1),
(13, 'Unidad', 'u', 1),
(14, 'Blister', 'Blister', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `status` tinyint(1) NOT NULL,
  `id_moneda` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_agencia` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `status`, `id_moneda`, `id_agencia`, `password`) VALUES
(1, 'root', '[\"ROLE_ADMIN\"]', 1, '2', NULL, '$argon2id$v=19$m=65536,t=4,p=1$Z1dpQjlQeG1LLnB2SVpZbA$OPsXOk93GwXrcXJsCH5ARKvyWoGVJX5aZLfCoUSjMm0'),
(2, 'sss@aasas.ass', '[\"ROLE_USER\"]', 1, NULL, NULL, '$argon2id$v=19$m=65536,t=4,p=1$b1BPeGM2MjVTMlR1dG0wQw$iSCLKc3DQXdNAmPJnvmd31pMCtYNsLlUfHLNMslPlTQ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_client_tmp`
--

CREATE TABLE `user_client_tmp` (
  `id` int(11) NOT NULL,
  `id_usuario_id` int(11) NOT NULL,
  `id_cliente_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user_client_tmp`
--

INSERT INTO `user_client_tmp` (`id`, `id_usuario_id`, `id_cliente_id`) VALUES
(33, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacaciones_disfrutadas`
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
-- Estructura de tabla para la tabla `vale_salida`
--

CREATE TABLE `vale_salida` (
  `id` int(11) NOT NULL,
  `id_documento_id` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `producto` tinyint(1) NOT NULL,
  `nro_consecutivo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anno` int(11) NOT NULL,
  `fecha_solicitud` date NOT NULL,
  `nro_solicitud` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_cuenta_deudora` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_subcuenta_deudora` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `vale_salida`
--

INSERT INTO `vale_salida` (`id`, `id_documento_id`, `activo`, `producto`, `nro_consecutivo`, `anno`, `fecha_solicitud`, `nro_solicitud`, `nro_cuenta_deudora`, `nro_subcuenta_deudora`) VALUES
(1, 11, 1, 0, '1', 2021, '2021-02-13', '01', '700', '0020');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vuelo_destino`
--

CREATE TABLE `vuelo_destino` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vuelo_origen`
--

CREATE TABLE `vuelo_origen` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zona`
--

CREATE TABLE `zona` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `zona`
--

INSERT INTO `zona` (`id`, `nombre`, `activo`) VALUES
(1, 'asasasa', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `activo_fijo`
--
ALTER TABLE `activo_fijo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EBC93EDB763453` (`id_tipo_movimiento_id`),
  ADD KEY `IDX_75EBC93E6FBA0327` (`id_tipo_movimiento_baja_id`),
  ADD KEY `IDX_75EBC93ED410562` (`id_area_responsabilidad_id`),
  ADD KEY `IDX_75EBC93E4A667A2B` (`id_grupo_activo_id`),
  ADD KEY `IDX_75EBC93E1D34FA6B` (`id_unidad_id`);

--
-- Indices de la tabla `activo_fijo_cuentas`
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
-- Indices de la tabla `activo_fijo_movimiento_activo_fijo`
--
ALTER TABLE `activo_fijo_movimiento_activo_fijo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2FA61FF25832E72E` (`id_activo_fijo_id`),
  ADD KEY `IDX_2FA61FF27786CA71` (`id_movimiento_activo_fijo_id`);

--
-- Indices de la tabla `acumulado_vacaciones`
--
ALTER TABLE `acumulado_vacaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_246B9D168D392AC7` (`id_empleado_id`);

--
-- Indices de la tabla `aeropuerto`
--
ALTER TABLE `aeropuerto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `agencias`
--
ALTER TABLE `agencias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `agencias_img`
--
ALTER TABLE `agencias_img`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `agencias_tv`
--
ALTER TABLE `agencias_tv`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ajuste`
--
ALTER TABLE `ajuste`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DD35BD326601BA07` (`id_documento_id`);

--
-- Indices de la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D5B2D25020332D99` (`codigo`),
  ADD KEY `IDX_D5B2D2501D34FA6B` (`id_unidad_id`);

--
-- Indices de la tabla `almacen_ocupado`
--
ALTER TABLE `almacen_ocupado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_AA53605839161EBF` (`id_almacen_id`),
  ADD KEY `IDX_AA5360587EB2C349` (`id_usuario_id`);

--
-- Indices de la tabla `apertura`
--
ALTER TABLE `apertura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DFFB55EB6601BA07` (`id_documento_id`);

--
-- Indices de la tabla `area_responsabilidad`
--
ALTER TABLE `area_responsabilidad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F469C2BA1D34FA6B` (`id_unidad_id`);

--
-- Indices de la tabla `asiento`
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
  ADD KEY `IDX_71D6D35CD410562` (`id_area_responsabilidad_id`),
  ADD KEY `IDX_71D6D35C8E5841CF` (`id_cotizacion_id`),
  ADD KEY `IDX_71D6D35C4CC57875` (`id_elemento_visa_id`);

--
-- Indices de la tabla `avisos_pagos`
--
ALTER TABLE `avisos_pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F439673A78A65A2` (`id_plazo_pago_id`),
  ADD KEY `IDX_F4396738E5841CF` (`id_cotizacion_id`);

--
-- Indices de la tabla `banco`
--
ALTER TABLE `banco`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `beneficiarios_clientes`
--
ALTER TABLE `beneficiarios_clientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_AE9DBD1E7BF9CE86` (`id_cliente_id`),
  ADD KEY `IDX_AE9DBD1E18997CB6` (`id_pais_id`),
  ADD KEY `IDX_AE9DBD1E6DB054DD` (`id_provincia_id`),
  ADD KEY `IDX_AE9DBD1E7B7D6E92` (`id_municipio_id`);

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categoria_cliente`
--
ALTER TABLE `categoria_cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `centro_costo`
--
ALTER TABLE `centro_costo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_749608CE1D34FA6B` (`id_unidad_id`);

--
-- Indices de la tabla `cierre`
--
ALTER TABLE `cierre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D0DCFCC739161EBF` (`id_almacen_id`),
  ADD KEY `IDX_D0DCFCC77EB2C349` (`id_usuario_id`);

--
-- Indices de la tabla `cierre_diario`
--
ALTER TABLE `cierre_diario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F3D0CD8939161EBF` (`id_almacen_id`),
  ADD KEY `IDX_F3D0CD897EB2C349` (`id_usuario_id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cliente_beneficiario`
--
ALTER TABLE `cliente_beneficiario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cliente_contabilidad`
--
ALTER TABLE `cliente_contabilidad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cliente_reporte`
--
ALTER TABLE `cliente_reporte`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cliente_solicitudes`
--
ALTER TABLE `cliente_solicitudes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D0874AE67BF9CE86` (`id_cliente_id`),
  ADD KEY `IDX_D0874AE63F78A396` (`id_solicitud_id`),
  ADD KEY `IDX_D0874AE61D34FA6B` (`id_unidad_id`);

--
-- Indices de la tabla `cobros_pagos`
--
ALTER TABLE `cobros_pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D9581D1655C5F988` (`id_factura_id`),
  ADD KEY `IDX_D9581D1626990C38` (`id_informe_id`),
  ADD KEY `IDX_D9581D16E8F12801` (`id_proveedor_id`),
  ADD KEY `IDX_D9581D167786CA71` (`id_movimiento_activo_fijo_id`);

--
-- Indices de la tabla `comprobante_cierre`
--
ALTER TABLE `comprobante_cierre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D03EA4C51800963C` (`id_comprobante_id`),
  ADD KEY `IDX_D03EA4C545F8C94C` (`id_cierre_id`);

--
-- Indices de la tabla `comprobante_movimiento_activo_fijo`
--
ALTER TABLE `comprobante_movimiento_activo_fijo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_81F5096A1399A3CF` (`id_registro_comprobante_id`),
  ADD KEY `IDX_81F5096A9D00B230` (`id_movimiento_activo_id`),
  ADD KEY `IDX_81F5096A1D34FA6B` (`id_unidad_id`);

--
-- Indices de la tabla `comprobante_salario`
--
ALTER TABLE `comprobante_salario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8C5550701399A3CF` (`id_registro_comprobante_id`),
  ADD KEY `IDX_8C5550701D34FA6B` (`id_unidad_id`);

--
-- Indices de la tabla `configuracion_inicial`
--
ALTER TABLE `configuracion_inicial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8521BE24404AE9D2` (`id_modulo_id`),
  ADD KEY `IDX_8521BE247A4F962` (`id_tipo_documento_id`);

--
-- Indices de la tabla `configuracion_reglas_remesas`
--
ALTER TABLE `configuracion_reglas_remesas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2398566118997CB6` (`id_pais_id`),
  ADD KEY `IDX_23985661E8F12801` (`id_proveedor_id`),
  ADD KEY `IDX_239856611D34FA6B` (`id_unidad_id`);

--
-- Indices de la tabla `config_precio_venta_servicio`
--
ALTER TABLE `config_precio_venta_servicio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6A244E601D34FA6B` (`id_unidad_id`);

--
-- Indices de la tabla `config_servicios`
--
ALTER TABLE `config_servicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A1A8B71269D86E10` (`id_servicio_id`),
  ADD KEY `IDX_A1A8B7121D34FA6B` (`id_unidad_id`);

--
-- Indices de la tabla `contratos_cliente`
--
ALTER TABLE `contratos_cliente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_29A5BB477BF9CE86` (`id_cliente_id`),
  ADD KEY `IDX_29A5BB47374388F5` (`id_moneda_id`);

--
-- Indices de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `creditos_precio_venta`
--
ALTER TABLE `creditos_precio_venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_847FE8A94699DFE5` (`id_config_precio_venta_id`),
  ADD KEY `IDX_847FE8A91D34FA6B` (`id_unidad_id`);

--
-- Indices de la tabla `criterio_analisis`
--
ALTER TABLE `criterio_analisis`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cuadre_diario`
--
ALTER TABLE `cuadre_diario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_60ABEFD91ADA4D3F` (`id_cuenta_id`),
  ADD KEY `IDX_60ABEFD92D412F53` (`id_subcuenta_id`),
  ADD KEY `IDX_60ABEFD945F8C94C` (`id_cierre_id`),
  ADD KEY `IDX_60ABEFD939161EBF` (`id_almacen_id`);

--
-- Indices de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_31C7BFCF45E7F350` (`id_tipo_cuenta_id`);

--
-- Indices de la tabla `cuentas_cliente`
--
ALTER TABLE `cuentas_cliente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_64653310374388F5` (`id_moneda_id`),
  ADD KEY `IDX_646533107BF9CE86` (`id_cliente_id`),
  ADD KEY `IDX_646533109CDF4BAB` (`id_banco_id`);

--
-- Indices de la tabla `cuentas_unidad`
--
ALTER TABLE `cuentas_unidad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_355374209CDF4BAB` (`id_banco_id`),
  ADD KEY `IDX_355374201D34FA6B` (`id_unidad_id`),
  ADD KEY `IDX_35537420374388F5` (`id_moneda_id`);

--
-- Indices de la tabla `cuenta_criterio_analisis`
--
ALTER TABLE `cuenta_criterio_analisis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_AF040B091ADA4D3F` (`id_cuenta_id`),
  ADD KEY `IDX_AF040B095ABBE5F6` (`id_criterio_analisis_id`);

--
-- Indices de la tabla `custom_user`
--
ALTER TABLE `custom_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8CE51EB479F37AE5` (`id_user_id`);

--
-- Indices de la tabla `depreciacion`
--
ALTER TABLE `depreciacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D618AE149D01464C` (`unidad_id`);

--
-- Indices de la tabla `devolucion`
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
-- Indices de la tabla `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B6B12EC739161EBF` (`id_almacen_id`),
  ADD KEY `IDX_B6B12EC71D34FA6B` (`id_unidad_id`),
  ADD KEY `IDX_B6B12EC7374388F5` (`id_moneda_id`),
  ADD KEY `IDX_B6B12EC77A4F962` (`id_tipo_documento_id`),
  ADD KEY `IDX_B6B12EC74832F387` (`id_documento_cancelado_id`);

--
-- Indices de la tabla `elementos_visa`
--
ALTER TABLE `elementos_visa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_90B65E04E8F12801` (`id_proveedor_id`),
  ADD KEY `IDX_90B65E0469D86E10` (`id_servicio_id`),
  ADD KEY `IDX_90B65E041D34FA6B` (`id_unidad_id`);

--
-- Indices de la tabla `elemento_gasto`
--
ALTER TABLE `elemento_gasto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D9D9BF527EB2C349` (`id_usuario_id`),
  ADD KEY `IDX_D9D9BF521D34FA6B` (`id_unidad_id`),
  ADD KEY `IDX_D9D9BF52D1E12F15` (`id_cargo_id`);

--
-- Indices de la tabla `estado_solicitudes`
--
ALTER TABLE `estado_solicitudes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `expediente`
--
ALTER TABLE `expediente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D59CA4131D34FA6B` (`id_unidad_id`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F9EBA00968BCB606` (`id_contrato_id`),
  ADD KEY `IDX_F9EBA0091D34FA6B` (`id_unidad_id`),
  ADD KEY `IDX_F9EBA0097EB2C349` (`id_usuario_id`),
  ADD KEY `IDX_F9EBA009C59B01FF` (`id_centro_costo_id`),
  ADD KEY `IDX_F9EBA00971381BB3` (`id_orden_trabajo_id`),
  ADD KEY `IDX_F9EBA009F66372E9` (`id_elemento_gasto_id`),
  ADD KEY `IDX_F9EBA009F5DBAF2B` (`id_expediente_id`),
  ADD KEY `IDX_F9EBA0094F4C4E26` (`id_categoria_cliente_id`),
  ADD KEY `IDX_F9EBA009C37A5552` (`id_termino_pago_id`),
  ADD KEY `IDX_F9EBA009374388F5` (`id_moneda_id`),
  ADD KEY `IDX_F9EBA00999274826` (`id_factura_cancela_id`);

--
-- Indices de la tabla `facturas_comprobante`
--
ALTER TABLE `facturas_comprobante`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6FD2F19B55C5F988` (`id_factura_id`),
  ADD KEY `IDX_6FD2F19B1800963C` (`id_comprobante_id`),
  ADD KEY `IDX_6FD2F19B1D34FA6B` (`id_unidad_id`);

--
-- Indices de la tabla `factura_documento`
--
ALTER TABLE `factura_documento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CCC060C155C5F988` (`id_factura_id`),
  ADD KEY `IDX_CCC060C16601BA07` (`id_documento_id`),
  ADD KEY `IDX_CCC060C1EC34F77F` (`id_movimiento_venta_id`);

--
-- Indices de la tabla `factura_imposdom`
--
ALTER TABLE `factura_imposdom`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `factura_no_contable`
--
ALTER TABLE `factura_no_contable`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `grupo_activos`
--
ALTER TABLE `grupo_activos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `hotel_destino`
--
ALTER TABLE `hotel_destino`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `hotel_origen`
--
ALTER TABLE `hotel_origen`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `impuesto`
--
ALTER TABLE `impuesto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B6E63AA11D34FA6B` (`id_unidad_id`);

--
-- Indices de la tabla `impuesto_sobre_renta`
--
ALTER TABLE `impuesto_sobre_renta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5EF11EF48D392AC7` (`id_empleado_id`),
  ADD KEY `IDX_5EF11EF4E9DBC8E8` (`id_nomina_pago_id`),
  ADD KEY `IDX_5EF11EF4A9ECE748` (`id_rango_escala_id`);

--
-- Indices de la tabla `informe_recepcion`
--
ALTER TABLE `informe_recepcion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_62A4EBD6601BA07` (`id_documento_id`),
  ADD KEY `IDX_62A4EBDE8F12801` (`id_proveedor_id`);

--
-- Indices de la tabla `instrumento_cobro`
--
ALTER TABLE `instrumento_cobro`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lugares`
--
ALTER TABLE `lugares`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A4EE5DFC104EA8FC` (`zona_id`);

--
-- Indices de la tabla `mercancia`
--
ALTER TABLE `mercancia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9D094AE0E2C70A62` (`id_amlacen_id`),
  ADD KEY `IDX_9D094AE0E16A5625` (`id_unidad_medida_id`);

--
-- Indices de la tabla `mercancia_producto`
--
ALTER TABLE `mercancia_producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3F705CF59F287F54` (`id_mercancia_id`),
  ADD KEY `IDX_3F705CF56E57A479` (`id_producto_id`);

--
-- Indices de la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `moneda`
--
ALTER TABLE `moneda`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `moneda_pais`
--
ALTER TABLE `moneda_pais`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `movimiento`
--
ALTER TABLE `movimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C8FF107AD1CE493D` (`id_tipo_documento_activo_fijo_id`),
  ADD KEY `IDX_C8FF107ADB763453` (`id_tipo_movimiento_id`),
  ADD KEY `IDX_C8FF107A873C7FC7` (`id_unidad_origen_id`),
  ADD KEY `IDX_C8FF107A4F781EA` (`id_unidad_destino_id`);

--
-- Indices de la tabla `movimiento_activo_fijo`
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
-- Indices de la tabla `movimiento_mercancia`
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
-- Indices de la tabla `movimiento_producto`
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
-- Indices de la tabla `movimiento_servicio`
--
ALTER TABLE `movimiento_servicio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_93FD19C355C5F988` (`id_factura_id`),
  ADD KEY `IDX_93FD19C371CAA3E7` (`servicio_id`);

--
-- Indices de la tabla `movimiento_venta`
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
-- Indices de la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `nominas_consecutivos`
--
ALTER TABLE `nominas_consecutivos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9FC8A71A1D34FA6B` (`id_unidad_id`);

--
-- Indices de la tabla `nomina_pago`
--
ALTER TABLE `nomina_pago`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5CB8BD338D392AC7` (`id_empleado_id`),
  ADD KEY `IDX_5CB8BD33AC6A6301` (`id_usuario_aprueba_id`),
  ADD KEY `IDX_5CB8BD331D34FA6B` (`id_unidad_id`);

--
-- Indices de la tabla `nomina_tercero_comprobante`
--
ALTER TABLE `nomina_tercero_comprobante`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D4A77ABF2547677` (`id_nomina_id`),
  ADD KEY `IDX_D4A77ABF1D34FA6B` (`id_unidad_id`),
  ADD KEY `IDX_D4A77ABF1800963C` (`id_comprobante_id`);

--
-- Indices de la tabla `obligacion_cobro`
--
ALTER TABLE `obligacion_cobro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_807C726D55C5F988` (`id_factura_id`);

--
-- Indices de la tabla `obligacion_pago`
--
ALTER TABLE `obligacion_pago`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_403C9B3BE8F12801` (`id_proveedor_id`),
  ADD KEY `IDX_403C9B3B6601BA07` (`id_documento_id`),
  ADD KEY `IDX_403C9B3B1D34FA6B` (`id_unidad_id`);

--
-- Indices de la tabla `operaciones_comprobante_operaciones`
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
  ADD KEY `IDX_E7EA17E1D34FA6B` (`id_unidad_id`),
  ADD KEY `IDX_E7EA17E47B60D7E` (`id_instrumento_cobro_id`);

--
-- Indices de la tabla `orden_trabajo`
--
ALTER TABLE `orden_trabajo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4158A0241D34FA6B` (`id_unidad_id`),
  ADD KEY `IDX_4158A02439161EBF` (`id_almacen_id`);

--
-- Indices de la tabla `pagos_cotizacion`
--
ALTER TABLE `pagos_cotizacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pais`
--
ALTER TABLE `pais`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `periodo_sistema`
--
ALTER TABLE `periodo_sistema`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_AEF0BAAD1D34FA6B` (`id_unidad_id`),
  ADD KEY `IDX_AEF0BAAD39161EBF` (`id_almacen_id`),
  ADD KEY `IDX_AEF0BAAD7EB2C349` (`id_usuario_id`);

--
-- Indices de la tabla `plazos_pago_cotizacion`
--
ALTER TABLE `plazos_pago_cotizacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4A1D3ED28E5841CF` (`id_cotizacion_id`);

--
-- Indices de la tabla `por_ciento_nominas`
--
ALTER TABLE `por_ciento_nominas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `precio_venta`
--
ALTER TABLE `precio_venta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A7BB0615E2C70A62` (`id_amlacen_id`),
  ADD KEY `IDX_A7BB0615E16A5625` (`id_unidad_medida_id`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `provincias`
--
ALTER TABLE `provincias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rango_escala_dgii`
--
ALTER TABLE `rango_escala_dgii`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `registro_comprobantes`
--
ALTER TABLE `registro_comprobantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B2D1B2B21D34FA6B` (`id_unidad_id`),
  ADD KEY `IDX_B2D1B2B2EF5F7851` (`id_tipo_comprobante_id`),
  ADD KEY `IDX_B2D1B2B27EB2C349` (`id_usuario_id`),
  ADD KEY `IDX_B2D1B2B239161EBF` (`id_almacen_id`),
  ADD KEY `IDX_B2D1B2B247B60D7E` (`id_instrumento_cobro_id`);

--
-- Indices de la tabla `reglas_remesas`
--
ALTER TABLE `reglas_remesas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rent_entrega`
--
ALTER TABLE `rent_entrega`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rent_recogida`
--
ALTER TABLE `rent_recogida`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reporte_efectivo`
--
ALTER TABLE `reporte_efectivo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `saldo_cuentas`
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
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_96D27CC01D34FA6B` (`id_unidad_id`);

--
-- Indices de la tabla `solicitud_turismo`
--
ALTER TABLE `solicitud_turismo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `solicitud_turismo_comentario`
--
ALTER TABLE `solicitud_turismo_comentario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `stripe_factura`
--
ALTER TABLE `stripe_factura`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `subcuenta`
--
ALTER TABLE `subcuenta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_57BB37EA1ADA4D3F` (`id_cuenta_id`);

--
-- Indices de la tabla `subcuenta_criterio_analisis`
--
ALTER TABLE `subcuenta_criterio_analisis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_52A4A7682D412F53` (`id_subcuenta_id`),
  ADD KEY `IDX_52A4A7685ABBE5F6` (`id_criterio_analisis_id`);

--
-- Indices de la tabla `subcuenta_proveedor`
--
ALTER TABLE `subcuenta_proveedor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5C22E4B82D412F53` (`id_subcuenta_id`),
  ADD KEY `IDX_5C22E4B8E8F12801` (`id_proveedor_id`);

--
-- Indices de la tabla `tasa_cambio`
--
ALTER TABLE `tasa_cambio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DAB48606FA5CADE9` (`id_moneda_origen_id`),
  ADD KEY `IDX_DAB48606D85CECF7` (`id_moneda_destino_id`);

--
-- Indices de la tabla `tasa_de_cambio`
--
ALTER TABLE `tasa_de_cambio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `termino_pago`
--
ALTER TABLE `termino_pago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `test_crud`
--
ALTER TABLE `test_crud`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_comprobante`
--
ALTER TABLE `tipo_comprobante`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_cuenta`
--
ALTER TABLE `tipo_cuenta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_documento_activo_fijo`
--
ALTER TABLE `tipo_documento_activo_fijo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_movimiento`
--
ALTER TABLE `tipo_movimiento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_traslado`
--
ALTER TABLE `tipo_traslado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_vehiculo`
--
ALTER TABLE `tipo_vehiculo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tour_nombre`
--
ALTER TABLE `tour_nombre`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tramo`
--
ALTER TABLE `tramo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `transferencia`
--
ALTER TABLE `transferencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_EDC227306601BA07` (`id_documento_id`),
  ADD KEY `IDX_EDC227301D34FA6B` (`id_unidad_id`),
  ADD KEY `IDX_EDC2273039161EBF` (`id_almacen_id`);

--
-- Indices de la tabla `transfer_destino`
--
ALTER TABLE `transfer_destino`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `transfer_origen`
--
ALTER TABLE `transfer_origen`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trasacciones`
--
ALTER TABLE `trasacciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `unidad`
--
ALTER TABLE `unidad`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_F3E6D02F3A909126` (`nombre`),
  ADD UNIQUE KEY `UNIQ_F3E6D02F20332D99` (`codigo`),
  ADD KEY `IDX_F3E6D02F31E700CD` (`id_padre_id`),
  ADD KEY `IDX_F3E6D02F374388F5` (`id_moneda_id`);

--
-- Indices de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`);

--
-- Indices de la tabla `user_client_tmp`
--
ALTER TABLE `user_client_tmp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_AC2C28007EB2C349` (`id_usuario_id`),
  ADD KEY `IDX_AC2C28007BF9CE86` (`id_cliente_id`);

--
-- Indices de la tabla `vacaciones_disfrutadas`
--
ALTER TABLE `vacaciones_disfrutadas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F02817318D392AC7` (`id_empleado_id`);

--
-- Indices de la tabla `vale_salida`
--
ALTER TABLE `vale_salida`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_90C265C86601BA07` (`id_documento_id`);

--
-- Indices de la tabla `vuelo_destino`
--
ALTER TABLE `vuelo_destino`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vuelo_origen`
--
ALTER TABLE `vuelo_origen`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zona`
--
ALTER TABLE `zona`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `activo_fijo`
--
ALTER TABLE `activo_fijo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `activo_fijo_cuentas`
--
ALTER TABLE `activo_fijo_cuentas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `activo_fijo_movimiento_activo_fijo`
--
ALTER TABLE `activo_fijo_movimiento_activo_fijo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `acumulado_vacaciones`
--
ALTER TABLE `acumulado_vacaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `aeropuerto`
--
ALTER TABLE `aeropuerto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `agencias`
--
ALTER TABLE `agencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `agencias_img`
--
ALTER TABLE `agencias_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `agencias_tv`
--
ALTER TABLE `agencias_tv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ajuste`
--
ALTER TABLE `ajuste`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `almacen`
--
ALTER TABLE `almacen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `almacen_ocupado`
--
ALTER TABLE `almacen_ocupado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `apertura`
--
ALTER TABLE `apertura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `area_responsabilidad`
--
ALTER TABLE `area_responsabilidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `asiento`
--
ALTER TABLE `asiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT de la tabla `avisos_pagos`
--
ALTER TABLE `avisos_pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `banco`
--
ALTER TABLE `banco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `beneficiarios_clientes`
--
ALTER TABLE `beneficiarios_clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT de la tabla `centro_costo`
--
ALTER TABLE `centro_costo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `cierre`
--
ALTER TABLE `cierre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `cierre_diario`
--
ALTER TABLE `cierre_diario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cliente_beneficiario`
--
ALTER TABLE `cliente_beneficiario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cliente_contabilidad`
--
ALTER TABLE `cliente_contabilidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cliente_reporte`
--
ALTER TABLE `cliente_reporte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cliente_solicitudes`
--
ALTER TABLE `cliente_solicitudes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cobros_pagos`
--
ALTER TABLE `cobros_pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comprobante_cierre`
--
ALTER TABLE `comprobante_cierre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `comprobante_movimiento_activo_fijo`
--
ALTER TABLE `comprobante_movimiento_activo_fijo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `comprobante_salario`
--
ALTER TABLE `comprobante_salario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuracion_inicial`
--
ALTER TABLE `configuracion_inicial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuracion_reglas_remesas`
--
ALTER TABLE `configuracion_reglas_remesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `config_precio_venta_servicio`
--
ALTER TABLE `config_precio_venta_servicio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `config_servicios`
--
ALTER TABLE `config_servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `contratos_cliente`
--
ALTER TABLE `contratos_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `creditos_precio_venta`
--
ALTER TABLE `creditos_precio_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `criterio_analisis`
--
ALTER TABLE `criterio_analisis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `cuadre_diario`
--
ALTER TABLE `cuadre_diario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de la tabla `cuentas_cliente`
--
ALTER TABLE `cuentas_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuentas_unidad`
--
ALTER TABLE `cuentas_unidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuenta_criterio_analisis`
--
ALTER TABLE `cuenta_criterio_analisis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT de la tabla `custom_user`
--
ALTER TABLE `custom_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `depreciacion`
--
ALTER TABLE `depreciacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `devolucion`
--
ALTER TABLE `devolucion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `documento`
--
ALTER TABLE `documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `elementos_visa`
--
ALTER TABLE `elementos_visa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `elemento_gasto`
--
ALTER TABLE `elemento_gasto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `expediente`
--
ALTER TABLE `expediente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `facturas_comprobante`
--
ALTER TABLE `facturas_comprobante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `factura_documento`
--
ALTER TABLE `factura_documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `factura_imposdom`
--
ALTER TABLE `factura_imposdom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `factura_no_contable`
--
ALTER TABLE `factura_no_contable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grupo_activos`
--
ALTER TABLE `grupo_activos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `hotel_destino`
--
ALTER TABLE `hotel_destino`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `hotel_origen`
--
ALTER TABLE `hotel_origen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `impuesto`
--
ALTER TABLE `impuesto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `impuesto_sobre_renta`
--
ALTER TABLE `impuesto_sobre_renta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `informe_recepcion`
--
ALTER TABLE `informe_recepcion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `instrumento_cobro`
--
ALTER TABLE `instrumento_cobro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `lugares`
--
ALTER TABLE `lugares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `mercancia`
--
ALTER TABLE `mercancia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `mercancia_producto`
--
ALTER TABLE `mercancia_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `moneda`
--
ALTER TABLE `moneda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `moneda_pais`
--
ALTER TABLE `moneda_pais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `movimiento`
--
ALTER TABLE `movimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movimiento_activo_fijo`
--
ALTER TABLE `movimiento_activo_fijo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `movimiento_mercancia`
--
ALTER TABLE `movimiento_mercancia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `movimiento_producto`
--
ALTER TABLE `movimiento_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `movimiento_servicio`
--
ALTER TABLE `movimiento_servicio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movimiento_venta`
--
ALTER TABLE `movimiento_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `municipios`
--
ALTER TABLE `municipios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `nominas_consecutivos`
--
ALTER TABLE `nominas_consecutivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nomina_pago`
--
ALTER TABLE `nomina_pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `nomina_tercero_comprobante`
--
ALTER TABLE `nomina_tercero_comprobante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `obligacion_cobro`
--
ALTER TABLE `obligacion_cobro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `obligacion_pago`
--
ALTER TABLE `obligacion_pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `operaciones_comprobante_operaciones`
--
ALTER TABLE `operaciones_comprobante_operaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `orden_trabajo`
--
ALTER TABLE `orden_trabajo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pagos_cotizacion`
--
ALTER TABLE `pagos_cotizacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `pais`
--
ALTER TABLE `pais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `periodo_sistema`
--
ALTER TABLE `periodo_sistema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `plazos_pago_cotizacion`
--
ALTER TABLE `plazos_pago_cotizacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `precio_venta`
--
ALTER TABLE `precio_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `provincias`
--
ALTER TABLE `provincias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `rango_escala_dgii`
--
ALTER TABLE `rango_escala_dgii`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro_comprobantes`
--
ALTER TABLE `registro_comprobantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `reglas_remesas`
--
ALTER TABLE `reglas_remesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rent_entrega`
--
ALTER TABLE `rent_entrega`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rent_recogida`
--
ALTER TABLE `rent_recogida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reporte_efectivo`
--
ALTER TABLE `reporte_efectivo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reset_password_request`
--
ALTER TABLE `reset_password_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `saldo_cuentas`
--
ALTER TABLE `saldo_cuentas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitud_turismo`
--
ALTER TABLE `solicitud_turismo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitud_turismo_comentario`
--
ALTER TABLE `solicitud_turismo_comentario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `stripe_factura`
--
ALTER TABLE `stripe_factura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `subcuenta`
--
ALTER TABLE `subcuenta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT de la tabla `subcuenta_criterio_analisis`
--
ALTER TABLE `subcuenta_criterio_analisis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT de la tabla `subcuenta_proveedor`
--
ALTER TABLE `subcuenta_proveedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tasa_cambio`
--
ALTER TABLE `tasa_cambio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `tasa_de_cambio`
--
ALTER TABLE `tasa_de_cambio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `test_crud`
--
ALTER TABLE `test_crud`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_cuenta`
--
ALTER TABLE `tipo_cuenta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tipo_documento_activo_fijo`
--
ALTER TABLE `tipo_documento_activo_fijo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_traslado`
--
ALTER TABLE `tipo_traslado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tipo_vehiculo`
--
ALTER TABLE `tipo_vehiculo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tour_nombre`
--
ALTER TABLE `tour_nombre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tramo`
--
ALTER TABLE `tramo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `transferencia`
--
ALTER TABLE `transferencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `transfer_destino`
--
ALTER TABLE `transfer_destino`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `transfer_origen`
--
ALTER TABLE `transfer_origen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trasacciones`
--
ALTER TABLE `trasacciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `unidad`
--
ALTER TABLE `unidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `user_client_tmp`
--
ALTER TABLE `user_client_tmp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `vacaciones_disfrutadas`
--
ALTER TABLE `vacaciones_disfrutadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `vale_salida`
--
ALTER TABLE `vale_salida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `vuelo_destino`
--
ALTER TABLE `vuelo_destino`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `vuelo_origen`
--
ALTER TABLE `vuelo_origen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `zona`
--
ALTER TABLE `zona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `activo_fijo`
--
ALTER TABLE `activo_fijo`
  ADD CONSTRAINT `FK_75EBC93E1D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_75EBC93E4A667A2B` FOREIGN KEY (`id_grupo_activo_id`) REFERENCES `grupo_activos` (`id`),
  ADD CONSTRAINT `FK_75EBC93E6FBA0327` FOREIGN KEY (`id_tipo_movimiento_baja_id`) REFERENCES `tipo_movimiento` (`id`),
  ADD CONSTRAINT `FK_75EBC93ED410562` FOREIGN KEY (`id_area_responsabilidad_id`) REFERENCES `area_responsabilidad` (`id`),
  ADD CONSTRAINT `FK_75EBC93EDB763453` FOREIGN KEY (`id_tipo_movimiento_id`) REFERENCES `tipo_movimiento` (`id`);

--
-- Filtros para la tabla `activo_fijo_cuentas`
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
-- Filtros para la tabla `activo_fijo_movimiento_activo_fijo`
--
ALTER TABLE `activo_fijo_movimiento_activo_fijo`
  ADD CONSTRAINT `FK_2FA61FF25832E72E` FOREIGN KEY (`id_activo_fijo_id`) REFERENCES `activo_fijo` (`id`),
  ADD CONSTRAINT `FK_2FA61FF27786CA71` FOREIGN KEY (`id_movimiento_activo_fijo_id`) REFERENCES `movimiento` (`id`);

--
-- Filtros para la tabla `acumulado_vacaciones`
--
ALTER TABLE `acumulado_vacaciones`
  ADD CONSTRAINT `FK_246B9D168D392AC7` FOREIGN KEY (`id_empleado_id`) REFERENCES `empleado` (`id`);

--
-- Filtros para la tabla `ajuste`
--
ALTER TABLE `ajuste`
  ADD CONSTRAINT `FK_DD35BD326601BA07` FOREIGN KEY (`id_documento_id`) REFERENCES `documento` (`id`);

--
-- Filtros para la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD CONSTRAINT `FK_D5B2D2501D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`);

--
-- Filtros para la tabla `almacen_ocupado`
--
ALTER TABLE `almacen_ocupado`
  ADD CONSTRAINT `FK_AA53605839161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_AA5360587EB2C349` FOREIGN KEY (`id_usuario_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `apertura`
--
ALTER TABLE `apertura`
  ADD CONSTRAINT `FK_DFFB55EB6601BA07` FOREIGN KEY (`id_documento_id`) REFERENCES `documento` (`id`);

--
-- Filtros para la tabla `area_responsabilidad`
--
ALTER TABLE `area_responsabilidad`
  ADD CONSTRAINT `FK_F469C2BA1D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`);

--
-- Filtros para la tabla `asiento`
--
ALTER TABLE `asiento`
  ADD CONSTRAINT `FK_71D6D35C1800963C` FOREIGN KEY (`id_comprobante_id`) REFERENCES `registro_comprobantes` (`id`),
  ADD CONSTRAINT `FK_71D6D35C1ADA4D3F` FOREIGN KEY (`id_cuenta_id`) REFERENCES `cuenta` (`id`),
  ADD CONSTRAINT `FK_71D6D35C1D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_71D6D35C2D412F53` FOREIGN KEY (`id_subcuenta_id`) REFERENCES `subcuenta` (`id`),
  ADD CONSTRAINT `FK_71D6D35C39161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_71D6D35C4CC57875` FOREIGN KEY (`id_elemento_visa_id`) REFERENCES `elementos_visa` (`id`),
  ADD CONSTRAINT `FK_71D6D35C55C5F988` FOREIGN KEY (`id_factura_id`) REFERENCES `factura` (`id`),
  ADD CONSTRAINT `FK_71D6D35C5832E72E` FOREIGN KEY (`id_activo_fijo_id`) REFERENCES `activo_fijo` (`id`),
  ADD CONSTRAINT `FK_71D6D35C6601BA07` FOREIGN KEY (`id_documento_id`) REFERENCES `documento` (`id`),
  ADD CONSTRAINT `FK_71D6D35C71381BB3` FOREIGN KEY (`id_orden_trabajo_id`) REFERENCES `orden_trabajo` (`id`),
  ADD CONSTRAINT `FK_71D6D35C8E5841CF` FOREIGN KEY (`id_cotizacion_id`) REFERENCES `cotizacion` (`id`),
  ADD CONSTRAINT `FK_71D6D35CC59B01FF` FOREIGN KEY (`id_centro_costo_id`) REFERENCES `centro_costo` (`id`),
  ADD CONSTRAINT `FK_71D6D35CD410562` FOREIGN KEY (`id_area_responsabilidad_id`) REFERENCES `area_responsabilidad` (`id`),
  ADD CONSTRAINT `FK_71D6D35CE8F12801` FOREIGN KEY (`id_proveedor_id`) REFERENCES `proveedor` (`id`),
  ADD CONSTRAINT `FK_71D6D35CEF5F7851` FOREIGN KEY (`id_tipo_comprobante_id`) REFERENCES `tipo_comprobante` (`id`),
  ADD CONSTRAINT `FK_71D6D35CF5DBAF2B` FOREIGN KEY (`id_expediente_id`) REFERENCES `expediente` (`id`),
  ADD CONSTRAINT `FK_71D6D35CF66372E9` FOREIGN KEY (`id_elemento_gasto_id`) REFERENCES `elemento_gasto` (`id`);

--
-- Filtros para la tabla `avisos_pagos`
--
ALTER TABLE `avisos_pagos`
  ADD CONSTRAINT `FK_F4396738E5841CF` FOREIGN KEY (`id_cotizacion_id`) REFERENCES `cotizacion` (`id`),
  ADD CONSTRAINT `FK_F439673A78A65A2` FOREIGN KEY (`id_plazo_pago_id`) REFERENCES `plazos_pago_cotizacion` (`id`);

--
-- Filtros para la tabla `beneficiarios_clientes`
--
ALTER TABLE `beneficiarios_clientes`
  ADD CONSTRAINT `FK_AE9DBD1E18997CB6` FOREIGN KEY (`id_pais_id`) REFERENCES `pais` (`id`),
  ADD CONSTRAINT `FK_AE9DBD1E6DB054DD` FOREIGN KEY (`id_provincia_id`) REFERENCES `provincias` (`id`),
  ADD CONSTRAINT `FK_AE9DBD1E7B7D6E92` FOREIGN KEY (`id_municipio_id`) REFERENCES `municipios` (`id`),
  ADD CONSTRAINT `FK_AE9DBD1E7BF9CE86` FOREIGN KEY (`id_cliente_id`) REFERENCES `cliente` (`id`);

--
-- Filtros para la tabla `centro_costo`
--
ALTER TABLE `centro_costo`
  ADD CONSTRAINT `FK_749608CE1D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`);

--
-- Filtros para la tabla `cierre`
--
ALTER TABLE `cierre`
  ADD CONSTRAINT `FK_D0DCFCC739161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_D0DCFCC77EB2C349` FOREIGN KEY (`id_usuario_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `cierre_diario`
--
ALTER TABLE `cierre_diario`
  ADD CONSTRAINT `FK_F3D0CD8939161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_F3D0CD897EB2C349` FOREIGN KEY (`id_usuario_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `cliente_solicitudes`
--
ALTER TABLE `cliente_solicitudes`
  ADD CONSTRAINT `FK_D0874AE61D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_D0874AE63F78A396` FOREIGN KEY (`id_solicitud_id`) REFERENCES `solicitud` (`id`),
  ADD CONSTRAINT `FK_D0874AE67BF9CE86` FOREIGN KEY (`id_cliente_id`) REFERENCES `cliente` (`id`);

--
-- Filtros para la tabla `cobros_pagos`
--
ALTER TABLE `cobros_pagos`
  ADD CONSTRAINT `FK_D9581D1626990C38` FOREIGN KEY (`id_informe_id`) REFERENCES `informe_recepcion` (`id`),
  ADD CONSTRAINT `FK_D9581D1655C5F988` FOREIGN KEY (`id_factura_id`) REFERENCES `factura` (`id`),
  ADD CONSTRAINT `FK_D9581D167786CA71` FOREIGN KEY (`id_movimiento_activo_fijo_id`) REFERENCES `movimiento_activo_fijo` (`id`),
  ADD CONSTRAINT `FK_D9581D16E8F12801` FOREIGN KEY (`id_proveedor_id`) REFERENCES `proveedor` (`id`);

--
-- Filtros para la tabla `comprobante_cierre`
--
ALTER TABLE `comprobante_cierre`
  ADD CONSTRAINT `FK_D03EA4C51800963C` FOREIGN KEY (`id_comprobante_id`) REFERENCES `registro_comprobantes` (`id`),
  ADD CONSTRAINT `FK_D03EA4C545F8C94C` FOREIGN KEY (`id_cierre_id`) REFERENCES `cierre` (`id`);

--
-- Filtros para la tabla `comprobante_movimiento_activo_fijo`
--
ALTER TABLE `comprobante_movimiento_activo_fijo`
  ADD CONSTRAINT `FK_81F5096A1399A3CF` FOREIGN KEY (`id_registro_comprobante_id`) REFERENCES `registro_comprobantes` (`id`),
  ADD CONSTRAINT `FK_81F5096A1D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_81F5096A9D00B230` FOREIGN KEY (`id_movimiento_activo_id`) REFERENCES `movimiento_activo_fijo` (`id`);

--
-- Filtros para la tabla `comprobante_salario`
--
ALTER TABLE `comprobante_salario`
  ADD CONSTRAINT `FK_8C5550701399A3CF` FOREIGN KEY (`id_registro_comprobante_id`) REFERENCES `registro_comprobantes` (`id`),
  ADD CONSTRAINT `FK_8C5550701D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`);

--
-- Filtros para la tabla `configuracion_inicial`
--
ALTER TABLE `configuracion_inicial`
  ADD CONSTRAINT `FK_8521BE24404AE9D2` FOREIGN KEY (`id_modulo_id`) REFERENCES `modulo` (`id`),
  ADD CONSTRAINT `FK_8521BE247A4F962` FOREIGN KEY (`id_tipo_documento_id`) REFERENCES `tipo_documento` (`id`);

--
-- Filtros para la tabla `configuracion_reglas_remesas`
--
ALTER TABLE `configuracion_reglas_remesas`
  ADD CONSTRAINT `FK_2398566118997CB6` FOREIGN KEY (`id_pais_id`) REFERENCES `pais` (`id`),
  ADD CONSTRAINT `FK_239856611D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_23985661E8F12801` FOREIGN KEY (`id_proveedor_id`) REFERENCES `proveedor` (`id`);

--
-- Filtros para la tabla `config_precio_venta_servicio`
--
ALTER TABLE `config_precio_venta_servicio`
  ADD CONSTRAINT `FK_6A244E601D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`);

--
-- Filtros para la tabla `config_servicios`
--
ALTER TABLE `config_servicios`
  ADD CONSTRAINT `FK_A1A8B7121D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_A1A8B71269D86E10` FOREIGN KEY (`id_servicio_id`) REFERENCES `servicios` (`id`);

--
-- Filtros para la tabla `contratos_cliente`
--
ALTER TABLE `contratos_cliente`
  ADD CONSTRAINT `FK_29A5BB47374388F5` FOREIGN KEY (`id_moneda_id`) REFERENCES `moneda` (`id`),
  ADD CONSTRAINT `FK_29A5BB477BF9CE86` FOREIGN KEY (`id_cliente_id`) REFERENCES `cliente_contabilidad` (`id`);

--
-- Filtros para la tabla `creditos_precio_venta`
--
ALTER TABLE `creditos_precio_venta`
  ADD CONSTRAINT `FK_847FE8A91D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_847FE8A94699DFE5` FOREIGN KEY (`id_config_precio_venta_id`) REFERENCES `config_precio_venta_servicio` (`id`);

--
-- Filtros para la tabla `cuadre_diario`
--
ALTER TABLE `cuadre_diario`
  ADD CONSTRAINT `FK_60ABEFD91ADA4D3F` FOREIGN KEY (`id_cuenta_id`) REFERENCES `cuenta` (`id`),
  ADD CONSTRAINT `FK_60ABEFD92D412F53` FOREIGN KEY (`id_subcuenta_id`) REFERENCES `subcuenta` (`id`),
  ADD CONSTRAINT `FK_60ABEFD939161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_60ABEFD945F8C94C` FOREIGN KEY (`id_cierre_id`) REFERENCES `cierre` (`id`);

--
-- Filtros para la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD CONSTRAINT `FK_31C7BFCF45E7F350` FOREIGN KEY (`id_tipo_cuenta_id`) REFERENCES `tipo_cuenta` (`id`);

--
-- Filtros para la tabla `cuentas_cliente`
--
ALTER TABLE `cuentas_cliente`
  ADD CONSTRAINT `FK_64653310374388F5` FOREIGN KEY (`id_moneda_id`) REFERENCES `moneda` (`id`),
  ADD CONSTRAINT `FK_646533107BF9CE86` FOREIGN KEY (`id_cliente_id`) REFERENCES `cliente_contabilidad` (`id`),
  ADD CONSTRAINT `FK_646533109CDF4BAB` FOREIGN KEY (`id_banco_id`) REFERENCES `banco` (`id`);

--
-- Filtros para la tabla `cuentas_unidad`
--
ALTER TABLE `cuentas_unidad`
  ADD CONSTRAINT `FK_355374201D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_35537420374388F5` FOREIGN KEY (`id_moneda_id`) REFERENCES `moneda` (`id`),
  ADD CONSTRAINT `FK_355374209CDF4BAB` FOREIGN KEY (`id_banco_id`) REFERENCES `banco` (`id`);

--
-- Filtros para la tabla `cuenta_criterio_analisis`
--
ALTER TABLE `cuenta_criterio_analisis`
  ADD CONSTRAINT `FK_AF040B091ADA4D3F` FOREIGN KEY (`id_cuenta_id`) REFERENCES `cuenta` (`id`),
  ADD CONSTRAINT `FK_AF040B095ABBE5F6` FOREIGN KEY (`id_criterio_analisis_id`) REFERENCES `criterio_analisis` (`id`);

--
-- Filtros para la tabla `custom_user`
--
ALTER TABLE `custom_user`
  ADD CONSTRAINT `FK_8CE51EB479F37AE5` FOREIGN KEY (`id_user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `depreciacion`
--
ALTER TABLE `depreciacion`
  ADD CONSTRAINT `FK_D618AE149D01464C` FOREIGN KEY (`unidad_id`) REFERENCES `unidad` (`id`);

--
-- Filtros para la tabla `devolucion`
--
ALTER TABLE `devolucion`
  ADD CONSTRAINT `FK_524D9F671D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_524D9F6739161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_524D9F675074DD86` FOREIGN KEY (`id_orden_tabajo_id`) REFERENCES `orden_trabajo` (`id`),
  ADD CONSTRAINT `FK_524D9F676601BA07` FOREIGN KEY (`id_documento_id`) REFERENCES `documento` (`id`),
  ADD CONSTRAINT `FK_524D9F67C59B01FF` FOREIGN KEY (`id_centro_costo_id`) REFERENCES `centro_costo` (`id`),
  ADD CONSTRAINT `FK_524D9F67F66372E9` FOREIGN KEY (`id_elemento_gasto_id`) REFERENCES `elemento_gasto` (`id`);

--
-- Filtros para la tabla `documento`
--
ALTER TABLE `documento`
  ADD CONSTRAINT `FK_B6B12EC71D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_B6B12EC7374388F5` FOREIGN KEY (`id_moneda_id`) REFERENCES `moneda` (`id`),
  ADD CONSTRAINT `FK_B6B12EC739161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_B6B12EC74832F387` FOREIGN KEY (`id_documento_cancelado_id`) REFERENCES `documento` (`id`),
  ADD CONSTRAINT `FK_B6B12EC77A4F962` FOREIGN KEY (`id_tipo_documento_id`) REFERENCES `tipo_documento` (`id`);

--
-- Filtros para la tabla `elementos_visa`
--
ALTER TABLE `elementos_visa`
  ADD CONSTRAINT `FK_90B65E041D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_90B65E0469D86E10` FOREIGN KEY (`id_servicio_id`) REFERENCES `servicios` (`id`),
  ADD CONSTRAINT `FK_90B65E04E8F12801` FOREIGN KEY (`id_proveedor_id`) REFERENCES `proveedor` (`id`);

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `FK_D9D9BF521D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_D9D9BF527EB2C349` FOREIGN KEY (`id_usuario_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_D9D9BF52D1E12F15` FOREIGN KEY (`id_cargo_id`) REFERENCES `cargo` (`id`);

--
-- Filtros para la tabla `expediente`
--
ALTER TABLE `expediente`
  ADD CONSTRAINT `FK_D59CA4131D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`);

--
-- Filtros para la tabla `factura`
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
-- Filtros para la tabla `facturas_comprobante`
--
ALTER TABLE `facturas_comprobante`
  ADD CONSTRAINT `FK_6FD2F19B1800963C` FOREIGN KEY (`id_comprobante_id`) REFERENCES `registro_comprobantes` (`id`),
  ADD CONSTRAINT `FK_6FD2F19B1D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_6FD2F19B55C5F988` FOREIGN KEY (`id_factura_id`) REFERENCES `factura` (`id`);

--
-- Filtros para la tabla `factura_documento`
--
ALTER TABLE `factura_documento`
  ADD CONSTRAINT `FK_CCC060C155C5F988` FOREIGN KEY (`id_factura_id`) REFERENCES `factura` (`id`),
  ADD CONSTRAINT `FK_CCC060C16601BA07` FOREIGN KEY (`id_documento_id`) REFERENCES `documento` (`id`),
  ADD CONSTRAINT `FK_CCC060C1EC34F77F` FOREIGN KEY (`id_movimiento_venta_id`) REFERENCES `movimiento_venta` (`id`);

--
-- Filtros para la tabla `impuesto`
--
ALTER TABLE `impuesto`
  ADD CONSTRAINT `FK_B6E63AA11D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`);

--
-- Filtros para la tabla `impuesto_sobre_renta`
--
ALTER TABLE `impuesto_sobre_renta`
  ADD CONSTRAINT `FK_5EF11EF48D392AC7` FOREIGN KEY (`id_empleado_id`) REFERENCES `empleado` (`id`),
  ADD CONSTRAINT `FK_5EF11EF4A9ECE748` FOREIGN KEY (`id_rango_escala_id`) REFERENCES `rango_escala_dgii` (`id`),
  ADD CONSTRAINT `FK_5EF11EF4E9DBC8E8` FOREIGN KEY (`id_nomina_pago_id`) REFERENCES `nomina_pago` (`id`);

--
-- Filtros para la tabla `informe_recepcion`
--
ALTER TABLE `informe_recepcion`
  ADD CONSTRAINT `FK_62A4EBD6601BA07` FOREIGN KEY (`id_documento_id`) REFERENCES `documento` (`id`),
  ADD CONSTRAINT `FK_62A4EBDE8F12801` FOREIGN KEY (`id_proveedor_id`) REFERENCES `proveedor` (`id`);

--
-- Filtros para la tabla `lugares`
--
ALTER TABLE `lugares`
  ADD CONSTRAINT `FK_A4EE5DFC104EA8FC` FOREIGN KEY (`zona_id`) REFERENCES `zona` (`id`);

--
-- Filtros para la tabla `mercancia`
--
ALTER TABLE `mercancia`
  ADD CONSTRAINT `FK_9D094AE0E16A5625` FOREIGN KEY (`id_unidad_medida_id`) REFERENCES `unidad_medida` (`id`),
  ADD CONSTRAINT `FK_9D094AE0E2C70A62` FOREIGN KEY (`id_amlacen_id`) REFERENCES `almacen` (`id`);

--
-- Filtros para la tabla `mercancia_producto`
--
ALTER TABLE `mercancia_producto`
  ADD CONSTRAINT `FK_3F705CF56E57A479` FOREIGN KEY (`id_producto_id`) REFERENCES `producto` (`id`),
  ADD CONSTRAINT `FK_3F705CF59F287F54` FOREIGN KEY (`id_mercancia_id`) REFERENCES `mercancia` (`id`);

--
-- Filtros para la tabla `movimiento`
--
ALTER TABLE `movimiento`
  ADD CONSTRAINT `FK_C8FF107A4F781EA` FOREIGN KEY (`id_unidad_destino_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_C8FF107A873C7FC7` FOREIGN KEY (`id_unidad_origen_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_C8FF107AD1CE493D` FOREIGN KEY (`id_tipo_documento_activo_fijo_id`) REFERENCES `tipo_documento_activo_fijo` (`id`),
  ADD CONSTRAINT `FK_C8FF107ADB763453` FOREIGN KEY (`id_tipo_movimiento_id`) REFERENCES `tipo_movimiento` (`id`);

--
-- Filtros para la tabla `movimiento_activo_fijo`
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
-- Filtros para la tabla `movimiento_mercancia`
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
-- Filtros para la tabla `movimiento_producto`
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
-- Filtros para la tabla `movimiento_servicio`
--
ALTER TABLE `movimiento_servicio`
  ADD CONSTRAINT `FK_93FD19C355C5F988` FOREIGN KEY (`id_factura_id`) REFERENCES `factura` (`id`),
  ADD CONSTRAINT `FK_93FD19C371CAA3E7` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`);

--
-- Filtros para la tabla `movimiento_venta`
--
ALTER TABLE `movimiento_venta`
  ADD CONSTRAINT `FK_8E3F7AE539161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_8E3F7AE555C5F988` FOREIGN KEY (`id_factura_id`) REFERENCES `factura` (`id`),
  ADD CONSTRAINT `FK_8E3F7AE56EA527F2` FOREIGN KEY (`id_expediente_acreedor_id`) REFERENCES `expediente` (`id`),
  ADD CONSTRAINT `FK_8E3F7AE5D8F8B0AD` FOREIGN KEY (`id_centro_costo_acreedor_id`) REFERENCES `centro_costo` (`id`),
  ADD CONSTRAINT `FK_8E3F7AE5F0821C98` FOREIGN KEY (`id_elemento_gasto_acreedor_id`) REFERENCES `elemento_gasto` (`id`),
  ADD CONSTRAINT `FK_8E3F7AE5FA3DF5CD` FOREIGN KEY (`id_orden_trabajo_acreedor_id`) REFERENCES `orden_trabajo` (`id`);

--
-- Filtros para la tabla `nominas_consecutivos`
--
ALTER TABLE `nominas_consecutivos`
  ADD CONSTRAINT `FK_9FC8A71A1D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`);

--
-- Filtros para la tabla `nomina_pago`
--
ALTER TABLE `nomina_pago`
  ADD CONSTRAINT `FK_5CB8BD331D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_5CB8BD338D392AC7` FOREIGN KEY (`id_empleado_id`) REFERENCES `empleado` (`id`),
  ADD CONSTRAINT `FK_5CB8BD33AC6A6301` FOREIGN KEY (`id_usuario_aprueba_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `nomina_tercero_comprobante`
--
ALTER TABLE `nomina_tercero_comprobante`
  ADD CONSTRAINT `FK_D4A77ABF1800963C` FOREIGN KEY (`id_comprobante_id`) REFERENCES `registro_comprobantes` (`id`),
  ADD CONSTRAINT `FK_D4A77ABF1D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_D4A77ABF2547677` FOREIGN KEY (`id_nomina_id`) REFERENCES `nomina_pago` (`id`);

--
-- Filtros para la tabla `obligacion_cobro`
--
ALTER TABLE `obligacion_cobro`
  ADD CONSTRAINT `FK_807C726D55C5F988` FOREIGN KEY (`id_factura_id`) REFERENCES `factura` (`id`);

--
-- Filtros para la tabla `obligacion_pago`
--
ALTER TABLE `obligacion_pago`
  ADD CONSTRAINT `FK_403C9B3B1D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_403C9B3B6601BA07` FOREIGN KEY (`id_documento_id`) REFERENCES `documento` (`id`),
  ADD CONSTRAINT `FK_403C9B3BE8F12801` FOREIGN KEY (`id_proveedor_id`) REFERENCES `proveedor` (`id`);

--
-- Filtros para la tabla `operaciones_comprobante_operaciones`
--
ALTER TABLE `operaciones_comprobante_operaciones`
  ADD CONSTRAINT `FK_E7EA17E1ADA4D3F` FOREIGN KEY (`id_cuenta_id`) REFERENCES `cuenta` (`id`),
  ADD CONSTRAINT `FK_E7EA17E1D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_E7EA17E2D412F53` FOREIGN KEY (`id_subcuenta_id`) REFERENCES `subcuenta` (`id`),
  ADD CONSTRAINT `FK_E7EA17E39161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_E7EA17E47B60D7E` FOREIGN KEY (`id_instrumento_cobro_id`) REFERENCES `instrumento_cobro` (`id`),
  ADD CONSTRAINT `FK_E7EA17E71381BB3` FOREIGN KEY (`id_orden_trabajo_id`) REFERENCES `orden_trabajo` (`id`),
  ADD CONSTRAINT `FK_E7EA17EC59B01FF` FOREIGN KEY (`id_centro_costo_id`) REFERENCES `centro_costo` (`id`),
  ADD CONSTRAINT `FK_E7EA17EE8F12801` FOREIGN KEY (`id_proveedor_id`) REFERENCES `proveedor` (`id`),
  ADD CONSTRAINT `FK_E7EA17EECB9FBA7` FOREIGN KEY (`id_registro_comprobantes_id`) REFERENCES `registro_comprobantes` (`id`),
  ADD CONSTRAINT `FK_E7EA17EF5DBAF2B` FOREIGN KEY (`id_expediente_id`) REFERENCES `expediente` (`id`),
  ADD CONSTRAINT `FK_E7EA17EF66372E9` FOREIGN KEY (`id_elemento_gasto_id`) REFERENCES `elemento_gasto` (`id`);

--
-- Filtros para la tabla `orden_trabajo`
--
ALTER TABLE `orden_trabajo`
  ADD CONSTRAINT `FK_4158A0241D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_4158A02439161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`);

--
-- Filtros para la tabla `periodo_sistema`
--
ALTER TABLE `periodo_sistema`
  ADD CONSTRAINT `FK_AEF0BAAD1D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_AEF0BAAD39161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_AEF0BAAD7EB2C349` FOREIGN KEY (`id_usuario_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `plazos_pago_cotizacion`
--
ALTER TABLE `plazos_pago_cotizacion`
  ADD CONSTRAINT `FK_4A1D3ED28E5841CF` FOREIGN KEY (`id_cotizacion_id`) REFERENCES `cotizacion` (`id`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `FK_A7BB0615E16A5625` FOREIGN KEY (`id_unidad_medida_id`) REFERENCES `unidad_medida` (`id`),
  ADD CONSTRAINT `FK_A7BB0615E2C70A62` FOREIGN KEY (`id_amlacen_id`) REFERENCES `almacen` (`id`);

--
-- Filtros para la tabla `registro_comprobantes`
--
ALTER TABLE `registro_comprobantes`
  ADD CONSTRAINT `FK_B2D1B2B21D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_B2D1B2B239161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_B2D1B2B247B60D7E` FOREIGN KEY (`id_instrumento_cobro_id`) REFERENCES `instrumento_cobro` (`id`),
  ADD CONSTRAINT `FK_B2D1B2B27EB2C349` FOREIGN KEY (`id_usuario_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_B2D1B2B2EF5F7851` FOREIGN KEY (`id_tipo_comprobante_id`) REFERENCES `tipo_comprobante` (`id`);

--
-- Filtros para la tabla `saldo_cuentas`
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
-- Filtros para la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD CONSTRAINT `FK_96D27CC01D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`);

--
-- Filtros para la tabla `subcuenta`
--
ALTER TABLE `subcuenta`
  ADD CONSTRAINT `FK_57BB37EA1ADA4D3F` FOREIGN KEY (`id_cuenta_id`) REFERENCES `cuenta` (`id`);

--
-- Filtros para la tabla `subcuenta_criterio_analisis`
--
ALTER TABLE `subcuenta_criterio_analisis`
  ADD CONSTRAINT `FK_52A4A7682D412F53` FOREIGN KEY (`id_subcuenta_id`) REFERENCES `subcuenta` (`id`),
  ADD CONSTRAINT `FK_52A4A7685ABBE5F6` FOREIGN KEY (`id_criterio_analisis_id`) REFERENCES `criterio_analisis` (`id`);

--
-- Filtros para la tabla `subcuenta_proveedor`
--
ALTER TABLE `subcuenta_proveedor`
  ADD CONSTRAINT `FK_5C22E4B82D412F53` FOREIGN KEY (`id_subcuenta_id`) REFERENCES `subcuenta` (`id`),
  ADD CONSTRAINT `FK_5C22E4B8E8F12801` FOREIGN KEY (`id_proveedor_id`) REFERENCES `proveedor` (`id`);

--
-- Filtros para la tabla `tasa_cambio`
--
ALTER TABLE `tasa_cambio`
  ADD CONSTRAINT `FK_DAB48606D85CECF7` FOREIGN KEY (`id_moneda_destino_id`) REFERENCES `moneda` (`id`),
  ADD CONSTRAINT `FK_DAB48606FA5CADE9` FOREIGN KEY (`id_moneda_origen_id`) REFERENCES `moneda` (`id`);

--
-- Filtros para la tabla `transferencia`
--
ALTER TABLE `transferencia`
  ADD CONSTRAINT `FK_EDC227301D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_EDC2273039161EBF` FOREIGN KEY (`id_almacen_id`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `FK_EDC227306601BA07` FOREIGN KEY (`id_documento_id`) REFERENCES `documento` (`id`);

--
-- Filtros para la tabla `unidad`
--
ALTER TABLE `unidad`
  ADD CONSTRAINT `FK_F3E6D02F31E700CD` FOREIGN KEY (`id_padre_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_F3E6D02F374388F5` FOREIGN KEY (`id_moneda_id`) REFERENCES `moneda` (`id`);

--
-- Filtros para la tabla `user_client_tmp`
--
ALTER TABLE `user_client_tmp`
  ADD CONSTRAINT `FK_AC2C28007BF9CE86` FOREIGN KEY (`id_cliente_id`) REFERENCES `cliente` (`id`),
  ADD CONSTRAINT `FK_AC2C28007EB2C349` FOREIGN KEY (`id_usuario_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `vacaciones_disfrutadas`
--
ALTER TABLE `vacaciones_disfrutadas`
  ADD CONSTRAINT `FK_F02817318D392AC7` FOREIGN KEY (`id_empleado_id`) REFERENCES `empleado` (`id`);

--
-- Filtros para la tabla `vale_salida`
--
ALTER TABLE `vale_salida`
  ADD CONSTRAINT `FK_90C265C86601BA07` FOREIGN KEY (`id_documento_id`) REFERENCES `documento` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
