<?php 
if($id_sistema != 0){
 ?>
   <div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Módulos</h4>
    <div class="myadmin-dd dd">
        <?php
            $contador = 0;
            $modelo = $this->db->query("SELECT * FROM org_modulo WHERE (dependencia = '' OR dependencia = 0 OR dependencia IS NULL) AND id_sistema = $id_sistema ORDER BY orden");
            if($modelo->num_rows() > 0){
                echo '<ol class="dd-list">';
                foreach ($modelo->result() as $fila) {           
        ?>

       
        <li class="dd-item">
          <div class="dd-handle" style="cursor: auto;"><span class="<?php echo $fila->img_modulo; ?>"></span> <?php echo $fila->nombre_modulo; ?></div>

            <?php
                $modelo2 = $this->db->query("SELECT * FROM org_modulo WHERE dependencia = $fila->id_modulo AND id_sistema = $id_sistema ORDER BY orden");
                if($modelo2->num_rows() > 0){
                    echo '<ol class="dd-list">';
                    foreach ($modelo2->result() as $fila2) {              
            ?>
          

            <button type="button" title="Agregar hijo" class="btn waves-effect waves-light btn-success2 pull-right" style="padding: 3px 5px 3px 5px;" onclick=""><i class="mdi mdi-plus"></i></button>

            

            <button type="button" class="btn waves-effect waves-light btn-info pull-right" style="padding: 3px 5px 3px 5px;" onclick=""><i class="mdi mdi-settings"></i></button>

      

            <li class="dd-item">
              <div class="dd-handle" style="cursor: auto;"><span class="<?php echo $fila2->img_modulo; ?>"></span> <?php echo $fila2->nombre_modulo; ?></div>

                <?php
                    $modelo3 = $this->db->query("SELECT * FROM org_modulo WHERE dependencia = $fila2->id_modulo AND id_sistema = $id_sistema ORDER BY orden");
                    if($modelo3->num_rows() > 0){
                        echo '<ol class="dd-list">';
                        foreach ($modelo3->result() as $fila3) {              
                ?>
                
                <button type="button" class="btn waves-effect waves-light btn-info pull-right" style="padding: 3px 5px 3px 5px;" onclick=""><i class="mdi mdi-settings"></i></button>
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
                Selecciona un sistema para poder iniciar las configuraciones de sus módulos.
            </blockquote>
        </div>
    </div>

<?php 
}
 ?>
