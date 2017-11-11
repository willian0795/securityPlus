
<script type="text/javascript">
    function iniciar(){
    	tabla_bitacora();  
    }

    function tabla_bitacora(){  
        var usuario = $("#usuario").val();  
        var accion = $("#accion").val();  
        var sistema = $("#sistema").val(); 
        
        $("#cnt-tabla").load("<?php echo site_url(); ?>/bitacora/bitacora/tabla_bitacora?id_sistema="+sistema+"&id_accion="+accion+"&id_usuario="+usuario);
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
        
          
         
            <div class="col-lg-4" >
<div class="card">
                <div class="row">
                        <div class="form-group col-lg-12">                            
                            <select id="sistema" name="sistema" class="select2" onchange="tabla_bitacora()" style="width: 100%">
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

<br>

                    <div class="row">
                        <div class="form-group col-lg-12">                            
                            <select id="usuario" name="usuario" class="select2" onchange="tabla_bitacora()" style="width: 100%">
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

<br>
                    <div class="row">
                        <div class="form-group col-lg-12">                            
                            <select id="accion" name="accion" class="select2" onchange="tabla_bitacora()" style="width: 100%">
                                <option value="0">[Elija la acción]</option>
                                <?php 
                                    $accion = $this->db->get("sep_accion_bitacora");
                                    if($accion->num_rows() > 0){
                                        foreach ($accion->result() as $fila3) {              
                                           echo '<option class="m-l-50" value="'.$fila3->id_accion.'">'.$fila3->accion.'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

           
     </div>        
</div>

            <div class="col-lg-8" id="cnt-tabla">


            </div>
            <!-- ============================================================== -->
            <!-- Fin de la TABLA -->
            <!-- ============================================================== -->
        </div>
        </div>
        <!-- ============================================================== -->
        <!-- Fin CUERPO DE LA SECCIÓN -->
        <!-- ============================================================== -->
    </div> 
</div>
<!-- ============================================================== -->
<!-- Fin de DIV de inicio (ENVOLTURA) -->
<!-- ============================================================== -->
