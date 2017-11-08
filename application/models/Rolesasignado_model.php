<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rolesasignado_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function insertar_usuario_rol($data){
		//$id = $this->obtener_ultimo_id("vyp_oficinas","id_oficina");
		if($this->db->insert('org_usuario_rol', array('id_usuario' => $data['id_usuario'], 'id_rol' => $data['id_rol']))){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function mostrar_rolasignado(){
		$query = $this->db->get("org_usuario_rol");
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	function mostrar_usuarios(){
		 $data = array();
        $query = $this->db->get('org_usuario');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row){
                    $data[] = $row;
                }
        }
        $query->free_result();
        return $data;
	}
	function mostrar_roles(){
		 $data = array();
        $query = $this->db->get('org_rol');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row){
                    $data[] = $row;
                }
        }
        $query->free_result();
        return $data;
	}

	function editar_usuario_rol($data){
		$this->db->where("id_usuario_rol",$data["id_usuario_rol"]);
		if($this->db->update('org_usuario_rol', array('id_usuario' => $data['id_usuario'], 'id_rol' => $data['id_rol']))){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function eliminar_usuario_rol($data){
		if($this->db->delete("org_usuario_rol",array('id_usuario_rol' => $data['id_usuario_rol']))){
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