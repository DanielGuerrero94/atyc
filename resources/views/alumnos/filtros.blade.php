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
					<label for="nombres" class="control-label col-xs-5">Nombres</label>
					<div class="col-xs-7">
						<input class="form-control" id="nombres" name="nombres">
					</div>
				</div>						
				<div class="form-group col-sm-4">  		  		
					<label for="apellidos" class="control-label col-xs-5">Apellidos</label>
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
							@foreach ($documentos as $documento)

							<option data-id="{{$documento->id_tipo_documento}}" title="{{$documento->titulo}}" value="{{$documento->id_tipo_documento}}">{{$documento->nombre}}</option>

							@endforeach
						</select>
					</div>
				</div>	
				<div class="form-group col-sm-4">  		  		
					<label for="nro_doc" class="control-label col-xs-5">Nro doc</label>
					<div class="col-xs-7">
						<input class="form-control" id="nro_doc" name="nro_doc" type="number">
					</div>
				</div>						
			</div>	
			<hr>					
			<div class="row">
				<div class="form-group col-sm-4">  		  		
					<label for="email" class="control-label col-xs-5">Email</label>
					<div class="col-xs-7">
						<input class="form-control" id="email" name="email">
					</div>
				</div>						
				<div class="form-group col-sm-4">  		  		
					<label for="tel" class="control-label col-xs-5">Tel</label>
					<div class="col-xs-7">
						<input class="form-control" id="tel" name="tel" type="number">
					</div>
				</div>						
				<div class="form-group col-sm-4">  		  		
					<label for="cel" class="control-label col-xs-5">Cel</label>
					<div class="col-xs-7">
						<input class="form-control" id="cel" name="cel" type="number">
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


<!-- 
<div class="form-group col-sm-4">
						<label for="trabaja_en" class="control-label col-xs-5">Trabaja en:</label>
						<div class="col-xs-7">
							<select class="form-control" id="trabaja_en">

								@foreach ($trabajos as $trabajo)

								<option data-id="{{$trabajo->id}}" title="{{$trabajo->nombre}}">{{$trabajo->nombre}}</option>				 					
								@endforeach

							</select>
						</div>
					</div>
					<div class="form-group col-sm-4" style="display: none;">
						<label for="funcion" class="control-label col-xs-5">Funcion que desempeña:</label>
						<div class="col-xs-7">
							<select class="form-control" id="funcion">

								@foreach ($funciones as $funcion)

								<option data-id="{{$funcion->id}}" title="{{$funcion->nombre}}">{{$funcion->nombre}}</option>	

								@endforeach

							</select>
						</div>
					</div>		
				</div>
				<div class="row">
					<div class="form-group checkbox col-sm-4" style="display: none;">	
						<label for="tipo_convenio" class="control-label col-xs-5">Tipo convenio:</label>
						<div class="col-xs-7">
							<input name="tipo_convenio" type="checkbox" id="tipo_convenio">Convenio con el programa CUS SUMAR
						</div>
					</div>
					<div class="form-group col-sm-4" style="display: none;">          
						<label for=efectores class="control-label col-xs-5">Efectores</label>
						<div class="col-xs-7">
							<input class="form-control" id=efectores name=efectores>
						</div>
					</div>
					<div class="form-group col-sm-4" style="display: none">          
						<label for=establecimiento class="control-label col-xs-5">Establecimiento</label>
						<div class="col-xs-7">
							<input class="form-control" id=establecimiento name=establecimiento>
						</div>
					</div>											
				</div>
				<div class="row" >
					<div class="form-group col-sm-4" style="display: none;">
						<label for="tipo_organismo" class="control-label col-xs-5">Organismo:</label>
						<div class="col-xs-7">
							<select class="form-control" name="tipo_organismo" id="tipo_organismo">

								@foreach ($organismos as $organismo)

								<option title="{{$organismo->organismo1}}">{{$organismo->organismo1}}</option>				 					
								@endforeach							

							</select>
						</div>
					</div>
					<div class="form-group col-sm-4" style="display: none">  
						<label for=nombre_organismo class="control-label col-xs-5">Nombre organismo</label>
						<div class="col-xs-7">
							<input class="form-control" id=nombre_organismo name=nombre_organismo>
						</div>
</div>
-->

<script type="text/javascript">

	$('#filtros').on("click","#trabaja_en",function () {
		$(this).attr("title",$(this).find(":selected").attr("title"));
		var tipo_organismo = $('#filtros').find('#tipo_organismo').closest('.form-group');
		var tipo_convenio = $('#filtros').find('#tipo_convenio').closest('.form-group');
		var nombre_organismo = $('#filtros').find('#nombre_organismo').closest('.form-group');
		var funcion = $('#filtros').find('#funcion').closest('.form-group');
		var establecimiento = $('#filtros').find('#establecimiento').closest('.form-group');

		if ($(this).val() == 'ORGANISMO GUBERNAMENTAL') {
			tipo_organismo.show();
			nombre_organismo.show();
			funcion.show();
			tipo_convenio.hide();
			establecimiento.hide();
			efectores.hide();
		}
		else if($(this).val() == 'ESTABLECIMIENTO DE SALUD'){
			tipo_convenio.show();
			establecimiento.show();
			tipo_organismo.hide();
			nombre_organismo.hide();
			funcion.show();
		}
		else {
			tipo_organismo.hide();
			tipo_convenio.hide();
			nombre_organismo.hide();
			funcion.hide();
			establecimiento.hide();
			efectores.hide();
		}			
	});

	var establecimiento = $('#filtros').find('#establecimiento').closest('.form-group');
	var efectores = $('#filtros').find('#efectores').closest('.form-group');

	$('#filtros').on('change','.checkbox',function () {			

		if(efectores.is(':visible')){
			efectores.hide();
			establecimiento.show();	
		}
		else{
			efectores.show();
			establecimiento.hide();			
		}

	});

	$('#filtros').on("click","#id_tipo_documento",function () {
		$(this).attr("title",$(this).find(":selected").attr("title"));
		var nacionalidad = $('#filtros').find('#nacionalidad');
		if ($(this).val() == 'DEX' || $(this).val() == 'PAS' ) {
			nacionalidad.show();
		}
		else {
			nacionalidad.hide();
		}			
	});
</script>