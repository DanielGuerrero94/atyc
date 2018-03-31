@extends('layouts.adminlte')
@section('content')
<div class="container-fluid">
  <div class="row">
  <div id="modificacion-pac" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <form id="form-modificacion">
      <div class="box">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li id="tab-pac" class="active"><a href="#inicial" data-toggle="tab">Planificación</a></li>
            <li id="tab-areaTematica"><a href="#areasTematicas" data-toggle="tab">Áreas Temáticas</a></li>
            <li id="tab-destinatario"><a href="#destinatarios-pane" data-toggle="tab">Destinatarios</a></li>
            <li id="tab-componenteCa"><a href="#componentesCa" data-toggle="tab">Componentes CA</a></li>
            <li id="tab-pauta"><a href="#pautas" data-toggle="tab">Pautas</a></li>
            <li class="navbar-right"><div class="btn btn-success store">Guardar</div></li>
          </ul>

          <div class="tab-content">
            <div class="tab-pane in active" id="inicial">
              <form>
                {{ csrf_field() }}
                <div class="row">
                  <div class="col-md-6">
                    <label for="linea_estrategica" class="control-label col-md-4 col-xs-3">Tipologia de accion:</label>
                    <div class="col-md-8 col-xs-9">
                      <select class="form-control" id="linea_estrategica" name="id_linea_estrategica">
                        @foreach ($tipologias as $tipologia)
                          @if($tipologia->id_linea_estrategica === $pac->acciones[0]->id_linea_estrategica)
                            <option data-id="{{$tipologia->id_linea_estrategica}}" value="{{$tipologia->id_linea_estrategica}}">{{$tipologia->numero}}-{{$tipologia->nombre}}</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="form-group col-xs-12 col-md-6">       
                    <label class="col-xs-3 col-sm-4 col-md-4 col-lg-4">Nombre:</label>
                    <div class="typeahead__container col-xs-9 col-sm-8 col-md-8 col-lg-8">
                      <div class="typeahead__field ">             
                        <span class="typeahead__query ">
                          <input class="curso_typeahead form-control" name="nombre"  type="search" placeholder="Buscar o agregar uno nuevo" autocomplete="off" value="{{$pac->nombre}}">
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">          
                    <div class="col-md-4 col-xs-3">
                      <input type="number" class="form-control" name="repeticiones" id="repeticiones" placeholder="Repeticiones" value="{{$pac->repeticiones}}" disabled> 
                    </div>
                  </div>
                </div>
                <br> 
                <div class="row">
                  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <label for="form-check" class="control-label col-md-4 col-xs-3">Trimestre planificación: </label>
                        <div class="form-check form-check-inline col-md-8 col-xs-9" id="form-check">
                            @if($pac->t1)
                            <input type="checkbox" id="t1" name="t1" checked>
                            @else
                            <input type="checkbox" id="t1" name="t1">
                            @endif
                            <label for="t1">1ro</label>
                            @if($pac->t2)
                            <input type="checkbox" id="t2" name="t2" checked>
                            @else
                            <input type="checkbox" id="t2" name="t2">
                            @endif
                            <label for="t2">2do</label>
                            @if($pac->t3)
                            <input type="checkbox" id="t3" name="t3" checked>
                            @else
                            <input type="checkbox" id="t3" name="t3">
                            @endif
                            <label for="t3">3ro</label>
                            @if($pac->t4)
                            <input type="checkbox" id="t4" name="t4" checked>
                            @else
                            <input type="checkbox" id="t4" name="t4">
                            @endif
                            <label for="t4">4to</label>
                        </div>
                  </div>         
                </div>
               <hr> 
                <div class="row">
                  <div class="form-group">
                    <div class="col-xs-12">
                      <textarea type="textarea" class="form-control" name="observado" id="observado" placeholder="Observaciones que quiera hacer..">{{$pac->observado}}</textarea>
                    </div>
                  </div>
                </div>          
              </form>  
            </div>
            <div class="tab-pane" id="pautas"> 

                  @include('pautas.asignacion')

            </div>
            <div class="tab-pane" id="destinatarios-pane">

                  @include('destinatarios.asignacion')

            </div>            
            <div class="tab-pane" id="componentesCa">
         
                  @include('componentesCa.asignacion')

            </div>
            <div class="tab-pane" id="areasTematicas">
         
                @include('areasTematicas.asignacion')

            </div>
          </div> 
          <div class="box-body">
            <a href="{{url()->previous()}}">
              <div class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i> Volver</div>
            </a>
            <div class="btn btn-primary pull-right" id="modificar" title="Modificar"><i class="fa fa-plus" aria-hidden="true"></i> Modificar</div>
          </div>
        </div>
          <div class="box-body">
            <table class="table table-striped" id="acciones">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Provincia</th>
                  <th>Linea Estrategica</th>
                  <th>Fecha</th>
                  <th>Duracion</th>
                  <th>Edicion</th>
                  <th>Fecha de Creacion</th>
                </tr>
              </thead>
              <tbody>
                @if(isset($pac))
                @foreach($pac->acciones as $accion)
                <tr>
                  <td>{{$accion->nombre}}</td>
                  <td>{{$accion->provincia}}</td>
                  <td>{{$accion->lineaEstrategica->numero." - ".$accion->lineaEstrategica->nombre}}</td>
                  <td>{{$accion->fecha}}</td>
                  <td>{{$accion->duracion}}</td>
                  <td>{{$accion->edicion}}</td>
                  <td>{{$accion->created_at}}</td>
                  <td>
                    @if(!isset($disabled))
                    <div class="btn btn-xs btn-info">
                      <a href="{{url('/cursos/'.$accion->id_curso)}}">
                        <i class="fa fa-search" data-id="{{$accion->id_curso}}"></i>
                      </a>
                    </div>
                    <div class="btn btn-xs btn-danger quitar">
                      <i class="fa fa-minus"></i>
                    </div>
                    @endif
                  </td>
                </tr>
                @endforeach
                @endif
              </tbody>
            </table>
          </div>
      </div>
    </form> 
  </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="{{ asset ("/bower_components/admin-lte/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>

<script type="text/javascript">

  $(document).ready(function() {
    console.log("Entro al if");
    $(".js-example-basic-single").select2();    

    var botonQuitar = '<td><button class="btn btn-danger btn-xs quitar" title="Quitar"><i class="fa fa-minus-circle" aria-hidden="true"></i></button></td>';
    @if(isset($disabled)) 
      $('.box input').each(function (k,v) {$(v).attr('disabled', true);});
      $('.box select').each(function (k,v) {$(v).attr('disabled', true);});
      $('.box textarea').each(function (k,v) {$(v).attr('disabled', true);});
      $('.box-body #modificar').hide();

    @endif

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

    function getPautasSelected() {
      return $('#form-modificacion #pautas-de-la-pac .fa-search').map(function(index, val) {
        return $(val).data('id');
      });
    }

    function getDestinatariosSelected() {
      return $('#form-modificacion #destinatarios-de-la-pac .fa-minus').map(function(index, val) {
        return $(val).data('id');
      });
    }

    function getComponentesCaSelected() {
      return $('#form-modificacion #componentesCa-de-la-pac .fa-minus').map(function(index, val) {
        return $(val).data('id');
      });
    }

    function getAreasTematicasSelected() {
      return $('#form-modificacion #areasTematicas-de-la-pac .fa-minus').map(function(index, val) {
        return $(val).data('id');
      });
    }    

    function getSelected() {

      var componentesCa = getComponentesCaSelected();
      var pautas = getPautasSelected();
      var areasTematicas = getAreasTematicasSelected();
      var destinatarios = getDestinatariosSelected();
      return [
      { 
        name: 'pautas',
        value: pautas.toArray()
      },
      { 
        name: 'destinatarios',
        value: destinatarios.toArray()
      },
      { 
        name: 'areasTematicas',
        value: areasTematicas.toArray()
      },
      { 
        name: 'componentesCa',
        value: componentesCa.toArray()
      }];
    }

    function getInput() {         
      return $.merge($('#form-modificacion').serializeArray(),getSelected());
    }  

    var validator = $('#modificacion-pac #form-modificacion').validate({
      rules : {
        nombre : {
          required: true
        },
        planificar : {
          required: true,
          number: true
        },
      },
      messages:{
        nombre : "Campo obligatorio",
        planificar : "Campo obligatorio",
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
          method : 'put',
          url : "{{url('pacs')}}" + '/' + "{{$pac->id_pac}}",
          data : getInput(),
          success : function(data){
            console.log("Success.");
            alert("Se modificó el pac.");
            window.location = "{{url('pacs')}}";
          },
          error : function(data){
            console.log("Error.");
            alert("No se pudo modificar el pac.");
          }
        });
      }
    });

    $('#modificacion-pac').on('click','.store',function() {  
      $('#modificacion-pac .nav-tabs').children().first().children().click();
      if(validator.valid()){
        $('#modificacion-pac #form-modificacion').submit(); 
      }else{
        alert('Hay campos que no cumplen con la validacion.');
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

{{-- Script asignacion pautas --}}
@include('pautas.asignacion-script')

{{-- Script para asignacion de componentes --}}
@include('componentesCa.asignacion-script')

{{-- Script para asignacion de destinatarios --}}
@include('destinatarios.asignacion-script')

{{-- Script para asignacion de areas tematicas --}}
@include('areasTematicas.asignacion-script')
