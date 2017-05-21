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