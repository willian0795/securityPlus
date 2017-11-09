<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tablaroles extends CI_Controller {

	function __construct(){
		parent::__construct();
		/************ Librerias para llamar funciones predefenidas **********/
		$this->load->helper(array('url','form','funciones_rapidas'));
		$this->load->model('roles_model');
	}

	public function index(){
		$objeto =  new stdClass();
		$objeto->roles = $roles = $this->roles_model->mostrar_rol();
		
		$this->load->view('roles/tabla_roles',$objeto);
	}
}
?>