<form id="form-alta">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li id="tab-pac" class="active"><a href="#inicial" data-toggle="tab">Inicial</a></li>
      <li id="tab-pauta"><a href="#pautas" data-toggle="tab">Pautas</a></li>
      <li id="tab-destinatario"><a href="#destinatarios" data-toggle="tab">Destinatarios</a></li>      
      <li id="tab-componenteCa"><a href="#componentesCa" data-toggle="tab">Componentes CA</a></li>
      <li class="navbar-right"><div class="btn btn-success store">Guardar</div></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane in active" id="inicial">
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
          
          <div class="row">
            <div class="form-group col-xs-12 col-md-6">          
              <label for="trimestre_planificacion" class="control-label col-md-4 col-xs-3">Trimestre a planificar</label>
              <div class="col-md-8 col-xs-9">
                <input type="number" class="form-control" name="trimestre_planificacion" id="trimestre_planificacion" placeholder="Trimestre a planificar la accion"> 
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">          
              <label for="repeticiones" class="control-label col-md-4 col-xs-3">Repeticiones</label>
              <div class="col-md-4 col-xs-3">
                <input type="number" class="form-control" name="repeticion" id="repeticiones" placeholder="Repeticiones"> 
              </div>
            </div>
            <div class="col-md-6">
              <label for="linea_estrategica" class="control-label col-md-4 col-xs-3">Tipologia de accion:</label>
              <div class="col-md-8 col-xs-9">
                <select class="form-control" id="linea_estrategica" name="linea_estrategica">
                  <option value="0">Seleccionar</option>
                  @foreach ($lineas_estrategicas as $linea)
                  <option data-id="{{$linea->id_linea_estrategica}}" value="{{$linea->id_linea_estrategica}}">Línea {{$linea->numero}}-{{$linea->nombre}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
                    
          <div class="row">
            <div class="col-md-6">
            <ul>
              <li>Trimestre:</li>
                  <div class="form-check form-check-inline">
                      <input type="checkbox" id="t1" name="t1">
                      <label for="t1">1ro</label>
                      <input type="checkbox" id="t2" name="t2">
                      <label for="t2">2do</label>
                      <input type="checkbox" id="t3" name="t3">
                      <label for="t3">3ro</label>
                      <input type="checkbox" id="t4" name="t4">
                      <label for="t4">4to</label>
                  </div>
            </ul>
            </div>
            <div class="col-md-6">
              <label for="area_tematica" class="control-label col-md-4 col-xs-3">Areas Tematicas:</label>
                <div class="col-md-8 col-xs-9">
                  <select class="form-control" id="area_tematica" name="area_tematica">
                    <option>Seleccionar</option>
                    @foreach ($areas_tematicas as $area)
                    <option data-id="{{$area->id_area_tematica}}" value="{{$area->id_area_tematica}}">{{$area->nombre}}</option>
                    @endforeach
                  </select>          
                </div>
            </div>            
          </div>
          <div class="row">
            <ul>
              <div class="checkbox checkbox-info">
                <input type="checkbox" id="consul_peatyc" name="consul_peatyc">
                <label for="consul_peatyc">
                    Consultor PeAtyc
                </label>
              </div>
            </ul>
          </div>
          
          <div class="row">
            <div class="form-group col-xs-12 col-md-6">          
              <label for="observado" class="control-label col-md-4 col-xs-3">Observado</label>
              <div class="col-md-8 col-xs-9">
                <input type="text" class="form-control" name="observado" id="observado" placeholder="Observado"> 
              </div>
            </div>
          </div>          
        </form>  
      </div>
      <div class="tab-pane" id="pautas">  

            @include('pautas.asignacion')  

      </div>
      <div class="tab-pane" id="destinatarios">

          @include('destinatarios.asignacion')  

      </div>            
      <div class="tab-pane" id="componentesCa">
   
            @include('componentesCa.asignacion')

      </div>
    </div> 
  </div>      
</form>

<script type="text/javascript">

  $(document).ready(function() {
    $(".js-example-basic-single").select2();    

    var botonQuitar = '<td><button class="btn btn-danger btn-xs quitar" title="Quitar"><i class="fa fa-minus-circle" aria-hidden="true"></i></button></td>';

    $.typeahead({
      input: '.curso_typeahead',
      order: "desc",
      source: {
        info: {
          ajax: {
            type: "get",
            url: "cursos/nombres",
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
      return $('#form-alta #pautas-de-la-pac .fa-search').map(function(index, val) {
        return $(val).data('id');
      });
    }

    function getDestinatariosSelected() {
      return $('#form-alta #destinatarios-de-la-pac .fa-minus').map(function(index, val) {
        return $(val).data('id');
      });
    }

    function getComponentesCaSelected() {
      return $('#form-alta #componentesCa-de-la-pac .fa-minus').map(function(index, val) {
        return $(val).data('id');
      });
    }

    function getSelected() {

      var componentesCa = getComponentesCaSelected();
      var pautas = getPautasSelected();
      
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
        name: 'componentesCa',
        value: componentesCa.toArray()
      }];
    }

    function getInput() {         
      return $.merge($('#form-alta').serializeArray(),getSelected());
    }  

    var validator = $('#alta-pac #form-alta').validate({
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
          method : 'post',
          url : 'pacs',
          data : getInput(),
          success : function(data){
            console.log("Success.");
            alert("Se crea el pac.");
            location.replace('pacs');
          },
          error : function(data){
            console.log("Error.");
            alert("No se pudo crear el pac.");
          }
        });
      }
    });

    $('#alta-pac').on('click','.store',function() {  
      $('#alta-pac .nav-tabs').children().first().children().click();
      if(validator.valid()){
        $('#alta-pac #form-alta').submit(); 
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