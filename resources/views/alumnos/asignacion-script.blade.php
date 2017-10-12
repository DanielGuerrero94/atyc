<script type="text/javascript">
  $(document).ready(function() {
  //Inicial
  refreshCounter();
  
  $.typeahead({
    input: '.alumnos_typeahead',
    maxItem: 10,
    minLength: 4,
    order: "desc",
    dynamic: true,
    delay: 400,
    backdrop: {
      "background-color": "#fff"
    },
    template: function (query, item) {
      return '<tr><td> <b>Nombre: </b>'+item.nombres+' '+item.apellidos+' -- <b>Documento: </b> '+item.documentos+'</td></tr>';
    },
    emptyTemplate: function(){
      /*return '<tr><td><span>Crear participante <div class="btn btn-xs btn-default" id="alta_participante_dialog"><i class="fa fa-plus text-green"></i></div></span></td></tr>';*/
      return '<tr><td><a href="{{url('alumnos')}}"><i class="fa fa-plus text-green"></i><span>Crear participante</span></a></td></tr>';
    },
    source: {
      Nombres: {
        display: 'nombres',
        ajax:{
          url: "{{url('alumnos/typeahead/apellidos')}}",
          path: "data.info",
          data: {
            q: "@{{query}}"
          },
          success: function(data) {
            console.log(data);
          },
          error: function(data){
            console.log("ajax error");
            console.log(data);
          }
        }
      },
      Apellidos: {
        display: 'apellidos',
        ajax:{
          url: "{{url('alumnos/typeahead/apellidos')}}",
          path: "data.info",
          data: {
            q: "@{{query}}"
          },
          success: function(data) {
            console.log(data);
          },
          error: function(data){
            console.log("ajax error");
            console.log(data);
          }
        }
      },
      Documentos: {
        display: 'documentos',
        ajax:{
          url: "{{url('alumnos/typeahead/apellidos')}}",
          path: "data.info",
          data: {
            q: "@{{query}}"
          },
          success: function(data) {
            console.log(data);
          },
          error: function(data){
            console.log("ajax error");
            console.log(data);
          }
        }
      }
    },
    callback: {
      onInit: function (node) {
        console.log('Typeahead Initiated on ' + node.selector);
      },
      onClick: function (node, a, item, event) {
        console.log(node);
        console.log(a);
        console.log(item);
        console.log(event);
        alumno = '<tr>'+
        '<td>'+item.nombres+'</td>'+
        '<td>'+item.apellidos+'</td>'+
        '<td>'+item.documentos+'</td>'+
        '<td>'+
        '<div class="btn btn-xs btn-info "><a href="{{url('/alumnos')}}/'+item.id+'"><i class="fa fa-search" data-id="'+item.id+'"></i></a></div>'+
        '<div class="btn btn-xs btn-danger quitar"><i class="fa fa-minus"></i></div>'+
        '</td>'+
        '</tr>';
        existe = false;
        
        $.each($('#alumnos-del-curso tbody tr .fa-search'),function(k,v){
          if($(v).data('id') == item.id){
            existe = true;
          }
        });
        
        if(!existe){
          $('#alumnos-del-curso tbody').append(alumno);     
          $('#alumnos-del-curso').closest('div').show();
          refreshCounter();
        }
        $('#alumnos .alumnos_typeahead').val('');
      }
    },
    debug: true
  }); 
  
  $('.container-fluid').on('click', '#alta_participante_dialog', function(event) {
    event.preventDefault();
    
    $.ajax({
      url: "{{url('alumnos/alta')}}",
      success: function (response) {
        console.log('success');

        $('.container-fluid #alta-accion').closest('.row').slideUp(450);

        //Creo animacion de creando
        jQuery('<div/>', {
          id: 'creando-participante',
          class: 'row',
          css: 'z-index: 1000;',
          html: '<h3 style="text-align: center;">(Alta de acción en progreso) <i class="fa fa-cog fa-spin fa-2x fa-fw margin-bottom"></i> Creando Participante</h3>'
        }).appendTo('.container-fluid');

        //Creo div para el form de alta de participante
        jQuery('<div/>', {
          id: 'alta',
          text: '',
          css: 'z-index: 1000;'
        }).appendTo('.container-fluid');
        $('#alta').html(response);              
        
      },
      error: function (response) {
        console.log('error');
      }
    });           
    
  });

  $('#alumnos-del-curso').on('click','.quitar', function(event) {     
    this.closest('tr').remove();  
    refreshCounter();
  });
  
  function refreshCounter() {
    let count = $('#alumnos-del-curso tbody').children().length;
    $('#contador-participantes').html(count);
  }
  
});
</script>