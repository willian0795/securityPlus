<?php  
        echo "<select class='form-control' name='id_modulo' id='id_modulo'>";
        echo "<option value=''>[Seleccione]</option>";
        foreach ($modulo as $list) {
            if($list['url_modulo']=='blank'){
                echo "<option disabled value='". $list['id_modulo'] . "'>" . $list['nombre_modulo'] . "</option>";
            }else if($seleccionado==$list['id_modulo']){
                echo "<option selected value='". $list['id_modulo'] . "'>" . $list['nombre_modulo'] . "</option>";
            }else{
                echo "<option  value='". $list['id_modulo'] . "'>" . $list['nombre_modulo'] . "</option>";
            }
        }
        echo "</select><br/>"; 
?>
        
