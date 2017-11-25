<script type="text/javascript">
    function cambiar_editar(id,nombre,sexo,usuario,estado,bandera){

        $("#id_empleado").parent().parent().hide(0);
        $("#idusuario").val(id);        

        $("#form_nusuario").hide(0);
        $("#form_eusuario").show(0);

        if(estado == 1){
            document.getElementById("estado").checked = 1;
        }else{
            document.getElementById("estado").checked = 0;
        }
        cambiar_check("estado");

        $("#l_nombre").val(nombre);
        $("#usuario").val(usuario);
        $("#l_usuario").val(usuario);

        $("#password").val("");
        $("#password2").val("");

        if(bandera == "edit"){
            $("#cnt-tabla").hide(0);
            $("#cnt_form").show(0);
            $("#ttl_form").children("h4").html("<span class='fa fa-wrench'></span> Editar usuario");
            $("#ttl_form").removeClass("bg-success");
            $("#ttl_form").addClass("bg-info");
            $("#btnadd").hide(0);
            $("#btnedit").show(0);
            tablaroles();
        }else{
            eliminar_usuario();
        }
    }

    function cambiar_nuevo(){
        $("#id_empleado").parent().parent().show(0);
        $("#idusuario").val("");
        $("#usuario").val("");
        $("#password").val("");
        $("#password2").val("");
        document.getElementById("estado").checked = 1;
        cambiar_check("estado");
        $("#band").val("save");
        tablaroles();

        $("#ttl_form").addClass("bg-success");
        $("#ttl_form").removeClass("bg-info");

        $("#form_eusuario").hide(0);

        $("#btnadd").show(0);
        $("#btnedit").hide(0);

        $("#cnt-tabla").hide(0);
        $("#cnt_form").show(0);

        $("#ttl_form").children("h4").html("<span class='mdi mdi-plus'></span> Nuevo usuario");
    }

    function cerrar_mantenimiento(){
        $("#cnt-tabla").show(0);
        $("#cnt_form").hide(0);
    }

    function editar_usuario(){
        $("#band").val("edit");
        $("#submit").click();
    }

    function eliminar_usuario(){
        $("#password").val("ninguna");
        $("#password2").val("ninguna");
        $("#band").val("delete");
        var nombre = $("#l_usuario").val();
        swal({   
            title: "¿Está seguro?",   
            text: "¡Desea eliminar al usuario: << "+nombre+" >>!",   
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
        tablausuarios();        
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

    function tablausuarios(){        
        $("#cnt-tabla").load("<?php echo site_url(); ?>/usuarios/tabla_usuario", function() {
            $('[data-toggle="tooltip"]').tooltip();
            tablaroles();
        });
    }

    function tablaroles(){
        var user = $("#idusuario").val(); 
        $( "#tabla_roles" ).load("<?php echo site_url(); ?>/usuarios/tabla_roles?id_usuario="+user, function() {
            multi_select();
        });  
    }

    function multi_select(){
        $('#pre-selected-options').multiSelect();
        $('#optgroup').multiSelect({
            selectableOptgroup: true
        });
    }

    function formusuario(){  
        id_empleado = $("#id_empleado").val();    
        $("#empleado"+id_empleado).click();

        if($("#id_empleado").val() == 0){
            $("#form_nusuario").show(0);        
            $("#usuario").val("");
            document.getElementById("tipo_pass").checked = 0;
            cambiar_check2("tipo_pass");
            $("#div_tipo_pass").hide(0);
        }else{
            $("#form_nusuario").hide(0);
            $("#div_tipo_pass").show(0);
        }
    }

    function show_contra(id){
    	$("#"+id).attr("type","text");
    }

    function hide_contra(id){
    	$("#"+id).attr("type","password");
    }

    function formar_usuario(){
    	var nombre = $("#nombre").val().toLowerCase();
    	var apellido = $("#apellido").val().toLowerCase();

		var res1 = nombre.split(" ");
		var res2 = apellido.split(" ");

		nombre = res1[0];
		apellido = res2[0];

    	$("#usuario").val(nombre+"."+apellido);
        $("#nombre0").val("");
        $("#nombre1").val("");
    }

    function cambiar_idgenero(){
    	$("#id_genero").val($('input:radio[name=genero]:checked').val());
    }

    function mostrar(id_empleado, usuario, id_genero){
        $("#usuario").val(usuario);
        document.getElementById("genero"+id_genero).checked = 1;
    }

    function cambiar_check(obj){
        if( $("#"+obj).prop('checked') ) {
            $("#"+obj).val('1');
        }else{
            $("#"+obj).val('0');
        }
    }

    function cambiar_check2(obj){
        if( $("#"+obj).prop('checked') ) {
            $("#"+obj).val('1');
            $("#div_pass").hide(0);
        }else{
            $("#"+obj).val('0');
            $("#div_pass").show(0);
        }
    }

    function recorrer_roles(){
        var roles = $("#pre-selected-options").children("option");
        var usuario = $("#usuario").val();

        for(i=0; i<roles.length; i++){
            if($(roles[i]).is(':selected')){
                gestionar_roles($(roles[i]).val(),usuario,"insertar");
            }else{
                gestionar_roles($(roles[i]).val(),usuario,"eliminar");
            }
            
        }
    }

    function gestionar_roles(id_rol, usuario,band){       

        jugador = document.getElementById('jugador');
        
        ajax = objetoAjax();
        ajax.open("POST", "<?php echo site_url(); ?>/usuarios/gestionar_roles", true);
        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4){
                jugador.value = (ajax.responseText);
            }
        } 
        ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
        ajax.send("&id_rol="+id_rol+"&usuario="+usuario+"&bandera="+band)
    }

    function obtener_usuario(){       
        var id_empleado = $("#id_empleado").val();
        jugador = document.getElementById('jugador');
        
        ajax = objetoAjax();
        ajax.open("POST", "<?php echo site_url(); ?>/usuarios/obtener_usuario", true);
        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4){
                $("#usuario").val(ajax.responseText);
                recorrer_roles2();
            }
        } 
        ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
        ajax.send("&id_empleado="+id_empleado)
    }

    function recorrer_roles2(){
        var roles = $("#pre-selected-options").children("option");
        var usuario = $("#usuario").val();

        for(i=0; i<roles.length; i++){
            if($(roles[i]).is(':selected')){
                gestionar_roles($(roles[i]).val(),usuario,"insertar");
            }else{
                gestionar_roles($(roles[i]).val(),usuario,"eliminar");
            }
            
        }
        tablausuarios();
    }

</script>

<!-- ============================================================== -->
<!-- Inicio de DIV de inicio (ENVOLTURA) -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <div class="container-fluid">
        <input type="hidden" name="jugador" id="jugador">
        <!-- ============================================================== -->
        <!-- TITULO de la página de sección -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="align-self-center" align="center">
                <h3 class="text-themecolor m-b-0 m-t-0">Administración de usuarios</h3>
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
                        <h4 class="card-title m-b-0 text-white">Listado de usuarios</h4>
                    </div>
                    <div class="card-body b-t">
                        <div id="form_user"></div>
                        <?php echo form_open('', array('id' => 'formajax', 'style' => 'margin-top: 0px;', 'class' => 'm-t-40', 'novalidate' => '')); ?>
                            <input type="hidden" id="band" name="band" value="save">
                            <input type="hidden" id="idusuario" name="idusuario" value="">

                            <div class="row">
                                <div class="form-group col-lg-6"> 
                                    <h5>Empleado: <span class="text-danger">*</span></h5>                           
                                    <select id="id_empleado" name="id_empleado" class="select2" onchange="formusuario();" style="width: 100%">
                                        <option value="0">[Elija el empleado]</option>
                                        <?php 
                                            $empleado = $this->db->query("SELECT id_empleado, UPPER(CONCAT_WS(' ', primer_nombre, segundo_nombre, tercer_nombre, primer_apellido, segundo_apellido, apellido_casada)) AS nombre_completo FROM sir_empleado");
                                            if($empleado->num_rows() > 0){
                                                foreach ($empleado->result() as $fila) {              
                                                   echo '<option class="m-l-50" value="'.$fila->id_empleado.'">'.$fila->nombre_completo.'</option>';
                                                }
                                            }
                                        ?>

                                        
                                    </select>
                                </div>
                                <div class="form-group col-lg-6" style="display: block;" id="div_tipo_pass">
                                    <h5>¿Usuario sin contraseña?<span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <div class="switch">
                                            <label>Desactivado<input type="checkbox" value="0" onchange="cambiar_check2(this.id)" name="tipo_pass" id="tipo_pass"><span class="lever"></span>Activado</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="form_eusuario">
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <h5>Nombre: <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" id="l_nombre" name="l_nombre" class="form-control" readonly="">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <h5>Usuario: <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" id="l_usuario" name="l_usuario" class="form-control" readonly="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="form_nusuario">
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <h5>Nombre: <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" onkeyup="formar_usuario();" id="nombre" name="nombre" class="form-control" placeholder="Ingrese el nombre">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <h5>Apellido: <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" onkeyup="formar_usuario();" id="apellido" name="apellido" class="form-control" placeholder="Ingrese el apellido">
                                        </div>
                                    </div>
                                </div>                                                
                                <div class="row">
                                	<div class="form-group col-lg-6">
                                        <h5>Genero: <span class="text-danger">*</span></h5>
                                        <fieldset class="controls">
                                            <?php
    	                                		$genero = $this->db->get("org_genero");

    						                    if(!empty($genero)){
    						                        foreach ($genero->result() as $fila) {
    						                        	echo '<input name="genero" type="radio" id="genero'.strtolower($fila->id_genero).'" value="'.strtolower($fila->id_genero).'">';
    						                        	echo '<label class="m-l-20" for="genero'.strtolower($fila->id_genero).'">'.ucfirst(strtolower($fila->genero)).'</label>';
    						                        }
    						                    }
    	                                	?>
                                        </fieldset>
                                    </div> 
                                    <div class="form-group col-lg-6">
                                        <h5>Usuario: <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Nombre de usuario" minlength="3" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="div_pass">
                            	<div class="form-group col-lg-6">
                                    <h5>Contraseña <span class="text-danger">*</span></h5>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" class="form-control">
                                        <div class="input-group-addon" id="pwd1" onmousedown="show_contra('password')" onmouseup="hide_contra('password')" style="cursor: pointer;"><i class="mdi mdi-looks"></i></div>
                                    </div>
                                    <div class="help-block"></div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <h5>Confirmar contraseña <span class="text-danger">*</span></h5>
                                    <div class="input-group">
                                        <input type="password" name="password2" id="password2" class="form-control">
                                        <div class="input-group-addon" id="pwd2" onmousedown="show_contra('password2')" onmouseup="hide_contra('password2')" style="cursor: pointer;"><i class="mdi mdi-looks"></i></div> 
                                    </div>
                                    <div class="help-block"></div>
                                </div>
                            </div>      

                            <div class="row" style="display: block;">
                                <div class="form-group col-lg-6">
                                </div>
                                <div align="right" class="form-group col-lg-6">
                                    <h5>Estado de la cuenta: <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" value="0" onchange="cambiar_check(this.id)" name="estado" id="estado" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Cuenta activa?</span> </label>
                                    <div class="help-block"></div></div>
                                </div>
                            </div>                              

                            <div id="tabla_roles">
                                
                            </div>

                            <button id="submit" type="submit" style="display: none;"></button>
                            <div align="right" id="btnadd">
                                <button type="input" class="btn waves-effect waves-light btn-success2"><i class="mdi mdi-plus"></i> Guardar</button>
                            </div>
                            <div align="right" id="btnedit" style="display: none;">
                                <button type="button" onclick="editar_usuario()" class="btn waves-effect waves-light btn-info"><i class="mdi mdi-pencil"></i> Editar</button>
                                <button type="button" onclick="eliminar_usuario()" class="btn waves-effect waves-light btn-danger"><i class="mdi mdi-window-close"></i> Eliminar</button>
                            </div>

                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-1"></div>
            <!-- ============================================================== -->
            <!-- Fin del FORMULARIO de gestión -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Inicio de la TABLA -->
            <!-- ============================================================== -->
            <div class="col-lg-12" id="cnt-tabla">

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
<script>

$(function(){     
    $("#formajax").on("submit", function(e){
        e.preventDefault();
        var f = $(this);
        var formData = new FormData(document.getElementById("formajax"));
        formData.append("dato", "valor");

        $.ajax({
            url: "<?php echo site_url(); ?>/usuarios/gestionar_usuarios",
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
                    obtener_usuario();
                }else if($("#band").val() == "edit"){
                    swal({ title: "¡Modificación exitosa!", type: "success", showConfirmButton: true });
                    recorrer_roles();
                }else{
                    swal({ title: "¡Borrado exitoso!", type: "success", showConfirmButton: true });
                    tablausuarios();
                }
            }else if(res == "existe"){
                swal({ title: "¡Ya existe!", text: "El usuario ya posee una cuenta", type: "warning", showConfirmButton: true });
            }else{
                swal({ title: "¡Ups! Error", text: "Intentalo nuevamente.", type: "error", showConfirmButton: true });
            }
        });
            
    });

});

</script>