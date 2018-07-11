<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="description" content=""><meta name="author" content=""><link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/images/logo_min.png"><title>Login - Seguridad MTPS</title><script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js"></script><link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"><link href="<?php echo base_url(); ?>assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css"><link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet"><link href="<?php echo base_url(); ?>assets/css/colors/blue.css" id="theme" rel="stylesheet">
</head>
<body class="fix-header fix-sidebar card-no-border logo-center">
    <div class="preloader"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /></svg></div>
        <!-- Inicio Barra Superior -->
        <header class="topbar" style="background-color: #393939;">
            <nav class="navbar top-navbar navbar-light">
                <div class="navbar-header" align="center">
                    <li style="margin-left: 10px;" class="navbar-brand text-white" href="index.html"><b><i class="icon-login"></i> &emsp;Inicio de Sesión</b></li>
                </div>
            </nav>
        </header>
        <!-- Fin Barra Superior -->
        <!-- Inicio cuerpo de login -->
        <section id="wrapper" class="login-register img-responsive login-sidebar" style="background-image:url(<?php echo base_url(); ?>assets/images/portadas/seguridad6.jpg);">
          <div class="login-box card">
            <div class="card-body">
              <?php echo form_open('', array('id' => 'loginform', 'style' => 'margin-top: 0px;', 'class' => 'form-horizontal form-material')); ?>
                <a href="javascript:void(0)" class="text-center db"><img height="200px;" src="<?php echo base_url(); ?>assets/images/logo_completo.png" alt="Home" /></a>  
                <div class="form-group m-t-40">
                  <div class="col-xs-12"><input class="form-control" type="text" name="usuario" required="" placeholder="Usuario"></div>
                </div>
                <div class="form-group">
                  <div class="col-xs-12"><input class="form-control" type="password" name="password" required="" placeholder="Contraseña"></div>
                </div><br>
                <div class="form-group text-center m-t-20">
                  <div class="col-xs-12"><button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Ingresar</button></div>
                </div>
                <h3 align="center" class="text-primary" style="display: none;" id="Save_info"><b><span class="fa fa-spinner fa-pulse"></span> <small>Espere. Estamos buscando en el sistema...</small></b></h3>
              </form>
            </div>
          </div>
        </section>
        <!-- Fin cuerpo de login Wrapper -->
        <script>
        $(function(){     
            $("#loginform").on("submit", function(e){
                e.preventDefault(); var f = $(this);
                $("#Save_info").find("small").text("Espere. Estamos verificando sus credenciales...");
                $("#Save_info").show(0);
                var formData = new FormData(document.getElementById("loginform"));
                formData.append("dato", "valor");        
                $.ajax({ url: "<?php echo site_url(); ?>/login/verificar_usuario", type: "post", dataType: "html", data: formData, cache: false, contentType: false, processData: false })
                .done(function(res){
                    if(res == "exito"){
                        $("#Save_info").find("small").text("Preparando página principal...");
                        var c = new Date();
                        localStorage["expira"] = new Date(c.getFullYear(),c.getMonth(),c.getDate(),c.getHours(),c.getMinutes(),c.getSeconds());
                        localStorage["ventanas"] = 0;
                        location.href = "<?php echo base_url(); ?>";
                    }else if(res == "usuario"){
                        $("#Save_info").hide(0);
                        swal({ title: "¡Usuario no existe!", text: "El usuario que intenta identificar no exíste.", type: "warning", showConfirmButton: true });
                    }else if(res == "estado"){
                        $("#Save_info").hide(0);
                        swal({ title: "¡Cuenta inactiva!", text: "La cuenta de este usuario esta deshabilitada.", type: "warning", showConfirmButton: true });
                    }else if(res == "password"){
                        $("#Save_info").hide(0);
                        swal({ title: "¡Clave no válida!", text: "La clave ingresada no es válida.", type: "warning", showConfirmButton: true });
                    }else if(res == "activeDirectory"){
                        $("#Save_info").hide(0);
                        swal({ title: "¡No encontrado en Active Directory!", text: "Usuario o contraseña no encontrado en Active Directory.", type: "warning", showConfirmButton: true });
                    }else if(res == "sesion"){
                        $("#Save_info").hide(0);
                        swal({ title: "¡Ocurrió un error!", text: "Falló el inicio de sesión. Por favor intentelo nuevamente.", type: "error", showConfirmButton: true });
                    }else{
                        $("#Save_info").hide(0);
                        swal({ title: "¡Ocurrió un error!", text: "El usuario o contraseña son incorrectos, o no se logró conectar a Active Directory.", type: "error", showConfirmButton: true });
                    }
                });        
            });
        });
        </script>
    </div>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script><script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/popper.min.js"></script><script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script><script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.js"></script><script src="<?php echo base_url(); ?>assets/js/waves.js"></script><script src="<?php echo base_url(); ?>assets/js/sidebarmenu.js"></script><script src="<?php echo base_url(); ?>assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script><script src="<?php echo base_url(); ?>assets/plugins/sparkline/jquery.sparkline.min.js"></script><script src="<?php echo base_url(); ?>assets/js/custom.min.js"></script><script src="<?php echo base_url(); ?>assets/plugins/sweetalert/sweetalert.min.js"></script><script src="<?php echo base_url(); ?>assets/plugins/toast-master/js/jquery.toast.js"></script>
</body>

</html>