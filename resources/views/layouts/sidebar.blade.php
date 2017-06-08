<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar" style="height: auto;">
  <form action="#" method="get" class="sidebar-form">
    <div class="input-group">
      <input type="text" name="q" class="form-control" placeholder="Buscar...">
      <span class="input-group-btn">
        <button type="submit" name="search" id="search-btn" class="btn btn-flat">
          <i class="fa fa-search"></i>
        </button>
      </span>
    </div>
  </form>
<ul class="sidebar-menu tree" data-widget="tree">
  <li class="header text-center"><b>MENU</b></li>
  @if (!Auth::guest())            
  <li class="treeview"><a href="#"><i class="fa fa-user-o" aria-hidden="true"></i>Usuarios <span class="pull-right-container">
    <i class="fa fa-angle-left pull-right"></i>
  </span></a>
  <ul class="treeview-menu">
    <li><a href={{url("/alumnos")}} ><i class="fa fa-circle-o"></i>Gestión de Alumnos</a></li>
    <li><a href={{url("/profesores")}} ><i class="fa fa-circle-o"></i>Gestión de Profesores</a></li>
  </ul>
</li>
<li class="treeview">
  <a href="#"><i class="fa fa-book" aria-hidden="true"></i>Cursos<span class="pull-right-container">
    <i class="fa fa-angle-left pull-right"></i>
  </span></a>
  <ul class="treeview-menu">
    <li><a href={{url("/cursos")}} ><i class="fa fa-circle-o"></i>Gestión de Cursos</a></li>
  </ul>
</li>
<li class="treeview">
  <a href="#"><i class="fa fa-file-o" aria-hidden="true"></i>Reportes<span class="pull-right-container">
    <i class="fa fa-angle-left pull-right"></i>
  </span></a>
  <ul class="treeview-menu" role="menu">
    <li><a href='{{url("/reportes/1")}}'><i class="fa fa-circle-o"></i>Total staff.</a></li>
    <li><a href='{{url("/reportes/2")}}'><i class="fa fa-circle-o"></i>Banco.</a></li>
    <li><a href='{{url("/reportes/3")}}'><i class="fa fa-circle-o"></i>Total staff institucional.</a></li>
    <li><a href='{{url("/reportes/4")}}'><i class="fa fa-circle-o"></i>Establecimientos capacitados</a></li>
    <li><a href={{url("/reportes/cursos")}}><i class="fa fa-circle-o"></i>Alumnos por curso</a></li>
  </ul>
</li>             
@if(Auth::user()->id_provincia == 25)
<li class="header text-center">ADMIN</li>
<li class="treeview">
  <a href="#"><i class="fa fa-bar-chart" aria-hidden="true"></i>Pac<span class="pull-right-container">
    <i class="fa fa-angle-left pull-right"></i>
  </span></a>
  <ul class="treeview-menu">
   <li>
     <a href="#">
      <span class="pull-right-container">
        <small class="badge bg-aqua">pendiente</small>
      </span>
    </a>
  </li>              
  <li><a href="#"><i class="fa fa-circle-o"></i>Pautas</a></li>
  <li><a href="#"><i class="fa fa-circle-o"></i>Ficha tecnica</a></li>
  <li><a href="#"><i class="fa fa-circle-o"></i>Matriz</a></li>
  <li class="treeview">
    <a href="#"><i class="fa fa-plus" aria-hidden="true"></i>ABM<span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span></a>
    <ul class="treeview-menu">
      <li><a href="#"><i class="fa fa-circle-o"></i>Alcances</a></li>
      <li><a href="#"><i class="fa fa-circle-o"></i>Destinatarios</a></li>
      <li><a href="#"><i class="fa fa-circle-o"></i>Modalidades</a></li>
      <li><a href="#"><i class="fa fa-circle-o"></i>Profundizaciones</a></li>
      <li><a href="#"><i class="fa fa-circle-o"></i>Pautas</a></li>
      <li><a href="#"><i class="fa fa-circle-o"></i>Insumos</a></li>
      <li><a href="#"><i class="fa fa-circle-o"></i>ABM</a></li>
    </ul>
  </li>
</ul>
</li>             
<li class="treeview">
  <a href="#"><i class="fa fa-file" aria-hidden="true"></i>Encuestas<span class="pull-right-container">
    <i class="fa fa-angle-left pull-right"></i>
  </span></a>
  <ul class="treeview-menu">
    <li>
      <a href="#">
        <span class="pull-right-container">
          <small class="badge pull-right bg-green">test</small>
        </span>
      </a>
    </li>
    <li>
      <a href="{{url("/encuestas/g_plannacer")}}"><i class="fa fa-circle-o"></i>g_plannacer
      </a>
    </li>
    <li>
      <a href="{{url("/encuestas/google_form")}}"><i class="fa fa-circle-o"></i>google form
      </a>
    </li>
    <li>
      <a href="{{url("/encuestas/survey")}}"><i class="fa fa-circle-o"></i>survey
      </a>
    </li>
    <li><a href="{{url("/encuestas/grafico")}}"><i class="fa fa-circle-o"></i>grafico migrando</a></li>
  </ul>
</li>             
<li class="treeview">
  <a href="#"><i class="fa fa-desktop"></i>Admin<span class="pull-right-container">
    <i class="fa fa-angle-left pull-right"></i>
  </span></a>
  <ul class="treeview-menu">
    <li><a href="{{url("/areasTematicas")}}"><i class="fa fa-circle-o"></i>Tipologias de accion</a></li>
    <li><a href="{{url("/lineasEstrategicas")}}"><i class="fa fa-circle-o"></i>Lineas Estrategicas</a></li>
    <li><a href="{{url("/gestores")}}"><i class="fa fa-circle-o"></i>Gestores</a></li>
    <li><a href="{{url("/efectores")}}"><i class="fa fa-circle-o"></i>Efectores</a></li>
  </ul>
</li>
@endif             
@endif
</ul>
</section>
      <!-- /.sidebar -->