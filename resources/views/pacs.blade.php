@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
	<div class="row">		
		<div id="abm" class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
			@include('pacs.abm')
		</div>
	</div>
	<div class="row">
		<div id="alta-pac" class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1" style="display: none;">
		</div>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">
	
	function format ( d ) {
	    var sum="";

	    sum = '<div class="container" style="float: left; border: 1px solid; width: 800px; border-color: #009900aa"><div style="float: left; width: 250px;"><strong>PAUTAS</strong>';
	    d.pautas.forEach(function(item)  {
	    	console.log(item.nombre);
	  		sum += '<br>'+item.nombre;
		});
	    sum += '</div>'

	    sum += '<div style="float: left; width: 250px;"><strong>DESTINATARIOS</strong>';
	    d.destinatarios.forEach(function(item)  {
	    	console.log(item.nombre);
	  		sum += '<br>'+item.nombre;
		});
	    sum += '</div>'

	    sum += '<div style="float: left; width: 250px;"><strong>COMPONENTES CA</strong>';
	    d.componentes_ca.forEach(function(item)  {
	    	console.log(item.nombre);
	  		sum += '<br>'+item.nombre;
		});
	    sum += '</div></div>'

	    return sum;
	}

	$(document).ready(function(){

		var datatable;

		$('#abm').on('click','.filter',function () {
			$('#filtros .box').show();
		});

		var datatable = $('#abm-table').DataTable({
	        processing: true,
	        serverSide: true,
			destroy: true,
			searching: false,
			ajax : '{{ url('pacs/tabla') }}',
			columns: [
			{ data: null, class: 'details-control', defaultContent: "" },
			{ data: 'nombre'},
			{ data: 't1'},
			{ data: 't2'},
			{ data: 't3'},
			{ data: 't4'},
			{ data: 'observado'},
			{ data: 'acciones',"orderable": false}
			],			
			rowReorder: {
				selector: 'td:nth-child(2)'
			},
			responsive: false
		});
	 // Array to track the ids of the details displayed rows
	    var detailRows = [];
	 
	    $('#abm-table tbody').on( 'click', 'tr td.details-control', function () {
	        var tr = $(this).closest('tr');
	        var row = datatable.row( tr );
	        var idx = $.inArray( tr.attr('id'), detailRows );
	 
	        if ( row.child.isShown() ) {
	            tr.removeClass( 'details' );
	            row.child.hide();
	 
	            // Remove from the 'open' array
	            detailRows.splice( idx, 1 );
	        }
	        else {
	            tr.addClass( 'details' );
	            row.child( format( row.data() ) ).show();
	 
	            // Add to the 'open' array
	            if ( idx === -1 ) {
	                detailRows.push( tr.attr('id') );
	            }
	        }
	    } );
	 
	    // On each draw, loop over the `detailRows` array and show any child rows
	    datatable.on( 'draw', function () {
	        $.each( detailRows, function ( i, id ) {
	            $('#'+id+' td.details-control').trigger( 'click' );
	        } );
	    } );


		$('#alta_pac').on("click",function(){

			$.ajax({
				url: "{{url('pacs/alta')}}",
				type: 'get',
                beforeSend: function () {
                        $("#alta-pac").html("Procesando, espere por favor...");
                },				
				success: function(data){
					$('#alta-pac').html(data);
					$('#alta-pac').show();
					$('#abm').hide();
				}
			});
		});

		$("#alta-pac").on("click","#volver",function(){
			console.log('Se vuelve sin crear la pac.');
			$('#alta-pac').html("");
			$('#abm').show();
			$('#filtros').show();
		});

		$('#abm').on('click','.expand',function () {
			$('#abm').removeClass("col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1");
			datatable.draw();
			$('.compress').show();	
			$(this).hide();
		});

		$('#abm').on('click','.compress',function () {
			$('#abm').addClass("col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1");
			datatable.draw();
			$('.expand').show();	
			$(this).hide();	
		});

		$('#abm').on("click",".eliminar",function(){
			var pac = $(this).data('id');
			var data = '_token='+$('#abm input').first().val();
			jQuery('<div/>', {
				id: 'dialogABM',
				text: ''
			}).appendTo('.container-fluid');

			$("#dialogABM").dialog({
				title: "Verificacion",
				show: {
					effect: "fold"
				},
				hide: {
					effect: "fade"
				},
				modal: true,
				width : 360,
				height : 220,
				closeOnEscape: true,
				resizable: false,
				dialogClass: "alert",
				open: function () {
					jQuery('<p/>', {
						id: 'dialogABM',
						text: '¿Esta seguro que quiere dar de baja al profesor?'
					}).appendTo('#dialogABM');
				},
				buttons :
				{
					"Aceptar" : function () {
						$(this).dialog("destroy");
						$("#dialogABM").html("");
						$.ajax ({
							url: 'pacs/'+pac,
							method: 'delete',
							data: data,
							success: function(data){
								console.log('Se borro la pac.');
								location.reload();
							},
							error: function (data) {
								console.log('Hubo un error.');
								console.log(data);
							}
						});

					},
					"Cancelar" : function () {
						$(this).dialog("destroy");
						$("#dialogABM").html("");
						location.reload("true");
					}
				}
			});
		});

		$('#alta-pac').on('click','#modificar',function() {

			var pac = $(this).data('id');

			$.ajax({				
				url : 'pacs/'+pac,
				method : 'put',
				data : $('form').serialize(),
				success : function(data){
					console.log("Success.");
					location.reload();	
				},
				error : function(data){
					console.log("Error.");
				}
			});
		});				

	});

</script> 
@endsection