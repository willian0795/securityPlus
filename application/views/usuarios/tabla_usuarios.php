<table id="myTable" class="table table-hover product-overview">
    <thead class="bg-info text-white">
        <tr>
            <th>#</th>   
            <th>Nombre completo</th>
            <th>Usuario</th>
            <th>NR</th>
            <th>Estado</th>
            <th style="min-width: 85px;">(*)</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $oficina = $_GET["oficina"];
        if(empty($oficina)){
            $usuarios = $this->db->query("SELECT id_usuario, nombre_completo, sexo, usuario, estado, nr, password FROM org_usuario WHERE id_seccion NOT IN (52,53,54,55,56,57,58,59,60,61,64,65,66) ORDER BY nombre_completo");
        }else{
            $usuarios = $this->db->query("SELECT id_usuario, nombre_completo, sexo, usuario, estado, nr, password FROM org_usuario WHERE id_seccion = '".$oficina."' ORDER BY nombre_completo");
        }
        $contador = 0;
        if($usuarios->num_rows() > 0){
            foreach ($usuarios->result() as $fila) {
                $contador++;
                echo "<tr>";
                echo "<td>".$contador."</td>";
                echo "<td>".$fila->nombre_completo."</td>";
                echo "<td>".$fila->usuario."</td>";
                echo "<td>".$fila->nr."</td>";
                    if($fila->estado == 1){ 
                        echo '<td><span class="label label-success">Activo</span></div>'; 
                    }else{ 
                        echo '<td><span class="label label-danger">Inactivo</span></div>'; 
                    }
                echo"</td>";

                echo"<td>";
                    $array = array($fila->id_usuario, $fila->nombre_completo, $fila->sexo, $fila->usuario, $fila->estado, $fila->nr, $fila->password);
                    array_push($array, "edit");
                    echo generar_boton($array,"cambiar_editar","btn-info","fa fa-wrench","Editar usuario");
                    unset($array[endKey($array)]); //eliminar el ultimo elemento de un array
                    if($fila->estado == 1){ 
                        array_push($array, "activo");
                        echo generar_boton($array,"cambiar_editar","btn-danger","fa fa-chevron-down","Desactivar cuenta");
                    }else{ 
                        array_push($array, "Inactivo");
                        echo generar_boton($array,"cambiar_editar","btn-success","fa fa-chevron-up","Activar cuenta"); 
                    }                        
                echo "</td>";

                echo "</tr>";
            }
        }
        $usuarios->free_result();
    ?>
    </tbody>
</table>
