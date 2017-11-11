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
			                        <th>Descripcion</th>
			                        <th>Fecha</th>
			                        <th>Ip</th>
			                    </tr>
			                </thead>
			                <tbody>
			                <?php 
			                    $bitacora = $this->db->get("sep_bitacora");
			                    if(!empty($bitacora)){
			                        foreach ($bitacora->result() as $fila) {
			                           echo "<tr>";
			                           echo "<td>".$fila->id_bitacora."</td>";
 										
 										//debe mostrar el nombre del usuario

			                           echo "<td>".$fila->descripcion."</td>";
			                           echo "<td>".date('d/m/Y h:i:s', strtotime($fila->fecha))."</td>";
			                            echo "<td>".$fila->ip."</td>";
			                       
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