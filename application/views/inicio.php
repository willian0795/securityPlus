<script type="text/javascript">
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

    var myVar = setInterval(function(){ cargar_estado() }, 3000);

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
                
                chart.update();

                $("#porcentajem").text(porceje_usado+"%");


                var porcentajecpu = datos[3];

                chart2.data.datasets[0].data[0] = porcentajecpu;  //memoria libre
                chart2.data.datasets[0].data[1] = 100-porcentajecpu;  //memoria usada
                chart2.update();

                $("#porcentajecpu").text(porcentajecpu+"%");


            }else if (xhr.status !== 200) {
                swal({ title: "Ups! ocurrió un Error", text: "Al parecer la tabla de empresas visitadas no se cargó correctamente por favor recarga la página e intentalo nuevamente", type: "error", showConfirmButton: true });
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

                <div class="col-lg-6">
                    <div class="row">


                    	<?php
                        	$querys = $this->db->query("SELECT * FROM org_sistema");
    						$sistemas = $querys->num_rows();

    						$querymod = $this->db->query("SELECT * FROM org_modulo");
    						$modulos = $querymod->num_rows();
    					?>

                        <!-- Column -->
                        <div class="col-lg-6">
                            <div class="card card-inverse card-info">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="m-r-20 align-self-center">
                                            <h1 class="text-white"><i class="mdi mdi-laptop-chromebook"></i></h1></div>
                                        <div>
                                            <h3 align="center" class="card-title">Sistemas</h3>
                                            <h2 align="center" class="card-subtitle"><?php echo $sistemas; ?></h2> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        <div class="col-lg-6">
                            <div class="card card-inverse card-success">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="m-r-20 align-self-center">
                                            <h1 class="text-white"><i class="mdi mdi-library-books"></i></h1></div>
                                        <div>
                                            <h3 align="center" class="card-title">Módulos</h3>
                                            <h2 align="center" class="card-subtitle"><?php echo $modulos; ?></h2> </div>
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
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-row">
                                        <div class="p-0 b-r" align="center">
                                            <h6 class="font-light">Usuarios Hombres</h6><h6><?php echo $hombres; ?></h6><h6><?php echo $porcentajeh; ?>%</h6>
                                        </div>
                                        <div class="p-0" align="center">
                                            <h6 class="font-light">Usuarios Mujeres</h6><h6><?php echo $mujeres; ?></h6><h6><?php echo $porcentajem; ?>%</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <?php 							            
    						$query = $this->db->query("SELECT * FROM org_usuario WHERE estado = 1");
    						$usuarios = $query->num_rows();

    						$query = $this->db->query("SELECT * FROM glb_bitacora WHERE id_accion = '1' AND cast(fecha_hora as date) = '".date ('Y-m-d')."' GROUP BY id_usuario");
    						$sesiones = $query->num_rows();

    						$porcentaje = (($sesiones/$usuarios)*100)

    					?>

                        <!-- Column -->
                        <div class="col-lg-6">
                            <div class="card card-body">
                                <!-- Row -->
                                <div class="row">
                                    <!-- Column -->
                                    <div align="center" class="col p-r-0 align-self-center" style="padding: 0px; padding-left: 10px;">
                                        <h2 class="font-light m-b-0"><?php echo $sesiones."/".$usuarios; ?></h2>
                                        <h6 class="font-light" style="margin: 0px;">Usuarios iniciaron sesión hoy</h6></div>
                                    <!-- Column -->
                                    <div class="col text-right align-self-center" style="padding: 0px;">
                                    	<div id="visitor" style="height:87px; width:90%; position: absolute;"></div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6">
                    <div class="row">


                    <!-- Column -->
                    <div class="col-md-6 col-lg-6">
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
                    <div class="col-md-6 col-lg-6">
                        <div class="card card-body">
                            <!-- Row -->
                            <div class="row">
                                <!-- Column -->
                                <div align="center" class="col p-r-0 align-self-center" style="padding: 0px; padding-left: 10px;">
                                    <h2 class="font-light m-b-0">Memoria RAM</h2>
                                    <h6 class="font-light" style="margin: 0px;">Servidor</h6></div>
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

                <button class="small" onclick="example();">Load</button>


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


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
t>

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
			$fecha = strtotime ( '-7 day' , strtotime ( $fecha ) ) ;

			for($i=0; $i<=14; $i++){
				if($i==14){
					echo "'".date ( 'd-m-Y' , $fecha )."'";
				}else{
					echo "'".date ( 'd-m-Y' , $fecha )."', ";
				}
				$fecha = date ( 'Y-m-j' , $fecha );
				$fecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
				/*if(date ( 'w' , $fecha ) == "0"){
					$fecha = strtotime ( '+1 day' , $fecha ) ;
				}else if(date ( 'w' , $fecha ) == "6"){
					$fecha = strtotime ( '+2 day' , $fecha ) ;
				}*/
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
			$fecha = strtotime ( '-7 day' , strtotime ( $fecha ) ) ;

			$max = 0;
			$x = 0;
			$min = 0;
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
				/*if(date ( 'w' , $fecha ) == "0"){
					$fecha = strtotime ( '+1 day' , $fecha ) ;
				}else if(date ( 'w' , $fecha ) == "6"){
					$fecha = strtotime ( '+2 day' , $fecha ) ;
				}*/
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
    options: { cutoutPercentage: 75 }

});

});



</script>