<form>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<form role="form">
				<div class="row" id="busqueda-participantes">
					<div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6">          
						<label for="alumno" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">Buscar participante:</label>
						<div class="typeahead__container col-xs-10 col-sm-10 col-md-10 col-lg-10">
							<div class="typeahead__field">             
								<span class="typeahead__query">
									<input class="alumnos_typeahead form-control" name="alumno" type="search" placeholder="Número de documento, nombres, apellido -- Min 3 caracteres" autocomplete="off" id="alumno"/>
								</span>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>	
	</div>
	<br>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box box-default no-padding">
				<div class="box-header">
					<p>Partipantes en el curso - Cantidad: <b><span id="contador-participantes"></span></b></p>
				</div>
				@if(isset($curso))
				<div class="box-body">
					@else
					<div class="box-body" style="display: none;">
						@endif
						<table class="table table-striped" id="alumnos-del-curso">
							<thead>
								<tr>
									<th>Nombre</th>
									<th>Apellido</th>
									<th>Documento</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($curso))
								@foreach($curso->alumnos as $alumno)
								<tr>
									<td>{{$alumno->nombres}}</td>
									<td>{{$alumno->apellidos}}</td>
									<td>{{$alumno->nro_doc}}</td>
									<td>
										<div class="btn btn-xs btn-info"><a href="{{url('alumnos/'.$alumno->id_alumno)}}"><i class="fa fa-search" data-id="{{$alumno->id_alumno}}"></i></a></div>
										<div class="btn btn-xs btn-danger quitar"><i class="fa fa-minus"></i></div>
									</td>
								</tr>
								@endforeach
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</form>