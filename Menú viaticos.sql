--
-- Volcado de datos para la tabla `org_modulo`
--

INSERT INTO `org_modulo` (`id_modulo`, `id_sistema`, `nombre_modulo`, `descripcion_modulo`, `orden`, `dependencia`, `url_modulo`, `img_modulo`, `opciones_modulo`) VALUES
(312, 15, 'Configuraciones', '', 1, 0, '#!', 'mdi mdi-settings', 0),
(313, 15, 'Horarios viáticos', '', 2, 324, 'configuraciones/horarios', 'mdi mdi-label', 0),
(314, 15, 'Bancos', '', 1, 324, 'configuraciones/bancos', 'mdi mdi-label', 0),
(315, 15, 'Oficinas mtps', '', 3, 324, 'configuraciones/oficinas', 'mdi mdi-label', 0),
(316, 15, 'Gestion de rutas', '', 4, 324, 'configuraciones/rutas', 'mdi mdi-label', 0),
(317, 15, 'Viáticos y pasajes', '', 2, 0, '#!', 'mdi mdi-bus', 0),
(318, 15, 'Crear solicitud', '', 1, 329, 'viatico/mision_oficial', 'mdi mdi-label', 0);

--
-- Índices para tablas volcadas
--