<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('login_model');
		$this->load->model('bitacora_model');
	}

	public function index()
	{
		$this->load->view('login');
		$this->load->view('templates/footer');
	}

	public function vista_inicio()
	{
		$this->load->view('templates/header');
		$this->load->view('inicio');
		$this->load->view('templates/footer');
	}

	public function verificar_usuario(){
		$data = array(
		'usuario' => $this->input->post('usuario'),
		'password' => $this->input->post('password')
		);
		$res = $this->login_model->verificar_usuario($data);

		if($res->num_rows() > 0){
			foreach ($res->result() as $fila) {
			}
			$usuario_data = array(
               'id_usuario' => $fila->id_usuario,
               'usuario' => $fila->usuario,
               'nombre_usuario' => $fila->nombre_completo,
               'sesion' => TRUE
            );
			$this->session->set_userdata($usuario_data);
			echo "exito";
			$this->bitacora_model->bitacora(array(
               'id_sistema' => "14",
               'descripcion' => "El usuario ".$this->input->post('usuario')." inició sesión",
               'id_accion' => "1"
            ));			
		}else{
			echo "fracaso";
			$this->session->sess_destroy();
		}
	}

	public function verificar_usuario2(){
		$data = array(
		'usuario' => $this->input->post('usuario'),
		'password' => $this->input->post('password')
		);
				
		$res = $this->login_model->verificar_usuario($data);

		if($res->num_rows() > 0){
			foreach ($res->result() as $fila) {
			}
			$usuario_data = array(
               'id_usuario' => $fila->id_usuario,
               'usuario' => $fila->usuario,
               'nombre_usuario' => $fila->nombre_completo,
               'sesion' => TRUE
            );
			$this->session->set_userdata($usuario_data);
			echo "exito";
		}else{
			echo $this->input->post('usuario');
			echo "fracaso";
		}
	}

	public function cerrar_sesion(){
		$this->session->sess_destroy();
		$this->index();
	}
}
?>