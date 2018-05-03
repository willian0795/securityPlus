<script type="text/javascript">

<?php
    $query = $this->db->query("SELECT * FROM org_usuario WHERE estado = 1");
?>

    var total_usuarios = <?php echo $query->num_rows(); ?>

    function iniciar(){
        cargar_estado();
	}

    var otroChart;

    function inicializar(chart){
        otroChart = chart;
    }

    function detener(){
        clearInterval(myVar);
        myVar = "";
    }

    var myVar = setInterval(function(){ cargar_estado() }, 2000);

    function cargar_estado(){
        var newName = 'John Smith',
        xhr = new XMLHttpRequest();
        xhr.open('GET', "<?php echo site_url(); ?>/inicio/memory_usage");
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200 && xhr.responseText !== newName) {
                var datos = xhr.responseText;
                datos = datos.split(",");

                var memoria_enuso = parseInt(datos[0])/(1024*1024*1024);
                var memoria_libre = parseInt(datos[1])/(1024*1024*1024);
                var memoria_total = parseInt(datos[2])/(1024*1024*1024);
                var porceje_usado = ((memoria_enuso/memoria_total)*100).toFixed(2);

                chart.data.datasets[0].data[0] = memoria_enuso.toFixed(2);  //memoria usada
                chart.data.datasets[0].data[1] = memoria_libre.toFixed(2);  //memoria libre

                if(parseFloat(porceje_usado)<30){
                    chart.data.datasets[0].backgroundColor[0] = "rgb(38, 198, 218)";
                }else if(parseFloat(porceje_usado)>=30 && parseFloat(porceje_usado)<50){
                    chart.data.datasets[0].backgroundColor[0] = "rgb(255, 178, 43)";
                }else{
                    chart.data.datasets[0].backgroundColor[0] = "rgb(255, 99, 132)";
                }
                
                chart.update();

                $("#porcentajem").text(porceje_usado+"%");


                var porcentajecpu = parseInt(datos[3]);

                chart2.data.datasets[0].data[0] = porcentajecpu;  //memoria libre
                chart2.data.datasets[0].data[1] = 100-porcentajecpu;  //memoria usada


                if(parseFloat(porcentajecpu)<30){
                    chart2.data.datasets[0].backgroundColor[0] = "rgb(38, 198, 218)";
                }else if(parseFloat(porcentajecpu)>=30 && parseFloat(porcentajecpu)<50){
                    chart2.data.datasets[0].backgroundColor[0] = "rgb(255, 178, 43)";
                }else{
                    chart2.data.datasets[0].backgroundColor[0] = "rgb(255, 99, 132)";
                }


                chart2.update();

                $("#porcentajecpu").text(porcentajecpu+"%");

                usuario_log();
            }else if (xhr.status !== 200) {
                //swal({ title: "Ups! ocurrió un Error", text: "Al parecer la tabla de empresas visitadas no se cargó correctamente por favor recarga la página e intentalo nuevamente", type: "error", showConfirmButton: true });
            }
        };
        xhr.send(encodeURI('name=' + newName));
    }

    function usuario_log(){
        var newName = 'AjaxCall',
        xhr = new XMLHttpRequest();
        xhr.open('GET', "<?php echo site_url(); ?>/inicio/usuario_log");
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200 && xhr.responseText !== newName) {
                var datos2 = xhr.responseText;
                var usuarioslog = parseInt(datos2);   //usuarios logeados
                var usuariostotal = parseInt(total_usuarios); //total de ususarios
                var porcentajelog = parseFloat((usuarioslog/usuariostotal)*100).toFixed(2);

                chart3.data.datasets[0].data[0] = usuarioslog;  //memoria libre
                chart3.data.datasets[0].data[1] = usuariostotal-usuarioslog;  //memoria usada
                chart3.update();

                $("#porcentajeus").text(porcentajelog+"%");
                $("#texto_usuarios").text(usuarioslog+"/"+usuariostotal);

            }else if (xhr.status !== 200) {
                //swal({ title: "Ups! ocurrió un Error", text: "Al parecer la tabla de empresas visitadas no se cargó correctamente por favor recarga la página e intentalo nuevamente", type: "error", showConfirmButton: true });
            }
        };
        xhr.send(encodeURI('name=' + newName));
    }

    function liberar_memoria(){
        var newName = 'AjaxCall',
        xhr = new XMLHttpRequest();
        xhr.open('GET', "<?php echo site_url(); ?>/inicio/liberar_memoria");
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200 && xhr.responseText !== newName) {
                var datos = xhr.responseText;
                alert(datos)
                if(datos == "sistemaoperativo"){
                    $.toast({ heading: 'Lo sentimos', text: 'Esta función no está disponible para su sistema operativo', position: 'top-right', loaderBg:'#000', icon: 'warning', hideAfter: 4000, stack: 6 });
                }else if(datos == "fracaso"){
                    $.toast({ heading: 'Ocurrió un error', text: 'No se logró ejecutar la acción solicitada', position: 'top-right', loaderBg:'#000', icon: 'error', hideAfter: 4000, stack: 6 });
                }else{
                    $.toast({ heading: 'Memoria liberada', text: 'El caché de la memoria RAM fué liberado exitosamente', position: 'top-right', loaderBg:'#000', icon: 'success', hideAfter: 4000, stack: 6 });
                }
                
            }else if (xhr.status !== 200) {
                swal({ title: "Ups! ocurrió un Error", text: "Al parecer no se logró ejecutar el comando requerido", type: "error", showConfirmButton: true });
            }
        };
        xhr.send(encodeURI('name=' + newName));
    }

</script>
<!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <br>
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->

                <div class="row">

                <div class="col-lg-3">
                    <div class="row">


                    	<?php
                        	$querys = $this->db->query("SELECT * FROM org_sistema");
    						$sistemas = $querys->num_rows();

    						$querymod = $this->db->query("SELECT * FROM org_modulo");
    						$modulos = $querymod->num_rows();
    					?>

                        <!-- Column -->
                        <div class="col-lg-12">
                            <div class="card card-inverse card-success">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="m-r-20 align-self-center">
                                            <h2 class="text-white"><i class="mdi mdi-laptop-chromebook"></i></h1></div>
                                        <div>
                                            <h3 align="center" class="card-title">Sistemas: <?php echo $sistemas; ?></h3>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="m-r-20 align-self-center">
                                            <h2 class="text-white"><i class="mdi mdi-library-books"></i></h1></div>
                                        <div>
                                            <h3 align="center" class="card-title">Módulos: <?php echo $modulos; ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        	$query = $this->db->query("SELECT * FROM org_usuario WHERE estado = 1");
    						$usuarios = $query->num_rows();

    						$queryh = $this->db->query("SELECT * FROM org_usuario WHERE estado = 1 AND sexo = 'M'");
    						$hombres = $queryh->num_rows();

    						$querym = $this->db->query("SELECT * FROM org_usuario WHERE estado = 1 AND sexo = 'F'");
    						$mujeres = $querym->num_rows();

    						$porcentajeh = number_format((($hombres/$usuarios)*100),2);
    						$porcentajem = number_format((($mujeres/$usuarios)*100),2);

    					?>


                        <!-- Column -->
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 align="center">Personas usuarias</h4>
                                    <div class="d-flex flex-row" align="center">
                                        <div class="p-0 b-r" align="center" style="width: 50%;">
                                            <h6 class="font-light">Hombres</h6><h6><?php echo $hombres; ?></h6><h6><?php echo $porcentajeh; ?>%</h6>
                                        </div>
                                        <div class="p-0" align="center" style="width: 50%;">
                                            <h6 class="font-light">Mujeres</h6><h6><?php echo $mujeres; ?></h6><h6><?php echo $porcentajem; ?>%</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        
                    </div>
                </div>


                <div class="col-lg-9">
                    <div class="row">


                        <!-- Column -->
                        <div class="col-lg-4">
                            <div class="card card-body">
                                <!-- Row -->
                                <div class="row">
                                    <!-- Column -->
                                    <div align="center" class="col p-r-0 align-self-center" style="padding: 0px; padding-left: 10px;">
                                        <h2 class="font-light m-b-0" id="texto_usuarios">0/0</h2>
                                        <h6 class="font-light" style="margin: 0px;">Usuarios iniciaron sesión hoy</h6></div>
                                    <!-- Column -->
                                    <div class="col text-right align-self-center" style="padding: 0px; position: relative;">
                                        <h3 align="center" id="porcentajeus" style="left:50%; top: 57%; position: absolute; transform: translate(-50%, -50%); -webkit-transform: translate(-50%, -50%);">Cargando...</h3>
                                        <div style="margin-left: 10px; margin-right: 10px;">
                                            <canvas id="myChart3"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    <!-- Column -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card card-body">
                            <!-- Row -->
                            <div class="row">
                                <!-- Column -->
                                <div align="center" class="col p-r-0 align-self-center" style="padding: 0px; padding-left: 10px;">
                                    <h2 class="font-light m-b-0">Procesador (CPU)</h2>
                                    <h6 class="font-light" style="margin: 0px;">Servidor</h6></div>
                                <!-- Column -->
                                <div class="col text-right align-self-center" style="padding: 0px; position: relative;">
                                    <h3 align="center" id="porcentajecpu" style="left:50%; top: 57%; position: absolute; transform: translate(-50%, -50%); -webkit-transform: translate(-50%, -50%);">Cargando...</h3>
                                    <div style="margin-left: 10px; margin-right: 10px;">
                                        <canvas id="myChart2"></canvas>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Column -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card card-body">
                            <!-- Row -->
                            <div class="row">
                                <!-- Column -->
                                <div align="center" class="col p-r-0 align-self-center" style="padding: 0px; padding-left: 10px;">
                                    <h2 class="font-light m-b-0">Memoria RAM <span class="mdi mdi-autorenew text-info" style="cursor: pointer;" onclick="liberar_memoria();"></span></h2>
                                    <h6 class="font-light" style="margin: 0px;">Servidor</h6>
                                </div>
                                <!-- Column -->
                                <div class="col text-right align-self-center" style="padding: 0px; position: relative;">
                                    <h3 align="center" id="porcentajem" style="left:50%; top: 57%; position: absolute; transform: translate(-50%, -50%); -webkit-transform: translate(-50%, -50%);">Cargando...</h3>
                                    <div style="margin-left: 10px; margin-right: 10px;">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>


                <div class="row">
                    <!-- column -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Gráfico de sesiones iniciadas por día</h4>
                                <div id="main" style="width:100%; height:300px;"></div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->
                </div>


                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->


<script src="<?php echo base_url(); ?>assets/js/Chart.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/echarts/echarts-all.js"></script>
<script type="text/javascript">

// ============================================================== 
// Line chart
// ============================================================== 
var dom = document.getElementById("main");
var mytempChart = echarts.init(dom);
var app = {};
option = null;
option = {
   
    tooltip : {
        trigger: 'axis'
    },
    legend: {
        data:['sesiones']
    },
    toolbox: {
        show : true,
        feature : {
            magicType : {show: true, type: ['line', 'bar']},
            restore : {show: false},
            saveAsImage : {show: true}
        }
    },
    color: ["#009efb"],
    calculable : true,
    xAxis : [
        {
            type : 'category',

            boundaryGap : false,
            data : [
            <?php 
            $fecha = date('Y-m-j');
			$fecha = strtotime ( '-14 day' , strtotime ( $fecha ) ) ;

			for($i=0; $i<=14; $i++){
				if($i==14){
					echo "'".date ( 'd-m-Y' , $fecha )."'";
				}else{
					echo "'".date ( 'd-m-Y' , $fecha )."', ";
				}
				$fecha = date ( 'Y-m-j' , $fecha );
				$fecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
			}
			 
			?>
            ]
        }
    ],
    yAxis : [
        {
            type : 'value',
            axisLabel : {
                formatter: '{value}'
            }
        }
    ],

    series : [
        {
            name:'sesiones',
            type:'line',
            data:[
            <?php 
            $fecha = date('Y-m-j');
			$fecha = strtotime ( '-14 day' , strtotime ( $fecha ) ) ;

			$max = 0;
			$x = 0;
			$min = 10000;
			$x2 = 0;

			for($j=0; $j<=14; $j++){
				$query = $this->db->query("SELECT * FROM glb_bitacora WHERE id_accion = '1' AND cast(fecha_hora as date) = '".date ( 'Y-m-d' , $fecha )."'");

				if(intval($query->num_rows()) > $max){
					$max = intval($query->num_rows());
					$x = $j;
				}


				if(intval($query->num_rows()) < $min){
					$min = intval($query->num_rows());
					$x2 = $j;
				}

				if($j==14){
					echo "'".intval($query->num_rows())."'";
				}else{
					echo "'".intval($query->num_rows())."', ";
				}
				$fecha = date ( 'Y-m-j' , $fecha );
				$fecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
			}
			 
			?>
            ],
            markPoint : {
                data : [
                    {name : 'Max', value : <?php echo $max; ?>, xAxis: <?php echo $x; ?>, yAxis: <?php echo $max; ?>, symbolSize:15},
                    {name : 'Min', value : <?php echo $min; ?>, xAxis: <?php echo $x2; ?>, yAxis: <?php echo $min; ?>, symbolSize:10}
                ]
            },
            itemStyle: {
                normal: {
                    lineStyle: {
                        shadowColor : 'rgba(0,0,0,0.3)',
                        shadowBlur: 10,
                        shadowOffsetX: 8,
                        shadowOffsetY: 8 
                    }
                }
            }            
        }
    ]
};

if (option && typeof option === "object") {
    mytempChart.setOption(option, true), $(function() {
            function resize() {
                setTimeout(function() {
                    mytempChart.resize()
                }, 100)
            }
            $(window).on("resize", resize), $(".sidebartoggler").on("click", resize)
        });
}


var ctx3;
var chart3;

$( document ).ready(function() {

ctx3 = document.getElementById('myChart3').getContext('2d');
chart3 = new Chart(ctx3, {
    // The type of chart we want to create
    type: 'doughnut',

    // The data for our dataset
    data: {
        labels: ["Logeados", "Sin logear"],
        datasets: [{
            backgroundColor: ['rgb(30, 136, 229)', 'rgba(33, 37, 41, 0.21)'],
            data: [0, 100],
        }]
    },

    // Configuration options go here
    options: { cutoutPercentage: 75  }

});

});



var ctx;
var chart;

$( document ).ready(function() {

ctx = document.getElementById('myChart').getContext('2d');
chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'doughnut',

    // The data for our dataset
    data: {
        labels: ["En uso", "Libre"],
        datasets: [{
            backgroundColor: ['rgb(255, 99, 132)', 'rgba(33, 37, 41, 0.21)'],
            data: [0, 100],
        }]
    },

    // Configuration options go here
    options: { cutoutPercentage: 75 }

});

});

var ctx2;
var chart2;

$( document ).ready(function() {

ctx2 = document.getElementById('myChart2').getContext('2d');
chart2 = new Chart(ctx2, {
    // The type of chart we want to create
    type: 'doughnut',

    // The data for our dataset
    data: {
        labels: ["En uso", "Libre"],
        datasets: [{
            backgroundColor: ['rgb(255, 99, 132)', 'rgba(33, 37, 41, 0.21)'],
            data: [0, 100],
        }]
    },

    // Configuration options go here
    options: { cutoutPercentage: 75  }

});

});






</script>