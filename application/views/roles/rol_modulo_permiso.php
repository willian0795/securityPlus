 <style>

      html, body {
        height: 100%;
        margin: 0;
        padding: 0;

      }

      @media screen and (max-width: 770px) {
        .otro {
            height: 500px;
        }
      }

      #divider {
          height: 89%;
      }

      #map {
        height: 100%;
      }

      #output {
        font-size: 14px;
      }
    </style>
<script type="text/javascript">
    function cambiar_editar(id_rol,nombre_rol,descripcion_rol){
         $("#id_rol").val(id_rol);
         $("#nombre_rol").val(nombre_rol);
         $("#descripcion_rol").val(descripcion_rol);
         

        $("#ttl_form").removeClass("bg-success");
        $("#ttl_form").addClass("bg-info");

        $("#btnadd").hide(0);
        $("#btnedit").show(0);

        $("#cnt-tabla").hide(0);
        $("#cnt_form").show(0);
        $("#ttl_form").children("h4").html("<span class='fa fa-wrench'></span> Editar Rol");
    }

    function cambiar_nuevo(){
        $("#nombre_rol").val("");
         $("#descripcion_rol").val("");
         
        $("#band").val("save");

        $("#ttl_form").addClass("bg-success");
        $("#ttl_form").removeClass("bg-info");

        $("#btnadd").show(0);
        $("#btnedit").hide(0);

        $("#cnt-tabla").hide(0);
        $("#cnt_form").show(0);

        $("#ttl_form").children("h4").html("<span class='mdi mdi-plus'></span> Nuevo Permiso Rol");
    }


    function cerrar_mantenimiento(){
        $("#nombre_rol").val("");
        $("#descripcion_rol").val("");

        $("#cnt-tabla").show(0);
        $("#cnt_form").hide(0);
    }

    function editar_rol(obj){
        $("#band").val("edit");
        $("#submit").click();
    }

    function eliminar_rol(obj){
        $("#band").val("delete");
        swal({
            title: "¿Está seguro?",
            text: "¡Desea eliminar el registro!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#fc4b6c",
            confirmButtonText: "Sí, deseo eliminar!",
            closeOnConfirm: false
        }, function(){
            $("#submit").click();
        });
    }

    function iniciar(){
        tablaroles();
    }

    function objetoAjax(){
        var xmlhttp = false;
        try {
            xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try { xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); } catch (E) { xmlhttp = false; }
        }
        if (!xmlhttp && typeof XMLHttpRequest!='undefined') { xmlhttp = new XMLHttpRequest(); }
        return xmlhttp;
    }

    function tablaroles(){
        if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttpB=new XMLHttpRequest();
        }else{// code for IE6, IE5
            xmlhttpB=new ActiveXObject("Microsoft.XMLHTTPB");
        }

        xmlhttpB.onreadystatechange=function(){
            if (xmlhttpB.readyState==4 && xmlhttpB.status==200){
                  document.getElementById("cnt-tabla").innerHTML=xmlhttpB.responseText;
                  $('#myTable').DataTable();
            }
        }

        xmlhttpB.open("GET","<?php echo site_url(); ?>/roles/tabla_rol_modulo_permiso",true);
        xmlhttpB.send();
    }
    function comboModulo(id_sistema){
        if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttpM=new XMLHttpRequest();
        }else{// code for IE6, IE5
            xmlhttpM=new ActiveXObject("Microsoft.XMLHTTPB");
        }

        xmlhttpM.onreadystatechange=function(){
            if (xmlhttpM.readyState==4 && xmlhttpM.status==200){
                  document.getElementById("cnt-modulo").innerHTML=xmlhttpM.responseText;
                 // $('#myTable').DataTable();
            }
        }

        xmlhttpM.open("GET","<?php echo site_url(); ?>/roles/rol_modulo_permiso/buscarModulo/"+id_sistema,true);
        xmlhttpM.send();
    }
    
</script>

<!-- ============================================================== -->
<!-- Inicio de DIV de inicio (ENVOLTURA) -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <div class="container-fluid">
        <button id="notificacion" style="display: none;" class="tst1 btn btn-success2">Info Message</button>
        <!-- ============================================================== -->
        <!-- TITULO de la página de sección -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="align-self-center" align="center">
                <h3 class="text-themecolor m-b-0 m-t-0">Gestión de Roles del MTPS</h3>
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
            <!-- Inicio del FORMULARIO de gestión -->
            <!-- ============================================================== -->
            <div class="col-lg-1"></div>
            <div class="col-lg-10" id="cnt_form" style="display: none;">
                <div class="card">
                    <div class="card-header bg-success2" id="ttl_form">
                        <div class="card-actions text-white">
                            <a style="font-size: 16px;" onclick="cerrar_mantenimiento();"><i class="mdi mdi-window-close"></i></a>
                        </div>
                        <h4 class="card-title m-b-0 text-white">Listado de Roles</h4>
                    </div>
                    <div class="card-body b-t">

                        <?php echo form_open('', array('id' => 'formajax', 'style' => 'margin-top: 0px;', 'class' => 'm-t-40', 'novalidate' => '')); ?>
                            <input type="hidden" id="band" name="band" value="save">
                            <input type="hidden" id="id_rol" name="id_rol">
                            


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre_rol" class="font-weight-bold">Seleccione el Rol: <span class="text-danger">*</span></label>
                                           <?php  echo "<select class='form-control' name='id' id='id'>";
                                                    echo "<option value=''>[Seleccione]</option>";
                                                    foreach ($rol as $list) {
                                                        echo "<option value='". $list['id_rol'] . "'>" . $list['nombre_rol'] . "</option>";
                                                    }
                                                echo "</select><br/>"; 
                                            ?>
                                       <div class="help-block"></div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="descripcion_rol" class="font-weight-bold">Seleccione el sistema :<span class="text-danger">*</span></label>
                                        <?php  echo "<select class='form-control' name='id' id='id'>";
                                                    echo "<option value=''>[Seleccione]</option>";
                                                    foreach ($sistema as $list) {
                                                        echo "<option value='". $list['id_sistema'] . "' onclick='comboModulo(".$list['id_sistema'].")'>" . $list['nombre_sistema'] . "</option>";
                                                    }
                                                echo "</select><br/>"; 
                                            ?>
                                        <div class="help-block"></div> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" id="cnt-modulo">
                                        <label for="nombre_rol" class="font-weight-bold">Seleccione el modulo: <span class="text-danger">*</span></label>
                                           <?php  echo "<select class='form-control' name='id' id='id'>";
                                                    echo "<option value=''>[Seleccione]</option>";
                                                    foreach ($modulo as $list) {
                                                        echo "<option value='". $list['id_modulo'] . "'>" . $list['nombre_modulo'] . "</option>";
                                                    }
                                                echo "</select><br/>"; 
                                            ?>
                                       <div class="help-block"></div>
                                    </div>

                                </div>
                            </div>
                            
                           

                            <button id="submit" type="submit" style="display: none;"></button>
                            <div align="right" id="btnadd">
                                <button type="reset" class="btn waves-effect waves-light btn-success"><i class="mdi mdi-delete"></i> Limpiar</button>
                                <button type="submit" class="btn waves-effect waves-light btn-success2"><i class="mdi mdi-plus"></i> Guardar</button>
                            </div>
                            <div align="right" id="btnedit" style="display: none;">
                                <button type="reset" class="btn waves-effect waves-light btn-success"><i class="mdi mdi-delete"></i> Limpiar</button>
                                <button type="button" onclick="editar_rol(this)" class="btn waves-effect waves-light btn-info"><i class="mdi mdi-pencil"></i> Editar</button>
                                <button type="button" onclick="eliminar_rol(this)" class="btn waves-effect waves-light btn-danger"><i class="mdi mdi-window-close"></i> Eliminar</button>
                            </div>

                        <?php echo form_close(); ?>
                    </div>

                </div>
            </div>
            <div class="col-lg-1"></div>
                <div class="col-lg-12" id="cnt-tabla">
            </div>

        </div>






    </div>
</div>

<script>

$(function(){
    $("#formajax").on("submit", function(e){
        e.preventDefault();
        var f = $(this);
        var formData = new FormData(document.getElementById("formajax"));
        formData.append("dato", "valor");

        $.ajax({
            url: "<?php echo site_url(); ?>/roles/roles/gestionar_rol",
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        })
        .done(function(res){
            if(res == "exito"){
                cerrar_mantenimiento();
                if($("#band").val() == "save"){
                    swal({ title: "¡Registro exitoso!", type: "success", showConfirmButton: true });
                }else if($("#band").val() == "edit"){
                    swal({ title: "¡Modificación exitosa!", type: "success", showConfirmButton: true });
                }else{
                    swal({ title: "¡Borrado exitoso!", type: "success", showConfirmButton: true });
                }
                tablaroles();$("#band").val('save');
            }else{
                swal({ title: "¡Ups! Error", text: "Intentalo nuevamente.", type: "error", showConfirmButton: true });
            }
        });

    });


    
});

</script>

