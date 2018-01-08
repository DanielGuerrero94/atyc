@foreach ($materiales as $material)
<div class="col-xs-12 col-sm-4 col-md-4 col-lg-2">
	<div class="box box-primary">
		<div class="box-body">
			<p><i class="fa {{$material->icon}}"></i>
				{{$material->original}}
			</p>
		</div>			
		<div class="box-footer" data-id="{{$material->id_material}}">
			<a href="{{'materiales/'}}{{$material->id_material}}/download" 
				style="text-decoration: none;color: #2F2D2D;">
				<i class="fa fa-download"></i> Descargar
			</a>
		</div>
	</div>	
</div>	
@endforeach
