<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modulos_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
	}

	function insertar_modulo($data){
		$id = $this->obtener_ultimo_id("org_modulo","id_modulo");

		$orden = $this->obtener_ultimo_id2("SELECT orden FROM org_modulo WHERE id_sistema = ".$data['id_sistema']." AND dependencia = ".$data['dependencia'],"orden");

		if($this->db->insert('org_modulo', array('id_modulo' => $id, 'id_sistema' => $data['id_sistema'], 'nombre_modulo' => $data['nombre'], 'descripcion_modulo' => $data['descripcion'], 'orden' => $orden, 'dependencia' => $data["dependencia"], 'url_modulo' => $data['url'], 'img_modulo' => $data['icono'], 'opciones_modulo' => $data['opciones']))){
			/************** Inicio de fragmento bitácora *********************/
			$this->bitacora_model->bitacora("Se registró el modulo '".$data["nombre"]."' con id: ".$id." para el sistema con id: ".$data["id_sistema"],"3");
            /************** Fin de fragmento bitácora *********************/
			return "exito";
		}else{
			return "fracaso";
		}
		
	}

	function mostrar_modulo(){
		$query = $this->db->get("org_modulo");
		if($query->num_rows() > 0) return $query;
		else return false;
	}

	function ordenar_modulo($data){
		$sistema = $this->obtener("SELECT nombre_sistema FROM org_sistema WHERE id_sistema = ".$data['id_sistema'],"nombre_sistema");

		if($this->db->query($data["query"])){
			/************** Inicio de fragmento bitácora *********************/
			$this->bitacora_model->bitacora("Se modificó el orden de los modulos del sistema '".$sistema."' con id: ".$data["id_sistema"],"4");
            /************** Fin de fragmento bitácora *********************/
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function editar_modulo($data){
		$this->db->where("id_modulo",$data["idmodulo"]);
		if($this->db->update('org_modulo', array('nombre_modulo' => $data['nombre'], 'descripcion_modulo' => $data['descripcion'], 'dependencia' => $data["dependencia"], 'url_modulo' => $data['url'], 'img_modulo' => $data['icono'], 'opciones_modulo' => $data['opciones']))){
			/************** Inicio de fragmento bitácora *********************/
			$this->bitacora_model->bitacora("Se modificó el modulo '".$data["nombre"]."' con id: ".$data["idmodulo"]." para el sistema con id: ".$data["id_sistema"],"4");
            /************** Fin de fragmento bitácora *********************/
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function eliminar_modulo($data){
		$orden = $this->obtener("SELECT orden FROM org_modulo WHERE id_modulo = ".$data['idmodulo'],"orden");
		
		$query = $this->db->query("SELECT * FROM org_modulo WHERE id_sistema = ".$data['id_sistema']." AND dependencia = ".$data['dependencia']);
		if($query->num_rows() > 1){
			$this->db->query("UPDATE org_modulo SET orden = orden-1 WHERE id_sistema = ".$data['id_sistema']." AND dependencia = ".$data['dependencia']." AND orden > ".$orden,"orden");
		}
		if($this->db->delete("org_modulo",array('id_modulo' => $data['idmodulo']))){
			/************** Inicio de fragmento bitácora *********************/
			$this->bitacora_model->bitacora("Se eliminó el modulo '".$data["nombre"]."' con id: ".$data['idmodulo']." para el sistema con id: ".$data["id_sistema"],"5");
            /************** Fin de fragmento bitácora *********************/
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function verificar_roles($data){
		$query = $this->db->query("SELECT DISTINCT r.* FROM org_rol AS r WHERE r.id_rol IN(SELECT id_rol FROM org_rol_modulo_permiso WHERE id_rol = r.id_rol AND id_modulo = '".$data['idmodulo']."') ORDER BY nombre_rol");
		if($query->num_rows() > 0) return $query;
		else return false;
	}

	function verificar_hijos($data){
		$query = $this->db->query("SELECT * FROM org_modulo WHERE dependencia = '".$data['idmodulo']."' ORDER BY orden");
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

	function obtener($consulta,$nombreid){
		$query = $this->db->query($consulta." ORDER BY ".$nombreid);
		$ultimoid = "";
		if($query->num_rows() > 0){
			foreach ($query->result() as $fila) {
				$ultimoid = $fila->$nombreid; 
			}
		}else{
			$ultimoid = "dependencia";
		}
		return $ultimoid;
	}

	function obtener_ultimo_id2($consulta,$nombreid){
		$query = $this->db->query($consulta." ORDER BY ".$nombreid);
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