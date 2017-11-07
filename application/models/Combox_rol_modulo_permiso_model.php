<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Combox_rol_modulo_permiso_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

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

}