<div id="filtros" class="col-xs-12">
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
				@foreach ($columnas as $columna)
				@foreach ($columna as $key => $value)
				@if ($loop->parent->iteration % 3 == 1)
					<div class="row">
				@endif
				
						<div class="form-group col-sm-4">  		  		
							<label for={{$value}} class="control-label col-xs-5">{{$value}}</label>
							<div class="col-xs-7">
								<input class="form-control" id={{$value}} name={{$value}}>
							</div>
						</div>						

				@if ($loop->parent->iteration % 3 == 0)
				</div>
				@endif				
				@endforeach 
				@endforeach	
			</div>
			<div class="box-footer">	
				<div class="btn btn-danger pull-right" id="limpiar" style="display: none"><i class="fa fa-eraser"></i>Limpiar</div>		
				<div class="btn btn-info pull-right" id="filtrar"><i class="fa fa-filter"></i>Filtrar</div>				
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {

		$('#filtros').on('click','#limpiar',function () {
			$('#filtros').find('.form-control').val("");
			$(this).hide();
		});		
	});
</script>
