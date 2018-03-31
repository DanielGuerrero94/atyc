<form id="form-alta">
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
                  <option value="0">Seleccionar</option>
                  @foreach ($tipologias as $tipologia)
                  <option data-id="{{$tipologia->id_linea_estrategica}}" value="{{$tipologia->id_linea_estrategica}}">{{$tipologia->numero}}-{{$tipologia->nombre}}</option>
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
                    <input class="curso_typeahead form-control" name="nombre"  type="search" placeholder="Buscar o agregar uno nuevo" autocomplete="off">
                  </span>
                </div>
              </div>
            </div>
            <div class="col-md-6">          
              <div class="col-md-4 col-xs-3">
                <input type="number" class="form-control" name="repeticiones" id="repeticiones" placeholder="Repeticiones"> 
              </div>
            </div>
          </div>
          <br> 
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
              <label for="form-check" class="control-label col-md-4 col-xs-3">Trimestre planificación: </label>
                  <div class="form-check form-check-inline col-md-8 col-xs-9" id="form-check">
                      <input type="checkbox" id="t1" name="t1">
                      <label for="t1">1ro</label>
                      <input type="checkbox" id="t2" name="t2">
                      <label for="t2">2do</label>
                      <input type="checkbox" id="t3" name="t3">
                      <label for="t3">3ro</label>
                      <input type="checkbox" id="t4" name="t4">
                      <label for="t4">4to</label>
                  </div>
            </div>         
          </div>
         <hr> 
          <div class="row">
            <div class="form-group">
              <div class="col-xs-12">
                <textarea type="textarea" class="form-control" name="observado" id="observado" placeholder="Observaciones que quiera hacer.."></textarea>
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

    function getAreasTematicasSelected() {
      return $('#form-alta #areasTematicas-de-la-pac .fa-minus').map(function(index, val) {
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

{{-- Script para asignacion de areas tematicas --}}
@include('areasTematicas.asignacion-script')
