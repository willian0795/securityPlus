<div class="card">
    <div class="card-header">
        <h4 class="card-title m-b-0">Listado de Roles asginados</h4>
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
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>(*)</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    
                    if(!empty($rolesasignados)){
                        foreach ($rolesasignados->result() as $fila) {
                           echo "<tr>";

                            
                           echo "<td>".$fila->id_usuario_rol."</td>";

                           $this->db->where("id_usuario",$fila->id_usuario);
                           $queryUsu = $this->db->get("org_usuario");
                           if(is_null($queryUsu)){
                            echo "--";
                           }else{
                                foreach ($queryUsu->result() as $queryFilaUsu) {
                                    echo "<td>".$queryFilaUsu->nombre_completo."</td>";
                                }
                            }
                            $this->db->where("id_rol",$fila->id_rol);
                            $queryRol = $this->db->get("org_rol");
                          
                                foreach ($queryRol->result() as $queryFilaRol) {
                                    echo "<td>".$queryFilaRol->nombre_rol."</td>";
                                }
                         
                           
                           
                           
                           $array = array($fila->id_usuario_rol, $fila->id_usuario, $fila->id_rol);
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