<?php $id_sistema = $_GET["id_sistema"];
if($id_sistema != 0){
 ?>
    <div align="right"> 
        <button type="button" onclick="cambiar_nuevo('0','1')" class="btn waves-effect waves-light btn-success2"><i class="mdi mdi-plus"></i> Agregar módulo </button>
    </div>
    <div class="myadmin-dd dd">
        <?php
            $contador = 0;
            $modelo = $this->db->query("SELECT * FROM org_modulo WHERE (dependencia = '' OR dependencia = 0 OR dependencia IS NULL) AND id_sistema = $id_sistema ORDER BY orden");
            if($modelo->num_rows() > 0){
                echo '<ol class="dd-list">';
                foreach ($modelo->result() as $fila) {           
        ?>

        <button type="button" name="icono_orden" class="btn waves-effect waves-light btn-danger pull-left" style="cursor: default; border-radius: 50%; font-size: 11px; padding: 0px; width: 15px;"><?php echo $fila->orden;?></button>
        <button type="button" title="Agregar hijo" class="btn waves-effect waves-light btn-success2 pull-right" style="padding: 3px 5px 3px 5px;" onclick="cambiar_nuevo('<?php echo $fila->id_modulo;?>','2')"><i class="mdi mdi-plus"></i></button>
        <button type="button" class="btn waves-effect waves-light btn-info pull-right" style="padding: 3px 5px 3px 5px;" onclick="cambiar_editar('<?php echo $fila->id_modulo;?>','<?php echo $fila->id_sistema;?>','<?php echo $fila->nombre_modulo;?>','<?php echo $fila->descripcion_modulo;?>','<?php echo $fila->dependencia;?>','<?php echo $fila->url_modulo;?>','<?php echo $fila->img_modulo;?>','<?php echo $fila->opciones_modulo;?>')"><i class="mdi mdi-settings"></i></button>
        <li class="dd-item">
          <div class="dd-handle" style="cursor: auto;"><span class="<?php echo $fila->img_modulo; ?>"></span> <?php echo $fila->nombre_modulo; ?></div>

            <?php
                $modelo2 = $this->db->query("SELECT * FROM org_modulo WHERE dependencia = $fila->id_modulo AND id_sistema = $id_sistema ORDER BY orden");
                if($modelo2->num_rows() > 0){
                    echo '<ol class="dd-list">';
                    foreach ($modelo2->result() as $fila2) {              
            ?>
            <button type="button" name="icono_orden" class="btn waves-effect waves-light btn-success pull-left" style="cursor: default; border-radius: 50%; font-size: 11px; padding: 0px; width: 15px;"><?php echo $fila2->orden;?></button>
            <button type="button" title="Agregar hijo" class="btn waves-effect waves-light btn-success2 pull-right" style="padding: 3px 5px 3px 5px;" onclick="cambiar_nuevo('<?php echo $fila2->id_modulo;?>','3')"><i class="mdi mdi-plus"></i></button>
            <button type="button" class="btn waves-effect waves-light btn-info pull-right" style="padding: 3px 5px 3px 5px;" onclick="cambiar_editar('<?php echo $fila2->id_modulo;?>','<?php echo $fila2->id_sistema;?>','<?php echo $fila2->nombre_modulo;?>','<?php echo $fila2->descripcion_modulo;?>','<?php echo $fila2->dependencia;?>','<?php echo $fila2->url_modulo;?>','<?php echo $fila2->img_modulo;?>','<?php echo $fila2->opciones_modulo;?>')"><i class="mdi mdi-settings"></i></button>
            <li class="dd-item">
              <div class="dd-handle" style="cursor: auto;"><span class="<?php echo $fila2->img_modulo; ?>"></span> <?php echo $fila2->nombre_modulo; ?></div>

                <?php
                    $modelo3 = $this->db->query("SELECT * FROM org_modulo WHERE dependencia = $fila2->id_modulo AND id_sistema = $id_sistema ORDER BY orden");
                    if($modelo3->num_rows() > 0){
                        echo '<ol class="dd-list">';
                        foreach ($modelo3->result() as $fila3) {              
                ?>
                <button type="button" name="icono_orden" class="btn waves-effect waves-light btn-warning pull-left" style="cursor: default; border-radius: 50%; font-size: 11px; padding: 0px; width: 15px;"><?php echo $fila3->orden;?></button>
                <button type="button" class="btn waves-effect waves-light btn-info pull-right" style="padding: 3px 5px 3px 5px;" onclick="cambiar_editar('<?php echo $fila3->id_modulo;?>','<?php echo $fila3->id_sistema;?>','<?php echo $fila3->nombre_modulo;?>','<?php echo $fila3->descripcion_modulo;?>','<?php echo $fila3->dependencia;?>','<?php echo $fila3->url_modulo;?>','<?php echo $fila3->img_modulo;?>','<?php echo $fila3->opciones_modulo;?>')"><i class="mdi mdi-settings"></i></button>
                <li class="dd-item">
                  <div class="dd-handle" style="cursor: auto;"><span class="<?php echo $fila3->img_modulo; ?>"></span> <?php echo $fila3->nombre_modulo; ?></div>
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
        </div>
        <?php } ?>
    </div>
<?php 
}else{
 ?>

<div class="sl-item">
    <div class="sl-right">
            <blockquote class="m-t-10">
                Selecciona un sistema para poder iniciar las configuraciones de sus módulos.
            </blockquote>
        </div>
    </div>
</div>

<?php 
}
 ?>
