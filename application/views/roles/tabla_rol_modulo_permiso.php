<div class="card">
    <div class="card-header">
        <h4 class="card-title m-b-0">Listado de Permisos </h4>
    </div>
    <div class="card-body b-t"  style="padding-top: 7px;">
        <div class="pull-right">
            <button type="button" onclick="tablaroles();" class="btn waves-effect waves-light btn-success2"><span class="mdi mdi-chevron-left"></span> Regresar</button>
            <button type="button" onclick="cambiar_nuevo();" class="btn waves-effect waves-light btn-success2"><span class="mdi mdi-plus"></span> Nuevo registro</button>
        </div>
        <div class="table-responsive">
            <table id="myTable" class="table table-bordered">
                <?php
                         $this->db->where("id_rol",$roles);
                            $this->db->group_by('id_modulo'); 
                            $query = $this->db->get("org_rol_modulo_permiso");

                            $this->db->where("id_rol",$roles);
                            $query2 = $this->db->get("org_rol");
                            foreach ($query2->result() as $query2F) {}
                            echo "<td colspan='4'><b>"."Rol: ".$query2F->nombre_rol."</b></td>";
                    ?>
                <thead class="bg-info text-white">
                    <tr>
                        <th>#</th>
                        <th>Permiso</th>
                        <th>Estado</th>
                        <th>(*)</th>
                    </tr>
                </thead>
                <tbody>
                <?php 


                            foreach ($query->result() as $queryFila) {
                                echo "<tr>";
                                    $this->db->where("id_modulo",$queryFila->id_modulo);
                                    $queryMod = $this->db->get("org_modulo");
                                    foreach ($queryMod->result() as $queryModFila) {
                                        $this->db->where("id_sistema",$queryModFila->id_sistema);
                                        $querySis = $this->db->get("org_sistema");
                                        foreach ($querySis->result() as  $querySisF) {
                                            # code...
                                        }
                                        echo "<td colspan='4'><b>"."Sistema: ".$querySisF->nombre_sistema." <br>Módulo: ".$queryModFila->nombre_modulo."</b></td>";

                                       
                                    }
                                 echo "</tr>";
                                 
                                        $this->db->where("id_rol",$roles);
                                        $this->db->where("id_modulo",$queryFila->id_modulo);
                                        $queryrolMod = $this->db->get("org_rol_modulo_permiso");
                                        foreach ($queryrolMod->result() as $queryrolModFila) {
                                            echo "<tr>";
                                            echo "<td>".$queryrolModFila->id_rol_permiso."</td>";
                                            
                                            $this->db->where("id_permiso",$queryrolModFila->id_permiso);
                                            $queryP = $this->db->get("org_permiso");
                                            foreach ($queryP->result() as $queryPFila) {
                                                echo "<td>".$queryPFila->permiso."</td>";
                                            }
                                           
                                            
                                            if($queryrolModFila->estado=="1"){
                                                echo "<td>Activado</td>";
                                            }else{
                                                 echo "<td>Desactivado</td>";
                                            }
                                            $array= array($queryrolModFila->id_rol_permiso,$querySisF->id_sistema,$queryModFila->id_modulo,$queryPFila->id_permiso,$queryrolModFila->estado);
                                            echo boton_tabla($array,"cambiar_editar");
                                            echo "</tr>";
                                        }
                                 
                            }
                           

                            
                           //$array = array($fila->id_rol_permiso,$fila->id_rol,$queryFilaMod->id_sistema, $fila->id_modulo, $fila->id_permiso,$fila->estado);
                           //echo boton_tabla($array,"cambiar_editar");
                           
                        
                    
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