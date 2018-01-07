{{csrf_field()}}
<div class="box box-info">
	<div class="box-header">
		<h2 class="box-tittle">Pacs
			<div class="btn-group pull-right" role="group" aria-label="...">
				<div type="button" class="btn btn-info expand" title="Expandir"><i class="fa fa-expand" aria-hidden="true"></i></div>
				<div type="button" class="btn btn-info compress" title="Comprimir" style="display: none;"><i class="fa fa-compress" aria-hidden="true"></i></div>	
			</div>
		</h2>
	</div>
	<div class="box-body">
		<table id="abm-table" class="table table-hover">
			<thead>
				<tr>
					<th>Nombre de la accion</th>
					<th>Trimestre a planificar</th>
					<th>1er. Trimestre</th>
					<th>2do. Trimestre</th>
					<th>3er. Trimestre</th>
					<th>4to. Trimestre</th>
					<th>Consultor PeAtyc</th>
					<th>Observado</th>
					<th>Tipología de acción</th>
					<th>Jurisdicción</th>
					<th>Acciones</th>
				</tr>
			</thead>
		</table>
	</div>
	<div class="box-footer">
		<button class="btn btn-success pull-right" id="alta_curso"><i class="fa fa-plus" aria-hidden="true"></i>Alta acción</button>
	</div>
</div>
