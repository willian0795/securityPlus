<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	<?php if($msj!="") {?>
		estado_correcto= '<?php echo $msj ?>';
		estado_incorrecto='Error de conexión al servidor. Por favor vuelva a intentarlo.';
	<?php }?>
</script>
<section>
    <h2>Bitácora de Sistemas</h2>
</section>
<table  class="grid" width="1050px">
<thead>
  <tr>
    <th width="120px">Fecha</th>
    <th width="80px">Usuario</th>
    <th>Descripción</th>
    <th width="200px">Sistema</th>
    <th width="50px">Opción</th>
  </tr>
 </thead>
 <tbody>
<?php
	foreach ($bitacora as $b) {
?>
  <tr>
    <td><?php echo $b['fecha_hora'] ?></td>
    <td><?php echo $b['usuario'] ?></td>
    <td><?php echo $b['descripcion'] ?></td>
    <td><?php echo ucwords($b['nombre_sistema']); ?></td>
    <td>
    	<a rel="leanModal" title="Ver información del registro" href="#ventana" onclick="dialogo(<?php echo $b['id_bitacora']?>)"><img  src="<?php echo base_url()?>img/lupa.gif"/></a>
        <a title="Eliminar registro"  onClick="eliminar(<?php echo $b['id_bitacora']?>)" href="#"><img src="<?php echo base_url()?>img/ico_basura.png"/></a>
	</td>
  </tr>
<?php } ?>
</tbody>
</table>

<div id="ventana" style="height:600px; width:650px">
    <div id='signup-header'>
        <h2>Información del Registro</h2>
        <a class="modal_close" id="cerrar"></a>
    </div>
    <div id='contenido-ventana'>
    </div>
</div>

<script language="javascript" >
	function eliminar (id)
	{
		alertify.confirm("¿Realmente desea eliminar este registro? Se perderán todos los datos relacionados. Este proceso no se puede revertir.",
		function (e)
		{
			if (e)
			{
				window.location.href = base_url()+'index.php/seguridad/eliminar_bitacora/'+id;
			}
			else
			{
				return false;
			}
		});
	}
		
	function cerrar_vent()
	{
		$('#cerrar').click();
	}
	function dialogo(id)
	{
		$('#contenido-ventana').load(base_url()+'index.php/seguridad/ventana_bitacora/'+id);
		return false;
	}
</script>