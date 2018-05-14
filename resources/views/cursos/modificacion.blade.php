@extends('layouts.adminlte')
@section('content')
<div class="container-fluid">
  <div class="row">
  <div id="modificacion-accion" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <form id="form-modificacion">
      <div class="box">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active">
              <a href="#inicial" data-toggle="tab">Inicial</a>
            </li>
            <li>
              <a href="#areasTematicas" data-toggle="tab">Areas Tematicas</a>
            </li>
            <li>
              <a href="#alumnos" data-toggle="tab">Participantes</a>
            </li>
            <li>
              <a href="#profesores" data-toggle="tab">Docentes</a>
            </li>
            <li class="pull-right" title="Descargar">
              <a href="{{url('cursos') . '/' . $curso->id_curso . '/excel'}}">
                <div class="btn btn-default">
                  <i class="fa fa-file-excel-o text-success" aria-hidden="true"></i> Excel
                </div>
              </a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="active tab-pane" id="inicial">
              {{ csrf_field() }}
              {{ method_field('PUT') }}
              <div class="row">
                  <div class="form-group col-xs-12 col-md-6">       
                    <label class="col-xs-3 col-sm-4 col-md-4 col-lg-4">Nombre:</label>
                    <div class="typeahead__container col-xs-9 col-sm-8 col-md-8 col-lg-8">
                      <div class="typeahead__field ">             
                        <span class="typeahead__query ">
                          <input class="curso_typeahead form-control" name="nombre"  type="search" placeholder="Buscar o agregar uno nuevo" autocomplete="off" value="{{$curso->nombre}}">
                        </span>
                      </div>
                    </div>
                  </div>
                <div class="col-md-6">  
                <div class="form-group col-xs-12 col-md-6">   
                  <label for="estado" class="control-label col-md-4 col-xs-3">Estado:</label>     
                  <div class="col-md-7 col-xs-8">
                    <select class="form-control" id="estado" name="estado">
                      <option>Seleccionar</option>
                      @foreach ($estados as $estado)
                        @if ($estado->id_estado === $curso->id_estado)
                          <option data-id="{{$estado->id_estado}}" selected="selected">{{$estado->nombre}}</option>
                        @else
                          <option data-id="{{$estado->id_estado}}">{{$estado->nombre}}</option>
                        @endif  
                      @endforeach
                    </select> 
                  </div>
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
                      @if ($linea->id_linea_estrategica === $curso->id_linea_estrategica)
                      <option data-id="{{$linea->id_linea_estrategica}}" selected="selected">{{$linea->numero}}-{{$linea->nombre}}</option>
                      @else
                      <option data-id="{{$linea->id_linea_estrategica}}">Línea {{$linea->numero}}-{{$linea->nombre}}</option>
                      @endif  
                      @endforeach
                    </select>
                  </div>          
                </div>

                <div class="col-md-6">  
                <div class="form-group col-xs-12 col-md-6">          
                  <label for="horas" class="control-label col-md-4 col-xs-3">Duración:</label>
                  <div class="col-md-7 col-xs-8">
                    <input type="number" class="form-control" name="duracion" id="horas" placeholder="Duración en horas" value="{{$curso->duracion}}"> 
                  </div>
                </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="form-group col-xs-12 col-md-6">          
                  <label for="provincia" class="control-label col-md-4 col-xs-3">Jurisdicción:</label>
                  <div class="col-md-8 col-xs-9">
                    @if(Auth::user()->id_provincia == 25)
                    <select class="form-control" id="provincia" name="provincia">
                      @foreach ($provincias as $provincia)
                      @if ($provincia->id_provincia === $curso->id_provincia)
                      <option value="{{$provincia->id_provincia}}" data-id="{{$provincia->id_provincia}}" title="{{$provincia->titulo}}" selected="selected">{{$provincia->nombre}}</option>
                      @else
                      <option value="{{$provincia->id_provincia}}" data-id="{{$provincia->id_provincia}}" title="{{$provincia->titulo}}">{{$provincia->nombre}}</option>
                      @endif                 
                      @endforeach
                    </select>
                    @else
                    <select class="form-control" id="provincia" name="provincia" disabled>
                      @foreach ($provincias as $provincia)
                      @if ($provincia->id_provincia === $curso->id_provincia)
                      <option value="{{$provincia->id_provincia}}" data-id="{{$provincia->id_provincia}}" title="{{$provincia->titulo}}" selected="selected">{{$provincia->nombre}}</option>
                      @endif   
                      @endforeach 
                    </select>
                    @endif
                  </div>        
                </div>
                <div class="col-md-6">  
                <div class="form-group col-xs-12 col-md-6">          
                  <label for="edicion" class="control-label col-md-4 col-xs-3">Edición:</label>
                  <div class="col-md-7 col-xs-8">
                    <input type="number" class="form-control" name="edicion" id="edicion" placeholder="Edición de la accion" value="{{$curso->edicion}}" disabled> 
                  </div>
                </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="form-group col-xs-12 col-md-6">          
                  <label for="provincia" class="control-label col-md-4 col-xs-3">Responsable:</label>
                  <div class="col-md-8 col-xs-9">
                    <select class="form-control" id="provincia" name="provincia">
                      @foreach ($responsables as $responsable)
                      @if ($responsable->id_responsable === $curso->id_responsable)
                      <option value="{{$responsable->id_responsable}}" data-id="{{$responsable->id_responsable}}" title="{{$responsable->nombre}}" selected="selected">{{$responsable->nombre}}</option>
                      @else
                      <option value="{{$responsable->id_responsable}}" data-id="{{$responsable->id_responsable}}" title="{{$responsable->nombre}}">{{$responsable->nombre}}</option>
                      @endif   
                      @endforeach 
                    </select>
                  </div>        
                </div>
                <div class="col-md-6">  
                <div class="form-group col-xs-12 col-md-6">            
                  <label for="fecha" class="control-label col-md-5 col-xs-3">Fecha:</label>
                  <div class="input-group date col-md-5 col-xs-9 ">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="fecha" id="fecha" class="form-control pull-right datepicker" value="{{$curso->fecha}}">
                  </div>
                </div>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="areasTematicas">
                @include('areasTematicas.asignacion')
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
            <div class="btn btn-primary pull-right" id="modificar" title="Modificar"><i class="fa fa-plus" aria-hidden="true"></i> Modificar</div>
          </div>
        </div>
      </div>
    </form> 
  </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="{{asset("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js")}}"></script>

<script src="{{asset("/bower_components/admin-lte/plugins/datepicker/locales/bootstrap-datepicker.es.js")}}" charset="UTF-8"></script>

<script type="text/javascript">

  $(document).ready(function() {
      console.log(getInput());

    @if(isset($disabled)) 
		$('.box input').each(function (k,v) {$(v).attr('disabled', true);});
		$('.box select').each(function (k,v) {$(v).attr('disabled', true);});
		$('.box-body #modificar').hide();
	@endif


    //No se porque estoy teniendo que inicializarlo aca si ya se deberia haber inicializado en el layout de adminlte
    $('.datepicker').datepicker({
      format: 'dd/mm/yyyy',
      language: 'es',
      autoclose: true,
    });

    $(".js-example-basic-single").select2();    

    var botonQuitar = '<td><button class="btn btn-danger btn-xs quitar" title="Quitar"><i class="fa fa-minus-circle" aria-hidden="true"></i></button></td>';

    $('.container-fluid #tabla-profesores').on('click','.agregar',function () {
    	console.log("Se agrea al curso el alumno con id:");
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
    	return $('#form-modificacion #alumnos-del-curso .fa-search').map(function(index, val) {
    		return $(val).data('id');
    	});
    }

    function getProfesoresSelected() {
    	return $('#profesores-del-curso .fa-search').map(function(index, val) {
    		return $(val).data('id');
    	});
    }

    function getAreasTematicasSelected() {
      return $('#form-modificacion #areasTematicas-de-la-pac .fa-minus').map(function(index, val) {
        return $(val).data('id');
      });
    } 

    function getSelected() {
    	var id_linea_estrategica = $('#form-modificacion #linea_estrategica option:selected').data('id');
    	var id_provincia = $('#form-modificacion #provincia option:selected').data('id');
      var id_estado = $('#form-modificacion #estado option:selected').data('id');

    	var alumnos = getAlumnosSelected();
    	var profesores = getProfesoresSelected();
      var areasTematicas = getAreasTematicasSelected(); 
    	return [
    	{ 
    		name: 'id_linea_estrategica',
    		value: id_linea_estrategica
    	},
    	{ 
    		name: 'id_provincia',
    		value: id_provincia
    	},
      { 
        name: 'id_estado',
        value: id_estado
      },
    	{ 
    		name: 'alumnos',
    		value: alumnos.toArray()
    	},
      { 
        name: 'areasTematicas',
        value: areasTematicas.toArray()
      },
    	{ 
    		name: 'profesores',
    		value: profesores.toArray()
    	}];
    }

    function getInput() {         
    	return $.merge($('#form-modificacion').serializeArray(),getSelected());
    }

    jQuery.validator.addMethod("selecciono", function(value, element) {
    	return $(element).find(':selected').val() !== "Seleccionar";
    }, "Debe seleccionar alguna opcion");   

    var validator = $('.container-fluid #form-modificacion').validate({
      rules : {
        nombre : "required",
        duracion : {
          required: true,
          number: true
        },
        fecha : {
          required: true
        },
        linea_estrategica: { selecciono : true},
        provincia: { selecciono : true},
      },
      messages:{
        nombre : "Campo obligatorio",
        duracion : "Campo obligatorio",
        fecha : "Campo obligatorio",
      },
      highlight: function(element) {
        $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
      },
      success: function(element) {
        $(element).text('').addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success');
      },
      submitHandler : function(form) {

        $.ajax({
          url : "{{url('cursos')}}" + '/' + "{{$curso->id_curso}}",
          method : 'put',
          data : getInput(),
          success : function(data){
            console.log("Success.");
            alert("Se modifico la acción.");
            window.location = "{{url()->previous()}}";
          },
          error : function(data){
            console.log(data);
            alert("No se pudo modificar la acción.");
          }
        });

      }
    });

    $('.container-fluid').on('click','#modificar',function() {  
      $('.container-fluid #form-modificacion .nav-tabs').children().first().children().click();

      if(validator.valid()){
        $('.container-fluid #form-modificacion').submit(); 
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

{{-- Script para asignacion de areas tematicas --}}
@include('areasTematicas.asignacion-script')
@endsection
