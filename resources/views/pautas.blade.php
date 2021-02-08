@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
	<div id="abm">
		{{csrf_field()}}
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h2 class="box-tittle">Pautas para Pac</h2>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse">
							<i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="box-body">
					<div id="filtros">
						<div class="row">
							<div class="form-group col-xs-12 col-sm-6">
								<label for="anio" class="control-label col-xs-4 col-sm-2">Año:</label>
								<div class="col-xs-8 col-sm-6">
									<select class="select-2 form-control anios" id="anios" name="id_anio" aria-hidden="true" multiple>
										@for($i = intval(date('Y'))+1; $i > 2015 ; $i--)
										<option data-id="{{$i}}" value="{{$i}}">{{$i}}</option>
										@endfor
									</select>
								</div>
							</div>
						</div>
						@if(Auth::user()->id_provincia == 25)
						<div class="row">
							<div class="form-group col-xs-12 col-sm-6">
								<label for="provincia" class="control-label col-xs-4 col-sm-2">Provincia:</label>
								<div class="col-xs-8 col-sm-6">
									<select class="select-2 form-control provincias" id="provincias" name="id_provincia" aria-hidden="true" multiple>
										@foreach ($provincias as $provincia)
										<option data-id="{{$provincia->id_provincia}}" value="{{$provincia->id_provincia}}">{{$provincia->nombre}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						@endif
					</div>
					<div class="row" style="padding-left:2em; padding-bottom:2em;">
					<a href="#table" class="btn btn-square filtro" id="pautas-refresh" title="Filtrar">
						<i class="fa fa-refresh text-info fa-lg"></i>
					</a>
					</div>
					<table id="table" class="table table-hover" style="display: none;">
					</table>
				</div>
				<div class="box-footer">
					<button class="btn btn-success pull-right" id="nueva_pauta"><i class="fa fa-plus" aria-hidden="true"></i>Nueva pauta</button>
				</div>
			</div>
		</div>
	</div>
	<div id="alta"></div>
</div>
@endsection

@section('script')
<!-- Moment.js -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script type="text/javascript">

	function iconoFontAwesome({icono="fa-bolt", color="#444" , titulo=""}) {
		return '<i class="fa '+icono+' fa-lg" style="color: '+color+';" title="'+titulo+'"> </i>';
	}

	function estadosFicha(ficha_obligatoria) {
		iconos = '';
		if(!ficha_obligatoria)
			iconos += iconoFontAwesome({icono: "fa-exclamation-triangle", color: "#D3D3D3", titulo: "Optativa"});
		else
			iconos += iconoFontAwesome({icono: "fa-exclamation-triangle", color: "#1E90FF", titulo: "Obligatoria"});

		return iconos;
	}

	function getFiltrosJson() {
		var anios = $('#anios').val();
		var provincias = $('#provincias').val();
		@if(Auth::user()->id_provincia != 25)
			provincias = [{{Auth::user()->id_provincia}}, 25];
		@endif

		data = {
			anios: anios,
			provincias: provincias
		};
		console.log(data);
		return data;
	}

	function createdAtValidDate(created_at) {
		var created_date = moment(created_at);
		var current_date = moment();

		diff = current_date.diff(created_date, 'days');

		return diff <= 7; // se creo la misma semana
	}

	function acciones(deleted_at, created_at, id_pauta, id_provincia) {
		curr_prov = {{Auth::user()->id_provincia}};
		buttons = '';

		if(id_provincia == curr_prov || curr_prov == 25) {
			buttons += '<a data-id="'+id_pauta+'" class="btn btn-circle editar" '+
			'title="Editar" style="margin-right: 1rem;"><i class="fa fa-pencil" aria-hidden="true" style="color: dodgerblue;"></i></a>';

			if(deleted_at)
				buttons += '<a data-id="'+id_pauta+'" class="btn btn-circle darAlta" '+
				'title="Dar de alta" style="margin-right: 1rem;"><i class="fa fa-plus" aria-hidden="true" style="color: forestgreen;"></i></a>';
			else
				buttons += '<a data-id="'+id_pauta+'" class="btn btn-circle darBaja" '+
				'title="Dar de baja" style="margin-right: 1rem;"><i class="fa fa-minus" aria-hidden="true" style="color: firebrick;"></i></a>';

			if(createdAtValidDate(created_at))
				buttons += '<a data-id="'+id_pauta+'" class="btn btn-circle eliminar" '+
			'title="Eliminar" style="margin-right: 1rem;"><i class="fa fa-trash" aria-hidden="true" style="color: dimgray;"></i></a>';
		}

		return buttons;
	}

	$(document).ready(function(){

		$('.anios').select2({
			"placeholder": {
				id: '0',
				text: " Todos los años"
			},
			width : "200%"
		});

		$('.provincias').select2({
			"placeholder": {
				id: '0',
				text: " Todas las provincias"
			},
			width : "200%"
		});

		$('.select-2').on('select2:select', function () {
			$('.select2-container--default .select2-selection--multiple .select2-selection__choice').css('color', '#444 !important')
		});

		$('.select-2').on('select2:unselect', function () {
			$('.select2-container--default .select2-selection--multiple .select2-selection__choice').css('color', '#444 !important');
		});

		$('[data-toggle="popover"]').popover();

		$('#pautas-refresh').click(function () {

			$('#table').show();

			$('#table').DataTable({
				destroy: true,
				scrollCollapse: true,
				ajax : {
					url: 'categoriasPautasTabla',
					data: {
						filtros: getFiltrosJson()
					}
				},
				columns: [
				{ title: 'Creación', data: 'pauta_created_at', defaultContent: '-',
					render: function(data, type, row, meta) {
						if(data) {
							return moment(data).format('DD/MM/YYYY');
						} else if(row.categoria_created_at) {
							return moment(row.categoria_created_at).format('DD/MM/YYYY');
						}
					}
				},
                { title: 'Categoria', data: 'categoria_numero', defaultContent: '-',
                    render: function(data, type, row, meta) {
                        if(data) {
                            return `<b>${data}</b> - ${row.categoria_nombre}`;
                        }
                    }
                },
				{ title: 'Pauta', data: 'pauta_numero', defaultContent: '-',
					render: function(data, type, row, meta) {
						if(data) {
							return `<b>${data}</b> - ${row.pauta_nombre}`;
						}
					}
				},
				{ title: 'Ficha Obligatoria', data: 'ficha_obligatoria', defaultContent: "-",
					render: function ( data, type, row, meta ) {
						return estadosFicha(data);
					}
				},
				{ title: 'Jurisdicción', data: 'provincia_nombre', name: 'id_provincia', defaultContent: '-'},
				{ title: 'Años', data: 'anios', orderable: false, defaultContent: "-",
					render: function ( data, type, row, meta ) {
						if(Object.entries(data[0]).length != 0)
							return data[0].map(function(anio) { return ' ' + anio.anio; });
					}
				},
				{ title: 'Descripción', data: 'descripcion', defaultContent: "-" },
				{ title: 'Acciones', data: 'pauta_deleted_at', defaultContent: "-",
					render: function( data, type, row, meta ) {
						if(row.pauta_created_at) {
							return acciones(data, row.pauta_created_at, row.id_pauta, row.id_provincia);
						}
					}
				}
				]
			});
		});

		$('#abm').on('click','#nueva_pauta',function() {
			$.ajax ({
				url: 'pautas/alta',
				method: 'get',
				success: function(data){
					$('#alta').html(data);
					$('#alta').show();
					$('#abm').hide();
				}
			});
		});

		$('#alta').on('click','#volver',function() {
			$('#abm').show();
			$('#alta').hide();
			$('#alta form').remove();
		});

	$('#abm').on('click','.editar',function() {

		var pauta = $(this).data('id');

		$.ajax ({
			url: 'pautas/'+pauta,
			success: function(data){
				$('#alta').html(data);
				$('#alta').show();
				$('#abm').hide();
			}
		});
	});

	$('#abm').on("click",".eliminar",function(){
		var pauta = $(this).data('id');
		var data = '_token='+$('#abm input').first().val();

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
					text: '¿Esta seguro que quiere dar de baja la pauta?'
				}).appendTo('#dialogABM');
			},
			buttons :
			{
				"Aceptar" : function () {
					$(this).dialog("destroy");
					$("#dialogABM").html("");

					$.ajax ({
						url: 'pautas/'+pauta+'/hard',
						method: 'delete',
						data: data,
						success: function(data){
							console.log('Se borro la pauta: '+pauta);
							alert("Se borro la pauta");
							$('#table').DataTable().clear().draw();
						},
						error: function (data) {
							alert("Hay un curso usando esa pauta. No se puede borrar el registro");
							console.log('Hubo un error.');
							console.log(data);
							location.reload();
						}
					});

				},
				"Cancelar" : function () {
					$(this).dialog("destroy");
					$("#dialogABM").html("");
					location.reload("true");
				}
			}
		});
	});

	$('#abm').on('click','.darBaja',function() {

		var pauta = $(this).data('id');
		var data = '_token='+$('#abm input').first().val();
		console.log(pauta);
		console.log(data);
		$.ajax ({
			url: 'pautas/'+pauta,
			method: 'delete',
			data: data,
			success: function(data){
				console.log("Se dio de baja la pauta: "+pauta);
				alert("Se dio de baja la pauta");
                $('#table').DataTable().clear().draw();
			},
			error: function(data){
				console.log("Error.");
				console.log(data);
			}
		});
	});


	$('#abm').on('click','.darAlta',function() {

		var pauta = $(this).data('id');
		var data = '_token='+$('#abm input').first().val();

		$.ajax ({
			url: 'pautas/'+pauta+'/alta',
			method: 'put',
			data: data,
			success: function(data){
				console.log("Se dio de alta la pauta: "+pauta);
				alert("Se dio de alta la pauta");
                $('#table').DataTable().clear().draw();
			},
			error: function(data){
				console.log("Error.");
				console.log(data);
			}
		});
	});

});
</script>
@endsection