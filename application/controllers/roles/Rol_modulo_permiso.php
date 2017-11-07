<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rol_modulo_permiso extends CI_Controller {

	function __construct(){
		parent::__construct();
		/************ Librerias para llamar funciones predefenidas **********/
		$this->load->helper(array('url','form','funciones_rapidas'));
		$this->load->model('roles_model');
		$this->load->model('combox_rol_modulo_permiso_model');
	}

	public function index(){
		$this->load->view('templates/header');
		$data['rol'] = $this->combox_rol_modulo_permiso_model->getRol();
		$data['sistema'] = $this->combox_rol_modulo_permiso_model->getSistema();
		$this->load->view('roles/rol_modulo_permiso',$data);
		
		$this->load->view('templates/footer');
	}
	public function buscarModulo($id_sistema){
		$data['modulo'] = $this->combox_rol_modulo_permiso_model->getModulo($id_sistema);
		return $data;
	}

	public function gestionar_rol(){
		if($this->input->post('band') == "save"){
			$data = array(
			'nombre_rol' => $this->input->post('nombre_rol'), 
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