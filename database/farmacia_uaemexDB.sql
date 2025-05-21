-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-05-2025 a las 06:52:19
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
-- Base de datos: `farmacia_uaemex`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `tipo` enum('entrada','salida') NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`id`, `producto_id`, `cantidad`, `tipo`, `fecha`, `usuario_id`) VALUES
(1, 1, 20, 'entrada', '2025-05-10 22:44:01', 1),
(2, 2, 10, 'salida', '2025-05-10 22:44:01', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `precio` decimal(10,2) NOT NULL,
  `proveedor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `stock`, `precio`, `proveedor_id`) VALUES
(1, 'Paracetamol 500mg', 'Analg?sico y antipir?tico', 50, 25.00, 1),
(2, 'Ibuprofeno 200mg', 'Antiinflamatorio no esteroideo', 30, 32.50, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `contacto` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `contacto`, `email`) VALUES
(1, 'Farmac?utica SA', 'Juan Torres', 'contacto@farmaceuticasa.com'),
(2, 'Distribuidora Delta', 'Laura Ruiz', 'ventas@deltadistrib.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'Administrador'),
(4, 'Alumno'),
(3, 'Auditor'),
(2, 'Inventario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `contrasena`, `rol_id`) VALUES
(1, 'Kas Neri', 'kas_neri@uaemex.mx', '$2y$10$CfihQfTLAT4G3eiKvqnzmO2/ndrKqO4IWRKNuFF03StHuGKI2shma', 1),
(2, 'Luis Gómez', 'alumno@uaemex.mx', '$2y$10$CfihQfTLAT4G3eiKvqnzmO2/ndrKqO4IWRKNuFF03StHuGKI2shma', 4);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_movimientos_detalle`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_movimientos_detalle` (
`id` int(11)
,`producto` varchar(100)
,`cantidad` int(11)
,`tipo` enum('entrada','salida')
,`fecha` datetime
,`usuario` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_productos_bajo_stock`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_productos_bajo_stock` (
`id` int(11)
,`nombre` varchar(100)
,`stock` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_stock_productos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_stock_productos` (
`id` int(11)
,`nombre` varchar(100)
,`descripcion` text
,`stock` int(11)
,`precio` decimal(10,2)
,`proveedor` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_usuarios_roles`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_usuarios_roles` (
`id` int(11)
,`nombre` varchar(100)
,`correo` varchar(100)
,`rol` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_movimientos_detalle`
--
DROP TABLE IF EXISTS `vista_movimientos_detalle`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_movimientos_detalle`  AS SELECT `m`.`id` AS `id`, `p`.`nombre` AS `producto`, `m`.`cantidad` AS `cantidad`, `m`.`tipo` AS `tipo`, `m`.`fecha` AS `fecha`, `u`.`nombre` AS `usuario` FROM ((`movimientos` `m` join `productos` `p` on(`m`.`producto_id` = `p`.`id`)) join `usuarios` `u` on(`m`.`usuario_id` = `u`.`id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_productos_bajo_stock`
--
DROP TABLE IF EXISTS `vista_productos_bajo_stock`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_productos_bajo_stock`  AS SELECT `productos`.`id` AS `id`, `productos`.`nombre` AS `nombre`, `productos`.`stock` AS `stock` FROM `productos` WHERE `productos`.`stock` < 10 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_stock_productos`
--
DROP TABLE IF EXISTS `vista_stock_productos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_stock_productos`  AS SELECT `productos`.`id` AS `id`, `productos`.`nombre` AS `nombre`, `productos`.`descripcion` AS `descripcion`, `productos`.`stock` AS `stock`, `productos`.`precio` AS `precio`, `proveedores`.`nombre` AS `proveedor` FROM (`productos` join `proveedores` on(`productos`.`proveedor_id` = `proveedores`.`id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_usuarios_roles`
--
DROP TABLE IF EXISTS `vista_usuarios_roles`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_usuarios_roles`  AS SELECT `usuarios`.`id` AS `id`, `usuarios`.`nombre` AS `nombre`, `usuarios`.`correo` AS `correo`, `roles`.`nombre` AS `rol` FROM (`usuarios` join `roles` on(`usuarios`.`rol_id` = `roles`.`id`)) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proveedor_id` (`proveedor_id`),
  ADD KEY `idx_producto_nombre` (`nombre`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `rol_id` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `movimientos_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `movimientos_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
