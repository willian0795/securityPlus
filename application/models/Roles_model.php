<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function insertar_rol($data){
		//$id = $this->obtener_ultimo_id("vyp_oficinas","id_oficina");
		if($this->db->insert('org_rol', array('nombre_rol' => $data['nombre_rol'], 'descripcion_rol' => $data['descripcion_rol']))){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function mostrar_rol(){
		$query = $this->db->get("org_rol");
		if($query->num_rows() > 0) return $query;
		else return false;
	}

	function editar_rol($data){
		$this->db->where("id_rol",$data["id_rol"]);
		if($this->db->update('org_rol', array('nombre_rol' => $data['nombre_rol'], 'descripcion_rol' => $data['descripcion_rol']))){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function eliminar_rol($data){
		if($this->db->delete("org_rol",array('id_rol' => $data['id_rol']))){
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
	 function mostrar_rol_por($data){
		 $this->db->where("nombre_rol",$data);
        $query = $this->db->get('org_rol');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row){
                    $data = $row['id_rol'];
                }
        }
        $query->free_result();
        return $data;
	}
}