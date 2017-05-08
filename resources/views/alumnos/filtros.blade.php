<div class="col-xs-12">
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
			<form id="form-filtros">												<div class="row">								
				<div class="form-group col-sm-4">  		  		
					<label for=Nombres class="control-label col-xs-5">Nombres</label>
					<div class="col-xs-7">
						<input class="form-control" id=Nombres name=Nombres>
					</div>
				</div>						
				<div class="form-group col-sm-4">  		  		
					<label for=Apellidos class="control-label col-xs-5">Apellidos</label>
					<div class="col-xs-7">
						<input class="form-control" id=Apellidos name=Apellidos>
					</div>
				</div>						
				<div class="form-group col-sm-4">
						<label class="control-label col-xs-5" for="tipo_doc">Tipo de Documento:</label>
						<div class="col-xs-7">
							<select class="form-control" id="tipo_doc" title="Documento nacional de identidad">
								@foreach ($documentos as $documento)
								
								<option data-id="{{$documento->id}}" title="{{$documento->titulo}}">{{$documento->nombre}}</option>
								
								@endforeach
							</select>
						</div>
					</div>						
			</div>
			<div class="row">
				<div class="form-group col-sm-4">  		  		
					<label for=Nro_doc class="control-label col-xs-5">Nro_doc</label>
					<div class="col-xs-7">
						<input class="form-control" id=Nro_doc name=Nro_doc>
					</div>
				</div>						
				<div class="form-group col-sm-4">  		  		
					<label for=Email class="control-label col-xs-5">Email</label>
					<div class="col-xs-7">
						<input class="form-control" id=Email name=Email>
					</div>
				</div>						
				<div class="form-group col-sm-4">  		  		
					<label for=Cel class="control-label col-xs-5">Cel</label>
					<div class="col-xs-7">
						<input class="form-control" id=Cel name=Cel>
					</div>
				</div>						

			</div>
			<div class="row">
				<div class="form-group col-sm-4">  		  		
					<label for=Tel class="control-label col-xs-5">Tel</label>
					<div class="col-xs-7">
						<input class="form-control" id=Tel name=Tel>
					</div>
				</div>						
				<div class="form-group col-sm-4">  		  		
					<label for=Localidad class="control-label col-xs-5">Localidad</label>
					<div class="col-xs-7">
						<input class="form-control" id=Localidad name=Localidad>
					</div>
				</div>						
				<div class="form-group col-sm-4">
						<label for="trabaja_en" class="control-label col-xs-5">Trabaja en:</label>
						<div class="col-xs-7">
							<select class="form-control" id="trabaja_en">

								<option data-id="null">Seleccionar</option>

								@foreach ($trabajos as $trabajo)
								
								<option data-id="{{$trabajo->id}}" title="{{$trabajo->nombre}}">{{$trabajo->nombre}}</option>				 					
								@endforeach
								
							</select>
						</div>
					</div>						
			</div>
			<div class="row">
				<div class="form-group col-sm-4" style="display: none;">
						<label for="funcion" class="control-label col-xs-5">Funcion que desempeña:</label>
						<div class="col-xs-7">
							<select class="form-control" id="funcion">

								<option data-id="1" title="Seleccionar">Seleccionar</option>

								@foreach ($funciones as $funcion)

								<option data-id="{{$funcion->id}}" title="{{$funcion->nombre}}">{{$funcion->nombre}}</option>	

								@endforeach

							</select>
						</div>
					</div>						
				<div class="form-group col-sm-4">
						<label for="provincia" class="control-label col-xs-5">Provincia:</label>
						<div class="col-xs-7">
							<select class="form-control" id="provincia">
								@foreach ($provincias as $provincia)
								
								<option data-id="{{$provincia->id}}" title="{{$provincia->titulo}}">{{$provincia->nombre}}</option>									
								@endforeach
							</select>
						</div>
					</div>						
				<div class="form-group checkbox" style="display: none;">	
						<label for="tipo_convenio" class="control-label col-xs-2">Tipo convenio:</label>
						<div class="col-xs-6">
							<input name="tipo_convenio" type="checkbox" id="tipo_convenio">Convenio con el programa CUS SUMAR
						</div>
					</div>						
			</div>
			<div class="row">
				<div class="form-group col-sm-4">  		  		
					<label for=Efectores class="control-label col-xs-5">Efectores</label>
					<div class="col-xs-7">
						<input class="form-control" id=Efectores name=Efectores>
					</div>
				</div>						
				<div class="form-group col-sm-4">  		  		
					<label for=Establecimiento2 class="control-label col-xs-5">Establecimiento2</label>
					<div class="col-xs-7">
						<input class="form-control" id=Establecimiento2 name=Establecimiento2>
					</div>
				</div>						
				<div class="form-group col-sm-4" style="display: none;">
						<label for="tipo_organismo" class="control-label col-xs-5">Organismo:</label>
						<div class="col-xs-7">
							<select class="form-control" name="tipo_organismo" id="tipo_organismo">

								<option>Seleccionar</option>

								@foreach ($organismos as $organismo)
								
								<option title="{{$organismo->organismo1}}">{{$organismo->organismo1}}</option>				 					
								@endforeach							
								
							</select>
						</div>
					</div>						
			</div>
			<div class="row">
				<div class="form-group col-sm-4">  		  		
					<label for=Organismo2 class="control-label col-xs-5">Organismo2</label>
					<div class="col-xs-7">
						<input class="form-control" id=Organismo2 name=Organismo2>
					</div>
				</div>						
				<div class="form-group col-sm-4">  		  		
					<label for=Id_pais class="control-label col-xs-5">Id_pais</label>
					<div class="col-xs-7">
						<input class="form-control" id=Id_pais name=Id_pais>
					</div>
				</div>						
			</div>
			<div class="box-footer">		
				<div class="btn btn-info pull-right" id="filtrar"><i class="fa fa-filter"></i>Filtrar</div>				
			</div>
		</form>
	</div>
</div>
