function addRow(idTable) {
    var table = document.getElementById(idTable);
    var lastPosition = table.rows.length - 1;
    var row = table.insertRow(lastPosition);
    var cell = row.insertCell(0);
    cell.innerHTML = lastPosition;
    cell = row.insertCell(1);
    cell.innerHTML = "<input type='text' class='form-control'"
            + " id='nombreSeccion" + lastPosition + "'"
            + " name = 'nombreSeccion" + lastPosition + "'"
            + " size='45' maxlength='45'"
            + " placeholder='Escribe el nombre de la secci&oacute;n'"
            + " autofocus required/>";
    var input = document.getElementById("numeroSecciones");
    input.value = lastPosition;
}

function addRowPregunta(idTable) {
    var table = document.getElementById(idTable);
    var lastPosition = table.rows.length - 1;
    var row = table.insertRow(lastPosition);
    var cell = row.insertCell(0);
    cell.innerHTML = "<table id='pregunta" + lastPosition + "'><tbody>"
            + "<tr><th colspan='2'>Pregunta " + lastPosition + "</th></tr>"
            + "</tbody></table>";
    var tablePregunta = document.getElementById("pregunta" + lastPosition);
    row = tablePregunta.insertRow(1);
    cell = row.insertCell(0);
    cell.innerHTML = "N&uacute;mero:";
    cell = row.insertCell(1);
    cell.innerHTML = lastPosition;
    row = tablePregunta.insertRow(2);
    cell = row.insertCell(0);
    cell.innerHTML = "Requerido:";
    cell = row.insertCell(1);
    cell.innerHTML = '<input type="checkbox" id="requeridoPregunta' + lastPosition + '"'
            + ' name="requeridoPregunta' + lastPosition + '" />';
    row = tablePregunta.insertRow(3);
    cell = row.insertCell(0);
    cell.innerHTML = "Enunciado:";
    cell = row.insertCell(1);
    cell.innerHTML = '<input type="text" id="enunciadoPregunta' + lastPosition + '"'
            + ' name="enunciadoPregunta' + lastPosition + '" size="45"'
            + ' maxlength="45" autofocus required/>';
    row = tablePregunta.insertRow(4);
    cell = row.insertCell(0);
    cell.innerHTML = "Tipo:";
    cell = row.insertCell(1);
    cell.innerHTML = '<input type="text" id="tipoPregunta' + lastPosition + '"'
            + ' name="tipoPregunta' + lastPosition + '"'
            + ' list="tipo"'
            + ' onchange="showOptions(\'pregunta' + lastPosition + '\', this)" required>';
    document.getElementById('numeroPreguntas').value = lastPosition;
}

function deleteRow(idTable, hasFoot) {
    var table = document.getElementById(idTable);
    var lastPosition = 0;
    if (hasFoot) {
        lastPosition = table.rows.length - 2;
    } else {
        lastPosition = table.rows.length - 1;
    }
    if (lastPosition !== 1) {
        document.getElementById(idTable).deleteRow(lastPosition);
    }
}

function showOptions(idTable, select) {
    var numeroPregunta = document.getElementById('preguntas');
    var idElement = numeroPregunta.rows.length - 2;
    var table = document.getElementById(idTable);
    var valueSelect = select.value;
    var lastPosition = table.rows.length;
    if (lastPosition > 5) {
        deleteRow(idTable, false);
        deleteRow(idTable, false);
    }
    lastPosition = table.rows.length;
    var row = table.insertRow(lastPosition);
    var cell = row.insertCell(0);
    if (valueSelect === "0") {
        cell.innerHTML = "Subtipo:";
        cell = row.insertCell(1);
        cell.innerHTML = "<input type='text' list='tipoAbierta' id='subtipoPregunta"
                + idElement + "' name='subtipoPregunta"
                + idElement + "' required/>";
        row = table.insertRow(lastPosition + 1);
        cell = row.insertCell(0);
        cell.innerHTML = "Longitud:";
        cell = row.insertCell(1);
        cell.innerHTML = "<input type='number' min=0 id='longitudPregunta"
                + idElement + "' name='longitudPregunta"
                + idElement + "' required/>";
    } else {
        cell.innerHTML = "Subtipo:";
        cell = row.insertCell(1);
        cell.innerHTML = "<input type='text' list='tipoCerrada' id='subtipoPregunta"
                + idElement + "' name='subtipoPregunta"
                + idElement + "' required/>";
        var row = table.insertRow(lastPosition + 1);
        cell = row.insertCell(0);
        cell.innerHTML = "Opciones de Respuesta:";
        cell = row.insertCell(1);
        cell.innerHTML = "<input type='text' id='opcRespuestaPregunta"
                + idElement + "' name='opcRespuestaPregunta"
                + idElement + "' required/>";

    }
}

function actualizarPreguntas(mod,niv,task,input,idElement){
    var seccionActual = input.value-1;
    alert('?mod='+ mod +'&niv=' + niv + '&task=' 
                    + task + '&seccionActual=' + seccionActual 
                    + "&id_element=" + idElement);
    location.href = '?mod='+ mod +'&niv=' + niv + '&task=' 
                    + task + '&seccionActual=' + seccionActual 
                    + "&id_element=" + idElement;
}