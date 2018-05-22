<form>
    @if(!isset($disabled))
    <div class="row">
        <div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <label for="destinatario" class="control-label col-md-2 col-xs-2">Destinatario: </label>
            <div class="col-md-10 col-xs-10">
                <select class="form-control" id="select-destinatarios" name="destinatario">
                    <option selected disabled>Seleccionar</option>
                    @foreach($destinatarios as $destinatario)
                    <option value="{{$destinatario->id_destinatario}}" data-id="{{$destinatario->id_funcion}}" data-nombre="{{$destinatario->nombre}}">{{$destinatario->nombre}}</option>
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
                    <p>Destinatarios - Cantidad:
                        <b><span id="contador-destinatarios"></span></b>
                    </p>
				</div>
				@if(isset($pac))
				<div class="box-body">
				@else
				<div class="box-body" style="display: none;">
				@endif
				<table class="table table-striped" id="destinatarios-pac">
					<thead>
						<tr>
                            <th>Nombre</th>
							@if(!isset($disabled))
							<th>Acciones</th>
                            @endif
						</tr>
					</thead>
			    	<tbody>
					@if(isset($pac))
					@foreach($pac->destinatarios as $funcion)
					<tr>
				    	<td>{{$funcion->nombre}}</td>
					    <td>
						@if(!isset($disabled))
						<a data-id="{{$funcion->id_funcion}}" class="btn btn-circle quitar" title="Remover"><i class="fa fa-minus text-danger fa-lg"></i></a>
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
