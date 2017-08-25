function switchIcon(domObject,unIcono,otroIcono) {
	if(domObject.hasClass(unIcono)){
		domObject.removeClass(unIcono);
		domObject.addClass(otroIcono);	
	}else{
		domObject.removeClass(otroIcono);
		domObject.addClass(unIcono);	
	}			
};

function showCalendarInputs(unInput,otroInput) {
	if(unInput.is(':visible')){
		unInput.hide('slow');
		otroInput.show();
	}else{
		unInput.show('slow');
		otroInput.hide();
	}
};

//Para reportes
function mostrarDialogDescarga(){
	
	jQuery('<div/>', {
		id: 'dialogDownload',
		text: ''
	}).appendTo('.container-fluid');
	
	$("#dialogDownload").dialog({
		title: "Descarga",
		show: {
			effect: "fold"
		},
		hide: {
			effect: "fade"
		},
		modal: true,
		width : 360,
		height : 150,
		closeOnEscape: true,
		closeText: "Cerrar",
		resizable: false,
		open: function () {
			jQuery('<h3/>', {
				id: 'dialogDownload',
				text: 'Se descargara pronto.'
			}).appendTo('#dialogDownload');
		}
	});
};

function getFiltrosReportes() {
	var id_provincia = $('#filtros #provincia :selected').data('id');
	var id_periodo,desde,hasta;

	if($('#toggle-fecha i').hasClass('fa-toggle-off')){
		id_periodo = $('#filtros #periodo :selected').data('id');
	}else{
		desde = $('#filtros #desde').val();
		hasta = $('#filtros #hasta').val();
	}

	return {
		id_provincia: id_provincia,
		id_periodo: id_periodo,
		desde: desde,
		hasta: hasta
	};
};

