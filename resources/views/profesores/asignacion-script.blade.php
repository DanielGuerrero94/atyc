<script type="text/javascript">

  $(document).ready(function() {
    //Inicial
    refreshCounter();

    $.typeahead({
      input: '.profesores_typeahead',
      maxItem: 10,
      order: "desc",
      dynamic: true,
      delay: 500,
      backdrop: {
        "background-color": "#fff"
      },
      template: function (query, item) {
        return '<tr>'+        
        '<td>'+
        item.nombres+
        ' '+
        item.apellidos+
        ' '+        
        item.documentos+
        '</td>'+
        '</tr>';
      },
      dropdownFilter: "Filtro",
      emptyTemplate: function(){
        return '<tr><td><a href="profesores"><i class="fa fa-plus text-green"></i><span>Crear docente</span></a></td></tr>';
      },
      source: {
        Nombres: {
          display: 'nombre',
          ajax:{
            url: "{{url('profesores/typeahead')}}",
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
            url: "{{url('profesores/typeahead')}}",
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
            url: "{{url('profesores/typeahead')}}",
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