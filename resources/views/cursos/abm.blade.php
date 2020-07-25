{{csrf_field()}}
<div class="box box-info">
	<div class="box-header">
		<h2 class="box-tittle">Acciones
		@if(isset($prefilters) && in_array(1, $prefilters))
			Planificadas
		@elseif(isset($prefilters) && in_array(4, $prefilters))
			Ejecutadas
		@endif
			<div class="btn-group pull-right" role="group" aria-label="...">
				<a href="#" class="btn btn-square excel" title="Excel"><i class="fa fa-file-excel-o text-success fa-lg"></i></a>
				<a href="#" class="btn btn-square filter" title="Filtro"><i class="fa fa-sliders text-info fa-lg"></i></a>
				<a href="#" class="btn btn-square expand" title="Expandir" style="display: none;"><i class="fa fa-expand text-info fa-lg"></i></a>
				<a href="#" class="btn btn-square compress" title="Comprimir"><i class="fa fa-compress text-info fa-lg"></i></a>
			</div>
		</h2>
	</div>
	<div class="box-body">
		<table id="abm-table" class="table table-hover">
		</table>
	</div>
	<div class="box-footer">
		<button class="btn btn-success pull-right" id="alta_curso"><i class="fa fa-plus" aria-hidden="true"></i>Alta acción</button>
	</div>
</div>
