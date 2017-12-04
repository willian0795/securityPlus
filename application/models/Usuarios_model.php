<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
	}

	function insertar_usuario($data){

		$query = $this->db->query("SELECT * FROM org_usuario WHERE usuario = '".$data['usuario']."'");
		if($query->num_rows() > 0){
			return "existe";
		}else{
			$id_seccion = $this->obtener("SELECT id_seccion FROM sir_empleado_informacion_laboral WHERE id_empleado = ".$data['id_empleado'],"id_seccion");

			$id = $this->obtener_ultimo_id("org_usuario","id_usuario");

			if($this->db->insert('org_usuario', array('id_usuario' => $id, 'nombre_completo' => $data['nombre'], 'nr' => $data['nr'], 'sexo' => $data['genero'], 'usuario' => $data['usuario'], 'password' => $data['password'], 'id_seccion' => $id_seccion, 'estado' => $data['estado']))){
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}

	function insertar_roles($data){
		$id_usuario = $this->obtener("SELECT id_usuario FROM org_usuario WHERE usuario = '".$data['usuario']."'","id_usuario");

		$query = $this->db->query("SELECT * FROM org_usuario_rol WHERE id_usuario = '".$id_usuario."' AND id_rol = '".$data['id_rol']."'");
		if($query->num_rows() > 0){
			return "existe";
		}else{
			$id = $this->obtener_ultimo_id("org_usuario_rol","id_usuario_rol");

			if($this->db->insert('org_usuario_rol', array('id_usuario_rol' => $id, 'id_usuario' => $id_usuario, 'id_rol' => $data['id_rol']))){
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}

	function eliminar_roles($data){
		$id_usuario = $this->obtener("SELECT id_usuario FROM org_usuario WHERE usuario = '".$data['usuario']."'","id_usuario");
		$query = $this->db->query("SELECT * FROM org_usuario_rol WHERE id_usuario = '".$id_usuario."' AND id_rol = '".$data['id_rol']."'");
		if($query->num_rows() > 0){
			foreach ($query->result() as $fila) {
				if($this->db->delete("org_usuario_rol",array('id_usuario_rol' => $fila->id_usuario_rol))){
					return "exito";
				}else{
					return "fracaso";
				} 
			}
		}
	}

	function editar_usuario($data){
		$this->db->where("id_usuario",$data["idusuario"]);
		if(!empty($data['password'])){
			if($this->db->update('org_usuario', array('password' => $data['password']))){
				return "exito";
			}else{
				return "fracaso";
			}
		}else{
			return "exito";
		}
	}

	function editar_estado_usuario($data){
		$this->db->where("id_usuario",$data["idusuario"]);
		if($this->db->update('org_usuario', array('estado' => $data['estado']))){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function eliminar_usuario($data){
		if($this->db->delete("org_usuario",array('id_usuario' => $data['idusuario']))){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function obtener($consulta,$nombreid){
		$query = $this->db->query($consulta." ORDER BY ".$nombreid);
		$ultimoid = "";
		if($query->num_rows() > 0){
			foreach ($query->result() as $fila) {
				$ultimoid = $fila->$nombreid; 
			}
		}else{
			$ultimoid = "0";
		}
		return $ultimoid;
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