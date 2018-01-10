<script type="text/javascript">

	function editTemplate(id) {
		return '<a href="#"><i class="fa fa-pencil-square-o fa-2x text-info detail" title="Detalle" data-id="' + id + '"></i></a>';
	}

	function deleteTemplate(id) {
		return '<a href="#"><i class="fa fa-trash-o fa-2x text-danger delete" title="Borrar" data-id="' + id + '"></i></a>';
	}

	var excelTemplate = '<a href="#" class="btn btn-box-tool excel" title="Excel"><i class="fa fa-file-excel-o fa-lg text-success"></i></a>';
	var createTemplate = '<a href="#" class="btn btn-box-tool" id="new" title="Crear"><i class="fa fa-plus fa-lg text-success"></i></a>';
	var barButtonsTemplate = '<div class="box-tools pull-right" style="margin-top: 5px;">' + excelTemplate + createTemplate + '</div>';

	$(document).ready(function(){

		$('.container-fluid #abm-table').DataTable({
			destroy: true,
			searching: true,
			ajax : "{{url('/funciones/table')}}",
			columns: [
			{ data: 'id_funcion', name: 'id'},
			{ data: 'nombre'},
			{ 
				data: 'id_funcion',
				name: 'acciones',
				render: function ( data, type, row, meta ) {
					return editTemplate(data);
				},
				orderable: false
			}
			],
			responsive: true
		});

		var check = jQuery('<p/>', {
			id: 'check',
			text: '¿Esta seguro que quiere dar de baja la funcion?'
		});

		$(".container-fluid").on("click", ".delete", function(event){
			event.preventDefault();
			let id = $(this).data("id");

			$('<div id="dialogDelete"></div>').appendTo('.container-fluid');

			$("#dialogDelete").dialog({
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
					check.appendTo('#dialogDelete');
				},
				close : function () {
					$(this).dialog("destroy").remove();
				},
				buttons :
				{
					"Aceptar" : function () {
						$(this).dialog("destroy");
						_token = $("#abm input").first().val();

						$.ajax ({
							url: "{{url('/funciones')}}" + "/" + id,
							method: 'delete',
							data: {'_token': _token},
							success: function(data){
								$('.main-sidebar').click("#destinatarios");
							},
							error: function (data) {
								alert(data.responseText);
							}
						});

					},
					"Cancelar" : function () {
						$(this).dialog("close");	
					}
				}
			});			
		});

		$(".container-fluid").on("click", "#new",function(){

			$('#abm').hide();

			$.ajax({
				url: "{{url('/funciones/create')}}",
				success: function(data){
					$('#alta').html(data);
					$('#alta').show();
				},
				error: function(error) {
					alert(error.responseText);
				}
			});

		});		

		$(".container-fluid").on("click", ".detail",function(){
			window.location = "{{url('/funciones')}}" + "/" + $(this).data('id') + "/edit";
		});		

	});

</script> 