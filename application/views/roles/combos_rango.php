<?php 
    $id_rol = $_GET["id_rol"];
    $id_modulo = $_GET["id_modulo"];
?>
<div class="row">
    <div class="form-group col-lg-12">   
        <label for="id_modulo_rango" class="font-weight-bold">Módulo seleccionado :<span class="text-danger">*</span></label>
        <select id="id_modulo_rango" name="id_modulo_rango" class="custom-select" style="width: 100%" disabled>
            <?php 
                $modulo = $this->db->query("SELECT * FROM org_modulo WHERE id_modulo = '".$id_modulo."'");
                if($modulo->num_rows() > 0){
                    foreach ($modulo->result() as $fila2) {              
                       echo '<option class="m-l-50" value="'.$fila2->id_modulo.'">'.$fila2->nombre_modulo.'</option>';
                    }
                }
            ?>
        </select>
    </div>
</div>
<div><label class="font-weight-bold m-t-0">Edite los rangos: </label>
    <blockquote class="m-t-0">
    <?php 
        $permisos = $this->db->query("SELECT * FROM org_rol_modulo_permiso WHERE id_modulo = '".$id_modulo."' AND id_rol = '".$id_rol."' order by id_permiso");
        if($permisos->num_rows() > 0){
            foreach ($permisos->result() as $fila) {
                if($fila->id_permiso == '1'){ $titulo = "<i class='fa fa-hand-pointer-o'></i> Consultas"; }
                else if($fila->id_permiso == '2'){ $titulo = "<i class='fa fa-plus'></i> Registros"; }
                else if($fila->id_permiso == '3'){ $titulo = "<i class='fa fa-close'></i> Eliminar"; }
                else if($fila->id_permiso == '4'){ $titulo = "<i class='ti-marker-alt'></i> Modificaciones"; }
        ?>
            <div class="d-flex no-block">
                <h4 class="card-title"><?php echo $titulo; ?></h4>
                <div class="ml-auto">
                    <select class="custom-select" onchange="cambiar_rango(this.value, '<?php echo $fila->id_rol_permiso; ?>');">
                        <option value="1" <?php if($fila->id_rango == '1'){ echo "selected"; } ?>>Personal</option>
                        <option value="2" <?php if($fila->id_rango == '2'){ echo "selected"; } ?>>Sección</option>
                        <option value="3" <?php if($fila->id_rango == '3'){ echo "selected"; } ?>>Departamental</option>
                        <option value="4" <?php if($fila->id_rango == '4'){ echo "selected"; } ?>>Nacional</option>
                    </select>
                </div>
            </div>
        <?php 
            }
        } 
    ?>
    </blockquote>
</div>