
function validar_add_manual(){

	if(document.getElementById('txt_nombre').value==''){
		mostrarDiv('error_nombre');
		return false;
	}
	if(document.getElementById('file_archivo').value==''){
		mostrarDiv('error_archivo');
		return false;
	}
	document.getElementById('frm_add_manual').action='?mod=manuales&task=saveAdd';
	document.getElementById('frm_add_manual').submit();
}

function validar_edit_manual(){
	if(document.getElementById('txt_nombre').value==''){
		mostrarDiv('error_nombre');
		return false;
	}
	document.getElementById('frm_edit_manual').action='?mod=manuales&task=saveEdit';
	document.getElementById('frm_edit_manual').submit();
}
