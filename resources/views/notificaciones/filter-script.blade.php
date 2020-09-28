<script type="text/javascript">

  $(document).on('click', '#historial-antiguedad a', function(event) {
    event.preventDefault();
    let target = $(this);
    target.closest('.btn-group').find('#antiguedad').html(target.html());
  });

  $(document).on('click', '#historial-division a', function(event) {
    event.preventDefault();
    let target = $(this);
    let division = target.closest('.btn-group').find('#division');
    division.html(target.html());
    division.data('id', target.data('id'));
  });

  $(document).ready(function($) {
    
    $(document).on('click', '#historial-refresh', function(event) {
      event.preventDefault();

      let historial = $(this).closest('.btn-group');
      let division = historial.find('#division').data('id');
      let antiguedad = historial.find('#antiguedad').data('dias');

      console.log(antiguedad);
        });
  });

</script>
