@if (!Auth::guest()) 
<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" onclick="fixsidebar()">
  <span class="sr-only">Toggle navigation</span>
</a> 
<div class="navbar-custom-menu">
  <ul class="nav navbar-nav">    
    <li>
      <a href="{{ url('/logout') }}" onclick="event.preventDefault();
      document.getElementById('logout-form').submit();" id="logout">
      Salir
    </a>
    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
      {{ csrf_field() }}
    </form>
  </li>
  @else

  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <li>
        <a href="{{url("/entrar")}}">Entrar</a>
      </li>
      @endif
    </ul>
  </div>
  <script type="text/javascript">
   function fixsidebar() { 
    body = $("body");
    if ($(window).width() > 767) {
     if (body.hasClass('sidebar-collapse')) {
       body.removeClass('sidebar-collapse').trigger('expanded.pushMenu');
     } else {
       body.addClass('sidebar-collapse').trigger('collapsed.pushMenu');
     }
   }
   else {
     if (body.hasClass('sidebar-open')) {
       body.removeClass('sidebar-open').removeClass('sidebar-collapse').trigger('collapsed.pushMenu');
     } else {
       body.addClass('sidebar-open').trigger('expanded.pushMenu');
     }
   }
   //Redibuja las tablas despues de medio segundo
   setTimeout(function() {
     $("body").find(".table").DataTable().draw();
   }, 500);
   $(window).resize();
 };
</script>