<?php $id_sistema = $_GET["id_sistema"];
if($id_sistema != 0){
 ?>

 <p align="right"><a class="mytooltip" href="javascript:void(0)"><i class="mdi mdi-help-circle"></i> Ayuda <span class="tooltip-content3">Arrastra ubicando los módulos donde desees y haz clic en Finalizar.</span></a></p>

<div class="myadmin-dd dd" id="nestable">
    <?php
        $contador = 0;
        $id_sistema = $_GET["id_sistema"];
        $modelo = $this->db->query("SELECT * FROM org_modulo WHERE (dependencia = '' OR dependencia = 0 OR dependencia IS NULL) AND id_sistema = $id_sistema ORDER BY orden");
        if($modelo->num_rows() > 0){
            echo '<ol class="dd-list">';
            $contador++;
            $nullocero;
            foreach ($modelo->result() as $fila) {
            if(is_null($fila->dependencia)){
                $nullocero = "NULL";
            }else{
                $nullocero = 0;
            }
    ?>

    <li class="dd-item" data-id="<?php $contador; ?>">
      <div class="dd-handle"><span class="<?php echo $fila->img_modulo; ?>"></span> <?php echo $fila->nombre_modulo; ?></div>
      <input type="hidden" value="<?php echo $fila->id_modulo; ?>">

        <?php
            $modelo2 = $this->db->query("SELECT * FROM org_modulo WHERE dependencia = $fila->id_modulo AND id_sistema = $id_sistema ORDER BY orden");
            if($modelo2->num_rows() > 0){
                echo '<ol class="dd-list">';
                $contador++;
                foreach ($modelo2->result() as $fila2) {              
        ?>
        <li class="dd-item" data-id="<?php $contador; ?>">
          <div class="dd-handle"><span class="<?php echo $fila2->img_modulo; ?>"></span> <?php echo $fila2->nombre_modulo; ?></div>
          <input type="hidden" value="<?php echo $fila2->id_modulo; ?>">

            <?php
                $modelo3 = $this->db->query("SELECT * FROM org_modulo WHERE dependencia = $fila2->id_modulo AND id_sistema = $id_sistema ORDER BY orden");
                if($modelo3->num_rows() > 0){
                    echo '<ol class="dd-list">';
                    $contador++;
                    foreach ($modelo3->result() as $fila3) {              
            ?>
            <li class="dd-item" data-id="<?php $contador; ?>">
              <div class="dd-handle"><span class="<?php echo $fila3->img_modulo; ?>"></span> <?php echo $fila3->nombre_modulo; ?></div>
              <input type="hidden" value="<?php echo $fila3->id_modulo; ?>">
            <?php
                    }
                    echo "</ol>";          
                    echo "</li>";
                }else{
                    echo "</li>";
                }
            ?>
        <?php
                }
                echo "</ol>";
                echo "</li>";
            }else{
                echo "</li>";
            }
        ?>
    
    <?php
            }
            echo "</ol>";
            echo "</li>";
    ?>
    <div class="pull-left" id="Loading2" style="display: none;">
        <h4 class="text-primary"><b><span class="fa fa-spinner fa-pulse"></span> <small>Ordenando menú...</small></b></h4>
    </div>
    <div align="right">
        <button type="button" onclick="recorrerNestable('<?php echo $nullocero; ?>');" class="btn waves-effect waves-light btn-success">Finalizar </button>
    </div>
    <?php }else{ ?>
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

<?php }else{ ?>
    <div class="sl-item">
        <div class="sl-right">
                <blockquote class="m-t-10">
                    Selecciona un sistema para poder iniciar las configuraciones de sus módulos.
                </blockquote>
            </div>
        </div>
    </div>
<?php } ?>