<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sistemas_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
	}

	function insertar_sistema($data){
		$idsistema = $this->obtener_ultimo_id("org_sistema","id_sistema");
		if($this->db->insert('org_sistema', array('id_sistema' => $idsistema, 'nombre_sistema' => $data['nombre']))){
			/************** Inicio de fragmento bitácora *********************/
			$this->bitacora_model->bitacora("Se registró el sistema '".$data["nombre"]."' con id: ".$idsistema,"3");
            /************** Fin de fragmento bitácora *********************/
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function mostrar_sistema(){
		$query = $this->db->get("org_sistema");
		if($query->num_rows() > 0) return $query;
		else return false;
	}

	function editar_sistema($data){
		$this->db->where("id_sistema",$data["idsistema"]);
		if($this->db->update('org_sistema', array('nombre_sistema' => $data['nombre']))){
			/************** Inicio de fragmento bitácora *********************/
			$this->bitacora_model->bitacora("Se modificó el sistema '".$data["nombre"]."' con id: ".$data["idsistema"],"4");
            /************** Fin de fragmento bitácora *********************/
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function eliminar_sistema($data){
		if($this->db->delete("org_sistema",array('id_sistema' => $data['idsistema']))){
			/************** Inicio de fragmento bitácora *********************/
			$this->bitacora_model->bitacora("Se eliminó el sistema '".$data["nombre"]."' con id: ".$data["idsistema"],"5");
            /************** Fin de fragmento bitácora *********************/
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function verificar_modulos($data){
		$query = $this->db->query("SELECT * FROM org_modulo WHERE id_sistema = '".$data['idsistema']."' ORDER BY orden");
		if($query->num_rows() > 0) return $query;
		else return false;
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