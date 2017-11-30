<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends CI_Controller {

	function __construct(){
		parent::__construct();
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
	public function tabla_rol_chequed($ids){
		$objeto = explode("x", $ids);
		$nuevo['id_sistema']=$objeto[0];
		$nuevo['id_rol']=$objeto[1];
		$this->load->view('roles/tabla_modulos_chequed',$nuevo);
	}

	public function tablaroles(){
		$objeto =  new stdClass();
		$objeto->roles = $roles = $this->roles_model->mostrar_rol();
		
		$this->load->view('roles/tabla_roles',$objeto);
	}

	public function tabla_rol_modulo_permiso($id){
		
		$objeto['roles'] = $id;
		
		$this->load->view('roles/tabla_rol_modulo_permiso',$objeto);
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

	public function buscarModulo($id_sistema,$seleccionado){
		$data['modulo'] = $this->roles_model->getModulo($id_sistema);
		$data['seleccionado'] = $seleccionado;
		$this->load->view('roles/combo_modulo',$data);
	}

	public function gestionar_rol_modulo_permiso(){
		if($this->input->post('band') == "save"){
			$miid = $this->roles_model->obtener_ultimo_id('org_rol','id_rol');
			$data = array(
			'id_rol' => $miid, 
			'id_modulo' => $this->input->post('id_modulo'),
			'id_permiso' => $this->input->post('id_permiso'),
			'estado' => $this->input->post('estado')
			);

			echo $this->roles_model->insertar_rol_modulo_permiso($data);

		}else if($this->input->post('band') == "edit"){

			$data = array(
			'id_rol_permiso' => $this->input->post('id_rol_permiso'),
			'id_rol' => $this->input->post('id_rol'), 
			'id_modulo' => $this->input->post('id_modulo'),
			'id_permiso' => $this->input->post('id_permiso'),
			'estado' => $this->input->post('estado')
			);
			echo $this->roles_model->editar_rol_modulo_permiso($data);

		}else if($this->input->post('band') == "delete"){

			$data = array(
			'id_rol_permiso' => $this->input->post('id_rol_permiso')
			);
			echo $this->roles_model->eliminar_rol_modulo_permiso($data);

		}
	}
	

}
?>