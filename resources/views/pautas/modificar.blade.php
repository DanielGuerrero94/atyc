@extends('layouts.adminlte')
@section('content')
<div class="container">
	<div class="col-xs-12">
		<div class="box box-success">
			<div class="box-header">Pauta</div>
			<div class="box-body">				
				<form id="form-alta">
				{{ csrf_field() }}
				{{ method_field('PUT') }}
					<div class="row">
						<div class="form-group col-sm-6">
							<label class="control-label col-xs-4" for="nro_doc">Item:</label>
							<div class="col-xs-8">
								<input name="item" type="text" class="form-control" id="item" value="{{$pauta->item}}">
							</div>
						</div>						
						<div class="form-group col-sm-6">
							<label for="nombre" class="control-label col-xs-4">Nombre:</label>
							<div class="col-xs-8">
								<input name="nombre" type="text" class="form-control" id="nombres" value="{{$pauta->nombre}}">	
							</div>
						</div>
						<div class="form-group col-sm-6">
							<label for="descripcion" class="control-label col-xs-4">Descripcion:</label>
							<div class="col-xs-8">
								<input name="descripcion" type="text" class="form-control" id="descripcion" value="{{$pauta->descripcion}}">
							</div>
						</div>
						<div class="form-group col-sm-6">
							<label class="control-label col-xs-4" for="id_accion_pauta">Accion de la Pauta:</label>
							<div class="col-xs-8">
								<select class="form-control" id="id_accion_pauta" name="id_accion_pauta">
									@foreach ($accionPauta as $accion)							
										@if ($accion->id_accion_pauta == $profesor->id_accion_pauta)
										<option value="{{$accion->id_accion_pauta}}" title="{{$accion->titulo}}" selected="selected">{{$accion->nombre}}</option>
										@else
										<option value="{{$accion->id_accion_pauta}}" title="{{$accion->item}}">{{$accion->nombre}}</option>
										@endif						
									@endforeach
								</select>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="box-footer">
			<a href="{{url()->previous()}}">
				<button class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i>Volver</button>
			</a>
				<div class="btn btn-primary pull-right" id="modificar" title="Modificar" data-id="{{$pauta->id_pauta}}"><i class="fa fa-plus" aria-hidden="true"></i>Modificar</div>
			</div>
		</div> 
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready(function () {

		//Para setear como seleccionado lo que ya tiene seteado

		$('#alta #id_accion_pauta').val($('#alta #id_accion_pauta').attr('value'));


		$("#alta").on("click","#volver",function(){
			console.log('Se vuelve sin crear pauta.');
			$('#alta').html("");
			$('#abm').show();
			$('#filtros').show();
		});

		var pauta = $('.container #modificar').data('id');

		$(".container").on("click","#modificar",function () {
			var data = $('#form-alta').serialize();

			$.ajax({
				url: pauta,
				method: 'put',
				data: data,
				success: function(data){
					console.log('Se modificaron los datos de la pauta correctamente.');
					$('#alta').html("");
					$('#abm').show();
					$('#filtros').show();
					window.location = "{{url('pautas')}}";
				},
				error: function (data) {
					console.log('Error.');
					console.log(data);
				}
			});

		});
		
	});
</script>
@endsection