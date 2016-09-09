CREATE DATABASE IF NOT EXISTS `seguimientofzt`;
USE `seguimientofzt`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--
DROP TABLE IF EXISTS `areas`;
CREATE TABLE `areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
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

-- Estructura de tabla para la tabla `periodo`
--
DROP TABLE IF EXISTS `periodos`;
CREATE TABLE `periodos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mes` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `anio` int(11) NOT NULL,
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

-- Estructura de tabla para la tabla `detalle`
--
DROP TABLE IF EXISTS `detalles`;
CREATE TABLE `detalles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `id_motivo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `detalles_id_motivo_fk` (`id_motivo`),
  CONSTRAINT `detalles_id_motivo_fk` FOREIGN KEY (`id_motivo`) REFERENCES `motivos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de tabla para la tabla `oficial`
--
DROP TABLE IF EXISTS `oficiales`;
CREATE TABLE `oficiales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_nac` date,
  `id_area` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `oficiales_id_area_fk` (`id_area`),
  CONSTRAINT `oficiales_id_area_fk` FOREIGN KEY (`id_area`) REFERENCES `areas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de tabla para la tabla `voluntario`
--
DROP TABLE IF EXISTS `voluntarios`;
CREATE TABLE `voluntarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de tabla para la tabla `Metas`
--
DROP TABLE IF EXISTS `metas`;
CREATE TABLE `metas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meta` int(11) NOT NULL,
  `id_oficial` int(11) NOT NULL,
  `id_periodo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `metas_id_oficial_fk` (`id_oficial`),
  CONSTRAINT `metas_id_oficial_fk` FOREIGN KEY (`id_oficial`) REFERENCES `oficiales` (`id`),
  KEY `metas_id_periodo_fk` (`id_periodo`),
  CONSTRAINT `metas_id_periodo_fk` FOREIGN KEY (`id_periodo`) REFERENCES `periodos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de tabla para la tabla `visita`
--
DROP TABLE IF EXISTS `visitas`;
CREATE TABLE `visitas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `id_escuela` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `visitas_id_escuela_fk` (`id_escuela`),
  CONSTRAINT `visitas_id_escuela_fk` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de tabla para la tabla `visita_oficial`
--
DROP TABLE IF EXISTS `visita_oficial`;
CREATE TABLE `visita_oficial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_visita` int(11) NOT NULL,
  `id_oficial` int(11) NOT NULL,
  `aulas` int(11),
  `viaticos` float,
  `pendientes` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  `observaciones` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `visitaO_id_visita_fk` (`id_visita`),
  CONSTRAINT `visitaO_id_visita_fk` FOREIGN KEY (`id_visita`) REFERENCES `visitas` (`id`),
  KEY `visitaO_id_oficial_fk` (`id_oficial`),
  CONSTRAINT `visitaO_id_oficial_fk` FOREIGN KEY (`id_oficial`) REFERENCES `oficiales` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de tabla para la tabla `visita_voluntario`
--
DROP TABLE IF EXISTS `visita_voluntario`;
CREATE TABLE `visita_voluntario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_visitaO` int(11) NOT NULL,
  `id_voluntario` int(11) NOT NULL,
  `tiempo` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `visitaV_id_visitaO_fk` (`id_visitaO`),
  CONSTRAINT `visitaV_id_visitaO_fk` FOREIGN KEY (`id_visitaO`) REFERENCES `visita_oficial` (`id`),
  KEY `visitaV_id_voluntario_fk` (`id_voluntario`),
  CONSTRAINT `visitaV_id_voluntario_fk` FOREIGN KEY (`id_voluntario`) REFERENCES `voluntarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de tabla para la tabla `visita_motivo`
--
DROP TABLE IF EXISTS `visita_motivo`;
CREATE TABLE `visita_motivo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_visitaO` int(11) NOT NULL,
  `id_motivo` int(11) NOT NULL,
  `tiempo` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `visitaM_id_visitaO_fk` (`id_visitaO`),
  CONSTRAINT `visitaM_id_visitaO_fk` FOREIGN KEY (`id_visitaO`) REFERENCES `visita_oficial` (`id`),
  KEY `visitaM_id_motivo_fk` (`id_motivo`),
  CONSTRAINT `visitaM_id_motivo_fk` FOREIGN KEY (`id_motivo`) REFERENCES `motivos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de tabla para la tabla `motivo_detalle`
--
DROP TABLE IF EXISTS `motivo_detalle`;
CREATE TABLE `motivo_detalle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_visitaM` int(11) NOT NULL,
  `id_detalle` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `motivoD_id_visitaM_fk` (`id_visitaM`),
  CONSTRAINT `motivoD_id_visitaM_fk` FOREIGN KEY (`id_visitaM`) REFERENCES `visita_motivo` (`id`),
  KEY `motivoD_id_detalle_fk` (`id_detalle`),
  CONSTRAINT `motivoD_id_detalle_fk` FOREIGN KEY (`id_detalle`) REFERENCES `detalles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ***********************************************
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

ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

-- ***********************************************
CREATE TABLE `user_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `access_level` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user_types` (`id`, `name`, `access_level`) VALUES
(1, 'Administrador', 100),
(2, 'Coordinador', 50),
(3, 'Oficial', 25);

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_type` int(11),
  `id_oficial` int(11),
  KEY `users_id_type_fk` (`id_type`),
  CONSTRAINT `users_id_type_fk` FOREIGN KEY (`id_type`) REFERENCES `user_types` (`id`),
  KEY `users_id_oficial_fk` (`id_oficial`),
  CONSTRAINT `users_id_oficial_fk` FOREIGN KEY (`id_oficial`) REFERENCES `oficiales` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `id_type`) VALUES
(1, 'Administrador', 'admin@admin.com', '$2y$10$0iVCZ/o1TWbQlhGsfy/OROYu8UzDzD9dGbiujFTORbCYetobsmj/i', '6M89cw5DMRROviuVV64EvRFuPZ6e4vYCt1vnZCci7WHDwKfWnM1vaHYe6Xqv', '2016-06-01 04:35:06', '2016-06-20 14:56:03', 1),
(2, 'FZTMobile', 'fztmobile@admin.com', '$2y$10$YKPJOauMci4/PwWITARbXezDNhNWtLmbN5/Tsi2cjZEa8Xw.SMjIW', 'lTlQtkURI6BmxXKSfk4vqxVapZAWlLYUFDCwfOgAG3nvlspFZ3pV8llzKUzn', '2016-06-03 03:38:29', '2016-06-20 14:28:12', 1);

ALTER TABLE `users` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `users_email_unique` (`email`);

ALTER TABLE `users` MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

-- ***********************************************
-- ***********************************************

-- Estructura de tabla para la tabla `contenido`
--
DROP TABLE IF EXISTS `contenidos`;
CREATE TABLE `contenidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de tabla para la tabla `publico`
--
DROP TABLE IF EXISTS `audiencia`;
CREATE TABLE `audiencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de tabla para la tabla `lugar`
--
DROP TABLE IF EXISTS `lugares`;
CREATE TABLE `lugares` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de tabla para la tabla `actividad`
--
DROP TABLE IF EXISTS `actividades`;
CREATE TABLE `actividades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de tabla para la tabla `internacional`
--
DROP TABLE IF EXISTS `internacionales`;
CREATE TABLE `internacionales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de tabla para la tabla `zona_receptora`
--
DROP TABLE IF EXISTS `zonas_receptoras`;
CREATE TABLE `zonas_receptoras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de tabla para la tabla `taller`
--
DROP TABLE IF EXISTS `talleres`;
CREATE TABLE `talleres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `duracion` time NOT NULL,
  `cant_mujeres` int(11) NOT NULL,
  `cant_hombres` int(11) NOT NULL,
  `observaciones` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  `id_lugar` int(11) NOT NULL,
  `id_actividad` int(11) NOT NULL,
  `viaticos` float,
  PRIMARY KEY (`id`),
  KEY `talleres_id_lugar_fk` (`id_lugar`),
  CONSTRAINT `talleres_id_lugar_fk` FOREIGN KEY (`id_lugar`) REFERENCES `lugares` (`id`),
  KEY `talleres_id_actividad_fk` (`id_actividad`),
  CONSTRAINT `talleres_id_actividad_fk` FOREIGN KEY (`id_actividad`) REFERENCES `actividades` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de tabla para la tabla `taller_contenido`
--
DROP TABLE IF EXISTS `taller_contenido`;
CREATE TABLE `taller_contenido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_taller` int(11) NOT NULL,
  `id_contenido` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `talleresC_id_taller_fk` (`id_taller`),
  CONSTRAINT `talleresC_id_taller_fk` FOREIGN KEY (`id_taller`) REFERENCES `talleres` (`id`),
  KEY `talleresC_id_contenido_fk` (`id_contenido`),
  CONSTRAINT `talleresC_id_contenido_fk` FOREIGN KEY (`id_contenido`) REFERENCES `contenidos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de tabla para la tabla `taller_oficial`
--
DROP TABLE IF EXISTS `taller_oficial`;
CREATE TABLE `taller_oficial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_taller` int(11) NOT NULL,
  `id_oficial` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `talleresO_id_taller_fk` (`id_taller`),
  CONSTRAINT `talleresO_id_taller_fk` FOREIGN KEY (`id_taller`) REFERENCES `talleres` (`id`),
  KEY `talleresO_id_oficial_fk` (`id_oficial`),
  CONSTRAINT `talleresO_id_oficial_fk` FOREIGN KEY (`id_oficial`) REFERENCES `oficiales` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de tabla para la tabla `taller_publico`
--
DROP TABLE IF EXISTS `taller_audiencia`;
CREATE TABLE `taller_audiencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_taller` int(11) NOT NULL,
  `id_audiencia` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `talleresA_id_taller_fk` (`id_taller`),
  CONSTRAINT `talleresA_id_taller_fk` FOREIGN KEY (`id_taller`) REFERENCES `talleres` (`id`),
  KEY `talleresA_id_audiencia_fk` (`id_audiencia`),
  CONSTRAINT `talleresA_id_audiencia_fk` FOREIGN KEY (`id_audiencia`) REFERENCES `audiencia` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Estructura de tabla para la tabla `detalle_taller`
--
DROP TABLE IF EXISTS `detalle_taller`;
CREATE TABLE `detalle_taller` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_taller` int(11) NOT NULL,

  `id_escuela` int(11),
  `id_internacional` int(11),
  `id_zona` int(11),
  PRIMARY KEY (`id`),

  KEY `detalleT_id_taller_fk` (`id_taller`),
  CONSTRAINT `detalleT_id_taller_fk` FOREIGN KEY (`id_taller`) REFERENCES `talleres` (`id`),

  KEY `detalleT_id_escuela_fk` (`id_escuela`),
  CONSTRAINT `detalleT_id_escuela_fk` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id`),

  KEY `detalleT_id_internacional_fk` (`id_internacional`),
  CONSTRAINT `detalleT_id_internacional_fk` FOREIGN KEY (`id_internacional`) REFERENCES `internacionales` (`id`),

  KEY `detalleT_id_zona_fk` (`id_zona`),
  CONSTRAINT `detalleT_id_zona_fk` FOREIGN KEY (`id_zona`) REFERENCES `zonas_receptoras` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;