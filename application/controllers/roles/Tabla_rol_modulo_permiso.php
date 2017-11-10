<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tabla_rol_modulo_permiso extends CI_Controller {

	function __construct(){
		parent::__construct();
		/************ Librerias para llamar funciones predefenidas **********/
		$this->load->helper(array('url','form','funciones_rapidas'));
		$this->load->model('rol_modulo_permiso_model');
	}

	public function index(){
		$objeto =  new stdClass();
		$objeto->roles = $roles = $this->rol_modulo_permiso_model->mostrar_rol_modulo_permiso();
		
		$this->load->view('roles/tabla_rol_modulo_permiso',$objeto);
	}
}
?>