@foreach ($materiales as $material)
<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 material">
	<div class="box box-primary">
		<div class="box-body">
			<p>
				<i class="fa {{$material->icon}}"></i>
				<span class="filename">{{$material->original}}</span>
			</p>
			<blockquote style="padding-left: 10px;margin-bottom: 5px;" class="description">
				<p>
					@if(isset($material->descripcion))
					<span>{{$material->descripcion}}</span>
					@else
					<span class="more" data-toggle=true>Sin descripción.</span>
					@endif
				</p>
			</blockquote>
		</div>			
		<div class="box-footer" data-id="{{$material->id_material}}">
			<span class="buttons"></span>
			<span class="pull-right" style="padding-top: 10px;"><b>Actualizado:</b> {{$material->updated_at->format('d/m/Y')}}</span>			
		</div>
	</div>	
</div>	
@endforeach