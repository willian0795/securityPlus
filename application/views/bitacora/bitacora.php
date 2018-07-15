<?php
    $mantenimiento = false;
    if($mantenimiento){
        header("Location: ".site_url()."/mantenimiento");
        exit();
    }

    $user = $this->session->userdata('usuario');
    $nr = $this->db->query("SELECT * FROM org_usuario WHERE usuario = '".$user."' LIMIT 1");
    $nr_usuario = "";
    if($nr->num_rows() > 0){
        foreach ($nr->result() as $fila) { 
            $nr_usuario = $fila->nr; 
        }
    }
?>
<script type="text/javascript">
    function iniciar(){
    	tabla_bitacora();  
    }

    function tabla_bitacora(){  
        var usuario = $("#usuario").val();  
        var accion = $("#accion").val();  
        var sistema = $("#sistema").val(); 

        if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttpB=new XMLHttpRequest();
        }else{// code for IE6, IE5
            xmlhttpB=new ActiveXObject("Microsoft.XMLHTTPB");
        }
        xmlhttpB.onreadystatechange=function(){
            if (xmlhttpB.readyState==4 && xmlhttpB.status==200){
                  document.getElementById("cnt-tabla").innerHTML=xmlhttpB.responseText;
                  $('#myTable').DataTable({"order": [[ 0, "desc" ]]});
            }
        }
        xmlhttpB.open("GET","<?php echo site_url(); ?>/bitacora/bitacora/tabla_bitacora?id_sistema="+sistema+"&id_accion="+accion+"&id_usuario="+usuario,true);
        xmlhttpB.send();
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

            <div class="col-lg-12">
                <div class="card">
                <div class="card-header">
                    <h4 class="card-title m-b-0">Listado de sistemas</h4>
                </div>
                <div class="card-body b-t"  style="padding-top: 7px;">
                    <div class="row">
                        <div class="form-group col-lg-5">
                            <h5>Sistema:</h5>                         
                            <select id="sistema" name="sistema" class="select2" onchange="tabla_bitacora()" style="width: 100%">
                                <option value="0">[Elija el sistema]</option>
                                <?php 
                                    $sistemas = $this->db->get("org_sistema");
                                    if($sistemas->num_rows() > 0){
                                        foreach ($sistemas->result() as $fila) {
                                            if($fila->id_sistema == "14"){
                                                echo '<option class="m-l-50" value="'.$fila->id_sistema.'" selected>'.$fila->nombre_sistema.'</option>';
                                            }else{
                                                echo '<option class="m-l-50" value="'.$fila->id_sistema.'">'.$fila->nombre_sistema.'</option>';
                                            }          
                                        }
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="form-group col-lg-4">
                            <h5>Usuario:</h5>                             
                            <select id="usuario" name="usuario" class="select2" onchange="tabla_bitacora()" style="width: 100%">
                                <option value="0">[Elija el usuario]</option>
                                <?php 
                                    $usuario = $this->db->get("org_usuario");
                                    if($usuario->num_rows() > 0){
                                        foreach ($usuario->result() as $fila2) {              
                                            if($fila2->nr == $nr_usuario){
                                                echo '<option class="m-l-50" value="'.$fila2->id_usuario.'" selected>'.$fila2->nombre_completo.'</option>';
                                            }else{
                                                echo '<option class="m-l-50" value="'.$fila2->id_usuario.'">'.$fila2->nombre_completo.'</option>';
                                            }   
                                        }
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="form-group col-lg-3">
                            <h5>Acción:</h5>                          
                            <select id="accion" name="accion" class="select2" onchange="tabla_bitacora()" style="width: 100%">
                                <option value="0">[Elija la acción]</option>
                                <?php 
                                    $accion = $this->db->get("glb_accion_bitacora");
                                    if($accion->num_rows() > 0){
                                        foreach ($accion->result() as $fila3) {              
                                           echo '<option class="m-l-50" value="'.$fila3->id_accion.'">'.$fila3->accion.'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                   
                    <div id="cnt-tabla"></div>
                    
                </div>
            </div>


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
