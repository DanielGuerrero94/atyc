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
								<input name="item" type="number" class="form-control" id="item" value="{{$pauta->item}}">
							</div>
						</div>						
						<div class="form-group col-sm-6">
							<label for="descripcion" class="control-label col-xs-4">Descripcion:</label>
							<div class="col-xs-8">
								<input name="descripcion" type="text" class="form-control" id="descripcion" value="{{$pauta->descripcion}}">
							</div>
						</div>
						<div class="form-group col-sm-6">
							<label class="control-label col-xs-4" for="id_categoria_pauta">Accion de la Pauta:</label>
							<div class="col-xs-8">
								<select class="form-control" id="id_categoria_pauta" name="id_categoria_pauta">
									@foreach ($categoriaPauta as $categoria)
									@if($pauta->id_categoria_pauta == $categoria->id_categoria_pauta)
										<option value="{{$categoria->id_categoria_pauta}}" title="{{$categoria->item}}" selected>{{$categoria->nombre}}</option>
									@else
										<option value="{{$categoria->id_categoria_pauta}}" title="{{$categoria->item}}">{{$categoria->nombre}}</option>
									@endif
									@endforeach
								</select>
							</div>
						</div>
			            <div class="form-group col-sm-6">          
				            <label for="provincia" class="control-label col-xs-4">Provincia:</label>
				            <div class="col-xs-8">
				                @if(Auth::user()->id_provincia == 25)
					                <select class="form-control" id="id_provincia" name="id_provincia">
					                    @foreach ($provincias as $provincia)
					                    @if($pauta->id_provincia == $provincia->id_provincia)           
					                       <option data-id="{{$provincia->id_provincia}}" title="{{$provincia->nombre}}" value="{{$provincia->id_provincia}}" selected>{{$provincia->nombre}}</option>
					                    @else
					                    	<option data-id="{{$provincia->id_provincia}}" title="{{$provincia->nombre}}" value="{{$provincia->id_provincia}}">{{$provincia->nombre}}</option>
					                    @endif
					                    @endforeach
					                </select>
				                @else
					                <select class="form-control" id="id_provincia" name="id_provincia" name="id_provincia" disabled>
					                    <option data-id="{{Auth::user()->id_provincia}}" value="{{Auth::user()->id_provincia}}">{{Auth::user()->name}}</option>  
					                </select>
				                @endif
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

		$('#alta #id_categoria_pauta').val($('#alta #id_categoria_pauta').attr('value'));


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
				url: "{{url('/pautas')}}"+"/"+pauta,
				method: 'put',
				data: data,
				success: function(data){
					console.log('Se modificaron los datos de la pauta correctamente.');
					$('#alta').html("");
					$('#abm').show();
					$('#filtros').show();
					window.location = "{{url('/pautas')}}";
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