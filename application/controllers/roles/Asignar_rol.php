<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asignar_rol extends CI_Controller {

	function __construct(){
		parent::__construct();
		/************ Librerias para llamar funciones predefenidas **********/
		$this->load->helper(array('url','form','funciones_rapidas'));
		$this->load->model('rolesasignado_model');
	}

	public function index(){
		$this->load->view('templates/header');
		$data['usuarios_list'] = $this->rolesasignado_model->mostrar_usuarios();
		$data['rol_list'] = $this->rolesasignado_model->mostrar_roles();
		$this->load->view('roles/asignar',$data);
		$this->load->view('templates/footer');
	}


	public function gestionar_usuario_rol(){
		if($this->input->post('band') == "save"){
			$data = array(
			'id_usuario' => $this->input->post('id_usuario'), 
			'id_rol' => $this->input->post('id_rol')
			);
			echo $this->rolesasignado_model->insertar_usuario_rol($data);

		}else if($this->input->post('band') == "edit"){

			$data = array(
			'id_usuario_rol' => $this->input->post('id_usuario_rol'), 
			'id_usuario' => $this->input->post('id_usuario'), 
			'id_rol' => $this->input->post('id_rol')
			);
			echo $this->rolesasignado_model->editar_usuario_rol($data);

		}else if($this->input->post('band') == "delete"){

			$data = array(
			'id_usuario_rol' => $this->input->post('id_usuario_rol')
			);
			echo $this->rolesasignado_model->eliminar_usuario_rol($data);

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