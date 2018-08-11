<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
		$this->load->helper(array('funciones_rapidas'));
	}

	function insertar_usuario($data){

		$query = $this->db->query("SELECT * FROM org_usuario WHERE usuario = '".$data['usuario']."'");
		if($query->num_rows() > 0){
			return "existe";
		}else{
			$id_empleado = $this->obtener("SELECT id_empleado FROM sir_empleado WHERE nr = '".$data['id_empleado']."'", "id_empleado");

			$id_seccion = $this->obtener("SELECT id_seccion FROM sir_empleado_informacion_laboral WHERE id_empleado = '".$id_empleado."' ORDER BY id_empleado_informacion_laboral", "id_seccion");

			$id = $this->obtener_ultimo_id("org_usuario","id_usuario");

			if($this->db->insert('org_usuario', array('id_usuario' => $id, 'nombre_completo' => $data['nombre'], 'nr' => $data['nr'], 'sexo' => $data['genero'], 'usuario' => $data['usuario'], 'password' => $data['password'], 'id_seccion' => $id_seccion, 'estado' => $data['estado']))){
				/************** Inicio de fragmento bitácora *********************/
				$this->bitacora_model->bitacora("Se registró el usuario '".$data["nombre"]."' con id: ".$id,"3");
	            /************** Fin de fragmento bitácora *********************/
				return "exito,".$id;
			}else{
				return "fracaso";
			}
		}
	}

	function insertar_roles($data){
		$query = $this->db->query("SELECT * FROM org_usuario_rol WHERE id_usuario = '".$data['usuario']."' AND id_rol = '".$data['id_rol']."'");
		if($query->num_rows() > 0){
			return "existe";
		}else{
			$id = $this->obtener_ultimo_id("org_usuario_rol","id_usuario_rol");

			if($this->db->insert('org_usuario_rol', array('id_usuario_rol' => $id, 'id_usuario' => $data['usuario'], 'id_rol' => $data['id_rol']))){
				return "exito";
							}else{
				return "fracaso";
			}
		}
	}

	function eliminar_roles($data){
		if($this->db->query("DELETE FROM org_usuario_rol WHERE id_usuario = '".$data['usuario']."' AND id_rol = '".$data['id_rol']."'")){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function editar_usuario($data){
		$this->db->where("id_usuario",$data["idusuario"]);		
		if($this->db->update('org_usuario', array('sexo' => $data['genero'], 'usuario' => $data['usuario'], 'password' => $data['password']))){
			/************** Inicio de fragmento bitácora *********************/
			$this->bitacora_model->bitacora("Se modificó el usuario '".$data["usuario"]."' con id: ".$data["idusuario"],"4");
            /************** Fin de fragmento bitácora *********************/
            return "exito";
		}else{
			return "fracaso";
		}
	}

	function editar_usuario2($data){
		$this->db->where("id_usuario",$data["idusuario"]);		
		if($this->db->update('org_usuario', array('sexo' => $data['genero'], 'usuario' => $data['usuario']))){
			/************** Inicio de fragmento bitácora *********************/
			$this->bitacora_model->bitacora("Se modificó el usuario '".$data["usuario"]."' con id: ".$data["idusuario"],"4");
            /************** Fin de fragmento bitácora *********************/
            return "exito";
		}else{
			return "fracaso";
		}
	}


	function editar_estado_usuario($data){
		$this->db->where("id_usuario",$data["idusuario"]);
		if($this->db->update('org_usuario', array('estado' => $data['estado']))){
			/************** Inicio de fragmento bitácora *********************/
			$this->bitacora_model->bitacora("Se cambió el estado del usuario con id: ".$data["idusuario"],"4");
            /************** Fin de fragmento bitácora *********************/
            return "exito";
		}else{
			return "fracaso";
		}
	}

	function obtener($consulta,$nombreid){
		$query = $this->db->query($consulta);
		$ultimoid = "";
		if($query->num_rows() > 0){
			foreach ($query->result() as $fila) {
				$ultimoid = $fila->$nombreid; 
			}
		}else{
			$ultimoid = NULL;
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