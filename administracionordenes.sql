-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-10-2022 a las 03:27:32
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
(69, 'REPARACION SERVICIOS HIGIENICOS'),
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
(140, '11.111.111-1', '1', '', 0, 66, '3794', '20.901.445-9', 'Se solicita comprar una pizarra 50x50', 'Llamar antes de entregar', '2022-10-15 10:57:22', '2022-10-15 11:35:47', 1, '2022-10-15 18:30:00', 'foco, detector de voltaje, multímetro, ', 21000, 'INTERNO', 'observacion', 'solicitud', '23.056.789-1', '2022-10-15 12:00:00', '2022-10-15 00:00:00', '12.341.234-5, 12.344.012-3, ', 6000, 3, 2, 27000),
(141, '11.111.111-1', '2', '', 1, 54, '3799', '20.901.445-9', 'Se solicita cambiar 2 focos LED', 'En sala 201 de ingles', '2022-10-15 10:58:11', '2022-10-15 11:44:37', 1, '2022-10-16 11:00:00', 'multímetro, cámara térmica, ', 9600, 'INTERNO', 'observacion', 'solicitud', '10.331.225-9', '2022-10-15 12:00:00', '2022-10-16 00:00:00', '12.341.234-5, 12.344.012-3, ', 6000, 3, 2, 15600),
(142, '11.111.111-1', '3', '', 2, 56, '3793', '12.345.567-8', 'Se solicita reparar camara climatica', 'Llamar antes de entrega', '2022-10-15 11:00:43', '2022-10-15 11:44:27', 1, '2022-10-17 14:00:00', 'Adhesivos para reparaciones, promotores de la adhesión, ', 22000, 'INTERNO', 'observacion', 'solicitud', '12.335.456-7', '2022-10-15 12:00:00', '2022-10-17 00:00:00', '12.345.678-9, 12.335.456-7, ', 2350, 1, 2, 24350),
(143, '11.111.111-1', '4', '', 0, 71, '3792', '20.901.445-9', 'Se solicita limpiar Auditorio', 'Ninguno', '2022-10-15 11:01:39', '2022-10-15 11:47:19', 1, '2022-10-18 12:00:00', 'multímetro, cámara térmica, cinta eléctrica líquida, ', 10900, 'INTERNO', 'observacion', 'solicitud', '20.901.445-9', '2022-10-15 12:00:00', '2022-10-18 00:00:00', '12.345.678-9, 23.452.739-1, ', 9800, 5, 2, 20700),
(144, '11.111.111-1', '8', '', 3, 57, '3798', '20.901.445-9', 'Se solicita controlar areas verdes', 'Ninguno', '2022-10-15 11:02:30', '2022-10-15 11:49:57', 1, '2022-10-19 20:00:00', 'pulsera antiestática, pinzas, Adhesivos para reparaciones, ', 17300, 'INTERNO', 'observacion', 'solicitud', '20.901.445-9', '2022-10-15 12:00:00', '2022-10-19 00:00:00', '23.456.789-1, 23.452.739-1, ', 8440, 4, 2, 25740),
(145, '11.111.111-1', '6', '', 1, 66, '3792', '20.901.445-9', 'Se solicita compra de 3 RASPERRYPi', 'Revisar antes de la entrega', '2022-10-15 11:05:29', '2022-10-15 16:04:19', 1, '2022-10-20 15:00:00', 'cinta eléctrica líquida, pinzas, promotores de la adhesión, ', 20600, 'INTERNO', 'observacion', 'solicitud', '20.901.445-9', '2022-10-15 12:00:00', '2022-10-20 16:00:00', '10.331.225-9, 12.345.678-9, 12.335.456-7, ', 11850, 3, 3, 32450),
(146, '11.111.111-1', '7', '', 4, 63, '3798', '20.901.445-9', 'Se solicita revisar el funcionamiento de las camaras', 'En todas las salas', '2022-10-15 11:06:29', '2022-10-15 16:03:37', 1, '2022-10-18 16:00:00', 'cinta eléctrica líquida, pinzas, ', 12600, 'INTERNO', 'observacion', 'solicitud', '10.331.225-9', '2022-10-15 12:00:00', '2022-10-18 05:00:00', '20.901.445-9, 10.331.225-9, ', 2700, 1, 2, 15300),
(147, '11.111.111-1', '1', '', 3, 59, '3794', '12.344.012-3', 'Se solicita mantenicion del pasto', 'Cancha Edmundo Flores', '2022-10-15 11:08:09', '2022-10-15 16:03:43', 1, '2022-10-18 12:00:00', 'cinta eléctrica líquida, Adhesivos para reparaciones, ', 11100, 'INTERNO', 'observacion', 'solicitud', '12.344.012-3', '2022-10-15 12:00:00', '2022-10-18 08:00:00', '12.335.456-7, 12.344.012-3, 23.456.789-1, 23.452.739-1, 9.456.789-1, ', 23760, 4, 5, 34860),
(148, '11.111.111-1', '19', '', 1, 61, '3794', '23.456.780-1', 'Se solicita transportar maquina sismologica', 'Ninguno', '2022-10-15 11:12:27', '2022-10-15 16:04:08', 1, '2022-10-15 16:58:56', 'foco, destornillador, pulsera antiestática, ', 18600, 'INTERNO', 'observacion', 'solicitud', '20.901.445-9', '2022-10-15 12:00:00', '2022-10-19 12:00:00', '20.901.445-9, 12.341.234-5, 12.344.012-3, 23.452.739-1, ', 12330, 3, 4, 30930),
(149, '11.111.111-1', '12', '', 4, 60, '3793', '23.006.789-1', 'Se solicita remodelacion fachada', 'Pintar Entrada', '2022-10-15 11:14:27', '2022-10-15 16:04:14', 1, '2022-10-19 16:00:00', 'foco, cámara térmica, destornillador, pulsera antiestática, Adhesivos para reparaciones, promotores de la adhesión, ', 21400, 'INTERNO', 'observacion', 'solicitud', '03.456.789-1', '2022-10-15 12:00:00', '2022-10-19 14:00:00', '12.344.012-3, 23.456.789-1, 03.456.789-1, ', 9930, 3, 3, 31330),
(150, '11.111.111-1', '11', '', 2, 70, '3792', '12.341.234-5', 'Compra de tablets android', 'Revisar antes de entregar', '2022-10-15 11:19:35', '2022-10-15 16:03:49', 1, '2022-10-18 20:00:00', 'foco, detector de voltaje, cámara térmica, destornillador, ', 24700, 'INTERNO', 'observacion', 'solicitud', '20.421.446-9', '2022-10-15 12:00:00', '2022-10-18 12:00:00', '20.901.445-9, 20.421.446-9, 10.331.225-9, 12.345.567-8, 12.345.678-9, ', 20250, 3, 5, 44950),
(151, '11.111.111-1', '12', '', 1, 71, '3790', '03.456.789-1', 'Se solicita limpiar ventanas', 'Ninguno', '2022-10-15 11:21:31', '2022-10-15 16:03:25', 1, '2022-10-17 17:00:00', 'foco, detector de voltaje, cámara térmica, ', 14100, 'INTERNO', 'observacion', 'solicitud', '10.331.225-9', '2022-10-15 12:00:00', '2022-10-17 12:00:00', '20.421.446-9, 12.345.567-8, 12.345.678-9, 23.056.789-1, ', 26950, 5, 4, 41050),
(152, '11.111.111-1', '20', '', 0, 58, '3791', '23.456.789-1', 'Se solicita instalar paneles en techo electrica ', 'Ninguno', '2022-10-15 11:23:56', '2022-10-15 16:04:25', 1, '2022-10-20 19:00:00', 'pulsera antiestática, Adhesivos para reparaciones, ', 22000, 'INTERNO', 'observacion', 'solicitud', '23.456.780-1', '2022-10-18 12:00:00', '2022-10-20 17:00:00', '12.341.234-5, 12.344.012-3, 23.456.789-1, ', 9300, 3, 3, 31300),
(153, '11.111.111-1', '6', '', 3, 45, '3791', '12.344.012-3', 'Se solicita producir piezas logo de univeridad', 'Ninguno', '2022-10-15 11:24:42', '2022-10-15 12:13:25', 1, '2022-10-27 09:00:00', 'foco, cámara térmica, pulsera antiestática, ', 16300, 'EXTERNO', 'observacion', 'solicitud', '20.901.445-9', '2022-10-15 12:00:00', '2022-10-27 00:00:00', '12.345.678-9, 12.335.456-7, 12.341.234-5, 12.344.012-3, ', 4350, 1, 4, 20650),
(154, '11.111.111-1', '13', '', 0, 64, '3793', '20.901.445-9', 'Se solicita revisar estado de buses', 'Los buses de placa W9.43W.H y T9.43F.Z ', '2022-10-15 11:26:41', '2022-10-15 12:30:02', 1, '2022-10-25 19:00:00', 'detector de voltaje, destornillador, pulsera antiestática, ', 22600, 'INTERNO', 'observacion', 'solicitud', '12.341.234-5', '2022-10-19 16:00:00', '2022-10-25 00:00:00', '20.901.445-9, 12.345.567-8, 12.345.678-9, ', 15000, 4, 3, 37600),
(155, '11.111.111-1', '10', '', 4, 63, '3792', '20.901.445-9', 'Se solicita verificar estado de camaras', 'Ninguno', '2022-10-15 11:27:40', '2022-10-15 16:04:41', 1, '2022-10-27 20:00:00', 'multímetro, destornillador, pulsera antiestática, ', 13600, 'INTERNO', 'observacion', 'solicitud', '20.901.445-9', '2022-10-15 12:00:00', '2022-10-27 12:00:00', '12.345.567-8, 12.341.234-5, ', 13000, 5, 2, 26600),
(156, '11.111.111-1', '8', '', 0, 70, '3790', '20.901.445-9', 'Se solicita comprar pantallas LED', 'Revisar antes de entregar', '2022-10-15 11:28:39', '2022-10-15 16:04:34', 1, '2022-10-25 18:00:00', 'detector de voltaje, multímetro, cámara térmica, destornillador, ', 20300, 'INTERNO', 'observacion', 'solicitud', '20.421.446-9', '2022-10-15 12:00:00', '2022-10-25 12:00:00', '12.341.234-5, 12.344.012-3, 23.456.789-1, 23.452.739-1, ', 8220, 2, 4, 28520),
(157, '11.111.111-1', '1', '', 1, 61, '3796', '12.335.456-7', 'Se solicita transportar pantallas gigantes al gimnasio principal', 'Ninguno', '2022-10-15 11:29:27', '2022-10-15 12:36:27', 1, '2022-10-26 17:00:00', 'destornillador, cinta eléctrica líquida, pinzas, promotores de la adhesión, ', 20300, 'EXTERNO', 'observacion', 'solicitud', '20.901.445-9', '2022-10-15 12:00:00', '2022-10-26 00:00:00', '23.452.739-1, 03.456.789-1, 9.456.789-1, ', 17250, 5, 3, 37550);

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
  `pass` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `run`, `nombre`, `apellido`, `correo`, `contacto`, `rol`, `pass`) VALUES
(1, '11.111.111-1', 'Mauricio', 'Antezana', 'mauricio.anteza@uta.cl', 947850503, 'generador', '12345'),
(2, '22.222.222-2', 'Adolfo', 'Navea', 'adolfo.navea@uta.cl', 947505032, 'Administrador', '1234');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de la tabla `centro`
--
ALTER TABLE `centro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3800;

--
-- AUTO_INCREMENT de la tabla `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `materiales`
--
ALTER TABLE `materiales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
