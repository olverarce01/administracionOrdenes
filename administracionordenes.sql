-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-11-2022 a las 00:59:49
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
(66, 'ADQUISICION DE ESTRUCTURA'),
(70, 'ADQUISICION DE TECNOLOGIA'),
(60, 'CONTROL CONSTRUCCION EDIFICION'),
(63, 'CONTROL DE CAMARAS VIGILANCIA'),
(62, 'DESPLAZAMIENTO DE ESTRUCTURAS'),
(67, 'ENSAMBLADO DE ESTRUCTURA'),
(55, 'INSTALACION ESTRUCTURA'),
(54, 'INSTALACION LUCES'),
(58, 'INSTALACION PANELES SOLARES'),
(71, 'LIMPIEZA DE ESPACIOS'),
(68, 'MANTENCION DE DISPENSADORES ALCOHOL GEL'),
(64, 'MANTENIMIENTO BUSES UTA'),
(65, 'MANTENIMIENTO VEHICULOS GENERAL'),
(45, 'PRODUCCION DE PIEZAS'),
(56, 'REPARACION ESTRUCTURA'),
(59, 'REPARACION RECINTO DEPORTIVO'),
(57, 'RESTAURACION AREAS VERDES'),
(44, 'SERVICIOS DE LIMPIEZA'),
(61, 'TRANSPORTE DE ESTRUCTURAS');

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
(1, '20.901.445-9', 'luis perez', 'ELECTRICISTA', 1100),
(2, '20.421.446-9', 'matias fernandez', 'MECANICO', 1400),
(3, '10.331.225-9', 'pedro picapiedra', 'INFORMATICO', 1600),
(4, '12.345.567-8', 'juan linux', 'ELECTRICISTA', 1700),
(5, '12.345.678-9', 'luis java', 'JARDINERO', 950),
(6, '12.335.456-7', 'pedro sas', 'REPARADOR DE ASCENSORES', 1400),
(7, '12.341.234-5', 'roberto android', 'ADMINISTRADOR DE REDES', 900),
(8, '12.344.012-3', 'felipe elixir', 'BODEGUERO', 1100),
(9, '23.456.789-1', 'mario bross', 'ENSAMBLADOR ESTRUCTURAS', 1100),
(10, '23.452.739-1', 'mario box', 'COMPRADOR TECNOLOGIA', 1010),
(11, '03.456.789-1', 'luigi martinez', 'COMPRADOR ESTRUCTURAS', 1110),
(12, '9.456.789-1', 'carlos vega', 'INSTALADOR LUMINARIA', 1330),
(13, '23.056.789-1', 'cristian cacerez', 'INSTALADOR PANELES SOLARES', 1340),
(14, '23.456.780-1', 'gaston gatuso', 'MANTENEDOR VEHICULOS', 1000),
(15, '23.006.789-1', 'diego chocolo', 'TRANSPORTADOR ESTRUCTURAS', 1000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funcionariosorden`
--

CREATE TABLE `funcionariosorden` (
  `id` int(11) NOT NULL,
  `idFuncionario` int(11) NOT NULL,
  `idOrden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `funcionariosorden`
--

INSERT INTO `funcionariosorden` (`id`, `idFuncionario`, `idOrden`) VALUES
(460, 2, 180),
(461, 3, 180),
(462, 1, 185),
(463, 4, 185),
(466, 5, 186),
(467, 6, 186);

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
-- Estructura de tabla para la tabla `materialesorden`
--

CREATE TABLE `materialesorden` (
  `id` int(11) NOT NULL,
  `idMaterial` int(11) NOT NULL,
  `idOrden` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `materialesorden`
--

INSERT INTO `materialesorden` (`id`, `idMaterial`, `idOrden`, `cantidad`) VALUES
(148, 1, 180, 2),
(149, 2, 180, 3),
(150, 3, 185, 1),
(151, 4, 185, 2),
(155, 5, 186, 3),
(156, 6, 186, 2),
(157, 7, 186, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

CREATE TABLE `ordenes` (
  `id` int(11) NOT NULL,
  `anexo` text NOT NULL,
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
  `fechaRecepcion` datetime DEFAULT NULL,
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

INSERT INTO `ordenes` (`id`, `anexo`, `ubicacion`, `nombre`, `prioridad`, `idCategoria`, `centroCosto`, `funcionarioContacto`, `resumen`, `detalle`, `fechaCreacion`, `fechaEdicion`, `terminada`, `fechaTermino`, `materiales`, `precioMateriales`, `tipoTrabajo`, `observacion`, `solicitudCompra`, `funcionarioEncargado`, `fechaRecepcion`, `fechaAsignacion`, `funcionariosEjecutores`, `precioFuncionariosEjecutores`, `horasHombre`, `cantidadPersonasInvolucradas`, `costoTotal`) VALUES
(180, '11.111.111-1', '1', '', 0, 66, '3794', 'Mauricio Antezana', 'res', 'et', '2022-11-06 10:31:19', '2022-11-11 17:32:28', 1, '2022-11-20 00:00:00', '1, 2, ', 16000, 'EXTERNO', 'd', 'no', '20.901.445-9', '2022-09-30 00:00:00', '2022-10-01 00:00:00', '2, 3, ', 3000, 1, 2, 19000),
(185, '11.111.111-1', '1', '', 0, 66, '3794', 'Mauricio Antezana', 'oooooooooooooooo', 'oooooooooooo', '2022-10-01 17:11:06', '2022-11-11 19:11:56', 1, '2022-11-12 00:00:00', '3, 4, ', 5700, 'EXTERNO', 'NA', 'no', '20.901.445-9', '2022-11-11 00:00:00', '2022-11-12 00:00:00', '1, 4, ', 2800, 3, 2, 14100),
(186, '44.444.444-4', '1', '', 2, 66, '3794', 'Olver  Arce', 'qwerty', 'qwerty', '2022-11-11 20:26:05', '2022-11-11 20:27:41', 1, '2022-12-02 00:00:00', '5, 6, 7, ', 12800, 'INTERNO', 'NA', 'no', '20.901.445-9', '2022-11-30 00:00:00', '2022-12-01 00:00:00', '5, 6, ', 2350, 1, 2, 15150);

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
(12, 'BIBLIOTECA CENTRAL'),
(13, 'DEPARTAMENTO DE EDUCACION FISICA'),
(14, 'DEPARTAMENTO DE SOCIOLOGIA'),
(15, 'DEPARTAMENTO DE ANTROPOLOGIA'),
(16, 'DEPARTAMENTO DE COMERCIAL'),
(17, 'DEPARTAMENTO DE TECNOLOGIA MEDICA'),
(18, 'DEPARTAMENTO DE QUIMICA LABORATORISTA'),
(19, 'DEPARTAMENTO SISMOLOGIA'),
(20, 'DEPARTAMENTO DE ELECTRICA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `run` varchar(150) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `apellido` varchar(200) NOT NULL,
  `correo` varchar(200) NOT NULL,
  `contacto` int(11) NOT NULL,
  `rol` varchar(200) NOT NULL,
  `pass` varchar(200) NOT NULL,
  `prioridad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `run`, `nombre`, `apellido`, `correo`, `contacto`, `rol`, `pass`, `prioridad`) VALUES
(1, '11.111.111-1', 'Mauricio', 'Antezana', 'mauricio.antezana@uta.cl', 947850503, 'generador', '12345', 0),
(2, '22.222.222-2', 'Adolfo', 'Navea', 'adolfo.navea@uta.cl', 947505032, 'Administrador', '1234', NULL),
(3, '33.333.333-3', 'Patricio ', 'Gutierrez', 'patricio.gutierrez@uta.cl', 947505444, 'generador', 'generador1', 1),
(4, '44.444.444-4', 'Olver ', 'Arce', 'olver.arce@uta.cl', 944405123, 'generador', 'generador2', 2),
(5, '55.555.555-5', 'Mauricio', 'Mamani', 'mauricio.mamani@uta.cl', 947634822, 'generador', 'generador3', 3);

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
-- Indices de la tabla `funcionariosorden`
--
ALTER TABLE `funcionariosorden`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idFuncionario` (`idFuncionario`),
  ADD KEY `idOrden` (`idOrden`);

--
-- Indices de la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `materialesorden`
--
ALTER TABLE `materialesorden`
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
-- Indices de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT de la tabla `centro`
--
ALTER TABLE `centro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3800;

--
-- AUTO_INCREMENT de la tabla `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `funcionariosorden`
--
ALTER TABLE `funcionariosorden`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=468;

--
-- AUTO_INCREMENT de la tabla `materiales`
--
ALTER TABLE `materiales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `materialesorden`
--
ALTER TABLE `materialesorden`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `funcionariosorden`
--
ALTER TABLE `funcionariosorden`
  ADD CONSTRAINT `funcionariosorden_ibfk_1` FOREIGN KEY (`idFuncionario`) REFERENCES `funcionarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `funcionariosorden_ibfk_2` FOREIGN KEY (`idOrden`) REFERENCES `ordenes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `materialesorden`
--
ALTER TABLE `materialesorden`
  ADD CONSTRAINT `materialesorden_ibfk_1` FOREIGN KEY (`idMaterial`) REFERENCES `materiales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `materialesorden_ibfk_2` FOREIGN KEY (`idOrden`) REFERENCES `ordenes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD CONSTRAINT `ordenes_ibfk_1` FOREIGN KEY (`idCategoria`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
