<script type="text/javascript">

  $(document).ready(function() {
    //Inicial
    refreshCounter();

    $.typeahead({
      input: '.areasTematicas_typeahead',
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
      source: {
        Nombre: {
          display: 'nombre',
          ajax:{
            url: "{{url('areasTematicas/typeahead')}}",
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
          areatematica = '<tr>'+       
          '<td>'+item.nombre+'</td>'+
          '<td>'+
          '<div class="btn btn-xs btn-danger quitar"><i class="fa fa-minus" data-id="'+item.id+'"></i></div>'+
          '</td>'+
          '</tr>';
          existe = false;

          $.each($('#areasTematicas-de-la-pac tbody tr .fa-search'),function(k,v){
            if($(v).data('id') == item.id){
              existe = true;
            }
          });

          if(!existe){
            $('#areasTematicas-de-la-pac tbody').append(areatematica);  
            $('#areasTematicas-de-la-pac').closest('div').show();
            refreshCounter();           
          }
          $('#areasTematicas .areasTematicas_typeahead').val('');
        }
      },
      debug: true
    });
         
    $('#areasTematicas-de-la-pac').on('click','.quitar', function(event) {
      this.closest('tr').remove();
      refreshCounter();
    });

    function refreshCounter() {
      let count = $('#areasTematicas-de-la-pac tbody').children().length;
      $('#contador-areasTematicas').html(count);
    }

  });
</script>