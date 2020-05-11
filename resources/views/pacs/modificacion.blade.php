@extends('layouts.adminlte')
@section('content')
@if(isset($response))
  <?php die($response) ?>
@endif
<div class="container-fluid">
  <div class="row">
  <div id="modificacion-pac" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <form id="form-modificacion">
      <div class="box">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li id="tab-pac" class="active">
              <a href="#general" data-toggle="tab">General</a>
            </li>
            <li id="tab-alcance">
              <a href="#alcance" data-toggle="tab">Alcance</a>
            </li>
            <li id="tab-ediciones">
              <a href="#ediciones-tab" data-toggle="tab">Ediciones</a>
            </li>
            <li class="pull-right" title="Descargar">
              <a href="{{url('pacs') . '/' . $pac->id_pac . '/excel'}}">
                <div class="btn btn-default">
                  <i class="fa fa-file-excel-o text-success" aria-hidden="true"></i> Excel
                </div>
              </a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="active tab-pane" id="general" data-id="{{$pac->id_pac}}">
              {{ csrf_field() }}
              {{ method_field('PUT') }}
              <div class="row">
                <div class="form-group col-xs-12 col-md-6">       
                  <label class="col-xs-3 col-sm-4 col-md-4 col-lg-4">Nombre:</label>
                  <div class="typeahead__container col-xs-9 col-sm-8 col-md-8 col-lg-8">
                    <div class="typeahead__field ">             
                      <span class="typeahead__query ">
                        <input class="curso_typeahead form-control" name="nombre" type="search" placeholder="Buscar o agregar uno nuevo" autocomplete="off" value="{{$pac->nombre}}">
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
                    <input type="number" class="form-control" name="duracion" id="horas" placeholder="Duración en horas" value="{{$pac->duracion}}"> 
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="form-group col-xs-12 col-md-6">          
                  <label for="tipo_accion" class="control-label col-md-4 col-xs-3">Tipo de acción:</label>
                  <div class="col-md-8 col-xs-9">
                    <select class="select-2 form-control" id="tipo_accion" name="id_accion">
                      <option></option>
                      @foreach ($tipoAccionesEdit as $tipoAccion)
                      @if ($tipoAccion->id_linea_estrategica === $pac->id_accion)
                      <option data-id="{{$tipoAccion->id_linea_estrategica}}"  value="{{$tipoAccion->id_linea_estrategica}}" selected="selected">{{$tipoAccion->numero ." " .$tipoAccion->nombre}}</option>
                      @else
                      <option data-id="{{$tipoAccion->id_linea_estrategica}}" value="{{$tipoAccion->id_linea_estrategica}}">{{$tipoAccion->numero ." " .$tipoAccion->nombre}}</option>
                      @endif  
                      @endforeach
                    </select>
                  </div>          
                </div>
              </div>
              <br>
              <div class="row">
                <div class="form-group col-xs-12 col-md-6">          
                  <label for="tematica" class="control-label col-md-4 col-xs-3">Temática/s:</label>
                  <div class="col-md-8 col-xs-9">
                    <select class="select-2 form-control" id="tematica" name="id_tematica" aria-hidden="true" multiple>
                      @foreach ($tematicasEdit as $tematica)
                        @if (in_array ($tematica->id_area_tematica, $pac->tematicas()->withTrashed()->get()->map(function ($_tematica) { return $_tematica->id_area_tematica; })->all() ))
                        <option data-id="{{$tematica->id_area_tematica}}" selected="selected">{{$tematica->nombre}}</option>
                        @else
                        <option data-id="{{$tematica->id_area_tematica}}">{{$tematica->nombre}}</option>
                        @endif  
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
                      @foreach ($provinciasEdit as $provincia)
                        @if ($provincia->id_provincia === $pac->id_provincia)
                          <option value="{{$provincia->id_provincia}}" data-id="{{$provincia->id_provincia}}" title="{{$provincia->titulo}}" selected="selected">{{$provincia->nombre}}</option>
                        @else
                          <option value="{{$provincia->id_provincia}}" data-id="{{$provincia->id_provincia}}" title="{{$provincia->titulo}}">{{$provincia->nombre}}</option>
                        @endif                 
                      @endforeach
                    </select>
                    @else
                    <select class="select2 form-control" id="provincia" name="provincia" disabled>
                      @foreach ($provinciasEdit as $provincia)
                      @if ($provincia->id_provincia === $pac->id_provincia)
                      <option value="{{$provincia->id_provincia}}" data-id="{{$provincia->id_provincia}}" title="{{$provincia->titulo}}">{{$provincia->nombre}}</option>
                      @endif   
                      @endforeach 
                    </select>
                    @endif
                  </div>        
                </div>
              </div>
              <br>
              <div class="row">
              <div class="col-xs-18 col-md-9" style="padding-left: 2em; padding-top: 2em;">
                <table id="ficha_tecnica-table" class="table table-hover">
		            </table>
              </div>
              </div>
            </div>
            <div class="tab-pane" id="alcance">
              <div class="row">
                <div class="form-group col-xs-12 col-md-6">          
                  <label for="destinatario" class="control-label col-md-4 col-xs-3">Destinatarios:</label>
                  <div class="col-md-8 col-xs-9">
                    <select class="select-2 form-control" id="destinatario" name="id_destinatario" aria-hidden="true" multiple>
                      @foreach ($destinatariosEdit as $destinatario)
                        @if (in_array ($destinatario->id_destinatario, $pac->destinatarios()->get()->map(function ($_destinatario) { return $_destinatario->id_destinatario; })->all() ))
                        <option data-id="{{$destinatario->id_destinatario}}" selected="selected">{{$destinatario->nombre}}</option>
                        @else
                        <option data-id="{{$destinatario->id_destinatario}}">{{$destinatario->nombre}}</option>
                        @endif  
                      @endforeach
                    </select>          
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="form-group col-xs-12 col-md-6">          
                  <label for="responsable" class="control-label col-md-4 col-xs-3">Responsables de la Ejecución:</label>
                  <div class="col-md-8 col-xs-9">
                    <select class="select-2 form-control" id="responsable" name="id_responsable" aria-hidden="true" multiple>
                      @foreach ($responsablesEdit as $responsable)
                        @if (in_array ($responsable->id_responsable, $pac->responsables()->get()->map(function ($_responsable) { return $_responsable->id_responsable; })->all() ))
                        <option data-id="{{$responsable->id_responsable}}" selected="selected">{{$responsable->nombre}}</option>
                        @else
                        <option data-id="{{$responsable->id_responsable}}">{{$responsable->nombre}}</option>
                        @endif  
                      @endforeach
                    </select>          
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="form-group col-xs-12 col-md-6">          
                  <label for="pauta" class="control-label col-md-4 col-xs-3">Pautas para PAC:</label>
                  <div class="col-md-8 col-xs-9">
                    <select class="select-2 form-control" id="pauta" name="id_pauta" aria-hidden="true" multiple>
                      @foreach ($pautasEdit as $pauta)
                        @if (in_array ($pauta->id_pauta, $pac->pautas()->get()->map(function ($_pauta) { return $_pauta->id_pauta; })->all() ))
                        <option data-id="{{$pauta->id_pauta}}" selected="selected">{{$pauta->nombre}}</option>
                        @else
                        <option data-id="{{$pauta->id_pauta}}">{{$pauta->nombre}}</option>
                        @endif  
                      @endforeach
                    </select>          
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="form-group col-xs-12 col-md-6">          
                  <label for="componente" class="control-label col-md-4 col-xs-3">Componentes CAI:</label>
                  <div class="col-md-8 col-xs-9">
                    <select class="select-2 form-control" id="componente" name="id_componente" aria-hidden="true" multiple>
                      @foreach ($componentesEdit as $componente)
                        @if (in_array ($componente->id_componente, $pac->componentes()->get()->map(function ($_componente) { return $_componente->id_componente; })->all() ))
                        <option data-id="{{$componente->id_componente}}" selected="selected">{{$componente->nombre}}</option>
                        @else
                        <option data-id="{{$componente->id_componente}}">{{$componente->nombre}}</option>
                        @endif  
                      @endforeach
                    </select>          
                  </div>
                </div>
              </div>
              <br>
            </div>
            <div class="tab-pane" id="ediciones-tab">
              <div class="row" style="padding-left: 2em;">
                  <table id="ediciones-table" class="table table-striped" width="100%">
		              </table>
              </div>
            </div> 
          </div>
          <div class="box-body">
            <a href="{{url('pacs')}}">
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script type="text/javascript" src="{{asset("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js")}}"></script>

<script src="{{asset("/bower_components/admin-lte/plugins/datepicker/locales/bootstrap-datepicker.es.js")}}" charset="UTF-8"></script>

<script type="text/javascript" src="{{"https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"}}"></script>

<script type="text/javascript">

  function fichaTecnica(id_ficha, id_pac)
  {
    if(id_ficha) {	
      buttons = '<a href="{{url("/pacs/ficha_tecnica")}}/' + id_ficha + '/download" data-id="'+ id_ficha + '" class="btn btn-circle download-ficha_tecnica" title="Descargar Ficha Tecnica"><i class="fa fa-download fa-lg" style="color: #2F2D2D;"></i></a>';
      upload = '<a href="#" data-id="'+ id_ficha + '" class="btn btn-circle update-ficha_tecnica" title="Reemplazar Ficha Técnica"><i class="fa fa-cloud-upload fa-lg text-primary"> </i> </a> ';
      
      @if(!isset($disabled))
      buttons += upload;
      @endif
      
      return buttons;
    } else {
      button = '';
      @if(!isset($disabled))
      button = '<a href="#" data-id="' + id_pac + '" class="btn btn-circle upload-ficha_tecnica" title="Subir Ficha Técnica"><i class="fa fa-upload fa-lg" style="color: #228B22;"> </i> </a> ';
      @endif
      
      return button;
    }
  }

  function accionesEdiciones(id_curso)
  {
    buttons = '<a href="{{url("cursos")}}/' + id_curso + '/see" class="btn btn-circle ver" title="Ver Curso"><i class="fa fa-search text-info fa-lg" data-id="'+id_curso+'"></i></a>';
    @if(!isset($disabled))
    buttons += '<a href=#'
    @endif

    return buttons
  }

  $(document).ready(function() {

		formUpload = '<form id="upload-ficha_tecnica" name="upload-ficha_tecnica" style="display: none;">{{ csrf_field() }}<label><input type="file" name="csv" style="display: none;"></label></form>';

		formUpdate = '<form id="update-ficha_tecnica" name="update-ficha_tecnica" style="display: none;">{{ csrf_field() }}<label><input type="file" name="csv" style="display: none;"></label></form>';
    

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

    @if(isset($disabled)) 
		$('.box input').each(function (k,v) {$(v).attr('disabled', true);});
		$('.select-2').each(function (k,v) {$(v).attr('disabled', true);});
		$('.box-body #modificar').hide();
	  @endif

    var id_pac = $('.tab-content #general').data('id');

    $('#ficha_tecnica-table').DataTable({
      destroy: true,
      responsive: true,
      searching: false,
      ajax: "{{url('/pacs')}}" + "/" + id_pac + "/tablaFicha",
      columns: [
        { title: 'Archivo', data: 'ficha_tecnica.original', defaultContent: '<b>No subió Ficha Técnica</b>', name: 'id_ficha_tecnica'},
        { title: 'Creado', data: 'ficha_tecnica.created_at', defaultContent: '-', name: 'id_ficha_tecnica', orderable: false},
        { title: 'Última modificación', data: 'ficha_tecnica.updated_at', defaultContent: '-', name: 'id_ficha_tecnica', orderable: false},
        {
          title: 'Acciones', data: 'id_ficha_tecnica',
          render: function ( data, type, row, meta ) {
            return fichaTecnica(data, id_pac);
          },
          orderable: false
        }
      ]
    });

    $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
        $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
    } );

    $('#ediciones-tab .row #ediciones-table').DataTable({
      destroy: true,
      responsive: true,
      searching: false,
      ajax: "{{url('/pacs')}}" + "/" + id_pac + "/tablaEdiciones",
      columns: [
        { title: '#', data: 'edicion'},
        { title: 'Estado', data: 'estado.nombre', defaultContent: '-', name: 'id_edicion'},
        { title: 'Fecha inicial planificada', data: 'fecha_plan_inicial', defaultContent: '-',
          render:function(data){
              if(data)
      				  return moment(data).format('DD/MM/YYYY');
          }
        },
        { title: 'Fecha final planificada', data: 'fecha_plan_final', defaultContent: '-',
          render:function(data){
            if(data)
      				return moment(data).format('DD/MM/YYYY');
          }
        },
        { title: 'Fecha inicial ejecución', data: 'fecha_ejec_inicial', defaultContent: '-',
          render:function(data){
            if(data)
      				return moment(data).format('DD/MM/YYYY');
          }
        },
        { title: 'Fecha final ejecución', data: 'fecha_ejec_final', defaultContent: '-',
          render:function(data){
            if(data)
      				return moment(data).format('DD/MM/YYYY');
          }
        },
        { 
          render: function ( data, type, row, meta )
          {
            return accionesEdiciones(row.id_curso);
          },
          orderable: false
        }
      ]
    });
    
    //fixedColumns().relayout();

    // $('.datepicker').datepicker({
    //   format: 'dd/mm/yyyy',
    // 	language: 'es',
    // 	autoclose: true,
    // });

    // var botonQuitar = '<td><button class="btn btn-danger btn-xs quitar" title="Quitar"><i class="fa fa-minus-circle" aria-hidden="true"></i></button></td>';

    // $('.container-fluid #tabla-profesores').on('click','.agregar',function () {
    // 	console.log("Se agrea al curso el alumno con id:");
    // 	var fila = $(this).parent().parent();
    // 	var id = $(this).data('id');

    //   fila.find('td:last').remove();
    //   fila.append(botonQuitar);

    //   var data = $('#tabla-profesores').DataTable().row(fila).data();      

    //   $('#tabla-profesores').DataTable().row(fila).remove().draw(false);
    //   var nueva_fila = $('#tabla-profesores-curso').DataTable().row.add(data).draw(false).row().node();
    //   $(nueva_fila).find('td:last').remove();
    //   $(nueva_fila).append(botonQuitar); 
    //   $(nueva_fila).find('td:last button').attr('data-id',id);      
    // });

    // $.typeahead({
    // 	input: '.curso_typeahead',
    // 	order: "desc",
    // 	source: {
    // 		info: {
    // 			ajax: {
    // 				type: "get",
    // 				url: "{{url('cursos/nombres')}}",
    // 				path: "data.info"
    // 			}
    // 		}
    // 	},
    // 	callback: {
    // 		onInit: function (node) {
    // 			console.log('Typeahead Initiated on ' + node.selector);
    // 		}
    // 	}
    // });

    // function getAlumnosSelected() {
    // 	return $('#form-modificacion #alumnos-del-curso .fa-search').map(function(index, val) {
    // 		return $(val).data('id');
    // 	});
    // }

    // function getProfesoresSelected() {
    // 	return $('#profesores-del-curso .fa-search').map(function(index, val) {
    // 		return $(val).data('id');
    // 	});
    // }

    // function getSelected() {
    // 	var id_linea_estrategica = $('#form-modificacion #linea_estrategica option:selected').data('id');
    // 	var id_area_tematica = $('#form-modificacion #area_tematica option:selected').data('id');
    // 	var id_provincia = $('#form-modificacion #provincia option:selected').data('id');

    // 	var alumnos = getAlumnosSelected();
    // 	var profesores = getProfesoresSelected();
    // 	return [
    // 	{ 
    // 		name: 'id_linea_estrategica',
    // 		value: id_linea_estrategica
    // 	},
    // 	{ 
    // 		name: 'id_area_tematica',
    // 		value: id_area_tematica
    // 	},
    // 	{ 
    // 		name: 'id_provincia',
    // 		value: id_provincia
    // 	},
    // 	{ 
    // 		name: 'alumnos',
    // 		value: alumnos.toArray()
    // 	},
    // 	{ 
    // 		name: 'profesores',
    // 		value: profesores.toArray()
    // 	}];
    // }

    // function getInput() {         
    // 	return $.merge($('#form-modificacion').serializeArray(),getSelected());
    // }

    // jQuery.validator.addMethod("selecciono", function(value, element) {
    // 	return $(element).find(':selected').val() !== "Seleccionar";
    // }, "Debe seleccionar alguna opcion");   

    // var validator = $('.container-fluid #form-modificacion').validate({
    //   rules : {
    //     nombre : "required",
    //     duracion : {
    //       required: true,
    //       number: true
    //     },
    //     fecha : {
    //       required: true
    //     },
    //     area_tematica: { selecciono : true},
    //     linea_estrategica: { selecciono : true},
    //     provincia: { selecciono : true},
    //   },
    //   messages:{
    //     nombre : "Campo obligatorio",
    //     duracion : "Campo obligatorio",
    //     fecha : "Campo obligatorio",
    //   },
    //   highlight: function(element) {
    //     $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
    //   },
    //   success: function(element) {
    //     $(element).text('').addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success');
    //   },
    //   submitHandler : function(form) {

    //     $.ajax({
    //       url : "{{url('cursos')}}" + '/' + "{{$pac->id_pac}}",
    //       method : 'put',
    //       data : getInput(),
    //       success : function(data){
    //         console.log("Success.");
    //         alert("Se modifico la acción.");
    //         window.location = "{{url('cursos')}}";
    //       },
    //       error : function(data){
    //         console.log("Error.");
    //         alert("No se pudo modificar la acción.");
    //       }
    //     });

    //   }
    // });

    // $('.container-fluid').on('click','#modificar',function() {  
    //   $('.container-fluid #form-modificacion .nav-tabs').children().first().children().click();

    //   if(validator.valid()){
    //     $('.container-fluid #form-modificacion').submit(); 
    //   }else{
    //     alert('Hay campos que no cumplen con la validacion.');
    //   }
    // });

    $(".container-fluid").on("click", ".upload-ficha_tecnica", function(event) {
			$(formUpload).appendTo($(this).parent());
			$(this).parent().find("form input").click();
		});

		$(".container-fluid").on("change", "#upload-ficha_tecnica input", function(event) {
			form = $(this).parent().parent();
			data = new FormData(form[0]);
			id_pac = form.parent().find(".upload-ficha_tecnica").data("id");			
			$.ajax({
				url: "{{url('pacs')}}" + "/" + id_pac,
				type: 'post',
				data: data,
				processData: false,
				contentType: false,
				success: function (data) {
					console.log("success");
					location.reload();
				},
				error: function (data) {
					alert("Error al subir el archivo.");
					location.reload();
				}
			});
		});

		$(".container-fluid").on("click", ".update-ficha_tecnica", function(event) {
			$(formUpdate).appendTo($(this).parent());
			$(this).parent().find("form input").click();
		});

		$(".container-fluid").on("change", "#update-ficha_tecnica input", function(event) {
			form = $(this).parent().parent();
			data = new FormData(form[0]);
			id_ficha = form.parent().find(".update-ficha_tecnica").data("id");			
			$.ajax({
				url: "{{url('pacs/fichas_tecnicas')}}" + "/" + id_ficha,
				type: 'post',
				data: data,
				processData: false,
				contentType: false,
				success: function (data) {
					console.log("success");
					location.reload();
				},
				error: function (data) {
					alert("Error al actualizar el archivo.");
					location.reload();
				}
			});
		});

		$(".container-fluid").on("click", '.download-ficha_tecnica', function(event) {
			event.preventDefault();
			let id = $(this).data("id");
			location.href = "{{url('/pacs/fichas_tecnicas')}}" + "/" + id + "/download";
		});

	});
</script>
