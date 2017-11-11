
 <div class="card">
			    <div class="card-header">
			        <h4 class="card-title m-b-0">Listado de sistemas</h4>
			    </div>
			    <div class="card-body b-t"  style="padding-top: 7px;">
			       
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
			                function cambiar($variable){
			                	if($variable == 0){
			                		$variable = "vacio";
			                	}
			                	return $variable;
			                }		
			                	                
			                $array = array('id_sistema' => cambiar($_GET["id_sistema"]), 'id_usuario' => cambiar($_GET["id_usuario"]), 'id_accion' => cambiar($_GET["id_accion"]));
			                $conta = 1;
			                $var = "";
			                while ($otro = current($array)) {
			                	if($otro != "vacio"){
			                	
			                		if($conta == 1){
			                			$var = " WHERE ".key($array)." = ".$otro;
			                		}else{
			                			$var .= " AND ".key($array)." = ".$otro;
			                		}
			                		$conta++;
			                	}
			                
			                	next($array);
			                }

			               
			                    $bitacora = $this->db->query("SELECT * FROM sep_bitacora $var");
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