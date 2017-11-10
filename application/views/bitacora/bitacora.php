
<script type="text/javascript">
    function iniciar(){
        
    }
</script>

<!-- ============================================================== -->
<!-- Inicio de DIV de inicio (ENVOLTURA) -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- TITULO de la página de sección -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="align-self-center" align="center">
                <h3 class="text-themecolor m-b-0 m-t-0">Bitácora</h3>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Fin TITULO de la página de sección -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Inicio del CUERPO DE LA SECCIÓN -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- ============================================================== -->
            <!-- Inicio de la TABLA -->
            <!-- ============================================================== -->
            <div class="col-lg-12" id="cnt-tabla">

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
			                    $bitacora = $this->db->get("sep_bitacora");
			                    if(!empty($bitacora)){
			                        foreach ($bitacora->result() as $fila) {
			                           echo "<tr>";
			                           echo "<td>".$fila->id_bitacora."</td>";
 										
 										//debe mostrar el nombre del usuario

			                           echo "<td>".$fila->descripcion."</td>";
			                           echo "<td>".$fila->fecha."</td>";
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

            </div>
            <!-- ============================================================== -->
            <!-- Fin de la TABLA -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- Fin CUERPO DE LA SECCIÓN -->
        <!-- ============================================================== -->
    </div> 
</div>
<!-- ============================================================== -->
<!-- Fin de DIV de inicio (ENVOLTURA) -->
<!-- ============================================================== -->
