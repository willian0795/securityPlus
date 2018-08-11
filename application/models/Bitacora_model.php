<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bitacora_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
		date_default_timezone_set('America/El_Salvador');
	}

	function bitacora($desc, $accion){
        $id_usuario = $this->session->userdata('id_usuario');
        $usuario = $this->session->userdata('usuario');
        $fecha = date('Y-m-d H:i:s');
        $ip = $this->get_real_ip();
        $descripcion = "";
        
        if($accion < 3){
        	$descripcion = "El usuario ".$usuario." ".$desc;
        }else{
            $descripcion = $desc;
        }
		if($this->db->insert('glb_bitacora', array('id_sistema' => '14', 'id_usuario' => $id_usuario, 'descripcion' => $descripcion, 'fecha_hora' => $fecha, 'IP' => $ip, 'id_accion' => $accion))){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	public function get_real_ip(){
        if (isset($_SERVER["HTTP_CLIENT_IP"])){
            return $_SERVER["HTTP_CLIENT_IP"];
        }elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        }elseif (isset($_SERVER["HTTP_X_FORWARDED"])){
            return $_SERVER["HTTP_X_FORWARDED"];
        }elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])){
            return $_SERVER["HTTP_FORWARDED_FOR"];
        }elseif (isset($_SERVER["HTTP_FORWARDED"])){
            return $_SERVER["HTTP_FORWARDED"];
        }else{
            return $_SERVER["REMOTE_ADDR"];
        }
    }

}
?>