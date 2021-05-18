
function validar_add_tramites(){

	if(document.getElementById('sel_tramite_add').value=='-1'){
		mostrarDiv('error_tramite');
		return false;
	}
	document.getElementById('frm_add_tramite').action='?mod=validaciones_tramite&niv=1&task=saveAdd';
	document.getElementById('frm_add_tramite').submit();
}
