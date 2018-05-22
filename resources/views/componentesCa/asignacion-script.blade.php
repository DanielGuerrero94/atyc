<script type="text/javascript">

function removeButton(id) {
    return '<a data-id="' + id + '" class="btn btn-circle quitar"><i class="fa fa-minus text-danger fa-lg"></i></a>';
}

  $(document).ready(function() {
    //Inicial
    refreshCounter("#componentesCa-de-la-pac");

    $(".container-fluid").on("click", "#select-componentes", function (e) {
        e.preventDefault();
        let selected = $(this).find(":selected");
        let id = selected.data("id");
        if (id) {

          let componenteCa = '<tr data-id="'+id+'">'+
          '<td>'+selected.data("nombre")+'<td>'+
          removeButton(id) +
          '</tr>';
          existe = false;

          $.each($("#componentesCa-de-la-pac tbody tr"),function(k,v) {
              if ($(v).data("id") == id) {
                  existe = true;
                  return false;//Corta el each de jquery
              }
          });
          if(!existe){
            $("#componentesCa-de-la-pac tbody").append(componenteCa);  
            $("#componentesCa-de-la-pac").closest("div").show();
            refreshCounter("#componentesCa-de-la-pac");           
          }
        }
    });

    $("#componentesCa-de-la-pac").on("click", ".quitar", function(event) {
      this.closest("tr").remove();
      refreshCounter("#componentesCa-de-la-pac");
    });

    function refreshCounter(html_id) {
      let count = $(html_id + " tbody").children().length;
      $("#contador-componenteCa").html(count);
    }

  });
</script>
