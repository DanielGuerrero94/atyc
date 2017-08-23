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
}