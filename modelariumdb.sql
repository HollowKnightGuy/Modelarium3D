-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-06-2023 a las 15:24:05
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `modelariumdb`
--
CREATE DATABASE IF NOT EXISTS `modelariumdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `modelariumdb`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_modelo` int(11) NOT NULL,
  `fecha_subida` datetime NOT NULL,
  `reportado` int(1) DEFAULT NULL,
  `contenido` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_modelo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `favoritos`
--

INSERT INTO `favoritos` (`id`, `id_usuario`, `id_modelo`) VALUES
(151, 66, 167),
(152, 78, 167);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_modelo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `likes`
--

INSERT INTO `likes` (`id`, `id_usuario`, `id_modelo`) VALUES
(140, 78, 167);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelos`
--

CREATE TABLE `modelos` (
  `id` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `descripcion` text NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `archivo_modelo` text NOT NULL,
  `foto_modelo` text NOT NULL,
  `precio` float NOT NULL,
  `fecha_subida` text DEFAULT NULL,
  `privado` tinyint(1) NOT NULL DEFAULT 0,
  `estado` text NOT NULL DEFAULT 'pendiente',
  `num_likes` int(11) DEFAULT NULL,
  `num_favs` int(11) DEFAULT NULL,
  `num_comment` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modelos`
--

INSERT INTO `modelos` (`id`, `titulo`, `descripcion`, `id_usuario`, `archivo_modelo`, `foto_modelo`, `precio`, `fecha_subida`, `privado`, `estado`, `num_likes`, `num_favs`, `num_comment`) VALUES
(167, 'Primer modelo updated ', 'Mi primer modelo updated updated updated', 78, 'arcade(2).glb', 'square.png', 18, '2023-06-14 11:38:08', 0, 'subido', 1, 2, NULL),
(172, 'Cactus', 'Cactus Lowpoly', 78, '3dmodel6489b85230f50cactus.glb', 'imgmodel6489b85230f58cactus.jpg', 4.99, '2023-06-14 14:53:38', 0, 'subido', NULL, NULL, NULL),
(173, 'Arcade Machine', 'Retro Arcade Machine Lowpoly', 78, '3dmodel6489b8a6a69d7arcade.glb', 'imgmodel6489b8a6a69e3arcade.jpg', 15, '2023-06-14 14:55:02', 0, 'subido', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peticiones`
--

CREATE TABLE `peticiones` (
  `id` int(11) NOT NULL,
  `id_modelo` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_comentario` int(11) DEFAULT NULL,
  `tipo` char(2) NOT NULL,
  `estado` text NOT NULL DEFAULT 'pendiente',
  `fecha_peticion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `rol` text NOT NULL,
  `nombre` text NOT NULL,
  `email` text NOT NULL,
  `pp_email` text DEFAULT NULL,
  `password` text NOT NULL,
  `descripcion` text DEFAULT NULL,
  `foto_perfil` text NOT NULL,
  `banner` text DEFAULT NULL,
  `ganancias` int(11) DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `rol`, `nombre`, `email`, `pp_email`, `password`, `descripcion`, `foto_perfil`, `banner`, `ganancias`, `fecha_creacion`) VALUES
(66, 'ROLE_ADMIN', 'Pog', 'pog@admin.com', '', '$2y$10$dfHmRR8A6wemgOOqUk8DZ.IBRii0cn7/S.LEH.xkdS/oMIV89bZvG', '', 'img647de2796c714hollow.png', 'img647de2adbb9a9hollowbg.jpg', NULL, '2023-06-05 15:26:17'),
(78, 'ROLE_CREATOR', 'Pablo Cid Olmos', 'pcid@gmail.com', NULL, '$2y$10$8mim9m2jJa9COaj6.51NcOdyd/T2WGoqhlTefn3slSC3/zXqvBmka', 'Creador veterano de Modelarium', 'img64898a3e206ecsquare.png', NULL, NULL, '2023-06-14 11:37:02'),
(79, 'ROLE_ADMIN', 'Admin', 'admin@gmail.es', NULL, '$2y$10$N5RcCLErfjo04BIwEahN3eN.nPNZzF2d4Wd6Z6yvsgWpGEftsnW4m', 'admin', 'img64898ad14cdc5square.png', NULL, NULL, '2023-06-14 11:39:29'),
(81, 'ROLE_CREATOR', 'Pablo Ortiz Gervilla', 'pablogervilla123@gmail.com', NULL, '$2y$10$4GulZLaGqX5SDrq5WUvSi.3pERGqwaxDRC0fOXCebdcDtnrwuV2B6', 'Creador de Modelarium3D', 'img64899cfadfe61hollow.jpg', 'img64899d0ac9104maxresdefault.jpg', NULL, '2023-06-14 12:53:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `id_usuario_creador` int(11) NOT NULL,
  `id_usuario_comprador` int(11) NOT NULL,
  `id_modelo` int(11) NOT NULL,
  `fecha_venta` datetime NOT NULL,
  `precio_venta` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `id_usuario_creador`, `id_usuario_comprador`, `id_modelo`, `fecha_venta`, `precio_venta`) VALUES
(29, 78, 78, 167, '2023-06-14 13:05:42', 18);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_modelo` (`id_modelo`);

--
-- Indices de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_modelo` (`id_modelo`);

--
-- Indices de la tabla `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_modelo` (`id_modelo`);

--
-- Indices de la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `peticiones`
--
ALTER TABLE `peticiones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_modelo` (`id_modelo`),
  ADD KEY `id_comentario` (`id_comentario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario_comprador` (`id_usuario_comprador`),
  ADD KEY `id_usuario_creador` (`id_usuario_creador`),
  ADD KEY `id_modelo` (`id_modelo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT de la tabla `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT de la tabla `modelos`
--
ALTER TABLE `modelos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT de la tabla `peticiones`
--
ALTER TABLE `peticiones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`id_modelo`) REFERENCES `modelos` (`id`);

--
-- Filtros para la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `favoritos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `favoritos_ibfk_2` FOREIGN KEY (`id_modelo`) REFERENCES `modelos` (`id`);

--
-- Filtros para la tabla `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`id_modelo`) REFERENCES `modelos` (`id`);

--
-- Filtros para la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD CONSTRAINT `modelos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `peticiones`
--
ALTER TABLE `peticiones`
  ADD CONSTRAINT `peticiones_ibfk_1` FOREIGN KEY (`id_comentario`) REFERENCES `comentarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
