<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rol_modulo_permiso extends CI_Controller {

	function __construct(){
		parent::__construct();
		/************ Librerias para llamar funciones predefenidas **********/
		$this->load->helper(array('url','form','funciones_rapidas'));
		$this->load->model('rol_modulo_permiso_model');
		$this->load->model('combox_rol_modulo_permiso_model');
		$this->load->model('roles_model');
	}

	public function index(){
		$this->load->view('templates/header');
		$data['rol'] = $this->combox_rol_modulo_permiso_model->getRol();
		$data['sistema'] = $this->combox_rol_modulo_permiso_model->getSistema();
		$data['permiso'] = $this->combox_rol_modulo_permiso_model->getPermiso();
		$this->load->view('roles/rol_modulo_permiso',$data);
		
		$this->load->view('templates/footer');
	}
	public function buscarModulo($id_sistema,$seleccionado){
		$data['modulo'] = $this->combox_rol_modulo_permiso_model->getModulo($id_sistema);
		$data['seleccionado'] = $seleccionado;
		$this->load->view('roles/combo_modulo',$data);
	}

	public function gestionar_rol_modulo_permiso(){
		if($this->input->post('band') == "save"){
			$miid = $this->obtener_ultimo_id('org_rol','id_rol');
			$data = array(
			'id_rol' => $miid, 
			'id_modulo' => $this->input->post('id_modulo'),
			'id_permiso' => $this->input->post('id_permiso'),
			'estado' => $this->input->post('estado')
			);

			echo $this->rol_modulo_permiso_model->insertar_rol_modulo_permiso($data);

		}else if($this->input->post('band') == "edit"){

			$data = array(
			'id_rol_permiso' => $this->input->post('id_rol_permiso'),
			'id_rol' => $this->input->post('id_rol'), 
			'id_modulo' => $this->input->post('id_modulo'),
			'id_permiso' => $this->input->post('id_permiso'),
			'estado' => $this->input->post('estado')
			);
			echo $this->rol_modulo_permiso_model->editar_rol_modulo_permiso($data);

		}else if($this->input->post('band') == "delete"){

			$data = array(
			'id_rol_permiso' => $this->input->post('id_rol_permiso')
			);
			echo $this->rol_modulo_permiso_model->eliminar_rol_modulo_permiso($data);

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
	public function obtener_ultimo_id($tabla,$nombreid){
		$this->db->order_by($nombreid, "asc");
		$query = $this->db->get($tabla);
		$ultimoid = 0;
		if($query->num_rows() > 0){
			foreach ($query->result() as $fila) {
				$ultimoid = $fila->$nombreid; 
			}
			 
		}else{
			$ultimoid = 1;
		}
		return $ultimoid;
	}
}
?>