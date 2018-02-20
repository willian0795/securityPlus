<?php
$id_empleado = $_GET["id_empleado"];
$tipo = $_GET["tipo"];

if($id_empleado == "0"){
?>
	<div id="form_nusuario">
        <div class="row">
            <div class="form-group col-lg-6">
                <h5>Nombre: <span class="text-danger">*</span></h5>
                <div class="controls">
                    <input type="text" onkeyup="formar_usuario();" id="nombre" name="nombre" class="form-control" placeholder="Ingrese el nombre" required>
                </div>
            </div>
            <div class="form-group col-lg-6">
                <h5>Apellido: <span class="text-danger">*</span></h5>
                <div class="controls">
                    <input type="text" onkeyup="formar_usuario();" id="apellido" name="apellido" class="form-control" placeholder="Ingrese el apellido" required>
                </div>
            </div>
        </div>                                                
        <div class="row">
        	<div class="form-group col-lg-6">
                <h5>Genero: <span class="text-danger">*</span></h5>
                <fieldset class="controls">
                    <input name="genero" type="radio" id="generoM" checked="" value="M" required>
                    <label class="m-l-20" for="generoM">Masculino</label>
                    <input name="genero" type="radio" id="generoF" value="F" required>
                    <label class="m-l-20" for="generoF">Femenino</label>
                </fieldset>
            </div> 
            <div class="form-group col-lg-6">
                <h5>Usuario: <span class="text-danger">*</span></h5>
                <div class="controls">
                    <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Nombre de usuario" minlength="3" required>
                </div>
            </div>
        </div>
    </div>
<?php
}else{

    if($tipo == "save"){
    	$empleado = $this->db->query("SELECT e.id_empleado, e.id_genero, UPPER(CONCAT_WS(' ', e.primer_nombre, e.segundo_nombre, e.tercer_nombre)) AS nombre, UPPER(CONCAT_WS(' ', e.primer_apellido, e.segundo_apellido, e.apellido_casada)) AS apellido, LOWER(CONCAT_WS('.',primer_nombre, primer_apellido)) AS usuario FROM sir_empleado AS e WHERE e.nr = '".$id_empleado."' ORDER BY primer_nombre");
        if($empleado->num_rows() > 0){
            foreach ($empleado->result() as $fila) {              
            }
        }
?>
	<div id="form_nusuario">
        <div class="row" style="display: none;">
            <div class="form-group col-lg-6">
                <h5>Nombre: <span class="text-danger">*</span></h5>
                <div class="controls">
                    <input type="text" onkeyup="formar_usuario();" id="nombre" name="nombre" class="form-control" value="<?php echo $fila->nombre; ?>" required>
                </div>
            </div>
            <div class="form-group col-lg-6">
                <h5>Apellido: <span class="text-danger">*</span></h5>
                <div class="controls">
                    <input type="text" onkeyup="formar_usuario();" id="apellido" name="apellido" class="form-control" value="<?php echo $fila->apellido; ?>" required>
                </div>
            </div>
        </div>                                                
        <div class="row">
        	<div class="form-group col-lg-6">
                <h5>Genero: <span class="text-danger">*</span></h5>
                <fieldset class="controls">
                    <input name="genero" type="radio" id="generoM" <?php if($fila->id_genero == "00001"){ echo "checked"; } ?> value="M" required>
                    <label class="m-l-20" for="generoM">Masculino</label>
                    <input name="genero" type="radio" id="generoF" <?php if($fila->id_genero == "00002"){ echo "checked"; } ?> value="F" required>
                    <label class="m-l-20" for="generoF">Femenino</label>
                </fieldset>
            </div> 
            <div class="form-group col-lg-6">
                <h5>Usuario: <span class="text-danger">*</span></h5>
                <div class="controls">
                    <input type="text" id="usuario" name="usuario" class="form-control" value="<?php echo $fila->usuario; ?>" minlength="3" required>
                </div>
            </div>
        </div>
    </div>
<?php
	}else{
		$empleado = $this->db->query("SELECT * FROM org_usuario WHERE id_usuario = '".$id_empleado."'");
        if($empleado->num_rows() > 0){
            foreach ($empleado->result() as $fila) {              
            }
        }
?>
	<div id="form_nusuario">
        <div class="row" style="display: none;">
            <div class="form-group col-lg-12">
                <h5>Nombre completo: <span class="text-danger">*</span></h5>
                <div class="controls">
                    <input type="text" onkeyup="formar_usuario();" id="nombre" name="nombre" class="form-control" value="<?php echo $fila->nombre_completo; ?>" required>
                </div>
            </div>
        </div>
        <div class="row">
        	<div class="form-group col-lg-6">
                <h5>Genero: <span class="text-danger">*</span></h5>
                <fieldset class="controls">
                    <input name="genero" type="radio" id="generoM" <?php if($fila->sexo == "M"){ echo "checked"; } ?> value="M" required>
                    <label class="m-l-20" for="generoM">Masculino</label>
                    <input name="genero" type="radio" id="generoF" <?php if($fila->sexo == "F"){ echo "checked"; } ?> value="F" required>
                    <label class="m-l-20" for="generoF">Femenino</label>
                </fieldset>
            </div> 
            <div class="form-group col-lg-6">
                <h5>Usuario: <span class="text-danger">*</span></h5>
                <div class="controls">
                    <input type="text" id="usuario" name="usuario" class="form-control" value="<?php echo $fila->usuario; ?>" minlength="3" required>
                </div>
            </div>
        </div>
    </div>
<?php
	}
}
?>