<script type="text/javascript">

function removeButton(id) {
    return '<a data-id="' + id + '" class="btn btn-circle quitar" title="Remover"><i class="fa fa-minus text-danger fa-lg"></i></a>';
}

  $(document).ready(function() {
    //Inicial
    refreshCounterPautas();

    $.typeahead({
      input: '.pautas_typeahead',
      maxItem: 10,
      minLength: 1,
      order: "desc",
      dynamic: true,
      delay: 400,
      backdrop: {
        "background-color": "#fff"
      },
      template: function (query, item) {
        return '<tr><td><b>Item: </b>'+item.item+' <b>Nombre: </b>'+item.nombre+' <b>Descripcion: </b>'+item.descripcion+'</td></tr>';
      },
      emptyTemplate: function(){
        return '<tr><td><button type="button" class="btn btn-outline" id="alta_pauta_dialog"><i class="fa fa-plus text-green"></i><b>  Crear pauta </b></button></td></tr>';        
      },
      source: {
        Nombre: {
          display: 'nombre',
          ajax:{
            url: "{{url('pautas/typeahead')}}",
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
        Descripcion: {
          display: 'descripcion',
          ajax: {
            url: "{{url('pautas/typeahead')}}",
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
        Item: {
          display: 'item',
          ajax:{
            url: "{{url('pautas/typeahead')}}",
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
          pauta = '<tr>'+
          '<td>'+item.nombre+'</td>'+
          '<td>'+item.descripcion+'</td>'+
          '<td>'+
          removeButton(item.id) +
          '</td>'+
          '</tr>';
          existe = false;

          $.each($('#pautas-de-la-pac tbody tr .fa-search'),function(k,v){
            if($(v).data('id') == item.id){
              existe = true;
            }
          });

          if(!existe){
            $('#pautas-de-la-pac tbody').append(pauta);  
            $('#pautas-de-la-pac').closest('div').show();
            refreshCounterPautas();           
          }
          $('#pautas .pautas_typeahead').val('');
        }
      },
      debug: true
    });

    $('.container-fluid').on('click', '#alta_pauta_dialog', function(event) {
      event.preventDefault();

      $.ajax({
        url: "{{url('pautas/alta')}}",
        success: function (response) {
          console.log('success');

          $('.container-fluid #alta-pauta').closest('.row').slideUp(450);

        //Creo animacion de creando
        jQuery('<div/>', {
          id: 'creando-pauta',
          class: 'row',
          css: 'z-index: 1000;',
          html: '<h3 style="text-align: center;">(Alta de pauta en progreso) <i class="fa fa-cog fa-spin fa-2x fa-fw margin-bottom"></i> Creando Pauta</h3>'
        }).appendTo('.container-fluid');

        //Creo div para el form de alta de pauta
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


    $('#pautas-de-la-pac').on('click','.quitar', function(event) {
      this.closest('tr').remove();
      refreshCounterPautas();
    });

    function refreshCounterPautas() {
      let count = $('#pautas-de-la-pac tbody').children().length;
      $('#contador-pautas').html(count);
    }

  });
</script>
