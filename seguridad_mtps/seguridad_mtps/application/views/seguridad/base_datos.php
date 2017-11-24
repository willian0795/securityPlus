<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	<?php if($msj!="") {?>
		estado_correcto= '<?php echo $msj ?>';
		estado_incorrecto='Error de conexión al servidor. Por favor vuelva a intentarlo.';
	<?php }?>
</script>

<section>
    <h2>Base de Datos</h2>
</section>

<button type="button" id="nuevo_backup1" class="button tam-1">Nuevo Respaldo</button>
<a id="nuevo_backup2" rel="leanModal" href="#ventana"></a>

<button type="button" id="restaura1" class="button tam-1">Restaurar Respaldo</button>
<a id="restaura2" rel="leanModal" href="#ventana"></a>


<table  class="grid">
<thead>
  <tr>
    <th width="175px">Fecha y hora</th>
    <th>Nombre</th>
    <th>Usuario</th>
    <th width="100px">Opción</th>
  </tr>
 </thead>
 <tbody>
<?php
	foreach ($backups as $b) {
?>
  <tr>
    <td align="center"><?php echo $b['fecha_hora'] ?></td>
    <td align="center"><?php echo $b['nombre'] ?></td>
    <td align="center"><?php echo $b['usuario']; ?></td>
    <td>
    	<a rel="leanModal" title="Ver información del respaldo" href="#ventana" onclick="dialogo(<?php echo $b['id_backup']?>)"><img  src="<?php echo base_url()?>img/lupa.gif"/></a> 
        <a title="Restaurar respaldo" onClick="restaurar(<?php echo $b['id_backup'] ?>)" href="#" ><img src="<?php echo base_url()?>img/restaura.png"/></a>
        <a title="Eliminar respaldo"  onClick="eliminar(<?php echo $b['id_backup']?>)" href="#"><img src="<?php echo base_url()?>img/ico_basura.png"/></a>
	</td>
  </tr>
<?php } ?>
</tbody>
</table>

<div id="ventana" style="height:600px; width:650px">
    <div id='signup-header'>
        <h2><div id="titulo-ventana">Infomación del Respaldo</div></h2>
        <a class="modal_close" id="cerrar"></a>
    </div>
    <div id='contenido-ventana'>
    </div>
</div>

<script language="javascript" >
	$(document).ready(function(){
		$("#nuevo_backup1").click(function(){
			$("#nuevo_backup2").click();
		});
		$("#nuevo_backup2").click(function(){
			$("#titulo-ventana").html("Nuevo Respaldo");
			$('#contenido-ventana').load(base_url()+'index.php/seguridad/datos_backup');
			return false;
		});
		
		$("#restaura1").click(function(){
			$("#restaura2").click();
		});
		$("#restaura2").click(function(){
			$("#titulo-ventana").html("Restaurar Respaldo Externo de la Base de Datos");
			$('#contenido-ventana').load(base_url()+'index.php/seguridad/ventana_restaurar');
			return false;
		});
		
		$('#lean_overlay, #cerrar').click(function(){
			var x=document.getElementById('titulo-ventana').innerHTML;
			if(x=="Nuevo Respaldo")	location.reload();
		});
	});
	
	function eliminar (id)
	{
		alertify.confirm("¿Realmente desea eliminar este respaldo? Se perderán todos los datos relacionados. Este proceso no se puede revertir.",
		function (e)
		{
			if (e)
			{
				window.location.href = base_url()+'index.php/seguridad/eliminar_backup/'+id;
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
		$('#contenido-ventana').load(base_url()+'index.php/seguridad/ventana_backup/'+id);
		return false;
	}
	
	function restaurar(id)
	{
		alertify.confirm("¿Realmente desea resturar éste respaldo? La funcionalidad del sistema podría cambiar. Este proceso no se puede revertir.",
		function (e)
		{
			if (e)
			{
				window.location.href = base_url()+'index.php/seguridad/restaurar_base_datos/'+id;
			}
			else
			{
				return false;
			}
		});
	}
</script>