@extends('layouts.adminlte')

@section('content')
@if(!Auth::guest())
@include('dashboard.filter')
@endif
<div class="row" style="margin-right: 5px;margin-left: 5px;">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
    <div class="small-box bg-aqua">
     <div class="inner">
      <h3 id="count-acciones"></h3>
      <h4>Acciones</h4>
    </div>
    <div class="icon">
      <i class="fa fa-address-book-o"></i>
    </div>
    <a href={{url("/cursos")}} class="small-box-footer">
      Más información <i class="fa fa-arrow-circle-right"></i>
    </a>
  </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
  <div class="small-box bg-aqua">
   <div class="inner">
    <h3 id="count-participantes"></h3>
    <h4>Participantes</h4>				             
  </div>
  <div class="icon">
    <i class="fa fa-users"></i>
  </div>			
  <a href={{url("/alumnos")}} class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>			
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
  <div class="small-box bg-aqua">
   <div class="inner">
    <h3 id="count-docentes"></h3>
    <h4>Docentes</h4>
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
  <div class="col-lg-3 col-xs-12">
    <div class="info-box bg-teal" id="progreso-pac">
      <span class="info-box-icon"><i class="fa fa-sitemap"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Cantidad de Acciones <br> de Capacitación Planificadas</span>
        <span class="info-box-number" id="planificadas1">0</span>
        <div class="progress" style="height: 1.45rem;">
          <div class="progress-bar">

          </div>
        </div>
        <span class="progress-description">
          Ejecutadas <span id='ejecutadas'>0</span> / <span id='planificadas2'>0</span> Planificadas.
        </span>
      </div>
    </div>
    <div class="info-box bg-teal" id="efectores-capacitados">
      <span class="info-box-icon"><i class="fa fa-h-square"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Efectores <br>capacitados</span>
        <span class="info-box-number">0</span>
      </div>
    </div>
    <div class="info-box bg-teal" id="fichas-aprobadas">
      <span class="info-box-icon"><i class="fa fa-scribd"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Fichas Técnicas <br> Aprobadas</span>
        <span class="info-box-number">0</span>
      </div>      
    </div>
    <div class="info-box bg-teal">
      <span class="info-box-icon"><i class="fa fa-telegram"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Simulador de <br>  Mejora de <br>Facturación</span>
        <span class="info-box-number">Proximamente</span>
      </div>      
    </div>
  </div>
  <div class="col-lg-9 col-xs-12">
    <div class="box box-primary">
      <div class="box-body">
        <div id="accionesPorAnioYMes" style="min-width: 310px;height: 400px; margin: 0 auto"></div>
      </div>
    </div>
  </div>  
</div>
<div class="row">
  <div class="col-lg-6 col-xs-12">
    <div class="box box-success">
      <div class="box-body">
        <div id="accionesPorTipologia" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
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
      url: 'dashboard/draw/first',
      data: {
        'division': division,
        'anio': anio
      },
      dataType: 'json',
      success: function (data) {
        $('#count-acciones').html(data.acciones);
        $('#count-participantes').html(data.participantes);
        $('#count-docentes').html(data.docentes);            
      }
    };
  }

  function progressCounts(division, anio) {
    return {
      url: 'dashboard/draw/progress',
      data: {
        'division': division,
        'anio': anio
      },
      dataType: 'json',
      success: function (data) {
          console.log(data);
        $("p").remove();
        $("#efectores-capacitados").find(".info-box-number").html(data.capacitados);
        // $("#talleres-sumarte").find(".info-box-number").html(data.talleres);
        $("#fichas-aprobadas").find(".info-box-number").html(data.fichas_aprobadas);
        $("#progreso-pac").find("#planificadas1").html(data.planificadas);
        $("#progreso-pac").find("#planificadas2").html(data.planificadas);
        $("#progreso-pac").find("#ejecutadas").html(data.ejecutadas);
        let porcentaje = data.planificadas != 0 ? (data.ejecutadas/data.planificadas) * 100 : 0;
        $("#progreso-pac").find(".progress-bar").css('width', ''+porcentaje+'%');
        $("#progreso-pac").find(".progress-bar").append('<p style="color: black;">'+Math.round(porcentaje)+'% </p>');
        
      }
    };
  }

  function areasChart(division, anio) {
    return {
      url: 'dashboard/draw/areas',
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
      url: 'dashboard/draw/trees',
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

  $(document).ajaxStop($.unblockUI);  

  $(document).ready(function(){

    // Instance the tour


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


    function load(anio) {
/*
      $.ajax({
        url: 'dashboard/draw/progress',
        data: {anio: 0},
        dataType: 'json',
        success: function (data) {
          console.log(data);
          let total = data.capacitados + "/" + data.efectores;
          let porcentaje = data.capacitados * 100 / data.efectores;
          $("#efectores-capacitados").find(".info-box-number").html(total);
          $("#efectores-capacitados").find(".progress-bar").css('width', porcentaje + "%");
        }
      }).
      fail(function() {
        alert('ajax error progress');
      });
      */

      $.ajax(progressCounts('Nación', 'Histórico'))
      .done(function() {
        console.log("success progress counts");
      })
      .fail(function() {
        alert('ajax error progress');
      });

      $.ajax(firstCounts('Nación', 'Histórico'))
      .done(function() {
        console.log("success counts");
      })
      .fail(function() {
        alert('ajax error first draw');
      })
      .always(function() {

        console.log("complete");

        $.ajax(areasChart('Nación', 'Histórico'))
        .done(function() {
          console.log("success areas");
        })
        .fail(function() {
          alert('ajax error areas')
        })
        .always(function() {

          console.log("complete");

          $.ajax(treesCharts('Nación', 'Histórico'))
          .done(function() {
            console.log("success trees");      
          })
          .fail(function() {
            alert('ajax error trees');
          })
          .always(function() {
            console.log("complete");

            $.ajax({
              url: 'dashboard/draw/pies',
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
    load(0);
  });

</script>
@if(!Auth::guest())
@include('dashboard.filter-script')
@endif
@endsection
@stack('more-scripts')
