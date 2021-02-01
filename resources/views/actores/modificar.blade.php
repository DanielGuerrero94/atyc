<div class="col-sm-6 col-sm-offset-3">
	<div class="box box-success ">
		<div class="box-header">Nuevo Actor</div>
		<div class="box-body">
			<!-- <form action="{{url('lineasEstrategicas/set')}}" method="post"> -->
			<form id="form-alta"> 
				{{ csrf_field() }}
				<div class="row">
					<div class="form-group col-sm-12">
						<label for="nombre" class="control-label col-xs-4">Nombre:</label>
						<div class="col-xs-8">
							<input type="text" class="form-control" id="nombre" name="nombre" value="{{$actor->nombre}}" required>
						</div>
					</div>
                    <div class="form-group col-sm-12">
						<label for="descripcion" class="control-label col-xs-4">Descripción:</label>
						<div class="col-xs-8">
							<textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripción del actor" data-autosize-input='{ "space": 40 }'>{{$actor->descripcion}}</textarea>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="box-footer">
			<button class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i>Volver</button>
			<button class="btn btn-primary pull-right" id="modificar" title="Modificar" data-id="{{$actor->id_actor}}"><i class="fa fa-plus" aria-hidden="true"></i>Modificar</button>
		</div>
	</div> 
</div>


<script type="text/javascript">

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
    });
</script>