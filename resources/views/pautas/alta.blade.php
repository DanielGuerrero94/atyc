<div class="col-sm-6 col-sm-offset-3">
	<div class="box box-success ">
		<div class="box-header">Nueva Pauta</div>
		<div class="box-body">
			<form id="form-alta">
				{{ csrf_field() }}
				<div class="row">
					<div class="form-group col-sm-12">
						<label for="anio" class="control-label col-xs-4">Año/s:</label>
						<div class="col-xs-8">
							<select class="select-2 form-control anio" id="anio" name="anio" aria-hidden="true" multiple>
								<option data-id="{{intval(date('Y'))+1}}" value="{{intval(date('Y'))+1}}">{{intval(date('Y'))+1}}</option>
								<option data-id="{{intval(date('Y'))}}" value="{{intval(date('Y'))}}" selected="selected">{{intval(date('Y'))}}</option>
								@for($i = intval(date('Y'))-1; $i > 2015 ; $i--)
                                <option data-id="{{$i}}" value="{{$i}}">{{$i}}</option>
                                @endfor
							</select>
						</div>
					</div>
                    <div class="form-group col-sm-12">
						<label for="categoria" class="control-label col-xs-4">Categoria:</label>
						<div class="col-xs-8">
							@if(Auth::user()->id_provincia == 25)
							<select class="select-2 form-control categoria" id="categoria" name="id_categoria" aria-hidden="true">
                                <option></option>
								@foreach ($categorias as $categoria)
									<option value="{{$categoria->id_categoria}}" data-id="{{$categoria->id_categoria}}">{{$categoria->numero." - ".$categoria->nombre}}</option>
								@endforeach
							</select>
							@else
							<select class="select-2 form-control categoria" id="categoria" name="id_categoria" aria-hidden="true">
								@foreach ($categorias as $categoria)
									@if($categoria->numero === 6)
									<option value="{{$categoria->id_categoria}}"data-id="{{$categoria->id_categoria}}" selected="selected">{{$categoria->numero." - ".$categoria->nombre}}</option>
									@endif
								@endforeach
							</select>
							@endif
						</div>
					</div>
                    <div class="form-group col-sm-12">
						<label for="ficha_obligatoria" class="control-label col-xs-4">Ficha obligatoria:</label>
						<div class="col-xs-8">
							<select class="form-control" id="ficha_obligatoria" name="ficha_obligatoria">
									<option value="false" data-id="false" title="Ficha Optativa">Ficha Optativa</option>
									<option value="true" data-id="true" title="Ficha Obligatoria">Ficha Obligatoria</option>
							</select>
						</div>
					</div>
                    <div class="form-group col-sm-12">
						<label for="numero" class="control-label col-xs-4">Número:</label>
						<div class="col-xs-8">
							<input type="text" class="form-control" id="numero" name="numero" placeholder="Numero de la pauta" required>
						</div>
					</div>
					<div class="form-group col-sm-12">
						<label for="nombre" class="control-label col-xs-4">Nombre:</label>
						<div class="col-xs-8">
							<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de la pauta">
						</div>
					</div>
                    <div class="form-group col-sm-12">
						<label for="descripcion" class="control-label col-xs-4">Descripción:</label>
						<div class="col-xs-8">
							<textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripción de la pauta" data-autosize-input='{ "space": 40 }'></textarea>
						</div>
					</div>
				</div>

				<div class="box-footer">
					<a class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i>Volver</a>
					<button class="btn btn-success pull-right" id="crear" title="Alta"><i class="fa fa-plus" aria-hidden="true"></i>Alta</button>
				</div>
			</form>
		</div>
	</div> 
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous"></script>
<script type="text/javascript">

	function getSelected() {
		var anios = $('#anio').val();
		var provincia = {{Auth::user()->id_provincia}};
		var categoria = $('#categoria').val();
		var numero = $('#numero').val();

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
			},
			{
				name: 'numero',
				value: numero
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
			"placeholder": "Seleccionar Categoria",
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
		var categorias = {!! $categorias->toJson() !!};

		$('#categoria').change(function() {
			let id = $('#categoria option:selected').data('id');
			let categoria = categorias.find(categoria => categoria.id_categoria === id);
			let pauta = categoria.pautas.sort((a, b) => a.numero - b.numero).pop();

			$('#numero').val( (pauta?.numero?.slice(0, -1) ?? categoria?.numero + '.') + ( (parseInt(pauta?.numero?.slice(-1) ?? 0) + 1).toString() ));
			$('#numero').prop('disabled', true);
		});

		$('#alta #form-alta').validate({
			rules : {
				anio: "required",
				id_categoria: {
					required: true,
					number: true
				},
				ficha_obligatoria: "required",
				nombre : "required",
				numero : "required"
			},
			messages: {
				anio: "Campo obligatorio",
				id_categoria: "Campo obligatorio",
				ficha_obligatoria: "Campo obligatorio",
				nombre : "Campo obligatorio",
				numero : "Campo obligatorio"
			},
			highlight: function(element)
			{
				console.log(element);
				$(element).closest('.form-control').removeClass('success').addClass('error');
			},
			success: function(element)
			{
				$(element).text('').addClass('valid')
				.closest('.control-group').removeClass('error').addClass('success');
			},
			submitHandler : function(form){

				$.ajax({
					method : 'post',
					url : 'pautas',
					data : getForm(),
					success : function(data){
						console.log("Success.");
						alert("Se crea la pauta");
						location.reload();	
					},
					error : function(data){
						console.log("Error.");
						console.log(data);
					}
				});
			}
		});
	});
</script>