<div class="col-sm-12">
	<div class="box box-success ">
		<div class="box-header with-border">
			<h2 class="box-title">Curso</h2>
		</div>		
		<div class="box-body">
			<form class="form" role="form">	
			{{ csrf_field() }}
			{{ method_field('PUT') }}
				<div class="form-group col-sm-12">          
					<label class="col-xs-2">Nombre:</label>
					<div class="typeahead__container col-xs-10">
						<div class="typeahead__field ">             
							<span class="typeahead__query ">
								<input class="nombre_typeahead " name="nombre" type="search" placeholder="Buscar o agregar uno nuevo" autocomplete="off"
								value="{{$curso->nombre}}">
							</span>
						</div>
					</div>
				</div>	
				<div class="form-group col-sm-6">
					<label for="provincia" class="control-label col-sm-4">Provincia:</label>
					<div class="col-sm-8">
						<select class="form-control" id="provincia" name="provincia">

							<option data-id="{{$curso->id_provincia}}">{{$provincia}}</option>

							@foreach ($provincias as $provincia)

							<option data-id="{{$provincia->id}}">{{$provincia->nombre}}</option>				 

							@endforeach
						</select>
					</div>
				</div>	
				<div class="form-group col-sm-6">
					<label for="area_tematica" class="control-label col-sm-4">Area tematica:</label>
					<div class="col-sm-8">
						<select class="form-control" id="area_tematica" name="area_tematica">

							<option data-id="{{$curso->id_area_tematica}}">{{$area}}</option>

							@foreach ($areas_tematicas as $area)
							
							<option data-id="{{$area->id}}">{{$area->nombre}}</option>				 
							
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group col-sm-6">
					<label for="linea_estrategica" class="control-label col-sm-4">Linea Estrategica:</label>
					<div class="col-sm-8">
						<select class="form-control" id="linea_estrategica" name="linea_estrategica">

							<option data-id="{{$curso->id_linea_estrategica}}">{{$linea}}</option>

							@foreach ($lineas_estrategicas as $linea)
							
							<option data-id="{{$linea->id}}">{{$linea->nombre}}</option>				 
							
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group col-sm-6">
					<label for="edicion" class="control-label col-sm-4">Edicion:</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="edicion" name="edicion" value="{{$curso->edicion}}" disabled>
					</div>
				</div>
				<div class="form-group col-sm-6">
					<label for="duracion" class="control-label col-sm-4">Duracion:</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="duracion" name="duracion" value="{{$curso->duracion}}">
					</div>
				</div>
				<div class="form-group col-sm-6">
					<label class="col-sm-3">Fecha:</label>

					<div class="input-group date col-sm-9">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" name="fecha" class="form-control pull-right" id="datepicker" value="{{$curso->fecha}}">
					</div>
				</div>
			</form>
		</div>		


		<div class="box-footer">
			<button class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i>Volver</button>
			<button class="btn btn-primary pull-right" id="modificar" title="Modificar" data-id="{{$curso->id}}"><i class="fa fa-plus" aria-hidden="true"></i>Modificar</button>
		</div>
	</div> 
</div>

<script type="text/javascript" src="{{asset("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js")}}"></script>

<script src="{{asset("/bower_components/admin-lte/plugins/datepicker/locales/bootstrap-datepicker.es.js")}}" charset="UTF-8"></script>

<script type="text/javascript">
	$.typeahead({
				input: '.nombre_typeahead',
				order: "desc",
				source: {
					info: {
						ajax: {
							type: "get",
							url: "cursos/nombres",
							path: "data.info"
						}
					}
				},
				callback: {
					onInit: function (node) {
						console.log('Typeahead Initiated on ' + node.selector);
					}
				}
			});

   //Date picker
   $('#datepicker').datepicker({
   	format: 'dd/mm/yyyy',
   	language: 'es',
   	autoclose: true
   });
</script>