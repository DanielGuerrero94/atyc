{{csrf_field()}}
<div class="box box-info" style="display: none;">
	<div class="box-header">
		<div class="btn-group pull-right" role="group" aria-label="...">
			<a href="#abm" class="btn btn-square excel" title="Excel"><i class="fa fa-file-excel-o text-success fa-lg"></i></a>
			<a href="#filtros" class="btn btn-square filter" title="Filtro"><i class="fa fa-sliders text-info fa-lg"></i></a>
			<a href="#" class="btn btn-square expand" title="Expandir" style="display: none;"><i class="fa fa-expand text-info fa-lg"></i></a>
			<a href="#" class="btn btn-square compress" title="Comprimir"><i class="fa fa-compress text-info fa-lg"></i></a>	
		</div>
	</div>
	<div class="box-body">
		<table id="abm-table" class="table table-hover">
		</table>
	</div>
	<div class="box-footer">
		<button class="btn btn-success pull-right" id="altas_pac"><i class="fa fa-plus" aria-hidden="true"></i> Crear Planificación</button>
	</div>
</div>
