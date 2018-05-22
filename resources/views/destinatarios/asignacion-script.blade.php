<script type="text/javascript">

function removeButton(id) {
    return '<a data-id="' + id + '" class="btn btn-circle quitar"><i class="fa fa-minus text-danger fa-lg"></i></a>';
}

  $(document).ready(function() {
    //Inicial
    refreshCounter();
    console.log("destinatarios script");
    $(".container-fluid").on("click", "#select-destinatarios", function (e) {
        e.preventDefault();
        let selected = $(this).find(":selected");
        let id = selected.data("id");

        if (id) {
          let destinatario = '<tr data-id="'+id+'">'+
          '<td>'+selected.data("nombre")+'</td>'+
          '<td>'+
          removeButton(id) +
          '</td>'+
          '</tr>';
          existe = false;


          $.each($("#destinatarios-pac tbody tr"),function(k,v) {
              if ($(v).data("id") == id) {
                  existe = true;
                  return false;//Corta el each de jquery
              }
          });

          if(!existe){
            $("#destinatarios-pac tbody").append(destinatario);  
            $("#destinatarios-pac").closest("div").show();
            refreshCounter();           
          }
        }
    });

    $('#destinatarios-pac').on('click','.quitar', function(event) {
      this.closest('tr').remove();
      refreshCounter();
    });

    function refreshCounter() {
      let count = $("#destinatarios-pac tbody").children().length;
      $("#contador-destinatarios").html(count);
    }

  });
</script>
