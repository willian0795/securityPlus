<script type="text/javascript">
    function cambiar_editar(id,nombre_completo,nr,sexo,usuario,seccion,estado){

        $("#id_empleado").parent().parent().hide(0);
        $("#idusuario").val(id);
        $("#nr").val(nr);
        $("#nombre").val(nombre_completo);
        $("#apellido").val(nombre_completo);
        $("#nombre_completo").val(nombre_completo);
        $("#genero"+sexo).attr('checked', true);
        $("#usuario").val(usuario);
        if(estado == 1){
            $("#estado :checkbox").attr('checked',true);
        }else{
            $("#estado :checkbox").attr('checked',false);
        }

        $("#nombre0").hide(0);
        $("#nombre1").show(0);

        $("#ttl_form").removeClass("bg-success");
        $("#ttl_form").addClass("bg-info");

        $("#btnadd").hide(0);
        $("#btnedit").show(0);

        $("#cnt-tabla").hide(0);
        $("#cnt_form").show(0);

        $("#ttl_form").children("h4").html("<span class='fa fa-wrench'></span> Editar usuario");
    }

    function cambiar_nuevo(){
        $("#id_empleado").parent().parent().show(0);
        $("#idusuario").val("");
        $("#nr").val("");
        $("#nombre_completo").val("");
        $("#usuario").val("");
        $("#estado :checkbox").attr('checked',true);
        $("#band").val("save");

        $("#ttl_form").addClass("bg-success");
        $("#ttl_form").removeClass("bg-info");

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

    function editar_usuario(obj){
        $("#band").val("edit");
        $("#submit").click();
    }

    function eliminar_usuario(obj){
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
        $("#cnt-tabla").load("<?php echo site_url(); ?>/usuarios/usuarios/tabla_usuario");
    }

    function formusuario(){  
        id_empleado = $("#id_empleado").val();    
        $("#empleado"+id_empleado).click();

        if($("#id_empleado").val() == 0){
            $("#nombre0").show(0);
            $("#nombre1").hide(0);
             $("#nr").val("");
             $("#usuario").val("");
        }else{
            $("#nombre1").hide(0);
            $("#nombre0").hide(0);
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
        $("#nombre_completo").val(nombre+"."+apellido);
    }

    function cambiar_idgenero(){
    	$("#id_genero").val($('input:radio[name=genero]:checked').val());
    }

    function mostrar(id_empleado, nr, usuario, id_genero, nombre){
        $("#nombre_completo").val(nombre)
        $("#nr").val(nr);
        $("#usuario").val(usuario);
        $("#genero"+id_genero).attr('checked', true);
    }

    function cambiar_check(obj){
        if( $(obj).prop('checked') ) {
            $(obj).val('1')
        }else{
            $(obj).val('0')
        }
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
                                            $empleado = $this->db->query("SELECT id_empleado, LOWER(CONCAT_WS(' ', primer_nombre, segundo_nombre, tercer_nombre, primer_apellido, segundo_apellido, apellido_casada)) AS nombre_completo,  LOWER(CONCAT_WS(' ', primer_nombre, segundo_nombre, tercer_nombre)) AS nombre, LOWER(CONCAT_WS(' ', primer_apellido, segundo_apellido, apellido_casada)) AS apellido, LOWER(CONCAT_WS('.',primer_nombre, primer_apellido)) AS usuario, nr, id_genero FROM sir_empleado");
                                            if($empleado->num_rows() > 0){
                                                foreach ($empleado->result() as $fila) {              
                                                   echo '<option class="m-l-50" value="'.$fila->id_empleado.'">'.$fila->nombre_completo.'</option>';
                                                   ?>
                                                   <optgroup id="empleado<?php echo $fila->id_empleado; ?>" type="button" onclick="mostrar('<?php echo $fila->id_empleado; ?>','<?php echo $fila->nr; ?>','<?php echo $fila->usuario; ?>','<?php echo $fila->id_genero; ?>','<?php echo $fila->nombre_completo; ?>')"></optgroup>
                                                   <?php
                                                }
                                            }
                                        ?>

                                        
                                    </select>
                                </div>
                            </div>

                            <div class="row" style="display: none;">
                            	<div class="form-group col-lg-6">
                                    <h5>NR: <span class="text-danger">*</span></h5>
                                    <div class="input-group">
                                        <input type="text" id="nr" name="nr" class="form-control">
                                    </div>
                                    <div class="help-block"></div>
                                </div>
                            </div>
                            <div class="row" id="nombre0">
                                <div class="form-group col-lg-6">
                                    <h5>Nombre: <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" onkeyup="formar_usuario();" id="nombre" name="nombre" class="form-control" placeholder="Ingrese el nombre">
                                        <div class="help-block"></div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <h5>Apellido: <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" onkeyup="formar_usuario();" id="apellido" name="apellido" class="form-control" placeholder="Ingrese el apellido">
                                        <div class="help-block"></div>
                                    </div>
                                </div>
                            </div> 

                            <div class="row" id="nombre1" style="display: none;">
                                <div class="form-group col-lg-12">
                                    <h5>Nombre completo: <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" id="nombre_completo" name="nombre_completo" class="form-control" required="" placeholder="Ingrese el nombre completo" minlength="3" data-validation-required-message="Este campo es requerido">
                                        <div class="help-block"></div>
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
						                        	echo '<input name="genero" type="radio" id="genero'.strtolower($fila->id_genero).'" value="'.strtolower($fila->id_genero).'" required>';
						                        	echo '<label class="m-l-20" for="genero'.strtolower($fila->id_genero).'">'.ucfirst(strtolower($fila->genero)).'</label>';
						                        }
						                    }
	                                	?>
                                    </fieldset>
                                </div> 
                                <div class="form-group col-lg-6">
                                    <h5>Usuario: <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" id="usuario" name="usuario" class="form-control" required="" placeholder="Nombre de usuario" minlength="3" readonly>
                                        <div class="help-block"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                            	<div class="form-group col-lg-6">
                                    <h5>Contraseña <span class="text-danger">*</span></h5>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" class="form-control" required data-validation-required-message="Este campo es requerido">
                                        <div class="input-group-addon" id="pwd1" onmousedown="show_contra('password')" onmouseup="hide_contra('password')" style="cursor: pointer;"><i class="mdi mdi-looks"></i></div>
                                    </div>
                                    <div class="help-block"></div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <h5>Confirmar contraseña <span class="text-danger">*</span></h5>
                                    <div class="input-group">
                                        <input type="password" name="password2" id="password2" data-validation-match-match="password" class="form-control" required>
                                        <div class="input-group-addon" id="pwd2" onmousedown="show_contra('password2')" onmouseup="hide_contra('password2')" style="cursor: pointer;"><i class="mdi mdi-looks"></i></div> 
                                    </div>
                                    <div class="help-block"></div>
                                </div>
                            </div>      

                            <div class="row">
                            	<div class="form-group col-lg-6">
                            	</div>
                            	<div align="right" class="form-group col-lg-6">
                                    <div class="checkbox checkbox-success">
                                        <input id="estado" name="estado" type="checkbox" value="1" checked onchange="cambiar_check(this)">
                                        <label for="estado"> Cuenta activa </label>
                                    </div>
                                </div>
                            </div>                              


                            <button id="submit" type="submit" style="display: none;"></button>
                            <div align="right" id="btnadd">
                                <button type="submit" class="btn waves-effect waves-light btn-success2"><i class="mdi mdi-plus"></i> Guardar</button>
                            </div>
                            <div align="right" id="btnedit" style="display: none;">
                                <button type="button" onclick="editar_usuario(this)" class="btn waves-effect waves-light btn-info"><i class="mdi mdi-pencil"></i> Editar</button>
                                <button type="button" onclick="eliminar_usuario(this)" class="btn waves-effect waves-light btn-danger"><i class="mdi mdi-window-close"></i> Eliminar</button>
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
            url: "<?php echo site_url(); ?>/usuarios/usuarios/gestionar_usuarios",
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        })
        .done(function(res){
        	alert(res)
            if(res == "exito"){
                cerrar_mantenimiento();
                if($("#band").val() == "save"){
                    swal({ title: "¡Registro exitoso!", type: "success", showConfirmButton: true });
                }else if($("#band").val() == "edit"){
                    swal({ title: "¡Modificación exitosa!", type: "success", showConfirmButton: true });
                }else{
                    swal({ title: "¡Borrado exitoso!", type: "success", showConfirmButton: true });
                }
                tablausuarios();
            }else{
                swal({ title: "¡Ups! Error", text: "Intentalo nuevamente.", type: "error", showConfirmButton: true });
            }
        });
            
    });

});

</script>