<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	function __construct(){
		parent::__construct();
		/************ Librerias para llamar funciones predefenidas **********/
		$this->load->helper(array('url','form','funciones_rapidas'));
		$this->load->model('usuarios_model');
	}

	public function index(){
		$this->load->view('templates/header');
		$this->load->view('usuarios/usuarios');
		$this->load->view('templates/footer');
	}

	public function form_usuario(){
		$this->load->view('usuarios/form_usuarios');
	}

	public function tabla_usuario(){
		$this->load->view('usuarios/tabla_usuarios');
	}

	public function gestionar_usuarios(){
		if($this->input->post('band') == "save"){
			if($this->input->post('id_empleado') == 0){
				$data = array(
				'id_empleado' => $this->input->post('id_empleado'), 
				'nr' => $this->input->post('nr'), 
				'nombre' => $this->input->post('nombre')." ".$this->input->post('apellido'),
				'genero' => $this->input->post('genero'),
				'usuario' => $this->input->post('usuario'),
				'password' => md5($this->input->post('password')),
				'estado' => $this->input->post('estado')
				);
			}else{
				$data = array(
				'id_empleado' => $this->input->post('id_empleado'), 
				'nr' => $this->input->post('nr'), 
				'nombre' => strtolower($this->input->post('nombre_completo')),
				'genero' => $this->input->post('genero'),
				'usuario' => $this->input->post('usuario'),
				'password' => md5($this->input->post('password')),
				'estado' => $this->input->post('estado')
				);
			}
			
			echo $this->usuarios_model->insertar_usuario($data);

		}else if($this->input->post('band') == "edit"){

			$data = array(
			'idusuario' => $this->input->post('idusuario'), 
			'nr' => $this->input->post('nr'), 
			'nombre' => strtolower($this->input->post('nombre_completo')),
			'genero' => $this->input->post('genero'),
			'usuario' => $this->input->post('usuario'),
			'password' => md5($this->input->post('password')),
			'estado' => $this->input->post('estado')
			);
			echo $this->usuarios_model->editar_usuario($data);

		}else if($this->input->post('band') == "delete"){

			$data = array(
			'idusuario' => $this->input->post('idusuario')
			);
			echo $this->usuarios_model->eliminar_usuario($data);

		}
	}
}
?>