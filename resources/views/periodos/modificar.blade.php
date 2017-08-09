@extends('layouts.adminlte')

@section('content')
<div id="modificar" class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
		<div class="box box-success ">
			<div class="box-header">Periodo</div>
			<div class="box-body">
				<form> 
					{{ csrf_field() }}
					<div class="row">
						<div class="form-group col-sm-12">
							<label for="nombre" class="control-label col-xs-4">Nombre:</label>
							<div class="col-xs-8">
								<input type="text" class="form-control" id="nombre" name="nombre" value="{{$periodo->nombre}}" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-12 col-sm-6">
							<label class="col-xs-4 col-sm-2">Desde:</label>
							<div class="input-group date col-xs-8 col-sm-8">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<input type="text" name="desde" id="desde" class="form-control pull-right datepicker" value="{{$periodo->desde}}">
							</div>
						</div>
						<div class="form-group col-xs-12 col-sm-6">
							<label class="col-xs-4 col-sm-2">Hasta:</label>
							<div class="input-group date col-xs-8 col-sm-8">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<input type="text" name="hasta" id="hasta" class="form-control pull-right datepicker" value="{{$periodo->hasta}}">
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="box-footer">
				<button class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i>Volver</button>
				<button class="btn btn-primary pull-right" id="modificar" title="Modificar" data-id="{{$periodo->id_periodo}}"><i class="fa fa-plus" aria-hidden="true"></i>Modificar</button>
			</div>
		</div> 
	</div>
</div>
</div>
@endsection