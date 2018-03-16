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
			/************** Inicio de fragmento bitácora *********************/
			$this->bitacora_model->bitacora("Se registró el rol '".$data["nombre_rol"]."'","3");
            /************** Fin de fragmento bitácora *********************/
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
			/************** Inicio de fragmento bitácora *********************/
			$this->bitacora_model->bitacora("Se modificó el rol '".$data["nombre_rol"]."' con id: ".$data["id_rol"],"4");
            /************** Fin de fragmento bitácora *********************/
            return "exito";
		}else{
			return "fracaso";
		}
	}

	function eliminar_rol($data){
		if($this->db->delete("org_rol",array('id_rol' => $data['id_rol'])) && $this->db->delete("org_rol_modulo_permiso",array('id_rol' => $data['id_rol']))){
			/************** Inicio de fragmento bitácora *********************/
			$this->bitacora_model->bitacora("Se eliminó el rol con id: ".$data["id_rol"],"5");
            /************** Fin de fragmento bitácora *********************/
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

	public function obtener_ultimo_rol($tabla,$nombreid){
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

	function verificar_usuarios($data){
		$query = $this->db->query("SELECT u.* FROM org_usuario AS u WHERE u.id_usuario IN (SELECT p.id_usuario FROM org_usuario_rol AS p WHERE p.id_rol = '".$data["id_rol"]."')");
		if($query->num_rows() > 0) return $query;
		else return false;
	}

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
		if( $this->db->delete("org_rol_modulo_permiso",array('id_rol_permiso' => $data['id_rol_permiso'])) ){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function eliminar_roles($data){
		if($this->db->query("DELETE FROM org_rol_modulo_permiso WHERE id_rol = '".$data["id_rol"]."' AND (id_modulo IN (SELECT m.id_modulo FROM org_modulo AS m WHERE m.id_sistema = '".$data["id_sistema"]."'))")){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function guardar_modulo_rol_permiso($data){
		$band = false; $n = 1;
		$ultimoid = $this->obtener_ultimo_rol("org_rol_modulo_permiso","id_rol_permiso");

		$query = $data["query"];

		while($band == false){
			$ultimoid++;
			$buscar = "*id".$n."*";
			$posicion_coincidencia = strrpos($query, $buscar);
			$posicion_coincidencia;
			if ($posicion_coincidencia === false) {
		    	$band = true;
		    }else{
		    	$query = str_replace($buscar, $ultimoid, $query);
		    	$n++;
		    }
		}
		
		if($this->db->query($query)){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	/***************** Fin Rol_modulo_permiso_model *********************************/
}