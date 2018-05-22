<script type="text/javascript">

function removeButton(id) {
    return '<a data-id="' + id + '" class="btn btn-circle quitar"><i class="fa fa-minus text-danger fa-lg"></i></a>';
}

  $(document).ready(function() {
    //Inicial
    refreshCounter();

    $(".container-fluid").on("click", "#select-areas-tematicas", function (e) {
        e.preventDefault();
        let selected = $(this).find(":selected");
        let id = selected.data("id");
        console.log("selected " + id);
        if (id) {

          let area_tematica = '<tr data-id="'+id+'">'+
          '<td>'+selected.data("nombre")+'</td>'+
          '<td>'+
          removeButton(id) +
          '</td>'+
          '</tr>';
          existe = false;

          $.each($("#areasTematicas-de-la-pac tbody tr"),function(k,v) {
              if ($(v).data("id") == id) {
                  existe = true;
                  return false;//Corta el each de jquery
              }
          });

          if(!existe){
            $("#areasTematicas-de-la-pac tbody").append(area_tematica);  
            $("#areasTematicas-de-la-pac").closest("div").show();
            refreshCounter();           
          }
        }
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
