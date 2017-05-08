@extends('layouts.adminlte')

@section('content')
<div class="row" style="margin-right: 5px;margin-left: 5px;">
	<div class="col-lg-4 col-xs-6">
		<div class="small-box bg-aqua">
			<div class="inner">
				<h3 id="cursos"></h3>
				<p>Cursos</p>
			</div>
			<div class="icon">
				<i class="fa fa-address-book-o"></i>
			</div>
			<a href={{url("/cursos")}} class="small-box-footer">
				Mas informacion <i class="fa fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
	<div class="col-lg-4 col-xs-6">
		<div class="small-box bg-aqua">
			<div class="inner">
				<h3 id="alumnos"></h3>
				<p>Alumnos</p>				             
			</div>
			<div class="icon">
				<i class="fa fa-users"></i>
			</div>			
			<a href={{url("/alumnos")}} class="small-box-footer">Mas informacion <i class="fa fa-arrow-circle-right"></i></a>			
		</div>
	</div>
	<!-- <div class="col-lg-4 col-xs-6">
		<div class="small-box bg-aqua">
			<div class="inner">
				<h3 id="alumnos">15963</h3>
				<p>Alumnos activos</p>				             
			</div>
			<div class="icon">
				<i class="fa fa-users"></i>
			</div>			
			<a href="#" class="small-box-footer">Mas informacion <i class="fa fa-arrow-circle-right"></i> <i class="fa fa-info-circle" title="Activo es aquel alumno que finalizo algun curso en el ultimo período"></i> </a>			
		</div>
	</div> -->
	<div class="col-lg-4 col-xs-6">
		<div class="small-box bg-aqua">
			<div class="inner">
				<h3 id="profesores"></h3>
				<p>Profesores</p>
			</div>
			<div class="icon">
				<i class="fa fa-user-md"></i>
			</div>
			<a href={{url("/profesores")}} class="small-box-footer">
				Mas informacion <i class="fa fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
</div>
<div class="row" style="margin-right: 5px;margin-left: 5px;">
	<div class="col-lg-4 col-xs-6">
		<div class="box box-danger">
			<div class="box-header with-border">
				<h3 class="box-title">Cursos por area tematica</h3>
        <i class="fa fa-pie-chart btn text-primary pull-right">Ver más</i>
			</div>
			<div class="box-body">
				<canvas id="pieAreas" class="pieChart"></canvas>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-xs-6">
		<div class="box box-danger">
			<div class="box-header with-border">
				<h3 class="box-title">Cursos por linea estrategica</h3>
			</div>
			<div class="box-body">
				<canvas id="pieLineas" class="pieChart"></canvas>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-xs-6">
		<div class="box box-danger">
			<div class="box-header with-border">
				<h3 class="box-title">Cursos con mas ediciones</h3>
			</div>
			<div class="box-body">
				<canvas id="pieChart" class="pieChart"></canvas>
			</div>
		</div>
	</div>
</div>
<div class="row" style="margin-right: 5px;margin-left: 5px;">
	<div class="col-lg-4 col-xs-6">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Cursos por año</h3>
			</div>
			<div class="box-body">
				<div class="chart">
					<canvas id="areaChartCursos" class="areaChart"></canvas>
				</div>
			</div>
		</div>
	</div>	
	<div class="col-lg-4 col-xs-6">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Cursos por mes y año</h3>
			</div>
			<div class="box-body">
				<div class="chart">
					<canvas id="areaChart" class="areaChart"></canvas>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-xs-6">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Cursos 2013</h3>
			</div>
			<div class="box-body">
				<div class="chart">
					<canvas id="areaChartCursos2013" class="areaChart"></canvas>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row" style="margin-right: 5px;margin-left: 5px;">
	<div class="col-lg-4 col-xs-6">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Cursos 2014</h3>
			</div>
			<div class="box-body">
				<div class="chart">
					<canvas id="areaChartCursos2014" class="areaChart"></canvas>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-xs-6">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Cursos 2015</h3>
			</div>
			<div class="box-body">
				<div class="chart">
					<canvas id="areaChartCursos2015" class="areaChart"></canvas>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-xs-6">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Cursos 2016</h3>
			</div>
			<div class="box-body">
				<div class="chart">
					<canvas id="areaChartCursos2016" class="areaChart"></canvas>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- <div style="margin: 0px 5px 0px 5px;">
				<div class="progress">
					<div class="progress-bar" style="width: 50%"></div>
				</div>
				<span class="progress-description">
					50% de un total de 
				</span>	
			</div>  -->
			@endsection
			@section('script')
			<script type="text/javascript" src="{{asset("/bower_components/admin-lte/plugins/chartjs/Chart.min.js")}}"></script>

<script type="text/javascript">

	$(document).ajaxStop($.unblockUI);

	$(document).ready(function(){

		/*variables que voy usar para cargar los datos*/
		var alumnos,profesores,cursos,cursos_areas_tematicas,cursos_lineas_estrategicas,cursos2013,cursos2014,cursos2015,cursos2016;

		$.blockUI({ 
			css: {
				border: 'none',
				padding: '15px',
				backgroundColor: '#000',
				'-webkit-border-radius': '10px',
				'-moz-border-radius': '10px',
				opacity: .5,
				color: '#fff'
			},		
			message: 'Cargando...', 
		});

		$.ajax ({
			url: 'dashboard/datos',
			method: 'get',
			dataType: 'json',
			success: function(data){
				console.log(data);
				alumnos = data.alumnos;
				profesores = data.profesores;
				cursos = data.cursos;
				cursos_areas_tematicas = data.cursos_areas_tematicas;
				cursos_lineas_estrategicas = data.cursos_lineas_estrategicas;
				cursos2013 = $.map(data.cursos2013, function(el) { return el.cantidad });
				cursos2014 = $.map(data.cursos2014, function(el) { return el.cantidad });
				cursos2015 = $.map(data.cursos2015, function(el) { return el.cantidad });
				cursos2016 = $.map(data.cursos2016, function(el) { return el.cantidad });
				console.log(cursos2015);

				/*Empiezo a hacer cosas*/

				$('#cursos').html(cursos);
				$('#alumnos').html(alumnos);
				$('#profesores').html(profesores);
				//--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvasCursos = $("#areaChartCursos").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var areaChartCursos = new Chart(areaChartCanvasCursos);

    var areaChartDataCursos = {
    	labels: ["2013", "2014", "2015", "2016"],
    	datasets: [
    	{
    		label: "Electronics",
    		fillColor: "rgba(60,141,188,0.9)",
    		strokeColor: "rgba(60,141,188,0.8)",
    		pointColor: "#3b8bba",
    		pointStrokeColor: "rgba(60,141,188,1)",
    		pointHighlightFill: "#fff",
    		pointHighlightStroke: "rgba(60,141,188,1)",
    		data: [1393, 1926, 2576, 1562]
    	}
    	]
    };

    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: false,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - Whether the line is curved between points
      bezierCurve: true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension: 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot: false,
      //Number - Radius of each point dot in pixels
      pointDotRadius: 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth: 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius: 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke: true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth: 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true
  };

    //Create the line chart
    areaChartCursos.Line(areaChartDataCursos, areaChartOptions);

    var labels_meses = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"]

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvasCursos2013 = $("#areaChartCursos2013").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var areaChartCursos2013 = new Chart(areaChartCanvasCursos2013);

    var areaChartDataCursos2013 = {
    	labels: labels_meses,
    	datasets: [
    	{
    		label: "Electronics",
    		fillColor: "rgba(60,141,188,0.9)",
    		strokeColor: "rgba(60,141,188,0.8)",
    		pointColor: "#3b8bba",
    		pointStrokeColor: "rgba(60,141,188,1)",
    		pointHighlightFill: "#fff",
    		pointHighlightStroke: "rgba(60,141,188,1)",
    		data: cursos2013
    	}
    	]
    };

    //Create the line chart
    areaChartCursos2013.Line(areaChartDataCursos2013, areaChartOptions);

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvasCursos2014 = $("#areaChartCursos2014").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var areaChartCursos2014 = new Chart(areaChartCanvasCursos2014);

    var areaChartDataCursos2014 = {
    	labels: labels_meses,
    	datasets: [
    	{
    		label: "Electronics",
    		fillColor: "rgba(60,141,188,0.9)",
    		strokeColor: "rgba(60,141,188,0.8)",
    		pointColor: "#3b8bba",
    		pointStrokeColor: "rgba(60,141,188,1)",
    		pointHighlightFill: "#fff",
    		pointHighlightStroke: "rgba(60,141,188,1)",
    		data: cursos2014
    	}
    	]
    };

    //Create the line chart
    areaChartCursos2014.Line(areaChartDataCursos2014, areaChartOptions);

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvasCursos2015 = $("#areaChartCursos2015").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var areaChartCursos2015 = new Chart(areaChartCanvasCursos2015);

    var areaChartDataCursos2015 = {
    	labels: labels_meses,
    	datasets: [
    	{
    		label: "Electronics",
    		fillColor: "rgba(60,141,188,0.9)",
    		strokeColor: "rgba(60,141,188,0.8)",
    		pointColor: "#3b8bba",
    		pointStrokeColor: "rgba(60,141,188,1)",
    		pointHighlightFill: "#fff",
    		pointHighlightStroke: "rgba(60,141,188,1)",
    		data: cursos2015
    	}
    	]
    };

    //Create the line chart
    areaChartCursos2015.Line(areaChartDataCursos2015, areaChartOptions);

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvasCursos2016 = $("#areaChartCursos2016").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var areaChartCursos2016 = new Chart(areaChartCanvasCursos2016);

    var areaChartDataCursos2016 = {
    	labels: labels_meses,
    	datasets: [
    	{
    		label: "Electronics",
    		fillColor: "rgba(60,141,188,0.9)",
    		strokeColor: "rgba(60,141,188,0.8)",
    		pointColor: "#3b8bba",
    		pointStrokeColor: "rgba(60,141,188,1)",
    		pointHighlightFill: "#fff",
    		pointHighlightStroke: "rgba(60,141,188,1)",
    		data: cursos2016
    	}
    	]
    };

    //Create the line chart
    areaChartCursos2016.Line(areaChartDataCursos2016, areaChartOptions);

        // Get context with jQuery - using jQuery's .get() method.
        var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var areaChart = new Chart(areaChartCanvas);

    var areaChartData = {
    	labels: labels_meses,
    	datasets: [    	
    	{
    		label: "2015",
    		fillColor: "#9BE18D",
    		strokeColor: "rgba(210, 214, 222, 1)",
    		pointColor: "rgba(210, 214, 222, 1)",
    		pointStrokeColor: "#c1c7d1",
    		pointHighlightFill: "#fff",
    		pointHighlightStroke: "rgba(220,220,220,1)",
    		data: cursos2015
    	},
    	{
    		label: "2013",
    		fillColor: "#BBAAE8",
    		strokeColor: "rgba(210, 214, 222, 1)",
    		pointColor: "rgba(210, 214, 222, 1)",
    		pointStrokeColor: "#c1c7d1",
    		pointHighlightFill: "#fff",
    		pointHighlightStroke: "rgba(220,220,220,1)",
    		data: cursos2013
    	},
    	{
    		label: "2014",
    		fillColor: "rgba(60,141,188,0.9)",
    		strokeColor: "rgba(60,141,188,0.8)",
    		pointColor: "#3b8bba",
    		pointStrokeColor: "rgba(60,141,188,1)",
    		pointHighlightFill: "#fff",
    		pointHighlightStroke: "rgba(60,141,188,1)",
    		data: cursos2014
    	},
    	{
    		label: "2016",
    		fillColor: "#BCF3F4",
    		strokeColor: "rgba(60,141,188,0.8)",
    		pointColor: "#3b8bba",
    		pointStrokeColor: "rgba(60,141,188,1)",
    		pointHighlightFill: "#fff",
    		pointHighlightStroke: "rgba(60,141,188,1)",
    		data: cursos2016
    	}
    	]
    };

    //Create the line chart
    areaChart.Line(areaChartData, areaChartOptions);


	//-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas);
    var pieOptions = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke: true,
      //String - The colour of each segment stroke
      segmentStrokeColor: "#fff",
      //Number - The width of each segment stroke
      segmentStrokeWidth: 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps: 100,
      //String - Animation easing effect
      animationEasing: "easeOutBounce",
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate: true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale: false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
  };
  var PieData = [
  {
  	value: 700,
  	color: "#f56954",
  	highlight: "#f56954",
  	label: "Chrome"
  },
  {
  	value: 500,
  	color: "#00a65a",
  	highlight: "#00a65a",
  	label: "IE"
  },
  {
  	value: 400,
  	color: "#f39c12",
  	highlight: "#f39c12",
  	label: "FireFox"
  },
  {
  	value: 600,
  	color: "#00c0ef",
  	highlight: "#73c1ef",
  	label: "Safari"
  },
  {
  	value: 300,
  	color: "#3c8dbc",
  	highlight: "#3c8def",
  	label: "Opera"
  },
  {
  	value: 100,
  	color: "#d2d6de",
  	highlight: "#d2d6de",
  	label: "Navigator"
  }
  ];

    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions);

    var pieChartCanvasAreas = $("#pieAreas").get(0).getContext("2d");
    var pieChartAreas = new Chart(pieChartCanvasAreas);
    var PieAreas = [
    {
    	value: 2639,
    	color: "#f56954",
    	highlight: "#f56954",
    	label: "Contenidos formativos en competencias de gestión en salud"
    },
    {
    	value: 1832,
    	color: "#00a65a",
    	highlight: "#00a65a",
    	label: "Contenidos formativos en competencias de habilidades y conducta"
    },
    {
    	value: 1021,
    	color: "#f39c12",
    	highlight: "#f39c12",
    	label: "Contenidos formativos en modelo de atención en salud"
    },
    {
    	value: 625,
    	color: "#00c0ef",
    	highlight: "#73c1ef",
    	label: "Ampliación Programa Sumar"
    },
    {
    	value: 274,
    	color: "#3c8dbc",
    	highlight: "#3c8def",
    	label: "Estrategia de Efectores Priorizados"
    },
    {
    	value: 269,
    	color: "#d2d6de",
    	highlight: "#d2d6de",
    	label: "Contenidos formativos en promoción y prevención de la salud y abordaje desde una perspectiva de derechos"
    }
    ];    
    pieChartAreas.Doughnut(PieAreas, pieOptions);

    var pieChartCanvasLineas = $("#pieLineas").get(0).getContext("2d");
    var pieChartLineas = new Chart(pieChartCanvasLineas);
    var PieLineas = [
    {
    	value: 3056,
    	color: "#f56954",
    	highlight: "#f56954",
    	label: "AC DE APRENDISAJE Y FORMACIÓN/CURSOS PRESENCIALES"
    },
    {
    	value: 1283,
    	color: "#00a65a",
    	highlight: "#00a65a",
    	label: "AC DE ASISTENCIA TÉCNICA / PROYECTOS PEATYC"
    },
    {
    	value: 1231,
    	color: "#f39c12",
    	highlight: "#f39c12",
    	label: "AC DE ASISTENCIA TÉCNICA / TUTORÍA , ASIST TECNICA, VISITAS"
    },
    {
    	value: 742,
    	color: "#00c0ef",
    	highlight: "#73c1ef",
    	label: "AC DE APRENDISAJE Y FORMACIÓN/TALLERES"
    },
    {
    	value: 230,
    	color: "#3c8dbc",
    	highlight: "#3c8def",
    	label: "AC DE DESARROLLO DE CONTENIDOS"
    },
    {
    	value: 230,
    	color: "#d2d6de",
    	highlight: "#d2d6de",
    	label: "AC DE APRENDISAJE Y FORMACIÓN/BECAS"
    }
    ];    
    pieChartLineas.Doughnut(PieLineas, pieOptions);




},
error: function() {
	alert("No se pudo cargar la informacion.");
}
});



});

</script> 

@endsection