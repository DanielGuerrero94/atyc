<form id="form-alta">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li id="tab-pac" class="active"><a href="#general" data-toggle="tab">General</a></li>
      <li id="tab-alcance"><a href="#alcance" data-toggle="tab">Alcance</a></li>      
      <li id="tab-ediciones"><a href="#ediciones-tab" data-toggle="tab">Ediciones</a></li>
      <li class="navbar-right"><div class="btn btn-success store">Guardar</div></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane in active" id="general">
          {{ csrf_field() }}
          <div class="row">
            <div class="form-group col-xs-12 col-md-6">       
              <label class="col-xs-3 col-sm-4 col-md-4 col-lg-4">Nombre:</label>
              <div class="typeahead__container col-xs-9 col-sm-8 col-md-8 col-lg-8">
                <div class="typeahead__field">             
                  <span class="typeahead__query">
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
                  <option data-id="{{$tipo_accion->id_linea_estrategica}}" value="{{$tipo_accion->id_linea_estrategica}}"> {{$tipo_accion->numero ." " .$tipo_accion->nombre}}</option>
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
                  <option data-id="{{$tematica->id_area_tematica}}" value="{{$tematica->id_area_tematica}}"> {{$tematica->nombre}}</option>
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
                  <option data-id="{{$provincia->id_provincia}}" value="{{$provincia->id_provincia}}" title="{{$provincia->titulo}}">{{$provincia->nombre}}</option>           
                  @endforeach
                </select>
                @else
                <select class="form-control" id="provincia" name="id_provincia" disabled>
                  <option data-id="{{Auth::user()->id_provincia}}" value="{{Auth::user()->id_provincia}}">{{Auth::user()->title}}</option>  
                </select>
                @endif
              </div>        
            </div>
          </div>
          <br>  
          <div class="row">
            <div class="form-group col-xs-12 col-md-6">          
              <label for="ficha_tecnica" class="control-label col-md-4 col-xs-3">Ficha Técnica</label>
                <span> <b> Subir Ficha Técnica </b> </span>
                <a href="#" data-id="0" class="btn btn-circle upload-ficha_tecnica-sin-pac" title="Subir Ficha Técnica">
                  <i class="fa fa-upload fa-lg" style="color: #228B22;"> </i>
                </a>
            </div>
          </div>  
      </div>
      <div class="tab-pane" id="alcance">
          <div class="row">
            <div class="form-group col-md-6">
              <label for="destinatario" class="control-label col-md-4 col-xs-3">Destinatarios:</label>
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
              <label for="responsable" class="control-label col-md-4 col-xs-3">Responsables de la ejecución:</label>
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
              <label for="pauta" class="control-label col-md-4 col-xs-3">Pautas Para PAC:</label>
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
              <label for="componentesCai" class="control-label col-md-4 col-xs-3">Componentes CAI:</label>
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
      <div class="tab-pane" id="ediciones-tab">
          <div class="row" id="ediciones">
            <div class="form-group col-xs-8 col-md-4">          
              <label for="ediciones" class="control-label col-md-4 col-xs-3">Ediciones</label>
              <div class="col-md-6 col-xs-4">
                <input type="number" class="form-control" name="ediciones" id="ediciones" placeholder="Cantidad de ediciones"> 
              </div>
            </div>
          </div>
      </div>
    </div>
    <div class="box-body">
      <div class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i> Volver</div>
    </div>
  </div>
</form>

<script type="text/javascript">

  $(document).ready(function() {

//Tutorial de alta de PAC

    formUploadSinPac = '<form id="upload-ficha_tecnica-sin-pac" name="upload-ficha_tecnica-sin-pac" style="display: none;">{{ csrf_field() }} <label><input type="file" name="csv" style="display: none;"></label>  <label><input type="hidden" name="id_ficha_tecnica" style="display: none;"></label> </form>';

    $('.select-2').select2(
      {
      "width": "200%",
      "placeholder": "   Seleccionar"
      }).change(function(){
        $(this).valid();
        var container = $(this).select('select2-container');
        var position = container.offset().top;
        var availableHeight = $(window).height() - position - container.outerHeight();
        var bottomPadding = 50; // Set as needed
        $('ul.select2-results__options').css('max-height', (availableHeight - bottomPadding) + 'px');
      });

      $('.select-2').ready(function() {
        $('.select2-container--default .select2-selection--multiple').css('height', 'auto');
      });

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
      return $('#general #tematica option:selected').map(function(){
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

      var id_accion = $('#general #tipo_accion option:selected').data('id');
      var id_provincia = $('#general #provincia option:selected').data('id');
      var id_ficha_tecnica = $('#upload-ficha_tecnica-sin-pac').val();
      var ids_tematicas = getTematicasSelected();
      var ids_destinatarios = getDestinatariosSelected();
      var ids_responsables = getResponsablesSelected();
      var ids_pautas = getPautasSelected();
      var ids_componentes = getComponentesSelected();
      var anio = parseInt(moment.utc($('#ediciones-tab #fecha_inicio_1').val(),'DD/MM/YYYY').format('YYYY'));

      var selected = [
      {
        name: 'id_accion',
        value: id_accion
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
        name: 'anio',
        value: anio
      },
      {
        name: 'ids_componentes',
        value: ids_componentes.toArray()
      }];

      console.log(selected);

      if(id_ficha_tecnica)
      {
        selected.push({
          name: 'id_ficha_tecnica',
          value: id_ficha_tecnica
        });
      }

      console.log(selected);
      return selected;
    }

    function getInput() {
      var input = $.merge($('#form-alta').serializeArray(),getSelected());
      console.log(input);

      return input;
    }
  
    jQuery.validator.addMethod("selecciono", function(value, element) {
      return $(element).find(':selected').length != 0 && $(element).find(':selected').val() != "";
    }, "Debe seleccionar alguna opcion");

    jQuery.validator.addMethod("completados", function(value, element) {
      return $('#form-alta #ediciones-tab input[type="text"]').
        toArray().
        every(
          function (element,value)
            {
              return ($(element).val() != '');
            }) && value > 0;

    }, "Falta la fecha de alguna edicion");

    $('#alta-pac #form-alta').validate({
      rules : {
        nombre : {
          required: true
        },
        duracion : {
          required: true,
          number: true
        },
        id_accion: {
          selecciono: true
        },
        id_tematica: {
          selecciono: true
        },
        id_provincia: {
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
        },
        ediciones: {
          required: true,
          number: true,
          completados: true
        },
        csv: {
          required: false,
          filesize:  2097152 //2MB (1MB = 1048576)
        }
      },
      errorPlacement: function (error, element) {
    		if(element.hasClass('select-2') && element.next('.select2-container').length) {
        	error.insertAfter(element.next('.select2-container'));
        }
        else if (element.parent('.input-group').length) {
            error.insertAfter(element.parent());
        }
        else {
            error.insertAfter(element);
        }
      },
      ignore: '.select2-input, .select2-focusser, .select2-search__field, input[type="hidden"]',
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


      submitHandler : function(form)
      {
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
            alert("No se pudo crear la pac.");
          }
        });
      }
    });

    $('#alta-pac').on('click','.store',function() {
      $('#alta-pac .nav-tabs').children().first().children().click();
      if($('#alta-pac #form-alta').valid()){
        $('#alta-pac #form-alta').submit(); 
      }else{
        alert('Hay campos que no cumplen con la validacion.');
      }
    });

    var edicionesAnteriores = 0;

    $('#alta-pac').on('change', '#ediciones input', function() {
      var ediciones = $ediciones = parseInt($('#form-alta .row #ediciones').val());
      var edicionesActuales = ediciones - edicionesAnteriores;

      if (ediciones > edicionesAnteriores) // edicionesActuales > 0
      {
        for( i = 0; i < edicionesActuales; i++)
        {
          var currentEdicion = +edicionesAnteriores + +i + +1;

          $('#form-alta #ediciones-tab').append(
            ' <br> <div class="row" id="'+ currentEdicion +'" style="display: none;"> <div class="form-group col-xs-2 col-md-2"> <label for="edicion_' + currentEdicion + ' " class="control-label col-md-6 col-xs-5">Edición ' + currentEdicion + '</label> </div> <div class="form-group col-xs-8 col-md-4"> <label for="fecha_inicio_'+currentEdicion+'" class="control-label col-md-4 col-xs-4">Fecha Inicio:</label> <div class="input-group date col-md-5 col-xs-3 "> <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div> <input type="text" name="fecha_inicio_'+currentEdicion+'" id="fecha_inicio_'+currentEdicion+'" class="form-control pull-right datepicker"> </div> </div> <div class="form-group col-xs-8 col-md-4"> <label for="fecha_final_'+currentEdicion+'" class="control-label col-md-4 col-xs-4">Fecha Final:</label> <div class="input-group date col-md-5 col-xs-3 "> <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div> <input type="text" name="fecha_final_'+currentEdicion+'" id="fecha_final_'+currentEdicion+'" class="form-control pull-right datepicker"> </div> </div> </div> '
          );
          $('#form-alta #ediciones-tab #'+currentEdicion).show(200);
        }
        edicionesAnteriores = ediciones;
        
      } else if(ediciones >= 0)
      {
        for (i = 0; edicionesActuales < i; edicionesActuales++)
        {
          $('#form-alta #ediciones-tab').children().last().remove(); // saca la <row>
          $('#form-alta #ediciones-tab').children().last().remove(); // saca el <br>
        }
        edicionesAnteriores = ediciones;
      }
      
      $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        language: 'es',
        autoclose: true,
      });

    });

		$(".container-fluid").on("click", ".upload-ficha_tecnica-sin-pac", function(event) {
			$(formUploadSinPac).appendTo($(this).parent());
			$(this).parent().find("form input").click();
		});

		$(".container-fluid").on("change", "#upload-ficha_tecnica-sin-pac input", function(event) {
			form = $(this).parent().parent();
			data = new FormData(form[0]);
      id_pac = form.parent().find(".upload-ficha_tecnica-sin-pac").data("id");
			$.ajax({
				url: "{{url('pacs')}}" + "/" + id_pac,
				type: 'post',
				data: data,
				processData: false,
				contentType: false,
				success: function (data) {
          console.log("success");
          $('#upload-ficha_tecnica-sin-pac').val(data);
          $('#upload-ficha_tecnica-sin-pac').valid();
				},
				error: function (data) {
					alert("Error al subir el archivo.");
          console.log(data);
        }
			});
		});

  });
</script>
