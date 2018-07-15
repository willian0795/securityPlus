<script type="text/javascript">
    function cambiar_editar(id,nombre,sexo,usuario,estado,nr,pass,bandera){
        $("#idusuario").val(id);
        $("#id_empleado").parent().hide(0);
        $("#id_empleado2").parent().show(0);
        $("#id_empleado2").val(id).trigger('change.select2');

        if(pass == ""){
            document.getElementById("tipo_pass").checked = 1;
            cambiar_check2("tipo_pass");
        }else{
            document.getElementById("tipo_pass").checked = 0;
            cambiar_check2("tipo_pass");
        }

        $("#password").val("");
        $("#password2").val("");
        $("#band").val(bandera);

        if(bandera == "edit"){
            $("#cnt-tabla").hide(0);
            $("#cnt_form").show(0);
            $("#ttl_form").children("h4").html("<span class='fa fa-wrench'></span> Editar usuario");
            $("#ttl_form").removeClass("bg-success");
            $("#ttl_form").addClass("bg-info");
            $("#btnadd").hide(0);
            $("#btnedit").show(0);
            $("#div_tipo_pass").show(0);
            open_form(1);
            formdatos(id, "edit");
        }else{
            cambiar_estado(id, usuario, estado);
        }
    }

    function cambiar_nuevo(){
        $("#id_empleado").parent().show(0);
        $("#id_empleado2").parent().hide(0);
        $("#idusuario").val("");
        $("#usuario").val("");
        $("#password").val("");
        $("#password2").val("");
        $("#band").val("save");
        formdatos("0", "save");
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
        tablausuarios();
    }

    function editar_usuario(){
        $("#band").val("edit");
        $("#submit").click();
    }

    function eliminar_usuario(estado){
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

    function cambiar_estado(id, usuario, estado){  
        var cambiar; if(estado == 0){ cambiar = 1;   }else{  cambiar = 0; }
        jugador = document.getElementById('jugador');
        ajax = objetoAjax();
        ajax.open("POST", "<?php echo site_url(); ?>/usuarios/usuarios/editar_estado", true);
        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4){
                jugador.value = (ajax.responseText);
                if(jugador.value == "exito" && cambiar == 1){
                    swal({ title: "¡Cuenta activada!", text: "La cuenta del usuario: <<"+usuario+">> fué activada exitosamente", type: "success", showConfirmButton: true });
                }else if(jugador.value == "exito" && cambiar == 0){
                    swal({ title: "¡Cuenta desactivada!", text: "La cuenta del usuario: <<"+usuario+">> fué desactivada", type: "warning", showConfirmButton: true });
                }else{
                    swal({ title: "¡Ocurrio un error!", text: "No se logró completar las modificaciones", type: "warning", showConfirmButton: true });
                }
                tablausuarios();
            }
        } 
        ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
        ajax.send("&id_usuario="+id+"&estado="+cambiar)
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
        var newName = 'Tabla usuarios',
        xhr = new XMLHttpRequest();
        var user = $("#idusuario").val();  var oficina = $("#oficina").val();

        xhr.open('GET', "<?php echo site_url(); ?>/usuarios/tabla_usuario?oficina="+oficina);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200 && xhr.responseText !== newName) {
                document.getElementById("cnt_tabla_user").innerHTML = xhr.responseText;
                //$('[data-toggle="tooltip"]').tooltip();
                $('#myTable').DataTable();
            }else if (xhr.status !== 200) {
                swal({ title: "Ups! ocurrió un Error", text: "Al parecer no todos los objetos se cargaron correctamente por favor recarga la página e intentalo nuevamente", type: "error", showConfirmButton: true });
            }
        };
        xhr.send(encodeURI('name=' + newName));
    }

    function tablaroles(){
        var newName = 'Tabla roles',
        xhr = new XMLHttpRequest();
        var user = $("#idusuario").val(); 

        xhr.open('GET', "<?php echo site_url(); ?>/usuarios/tabla_roles?id_usuario="+user);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200 && xhr.responseText !== newName) {
                document.getElementById("tabla_roles").innerHTML = xhr.responseText;
                $('#myTable2').DataTable();
            }else if (xhr.status !== 200) {
                swal({ title: "Ups! ocurrió un Error", text: "Al parecer no todos los objetos se cargaron correctamente por favor recarga la página e intentalo nuevamente", type: "error", showConfirmButton: true });
            }
        };
        xhr.send(encodeURI('name=' + newName));
    }

    function password_change(valor){
        if(valor == "0"){
            $("#form_nusuario").show(0);
        }else{
            $("#form_nusuario").hide(0);
        }
    }

    function formdatos(valor, tipo){
        var newName = 'Form datos',
        xhr = new XMLHttpRequest();

        xhr.open('GET', "<?php echo site_url(); ?>/usuarios/form_datos?id_empleado="+valor+"&tipo="+tipo);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200 && xhr.responseText !== newName) {
                document.getElementById("form_datos").innerHTML = xhr.responseText;
            }else if (xhr.status !== 200) {
                swal({ title: "Ups! ocurrió un Error", text: "Al parecer no todos los objetos se cargaron correctamente por favor recarga la página e intentalo nuevamente", type: "error", showConfirmButton: true });
            }
        };
        xhr.send(encodeURI('name=' + newName));
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
            $("#password").val("");
            $("#password2").val("");
        }else{
            $("#"+obj).val('0');
            $("#div_pass").show(0);
        }
    }

    function nuevo_rol(){
        var id_rol = $("#id_rol").val();
        var id_usuario = $("#idusuario").val();
        gestionar_roles(id_rol, id_usuario, "insertar");
    }

    function gestionar_roles(id_rol, usuario, band){
        jugador = document.getElementById('jugador');
        ajax = objetoAjax();
        ajax.open("POST", "<?php echo site_url(); ?>/usuarios/gestionar_roles", true);
        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4){
                jugador.value = (ajax.responseText);
                if(jugador.value == "exito"){                    
                    if(band == "insertar"){
                        $.toast({ heading: '¡Rol registrado!', text: 'El rol se registró exitosamente', position: 'top-right', loaderBg:'#000', icon: 'success', hideAfter: 3000, stack: 6 });
                    }else if(band == "eliminar"){
                        $.toast({ heading: 'Rol eliminado', text: 'El rol fué eliminado', position: 'top-right', loaderBg:'#000', icon: 'success', hideAfter: 3000, stack: 6 });
                    }
                    tablaroles();
                }else if(jugador.value == "existe"){
                    swal({ title: "¡Ya existe!", text: "El rol ya está asignado a este usuario", type: "warning", showConfirmButton: true });
                }else{
                    swal({ title: "¡Ups! Error", text: "Intentalo nuevamente.", type: "error", showConfirmButton: true });
                }
            }
        } 
        ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
        ajax.send("&id_rol="+id_rol+"&usuario="+usuario+"&bandera="+band)
    }

    function open_form(num){
        $("#form"+num).show(0);
        $("#form"+num).siblings("div").hide(0);

        if($("#band").val() == "save"){
            $("#btnadd"+num).show(0);
            $("#btnedit"+num).hide(0);
        }else{
            $("#btnadd"+num).hide(0);
            $("#btnedit"+num).show(0);
        }
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
                <h3 class="text-themecolor m-b-0 m-t-0">Administración de personas usuarias</h3>
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
                        <h4 class="card-title m-b-0 text-white">Listado de personas usuarias</h4>
                    </div>
                    <div class="card-body b-t">
                        <div id="form1">
                        <?php echo form_open('', array('id' => 'formajax', 'style' => 'margin-top: 0px;', 'class' => 'm-t-40')); ?>
                            <input type="hidden" id="band" name="band" value="save">
                            <input type="hidden" id="idusuario" name="idusuario" value="">

                            <div class="row">
                                <div class="form-group col-lg-6"> 
                                    <h5>Persona empleada: <span class="text-danger">*</span></h5>                           
                                    <select id="id_empleado" name="id_empleado" class="select2" style="width: 100%" onchange="formdatos(this.value,'save');">
                                        <option value="0">[Elija el empleado]</option>
                                        <?php 
                                            $empleado = $this->db->query("SELECT e.nr, UPPER(CONCAT_WS(' ', e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido, e.segundo_apellido, e.apellido_casada)) AS nombre_completo FROM sir_empleado AS e WHERE NOT EXISTS (SELECT u.nr FROM org_usuario AS u WHERE u.nr = e.nr) ORDER BY primer_nombre");
                                            if($empleado->num_rows() > 0){
                                                foreach ($empleado->result() as $fila) {              
                                                   echo '<option class="m-l-50" value="'.$fila->nr.'">'.preg_replace ('/[ ]+/', ' ', $fila->nombre_completo.' - '.$fila->nr).'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6"> 
                                    <h5>Persona empleada: <span class="text-danger">*</span></h5>                           
                                    <select id="id_empleado2" name="id_empleado2" class="select2" style="width: 100%">
                                        <option value="0">[Elija el empleado]</option>
                                        <?php 
                                            $empleado = $this->db->query("SELECT id_usuario, nombre_completo, nr FROM org_usuario");
                                            if($empleado->num_rows() > 0){
                                                foreach ($empleado->result() as $fila) {              
                                                   echo '<option class="m-l-50" value="'.$fila->id_usuario.'">'.preg_replace ('/[ ]+/', ' ', $fila->nombre_completo.' - '.$fila->nr).'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6" id="div_tipo_pass">
                                    <h5>¿Usuario sin contraseña?<span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <div class="switch">
                                            <label>Desactivado<input type="checkbox" value="0" onchange="cambiar_check2(this.id)" name="tipo_pass" id="tipo_pass"><span class="lever"></span>Activado</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="form_datos"></div>                           

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

                            <button id="submit" type="submit" style="display: none;"></button>
                            <div align="right" id="btnadd1">
                                <button type="reset" class="btn waves-effect waves-light btn-success"><i class="mdi mdi-recycle"></i> Limpiar</button>
                                <button type="submit" class="btn waves-effect waves-light btn-success2">Siguiente <span class="fa fa-chevron-right"></span></button>
                            </div>
                            <div align="right" id="btnedit1" style="display: none;">
                                <button type="reset" class="btn waves-effect waves-light btn-success"><i class="mdi mdi-recycle"></i> Limpiar</button>
                                <button type="submit" class="btn waves-effect waves-light btn-info">Siguiente <span class="fa fa-chevron-right"></span></button>
                            </div>

                        <?php echo form_close(); ?>
                        </div>
                        <div id="form2" style="display: none;">
                        <?php echo form_open('', array('id' => 'formajax2', 'style' => 'margin-top: 0px;', 'class' => 'm-t-40')); ?>

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title m-b-0">Lista de roles</h4>
                                </div>
                                <div class="card-body b-t" style="padding-top: 7px;">
                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <h5>Rol: <span class="text-danger">*</span></h5>
                                            <div class="input-group">                           
                                                <select id="id_rol" name="id_rol" class="select2" style="width: 100%">
                                                    <option value="">[Elija el rol]</option>
                                                    <?php 
                                                        $rol = $this->db->query("SELECT * FROM org_rol WHERE id_rol ORDER BY nombre_rol");
                                                        if($rol->num_rows() > 0){
                                                            foreach ($rol->result() as $fila2) {              
                                                               echo '<option class="m-l-50" value="'.$fila2->id_rol.'">'.$fila2->nombre_rol.'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                                <div onclick="nuevo_rol();" class="input-group-addon btn-success2" style="cursor: pointer; position: relative; right: 3px;"><i class="mdi mdi-plus"></i></div> 
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tabla_roles"></div>  
                                </div>
                            </div>
                            <div align="right" id="btnadd2">
                                <button type="button" class="btn waves-effect waves-light btn-success2" onclick="cerrar_mantenimiento();"><span class="fa fa-check"> Listo</span></button>
                            </div>
                            <div align="right" id="btnedit2" style="display: none;">
                                <button type="button" class="btn waves-effect waves-light btn-info" onclick="cerrar_mantenimiento();"><span class="fa fa-check"> Listo</span></button>
                            </div>
                        <?php echo form_close(); ?>
                        </div>
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
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title m-b-0">Listado de personas usuarias</h4>
                    </div>
                    <div class="card-body b-t" style="padding-top: 7px;">

                        <div class="row clearfix">
                        <div class="col-lg-6">
                            <div class="form-group"> 
                                <select id="oficina" name="oficina" class="select2" style="width: 100%" onchange="tablausuarios();">
                                    <option value="">OFICINA CENTRAL SAN SALVADOR</option>
                                    <?php 
                                        $oficinas = $this->db->query("SELECT * FROM `org_seccion` WHERE id_seccion IN (52,53,54,55,56,57,58,59,60,61,64,65,66) ORDER BY nombre_seccion");
                                        if($oficinas->num_rows() > 0){
                                            foreach ($oficinas->result() as $fila) {              
                                               echo '<option class="m-l-50" value="'.$fila->id_seccion.'">'.$fila->nombre_seccion.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6" align="right">
                            <button type="button" onclick="cambiar_nuevo();" class="btn btn-success2"><span class="mdi mdi-plus"></span> Nuevo registro</button>
                        </div>
                    </div>
                        <div class="table-responsive" id="cnt_tabla_user">
                        </div>
                    </div>
                </div>
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

        var band = true;

        if($("#band").val()=="save"){
            if(document.getElementById("tipo_pass").checked == 0){
                if($("#password").val() != $("#password2").val()){
                    band = false;
                }

                if($("#password").val().trim() == "" || $("#password2").val().trim() == ""){
                    band = false;
                }
            }
        }else{
            if(document.getElementById("tipo_pass").checked == 0){
                if($("#password").val() != $("#password2").val()){
                    band = false;
                }
            }
        }
        if(band){
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
                var res = res.split(",");
                if(res[0] == "exito"){                    
                    if($("#band").val() == "save"){
                        //swal({ title: "¡Registro exitoso!", type: "success", showConfirmButton: true });
                        $.toast({ heading: '¡Registro exito!', text: 'Usuario registrado', position: 'top-right', loaderBg:'#000', icon: 'success', hideAfter: 3000, stack: 6 });
                        $("#idusuario").val(res[1]);
                    }else if($("#band").val() == "edit"){
                        //swal({ title: "¡Modificación exitosa!", type: "success", showConfirmButton: true });
                        $.toast({ heading: 'Modificación exitosa!', text: 'Usuario modificado', position: 'top-right', loaderBg:'#000', icon: 'success', hideAfter: 3000, stack: 6 });
                    }
                    tablaroles();
                    open_form(2);
                }else if(res == "existe"){
                    swal({ title: "¡Ya existe!", text: "El usuario ya posee una cuenta", type: "warning", showConfirmButton: true });
                }else{
                    swal({ title: "¡Ups! Error", text: "Intentalo nuevamente.", type: "error", showConfirmButton: true });
                }
            });
        }else{
            $.toast({ heading: 'Contraseña no válida', text: 'La contraseña debe empatar y no puede estar vacía', position: 'top-right', loaderBg:'#000', icon: 'warning', hideAfter: 4000, stack: 6 });
        }
            
    });

});

</script>