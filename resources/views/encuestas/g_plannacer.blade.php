@extends('layouts.adminlte')
@section('content')
	<div class="row">		
		<div class="box box-primary">
			<div class="box-body">
				<div class="box-header" style="text-align:center;">
					<div class="box-group" id="accordion">

						@for ($i = 1; $i < 10; $i++)						
						<div class="panel box box-primary">
							<div class="box-header">
								<h4 class="box-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapse_{{ $i }}" aria-expanded="false" class="collapsed" >
										{{ $i }}
									</a>
								</h4>
							</div>
							<div id="collapse_{{ $i }}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
								<div class="box-body">
									<div class="chart">
										<div id="chart_{{ $i }}" style="height: 60%; width: 98%"></div>
									</div>
								</div>
							</div>
						</div>
						@endfor

					</div>
				</div>
			</div>
		</div>
	@endsection
	@section('script')
	<script type="text/javascript">	

$(document).ready(function($) {

    $(".content-header .fa-thumb-tack").parent().on("click", function () {
        alert('asd');
    });


			highcharts_init_options();		

			function encuestas_highcharts(chart,pregunta,datos) {
				Highcharts.chart(chart, {
					chart: {
						type: 'column'
					},
					title: {
						text: pregunta
					},
					subtitle: {
						text: 'Source: <a href="http://en.wikipedia.org/wiki/List_of_cities_proper_by_population">Wikipedia</a>'
					},
					xAxis: {
						type: 'category',
						labels: {
							rotation: -45,
							style: {
								fontSize: '13px',
								fontFamily: 'Verdana, sans-serif'
							}
						}
					},
					yAxis: {
						min: 0,
						title: {
							text: 'Cantidad respuestas'
						}
					},
					legend: {
						enabled: false
					},
					tooltip: {
						pointFormat: 'Respuestas: <b>{point.y:.1f}%</b>'
					},
					plotOptions: {
						series: {
							borderWidth: 0,
							dataLabels: {
								enabled: true,
								format: '{point.y:.1f}%'
							}
						}
					},
					series: datos
				});	
			}

			$.ajax({
				url: 'g_plannacer/datos',
				dataType: 'json',
				complete: function(xhr, textStatus) {
					console.log('complete');
				},
				success: function(data, textStatus, xhr) {
					console.log('success');
					console.log(data.preguntas);

					for (var i = 0; i < size(data.preguntas); i++) {

						var chart = [{
							name: 'Cantidad',
							data: [
							['ESCASO', preguntas[i]],
							['MALO', preguntas[i]],
							['REGULAR', preguntas[i]],
							['BUENO', preguntas[i]],
							['MUY BUENO', preguntas[i]]
							],
						}];
						
						encuestas_highcharts('chart_'+i,pregunta,chart);
					}
				},
				error: function(xhr, textStatus, errorThrown) {
					console.log('error');
				}
			});

			var chart = [{
				name: 'Cantidad',
				data: [
				['ESCASO', 10],
				['MALO', 12],
				['REGULAR', 14],
				['BUENO', 18],
				['MUY BUENO', 19]]
			}];
			encuestas_highcharts('chart_1','asd',chart);

		});

		function highcharts_init_options() {
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
		}	
    </script>
<script type="text/javascript">
alert("Estos graficos estan basados en todos los tipos de pregunta que se reportaban al g_plannacer. Estos mismos graficos pero con puntaje del 0 al 10 se puede hacer para el excel importado desde el google form. Mas adelante hare filtros por provincia, periodo, tipologia de accion y tematica");
</script>
	@endsection

