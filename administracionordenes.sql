-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-10-2022 a las 13:56:04
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `administracionordenes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categoria` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`) VALUES
(46, 'electrónicas'),
(47, 'labores de construcción'),
(45, 'producción de piezas'),
(44, 'servicios de limpieza'),
(43, 'talleres mecánicos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales`
--

CREATE TABLE `materiales` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `precioUnitario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `materiales`
--

INSERT INTO `materiales` (`id`, `nombre`, `precioUnitario`) VALUES
(1, 'foco', 2000),
(2, 'detector de voltaje', 4000),
(3, 'multímetro', 1500),
(4, 'cámara térmica', 2100),
(5, 'destornillador', 2200),
(6, 'cinta eléctrica líquida', 1100),
(7, 'pulsera antiestática', 4000),
(8, 'pinzas', 3100),
(9, 'Adhesivos para reparaciones', 5000),
(10, 'promotores de la adhesión', 2000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materialesordenes`
--

CREATE TABLE `materialesordenes` (
  `id` int(11) NOT NULL,
  `idMaterial` int(11) NOT NULL,
  `idOrden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

CREATE TABLE `ordenes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `fechaCreacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fechaEdicion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `terminada` tinyint(1) NOT NULL,
  `fechaTermino` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ordenes`
--

INSERT INTO `ordenes` (`id`, `nombre`, `idCategoria`, `fechaCreacion`, `fechaEdicion`, `terminada`, `fechaTermino`) VALUES
(49, 'orden 1', 46, '2022-10-01 08:10:49', '2022-10-01 08:25:58', 1, '2022-10-01 08:25:58'),
(50, 'orden 2', 47, '2022-10-01 08:10:57', '2022-10-01 08:10:57', 0, NULL),
(51, 'orden 3', 46, '2022-10-01 08:11:03', '2022-10-01 08:11:03', 0, NULL),
(52, 'orden 4', 44, '2022-10-01 08:11:16', '2022-10-01 08:11:16', 0, NULL),
(53, 'orden 5', 43, '2022-10-01 08:11:27', '2022-10-01 08:11:27', 0, NULL),
(54, 'orden 6', 46, '2022-10-01 08:11:47', '2022-10-01 08:11:47', 0, NULL),
(55, 'orden 7', 47, '2022-10-01 08:11:58', '2022-10-01 08:11:58', 0, NULL),
(56, 'orden 8', 43, '2022-10-01 08:12:10', '2022-10-01 08:12:10', 0, NULL),
(57, 'orden 9', 43, '2022-10-01 08:12:29', '2022-10-01 08:31:35', 1, '2022-10-01 08:31:35');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categoria` (`categoria`);

--
-- Indices de la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `materialesordenes`
--
ALTER TABLE `materialesordenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idMaterial` (`idMaterial`),
  ADD KEY `idOrden` (`idOrden`);

--
-- Indices de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ordenes_ibfk_1` (`idCategoria`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `materiales`
--
ALTER TABLE `materiales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `materialesordenes`
--
ALTER TABLE `materialesordenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `materialesordenes`
--
ALTER TABLE `materialesordenes`
  ADD CONSTRAINT `materialesordenes_ibfk_1` FOREIGN KEY (`idMaterial`) REFERENCES `materiales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `materialesordenes_ibfk_2` FOREIGN KEY (`idOrden`) REFERENCES `ordenes` (`id`);

--
-- Filtros para la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD CONSTRAINT `ordenes_ibfk_1` FOREIGN KEY (`idCategoria`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
