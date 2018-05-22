<script type="text/javascript">

function removeButton(id) {
    return '<a data-id="' + id + '" class="btn btn-circle quitar" title="Remover"><i class="fa fa-minus text-danger fa-lg"></i></a>';
}

function refreshCounterPautas() {
    let count = $('#pautas-de-la-pac tbody').children().length;
    $('#contador-pautas').html(count);
}

  $(document).ready(function() {
    //Inicial
    refreshCounterPautas();

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
        event.preventDefault();
        this.closest('tr').remove();
        refreshCounterPautas();
    });

    
  });

    $(".container-fluid").on("click", "#select-pauta", function (e) {
        e.preventDefault();
        let selected = $(this).find(":selected");
        console.log(selected);
        let id = selected.data('id-pauta');
        if (id) {
          let pauta = '<tr data-id-pauta="'+id+'">'+
          '<td>'+selected.data('nombre')+'</td>'+
          '<td>'+selected.data('descripcion')+'</td>'+
          '<td>'+
          removeButton(id) +
          '</td>'+
          '</tr>';
          existe = false;

          $.each($('#pautas-de-la-pac tbody tr'),function(k,v) {
              if ($(v).data('id-pauta') == id) {
                  existe = true;
                  return false;
              }
          });

          if(!existe){
            $('#pautas-de-la-pac tbody').append(pauta);  
            $('#pautas-de-la-pac').closest('div').show();
            refreshCounterPautas();           
          }
        }
    });
</script>
