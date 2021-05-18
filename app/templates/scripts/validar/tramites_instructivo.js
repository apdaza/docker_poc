
function validar_add_tramite_instructivo(){

	if(document.getElementById('txt_fecha_add').value==''){
		mostrarDiv('error_fecha');
		return false;
	}
	if(document.getElementById('file_archivo').value==''){
		mostrarDiv('error_archivo');
		return false;
	}

	document.getElementById('frm_add_tramite_instructivo').action='?mod=tramites_instructivo&niv=1&task=saveAddInstructivo';
	document.getElementById('frm_add_tramite_instructivo').submit();
}
