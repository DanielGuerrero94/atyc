@extends('layouts.adminlte')

@section('content')
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
  <div class="col-lg-9 col-xs-12">
    <div class="box box-primary">
      <div class="box-body">
        <div id="accionesPorAnioYMes" style="min-width: 310px;height: 400px; margin: 0 auto"></div>
      </div>
    </div>
  </div>  
  <div class="col-lg-3 col-xs-12" id="efectores-capacitados">
    <div class="info-box bg-aqua">
      <span class="info-box-icon"><i class="fa fa-h-square "></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Efectores capacitados</span>
        <span class="info-box-number"></span>

        <div class="progress">
          <div class="progress-bar" style="width: 20%"></div>
        </div>
        <span class="progress-description">
          20% Increase in 30 Days
        </span>
      </div>
      <!-- /.info-box-content -->
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

<div class="row" style="margin-right: 5px;margin-left: 5px;">
  <div class="col-lg-12 col-xs-12">
    <div class="box box-default">
      <div class="box-body">
        <div id="pieAccionesTipologia"></div>
      </div>
    </div>
  </div>  
</div>
@endif
@endif
@endsection

@section('script')

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

    // Radialize the colors Deberia ponerselo solo al pie
    /*
    Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
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
        });
        */

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

    $.ajax({
      url: 'dashboard/draw/progress',
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

    $.ajax({
      url: 'dashboard/draw/first',
      dataType: 'json',
      success: function (data) {
        $('#count-acciones').html(data.acciones);
        $('#count-participantes').html(data.participantes);
        $('#count-docentes').html(data.docentes);            
      }
    })
    .done(function() {
      console.log("success counts");
    })
    .fail(function() {
      alert('ajax error first draw');
    })
    .always(function() {

      console.log("complete");

      $.ajax({
        url: 'dashboard/draw/areas',
        dataType: 'json',
        success: function (data) {

          Highcharts.chart('accionesPorAnioYMes', {
            chart: {
              type: 'areaspline'
            },
            title: {
              text: 'Acciones por año y mes (Nación)' 
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
      })
      .done(function() {
        console.log("success areas");
      })
      .fail(function() {
        alert('ajax error areas')
      })
      .always(function() {

        console.log("complete");

        $.ajax({
          url: 'dashboard/draw/trees',
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
                text: 'Cantidad de acciones por temática (Nación)'
              }
            });  

          }
        })
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
                series: data.porcentajeTematica
              });                 

            }
          })
          .done(function() {
            console.log("success pies");
          })
          .fail(function() {
            alert('ajax error pies');
          })
          .always(function() {

            console.log("complete");

            if($('#accionesReportadas').length){

              $.ajax({
                url: 'dashboard/draw/heats',
                dataType: 'json',
                success: function (data) {

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
                      categories: Highcharts.getOptions().lang.months,
                      title: {
                        text: 'Mes'
                      }
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
                      name: 'Acciones',
                      borderWidth: 1,
                      data: data.accionesReportadas,
                      dataLabels: {
                        enabled: true,
                        color: '#000000'
                      }
                    }]
                  });

                }
              })
              .done(function() {
                console.log("success heats");
              })
              .fail(function() {
                alert('ajax error heats');
              });

            } 

          });

        });

});
});
});

</script>
@endsection
@stack('more-scripts')