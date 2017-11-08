<div class="card">
    <div class="card-header">
        <h4 class="card-title m-b-0">Listado de sistemas</h4>
    </div>
    <div class="card-body b-t"  style="padding-top: 7px;">
        <div class="pull-right">
            <button type="button" onclick="cambiar_nuevo();" class="btn waves-effect waves-light btn-success2"><span class="mdi mdi-plus"></span> Nuevo registro</button>
        </div>
        <div class="table-responsive">
            <table id="myTable" class="table table-bordered">
                <thead class="bg-info text-white">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Base URL</th>
                        <th>(*)</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $sistemas = $this->db->get("org_sistema");
                    if(!empty($sistemas)){
                        foreach ($sistemas->result() as $fila) {
                           echo "<tr>";
                           echo "<td>".$fila->id_sistema."</td>";
                           echo "<td>".$fila->nombre_sistema."</td>";
                           echo "<td>".$fila->base_url."</td>";
                           
                           $array = array($fila->id_sistema, $fila->nombre_sistema, $fila->base_url);
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
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>