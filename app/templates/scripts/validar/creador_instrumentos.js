
function validar_edit_tabla_instrumentos(){
	form = document.getElementById('frm_edit_tablas');
	for(var i = 0; i < form.elements.length; i++){
		if(form.elements[i].type == 'select-one'){
			if(form.elements[i].value == '-1'){
				mostrarDiv('error_'+form.elements[i].name.substring(4,100));
				return false;
			}
		}else{
			if(form.elements[i].value == ''){
				mostrarDiv('error_'+form.elements[i].name.substring(4,100));
				return false;
			}
		}
	}
	document.getElementById('frm_edit_tablas').action='?mod=instrumento&niv=1&task=saveEdit';
	document.getElementById('frm_edit_tablas').submit();
}

function validar_add_tabla_instrumentos(){
    form = document.getElementById('frm_add_tablas');
    var numeros="0123456789";
    var texto1 = document.getElementById('txt_tabla').value;

	for(var i = 0; i < form.elements.length; i++){
		if(form.elements[i].type == 'select-one'){
			if(form.elements[i].value == '-1'){
				mostrarDiv('error_'+form.elements[i].name.substring(4,100));
				return false;
			}
		}else{
			if(form.elements[i].value == '' && form.elements[i].type != 'hidden'){
                            //alert(document.getElementById('error_'+form.elements[i].name.substring(4,100)).innerHTML.toString().trim().substr(0,2));
                            //if(document.getElementById('error_'+form.elements[i].name.substring(4,100)).innerHTML.toString().trim().substr(0,2) != 'NO'){
				mostrarDiv('error_'+form.elements[i].name.substring(4,100));
				return false;
                            //}
			}
		}
	}

	document.getElementById('frm_add_tablas').action='?mod=instrumento&niv=1&task=saveAdd';
	document.getElementById('frm_add_tablas').submit();
}
