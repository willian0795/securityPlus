
                    <div class="row">
                        <div class="form-group col-lg-12">                            
                            <select id="sistema" name="sistema" class="select2" onchange="mostrarFormMenu()" style="width: 100%">
                                <option value="0">[Elija el sistema]</option>
                                <?php 
                                    $sistemas = $this->db->get("org_sistema");
                                    if($sistemas->num_rows() > 0){
                                        foreach ($sistemas->result() as $fila) {              
                                           echo '<option class="m-l-50" value="'.$fila->id_sistema.'">'.$fila->nombre_sistema.'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

//

                    <div class="row">
                        <div class="form-group col-lg-12">                            
                            <select id="usuario" name="usuario" class="select2" onchange="mostrarFormMenu()" style="width: 100%">
                                <option value="0">[Elija el usuario]</option>
                                <?php 
                                    $usuario = $this->db->get("org_usuario");
                                    if($usuario->num_rows() > 0){
                                        foreach ($usuario->result() as $fila2) {              
                                           echo '<option class="m-l-50" value="'.$fila2->id_usuario.'">'.$fila2->nombre_completo.'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>