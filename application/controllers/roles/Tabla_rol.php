<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tabla_rol extends CI_Controller {

	function __construct(){
		parent::__construct();
		/************ Librerias para llamar funciones predefenidas **********/
		$this->load->helper(array('url','form','funciones_rapidas'));
		$this->load->model('rol_modulo_permiso_model');
	}

	public function index($id){
		
		$objeto['id_sistema'] = $id;
		$this->load->view('roles/tabla_modulos',$objeto);
	}
}
?>