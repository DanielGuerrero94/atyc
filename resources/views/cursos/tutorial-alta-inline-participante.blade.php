$('.container-fluid').on('click', '#tutorial-alta-inline', function(event) {
	event.preventDefault();
	
	var tour_alta_inline = new Tour({
		debug: true,
		backdrop: true,
		delay: 500,
		template: "<div class='popover tour'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div><div class='popover-navigation'><button class='btn btn-info' data-role='prev'>« Ant</button><span data-role='separator'>|</span><button class='btn btn-info' data-role='next'>Sig »</button><button class='btn btn-info' data-role='end'>Fin</button></div></div>",
		steps: [
		{
			element: "#busqueda-participantes",
			title: "Asignacion participante",
			content: "Si el participante no se encuentra lo puede crear sin perder el estado actual de la creacion de la accion.",
			placement: 'bottom',
			onShown: function () {
				$('#busqueda-participantes input').val('Cualquier participante que no exista.');
				$('#busqueda-participantes .alumnos_typeahead').trigger(jQuery.Event("input"));
			},
			onNext: function () {
				$('#alta_participante_dialog').click();
			}
		},
		{
			element: ".container-fluid",
			title: "Creacion de participante",
			content: "Puede crear el participante en este formulario.",
			placement: 'left'
		},
		{
			element: ".container-fluid #alta #form-alta #crear",
			title: "Creacion de participante",
			content: "Al crear el participante volvera a la carga de la accion.",
			placement: 'top',
			onNext: function () {
				$('.container-fluid #alta #form-alta #volver').click();
			}
		},
		{
			element: "#alta-accion",
			title: "Asignacion de participante",
			content: "El participante creado se asigna directamente a la accion.",
			placement: 'top'
		}
		],		
		onStart: function () {
			$('#beta-alert').remove();
		},
		onEnd: function () {
			$('.alumnos_typeahead').val("");
		}
	});

	tour_alta_inline.init();

	tour_alta_inline.restart();
});