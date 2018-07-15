<div class="table-responsive">
    <table id="myTable2" class="table table-hover product-overview">
        <thead class="bg-info text-white">
            <tr>
                <th>#</th>   
                <th>Nombre del rol</th>
                <th style="min-width: 85px;">(*)</th>
            </tr>
        </thead>
        <tbody>
        <?php
        	$usuario = $_GET["id_usuario"];
            
            $roles = $this->db->query("SELECT * FROM org_rol WHERE id_rol IN (SELECT r.id_rol FROM org_usuario_rol AS r WHERE r.id_usuario = '".$usuario."') ORDER BY nombre_rol");
            $contador = 0;
            if($roles->num_rows() > 0){
                foreach ($roles->result() as $fila) {
                    $contador++;
                    echo "<tr>";
                    echo "<td>".$contador."</td>";
                    echo "<td>".$fila->nombre_rol."</td>";
                    echo"<td>";
                        $array = array($fila->id_rol, $usuario);
                        array_push($array, "eliminar");
                        echo generar_boton($array,"gestionar_roles","btn-danger","fa fa-close","Eliminar");
                    echo "</td>";
                    echo "</tr>";
                }
            }
            $roles->free_result();
        ?>
        </tbody>
    </table>
</div>