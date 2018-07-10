@extends('layouts.adminlte')

@section('content')
<div class="row" style="margin-right: 4px;margin-left: 5px;">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
    <a href="{{url("dashboard/acciones")}}" class="small-box bg-aqua">
     <div class="inner">
      <h3 id="count-acciones"></h3>
      <h4>Acciones</h4>
    </div>
    <div class="icon">
      <i class="fa fa-address-book-o"></i>
    </div>
    <div class="small-box-footer">
      Más información <i class="fa fa-arrow-circle-right"></i>
    </div>
  </a>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
  <a href="{{url("/dashboard/participantes")}}" class="small-box bg-aqua">
   <div class="inner">
    <h3 id="count-participantes"></h3>
    <h4>Participantes</h4>				             
   </div>
   <div class="icon">
    <i class="fa fa-users"></i>
   </div>			
   <div class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></div>			
  </a>
</div>
</div>
<img src="{{asset("/img/proceso.png")}}" style="display: block; margin-left: auto; margin-right: auto;" usemap="#proceso">
<map name="proceso">
  <area shape="rect" coords="525,10,940,250" alt="Sun" href="{{url("/materiales/etapa/1")}}">
  <area shape="rect" coords="980,285,1390,525" alt="Sun" href="{{url("/materiales/etapa/3")}}">
  <area shape="rect" coords="590,345,880,500" alt="Sun" href="{{url("/reportes/1")}}">
  <area shape="rect" coords="805,625,1220,865" alt="Sun" href="{{url("/materiales/etapa/2")}}">
  <area shape="rect" coords="260,620,675,860" alt="Sun" href="{{url("/materiales/etapa/4")}}">
  <area shape="rect" coords="75,285,490,525" alt="Sun" href="{{url("/materiales/etapa/5")}}">
</map>
<!--
<div class="row">
  <div class="col-lg-3 col-xs-12">
    <a href="{{url("/pacs")}}" class="info-box bg-teal" id="progreso-pac" >
      <span class="info-box-icon"><i class="fa fa-sitemap"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Progreso PAC</span>
        <span class="info-box-number">Haga click para cargar</span>
        <div class="progress">
          <div class="progress-bar" style="width: 0%">

          </div>
        </div>
        <span class="progress-description">
          0/0 de acciones planificadas.
        </span>
      </div>
    </a>
    <a href="{{url("/efectores")}}" class="info-box bg-teal" id="efectores-capacitados">
      <span class="info-box-icon"><i class="fa fa-h-square"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Efectores capacitados</span>
        <span class="info-box-number">0</span>
      </div>
    </a>
    <div class="info-box bg-teal" id="talleres-sumarte">
      <span class="info-box-icon"><i class="fa fa-scribd"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Talleres sumarte</span>
        <span class="info-box-number">0</span>
      </div>      
    </div>
    <div class="info-box bg-teal" id="acciones-a-distancia">
      <span class="info-box-icon"><i class="fa fa-laptop"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Acciones a distancia</span>
        <span class="info-box-number">0</span>
      </div>      
    </div>
  </div>
</div>
-->
@endsection

@section("script")
<script type="text/javascript">

 function firstCounts(division, anio) {
  return {
   url: '{{url('dashboard/draw/first')}}',
   data: {
    'division': division,
    'anio': anio
   },
   dataType: 'json',
    success: function (data) {
    $('#count-acciones').html(data.acciones);
    $('#count-participantes').html(data.participantes);
   }
  };
 }

 function progressCounts(division, anio) {
  return {
   url: 'dashboard/draw/progress',
   data: {
    'division': division,
    'anio': anio
   },
   dataType: 'json',
    success: function (data) {
    $("#efectores-capacitados").find(".info-box-number").html(data.capacitados);
    $("#talleres-sumarte").find(".info-box-number").html(data.talleres);
    $("#acciones-a-distancia").find(".info-box-number").html(data.distancia);
   }
  };
 }

 $(document).ajaxStop($.unblockUI);  

 $(document).ready(function(){

    function load(anio) {

      $.ajax(progressCounts('Nación', 'Histórico'))
      .done(function() {
        console.log("success progress counts");
      })
      .fail(function() {
        alert('ajax error progress');
      });

      $.ajax(firstCounts('Nación', 'Histórico'))
      .done(function() {
        console.log("success counts");
      })
      .fail(function() {
        alert('ajax error first draw');
      });

    }

    load(0);
  });

</script>
@endsection
