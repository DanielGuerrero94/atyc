<div class="row">
  <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 text-center">
    <div class="btn-group" role="group" aria-label="...">
      <div class="btn-group" id="dashboard-division">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <b><span id="division">Nación</span></b>
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
          <li><a href="#" data-id="no-id">Nación</a></li>
          <li><a href="#" data-id="{{Auth::user()->provincia->id_provincia}}">{{Auth::user()->provincia->nombre}}</a></li>
          @if (Auth::user()->isUEC())
          <li role="separator" class="divider"></li>
          @foreach(App\Provincia::where('id_provincia', '!=', 25)->get() as $provincia)
          <li><a href="#" data-id="{{$provincia->id_provincia}}">{{$provincia->nombre}}</a></li>
          @endforeach
          @endif
        </ul>
      </div>
      <div class="btn-group" id="dashboard-anio">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <b><span id="anio">Histórico</span></b>
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
          <li><a href="#">Histórico</a></li>
          <li><a href="#">{{date('Y')}}</a></li>
          <li role="separator" class="divider"></li>
          @for($i = intval(date('Y')) - 1; $i > 2012 ; $i--)
          <li><a href="#">{{$i}}</a></li>
          @endfor
        </ul>
      </div>
      <button type="button" class="btn btn-default" id="dashboard-refresh">
        <i class="fa fa-refresh"></i>
      </button>
    </div>
  </div>
</div>
<br>
