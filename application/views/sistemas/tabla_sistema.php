<div class="card">
    <div class="card-header">
        <h4 class="card-title m-b-0">Listado de sistemas</h4>
    </div>
    <div class="card-body b-t"  style="padding-top: 7px;">
        <div class="pull-right">
            <button type="button" onclick="cambiar_nuevo();" class="btn waves-effect waves-light btn-success2"><span class="mdi mdi-plus"></span> Nuevo registro</button>
        </div>
        <div class="table-responsive">
            <table id="myTable" class="table table-hover product-overview">
                <thead class="bg-info text-white">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th style="min-width: 85px;">(*)</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $sistemas = $this->db->get("org_sistema");
                    if($sistemas->num_rows() > 0){
                        foreach ($sistemas->result() as $fila) {
                            echo "<tr>";
                            echo "<td>".$fila->id_sistema."</td>";
                            echo "<td>".$fila->nombre_sistema."</td>";
                            echo "<td>";
                            $array = array($fila->id_sistema, $fila->nombre_sistema);
                            array_push($array, "edit");
                            echo generar_boton($array,"cambiar_editar","btn-info","fa fa-wrench","Editar");
                            unset($array[endKey($array)]); //eliminar el ultimo elemento de un array
                            array_push($array, "delete");
                            echo generar_boton($array,"cambiar_editar","btn-danger","fa fa-close","Eliminar");
                            echo "</td>";

                            echo "</tr>";
                        }
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>