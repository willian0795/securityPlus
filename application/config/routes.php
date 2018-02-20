<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

/**********************************************************************************************
		INICIO DE LA APLIACIÓN
***********************************************************************************************/
$route['default_controller'] = 'inicio';

/**********************************************************************************************
		LOGIN - SESIONES
***********************************************************************************************/
$route['cerrar_sesion'] = '/login/cerrar_sesion';

/**********************************************************************************************
		MODULO DE SISTEMAS
***********************************************************************************************/
$route['sistemas'] = '/sistemas/sistema';
$route['sistemas/tabla_sistema'] = '/sistemas/sistema/tabla_sistema';
$route['sistemas/gestionar_sistemas'] = '/sistemas/sistema/gestionar_sistemas';

$route['modulos'] = '/sistemas/modulo';
$route['modulos/gestionar_modulos'] = '/sistemas/modulo/gestionar_modulos';
$route['modulos/ordenar_modulo'] = '/sistemas/modulo/ordenar_modulo';
$route['modulos/tabla_modulo'] = '/sistemas/modulo/tabla_modulo';
$route['modulos/tabla_modulo2'] = '/sistemas/modulo/tabla_modulo2';
$route['modulos/combo_modulo'] = '/sistemas/modulo/combo_modulo';

/**********************************************************************************************
		MODULO DE USUARIOS
***********************************************************************************************/
$route['usuarios'] = '/usuarios/usuarios';
$route['usuarios/gestionar_usuarios'] = '/usuarios/usuarios/gestionar_usuarios';
$route['usuarios/obtener_usuario'] = '/usuarios/usuarios/obtener_usuario';
$route['usuarios/gestionar_roles'] = '/usuarios/usuarios/gestionar_roles';
$route['usuarios/tabla_usuario'] = '/usuarios/usuarios/tabla_usuario';
$route['usuarios/tabla_roles'] = '/usuarios/usuarios/tabla_roles';
$route['usuarios/form_datos'] = '/usuarios/usuarios/form_datos';

/**********************************************************************************************
		MODULO DE ROLES
***********************************************************************************************/

/**********************************************************************************************
		MODULO DE BITÁCORA
***********************************************************************************************/
$route['mapa'] = 'mapa';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
