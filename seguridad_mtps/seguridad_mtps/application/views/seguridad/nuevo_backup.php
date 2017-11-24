
<form method="post" name="form_backup" action="<?php echo base_url(); ?>index.php/seguridad/nuevo_backup">
    <fieldset>
    	<legend>Datos a ingresar</legend>
       <p>
       	<label for="nombre" id="lnombre">Nombre </label>
        <input type="text" name="nombre" id="nombre"><?php echo "_".date('Y-m-d_H-i-s'); ?>
       </p>
       <p style='vertical-align: top;'>
       	<label for="descripcion" class="label_textarea">Descripción </label>
        <textarea name="descripcion" id="descripcion" style="resize:none"></textarea><br>
       </p>
    </fieldset>
    <p style='text-align: center;'>
	<button type="submit" id="guardar" name="guardar" class="button tam-1 boton_validador">Guardar</button>
    <button type="button" id="descargar" name="descargar" class="button tam-1 boton_validador">Descargar</button>
	</p>
</form>

<script>
$(document).ready(function(){
	$('#nombre').validacion({
		req:true
	});
	$('#descripcion').validacion({
		req:false,
		lonMin: 5
	});
	$('#descargar').click(function(){
		var n = document.getElementById('nombre').value;
		if(n!="")
		{
			document.form_backup.action=base_url()+"index.php/seguridad/nuevo_backup/1";
			document.form_backup.submit();
		}
	});
});
</script>