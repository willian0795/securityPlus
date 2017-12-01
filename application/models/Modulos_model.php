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
		$this->db->where("id_modulo",$data["idmodulo"]);
		if($this->db->update('org_modulo', array('dependencia' => $data["dependencia"], 'orden' => $data["orden"]))){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function editar_modulo($data){
		$this->db->where("id_modulo",$data["idmodulo"]);
		if($this->db->update('org_modulo', array('nombre_modulo' => $data['nombre'], 'descripcion_modulo' => $data['descripcion'], 'dependencia' => $data["dependencia"], 'url_modulo' => $data['url'], 'img_modulo' => $data['icono'], 'opciones_modulo' => $data['opciones']))){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function eliminar_modulo($data){
		$orden = $this->obtener("SELECT orden FROM org_modulo WHERE id_modulo = ".$data['idmodulo'],"orden");
		$query = $this->db->query("SELECT * FROM org_modulo WHERE id_sistema = ".$data['id_sistema']." AND dependencia = ".$data['idmodulo']);
		if($query->num_rows() > 0){
			echo "dependencia";
		}else{
			$query = $this->db->query("SELECT * FROM org_modulo WHERE id_sistema = ".$data['id_sistema']." AND dependencia = ".$data['dependencia']);
			if($query->num_rows() > 1){
				$this->db->query("UPDATE org_modulo SET orden = orden-1 WHERE id_sistema = ".$data['id_sistema']." AND dependencia = ".$data['dependencia']." AND orden > ".$orden,"orden");
			}
			if($this->db->delete("org_modulo",array('id_modulo' => $data['idmodulo']))){
				return "exito";
			}else{
				return "fracaso";
			}
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

/*	function mostrar_personal(){
		$query = $this->db->get("tpersonal");
		if($query->num_rows() > 0) return $query;
		else return false;
	}

	function mostrar_personal2(){
        $query = $this->db->query("SELECT p.idpersonal, p.nombre, p.direccion, p.telefono, c.idcargo, c.nombre AS cnombre, z.idzona, z.nombre AS znombre FROM tpersonal p JOIN tcargos c ON p.idcargo = c.idcargo JOIN tzonas z ON z.idzona = p.idzona");
		if($query->num_rows() > 0) return $query;
		else return false;
	}

	function mostrar_cargos(){
		$query = $this->db->get("tcargos");
		if($query->num_rows() > 0) return $query;
		else return false;
	}

	function mostrar_zonas(){
		$query = $this->db->get("tzonas");
		if($query->num_rows() > 0) return $query;
		else return false;
	}*/
}