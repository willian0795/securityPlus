<div class="table-responsive">
    <table id="myTable" class="table table-bordered">
        <thead class="bg-info text-white">
            <tr>
                <?php 
                    function cambiar($variable){
                        if($variable == 0){ $variable = "vacio"; }
                        return $variable;
                    }       
                    $array = array('id_sistema' => cambiar($_GET["id_sistema"]), 'id_usuario' => cambiar($_GET["id_usuario"]), 'id_accion' => cambiar($_GET["id_accion"]));
                    $conta = 1; $var = "";
                    while ($otro = current($array)) {
                        if($otro != "vacio"){
                            if($conta == 1){ $var = " WHERE ".key($array)." = ".$otro;
                            }else{ $var .= " AND ".key($array)." = ".$otro; }
                            $conta++;
                        }
                        next($array);
                    }
                    echo "<th>Fecha</th>";
                    if($array["id_usuario"] == "vacio"){ echo "<th>Usuario</th>"; }
                    echo "<th>Descripción</th>";
                    if($array["id_sistema"] == "vacio"){ echo "<th>Sistema</th>"; }
                    echo "<th>Ip</th>";
                ?>
            </tr>
        </thead>
        <tbody>
        <?php
            $bitacora = $this->db->query("SELECT * FROM glb_bitacora $var");
            if($bitacora->num_rows() > 0){
                foreach ($bitacora->result() as $fila) {
                    echo "<tr>";
                        echo "<td>".date('Y-m-d h:i A', strtotime($fila->fecha_hora))."</td>";
                        if($array["id_usuario"] == "vacio"){
                        	$usuario = $this->db->query("SELECT * FROM org_usuario WHERE id_usuario = ".$fila->id_usuario);
                            if(!empty($usuario)){
                                foreach ($usuario->result() as $fila2) {
                                	echo "<td>".$fila2->usuario."</td>";
                                }
                            }
                        }
                        echo "<td>".$fila->descripcion."</td>";
                        if($array["id_sistema"] == "vacio"){
                        	$sistema = $this->db->query("SELECT * FROM org_sistema WHERE id_sistema = ".$fila->id_sistema);
                            if(!empty($sistema)){
                                foreach ($sistema->result() as $fila3) {}
                                echo "<td width='350px;'>".$fila3->nombre_sistema."</td>";
                            }
                        }
                        if($fila->IP == '::1'){
                            echo "<td>Servidor</td>";
                        }else{
                            echo "<td>".$fila->IP."</td>";
                        }
                    echo "</tr>";
                }
            }
        ?>
        </tbody>
    </table>
</div>