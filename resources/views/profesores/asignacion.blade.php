<form>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<form role="form">
				<div class="row" id="busqueda-docentes">
					<div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6">  
						<label for="profesor" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">Buscar docente:</label>
						<div class="typeahead__container col-xs-10 col-sm-10 col-md-10 col-lg-10">
							<div class="typeahead__field">             
								<span class="typeahead__query">
									<input class="profesores_typeahead form-control" name="profesor" type="search" placeholder="Número de documento, nombres, apellido -- Min 3 caracteres" autocomplete="off" id="profesor">
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
					<p>Docentes a cargo del curso - Cantidad: <b><span id="contador-docentes"></span></b></p>
				</div>
				@if(isset($curso))
				<div class="box-body">
					@else
					<div class="box-body" style="display: none;">
						@endif
						<table class="table table-striped" id="profesores-del-curso">
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
								@foreach($curso->profesores as $profesor)
								<tr>
									<td>{{$profesor->nombres}}</td>
									<td>{{$profesor->apellidos}}</td>
									<td>{{$profesor->nro_doc}}</td>
									<td>
                                        <div class="btn btn-xs btn-info"><a href="{{url('/profesores/'.$profesor->id_profesor)}}"><i class="fa fa-search" data-id="{{$profesor->id_profesor}}"></i></a></div>
    @if(!isset($disabled))
                                        <div class="btn btn-xs btn-danger quitar"><i class="fa fa-minus"></i></div>
@endif
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
	</div>
</form>
