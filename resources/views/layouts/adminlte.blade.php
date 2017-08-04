<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>CUS-SUMAR-Elearning</title>

  <!-- Styles -->
  <link href={{url("/css/app.css")}} rel="stylesheet">
  <link href={{url("/css/elearning.css")}} rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="{{asset("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css")}}">  

  <link rel="stylesheet" type="text/css" href="{{asset("/bower_components/admin-lte/dist/css/AdminLTE.min.css")}}">

  <link rel="stylesheet" type="text/css" href="{{asset("/bower_components/admin-lte/dist/css/skins/_all-skins.min.css")}}">

  <!-- tether para popover -->
  <link rel="stylesheet" href="{{ asset ("/bower_components/tether/dist/css/tether.min.css") }}" >

  <!-- Bootstrap -->
  <link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/bootstrap/css/bootstrap.min.css") }}" >

  <!-- time picker -->
  <link rel="stylesheet" type="text/css" href="{{asset("/bower_components/admin-lte/plugins/timepicker/bootstrap-timepicker.min.css")}}">

  <!-- date picker -->
  <link rel="stylesheet" type="text/css" href="{{asset("/bower_components/admin-lte/plugins/datepicker/datepicker3.css")}}">

  <!-- date range picker -->
  <link rel="stylesheet" type="text/css" href="{{asset("/bower_components/admin-lte/plugins/daterangepicker/daterangepicker.css")}}">

  <!-- typeahead -->
  <link rel="stylesheet" type="text/css" href="{{asset("/bower_components/jquery-typeahead/dist/jquery.typeahead.min.css")}}">

  <!-- fontawesome -->
  <link rel="stylesheet" type="text/css" href="{{asset("/bower_components/font-awesome/css/font-awesome.min.css")}}">

  <!-- datatable buttons -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">

  <!-- select 2 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

  <!-- datatable reorder -->
<link href="https://cdn.datatables.net/rowreorder/1.2.0/css/rowReorder.dataTables.min.css" rel="stylesheet" />
  
  <!-- datatable responsive -->
  <link href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css" rel="stylesheet" />

  <!-- Scripts -->
  <script>
    window.Laravel = <?php echo json_encode([
      'csrfToken' => csrf_token(),
      ]); ?>
    </script>

    <!-- jQuery 2.1.4 -->
    <script type="text/javascript" src="{{ asset ("/bower_components/admin-lte/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script> 

    <!-- tether para popover -->
    <script type="text/javascript" src="{{ asset ("/bower_components/tether/dist/js/tether.min.js") }}" ></script>

    <!-- Bootstrap 3.3.2 JS -->
    <script type="text/javascript" src="{{ asset ("/bower_components/admin-lte/bootstrap/js/bootstrap.min.js") }}" ></script>

    <!-- DataTable -->    
    <!-- <script type="text/javascript" src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}" ></script> -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js" ></script>

    <script type="text/javascript" src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}" ></script>
    
    <!-- Block UI -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.66.0-2013.10.09/jquery.blockUI.min.js"></script>

    <!-- js adminlte -->
    <script type="text/javascript" src="{{asset("/bower_components/admin-lte/dist/js/app.min.js")}}"></script>

    <!-- FastClick -->
    <script type="text/javascript" src="{{asset("/bower_components/admin-lte/plugins/fastclick/fastclick.min.js")}}"></script>

    <!-- SlimScroll -->
    <script type="text/javascript" src="{{asset("/bower_components/admin-lte/plugins/slimScroll/jquery.slimscroll.min.js")}}"></script>    

    <!-- js validate-->
    <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js" ></script>

    <!-- js dialog -->
    <script type="text/javascript" src="{{asset("/bower_components/admin-lte/plugins/fullcalendar/moment.js")}}"></script>

    <!-- moment para fullcalendar -->
    <script type="text/javascript" src="{{asset("/bower_components/admin-lte/plugins/fullcalendar/moment.js")}}"></script>

    <!-- full calendar -->
    <script type="text/javascript" src="{{asset("/bower_components/jquery-ui-1.12.1/jquery-ui.min.js")}}"></script>

    <!-- time picker -->
    <script type="text/javascript" src="{{asset("/bower_components/admin-lte/plugins/timepicker/bootstrap-timepicker.min.js")}}"></script>

    <!-- date picker -->
    <script type="text/javascript" src="{{asset("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js")}}"></script>

    <!-- date range picker -->
    <script type="text/javascript" src="{{asset("/bower_components/admin-lte/plugins/daterangepicker/daterangepicker.js")}}"></script>

    <!-- typeahead -->
    <script type="text/javascript" src="{{asset("/bower_components/jquery-typeahead/dist/jquery.typeahead.min.js")}}"></script>

    <!-- form-validation -->
    <script type="text/javascript" src="{{asset("/bower_components/html5-form-validation/dist/jquery.validation.min.js")}}"></script>

    <script type="text/javascript" src="{{ asset ("/dist/js/jquery.validate.min.js") }}"></script>

    <!-- select 2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <!-- datatable buttons -->
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>

    <!-- knob -->
    <script type="text/javascript" src="{{asset("/bower_components/admin-lte/plugins/knob/jquery.knob.js")}}"></script>

    <!-- Jquery UI ejemplo -->
    <link rel="stylesheet" href="{{asset("/bower_components/jquery-ui-1.12.1/jquery-ui.min.css")}}">

    <!-- Scripts propios -->
    <script type="text/javascript" src="{{asset("/js/elearning.js")}}"></script> 

    <!-- Highcharts -->
    <script type="text/javascript" src="{{asset("/bower_components/highcharts/highcharts.js")}}"></script>

    <!-- Modulos highcharts -->
    <script type="text/javascript" src="{{asset("/bower_components/highcharts/modules/exporting.js")}}"></script>

    <script type="text/javascript" src="{{asset("/bower_components/highcharts-export-csv/highcharts-export-csv.js")}}"></script>

    <script type="text/javascript" src="{{asset("/bower_components/highcharts/modules/data.js")}}"></script>

    <script type="text/javascript" src="{{asset("/bower_components/highcharts/modules/drilldown.js")}}"></script>

    <script type="text/javascript" src="{{asset("/bower_components/highcharts/modules/heatmap.js")}}"></script>

    <script type="text/javascript" src="{{asset("/bower_components/highcharts/modules/treemap.js")}}"></script>

    <!-- Inputmask -->
    <script type="text/javascript" src="{{asset("/bower_components/admin-lte/plugins/input-mask/jquery.inputmask.js")}}"></script>

    <script type="text/javascript" src="{{asset("/bower_components/admin-lte/plugins/input-mask/jquery.inputmask.extensions.js")}}"></script>

    <script type="text/javascript" src="{{asset("/bower_components/admin-lte/plugins/input-mask/jquery.inputmask.date.extensions.js")}}"></script>


    <!-- datatable reorder -->
    <script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js"></script>

    <!-- datatable responsive -->
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    

  </head>
  <body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
    <div class="wrapper" style="height: auto; min-height: 100%;background-color: #f5f5f5;">
      <header class="main-header">
        <!-- Branding Image -->
        <a class="logo" href="{{ url('/dashboard') }}">
          <span class="logo-mini"><b>A</b>tyc</span>
          <span class="logo-lg"><b>A</b>tyc</span>
        </a>      
        <nav class="navbar navbar-static-top" role="navigation">
          @include('layouts.navbar')

        </nav> 
      </header>
      @if (!Auth::guest())
      <aside class="main-sidebar">
        @include('layouts.sidebar')
      </aside>
      <div class="content-wrapper">      
        <section class="content">
        <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: rgb(0,0,0);">×</button>
                <h4 style="color: rgb(0,0,0); text-align: center;"><i class="icon fa fa-warning"></i> Version de prueba!</h4>
                <p style="color: rgb(0,0,0); text-align: center;">Si tiene preguntas,dudas,errores y/o sugerencias envíe un email a sistemasuec@gmail.com.</p>
              </div>
          @yield('content')
        </section>
      </div>
      @else
      <div class="content-wrapper" style="margin-left:0em;">      
        <section class="content">
          @yield('content')
        </section>
      </div>
      @endif   
    </div>  
  </body>
  </html>

  <script type="text/javascript" src="{{asset("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js")}}"></script>

  <script src="{{asset("/bower_components/admin-lte/plugins/datepicker/locales/bootstrap-datepicker.es.js")}}" charset="UTF-8"></script>

  <script type="text/javascript" src="{{ asset ("/dist/js/jquery.validate.min.js") }}"></script>

<script type="text/javascript">

  $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);

  $.blockUI.defaults = { 
    css: {
      border: 'none',
      padding: '15px',
      backgroundColor: '#000',
      '-webkit-border-radius': '10px',
      '-moz-border-radius': '10px',
      opacity: .5,
      color: '#fff',
    },    
    message: '<i class="fa fa-spinner fa-spin"></i>  Cargando...', 
  };

  /*Traduccion a español para DataPicker*/
  $('.datepicker').datepicker({
    format: 'dd/mm/yyyy',
    language: 'es',
    autoclose: true,
  });

  $('.select2').select2();
  $(".js-example-basic-multiple").select2();

  $(document).ready(function(){       

    /*Traduccion a español para DataTable*/
    $.extend( $.fn.dataTable.defaults, {
      processing: true,
      scrollY:"400px",
      scrollCollapse: true,
      serverSide: true,
      rowReorder: {
        selector: 'td:nth-child(2)'
      },
      responsive: true,
      language: {
        emptyTable: "No se encontraron registros",
        info: "Mostrando registros del _START_ al _END_ de _TOTAL_ registros",
        infoEmpty: "No hay registros disponibles",
        infoFiltered: "(filtrados de un total de _MAX_ registros)",
        lengthMenu: "Mostrar _MENU_ registros",
        loadingRecords: "Cargando...",
        paginate: {
          next: "Siguiente",
          previous: "Anterior",
          last: "Ultima"
        },
        processing: "Procesando...",
        search: "Buscar:",
        thousands: ".",
        zeroRecords: "No se encontraron registros",
      }
    });

  });

      var timer;
        window.onload = resetTimer;
        // DOM Events
        document.onmousemove = resetTimer;
        document.onkeypress = resetTimer;
        function resetTimer() {
          clearTimeout(timer);
          timer = setTimeout(function() {
            $('#logout').trigger('click');
          },1000000);  
        }

</script>
<!-- <script>
window.location.hash="no-back-button";
window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
window.onhashchange=function(){window.location.hash="no-back-button";}
</script>  -->
@yield('script')
@stack('moreScripts')


