<script type="text/javascript">

  $(document).on('click', '#dashboard-anio a', function(event) {
    event.preventDefault();
    let target = $(this);
    target.closest('.btn-group').find('#anio').html(target.html());
  });

  $(document).on('click', '#dashboard-division a', function(event) {
    event.preventDefault();
    let target = $(this);
    let division = target.closest('.btn-group').find('#division');
    division.html(target.html());
    division.data('id', target.data('id'));
  });

  $(document).ready(function($) {
    
    $(document).on('click', '#dashboard-refresh', function(event) {
      event.preventDefault();

      let dashboard = $(this).closest('.btn-group');
      let division = dashboard.find('#division').data('id');
      let anio = dashboard.find('#anio').html();

      $.ajax(firstCounts(division, anio))
      .done(function() {
        console.log("success counts");
      })
      .fail(function() {
        alert('ajax error first draw');
      });

      $.ajax(progressCounts(division, anio))
      .done(function() {
        console.log("success progress chart");
      })
      .fail(function() {
        alert('ajax error progress draw');
      });

      $.ajax(areasChart(division, anio))
      .done(function() {
        console.log("success areas chart");
      })
      .fail(function() {
        alert('ajax error areas draw');
      });

      $.ajax(treesCharts(division, anio))
      .done(function() {
        console.log("success trees chart");
      })
      .fail(function() {
        alert('ajax error trees draw');
      });      

    });

  });

</script>