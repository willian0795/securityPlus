<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends CI_Controller {

	function __construct(){
		parent::__construct();
		/************ Librerias para llamar funciones predefenidas **********/
		$this->load->helper(array('url','form','funciones_rapidas'));
		$this->load->model('roles_model');
	}

	public function index(){
		$this->load->view('templates/header');
		$this->load->view('roles/roles');
		$this->load->view('templates/footer');
	}

	public function tabla_rol($id){
		$objeto['id_sistema'] = $id;
		$this->load->view('roles/tabla_modulos',$objeto);
	}


	public function gestionar_rol(){
		if($this->input->post('band') == "save"){
			$nombre=$this->input->post('nombre_rol');
			$data = array(
			'nombre_rol' => $nombre, 
			'descripcion_rol' => $this->input->post('descripcion_rol')
			);
			echo $this->roles_model->insertar_rol($data);

		}else if($this->input->post('band') == "edit"){

			$data = array(
			'id_rol' => $this->input->post('id_rol'), 
			'nombre_rol' => $this->input->post('nombre_rol'), 
			'descripcion_rol' => $this->input->post('descripcion_rol')
			);
			echo $this->roles_model->editar_rol($data);

		}else if($this->input->post('band') == "delete"){

			$data = array(
			'id_rol' => $this->input->post('id_rol')
			);
			echo $this->roles_model->eliminar_rol($data);

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