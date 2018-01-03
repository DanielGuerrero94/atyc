<script type="text/javascript">

  $(document).ready(function() {
    //Inicial
    refreshCounter();

    $.typeahead({
      input: '.profesores_typeahead',
      maxItem: 10,
      minLength: 3,
      order: "desc",
      dynamic: true,
      delay: 400,
      backdrop: {
        "background-color": "#fff"
      },
      template: function (query, item) {
        return '<tr><td><b>Nombre: </b>'+item.nombres+' '+item.apellidos+' -- <b>Documento: </b>'+item.documentos+'</td></tr>';
      },
      emptyTemplate: function(){
        return '<tr><td><button type="button" class="btn btn-outline" id="alta_docente_dialog"><i class="fa fa-plus text-green"></i><b>  Crear docente </b></button></td></tr>';        
      },
      source: {
        Nombres: {
          display: 'nombre',
          ajax:{
            url: "{{url('/profesores/typeahead')}}",
            path: "data.info",
            data: {
              q: "@{{query}}"
            },
            error: function(data){
              console.log("ajax error");
              console.log(data);
            }
          }
        },
        Apellidos: {
          display: 'apellidos',
          ajax: {
            url: "{{url('/profesores/typeahead')}}",
            path: "data.info",
            data: {
              q: "@{{query}}"
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
            url: "{{url('/profesores/typeahead')}}",
            path: "data.info",
            data: {
              q: "@{{query}}"
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
        onClick: function (node,  a, item, event) {
          profesor = '<tr>'+
          '<td>'+item.nombres+'</td>'+
          '<td>'+item.apellidos+'</td>'+
          '<td>'+item.documentos+'</td>'+
          '<td>'+
          '<div class="btn btn-xs btn-info"><a href="{{url('/profesores')}}/'+item.id+'"><i class="fa fa-search" data-id="'+item.id+'"></i></a></div>'+
          '<div class="btn btn-xs btn-danger quitar"><i class="fa fa-minus"></i></div>'+
          '</td>'+
          '</tr>';
          existe = false;

          $.each($('#profesores-del-curso tbody tr .fa-search'),function(k,v){
            if($(v).data('id') == item.id){
              existe = true;
            }
          });

          if(!existe){
            $('#profesores-del-curso tbody').append(profesor);  
            $('#profesores-del-curso').closest('div').show();
            refreshCounter();           
          }
          $('#profesores .profesores_typeahead').val('');
        }
      },
      debug: true
    });

    $('.container-fluid').on('click', '#alta_docente_dialog', function(event) {
      event.preventDefault();

      $.ajax({
        url: "{{url('/profesores/alta')}}",
        success: function (response) {
          console.log('success');

          $('.container-fluid #alta-accion').closest('.row').slideUp(450);
          //Quick fix
          $('.container-fluid #modificacion-accion').closest('.row').slideUp(450);

        //Creo animacion de creando
        jQuery('<div/>', {
          id: 'creando-docente',
          class: 'row',
          css: 'z-index: 1000;',
          html: '<h3 style="text-align: center;">(Alta de acción en progreso) <i class="fa fa-cog fa-spin fa-2x fa-fw margin-bottom"></i> Creando Docente</h3>'
        }).appendTo('.container-fluid');

        //Creo div para el form de alta de docente
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


    $('#profesores-del-curso').on('click','.quitar', function(event) {
      this.closest('tr').remove();
      refreshCounter();
    });

    function refreshCounter() {
      let count = $('#profesores-del-curso tbody').children().length;
      $('#contador-docentes').html(count);
    }

  });
</script>