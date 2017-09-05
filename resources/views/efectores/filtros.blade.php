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
					<label for="nombres" class="control-label col-xs-5">Cuie</label>
					<div class="col-xs-7">
						<input class="form-control" id="nombres" name="nombres">
					</div>
				</div>						
				<div class="form-group col-sm-4">  		  		
					<label for="apellidos" class="control-label col-xs-5">Siisa</label>
					<div class="col-xs-7">
						<input class="form-control" id="apellidos" name="apellidos">
					</div>
				</div>						
			</div>
			<hr>
			<div class="row">
				<div class="form-group col-sm-4">  		  		
					<label for="localidad" class="control-label col-xs-5">Localidad</label>
					<div class="col-xs-7">
						<input class="form-control" id="localidad" name="localidad">
					</div>
				</div>					
				@if(Auth::user()->id_provincia == 25)
				<div class="form-group col-sm-4">
					<label for="provincia" class="control-label col-xs-5">Provincia:</label>
					<div class="col-xs-7">
						<select class="form-control" id="provincia" name="id_provincia">
							<option data-id="0" value="0">Todas las provincias</option>
							@foreach ($provincias as $provincia)

							<option data-id="{{$provincia->id_provincia}}" value="{{$provincia->id_provincia}}" title="{{$provincia->titulo}}">{{$provincia->nombre}}</option>									
							@endforeach
						</select>
					</div>
				</div>
				@endif					
			</div>
			<div class="box-footer">		
				<div class="btn btn-info pull-right" id="filtrar"><i class="fa fa-filter"></i>Filtrar</div>	
			</div>	
		</form>
	</div>
</div>