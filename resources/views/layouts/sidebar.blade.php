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
    <li class="treeview" id="ejecucion">
      <a href="#">
        <i class="fa fa-tachometer" aria-hidden="true"></i>
        <span>Ejecución</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li>
          <a href={{url("/alumnos")}}>
            <i class="fa fa-user-o"></i>
            <span>Gestión de Participantes</span>
          </a>
        </li>
        <li>
          <a href={{url("/profesores")}}>
            <i class="fa fa-graduation-cap"></i>
            <span>Gestión de Docentes</span>
          </a>
        </li>
        <li>
          <a href={{url("/cursos")}}>
            <i class="fa fa-address-book"></i>
            <span>Gestión de Acciones</span>
          </a>
        </li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-file-o" aria-hidden="true"></i>
        <span>Monitoreo y Evaluación</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu" role="menu">
        <li>
          <a href='{{url("/reportes/1")}}'>
            <span>1 - ODP 4</span>
          </a>
        </li>
        <!-- <li>
          <a href='{{url("/reportes/2")}}'>
            <i class="fa fa-circle-o"></i>
            <span>Banco.</span>
          </a>
        </li> -->
        <li>
          <a href='{{url("/reportes/3")}}'>
            <span>2 - Total staff institucional</span>
          </a>
        </li>
        <li>
          <a href='{{url("/reportes/4")}}'>
            <span>3 - Porcentaje de efectores</span>
            <br>
            <span>capacitados con modalidad</span>
            <br> 
            <span>presencial</span>
          </a>
        </li>
        <li>
          <a href='{{url("/reportes/cursos")}}'>
            <span>4 - Cantidad de participantes</span>
            <br>
            <span>por acción de capacitación</span>
          </a>
        </li>
        <li>
          <a href='{{url("/reportes/6")}}'>
            <span>5 - Efectores</span>
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
      <i class="fa fa-desktop"></i>
      <span>Admin</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">      
      <li class="treeview">
        <a href="#">
          <i class="fa fa-plus" aria-hidden="true"></i>
          <span>ABM</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li>
        <a href="{{url("/areasTematicas")}}">
          <i class="fa fa-circle-o"></i>
          <span>Areas temáticas</span>
        </a>
      </li>
          <li>
        <a href="{{url("/periodos")}}">
          <i class="fa fa-circle-o"></i>
          <span>Periodos</span>
        </a>
      </li>
      <li>
        <a href="{{url("/lineasEstrategicas")}}">
          <i class="fa fa-circle-o"></i>
          <span>Tipologias de acción</span>
        </a>
      </li>
      <li>
        <a href="{{url("/tipoDocentes")}}">
          <i class="fa fa-circle-o"></i>
          <span>Tipo de docentes</span>
        </a>
      </li>
      <li>
        <a href="{{url("/funciones")}}">
          <i class="fa fa-circle-o"></i>
          <span>Rol en el sumar</span>
        </a>
      </li>
        </ul>
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
  <li class="header text-center">
      <span>DESARROLLO</span>
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
          <li>
            <a href='{{url("/componentesCa")}}'><i class="fa fa-circle-o"></i>
              <span>Componentes CA</span>
            </a>
          </li>
          <li>
            <a href="#"><i class="fa fa-circle-o"></i>
              <span>Pautas</span>
            </a>
          </li>
          <li>
            <a href='{{url("/estados")}}'><i class="fa fa-circle-o"></i>
              <span>Estados</span>
            </a>
          </li>
          <li>
            <a href="#"><i class="fa fa-circle-o"></i>
              <span>Talleres Sumarte</span>
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
          <span>gráfico migrando</span>
        </a>
      </li>
    </ul>
  </li>             
  
  @endif             
  @endif
</ul>
</section>