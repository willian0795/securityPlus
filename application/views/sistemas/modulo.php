<script type="text/javascript">
    function cambiar_editar(id,id_sistema,nombre,descripcion,dependencia,url,icono,opciones){
        $("#idmodulo").val(id);
        $("#id_sistema").val(id_sistema);
        $("#nombre").val(nombre);
        $("#descripcion").val(descripcion);
        $("#dependencia").val(dependencia);
        $( "#dependencia" ).prop( "disabled", true );
        $("#url").val(url);
        $("#icono").val(icono);
        $("#opciones").val(opciones);        
        $("#band").val("edit");

        $("#ttl_form").removeClass("bg-success");
        $("#ttl_form").addClass("bg-info");

        $("#btnadd").hide(0);
        $("#btnedit").show(0);

        vista_form_tabla();

        $("#cnt_form").show(500);

        $("#ttl_form").children("h4").html("<span class='fa fa-wrench'></span> Editar módulo");
    }

    function cambiar_nuevo(dependencia){
        $("#idmodulo").val("");        
        $("#nombre").val("");
        $("#descripcion").val("");
        $("#dependencia").val(dependencia);
        $( "#dependencia" ).prop( "disabled", false );
        $("#url").val("");
        $("#icono").val("");
        $("#opciones").val("");
        $("#band").val("save");

        $("#ttl_form").addClass("bg-success");
        $("#ttl_form").removeClass("bg-info");

        $("#btnadd").show(0);
        $("#btnedit").hide(0);

        $("#dependencia").val(dependencia);
        $("#cnt_form").show(500);
        $("#ttl_form").children("h4").html("<span class='mdi mdi-plus'></span> Nuevo módulo");
        vista_form_tabla();
    }

    function cerrar_mantenimiento(){
        $("#cnt_tabla").show(500);
        $("#cnt_form").hide(500);
    }

    function editar_modulo(obj){
        $("#band").val("edit");
        $( "#dependencia" ).prop( "disabled", false );
        $("#submit").click();
    }

    function eliminar_modulo(obj){
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
            $( "#dependencia" ).prop( "disabled", false );
            $("#submit").click(); 
        });
    }

    function iniciar(){
        tablamodulos();        
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

    function combosistemas(){    
        var id_sistema = $("#sistema").val();
        $("#combosistemas").load("<?php echo site_url(); ?>/modulos/combo_modulo?id_sistema="+id_sistema);
    }

    function tablamodulos(){          
        var id_sistema = $("#sistema").val();
        $( "#cnt_tabla" ).load("<?php echo site_url(); ?>/modulos/tabla_modulo?id_sistema="+id_sistema, function() {
            tablamodulos2();
        });  
    }

    function tablamodulos2(){  
        var id_sistema = $("#sistema").val();
        $( "#cnt_tabla2" ).load("<?php echo site_url(); ?>/modulos/tabla_modulo2?id_sistema="+id_sistema, function() {
            $("#cnt_form").hide(500);
            vista_solo_form();
            combosistemas();
            var updateOutput = function(e) {
                var list = e.length ? e : $(e.target),
                    output = list.data('output');
            };
            $('#nestable').nestable({
                group: 1
            }).on('change', updateOutput);
            updateOutput($('#nestable').data('output', $('#nestable-output')));
        });       
    }

    function mostrarFormMenu(){
        $("#cnt_form").hide(500);
        if($("#sistema").val() == 0){
            $("#cnt_tabla").hide(0);
        }else{
            tablamodulos();
            $("#cnt_tabla").show(0);
            $("#id_sistema").val($("#sistema").val())
        }
    }

    function recorrerNestable(){
        var n1 = $("#nestable").children().children("li");
        var id = "", dep1 = 0,dep2 = 0,dep3 = 0, orden = 0;

        for(i=0; i<n1.length; i++){
            orden = i+1;
            dep1 = 0;
            id = $($(n1[i]).children("input")).val();
            ordenando_modulo(id,dep1,orden);
            var n2 = $(n1[i]).children("ol").children("li");
            dep2 = id;
            for(j=0; j<n2.length; j++){
                orden = j+1;                
                id = $($(n2[j]).children("input")).val();
                ordenando_modulo(id,dep2,orden);
                var n3 = $(n2[j]).children("ol").children("li");
                dep3 = id;
                for(k=0; k<n3.length; k++){
                    orden = k+1;
                    id = $($(n3[k]).children("input")).val();
                    ordenando_modulo(id,dep3,orden);
                }

            }
        }
        swal({ title: "¡Ordenamiento finalizado!", type: "success", showConfirmButton: true });
        tablamodulos2();
    }

    function ordenando_modulo(id, dependencia, orden){       

        jugador = document.getElementById('jugador');
        
        ajax = objetoAjax();
        ajax.open("POST", "<?php echo site_url(); ?>/modulos/ordenar_modulo", true);
        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4){
                jugador.value = (ajax.responseText);
            }
        } 
        ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
        ajax.send("&idmodulo="+id+"&dependencia="+dependencia+"&orden="+orden)
    }

    function vista_solo_form(){
        var divs = $("#cnt_content").children("div");

        $("#cnt_content").removeClass("col-lg-6");
        $("#cnt_content").addClass("col-lg-12");

        $(divs[0]).addClass("col-lg-1");
        $(divs[1]).addClass("col-lg-10");
        $(divs[1]).removeClass("col-lg-12");
        $(divs[2]).addClass("col-lg-1");
    }

    function vista_form_tabla(){
        var divs = $("#cnt_content").children("div");

        $("#cnt_content").removeClass("col-lg-12");
        $("#cnt_content").addClass("col-lg-6");

        $(divs[0]).removeClass("col-lg-1");
        $(divs[1]).removeClass("col-lg-10");
        $(divs[1]).addClass("col-lg-12");
        $(divs[2]).removeClass("col-lg-1");

        $("#cnt_form").removeClass("pulse animated");
        $("html").animate({scrollTop:0}, '2000', function() {
            $("#cnt_form").addClass("pulse animated");
        });
    }    

</script>
<style type="text/css">
@media screen (min-width: 700px){
    .fixeado{
        position: fixed; 
        right: 0;
    }
}
</style>
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
                <h3 class="text-themecolor m-b-0 m-t-0">Gestión de módulos</h3>
            </div>
        </div>
        <input type="hidden" id="jugador">
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
            <div class="col-lg-12 row" id="cnt_content">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                <div class="card">
                    <div class="card-body p-b-0">
                        <h4 class="card-title">Elija el sistema a editar:</h4>
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
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs customtab2 justify-content-end" role="tablist">
                        <li class="nav-item" onclick="tablamodulos();"> 
                            <a class="nav-link active" data-toggle="tab" href="#home7" role="tab" aria-expanded="true">
                                <span class="hidden-sm-up">
                                    <i class="mdi mdi-pencil"></i>
                                </span> 
                                <span class="hidden-xs-down">
                                    <i class="mdi mdi-pencil"></i> Mantenimiento
                                </span>
                            </a> 
                        </li>
                        <li class="nav-item" onclick="tablamodulos2();">
                            <a class="nav-link" data-toggle="tab" href="#profile7" role="tab" aria-expanded="false">
                                <span class="hidden-sm-up">
                                    <i class="ti-user"></i>
                                </span>
                                <span class="hidden-xs-down">
                                    <i class="mdi mdi-cursor-move"></i> Ordenar
                                </span>
                            </a> 
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active p-10" id="home7" role="tabpanel" aria-expanded="true">
                            <div id="cnt_tabla">
                            </div>
                        </div>
                        <div class="tab-pane p-10" id="profile7" role="tabpanel" aria-expanded="false">
                            <div id="cnt_tabla2"></div>
                        </div>                    
                    </div>
                    </div>
                </div>
                </div>
                <div class="col-lg-1"></div>
            </div>
            <div class="col-lg-6" style="display: none;" id="cnt_form">
                <div class="card">
                    <div class="card-header bg-success2" id="ttl_form">
                        <h4 class="card-title m-b-0 text-white"><span class='mdi mdi-plus'></span> Nuevo módulo</h4>
                    </div>
                    <div class="card-body b-t">
                        <?php echo form_open('', array('id' => 'formajax', 'style' => 'margin-top: 0px;', 'class' => 'm-t-40', 'novalidate' => '')); ?>
                        <input type="hidden" id="band" name="band" value="save">
                        <input type="hidden" id="idmodulo" name="idmodulo" value="">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <h5>Nombre: <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" id="nombre" name="nombre" class="form-control" required="" data-validation-required-message="Este campo es requerido">
                                    <div class="help-block"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <h5>URL: <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" id="url" name="url" class="form-control" required="" data-validation-required-message="Este campo es requerido">
                                    <div class="help-block"></div>
                                </div>
                            </div>
                            <div class="form-group col-lg-6" id="combosistemas">
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <h5>Descripción:</h5>
                                <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <h5>Icono / Imagen: </h5>
                                <div class="controls">
                                    <input type="text" id="icono" name="icono" class="form-control">
                                    <div class="help-block"></div>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <h5>Opciones modulo: </h5>
                                <div class="controls">
                                    <input type="text" id="opciones" name="opciones" value="" class="form-control">
                                    <div class="help-block"></div>
                                </div>
                            </div>
                        </div>
                        <div style="display: none;">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <h5>Orden:</h5>
                                <div class="controls">
                                    <input type="text" id="orden" name="orden" value="" class="form-control">
                                    <div class="help-block"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <h5>Id sistema:</h5>
                                <div class="controls">
                                    <input type="text" id="id_sistema" name="id_sistema" class="form-control">
                                    <div class="help-block"></div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <button id="submit" type="submit" style="display: none;"></button>
                        <div align="right" id="btnadd">
                            <button type="reset" class="btn waves-effect waves-light btn-success"><i class="mdi mdi-delete"></i> Limpiar</button>
                            <button type="submit" class="btn waves-effect waves-light btn-success2"><i class="mdi mdi-plus"></i> Guardar</button>
                        </div>
                        <div align="right" id="btnedit" style="display: none;">
                            <button type="reset" class="btn waves-effect waves-light btn-success"><i class="mdi mdi-delete-empty"></i> Limpiar</button>
                            <button type="button" onclick="editar_modulo(this)" class="btn waves-effect waves-light btn-info"><i class="mdi mdi-pencil"></i> Editar</button>
                            <button type="button" onclick="eliminar_modulo(this)" class="btn waves-effect waves-light btn-danger"><i class="mdi mdi-window-close"></i> Eliminar</button>
                        </div>
                        <?php echo form_close(); ?>
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
        
        $.ajax({
            url: "<?php echo site_url(); ?>/modulos/gestionar_modulos",
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        })
        .done(function(res){
            if(res == "dependencia"){
                swal({ title: "¡Espere un momento!", text: "Elimine las dependecias del módulo '"+$("#nombre").val()+"' para poder eliminarlo", type: "warning", showConfirmButton: true });
            }else if(res == "exito"){
                if($("#band").val() == "save"){
                    swal({ title: "¡Registro exitoso!", type: "success", showConfirmButton: true });
                }else if($("#band").val() == "edit"){
                    swal({ title: "¡Modificación exitosa!", type: "success", showConfirmButton: true });
                    $( "#dependencia" ).prop( "disabled", true );
                }else{
                    swal({ title: "¡Borrado exitoso!", type: "success", showConfirmButton: true });
                    $( "#dependencia" ).prop( "disabled", true );
                }
                tablamodulos();
            }else{
                swal({ title: "¡Ups! Error", text: "Intentalo nuevamente.", type: "error", showConfirmButton: true });
            }
        });
            
    });
});

</script>