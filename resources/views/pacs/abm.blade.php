{{csrf_field()}}
<div class="box box-info">
	<div class="box-header">
		<h2 class="box-tittle">PACs
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
					<th>Nombre</th>
					<th>Tipo</th>
					<th>Temática/s</th>
					<th>Ediciones</th>
					<th>Duración</th>
					<th>Informe entregado</th>
					<th>Jurisdicción</th>
					<th>Estado</th>
				</tr>
			</thead>
		</table>
	</div>
	<div class="box-footer">
		<button class="btn btn-success pull-right" id="alta_pac"><i class="fa fa-plus" aria-hidden="true"></i>Alta PAC</button>
	</div>
</div>
