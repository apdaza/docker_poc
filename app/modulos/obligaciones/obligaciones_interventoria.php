<?php
/**
* Sistema GPC
*
*<ul>
* <li> MadeOpen <madeopensoftware.com></li>
* <li> Proyecto KBT </li>
*</ul>
*/

/**
* Modulo obligaciones_interventoria
* maneja el modulo OBLIGACIONES en union con CObligacion y CObligacionInterventoriaData
*
* @see CObligacion
* @see CObligacionInterventoriaData
*
* @package  modulos
* @subpackage obligaciones
* @author Alejandro Daza
* @version 2020.01
* @copyright apdaza
*/

	//no permite el acceso directo
	defined('_VALID_PRY') or die('Restricted access');
	$obiData 		= new CObligacionInterventoriaData($db);
	$operador       = $_REQUEST['operador'];
	$perfil 		= $du->getUserPerfil($id_usuario);
	$task 			= $_REQUEST['task'];
	if(empty($task)) $task = 'list';

	switch($task){
		/**
		* la variable list, permite hacer la carga la página con la lista de objetos OBLIGACION según los parámetros de entrada
		*/
		case 'list':

			$componente 	= $_REQUEST['sel_componente'];
			$clausula 		= $_REQUEST['sel_clausula'];
			$palabra_clave 	= $_REQUEST['txt_palabra_clave'];

			$criterio='';
			if(isset($componente) && $componente!=-1 && $componente!=''){
				if($criterio==""){
					$criterio = " oco.oco_id = ".$componente;
				}else{
					$criterio .= " and oco.oco_id = ".$componente;
				}
			}
			if(isset($clausula) && $clausula!=-1 && $clausula!=''){
				if($criterio==""){
					$criterio = " obc.obc_id = ".$clausula;
				}else{
					$criterio .= " and obc.obc_id = ".$clausula;
				}
			}
			if(isset($palabra_clave) && $palabra_clave!=''){
				if($criterio==""){
					$criterio = " (obi.obi_literal  like '%".$palabra_clave."%' || obi.obi_descripcion like '%".$palabra_clave."%' )";
				}else{
					$criterio .= " and (obi.obi_literal like  '%".$palabra_clave."%' || obi.obi_descripcion like '%".$palabra_clave."%')";
				}
			}
			$form = new CHtmlForm();
			$form->setId('frm_list');
			$form->setMethod('post');
			$form->setTitle(OBLIGACION_TITULO);
			$form->setClassEtiquetas('td_label');

			$componentes = $obiData->getComponentes('1','oco_nombre');
			$opciones=null;
			foreach($componentes as $s){
				$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
			}

			$form->addEtiqueta(OBLIGACION_COMPONENTE);
			$form->addSelect('select','sel_componente','sel_componente',$opciones,OBLIGACION_COMPONENTE,$componente,'','onChange=submit();');

			$clausulas = $obiData->getClausulas('1','obc_nombre');

			$opciones=null;
			foreach($clausulas as $t){
				$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
			}
			$form->addEtiqueta(OBLIGACION_CLAUSULA);
			$form->addSelect('select','sel_clausula','sel_clausula',$opciones,OBLIGACION_CLAUSULA,$clausula,'','onChange=submit();');

			$form->addEtiqueta(OBLIGACION_CLAVE);
			$form->addInputText('text','txt_palabra_clave','txt_palabra_clave','50','50',$palabra_clave,'','onChange=submit();');

			//echo("<br>criterio:".$criterio);

			$form->writeForm();

			$obligaciones = $obiData->getObligaciones($criterio,' oco.oco_nombre, obc.obc_nombre');

			$dt = new CHtmlDataTable();
			$titulos = array(OBLIGACION_COMPONENTE,OBLIGACION_CLAUSULA,OBLIGACION_LITERAL,OBLIGACION_DESCRIPCION);
			$dt->setDataRows($obligaciones);
			$dt->setTitleRow($titulos);

			$dt->setTitleTable(OBLIGACION_SUBTITULO);

			if($perfil==PERFIL_ADMIN || $perfil==PERFIL_ANALISTA || $perfil==PERFIL_ANALISTA_SENIOR){
				$dt->setEditLink("?mod=".$modulo."&niv=".$niv."&task=edit&sel_clausula=".$clausula."&sel_componente=".$componente."&operador=".$operador);
				$dt->setDeleteLink("?mod=".$modulo."&niv=".$niv."&task=delete&sel_clausula=".$clausula."&sel_componente=".$componente."&operador=".$operador);

				$dt->setAddLink("?mod=".$modulo."&niv=".$niv."&task=add&sel_clausula=".$clausula."&sel_componente=".$componente."&operador=".$operador);
			}

			$dt->setType(1);
			$pag_crit="?mod=".$modulo."&niv=".$niv."&sel_clausula=".$clausula."&sel_componente=".$componente."&operador=".$operador;
			$dt->setPag(1,$pag_crit);
			$dt->writeDataTable($niv);
			$tabla = new CHtmlTable();

		break;
		/**
		* la variable add, permite hacer la carga la página con las variables que componen el objeto OBLIGACION, ver la clase CObligacion
		*/
		case 'add':
			$componente 	= $_REQUEST['sel_componente'];
			$clausula 		= $_REQUEST['sel_clausula'];
			$operador		= $_REQUEST['operador'];

			$componente_add	= $_REQUEST['sel_componente_add'];
			$clausula_add 	= $_REQUEST['sel_clausula_add'];

			$form 			= new CHtmlForm();
			$form->setTitle(AGREGAR_OBLIGACION);
			$form->setId('frm_add_obligacion_interventoria');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$componentes = $obiData->getComponentes('1','oco_nombre');
			$opciones=null;
			foreach($componentes as $s){
				$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
			}

			$form->addEtiqueta(OBLIGACION_COMPONENTE);
			$form->addSelect('select','sel_componente_add','sel_componente_add',$opciones,OBLIGACION_COMPONENTE,$componente_add,'','onkeypress="ocultarDiv(\'error_componente\');"');
			$form->addError('error_componente',ERROR_OBLIGACION_COMPONENTE);

			$clausulas = $obiData->getClausulas('1','obc_nombre');

			$opciones=null;
			foreach($clausulas as $t){
				$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
			}
			$form->addEtiqueta(OBLIGACION_CLAUSULA);
			$form->addSelect('select','sel_clausula_add','sel_clausula_add',$opciones,OBLIGACION_CLAUSULA,$clausula_add,'','onkeypress="ocultarDiv(\'error_clausula\');"');
			$form->addError('error_clausula',ERROR_OBLIGACION_CLAUSULA);

			$form->addEtiqueta(OBLIGACION_LITERAL);
			$form->addInputText('text','txt_literal_add','txt_literal_add','150','150',$literal_add,'','onkeypress="ocultarDiv(\'error_literal\');"');
			$form->addError('error_literal',ERROR_OBLIGACION_LITERAL);

			$form->addEtiqueta(OBLIGACION_DESCRIPCION);
			$form->addTextArea('textarea','txt_descripcion_add','txt_descripcion_add','65','5',$descripcion_add,'','onkeypress="ocultarDiv(\'error_descripcion\');"');
			$form->addError('error_descripcion',ERROR_OBLIGACION_DESCRIPCION);

			$form->addInputText('hidden','sel_componente','sel_componente','15','15',$componente,'','');
			$form->addInputText('hidden','sel_clausula','sel_clausula','15','15',$clausula,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');

			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_add_obligacion_interventoria();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_add_obligacion_interventoria\',\'?mod='.$modulo.'&niv='.$niv.'&sel_clausula='.$clausula.'&sel_componente='.$componente.'&operador='.$operador.'\');"');

			$form->writeForm();

		break;
		/**
		* la variable saveAdd, permite almacenar el objeto OBLIGACION en la base de datos, ver la clase CObligacionInterventoriaData
		*/
		case 'saveAdd':
			$componente 	= $_REQUEST['sel_componente'];
			$clausula 		= $_REQUEST['sel_clausula'];
			$operador		= $_REQUEST['operador'];

			$componente_add = $_REQUEST['sel_componente_add'];
			$clausula_add	= $_REQUEST['sel_clausula_add'];
			$literal_add	= $_REQUEST['txt_literal_add'];
			$descripcion_add= $_REQUEST['txt_descripcion_add'];

			$obligaciones = new CObligacionInterventoria('',$componente_add,$clausula_add,$literal_add,$descripcion_add,$obiData);
			$m = $obligaciones->saveNewObligacion();

			echo $html->generaAviso($m,"?mod=".$modulo."&niv=1&task=list&sel_clausula=".$clausula."&sel_componente=".$componente."&operador=".$operador);

		break;
		/**
		* la variable delete, permite hacer la carga del objeto OBLIGACION y espera confirmacion de eliminarlo, ver la clase CObligacion
		*/
		case 'delete':
			$id_delete 		= $_REQUEST['id_element'];
			$componente 	= $_REQUEST['sel_componente'];
			$clausula 		= $_REQUEST['sel_clausula'];
			$operador		= $_REQUEST['operador'];

			$form = new CHtmlForm();
			$form->setId('frm_delete');
			$form->setMethod('post');
			$form->addInputText('hidden','sel_componente','sel_componente','15','15',$componente,'','');
			$form->addInputText('hidden','sel_clausula','sel_clausula','15','15',$clausula,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			$form->writeForm();

			echo $html->generaAdvertencia(OBLIGACION_MSG_BORRADO,'?mod='.$modulo.'&niv=1&task=confirmDelete&id_element='.$id_delete.'&sel_clausula='.$clausula.'&sel_componente='.$componente.'&operador='.$operador,"cancelarAccion('frm_delete','?mod=".$modulo."&niv=1&sel_clausula=".$clausula."&sel_componente=".$componente."&operador=".$operador."')");

		break;
		/**
		* la variable confirmDelete, permite eliminar el objeto OBLIGACION de la base de datos, ver la clase CObligacionInterventoriaData
		*/
		case 'confirmDelete':
			$id_delete 		= $_REQUEST['id_element'];
			$componente 	= $_REQUEST['sel_componente'];
			$clausula 		= $_REQUEST['sel_clausula'];
			$operador		= $_REQUEST['operador'];

			$obligaciones = new CObligacionInterventoria($id_delete,'','','','',$obiData);
			$m = $obligaciones->deleteObligacion();

			echo $html->generaAviso($m,'?mod='.$modulo.'&niv=1&task=list&sel_clausula='.$clausula.'&sel_componente='.$componente.'&operador='.$operador);

		break;
		/**
		* la variable edit, permite hacer la carga del objeto OBLIGACION y espera confirmacion de edicion, ver la clase CObligacion
		*/
		case 'edit':
			$id_edit 		= $_REQUEST['id_element'];
			$componente 	= $_REQUEST['sel_componente'];
			$clausula 		= $_REQUEST['sel_clausula'];
			$operador		= $_REQUEST['operador'];

			$componente_edit 	= $_REQUEST['sel_componente_edit'];
			$clausula_edit		= $_REQUEST['sel_clausula_edit'];
			$literal_edit		= $_REQUEST['txt_literal_edit'];
			$descripcion_edit	= $_REQUEST['txt_descripcion_edit'];

			$obligaciones = new CObligacionInterventoria($id_edit,'','','','',$obiData);

			$obligaciones->loadObligacion();

			if(!isset($_REQUEST['sel_componente_edit'])  || $componente_edit==-1)  $componente_edit  = $obligaciones->getComponente();  else $componente_edit  = $_REQUEST['sel_componente_edit'];
			if(!isset($_REQUEST['sel_clausula_edit'])    || $clausula_edit==-1)    $clausula_edit    = $obligaciones->getClausula();    else $clausula_edit    = $_REQUEST['sel_clausula_edit'];
			if(!isset($_REQUEST['txt_literal_edit'])     || $literal_edit=="")     $literal_edit     = $obligaciones->getLiteral();     else $literal_edit     = $_REQUEST['txt_literal_edit'];
			if(!isset($_REQUEST['txt_descripcion_edit']) || $descripcion_edit=="") $descripcion_edit = $obligaciones->getDescripcion(); else $descripcion_edit = $_REQUEST['txt_descripcion_edit'];

			$form = new CHtmlForm();

			$form->setTitle(EDITAR_OBLIGACION);
			$form->setId('frm_edit_obligacion_interventoria');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$componentes = $obiData->getComponentes('1','oco_nombre');
			$opciones=null;
			foreach($componentes as $s){
				$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
			}

			$form->addEtiqueta(OBLIGACION_COMPONENTE);
			$form->addSelect('select','sel_componente_edit','sel_componente_edit',$opciones,OBLIGACION_COMPONENTE,$componente_edit,'','onkeypress="ocultarDiv(\'error_componente\');"');
			$form->addError('error_componente',ERROR_OBLIGACION_COMPONENTE);

			$clausulas = $obiData->getClausulas('1','obc_nombre');

			$opciones=null;
			foreach($clausulas as $t){
				$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
			}
			$form->addEtiqueta(OBLIGACION_CLAUSULA);
			$form->addSelect('select','sel_clausula_edit','sel_clausula_edit',$opciones,OBLIGACION_CLAUSULA,$clausula_edit,'','onkeypress="ocultarDiv(\'error_clausula\');"');
			$form->addError('error_clausula',ERROR_OBLIGACION_CLAUSULA);

			$form->addEtiqueta(OBLIGACION_LITERAL);
			$form->addInputText('text','txt_literal_edit','txt_literal_edit','150','150',$literal_edit,'','onkeypress="ocultarDiv(\'error_literal\');"');
			$form->addError('error_literal',ERROR_OBLIGACION_LITERAL);

			$form->addEtiqueta(OBLIGACION_DESCRIPCION);
			$form->addTextArea('textarea','txt_descripcion_edit','txt_descripcion_edit','65','5',$descripcion_edit,'','onkeypress="ocultarDiv(\'error_descripcion\');"');
			$form->addError('error_descripcion',ERROR_OBLIGACION_DESCRIPCION);

			$form->addInputText('hidden','sel_componente','sel_componente','15','15',$componente,'','');
			$form->addInputText('hidden','sel_clausula','sel_clausula','15','15',$clausula,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			$form->addInputText('hidden','id_element','id_element','15','15',$id_edit,'','');

			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_edit_obligacion_interventoria();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_edit_obligacion_interventoria\',\'?mod='.$modulo.'&niv='.$niv.'&sel_clausula='.$clausula.'&sel_componente='.$componente.'&operador='.$operador.'\');"');

			$form->writeForm();

		break;
		/**
		* la variable saveEdit, permite actualizar el objeto OBLIGACION en la base de datos, ver la clase CObligacionInterventoriaData
		*/
		case 'saveEdit':
			$id_edit 		= $_REQUEST['id_element'];
			$componente 	= $_REQUEST['sel_componente'];
			$clausula 		= $_REQUEST['sel_clausula'];
			$operador		= $_REQUEST['operador'];

			$componente_edit 	= $_REQUEST['sel_componente_edit'];
			$clausula_edit		= $_REQUEST['sel_clausula_edit'];
			$literal_edit		= $_REQUEST['txt_literal_edit'];
			$descripcion_edit	= $_REQUEST['txt_descripcion_edit'];

			$obligaciones = new CObligacionInterventoria($id_edit,$componente_edit,$clausula_edit,$literal_edit,$descripcion_edit,$obiData);

			$m = $obligaciones->saveEditObligacion();
			echo $html->generaAviso($m,'?mod='.$modulo.'&niv=1&task=list&sel_clausula='.$clausula.'&sel_componente='.$componente.'&operador='.$operador);

		break;

		/**
		* en caso de que la variable task no este definida carga la página en construcción
		*/
		default:
			include('templates/html/under.html');

		break;
	}
?>
