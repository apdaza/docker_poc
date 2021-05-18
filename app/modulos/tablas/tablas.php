<?php

/**
 *
 *
 * <ul>
 * <li> MadeOpen <madeopensoftware.com></li>
 * <li> Proyecto PNCAV</li>
 * </ul>
 */
/**
 * Modulo Tablas
 * maneja el modulo TABLAS en union con CTabla y CTablaData
 *
 * @see CTabla
 * @see CTablaData
 *
 * @package  modulos
 * @subpackage tablas
 * @author Alejandro Daza
 * @version 2020.01
 * @copyright apdaza
 */
//no permite el acceso directo
defined('_VALID_PRY') or die('Restricted access');
$tablaData = new CTablaData($db);
$task = $_REQUEST['task'];
if (empty($task))
    $task = 'list';

switch ($task) {
    /**
     * la variable list, permite hacer la carga la página con la lista de objetos TABLA según los parámetros de entrada
     */
    case 'list':
        if (isset($_REQUEST['sel_tabla'])) {
            $tabla_id = $_REQUEST['sel_tabla'];
        } else {
            $tabla_id = -1;
        }

        $tabla = new CTabla($tablaData);

        $tablas = $tabla->getTablas();
        $titulos_campos = $tabla->getTitulos();
        $relacion_tablas = $tabla->getRelaciones();
        $modos_tablas = $tabla->getModos();

        $form = new CHtmlForm();
        $form->setId('frm_list_tablas');
        $form->setMethod('post');
        $form->setTitle(EDITAR_TABLAS);
        $form->setClassEtiquetas('td_label');

        $opciones = null;
        foreach ($tablas as $t) {
            $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
        }
        $form->addEtiqueta(TABLA);
        $form->addSelect('select', 'sel_tabla', 'sel_tabla', $opciones, TABLA, $tabla_id, '', 'onChange=ocultarDiv(\'error_tabla\');submit();');
        $form->addError('error_tabla', ERROR_TABLA);

        $form->writeForm();


        if ($tabla_id != -1) {
            $campos = $tablaData->getCampos($tabla_id);
            $registros = $tablaData->getRegistros($tabla_id, $campos, $relacion_tablas, '1');

            $dt = new CHtmlDataTable();
            $cont = 0;
            $titulos = null;
            foreach ($campos as $c) {
                if ($cont != 0) {
                    $titulos[$cont] = $titulos_campos[$c];
                    if($relacion_tablas[$tabla_id][$c]['campo']==$c){
                        $titulos[$cont] = $titulos_campos[$relacion_tablas[$tabla_id][$c]['remplazo']];
                    }
                }
                $cont++;
            }

            $dt->setDataRows($registros);
            $dt->setTitleRow($titulos);
            $dt->setPag(1, 'sel_tabla=' . $tabla_id);

            $dt->setTitleTable($tablas[$tabla_id]['nombre']);

            $dt->setEditLink("?mod=" . $modulo . "&niv=" . $niv . "&task=edit&tabla=" . $tabla_id);
            $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $niv . "&task=delete&tabla=" . $tabla_id);

            if ($modos_tablas[$tabla_id] == 1) {
                $dt->setAddLink("?mod=" . $modulo . "&niv=" . $niv . "&task=add&tabla=" . $tabla_id);
            }
            $dt->setType(1);

            $dt->writeDataTable($niv);
        }

        break;
    /**
     * la variable add, permite hacer la carga la página con las variables que componen el objeto TABLA, ver la clase CTabla
     */
    case 'add':
        $tablaSel = $_REQUEST['tabla'];
        $id_edit = $_REQUEST['id_element'];
        $tabla_id = $_REQUEST['tabla'];

        $tabla = new CTabla($tablaData);

        $tablas = $tabla->getTablas();
        $titulos_campos = $tabla->getTitulos();
        $relacion_tablas = $tabla->getRelaciones();
        $modos_tablas = $tabla->getModos();

        $form = new CHtmlForm();
        $form->setId('frm_add_tablas');
        $form->setMethod('post');
        $form->setTitle($tablas[$tabla_id]['nombre']);
        $form->setClassEtiquetas('td_label');

        $campos = $tablaData->getCampos($tabla_id);
        $criterio = $campos[0] . " = " . $id_edit;
        $registros = $tablaData->getRegistros($tabla_id, $campos, null, $criterio);

        $cont = 0;
        foreach ($campos as $c) {
            if ($cont > 0) {
                $form->addEtiqueta($titulos_campos[$c]);
            }
            $cont++;
        }

        $tipos = $tabla->getTiposCampos($tabla_id);

        $form->addInputText('hidden', 'txt_tabla', 'txt_tabla', '60', '60', $tabla_id, '', '');
        $form->addInputText('hidden', 'sel_tabla', 'sel_tabla', '60', '60', $tablaSel, '', '');

        $cont = 0;
        foreach ($campos as $c) {
            if ($cont != 0) {
                if ($relacion_tablas[$tabla_id][$c]['campo'] == $c) {
                    $opciones = $tabla->getOpciones($relacion_tablas[$tabla_id][$c]);
                    $form->addSelect('select', 'sel_' . $c, 'sel_' . $c, $opciones, $titulos_campos[$c], $registros[0][$cont], '', 'onChange="ocultarDiv(\'error_' . $c . '\');"');
                    $form->addError('error_' . $c, '**' . $titulos_campos[$c]);
                } else {
                    //if ($tipos[$c]['len'] > 30)
                        $size = 30;
                    //else
                        //$size = 15;
                    $form->addInputText('text', 'txt_' . $c, 'txt_' . $c, $size, $tipos[$c]['len'], $registros[0][$cont], '', 'onkeypress="ocultarDiv(\'error_' . $c . '\');"');
                    $form->addError('error_' . $c, '**' . $titulos_campos[$c]);
                }
            }
            $cont++;
        }

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_add_tabla();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_add_tablas\',\'?mod=tablas&niv=1&sel_tablas=' . $tablaSel . '\');"');

        $form->writeForm();
        break;
    /**
     * la variable saveAdd, permite almacenar el objeto TABLA en la base de datos, ver la clase CTablaData
     */
    case 'saveAdd':
        $tablaSel = $_REQUEST['sel_tabla'];
        $tabla_id = $_REQUEST['txt_tabla'];

        $tabla = new CTabla($tablaData);

        $tablas = $tabla->getTablas();
        $titulos_campos = $tabla->getTitulos();
        $relacion_tablas = $tabla->getRelaciones();
        $modos_tablas = $tabla->getModos();


        $campos = $tablaData->getCampos($tabla_id);
        $criterio = $campos[0] . " = " . $id_edit;
        $registros = $tablaData->getRegistros($tabla_id, $campos, null, $criterio);

        $tipos = $tabla->getTiposCampos($tabla_id);

        $cont = 0;
        foreach ($campos as $c) {
            if ($cont != 0) {
                if ($relacion_tablas[$tabla_id][$c]['campo'] == $c) {
                    $valores[$c] = $_REQUEST['sel_' . $c];
                } else {
                    $valores[$c] = ($_REQUEST['txt_' . $c]);
                }
            }
            $cont++;
        }

        $m = $tabla->saveNewTabla($tabla_id, $campos, $valores);

        echo $html->generaAviso($m, "?mod=tablas&niv=1&sel_tabla=" . $tablaSel);

        break;
    /**
     * la variable edit, permite hacer la carga del objeto TABLA y espera confirmacion de edicion, ver la clase CTabla
     */
    case 'edit':
        $tablaSel = $_REQUEST['tabla'];
        $id_edit = $_REQUEST['id_element'];
        $tabla_id = $_REQUEST['tabla'];

        $tabla = new CTabla($tablaData);

        $tablas = $tabla->getTablas();
        $titulos_campos = $tabla->getTitulos();
        $relacion_tablas = $tabla->getRelaciones();
        $modos_tablas = $tabla->getModos();

        $form = new CHtmlForm();
        $form->setId('frm_edit_tablas');
        $form->setMethod('post');
        $form->setTitle($tablas[$tabla_id]['nombre']);
        $form->setClassEtiquetas('td_label');

        $campos = $tablaData->getCampos($tabla_id);
        $criterio = $campos[0] . " = " . $id_edit;
        $registros = $tablaData->getRegistros($tabla_id, $campos, null, $criterio);

        $cont = 0;
        foreach ($campos as $c) {
            if ($cont > 0) {
                $form->addEtiqueta($titulos_campos[$c]);
            }
            $cont++;
        }

        $tipos = $tabla->getTiposCampos($tabla_id);

        $form->addInputText('hidden', 'txt_tabla', 'txt_tabla', '60', '60', $tabla_id, '', '');
        $form->addInputText('hidden', 'sel_tabla', 'sel_tabla', '60', '60', $tablaSel, '', '');

        $cont = 0;
        foreach ($campos as $c) {
            if ($cont == 0) {
                $form->addInputText('hidden', 'txt_id', 'txt_id', '50', '50', $id_edit, '', '');
            } else {
                if ($relacion_tablas[$tabla_id][$c]['campo'] == $c) {
                    $opciones = $tabla->getOpciones($relacion_tablas[$tabla_id][$c]);
                    $form->addSelect('select', 'sel_' . $c, 'sel_' . $c, $opciones, $titulos_campos[$c], $registros[0][$cont], '', 'onChange="ocultarDiv(\'error_' . $c . '\');"');
                    $form->addError('error_' . $c, '**' . $titulos_campos[$c]);
                } else {
                    if ($tipos[$c]['len'] > 50)
                        $size = 50;
                    else
                        $size = 50;
                    $form->addInputText('text', 'txt_' . $c, 'txt_' . $c, $size, $tipos[$c]['len'], $registros[0][$cont], '', 'onkeypress="ocultarDiv(\'error_' . $c . '\');"');
                    $form->addError('error_' . $c, '**' . $titulos_campos[$c]);
                }
            }
            $cont++;
        }

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_edit_tabla();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_edit_tablas\',\'?mod=tablas&niv=1&sel_tablas=' . $tablaSel . '\');"');

        $form->writeForm();

        break;
    /**
     * la variable saveEdit, permite actualizar el objeto TABLA en la base de datos, ver la clase CTablaData
     */
    case 'saveEdit':
        $tablaSel = $_REQUEST['sel_tabla'];
        $id_edit = $_REQUEST['txt_id'];
        $tabla_id = $_REQUEST['txt_tabla'];

        $tabla = new CTabla($tablaData);

        $tablas = $tabla->getTablas();
        $titulos_campos = $tabla->getTitulos();
        $relacion_tablas = $tabla->getRelaciones();
        $modos_tablas = $tabla->getModos();


        $campos = $tablaData->getCampos($tabla_id);
        $criterio = $campos[0] . " = " . $id_edit;
        $registros = $tablaData->getRegistros($tabla_id, $campos, null, $criterio);

        $tipos = $tabla->getTiposCampos($tabla_id);

        $cont = 0;
        foreach ($campos as $c) {
            if ($cont != 0) {
                if ($relacion_tablas[$tabla_id][$c]['campo'] == $c) {
                    $valores[$c] = $_REQUEST['sel_' . $c];
                } else {
                    $valores[$c] = ($_REQUEST['txt_' . $c]);
                }
            }
            $cont++;
        }

        $m = $tabla->saveEditTabla($tabla_id, $id_edit, $campos, $valores);

        echo $html->generaAviso($m, "?mod=tablas&niv=1&sel_tabla=" . $tablaSel);

        break;
    //------------------------------------------------------------------------------------------------------------
    case 'delete':
        $id_delete = $_REQUEST['id_element'];
        $id_tabla = $_REQUEST['tabla'];
        //variables filtro cargadas en el list

        $form = new CHtmlForm();
        $form->setId('frm_delete_tablas');
        $form->setMethod('post');
        //--------------------------------------
        //variables cargadas en el list para no perder los filtros
        $form->addInputText('hidden', 'sel_tabla', 'sel_tabla', '15', '15', $id_tabla, '', '');
        //-----------------------------------------

        $form->writeForm();

        echo $html->generaAdvertencia(TABLA_MSG_BORRADO, '?mod=' . $modulo . '&niv=' . $niv . '&task=confirmDelete&id_element=' . $id_delete . '&id_tabla=' . $id_tabla . '&operador=' . $operador, "cancelarAccion('frm_delete_tablas','?mod=" . $modulo . "&niv=" . $niv . "&task=list&sel_tabla=" . $id_tabla . "&operador=" . $operador . "')");

        break;
    /**
     * la variable confirmDelete, permite eliminar el objeto COMPROMISO de la base de datos, ver la clase CCompromisoData
     */
    case 'confirmDelete':
        $id_delete = $_REQUEST['id_element'];
        $id_tabla = $_REQUEST['id_tabla'];

        $tabla = new CTabla($tablaData);
        $campos = $tablaData->getCampos($id_tabla);
        $criterio = $campos[0] . " = " . $id_delete;
        //echo $criterio;
        $m = $tabla->deleteTabla($id_tabla, $criterio);

        //echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=" . $niv . "&task=list&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . '&operador=' . $operador);
        echo $html->generaAviso($m, "?mod=tablas&niv=1&sel_tabla=" . $id_tabla);

        break;
    //---------------------------------------------------------------------------------------------------


    /**
     * en caso de que la variable task no este definida carga la página en construcción
     */
    default:
        include('templates/html/under.html');

        break;
}
?>
