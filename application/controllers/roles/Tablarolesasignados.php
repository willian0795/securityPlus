<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tablarolesasignados extends CI_Controller {

	function __construct(){
		parent::__construct();
		/************ Librerias para llamar funciones predefenidas **********/
		$this->load->helper(array('url','form','funciones_rapidas'));
		$this->load->model('rolesasignado_model');
	}

	public function index(){
		$objeto =  new stdClass();
		$objeto->rolesasignados = $rolesasignados  = $this->rolesasignado_model->mostrar_rolasignado();
		
		$this->load->view('roles/tablarolesasignados',$objeto);
	}
}
?>