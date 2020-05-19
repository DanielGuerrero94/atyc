<div class="box box-info">
        <div class="box-header with-border">
	</div>
    <div class="box-body">
		<form id="form-prefilter">
            <div class="row">
                @if(Auth::user()->id_provincia == 25)
                <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                        <label for="provincia" class="control-label col-xs-4 col-sm-2">Provincia:</label>
                        <div class="col-xs-8 col-sm-6">
                            <select class="select-2 form-control provincias" id="provincias" name="id_provincia" aria-hidden="true" multiple>
                                @foreach ($provinciasEdit as $provincia)
                                <option data-id="{{$provincia->id_provincia}}" value="{{$provincia->id_provincia}}">{{$provincia->nombre}}</option>									
                                @endforeach
                            </select>
                        </div>
                    </div>	
                </div>
                @endif

                <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                        <label for="anio" class="control-label col-xs-4 col-sm-2">Año:</label>
                        <div class="col-xs-8 col-sm-6">
                            <select class="select-2 form-control anios" id="anios" name="id_anio" aria-hidden="true" multiple>
                                @for($i = intval(date('Y')); $i > 2015 ; $i--)
                                <option data-id="{{$i}}" value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>						
                </div>
                <div class="row" style="padding-left:2em;">
				<a href="#abm" class="btn btn-square filtro" id="pac-refresh">
					<i class="fa fa-refresh text-info fa-lg"></i>
				</a>
                </div>
            </div>
        </form>
    </div>
</div>