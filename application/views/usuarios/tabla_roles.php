<hr>
<div class="row">
	<div class="col-lg-12" align="center">
	    <h5 class="box-title">Asignación de roles</h5>
	    <select id='pre-selected-options' multiple='multiple'>
	        <?php 
	            $roles = $this->db->query("SELECT * FROM org_rol ORDER BY nombre_rol");
	            if($roles->num_rows() > 0){
	                foreach ($roles->result() as $fila) {              
	                   echo '<option align="left" value="'.$fila->id_rol.'">'.$fila->nombre_rol.'</option>';
	                }
	            }
	        ?>
	    </select>
	</div>
</div>
<hr>