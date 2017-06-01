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

    <script type="text/javascript" src="{{asset("/bower_components/highcharts-export-csv/export-csv.js")}}"></script>

    <script type="text/javascript" src="{{asset("/bower_components/highcharts/modules/data.js")}}"></script>

    <script type="text/javascript" src="{{asset("/bower_components/highcharts/modules/drilldown.js")}}"></script>

    <!-- Inputmask -->
    <script type="text/javascript" src="{{asset("/bower_components/admin-lte/plugins/input-mask/jquery.inputmask.js")}}"></script>

    <script type="text/javascript" src="{{asset("/bower_components/admin-lte/plugins/input-mask/jquery.inputmask.extensions.js")}}"></script>

    <script type="text/javascript" src="{{asset("/bower_components/admin-lte/plugins/input-mask/jquery.inputmask.date.extensions.js")}}"></script>

  </head>
  <body class="skin-blue">
    <div class="wrapper" style="background-color: #f5f5f5;">
      <header class="main-header fixed">
        <!-- Branding Image -->
        <a class="logo" href="{{ url('/dashboard') }}">
          <span class="logo-lg"><b>C</b>apacitacion</span>
        </a>      
        <nav class="navbar navbar-static-top" role="navigation">
          <ul class="nav navbar-nav">
            @if (!Auth::guest())            
            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Usuarios <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href={{url("/alumnos")}} >Gestión de Alumnos</a></li>
                <li><a href={{url("/profesores")}} >Gestión de Profesores</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cursos<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href={{url("/cursos")}} >Gestión de Cursos</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reportes<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href='{{url("/reportes/1")}}'>Total de staff que participo de actividades de capacitacion con mas de 10 horas</a></li>
                <li><a href='{{url("/reportes/2")}}'>Banco - Participaron de actividades de capacitacion con mas de 10 horas</a></li>
                <li><a href='{{url("/reportes/3")}}'>Total de staff institucional que participo de alguna actividad de capacitacion</a></li>
                <li><a href='{{url("/reportes/4")}}'>Porcentaje de establecimientos de salud capacitados por provincia</a></li>
                <li><a href={{url("/reportes/cursos")}}>Cantidad de alumnos por curso</a></li>
              </ul>
            </li> 
            @if(Auth::user()->id_provincia == 25)
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href={{url("/areasTematicas")}} >Tipologias de accion</a></li>
                <li><a href={{url("/lineasEstrategicas")}} >Lineas Estrategicas</a></li>
                <li><a href="{{url("/gestores")}}">Gestores</a></li>
                <li><a href="{{url("/efectores")}}">Efectores</a></li>
              </ul>
            </li>             
            @endif
            @endif
          </ul> 
          <ul class="nav navbar-nav navbar-right" style="width: 100px;">
            <!-- Authentication Links -->
            @if (Auth::guest())
            <li class="dropdown user user-menu">            
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="login">
                <span class="hidden-md"><b>Entrar</b></span>
              </a>            
              <ul class="dropdown-menu">
                <li class="user-header">
                  <form action="{{ url('/login') }}" method="post">
                    {{ csrf_field() }}

                    <!-- <div class="form-group has-feedback">
                      <input id="email" type="email" class="form-control" name="email" placeholder="Email"  required autofocus>
                      <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div> -->
                    <div class="form-group has-feedback">
                    <input id="name" type="text" name="name" class="form-control" placeholder="Nombre" required autofocus>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                  </div>
                    <div class="form-group has-feedback">
                      <input id="password" type="password" class="form-control" placeholder="Contraseña" name="password" required>
                      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                      <div class="col-xs-4 col-xs-offset-4">
                        <button type="submit" class="btn btn-default  ">Entrar</button>
                      </div>
                    </div> 
                  </form>
                </li>
              </ul>

            </li>
            @else
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                {{ Auth::user()->title }} <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li>
                  <a href="{{ url('/elearning') }}"
                  onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                  Salir
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                </form>
              </li>
            </ul>
          </li>
          @endif
        </ul> 
      </nav> 
    </header>
    <div class="content-wraper">
      @yield('content')
    </div>
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
      serverSide: true,
      language: {
        emptyTable: "No se encontraron registros",
        info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
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

</script>
<!-- <script>
window.location.hash="no-back-button";
window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
window.onhashchange=function(){window.location.hash="no-back-button";}
</script>  -->
@yield('script')
@stack('moreScripts')


