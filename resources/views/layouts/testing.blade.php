@if(env('APP_ENV') == 'qa')
<div class="alert alert-warning alert-dismissible" style="background-image: linear-gradient(to bottom,#ffef94 0,#dfcb63 100%);color: #444 !important;">
    <h4>
        <i class="icon fa fa-warning"></i> 
            Entorno de prueba!  |   Todos los cambios que se realicen no se veran reflejados en el entorno producción.
    </h4>
</div>
@endif
