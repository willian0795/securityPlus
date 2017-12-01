<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles_model extends CI_Model {
	
	function __construct(){
		parent::__construct();		
	}

	/***************** Inicio Roles_model *********************************/
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

	public function obtener_ultimo_id($tabla,$nombreid){
		$this->db->order_by($nombreid, "asc");
		$query = $this->db->get($tabla);
		$ultimoid = 0;
		if($query->num_rows() > 0){
			foreach ($query->result() as $fila) {
				$ultimoid = $fila->$nombreid; 
			}
			 
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
	/***************** Fin Roles_model *********************************/


	/***************** Inicio Combox_rol_modulo_permiso_model *********************************/
	function getRol() {
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
    function getSistema() {
        $data = array();
        //$this->db->where("url_modulo !=","blank");
        $query = $this->db->get('org_sistema');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row){
                    $data[] = $row;
                }
        }
        $query->free_result();
        return $data;
    }
    function getModulo($id_sistema) {
        $data = array();
        $this->db->where("id_sistema",$id_sistema);
        $query = $this->db->get('org_modulo');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row){
                    $data[] = $row;
                }
        }
        $query->free_result();
        return $data;
    }
    function getPermiso() {
        $data = array();
    
        $query = $this->db->get('org_permiso');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row){
                    $data[] = $row;
                }
        }
        $query->free_result();
        return $data;
    }
    /***************** Fin Combox_rol_modulo_permiso_model *********************************/


    /***************** Inicio Rol_modulo_permiso_model *********************************/
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

	/***************** Fin Rol_modulo_permiso_model *********************************/
}