<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
  <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 text-center">
<button type="button" class="btn btn-primary">
          <b><span>Acciones</span></b>
        </button>
        <button type="button" class="btn btn-primary" disabled>
          <b><span>Participantes</span></b>
        </button>
        <button type="button" class="btn btn-primary" disabled>
          <b><span>Docentes</span></b>
        </button>
</div>
</div>
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
  <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 text-center">
            <div class="btn-group" role="group" aria-label="...">
      <div class="btn-group" id="historial-division">
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
      <div class="btn-group" id="historial-antiguedad">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <b><span id="antiguedad">Ultima semana</span></b>
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
          <li><a href="#" data-dias="1">Hoy</a></li>
          <li role="separator" class="divider"></li>
          <li><a href="#" data-dias="7">Ultima semana</a></li>
          <li><a href="#" data-dias="14">Ultimas dos semanas</a></li>
          <li><a href="#" data-dias="21">Ultimas tres semanas</a></li>
          <li><a href="#" data-dias="30">Este mes</a></li>
        </ul>
      </div>
      <button type="button" class="btn btn-default" id="historial-refresh">
        <i class="fa fa-refresh"></i>
      </button>
    </div>
  </div>
  </div>
</div>
<br>
