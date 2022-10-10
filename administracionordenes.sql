-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-10-2022 a las 02:48:44
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
(45, 'PRODUCCION DE PIEZAS'),
(44, 'SERVICIOS DE LIMPIEZA'),
(43, 'TALLERES MECANICOS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centro`
--

CREATE TABLE `centro` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `centro`
--

INSERT INTO `centro` (`id`, `nombre`) VALUES
(3794, 'ACADEMIA DE BASQUETBALL 2022'),
(3796, 'ACADEMIA DE FUTBOL 2022'),
(3792, 'ACADEMIA DE INFORMATICA 2022'),
(3799, 'ACADEMIA DE INGLES: CURSO INGLES ADOLESCENTES 2021'),
(3798, 'ACADEMIA DE LENGUAJE 2022'),
(3791, 'ACADEMIA DE MECATRONICA 2022'),
(3790, 'ACADEMIA DE OFIMATICA 2022'),
(3793, 'ACADEMIA DE TECNOLOGIA 2022'),
(3795, 'ACADEMIA DE TENIS 2022');

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
  `anexo` int(11) NOT NULL,
  `ubicacion` varchar(150) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `prioridad` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `centroCosto` varchar(150) NOT NULL,
  `funcionarioContacto` varchar(150) NOT NULL,
  `resumen` varchar(150) NOT NULL,
  `detalle` varchar(150) NOT NULL,
  `fechaCreacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fechaEdicion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `terminada` tinyint(1) NOT NULL,
  `fechaTermino` datetime DEFAULT NULL,
  `materiales` text DEFAULT NULL,
  `precioMateriales` int(11) DEFAULT NULL,
  `tipoTrabajo` varchar(150) NOT NULL,
  `observacion` text DEFAULT NULL,
  `solicitudCompra` text DEFAULT NULL,
  `funcionarioEncargado` varchar(150) DEFAULT NULL,
  `fechaAsignacion` datetime DEFAULT NULL,
  `funcionariosEjecutores` text DEFAULT NULL,
  `precioFuncionariosEjecutores` int(11) DEFAULT NULL,
  `horasHombre` int(11) DEFAULT NULL,
  `cantidadPersonasInvolucradas` int(11) DEFAULT NULL,
  `costoTotal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ordenes`
--

INSERT INTO `ordenes` (`id`, `anexo`, `ubicacion`, `nombre`, `prioridad`, `idCategoria`, `centroCosto`, `funcionarioContacto`, `resumen`, `detalle`, `fechaCreacion`, `fechaEdicion`, `terminada`, `fechaTermino`, `materiales`, `precioMateriales`, `tipoTrabajo`, `observacion`, `solicitudCompra`, `funcionarioEncargado`, `fechaAsignacion`, `funcionariosEjecutores`, `precioFuncionariosEjecutores`, `horasHombre`, `cantidadPersonasInvolucradas`, `costoTotal`) VALUES
(132, 0, '5', '', 2, 44, '3792', '20.901.445-9', 'se solicita limpieza en departamento de informatica', 'dentro de esta semana', '2022-10-09 19:21:44', '2022-10-09 19:21:44', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion`
--

CREATE TABLE `ubicacion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ubicacion`
--

INSERT INTO `ubicacion` (`id`, `nombre`) VALUES
(1, 'DEPARTAMENTO DE FISICA'),
(2, 'DEPARTAMENTO DE INGLES'),
(3, 'DEPARTAMENTO DE AGRONOMIA'),
(4, 'DEPARTAMENTO DE INDUSTRIAL'),
(5, 'DEPARTAMENTO DE INFORMATICA'),
(6, 'DEPARTAMENTO DE ELECTRONICA'),
(7, 'DEPARTAMENTO DE DERECHO'),
(8, 'DEPARTAMENTO DE SALUD'),
(9, 'DEPARTAMENTO DE TRABAJO SOCIAL'),
(10, 'DEPARTAMENTO DE ADMINISTRACION'),
(11, 'DEPARTAMENTO DE MATEMATICA'),
(12, 'BIBLIOTECA CENTRAL');

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
-- Indices de la tabla `centro`
--
ALTER TABLE `centro`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

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
-- Indices de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `centro`
--
ALTER TABLE `centro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3800;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
