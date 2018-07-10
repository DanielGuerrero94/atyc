@extends('layouts.adminlte')

@section('content')
<div class="row" style="margin-right: 5px;margin-left: 5px;">
 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-lg-offset-3">
  <a href="{{url("/cursos")}}" class="small-box bg-aqua">
   <div class="inner">
    <h3 id="count-acciones"></h3>
    <h4>Acciones</h4>
   </div>
   <div class="icon">
    <i class="fa fa-address-book-o"></i>
   </div>
   <div class="small-box-footer">
    Más información <i class="fa fa-arrow-circle-right"></i>
   </div>
  </a>
 </div>
</div>
<div class="row">
 <div class="col-lg-12 col-xs-12">
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
<div class="row">
  <div class="col-lg-12 col-xs-12">
    <div class="box box-success">
      <div class="box-body">
        <div id="pieTipologia" style="min-width: 310px; max-width: 600px; height: 400px; margin: 0 auto"></div>
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

// Create the chart
Highcharts.chart('pieTipologia', {
    chart: {
        type: 'pie'
    },
    title: {
        text: 'Browser market shares. January, 2018'
    },
    subtitle: {
        text: 'Click the slices to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
    },
    plotOptions: {
        series: {
            dataLabels: {
                enabled: true,
                format: '{point.name}: {point.y:.1f}%'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
    },

    "series": [
        {
            "name": "Browsers",
            "colorByPoint": true,
            "data": [
                {
                    "name": "Chrome",
                    "y": 62.74,
                    "drilldown": "Chrome"
                },
                {
                    "name": "Firefox",
                    "y": 10.57,
                    "drilldown": "Firefox"
                },
                {
                    "name": "Internet Explorer",
                    "y": 7.23,
                    "drilldown": "Internet Explorer"
                },
                {
                    "name": "Safari",
                    "y": 5.58,
                    "drilldown": "Safari"
                },
                {
                    "name": "Edge",
                    "y": 4.02,
                    "drilldown": "Edge"
                },
                {
                    "name": "Opera",
                    "y": 1.92,
                    "drilldown": "Opera"
                },
                {
                    "name": "Other",
                    "y": 7.62,
                    "drilldown": null
                }
            ]
        }
    ],
    "drilldown": {
        "series": [
            {
                "name": "Chrome",
                "id": "Chrome",
                "data": [
                    [
                        "v65.0",
                        0.1
                    ],
                    [
                        "v64.0",
                        1.3
                    ],
                    [
                        "v63.0",
                        53.02
                    ],
                    [
                        "v62.0",
                        1.4
                    ],
                    [
                        "v61.0",
                        0.88
                    ],
                    [
                        "v60.0",
                        0.56
                    ],
                    [
                        "v59.0",
                        0.45
                    ],
                    [
                        "v58.0",
                        0.49
                    ],
                    [
                        "v57.0",
                        0.32
                    ],
                    [
                        "v56.0",
                        0.29
                    ],
                    [
                        "v55.0",
                        0.79
                    ],
                    [
                        "v54.0",
                        0.18
                    ],
                    [
                        "v51.0",
                        0.13
                    ],
                    [
                        "v49.0",
                        2.16
                    ],
                    [
                        "v48.0",
                        0.13
                    ],
                    [
                        "v47.0",
                        0.11
                    ],
                    [
                        "v43.0",
                        0.17
                    ],
                    [
                        "v29.0",
                        0.26
                    ]
                ]
            },
            {
                "name": "Firefox",
                "id": "Firefox",
                "data": [
                    [
                        "v58.0",
                        1.02
                    ],
                    [
                        "v57.0",
                        7.36
                    ],
                    [
                        "v56.0",
                        0.35
                    ],
                    [
                        "v55.0",
                        0.11
                    ],
                    [
                        "v54.0",
                        0.1
                    ],
                    [
                        "v52.0",
                        0.95
                    ],
                    [
                        "v51.0",
                        0.15
                    ],
                    [
                        "v50.0",
                        0.1
                    ],
                    [
                        "v48.0",
                        0.31
                    ],
                    [
                        "v47.0",
                        0.12
                    ]
                ]
            },
            {
                "name": "Internet Explorer",
                "id": "Internet Explorer",
                "data": [
                    [
                        "v11.0",
                        6.2
                    ],
                    [
                        "v10.0",
                        0.29
                    ],
                    [
                        "v9.0",
                        0.27
                    ],
                    [
                        "v8.0",
                        0.47
                    ]
                ]
            },
            {
                "name": "Safari",
                "id": "Safari",
                "data": [
                    [
                        "v11.0",
                        3.39
                    ],
                    [
                        "v10.1",
                        0.96
                    ],
                    [
                        "v10.0",
                        0.36
                    ],
                    [
                        "v9.1",
                        0.54
                    ],
                    [
                        "v9.0",
                        0.13
                    ],
                    [
                        "v5.1",
                        0.2
                    ]
                ]
            },
            {
                "name": "Edge",
                "id": "Edge",
                "data": [
                    [
                        "v16",
                        2.6
                    ],
                    [
                        "v15",
                        0.92
                    ],
                    [
                        "v14",
                        0.4
                    ],
                    [
                        "v13",
                        0.1
                    ]
                ]
            },
            {
                "name": "Opera",
                "id": "Opera",
                "data": [
                    [
                        "v50.0",
                        0.96
                    ],
                    [
                        "v49.0",
                        0.82
                    ],
                    [
                        "v12.1",
                        0.14
                    ]
                ]
            }
        ]
    }
});
 

 
  });

</script>
@if(!Auth::guest())
 @include('dashboard.filter-script')
@endif
@endsection
