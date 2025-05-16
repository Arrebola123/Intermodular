-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-03-2025 a las 17:57:32
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda_relojes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` char(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(3, 'lujo'),
(4, 'accesible'),
(5, 'icónico'),
(6, 'clasico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_usuario` int(11) NOT NULL,
  `correo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_usuario`, `correo`) VALUES
(2, 'alejandrooar03@gmail.com'),
(3, 'sergio@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colaborar`
--

CREATE TABLE `colaborar` (
  `id_proveedor1` int(11) NOT NULL,
  `id_proveedor2` int(11) NOT NULL,
  `nuevos productos` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprar`
--

CREATE TABLE `comprar` (
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_usuario` int(11) NOT NULL,
  `fecha_contratacion` date NOT NULL,
  `rol` char(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_usuario`, `fecha_contratacion`, `rol`) VALUES
(12, '2025-02-25', 'Gerente de tienda');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generar`
--

CREATE TABLE `generar` (
  `id_informe` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informes`
--

CREATE TABLE `informes` (
  `id` int(11) NOT NULL,
  `nombre del cliente` char(25) NOT NULL,
  `codigo del producto` int(11) NOT NULL,
  `fecha de compra` date NOT NULL,
  `importe total gastado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `id` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `logo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`id`, `nombre`, `logo`) VALUES
(2, 'Tissot', 'logos/logo_tissot.png'),
(3, 'Rolex', 'logos/logo_rolex.png'),
(4, 'Omega', 'logos/logo-omega.png'),
(8, 'Seiko', 'logos/logo-seiko2.1.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos_de_pago`
--

CREATE TABLE `metodos_de_pago` (
  `id` int(11) NOT NULL,
  `tipo_de_pago` char(25) DEFAULT NULL,
  `detalles_de_pago` varchar(75) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `organizar`
--

CREATE TABLE `organizar` (
  `id_producto` int(11) NOT NULL,
  `id_subasta` int(11) NOT NULL,
  `id_pujas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagar`
--

CREATE TABLE `pagar` (
  `id_cliente` int(11) NOT NULL,
  `id_pedidos` int(11) NOT NULL,
  `id_metodos_de_pago` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `precio` double NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `fecha`, `estado`, `precio`, `id_usuario`) VALUES
(13, '2025-02-23', 0, -146170, 2),
(14, '2025-02-26', 0, 747700, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `numero_de_modelo` varchar(40) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `materiales` varchar(100) NOT NULL,
  `movimiento` varchar(100) NOT NULL,
  `resistencia_al_agua` varchar(100) NOT NULL,
  `cristal` varchar(100) NOT NULL,
  `precio` int(11) NOT NULL,
  `stock_disponible` int(11) NOT NULL,
  `imagen1` text NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `id_marca` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `numero_de_modelo`, `descripcion`, `materiales`, `movimiento`, `resistencia_al_agua`, `cristal`, `precio`, `stock_disponible`, `imagen1`, `id_categoria`, `id_proveedor`, `id_marca`) VALUES
(45, 'Omega Seamaster Diver 300M', '210.30.42.20.01.001', 'El Seamaster Diver 300M es un reloj de buceo que combina funcionalidad y elegancia. Su caja de acero inoxidable de 42 mm, con bisel cerámico, es extremadamente resistente y diseñada para soportar entornos acuáticos. Además, el movimiento Calibre 8800 ofrece una alta precisión con certificación COSC y una resistencia al agua de 300 metros. Es ideal tanto para el buceador profesional como para quienes buscan un reloj duradero para el día a día.', 'Caja de acero inoxidable, bisel cerámico, brazalete de acero.', 'Calibre 8800 automático, cronómetro certificado.', '300 metros.', 'Zafiro antirreflejo.', 5200, 6, 'imgs/Omega Seamaster Diver 300M.png', 5, 1, 4),
(46, 'Omega Speedmaster Professional Moonwatch', '311.30.42.30.01.005', 'El Speedmaster Moonwatch es un reloj histórico y técnico que acompaña a los astronautas en sus misiones espaciales. Su diseño de cronógrafo clásico con una caja de acero inoxidable y un movimiento manual Calibre 1861 es ideal para quienes buscan un reloj robusto y de alto rendimiento. La resistencia al agua es de 50 metros, lo que lo hace adecuado para un uso cotidiano, aunque su verdadera esencia es su legado como el primer reloj usado en la Luna.', 'Caja de acero inoxidable, cristal de Hesalite.', 'Calibre 1861 manual.', '50 metros.', 'Hesalite.', 5800, 8, 'imgs/Omega Speedmaster Professional Moonwatch.png', 6, 2, 4),
(47, 'Tissot Le Locle Automatic', 'T41.1.423.33', 'El Tissot Le Locle Automatic es un reloj de diseño clásico y elegante, perfecto para quienes buscan una pieza accesible pero de alta calidad. Su caja de acero inoxidable de 39 mm es complementada por un movimiento automático Calibre 2824-2, reconocido por su precisión y fiabilidad. Con una resistencia al agua de 30 metros y un cristal de zafiro, es una excelente opción para aquellos que valoran la tradición y la durabilidad.', 'Caja de acero inoxidable, correa de cuero.', 'Calibre 2824-2 automático.', '30 metros.', 'Zafiro.', 450, 12, 'imgs/Tissot Le Locle Automatic.png', 4, 2, 2),
(48, 'Rolex Submariner Date', '126610LN', 'El Rolex Submariner Date es el reloj de buceo por excelencia, conocido por su fiabilidad y resistencia. Con una caja de acero inoxidable de 41 mm, su movimiento Calibre 3235 es preciso y certificado como cronómetro. Su resistencia al agua de 300 metros y el bisel cerámico lo hacen perfecto para el buceo profesional, mientras que su diseño atemporal lo convierte en una pieza deseable para cualquier ocasión.', 'Caja de acero inoxidable 904L, bisel cerámico, brazalete Oystersteel.', 'Calibre 3235 automático, cronómetro certificado.', '300 metros.', 'Zafiro.', 10000, 4, 'imgs/Rolex Submariner Date.png', 3, 1, 3),
(49, 'Seiko 5 Sports', 'SRPD55K1', 'El Seiko 5 Sports es un reloj automático accesible y robusto, ideal para el uso diario. Con una caja de acero inoxidable y un movimiento automático Calibre 4R36, este reloj es conocido por su fiabilidad y durabilidad. Su resistencia al agua de 100 metros y su cristal Hardlex lo convierten en una opción económica pero de alta calidad.', 'Caja de acero inoxidable, correa de nylon.', 'Calibre 4R36 automático.', '100 metros.', 'Hardlex.', 150, 20, 'imgs/Seiko 5 Sports.png', 4, 2, 8),
(50, 'Rolex Datejust 41', '126334', 'El Rolex Datejust 41 es un reloj icónico, con una caja de 41 mm y un diseño elegante que lo hace adecuado para cualquier ocasión. Su movimiento Calibre 3235 es conocido por su precisión y eficiencia. Además, cuenta con una resistencia al agua de 100 metros, lo que lo convierte en un reloj funcional y versátil.', 'Caja de acero inoxidable 904L, bisel de acero o de oro.', 'Calibre 3235 automático, cronómetro certificado.', '100 metros.', 'Zafiro.', 8000, 5, 'imgs/Rolex-Dayjust-41.png', 3, 2, 3),
(51, 'Omega Constellation Co-Axial Master Chronometer', '131.10.39.20.02.001', 'El Constellation Co-Axial Master Chronometer es un reloj de lujo con un diseño elegante que incorpora el exclusivo movimiento automático Calibre 8800. Es conocido por su caja de acero inoxidable y su bisel de oro, con detalles finos que lo hacen ideal para ocasiones formales. Además, su resistencia al agua de 50 metros y su cristal de zafiro lo hacen funcional y elegante al mismo tiempo.\r\nMateriales: Caja de acero inoxidable, bisel de oro, brazalete de acero.', 'Caja de acero inoxidable, bisel de oro, brazalete de acero.', 'Calibre 8800 automático.', '50 metros.', 'Zafiro.', 4500, 7, 'imgs/Omega Constellation Co-Axial Master Chronometer.png', 6, 2, 4),
(52, 'Omega De Ville Trésor', '431.13.42.21.02.001', 'El De Ville Trésor es un reloj sofisticado y minimalista, ideal para quienes buscan un reloj de vestir de alta calidad. Con una caja de acero inoxidable de 40 mm y un movimiento automático Calibre 8910, el De Ville Trésor destaca por su elegancia, con detalles finos que lo hacen perfecto para ocasiones especiales. Su resistencia al agua de 30 metros y su cristal de zafiro garantizan durabilidad y estilo.', 'Caja de acero inoxidable, correa de cuero.', 'Calibre 8910 automático.', '30 metros.', 'Zafiro.', 6000, 5, 'imgs/Omega De Ville Tresor.png', 5, 1, 4),
(53, 'Tissot PRX Quartz', 'T137.410.11.041.00', 'El Tissot PRX Quartz destaca por su diseño retro y deportivo, ofreciendo una caja delgada de acero inoxidable y un movimiento de cuarzo ETA F06.115 de alta precisión. Su estilo de los años 70 lo convierte en una pieza moderna con un toque nostálgico, ideal tanto para ocasiones formales como informales. Además, cuenta con una resistencia al agua de 100 metros y un cristal de zafiro, que le otorgan gran durabilidad.', 'Caja de acero inoxidable, brazalete de acero inoxidable.', 'Calibre ETA F06.115 cuarzo.', '100 metros.', 'Zafiro.', 375, 12, 'imgs/Tissot PRX Quartz.png', 4, 1, 2),
(54, 'Tissot T-Touch Expert Solar', 'T0914204405100', 'El Tissot T-Touch Expert Solar es un reloj multifuncional con pantalla táctil, diseñado para los aventureros y las personas activas. Alimentado por energía solar, este reloj ofrece una variedad de funciones útiles como altímetro, brújula y cronógrafo. Su resistencia al agua de 100 metros y su cristal de zafiro aseguran que sea un reloj durable y preciso en todas las condiciones.', 'Caja de acero inoxidable, brazalete de caucho.', 'Cuarzo solar.', '100 metros.', 'Zafiro.', 750, 8, 'imgs/Tissot T-Touch Expert Solar.png', 4, 2, 2),
(55, 'Tissot Couturier Chronograph', 'T035.617.11.051.00', 'El Tissot Couturier Chronograph combina la funcionalidad de un cronógrafo con un diseño elegante y deportivo. Su caja de acero inoxidable de 42 mm y el movimiento de cuarzo ETA 251.262 garantizan precisión y fiabilidad. Además, cuenta con una resistencia al agua de 100 metros y un cristal de zafiro, lo que lo convierte en una excelente opción tanto para el uso diario como para ocasiones más formales.', 'Caja de acero inoxidable, correa de cuero.', 'Calibre ETA 251.262 cuarzo.', '100 metros.', 'Zafiro.', 500, 10, 'imgs/Tissot Couturier Chronograph.png', 4, 2, 2),
(56, 'Rolex Daytona', '116500LN', 'El Rolex Daytona es un cronógrafo de lujo, conocido por su relación con las carreras de coches y su precisión inigualable. Con su caja de acero inoxidable y el movimiento Calibre 4130, es perfecto para quienes buscan un reloj de alto rendimiento. La resistencia al agua de 100 metros lo hace ideal tanto para el uso deportivo como para ocasiones más formales.', 'Caja de acero inoxidable 904L, bisel cerámico.', 'Calibre 4130 automático, cronómetro certificado.', '100 metros.', 'Zafiro.', 13000, 6, 'imgs/Rolex-Daytona.png', 3, 1, 3),
(57, 'Rolex GMT-Master II', '126710BLRO', 'El Rolex GMT-Master II es un reloj de viajeros, conocido por su capacidad de mostrar dos zonas horarias al mismo tiempo. Con una caja de acero inoxidable de 40 mm y un bisel cerámico bicolor, este reloj combina funcionalidad y estilo. El movimiento Calibre 3285 asegura precisión, y su resistencia al agua de 100 metros lo convierte en un reloj confiable para cualquier tipo de uso.', 'Caja de acero inoxidable 904L, bisel cerámico.', 'Calibre 3285 automático, cronómetro certificado.', '100 metros.', 'Zafiro.', 9500, 4, 'imgs/Rolex GMT-Master II.png', 3, 2, 3),
(58, 'Seiko Presage Cocktail Time', 'SRPB43J1', 'El Seiko Presage Cocktail Time es un reloj elegante con un diseño inspirado en cócteles. Su movimiento automático Calibre 4R35 ofrece una excelente precisión. Con una resistencia al agua de 50 metros y un cristal Hardlex, es una excelente opción para quienes buscan un reloj de vestir asequible pero sofisticado.', 'Caja de acero inoxidable, correa de cuero.', 'Calibre 4R35 automático.', '50 metros.', 'Hardlex.', 400, 8, 'imgs/Seiko Presage Cocktail Time.jpg', 6, 1, 8),
(59, 'Seiko Turtle Automatic', 'SRP777', 'El Seiko Turtle Automatic es un reloj de buceo con una caja de forma \"turtle\" que lo hace fácilmente reconocible. Con un movimiento automático Calibre 4R36 y una resistencia al agua de 200 metros, es ideal para actividades acuáticas. Su cristal Hardlex le da una alta durabilidad, siendo perfecto para el uso diario.', 'Caja de acero inoxidable, correa de caucho.', 'Calibre 4R36 automático.', '200 metros.', 'Hardlex.', 500, 9, 'imgs/Seiko Turtle Automatic.png', 4, 1, 8),
(60, 'Seiko Astron GPS Solar', 'SSH007', 'El Seiko Astron GPS Solar es un reloj inteligente que se ajusta automáticamente a la hora correcta mediante GPS. Alimentado por energía solar y con un movimiento Calibre 8X22, es ideal para los viajeros frecuentes. Su resistencia al agua de 100 metros y el cristal zafiro lo hacen un reloj sofisticado y funcional.', 'Caja de titanio, brazalete de titanio.', 'Calibre 8X22 GPS solar.', '100 metros.', 'Zafiro.', 2000, 5, 'imgs/Seiko Astron GPS Solar.png', 5, 1, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `nombre` char(30) NOT NULL,
  `contacto` int(11) NOT NULL,
  `dirección` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `contacto`, `dirección`) VALUES
(1, 'rick Industries', 123456789, 'calle rick 24'),
(2, 'alex Industries', 987654321, 'calle alex 45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pujas`
--

CREATE TABLE `pujas` (
  `id` int(11) NOT NULL,
  `precio` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subastas`
--

CREATE TABLE `subastas` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `productos` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `dni` char(9) NOT NULL,
  `nombre` char(25) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `administrador` tinyint(1) NOT NULL,
  `imagen` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `dni`, `nombre`, `contraseña`, `administrador`, `imagen`) VALUES
(2, '4937567L', 'Alejandro', '$2y$10$BYIySWfx0RtKdxCGu7fVHeEH1LJeAy1/adZ4FwFguXFWILeOQCCQe', 0, ''),
(3, '4937567A', 'Sergio', '$2y$10$HX4MaXhCqed3nTpPqXnVHODptnfslLy.Y3zAB7KnmvAfo6Jdg3Ja2', 0, ''),
(12, '12345678A', 'Admin', '$2y$10$1gp0GGRuQ2jhuFDzXa4cdubZ04zRzaB3lsBMO/aH.kYT1PevSHFJG', 1, '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `colaborar`
--
ALTER TABLE `colaborar`
  ADD PRIMARY KEY (`id_proveedor1`,`id_proveedor2`) USING BTREE,
  ADD KEY `fk_colaborar_proveedor2` (`id_proveedor2`);

--
-- Indices de la tabla `comprar`
--
ALTER TABLE `comprar`
  ADD PRIMARY KEY (`id_pedido`,`id_producto`,`id_usuario`),
  ADD KEY `fk_comprar_producto` (`id_producto`),
  ADD KEY `fk_comprar_usuario` (`id_usuario`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `generar`
--
ALTER TABLE `generar`
  ADD PRIMARY KEY (`id_informe`,`id_pedido`,`id_producto`,`id_cliente`),
  ADD UNIQUE KEY `unica` (`id_informe`,`id_pedido`,`id_producto`,`id_cliente`),
  ADD KEY `fk_generar_producto` (`id_producto`),
  ADD KEY `fk_generar_cliente` (`id_cliente`),
  ADD KEY `fk_generar_pedido` (`id_pedido`);

--
-- Indices de la tabla `informes`
--
ALTER TABLE `informes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `metodos_de_pago`
--
ALTER TABLE `metodos_de_pago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `organizar`
--
ALTER TABLE `organizar`
  ADD PRIMARY KEY (`id_producto`,`id_pujas`),
  ADD KEY `fk_organizar_pujas` (`id_pujas`),
  ADD KEY `fk_organizar_subasta` (`id_subasta`);

--
-- Indices de la tabla `pagar`
--
ALTER TABLE `pagar`
  ADD PRIMARY KEY (`id_pedidos`,`id_metodos_de_pago`,`id_cliente`) USING BTREE,
  ADD KEY `fk_pagar_cliente` (`id_cliente`),
  ADD KEY `fk_pagar_metodo` (`id_metodos_de_pago`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pedidos_usuario` (`id_usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_productos_categoria` (`id_categoria`),
  ADD KEY `fk_productos_proveedor` (`id_proveedor`),
  ADD KEY `fk_productos_marca` (`id_marca`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pujas`
--
ALTER TABLE `pujas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pujas_cliente` (`id_cliente`);

--
-- Indices de la tabla `subastas`
--
ALTER TABLE `subastas`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `informes`
--
ALTER TABLE `informes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `metodos_de_pago`
--
ALTER TABLE `metodos_de_pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pujas`
--
ALTER TABLE `pujas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `subastas`
--
ALTER TABLE `subastas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_clientes_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `colaborar`
--
ALTER TABLE `colaborar`
  ADD CONSTRAINT `fk_colaborar_proveedor1` FOREIGN KEY (`id_proveedor1`) REFERENCES `proveedores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_colaborar_proveedor2` FOREIGN KEY (`id_proveedor2`) REFERENCES `proveedores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comprar`
--
ALTER TABLE `comprar`
  ADD CONSTRAINT `fk_comprar_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comprar_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comprar_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `clientes` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `fk_empleados_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `generar`
--
ALTER TABLE `generar`
  ADD CONSTRAINT `fk_generar_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `comprar` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_generar_informe` FOREIGN KEY (`id_informe`) REFERENCES `informes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_generar_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_generar_producto` FOREIGN KEY (`id_producto`) REFERENCES `comprar` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `organizar`
--
ALTER TABLE `organizar`
  ADD CONSTRAINT `fk_organizar_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_organizar_pujas` FOREIGN KEY (`id_pujas`) REFERENCES `pujas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_organizar_subasta` FOREIGN KEY (`id_subasta`) REFERENCES `subastas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pagar`
--
ALTER TABLE `pagar`
  ADD CONSTRAINT `fk_pagar_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pagar_metodo` FOREIGN KEY (`id_metodos_de_pago`) REFERENCES `metodos_de_pago` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pagar_pedidos` FOREIGN KEY (`id_pedidos`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedidos_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_productos_marca` FOREIGN KEY (`id_marca`) REFERENCES `marca` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_productos_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pujas`
--
ALTER TABLE `pujas`
  ADD CONSTRAINT `fk_pujas_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
