<script type="text/javascript">
	
	var updateButton = '<a href="#" class="btn btn-circle update" title="Remplazar archivo"><i class="fa fa-cloud-upload fa-lg text-primary"></i></a>';
	var editButton = '<a href="#" class="btn btn-circle edit" title="Editar descripción"><i class="fa fa-pencil fa-lg text-info"></i></a>';
	var deleteButton = '<a href="#" class="btn btn-circle delete" title="Borrar"><i class="fa fa-trash fa-lg text-danger"></i></a>';
	var saveButton = '<a href="#" class="btn btn-circle save" title="Guardar"><i class="fa fa-floppy-o fa-lg text-success"></i></a>';
	var cancelButton = '<a href="#" class="btn btn-circle cancel" title="Cancelar"><i class="fa fa-ban fa-lg text-danger"></i></a>';
	// var orderButton = '<a href="#" class="btn btn-circle order pull-right" title="Orden"><i class="fa fa fa-sort fa-lg" style="color: #2F2D2D;"></i></a>';
	
	var confirmOrderButton = '<a href="#" class="btn btn-circle confirm-order" title="Confirmar"><i class="fa fa-check fa-lg text-success"></i></a>';
	var revertOrderButton = '<a href="#" class="btn btn-circle revert-order" title="Revertir"><i class="fa fa-ban fa-lg text-danger"></i></a>';

	function orderInput(value) {
		return '<input type="number" name="order" class="form-control order" value="' + value + '" style="width: 20%;float: right;">';
	}

	function changeToEdit() {
		$('#grid .buttons').each(function(key,value){
			let buttons = $(value);
			buttons.html("");
			$(updateButton).appendTo(buttons);
			$(editButton).appendTo(buttons);
			$(deleteButton).appendTo(buttons);
			//$(orderButton).appendTo(buttons);
		});
	}

	$(document).ready(function($) {

		$(".container-fluid").keydown( function(e) {
			var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
			if(key == 13) {
				e.preventDefault();
				$(this).find(".save").click();
			}
		});
		
		formDescripcion = '<form id="description">{{ csrf_field() }}{{ method_field('PUT') }}<input type="text" class="form-control" id="descripcion" name="descripcion"></form>';

		formUpdate = '<form id="update" name="update" style="display: none;">{{ csrf_field() }}<label><input type="file" name="csv" style="display: none;"></label></form>';

		formUpdateAction = '<form id="update-action" name="update" style="display: none;">{{ csrf_field() }}<label><input type="file" name="csv" style="display: none;"></label></form>';

		$(".container-fluid").on("click", ".material .box-body", function(event) {
			if ($(this).parent()) {
				buttons = $(this).parent().find(".box-footer");
				buttons.html("");
				$(updateButton).appendTo(buttons);
				$(editButton).appendTo(buttons);
				$(deleteButton).appendTo(buttons);
			}
			// $(orderInput(0)).appendTo(buttons);
		});

		$(".container-fluid").on("change", ".order", function(event) {
			alert("Quiere cambiar el orden");
			value = event.currentTarget.value;
			buttons = $(this).parent();
			buttons.html("");
			$(confirmOrderButton).appendTo(buttons);
			$(revertOrderButton).appendTo(buttons);
			// $(orderInput(value)).appendTo(buttons);
		});

		$(".container-fluid").on("change", "#upload input", function(event) {
			data = new FormData($("#upload")[0]);
			$.ajax({
				url: "{{url('/materiales/etapa')}}" + "/" + $("#etapa").data('id'),
				type: 'post',
				data: data,
				processData: false,
				contentType: false,
				success: function (data) {
					console.log("success");
					location.reload();
				},
				error: function (data) {
					alert("Error al subir un archivo.");
					location.reload();
				}
			});
		});

		$(".container-fluid").on("change", "#update input", function(event) {
			data = new FormData($(this).closest(".box").find("form")[0]);
			let id = $(this).closest(".box-footer").data("id");			
			$.ajax({
				url: "{{url('/materiales')}}" + "/" + id,
				type: 'post',
				data: data,
				processData: false,
				contentType: false,
				success: function (data) {
					console.log("success");
					location.reload();
				},
				error: function (data) {
					alert("Error al actualizar el archivo.");
					location.reload();
				}
			});
		});

		$(".container-fluid").on("click", "#configure", function(event) {
			event.preventDefault();
			configure = $(this);
			if (configure.data('toggle')) {
				changeToDownload();
				configure.data("toggle", false);
			} else {
				changeToEdit();
				configure.data("toggle", true);
			}			
		});

		$(".container-fluid").on("click", ".update-action", function(event) {
			$(formUpdateAction).appendTo($(this).parent());
			$(this).parent().find("form input").click();
		});

		$(".container-fluid").on("change", "#update-action input", function(event) {
			form = $(this).parent().parent();
			data = new FormData(form[0]);
			id = form.parent().find(".update-action").data("id");			
			$.ajax({
				url: "{{url('/materiales')}}" + "/" + id,
				type: 'post',
				data: data,
				processData: false,
				contentType: false,
				success: function (data) {
					console.log("success");
					location.reload();
				},
				error: function (data) {
					alert("Error al actualizar el archivo.");
					location.reload();
				}
			});
		});

		$(".container-fluid").on("click", ".update", function(event) {
			let buttons = $(this).parent();
			$(formUpdate).appendTo(buttons);
			buttons.find("#update input").eq(1).click();
		});

		var short;

		$(".container-fluid").on("click", ".edit", function(event) {
			event.preventDefault();
			let edit = $(this);
			let id = edit.closest(".box-footer").data("id");
			let blockquote = edit.closest(".box").find(".description");
			//Guardo el texto de descripcion
			let span = blockquote.find("span");
			short = span.text();
			span.html(span.attr('tittle'));
			let old = span.text();
			//Agrego el input y pongo el texto viejo
			input = formDescripcion;
			blockquote.html(input);

			//Fuerzo a que haga focus al final del texto
			blockquote.find("input").eq(2).val(old);
			blockquote.find("input").eq(2).focus();

			//Saco los botones y pongo el de cancelar y guardar
			let buttons = edit.parent();
			buttons.html("");
			$(cancelButton).appendTo(buttons);
			$(saveButton).appendTo(buttons);

			blockquote.css("margin-bottom", "0px");
			blockquote.css("padding-bottom", "5px");
		});

		$(".container-fluid").on("click", ".cancel", function(event) {
			location.reload();
		});

		$(".container-fluid").on("click", ".save", function(event) {
			let id = $(this).closest(".box-footer").data("id");
			let data = $(this).closest(".box").find("#description").serialize();
			console.log(data);
			$.ajax({
				url: "{{url('/materiales')}}" + "/" + id,
				type: 'put',
				data: data,
				success: function (data) {
					console.log("success");
					location.reload();
				},
				error: function (data) {
					console.log(data);
					alert("Error al subir un archivo.");
					// location.reload();
				}
			});			
		});

		var check = jQuery('<p/>', {
			id: 'dialogDelete',
			text: '¿Esta seguro que quiere borrar el archivo?'
		});

		$(".container-fluid").on("click", ".delete", function(event) {
			event.preventDefault();
			let id;

			if ($(".container-fluid .fa-th").length) {
				id = $(this).data("id");
			} else {
				id = $(this).closest(".box-footer").data('id');				
			}


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
						_token = $('.container-fluid #upload').children().val();

						$.ajax({
							url: "{{url('/materiales')}}" + "/" + id,
							type: 'delete',
							data: {'_token': _token},
							success: function (data) {
								location.reload("true");
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

	});

</script>
