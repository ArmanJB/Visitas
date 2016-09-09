CREATE DATABASE IF NOT EXISTS `seguimiento`;
USE `seguimiento`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--
DROP TABLE IF EXISTS `areas`;
CREATE TABLE `areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `meta` int(11),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de tabla para la tabla `departamento`
--
DROP TABLE IF EXISTS `departamentos`;
CREATE TABLE `departamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de tabla para la tabla `escuela`
--
DROP TABLE IF EXISTS `escuelas`;
CREATE TABLE `escuelas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `id_departamento` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `escuelas_id_departamento_fk` (`id_departamento`),
  CONSTRAINT `escuelas_id_departamento_fk` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de tabla para la tabla `motivo`
--
DROP TABLE IF EXISTS `motivos`;
CREATE TABLE `motivos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `id_area` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `motivos_id_area_fk` (`id_area`),
  CONSTRAINT `motivos_id_area_fk` FOREIGN KEY (`id_area`) REFERENCES `areas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de tabla para la tabla `oficial`
--
DROP TABLE IF EXISTS `oficiales`;
CREATE TABLE `oficiales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `id_area` int(11) NOT NULL,
  `meta` int(11),
  PRIMARY KEY (`id`),
  KEY `oficiales_id_area_fk` (`id_area`),
  CONSTRAINT `oficiales_id_area_fk` FOREIGN KEY (`id_area`) REFERENCES `areas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de tabla para la tabla `visita`
--
DROP TABLE IF EXISTS `visitas`;
CREATE TABLE `visitas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `id_escuela` int(11) NOT NULL,
  `id_oficial` int(11) NOT NULL,
  `aulas` int(11),
  PRIMARY KEY (`id`),
  KEY `visitas_id_escuela_fk` (`id_escuela`),
  CONSTRAINT `visitas_id_escuela_fk` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id`),
  KEY `visitas_id_oficial_fk` (`id_oficial`),
  CONSTRAINT `visitas_id_oficial_fk` FOREIGN KEY (`id_oficial`) REFERENCES `oficiales` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de tabla para la tabla `pendientes`
--
DROP TABLE IF EXISTS `pendientes`;
CREATE TABLE `pendientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(10000) COLLATE utf8_unicode_ci NOT NULL,
  `finalizado` tinyint(1) NOT NULL,
  `id_visita` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pendientes_id_visita_fk` (`id_visita`),
  CONSTRAINT `pendientes_id_visita_fk` FOREIGN KEY (`id_visita`) REFERENCES `visitas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de tabla para la tabla `detalle_visita`
--
DROP TABLE IF EXISTS `detalle_visita`;
CREATE TABLE `detalle_visita` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_visita` int(11) NOT NULL,
  `id_motivo` int(11) NOT NULL,
  `horas` double,
  PRIMARY KEY (`id`),
  KEY `detvisita_id_visita_fk` (`id_visita`),
  CONSTRAINT `detvisita_id_visita_fk` FOREIGN KEY (`id_visita`) REFERENCES `visitas` (`id`),
  KEY `detvisita_id_motivo_fk` (`id_motivo`),
  CONSTRAINT `detvisita_id_motivo_fk` FOREIGN KEY (`id_motivo`) REFERENCES `motivos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- ***********************************************

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1);

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administador', 'admin@admin.com', '$2y$10$0iVCZ/o1TWbQlhGsfy/OROYu8UzDzD9dGbiujFTORbCYetobsmj/i', '6M89cw5DMRROviuVV64EvRFuPZ6e4vYCt1vnZCci7WHDwKfWnM1vaHYe6Xqv', '2016-06-01 04:35:06', '2016-06-20 14:56:03'),
(2, 'FZTMobile', 'fztmobile@admin.com', '$2y$10$YKPJOauMci4/PwWITARbXezDNhNWtLmbN5/Tsi2cjZEa8Xw.SMjIW', 'lTlQtkURI6BmxXKSfk4vqxVapZAWlLYUFDCwfOgAG3nvlspFZ3pV8llzKUzn', '2016-06-03 03:38:29', '2016-06-20 14:28:12'),
(3, 'Armando Bustos', 'armanjbustos596@gmail.com', '$2y$10$cdEgezrFB/URjYn2M1OGROM0VHZjOv/lF6403KQKtCr8kP3qnmkou', 'LUSLZSVNZ8M4BX1G4yAjkRNCKGSBnNOnyw73OUCsuLz7100ChI67f50S0xwv', '2016-06-20 14:27:40', '2016-06-20 14:27:57');

ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

  ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

  ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

-- *****************************************************
INSERT INTO `areas` (`id`, `nombre`) VALUES
(1, 'Soporte Técnico'),
(2, 'Área Educativa'),
(3, 'Logística'),
(4, 'Otros');

INSERT INTO `departamentos` (`id`, `nombre`) VALUES
(1, 'Chinandega'),
(2, 'León'),
(3, 'Managua'),
(4, 'Managua/Ciudad Sandino'),
(5, 'Masaya'),
(6, 'Carazo'),
(7, 'Granada'),
(8, 'Rivas'),
(9, 'Rivas/Ometepe'),
(10, 'Madríz'),
(11, 'Matagalpa'),
(12, 'Boaco'),
(13, 'Chontales'),
(14, 'RAAN'),
(15, 'RAAS'),
(16, 'RAAS/Bluefields'),
(17, 'RAAS/Muelle de los Bueyes'),
(18, 'RAAS/Corn Island');

INSERT INTO `escuelas` (`id`, `nombre`, `id_departamento`) VALUES
(1, 'Divino Niño Jesús', 1),
(2, 'El peregrino', 1),
(3, 'Hogar San José', 1),
(4, 'Rubén Darío', 1),
(5, 'Rey Juan Carlos I', 1),
(6, 'Mercedes Vanegas Morales', 1),
(7, 'Aquespalapa', 1),
(8, 'Teresita Gonzalez', 1),
(9, 'IMABITE', 2),
(10, 'John F. Kennedy', 2),
(11, 'San Martín', 2),
(12, 'Nueva Jerusalén', 2),
(13, 'Oscar Danilo Rosales', 2),
(14, 'Base Enmanuel Mongalo', 2),
(15, 'Los Maribios', 2),
(16, 'Asunción de María', 3),
(17, 'Chiquilistagua', 3),
(18, 'San Judas Tadeo', 3),
(19, 'Anexo Juan Pablo II', 3),
(20, 'Enmanuel Mongalo', 3),
(21, 'San Francisco de Asís/CS', 3),
(22, 'Nandayosi #1', 3),
(23, 'Santa Clara de Asís', 3),
(24, 'San Francisco de Asís/SFL', 3),
(25, 'Hijos de Dios', 3),
(26, 'Miguel Larreynaga', 3),
(27, 'Liceo Benito Pititto La Bella', 3),
(28, 'Corazón de Jesús', 3),
(29, 'República de Colombia', 3),
(30, 'Divino Niño Jesús', 3),
(31, 'Divina Infantita', 3),
(32, 'Simón Bolivar', 3),
(33, 'Laura Vicuña', 5),
(34, 'Laguna de Apoyo', 5),
(35, 'Salomón de la Selva', 5),
(36, 'Sagrado Corazón de Jesús', 5),
(37, 'Enmanuel Mongalo y Rubio', 6),
(38, 'San Francisco de Asís', 6),
(39, 'Rey de Reyes', 6),
(40, 'La Esperanza', 7),
(41, 'Colegio Diocesano Inmaculada Concepción', 7),
(42, 'Jose Antonio Ruíz', 8),
(43, 'Raul Barrios Torres', 8),
(44, 'Escuela de Obrajuelos', 8),
(45, 'San Martín', 8),
(46, 'Amelia Cole', 8),
(47, 'Juana Cerda Noguera', 8),
(48, 'Los Ángeles', 10),
(49, 'Enmanuel Mongalo y Rubio', 10),
(50, 'La Grecia', 11),
(51, 'Santa Celia', 11),
(52, 'Buenos Aires', 11),
(53, 'Juan Pablo II', 11),
(54, 'La Virgen', 11),
(55, 'Roberth Shuman', 11),
(56, 'José Benito Escobar', 11),
(57, 'San Miguel', 12),
(58, 'Elaisa Sandoval Vargas', 13),
(59, 'San Esteban', 13),
(60, 'Jose Dolores Estrada', 13),
(61, 'San Pablo', 13),
(62, 'Fuente de Vida', 13),
(63, 'Las Alturas', 13),
(64, 'La Haya', 13),
(65, 'Hermida Flores Gutiérrez', 13),
(66, 'San Marcos', 13),
(67, 'Nueva Jerusalén II', 14),
(68, 'Nueva Jerusalén I', 14),
(69, 'Los Amiguitos', 14),
(70, 'Rubén Darío', 14),
(71, 'Irma Cajina', 14),
(72, 'Winston Hebert Padilla', 14),
(73, 'San Judas', 14),
(74, 'Miguel Obando Martínez', 15),
(75, 'Anexo Gruta Xavier', 4),
(76, 'Filadelfia', 4),
(77, 'Azarías', 4),
(78, 'Villa Soberana', 4),
(79, 'Bautista Betania', 4),
(80, 'Roberto Clemente Fe y Alegría', 4),
(81, 'Costa Rica', 4),
(82, 'San Francisco Xavier Fe y Alegría', 4),
(83, 'Esther Galiardy Spinella', 4),
(84, 'Luisa Amanda Espinoza', 4),
(85, 'Divino Salvador', 4),
(86, 'Hermana Maura Clarke', 4),
(87, 'Escuela Sacramento', 9),
(88, 'Nuestra Señora de Guadalupe', 9),
(89, 'Rigoberto Cabezas', 9),
(90, 'San Jose del Sur', 9),
(91, 'Escuela Israel Ometepe', 9),
(92, 'NER-Los Angeles Esquipulas', 9),
(93, 'Escuela La Concepción', 9),
(94, 'Escuela Nicarao', 9),
(95, 'Escuela CICRIN', 9),
(96, 'Escuela Bilingüe OMETEPE', 9),
(97, 'Escuela San Ramón', 9),
(98, 'NER-Merida', 9),
(99, 'Jose Dolores Estrada', 9),
(100, 'Andres Castro', 9),
(101, 'Enmanuel Mongalo', 9),
(102, 'Las Cuchillas', 9),
(103, 'NER-Balgue', 9),
(104, 'Corosal', 9),
(105, 'Madroñal', 9),
(106, 'La Esperanza', 9),
(107, 'KOOS KOSTER', 9),
(108, 'Las Cruces', 9),
(109, 'Jorge Bonch', 9),
(110, 'Santa Teresa', 9),
(111, 'Anexo Santa Ana', 9),
(112, 'Los Ramos', 9),
(113, 'Rafaela Herrera', 9),
(114, 'La Pilas', 9),
(115, 'SINTIOPE', 9),
(116, 'Pedro Joaquín Chamorro', 9),
(117, 'Ruben Dario', 9),
(118, 'Escuela San Diego', 9),
(119, 'San Miguel', 9),
(120, 'Escuela San Marcos', 9),
(121, 'Escuela San Juan Bautista', 9),
(122, 'BAUTISTA', 16),
(123, 'Nuestra Señora de Guadalupe', 16),
(124, 'El Verbo', 16),
(125, 'Virgen del Carmen', 16),
(126, 'La Escuelita', 16),
(127, 'Aharon Hogson', 16),
(128, 'Madre del Divino Pastor', 16),
(129, 'Adventista', 16),
(130, 'San Pedro', 16),
(131, 'San Mateo', 16),
(132, 'Rubén Darío', 16),
(133, 'Santa Teresita', 17),
(134, 'Rubén Darío', 17),
(135, 'El Progreso', 17),
(136, 'Madre Teresa de Calcuta', 17),
(137, 'Rigoberto Cabezas', 18),
(138, 'Heddley Wilson', 18),
(139, 'Nubia Rigby', 18),
(140, 'Trinity Bautista', 18),
(141, 'San Santiago Episcopal', 18),
(142, 'Olive Brown', 18),
(143, 'Ebenezer Bautista', 18),
(144, 'Camilo Doerfler', 18),
(145, 'Essie Nixon', 18),
(146, 'La Islita', 18);

INSERT INTO `motivos` (`id`, `nombre`, `id_area`) VALUES
(1, 'Mantenimiento de XO', 1),
(2, 'Verificación de inventario', 1),
(3, 'Capacitación docentes monitores técnicos.', 1),
(4, 'Capacitación alumnos monitores técnicos.', 1),
(5, 'Implementación de campañas de limpieza', 1),
(6, 'Implementación y seguimiento Plan EA', 1),
(7, 'Devolución de XO reparadas o atendidas', 1),
(8, 'Retiro de equipos', 1),
(9, 'Revisión de conectividad', 1),
(10, 'Acompañamiento educativo', 2),
(11, 'Desarrollo de talleres', 2),
(12, 'Capacitación a padres de familia', 2),
(13, 'Familiarización en escuelas', 2),
(14, 'Preparación y seguimiento de plan EA', 2),
(15, 'Recolección de información en la escuela', 2),
(16, 'Entrega de XO', 3),
(17, 'Devolución de XO', 3),
(18, 'Preparación para entregas', 3),
(19, 'Reunión con autoridades de la zona', 3),
(20, 'Reunión con directores de la zona', 3),
(21, 'Reunión con voluntarios', 3),
(22, 'Reunión con director y docentes', 4),
(23, 'Reunión con padres de familia', 4),
(24, 'Recolección de Historias de éxito', 4),
(25, 'Información para donantes.', 4),
(26, 'Charlas a estudiantes', 4),
(27, 'Programas con voluntarios', 4);

INSERT INTO `oficiales` (`id`, `nombres`, `apellidos`, `id_area`) VALUES
(1, 'Dayton', 'Calderón', 1),
(2, 'Jairo', 'Gonzalez', 1),
(3, 'José Alberto', 'Bosque', 1),
(4, 'Karen', 'Martínez', 1),
(5, 'Kennedy', 'Simmons', 1),
(6, 'Linton', 'Ugarte', 1),
(7, 'Marlen', 'Flores', 1),
(8, 'Roxana', 'Rodríguez', 1),
(9, 'Seneyda', 'García', 1),
(10, 'Anielka', 'Oviedo', 2),
(11, 'Bianora', 'Alvarez', 2),
(12, 'Claudia', 'Moreno', 2),
(13, 'Ezer', 'Calderón', 2),
(14, 'Frannia', 'Araquistain', 2),
(15, 'Heriberto', 'Méndez', 2),
(16, 'Junieth', 'Bello', 2),
(17, 'Luz Amanda', 'Benavides', 2),
(18, 'María Magdalena', 'Hernández', 2),
(19, 'Juan Otoniel', 'Saldaña', 2),
(20, 'Nayiris', 'Urbina', 2),
(21, 'Yania', 'Amador', 2),
(22, 'Magda', 'Aguirre', 3);

