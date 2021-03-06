<script type="text/javascript">
    function cambiar_editar(id,id_sistema,nombre,descripcion,dependencia,url,icono,opciones,bandera){
        $("#idmodulo").val(id);
        $("#id_sistema").val(id_sistema);
        $("#nombre").val(nombre);
        $("#descripcion").val(descripcion);
        $("#dependencia").val(dependencia);
        $("#dependencia" ).prop( "disabled", true );
        $("#url").val(url);
        $("#icono").val(icono);
        $("#opciones").val(opciones);        

        if(bandera == "edit"){
            $("#band").val("edit");
            $("#ttl_form").removeClass("bg-success");
            $("#ttl_form").addClass("bg-info");
            $("#btnadd").hide(0);
            $("#btnedit").show(0);
            vista_form_tabla();
            $("#cnt_form").show(500);
            $("#ttl_form").children("h4").html("<span class='fa fa-wrench'></span> Editar módulo");
        }else{
            verificar_eliminacion();
        }
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

    function editar_modulo(){
        $("#band").val("edit");
        $( "#dependencia" ).prop( "disabled", false );
        $("#submit").click();
    }

    function eliminar_modulo(){
        $("#band").val("delete");
        swal({   
            title: "¿Seguro que desea eliminarlo?",   
            text: "¡El registro no podrá ser recuperado!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#fc4b6c",   
            confirmButtonText: "Sí, deseo eliminar!",   
            closeOnConfirm: true 
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
        
        if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttpB=new XMLHttpRequest();
        }else{// code for IE6, IE5
            xmlhttpB=new ActiveXObject("Microsoft.XMLHTTPB");
        }

        xmlhttpB.onreadystatechange=function(){
            if (xmlhttpB.readyState==4 && xmlhttpB.status==200){
                document.getElementById("combosistemas").innerHTML=xmlhttpB.responseText;
            }
        }

        xmlhttpB.open("GET","<?php echo site_url(); ?>/modulos/combo_modulo?id_sistema="+id_sistema,true);
        xmlhttpB.send(); 
    }

    function tablamodulos(){          
        var id_sistema = $("#sistema").val();

        if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttpB=new XMLHttpRequest();
        }else{// code for IE6, IE5
            xmlhttpB=new ActiveXObject("Microsoft.XMLHTTPB");
        }

        xmlhttpB.onreadystatechange=function(){
            if (xmlhttpB.readyState==4 && xmlhttpB.status==200){
                document.getElementById("cnt_tabla").innerHTML=xmlhttpB.responseText;
                combosistemas();
                $('[data-toggle="tooltip"]').tooltip();
            }
        }

        xmlhttpB.open("GET","<?php echo site_url(); ?>/modulos/tabla_modulo?id_sistema="+id_sistema,true);
        xmlhttpB.send(); 
    }


    function tablamodulos2(){  
        var id_sistema = $("#sistema").val();

        if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttpB=new XMLHttpRequest();
        }else{// code for IE6, IE5
            xmlhttpB=new ActiveXObject("Microsoft.XMLHTTPB");
        }

        xmlhttpB.onreadystatechange=function(){
            if (xmlhttpB.readyState==4 && xmlhttpB.status==200){
                document.getElementById("cnt_tabla2").innerHTML=xmlhttpB.responseText;
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
            }
        }

        xmlhttpB.open("GET","<?php echo site_url(); ?>/modulos/tabla_modulo2?id_sistema="+id_sistema,true);
        xmlhttpB.send();      
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

    function recorrerNestable(nullocero){
        $("#Loading2").show(0);
        var n1 = $("#nestable").children().children("li");
        var id = "", dep1 = 0,dep2 = 0,dep3 = 0, orden = 0;

        var query = "UPDATE org_modulo SET\n";
        var idqr = "", ordenquery = "orden = CASE id_modulo\n", dependenciaquery = "dependencia = CASE id_modulo\n";

        for(i=0; i<n1.length; i++){
            orden = i+1;
            if(nullocero == "NULL"){
                dep1 = "NULL";
            }else{
                dep1 = "'0'";
            }
            id = $($(n1[i]).children("input")).val();
            ordenquery += "WHEN "+id+" THEN '"+orden+"'\n";
            dependenciaquery += "WHEN "+id+" THEN "+dep1+"\n";
            idqr += id+",";
            var n2 = $(n1[i]).children("ol").children("li");
            dep2 = id;
            for(j=0; j<n2.length; j++){
                orden = j+1;                
                id = $($(n2[j]).children("input")).val();
                ordenquery += "WHEN "+id+" THEN '"+orden+"'\n";
                dependenciaquery += "WHEN "+id+" THEN '"+dep2+"'\n";
                idqr += id+",";
                var n3 = $(n2[j]).children("ol").children("li");
                dep3 = id;
                for(k=0; k<n3.length; k++){
                    orden = k+1;
                    id = $($(n3[k]).children("input")).val();
                    ordenquery += "WHEN "+id+" THEN '"+orden+"'\n";
                    dependenciaquery += "WHEN "+id+" THEN '"+dep3+"'\n";
                    idqr += id+",";
                }

            }
        }
        ordenquery += "END,\n";
        dependenciaquery += "END";
        idqr = idqr.substr(0,idqr.length-1);
        ordenando_modulo(query+ordenquery+dependenciaquery+"\nWHERE id_modulo IN ("+idqr+")")
    }

    function ordenando_modulo(query){       
        var id_sistema = $("#id_sistema").val();
        jugador = document.getElementById('jugador');
        
        ajax = objetoAjax();
        ajax.open("POST", "<?php echo site_url(); ?>/modulos/ordenar_modulo", true);
        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4){
                jugador.value = (ajax.responseText);
                $("#Loading2").hide(0);
                if(jugador.value == "exito"){
                    swal({ title: "¡Ordenamiento finalizado!", type: "success", showConfirmButton: true });
                }else{
                    swal({ title: "¡Ups! Error", text: "Intentalo nuevamente.", type: "error", showConfirmButton: true });
                }
                tablamodulos2();
            }
        } 
        ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
        ajax.send("&query="+query+"&id_sistema="+id_sistema)
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

    function verificar_eliminacion(){        
        var parametros = {
                "idmodulo" : $("#idmodulo").val(),
                "nombre" : $("#nombre").val()
        };
        $.ajax({
            data:  parametros, //datos que se envian a traves de ajax
            url:   '<?php echo site_url(); ?>/sistemas/modulo/verificar_roles2', //archivo que recibe la peticion
            type:  'post', //método de envio
            success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                if(response == "eliminar"){
                    eliminar_modulo();
                }else{
                    verificar_eliminacion2(response)
                }
            }
        });
    }  

    function verificar_eliminacion2(tipo){        
        var parametros = {
                "idmodulo" : $("#idmodulo").val(),
                "nombre" : $("#nombre").val()
        };
        $.ajax({
            data:  parametros, //datos que se envian a traves de ajax
            url:   '<?php echo site_url(); ?>/sistemas/modulo/verificar_roles', //archivo que recibe la peticion
            type:  'post', //método de envio
            success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                $('#myModal').modal('show'); // abrir
                $("#resultado").html("Para eliminar el modulo '"+parametros["nombre"]+"' debe eliminar su(s) "+tipo+": <br><br>"+response);                
            }
        });
    }

    function stopRKey(evt) {
    var evt = (evt) ? evt : ((event) ? event : null);
    var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
    if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
    }
    document.onkeypress = stopRKey; 

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
                        <?php echo form_open('', array('id' => 'formajax', 'style' => 'margin-top: 0px;', 'class' => 'm-t-40')); ?>
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
                                <h5>Opciones del módulo: </h5>
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
                        <div class="pull-left" id="Loading1" style="display: none;">
                            <h4 class="text-primary"><b><span class="fa fa-spinner fa-pulse"></span> <small>Aplicando los cambios...</small></b></h4>
                        </div>
                        <div align="right" id="btnadd">
                            <button type="reset" class="btn waves-effect waves-light btn-success"><i class="mdi mdi-recycle"></i> Limpiar</button>
                            <button type="submit" class="btn waves-effect waves-light btn-success2"><i class="mdi mdi-plus"></i> Guardar</button>
                        </div>
                        <div align="right" id="btnedit" style="display: none;">
                            <button type="reset" class="btn waves-effect waves-light btn-success"><i class="mdi mdi-recycle"></i> Limpiar</button>
                            <button type="button" onclick="editar_modulo()" class="btn waves-effect waves-light btn-info"><i class="mdi mdi-pencil"></i> Editar</button>
                        </div>
                        </form>
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

<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">¡El módulo posee roles asociados!</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <p id="resultado"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>

$(function(){     
    $("#formajax").on("submit", function(e){
        e.preventDefault();
        $("#Loading1").show(0);
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
            $("#Loading1").hide(0);
            if(res == "exito"){
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