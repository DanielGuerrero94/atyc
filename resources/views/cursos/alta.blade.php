<form id="form-alta">
  <div class="box">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#inicial" data-toggle="tab">Inicial</a></li>
        <li><a href="#alumnos" data-toggle="tab">Alumnos</a></li>
        <li><a href="#profesores" data-toggle="tab">Profesores</a></li>
      </ul>
      <div class="tab-content">
        <div class="active tab-pane" id="inicial">
          <form class="form-alta">
            {{ csrf_field() }}
            <div class="form-group">       
              <label class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Nombre:</label>
              <div class="typeahead__container col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <div class="typeahead__field ">             
                  <span class="typeahead__query ">
                    <input class="nombre_typeahead " name="nombre" type="search" placeholder="Buscar o agregar uno nuevo" autocomplete="off">
                  </span>
                </div>
              </div>
            </div>
            <br>
            <br> 
            <br>
            <div class="row">
            <div class="form-group">          
              <label for="horas" class="control-label col-xs-2">Duración:</label>
              <div class="col-xs-6">
              <input type="text" name="duracion" id="horas" placeholder="Duración en horas"> 
              </div>
            </div>
            </div>
            <br>
            <div class="row">
            <div class="form-group">            
              <label for="fecha" class="control-label col-xs-2">Fecha:</label>
              <div class="input-group date col-xs-8">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" name="fecha" id="fecha" class="form-control pull-right datepicker">
              </div>
            </div>
            </div>
            <div class="row">
              <div class="form-group">          
              <label for="area_tematica" class="control-label col-xs-2">Areas Tematicas:</label>
              <div class="col-xs-6">
              <select class="form-control" id="area_tematica" name="area_tematica">
                <option>Seleccionar</option>
                @foreach ($areas_tematicas as $area)
                <option data-id="{{$area->id_area_tematica}}">{{$area->nombre}}</option>
                @endforeach
              </select>          
              </div>
            </div>
            </div>
            <br>
            <div class="row">
            <div class="form-group">          
              <label for="linea_estrategica" class="control-label col-xs-2">Lineas estrategicas:</label>
              <div class="col-xs-6">
              <select class="form-control" id="linea_estrategica" name="linea_estrategica">
                <option>Seleccionar</option>
                @foreach ($lineas_estrategicas as $linea)
                <option data-id="{{$linea->id_linea_estrategica}}">Línea {{$linea->numero}}-{{$linea->nombre}}</option>
                @endforeach
              </select>
              </div>          
            </div>
            </div>
            <br>
            <div class="row">
            <div class="form-group">          
              <label for="provincia" class="control-label col-xs-2">Provincia:</label>
              <div class="col-xs-6">
              <select class="form-control" id="provincia" name="provincia">
                <option>Seleccionar</option>
                @foreach ($provincias as $provincia)
                <option data-id="{{$provincia->id_provincia}}">{{$provincia->nombre}}</option>
                @endforeach
              </select>  
              </div>        
            </div>
            </div>          
        </div>
        <div class="tab-pane" id="alumnos">   
        @include('alumnos.asignacionAlternativa')            
        </div>
        <div class="tab-pane" id="profesores">
        @include('profesores.asignacion')         
        </div>  
        </form>  
      </div>
    </div>
    <div class="box-body">
      <div class="btn btn-success pull-right store">Guardar</div>
    </div>
  </div>
</form>

<script type="text/javascript">

  $(document).ready(function() {

    //No se porque estoy teniendo que inicializarlo aca si ya se deberia haber inicializado en el layout de adminlte
    $('.datepicker').datepicker({
      format: 'dd/mm/yyyy',
      language: 'es',
      autoclose: true,
    });

    $(".js-example-basic-single").select2();    

    $('#tabla-alumnos').DataTable({
      scrollY:"200px",
      scrollCollapse: true,
      serverSide: false,
      ajax : {
        "url": 'alumnos/tabla',
        "data": {
          "botones" : 'agregar'
        }
      },
      columns: [
      { data: 'nombres'},
      { data: 'apellidos'},
      { data: 'tipo_documento.nombre'},
      { data: 'nro_doc'},
      { data: 'provincia.nombre'},
      { data: 'acciones'}
      ]
    });  

    $('#tabla-alumnos-curso').DataTable({
      destroy: true,
      scrollY:"200px",
      scrollCollapse: true,
      filter: false,
      paging: false,
      serverSide: false,
      columns: [
      { data: 'nombres'},
      { data: 'apellidos'},
      { data: 'tipo_documento.nombre'},
      { data: 'nro_doc'},
      { data: 'provincia.nombre'},
      { data: 'acciones'}
      ]
    });

    $('#tabla-profesores').DataTable({
      scrollY:"200px",
      scrollCollapse: true,
      serverSide: false,
      ajax : {
        "url": 'profesores/tabla',
        "data": {
          "botones" : 'agregar'
        }
      },
      columns: [
      { data: 'nombres'},
      { data: 'apellidos'},
      { data: 'tipo_documento.nombre'},
      { data: 'nro_doc'},
      { data: 'acciones'}
      ]
    });

    $('#tabla-profesores-curso').DataTable({
      scrollY:"200px",
      scrollCollapse: true,
      filter: false,
      paging: false,
      serverSide: false,
      columns: [
      { data: 'nombres'},
      { data: 'apellidos'},
      { data: 'tipo_documento.nombre'},
      { data: 'nro_doc'},
      { data: 'acciones'}
      ]
    });

    var botonQuitar = '<td><button class="btn btn-danger btn-xs quitar" title="Quitar"><i class="fa fa-minus-circle" aria-hidden="true"></i></button></td>';

    /*$('#alta #tabla-alumnos').on('click','.agregar',function () {
      console.log("Se agrea al curso el alumno con id:");
      var fila = $(this).parent().parent();
      var id = $(this).data('id');

      //fila.hide();      
      fila.find('td:last').remove();
      console.log(id);
      fila.append(botonQuitar);
      console.log(fila);

      var data = $('#tabla-alumnos').DataTable().row(fila).data();      

      console.log(data);   
      $('#tabla-alumnos').DataTable().row(fila).remove().draw(false);
      var nueva_fila = $('#tabla-alumnos-curso').DataTable().row.add(data).draw(false).row().node();
      console.log(nueva_fila);
      $(nueva_fila).find('td:last').remove();
      $(nueva_fila).append(botonQuitar); 
      $(nueva_fila).find('td:last button').attr('data-id',id);
    });*/

    $('#alta #tabla-profesores').on('click','.agregar',function () {
      console.log("Se agrea al curso el alumno con id:");
      var fila = $(this).parent().parent();
      var id = $(this).data('id');

      //fila.hide();      
      fila.find('td:last').remove();
      console.log(id);
      fila.append(botonQuitar);
      console.log(fila);

      var data = $('#tabla-profesores').DataTable().row(fila).data();      

      console.log(data);   
      $('#tabla-profesores').DataTable().row(fila).remove().draw(false);
      var nueva_fila = $('#tabla-profesores-curso').DataTable().row.add(data).draw(false).row().node();
      console.log(nueva_fila);
      $(nueva_fila).find('td:last').remove();
      $(nueva_fila).append(botonQuitar); 
      $(nueva_fila).find('td:last button').attr('data-id',id);
    });

    $.typeahead({
      input: '.nombre_typeahead',
      order: "desc",
      source: {
        info: {
          ajax: {
            type: "get",
            url: "cursos/nombres",
            path: "data.info"
          }
        }
      },
      callback: {
        onInit: function (node) {
          console.log('Typeahead Initiated on ' + node.selector);
        }
      }
    });

    /*function getAlumnosSelected() {
      $('#tabla-alumnos-curso .quitar').map(function(index, val) {
        return $(val).data('id');
      });
    }*/

    function getAlumnosSelected() {
      return $('#form-alta #alumnos-del-curso .fa-search').map(function(index, val) {
        return $(val).data('id');
      });
    }

    /*function getProfesoresSelected() {
      $('#tabla-profesores-curso .quitar').map(function(index, val) {
        return $(val).data('id');
      });
    }*/

    function getProfesoresSelected() {
      return $('#profesores-del-curso .fa-search').map(function(index, val) {
        return $(val).data('id');
      });
    }

    function getSelected() {
      var id_linea_estrategica = $('#form-alta #linea_estrategica option:selected').data('id');
      var id_area_tematica = $('#form-alta #area_tematica option:selected').data('id');
      var id_provincia = $('#form-alta #provincia option:selected').data('id');

      var alumnos = getAlumnosSelected();
      console.log(alumnos);
      //var alumnos = [49641,4119,33030,3831];
      var profesores = getProfesoresSelected();
      //var profesores = [207,396,397,399];
      return [
      { 
        name: 'id_linea_estrategica',
        value: id_linea_estrategica
      },
      { 
        name: 'id_area_tematica',
        value: id_area_tematica
      },
      { 
        name: 'id_provincia',
        value: id_provincia
      },
      { 
        name: 'alumnos',
        value: alumnos.toArray()
      },
      { 
        name: 'profesores',
        value: profesores.toArray()
      }];
    }

    function getInput() {         
      return $.merge($('#form-alta').serializeArray(),getSelected());
    }

    jQuery.validator.addMethod("selecciono", function(value, element) {
      return $(element).find(':selected').val() !== "Seleccionar";
    }, "Debe seleccionar alguna opcion");    

    var validator = $('#form-alta').validate({
      ignore: [],
      rules : {
        nombre : "required",
        duracion : {
          required: true,
          number: true
        },
        fecha : {
          required: true
        },
        area_tematica: { selecciono : true},
        linea_estrategica: { selecciono : true},
        provincia: { selecciono : true},
      },
      messages:{
        nombre : "Campo obligatorio",
        duracion : "Campo obligatorio",
        fecha : "Campo obligatorio",
      },
      highlight: function(element)
      {
        $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
      },
      success: function(element)
      {
        $(element).text('').addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success');
      },
      submitHandler : function(form){
        console.log('Alta del form validado');
        console.log(getInput());
        $.ajax({
          method : 'post',
          url : 'cursos',
          data : getInput(),
          success : function(data){
            console.log("Success.");
            alert("Se crea el curso.");
          },
          error : function(data){
            console.log("Error.");
            alert("No se pudo crear el curso.");
          }
        });
      }
    });

    $('#alta').on('click','.store',function() {     
      if(validator.valid()){
        $('#alta #form-alta').submit(); 
      }else{
        alert('Hay campos que no cumplen con la validacion.');
      }
    });
  });
</script>





