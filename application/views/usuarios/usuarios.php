<script type="text/javascript">
    function cambiar_editar(id,nombre_completo,nr,sexo,usuario,seccion,estado){
        $("#idusuario").val(id);
        //$("#descripcion").val(descripcion);
        $("#nr").val(nr);
        $("#sexo").val(sexo);
        $("#usuario").val(usuario);
        $("#seccion").val(seccion);
        $("#estado :checkbox").attr('checked',estado);

        $("#ttl_form").removeClass("bg-success");
        $("#ttl_form").addClass("bg-info");

        $("#btnadd").hide(0);
        $("#btnedit").show(0);

        $("#cnt-tabla").hide(0);
        $("#cnt_form").show(0);

        $("#ttl_form").children("h4").html("<span class='fa fa-wrench'></span> Editar usuario");
    }

    function cambiar_nuevo(){
        $("#idhorario").val("");
        $("#descripcion").val("");
        $("#hora_inicio").val("");
        $("#hora_fin").val("");
        $("#monto").val("");
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

    function editar_horario(obj){
        $("#band").val("edit");
        $("#submit").click();
    }

    function eliminar_horario(obj){
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
        $("#cnt-tabla").load("<?php echo site_url(); ?>/usuarios/tablausuarios");
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
        $("#cnt-tabla").load("<?php echo site_url(); ?>/usuarios/tablausuarios");
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
    }

    function cambiar_idgenero(){
    	$("#id_genero").val($('input:radio[name=genero]:checked').val());
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
                        
                        <?php echo form_open('', array('id' => 'formajax', 'style' => 'margin-top: 0px;', 'class' => 'm-t-40', 'novalidate' => '')); ?>
                            <input type="hidden" id="band" name="band" value="save">
                            <input type="hidden" id="idusuario" name="idusuario" value="">
                            <div class="row">
                            	<div class="form-group col-lg-6">
                                    <h5>NR: <span class="text-danger">*</span></h5>
                                    <div class="input-group">
                                        <input type="text" id="nr" name="nr" class="form-control" data-mask="999*" required placeholder="Código de empleado" data-validation-required-message="Este campo es requerido">
                                        <div class="input-group-addon" onclick="cargar_datos(this.value);" style="cursor: pointer;"><i class="mdi mdi-upload"></i></div>
                                    </div>
                                    <div class="help-block"></div>
                                </div>
                            	<div class="form-group col-lg-6">
                                    <h5>Sección: <span class="text-danger">*</span></h5>
                                    <select id="seccion" name="seccion" class="select2" style="width: 100%">
                                        <option>Select</option>
                                        <?php
                                            $seccion = $this->db->get("org_seccion");

                                            if(!empty($seccion)){
                                                foreach ($seccion->result() as $fila) {
                                                    echo '<option value="'.$fila->id_seccion.'">'.$fila->nombre_seccion.'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <h5>Nombre: <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" onkeyup="formar_usuario();" id="nombre" name="nombre" class="form-control" required="" placeholder="Ingrese el nombre" minlength="3" data-validation-required-message="Este campo es requerido">
                                        <div class="help-block"></div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <h5>Apellido: <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" onkeyup="formar_usuario();" id="apellido" name="apellido" class="form-control" required="" placeholder="Ingrese el apellido" minlength="3" data-validation-required-message="Este campo es requerido">
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
						                        	echo '<label class="custom-control custom-radio">';
						                        	echo '<input type="radio" data-radio="iradio_square-blue" name="genero" value="'.strtolower($fila->id_genero).'" data-validation-required-message="Seleccione el genero" id="'.strtolower($fila->genero).'" class="check" required>';
						                        	echo '<span class="custom-control-description" style="margin-left:10px;">'.ucfirst(strtolower($fila->genero)).'</span>';
						                        	echo '</label>';
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
                                        <input id="estado" name="estado" type="checkbox" checked>
                                        <label for="estado"> Cuenta activa </label>
                                    </div>
                                </div>
                            </div>                              


                            <button id="submit" type="submit" style="display: none;"></button>
                            <div align="right" id="btnadd">
                                <button type="submit" class="btn waves-effect waves-light btn-success2"><i class="mdi mdi-plus"></i> Guardar</button>
                            </div>
                            <div align="right" id="btnedit" style="display: none;">
                                <button type="button" onclick="editar_horario(this)" class="btn waves-effect waves-light btn-info"><i class="mdi mdi-pencil"></i> Editar</button>
                                <button type="button" onclick="eliminar_horario(this)" class="btn waves-effect waves-light btn-danger"><i class="mdi mdi-window-close"></i> Eliminar</button>
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
                tablahorarios();
            }else{
                swal({ title: "¡Ups! Error", text: "Intentalo nuevamente.", type: "error", showConfirmButton: true });
            }
        });
            
    });

});

</script>