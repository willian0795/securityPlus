<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function verificar_usuario($data){
		$query = $this->db->query("SELECT * FROM org_usuario WHERE usuario = '".$data['usuario']."' AND password = '".md5($data['password'])."'");
		if($query->num_rows() > 0) return "exito";
		else return "fracaso";
	}

}