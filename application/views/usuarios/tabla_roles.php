<hr>
<div class="row">
	<div class="col-lg-12" align="center">
	    <h5 class="box-title">Asignación de roles</h5>
	    <select id='pre-selected-options' multiple='multiple'>
	        <?php 
	        	$usuario = $_GET["id_usuario"];
	            $roles = $this->db->query("SELECT * FROM org_rol ORDER BY nombre_rol");
	            if($roles->num_rows() > 0){
	                foreach ($roles->result() as $fila) {
	                	$existe = $this->db->query("SELECT * FROM org_usuario_rol WHERE id_usuario = '".$usuario."' AND id_rol = '".$fila->id_rol."'");
	                	if($existe->num_rows() > 0){          
	                  		echo '<option align="left" value="'.$fila->id_rol.'" selected>'.$fila->nombre_rol.'</option>';
	               		}else{
	               			echo '<option align="left" value="'.$fila->id_rol.'">'.$fila->nombre_rol.'</option>';
	               		}
	                }
	            }
	        ?>
	    </select>
	</div>
</div>
<hr>