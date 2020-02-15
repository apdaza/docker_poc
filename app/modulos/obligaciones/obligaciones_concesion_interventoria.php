<?php
/**
* Sistema POC
*
*<ul>
* <li> MadeOpen <madeopensoftware.com></li>
* <li> Proyecto KBT </li>
*</ul>
*/

/**
* Modulo obligaciones_concesion
* maneja el modulo OBLIGACIONES en union con CObligacion y CObligacionConcIntData
*
* @see CObligacion
* @see CObligacionConcIntData
*
* @package  modulos
* @subpackage obligaciones
* @author Alejandro Daza
* @version 2019.02
* @copyright apdaza
*/

	//no permite el acceso directo
	defined('_VALID_PRY') or die('Restricted access');
	$ocsData 		= new CObligacionConcIntData($db);
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
					$criterio = " (ocs.ocs_literal  like '%".$palabra_clave."%' || ocs.ocs_descripcion like '%".$palabra_clave."%' ||
								   ocs.ocs_criterio like '%".$palabra_clave."%' )";
				}else{
					$criterio .= " and (ocs.ocs_literal like  '%".$palabra_clave."%' || ocs.ocs_descripcion like '%".$palabra_clave."%' ||
					                    ocs.ocs_criterio like '%".$palabra_clave."%' )";
				}
			}

			$form = new CHtmlForm();
			$form->setId('frm_list');
			$form->setMethod('post');
			$form->setTitle(OBLIGACION_TITULO_CONCESION_INTERVENTORIA);
			$form->setClassEtiquetas('td_label');

			$componentes = $ocsData->getComponentes('1','oco_nombre');
			$opciones=null;
			foreach($componentes as $s){
				$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
			}

			$form->addEtiqueta(OBLIGACION_COMPONENTE);
			$form->addSelect('select','sel_componente','sel_componente',$opciones,OBLIGACION_COMPONENTE,$componente,'','onChange=submit();');

			$clausulas = $ocsData->getClausulas('1','obc_nombre');

			$opciones=null;
			foreach($clausulas as $t){
				$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
			}
			$form->addEtiqueta(OBLIGACION_CLAUSULA);
			$form->addSelect('select','sel_clausula','sel_clausula',$opciones,OBLIGACION_CLAUSULA,$clausula,'','onChange=submit();');

			$form->addEtiqueta(OBLIGACION_CLAVE);
			$form->addInputText('text','txt_palabra_clave','txt_palabra_clave','50','50',$palabra_clave,'','onChange=submit();');

			$form->writeForm();

			//echo("<br>criterio:".$criterio);

			$dt = new CHtmlDataTable();
			$obligaciones = $ocsData->getObligaciones($criterio);
			$titulos = array(OBLIGACION_COMPONENTE,OBLIGACION_CLAUSULA,OBLIGACION_CONCESION,OBLIGACION_INTERVENTORIA);
			$dt->setDataRows($obligaciones);
			$dt->setTitleRow($titulos);

			$dt->setTitleTable(OBLIGACION_SUBTITULO_CONCESION_INTERVENTORIA);

			if($perfil==PERFIL_ADMIN || $perfil==PERFIL_ANALISTA || $perfil==PERFIL_ANALISTA_SENIOR || $perfil==PERFIL_ANALISTA_FINANCIERO){
				$dt->setDeleteLink("?mod=".$modulo."&niv=".$niv."&task=delete&sel_clausula=".$clausula."&sel_componente=".$componente."&txt_palabra_clave=".$palabra_clave);

				$dt->setAddLink("?mod=".$modulo."&niv=".$niv."&task=add&sel_clausula=".$clausula."&sel_componente=".$componente."&txt_palabra_clave=".$palabra_clave);
			}

			$dt->setType(1);
			$pag_crit="?mod=".$modulo."&niv=".$niv."&sel_clausula=".$clausula."&sel_componente=".$componente."&txt_palabra_clave=".$palabra_clave;
			$dt->setPag(1,$pag_crit);
			$dt->writeDataTable($niv);
			$tabla = new CHtmlTable();

		break;
		/**
		* la variable add, permite hacer la carga la página con las variables que componen el objeto OBLIGACION, ver la clase CObligacion
		*/
		case 'add':
			$componente 		= $_REQUEST['sel_componente'];
			$clausula 			= $_REQUEST['sel_clausula'];

			$obligacion_conc_add= $_REQUEST['sel_obligacion_conc_add'];
			$obligacion_int_add	= $_REQUEST['sel_obligacion_int_add'];

			$form 			= new CHtmlForm();
			$form->setTitle(AGREGAR_OBLIGACION_CONCESION);
			$form->setId('frm_add_oblig_conc_int');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$componentes = $ocsData->getComponentes('1','oco_nombre');
			$opciones=null;
			foreach($componentes as $s){
				$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
			}

			$form->addEtiqueta(OBLIGACION_COMPONENTE);
			$form->addSelect('select','sel_componente','sel_componente',$opciones,OBLIGACION_COMPONENTE,$componente,'','onChange=submit();onkeypress="ocultarDiv(\'error_componente\');"');
			$form->addError('error_componente',ERROR_OBLIGACION_COMPONENTE);

			$clausulas = $ocsData->getClausulas('1','obc_nombre');

			$opciones=null;
			foreach($clausulas as $t){
				$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
			}
			$form->addEtiqueta(OBLIGACION_CLAUSULA);
			$form->addSelect('select','sel_clausula','sel_clausula',$opciones,OBLIGACION_CLAUSULA,$clausula,'','onChange=submit();onkeypress="ocultarDiv(\'error_clausula\');"');
			$form->addError('error_clausula',ERROR_OBLIGACION_CLAUSULA);

			$literales = $ocsData->getLiterales("obc_id=".$clausula." and oco_id=".$componente,"ocs_literal");

			$opciones=null;
			foreach($literales as $t){
				$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
			}

			$form->addEtiqueta(OBLIGACION_LITERAL);
			$form->addSelect('select','sel_obligacion_conc_add','sel_obligacion_conc_add',$opciones,OBLIGACION_LITERAL,$obligacion_conc_add,'','onkeypress="ocultarDiv(\'error_literal\');"');
			$form->addError('error_literal',ERROR_OBLIGACION_LITERAL);

			$obligaciones_int = $ocsData->getObligacionesInterventoria('1','obi_literal');
			$opciones=null;
			foreach($obligaciones_int as $s){
				$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
			}

			$form->addEtiqueta(OBLIGACION_INTERVENTORIA);
			$form->addSelect('select','sel_obligacion_int_add','sel_obligacion_int_add',$opciones,OBLIGACION_INTERVENTORIA,$obligacion_int_add,'','onkeypress="ocultarDiv(\'error_obligacion_int\');"');
			$form->addError('error_obligacion_int',ERROR_OBLIGACION_INTERVENTORIA);

			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_add_obligacion_concesion_interventoria();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_add_oblig_conc_int\',\'?mod='.$modulo.'&niv='.$niv.'&sel_clausula='.$clausula.'&sel_componente='.$componente.'&txt_palabra_clave='.$palabra_clave.'&txt_palabra_clave='.$palabra_clave.'\');"');

			$form->writeForm();

		break;
		/**
		* la variable saveAdd, permite almacenar el objeto OBLIGACION en la base de datos, ver la clase CObligacionConcIntData
		*/
		case 'saveAdd':
			$componente 		= $_REQUEST['sel_componente'];
			$clausula 			= $_REQUEST['sel_clausula'];

			$obligacion_conc_add= $_REQUEST['sel_obligacion_conc_add'];
			$obligacion_int_add	= $_REQUEST['sel_obligacion_int_add'];

			$obligaciones = new CObligacionConcInt('',$obligacion_conc_add,$obligacion_int_add,$ocsData);
			$m = $obligaciones->saveNewObligacionConcInt();

			echo $html->generaAviso($m,"?mod=".$modulo."&niv=1&task=list&sel_clausula=".$clausula."&sel_componente=".$componente."&txt_palabra_clave=".$palabra_clave);

		break;
		/**
		* la variable delete, permite hacer la carga del objeto OBLIGACION y espera confirmacion de eliminarlo, ver la clase CObligacion
		*/
		case 'delete':
			$id_delete 		= $_REQUEST['id_element'];
			$componente 	= $_REQUEST['sel_componente'];
			$clausula 		= $_REQUEST['sel_clausula'];


			$form = new CHtmlForm();
			$form->setId('frm_delete');
			$form->setMethod('post');
			$form->addInputText('hidden','sel_componente','sel_componente','15','15',$componente,'','');
			$form->addInputText('hidden','sel_clausula','sel_clausula','15','15',$clausula,'','');
			$form->writeForm();

			echo $html->generaAdvertencia(OBLIGACION_MSG_BORRADO,'?mod='.$modulo.'&niv=1&task=confirmDelete&id_element='.$id_delete.'&sel_clausula='.$clausula.'&sel_componente='.$componente.'&txt_palabra_clave='.$palabra_clave,"cancelarAccion('frm_delete','?mod=".$modulo."&niv=1&sel_clausula=".$clausula."&sel_componente=".$componente."&txt_palabra_clave=".$palabra_clave."&txt_palabra_clave=".$palabra_clave."')");

		break;
		/**
		* la variable confirmDelete, permite eliminar el objeto OBLIGACION de la base de datos, ver la clase CObligacionConcIntData
		*/
		case 'confirmDelete':
			$id_delete 		= $_REQUEST['id_element'];
			$componente 	= $_REQUEST['sel_componente'];
			$clausula 		= $_REQUEST['sel_clausula'];
			$palabra_clave 	= $_REQUEST['txt_palabra_clave'];
			$anio	 		= $_REQUEST['sel_anio'];
			$operador		= $_REQUEST['operador'];

			$obligaciones = new CObligacionConcInt($id_delete,'','',$ocsData);
			$m = $obligaciones->deleteObligacionConcInt();

			echo $html->generaAviso($m,'?mod='.$modulo.'&niv=1&task=list&sel_clausula='.$clausula.'&sel_componente='.$componente.'&txt_palabra_clave='.$palabra_clave);

		break;
		/**
		* en caso de que la variable task no este definida carga la página en construcción
		*/
		default:
			include('templates/html/under.html');

		break;
	}
?>
