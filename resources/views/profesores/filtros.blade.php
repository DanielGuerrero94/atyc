<div class="box box-info" style="display: none;">
	<div class="box-header with-border">
		<h2 class="box-title">Filtros</h2>
		<div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
			<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
		</div>
	</div>
	<div class="box-body">
		<form id="form-filtros">
			<div class="row">
				<div class="form-group col-sm-4">  		  		
					<label for="Nombres" class="control-label col-xs-5">Nombres</label>
					<div class="col-xs-7">
						<input class="form-control" id="nombres" name="nombres">
					</div>
				</div>						

				<div class="form-group col-sm-4">  		  		
					<label for="Apellidos" class="control-label col-xs-5">Apellidos</label>
					<div class="col-xs-7">
						<input class="form-control" id="apellidos" name="apellidos">
					</div>
				</div>							
			</div>

			<div class="row">
				<div class="form-group col-sm-4">
					<label class="control-label col-xs-5" for="id_tipo_documento">Tipo de Documento:</label>
					<div class="col-xs-7">
						<select class="form-control" id="id_tipo_documento" title="Documento nacional de identidad" name="id_tipo_documento">
							@foreach ($tipoDocumento as $documento)

							<option value="{{$documento->id_tipo_documento}}" title="{{$documento->titulo}}">{{$documento->nombre}}</option>										
							@endforeach
						</select>
					</div>
				</div>	
				<div class="form-group col-sm-4">  		  		
					<label for="Nro doc" class="control-label col-xs-5">Nro doc</label>
					<div class="col-xs-7">
						<input class="form-control" id="nro_doc" name="nro_doc">
					</div>
				</div>					
			</div>
				<!-- <div class="row">
					<div class="form-group col-sm-4">
						<label class="control-label col-xs-5" for="id_tipo_docente">Tipo de Documento:</label>
						<div class="col-xs-7">
							<select class="form-control" id="id_tipo_docente" name="id_tipo_docente">
								@foreach ($tipoDocente as $docente)

								<option value="{{$docente->id_tipo_docente}}">{{$docente->nombre}}</option>

								@endforeach
							</select>
						</div>
					</div>	
				</div> -->
				<div class="row">
					<div class="form-group col-sm-4">  		  		
						<label for="Email" class="control-label col-xs-5">Email</label>
						<div class="col-xs-7">
							<input class="form-control" id="email" name="email">
						</div>
					</div>						

					<div class="form-group col-sm-4">  		  		
						<label for="Cel" class="control-label col-xs-5">Cel</label>
						<div class="col-xs-7">
							<input class="form-control" id="cel" name="cel">
						</div>
					</div>
					<div class="form-group col-sm-4">  		  		
						<label for="Tel" class="control-label col-xs-5">Tel</label>
						<div class="col-xs-7">
							<input class="form-control" id="tel" name="tel">
						</div>
					</div>							
				</div>
				<div class="box-footer">		
					<div class="btn btn-info pull-right" id="filtrar"><i class="fa fa-filter"></i>Filtrar</div>	
				</div>
			</form>
		</div>
	</div>
