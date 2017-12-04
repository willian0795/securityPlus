--
-- Volcado de datos para la tabla `org_modulo`
--

INSERT INTO `org_modulo` (`id_modulo`, `id_sistema`, `nombre_modulo`, `descripcion_modulo`, `orden`, `dependencia`, `url_modulo`, `img_modulo`, `opciones_modulo`) VALUES
(324, 15, 'Configuraciones', '', 1, 0, '#!', 'mdi mdi-settings', 0),
(325, 15, 'Horarios viáticos', '', 2, 324, 'configuraciones/horarios', 'mdi mdi-label', 0),
(326, 15, 'Bancos', '', 1, 324, 'configuraciones/bancos', 'mdi mdi-label', 0),
(327, 15, 'Oficinas mtps', '', 3, 324, 'configuraciones/oficinas', 'mdi mdi-label', 0),
(328, 15, 'Gestion de rutas', '', 4, 324, 'configuraciones/rutas', 'mdi mdi-label', 0),
(329, 15, 'Viáticos y pasajes', '', 2, 0, '#!', 'mdi mdi-bus', 0),
(330, 15, 'Crear solicitud', '', 1, 329, 'viatico/solicitud', 'mdi mdi-label', 0);

--
-- Índices para tablas volcadas
--