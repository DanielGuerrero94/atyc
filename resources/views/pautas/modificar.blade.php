<div class="col-sm-6 col-sm-offset-3">
	<div class="box box-success ">
		<div class="box-header">Pauta</div>
		<div class="box-body">
			<form> 
				{{ csrf_field() }}
				<div class="row">
					<div class="form-group col-sm-12">
						<label for="anio" class="control-label col-xs-4">Año/s:</label>
						<div class="col-xs-8">
							<select class="select-2 form-control anio" id="anio" name="anio" aria-hidden="true" multiple>
								@foreach($anios as $anio)
									@for($i = intval(date('Y')); $i > 2015 ; $i--)
										@if($i == $anio->anio)
                                		<option data-id="{{$i}}" value="{{$i}}" selected="selected">{{$i}}</option>
										@else
                                		<option data-id="{{$i}}" value="{{$i}}">{{$i}}</option>
										@endif
                                	@endfor
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group col-sm-12">
						<label for="categoria" class="control-label col-xs-4">Categoria:</label>
						<div class="col-xs-8">
						<select class="select-2 form-control categoria" id="categoria" name="id_categoria" aria-hidden="true">
							@foreach ($categorias as $categoria)
								@if ($categoria->id_categoria === $pauta->id_categoria)
									<option value="{{$categoria->id_categoria}}" data-id="{{$categoria->id_categoria}}" title="{{$categoria->nombre}}" selected="selected">{{$categoria->id_categoria." - ".$categoria->nombre}}</option>
								@else
									<option value="{{$categoria->id_categoria}}" data-id="{{$categoria->id_categoria}}" title="{{$categoria->nombre}}">{{$categoria->id_categoria." - ".$categoria->nombre}}</option>
								@endif
							@endforeach
						</select>
						</div>
					</div>
					<div class="form-group col-sm-12">
						<label for="ficha_obligatoria" class="control-label col-xs-4">Ficha obligatoria:</label>
						<div class="col-xs-8">
							<select class="form-control" id="ficha_obligatoria" name="ficha_obligatoria">
								@if ($pauta->ficha_obligatoria)
									<option value="{{$pauta->ficha_obligatoria}}" data-id="{{$pauta->ficha_obligatoria}}" title="Ficha Obligatoria" selected="selected">Ficha Obligatoria</option>
									<option value="false" data-id="false" title="Ficha Optativa">Ficha Optativa</option>
								@else
									<option value="{{$pauta->ficha_obligatoria}}" data-id="{{$pauta->ficha_obligatoria}}" title="Ficha Optativa" selected="selected">Ficha Optativa</option>
									<option value="true" data-id="true" title="Ficha Obligatoria">Ficha Obligatoria</option>
								@endif
							</select>
						</div>
					</div>
                    <div class="form-group col-sm-12">
						<label for="numero" class="control-label col-xs-4">Numero:</label>
						<div class="col-xs-8">
							<input type="text" class="form-control" id="numero" name="numero" value="{{$pauta->numero}}" required>
						</div>
					</div>
					<div class="form-group col-sm-12">
						<label for="nombre" class="control-label col-xs-4">Nombre:</label>
						<div class="col-xs-8">
							<input type="text" class="form-control" id="nombre" name="nombre" value="{{$pauta->nombre}}" required>
						</div>
					</div>
					<div class="form-group col-sm-12">
						<label for="descripcion" class="control-label col-xs-4">Descripción:</label>
						<div class="col-xs-8">
							<textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripción de la pauta" data-autosize-input='{ "space": 40 }'>{{$pauta->descripcion}}</textarea>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="box-footer">
			<button class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i>Volver</button>
			<button class="btn btn-primary pull-right" id="modificar" title="Modificar" data-id="{{$pauta->id_pauta}}"><i class="fa fa-plus" aria-hidden="true"></i>Modificar</button>
		</div>
	</div> 
</div>

<script type="text/javascript">

	function getSelected() {
		var anios = $('#anio').val();
		var provincia = {{Auth::user()->id_provincia}};
		var categoria = $('#categoria').val();

		return [
			{
				name: 'anios',
				value: anios
			},
			{
				name: 'id_provincia',
				value: provincia
			},
			{
				name: 'id_categoria',
				value: categoria
			}
		];
	}
	
	function getForm() {

		var input = $.merge($('form').serializeArray(),getSelected());

		console.log(input);

		return input;
	}

	function inicializarSelect2() {
		$('.anio').select2({
			"placeholder": {
				id: '0',
				text: " Seleccionar año/s"
			},
			"width" : '100%'
		});

		$('.categoria').select2({
			"placeholder": " Seleccionar categoria",
			"width" : '100%'
		});

		$('.select-2').ready(function() {
			$('.select2-container--default .select2-selection--multiple').css('height', 'auto');
			$('.select2-container--default .select2-selection--single').css('height', 'auto');
			$('.select2-container .select2-selection--single .select2-selection__rendered').css('white-space', 'normal');
			$('.select2-container--default .select2-selection--multiple .select2-selection__choice').css('color', '#444 !important');
		});

		$('.select-2').on('select2:select', function () {
			$('.select2-container--default .select2-selection--multiple .select2-selection__choice').css('color', '#444 !important');
		});

		$('.select-2').on('select2:unselect', function () {
			$('.select2-container--default .select2-selection--multiple .select2-selection__choice').css('color', '#444 !important');
		});

		@if(Auth::user()->id_provincia != 25)
			$('.categoria').each(function (k,v) {$(v).attr('disabled', true);});
		@endif
	}

	$(document).ready(function(){

		$('#alta textarea').on("click", function() {
			var totalHeight = $(this).prop('scrollHeight') - parseInt($(this).css('padding-top')) - parseInt($(this).css('padding-bottom'));
			$(this).css({'height':totalHeight});
		});

		$('#alta textarea').on({
			input: function() {
				var totalHeight = $(this).prop('scrollHeight') - parseInt($(this).css('padding-top')) - parseInt($(this).css('padding-bottom'));
				$(this).css({'height':totalHeight});
			}
		});
		
		inicializarSelect2();

		$('#alta').on('click','#modificar',function() {

			var pauta = $(this).data('id');

			$.ajax({				
				url : 'pautas/'+pauta,
				method : 'put',
				data : getForm(),
				success : function(data){
					console.log("Success.");
					alert("Se modifica la pauta");
					location.reload();	
				},
				error : function(data){
					console.log("Error.");
					console.log(data);
				}
			});
		});

	});

</script>