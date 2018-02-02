<section class="sidebar" style="height: auto;">
  <ul class="sidebar-menu tree" data-widget="tree">
    <li class="header text-center">
      <b><span>MENU</span></b>
    </li>
    @if (!Auth::guest())            
    <li>
      <a href="{{url('/dashboard')}}">
        <i class="fa fa-tachometer" aria-hidden="true"></i>
        <span>Dashboard</span>
      </a>

    </li>
    <li class="treeview" id="diagnostico">
      <a href="#">
        <i class="fa fa-bar-chart" aria-hidden="true"></i>
        <span>Diagnóstico</span>
        <span class="pull-right">
          <i class="fa fa-angle-down"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li>
          <a href={{url("/materiales/etapa/1")}}>
            <i class="fa fa-book"></i>
            <span>Documentación</span>
          </a>
        </li>
      </ul>
    </li>
    <li class="treeview" id="planificacion">
      <a href="#">
        <i class="fa fa-sitemap" aria-hidden="true"></i>
        <span>Planificación</span>
        <span class="pull-right">
          <i class="fa fa-angle-down"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li>
          <a href={{url("/materiales/etapa/3")}}>
            <i class="fa fa-book"></i>
            <span>Documentación</span>
          </a>
        </li>
      </ul>
    </li>
    <li class="treeview" id="disenio">
      <a href="#">
        <i class="fa fa-pencil" aria-hidden="true"></i>
        <span>Diseño</span>
        <span class="pull-right">
          <i class="fa fa-angle-down"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li>
          <a href={{url("/materiales/etapa/2")}}>
            <i class="fa fa-book"></i>
            <span>Documentación</span>
          </a>
        </li>
      </ul>
    </li>
    <li class="treeview" id="ejecucion">
      <a href="#">
        <i class="fa fa-desktop" aria-hidden="true"></i>
        <span>Ejecución</span>
        <span class="pull-right">
          <i class="fa fa-angle-down"></i>
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
        <li>
          <a href={{url("/materiales/etapa/4")}}>
            <i class="fa fa-book"></i>
            <span>Documentación</span>
          </a>
        </li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-check-square-o" aria-hidden="true"></i>
        <span>Evaluación</span>
        <span class="pull-right">
          <i class="fa fa-angle-down"></i>
        </span>
      </a>
      <ul class="treeview-menu" role="menu">
        <li>
          <a href={{url("/materiales/etapa/5")}}>
            <i class="fa fa-book"></i>
            <span>Documentación</span>
          </a>
        </li>
      </ul>
    </li>             
    <li class="treeview">
      <a href="#">
        <i class="fa fa-calendar" aria-hidden="true"></i>
        <span>Monitoreo</span>
        <span class="pull-right">
          <i class="fa fa-angle-down"></i>
        </span>
      </a>
      <ul class="treeview-menu" role="menu">
        <li>
          <a href='{{url("/reportes/1")}}'>
            <span class="label label-primary pull-left">1</span>
            <span>ODP 4</span>
          </a>
        </li>
        <li>
          <a href='{{url("/reportes/3")}}'>
            <span class="label label-primary pull-left">2</span>
            <span>Total staff institucional</span>
          </a>
        </li>
        <li>
          <a href='{{url("/reportes/4")}}'>
            <span class="label label-primary pull-left">3</span>
            <span>Porcentaje de efectores</span>
            <br>
            <span>capacitados con modalidad</span>
            <br> 
            <span>presencial</span>
          </a>
        </li>
        <li>
          <a href='{{url("/reportes/cursos")}}'>
            <span class="label label-primary pull-left">4</span>
            <span>Cantidad de participantes</span>
            <br>
            <span>por acción de capacitación</span>
          </a>
        </li>
        <li>
          <a href='{{url("/reportes/6")}}'>
            <span class="label label-primary pull-left">5</span>
            <span>Efectores</span>
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
        <i class="fa fa-plus"></i>
        <span>ABM</span>
        <span class="pull-right">
          <i class="fa fa-angle-down"></i>
        </span>
      </a>
      <ul class="treeview-menu">      
        <li class="treeview">
          <a href="#">
            <i class="fa fa-user-o" aria-hidden="true"></i>
            <span>Participantes</span>
            <span class="pull-right">
              <i class="fa fa-angle-down"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="{{url("/funciones")}}" id="destinatarios">
                <i class="fa fa-circle-o"></i>
                <span>Rol/Destinatario</span>
              </a>
            </li>            
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-graduation-cap" aria-hidden="true"></i>
            <span>Docentes</span>
            <span class="pull-right">
              <i class="fa fa-angle-down"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="{{url("/tipoDocentes")}}">
                <i class="fa fa-circle-o"></i>
                <span>Tipo de docentes</span>
              </a>
            </li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-address-book" aria-hidden="true"></i>
            <span>Acciones</span>
            <span class="pull-right">
              <i class="fa fa-angle-down"></i>
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
              <a href="{{url("/lineasEstrategicas")}}">
                <i class="fa fa-circle-o"></i>
                <span>Tipologias de acción</span>
              </a>
            </li>
          </ul>
        </li>
        <li>
          <a href="{{url("/periodos")}}">
            <i class="fa fa-circle-o"></i>
            <span>Periodos</span>
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
    <li class="header text-center">
      <span>DESARROLLO</span>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-bar-chart" aria-hidden="true"></i>
        <span>Pac</span>
        <span class="pull-right">
          <i class="fa fa-angle-down"></i>
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
        </ul>
      </li>
    </ul>
  </li>             
  <li class="treeview">
    <a href="#">
      <i class="fa fa-file" aria-hidden="true"></i>
      <span>Encuestas</span>
      <span class="pull-right">
        <i class="fa fa-angle-down"></i>
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
