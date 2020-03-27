<form id="form-alta">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li id="tab-pac" class="active"><a href="#inicial" data-toggle="tab">Inicial</a></li>
      <li id="tab-alcance"><a href="#alcance" data-toggle="tab">Alcance</a></li>      
      <li id="tab-ediciones"><a href="#ediciones" data-toggle="tab">Ediciones</a></li>
      <li class="navbar-right"><div class="btn btn-success store">Guardar</div></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane in active" id="inicial">
          {{ csrf_field() }}
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
          </div>
          <div class="row">
            <div class="form-group col-xs-12 col-md-6">          
              <label for="horas" class="control-label col-md-4 col-xs-3">Duración:</label>
              <div class="col-md-8 col-xs-9">
                <input type="number" class="form-control" name="duracion" id="horas" placeholder="Duración en horas"> 
              </div>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
              <label for="tipo_accion" class="control-label col-md-4 col-xs-3">Tipo de acción:</label>
              <div class="col-md-8 col-xs-9">
                <select class="select-2 form-control" id="tipo_accion" name="id_accion">
                  <option></option>
                  @foreach ($tipoAcciones as $tipo_accion)
                  <option data-id="{{$tipo_accion->id_accion}}" value="{{$tipo_accion->id_accion}}"> {{$tipo_accion->nombre}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <br>    
          <div class="row">
            <div class="form-group col-md-6">
              <label for="tematica" class="control-label col-md-4 col-xs-3">Temática/s:</label>
              <div class="col-md-8 col-xs-9">
                <select class="select-2 form-control" id="tematica" name="id_tematica" aria-hidden="true" multiple>
                  @foreach ($tematicas as $tematica)
                  <option data-id="{{$tematica->id_tematica}}" value="{{$tematica->id_tematica}}"> {{$tematica->nombre}}</option>
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
                <select class="select-2 form-control" id="provincia" name="id_provincia">
                  <option></option>
                  @foreach ($provincias as $provincia)                
                  <option data-id="{{$provincia->id_provincia}}" title="{{$provincia->titulo}}">{{$provincia->nombre}}</option>           
                  @endforeach
                </select>
                @else
                <select class="form-control" id="provincia" name="id_provincia" disabled>
                  <option data-id="{{Auth::user()->id_provincia}}">{{Auth::user()->name}}</option>  
                </select>
                @endif
              </div>        
            </div>
          </div>
          <br>
          <div class="row">
            <div class="form-group col-xs-12 col-md-6">          
              <label for="informe" class="control-label col-md-4 col-xs-3">Informe</label>
              <div class="btn btn-box-tool" title="Subir informe">
                <label style="cursor: pointer;color: #2F2D2D;">
                  <input type="file" class="form-control" style="display: none;" name="informe" id="informe">
                  <i class="fa fa-lg fa-cloud-upload"></i> Subir Informe
                </label>
              </div>
            </div>
          </div>
      </div>
      <div class="tab-pane" id="alcance">
          <div class="row">
            <div class="form-group col-md-6">
              <label for="destinatario" class="control-label col-md-4 col-xs-3">Destinatario/s:</label>
              <div class="col-md-8 col-xs-9">
                <select class="select-2 form-control" id="destinatario" name="id_destinatario" aria-hidden="true" multiple>
                  @foreach ($destinatarios as $destinatario)
                  <option data-id="{{$destinatario->id_destinatario}}" value="{{$destinatario->id_destinatario}}"> {{$destinatario->nombre}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="form-group col-md-6">
              <label for="responsable" class="control-label col-md-4 col-xs-3">Responsable/s:</label>
              <div class="col-md-8 col-xs-9">
                <select class="select-2 form-control" id="responsable" name="id_responsable" aria-hidden="true" multiple>
                  @foreach ($responsables as $responsable)
                  <option data-id="{{$responsable->id_responsable}}" value="{{$responsable->id_responsable}}"> {{$responsable->nombre}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="form-group col-md-6">
              <label for="pauta" class="control-label col-md-4 col-xs-3">Pauta/s:</label>
              <div class="col-md-8 col-xs-9">
                <select class="select-2 form-control" id="pautaSelected" name="id_pauta" aria-hidden="true" multiple>
                  @foreach ($pautas as $pauta)
                  <option data-id="{{$pauta->id_pauta}}" value="{{$pauta->id_pauta}}"> {{$pauta->nombre}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="form-group col-md-6">
              <label for="componentesCai" class="control-label col-md-4 col-xs-3">Componente/s CAI:</label>
              <div class="col-md-8 col-xs-9">
                <select class="select-2 form-control" id="componentesCai" name="id_componente" aria-hidden="true" multiple>
                  @foreach ($componentes as $componente)
                  <option data-id="{{$componente->id_componente}}" value="{{$componente->id_componente}}"> {{$componente->nombre}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
      </div>
      <div class="tab-pane" id="ediciones">
          <div class="row">
            <div class="form-group col-xs-8 col-md-4">          
              <label for="ediciones" class="control-label col-md-4 col-xs-3">Ediciones</label>
              <div class="col-md-6 col-xs-4">
                <input type="number" class="form-control" name="ediciones" id="ediciones" placeholder="Cantidad de ediciones"> 
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="form-group col-xs-8 col-md-4">
              <label for="fecha_inicio" class="control-label col-md-4 col-xs-4">Fecha Inicio:</label>
              <div class="input-group date col-md-5 col-xs-3 ">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" name="fecha_inicio" id="fecha_inicio" class="form-control pull-right datepicker">
              </div>
            </div>
            <div class="form-group col-xs-8 col-md-4">
              <label for="fecha_final" class="control-label col-md-4 col-xs-4">Fecha Final:</label>
              <div class="input-group date col-md-5 col-xs-3 ">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" name="fecha_final" id="fecha_final" class="form-control pull-right datepicker">
              </div>
            </div>
          </div>
      </div>
    </div> 
  </div>      
</form>

<script type="text/javascript">

  $(document).ready(function() {

//Tutorial de alta de PAC


    $(".select-2").select2(
      {
      "width": "200%",
      "placeholder": "Seleccionar"
      });

    $('.datepicker').datepicker({
      format: 'dd/mm/yyyy',
      language: 'es',
      autoclose: true,
    });

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

    function getTematicasSelected() {
      return $('#inicial #tematica option:selected').map(function(){
          return this.value;
          });
    }

    function getDestinatariosSelected() {
      return $('#alcance #destinatario option:selected').map(function(){
          return this.value;
          });
    }

    function getResponsablesSelected() {
      return $('#alcance #responsable option:selected').map(function(){
          return this.value;
          });
    }

    function getPautasSelected() {
      return $('#alcance #pautaSelected option:selected').map(function(){
          return this.value;
          });
    }

    function getComponentesSelected() {
      return $('#alcance #componentesCai option:selected').map(function(){
          return this.value;
          });
    }

    function getSelected() {

      var id_tipo_accion = $('#inicial #tipo_accion option:selected').data('id');
      var id_provincia = $('#inicial #provincia option:selected').data('id');
      var ids_tematicas = getTematicasSelected();
      var ids_destinatarios = getDestinatariosSelected();
      var ids_responsables = getResponsablesSelected();
      var ids_pautas = getPautasSelected();
      var ids_componentes = getComponentesSelected();

      var selected = [
      {
        name: 'id_tipo_accion',
        value: id_tipo_accion
      },
      {
        name: 'id_provincia',
        value: id_provincia
      },
      {
        name: 'ids_tematicas',
        value: ids_tematicas.toArray()
      },
      { 
        name: 'ids_destinatarios',
        value: ids_destinatarios.toArray()
      },
      { 
        name: 'ids_responsables',
        value: ids_responsables.toArray()
      },
      {
        name: 'ids_pautas',
        value: ids_pautas.toArray()
      },
      {
        name: 'ids_componentes',
        value: ids_componentes.toArray()
      }];

      console.log(selected);
      return selected;
    }

    function getInput() {
      var input = $.merge($('#form-alta').serializeArray(),getSelected());
      console.log(input)
      return input;
    }
  
    jQuery.validator.addMethod("selecciono", function(value, element) {
      console.log(element);
      return $(element).find(':selected').length != 0 && $(element).find(':selected').val() != "";
    }, "Debe seleccionar alguna opcion");  

    var validator = $('#alta-pac #form-alta').validate({
      rules : {
        nombre : {
          required: true
        },
        duracion : {
          required: true,
          number: true
        },
        ediciones: {
          required: true,
          number: true
        },
        id_accion: {
          selecciono: true
        },
        id_tematica: {
          selecciono: true
        },
        id_destinatario: {
          selecciono: true
        },
        id_responsable: {
          selecciono: true
        },
        id_pauta: {
          selecciono: true
        },
        id_componente: {
          selecciono: true
        }
      },
      messages:{
        nombre : "Campo obligatorio",
        duracion : "Campo obligatorio"
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
            console.log(data);
            alert("Se crea la pac.");
            location.replace('pacs');
          },
          error : function(data){
            console.log(data);
            alert("No se pudo crear el pac.");
          }
        });
      }
    });
    // $('.select-2').on('select2:select', function() {
    //   validator.valid();
    // });

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
