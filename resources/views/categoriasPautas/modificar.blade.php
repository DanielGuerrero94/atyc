@extends('layouts.adminlte')
@section('content')
<div class="container">
	<div class="col-xs-12">
		<div class="box box-success">
			<div class="box-header">Categoria Pauta</div>
			<div class="box-body">				
				<form id="form-alta">
				{{ csrf_field() }}
				{{ method_field('PUT') }}
				
					<div class="row">
						<div class="form-group col-sm-6">
							<label class="control-label col-xs-4" for="nro_doc">Item:</label>
							<div class="col-xs-8">
								<input name="item" type="number" class="form-control" id="item" value="{{$categoriaPauta->item}}">
							</div>
						</div>
						<div class="form-group col-sm-6">
							<label for="nombre" class="control-label col-xs-4">Nombre:</label>
							<div class="col-xs-8">
								<input name="nombre" type="text" class="form-control" id="nombre" value="{{$categoriaPauta->nombre}}">
							</div>
						</div>						
						<div class="form-group col-sm-6">
							<label for="descripcion" class="control-label col-xs-4">Descripcion:</label>
							<div class="col-xs-8">
								<input name="descripcion" type="text" class="form-control" id="descripcion" value="{{$categoriaPauta->descripcion}}">
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="box-footer">
			<a href="{{url()->previous()}}">
				<button class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i>Volver</button>
			</a>
				<div class="btn btn-primary pull-right" id="modificar" title="Modificar" data-id="{{$categoriaPauta->id_categoria_pauta}}"><i class="fa fa-plus" aria-hidden="true"></i>Modificar</div>
			</div>
		</div> 
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready(function () {


		$("#alta").on("click","#volver",function(){
			console.log('Se vuelve sin crear categoria pauta.');
			$('#alta').html("");
			$('#abm').show();
		});


		$(".container").on("click","#modificar",function () {
			var data = $('#form-alta').serialize();
			console.log(data);
			var categoria = $('.container #modificar').data('id');
			console.log(categoria);
			$.ajax({
				url: "{{url('/categoriasPautas')}}"+"/"+categoria,
				method: 'put',
				data: data,
				success: function(data){
					console.log('Se modificaron los datos de la categoria pauta correctamente.');
					$('#alta').html("");
					$('#abm').show();
					$('#filtros').show();
					window.location = "{{url('/categoriasPautas')}}";
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