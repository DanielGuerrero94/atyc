{{csrf_field()}}
<div class="box box-info">
	<div class="box-header">
		<h2 class="box-tittle">Acciones
			<div class="btn-group pull-right" role="group" aria-label="...">
				<div type="button" class="btn btn-box-tool btn-default excel" title="Excel"><i class="fa fa-file-excel-o text-success" aria-hidden="true"></i></div>
				<div type="button" class="btn btn-box-tool btn-default pdf" title="PDF"><i class="fa fa-file-pdf-o text-danger" aria-hidden="true"></i></div>
				<div type="button" class="btn btn-info filter" title="Filtro"><i class="fa fa-sliders" aria-hidden="true"></i></div>
				<div type="button" class="btn btn-info expand" title="Expandir"><i class="fa fa-expand" aria-hidden="true"></i></div>
				<div type="button" class="btn btn-info compress" title="Comprimir" style="display: none;"><i class="fa fa-compress" aria-hidden="true"></i></div>	
			</div>
		</h2>
	</div>
	<div class="box-body">
		<table id="abm-table" class="table table-hover">
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Fecha</th>
					<th>Edicion</th>
					<th>Duracion</th>
					<th>Area tematica</th>
					<th>Tipologia de accion</th>
					<th>Provincia</th>
					<th></th>
				</tr>
			</thead>
		</table>
	</div>
	<div class="box-footer">
		<button class="btn btn-success pull-right" id="alta_curso"><i class="fa fa-plus" aria-hidden="true"></i>Alta curso</button>
	</div>
</div>
