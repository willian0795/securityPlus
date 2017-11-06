<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class roles extends CI_Controller {

	function __construct(){
		parent::__construct();
		/************ Librerias para llamar funciones predefenidas **********/
		$this->load->helper(array('url','form','funciones_rapidas'));
		$this->load->model('modulos_model');
	}

	public function index(){
		$this->load->view('templates/header');
		$this->load->view('roles/roles');
		$this->load->view('templates/footer');
	}


	public function gestionar_modulos(){
		if($this->input->post('band') == "save"){
			$data = array(
			'nombre' => ucfirst(strtolower($this->input->post('nombre'))), 
			'icono' => $this->input->post('icono'),
			'descripcion' => $this->input->post('descripcion'),
			'url' => $this->input->post('url'),
			'opciones' => $this->input->post('opciones'),
			'orden' => $this->input->post('orden'),
			'dependencia' => $this->input->post('dependencia'),
			'id_sistema' => $this->input->post('id_sistema')
			);
			echo $this->modulos_model->insertar_modulo($data);

		}else if($this->input->post('band') == "edit"){

			$data = array(
			'idmodulo' => $this->input->post('idmodulo'), 
			'nombre' => ucfirst(strtolower($this->input->post('nombre'))), 
			'icono' => $this->input->post('icono'),
			'descripcion' => $this->input->post('descripcion'),
			'url' => $this->input->post('url'),
			'opciones' => $this->input->post('opciones'),
			'orden' => $this->input->post('orden'),
			'dependencia' => $this->input->post('dependencia'),
			'id_sistema' => $this->input->post('id_sistema')
			);
			echo $this->modulos_model->editar_modulo($data);

		}else if($this->input->post('band') == "delete"){

			$data = array(
			'idmodulo' => $this->input->post('idmodulo'),
			'dependencia' => $this->input->post('dependencia'),
			'id_sistema' => $this->input->post('id_sistema')
			);
			echo $this->modulos_model->eliminar_modulo($data);

		}
	}

	public function ordenar_modulo(){
		$data = array(
			'idmodulo' => $this->input->post('idmodulo'), 
			'orden' => $this->input->post('orden'),
			'dependencia' => $this->input->post('dependencia')
			);
		echo $this->modulos_model->ordenar_modulo($data);
	}
}
?>