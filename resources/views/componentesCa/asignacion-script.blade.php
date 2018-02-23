<script type="text/javascript">

  $(document).ready(function() {
    //Inicial
    refreshCounter();

    $.typeahead({
      input: '.componentesCa_typeahead',
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
        return '<tr><td><div class="alert alert-info"><p class="text-danger">No existe componente Ca</p></div></td></tr>';        
      },
      source: {
        Nombre: {
          display: 'nombre',
          ajax:{
            url: "{{url('componentesCa/typeahead')}}",
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
          componenteCa = '<tr>'+
          '<td>'+item.nombre+'</td>'+
          '<td>'+
          '<div class="btn btn-xs btn-danger quitar"><i class="fa fa-minus" data-id="'+item.id+'"></i></div>'+
          '</td>'+
          '</tr>';
          existe = false;

          $.each($('#componentesCa-de-la-pac tbody tr .fa-minus'),function(k,v){
            //$(v).find(td).last().find(i).first().data('id')
            if($(v).data('id') == item.id){
              existe = true;
            }
          });

          if(!existe){
            $('#componentesCa-de-la-pac tbody').append(componenteCa);  
            $('#componentesCa-de-la-pac').closest('div').show();
            refreshCounter();           
          }
          $('#componentesCa .componentesCa_typeahead').val('');
        }
      },
      debug: true
    });

/*    $('.container-fluid').on('click', '#alta_componenteCa_dialog', function(event) {
      event.preventDefault();

      $.ajax({
        url: "{{url('componentesCa/alta')}}",
        success: function (response) {
          console.log('success');

          $('.container-fluid #alta-pac').closest('.row').slideUp(450);

        //Creo animacion de creando
        jQuery('<div/>', {
          id: 'creando-componenteCa',
          class: 'row',
          css: 'z-index: 1000;',
          html: '<h3 style="text-align: center;">(Alta de pac en progreso) <i class="fa fa-cog fa-spin fa-2x fa-fw margin-bottom"></i> Creando Componente CA</h3>'
        }).appendTo('.container-fluid');

        //Creo div para el form de alta de componenteCa
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
    }); */         


    $('#componentesCa-de-la-pac').on('click','.quitar', function(event) {
      this.closest('tr').remove();
      refreshCounter();
    });

    function refreshCounter() {
      let count = $('#componentesCa-de-la-pac tbody').children().length;
      $('#contador-componenteCa').html(count);
    }

  });
</script>