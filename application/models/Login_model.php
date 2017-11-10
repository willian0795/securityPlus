<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
	}

	function verificar_usuario($data){
		$query = $this->db->query("SELECT * FROM org_usuario WHERE usuario = '".$data['usuario']."' AND password = '".md5($data['password'])."'");
		return $query;
	}

}