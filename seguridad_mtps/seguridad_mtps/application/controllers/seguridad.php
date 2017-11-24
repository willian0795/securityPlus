<?php

define('BITACORA',190);
define('BASE_DATOS',191);


class Seguridad extends CI_Controller
{
    
    function Seguridad()
	{
        parent::__construct();
		date_default_timezone_set('America/El_Salvador');
		$this->load->model('usuario_model');
		$this->load->model('seguridad_model');
		$this->load->model('transporte_model');
		$this->load->library("mpdf");
    	if(!$this->session->userdata('id_usuario')) {
			redirect('index.php/sessiones');
		}
    }
	
	function index()
	{
		$this->bitacora();
  	}

	/*
	*	Nombre: bitacora
	*	Objetivo: Carga la vista para la administración de la bitacora
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 19/06/2015
	*	Observaciones: Ninguna.
	*/
	
	function bitacora($estado_transaccion=NULL, $tipo=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),BITACORA);
		$data['id_modulo']=BITACORA;
		if($data['id_permiso']==3)
		{
			$data['bitacora']=$this->seguridad_model->bitacora_reg();
			
			if($tipo!=NULL && $estado_transaccion!=NULL)
			{
				$msj="";
				switch($tipo)
				{
					case 1: $msj="El registro ha sido modificado con éxito"; break;
					case 2: $msj="El registro ha sido eliminado con éxito"; break;
				}
				
				$data['estado_transaccion']=$estado_transaccion;
				$data['msj']=$msj;
			}
			
			pantalla('seguridad/bitacora',$data);
			
		}
		else
		{
			echo "No tiene permiso para acceder";
		}
	}
	
	/*
	*	Nombre: ventana_bitacora
	*	Objetivo: Carga la ventana de la inforamción del registro de bitácora
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 19/06/2015
	*	Observaciones: Ninguna.
	*/
	
	function ventana_bitacora($id_bitacora)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),BITACORA);
		
		if($data['id_permiso']==3)
		{
			$data['bitacora']=$this->seguridad_model->bitacora_reg($id_bitacora);
			$data['bitacora']=$data['bitacora'][0];
			$this->load->view('seguridad/ventana_bitacora',$data);
		}
		else
		{
			echo "No tiene permiso para acceder";
		}
	}
	
	/*
	*	Nombre: eliminar_bitacora
	*	Objetivo: Elimina el registro de la bitacora
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 19/06/2015
	*	Observaciones: Ninguna.
	*/
	
	function eliminar_bitacora($id_bitacora)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),BITACORA);
		
		if($data['id_permiso']==3)
		{
			$this->db->trans_start();
			$this->seguridad_model->eliminar_bitacora($id_bitacora);
			$this->db->trans_complete();
			$tr=($this->db->trans_status()===FALSE)?0:1;
			redirect('index.php/seguridad/bitacora/'.$tr.'/2');
		}
		else
		{
			echo "No tiene permiso para acceder";
		}
	}
	
	/*
	*	Nombre: base_datos
	*	Objetivo: Muestra la vista en donde se cargan todos los backups realizados
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 12/07/2015
	*	Observaciones: Ninguna.
	*/
	
	function base_datos($estado_transaccion=NULL, $tipo=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),BASE_DATOS);
		$data['id_modulo']=BASE_DATOS;
		if($data['id_permiso']==3)
		{
			$data['backups']=$this->seguridad_model->backups();
			
			if($tipo!=NULL && $estado_transaccion!=NULL)
			{
				$msj="";
				switch($tipo)
				{
					case 1: $msj="El respaldo de base de datos ha sido creado con éxito"; break;
					case 2: $msj="El respaldo ha sido eliminado con éxito"; break;
					case 3: $msj="El respaldo ha sido restaurado con éxito"; break;
				}
				
				$data['estado_transaccion']=$estado_transaccion;
				$data['msj']=$msj;
			}
			
			pantalla('seguridad/base_datos',$data);
			
		}
		else
		{
			echo "No tiene permiso para acceder";
		}
	}
	
	/*
	*	Nombre: ventana_backup
	*	Objetivo: Carga la ventana de la información del registro de un respaldo de la base de datos
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 11/07/2015
	*	Observaciones: Ninguna.
	*/
	
	function ventana_backup($id_backup)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),BASE_DATOS);
		
		if($data['id_permiso']==3)
		{
			$data['backup']=$this->seguridad_model->backups($id_backup);
			$data['backup']=$data['backup'][0];
			$this->load->view('seguridad/ventana_backup',$data);
		}
		else
		{
			echo "No tiene permiso para acceder";
		}
	}
	
	/*
	*	Nombre: datos_backup
	*	Objetivo: Carga la ventana de la información del registro de un respaldo de la base de datos
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 12/07/2015
	*	Observaciones: Ninguna.
	*/
	
	function datos_backup()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),BASE_DATOS);
		
		if($data['id_permiso']==3)
		{
			$this->load->view('seguridad/nuevo_backup');
		}
		else
		{
			echo "No tiene permiso para acceder";
		}
	}
	
	/*
	*	Nombre: nuevo_backup
	*	Objetivo: Guarda el registro de un nuevo respaldo de base de datos
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 12/07/2015
	*	Observaciones: Ninguna.
	*/
	
	function nuevo_backup($descarga=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),BASE_DATOS);
		
		if($data['id_permiso']==3)
		{
			$_POST['id_usuario']=$this->session->userdata('id_usuario');
			$_POST['nombre']=$_POST['nombre']."_".date('Y-m-d_H_i_s');
			$nombre=$_POST['nombre'];
			
			$this->db->trans_start();
			$this->seguridad_model->guardar_backup($_POST);
			$this->db->trans_complete();
			
			$tr=($this->db->trans_status()===FALSE)?0:1;
			if($descarga!=NULL)
			{
				//$this->load->helper('file');
				$this->load->helper('download');
				
				$texto=file_get_contents('./respaldos/'.$nombre.'.sql');
				force_download($nombre.'.sql',$texto);
			}
			redirect('index.php/seguridad/base_datos/'.$tr.'/1');
		}
		else
		{
			echo "No tiene permiso para acceder";
		}
	}
	
	/*
	*	Nombre: ventana_restaurar
	*	Objetivo: Carga la ventana para restaurar un respaldo externo de la base de datos
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 31/07/2015
	*	Observaciones: Ninguna.
	*/
	
	function ventana_restaurar()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),BASE_DATOS);
		
		if($data['id_permiso']==3)
		{
			$this->load->view('seguridad/ventana_restaurar');
		}
		else
		{
			echo "No tiene permiso para acceder";
		}
	}
	
	/*
	*	Nombre: eliminar_backup
	*	Objetivo: Elimina el registro del backup
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 31/07/2015
	*	Observaciones: Ninguna.
	*/
	
	function eliminar_backup($id_backup)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),BASE_DATOS);
		
		if($data['id_permiso']==3)
		{
			$this->db->trans_start();
			$this->seguridad_model->eliminar_backup($id_backup);
			$this->db->trans_complete();
			$tr=($this->db->trans_status()===FALSE)?0:1;
			redirect('index.php/seguridad/base_datos/'.$tr.'/2');
		}
		else
		{
			echo "No tiene permiso para acceder";
		}
	}
	
	/*
	*	Nombre: restaurar_base_datos
	*	Objetivo: Restaura una base de datos desde el sistema
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 04/08/2015
	*	Observaciones: Ninguna.
	*/
	
	function restaurar_base_datos($id_backup=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),BASE_DATOS);
		
		if($data['id_permiso']==3)
		{
			$_POST['id_backup']=$id_backup;
			$_POST['url']=$_FILES['archivo']['tmp_name'];
			$_POST['nombre']=$_FILES['archivo']['name'];
			
			$this->db->trans_start();
			$this->seguridad_model->restaurar_backup($_POST);
			$this->db->trans_complete();
			$tr=($this->db->trans_status()===FALSE)?0:1;
			redirect('index.php/seguridad/base_datos/'.$tr.'/3');
		}
		else
		{
			echo "No tiene permiso para acceder";
		}
	}
}
?>
