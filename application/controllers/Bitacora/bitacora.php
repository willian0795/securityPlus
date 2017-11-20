<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bitacora extends CI_Controller {

	function __construct(){
		parent::__construct();
		/************ Librerias para llamar funciones predefenidas **********/		
	}

	public function index(){
		$this->load->view('templates/header');
		$this->load->view('bitacora/bitacora');		
		$this->load->view('templates/footer');
	}

    public function tabla_bitacora(){
		$this->load->view('bitacora/tabla_bitacora');
	}
}
?>