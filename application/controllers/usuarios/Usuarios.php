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

	public function tabla_usuario(){
		$this->load->view('usuarios/tabla_usuarios');
	}

	public function tabla_roles(){
		$this->load->view('usuarios/tabla_roles');
	}

	public function form_datos(){
		$this->load->view('usuarios/form_datos');
	}

	public function cambiar_checke($dato){
		if(empty($dato)){
			$dato = 0;
		}
		return $dato;
	}

	public function gestionar_roles(){
		$data = array(
			'usuario' => $this->input->post('usuario'), 
			'id_rol' => $this->input->post('id_rol')
		);

		if($this->input->post('bandera') == "insertar"){
			echo $this->usuarios_model->insertar_roles($data);
		}else{
			echo $this->usuarios_model->eliminar_roles($data);
		};
		
	}

	public function obtener_usuario(){
		$empleado = $this->db->query("SELECT UPPER(CONCAT_WS(' ', primer_nombre, segundo_nombre, tercer_nombre, primer_apellido, segundo_apellido, apellido_casada)) AS nombre_completo,  LOWER(CONCAT_WS(' ', primer_nombre, segundo_nombre, tercer_nombre)) AS nombre, LOWER(CONCAT_WS(' ', primer_apellido, segundo_apellido, apellido_casada)) AS apellido, LOWER(CONCAT_WS('.',primer_nombre, primer_apellido)) AS usuario, nr, id_genero FROM sir_empleado WHERE id_empleado = '".$this->input->post('id_empleado')."'");
		        if($empleado->num_rows() > 0){
		            foreach ($empleado->result() as $fila) {  		            
		            }
		        }
		echo $fila->usuario;
	}

	public function gestionar_usuarios(){

		if($this->input->post('band') == "save"){
			if($this->input->post('tipo_pass') == 1){
				$pass = NULL;
			}else{
				$pass = md5($this->input->post('password'));
			}
			if($this->input->post('id_empleado') == 0){
				$data = array(
					'id_empleado' => $this->input->post('id_empleado'), 
					'nr' => NULL, 
					'nombre' => $this->input->post('nombre')." ".$this->input->post('apellido'),
					'genero' => $this->input->post('genero'),
					'usuario' => $this->input->post('usuario'),
					'password' => $pass,
					'estado' => 1
				);
			}else{
				$data = array(
					'id_empleado' => $this->input->post('id_empleado'), 
					'nr' => $this->input->post('id_empleado'), 
					'nombre' => $this->input->post('nombre')." ".$this->input->post('apellido'),
					'genero' => $this->input->post('genero'),
					'usuario' => $this->input->post('usuario'),
					'password' => $pass,
					'estado' => 1
				);
			}
			
			echo $this->usuarios_model->insertar_usuario($data);

		}else if($this->input->post('band') == "edit"){

			if($this->input->post('tipo_pass') == 1){
				$pass = NULL;
				$data = array(
				'idusuario' => $this->input->post('idusuario'),
				'genero' => $this->input->post('genero'),
				'usuario' => $this->input->post('usuario'), 
				'password' => $pass
				);
				echo $this->usuarios_model->editar_usuario($data);
			}else{
				$pass = md5($this->input->post('password'));
				$data = array(
				'idusuario' => $this->input->post('idusuario'),
				'genero' => $this->input->post('genero'),
				'usuario' => $this->input->post('usuario'), 
				'password' => $pass
				);
				if($this->input->post('password') == ""){
					echo $this->usuarios_model->editar_usuario2($data);
				}else{
					echo $this->usuarios_model->editar_usuario($data);
				}
			}

		}else if($this->input->post('band') == "delete"){

			$data = array(
			'idusuario' => $this->input->post('idusuario')
			);
			echo $this->usuarios_model->eliminar_usuario($data);

		}
	}

	public function editar_estado(){
		$data = array(
		'idusuario' => $this->input->post('id_usuario'), 
		'estado' => $this->input->post('estado')
		);
		echo $this->usuarios_model->editar_estado_usuario($data);
	}
}
?>