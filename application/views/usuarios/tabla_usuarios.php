<div class="card">
	<div class="card-header">
        <h4 class="card-title m-b-0">Listado de usuarios</h4>
    </div>
    <div class="card-body b-t" style="padding-top: 7px;">
        <div class="pull-right">
            <button type="button" onclick="cambiar_nuevo();" class="btn btn-rounded btn-success2"><span class="mdi mdi-plus"></span> Nuevo registro</button>
        </div>
        <div class="table-responsive">
            <table id="myTable" class="table table-hover product-overview">
                <thead class="bg-info text-white">
                    <tr>                        
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Estado</th>
                        <th style="min-width: 85px;">(*)</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $this->db->order_by("nombre_completo", "asc");
                    $usuarios = $this->db->get("org_usuario");

                    if(!empty($usuarios)){
                        foreach ($usuarios->result() as $fila) {
                            echo "<tr>";
                            echo "<td>".$fila->nombre_completo."</td>";
                            echo "<td>".$fila->usuario."</td>";
                            if($fila->estado == 1){ 
                                echo '<td><span class="label label-success">Activo</span></div>'; 
                            }else{ 
                                echo '<td><span class="label label-danger">Inactivo</span></div>'; 
                            }

                            echo"</td>";
                           
                            $array = array($fila->id_usuario, $fila->nombre_completo, $fila->sexo, $fila->usuario, $fila->estado);
                            echo boton_tabla2($array,"cambiar_editar","cambiar_eliminar");
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