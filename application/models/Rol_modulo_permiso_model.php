<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rol_modulo_permiso_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function insertar_rol_modulo_permiso($data){
		//$id = $this->obtener_ultimo_id("vyp_oficinas","id_oficina");
		if($this->db->insert('org_rol_modulo_permiso', array('id_rol' => $data['id_rol'], 'id_modulo' => $data['id_modulo'],'id_permiso' => $data['id_permiso'],'estado' => $data['estado']))){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function mostrar_rol_modulo_permiso($id){
		$this->db->where("id_rol",$id);
		$query = $this->db->get("org_rol_modulo_permiso");
		if($query->num_rows() > 0) return $query;
		else return false;
	}

	function editar_rol_modulo_permiso($data){
		$this->db->where("id_rol_permiso",$data["id_rol_permiso"]);
		if($this->db->update('org_rol_modulo_permiso', array('id_rol' => $data['id_rol'], 'id_modulo' => $data['id_modulo'],'id_permiso' => $data['id_permiso'],'estado' => $data['estado']))){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function eliminar_rol_modulo_permiso($data){
		if($this->db->delete("org_rol_modulo_permiso",array('id_rol_permiso' => $data['id_rol_permiso']))){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function obtener_ultimo_id($tabla,$nombreid){
		$this->db->order_by($nombreid, "asc");
		$query = $this->db->get($tabla);
		$ultimoid = 0;
		if($query->num_rows() > 0){
			foreach ($query->result() as $fila) {
				$ultimoid = $fila->$nombreid; 
			}
			$ultimoid++;
		}else{
			$ultimoid = 1;
		}
		return $ultimoid;
	}

}