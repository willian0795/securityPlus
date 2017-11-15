<div class="card">
	<div class="card-header">
        <h4 class="card-title m-b-0">Listado de usuarios</h4>
    </div>
    <div class="card-body b-t" style="padding-top: 7px;">
        <div class="pull-right">
            <button type="button" onclick="cambiar_nuevo();" class="btn btn-rounded btn-success2"><span class="mdi mdi-plus"></span> Nuevo registro</button>
        </div>
        <div class="table-responsive">
            <table id="myTable" class="table table-bordered">
                <thead class="bg-info text-white">
                    <tr>
                        <th>Id</th>
                        <th>NR</th>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>(*)</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $usuarios = $this->db->get("org_usuario");

                    if(!empty($usuarios)){
                        foreach ($usuarios->result() as $fila) {
                            echo "<tr>";
                            echo "<td>".$fila->id_usuario."</td>";
                            echo "<td>".$fila->nr."</td>";
                            echo "<td>".$fila->nombre_completo."</td>";
                            if($fila->estado == 1){ 
                                echo "<td><div class='btn btn-rounded btn-sm btn-success' style='cursor:default;'><i class='ti-user'></i></div>"; 
                            }else{ 
                                echo "<td><div class='btn btn-rounded btn-sm btn-danger' style='cursor:default;'><i class='ti-user'></i></div>"; 
                            }

                            echo"</td>";
                           
                            $array = array($fila->id_usuario, $fila->nombre_completo, $fila->nr, $fila->sexo, $fila->usuario, $fila->id_seccion, $fila->estado);
                            echo boton_tabla($array,"cambiar_editar");
                            echo "</tr>";
                        }
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>