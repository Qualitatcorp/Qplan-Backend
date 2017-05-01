-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-03-2017 a las 15:06:40
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `qplan`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_access_permission` (IN `PARENT` VARCHAR(128), IN `CHILD` VARCHAR(128), IN `PERMISSION` ENUM('ALLOW','DENY'))  MODIFIES SQL DATA
    COMMENT 'DEFINE HERENCIA DE PERMISOS'
BEGIN
	DECLARE _PARENT_ID INT UNSIGNED;
	DECLARE _CHILD_ID INT UNSIGNED;

	SET _PARENT_ID=(SELECT id FROM user_resource WHERE resource=PARENT);
	SET _CHILD_ID=(SELECT id FROM user_resource WHERE resource=CHILD);

	IF (PERMISSION='ALLOW') THEN
		IF EXISTS(
			SELECT * 
			FROM user_resource_children 
			WHERE parent_id=_PARENT_ID AND child_id=_CHILD_ID) THEN
				SELECT 'NOT CHANGE ALLOW' AS RESULT;
		ELSE

			INSERT INTO user_resource_children (parent_id,child_id) VALUES(_PARENT_ID,_CHILD_ID);
			SELECT 'DONE ALLOW' AS RESULT;
		END IF;
	ELSE
		IF EXISTS(SELECT * FROM user_resource_children WHERE parent_id=_PARENT_ID AND child_id=_CHILD_ID) THEN
			DELETE FROM user_resource_children WHERE parent_id=_PARENT_ID AND child_id=_CHILD_ID;
			SELECT 'DONE DENY' AS RESULT;
		ELSE
			SELECT 'NOT CHANGE DENY' AS RESULT;
		END IF;
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_access_resource_user` (IN `USER` INT UNSIGNED, IN `RESOURCE` VARCHAR(128))  READS SQL DATA
BEGIN
	IF EXISTS(SELECT * FROM user_authorization INNER JOIN user_resource ON (res_id = user_resource.id) WHERE user_id=USER AND user_resource.resource=RESOURCE) THEN
		SELECT 'ALLOW' AS PERMISSION;
	ELSE 
		IF EXISTS(SELECT * FROM user_authorization INNER JOIN user_resource p ON (user_authorization.res_id = p.id) INNER JOIN user_resource_children ON (p.id = user_resource_children.parent_id) INNER JOIN user_resource c ON (user_resource_children.child_id = c.id) WHERE user_authorization.user_id=USER AND c.resource=RESOURCE) THEN
			SELECT 'ALLOW' AS PERMISSION;
		ELSE 
			SELECT 'DENY' AS PERMISSION;
		END IF;
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_resource_register` (IN `new_resource` VARCHAR(128))  MODIFIES SQL DATA
BEGIN
IF EXISTS(SELECT * FROM `user_resource` WHERE `resource`=new_resource)THEN
SELECT 'EXISTS' AS RESULT;
ELSE
 INSERT INTO `user_resource` (resource) VALUES(new_resource);
 SELECT 'DONE' AS RESULT;
END IF; 
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasificacion`
--

CREATE TABLE `clasificacion` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `cat_id` tinyint(3) UNSIGNED NOT NULL,
  `nombre` varchar(128) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasificacion_categoria`
--

CREATE TABLE `clasificacion_categoria` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `nombre` varchar(128) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasificacion_perfil`
--

CREATE TABLE `clasificacion_perfil` (
  `id` int(10) UNSIGNED NOT NULL,
  `cla_id` smallint(5) UNSIGNED NOT NULL,
  `per_id` mediumint(8) UNSIGNED NOT NULL,
  `acierto` decimal(5,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='define el criterio';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comuna`
--

CREATE TABLE `comuna` (
  `com_id` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `nombre` varchar(20) DEFAULT NULL,
  `pro_id` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comuna`
--

INSERT INTO `comuna` (`com_id`, `nombre`, `pro_id`) VALUES
(1101, 'Iquique', 11),
(1107, 'Alto Hospicio', 11),
(1401, 'Pozo Almonte', 14),
(1402, 'Camiña', 14),
(1403, 'Colchane', 14),
(1404, 'Huara', 14),
(1405, 'Pica', 14),
(2101, 'Antofagasta', 21),
(2102, 'Mejillones', 21),
(2103, 'Sierra Gorda', 21),
(2104, 'Taltal', 21),
(2201, 'Calama', 22),
(2202, 'Ollagüe', 22),
(2203, 'San Pedro de Atacama', 22),
(2301, 'Tocopilla', 23),
(2302, 'María Elena', 23),
(3101, 'Copiapó', 31),
(3102, 'Caldera', 31),
(3103, 'Tierra Amarilla', 31),
(3201, 'Chañaral', 32),
(3202, 'Diego de Almagro', 32),
(3301, 'Vallenar', 33),
(3302, 'Alto del Carmen', 33),
(3303, 'Freirina', 33),
(3304, 'Huasco', 33),
(4101, 'La Serena', 41),
(4102, 'Coquimbo', 41),
(4103, 'Andacollo', 41),
(4104, 'La Higuera', 41),
(4105, 'Paihuano', 41),
(4106, 'Vicuña', 41),
(4201, 'Illapel', 42),
(4202, 'Canela', 42),
(4203, 'Los Vilos', 42),
(4204, 'Salamanca', 42),
(4301, 'Ovalle', 43),
(4302, 'Combarbalá', 43),
(4303, 'Monte Patria', 43),
(4304, 'Punitaqui', 43),
(4305, 'Río Hurtado', 43),
(5101, 'Valparaíso', 51),
(5102, 'Casablanca', 51),
(5103, 'Concón', 51),
(5104, 'Juan Fernández', 51),
(5105, 'Puchuncaví', 51),
(5107, 'Quintero', 51),
(5109, 'Viña del Mar', 51),
(5201, 'Isla de Pascua', 52),
(5301, 'Los Andes', 53),
(5302, 'Calle Larga', 53),
(5303, 'Rinconada', 53),
(5304, 'San Esteban', 53),
(5401, 'La Ligua', 54),
(5402, 'Cabildo', 54),
(5403, 'Papudo', 54),
(5404, 'Petorca', 54),
(5405, 'Zapallar', 54),
(5501, 'Quillota', 55),
(5502, 'La Calera', 55),
(5503, 'Hijuelas', 55),
(5504, 'La Cruz', 55),
(5506, 'Nogales', 55),
(5601, 'San Antonio', 56),
(5602, 'Algarrobo', 56),
(5603, 'Cartagena', 56),
(5604, 'El Quisco', 56),
(5605, 'El Tabo', 56),
(5606, 'Santo Domingo', 56),
(5701, 'San Felipe', 57),
(5702, 'Catemu', 57),
(5703, 'Llay Llay', 57),
(5704, 'Panquehue', 57),
(5705, 'Putaendo', 57),
(5706, 'Santa María', 57),
(5801, 'Quilpué', 58),
(5802, 'Limache', 58),
(5803, 'Olmué', 58),
(5804, 'Villa Alemana', 58),
(6101, 'Rancagua', 61),
(6102, 'Codegua', 61),
(6103, 'Coinco', 61),
(6104, 'Coltauco', 61),
(6105, 'Doñihue', 61),
(6106, 'Graneros', 61),
(6107, 'Las Cabras', 61),
(6108, 'Machalí', 61),
(6109, 'Malloa', 61),
(6110, 'Mostazal', 61),
(6111, 'Olivar', 61),
(6112, 'Peumo', 61),
(6113, 'Pichidegua', 61),
(6114, 'Quinta de Tilcoco', 61),
(6115, 'Rengo', 61),
(6116, 'Requínoa', 61),
(6117, 'San Vicente', 61),
(6201, 'Pichilemu', 62),
(6202, 'La Estrella', 62),
(6203, 'Litueche', 62),
(6204, 'Marchihue', 62),
(6205, 'Navidad', 62),
(6206, 'Paredones', 62),
(6301, 'San Fernando', 63),
(6302, 'Chépica', 63),
(6303, 'Chimbarongo', 63),
(6304, 'Lolol', 63),
(6305, 'Nancagua', 63),
(6306, 'Palmilla', 63),
(6307, 'Peralillo', 63),
(6308, 'Placilla', 63),
(6309, 'Pumanque', 63),
(6310, 'Santa Cruz', 63),
(7101, 'Talca', 71),
(7102, 'Constitución', 71),
(7103, 'Curepto', 71),
(7104, 'Empedrado', 71),
(7105, 'Maule', 71),
(7106, 'Pelarco', 71),
(7107, 'Pencahue', 71),
(7108, 'Río Claro', 71),
(7109, 'San Clemente', 71),
(7110, 'San Rafael', 71),
(7201, 'Cauquenes', 72),
(7202, 'Chanco', 72),
(7203, 'Pelluhue', 72),
(7301, 'Curicó', 73),
(7302, 'Hualañé', 73),
(7303, 'Licantén', 73),
(7304, 'Molina', 73),
(7305, 'Rauco', 73),
(7306, 'Romeral', 73),
(7307, 'Sagrada Familia', 73),
(7308, 'Teno', 73),
(7309, 'Vichuquén', 73),
(7401, 'Linares', 74),
(7402, 'Colbún', 74),
(7403, 'Longaví', 74),
(7404, 'Parral', 74),
(7405, 'Retiro', 74),
(7406, 'San Javier', 74),
(7407, 'Villa Alegre', 74),
(7408, 'Yerbas Buenas', 74),
(8101, 'Concepción', 81),
(8102, 'Coronel', 81),
(8103, 'Chiguayante', 81),
(8104, 'Florida', 81),
(8105, 'Hualqui', 81),
(8106, 'Lota', 81),
(8107, 'Penco', 81),
(8108, 'San Pedro de la Paz', 81),
(8109, 'Santa Juana', 81),
(8110, 'Talcahuano', 81),
(8111, 'Tomé', 81),
(8112, 'Hualpén', 81),
(8201, 'Lebu', 82),
(8202, 'Arauco', 82),
(8203, 'Cañete', 82),
(8204, 'Contulmo', 82),
(8205, 'Curanilahue', 82),
(8206, 'Los Álamos', 82),
(8207, 'Tirúa', 82),
(8301, 'Los Ángeles', 83),
(8302, 'Antuco', 83),
(8303, 'Cabrero', 83),
(8304, 'Laja', 83),
(8305, 'Mulchén', 83),
(8306, 'Nacimiento', 83),
(8307, 'Negrete', 83),
(8308, 'Quilaco', 83),
(8309, 'Quilleco', 83),
(8310, 'San Rosendo', 83),
(8311, 'Santa Bárbara', 83),
(8312, 'Tucapel', 83),
(8313, 'Yumbel', 83),
(8314, 'Alto Biobío', 83),
(8401, 'Chillán', 84),
(8402, 'Bulnes', 84),
(8403, 'Cobquecura', 84),
(8404, 'Coelemu', 84),
(8405, 'Coihueco', 84),
(8406, 'Chillán Viejo', 84),
(8407, 'El Carmen', 84),
(8408, 'Ninhue', 84),
(8409, 'Ñiquén', 84),
(8410, 'Pemuco', 84),
(8411, 'Pinto', 84),
(8412, 'Portezuelo', 84),
(8413, 'Quillón', 84),
(8414, 'Quirihue', 84),
(8415, 'Ránquil', 84),
(8416, 'San Carlos', 84),
(8417, 'San Fabián', 84),
(8418, 'San Ignacio', 84),
(8419, 'San Nicolás', 84),
(8420, 'Treguaco', 84),
(8421, 'Yungay', 84),
(9101, 'Temuco', 91),
(9102, 'Carahue', 91),
(9103, 'Cunco', 91),
(9104, 'Curarrehue', 91),
(9105, 'Freire', 91),
(9106, 'Galvarino', 91),
(9107, 'Gorbea', 91),
(9108, 'Lautaro', 91),
(9109, 'Loncoche', 91),
(9110, 'Melipeuco', 91),
(9111, 'Nueva Imperial', 91),
(9112, 'Padre las Casas', 91),
(9113, 'Perquenco', 91),
(9114, 'Pitrufquén', 91),
(9115, 'Pucón', 91),
(9116, 'Saavedra', 91),
(9117, 'Teodoro Schmidt', 91),
(9118, 'Toltén', 91),
(9119, 'Vilcún', 91),
(9120, 'Villarrica', 91),
(9121, 'Cholchol', 91),
(9201, 'Angol', 92),
(9202, 'Collipulli', 92),
(9203, 'Curacautín', 92),
(9204, 'Ercilla', 92),
(9205, 'Lonquimay', 92),
(9206, 'Los Sauces', 92),
(9207, 'Lumaco', 92),
(9208, 'Purén', 92),
(9209, 'Renaico', 92),
(9210, 'Traiguén', 92),
(9211, 'Victoria', 92),
(10101, 'Puerto Montt', 101),
(10102, 'Calbuco', 101),
(10103, 'Cochamó', 101),
(10104, 'Fresia', 101),
(10105, 'Frutillar', 101),
(10106, 'Los Muermos', 101),
(10107, 'Llanquihue', 101),
(10108, 'Maullín', 101),
(10109, 'Puerto Varas', 101),
(10201, 'Castro', 102),
(10202, 'Ancud', 102),
(10203, 'Chonchi', 102),
(10204, 'Curaco de Vélez', 102),
(10205, 'Dalcahue', 102),
(10206, 'Puqueldón', 102),
(10207, 'Queilén', 102),
(10208, 'Quellón', 102),
(10209, 'Quemchi', 102),
(10210, 'Quinchao', 102),
(10301, 'Osorno', 103),
(10302, 'Puerto Octay', 103),
(10303, 'Purranque', 103),
(10304, 'Puyehue', 103),
(10305, 'Río Negro', 103),
(10306, 'San Juan de la Costa', 103),
(10307, 'San Pablo', 103),
(10401, 'Chaitén', 104),
(10402, 'Futaleufú', 104),
(10403, 'Hualaihué', 104),
(10404, 'Palena', 104),
(11101, 'Coyhaique', 111),
(11102, 'Lago Verde', 111),
(11201, 'Aysén', 112),
(11202, 'Cisnes', 112),
(11203, 'Guaitecas', 112),
(11301, 'Cochrane', 113),
(11302, 'O''Higgins', 113),
(11303, 'Tortel', 113),
(11401, 'Chile Chico', 114),
(11402, 'Río Ibáñez', 114),
(12101, 'Punta Arenas', 121),
(12102, 'Laguna Blanca', 121),
(12103, 'Río Verde', 121),
(12104, 'San Gregorio', 121),
(12201, 'Cabo de Hornos', 122),
(12202, 'Antártica', 122),
(12301, 'Porvenir', 123),
(12302, 'Primavera', 123),
(12303, 'Timaukel', 123),
(12401, 'Natales', 124),
(12402, 'Torres del Paine', 124),
(13101, 'Santiago', 131),
(13102, 'Cerrillos', 131),
(13103, 'Cerro Navia', 131),
(13104, 'Conchalí', 131),
(13105, 'El Bosque', 131),
(13106, 'Estación Central', 131),
(13107, 'Huechuraba', 131),
(13108, 'Independencia', 131),
(13109, 'La Cisterna', 131),
(13110, 'La Florida', 131),
(13111, 'La Granja', 131),
(13112, 'La Pintana', 131),
(13113, 'La Reina', 131),
(13114, 'Las Condes', 131),
(13115, 'Lo Barnechea', 131),
(13116, 'Lo Espejo', 131),
(13117, 'Lo Prado', 131),
(13118, 'Macul', 131),
(13119, 'Maipú', 131),
(13120, 'Ñuñoa', 131),
(13121, 'Pedro Aguirre Cerda', 131),
(13122, 'Peñalolén', 131),
(13123, 'Providencia', 131),
(13124, 'Pudahuel', 131),
(13125, 'Quilicura', 131),
(13126, 'Quinta Normal', 131),
(13127, 'Recoleta', 131),
(13128, 'Renca', 131),
(13129, 'San Joaquín', 131),
(13130, 'San Miguel', 131),
(13131, 'San Ramón', 131),
(13132, 'Vitacura', 131),
(13201, 'Puente Alto', 132),
(13202, 'Pirque', 132),
(13203, 'San José de Maipo', 132),
(13301, 'Colina', 133),
(13302, 'Lampa', 133),
(13303, 'Tiltil', 133),
(13401, 'San Bernardo', 134),
(13402, 'Buin', 134),
(13403, 'Calera de Tango', 134),
(13404, 'Paine', 134),
(13501, 'Melipilla', 135),
(13502, 'Alhué', 135),
(13503, 'Curacaví', 135),
(13504, 'María Pinto', 135),
(13505, 'San Pedro', 135),
(13601, 'Talagante', 136),
(13602, 'El Monte', 136),
(13603, 'Isla de Maipo', 136),
(13604, 'Padre Hurtado', 136),
(13605, 'Peñaflor', 136),
(14101, 'Valdivia', 141),
(14102, 'Corral', 141),
(14103, 'Lanco', 141),
(14104, 'Los Lagos', 141),
(14105, 'Máfil', 141),
(14106, 'Mariquina', 141),
(14107, 'Paillaco', 141),
(14108, 'Panguipulli', 141),
(14201, 'La Unión', 142),
(14202, 'Futrono', 142),
(14203, 'Lago Ranco', 142),
(14204, 'Río Bueno', 142),
(15101, 'Arica', 151),
(15102, 'Camarones', 151),
(15201, 'Putre', 152),
(15202, 'General Lagos', 152);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comuna_provincia`
--

CREATE TABLE `comuna_provincia` (
  `pro_id` int(3) NOT NULL DEFAULT '0',
  `nombre` varchar(23) DEFAULT NULL,
  `reg_id` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comuna_provincia`
--

INSERT INTO `comuna_provincia` (`pro_id`, `nombre`, `reg_id`) VALUES
(11, 'Iquique', 1),
(14, 'Tamarugal', 1),
(21, 'Antofagasta', 2),
(22, 'El Loa', 2),
(23, 'Tocopilla', 2),
(31, 'Copiapó', 3),
(32, 'Chañaral', 3),
(33, 'Huasco', 3),
(41, 'Elqui', 4),
(42, 'Choapa', 4),
(43, 'Limarí', 4),
(51, 'Valparaíso', 5),
(52, 'Isla de Pascua', 5),
(53, 'Los Andes', 5),
(54, 'Petorca', 5),
(55, 'Quillota', 5),
(56, 'San Antonio', 5),
(57, 'San Felipe de Aconcagua', 5),
(58, 'Marga Marga', 5),
(61, 'Cachapoal', 6),
(62, 'Cardenal Caro', 6),
(63, 'Colchagua', 6),
(71, 'Talca', 7),
(72, 'Cauquenes', 7),
(73, 'Curicó', 7),
(74, 'Linares', 7),
(81, 'Concepción', 8),
(82, 'Arauco', 8),
(83, 'Biobío', 8),
(84, 'Ñuble', 8),
(91, 'Cautín', 9),
(92, 'Malleco', 9),
(101, 'Llanquihue', 10),
(102, 'Chiloé', 10),
(103, 'Osorno', 10),
(104, 'Palena', 10),
(111, 'Coihaique', 11),
(112, 'Aisén', 11),
(113, 'Capitán Prat', 11),
(114, 'General Carrera', 11),
(121, 'Magallanes', 12),
(122, 'Antártica Chilena', 12),
(123, 'Tierra del Fuego', 12),
(124, 'Última Esperanza', 12),
(131, 'Santiago', 13),
(132, 'Cordillera', 13),
(133, 'Chacabuco', 13),
(134, 'Maipo', 13),
(135, 'Melipilla', 13),
(136, 'Talagante', 13),
(141, 'Valdivia', 14),
(142, 'Ranco', 14),
(151, 'Arica', 15),
(152, 'Parinacota', 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comuna_region`
--

CREATE TABLE `comuna_region` (
  `reg_id` int(2) NOT NULL DEFAULT '0',
  `nombre` varchar(50) DEFAULT NULL,
  `ISO_3166_2_CL` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comuna_region`
--

INSERT INTO `comuna_region` (`reg_id`, `nombre`, `ISO_3166_2_CL`) VALUES
(1, 'Tarapacá', 'CL-TA'),
(2, 'Antofagasta', 'CL-AN'),
(3, 'Atacama', 'CL-AT'),
(4, 'Coquimbo', 'CL-CO'),
(5, 'Valparaíso', 'CL-VS'),
(6, 'Región del Libertador Gral. Bernardo O’Higgins', 'CL-LI'),
(7, 'Región del Maule', 'CL-ML'),
(8, 'Región del Biobío', 'CL-BI'),
(9, 'Región de la Araucanía', 'CL-AR'),
(10, 'Región de Los Lagos', 'CL-LL'),
(11, 'Región Aisén del Gral. Carlos Ibáñez del Campo', 'CL-AI'),
(12, 'Región de Magallanes y de la Antártica Chilena', 'CL-MA'),
(13, 'Región Metropolitana de Santiago', 'CL-RM'),
(14, 'Región de Los Ríos', 'CL-LR'),
(15, 'Arica y Parinacota', 'CL-AP');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT 'Empresa',
  `com_id` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'Comuna',
  `nombre` varchar(64) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre corto',
  `rut` varchar(12) COLLATE utf8_spanish_ci NOT NULL COMMENT 'RUT',
  `razon` varchar(256) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Razón social',
  `giro` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Giro',
  `fono` varchar(128) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Teléfono de contacto',
  `mail` varchar(128) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'e-mail',
  `pais_id` tinyint(3) UNSIGNED DEFAULT NULL COMMENT 'Pais',
  `creada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación',
  `habilitada` enum('SI','NO') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'SI' COMMENT 'Habilitada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id`, `com_id`, `nombre`, `rut`, `razon`, `giro`, `fono`, `mail`, `pais_id`, `creada`, `habilitada`) VALUES
(1, NULL, 'Qualitatcorp', '76.150.831-8', 'Sociedad de desarrollo Tecnológico y Certificación Qualitat Corp Limit', NULL, NULL, NULL, NULL, '2017-03-09 19:03:37', 'SI'),
(2, NULL, 'CMPC', '90.222.000-3', 'EMPRESAS CMPC S.A.', NULL, NULL, NULL, NULL, '2017-03-09 19:08:17', 'SI'),
(3, NULL, 'Arauco', '93.458.000-1', 'Celulosa Arauco Y Constitucion S A', NULL, NULL, NULL, NULL, '2017-03-09 19:08:17', 'SI');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa_clasificacion`
--

CREATE TABLE `empresa_clasificacion` (
  `id` int(10) UNSIGNED NOT NULL,
  `cla_id` smallint(5) UNSIGNED NOT NULL,
  `emp_id` smallint(5) UNSIGNED NOT NULL,
  `per_id` mediumint(8) UNSIGNED NOT NULL,
  `acierto` decimal(5,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='crea el criterio de clasificación de un perfil';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa_sucursal`
--

CREATE TABLE `empresa_sucursal` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `emp_id` smallint(5) UNSIGNED NOT NULL,
  `nombre` varchar(128) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre',
  `direccion` text COLLATE utf8_spanish_ci COMMENT 'Dirección'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `empresa_sucursal`
--

INSERT INTO `empresa_sucursal` (`id`, `emp_id`, `nombre`, `direccion`) VALUES
(1, 1, 'Talcahuano', 'Dalcahue'),
(2, 1, 'Santiago', NULL),
(3, 2, 'Celulosa Laja', NULL),
(4, 2, 'Celulosa Santa Fe', NULL),
(5, 2, 'Papeles Inforsa', NULL),
(6, 2, 'Cartulinas Maule', NULL),
(7, 2, 'Papeles Maule', NULL),
(8, 2, 'Papeles Cordillera', NULL),
(9, 2, 'Aserraderos', NULL),
(10, 2, 'Paneles', NULL),
(11, 2, 'Celulosa Pacifico', NULL),
(12, 3, 'Celulosa Valdivia', NULL),
(14, 3, 'Celulosa Constitución', NULL),
(15, 3, 'Celulosa Licancel', NULL),
(16, 3, 'Aserraderos', NULL),
(17, 3, 'Celulosa Nueva Aldea', NULL),
(18, 3, 'Celulosa Horcones', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa_user`
--

CREATE TABLE `empresa_user` (
  `emu_id` int(11) NOT NULL,
  `emp_id` smallint(5) UNSIGNED NOT NULL COMMENT 'Empresa',
  `usu_id` int(11) UNSIGNED NOT NULL COMMENT 'Usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad`
--

CREATE TABLE `especialidad` (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT 'Especialidad',
  `car_id` smallint(5) UNSIGNED NOT NULL COMMENT 'Cargo',
  `nombre` varchar(128) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Especialidad'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad_area`
--

CREATE TABLE `especialidad_area` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `nombre` varchar(128) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Categoría'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `especialidad_area`
--

INSERT INTO `especialidad_area` (`id`, `nombre`) VALUES
(2, 'Forestal'),
(1, 'Industrial'),
(3, 'Minero Acerero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad_cargo`
--

CREATE TABLE `especialidad_cargo` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `are_id` smallint(5) UNSIGNED NOT NULL,
  `nombre` varchar(128) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluacion_alternativa`
--

CREATE TABLE `evaluacion_alternativa` (
  `id` int(10) UNSIGNED NOT NULL,
  `pre_id` int(10) UNSIGNED NOT NULL COMMENT 'Pregunta',
  `altenativa` tinyint(4) NOT NULL COMMENT 'Posibles Respuesta',
  `poderacion` float NOT NULL DEFAULT '1',
  `correcta` enum('SI','NO') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluacion_item`
--

CREATE TABLE `evaluacion_item` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'Ítem de evaluación',
  `evt_id` mediumint(8) UNSIGNED NOT NULL COMMENT 'Evaluación Técnica',
  `tipo` enum('TECNICA','SEGURIDAD','PRACTICA','PSICOLOGICA','CURRICULAR','USUARIA') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de Preguntas',
  `influencia` enum('PONDERA','NO PONDERA') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Influencia en la Nota final',
  `metodo` enum('USUARIO','EMPRESA','TERCERO') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Método para resolver la evaluación'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluacion_pregunta`
--

CREATE TABLE `evaluacion_pregunta` (
  `id` int(10) UNSIGNED NOT NULL,
  `ite_id` mediumint(8) UNSIGNED NOT NULL,
  `pregunta` text COLLATE utf8_spanish_ci NOT NULL,
  `comentario` text COLLATE utf8_spanish_ci,
  `creado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modificado` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `habilitado` enum('SI','NO') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'SI'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluacion_teorica`
--

CREATE TABLE `evaluacion_teorica` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `tev_id` smallint(5) UNSIGNED NOT NULL,
  `nombre` varchar(256) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluacion_tipo`
--

CREATE TABLE `evaluacion_tipo` (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT 'Tipo de evaluación',
  `nombre` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ficha`
--

CREATE TABLE `ficha` (
  `id` int(10) UNSIGNED NOT NULL,
  `ot_id` int(10) UNSIGNED NOT NULL,
  `tra_id` int(10) UNSIGNED NOT NULL,
  `proceso` enum('PENDIENTE','FINALIZADO') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'PENDIENTE',
  `creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ficha_item`
--

CREATE TABLE `ficha_item` (
  `id` int(10) UNSIGNED NOT NULL,
  `ite_id` mediumint(8) UNSIGNED NOT NULL,
  `teo_id` int(10) UNSIGNED NOT NULL,
  `nota` decimal(2,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ficha_practica`
--

CREATE TABLE `ficha_practica` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mod_id` mediumint(8) UNSIGNED NOT NULL,
  `fic_id` int(10) UNSIGNED NOT NULL,
  `nota` decimal(2,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ficha_respuesta`
--

CREATE TABLE `ficha_respuesta` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fide_id` int(10) UNSIGNED NOT NULL COMMENT 'Item',
  `alt_id` int(10) UNSIGNED NOT NULL COMMENT 'Alternativa',
  `creado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ficha_teorico`
--

CREATE TABLE `ficha_teorico` (
  `id` int(10) UNSIGNED NOT NULL,
  `mod_id` mediumint(8) UNSIGNED NOT NULL,
  `fic_id` int(10) UNSIGNED NOT NULL,
  `nota` decimal(2,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_trabajo`
--

CREATE TABLE `orden_trabajo` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'Orden de Trabajo',
  `emp_id` smallint(5) UNSIGNED NOT NULL COMMENT 'Empresa Contratista',
  `esp_id` smallint(5) UNSIGNED NOT NULL COMMENT 'Especialidad',
  `per_id` mediumint(8) UNSIGNED NOT NULL COMMENT 'Perfil de evaluación',
  `sol_id` int(10) UNSIGNED NOT NULL COMMENT 'Solicitud',
  `inicio` date NOT NULL COMMENT 'Fecha de inicio',
  `termino` date NOT NULL COMMENT 'Fecha de termino',
  `direccion` tinytext COLLATE utf8_spanish_ci NOT NULL COMMENT 'Dirección de servicio',
  `estado` enum('CERRADO','EXTENCION','ABIERTO') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'CERRADO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_trabajo_solicitud`
--

CREATE TABLE `orden_trabajo_solicitud` (
  `id` int(10) UNSIGNED NOT NULL,
  `emp_id` int(10) UNSIGNED NOT NULL,
  `usu_id` int(10) UNSIGNED NOT NULL,
  `creacion` date NOT NULL,
  `inicio` date NOT NULL,
  `termino` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_trabajo_trabajador`
--

CREATE TABLE `orden_trabajo_trabajador` (
  `id` int(10) UNSIGNED NOT NULL,
  `ot_id` int(10) UNSIGNED NOT NULL,
  `tra_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE `pais` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `codigo` varchar(3) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pais`
--

INSERT INTO `pais` (`id`, `codigo`, `nombre`) VALUES
(1, 'AC', 'Ascension'),
(2, 'AD', 'Andorra'),
(3, 'AE', 'United Arab Emirates'),
(4, 'AF', 'Afghanistan'),
(5, 'AG', 'Antigua and Barbuda'),
(6, 'AI', 'Anguilla'),
(7, 'AL', 'Albania'),
(8, 'AM', 'Armenia'),
(9, 'AN', 'Netherlands Antilles'),
(10, 'AO', 'Angola'),
(11, 'AQ', 'Australian Antarctic Territory'),
(12, 'AR', 'Argentina'),
(13, 'AS', 'American Samoa'),
(14, 'AT', 'Austria'),
(15, 'AU', 'Australia'),
(16, 'AW', 'Aruba'),
(17, 'AX', 'Aland'),
(18, 'AZ', 'Azerbaijan'),
(19, 'BA', 'Bosnia and Herzegovina'),
(20, 'BB', 'Barbados'),
(21, 'BD', 'Bangladesh'),
(22, 'BE', 'Belgium'),
(23, 'BF', 'Burkina Faso'),
(24, 'BG', 'Bulgaria'),
(25, 'BH', 'Bahrain'),
(26, 'BI', 'Burundi'),
(27, 'BJ', 'Benin'),
(28, 'BM', 'Bermuda'),
(29, 'BN', 'Brunei'),
(30, 'BO', 'Bolivia'),
(31, 'BR', 'Brazil'),
(32, 'BS', 'Bahamas, The'),
(33, 'BT', 'Bhutan'),
(34, 'BV', 'Bouvet Island'),
(35, 'BW', 'Botswana'),
(36, 'BY', 'Belarus'),
(37, 'BZ', 'Belize'),
(38, 'CA', 'Canada'),
(39, 'CC', 'Cocos (Keeling) Islands'),
(40, 'CD', 'Congo, (Congo ?? Kinshasa)'),
(41, 'CF', 'Central African Republic'),
(42, 'CG', 'Congo, (Congo ?? Brazzaville)'),
(43, 'CH', 'Switzerland'),
(44, 'CI', 'Cote d''Ivoire (Ivory Coast)'),
(45, 'CK', 'Cook Islands'),
(46, 'CL', 'Chile'),
(47, 'CM', 'Cameroon'),
(48, 'CN', 'China, People''s Republic of'),
(49, 'CO', 'Colombia'),
(50, 'CR', 'Costa Rica'),
(51, 'CU', 'Cuba'),
(52, 'CV', 'Cape Verde'),
(53, 'CX', 'Christmas Island'),
(54, 'CY', 'Cyprus'),
(55, 'CZ', 'Czech Republic'),
(56, 'DE', 'Germany'),
(57, 'DJ', 'Djibouti'),
(58, 'DK', 'Denmark'),
(59, 'DM', 'Dominica'),
(60, 'DO', 'Dominican Republic'),
(61, 'DZ', 'Algeria'),
(62, 'EC', 'Ecuador'),
(63, 'EE', 'Estonia'),
(64, 'EG', 'Egypt'),
(65, 'ER', 'Eritrea'),
(66, 'ES', 'Spain'),
(67, 'ET', 'Ethiopia'),
(68, 'FI', 'Finland'),
(69, 'FJ', 'Fiji'),
(70, 'FK', 'Falkland Islands (Islas Malvinas)'),
(71, 'FM', 'Micronesia'),
(72, 'FO', 'Faroe Islands'),
(73, 'FR', 'France'),
(74, 'GA', 'Gabon'),
(75, 'GB', 'United Kingdom'),
(76, 'GD', 'Grenada'),
(77, 'GE', 'Georgia'),
(78, 'GF', 'French Guiana'),
(79, 'GG', 'Guernsey'),
(80, 'GH', 'Ghana'),
(81, 'GI', 'Gibraltar'),
(82, 'GL', 'Greenland'),
(83, 'GM', 'Gambia, The'),
(84, 'GN', 'Guinea'),
(85, 'GP', 'Saint Barthelemy'),
(86, 'GQ', 'Equatorial Guinea'),
(87, 'GR', 'Greece'),
(88, 'GS', 'South Georgia & South Sandwich Islands'),
(89, 'GT', 'Guatemala'),
(90, 'GU', 'Guam'),
(91, 'GW', 'Guinea-Bissau'),
(92, 'GY', 'Guyana'),
(93, 'HK', 'Hong Kong'),
(94, 'HM', 'Heard Island and McDonald Islands'),
(95, 'HN', 'Honduras'),
(96, 'HR', 'Croatia'),
(97, 'HT', 'Haiti'),
(98, 'HU', 'Hungary'),
(99, 'ID', 'Indonesia'),
(100, 'IE', 'Ireland'),
(101, 'IL', 'Israel'),
(102, 'IM', 'Isle of Man'),
(103, 'IN', 'India'),
(104, 'IO', 'British Indian Ocean Territory'),
(105, 'IQ', 'Iraq'),
(106, 'IR', 'Iran'),
(107, 'IS', 'Iceland'),
(108, 'IT', 'Italy'),
(109, 'JE', 'Jersey'),
(110, 'JM', 'Jamaica'),
(111, 'JO', 'Jordan'),
(112, 'JP', 'Japan'),
(113, 'KE', 'Kenya'),
(114, 'KG', 'Kyrgyzstan'),
(115, 'KH', 'Cambodia'),
(116, 'KI', 'Kiribati'),
(117, 'KM', 'Comoros'),
(118, 'KN', 'Saint Kitts and Nevis'),
(119, 'KP', 'Korea, North'),
(120, 'KR', 'Korea, South'),
(121, 'KW', 'Kuwait'),
(122, 'KY', 'Cayman Islands'),
(123, 'KZ', 'Kazakhstan'),
(124, 'LA', 'Laos'),
(125, 'LB', 'Lebanon'),
(126, 'LC', 'Saint Lucia'),
(127, 'LI', 'Liechtenstein'),
(128, 'LK', 'Sri Lanka'),
(129, 'LR', 'Liberia'),
(130, 'LS', 'Lesotho'),
(131, 'LT', 'Lithuania'),
(132, 'LU', 'Luxembourg'),
(133, 'LV', 'Latvia'),
(134, 'LY', 'Libya'),
(135, 'MA', 'Morocco'),
(136, 'MC', 'Monaco'),
(137, 'MD', 'Moldova'),
(138, 'ME', 'Montenegro'),
(139, 'MG', 'Madagascar'),
(140, 'MH', 'Marshall Islands'),
(141, 'MK', 'Macedonia'),
(142, 'ML', 'Mali'),
(143, 'MM', 'Myanmar (Burma)'),
(144, 'MN', 'Mongolia'),
(145, 'MO', 'Macau'),
(146, 'MP', 'Northern Mariana Islands'),
(147, 'MQ', 'Martinique'),
(148, 'MR', 'Mauritania'),
(149, 'MS', 'Montserrat'),
(150, 'MT', 'Malta'),
(151, 'MU', 'Mauritius'),
(152, 'MV', 'Maldives'),
(153, 'MW', 'Malawi'),
(154, 'MX', 'Mexico'),
(155, 'MY', 'Malaysia'),
(156, 'MZ', 'Mozambique'),
(157, 'NA', 'Namibia'),
(158, 'NC', 'New Caledonia'),
(159, 'NE', 'Niger'),
(160, 'NF', 'Norfolk Island'),
(161, 'NG', 'Nigeria'),
(162, 'NI', 'Nicaragua'),
(163, 'NL', 'Netherlands'),
(164, 'NO', 'Norway'),
(165, 'NP', 'Nepal'),
(166, 'NR', 'Nauru'),
(167, 'NU', 'Niue'),
(168, 'NZ', 'New Zealand'),
(169, 'OM', 'Oman'),
(170, 'PA', 'Panama'),
(171, 'PE', 'Peru'),
(172, 'PF', 'French Polynesia'),
(173, 'PG', 'Papua New Guinea'),
(174, 'PH', 'Philippines'),
(175, 'PK', 'Pakistan'),
(176, 'PL', 'Poland'),
(177, 'PM', 'Saint Pierre and Miquelon'),
(178, 'PN', 'Pitcairn Islands'),
(179, 'PR', 'Puerto Rico'),
(180, 'PT', 'Portugal'),
(181, 'PW', 'Palau'),
(182, 'PY', 'Paraguay'),
(183, 'QA', 'Qatar'),
(184, 'RE', 'Reunion'),
(185, 'RO', 'Romania'),
(186, 'RS', 'Serbia'),
(187, 'RU', 'Russia'),
(188, 'RW', 'Rwanda'),
(189, 'SA', 'Saudi Arabia'),
(190, 'SB', 'Solomon Islands'),
(191, 'SC', 'Seychelles'),
(192, 'SD', 'Sudan'),
(193, 'SE', 'Sweden'),
(194, 'SG', 'Singapore'),
(195, 'SH', 'Saint Helena'),
(196, 'SI', 'Slovenia'),
(197, 'SJ', 'Svalbard'),
(198, 'SK', 'Slovakia'),
(199, 'SL', 'Sierra Leone'),
(200, 'SM', 'San Marino'),
(201, 'SN', 'Senegal'),
(202, 'SO', 'Somalia'),
(203, 'SR', 'Suriname'),
(204, 'ST', 'Sao Tome and Principe'),
(205, 'SV', 'El Salvador'),
(206, 'SY', 'Syria'),
(207, 'SZ', 'Swaziland'),
(208, 'TA', 'Tristan da Cunha'),
(209, 'TC', 'Turks and Caicos Islands'),
(210, 'TD', 'Chad'),
(211, 'TF', 'French Southern and Antarctic Lands'),
(212, 'TG', 'Togo'),
(213, 'TH', 'Thailand'),
(214, 'TJ', 'Tajikistan'),
(215, 'TK', 'Tokelau'),
(216, 'TL', 'Timor-Leste (East Timor)'),
(217, 'TM', 'Turkmenistan'),
(218, 'TN', 'Tunisia'),
(219, 'TO', 'Tonga'),
(220, 'TR', 'Turkey'),
(221, 'TT', 'Trinidad and Tobago'),
(222, 'TV', 'Tuvalu'),
(223, 'TW', 'China, Republic of (Taiwan)'),
(224, 'TZ', 'Tanzania'),
(225, 'UA', 'Ukraine'),
(226, 'UG', 'Uganda'),
(227, 'UM', 'Baker Island'),
(228, 'US', 'United States'),
(229, 'UY', 'Uruguay'),
(230, 'UZ', 'Uzbekistan'),
(231, 'VA', 'Vatican City'),
(232, 'VC', 'Saint Vincent and the Grenadines'),
(233, 'VE', 'Venezuela'),
(234, 'VG', 'British Virgin Islands'),
(235, 'VI', 'U.S. Virgin Islands'),
(236, 'VN', 'Vietnam'),
(237, 'VU', 'Vanuatu'),
(238, 'WF', 'Wallis and Futuna'),
(239, 'WS', 'Samoa'),
(240, 'YE', 'Yemen'),
(241, 'YT', 'Mayotte'),
(242, 'ZA', 'South Africa'),
(243, 'ZM', 'Zambia'),
(244, 'ZW', 'Zimbabwe'),
(245, '-', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `nombre` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci,
  `documento` text COLLATE utf8_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil_especialidad`
--

CREATE TABLE `perfil_especialidad` (
  `id` int(10) UNSIGNED NOT NULL,
  `per_id` mediumint(8) UNSIGNED NOT NULL,
  `esp_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil_evaluacion_teorica`
--

CREATE TABLE `perfil_evaluacion_teorica` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `evt_id` mediumint(5) UNSIGNED NOT NULL COMMENT 'Evaluación teórica',
  `mop_id` mediumint(8) UNSIGNED NOT NULL COMMENT 'Modulo de perfil'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil_modulo`
--

CREATE TABLE `perfil_modulo` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `per_id` mediumint(8) UNSIGNED NOT NULL COMMENT 'Perfil',
  `evaluacion` set('TEORICA','PRACTICA') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Evaluacion'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recursos`
--

CREATE TABLE `recursos` (
  `id` int(10) UNSIGNED NOT NULL,
  `pre_id` int(10) UNSIGNED NOT NULL,
  `tipo` enum('AUDIO','IMAGE','VIDEO','SFW') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recursos_has_options`
--

CREATE TABLE `recursos_has_options` (
  `id` int(10) UNSIGNED NOT NULL,
  `rec_id` int(10) UNSIGNED NOT NULL,
  `opt_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recursos_has_sources`
--

CREATE TABLE `recursos_has_sources` (
  `id` int(10) UNSIGNED NOT NULL,
  `rec_id` int(10) UNSIGNED NOT NULL,
  `src_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recursos_options`
--

CREATE TABLE `recursos_options` (
  `id` int(10) UNSIGNED NOT NULL,
  `variable` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `valor` varchar(512) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` enum('STRING','INTEGER','FLOAT','JSON') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'STRING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recursos_sources`
--

CREATE TABLE `recursos_sources` (
  `id` int(10) UNSIGNED NOT NULL,
  `src` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `type` enum('application/excel','application/msword','application/pdf','application/vnd.ms-excel','application/x-excel','application/x-msexcel','audio/aac','audio/mp4','audio/mpeg','audio/ogg','audio/wav','audio/webm','image/bmp','image/gif','image/jpeg','image/png','text/html','text/plain','video/avi','video/mp4','video/mpeg','video/ogg','video/quicktime','video/webm') COLLATE utf8_spanish_ci NOT NULL,
  `title` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `test`
--

CREATE TABLE `test` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(128) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nacimiento` date NOT NULL,
  `hijos` tinyint(3) UNSIGNED NOT NULL,
  `civil` enum('SOLTERO/A','CASADO/A','DIVORCIADO/A','SEPARADO','CONVIVIENTE') COLLATE utf8_spanish_ci NOT NULL,
  `licencia` set('A1','A2','A3','A4','A5','B','C','D','E','F') COLLATE utf8_spanish_ci NOT NULL,
  `estatura` decimal(3,2) NOT NULL,
  `comuna` smallint(5) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `test`
--

INSERT INTO `test` (`id`, `nombre`, `nacimiento`, `hijos`, `civil`, `licencia`, `estatura`, `comuna`) VALUES
(4, 'Ruben Eduardo Tejeda Roa', '1992-04-12', 0, 'SOLTERO/A', 'A1,B', '1.71', NULL),
(18, 'Rodrigo', '2017-03-13', 9, 'SOLTERO/A', 'A1,A2', '1.60', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajador`
--

CREATE TABLE `trabajador` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'Trabajador',
  `com_id` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'Comuna',
  `rut` varchar(12) COLLATE utf8_spanish_ci NOT NULL COMMENT 'RUT',
  `nombre` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Nombres',
  `paterno` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Apellido paterno',
  `materno` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Apellido materno',
  `nacimiento` date DEFAULT NULL COMMENT 'Fecha de nacimiento',
  `fono` varchar(36) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Numero Telefonico',
  `mail` varchar(128) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'e-mail',
  `gerencia` varchar(128) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Gerencia',
  `antiguedad` tinyint(4) DEFAULT NULL COMMENT 'Años de antigüedad',
  `civil` enum('SOLTERO/A','CASADO/A','DIVORCIADO/A','SEPARADO','CONVIVIENTE') COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Estado civil',
  `hijos` int(11) DEFAULT NULL COMMENT 'Cantidad de hijos',
  `licencia` set('A1','A2','A3','A4','A5','B','C','D','E','F') COLLATE utf8_spanish_ci DEFAULT NULL,
  `talla` enum('XXS','XS','S','M','L','XL','XXL','XXXL') COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` text COLLATE utf8_spanish_ci COMMENT 'Dirección',
  `contacto` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  `afp` enum('AFP Cuprum','AFP Habitat','AFP PlanVital','ProVida AFP','AFP Capital','AFP Modelo') COLLATE utf8_spanish_ci DEFAULT NULL,
  `prevision` enum('FONASA','BANMEDICA','CONSALUD','CRUZ BLANCA','ING','CAPREDENA','DIPRECA','MASVIDA','SIN PREVISIÓN') COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Previsión de salud',
  `nivel` enum('Basica completa','Media incompleta','Media completa','Tecnica','Técnico en nivel superior incompleta','Técnico en nivel superior','Profesional incompleta','Profesional') COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Nivel educacional',
  `creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación',
  `modificacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de modificación'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `trabajador`
--

INSERT INTO `trabajador` (`id`, `com_id`, `rut`, `nombre`, `paterno`, `materno`, `nacimiento`, `fono`, `mail`, `gerencia`, `antiguedad`, `civil`, `hijos`, `licencia`, `talla`, `direccion`, `contacto`, `afp`, `prevision`, `nivel`, `creacion`, `modificacion`) VALUES
(1, NULL, '18.108.559-2', 'Ruben Eduardo', 'Tejeda', 'Roa', '1992-04-12', '+5691223304', 'rubentejedaroa@gmail.com', 'Santa Fe', 1, 'SOLTERO/A', NULL, 'A2', 'M', 'calle seis #2682, concepción Hualpen.', NULL, NULL, NULL, '', '2017-03-09 18:54:02', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajador_experiencia`
--

CREATE TABLE `trabajador_experiencia` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'Experiencia',
  `tra_id` int(10) UNSIGNED NOT NULL COMMENT 'Trabajador',
  `esp_id` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'Especialidad',
  `emp_id` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'Empresa Contratista',
  `suc_id` mediumint(8) UNSIGNED DEFAULT NULL COMMENT 'Planta',
  `inicio` date NOT NULL COMMENT 'Fecha de inicio',
  `termino` date NOT NULL COMMENT 'Fecha de termino',
  `cargo` varchar(128) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Cargo',
  `funciones` text COLLATE utf8_spanish_ci COMMENT 'Funciones desempeñadas'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'Usuario',
  `username` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Username',
  `rut` varchar(12) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'RUT',
  `mail` varchar(128) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Correo',
  `password` varchar(40) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Contraseña',
  `nombre` varchar(128) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombres',
  `paterno` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Apellido paterno',
  `materno` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Apellido materno',
  `cargo` varchar(128) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Cargo',
  `nacimiento` date DEFAULT NULL COMMENT 'Fecha de nacimiento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `username`, `rut`, `mail`, `password`, `nombre`, `paterno`, `materno`, `cargo`, `nacimiento`) VALUES
(1, 'ruben', '18.108.559-2', 'rubentejedaroa@gmail.com', '164352', 'Rubencillo', 'Tejeda', 'Roa', 'Administrador del Sistema', '1992-04-12'),
(2, 'trabajador-qplan', NULL, NULL, 'qualitat-2017', 'Aplicación de Qplan', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_authentication`
--

CREATE TABLE `user_authentication` (
  `token` char(32) COLLATE utf8_spanish_ci NOT NULL,
  `refresh` char(32) COLLATE utf8_spanish_ci DEFAULT NULL,
  `expire` int(11) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `user_authentication`
--

INSERT INTO `user_authentication` (`token`, `refresh`, `expire`, `user_id`, `client_id`) VALUES
('1kFlEPbD6X8L6WOhbh7ImZ7Q86gpxkMi', NULL, 1489177821, 1, 1),
('bKE2EIgCQBAGIofK6DCn0Fxz6D8dbcDO', NULL, 1489075099, 2, 1),
('bMLQOJICUZasbeF8-KtpOoY0rwZqKnmj', 'Av7xgTNkmCq2parNQcxUbIdNOyhqONWo', 1489075115, 2, 1),
('bNyJIbqDiZzK5xx2SS3rDeeCbm0MfEXt', 'vf_cIM2QeHyUbqbWxEX0DVeC_Qn8A3sm', 1489177808, 1, 1),
('dSnBt7KTl35jPmPUjwZbyXH3DTcShLPg', 'Sa38-5XCFYQFQlJCAsCD79Zee4GjzaQ_', 1489075081, 2, 1),
('Egp6p3RBR9OUMt34LXkn10ClVESeBuCo', NULL, 1489074335, 2, 1),
('mO1Hmc8jP2PF_rUrZvhQC7Vwg0qR1HpP', NULL, 1489075107, 2, 1),
('POWLTwJmaRt68BdClhlBFEgx_EvtQ6c_', NULL, 1489074343, 2, 1),
('sYoG7BPnvIRmN_OkqYe-WtoVkaF9pwDV', NULL, 1489586878, 1, 1),
('U77Mf5JU3OAbh7BebGseEn-oWBeNxxrD', NULL, 1588819394, 1, 1),
('vkYQW918pUsKATJnbugSRWE3xrK4BHY7', 'iG1tAptcrYuDwIim8EXQa0flFFMJ_pIP', 1489179601, 2, 1),
('zjn5pRj2YaLcIOvuUCVpNH0IA-xr8xgQ', 'BZqufhtI0IIWM_P3nNlOyFvlvLcWZm9R', 1489077564, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_authorization`
--

CREATE TABLE `user_authorization` (
  `user_id` int(10) UNSIGNED NOT NULL COMMENT 'Usuario',
  `res_id` smallint(5) UNSIGNED NOT NULL COMMENT 'Recurso'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `user_authorization`
--

INSERT INTO `user_authorization` (`user_id`, `res_id`) VALUES
(1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_client`
--

CREATE TABLE `user_client` (
  `client_id` int(11) UNSIGNED NOT NULL,
  `secret` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL,
  `name` varchar(64) COLLATE utf8_spanish_ci DEFAULT NULL,
  `redirect` varchar(512) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `user_client`
--

INSERT INTO `user_client` (`client_id`, `secret`, `name`, `redirect`) VALUES
(1, 'qualitat2016', 'qplan-evaluacion', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_resource`
--

CREATE TABLE `user_resource` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `resource` varchar(128) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `user_resource`
--

INSERT INTO `user_resource` (`id`, `resource`) VALUES
(1, 'Admin'),
(31, 'Cliente'),
(30, 'Funcionario'),
(27, 'Qplan_authorization_identity'),
(25, 'Qplan_authorization_index'),
(33, 'Qplan_authorization_permission'),
(28, 'Qplan_authorization_resources'),
(26, 'Qplan_authorization_view'),
(0, 'RESOURCE'),
(2, 'ROLE'),
(29, 'Trabajador'),
(32, 'Unity'),
(24, 'v1_users_delete'),
(20, 'v1_users_identity'),
(21, 'v1_users_index'),
(23, 'v1_users_update'),
(22, 'v1_users_view');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_resource_children`
--

CREATE TABLE `user_resource_children` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` smallint(5) UNSIGNED NOT NULL,
  `child_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `user_resource_children`
--

INSERT INTO `user_resource_children` (`id`, `parent_id`, `child_id`) VALUES
(1, 0, 20),
(2, 0, 21),
(3, 0, 22),
(4, 0, 23),
(5, 0, 24),
(6, 0, 25),
(7, 0, 26),
(8, 0, 27),
(9, 0, 28),
(17, 0, 33),
(10, 1, 31),
(11, 2, 1),
(12, 2, 29),
(13, 2, 30),
(14, 2, 31),
(15, 2, 32);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clasificacion`
--
ALTER TABLE `clasificacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indices de la tabla `clasificacion_categoria`
--
ALTER TABLE `clasificacion_categoria`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `clasificacion_perfil`
--
ALTER TABLE `clasificacion_perfil`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cla_id` (`cla_id`,`per_id`),
  ADD KEY `per_id` (`per_id`);

--
-- Indices de la tabla `comuna`
--
ALTER TABLE `comuna`
  ADD PRIMARY KEY (`com_id`),
  ADD KEY `pro_id` (`pro_id`);

--
-- Indices de la tabla `comuna_provincia`
--
ALTER TABLE `comuna_provincia`
  ADD PRIMARY KEY (`pro_id`),
  ADD KEY `reg_id` (`reg_id`);

--
-- Indices de la tabla `comuna_region`
--
ALTER TABLE `comuna_region`
  ADD PRIMARY KEY (`reg_id`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rut` (`rut`),
  ADD KEY `com_id` (`com_id`),
  ADD KEY `pais_id` (`pais_id`);

--
-- Indices de la tabla `empresa_clasificacion`
--
ALTER TABLE `empresa_clasificacion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cla_id` (`cla_id`,`emp_id`,`per_id`),
  ADD KEY `emp_id` (`emp_id`),
  ADD KEY `per_id` (`per_id`);

--
-- Indices de la tabla `empresa_sucursal`
--
ALTER TABLE `empresa_sucursal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indices de la tabla `empresa_user`
--
ALTER TABLE `empresa_user`
  ADD PRIMARY KEY (`emu_id`),
  ADD UNIQUE KEY `emp_id` (`emp_id`,`usu_id`),
  ADD KEY `usu_id` (`usu_id`);

--
-- Indices de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indices de la tabla `especialidad_area`
--
ALTER TABLE `especialidad_area`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `especialidad_cargo`
--
ALTER TABLE `especialidad_cargo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `are_id` (`are_id`);

--
-- Indices de la tabla `evaluacion_alternativa`
--
ALTER TABLE `evaluacion_alternativa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pre_id` (`pre_id`);

--
-- Indices de la tabla `evaluacion_item`
--
ALTER TABLE `evaluacion_item`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `evt_id_2` (`evt_id`,`tipo`),
  ADD KEY `evt_id` (`evt_id`);

--
-- Indices de la tabla `evaluacion_pregunta`
--
ALTER TABLE `evaluacion_pregunta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ite_id` (`ite_id`);

--
-- Indices de la tabla `evaluacion_teorica`
--
ALTER TABLE `evaluacion_teorica`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tev_id` (`tev_id`);

--
-- Indices de la tabla `evaluacion_tipo`
--
ALTER TABLE `evaluacion_tipo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `ficha`
--
ALTER TABLE `ficha`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ot_id` (`ot_id`,`tra_id`),
  ADD KEY `tra_id` (`tra_id`);

--
-- Indices de la tabla `ficha_item`
--
ALTER TABLE `ficha_item`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ite_id` (`ite_id`,`teo_id`),
  ADD KEY `teo_id` (`teo_id`);

--
-- Indices de la tabla `ficha_practica`
--
ALTER TABLE `ficha_practica`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mod_id` (`mod_id`,`fic_id`),
  ADD KEY `fic_id` (`fic_id`);

--
-- Indices de la tabla `ficha_respuesta`
--
ALTER TABLE `ficha_respuesta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fide_id` (`fide_id`,`alt_id`),
  ADD KEY `alt_id` (`alt_id`);

--
-- Indices de la tabla `ficha_teorico`
--
ALTER TABLE `ficha_teorico`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orden_trabajo`
--
ALTER TABLE `orden_trabajo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sol_id` (`sol_id`),
  ADD KEY `per_id` (`per_id`),
  ADD KEY `esp_id` (`esp_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indices de la tabla `orden_trabajo_solicitud`
--
ALTER TABLE `orden_trabajo_solicitud`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orden_trabajo_trabajador`
--
ALTER TABLE `orden_trabajo_trabajador`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ot_id` (`ot_id`,`tra_id`),
  ADD KEY `tra_id` (`tra_id`);

--
-- Indices de la tabla `pais`
--
ALTER TABLE `pais`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`codigo`),
  ADD UNIQUE KEY `codigo` (`nombre`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `perfil_especialidad`
--
ALTER TABLE `perfil_especialidad`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `per_id` (`per_id`,`esp_id`),
  ADD KEY `esp_id` (`esp_id`);

--
-- Indices de la tabla `perfil_evaluacion_teorica`
--
ALTER TABLE `perfil_evaluacion_teorica`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `evt_id` (`evt_id`,`mop_id`),
  ADD KEY `mop_id` (`mop_id`);

--
-- Indices de la tabla `perfil_modulo`
--
ALTER TABLE `perfil_modulo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `per_id` (`per_id`);

--
-- Indices de la tabla `recursos`
--
ALTER TABLE `recursos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pre_id` (`pre_id`);

--
-- Indices de la tabla `recursos_has_options`
--
ALTER TABLE `recursos_has_options`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rec_id` (`rec_id`,`opt_id`),
  ADD KEY `opt_id` (`opt_id`);

--
-- Indices de la tabla `recursos_has_sources`
--
ALTER TABLE `recursos_has_sources`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rec_id` (`rec_id`,`src_id`),
  ADD KEY `src_id` (`src_id`);

--
-- Indices de la tabla `recursos_options`
--
ALTER TABLE `recursos_options`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `recursos_sources`
--
ALTER TABLE `recursos_sources`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `src` (`src`);

--
-- Indices de la tabla `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comuna` (`comuna`);

--
-- Indices de la tabla `trabajador`
--
ALTER TABLE `trabajador`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rut` (`rut`),
  ADD KEY `com_id` (`com_id`);

--
-- Indices de la tabla `trabajador_experiencia`
--
ALTER TABLE `trabajador_experiencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tra_id` (`tra_id`),
  ADD KEY `tra_id_2` (`tra_id`),
  ADD KEY `esp_id` (`esp_id`),
  ADD KEY `emp_id` (`emp_id`),
  ADD KEY `pla_id` (`suc_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `mail` (`mail`),
  ADD UNIQUE KEY `rut` (`rut`);

--
-- Indices de la tabla `user_authentication`
--
ALTER TABLE `user_authentication`
  ADD PRIMARY KEY (`token`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `user_authorization`
--
ALTER TABLE `user_authorization`
  ADD PRIMARY KEY (`user_id`,`res_id`),
  ADD KEY `res_id` (`res_id`);

--
-- Indices de la tabla `user_client`
--
ALTER TABLE `user_client`
  ADD PRIMARY KEY (`client_id`);

--
-- Indices de la tabla `user_resource`
--
ALTER TABLE `user_resource`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `resource` (`resource`);

--
-- Indices de la tabla `user_resource_children`
--
ALTER TABLE `user_resource_children`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `parent_id` (`parent_id`,`child_id`),
  ADD KEY `child_id` (`child_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clasificacion`
--
ALTER TABLE `clasificacion`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `clasificacion_categoria`
--
ALTER TABLE `clasificacion_categoria`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `clasificacion_perfil`
--
ALTER TABLE `clasificacion_perfil`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Empresa', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `empresa_clasificacion`
--
ALTER TABLE `empresa_clasificacion`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `empresa_sucursal`
--
ALTER TABLE `empresa_sucursal`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT de la tabla `empresa_user`
--
ALTER TABLE `empresa_user`
  MODIFY `emu_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Especialidad';
--
-- AUTO_INCREMENT de la tabla `especialidad_area`
--
ALTER TABLE `especialidad_area`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `especialidad_cargo`
--
ALTER TABLE `especialidad_cargo`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `evaluacion_alternativa`
--
ALTER TABLE `evaluacion_alternativa`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `evaluacion_item`
--
ALTER TABLE `evaluacion_item`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Ítem de evaluación';
--
-- AUTO_INCREMENT de la tabla `evaluacion_pregunta`
--
ALTER TABLE `evaluacion_pregunta`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `evaluacion_teorica`
--
ALTER TABLE `evaluacion_teorica`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `evaluacion_tipo`
--
ALTER TABLE `evaluacion_tipo`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Tipo de evaluación';
--
-- AUTO_INCREMENT de la tabla `ficha`
--
ALTER TABLE `ficha`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ficha_item`
--
ALTER TABLE `ficha_item`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ficha_practica`
--
ALTER TABLE `ficha_practica`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ficha_respuesta`
--
ALTER TABLE `ficha_respuesta`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ficha_teorico`
--
ALTER TABLE `ficha_teorico`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `orden_trabajo`
--
ALTER TABLE `orden_trabajo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Orden de Trabajo';
--
-- AUTO_INCREMENT de la tabla `orden_trabajo_solicitud`
--
ALTER TABLE `orden_trabajo_solicitud`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `orden_trabajo_trabajador`
--
ALTER TABLE `orden_trabajo_trabajador`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `pais`
--
ALTER TABLE `pais`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;
--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `perfil_especialidad`
--
ALTER TABLE `perfil_especialidad`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `perfil_evaluacion_teorica`
--
ALTER TABLE `perfil_evaluacion_teorica`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `perfil_modulo`
--
ALTER TABLE `perfil_modulo`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `recursos`
--
ALTER TABLE `recursos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `recursos_has_options`
--
ALTER TABLE `recursos_has_options`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `recursos_has_sources`
--
ALTER TABLE `recursos_has_sources`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `recursos_options`
--
ALTER TABLE `recursos_options`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `recursos_sources`
--
ALTER TABLE `recursos_sources`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `test`
--
ALTER TABLE `test`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT de la tabla `trabajador`
--
ALTER TABLE `trabajador`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Trabajador', AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `trabajador_experiencia`
--
ALTER TABLE `trabajador_experiencia`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Experiencia';
--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Usuario', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `user_client`
--
ALTER TABLE `user_client`
  MODIFY `client_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `user_resource`
--
ALTER TABLE `user_resource`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT de la tabla `user_resource_children`
--
ALTER TABLE `user_resource_children`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clasificacion`
--
ALTER TABLE `clasificacion`
  ADD CONSTRAINT `clasificacion_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `clasificacion_categoria` (`id`);

--
-- Filtros para la tabla `clasificacion_perfil`
--
ALTER TABLE `clasificacion_perfil`
  ADD CONSTRAINT `clasificacion_perfil_ibfk_1` FOREIGN KEY (`cla_id`) REFERENCES `clasificacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `clasificacion_perfil_ibfk_2` FOREIGN KEY (`per_id`) REFERENCES `perfil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comuna`
--
ALTER TABLE `comuna`
  ADD CONSTRAINT `comuna_ibfk_1` FOREIGN KEY (`pro_id`) REFERENCES `comuna_provincia` (`pro_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `comuna_provincia`
--
ALTER TABLE `comuna_provincia`
  ADD CONSTRAINT `comuna_provincia_ibfk_1` FOREIGN KEY (`reg_id`) REFERENCES `comuna_region` (`reg_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT `empresa_ibfk_1` FOREIGN KEY (`com_id`) REFERENCES `comuna` (`com_id`),
  ADD CONSTRAINT `empresa_ibfk_2` FOREIGN KEY (`pais_id`) REFERENCES `pais` (`id`);

--
-- Filtros para la tabla `empresa_clasificacion`
--
ALTER TABLE `empresa_clasificacion`
  ADD CONSTRAINT `empresa_clasificacion_ibfk_1` FOREIGN KEY (`cla_id`) REFERENCES `clasificacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `empresa_clasificacion_ibfk_2` FOREIGN KEY (`emp_id`) REFERENCES `empresa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `empresa_clasificacion_ibfk_3` FOREIGN KEY (`per_id`) REFERENCES `perfil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `empresa_sucursal`
--
ALTER TABLE `empresa_sucursal`
  ADD CONSTRAINT `empresa_sucursal_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `empresa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `empresa_user`
--
ALTER TABLE `empresa_user`
  ADD CONSTRAINT `empresa_user_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `empresa` (`id`),
  ADD CONSTRAINT `empresa_user_ibfk_2` FOREIGN KEY (`usu_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `especialidad`
--
ALTER TABLE `especialidad`
  ADD CONSTRAINT `especialidad_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `especialidad_cargo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `especialidad_cargo`
--
ALTER TABLE `especialidad_cargo`
  ADD CONSTRAINT `especialidad_cargo_ibfk_1` FOREIGN KEY (`are_id`) REFERENCES `especialidad_area` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `evaluacion_alternativa`
--
ALTER TABLE `evaluacion_alternativa`
  ADD CONSTRAINT `evaluacion_alternativa_ibfk_1` FOREIGN KEY (`pre_id`) REFERENCES `evaluacion_pregunta` (`id`);

--
-- Filtros para la tabla `evaluacion_item`
--
ALTER TABLE `evaluacion_item`
  ADD CONSTRAINT `evaluacion_item_ibfk_1` FOREIGN KEY (`evt_id`) REFERENCES `evaluacion_teorica` (`id`);

--
-- Filtros para la tabla `evaluacion_pregunta`
--
ALTER TABLE `evaluacion_pregunta`
  ADD CONSTRAINT `evaluacion_pregunta_ibfk_1` FOREIGN KEY (`ite_id`) REFERENCES `evaluacion_item` (`id`);

--
-- Filtros para la tabla `evaluacion_teorica`
--
ALTER TABLE `evaluacion_teorica`
  ADD CONSTRAINT `evaluacion_teorica_ibfk_1` FOREIGN KEY (`tev_id`) REFERENCES `evaluacion_tipo` (`id`);

--
-- Filtros para la tabla `ficha`
--
ALTER TABLE `ficha`
  ADD CONSTRAINT `ficha_ibfk_1` FOREIGN KEY (`ot_id`) REFERENCES `orden_trabajo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ficha_ibfk_2` FOREIGN KEY (`tra_id`) REFERENCES `trabajador` (`id`);

--
-- Filtros para la tabla `ficha_item`
--
ALTER TABLE `ficha_item`
  ADD CONSTRAINT `ficha_item_ibfk_1` FOREIGN KEY (`ite_id`) REFERENCES `evaluacion_item` (`id`),
  ADD CONSTRAINT `ficha_item_ibfk_2` FOREIGN KEY (`teo_id`) REFERENCES `ficha_teorico` (`id`);

--
-- Filtros para la tabla `ficha_practica`
--
ALTER TABLE `ficha_practica`
  ADD CONSTRAINT `ficha_practica_ibfk_1` FOREIGN KEY (`mod_id`) REFERENCES `perfil_modulo` (`id`),
  ADD CONSTRAINT `ficha_practica_ibfk_2` FOREIGN KEY (`fic_id`) REFERENCES `ficha` (`id`);

--
-- Filtros para la tabla `ficha_respuesta`
--
ALTER TABLE `ficha_respuesta`
  ADD CONSTRAINT `ficha_respuesta_ibfk_1` FOREIGN KEY (`fide_id`) REFERENCES `ficha_item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ficha_respuesta_ibfk_2` FOREIGN KEY (`alt_id`) REFERENCES `evaluacion_alternativa` (`id`);

--
-- Filtros para la tabla `orden_trabajo`
--
ALTER TABLE `orden_trabajo`
  ADD CONSTRAINT `orden_trabajo_ibfk_1` FOREIGN KEY (`sol_id`) REFERENCES `orden_trabajo_solicitud` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orden_trabajo_ibfk_2` FOREIGN KEY (`emp_id`) REFERENCES `empresa` (`id`),
  ADD CONSTRAINT `orden_trabajo_ibfk_3` FOREIGN KEY (`esp_id`) REFERENCES `especialidad` (`id`),
  ADD CONSTRAINT `orden_trabajo_ibfk_4` FOREIGN KEY (`sol_id`) REFERENCES `orden_trabajo_solicitud` (`id`);

--
-- Filtros para la tabla `orden_trabajo_trabajador`
--
ALTER TABLE `orden_trabajo_trabajador`
  ADD CONSTRAINT `orden_trabajo_trabajador_ibfk_1` FOREIGN KEY (`ot_id`) REFERENCES `orden_trabajo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orden_trabajo_trabajador_ibfk_2` FOREIGN KEY (`tra_id`) REFERENCES `trabajador` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `perfil_especialidad`
--
ALTER TABLE `perfil_especialidad`
  ADD CONSTRAINT `perfil_especialidad_ibfk_1` FOREIGN KEY (`per_id`) REFERENCES `perfil` (`id`),
  ADD CONSTRAINT `perfil_especialidad_ibfk_2` FOREIGN KEY (`esp_id`) REFERENCES `especialidad` (`id`);

--
-- Filtros para la tabla `perfil_evaluacion_teorica`
--
ALTER TABLE `perfil_evaluacion_teorica`
  ADD CONSTRAINT `perfil_evaluacion_teorica_ibfk_1` FOREIGN KEY (`mop_id`) REFERENCES `perfil_modulo` (`id`),
  ADD CONSTRAINT `perfil_evaluacion_teorica_ibfk_2` FOREIGN KEY (`evt_id`) REFERENCES `evaluacion_teorica` (`id`);

--
-- Filtros para la tabla `perfil_modulo`
--
ALTER TABLE `perfil_modulo`
  ADD CONSTRAINT `perfil_modulo_ibfk_1` FOREIGN KEY (`per_id`) REFERENCES `perfil` (`id`);

--
-- Filtros para la tabla `recursos`
--
ALTER TABLE `recursos`
  ADD CONSTRAINT `recursos_ibfk_1` FOREIGN KEY (`pre_id`) REFERENCES `evaluacion_pregunta` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `recursos_has_options`
--
ALTER TABLE `recursos_has_options`
  ADD CONSTRAINT `recursos_has_options_ibfk_1` FOREIGN KEY (`rec_id`) REFERENCES `recursos` (`id`),
  ADD CONSTRAINT `recursos_has_options_ibfk_2` FOREIGN KEY (`opt_id`) REFERENCES `recursos_options` (`id`);

--
-- Filtros para la tabla `recursos_has_sources`
--
ALTER TABLE `recursos_has_sources`
  ADD CONSTRAINT `recursos_has_sources_ibfk_1` FOREIGN KEY (`rec_id`) REFERENCES `recursos` (`id`),
  ADD CONSTRAINT `recursos_has_sources_ibfk_2` FOREIGN KEY (`src_id`) REFERENCES `recursos_sources` (`id`);

--
-- Filtros para la tabla `test`
--
ALTER TABLE `test`
  ADD CONSTRAINT `test_ibfk_1` FOREIGN KEY (`comuna`) REFERENCES `comuna` (`com_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `trabajador`
--
ALTER TABLE `trabajador`
  ADD CONSTRAINT `trabajador_ibfk_1` FOREIGN KEY (`com_id`) REFERENCES `comuna` (`com_id`);

--
-- Filtros para la tabla `trabajador_experiencia`
--
ALTER TABLE `trabajador_experiencia`
  ADD CONSTRAINT `trabajador_experiencia_ibfk_1` FOREIGN KEY (`tra_id`) REFERENCES `trabajador` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `trabajador_experiencia_ibfk_2` FOREIGN KEY (`esp_id`) REFERENCES `especialidad` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `trabajador_experiencia_ibfk_3` FOREIGN KEY (`emp_id`) REFERENCES `empresa` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `trabajador_experiencia_ibfk_4` FOREIGN KEY (`suc_id`) REFERENCES `empresa_sucursal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user_authentication`
--
ALTER TABLE `user_authentication`
  ADD CONSTRAINT `user_authentication_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `user_client` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_authentication_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user_authorization`
--
ALTER TABLE `user_authorization`
  ADD CONSTRAINT `user_authorization_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_authorization_ibfk_2` FOREIGN KEY (`res_id`) REFERENCES `user_resource` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user_resource_children`
--
ALTER TABLE `user_resource_children`
  ADD CONSTRAINT `user_resource_children_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `user_resource` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_resource_children_ibfk_2` FOREIGN KEY (`child_id`) REFERENCES `user_resource` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
