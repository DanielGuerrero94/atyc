<div class="col-sm-6 col-sm-offset-3">
	<div class="box box-success ">
		<div class="box-header">Area tematica</div>
		<div class="box-body">
			<form> 
				{{ csrf_field() }}
				<div class="row">
					<div class="form-group col-sm-12">
						<label for="nombre" class="control-label col-xs-4">Nombre:</label>
						<div class="col-xs-8">
							<input type="text" class="form-control" id="nombre" name="nombre" value="{{$area->nombre}}" required>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="box-footer">
			<button class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i>Volver</button>
			<button class="btn btn-primary pull-right" id="modificar" title="Modificar" data-id="{{$area->id}}"><i class="fa fa-plus" aria-hidden="true"></i>Modificar</button>
		</div>
	</div> 
</div>