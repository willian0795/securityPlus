<?php
extract($backup);
?>
<form name="form_backup" method="post">

<fieldset>
	<legend>Información del usuario</legend>
    Usuario: <strong><?php echo $usuario; ?></strong><br />
    Nombre: <strong><?php echo ucwords($nombre_completo); ?></strong><br />
</fieldset>
<fieldset>
	<legend>Detalles del respaldo</legend>
    Fecha y hora: <strong><?php echo $fecha_hora; ?></strong><br />
    Nombre: <strong><?php echo $nombre; ?></strong><br />
    Descripción: <strong><?php echo $descripcion; ?></strong><br />
    </fieldset>
<p style='text-align: center;'>
	<button type="button" id="aceptar" onclick="cerrar_vent()" name="Aceptar">Aceptar</button>
</p>
</form>