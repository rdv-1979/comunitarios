-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-03-2026 a las 22:23:18
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `reportes_comunitarios`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `descripcion_categoria` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `descripcion_categoria`) VALUES
(1, 'bache'),
(2, 'luminaria'),
(3, 'mascota'),
(5, 'basura');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colaboraciones_empresas`
--

CREATE TABLE `colaboraciones_empresas` (
  `id_colaboracion` int(11) NOT NULL,
  `id_empresa_usuario` int(11) NOT NULL,
  `id_reporte_c` int(11) NOT NULL,
  `descripcion_colaboracion` varchar(355) NOT NULL,
  `fecha_colaboracion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `colaboraciones_empresas`
--

INSERT INTO `colaboraciones_empresas` (`id_colaboracion`, `id_empresa_usuario`, `id_reporte_c`, `descripcion_colaboracion`, `fecha_colaboracion`) VALUES
(3, 12, 9, 'La empresa donará $50.000 pesos para recolección de basura!', '2025-12-15 21:05:21'),
(4, 12, 10, 'La empresa donará $23.000 pesos para colaborar!!!', '2025-12-16 17:39:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_puntos`
--

CREATE TABLE `historial_puntos` (
  `id_historial` int(11) NOT NULL,
  `id_usuario_h` int(11) NOT NULL,
  `id_reporte_h` int(11) NOT NULL,
  `puntos_h` int(11) NOT NULL,
  `motivo` varchar(355) NOT NULL,
  `fecha_h` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_puntos`
--

INSERT INTO `historial_puntos` (`id_historial`, `id_usuario_h`, `id_reporte_h`, `puntos_h`, `motivo`, `fecha_h`) VALUES
(4, 2, 9, 10, 'Mucha basura en esta locación!', '2025-12-15 21:03:46'),
(5, 12, 9, 10, '', '2025-12-15 21:05:21'),
(6, 2, 10, 10, 'Luminaria rota!!!', '2025-12-16 17:33:48'),
(7, 12, 10, 10, '', '2025-12-16 17:39:27'),
(9, 2, 12, 10, 'Poso muy grande aquí!!!', '2025-12-16 20:00:19'),
(10, 2, 13, 10, 'Se perdió un perro en este lugar!!', '2025-12-17 11:36:36'),
(11, 2, 14, 10, 'xxxx', '2025-12-19 16:22:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id_mensaje` int(11) NOT NULL,
  `usuario_m` varchar(255) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `mensaje` varchar(355) NOT NULL,
  `respuesta` varchar(355) NOT NULL,
  `estado_m` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id_mensaje`, `usuario_m`, `fecha`, `mensaje`, `respuesta`, `estado_m`) VALUES
(1, '2', '2025-12-17 16:16:21', 'El bache se pudo arreglar?', 'Si pudimos arreglar el bache. Gracias por preguntar!', 1),
(2, '2', '2025-12-17 16:28:10', 'Perdón, se encontró el perrito?.', '', 0),
(3, '12', '2025-12-17 16:56:51', 'Les llego el dinero para las colaboraciones?', 'Hola, si nos llego el dinero para la colaboración. Muchas gracias!', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

CREATE TABLE `reportes` (
  `id_reporte` int(11) NOT NULL,
  `id_usuario_r` int(11) NOT NULL,
  `id_categoria_r` int(11) NOT NULL,
  `descripcion_reporte` varchar(255) NOT NULL,
  `latitud` double NOT NULL,
  `longitud` double NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `estado_reporte` varchar(255) NOT NULL DEFAULT 'pendiente',
  `foto` varchar(355) NOT NULL,
  `captura` varchar(255) NOT NULL,
  `observacion_r` varchar(355) NOT NULL,
  `valido` varchar(355) NOT NULL DEFAULT 'si'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reportes`
--

INSERT INTO `reportes` (`id_reporte`, `id_usuario_r`, `id_categoria_r`, `descripcion_reporte`, `latitud`, `longitud`, `fecha`, `estado_reporte`, `foto`, `captura`, `observacion_r`, `valido`) VALUES
(9, 2, 5, 'Mucha basura en esta locación!', -35.48821557834367, -62.98517879815233, '2025-12-16 01:03:00', 'resuelto', './vacio/vacio.png', '', '', 'si'),
(10, 2, 2, 'Luminaria rota!!!', -35.49118753769104, -62.965440680544624, '2025-12-16 21:33:00', 'resuelto', './upload/1765917228ejemplo.jpg', '', '', 'si'),
(12, 2, 1, 'Poso muy grande aquí!!!', -35.4796487275982, -62.9720486590481, '2025-12-16 23:59:00', 'en_proceso', './vacio/vacio.png', '', 'Se cambia el estado porque se pudo verificar el reporte.', 'si'),
(13, 2, 3, 'Se perdió un perro en este lugar!!', -35.49101271959565, -62.98406316541799, '2025-12-17 15:35:00', 'pendiente', './vacio/vacio.png', '', '', 'si'),
(14, 2, 1, 'xxxx', -35.49230636449483, -62.96737355599856, '2025-12-19 20:22:00', 'pendiente', './vacio/vacio.png', './mapa/captura1766172148.png', 'Error!', 'no');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte_estado`
--

CREATE TABLE `reporte_estado` (
  `id_estado_reporte` int(11) NOT NULL,
  `descripcion_estado` varchar(355) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reporte_estado`
--

INSERT INTO `reporte_estado` (`id_estado_reporte`, `descripcion_estado`) VALUES
(1, 'pendiente'),
(2, 'en_proceso'),
(5, 'resuelto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuarios`
--

CREATE TABLE `tipo_usuarios` (
  `id_tipo_usuario` int(11) NOT NULL,
  `descripcion_tipo_usuario` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_usuarios`
--

INSERT INTO `tipo_usuarios` (`id_tipo_usuario`, `descripcion_tipo_usuario`) VALUES
(1, 'municipio'),
(2, 'empresa'),
(3, 'vecino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_u` varchar(255) NOT NULL,
  `email_u` varchar(255) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `tipo_u` int(11) NOT NULL,
  `cuil` bigint(20) NOT NULL,
  `maravilla` varchar(355) NOT NULL,
  `observacion` varchar(355) NOT NULL,
  `valor_estado` varchar(255) NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_u`, `email_u`, `clave`, `tipo_u`, `cuil`, `maravilla`, `observacion`, `valor_estado`) VALUES
(1, 'Rubén Darío Velazquez', 'rdvelazquez1979@gmail.com', 'admin', 1, 0, '', '', 'activo'),
(2, 'Verónica Daniela Coronel', 'vdcoronel@gmail.com', 'veronica', 3, 0, '', '', 'activo'),
(12, 'Luz Velazquez Coronel', 'luzvc@gmail.com', 'luz', 2, 20510860265, 'La Luz-super', '', 'activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `colaboraciones_empresas`
--
ALTER TABLE `colaboraciones_empresas`
  ADD PRIMARY KEY (`id_colaboracion`),
  ADD KEY `id_empresa_usuario` (`id_empresa_usuario`),
  ADD KEY `id_reporte_c` (`id_reporte_c`);

--
-- Indices de la tabla `historial_puntos`
--
ALTER TABLE `historial_puntos`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `id_usuario_h` (`id_usuario_h`),
  ADD KEY `id_reporte_h` (`id_reporte_h`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id_mensaje`);

--
-- Indices de la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`id_reporte`),
  ADD KEY `id_usuario_r` (`id_usuario_r`),
  ADD KEY `id_categoria_r` (`id_categoria_r`);

--
-- Indices de la tabla `reporte_estado`
--
ALTER TABLE `reporte_estado`
  ADD PRIMARY KEY (`id_estado_reporte`);

--
-- Indices de la tabla `tipo_usuarios`
--
ALTER TABLE `tipo_usuarios`
  ADD PRIMARY KEY (`id_tipo_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `tipo_u` (`tipo_u`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `colaboraciones_empresas`
--
ALTER TABLE `colaboraciones_empresas`
  MODIFY `id_colaboracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `historial_puntos`
--
ALTER TABLE `historial_puntos`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id_mensaje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `reportes`
--
ALTER TABLE `reportes`
  MODIFY `id_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `reporte_estado`
--
ALTER TABLE `reporte_estado`
  MODIFY `id_estado_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo_usuarios`
--
ALTER TABLE `tipo_usuarios`
  MODIFY `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `colaboraciones_empresas`
--
ALTER TABLE `colaboraciones_empresas`
  ADD CONSTRAINT `colaboraciones_empresas_ibfk_1` FOREIGN KEY (`id_empresa_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `colaboraciones_empresas_ibfk_2` FOREIGN KEY (`id_reporte_c`) REFERENCES `reportes` (`id_reporte`);

--
-- Filtros para la tabla `historial_puntos`
--
ALTER TABLE `historial_puntos`
  ADD CONSTRAINT `historial_puntos_ibfk_1` FOREIGN KEY (`id_usuario_h`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `historial_puntos_ibfk_2` FOREIGN KEY (`id_reporte_h`) REFERENCES `reportes` (`id_reporte`);

--
-- Filtros para la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD CONSTRAINT `reportes_ibfk_1` FOREIGN KEY (`id_usuario_r`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `reportes_ibfk_2` FOREIGN KEY (`id_categoria_r`) REFERENCES `categoria` (`id_categoria`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`tipo_u`) REFERENCES `tipo_usuarios` (`id_tipo_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
