$('.container-fluid').on('click', '#tutorial', function(event) {
	event.preventDefault();
	
	var tour_docentes = new Tour({
		debug: true,
		backdrop: true,
		template: "<div class='popover tour'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div><div class='popover-navigation'><button class='btn btn-info' data-role='prev'>« Ant</button><span data-role='separator'>|</span><button class='btn btn-info' data-role='next'>Sig »</button><button class='btn btn-info' data-role='end'>Fin</button></div></div>",
		steps: [
		{
			element: "#abm",
			title: "Abm docentes",
			content: "Puede ver los docentes de la provincia",
			placement: 'top'
		},
		{
			element: "#abm .btn-group",
			title: "Botones",
			content: "Puede exportar en excel o pdf",
			placement: 'left'
		},
		{
			element: "#alta_profesor",
			title: "Dar de alta",
			content: "Para poder dar de alta un nuevo docente",
			placement: 'left'
		}
		]});

	tour_docentes.init();

	tour_docentes.restart();
});		