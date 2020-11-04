@extends('layouts.adminlte')
@section('content')
@if(isset($error))
  <?php dd($error) ?>
@endif
<div class="container-fluid">
  <div class="row">
		<div class="callout callout-info">
			<h2>Planificación Anual de Capacitaciones</h2>
		</div>
	</div>
  <div class="row">
  <div id="modificacion-pac" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <form id="form-modificacion">
      <div class="box">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li id="tab-pac" class="active">
              <a href="#general" data-toggle="tab">General</a>
            </li>
            <li id="tab-estados">
              <a href="#estados-tab" data-toggle="tab">Estados</a>
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
                      <option data-id="{{$tipoAccion->id_linea_estrategica}}" value="{{$tipoAccion->id_linea_estrategica}}" selected="selected">{{$tipoAccion->numero ." " .$tipoAccion->nombre}}</option>
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
                        <option data-id="{{$tematica->id_area_tematica}}" value="{{$tematica->id_area_tematica}}" selected="selected">{{$tematica->nombre}}</option>
                        @else
                        <option data-id="{{$tematica->id_area_tematica}}" value="{{$tematica->id_area_tematica}}">{{$tematica->nombre}}</option>
                        @endif  
                      @endforeach
                    </select>          
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="form-group col-xs-12 col-md-6">          
                  <label for="provincia" class="control-label col-md-4 col-xs-3">Jurisdicción / <br> Dependencia Jerárquica:</label>
                  <div class="col-md-8 col-xs-9">
                  <br>
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
            </div>
            <div class="tab-pane" id="estados-tab">
              <div class="row" id="estados-row" data-estados-id="{{$pac->estado}}">
                <div class="col-xs-18 col-md-9">
                  <span class="col-md-2 col-xs-2"><b>Estado Acción: </b></span>
                </div>
              </div>
              <div class="row" id="cambios-estados" data-cambios-estado-id="{{$pac->cambiosEstado()->with(['estadoAnterior','estadoNuevo'])->orderBy('created_at', 'desc')->get()}}">
              </div>
              <div class="row">
                <div class="col-xs-12 col-md-6">
                  <span class="col-md-4 col-xs-3"><b>Ficha Técnica</b></span>
                </div>
                <div style="padding-left: 1.8em; padding-top: 1.8em;">
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
                        @if (in_array ($destinatario->id_funcion, $pac->destinatarios()->withTrashed()->get()->map(function ($_destinatario) { return $_destinatario->id_funcion; })->all() ))
                        <option data-id="{{$destinatario->id_funcion}}" value="{{$destinatario->id_funcion}}" selected="selected">{{$destinatario->nombre}}</option>
                        @else
                        <option data-id="{{$destinatario->id_funcion}}" value="{{$destinatario->id_funcion}}">{{$destinatario->nombre}}</option>
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
                        @if (in_array ($responsable->id_responsable, $pac->responsables()->withTrashed()->get()->map(function ($_responsable) { return $_responsable->id_responsable; })->all() ))
                        <option data-id="{{$responsable->id_responsable}}" value="{{$responsable->id_responsable}}" selected="selected">{{$responsable->nombre}}</option>
                        @else
                        <option data-id="{{$responsable->id_responsable}}" value="{{$responsable->id_responsable}}">{{$responsable->nombre}}</option>
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
                        @if (in_array ($pauta->id_pauta, $pac->pautas()->withTrashed()->get()->map(function ($_pauta) { return $_pauta->id_pauta; })->all() ))
                        <option data-id="{{$pauta->id_pauta}}" value="{{$pauta->id_pauta}}" selected="selected">{{$pauta->numero." - ".$pauta->nombre}}</option>
                        @else
                        <option data-id="{{$pauta->id_pauta}}" value="{{$pauta->id_pauta}}">{{$pauta->numero." - ".$pauta->nombre}}</option>
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
                        @if (in_array ($componente->id_componente, $pac->componentes()->withTrashed()->get()->map(function ($_componente) { return $_componente->id_componente; })->all() ))
                        <option data-id="{{$componente->id_componente}}" value="{{$componente->id_componente}}" selected="selected">{{$componente->numero." - ".$componente->nombre}}</option>
                        @else
                        <option data-id="{{$componente->id_componente}}" value="{{$componente->id_componente}}">{{$componente->numero." - ".$componente->nombre}}</option>
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
              <br>
              <div class="row" style="padding-left: 1.5em;">
                <div class="btn btn-info agregar_ediciones" id="agregar_ediciones" title="Agregar Ediciones"> <i class="fa fa-plus" aria-hidden="true"></i> Agregar Ediciones</div>
              </div>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script type="text/javascript" src="{{asset("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js")}}"></script>

<script src="{{asset("/bower_components/admin-lte/plugins/datepicker/locales/bootstrap-datepicker.es.js")}}" charset="UTF-8"></script>

<script type="text/javascript" src="{{"https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"}}"></script>

<script type="text/javascript">

  //Variables Globales
  formUpload = '<form id="upload-ficha_tecnica" name="upload-ficha_tecnica" style="display: none;">{{ csrf_field() }}<label><input type="file" name="csv" style="display: none;"></label></form>';

  formUpdate = '<form id="update-ficha_tecnica" name="update-ficha_tecnica" style="display: none;">{{ csrf_field() }}<label><input type="file" name="csv" style="display: none;"></label></form>';

  formAgregarEdiciones = '<div class="row" id="ediciones" style="display: hidden;"> <div class="form-group col-xs-12 col-md-6"> <label for="ediciones" class="control-label col-md-4 col-xs-3">Ediciones a agregar</label> <div class="col-md-6 col-xs-4"> <input type="number" class="form-control" name="ediciones" id="ediciones" placeholder="Cantidad a agregar"> </div> </div> </div>';

  //Abstraccion para FontAwesome
  function iconFA({icon="fa-bolt", color="#000000" , titulo=""}) {
		return '<i class="fa '+icon+' fa-lg" style="color: '+color+';" title="'+titulo+'"> </i>';
	}

  //Abstraccion para alerta antes de cambiar el estado de algo
  function alertChangeState(object, {url= "", log="", messageText=""}) {
    var id = object.data('id');
    var data = '_token='+$('.container-fluid input').first().val();
    
    jQuery('<div/>', {
      id: 'dialogABM',
      text: ''
    }).appendTo('.container-fluid');

    $("#dialogABM").dialog({
      title: "Verificacion",
      show: {
        effect: "fold"
      },
      hide: {
        effect: "fade"
      },
      modal: true,
      width : 360,
      height : 220,
      closeOnEscape: true,
      resizable: false,
      dialogClass: "alert",
      open: function () {
        jQuery('<p/>', {
          id: 'dialogABM',
          text: messageText
        }).appendTo('#dialogABM');
      },
      buttons :
      {
        "Aceptar" : function () {
          $(this).dialog("destroy");
          $("#dialogABM").html("");
          $('.container-fluid #dialogABM').html("");
          $('.container-fluid #dialogABM').remove();
          $.ajax ({
            url: "{{url('pacs/fichas_tecnicas/')}}"+'/'+id+url,
            method: 'post',
            data: data,
            success: function(data){
              console.log(log);
              $('#ficha_tecnica-table').DataTable().clear().draw();
            },
            error: function (data) {
              alert("Hubo un error al cargar la ficha técnica")
              console.log(data);
            }
          });

        },
        "Cancelar" : function () {
          $(this).dialog("destroy");
          $("#dialogABM").html("");
          $('.container-fluid #dialogABM').html("");
          $('.container-fluid #dialogABM').remove();
          $('[role=dialog]').html("");
          $('[role=dialog]').remove();
        }
      }
    });
  }

  //Botones Ficha Tecnica
	function uploadFichaButton(id_pac) {
		return '<a href="#" data-id="' + id_pac + '" class="btn btn-circle upload-ficha_tecnica">' + iconFA({ icon: "fa-upload", color: "#FFD700", titulo: "Subir" }) + '</a>';
	}

	function updateFichaButton(id_ficha) {
		return '<a href="#" data-id="'+ id_ficha + '" class="btn btn-circle update-ficha_tecnica">' + iconFA({ icon: "fa-cloud-upload", color: "#FFD700", titulo: "Reemplazar" }) + '</a>';
	}

	function downloadFichaButton(id_ficha) {
		return '<a href="{{url("/pacs/ficha_tecnica")}}/' + id_ficha + '/download" data-id="'+ id_ficha + '" class="btn btn-circle download-ficha_tecnica">' + iconFA({ icon: "fa-download", color: "#2F2D2D", titulo: "Descargar" }) + '</a>';
	}

	function aprobarFichaButton(id_ficha) {
		return '<a href="javascript:void(0)" data-id="' + id_ficha + '" class="btn btn-circle aprobar-ficha_tecnica">' + iconFA({ icon: "fa-check", color: "#228B22", titulo: "Aprobar" }) + '</a>';
	}

	function desaprobarFichaButton(id_ficha) {
		return '<a href="javascript:void(0)" data-id="' + id_ficha + '" class="btn btn-circle desaprobar-ficha_tecnica">' + iconFA({ icon: "fa-close", color: "#FFD700", titulo: "Desaprobar" }) + '</a>';
	}

  function obligarFichaButton(id_pac) {
    return '<a href="javascript:void(0)" data-id="'+id_pac+'" class="btn btn-circle obligar-ficha_tecnica">' + trianguloFicha({ color: "#1E90FF", titulo: "Hacerla obligatoria" }) + '</a>';
  }

  function desobligarFichaButton(id_pac) {
    return '<a href="javascript:void(0)" data-id="'+id_pac+'" class="btn btn-circle desobligar-ficha_tecnica">' + trianguloFicha({ color: "#D3D3D3", titulo: "Hacerla optativa" }) + '</a>';
  }

  //Indicadores de Estado de la Ficha Tecnica
	function semaforo({color, titulo}) {
		return iconFA({icon: "fa-circle", color, titulo});
	}

  function trianguloFicha({color, titulo = ""}) {
    return iconFA({icon: "fa-exclamation-triangle", color: color, titulo: titulo});
  }

  //Estados de la Ficha Tecnica
	function estadosFicha(ficha, ficha_obligatoria) {
		icons = '';
		if(!ficha_obligatoria)
			icons += trianguloFicha({color: "#D3D3D3", titulo: "Optativa"});
		else
			icons += trianguloFicha({color: "#1E90FF", titulo: "Obligatoria"});
		
		icons += '  ';

		if (jQuery.isEmptyObject(ficha))
			icons += semaforo({color: "#B22222", titulo: 'No tiene'});
		else if (!ficha.aprobada)
			icons += semaforo({color: "#FFD700", titulo: 'En diseño'});
		else
			icons += semaforo({color: "#228B22", titulo: 'Aprobada'});

		return icons;
  }
  
  //Acciones de la Ficha Tecnica
  function fichaTecnicaAccionesButtons (ficha, id_pac, ficha_obligatoria) {
    buttons = '';
    if (jQuery.isEmptyObject(ficha))
      buttons += uploadFichaButton(id_pac);
    else if(!ficha.aprobada)
      buttons += downloadFichaButton(ficha.id_ficha_tecnica) + updateFichaButton(ficha.id_ficha_tecnica);
    else
      buttons += downloadFichaButton(ficha.id_ficha_tecnica);
    
    @if(Auth::user()->id_provincia === 25)
      if(!jQuery.isEmptyObject(ficha)) {
        if(ficha.aprobada)
          buttons += updateFichaButton(ficha.id_ficha_tecnica) + desaprobarFichaButton(ficha.id_ficha_tecnica);
        else
          buttons += aprobarFichaButton(ficha.id_ficha_tecnica)
      }

      if(ficha_obligatoria)
        buttons += desobligarFichaButton(id_pac);
      else
        buttons += obligarFichaButton(id_pac);
    @endif

    return buttons;
  }

  //Comportamiento de la Ficha Tecnica
  function fichaTecnicaBehaviour() {
    uploadFichaBehaviour();
    updateFichaBehaviour();
    downloadFichaBehaviour();
    aprobarFichaBehaviour();
    desaprobarFichaBehaviour();
    obligarFichaBehaviour();
    desobligarFichaBehaviour();
  }

  //Comportamiento para cargar la Ficha Tecnica
  function uploadFichaBehaviour() {
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
          $('#ficha_tecnica-table').DataTable().clear().draw();
				},
				error: function (data) {
					alert("Error al subir el archivo.");
				}
			});
		});
  }

  //Comportamiento para actualizar la Ficha Tecnica
  function updateFichaBehaviour() {
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
          $('#ficha_tecnica-table').DataTable().clear().draw();
				},
				error: function (data) {
					alert("Error al actualizar el archivo.");
				}
			});
		});
  }

  //Comportamiento para descargar la Ficha Tecnica
  function downloadFichaBehaviour() {
    $(".container-fluid").on("click", '.download-ficha_tecnica', function(event) {
			event.preventDefault();
			let id = $(this).data("id");
			location.href = "{{url('/pacs/fichas_tecnicas')}}" + "/" + id + "/download";
		});
  }

  //Comportamiento para aprobar la Ficha Tecnica
  function aprobarFichaBehaviour() {
		$('.container-fluid').on("click",".aprobar-ficha_tecnica", function() {
			alertChangeState($(this), {
        url: "/aprobar",
        log:"Se aprobo la ficha tecnica",
        messageText:"Está segura/o de aprobar la ficha técnica?"
      });
		});
  }

  //Comportamiento para desaprobar la Ficha Tecnica
  function desaprobarFichaBehaviour() {
		$('.container-fluid').on("click",".desaprobar-ficha_tecnica", function() {
			alertChangeState($(this), {
        url: "/desaprobar",
        log:"Se desaprobo la ficha tecnica",
        messageText:"Está segura/o de desaprobar la ficha técnica?"});
		});
  }

  //Comportamiento para hacer Obligatoria la Ficha Tecnica
  function obligarFichaBehaviour() {
    $('.container-fluid').on("click",".obligar-ficha_tecnica", function() {
			alertChangeState($(this), {
        url: "/obligar",
        log:"Se obligo la ficha tecnica",
        messageText: "Está segura/o que la ficha técnica debe ser obligatoria?"});
		});
  }

  //Comportamiento para hacer Optativa la Ficha Tecnica
  function desobligarFichaBehaviour() {
    $('.container-fluid').on("click",".desobligar-ficha_tecnica", function() {
			alertChangeState($(this), {
        url: "/desobligar",
        log:"Se desobligo la ficha tecnica",
        messageText: "Está segura/o que la ficha técnica debe ser optativa?"});
		});
  }

  //Botones de Curso
  function verCursoButton(id_curso) {
    return '<a href="{{url("cursos")}}/' + id_curso + '/see" class="btn btn-circle ver">' + iconFA({ icon: "fa-search", color: "#337ab7", titulo: "Ver"}) + '</a>';
  }
  
  function editarCursoButton(id_curso) {
    return '<a href="{{url("cursos")}}/' + id_curso + '" class="btn btn-circle editar">' + iconFA({ icon: "fa-pencil", color: "#337ab7", titulo: "Editar"}) + '</a>';
  }

  function ejecutarCursoButton(id_curso) {
    return '<a href="javascript:void(0)" data-id="'+id_curso+'" class="btn btn-circle ejecutar_curso">' + iconFA({ icon: "fa-check", color: "#1E90FF", titulo: "Informar ejecución" }) + '</a>';
  }

  function reprogramarCursoButton(id_curso) {
    return '<a href="javascript:void(0)" data-id="'+id_curso+'" class="btn btn-circle reprogramar_curso">' + iconFA({ icon: "fa-clock-o", color: "#FFD700", titulo: "Reprogramar" }) + '</a>';
  }

  function desactivarCursoButton(id_curso) {
    return '<a href="javascript:void(0)" data-id="'+id_curso+'" class="btn btn-circle desactivar_curso">' + iconFA({ icon: "fa-ban", color: "#B22222", titulo: "Desactivar" }) + '</a>';
  }

  function cambiarEstadoCursoButtons(id_curso) {
      return ejecutarCursoButton(id_curso) + reprogramarCursoButton(id_curso) + desactivarCursoButton(id_curso);
  }

  //Acciones de Curso
  function accionesEdiciones(estado, id_curso) {
    buttons = verCursoButton(id_curso);

    @if(!isset($disabled))
      buttons += editarCursoButton(id_curso);
      
      if (estado != "Finalizado" && estado != "Desactivado")
        buttons += cambiarEstadoCursoButtons(id_curso);

    @endif

    return buttons
  }

  //Comportamientos de Acciones
  function accionesBehaviour() {
    agregarEdicionesBehaviour();
    ejecutarCursoBehaviour();
    reprogramarCursoBehaviour();
    desactivarCursoBehaviour();
  }

  //Comportamiento para Agregar Ediciones
  function agregarEdicionesBehaviour() {
    $('.container-fluid').on("click", ".agregar_ediciones", function() {
      $(this).hide('slow');
      $(this).parent().append(formAgregarEdiciones).show('slow');
    });

    var edicionesAnteriores = 0;

    $('#ediciones-tab').on('change', '#ediciones input', function() {
      var ediciones = parseInt($('#ediciones-tab #ediciones input').val());
      var edicionesActuales = ediciones - edicionesAnteriores;

      if (ediciones > edicionesAnteriores) // edicionesActuales > 0
      {
        for( i = 0; i < edicionesActuales; i++)
        {
          var currentEdicion = +edicionesAnteriores + +i + +1;

          $('#ediciones-tab').append(
            ' <br> <div class="row" id="'+ currentEdicion +'" style="display: none;"> <div class="form-group col-xs-2 col-md-2"> <label for="edicion_' + currentEdicion + ' " class="control-label col-md-6 col-xs-5">Edición ' + currentEdicion + '</label> </div> <div class="form-group col-xs-8 col-md-4"> <label for="fecha_inicio_'+currentEdicion+'" class="control-label col-md-4 col-xs-4">Fecha Inicio:</label> <div class="input-group date col-md-5 col-xs-3 "> <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div> <input type="text" name="fecha_inicio_'+currentEdicion+'" id="fecha_inicio_'+currentEdicion+'" class="form-control pull-right datepicker"> </div> </div> <div class="form-group col-xs-8 col-md-4"> <label for="fecha_final_'+currentEdicion+'" class="control-label col-md-4 col-xs-4">Fecha Final:</label> <div class="input-group date col-md-5 col-xs-3 "> <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div> <input type="text" name="fecha_final_'+currentEdicion+'" id="fecha_final_'+currentEdicion+'" class="form-control pull-right datepicker"> </div> </div> </div> '
          );
          $('#ediciones-tab #'+currentEdicion).show('200');
        }
        edicionesAnteriores = ediciones;
        
      } else if(ediciones >= 0)
      {
        for (i = 0; edicionesActuales < i; edicionesActuales++)
        {
          $('#ediciones-tab').children().last().remove(); // saca la <row>
          $('#ediciones-tab').children().last().remove(); // saca el <br>
        }
        edicionesAnteriores = ediciones;
      }

      $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        language: 'es',
        autoclose: true,
      });

    });
  }

  //Comportamiento para Ejecutar Curso
  function ejecutarCursoBehaviour() {
    $('.container-fluid').on("click",".ejecutar_curso", function() {
      var id = $(this).data('id');
      
      jQuery('<div/>', {
        id: 'dialogEjecutar',
        text: ''
      }).appendTo('.container-fluid');

      $("#dialogEjecutar").dialog({
        title: "Informar la Ejecución del Curso",
        show: {
          effect: "fold"
        },
        hide: {
          effect: "fade"
        },
        modal: true,
        width : 400,
        height : 300,
        closeOnEscape: true,
        resizable: false,
        dialogClass: "alert",
        open: function () {
          jQuery('<p/>', {
            id: 'dialogEjecutar',
            text: "Seleccionar las fechas de ejecución"
          }).appendTo('#dialogEjecutar');

          jQuery('<p/>', {
            id: 'p_fecha_inicio',
            text: 'Fecha Inicial de Ejecución'
          }).appendTo('#dialogEjecutar');

          jQuery('<input/>', {
            type: "text",
            name: "fecha_ejec_inicial",
            id: "fecha_ejec_inicial",
            class: "form-control pull-right datepicker"
          }).appendTo('#dialogEjecutar');

          jQuery('<p/>', {
            id: 'p_fecha_final',
            text: 'Fecha Final de Ejecución'
          }).appendTo('#dialogEjecutar');

          jQuery('<input/>', {
            type: "text",
            name: "fecha_ejec_final",
            id: "fecha_ejec_final",
            class: "form-control pull-right datepicker"
          }).appendTo('#dialogEjecutar');

          $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            language: 'es',
            autoclose: true,
          });
        },
        close: function() {
          removeDialog($(this), 'dialogEjecutar');
        },

        buttons :
        {
          "Aceptar y completar" : function () {
            $.ajax ({
              url: "{{url('cursos')}}" + '/' + id + '/ejecutar',
              method: 'put',
              data: getDataEjecucionCurso(),
              success: function(data){
                console.log(data);
                if(data != "error") {
                  console.log("Se informó la ejecución del curso: "+id+" y va a editarlo ahora");
                  alert("Se informó la ejecución del curso. Va a completar los alumnos y profesor ahora");
                  $('#ediciones-table').DataTable().clear().draw();
                  location.replace("{{url('cursos')}}" + '/' + id);
                }
              },
              error: function (data) {
                console.log('Hubo un error.');
                console.log(data);
              }
            });
            removeDialog($(this), 'dialogEjecutar');
          },

          "Aceptar" : function () {
            $.ajax ({
              url: "{{url('cursos')}}"+'/'+id+'/ejecutar',
              method: 'put',
              data: getDataEjecucionCurso(),
              success: function(data){
                if(data != "error") {
                  console.log("Se informó la ejecución del curso: "+id);
                  alert("Se informó la ejecución del curso");
                  $('#ediciones-table').DataTable().clear().draw();
                } else {
                  console.log(data + ': falta de fecha');
                }
              },
              error: function (data) {
                console.log('Hubo un error.');
                console.log(data);
              }
            });
            removeDialog($(this), 'dialogEjecutar');
          },

          "Cancelar" : function () {
            removeDialog($(this), 'dialogEjecutar');
          }
        }
      });
		});
  }

  //Selecciona los inputs de la Ejecucion de un Curso
  function getDataEjecucionCurso() {
    if($('#fecha_ejec_final').val() === "" || $('#fecha_ejec_inicial').val() === "")
    {
      alert("Debe seleccionar ambas fechas para poder cargar la ejecución del curso");
      return noDateSelectedError();
    }

    var data =
    [
      {
        name: '_token',
        value: $('.container-fluid input').first().val()
      },
      {
        name: 'fecha_ejec_inicial',
        value: $('#fecha_ejec_inicial').val()
      },
      {
        name: 'fecha_ejec_final',
        value: $('#fecha_ejec_final').val()
      },
      {
        name: 'fecha_display',
        value: $('#fecha_ejec_inicial').val()
      },
      {
        name: 'id_estado',
        value: 4
      }
    ];

    return data;
  }

  //Determina si se está ejecutando en este momento(3) o si ya finalizó(4)
  function estadoEjecucion() {

    var initial = moment($('#fecha_ejec_inicial').val(), 'DD/MM/YYYY').format("YYYY-MM-DD");
    var final = moment($('#fecha_ejec_final').val(), 'DD/MM/YYYY').format("YYYY-MM-DD");

    if(moment('YYYY-MM-DD').isBetween(initial, final, undefined, '[]'))
      estado = 3;
    else
      estado = 4;

    return estado;
  }

  //Comportamiento para Reprogramar Curso
  function reprogramarCursoBehaviour() {
    $('.container-fluid').on("click",".reprogramar_curso", function() {
      var id = $(this).data('id');
      
      jQuery('<div/>', {
        id: 'dialogReprogramar',
        text: ''
      }).appendTo('.container-fluid');

      $("#dialogReprogramar").dialog({
        title: "Reprogramación del Curso",
        show: {
          effect: "fold"
        },
        hide: {
          effect: "fade"
        },
        modal: true,
        width : 400,
        height : 300,
        closeOnEscape: true,
        resizable: false,
        dialogClass: "alert",
        open: function () {
          jQuery('<p/>', {
            id: 'dialogReprogramar',
            text: "Seleccionar las fechas de reprogramación"
          }).appendTo('#dialogReprogramar');

          jQuery('<p/>', {
            id: 'p_fecha_reprograma_inicial',
            text: 'Fecha Inicial Reprogramada'
          }).appendTo('#dialogReprogramar');

          jQuery('<input/>', {
            type: "text",
            name: "fecha_reprograma_inicial",
            id: "fecha_reprograma_inicial",
            class: "form-control pull-right datepicker"
          }).appendTo('#dialogReprogramar');

          jQuery('<p/>', {
            id: 'p_fecha_final',
            text: 'Fecha Final Reprogramada'
          }).appendTo('#dialogReprogramar');

          jQuery('<input/>', {
            type: "text",
            name: "fecha_reprograma_final",
            id: "fecha_reprograma_final",
            class: "form-control pull-right datepicker"
          }).appendTo('#dialogReprogramar');

          $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            language: 'es',
            autoclose: true,
          });
        },
        close: function() {
          removeDialog($(this), 'dialogReprogramar');
        },

        buttons :
        {
          "Aceptar" : function () {
            $.ajax ({
              url: "{{url('cursos')}}"+'/'+id+'/reprogramar',
              method: 'put',
              data: getDataReprogramacionCurso(),
              success: function(data){
                if(data != "error") {
                  console.log("Se reprogramó el curso: "+id);
							    alert("Se reprogramó el curso");
                  $('#ediciones-table').DataTable().clear().draw();
                } else {
                  console.log(data + ': falta de fecha');
                }
              },
              error: function (data) {
                console.log('Hubo un error.');
                console.log(data);
              }
            });
            removeDialog($(this), 'dialogReprogramar');
          },

          "Cancelar" : function () {
            removeDialog($(this), 'dialogReprogramar');
          }
        }
      });
		});
  }

  //Selecciona los inputs de la Reprogramacion de un Curso
  function getDataReprogramacionCurso() {
    if($('#fecha_reprograma_inicial').val() === "" || $('#fecha_reprograma_final').val() === "")
    {
      alert("Debe seleccionar ambas fechas para poder reprogramar el curso");
      return noDateSelectedError();
    }

    var data =
    [
      {
        name: '_token',
        value: $('.container-fluid input').first().val()
      },
      {
        name: 'fecha_plan_inicial',
        value: $('#fecha_reprograma_inicial').val()
      },
      {
        name: 'fecha_plan_final',
        value: $('#fecha_reprograma_final').val()
      },
      {
        name: 'fecha_display',
        value: $('#fecha_reprograma_inicial').val()
      },
      {
        name: 'id_estado',
        value: 5
      }
    ];

    return data;
  }

  //Comportamiento para Desactivar Curso
  function desactivarCursoBehaviour() {
    $('.container-fluid').on("click",".desactivar_curso", function() {
      var id = $(this).data('id');
      
      jQuery('<div/>', {
        id: 'dialogDesactivar',
        text: ''
      }).appendTo('.container-fluid');

      $("#dialogDesactivar").dialog({
        title: "Desactivación del Curso",
        show: {
          effect: "fold"
        },
        hide: {
          effect: "fade"
        },
        modal: true,
        width : 400,
        height : 300,
        closeOnEscape: true,
        resizable: false,
        dialogClass: "alert",
        open: function () {
          jQuery('<p/>', {
            id: 'dialogDesactivar',
            text: "¿Está segura/o de desactivar el curso? Desactivarlo no le permitirá realizar el curso en el futuro"
          }).appendTo('#dialogDesactivar');
        },
        close: function() {
          removeDialog($(this), 'dialogDesactivar');
        },
        buttons :
        {
          "Aceptar" : function () {
            $.ajax ({
              url: "{{url('cursos')}}"+'/'+id+'/desactivar',
              method: 'put',
              data: getDataDesactivacionCurso(),
              success: function(data){
                console.log(data);
						    alert("Se desactivó el curso");
                $('#ediciones-table').DataTable().clear().draw();
              },
              error: function (data) {
                console.log('Hubo un error.');
                console.log(data);
              }
            });
            removeDialog($(this), 'dialogDesactivar');
          },

          "Cancelar" : function () {
            removeDialog($(this), 'dialogDesactivar');
          }
        }
      });
		});
  }

  //Selecciona los inputs de la desactivacion de un curso
  function getDataDesactivacionCurso() {
    var data = 
    [
      {
        name: '_token',
        value: $('.container-fluid input').first().val()
      },
      {
        name: 'id_estado',
        value: 6
      }
    ];

    console.log(data);

    return data;
  }

  // Abstracciones para el comportamiento de acciones
  // Abstraccion para remover todo lo referido a un dialogo iniciado
  function removeDialog(dialog, id) {
    dialog.dialog("destroy");
    $("#"+id).html("");
    $('.container-fluid #'+id).html("");
    $('.container-fluid #'+id).remove();
    $('[role=dialog]').html("");
    $('[role=dialog]').remove();
  }

  //Abstraccion para cuando no seleccionan una fecha
  function noDateSelectedError() {
    data =  
    [
      {
        name: '_token',
        value: $('.container-fluid input').first().val()
      },
      {
        name: "error",
        value: 0
      }
    ];

    console.log(data);
    return data;
  }

  //Inicializacion de Select2
  function inicializarSelect2() {
    $('.select-2').select2({
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
      $('.select2-container--default .select2-selection--multiple .select2-selection__choice').css('color', '#444 !important')
    });

    $('.select-2').on('select2:select', function () {
			$('.select2-container--default .select2-selection--multiple .select2-selection__choice').css('color', '#444 !important')
		});

    $('.select-2').on('select2:unselect', function () {
			$('.select2-container--default .select2-selection--multiple .select2-selection__choice').css('color', '#444 !important');
		});
  }

  //Diferenciacion entre Ver y Modificar
  function disableSeeButtons() {
    @if(isset($disabled))
		$('.box input').each(function (k,v) {$(v).attr('disabled', true);});
		$('.select-2').each(function (k,v) {$(v).attr('disabled', true);});
		$('.box-body #modificar').hide();
	  @endif
  }

  //Datatable Ficha Tecnica
  function tableFichaTecnica() {
    var id_pac = $('.tab-content #general').data('id');

    var datatable = $('#ficha_tecnica-table').DataTable({
      destroy: true,
      responsive: true,
      searching: false,
      paginate: false,
      info: false,
      ajax: "{{url('/pacs')}}" + "/" + id_pac + "/tablaFicha",
      columns: [
        { title: 'Archivo', data: 'ficha_tecnica.original', defaultContent: '<b>No subió Ficha Técnica</b>', name: 'id_ficha_tecnica'},
        { title: 'Creado', data: 'ficha_tecnica.created_at', defaultContent: '-', name: 'id_ficha_tecnica', orderable: false},
        { title: 'Última modificación', data: 'ficha_tecnica.updated_at', defaultContent: '-', name: 'id_ficha_tecnica', orderable: false},
        {
          title: 'Estado', data: 'ficha_tecnica', name: 'id_ficha_tecnica', 
          render: function ( data, type, row, meta ) {
            return estadosFicha(data, row.ficha_obligatoria);
          },
          orderable: false
        },
        {
          title: 'Acciones', data: 'ficha_tecnica', name: 'id_ficha_tecnica', 
          render: function ( data, type, row, meta ) {
            return fichaTecnicaAccionesButtons(data, row.id_pac, row.ficha_obligatoria);
          },
          orderable: false
        }
      ]
    });

    return datatable;
  }

  function fechaPlanificada(fecha, fecha_final, estado) 
	{
		fecha = moment(fecha).format('DD/MM/YYYY');
		final = moment(fecha_final);

		if(moment().isAfter(final) && estado != 3 && estado != 4 && estado != 6)
			fecha = '<p title="Se pasó fecha de ejecución planificada sin informar" style="color:red;">'+fecha+'</p>';

		return fecha;		
  }
  
  //Datatable Acciones
  function tableAcciones() {

    var id_pac = $('.tab-content #general').data('id');

    var datatable = $('#ediciones-tab .row #ediciones-table').DataTable({
      destroy: true,
      responsive: true,
      searching: false,
      ajax: "{{url('/pacs')}}" + "/" + id_pac + "/tablaEdiciones",
      columns: [
        { title: '#', data: 'edicion'},
        { title: 'Estado', data: 'estado.nombre', defaultContent: '-', name: 'id_edicion'},
        { title: 'Fecha inicial planificada', data: 'fecha_plan_inicial', defaultContent: '-',
          render: function(data, type, row, meta) {
					  return fechaPlanificada(data, row.fecha_plan_final, row.id_estado);
          }
        },
        { title: 'Fecha inicial ejecución', data: 'fecha_ejec_inicial', defaultContent: '-',
          render:function(data){
            if(data)
      				return moment(data).format('DD/MM/YYYY');
          }
        },
        { title: 'Fecha final planificada', data: 'fecha_plan_final', defaultContent: '-',
          render: function(data, type, row, meta) {
					  return fechaPlanificada(data, row.fecha_plan_final, row.id_estado);
          }
        },
        { title: 'Fecha final ejecución', data: 'fecha_ejec_final', defaultContent: '-',
          render:function(data){
            if(data)
      				return moment(data).format('DD/MM/YYYY');
          }
        },
        { data: 'estado.nombre', name: 'id_estado',
          render: function ( data, type, row, meta )
          {
            return accionesEdiciones(data, row.id_curso);
          },
          orderable: false
        }
      ]
    });

    return datatable;
  }

  //Acomoda la tabla que no se carga en pantalla inicialmente
  function adjustDatatablesView() {
    $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
        $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
    });
  }

  //Arma la vista del estado de la pac y las acciones disponibles
  function estadosAccionRender() {
    let estado = $('#estados-tab #estados-row').data("estados-id");
    let cambiosEstado = $('#estados-tab #cambios-estados').data("cambios-estado-id");

    rowEstado = $('#estados-tab #estados-row').children();
    rowEstado.append(renderEstado(estado));

    nextRowCambiosEstado = $('#estados-tab #cambios-estados').next();
    nextRowCambiosEstado.before(renderCambiosEstado(cambiosEstado));

    @if(Auth::user()->isAdmin())
      nextRowCambiosEstado.before(estadoButtons(estado));
    @endif
  }

  function renderCambiosEstado(cambiosEstado) {
    if (cambiosEstado == null) {
      return null;
    }

    let start =
    `<br>
    <div class="row" style="padding-left:1.5rem; line-height:3rem;">
      <span class="col-md-5 col-xs-4"><b>Historial de Estados de Acción</b></span>`;

    let middle = '';
    for (var i in cambiosEstado) {
      middle += 
      `<div class="row" style="padding-left:1.5rem;">
        <div class="col-xs-18 col-md-9">
          <span class="col-md-1 col-xs-1"><b>Cambio:</b></span>
          ${renderEstado(cambiosEstado[i]['estado_anterior'])}
          <span class="col-md-1 col-xs-1" style="width: 4%; margin-top:0.8rem; margin-left:-4.2rem;">${iconFA({icon: 'fa-arrow-right'})}</span>
          ${renderEstado(cambiosEstado[i]['estado_nuevo'])}
        </div>
      </div>
      <div class="row" style="padding-left:1.5rem;">
        <div class="col-xs-18 col-md-9">
          <span class="col-md-1 col-xs-1"><b>Fecha: </b></span>
          <span class="col-md-2 col-xs-2">${moment(cambiosEstado[i]['created_at']).format('DD/MM/YYYY')}</span>
        </div>
      </div>`;
      
      if(cambiosEstado[i]['mensaje']) {
        middle +=
        `<div class="row" style="padding-left:1.5rem;">
          <div class="col-xs-18 col-md-9">
            <span class="col-md-4 col-xs-3"><b>Mensaje:</b></span>
          </div>
        </div>
        <div class="row" style="padding-left:1.5rem;">
          <div class="col-xs-18 col-md-9">
            <span class="col-xs-18 col-md-9">${cambiosEstado[i]['mensaje']}</span>
          </div>
        </div>
        <br>`;
      } else {
        middle += '<br>';
      }
    }

    let end =
    `</div>`;

    return start + middle + end;
  }

  function renderEstado(estado) {
    text = '<span class="col-md-3 col-xs-3">';
    if (estado == null) {
			text += 'No tiene estado  ' + iconFA({icon:'fa-question', color:'#6C757D', titulo:'No tiene estado'}) + '</span>';
      return text;
		}

    text += estado.nombre + '  ';
		switch(estado['id_estado']) {
			case 1:
			  text += iconFA({icon:'fa-minus-square', color:'#FFC107', titulo: estado.nombre});
        break;
			case 2:
			  text += iconFA({icon:'fa-check-square', color:'#28A745', titulo: estado.nombre});
        break;
			case 3:
        text += iconFA({icon:'fa-window-close', color:'#DC3545', titulo: estado.nombre});
        break;
			default:
        text += '- Estado desconocido  ' + iconFA({icon:'fa-question', color:'#6C757D', titulo: estado.nombre + ' - Estado desconocido'});
		}

    text += '</span>';

    return text;
  }

  function aprobarAccionButton() {
   return '<a href="javascript:void(0)" data-id="{{$pac->id_pac}}" class="btn btn-success aprobar-pac">' + iconFA({ icon: "fa-check", color: "white", titulo: "Aprobar Acción" }) + 'Aprobar Acción </a>';
  }

  function rechazarAccionButton() {
    return '<a href="javascript:void(0)" data-id="{{$pac->id_pac}}" class="btn btn-danger rechazar-pac">' + iconFA({ icon: "fa-close", color: "white", titulo: "Rechazar Acción" }) + 'Rechazar Acción </a>';
  }
  
  function estadoButtons(estado) {
    if (estado == null) {
      return null;
    }

    let start =
    `<div class="row" id="buttons-estados">
      <div class="col-xs-18 col-md-9">
        <span class="col-md-2 col-xs-2"><b>Cambiar Estado: </b></span>
      </div>
    </div>
    <br>`;
    
    let middle = '';
    switch (estado['id_estado']) {
      case 1:
		    middle +=
        `<div class="row" style="padding-left: 1.5em;">
          <div class="col-xs-4 col-md-2">
          ${aprobarAccionButton()}
          </div>
          <div class="col-xs-4 col-md-2">
          ${rechazarAccionButton()}
          </div>
        </div>`;
        break;
      case 2:
        middle +=
        `<div class="row" style="padding-left: 1.5em;">
          <div class="col-xs-4 col-md-2">
          ${rechazarAccionButton()}
          </div>
        </div>`;
        break;
      case 3:
        middle +=
        `<div class="row" style="padding-left: 1.5em;">
          <div class="col-xs-4 col-md-2">
          ${aprobarAccionButton()}
          </div>
        </div>`;
        break;
      default:
        return null;
    }
    let end = '<br>';
    return start + middle + end;
  }

  //Comportamiento de los cambios de estado
  function estadosAccionBehaviour() {
    aprobarAccionBehaviour();
    console.log("aprobar");
    rechazarAccionBehaviour();
  }

  //Comportamiento de aprobación de una acción
  function aprobarAccionBehaviour() {
    $('.container-fluid').on("click",".aprobar-pac", function() {
      var id = $(this).data('id');
      
      jQuery('<div/>', {
        id: 'dialogAprobar',
        text: ''
      }).appendTo('.container-fluid');

      $("#dialogAprobar").dialog({
        title: "Aprobar una Acción",
        show: {
          effect: "fold"
        },
        hide: {
          effect: "fade"
        },
        modal: true,
        width : 400,
        height : 300,
        closeOnEscape: true,
        resizable: false,
        dialogClass: "alert",
        open: function () {
          jQuery('<p/>', {
            id: 'dialogAprobar',
            text: "Mensaje adicional a la aprobación de la Acción"
          }).appendTo('#dialogAprobar');

          jQuery('<textarea/>', {
            name: "mensaje",
            id: "mensaje",
            placeholder: "Mensaje optativo."
          }).appendTo('#dialogAprobar');
        },
        close: function() {
          removeDialog($(this), 'dialogAprobar');
        },

        buttons :
        {
          "Aceptar" : function () {
            $.ajax ({
              url: "{{url('pacs')}}"+'/'+id+'/aprobar',
              method: 'put',
              data: getDataCambioEstadoAccion(),
              success: function(data){
                console.log("Se aprobó la acción: "+id);
                alert("Se aprobó la acción");
              },
              error: function (data) {
                console.log('Hubo un error.');
                console.log(data);
              }
            });
            removeDialog($(this), 'dialogAprobar');
          },

          "Cancelar" : function () {
            removeDialog($(this), 'dialogAprobar');
          }
        }
      });
		});
  }

  function rechazarAccionBehaviour() {
    $('.container-fluid').on("click",".rechazar-pac", function() {
      var id = $(this).data('id');
      
      jQuery('<div/>', {
        id: 'dialogRechazar',
        text: ''
      }).appendTo('.container-fluid');

      $("#dialogRechazar").dialog({
        title: "Aprobar una Acción",
        show: {
          effect: "fold"
        },
        hide: {
          effect: "fade"
        },
        modal: true,
        width : 400,
        height : 300,
        closeOnEscape: true,
        resizable: false,
        dialogClass: "alert",
        open: function () {
          jQuery('<p/>', {
            id: 'dialogRechazar',
            text: "Mensaje adicional al rechazo de la Acción"
          }).appendTo('#dialogRechazar');

          jQuery('<textarea/>', {
            name: "mensaje",
            id: "mensaje",
            placeholder: "Mensaje optativo."
          }).appendTo('#dialogRechazar');
        },
        close: function() {
          removeDialog($(this), 'dialogRechazar');
        },

        buttons :
        {
          "Aceptar" : function () {
            $.ajax ({
              url: "{{url('pacs')}}"+'/'+id+'/rechazar',
              method: 'put',
              data: getDataCambioEstadoAccion(),
              success: function(data){
                console.log("Se rechazó la acción: "+id);
                alert("Se rechazó la acción");
              },
              error: function (data) {
                console.log('Hubo un error.');
                console.log(data);
              }
            });
            removeDialog($(this), 'dialogRechazar');
          },

          "Cancelar" : function () {
            removeDialog($(this), 'dialogRechazar');
          }
        }
      });
		});
  }

  //Selecciona los inputs de un cambio de Estado de una Acción
  function getDataCambioEstadoAccion() {
    var data =
    [
      {
        name: '_token',
        value: $('.container-fluid input').first().val()
      },
      {
        name: 'mensaje',
        value: $('#mensaje').val()
      },
    ];

    console.log(data);

    return data;
  }


  //Inicializa el TypeAhead del nombre del Pac
  function inicializarTypeahead() {
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
  }

  //Validaciones de los valores nuevos
  function newValidationMethods() {
    jQuery.validator.addMethod("selecciono", function(value, element) {
      return $(element).find(':selected').length != 0 && $(element).find(':selected').val() != "";
    }, "Debe seleccionar alguna opcion");

    jQuery.validator.addMethod("completados", function(value, element) {
      return $('#form-modificacion #ediciones-tab input[type="text"]').
        toArray().
        every(
          function (element,value)
            {
              return ($(element).val() != '');
            }) && value > 0;

    }, "Falta la fecha de alguna edicion");
  }

  //Validaciones de los campos
  function inputValidations() {
    $('#modificacion-pac #form-modificacion').validate({
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
          number: true,
          completados: true
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
      ignore: '.select2-input, .select2-focusser, .select2-search__field',
      messages: {
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
          method : 'put',
          url : "{{url('pacs')}}" + '/' + "{{$pac->id_pac}}",
          data : getInput(),
          success : function(data){
            alert("Se actualiza la pac.");
            location.reload();
          },
          error : function(data){
            alert("No se pudo modificar la pac.");
          }
        });
      }
    });
  }

  //Comportamiento al clickear en modificar
  function modificarClick() {
    $('.container-fluid').on('click','#modificar',function() {  
      $('.container-fluid #form-modificacion .nav-tabs').children().first().children().click();

      if($('#modificacion-pac #form-modificacion').valid()){
        $('.container-fluid #form-modificacion').submit(); 
      }else{
        alert('Hay campos que no cumplen con la validacion.');
      }
    });
  }

  //Comportamiento de las modific aciones
  function modificacionesBehaviour() {
    newValidationMethods();
    inputValidations();
    modificarClick();
  }

  //Seleccion de Valores ingresados
  function getSelected() {

    var id_accion = $('#general #tipo_accion').val();
    var id_provincia = $('#general #provincia').val();
    var ids_tematicas = $('#general #tematica').val();
    var ids_destinatarios = $('#alcance #destinatario').val();
    var ids_responsables = $('#alcance #responsable').val();
    var ids_pautas = $('#alcance #pauta').val();
    var ids_componentes = $('#alcance #componente').val();

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
      value: ids_tematicas
    },
    { 
      name: 'ids_destinatarios',
      value: ids_destinatarios
    },
    { 
      name: 'ids_responsables',
      value: ids_responsables
    },
    {
      name: 'ids_pautas',
      value: ids_pautas
    },
    {
      name: 'ids_componentes',
      value: ids_componentes
    }];

    return selected;
  }

  function getInput() {
    var input = $.merge($('#form-modificacion').serializeArray(),getSelected());

    return input;
  }

  $(document).ready(function() {
    inicializarSelect2();
    inicializarTypeahead();
    disableSeeButtons();

    tableFichaTecnica();
    tableAcciones();
    adjustDatatablesView();

    fichaTecnicaBehaviour();
    accionesBehaviour();
    modificacionesBehaviour();

    estadosAccionRender();
    estadosAccionBehaviour();
	});
</script>
