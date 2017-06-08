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
  <body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
    <div class="wrapper" style="height: auto; min-height: 100%;background-color: #f5f5f5;">
      <header class="main-header">
        <!-- Branding Image -->
        <a class="logo" href="{{ url('/dashboard') }}">
          <span class="logo-lg"><b>C</b>apacitacion</span>
        </a>      
        <nav class="navbar navbar-static-top" role="navigation">
          
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" onclick="fixsidebar()">
            <span class="sr-only">Toggle navigation</span>
          </a> 
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              @if (!Auth::guest()) 
              <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-envelope-o"></i>
                  <span class="label label-success">4</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 4 messages</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <li><!-- start message -->
                        <a href="#">
                          <div class="pull-left">
                            <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                          </div>
                          <h4>
                            Support Team
                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>
                      <!-- end message -->
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                          </div>
                          <h4>
                            AdminLTE Design Team
                            <small><i class="fa fa-clock-o"></i> 2 hours</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                          </div>
                          <h4>
                            Developers
                            <small><i class="fa fa-clock-o"></i> Today</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                          </div>
                          <h4>
                            Sales Department
                            <small><i class="fa fa-clock-o"></i> Yesterday</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                          </div>
                          <h4>
                            Reviewers
                            <small><i class="fa fa-clock-o"></i> 2 days</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="footer"><a href="#">See All Messages</a></li>
                </ul>
              </li>
              <!-- Notifications: style can be found in dropdown.less -->
              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning">10</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 10 notifications</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <li>
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i> 5 new members joined today
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                          page and may cause design problems
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-users text-red"></i> 5 new members joined
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-user text-red"></i> You changed your username
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="footer"><a href="#">View all</a></li>
                </ul>
              </li>
              <!-- Tasks: style can be found in dropdown.less -->
              <li class="dropdown tasks-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-flag-o"></i>
                  <span class="label label-danger">9</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 9 tasks</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <li><!-- Task item -->
                        <a href="#">
                          <h3>
                            Design some buttons
                            <small class="pull-right">20%</small>
                          </h3>
                          <div class="progress xs">
                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                              <span class="sr-only">20% Complete</span>
                            </div>
                          </div>
                        </a>
                      </li>
                      <!-- end task item -->
                      <li><!-- Task item -->
                        <a href="#">
                          <h3>
                            Create a nice theme
                            <small class="pull-right">40%</small>
                          </h3>
                          <div class="progress xs">
                            <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                              <span class="sr-only">40% Complete</span>
                            </div>
                          </div>
                        </a>
                      </li>
                      <!-- end task item -->
                      <li><!-- Task item -->
                        <a href="#">
                          <h3>
                            Some task I need to do
                            <small class="pull-right">60%</small>
                          </h3>
                          <div class="progress xs">
                            <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                              <span class="sr-only">60% Complete</span>
                            </div>
                          </div>
                        </a>
                      </li>
                      <!-- end task item -->
                      <li><!-- Task item -->
                        <a href="#">
                          <h3>
                            Make beautiful transitions
                            <small class="pull-right">80%</small>
                          </h3>
                          <div class="progress xs">
                            <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                              <span class="sr-only">80% Complete</span>
                            </div>
                          </div>
                        </a>
                      </li>
                      <!-- end task item -->
                    </ul>
                  </li>
                  <li class="footer">
                    <a href="#">View all tasks</a>
                  </li>
                </ul>
              </li>
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="hidden-xs">{{ Auth::user()->title }}</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="" class="img-circle" alt="User Image">

                    <p>
                      {{ Auth::user()->title }}
                      <small>Member since Nov. 2012</small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <li class="user-body">
                    <div class="row">
                      <div class="col-xs-4 text-center">
                        <a href="#">Followers</a>
                      </div>
                      <div class="col-xs-4 text-center">
                        <a href="#">Sales</a>
                      </div>
                      <div class="col-xs-4 text-center">
                        <a href="#">Friends</a>
                      </div>
                    </div>
                    <!-- /.row -->
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="{{ url('/logout') }}" class="btn btn-default btn-flat"
                      onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
                      Salir
                    </a>

                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                    </form>
                  </div>
                </li>
              </ul>
            </li>
            @else
            <li class="dropdown user user-menu">
              <a href="{{url('/entrar')}}" class="dropdown-toggle" data-toggle="dropdown">
                <span class="hidden-xs">Entrar</span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">

                  <p>
                    <small>Member since Nov. 2012</small>
                  </p>
                </li>
                <!-- Menu Body -->
                <li class="user-body">
                  <div class="row">
                    <div class="col-xs-4 text-center">
                      <a href="#">Followers</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Sales</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Friends</a>
                    </div>
                  </div>
                  <!-- /.row -->
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="{{url("/entrar")}}" class="btn btn-primary btn-flat">Entrar</a>
                  </div>
                  <div class="pull-right">
                    <a href="#" class="btn btn-default btn-flat">Sign out</a>
                  </div>
                </li>
              </ul>
            </li>
            @endif
          </ul>
        </div>
        
      </nav> 
    </header>
    <aside class="main-sidebar">
      @include('layouts.sidebar')
    </aside>
    <div class="content-wrapper" style="min-height: 298px;"> 
      <section class="content">
        @yield('content')
      </section>
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
<script type="text/javascript">
 function fixsidebar() { 
  if ($(window).width() > 767) {
   if ($("body").hasClass('sidebar-collapse')) {
     $("body").removeClass('sidebar-collapse').trigger('expanded.pushMenu');
   } else {
     $("body").addClass('sidebar-collapse').trigger('collapsed.pushMenu');
   }
 }
 else {
   if ($("body").hasClass('sidebar-open')) {
     $("body").removeClass('sidebar-open').removeClass('sidebar-collapse').trigger('collapsed.pushMenu');
   } else {
     $("body").addClass('sidebar-open').trigger('expanded.pushMenu');
   }
 }
};
</script>
<!-- <script>
window.location.hash="no-back-button";
window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
window.onhashchange=function(){window.location.hash="no-back-button";}
</script>  -->
@yield('script')
@stack('moreScripts')


