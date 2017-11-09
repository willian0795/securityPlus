<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form','funciones_rapidas'));
		$this->load->database();
	}

	public function index()
	{
		$this->load->view('templates/header');
		$this->load->view('inicio');
		$this->load->view('templates/footer');
	}
}
?>