<script type="text/javascript">

  $(document).ready(function() {
    //Inicial
    refreshCounter();

    $.typeahead({
      input: '.destinatarios_typeahead',
      maxItem: 10,
      minLength: 1,
      order: "desc",
      dynamic: true,
      delay: 400,
      backdrop: {
        "background-color": "#fff"
      },
      template: function (query, item) {
        return '<tr><td><b>Nombre: </b>'+item.nombre+'</td></tr>';
      },
      emptyTemplate: function(){
        return '<div class="alert alert-info"><p class="text-danger">No existe destinatario</p></div>';        
      },
      source: {
        Nombre: {
          display: 'nombre',
          ajax:{
            url: "{{url('funciones/typeahead')}}",
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
      },
      callback: {
        onInit: function (node) {
          console.log('Typeahead Initiated on ' + node.selector);
        },
        onClick: function (node,  a, item, event) {
          funcion = '<tr>'+         
          '<td>'+item.nombre+'</td>'+
          '<td>'+
          '<div class="btn btn-xs btn-danger quitar"><i class="fa fa-minus" data-id="'+item.id+'"></i></div>'+
          '</td>'+
          '</tr>';
          existe = false;

          $.each($('#destinatarios-de-la-pac tbody tr .fa-minus'),function(k,v){
            if($(v).data('id') == item.id){
              existe = true;
            }
          });

          if(!existe){
            $('#destinatarios-de-la-pac tbody').append(funcion);  
            $('#destinatarios-de-la-pac').closest('div').show();
            refreshCounter();           
          }
          $('#destinatarios .destinatarios_typeahead').val('');
        }
      },
      debug: true
    });

    $('#destinatarios-de-la-pac').on('click','.quitar', function(event) {
      this.closest('tr').remove();
      refreshCounter();
    });

    function refreshCounter() {
      let count = $('#destinatarios-de-la-pac tbody').children().length;
      $('#contador-destinatarios').html(count);
    }

  });
</script>