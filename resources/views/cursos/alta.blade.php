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
              <label class="col-xs-2">Nombre:</label>
              <div class="typeahead__container col-xs-4">
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
            <div class="form-group">          
              <label class="col-xs-2">Duración:</label>
              <input type="text" name="duracion" id="horas" class="col-xs-8" style="width: 400px" placeholder="Duración en horas">          
            </div>
            <br>
            <div class="form-group">            
              <label class="col-xs-2">Fecha:</label>
              <div class="input-group date col-xs-8" style="width: 400px">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" name="fecha" class="form-control pull-right datepicker">
              </div>
            </div>
            <div class="form-group">          
              <label class="col-xs-2">Areas Tematicas:</label>
              <select class="form-control" style="width: 400px" id="area_tematica" name="area_tematica">
                <option>Seleccionar</option>
                @foreach ($areas_tematicas as $area)
                <option data-id="{{$area->id_area_tematica}}">{{$area->nombre}}</option>
                @endforeach
              </select>          
            </div>
            <div class="form-group">          
              <label class="col-xs-2">Lineas estrategicas:</label>
              <select class="form-control" style="width: 400px" id="linea_estrategica" name="linea_estrategica">
                <option>Seleccionar</option>
                @foreach ($lineas_estrategicas as $linea)
                <option data-id="{{$linea->id_linea_estrategica}}">Línea {{$linea->numero}}-{{$linea->nombre}}</option>
                @endforeach
              </select>          
            </div>
            <div class="form-group">          
              <label for="provincia" class="control-label col-xs-2">Provincia:</label>
              <select class="form-control" style="width: 400px" id="provincia" name="provincia">
                <option>Seleccionar</option>
                @foreach ($provincias as $provincia)
                <option data-id="{{$provincia->id_provincia}}">{{$provincia->nombre}}</option>
                @endforeach
              </select>          
            </div>
          </form>
        </div>
        <div class="tab-pane" id="alumnos">
          <div id="alumnos-curso">
            <div class="box box-info collapsed-box">
              <div class="box-header with-border">
                <h2 class="box-title">Alumnos en el curso</h2>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-plus"></i>
                  </button>
                </div>
              </div>
              <div class="box-body"">
                <table id="tabla-alumnos-curso" class="table table-hover">
                  <thead>
                    <tr>
                      <th>Nombres</th>
                      <th>Apellidos</th>
                      <th>Tipo Doc</th>
                      <th>Nro Doc</th>
                      <th>Provincia</th>
                      <th>Acciones</th>   
                    </tr>
                  </thead>
                </table>    
              </div>
            </div>
          </div>          
          <div id="alumnos">
            <div class="box box-info">
              <div class="box-header with-border">
                <h2 class="box-title">Alumnos</h2>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="box-body">
                <table id="tabla-alumnos" class="table table-hover">
                  <thead>
                    <tr>
                      <th>Nombres</th>
                      <th>Apellidos</th>
                      <th>Tipo Doc</th>
                      <th>Nro Doc</th>
                      <th>Provincia</th>
                      <th>Acciones</th>               
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="profesores">
          <div id="profesores-curso">
            <div class="box box-info collapsed-box">
              <div class="box-header with-border">
                <h2 class="box-title">Profesor/es del curso</h2>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-plus"></i>
                  </button>
                </div>
              </div>
              <div class="box-body" style="display: none;">
                <table id="tabla-profesores-curso" class="table table-hover">
                  <thead>
                    <tr>
                      <th>Nombres</th>
                      <th>Apellidos</th>
                      <th>Tipo Doc</th>
                      <th>Nro Doc</th>
                      <th>Acciones</th>               
                    </tr>
                  </thead>
                </table>    
              </div>
            </div>
          </div>          
          <div id="profesores">
            <div class="box box-info">
              <div class="box-header with-border">
                <h2 class="box-title">Profesores</h2>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="box-body">
                <table id="tabla-profesores" class="table table-hover">
                  <thead>
                    <tr>
                      <th>Nombres</th>
                      <th>Apellidos</th>
                      <th>Tipo Doc</th>
                      <th>Nro Doc</th>
                      <th>Acciones</th>               
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>    
      </div>
    </div>
    <div class="box-body">
      <button class="btn btn-success pull-right guardar" type="submit">Guardar</button>
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

    $('#tabla-alumnos-cursos').DataTable({
      destroy: true,
      scrollY:"200px",
      scrollCollapse: true,
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

    $('#tabla-profesores-cursos').DataTable({
      destroy: true,
      scrollY:"200px",
      scrollCollapse: true,
      columns: [
      { data: 'nombres'},
      { data: 'apellidos'},
      { data: 'tipo_documento.nombre'},
      { data: 'nro_doc'},
      { data: 'acciones'}
      ]
    });

    var botonQuitar = '<td><button class="btn btn-danger btn-xs quitar" title="Quitar"><i class="fa fa-minus-circle" aria-hidden="true"></i></button></td>';

    $('#alta #tabla-alumnos').on('click','.agregar',function () {
      console.log("Se agrea al curso el alumno con id:");
      var fila = $(this).parent().parent();
      var id = $(this).data('id');

      //fila.hide();      
      fila.find('td:last').remove();
      console.log(id);
      fila.append(botonQuitar).attr('data-id',id);

      var nodo = $('#tabla-alumnos').DataTable().row(fila).node();

      console.log(nodo);

      

      $('#tabla-alumnos-curso').DataTable().row.add(nodo).draw();

      /*$('#tabla-alumnos-curso tbody tr').each(function () {
        if(id == $('#tabla-alumnos-curso tbody tr').data('id') ){
          console.log('Ya existe.');
        }
      });*/
      //$('#tabla-alumnos-curso tbody tr').show(); 
    });

    /*$('#alta #tabla-alumnos-curso').on('click','.agregar',function () {
      console.log("Se agrea al curso el alumno con id:");
      var fila = $(this).parent().parent();
      console.log(fila);
      
      var aBuscar = '#tabla-profesores-curso tbody tr #profesor_id';

      console.log(aBuscar);

      fila.hide();      
      fila.find('td:last').remove();
      fila.append(botonQuitar);
      fila.data('id',$(this).data('id'));

      var nodo = $('#tabla-profesores').DataTable().row(fila).node();

      console.log(nodo);

      $('#tabla-profesores-curso tbody tr').each(function () {
        if($(this).attr('data-id-profesor') == $('#tabla-profesores-curso tbody tr').data('id') ){
          console.log('Ya existe.');
        }
      });

      $('#tabla-profesores-curso').DataTable().row.add(nodo).draw();
      $('#tabla-profesores-curso tbody tr').show(); 
    });*/

    $('#alta').on('click','.quitar',function () {
      $(this).parent().parent().remove();
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

    function getAlumnosSelected() {
      $('#tabla-alumnos-curso .agregar').map(function(index, val) {
        return $(val).data('id');
      });
    }

    function getProfesoresSelected() {
      $('#tabla-profesores-curso .agregar').map(function(index, val) {
        return $(val).data('id');
      });
    }

    function getSelected() {
      var id_linea_estrategica = $('#form-alta #linea_estrategica option:selected').data('id');
      var id_area_tematica = $('#form-alta #area_tematica option:selected').data('id');
      var id_provincia = $('#form-alta #provincia option:selected').data('id');

      var alumnos = getAlumnosSelected();
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
        value: alumnos
      },
      { 
        name: 'profesores',
        value: profesores
      }];
    }

    function getInput() {         
      return $.merge($('#form-alta').serializeArray(),getSelected());
    }

    jQuery.validator.addMethod("selecciono", function(value, element) {
      return $(element).find(':selected').val() !== "Seleccionar";
    }, "Debe seleccionar alguna opcion");

    var validator = $('#form-alta').validate({
      rules : {
        nombre : "required",
        duracion : {
          required: true,
          number: true
        },
        fecha : {
          required: true,
          date: true
        },
        /*funcion: {
          depends: function (element) {
            return $('#alta form #funcion :selected').val() !== "Seleccionar";
          }
        }*/ 
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
        console.log('asd');
        $.ajax({
          method : 'post',
          url : 'cursos',
          data : getInput(),
          success : function(data){
            console.log("Success.");
            alert("Se crea el curso.");
            //location.reload();  
          },
          error : function(data){
            console.log("Error.");
            alert("No se pudo crear el curso.");
          }
        });
      }
    });
  });
</script>





