<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tablamodulos extends CI_Controller {

	function __construct(){
		parent::__construct();
		/************ Librerias para llamar funciones predefenidas **********/
		$this->load->helper(array('url','form','funciones_rapidas'));
		$this->load->model('modulos_model');
	}

	public function index(){
		$this->load->view('sistemas/tabla_modulo');
	}
}
?>