@extends('layouts.adminlte')
@section('content')
@if(!Auth::guest())
 @include('dashboard.filter')
@endif
<div class="row" style="margin-right: 5px;margin-left: 5px;">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-lg-offset-3">
  <a href="{{url("/alumnos")}}" class="small-box bg-aqua">
   <div class="inner">
    <h3 id="count-participantes"></h3>
    <h4>Participantes</h4>				             
   </div>
   <div class="icon">
    <i class="fa fa-users"></i>
   </div>			
   <div class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></div>			
  </a>
</div>
</div>
<div class="row">
  <div class="col-lg-6 col-xs-12">
    <div class="box box-success">
      <div class="box-body">
        <div id="participantes" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-xs-12">
    <div class="box box-info">
      <div class="box-body">
        <div id="participantes" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
      </div>
    </div>
  </div>   
</div>
@endsection
@section("script")
<!-- Highcharts -->
<script type="text/javascript" src="{{asset("/bower_components/highcharts/highcharts.js")}}"></script>

<!-- Modulos highcharts -->
<script type="text/javascript" src="{{asset("/bower_components/highcharts/modules/exporting.js")}}"></script>

<script type="text/javascript" src="{{asset("/bower_components/highcharts/modules/export-data.js")}}"></script>    

<script type="text/javascript" src="{{asset("/bower_components/highcharts/modules/data.js")}}"></script>

<script type="text/javascript" src="{{asset("/bower_components/highcharts/modules/drilldown.js")}}"></script>

<script type="text/javascript" src="{{asset("/bower_components/highcharts/modules/heatmap.js")}}"></script>

<script type="text/javascript" src="{{asset("/bower_components/highcharts/modules/treemap.js")}}"></script>

<script type="text/javascript">

 function firstCounts(division, anio) {
  return {
   url: '{{url('/dashboard/draw/first')}}',
   data: {
    'division': division,
    'anio': anio
   },
   dataType: 'json',
    success: function (data) {
     $('#count-acciones').html(data.acciones);
     $('#count-participantes').html(data.participantes);
   }
  };
 }

 function areasChart(division, anio) {
    return {
      url: '{{url('/dashboard/draw/areas')}}',
      data: {
        'division': division,
        'anio': anio
      },
      dataType: 'json',
      success: function (data) {

        Highcharts.chart('accionesPorAnioYMes', {
          chart: {
            type: 'areaspline'
          },
          title: {
            text: 'Acciones por año y mes' 
          },
          xAxis: {
            categories: Highcharts.getOptions().lang.months,
            tickmarkPlacement: 'on',
            title: {
              enabled: false,
              text: 'Mes'
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
          series: data.accionesPorAnioYMes
        });

      }
    };
  }

  function treesCharts(division, anio) {
    return {
      url: '{{url('/dashboard/draw/trees')}}',
      data: {
        'division': division,
        'anio': anio
      },
      dataType: 'json',
      success: function (data) {

        Highcharts.chart('accionesPorTipologia', {
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
            data: data.accionesPorTipologia
          }],
          title: {
            text: 'Cantidad de acciones por tipología'
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
                  return '<span>'+this.point.name.substring(0,20) + '</span>';
                }
              }
            }
          },
          series: [{
            type: 'treemap',
            layoutAlgorithm: 'squarified',
            data: data.accionesPorTematica
          }],
          title: {
            text: 'Cantidad de acciones por temática'
          }
        });  

      }
    };
  }

  //Carga anidadamente todos los graficos
  function load(anio) {

      $.ajax(firstCounts('Nación', anio))
      .done(function() {
        console.log("success counts");
      })
      .fail(function() {
        alert('ajax error first draw');
      })
      .always(function() {

        console.log("complete");

        $.ajax(areasChart('Nación', anio))
        .done(function() {
          console.log("success areas");
        })
        .fail(function() {
          alert('ajax error areas')
        })
        .always(function() {

          console.log("complete");

          $.ajax(treesCharts('Nación', anio))
          .done(function() {
            console.log("success trees");      
          })
          .fail(function() {
            alert('ajax error trees');
          })
          .always(function() {
            console.log("complete");

            $.ajax({
              url: '{{url('dashboard/draw/pies')}}',
              dataType: 'json',
              success: function (data) {
              }
            })
            .always(function() {
              console.log("complete");
            });

          });
        });
      });
  }

  //consigo los totales historicos
  function historicoCounts(division, anio) {
   return {
    url: '{{url('dashboard/draw/first')}}',
    data: {
     'division': 'Nación',
     'anio': 'Histórico'
    },
    dataType: 'json',
     success: function (data) {
      data.acciones;
      data.participantes;
    }
   };
 }

  $(document).ready(function () {

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
    });

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

    load({{date('Y')}});
    'Histórico'
  
  });

</script>
@if(!Auth::guest())
 @include('dashboard.filter-script')
@endif
@endsection
