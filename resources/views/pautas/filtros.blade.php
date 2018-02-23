<div class="box box-info" style="display: none;">
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
			<div class="row">
				<div class="form-group col-sm-4">  		  		
					<label for="Item" class="control-label col-xs-5">Item</label>
					<div class="col-xs-7">
						<input class="form-control" id="item" name="item" type="number">
					</div>
				</div>				
				<div class="form-group col-sm-4">  		  		
					<label for="Nombre" class="control-label col-xs-5">Nombre</label>
					<div class="col-xs-7">
						<input class="form-control" id="nombre" name="nombre">
					</div>
				</div>						

				<div class="form-group col-sm-4">  		  		
					<label for="Descripcion" class="control-label col-xs-5">Descripcion</label>
					<div class="col-xs-7">
						<input class="form-control" id="descripcion" name="descripcion">
					</div>
				</div>							
			</div>
			<div class="row">
				<div class="form-group col-sm-4">
					<label class="control-label col-xs-5" for="id_categoria_pauta">Categoriaid_categoria_pauta de la Pauta:</label>
					<div class="col-xs-7">
						<select class="form-control" id="id_categoria_pauta" title="Categoriaid_categoria_pauta de la Pauta" name="id_categoria_pauta">
							@foreach ($categoriaPauta as $categoria)

							<option value="{{$categoria->id_categoria_pauta}}" title="{{$categoria->item}}">{{$categoria->nombre}}</option>										
							@endforeach
						</select>
					</div>
				</div>						
			</div>
			<hr>
			<div class="box-footer">		
				<div class="btn btn-info pull-right" id="filtrar"><i class="fa fa-filter"></i>Filtrar</div>	
			</div>
		</form>
	</div>
</div>