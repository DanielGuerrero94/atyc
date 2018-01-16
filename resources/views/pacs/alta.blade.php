<form id="form-alta">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li id="tab-pac" class="active"><a href="#inicial" data-toggle="tab">Inicial</a></li>
      <li id="tab-pauta"><a href="#pautas" data-toggle="tab">Pautas</a></li>
      <li id="tab-docente"><a href="#profesores" data-toggle="tab">Docentes</a></li>
      <li class="navbar-right"><div class="btn btn-success store">Guardar</div></li>
    </ul>
    <div class="tab-content">
      <div class="active tab-pane" id="inicial">
        <form>
          {{ csrf_field() }}
          <div class="row">
            <div class="form-group col-xs-12 col-md-6">       
              <label class="col-xs-3 col-sm-4 col-md-4 col-lg-4">Nombre:</label>
              <div class="typeahead__container col-xs-9 col-sm-8 col-md-8 col-lg-8">
                <div class="typeahead__field ">             
                  <span class="typeahead__query ">
                    <input class="curso_typeahead form-control" name="nombre" type="search" placeholder="Buscar o agregar uno nuevo" autocomplete="off">
                  </span>
                </div>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="form-group col-xs-12 col-md-6">          
              <label for="trimestre_planificacion" class="control-label col-md-4 col-xs-3">Trimestre a planificar</label>
              <div class="col-md-8 col-xs-9">
                <input type="number" class="form-control" name="planificar" id="trimestre_planificacion" placeholder="Trimestre a planificar la accion"> 
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <ul>
              <li>Trimestre:</li>
                  <div class="form-check form-check-inline">
                      <input type="checkbox" id="t1">
                      <label for="t1">
                          1ro
                      </label>
                      <input type="checkbox" id="t2">
                      <label for="t2">
                          2do
                      </label>
                      <input type="checkbox" id="t3">
                      <label for="t3">
                          3ro
                      </label>
                      <input type="checkbox" id="t4">
                      <label for="t4">
                          4to
                      </label>
                  </div>
            </ul>
          </div>
          <div class="row">
            <ul>
              <div class="checkbox checkbox-info">
                <input type="checkbox" id="consul_peatyc">
                <label for="consul_peatyc">
                    Consultor PeAtyc
                </label>
              </div>
            </ul>
          </div>
          <br>
          <div class="row">
            <div class="form-group col-xs-12 col-md-6">          
              <label for="observado" class="control-label col-md-4 col-xs-3">Observado</label>
              <div class="col-md-8 col-xs-9">
                <input type="text" class="form-control" name="observado" id="observado" placeholder="Observado"> 
              </div>
            </div>
          </div>          
        </form>  
      </div>
      <div class="tab-pane" id="pautas">  
        <form>
          @include('componentesCa.asignacion')
        @include('pautas.asignacion') 
        <br>        
        </form>
      </div>
    </div> 
  </div>      
</form>

<script type="text/javascript">

  $(document).ready(function() {

    $(".js-example-basic-single").select2();    

    var botonQuitar = '<td><button class="btn btn-danger btn-xs quitar" title="Quitar"><i class="fa fa-minus-circle" aria-hidden="true"></i></button></td>';

/*    $('#alta-pac #tabla-profesores').on('click','.agregar',function () {

      var fila = $(this).parent().parent();
      var id = $(this).data('id');

      fila.find('td:last').remove();
      fila.append(botonQuitar);

      var data = $('#tabla-profesores').DataTable().row(fila).data();      

      $('#tabla-profesores').DataTable().row(fila).remove().draw(false);
      var nueva_fila = $('#tabla-profesores-curso').DataTable().row.add(data).draw(false).row().node();

      $(nueva_fila).find('td:last').remove();
      $(nueva_fila).append(botonQuitar); 
      $(nueva_fila).find('td:last button').attr('data-id',id);

    });*/

    $.typeahead({
      input: '.curso_typeahead',
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

    function getPautasSelected() {
      return $('#form-alta #pautas-de-la-pac .fa-search').map(function(index, val) {
        return $(val).data('id');
      });
    }

    function getComponentesCaSelected() {
      return $('#componentesCa-de-la-pac .fa-search').map(function(index, val) {
        return $(val).data('id');
      });
    }

    function getSelected() {

      var pautas = getPautasSelected();
      var componentesCa = getComponrentesCaSelected();
      return [
      { 
        name: 'pautas',
        value: pautas.toArray()
      },
      { 
        name: 'componentesCa',
        value: componentesCa.toArray()
      }];
    }

    function getInput() {         
      return $.merge($('#form-alta').serializeArray(),getSelected());
    }  

    var validator = $('#alta-pauta #form-alta').validate({
      rules : {
        nombre : {
          required: true
        },
        planificar : {
          required: true,
          number: true
        },
      },
      messages:{
        nombre : "Campo obligatorio",
        planificar : "Campo obligatorio",
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
        $.ajax({
          method : 'post',
          url : 'pacs',
          data : getInput(),
          success : function(data){
            console.log("Success.");
            alert("Se crea el pac.");
            location.replace('pacs');
          },
          error : function(data){
            console.log("Error.");
            alert("No se pudo crear el pac.");
          }
        });
      }
    });

    $('#alta-pac').on('click','.store',function() {  
      $('#alta-pac .nav-tabs').children().first().children().click();
      if(validator.valid()){
        $('#alta-pac #form-alta').submit(); 
      }else{
        alert('Hay campos que no cumplen con la validacion.');
      }
    });

  });
</script>

{{-- Script asignacion pautas --}}
@include('pautas.asignacion-script')

{{-- Script para asignacion de componentes --}}
@include('componentesCa.asignacion-script')