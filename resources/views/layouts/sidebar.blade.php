<section class="sidebar" style="height: auto;">
  {{-- <form action="#" method="get" class="sidebar-form">
    <div class="input-group">
      <input type="text" name="q" class="form-control" placeholder="Buscar...">
      <span class="input-group-btn">
        <button type="submit" name="search" id="search-btn" class="btn btn-flat">
          <i class="fa fa-search"></i>
        </button>
      </span>
    </div>
  </form> --}}
  <ul class="sidebar-menu tree" data-widget="tree">
    <li class="header text-center">
      <b><span>MENU</span></b>
    </li>
    @if (!Auth::guest())            
    <li class="treeview">
      <a href="#">
        <i class="fa fa-user-o" aria-hidden="true"></i>
        <span>Usuarios</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li>
          <a href={{url("/alumnos")}}>
            <i class="fa fa-circle-o"></i>
            <span>Gestión de Alumnos</span>
          </a>
        </li>
        <li>
          <a href={{url("/profesores")}}>
            <i class="fa fa-circle-o"></i>
            <span>Gestión de Profesores</span>
          </a>
        </li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-book" aria-hidden="true"></i>
        <span>Cursos</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li>
          <a href={{url("/cursos")}}>
            <i class="fa fa-circle-o"></i>
            <span>Gestión de Cursos</span>
          </a>
        </li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-file-o" aria-hidden="true"></i>
        <span>Reportes</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu" role="menu">
        <li>
          <a href='{{url("/reportes/1")}}'>
            <i class="fa fa-circle-o"></i>
            <span>Total staff.</span>
          </a>
        </li>
        <li>
          <a href='{{url("/reportes/2")}}'>
            <i class="fa fa-circle-o"></i>
            <span>Banco.</span>
          </a>
        </li>
        <li>
          <a href='{{url("/reportes/3")}}'>
            <i class="fa fa-circle-o"></i>
            <span>Total staff institucional.</span>
          </a>
        </li>
        <li>
          <a href='{{url("/reportes/4")}}'>
            <i class="fa fa-circle-o"></i>
            <span>Establecimientos capacitados</span>
          </a>
        </li>
        <li>
          <a href='{{url("/reportes/cursos")}}'>
            <i class="fa fa-circle-o"></i>
            <span>Alumnos por curso</span>
          </a>
        </li>
      </ul>
    </li>             
    @if(Auth::user()->id_provincia == 25)
    <li class="header text-center">
      <span>ADMIN</span>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-bar-chart" aria-hidden="true"></i>
        <span>Pac</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
       <li>
         <a href="#">
          <span class="pull-right-container">
            <small class="badge bg-aqua">pendiente</small>
          </span>
        </a>
      </li>              
      <li>
        <a href="#">
          <i class="fa fa-circle-o"></i>
          <span>Pautas</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="fa fa-circle-o"></i>
          <span>Ficha tecnica</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="fa fa-circle-o"></i>
          <span>Matriz</span>
        </a>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-plus" aria-hidden="true"></i>
          <span>ABM</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
        @foreach($menus as $menu)
          <li>
            <a href="#"><i class="{{$menu->icon}}"></i>
              <span>{{$menu->title}}</span>
            </a>
          </li>    
        @endforeach
          <li>
            <a href="#"><i class="fa fa-circle-o"></i>
              <span>Alcances</span>
            </a>
          </li>
          <li>
            <a href="#"><i class="fa fa-circle-o"></i>
              <span>Destinatarios</span>
            </a>
          </li>
          <li>
            <a href="#"><i class="fa fa-circle-o"></i>
              <span>Modalidades</span>
            </a>
          </li>
          <li>
            <a href="#"><i class="fa fa-circle-o"></i>
              <span>Profundizaciones</span>
            </a>
          </li>
          <li>
            <a href="#"><i class="fa fa-circle-o"></i>
              <span>Pautas</span>
            </a>
          </li>
          <li>
            <a href="#"><i class="fa fa-circle-o"></i>
              <span>Insumos</span>
            </a>
          </li>
          <li>
            <a href="#"><i class="fa fa-circle-o"></i>
              <span>ABM</span>
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </li>             
  <li class="treeview">
    <a href="#">
      <i class="fa fa-file" aria-hidden="true"></i>
      <span>Encuestas</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li>
        <a href="#">
          <span class="pull-right-container">
            <small class="badge pull-right bg-green">test</small>
          </span>
        </a>
      </li>
      <li>
        <a href="{{url("/encuestas/g_plannacer")}}">
          <i class="fa fa-circle-o"></i>
          <span>g_plannacer</span>
        </a>
      </li>
      <li>
        <a href="{{url("/encuestas/google_form")}}">
          <i class="fa fa-circle-o"></i>
          <span>google form</span>
        </a>
      </li>
      <li>
        <a href="{{url("/encuestas/survey")}}">
          <i class="fa fa-circle-o"></i>
          <span>survey</span>
        </a>
      </li>
      <li>
        <a href="{{url("/encuestas/grafico")}}">
          <i class="fa fa-circle-o"></i>
          <span>grafico migrando</span>
        </a>
      </li>
    </ul>
  </li>             
  <li class="treeview">
    <a href="#">
      <i class="fa fa-desktop"></i>
      <span>Admin</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li>
        <a href="{{url("/areasTematicas")}}">
          <i class="fa fa-circle-o"></i>
          <span>Areas tematicas</span>
        </a>
      </li>
      <li>
        <a href="{{url("/lineasEstrategicas")}}">
          <i class="fa fa-circle-o"></i>
          <span>Tipologias de accion</span>
        </a>
      </li>
      <li>
        <a href="{{url("/gestores")}}">
          <i class="fa fa-circle-o"></i>
          <span>Gestores</span>
        </a>
      </li>
      <li>
        <a href="{{url("/efectores")}}">
          <i class="fa fa-circle-o"></i>
          <span>Efectores</span>
        </a>
      </li>
    </ul>
  </li>
  @endif             
  @endif
</ul>
</section>