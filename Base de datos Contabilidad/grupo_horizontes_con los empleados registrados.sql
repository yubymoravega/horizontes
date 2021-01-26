-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2021 at 06:09 AM
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
(28, 1, 1, NULL, '2550', 500, 'Buro', '2021-01-23', 1, NULL, 'BOLIVIA', NULL, 1, 1, NULL, 0, 500, 10, 'vgf', 'Mueble', 'bolivia', '', '', '', '', '', NULL),
(29, 1, 2, NULL, '2551', 700, 'Torre, Monitor y accesorio', '2021-01-23', 1, NULL, 'BAHAMAS', NULL, 1, 1, NULL, 0, 700, 10, '23', 'Equipos de Computo', 'Dell', '', '', '', '', '', NULL),
(30, 1, 2, NULL, '2552', 50000, 'Edificio Administrativo', '2021-01-23', 1, NULL, 'BELARUS', NULL, 1, 1, NULL, 0, 50000, 10, 'i', 'Edificios', '.', '.', '', '', '', '', NULL),
(31, 1, 3, NULL, '2553', 150, 'Silla Giratoria', '2021-01-23', 1, NULL, 'AUSTRALIA', NULL, 1, 1, NULL, 0, 150, 5, '-', 'Muebles', '-', '', '', '', '', '', NULL);

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
(28, 28, 22, 138, 25, 1, 33, 134, 69, 97, 25, 17, 54, 38),
(29, 29, 22, 138, 25, 1, 33, 134, 69, 97, 25, 17, 54, 38),
(30, 30, 22, 138, 25, 1, 33, 134, 69, 97, 25, 17, 54, 38),
(31, 31, 22, 138, 25, 1, 33, 134, 69, 97, 25, 17, 54, 38);

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
(3, 1, 'Almacén de Productos Terminados', 1, '03'),
(4, 1, 'Almacén de Materias Primas y Materiales', 0, '001');

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
-- Table structure for table `apertura`
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
-- Dumping data for table `apertura`
--

INSERT INTO `apertura` (`id`, `id_documento_id`, `nro_cuenta_inventario`, `observacion`, `nro_subcuenta_inventario`, `nro_cuenta_acreedora`, `nro_subcuenta_acreedora`, `nro_concecutivo`, `anno`, `activo`, `entrada`) VALUES
(1, 182, '', 'Apertura del Negocio', '', '600', '0040', '1', 2021, 1, 1),
(2, 183, '', 'Apertura de Negocio Mercancias', '', '600', '0040', '1', 2021, 1, 1),
(3, 184, '', 'Apertura de Negicios ( Productos)', '', '600', '0040', '1', 2021, 1, 1);

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
(497, 10, 65, 182, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2021-01-23', 2021, 0, 10000, 'AP-1', 2, 86, NULL, NULL, NULL),
(498, 10, 65, 182, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2021-01-23', 2021, 0, 5000, 'AP-1', 2, 86, NULL, NULL, NULL),
(499, 10, 65, 182, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2021-01-23', 2021, 0, 8000, 'AP-1', 2, 86, NULL, NULL, NULL),
(500, 54, 41, 182, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2021-01-23', 2021, 23000, 0, 'AP-1', 2, 86, NULL, NULL, NULL),
(501, 15, 62, 183, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2021-01-23', 2021, 0, 3000, 'AP-1', 2, 87, NULL, NULL, NULL),
(502, 54, 41, 183, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2021-01-23', 2021, 3000, 0, 'AP-1', 2, 87, NULL, NULL, NULL),
(503, 14, 6, 184, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2021-01-23', 2021, 0, 12500, 'IRP-1', 2, 85, NULL, NULL, NULL),
(504, 54, 41, 184, 3, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2021-01-23', 2021, 12500, 0, 'AE-1', 2, 85, NULL, NULL, NULL),
(505, 2, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2021-01-24', 2021, 0, 2550000, '-', 1, 88, NULL, NULL, NULL),
(506, 54, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2021-01-24', 2021, 2550000, 0, '-', 1, 88, NULL, NULL, NULL),
(507, 22, 138, NULL, NULL, 25, NULL, NULL, NULL, NULL, 1, 0, NULL, '2021-01-23', 2021, 0, 500, 'AP-1', 2, 89, NULL, 28, 1),
(508, 54, 38, NULL, NULL, 25, 17, NULL, NULL, NULL, 1, 0, NULL, '2021-01-23', 2021, 500, 0, 'AP-1', 2, 89, NULL, 28, NULL),
(509, 22, 138, NULL, NULL, 25, NULL, NULL, NULL, NULL, 1, 0, NULL, '2021-01-23', 2021, 0, 700, 'AP-2', 2, 89, NULL, 29, 1),
(510, 54, 38, NULL, NULL, 25, 17, NULL, NULL, NULL, 1, 0, NULL, '2021-01-23', 2021, 700, 0, 'AP-2', 2, 89, NULL, 29, NULL),
(511, 22, 138, NULL, NULL, 25, NULL, NULL, NULL, NULL, 1, 0, NULL, '2021-01-23', 2021, 0, 50000, 'AP-3', 2, 89, NULL, 30, 1),
(512, 54, 38, NULL, NULL, 25, 17, NULL, NULL, NULL, 1, 0, NULL, '2021-01-23', 2021, 50000, 0, 'AP-3', 2, 89, NULL, 30, NULL),
(513, 22, 138, NULL, NULL, 25, NULL, NULL, NULL, NULL, 1, 0, NULL, '2021-01-23', 2021, 0, 150, 'AP-4', 2, 89, NULL, 31, 1),
(514, 54, 38, NULL, NULL, 25, 17, NULL, NULL, NULL, 1, 0, NULL, '2021-01-23', 2021, 150, 0, 'AP-4', 2, 89, NULL, 31, NULL);

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
(73, 1, 1, 1, 1, 2021, '2021-01-23', 0, 0, 23000, 0),
(74, 1, 1, 1, 1, 2021, '2021-01-24', 23000, 1, 0, 0),
(75, 2, 1, 1, 1, 2021, '2021-01-23', 0, 0, 3000, 0),
(76, 2, 1, 1, 1, 2021, '2021-01-24', 3000, 1, 0, 0),
(77, 3, 1, 1, 1, 2021, '2021-01-23', 0, 0, 12500, 0),
(78, 3, 1, 1, 1, 2021, '2021-01-24', 12500, 1, 0, 0);

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
(39, 85, 77),
(40, 86, 73),
(41, 87, 75);

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
(14, 89, 40, 1, 2021),
(15, 89, 41, 1, 2021),
(16, 89, 42, 1, 2021),
(17, 89, 43, 1, 2021);

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
(82, 10, 65, 73, 1, '01', '2021-01-23', '0.00', 23000, 0),
(83, 15, 62, 75, 2, '02', '2021-01-23', '0.00', 3000, 0),
(84, 14, 6, 77, 3, '03', '2021-01-23', '0.00', 12500, 0);

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
(54, 11, 600, 'Capital Contable', 0, 0, 0, 1, 0, 0),
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
(161, 22, 3, 3);

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
('DoctrineMigrations\\Version20210121103943', '2021-01-21 11:40:04', 1881),
('DoctrineMigrations\\Version20210123042333', '2021-01-23 05:23:40', 5718),
('DoctrineMigrations\\Version20210123161100', '2021-01-23 17:11:27', 1135);

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
(182, 1, 1, 1, 23000, '2021-01-23', 1, 12, 2021, NULL),
(183, 2, 1, 1, 3000, '2021-01-23', 1, 12, 2021, NULL),
(184, 3, 1, 1, 12500, '2021-01-23', 1, 13, 2021, NULL);

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
(6, 1, 1, 1, 'Anibal Valdes Llende', 'anibal@solyag.com', '2020-11-01', 0, NULL, 'Calle 2da', '55816826', 'ROLE_ADMIN', 1, '89102815009', 65000, NULL),
(10, 1, 1, NULL, 'Leidiana Delgado Prado', 'lprado@solyag.com', '2021-01-01', 0, NULL, 'Calle 2da Edif 22', '+53 55816826', NULL, 1, '90013136016', 33000, NULL),
(11, 1, 1, NULL, 'Camilo Alberto Hernandez Valdes', 'cavaldes@solyag.com', '2021-01-01', 0, NULL, 'Calle Antonio Rubio', '+53 59977579', NULL, 1, '89102815009', 20000, NULL),
(12, 1, 1, NULL, 'Marlon Hernandez Valdes', 'mhernandez@solyag.com', '2021-01-01', 0, NULL, 'Calle 2da entre B & C', '+53 54054679', NULL, 1, '94032202356', 90500, NULL),
(13, 1, 1, NULL, 'Alberto Hernandez Correa', 'albehernandez@solyag.com', '2021-01-01', 0, NULL, 'Calle B #319', '+53 59926869', NULL, 1, '6512365226', 40000, NULL),
(14, 1, 1, NULL, 'Maria Maire Valdes Llende', 'mmvaldes@solyag.com', '2021-01-01', 0, NULL, 'Call 2da Edif 22', '+52568127', NULL, 1, '75123136256', 40000, NULL),
(15, 1, 1, NULL, 'Liset Herrera Valdes', 'liset@solyag.com', '2021-01-01', 0, NULL, 'Call Retiro #36', '+52568128', NULL, 1, '89011512365', 22000, NULL),
(16, 1, 1, NULL, 'Dianabel Valdes Figueroa', 'diani@solyag.com', '2021-01-01', 0, NULL, 'Calle Antonio Rubio #313', '+53 58963265', NULL, 1, '95022212365', 15000, NULL),
(17, 1, 1, NULL, 'Ever Alejandro Hernandez Valdes', 'ever@solyag.com', '2021-01-01', 0, NULL, 'Calle @da edificio 22 apto B11', '89562365914', NULL, 1, '15091012365', 60000, NULL),
(18, 1, 1, NULL, 'Evellin Herhandez Delgado', 'evelly@solyag.vom', '2021-01-01', 0, NULL, 'Calle 2da entre C y D', '+5356985321569', NULL, 1, '19101863965', 58000, NULL);

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
(116, 1, 13, '104612', '183', 'Detergente', 50, 10000, 1, '0010', '600', '0040'),
(117, 1, 13, '104651', '183', 'Jabon', 100, 5000, 1, '0010', '600', '0040'),
(118, 1, 13, '1075-23', '183', 'Shampu', 100, 8000, 1, '0010', '600', '0040'),
(119, 2, 13, '2013151', '189', 'Split  de 2.0 t', 10, 3000, 1, '0040', '600', '0040');

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
(40, 1, 28, 1, 22, 138, 1, '2021-01-23', 'Altas de activos fijos', 1, 1, 2021, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 1, 29, 1, 22, 138, 1, '2021-01-23', 'altas de activos fijos', 1, 2, 2021, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 1, 30, 1, 22, 138, 1, '2021-01-23', 'alta de activos fijos', 1, 3, 2021, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 1, 31, 1, 22, 138, 1, '2021-01-23', 'Alta de Activos Fijos', 1, 4, 2021, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
(347, 116, 182, 12, 1, NULL, NULL, 50, 10000, 50, '2021-01-23', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(348, 117, 182, 12, 1, NULL, NULL, 100, 5000, 100, '2021-01-23', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(349, 118, 182, 12, 1, NULL, NULL, 100, 8000, 100, '2021-01-23', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(350, 119, 183, 12, 1, NULL, NULL, 10, 3000, 10, '2021-01-23', 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL);

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
(52, 13, 184, 13, 1, NULL, NULL, 50, 12500, 50, '2021-01-23', 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL);

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

-- --------------------------------------------------------

--
-- Table structure for table `nomina_tercero_comprobante`
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
(83, 2, 133, NULL, NULL, NULL, NULL, NULL, 88, NULL, 1, NULL, NULL, 0, 2550000),
(84, 54, 40, NULL, NULL, NULL, NULL, NULL, 88, NULL, 1, NULL, NULL, 2550000, 0);

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
(5, 1, 1, 1, 1, 2021, 1, '2021-01-23', 0),
(6, 1, 3, 1, 1, 2021, 1, '2021-01-23', 0),
(7, 1, 2, 1, 1, 2021, 1, '2021-01-23', 0);

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
(13, 3, 13, 'AP-00', '188', 'Combo de Aseo', 50, 12500, 1, '0040', '600', '0040');

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
(85, 1, 2, 1, 3, 1, '2021-01-24', 'Registrando los recursos aportados para el inicio del negocio por parte de su dueño', 12500, 12500, 2021, 1, NULL),
(86, 1, 2, 1, 1, 2, '2021-01-24', 'Registrando recursos del dueño al inicio del negocio', 23000, 23000, 2021, 1, NULL),
(87, 1, 2, 1, 2, 3, '2021-01-24', 'Registrando aportes del dueño para inicio del negocio', 3000, 3000, 2021, 1, NULL),
(88, 1, 1, 1, NULL, 4, '2021-01-24', 'Contabilizando efectivo para inicio de megocio', 2550000, 2550000, 2021, 3, 'Apertura'),
(89, 1, 2, 1, NULL, 4, '2021-01-24', 'Contabilizando la apertura de  activos fijos para el inicio del negocio', 51350, 51350, 2021, 5, NULL);

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
(11, 'DEVOLUCION VENTA', 1),
(12, 'APERTURA', 1),
(13, 'APERTURA PRODUCTO', 1);

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
-- Indexes for table `apertura`
--
ALTER TABLE `apertura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DFFB55EB6601BA07` (`id_documento_id`);

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
-- Indexes for table `nomina_tercero_comprobante`
--
ALTER TABLE `nomina_tercero_comprobante`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D4A77ABF2547677` (`id_nomina_id`),
  ADD KEY `IDX_D4A77ABF1D34FA6B` (`id_unidad_id`),
  ADD KEY `IDX_D4A77ABF1800963C` (`id_comprobante_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `activo_fijo_cuentas`
--
ALTER TABLE `activo_fijo_cuentas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `almacen_ocupado`
--
ALTER TABLE `almacen_ocupado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=256;

--
-- AUTO_INCREMENT for table `apertura`
--
ALTER TABLE `apertura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `area_responsabilidad`
--
ALTER TABLE `area_responsabilidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `asiento`
--
ALTER TABLE `asiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=515;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `comprobante_movimiento_activo_fijo`
--
ALTER TABLE `comprobante_movimiento_activo_fijo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT for table `elemento_gasto`
--
ALTER TABLE `elemento_gasto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `movimiento_mercancia`
--
ALTER TABLE `movimiento_mercancia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=351;

--
-- AUTO_INCREMENT for table `movimiento_producto`
--
ALTER TABLE `movimiento_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `nomina_tercero_comprobante`
--
ALTER TABLE `nomina_tercero_comprobante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

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
-- Constraints for table `apertura`
--
ALTER TABLE `apertura`
  ADD CONSTRAINT `FK_DFFB55EB6601BA07` FOREIGN KEY (`id_documento_id`) REFERENCES `documento` (`id`);

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
-- Constraints for table `nomina_tercero_comprobante`
--
ALTER TABLE `nomina_tercero_comprobante`
  ADD CONSTRAINT `FK_D4A77ABF1800963C` FOREIGN KEY (`id_comprobante_id`) REFERENCES `registro_comprobantes` (`id`),
  ADD CONSTRAINT `FK_D4A77ABF1D34FA6B` FOREIGN KEY (`id_unidad_id`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_D4A77ABF2547677` FOREIGN KEY (`id_nomina_id`) REFERENCES `nomina_pago` (`id`);

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