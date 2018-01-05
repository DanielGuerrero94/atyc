{{ csrf_field() }}	
<div class="box box-info">
	<div class="box-header">
		<h2 class="box-tittle">Pautas
			<div class="btn-group pull-right" role="group" aria-label="...">
				<button type="button" class="btn btn-box-tool btn-info filter" title="Filtro"><i class="fa fa-sliders" aria-hidden="true"></i></button>
			</div>
		</h2>
	</div>
	<div class="box-body">
		<table id="table" class="table table-hover">
			<thead>
				<tr>
					<th>Item</th>
					<th>Nombre</th>
					<th>Descripcion</th>
					<th>Categoria Pauta</th>
					<th>Acciones</th>
				</tr>
			</thead>
		</table>
	</div>
	<div class="box-footer">
		<button class="btn btn-success pull-right" id="alta_pauta"><i class="fa fa-plus" aria-hidden="true"></i>Alta Pauta</button>
	</div>
</div>