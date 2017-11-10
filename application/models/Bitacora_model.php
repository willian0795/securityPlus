<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bitacora_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
	}

	function bitacora($data){

        $user = $this->session->userdata('usuario');
        $fecha = date('Y-m-d h:i:s');
        $ip = $this->get_real_ip();
        
		
		$id = $this->obtener_ultimo_id("sep_bitacora","id_bitacora");

		if($this->db->insert('sep_bitacora', array('id_bitacora' => $id, 'id_sistema' => $data['id_sistema'], 'id_usuario' => $user, 'descripcion' => $data['descripcion'], 'fecha' => $fecha, 'ip' => $ip, 'id_accion' => $data['id_accion']))){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	public function get_real_ip(){

        if (isset($_SERVER["HTTP_CLIENT_IP"]))
        {
            return $_SERVER["HTTP_CLIENT_IP"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
        {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
        {
            return $_SERVER["HTTP_X_FORWARDED"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
        {
            return $_SERVER["HTTP_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED"]))
        {
            return $_SERVER["HTTP_FORWARDED"];
        }
        else
        {
            return $_SERVER["REMOTE_ADDR"];
        }
    }

}
?>