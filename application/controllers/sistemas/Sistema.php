<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sistema extends CI_Controller {

	function __construct(){
		parent::__construct();
		/************ Librerias para llamar funciones predefenidas **********/
		$this->load->model('sistemas_model');
	}

	public function index(){
		$this->load->view('templates/header');
		$this->load->view('sistemas/sistema');
		$this->load->view('templates/footer');
	}

	public function tabla_sistema(){
		$this->load->view('sistemas/tabla_sistema');
	}

	public function gestionar_sistemas(){		

		if($this->input->post('band') == "save"){

			$data = array(
			'nombre' => strtoupper($this->input->post('nombre')),
			'base_url' => trim($this->input->post('base_url'))
			);
			echo $this->sistemas_model->insertar_sistema($data);
			
		}else if($this->input->post('band') == "edit"){
			$data = array(
			'idsistema' => $this->input->post('idb'), 
			'nombre' => strtoupper($this->input->post('nombre')),
			'base_url' => trim($this->input->post('base_url'))
			);
			echo $this->sistemas_model->editar_sistema($data);

		}else if($this->input->post('band') == "delete"){

			$data = array(
			'idsistema' => $this->input->post('idb')
			);
			echo $this->sistemas_model->eliminar_sistema($data);

		}
	}
}
?>