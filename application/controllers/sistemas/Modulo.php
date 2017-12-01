<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class modulo extends CI_Controller {

	function __construct(){
		parent::__construct();
		/************ Librerias para llamar funciones predefenidas **********/
		$this->load->helper(array('url','form','funciones_rapidas'));
		$this->load->model('modulos_model');
	}

	public function index(){
		$this->load->view('templates/header');
		$this->load->view('sistemas/modulo');
		$this->load->view('templates/footer');
	}

	public function combo_modulo(){
		$this->load->view('sistemas/combo_modulo');
	}

	public function tabla_modulo(){
		$this->load->view('sistemas/tabla_modulo');
	}

	public function tabla_modulo2(){
		$this->load->view('sistemas/tabla_modulo2');
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

			$validar_hijos = $this->modulos_model->verificar_hijos($data);

			if($validar_hijos != false){
				echo "hijos"; // No se eliminará por que el sistema tiene modulos
			}else{
				$valido_eliminar = $this->modulos_model->verificar_roles($data); //verifica si el sistema tiene modulos
				if($valido_eliminar != false){
					echo "roles"; // No se eliminará por que el sistema tiene modulos
				}else{
					echo $this->modulos_model->eliminar_modulo($data); // si no tiene modulos se elimina
				}
			}							

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

	function verificar_roles(){
		$data = array(
			'idmodulo' => $this->input->post('idmodulo')
		);
		$roles = '<ul>';
		$validar_hijos = $this->modulos_model->verificar_hijos($data);
		if($validar_hijos != false){
			foreach ($validar_hijos->result() as $fila) {
				$roles .= '<li>'.$fila->nombre_modulo.'</li>'; 
			}
		}else{
			$valido_eliminar = $this->modulos_model->verificar_roles($data); //verifica si el sistema tiene modulos
			if($valido_eliminar != false){
				foreach ($valido_eliminar->result() as $fila) {
					$roles .= '<li>'.$fila->nombre_rol.'</li>'; 
				}
			}
		}	
		$roles .= '</ul>';

		echo $roles;
	}
}
?>