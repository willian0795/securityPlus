<?php
class Seguridad_model extends CI_Model {
    
	//constructor de la clase
    function __construct() {
        //LLamar al constructor del Modelo
        parent::__construct();
    }
	
	function consultar_usuario($login,$clave, $blank=false)
	{
		
		$where="";
		if (!$blank) {  ///verificacion normal, clave o contraseña
			$where=" WHERE usuario='$login' AND password=MD5('$clave') AND estado=1";
		} elseif ($blank AND $clave=="") {
			$where= " WHERE usuario='$login' AND password='' AND estado=1";//cuando sea permitido vacio
		}else{
			$where=" WHERE usuario='$login' AND password=MD5('$clave') AND estado=1"; //cuando sea permitido vacio pero la clave no esta en blanco
		}
		

		$sentencia="SELECT id_usuario, usuario, LOWER(nombre_completo) as nombre_completo, NR , id_seccion, sexo
					FROM org_usuario".$where;
		$query=$this->db->query($sentencia);
	
		if($query->num_rows>0) {
			return (array)$query->row();
		}
		else {
			return array(
				'id_usuario' => 0
			);
		}
	}
	
	function consultar_usuario2($login)
	{
		$sentencia="SELECT id_usuario, usuario, nombre_completo, NR , id_seccion, sexo
					FROM org_usuario
					WHERE usuario='$login' AND estado=1";
		$query=$this->db->query($sentencia);
	
		if($query->num_rows>0) {
			return (array)$query->row();
		}
		else {
			return array(
				'id_usuario' => 0
			);
		}
	}
	
	public function sexoUsuario($id_usuario='')
	{
			$sentencia="SELECT
						CASE 1
					WHEN sexo = 'F' THEN
						'Bienvenida'
					WHEN sexo = 'M' THEN
						'Bienvenido'
					ELSE
						'Bienvenido/a'
					END AS msj
					FROM
						org_usuario
					WHERE
						id_usuario =".$id_usuario;
			$query=$this->db->query($sentencia);
			return (array)$query->result_array();
	}
	
	function buscar_menus2($id) 
	{
		$sentencia="SELECT 
					orden_padre,
					id_padre,
					nombre_padre,
					GROUP_CONCAT(id_modulo) as id_modulo,
					GROUP_CONCAT(orden) as orden,
					GROUP_CONCAT(nombre_modulo) as nombre_modulo,
					GROUP_CONCAT(descripcion_modulo) as descripcion_modulo,
					GROUP_CONCAT(dependencia) as dependencia,
					GROUP_CONCAT(url_modulo) as url_modulo,
					GROUP_CONCAT(img_modulo) as img_modulo
					FROM
					(SELECT DISTINCT
					m2.orden AS orden_padre,
					m2.id_modulo AS id_padre,
					m2.nombre_modulo AS nombre_padre,
					org_modulo.id_modulo,
					org_modulo.orden,
					org_modulo.nombre_modulo,
					org_modulo.descripcion_modulo,
					org_modulo.dependencia,
					org_modulo.url_modulo,
					org_modulo.img_modulo
					FROM org_rol
					INNER JOIN org_usuario_rol ON org_rol.id_rol = org_usuario_rol.id_rol
					INNER JOIN org_rol_modulo_permiso ON org_rol_modulo_permiso.id_rol = org_rol.id_rol
					INNER JOIN org_modulo ON org_modulo.id_modulo = org_rol_modulo_permiso.id_modulo
					LEFT JOIN org_modulo AS m2 ON m2.id_modulo = org_modulo.dependencia
					WHERE org_usuario_rol.id_usuario=".$id." AND org_modulo.id_sistema=11 AND org_rol_modulo_permiso.estado=1
					ORDER BY m2.id_modulo, org_modulo.orden) AS MENU
					GROUP BY id_padre
					ORDER BY id_padre, orden";
		$query=$this->db->query($sentencia);
		if($query->num_rows>0) {
			return (array)$query->result_array();
		}
		else {
			return 0;
		}
	}
		
	function buscar_menus($id) 
	{
		$sentencia="SELECT DISTINCT
					m2.orden AS orden_padre,
					m2.id_modulo AS id_padre,
					m2.nombre_modulo AS nombre_padre,
					
					org_modulo.id_modulo,
					org_modulo.orden,
					org_modulo.nombre_modulo,
					org_modulo.descripcion_modulo,
					org_modulo.dependencia,
					org_modulo.url_modulo,
					org_modulo.img_modulo
					FROM org_rol
					INNER JOIN org_usuario_rol ON org_rol.id_rol = org_usuario_rol.id_rol
					INNER JOIN org_rol_modulo_permiso ON org_rol_modulo_permiso.id_rol = org_rol.id_rol
					INNER JOIN org_modulo ON org_modulo.id_modulo = org_rol_modulo_permiso.id_modulo
					LEFT JOIN org_modulo AS m2 ON m2.id_modulo = org_modulo.dependencia
					WHERE org_usuario_rol.id_usuario=".$id." AND org_modulo.id_sistema=11 AND org_rol_modulo_permiso.estado=1
					ORDER BY m2.id_modulo, org_modulo.orden";
		$query=$this->db->query($sentencia);
		
		$result=(array)$query->result_array();
		
		$new_menu=array();
		foreach($result as $r) {
			if(!in_array($r[id_padre], $new_menu)){
				$new_menu[$r[id_padre]]=array(
					"orden_padre"=>$r[orden_padre],
					"id_padre"=>$r[id_padre],
					"nombre_padre"=>$r[nombre_padre],
					"id_modulo"=>$this->buscar_submenus($r[id_padre],$result,"id_modulo"),
					"orden"=>$this->buscar_submenus($r[id_padre],$result,"orden"),
					"nombre_modulo"=>$this->buscar_submenus($r[id_padre],$result,"nombre_modulo"),
					"descripcion_modulo"=>$this->buscar_submenus($r[id_padre],$result,"descripcion_modulo"),
					"dependencia"=>$this->buscar_submenus($r[id_padre],$result,"dependencia"),
					"url_modulo"=>$this->buscar_submenus($r[id_padre],$result,"url_modulo"),
					"img_modulo"=>$this->buscar_submenus($r[id_padre],$result,"img_modulo")
				);
			}			
		}
		
		if($query->num_rows>0) {
			return $new_menu;
		}
		else {
			return 0;
		}
	}	
	
	function buscar_submenus($id_modulo,$result,$campo) 
	{
		$valores='';
		foreach($result as $r) {
			if($r[dependencia]==$id_modulo) {
				if($r[$campo]!="" && $r[$campo]!=NULL)
					$valores.=$r[$campo].',';
			}
		}
		return substr($valores, 0, -1);
	}
	
	function consultar_permiso($id_usuario,$id_modulo)
	{
		$sentencia="SELECT
						MAX(id_permiso ) AS id_permiso
					FROM
					org_usuario_rol
					INNER JOIN org_rol_modulo_permiso ON org_usuario_rol.id_rol = org_rol_modulo_permiso.id_rol
					WHERE org_usuario_rol.id_usuario=".$id_usuario." AND org_rol_modulo_permiso.id_modulo=".$id_modulo." GROUP BY id_modulo";
						
		$query=$this->db->query($sentencia);
			
		if($query->num_rows>0) {
			return (array)$query->row();
		}
		else {
			return array(
				'id_usuario' => 0
			);
		}
	}
	   function info_empleado($id_empleado=NULL, $select="*", $id_usuario=NULL, $usuario="")
    {
        $where="";
        if($id_empleado!=NULL)
            $where.=" AND id_empleado=".$id_empleado;
        if($id_usuario!=NULL)
            $where.=" AND id_usuario=".$id_usuario;
        if($usuario!="")
            $where.=" AND usuario LIKE '".$usuario."'
        			OR nr LIKE '".$usuario."'";
        $sentencia="SELECT ".$select." FROM tcm_empleado WHERE TRUE ".$where;
        $query=$this->db->query($sentencia);
        return (array)$query->row();
    }
	
	function guardar_caso($formuInfo)
	{
		extract($formuInfo);
        $sentencia="INSERT INTO glb_caso
                    (id_usuario, fecha_caso, nuevo_pass, codigo_caso) 
                    VALUES 
                    ($id_usuario, '$fecha_caso', '$nuevo_pass', '$codigo_caso')";
        $this->db->query($sentencia);
	}
	
	function buscar_caso($codigo_caso)
	{
		$sentencia="SELECT
                    id_usuario, nuevo_pass
                    FROM glb_caso
                    WHERE estado_caso=1 AND DATEDIFF(CURDATE(),fecha_caso)<=3 AND codigo_caso LIKE '".$codigo_caso."'";
        $query=$this->db->query($sentencia);
		$caso=(array)$query->row();
        $count=0+$query->num_rows;
		if($count>0) {
			$sentencia="UPDATE glb_caso SET estado_caso=0 WHERE codigo_caso LIKE '".$codigo_caso."'";
			$this->db->query($sentencia);
			$sentencia="UPDATE org_usuario SET password='".$caso['nuevo_pass']."' WHERE id_usuario=".$caso['id_usuario'];
			$this->db->query($sentencia);
		}
        return $count;
	}

	function get_ayuda($id_modulo=NULL)
	{
		$q="SELECT * FROM glb_ayuda WHERE id_modulo=$id_modulo";
		$query=$this->db->query($q);
		$temp= $query->result_array();
		return $temp[0];
	}	
	 function verificar_usuario($usuarioe=NULL)
    {

        $sentencia="SELECT id_usuario, usuario FROM org_usuario WHERE md5(id_usuario)= '$usuarioe'";
        $query=$this->db->query($sentencia);
        return (array)$query->row();
    }
		 function verificar_solicitud($solicitude=NULL)
    {

        $sentencia="SELECT id_solicitud_transporte, estado_solicitud_transporte as estado FROM tcm_solicitud_transporte WHERE md5(id_solicitud_transporte)= '$solicitude'";
        $query=$this->db->query($sentencia);
        return (array)$query->row();
    }
	
	function bitacora($id_sistema,$id_usuario,$descripcion,$id_accion)
	{
		$fecha_hora=date('Y-m-d H:i:s');
		$IP=$this->get_real_ip();
		
		$query="INSERT INTO glb_bitacora(id_sistema,id_usuario,descripcion,fecha_hora,IP,id_accion) VALUES
		('$id_sistema','$id_usuario','$descripcion','$fecha_hora','$IP','$id_accion')";
		return($this->db->query($query));
	}
	
	function get_real_ip()
    {
 
        if (isset($_SERVER["HTTP_CLIENT_IP"]))
        {
            return $_SERVER["HTTP_CLIENT_IP"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
        {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
        {
            return $_SERVER["HTTP_X_FORWARDED"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
        {
            return $_SERVER["HTTP_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED"]))
        {
            return $_SERVER["HTTP_FORWARDED"];
        }
        else
        {
            return $_SERVER["REMOTE_ADDR"];
        }
 
    }
	
	function bitacora_reg($id_bitacora=NULL)
	{
		$where="";
		if($id_bitacora!=NULL) $where = "WHERE b.id_bitacora='$id_bitacora'";
		
		$query="SELECT b.id_bitacora, DATE_FORMAT(b.fecha_hora,'%d-%m-%Y %H:%i:%s') AS fecha_hora, b.descripcion, b.IP, b.id_accion, ab.accion,
				b.id_sistema, LOWER(os.nombre_sistema) AS nombre_sistema, b.id_usuario, LOWER(ou.nombre_completo) AS nombre_usuario, ou.usuario
				FROM glb_bitacora AS b INNER JOIN glb_accion_bitacora AS ab ON (b.id_accion=ab.id_accion)
				INNER JOIN org_sistema AS os ON (os.id_sistema=b.id_sistema)
				INNER JOIN org_usuario As ou ON (ou.id_usuario=b.id_usuario) ".$where;
				
		$query=$this->db->query($query);
		return (array)$query->result_array();
	}
	
	function eliminar_bitacora($id_bitacora)
	{
		$query="delete from glb_bitacora where id_bitacora='$id_bitacora'";
		return $this->db->query($query);
	}
	
	function backups($id_backup=NULL)
	{
		$where="";
		if($id_backup!=NULL) $where = "WHERE b.id_backup='$id_backup'";
		
		$query="select b.id_backup, b.nombre, b.descripcion, DATE_FORMAT(b.fecha_hora,'%d-%m-%Y %H:%i:%s') as fecha_hora, u.id_usuario,
				lower(u.nombre_completo) as nombre_completo, u.usuario
				FROM glb_backup as b
				INNER JOIN org_usuario as u on (u.id_usuario=b.id_usuario) ".$where;
				
		$query=$this->db->query($query);
		return (array)$query->result_array();
	}
	
	function guardar_backup($datos)
	{
		extract($datos);
		
		$fecha_hora=date('Y-m-d H:i:s');
		
		// Carga la clase de utilidades de base de datos
		$this->load->dbutil();

		$prefs = array(
			//'tables'      => array('edp_area', 'edp_asignacion', 'edp_calificacion', 'edp_cap_solicitada', 'edp_capacitacion', 'edp_capacitacion_programada', 'edp_categoria', 'edp_edicion', 'edp_edicion_detalle', 'edp_enviado', 'edp_evaluacion_version', 'edp_factor', 'edp_perfil', 'edp_pregunta', 'edp_razon', 'edp_respuesta', 'glb_accion_bitacora', 'glb_ayuda', 'glb_backup', 'glb_bitacora', 'glb_paso', 'glb_problema', 'org_departamento', 'org_fuente_fondo', 'org_genero', 'org_modulo', 'org_municipio', 'org_permiso', 'org_rol', 'org_rol_modulo_permiso', 'org_seccion', 'org_seccion_has_almacen', 'org_sistema', 'org_usuario', 'org_usuario_rol', 'pat_documento', 'pat_indicador', 'pat_item', 'pat_item_seccion', 'pat_nivel', 'pat_presupuesto', 'sac_asistencia', 'sac_capacitacion', 'sac_capacitador', 'sac_cargo_comite', 'sac_clasificacion_institucion', 'sac_control_visita', 'sac_empleado_institucion', 'sac_entrega_acreditacion', 'sac_estado_verificacion', 'sac_incumplimiento', 'sac_incumplimiento_promocion', 'sac_institucion', 'sac_lugar_trabajo', 'sac_miembro_entrevistado', 'sac_programacion_visita', 'sac_promocion', 'sac_sector_institucion', 'sac_tematica', 'sac_tipo_inscripcion', 'sac_tipo_lugar_trabajo', 'sac_tipo_representacion', 'sir_cargo_funcional', 'sir_cargo_nominal', 'sir_empleado', 'sir_empleado_informacion_laboral', 'tcm_accesorios', 'tcm_acompanante', 'tcm_articulo_bodega', 'tcm_asignacion_sol_veh_mot', 'tcm_bitacora_vehiculo', 'tcm_chekeo_accesorio', 'tcm_chequeo_reparacion', 'tcm_chequeo_revision', 'tcm_configuracion', 'tcm_consumo', 'tcm_consumo_copy', 'tcm_consumo_vehiculo', 'tcm_consumo_vehiculo_copy', 'tcm_destino_mision', 'tcm_fuente_fondo', 'tcm_gasolinera', 'tcm_gasto_presupuesto', 'tcm_herramienta', 'tcm_ingreso_taller', 'tcm_ingreso_taller_ext', 'tcm_mantenimiento_interno', 'tcm_mantenimiento_rutinario', 'tcm_observacion', 'tcm_presupuesto_mantenimiento', 'tcm_refuerzo_presupuesto', 'tcm_reparacion', 'tcm_req_veh', 'tcm_requisicion', 'tcm_requisicion_vale', 'tcm_requisicion_vale_consumo_vehiculo', 'tcm_requisicion_vale_consumo_vehiculo_copy', 'tcm_revision', 'tcm_seccion_asignacion', 'tcm_sobrantes', 'tcm_solicitud_transporte', 'tcm_taller_externo', 'tcm_transaccion_articulo', 'tcm_unidad_medida', 'tcm_vale', 'tcm_vehiculo', 'tcm_vehiculo_clase', 'tcm_vehiculo_condicion', 'tcm_vehiculo_kilometraje', 'tcm_vehiculo_marca', 'tcm_vehiculo_modelo', 'tcm_vehiculo_motorista'),                   // Arreglo de tablas para respaldar.
			'tables'      => array('tcm_presupuesto_mantenimiento'),
			'ignore'      => array(),           // Lista de tablas para omitir en la copia de seguridad
			'format'      => 'sql',             // gzip, zip, txt
			'filename'    => $nombre.".sql",    // Nombre de archivo - NECESARIO SOLO CON ARCHIVOS ZIP
			'add_drop'    => TRUE,              // Agregar o no la sentencia DROP TABLE al archivo de respaldo
			'add_insert'  => TRUE,              // Agregar o no datos de INSERT al archivo de respaldo
			'newline'     => "\n"               // Caracter de nueva línea usado en el archivo de respaldo
		);

		// Crea una copia de seguridad de toda la base de datos y la asigna a una variable
		$copia_de_seguridad = $this->dbutil->backup($prefs); 

		//print_r($copia_de_seguridad);
		// Carga el asistente de archivos y escribe el archivo en su servidor
		$this->load->helper('file');

		if ( ! write_file('./respaldos/'.$nombre.'.sql', $copia_de_seguridad))
		{
			return false;
		}
		else
		{
			$query="INSERT INTO glb_backup(nombre,fecha_hora,id_usuario,descripcion) VALUES
			('$nombre','$fecha_hora','$id_usuario','$descripcion')";
			
			return $this->db->query($query);
		}		
	}
	
	function eliminar_backup($id_backup)
	{
		$query="delete from glb_backup where id_backup='$id_backup'";
		return $this->db->query($query);
	}
	
	function restaurar_backup($datos)
	{
		extract($datos);
		$this->load->helper('file');
		
		if($id_backup!=NULL)/*verificando si es un backup interno (es decir, uno que se encuentra en la carpeta respaldos del sistema)*/
		{
			$query="select nombre from glb_backup where id_backup='$id_backup'";
			$query=$this->db->query($query);
			$name=$query->result_array();
			
			foreach($name as $n)
			{
				$nombre=$n['nombre'];
			}
			
			if(file('./respaldos/'.$nombre.'.sql')===FALSE) return false;
			else $archivo=file('./respaldos/'.$nombre.'.sql');
		}
		else
		{
			if(file($url)===FALSE) return false;
			else $archivo=file($url);
		}
		
		$templine = '';
		
		
		// Loop through each line
		foreach ($archivo as $line)
		{
			// Skip it if it's a comment
			if (substr($line, 0, 2) == '--' || $line == '')
				continue;
		 
			// Add this line to the current segment
			$templine .= $line;
			// If it has a semicolon at the end, it's the end of the query
			if (substr(trim($line), -1, 1) == ';')
			{
				// Perform the query
				$this->db->query('set foreign_key_checks=0;');
				mysql_query($templine);// or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
				// Reset temp variable to empty
				$templine = '';
			}
		}
		
		$this->db->query('set foreign_key_checks=1;');

	}
}
?>