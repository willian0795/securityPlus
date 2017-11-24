<style>

input[type="file"]
{
	z-index: 999;
	line-height: 0;
	font-size: 50px;
	position: absolute;
	opacity: 0;
	filter: alpha(opacity = 0);-ms-filter: "alpha(opacity=0)";
	margin: 0;
	padding:0;
	left:0;
}

/* Al label lo convertimos en "boton"
(en apariencia) */
.cargar
{
	display: inline-block;
	margin: 15px auto;
	padding: 5px;
	text-decoration: none;
	text-align: center;
	font: bold 13px Verdana, Arial, Helvetica, sans-serif;
	width: 150px;
	color: #FFF;
	cursor: pointer;
	outline-style: none;
	background-color: #5A5655;
	border: 1px solid #5A5655;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
}

</style>
<form name="form_restaura" method="post" action="<?php echo base_url(); ?>index.php/seguridad/restaurar_base_datos" enctype="multipart/form-data">

<fieldset>
<legend>Buscar respaldo de la base de datos</legend>
<label class="cargar" style="width: 212px; height: 29px;">
	<span>
    Seleccione Respaldo
    <input type="file" id="archivo" name="archivo" onchange="validate_fileupload(this.value)" />
    </span>
</label>

<input type="text" id="url-archivo" name="url-archivo" />
</fieldset>

<p style='text-align: center;'>
	<button type="submit" id="restaurar_bd" name="restaurar_bd" class="button tam-1 boton_validador">Restaurar</button>
</p>

</form>
<script>
$(document).ready(function()
{
	$('#url-archivo').validacion({
		req:true,
		men: "Debe seleccionar un archivo .sql"
	});
	$('#archivo').change(function()
	{
		$('#url-archivo').val($(this).val());
	});
});

function validate_fileupload(fileName)
{
    var allowed_extensions = new Array("sql","SQL");
    var file_extension = fileName.split('.').pop(); // split function will split the filename by dot(.), and pop function will pop the last element from the array which will give you the extension as well. If there will be no extension then it will return the filename.
    var tipoArchivo= false;
    for(var i = 0; i <= allowed_extensions.length; i++)
    {
        if(allowed_extensions[i]==file_extension)
        {
     		tipoArchivo=true;
            return true; // valid file extension
            
        }
    }
    alertify.alert("Debe seleccionar un archivo .sql");
	tipoArchivo=false;
	
	document.getElementById('archivo').value="";
	
    return false;
}
</script>