@extends('layouts.adminlte')

@section('content')
<div class="row" style="margin-right: 5px;margin-left: 5px;">
	<div class="col-lg-4 col-xs-6">
		<div class="small-box bg-aqua">
			<div class="inner">
				<h3 id="cursos"></h3>
				<p>Acciones</p>
			</div>
			<div class="icon">
				<i class="fa fa-address-book-o"></i>
			</div>
			<a href={{url("/cursos")}} class="small-box-footer">
				Más información <i class="fa fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
	<div class="col-lg-4 col-xs-6">
		<div class="small-box bg-aqua">
			<div class="inner">
				<h3 id="alumnos"></h3>
				<p>Participantes</p>				             
			</div>
			<div class="icon">
				<i class="fa fa-users"></i>
			</div>			
			<a href={{url("/alumnos")}} class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>			
		</div>
	</div>
	<div class="col-lg-4 col-xs-6">
		<div class="small-box bg-aqua">
			<div class="inner">
				<h3 id="profesores"></h3>
				<p>Docentes</p>
			</div>
			<div class="icon">
				<i class="fa fa-user-md"></i>
			</div>
			<a href={{url("/profesores")}} class="small-box-footer">
				Más información <i class="fa fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
</div>
<div class="row">
  <div class="col-lg-12 col-xs-12">
    <div class="box box-primary">
      <div class="box-body">
        <div id="highchart_acciones" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
      </div>
    </div>
  </div>  
</div>
<div class="row">
  <div class="col-lg-6 col-xs-12">
    <div class="box box-success">
      <div class="box-body">
        <div id="accionesPorTipo" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-xs-12">
    <div class="box box-info">
      <div class="box-body">
        <div id="accionesPorTematica" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
      </div>
    </div>
  </div>   
</div>
@if(!Auth::guest())
@if(Auth::user()->id_provincia == 25)
<div class="row">
  <div class="col-lg-12 col-xs-12">
    <div class="box box-success">
      <div class="box-body">
        <div id="accionesReportadas" style="min-width: 310px; height: 600px; margin: 0 auto"></div>
      </div>
    </div>
  </div>
</div>
@endif
@endif
<div class="row" style="margin-right: 5px;margin-left: 5px;">
  <div class="col-lg-12 col-xs-12">
    <div class="box box-default">
      <div class="box-body">
        <div id="pieAccionesTipologia"></div>
      </div>
    </div>
  </div>  
</div>



<!-- <div class="row" style="margin-right: 5px;margin-left: 5px;">
  <div class="col-lg-4 col-xs-6">
    <div class="box box-danger">
      <div class="box-header with-border">
        <h3 class="box-title">Acciones por area temática</h3>
      </div>
      <div class="box-body">
        <canvas id="pieAreas" class="pieChart"></canvas>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-xs-6">
    <div class="box box-danger">
     <div class="box-header with-border">
      <h3 class="box-title">Acciones por tipología</h3>
    </div>
    <div class="box-body">
      <canvas id="pieLineas" class="pieChart"></canvas>
    </div>
  </div>
</div>
<div class="col-lg-4 col-xs-6">
  <div class="box box-danger">
   <div class="box-header with-border">
    <h3 class="box-title">Provincias que más acciones realizaron</h3>
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
				<h3 class="box-title">Acciones por año</h3>
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
				<h3 class="box-title">Acciones por mes y año</h3>
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
				<h3 class="box-title">Acciones 2013</h3>
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
				<h3 class="box-title">Acciones 2014</h3>
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
				<h3 class="box-title">Acciones 2015</h3>
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
				<h3 class="box-title">Acciones 2016</h3>
			</div>
			<div class="box-body">
				<div class="chart">
					<canvas id="areaChartCursos2016" class="areaChart"></canvas>
				</div>
			</div>
		</div>
	</div>
</div> -->
<!--<div class="row" style="margin-right: 5px;margin-left: 5px;">
  <div id="highchart"></div>  
</div>-->
<div class="row" style="margin-right: 5px;margin-left: 5px;">
  <div id="columnDrilldown"></div>  
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
		var alumnos,profesores,cursos,cursos_areas_tematicas,cursos_lineas_estrategicas,cursos_por_provincia,cursos_por_anio,cursos2013,cursos2014,cursos2015,cursos2016;

    function data_to_pie_chart_highcharts() {

    };

    Highcharts.setOptions({
      lang: {        
        contextButtonTitle: "Menu exportar",
        decimalPoint: ".",
        downloadJPEG: "Descargar imagen JPEG",
        downloadPDF: "Descargar documento PDF",
        downloadPNG: "Descargar imagen PNG",
        downloadSVG: "Descargar vector imagen SVG",
        downloadCSV: 'Descargar CSV',
        downloadXLS: 'Descargar XLS',
        viewData: 'Ver data table',
        drillUpText: "Volver a {series.name}",
        loading: "Cargando...",
        months: [ "Enero" , "Febrero" , "Marzo" , "Abril" , "Mayo" , "Junio" , "Julio" , "Agosto" , "Septiembre" , "Octubre" , "Noviembre" , "Diciembre"],
        noData: "No hay datos para mostrar",
        numericSymbolMagnitude: 1000,
        numericSymbols: [ "k" , "M" , "G" , "T" , "P" , "E"],
        printChart: "Imprimir Gráfico",
        resetZoom: "Reiniciar zoom",
        resetZoomTitle: "Reiniciar zoom 1:1",
        shortMonths: [ "Ene" , "Feb" , "Mar" , "Abr" , "May" , "Jun" , "Jul" , "Ago" , "Sep" , "Oct" , "Nov" , "Dic"],
        shortWeekdays: undefined,
        thousandsSep: " ",
        weekdays: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"]
      }
    });

    /*Highcharts.chart('highchart', {

      title: {
        text: 'Solar Employment Growth by Sector, 2010-2016'
      },

      subtitle: {
        text: 'Source: thesolarfoundation.com'
      },

      yAxis: {
        title: {
          text: 'Number of Employees'
        }
      },
      legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
      },

      plotOptions: {
        series: {
          pointStart: 2010
        }
      },

      series: [{
        name: 'Installation',
        data: [43934, 52503, 57177, 69658, 97031, 119931, 137133, 154175]
      }, {
        name: 'Manufacturing',
        data: [24916, 24064, 29742, 29851, 32490, 30282, 38121, 40434]
      }, {
        name: 'Sales & Distribution',
        data: [11744, 17722, 16005, 19771, 20185, 24377, 32147, 39387]
      }, {
        name: 'Project Development',
        data: [null, null, 7988, 12169, 15112, 22452, 34400, 34227]
      }, {
        name: 'Other',
        data: [12908, 5948, 8105, 11248, 8989, 11816, 18274, 18111]
      }]

    });*/




// Radialize the colors Deberia ponerselo solo al pie
/*Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
  return {
    radialGradient: {
      cx: 0.5,
      cy: 0.3,
      r: 0.7
    },
    stops: [
    [0, color],
            [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
            ]
          };
        });*/



// Make monochrome colors and set them as default for all pies
Highcharts.getOptions().plotOptions.pie.colors = (function () {
  var colors = [],
  base = Highcharts.getOptions().colors[2],
  i;

  for (i = 0; i < 10; i += 1) {
        // Start out with a darkened base color (negative brighten), and end
        // up with a much brighter color
        colors.push(Highcharts.Color(base).brighten((i - 3) / 7).get());
      }
      return colors;
    }());

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

function data_to_pie_chart(data,colors,highlights) {
  var sorted = data.sort(function (a,b){ return b.value-a.value});
  var sliced = sorted.slice(0,6);
  var mapeado = $.map(sliced, function(elem) {
    var item = {};
    item ['label'] = elem.label.substring(0,24) + "...";
    item ['value'] = elem.value;
    item ['color'] = colors.shift();
    item ['highlight'] = highlights.shift();
    return item;
  });
  return mapeado; 
}

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
  cursos_por_provincia = data.cursos_por_provincia;
  cursos_por_anio = $.map(data.cursos_por_anio, function(el) { return el.cantidad });
  cursos2013 = $.map(data.cursos2013, function(el) { return el.cantidad });
  cursos2014 = $.map(data.cursos2014, function(el) { return el.cantidad });
  cursos2015 = $.map(data.cursos2015, function(el) { return el.cantidad });
  cursos2016 = $.map(data.cursos2016, function(el) { return el.cantidad });
  cursos_lineas_estrategicas_hc = data.cursos_lineas_estrategicas_hc;
  cursos_por_anio_hc = data.cursos_por_anio_hc;
  cursos_por_anio_y_mes_hc = data.cursos_por_anio_y_mes_hc;
  accionesAnioMes = data.accionesAnioMes;
  accionesPorTipo = data.accionesPorTipo;
  accionesPorTematica = data.accionesPorTematica;
  accionesReportadas = data.accionesReportadas;

  /*Empiezo a hacer cosas*/

  $('#cursos').html(cursos);
  $('#alumnos').html(alumnos);
  $('#profesores').html(profesores);

        //Todos los arrays con los colores son downgrades
        var colores_pie_areas = ["#6591BC","#749cc2","#83a7c9","#93b2d0","#a2bdd6","#b2c8dd"];
        var highlights_pie_areas = ["#83a7c9","#93b2d0","#a2bdd6","#b2c8dd","#c1d3e4","#d0deea"];

        var colores_pie_lineas = ["#5f826e", "#6f8e7c", "#7e9b8b", "#8fa799", "#9fb4a8", "#afc0b6"];
        var highlights_pie_lineas = ["#7e9b8b", "#8fa799", "#9fb4a8", "#afc0b6", "#bfcdc5", "#cfd9d3"];
        
        var colores_pie_por_provincia = ["#c1b989","#c7c094","#cdc7a0","#d3ceac","#d9d5b8","#e0dcc4"];
        var highlights_pie_por_provincia = ["#cdc7a0","#d3ceac","#d9d5b8","#e0dcc4","#e6e3cf","#eceadb"];



        //De los pie charts solo quiero un top 6 para llenarlo 
        var data_pie_chart_areas = data_to_pie_chart(cursos_areas_tematicas,colores_pie_areas,highlights_pie_areas);
        console.log(data_pie_chart_areas);

        var data_pie_chart_lineas = data_to_pie_chart(cursos_lineas_estrategicas,colores_pie_lineas,highlights_pie_lineas);
        console.log(data_pie_chart_lineas);

        var data_pie_chart_provincias = data_to_pie_chart(cursos_por_provincia,colores_pie_por_provincia,highlights_pie_por_provincia);
        console.log(data_pie_chart_provincias);        


// Build the chart
Highcharts.chart('pieAccionesTipologia', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie',
  },
  title: {
    text: 'Acciones por tipología'
  },
  tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      dataLabels: {
        enabled: true,
        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
        style: {
          color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
        },
        connectorColor: 'silver'
      },
      size : 300
    }
  },  
  series: cursos_lineas_estrategicas_hc
});

Highcharts.chart('highchart_acciones', {

  chart: {
    type: 'areaspline',    
  },
  title: {
    text: 'Acciones por año y mes (Nación)' 
  },
  xAxis: {
    categories: [
    'Enero',
    'Febrero',
    'Marzo',
    'Abril',
    'Mayo',
    'Junio',
    'Julio',
    'Agosto',
    'Septiembre',
    'Octubre',
    'Noviembre',
    'Diciembre'
    ],
    tickmarkPlacement: 'on',
    title: {
      enabled: false
    }
  },
  yAxis: {
    title: {
      text: 'Acciones'
    }
  },
  tooltip: {
    shared: true,
    valueSuffix: ' acciones'
  },
  plotOptions: {
    areaspline: {
      fillOpacity: 0.5
    }  
  },
  series: accionesAnioMes
});

Highcharts.chart('accionesPorTipo', {
  colorAxis: {
    minColor: '#FFFFFF',
    maxColor: Highcharts.getOptions().colors[2]
  },
  plotOptions: {
    treemap: {
      allowPointSelect: true,
      point: {
        events: {
          click: function (e) {
            console.log(this.name);
            console.log($(this));
            alert(this.name);
          }
        }
      },
      tooltip: {
        pointFormatter: function () {
          return this.name + ': ' + this.label + ' <b>' + this.value + '</b> acciones.';
        }
      }
    }
  },
  series: [{
    type: 'treemap',
    layoutAlgorithm: 'squarified',
    data: accionesPorTipo
  }],
  title: {
    text: 'Cantidad de acciones por tipología (Nación)'
  }
});

Highcharts.chart('accionesPorTematica', {
  colorAxis: {
    minColor: '#FFFFFF',
    maxColor: Highcharts.getOptions().colors[0]
  },
  legend: {
    labelFormat: "{name.substring(1,12)}"
  },
  plotOptions: {
    treemap: {
      dataLabels: {
        formatter: function () {
          console.log(this.point.name);
          return '<span>'+this.point.name.substring(0,20) + '</span>';
        }
      }
    }
  },
  series: [{
    type: 'treemap',
    layoutAlgorithm: 'squarified',
    data: accionesPorTematica
  }],
  title: {
    text: 'Cantidad de acciones por temática (Nación)'
  }
});


Highcharts.chart('accionesReportadas', {

    chart: {
        type: 'heatmap',
        marginTop: 40,
        marginBottom: 80,
        plotBorderWidth: 1
    },


    title: {
        text: 'Acciones reportadas al sistema este año'
    },

    xAxis: {
        categories: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']
    },

    yAxis: {
        categories: ['CABA','BUENOS AIRES','CATAMARCA','CORDOBA','CORRIENTES','ENTRE RIOS','JUJUY','LA RIOJA','MENDOZA','SALTA','SAN JUAN','SAN LUIS','SANTA FE','SANTIAGO DEL ESTERO','CHACO','TUCUMAN','CHUBUT','FORMOSA','LA PAMPA','MISIONES','NEUQUEN','RIO NEGRO','SANTA CRUZ','TIERRA DEL FUEGO'],
        title: null
    },

    colorAxis: {
        min: 0,
        minColor: '#FFFFFF',
        maxColor: Highcharts.getOptions().colors[0]
    },

    legend: {
        align: 'right',
        layout: 'vertical',
        margin: 0,
        verticalAlign: 'top',
        y: 25,
        symbolHeight: 280
    },

    tooltip: {
        formatter: function () {
            return '<b>' + this.series.yAxis.categories[this.point.y] + '</b> reporto <br><b>' +
                this.point.value + '</b> acciones en <br><b>' + this.series.xAxis.categories[this.point.x] + '</b>';
        }
    },

    series: [{
        name: 'Sales per employee',
        borderWidth: 1,
        data: accionesReportadas,
        dataLabels: {
            enabled: true,
            color: '#000000'
        }
    }]

});

				//--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvasCursos = $("#areaChartCursos").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var areaChartCursos = new Chart(areaChartCanvasCursos);

    var areaChartDataCursos = {
    	labels: ["2013", "2014", "2015", "2016", "2017"],
    	datasets: [
    	{
    		label: "Electronics",
    		fillColor: "rgba(60,141,188,0.9)",
    		strokeColor: "rgba(60,141,188,0.8)",
    		pointColor: "#3b8bba",
    		pointStrokeColor: "rgba(60,141,188,1)",
    		pointHighlightFill: "#fff",
    		pointHighlightStroke: "rgba(60,141,188,1)",
    		data: cursos_por_anio
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
    		label: "2013",
    		fillColor: "#6591BC",
    		strokeColor: "rgba(210, 214, 222, 1)",
    		pointColor: "#6591BC",
    		pointStrokeColor: "#c1c7d1",
    		pointHighlightFill: "#fff",
    		pointHighlightStroke: "rgba(220,220,220,1)",
    		data: cursos2013
    	},
    	{
    		label: "2014",
    		fillColor: "#749cc2",
    		strokeColor: "rgba(60,141,188,0.8)",
    		pointColor: "#749cc2",
    		pointStrokeColor: "rgba(60,141,188,1)",
    		pointHighlightFill: "#fff",
    		pointHighlightStroke: "rgba(60,141,188,1)",
    		data: cursos2014
    	},
      {
        label: "2015",
        fillColor: "#83a7c9",
        strokeColor: "#2ffc6d",
        pointColor: "#83a7c9",
        pointStrokeColor: "#aeefc2",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(220,220,220,1)",
        data: cursos2015
      },
      {
        label: "2016",
        fillColor: "#93b2d0",
        strokeColor: "rgba(60,141,188,0.8)",
        pointColor: "#93b2d0",
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

    //Pie provincias
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas);
    pieChart.Doughnut(data_pie_chart_provincias, pieOptions);

    //Pie areas
    var pieChartCanvasAreas = $("#pieAreas").get(0).getContext("2d");
    var pieChartAreas = new Chart(pieChartCanvasAreas);
    pieChartAreas.Doughnut(data_pie_chart_areas, pieOptions);

    //Pie lineas
    var pieChartCanvasLineas = $("#pieLineas").get(0).getContext("2d");
    var pieChartLineas = new Chart(pieChartCanvasLineas);
    pieChartLineas.Doughnut(data_pie_chart_lineas, pieOptions);

  },
  error: function() {
   alert("No se pudo cargar la información.");
 }
});



});

</script> 

@endsection
