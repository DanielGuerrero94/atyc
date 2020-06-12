<div class="col-sm-6 col-sm-offset-3">
	<div class="box box-success">
		<div class="box-header">Gestor</div>
		<div class="box-body">
			<form id="form-modificacion"> 
				{{ csrf_field() }}
				<div class="row">
                    <div class="form-group col-sm-12">
						<label for="name" class="control-label col-xs-4">Nombre:</label>
						<div class="col-xs-8">
							<input type="text" class="form-control" id="name" name="name" value="{{$gestor->name}}" required>
						</div>
					</div>
                    <div class="form-group col-sm-12">
						<label for="email" class="control-label col-xs-4">E-mail:</label>
						<div class="col-xs-8">
							<input type="text" class="form-control" id="email" name="email" value="{{$gestor->email}}" required>
						</div>
					</div>
                    <div class="form-group col-sm-12">
						<label for="title" class="control-label col-xs-4">Descripción:</label>
						<div class="col-xs-8">
							<input type="text" class="form-control" id="title" name="title" value="{{$gestor->title}}" required>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="box-footer">
			<button class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i>Volver</button>
			<button class="btn btn-primary pull-right" id="modificar" title="Modificar" data-id="{{$gestor->id_user}}"><i class="fa fa-plus" aria-hidden="true"></i>Modificar</button>
		</div>
	</div>
</div>