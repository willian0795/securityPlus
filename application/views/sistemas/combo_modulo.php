<h5>Dependencia: <span class="text-danger">*</span></h5>
<select id="dependencia" name="dependencia" class="form-control custom-select" style="width: 100%">
    <option value="0">[Ninguna]</option>
<?php
        $id_sistema = $_GET["id_sistema"];
        $modelo = $this->db->query("SELECT * FROM org_modulo WHERE (dependencia = '' OR dependencia = 0 OR dependencia IS NULL) AND id_sistema = $id_sistema ORDER BY orden");
        if($modelo->num_rows() > 0){
            foreach ($modelo->result() as $fila) {           
            echo '<option value="'.$fila->id_modulo.'">'.$fila->nombre_modulo.'</option>';
            $modelo2 = $this->db->query("SELECT * FROM org_modulo WHERE dependencia = $fila->id_modulo AND id_sistema = $id_sistema ORDER BY orden");
            if($modelo2->num_rows() > 0){
                $contador++;
                foreach ($modelo2->result() as $fila2) {              
                echo '<option value="'.$fila2->id_modulo.'">&emsp;'.$fila2->nombre_modulo.'</option>';
                $modelo3 = $this->db->query("SELECT * FROM org_modulo WHERE dependencia = $fila2->id_modulo AND id_sistema = $id_sistema ORDER BY orden");
                if($modelo3->num_rows() > 0){
                    $contador++;
                    foreach ($modelo3->result() as $fila3) {              
                    echo '<option value="'.$fila3->id_modulo.'">&emsp;&emsp;'.$fila3->nombre_modulo.'</option>';
                    }
                }
                }
            }
            }
        }
    ?>
</select>