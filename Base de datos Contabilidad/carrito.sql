-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 08, 2021 at 05:37 PM
-- Server version: 8.0.23-0ubuntu0.20.04.1
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dev-cuba`
--

-- --------------------------------------------------------

--
-- Table structure for table `carrito`
--

CREATE TABLE `carrito` (
  `id` int NOT NULL,
  `json` varchar(1500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empleado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carrito`
--

    INSERT INTO `carrito` (`id`, `json`, `empleado`) VALUES
    (84, '{\"id_empleado\":1,\"id_cliente\":\"8095648845\",\"id_servicio\":4,\"nombre_servicio\":\"Envio de Remesas\",\"precio_servicio\":\"100\",\"total\":100,\"data\":[{\"id\":1,\"primerNombre\":\"nombre\",\"primerApellido\":\"apellido\",\"segundoApellido\":\"segundo apellido\",\"identificacion\":\"4020000000\",\"telefono\":\"8095648845\",\"telefonoCasa\":\"8095648846\",\"alternativoNombre\":\"altelnativo nombre\",\"alternativoApellido\":\"Primer Apellido\",\"alternativoSegundoApellido\":\"Segundo Apellido\",\"calle\":\"000\",\"no\":\"00\",\"entre\":\"0\",\"y\":\"0\",\"apto\":\"0\",\"edificio\":\"00\",\"reparto\":\"0\",\"provincia\":\"31\",\"municipio\":\"3102\",\"idCliente\":\"8095648845\",\"nombreCliente\":\"Jose Miguel De Jesus\",\"remitenteNombre\":null,\"remitenteApellido\":null,\"comentario\":null,\"fecha\":\"2021-02-08 17:30:44\",\"empleado\":\"Solyag\",\"monto\":\"100\",\"montoMoneda\":\"1\",\"recibir\":\"2328\",\"recibirMoneda\":\"3\",\"pais\":\"3\",\"servicio\":\"Remesa\",\"orden\":\"6021ad84507e4\",\"idCarrito\":1,\"nombreMostrar\":\"nombre apellido\",\"montoMostrar\":\"100\"}]}', 'Solyag'),
    (85, '{\"id_empleado\":1,\"id_cliente\":1,\"id_servicio\":11,\"nombre_servicio\":\"Tr\\u00e1mites Migratorios\",\"precio_servicio\":1258,\"total\":1258,\"data\":[{\"nombre\":\"Jose Miguel\",\"primer_apellido\":\"De\",\"segundo_apellido\":\"Jesus\",\"telefono_celular\":\"8095648845\",\"telefono_fijo\":\"\",\"idCarrito\":0,\"nombreMostrar\":\"Jose Miguel De\",\"montoMostrar\":1258}]}', 'Solyag');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
