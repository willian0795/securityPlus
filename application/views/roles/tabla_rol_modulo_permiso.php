<div class="card">
    <div class="card-header">
        <h4 class="card-title m-b-0">Listado de Roles</h4>
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
                        <th>Rol</th>
                        <th>Modulo</th>
                        <th>Permiso</th>
                        <th>Estado</th>
                        <th>(*)</th>
                    </tr>
                </thead>
                <tbody>
                <?php 

                    if(!empty($roles)){
                        foreach ($roles->result() as $fila) {
                           echo "<tr>";
                            echo "<td>".$fila->id_rol_permiso."</td>";

                            $this->db->where("id_rol",$fila->id_rol);
                            $queryRol = $this->db->get("org_rol");
                            foreach ($queryRol->result() as $queryFilaRol) {}
                           echo "<td>".$queryFilaRol->nombre_rol."</td>";

                           $this->db->where("id_modulo",$fila->id_modulo);
                            $queryMod = $this->db->get("org_modulo");
                            foreach ($queryMod->result() as $queryFilaMod) {}
                           echo "<td>".$queryFilaMod->nombre_modulo."</td>";


                           $this->db->where("id_permiso",$fila->id_permiso);
                            $queryPer = $this->db->get("org_permiso");
                            foreach ($queryPer->result() as $queryFilaPer) {}
                           echo "<td>".$queryFilaPer->permiso."</td>";

                            if($fila->estado=="1"){
                                echo "<td>Activado</td>";
                            }else{
                                echo "<td>Desactivado</td>";
                            }
                            
                           $array = array($fila->id_rol_permiso,$fila->id_rol,$queryFilaMod->id_sistema, $fila->id_modulo, $fila->id_permiso,$fila->estado);
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