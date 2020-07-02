<form id="form-alta">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li id="tab-accion" class="active"><a href="#inicial" data-toggle="tab">Inicial</a></li>
      <li id="tab-participante"><a href="#alumnos" data-toggle="tab">Participantes</a></li>
      <li id="tab-docente"><a href="#profesores" data-toggle="tab">Docentes</a></li>
      <li class="navbar-right"><div class="btn btn-success store">Guardar</div></li>
    </ul>
    <div class="tab-content">
      <div class="active tab-pane" id="inicial">
        <form>
          {{ csrf_field() }}
          <div class="row">
            <div class="form-group col-xs-12 col-md-6">       
              <label class="col-xs-3 col-sm-4 col-md-4 col-lg-4">Nombre:</label>
              <div class="typeahead__container col-xs-9 col-sm-8 col-md-8 col-lg-8">
                <div class="typeahead__field ">             
                  <span class="typeahead__query ">
                    <input class="curso_typeahead form-control" name="nombre" type="search" placeholder="Buscar o agregar uno nuevo" autocomplete="off">
                  </span>
                </div>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="form-group col-xs-12 col-md-6">          
              <label for="horas" class="control-label col-md-4 col-xs-3">Duración:</label>
              <div class="col-md-8 col-xs-9">
                <input type="number" class="form-control" name="duracion" id="horas" placeholder="Duración en horas"> 
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="form-group col-xs-12 col-md-6">
              <label for="fecha_ejec_inicial" class="control-label col-md-4 col-xs-4">Fecha Ejecución:</label>
              <div class="input-group date col-md-8 col-xs-6 ">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" name="fecha_ejec_inicial" id="fecha_ejec_inicial" class="form-control pull-right datepicker">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-xs-12 col-md-6">          
              <label for="area_tematica" class="control-label col-md-4 col-xs-3">Areas Tematicas:</label>
              <div class="col-md-8 col-xs-9">
                <select class="form-control" id="area_tematica" name="area_tematica">
                  <option>Seleccionar</option>
                  @foreach ($areas_tematicas as $area)
                  <option data-id="{{$area->id_area_tematica}}">{{$area->nombre}}</option>
                  @endforeach
                </select>          
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="form-group col-xs-12 col-md-6">          
              <label for="linea_estrategica" class="control-label col-md-4 col-xs-3">Tipologia de accion:</label>
              <div class="col-md-8 col-xs-9">
                <select class="form-control" id="linea_estrategica" name="linea_estrategica">
                  <option>Seleccionar</option>
                  @foreach ($lineas_estrategicas as $linea)
                  <option data-id="{{$linea->id_linea_estrategica}}">Línea {{$linea->numero}}-{{$linea->nombre}}</option>
                  @endforeach
                </select>
              </div>          
            </div>
          </div>
          <br>
          <div class="row">
            <div class="form-group col-xs-12 col-md-6">          
              <label for="provincia" class="control-label col-md-4 col-xs-3">Provincia:</label>
              <div class="col-md-8 col-xs-9">
                @if(Auth::user()->id_provincia == 25)
                <select class="form-control" id="provincia" name="provincia">
                  @foreach ($provincias as $provincia)                
                  <option data-id="{{$provincia->id_provincia}}" title="{{$provincia->titulo}}">{{$provincia->nombre}}</option>           
                  @endforeach
                </select>
                @else
                <select class="form-control" id="provincia" name="provincia" disabled>
                  <option data-id="{{Auth::user()->id_provincia}}">{{Auth::user()->name}}</option>  
                </select>
                @endif
              </div>        
            </div>
          </div>          
        </form>  
      </div>
      <div class="tab-pane" id="alumnos">   
        @include('alumnos.asignacion')             
      </div>
      <div class="tab-pane" id="profesores">
        @include('profesores.asignacion')
      </div>
    </div>
    <div class="box-body">
      <a href="{{url()->previous()}}">
        <div class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i> Volver</div>
      </a>
    </div>
  </div>      
</form>

<script type="text/javascript">

  $(document).ready(function() {

    @include('cursos.tutorial-alta-inline-participante')

    $('.datepicker').datepicker({
      format: 'dd/mm/yyyy',
      language: 'es',
      autoclose: true,
    });

    $('.container-fluid').on('click', '.nav-tabs #tab-participante', function(event) {
      event.preventDefault();

      jQuery('<li/>', {
        id: 'tab-tutorial',
        class: 'navbar-right'
      }).appendTo('.container-fluid .nav-tabs');

      jQuery('<a/>', {
        id: 'tutorial-alta-inline',
        class: 'fa fa-question-circle-o',
        href: '#',
        title: 'Tutorial',
        css: 'text-decoration: none;',
        html: ' Tutorial '
      }).appendTo('.container-fluid #tab-tutorial');

    });

    $('.container-fluid').on('click', '.nav-tabs #tab-accion,.nav-tabs #tab-docente', function(event) {
      event.preventDefault();
      $('#tab-tutorial').remove();
    });

    var botonQuitar = '<td><button class="btn btn-danger btn-xs quitar" title="Quitar"><i class="fa fa-minus-circle" aria-hidden="true"></i></button></td>';

    $('#alta-accion #tabla-profesores').on('click','.agregar',function () {

      var fila = $(this).parent().parent();
      var id = $(this).data('id');

      fila.find('td:last').remove();
      fila.append(botonQuitar);

      var data = $('#tabla-profesores').DataTable().row(fila).data();      

      $('#tabla-profesores').DataTable().row(fila).remove().draw(false);
      var nueva_fila = $('#tabla-profesores-curso').DataTable().row.add(data).draw(false).row().node();

      $(nueva_fila).find('td:last').remove();
      $(nueva_fila).append(botonQuitar); 
      $(nueva_fila).find('td:last button').attr('data-id',id);

    });

    $.typeahead({
      input: '.curso_typeahead',
      order: "desc",
      source: {
        info: {
          ajax: {
            type: "get",
            url: "{{url('cursos/nombres')}}",
            path: "data.info"
          }
        }
      },
      callback: {
        onInit: function (node) {
          console.log('Typeahead Initiated on ' + node.selector);
        }
      }
    });

    function getAlumnosSelected() {
      return $('#form-alta #alumnos-del-curso .fa-search').map(function(index, val) {
        return $(val).data('id');
      });
    }

    function getProfesoresSelected() {
      return $('#profesores-del-curso .fa-search').map(function(index, val) {
        return $(val).data('id');
      });
    }

    function getSelected() {
      var id_linea_estrategica = $('#form-alta #linea_estrategica option:selected').data('id');
      var id_area_tematica = $('#form-alta #area_tematica option:selected').data('id');
      var id_provincia = $('#form-alta #provincia option:selected').data('id');

      var alumnos = getAlumnosSelected();
      var profesores = getProfesoresSelected();
      return [
      { 
        name: 'id_linea_estrategica',
        value: id_linea_estrategica
      },
      { 
        name: 'id_area_tematica',
        value: id_area_tematica
      },
      { 
        name: 'id_provincia',
        value: id_provincia
      },
      { 
        name: 'alumnos',
        value: alumnos.toArray()
      },
      { 
        name: 'profesores',
        value: profesores.toArray()
      }];
    }

    function getInput() {         
      return $.merge($('#form-alta').serializeArray(),getSelected());
    }

    jQuery.validator.addMethod("selecciono", function(value, element) {
      return $(element).find(':selected').val() !== "Seleccionar";
    }, "Debe seleccionar alguna opcion");    

    var validator = $('#alta-accion #form-alta').validate({
      rules : {
        nombre : {
          required: true
        },
        duracion : {
          required: true,
          number: true
        },
        fecha_ejec_inicial : {
          required: true
        },
        area_tematica: { selecciono : true},
        linea_estrategica: { selecciono : true},
        provincia: { selecciono : true},
      },
      messages:{
        nombre : "Campo obligatorio",
        duracion : "Campo obligatorio",
        fecha_ejec_inicial : "Campo obligatorio",
      },
      highlight: function(element)
      {
        $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
      },
      success: function(element)
      {
        $(element).text('').addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success');
      },
      submitHandler : function(form){
        $.ajax({
          method : 'post',
          url : "{{url('cursos')}}",
          data : getInput(),
          success : function(data){
            console.log("Success.");
            alert("Se crea el curso.");
            location.replace("{{url('cursos')}}");
          },
          error : function(data){
            console.log("Error.");
            alert("No se pudo crear el curso.");
          }
        });
      }
    });

    $('#alta-accion').on('click','.store',function() {  
      $('#alta-accion .nav-tabs').children().first().children().click();
      if(validator.valid()){
        $('#alta-accion #form-alta').submit(); 
      }else{
        alert('Hay campos que no cumplen con la validacion.');
      }
    });

  });
</script>

{{-- Script asignacion alumnos --}}
@include('alumnos.asignacion-script')

{{-- Script para asignacion de docentes --}}
@include('profesores.asignacion-script')
