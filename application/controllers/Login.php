<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form','funciones_rapidas'));
		$this->load->model('login_model');
	}

	public function index()
	{
		$this->load->view('login');
		$this->load->view('templates/footer');
	}

	public function vista_inicio()
	{
		$this->load->view('templates/header');
		$this->load->view('inicio');
		$this->load->view('templates/footer');
	}

	public function verificar_usuario(){
		$data = array(
		'usuario' => $this->input->post('usuario'),
		'password' => $this->input->post('password')
		);
		echo $this->login_model->verificar_usuario($data);
	}
}
?>