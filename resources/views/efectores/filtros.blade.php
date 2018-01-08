<div class="box box-info">
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
				<div class="form-group col-sm-4">  		  		
					<label for="capacitados" class="control-label col-xs-5">Capacitados</label>
					<div class="col-xs-7">
						<i class="fa btn fa-toggle-on" id="capacitados" name="capacitados" data-check=true></i>
					</div>
				</div>	
				
			</div>
			<hr>
			<div class="row">
				@if(Auth::user()->id_provincia == 25)
				<div class="form-group col-sm-4">
					<label for="provincia" class="control-label col-xs-5">Provincia:</label>
					<div class="col-xs-7">
						<select class="form-control" id="provincia" name="id_provincia">
							<option value="0">Todas las provincias</option>
							@foreach ($provincias as $provincia)
							<option value="{{$provincia->id_provincia}}" title="{{$provincia->titulo}}">{{$provincia->nombre}}</option>	
							@endforeach
						</select>
					</div>
				</div>
				@else
				<select class="form-control" id="provincia" name="id_provincia" style="display: none;">
							<option value="{{Auth::user()->id_provincia}}"></option>
				</select>
				@endif
				<div class="form-group col-sm-4">  		  		
					<label for="departamento" class="control-label col-xs-5">Departamento</label>
					<div class="col-xs-7">
						<select class="form-control" id="departamento" name="id_departamento">
							<option value="0">Todos los departamentos</option>
						</select>
					</div>
				</div>
				<div class="form-group col-sm-4">  		  		
					<label for="localidad" class="control-label col-xs-5">Localidad</label>
					<div class="col-xs-7">
						<input class="form-control" id="localidad" name="localidad" disabled="true">
					</div>
				</div>								
			</div>
			<div class="box-footer">		
				<div class="btn btn-info pull-right" id="filtrar"><i class="fa fa-filter"></i>Filtrar</div>	
			</div>	
		</form>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		{{-- Esta funcion es solo para aquel que pueda ver otras provincias, verifica si tiene que traer el departamento de esa provincia --}}

		@if(Auth::user()->id_provincia === 25)
		$("#filtros").on("change", "#provincia", function(event) {
			event.preventDefault();
			console.log("selecciona provincia va buscar departamentos");

			if ($(this).val() == 0) {
				return;
			}
			
			$.ajax({
				url: "{{url('/efectores/provincias')}}" + "/" + $(this).val() + "/departamentos",
				success: function (data) {
					let departamentos = $("#filtros #departamento");
					departamentos.html('<option value="0">Todos los departamentos</option>');
					$.each(data, function (key, value) {
						$('<option value="'+value.id+'">'+value.departamento+'</option>').appendTo(departamentos);
					});
					console.log(data);
					console.log("Departamentos cargados");
				},
				error: function (data) {
					alert("No se pudieron cargar los departamentos.");
					location.reload();
				}
			});
		});
		@endif

		$("#filtros").on("change", "#departamento", function(event) {
			event.preventDefault();
			console.log("selecciona departamento tiene que ir a buscar localidades");
			$.ajax({
				url: "{{url('/efectores/provincias')}}" + "/" + $('#provincia').val() + "/departamentos" + "/" + $(this).val(),
				success: function (data) {
					let localidades = $("#filtros #localidad");
					localidades.html('<option value="0">Todos las localidades</option>');
					localidades.attr("disabled", false);
					$.each(data, function (key, value) {
						$('<option value="'+value.id+'">'+value.localidad+'</option>').appendTo(localidades);
					});
					console.log(data);
					console.log("Localidades cargadas");
				},
				error: function (data) {
					alert("No se pudieron cargar las localidades.");
					location.reload();
				}
			});			
		});

		$("#filtros").on("click", "#capacitados", function () {

			switchIcon($(this),"fa-toggle-off","fa-toggle-on");

			$(this).data("check", !$(this).data("check"));
			
		});	
	});
</script>