<div class="box box-success">
	<div class="box-header with-border">Alta de pauta</div>
	<div class="box-body">
		<form id="form-alta">
			{{ csrf_field() }}
			<div class="row">
				<div class="form-group col-sm-6">
					<label for="item" class="control-label col-xs-4">Item:</label>
					<div class="col-xs-8">
						<input name="item" type="number" class="form-control" id="item">
					</div>
				</div>
				<div class="form-group col-sm-6">
					<label for="descripcion" class="control-label col-xs-4">Descripcion:</label>
					<div class="col-xs-8">
						<input name="descripcion" type="text" class="form-control" id="descripcion">
					</div>
				</div>
				<div class="form-group col-sm-6">
					<label class="control-label col-xs-4" for="id_categoria_pauta">Categoria Pauta:</label>
					<div class="col-xs-8">
						@if(Auth::user()->id_provincia == 25)
							<select class="form-control" id="id_categoria_pauta" title="Categoria Pauta" name="id_categoria_pauta">
								@foreach ($categoriaPauta as $categoria)
								
								<option data-id="{{$categoria->id_categoria_pauta}}" title="{{$categoria->item}}" value="{{$categoria->id_categoria_pauta}}">{{$categoria->nombre}}</option>					
								@endforeach
							</select>
						@else

							<select class="form-control" id="id_categoria_pauta" name="id_categoria_pauta" >
								@foreach ($categoriaPauta as $categoria)
									@if($categoria->item == '10')
							    		<option data-id="{{ $categoria->id_categoria_pauta }}" title="{{ $categoria->nombre }}" value="{{ $categoria->id_categoria_pauta }}">{{ $categoria->nombre }}</option> 
							    		@break
							  		@endif
								@endforeach
							</select>
						@endif
					</div>
				</div>
	            <div class="form-group col-sm-6">          
		            <label for="provincia" class="control-label col-xs-4">Provincia:</label>
		            <div class="col-xs-8">
		                @if(Auth::user()->id_provincia == 25)
			                <select class="form-control" id="id_provincia" name="id_provincia">
			                    @foreach ($provincias as $provincia)                
			                       <option data-id="{{$provincia->id_provincia}}" title="{{$provincia->nombre}}" value="{{$provincia->id_provincia}}">{{$provincia->nombre}}</option>           
			                    @endforeach
			                </select>
		                @else
			                <select class="form-control" id="id_provincia" name="id_provincia" name="id_provincia" disabled>
			                    <option data-id="{{Auth::user()->id_provincia}}" value="{{Auth::user()->id_provincia}}">{{Auth::user()->name}}</option>  
			                </select>
		                @endif
		            </div>        
	            </div>            				
			</div>	
			<hr>

		</form>
	</div>
	<div class="box-footer">
		<div class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo"></i> Volver</div>
		<button type="submit" class="btn btn-success pull-right" id="crear" title="Alta"><i class="fa fa-plus"></i> Alta</button>
	</div>
</div> 

<script type="text/javascript">
	$(document).ready(function () {


		//Pregunta si el alta se esta dando desde el abm de participantes o desde el de acciones
		if ($('.container-fluid #creando-pauta').length) {

			function backToCreate () {
				$('.container-fluid #creando-pauta').remove();
				$('.container-fluid #alta-accion').closest('.row').show();
				$('.container-fluid #alta').remove();
			}
			
			function transitionAfterSubmit(data) {
				$('.container-fluid #creando-pauta').remove();
				$('.container-fluid #alta-accion').closest('.row').show();
				$('.container-fluid #alta').remove();
				console.log("Se intenta agregar al pauta a la accion.");
				agregarPauta(data.item, data.nombre, data.descripcion, data.id_pauta);
			}

		} else {

			function backToCreate () {
				console.log("Vuelve sin crear la pauta");
				$("#alta").hide();
				$("#filtros").show();
				$("#abm").show();
			}
			
			function transitionAfterSubmit(data) {
				location.reload();
			}
			
		}


		jQuery.validator.addMethod("requerido", function(value, element) {
			return value != "";
		}, "Campo obligatorio");	

		$('#alta').on("click","#volver",backToCreate);

		function agregarPauta(item, nombre, descripcion, id) {
			pauta = '<tr>'+
			'<td>'+item+'</td>'+
			'<td>'+nombre+'</td>'+
			'<td>'+descripcion+'</td>'+
			'<td>'+
			'<div class="btn btn-xs btn-info "><a href="{{url('/pautas')}}/'+id+'"><i class="fa fa-search" data-id="'+id+'"></i></a></div>'+
			'<div class="btn btn-xs btn-danger quitar"><i class="fa fa-minus"></i></div>'+
			'</td>'+
			'</tr>';
			existe = false;

			$.each($('#pautas-del-curso tbody tr .fa-search'),function(k,v){
				if($(v).data('id') == id){
					existe = true;
				}
			});

			if(!existe){
				console.log("No esta en la tabla entonces se agrega.");
				$('#pautas-del-curso tbody').append(pauta);     
				$('#pautas-del-curso').closest('div').show();
				refreshCounter();
			}
		}

		function refreshCounter() {
			let count = $('#pautas-del-curso tbody').children().length;
			$('#contador-pautas').html(count);
		}

		function getInput() {					
			return $('#alta #form-alta').serializeArray().filter(function(v){return v.value != ""});
		}

		var validator = $('#alta #form-alta').validate({
			debug: true,				
			rules : {
				item 		: {required: true, number: true },
				descripcion : {required: true}
			},
			messages:{
				descripcion : "Campo obligatorio",
				item : "Campo obligatorio o Tiene que ser un numero"
			},
			highlight: function(element)
			{
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			},				
			success: function(element)
			{
				$(element).text('').addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success');
			},
			submitHandler : function(form){
				console.log($('form').serialize());
				$.ajax({
					url: 'pautas',
					method : 'post',						
					data : $('form').serialize(),
					success: function(data, textStatus, xhr) {
						console.log("Se creo la pauta y devolvio: " + data);
						transitionAfterSubmit(data);
					},
					error: function(xhr, textStatus, errorThrown) {
						alert('No se pudo dar de alta la pauta.');
					}
				});
			}	
		});

		$('#alta').on('click','#crear',function(e) {
			e.preventDefault();		
			if(validator.valid()){

				$('#vigencia').prop('disabled', false);
				$('#id_provincia').prop('disabled', false);
				$('#alta #form-alta').submit();

			}
		});

	});
</script>
