@extends('layouts.adminlte')

@section('content')
<div class="container">
	<div id="abm">
		{{csrf_field()}}
		<div class="col-xs-12">
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
					</div>
					<div class="row" style="padding-left:2em; padding-bottom:2em;">
					<a href="#table" class="btn btn-square filtro" id="pautas-refresh">
						<i class="fa fa-refresh text-info fa-lg"></i>
					</a>
					</div>
					<table id="table" class="table table-hover" style="display: none;">
						<thead>
							<tr>
                                <th>Numero</th>
								<th>Nombre</th>
								<th>Ficha Obligatoria</th>
								<th>Años</th>
								<th>Acciones</th>
							</tr>
						</thead>
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
<script type="text/javascript">

	function iconoFontAwesome({icono="fa-bolt", color="#000000" , titulo=""}) {
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
		
		data = {
			anios: anios
		};

		return data;
	}

	$(document).ready(function(){

		$('.anios').select2({
			"placeholder": {
				id: '0',
				text: " Todos los años"
			},
			width : "200%"
		});

		$('[data-toggle="popover"]').popover(); 

		$('#pautas-refresh').click(function () {

			$('#table').show();

			$('#table').DataTable({
				destroy: true,
				scrollCollapse: true,
				ajax : {
					url: 'pautasTabla',
					data: {
						filtros: getFiltrosJson()
					}
				},
				columns: [
				{ data: 'numero', orderable: false},
				{ data: 'nombre'},
				{ data: 'ficha_obligatoria', 
					render: function ( data, type, row, meta ) {
							return estadosFicha(data);
					}
				},
				{ data: 'anios', orderable: false,
					render: function ( data, type, row, meta ) {
						console.log(data[0]);

						if(Object.entries(data[0]).length != 0)
							return data[0].map(function(anio) { return ' ' + anio.anio; });
					}
				},
				{ data: 'acciones', orderable: false}
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
		}).appendTo('.container');

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
							location.reload();
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
				location.reload();
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
				location.reload();
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