{{ csrf_field() }}	
<div class="box box-info">
	<div class="box-header">
		<h2 class="box-tittle">Docentes
			<div class="btn-group pull-right" role="group" aria-label="...">
				<button type="button" class="btn btn-box-tool btn-default excel" title="Excel"><i class="fa fa-file-excel-o text-success" aria-hidden="true"></i></button>
				<button type="button" class="btn btn-box-tool btn-default pdf" title="PDF"><i class="fa fa-file-pdf-o text-danger" aria-hidden="true"></i></button>
				<button type="button" class="btn btn-box-tool btn-info filter" title="Filtro"><i class="fa fa-sliders" aria-hidden="true"></i></button>
				<button type="button" class="btn btn-box-tool btn-info compress" title="Comprimir" style="display: none;"><i class="fa fa-compress" aria-hidden="true"></i></button>
				<button type="button" class="btn btn-box-tool btn-info expand" title="Expandir"><i class="fa fa-expand" aria-hidden="true"></i></button>					
			</div>
		</h2>
	</div>
	<div class="box-body">
		<table id="table" class="table table-hover">
			<thead>
				<tr>
					<th>Nombres</th>
					<th>Apellidos</th>
					<th>Nro Doc</th>
					<th>Tipo Doc</th>
					<th>Acciones</th>
				</tr>
			</thead>
		</table>
	</div>
	<div class="box-footer">
		<button class="btn btn-success pull-right" id="alta_profesor"><i class="fa fa-plus" aria-hidden="true"></i>Alta Docente</button>
	</div>
</div>