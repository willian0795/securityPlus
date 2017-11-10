<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sistemas_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function insertar_sistema($data){
		$idsistema = $this->obtener_ultimo_id("org_sistema","id_sistema");
		if($this->db->insert('org_sistema', array('id_sistema' => $idsistema, 'nombre_sistema' => $data['nombre'], 'base_url' => $data['base_url']))){
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
		if($this->db->update('org_sistema', array('nombre_sistema' => $data['nombre'], 'base_url' => $data['base_url']))){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function eliminar_sistema($data){
		if($this->db->delete("org_sistema",array('id_sistema' => $data['idsistema']))){
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