<form>
@if(!isset($disabled))
    <div class="row">
        <div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <label for="area-tematica" class="control-label col-md-2 col-xs-2">Tematica: </label>
            <div class="col-md-10 col-xs-10">
                <select class="form-control" id="select-areas-tematicas" name="area-tematica">
                    <option selected disabled>Seleccionar</option>
                    @foreach($tematicas as $tematica)
                    <option value="{{$tematica->id_area_tematica}}" data-id="{{$tematica->id_area_tematica}}" data-nombre="{{$tematica->nombre}}">{{$tematica->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <br>
@endif
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box box-default no-padding">
				<div class="box-header">
					<p>Areas Tematicas - Cantidad: <b><span id="contador-areasTematicas"></span></b></p>
				</div>
				@if(isset($curso))
				<div class="box-body">
					@else
					<div class="box-body" style="display: none;">
						@endif
						<table class="table table-striped" id="areasTematicas-de-la-pac">
							<thead>
								<tr>
									<th>Nombre</th>
										@if(!isset($disabled))
									<th>Acciones</th>
										@endif
								</tr>
							</thead>
							<tbody>
								@if(isset($curso))
								@foreach($curso->areasTematicas as $areaTematica)
								<tr>
									<td>{{$areaTematica->nombre}}</td>
									<td>
                                        @if(!isset($disabled))
									<a data-id="{{$areaTematica->id_area_tematica}}" class="btn btn-circle quitar" title="Remover"><i class="fa fa-minus text-danger fa-lg"></i></a>
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
	</form>
