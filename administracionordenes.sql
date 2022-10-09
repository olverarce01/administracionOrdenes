-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-10-2022 a las 20:28:51
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
(45, 'produccion de piezas'),
(53, 'regar plantas'),
(44, 'servicios de limpieza'),
(43, 'talleres mecanicos'),
(52, 'ver camara');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` int(11) NOT NULL,
  `rut` varchar(150) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `cargo` varchar(150) NOT NULL,
  `precioHora` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `rut`, `nombre`, `cargo`, `precioHora`) VALUES
(1, '20.901.445-9', 'luis perez', 'electricista', 1000),
(2, '20.421.446-9', 'matias fernandez', 'mecanico', 2000),
(3, '10.331.225-9', 'pedro picapiedra', 'informatico', 3000);

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
-- Estructura de tabla para la tabla `ordenes`
--

CREATE TABLE `ordenes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `prioridad` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `fechaCreacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fechaEdicion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `terminada` tinyint(1) NOT NULL,
  `fechaTermino` datetime DEFAULT NULL,
  `materiales` text DEFAULT NULL,
  `precioMateriales` int(11) DEFAULT NULL,
  `tipoTrabajo` varchar(150) NOT NULL,
  `observacion` text NOT NULL,
  `solicitudCompra` text NOT NULL,
  `funcionarioEncargado` varchar(150) NOT NULL,
  `fechaAsignacion` datetime NOT NULL,
  `funcionariosEjecutores` text DEFAULT NULL,
  `precioFuncionariosEjecutores` int(11) NOT NULL,
  `horasHombre` int(11) NOT NULL,
  `cantidadPersonasInvolucradas` int(11) NOT NULL,
  `costoTotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ordenes`
--

INSERT INTO `ordenes` (`id`, `nombre`, `prioridad`, `idCategoria`, `fechaCreacion`, `fechaEdicion`, `terminada`, `fechaTermino`, `materiales`, `precioMateriales`, `tipoTrabajo`, `observacion`, `solicitudCompra`, `funcionarioEncargado`, `fechaAsignacion`, `funcionariosEjecutores`, `precioFuncionariosEjecutores`, `horasHombre`, `cantidadPersonasInvolucradas`, `costoTotal`) VALUES
(114, 'orden 1', 0, 45, '2022-10-07 20:49:25', '2022-10-08 16:16:20', 1, '2022-10-08 16:16:20', 'foco, detector de voltaje, ', 6000, 'interno', 'se observa la orden', 'se solicita la compra', '20.901.445-9', '2022-09-30 12:02:00', '20.901.445-9, 20.421.446-9, ', 3000, 10, 2, 36000),
(115, 'orden 2', 4, 44, '2022-10-07 23:31:20', '2022-10-08 23:17:33', 0, NULL, 'foco, multímetro, ', 3500, 'interno', 'se observa la orden', 'se solicita la compra', '20.901.445-9', '2022-10-07 23:31:00', '20.901.445-9, ', 1000, 2, 1, 5500),
(116, 'orden 3', 2, 43, '2022-10-08 07:55:52', '2022-10-08 23:17:37', 0, NULL, 'foco, ', 6000, 'interno', 'se observa la orden', 'se solicita la compra', '20.421.446-9', '2022-10-08 07:55:00', '20.901.445-9, ', 1000, 1, 1, 7000),
(117, 'orden 4', 1, 52, '2022-10-08 07:56:41', '2022-10-08 23:17:41', 1, '2022-10-08 09:15:36', 'foco, ', 2000, 'interno', 'se observa la orden', 'se solicita la compra', '20.901.445-9', '2022-10-08 07:56:00', '10.331.225-9, ', 3000, 1, 1, 5000),
(118, 'orden 5', 3, 52, '2022-10-08 10:22:45', '2022-10-08 23:17:57', 1, '2022-10-08 16:46:08', 'foco, detector de voltaje, cámara térmica, cinta eléctrica líquida, ', 9200, 'interno', 'se observa la orden', 'se solicita la compra', '20.901.445-9', '2022-10-08 12:00:00', '20.901.445-9, ', 1000, 2, 1, 11200),
(119, 'orden 6', 1, 53, '2022-10-08 14:41:11', '2022-10-08 23:17:52', 1, '2022-10-08 16:45:59', 'destornillador, Adhesivos para reparaciones, ', 12200, 'interno', 'se observa la orden', 'se solicita la compra', '10.331.225-9', '2022-10-08 14:01:00', '20.901.445-9, ', 1000, 2, 1, 14200),
(120, 'orden 7', 4, 53, '2022-10-08 14:41:54', '2022-10-08 23:17:48', 1, '2022-10-08 16:45:55', 'cinta eléctrica líquida, ', 2200, 'interno', 'se observa la orden', 'se solicita la compra', '20.901.445-9', '2022-10-08 19:41:54', '20.421.446-9, ', 2000, 3, 1, 8200),
(121, 'orden 8', 0, 53, '2022-10-08 14:42:43', '2022-10-08 14:42:43', 0, NULL, 'pinzas, Adhesivos para reparaciones, ', 11200, 'interno', 'se observa la orden', 'se solicita la compra', '20.901.445-9', '2022-10-08 19:42:43', '10.331.225-9, ', 3000, 3, 1, 20200),
(122, 'orden 9', 2, 45, '2022-10-08 23:07:53', '2022-10-08 23:07:53', 0, NULL, 'foco, ', 4000, 'interno', 'sin obervacion', 'sin solicitud', '20.901.445-9', '2022-10-08 12:00:00', '20.421.446-9, ', 2000, 2, 1, 8000);

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
-- Indices de la tabla `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `materiales`
--
ALTER TABLE `materiales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD CONSTRAINT `ordenes_ibfk_1` FOREIGN KEY (`idCategoria`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
