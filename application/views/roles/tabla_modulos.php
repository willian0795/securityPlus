<?php 
if($id_sistema != 0){
 ?>
                                     
   <div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Módulos</h4>
    <div class="myadmin-dd dd-nodrag" id="nestable">
        <?php
            $contador = 0;
            $modelo = $this->db->query("SELECT * FROM org_modulo WHERE (dependencia = '' OR dependencia = 0 OR dependencia IS NULL) AND id_sistema = $id_sistema ORDER BY orden");
            if($modelo->num_rows() > 0){
                echo '<ol class="dd-list">';
                foreach ($modelo->result() as $fila) { 
                    $modelo2 = $this->db->query("SELECT * FROM org_modulo WHERE dependencia = $fila->id_modulo AND id_sistema = $id_sistema ORDER BY orden");          
        ?>
            <?php                
                if($modelo2->num_rows() == 0){
            ?>
                <div class="pull-right">
                    <div class="input-group" style="z-index: 1; font-size: 16px;">
                        <input type="hidden" value="<?php echo $fila->id_modulo; ?>" style="width: 30px; margin-right: 10px;">
                        <label class="custom-control custom-checkbox" data-toggle="tooltip" title="Consultar" style="margin-right: 5px;">
                            <input type="checkbox" class="custom-control-input" value="0" onchange="cambiar_check(this)">
                            <span class="custom-control-indicator" style="width: 20px; height: 20px;"></span>
                            <span style="position: absolute; left: -5px; top:-5px; display: inline-flex;">
                                <i class="fa fa-hand-pointer-o"></i>
                            </span>
                        </label>
                        <label class="custom-control custom-checkbox" data-toggle="tooltip" title="Insertar" style="margin-right: 5px;">
                            <input type="checkbox" class="custom-control-input" value="0" onchange="cambiar_check(this)">
                            <span class="custom-control-indicator" style="width: 20px; height: 20px;"></span>
                            <span style="position: absolute; left: -5px; top:-5px; display: inline-flex;">
                                <i class="fa fa-plus"></i>
                            </span>
                        </label>
                        <label class="custom-control custom-checkbox" data-toggle="tooltip" title="Modificar" style="margin-right: 5px;">
                            <input type="checkbox" class="custom-control-input" value="0" onchange="cambiar_check(this)">
                            <span class="custom-control-indicator" style="width: 20px; height: 20px;"></span>
                            <span style="position: absolute; left: -5px; top:-5px; display: inline-flex;">
                                <i class="ti-marker-alt"></i>
                            </span>
                        </label>
                        <label class="custom-control custom-checkbox" data-toggle="tooltip" title="Eliminar" style="margin-right: 5px;">
                            <input type="checkbox" class="custom-control-input" value="0" onchange="cambiar_check(this)">
                            <span class="custom-control-indicator" style="width: 20px; height: 20px;"></span>
                            <span style="position: absolute; left: -5px; top:-5px; display: inline-flex;">
                                <i class="fa fa-close"></i>
                            </span>
                        </label>
                        <label class="custom-control custom-checkbox m-0" data-toggle="tooltip" title="Seleccionar todos">
                            <input type="checkbox" class="custom-control-input" value="0" onchange="marcar_check(this)">
                            <span class="custom-control-indicator" style="width: 20px; height: 20px;"></span>
                            <span style="position: absolute; left: 12px; top:-5px; display: inline-flex;">
                                <i class="fa fa-check-circle-o"></i>
                            </span>
                        </label>
                    </div>
                </div>
            <?php
                }
            ?>

        <li class="dd-item">
          <div class="dd-handle" id="no-drag" style="cursor: auto; pointer-events: none;"><span class="<?php echo $fila->img_modulo; ?>"></span> <?php echo $fila->nombre_modulo; ?></div>

            <?php
                if($modelo2->num_rows() > 0){
                    echo '<ol class="dd-list">';
                    foreach ($modelo2->result() as $fila2) { 
                        $modelo3 = $this->db->query("SELECT * FROM org_modulo WHERE dependencia = $fila2->id_modulo AND id_sistema = $id_sistema ORDER BY orden");             
            ?>    

            <?php                
                if($modelo3->num_rows() == 0){
            ?>
                <div class="pull-right">
                    <div class="input-group" style="z-index: 1; font-size: 16px;">
                        <input type="hidden" value="<?php echo $fila2->id_modulo; ?>" style="width: 30px; margin-right: 10px;">
                        <label class="custom-control custom-checkbox" data-toggle="tooltip" title="Consultar" style="margin-right: 5px;">
                            <input type="checkbox" class="custom-control-input" value="0" onchange="cambiar_check(this)">
                            <span class="custom-control-indicator" style="width: 20px; height: 20px;"></span>
                            <span style="position: absolute; left: -5px; top:-5px; display: inline-flex;">
                                <i class="fa fa-hand-pointer-o"></i>
                            </span>
                        </label>
                        <label class="custom-control custom-checkbox" data-toggle="tooltip" title="Insertar" style="margin-right: 5px;">
                            <input type="checkbox" class="custom-control-input" value="0" onchange="cambiar_check(this)">
                            <span class="custom-control-indicator" style="width: 20px; height: 20px;"></span>
                            <span style="position: absolute; left: -5px; top:-5px; display: inline-flex;">
                                <i class="fa fa-plus"></i>
                            </span>
                        </label>
                        <label class="custom-control custom-checkbox" data-toggle="tooltip" title="Modificar" style="margin-right: 5px;">
                            <input type="checkbox" class="custom-control-input" value="0" onchange="cambiar_check(this)">
                            <span class="custom-control-indicator" style="width: 20px; height: 20px;"></span>
                            <span style="position: absolute; left: -5px; top:-5px; display: inline-flex;">
                                <i class="ti-marker-alt"></i>
                            </span>
                        </label>
                        <label class="custom-control custom-checkbox m-0" data-toggle="tooltip" title="Eliminar">
                            <input type="checkbox" class="custom-control-input" value="0" onchange="cambiar_check(this)">
                            <span class="custom-control-indicator" style="width: 20px; height: 20px;"></span>
                            <span style="position: absolute; left: -5px; top:-5px; display: inline-flex;">
                                <i class="fa fa-close"></i>
                            </span>
                        </label>
                        <label class="custom-control custom-checkbox m-0" data-toggle="tooltip" title="Seleccionar todos">
                            <input type="checkbox" class="custom-control-input" value="0" onchange="marcar_check(this)">
                            <span class="custom-control-indicator" style="width: 20px; height: 20px;"></span>
                            <span style="position: absolute; left: 12px; top:-5px; display: inline-flex;">
                                <i class="fa fa-check-circle-o"></i>
                            </span>
                        </label>
                    </div>
                </div>
            <?php
                }
            ?>        

            <li class="dd-item">
              <div class="dd-handle" style="cursor: auto; pointer-events: none;"><span class="<?php echo $fila2->img_modulo; ?>"></span> <?php echo $fila2->nombre_modulo; ?></div>

                <?php
                    if($modelo3->num_rows() > 0){
                        echo '<ol class="dd-list">';
                        foreach ($modelo3->result() as $fila3) {              
                ?>
                
                <div class="pull-right">
                    <div class="input-group" style="z-index: 1; font-size: 16px;">
                        <input type="hidden" value="<?php echo $fila3->id_modulo; ?>" style="width: 30px; margin-right: 10px;">
                        <label class="custom-control custom-checkbox" data-toggle="tooltip" title="Consultar" style="margin-right: 5px;">
                            <input type="checkbox" class="custom-control-input" value="0" onchange="cambiar_check(this)">
                            <span class="custom-control-indicator" style="width: 20px; height: 20px;"></span>
                            <span style="position: absolute; left: -5px; top:-5px; display: inline-flex;">
                                <i class="fa fa-hand-pointer-o"></i>
                            </span>
                        </label>
                        <label class="custom-control custom-checkbox" data-toggle="tooltip" title="Insertar" style="margin-right: 5px;">
                            <input type="checkbox" class="custom-control-input" value="0" onchange="cambiar_check(this)">
                            <span class="custom-control-indicator" style="width: 20px; height: 20px;"></span>
                            <span style="position: absolute; left: -5px; top:-5px; display: inline-flex;">
                                <i class="fa fa-plus"></i>
                            </span>
                        </label>
                        <label class="custom-control custom-checkbox" data-toggle="tooltip" title="Modificar" style="margin-right: 5px;">
                            <input type="checkbox" class="custom-control-input" value="0" onchange="cambiar_check(this)">
                            <span class="custom-control-indicator" style="width: 20px; height: 20px;"></span>
                            <span style="position: absolute; left: -5px; top:-5px; display: inline-flex;">
                                <i class="ti-marker-alt"></i>
                            </span>
                        </label>
                        <label class="custom-control custom-checkbox m-0" data-toggle="tooltip" title="Eliminar">
                            <input type="checkbox" class="custom-control-input" value="0" onchange="cambiar_check(this)">
                            <span class="custom-control-indicator" style="width: 20px; height: 20px;"></span>
                            <span style="position: absolute; left: -5px; top:-5px; display: inline-flex;">
                                <i class="fa fa-close"></i>
                            </span>
                        </label>
                        <label class="custom-control custom-checkbox m-0" data-toggle="tooltip" title="Seleccionar todos">
                            <input type="checkbox" class="custom-control-input" value="0" onchange="marcar_check(this)">
                            <span class="custom-control-indicator" style="width: 20px; height: 20px;"></span>
                            <span style="position: absolute; left: 12px; top:-5px; display: inline-flex;">
                                <i class="fa fa-check-circle-o"></i>
                            </span>
                        </label>
                    </div>
                </div>
                <li class="dd-item">
                  <div class="dd-handle" style="cursor: auto; pointer-events: none;"><span class="<?php echo $fila3->img_modulo; ?>"></span> <?php echo $fila3->nombre_modulo; ?></div>
                </li>
                <?php
                        }
                        echo "</ol>";
                    }
                ?>
            </li>
            <?php
                    }
                    echo "</ol>";
                }
            ?>
        </li>
        <?php
                }
                echo "</ol>";
                
            }else{
        ?>
        <div class="sl-item">
            <div class="sl-right">
                    <blockquote class="m-t-10">
                        No hay módulos disponibles para este sistema.
                    </blockquote>
                </div>
        </div>
    
        <?php } ?>
    </div>

</div>
</div>
</div>

<?php 
}else{
 ?>

<div class="sl-item">
    <div class="sl-right">
            <blockquote class="m-t-10">
                Selecciona un sistema para poder configurar los roles de sus módulos
            </blockquote>
        </div>
    </div>

<?php 
}
 ?>
