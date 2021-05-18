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
* Modulo obligaciones_concesion
* maneja el modulo OBLIGACIONES en union con CObligacion y CObligacionConcesionData
*
* @see CObligacion
* @see CObligacionConcesionData
*
* @package  modulos
* @subpackage obligaciones
* @author Alejandro Daza
* @version 2020.01
* @copyright apdaza
*/

	//no permite el acceso directo
	defined('_VALID_PRY') or die('Restricted access');
	$ocsData 		= new CObligacionConcesionData($db);
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
			$periodicidad 	= $_REQUEST['sel_periodicidad'];
			$palabra_clave 	= $_REQUEST['txt_palabra_clave'];
			$anio 			= $_REQUEST['sel_anio'];

			$criterio='';
			if(isset($componente) && $componente!=-1 && $componente!=''){
				if($criterio==""){
					$criterio = " oco.oco_id = ".$componente;
				}else{
					$criterio .= " and oco.oco_id = ".$componente;
				}
			}
			if(isset($periodicidad) && $periodicidad!=-1 && $periodicidad!=''){
				if($criterio==""){
					$criterio = " obp.obp_id = ".$periodicidad;
				}else{
					$criterio .= " and obp.obp_id = ".$periodicidad;
				}
			}
			if(isset($palabra_clave) && $palabra_clave!=''){
				if($criterio==""){
					$criterio = " (ocs.ocs_literal  like '%".$palabra_clave."%' || ocs.ocs_descripcion like '%".$palabra_clave."%' ||
								   ocs.ocs_criterio like '%".$palabra_clave."%' || obp.obp_nombre like '%".$palabra_clave."%')";
				}else{
					$criterio .= " and (ocs.ocs_literal like  '%".$palabra_clave."%' || ocs.ocs_descripcion like '%".$palabra_clave."%' ||
					                    ocs.ocs_criterio like '%".$palabra_clave."%' || obp.obp_nombre like '%".$palabra_clave."%')";
				}
			}

			$form = new CHtmlForm();
			$form->setId('frm_list');
			$form->setMethod('post');
			$form->setTitle(OBLIGACION_TITULO_CONCESION);
			$form->setClassEtiquetas('td_label');

			$componentes = $ocsData->getComponentes('1','oco_nombre');
			$opciones=null;
			foreach($componentes as $s){
				$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
			}

			$form->addEtiqueta(OBLIGACION_COMPONENTE);
			$form->addSelect('select','sel_componente','sel_componente',$opciones,OBLIGACION_COMPONENTE,$componente,'','onChange=submit();');

			$periodicidades = $ocsData->getPeriodicidades('1','obp_nombre');

			$opciones=null;
			foreach($periodicidades as $t){
				$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
			}
			$form->addEtiqueta(OBLIGACION_PERIODICIDAD);
			$form->addSelect('select','sel_periodicidad','sel_periodicidad',$opciones,OBLIGACION_PERIODICIDAD,$periodicidad,'','onChange=submit();');

			$anios = $ocsData->getAniosObligacion('1','oct_anio');

			$opciones=null;
			foreach($anios as $t){
				$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
			}
			$form->addEtiqueta(OBLIGACION_ANIO);
			$form->addSelect('select','sel_anio','sel_anio',$opciones,OBLIGACION_ANIO,$anio,'','onChange=submit();');

			$form->addEtiqueta(OBLIGACION_CLAVE);
			$form->addInputText('text','txt_palabra_clave','txt_palabra_clave','50','50',$palabra_clave,'','onChange=submit();');

			$form->writeForm();

			//echo("<br>criterio:".$criterio);

			if ($componente!=-1 || $anio!=-1 || $periodicidad!=-1){
				$obligaciones = $ocsData->getObligaciones($criterio,' oco.oco_nombre, obp.obp_nombre',$anio);
			}
			elseif (($componente!=-1|| $componente=="") && ($anio==-1 || $anio=="") || $palabra_clave!=""){
				$anio = date("Y");
				$obligaciones = $ocsData->getObligaciones($criterio,' oco.oco_nombre, obp.obp_nombre',$anio);
			}
			$dt = new CHtmlDataTable();
			if($anio==2014)
				$titulos = array(OBLIGACION_COMPONENTE,OBLIGACION_LITERAL,OBLIGACION_DESCRIPCION,
							OBLIGACION_INTERVENTORIA,OBLIGACION_PERIODICIDAD,OBLIGACION_CRITERIO,
							'Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
			else
				$titulos = array(OBLIGACION_COMPONENTE,OBLIGACION_LITERAL,OBLIGACION_DESCRIPCION,
							OBLIGACION_INTERVENTORIA,OBLIGACION_PERIODICIDAD,OBLIGACION_CRITERIO,
							'Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
			$dt->setDataRows($obligaciones);
			$dt->setTitleRow($titulos);

			$dt->setTitleTable(OBLIGACION_SUBTITULO_CONCESION);

			if($perfil==PERFIL_ADMIN || $perfil==PERFIL_ANALISTA || $perfil==PERFIL_ANALISTA_SENIOR || $perfil==PERFIL_ANALISTA_FINANCIERO){
				$dt->setEditLink("?mod=".$modulo."&niv=".$niv."&task=edit&sel_periodicidad=".$periodicidad."&sel_componente=".$componente."&txt_palabra_clave=".$palabra_clave."&sel_anio=".$anio);
				$dt->setDeleteLink("?mod=".$modulo."&niv=".$niv."&task=delete&sel_periodicidad=".$periodicidad."&sel_componente=".$componente."&txt_palabra_clave=".$palabra_clave."&sel_anio=".$anio);

				$dt->setAddLink("?mod=".$modulo."&niv=".$niv."&task=add&sel_periodicidad=".$periodicidad."&sel_componente=".$componente."&txt_palabra_clave=".$palabra_clave."&sel_anio=".$anio);
			}
			$otros = array('link'=>"?mod=".$modulo."&niv=".$niv."&task=listTrazabilidad&sel_periodicidad=".$periodicidad."&sel_componente=".$componente."&txt_palabra_clave=".$palabra_clave."&sel_anio=".$anio,'img'=>'soportes.gif','alt'=>ALT_VISITASS);
			$dt->addOtrosLink($otros);

			$dt->setType(1);
			$pag_crit="?mod=".$modulo."&niv=".$niv."&sel_periodicidad=".$periodicidad."&sel_componente=".$componente."&txt_palabra_clave=".$palabra_clave."&sel_anio=".$anio;
			$dt->setPag(1,$pag_crit);
			$dt->writeDataTable($niv);
			$tabla = new CHtmlTable();

		break;
		/**
		* la variable add, permite hacer la carga la página con las variables que componen el objeto OBLIGACION, ver la clase CObligacion
		*/
		case 'add':
			$componente 		= $_REQUEST['sel_componente'];
			$periodicidad 		= $_REQUEST['sel_periodicidad'];
			$palabra_clave 		= $_REQUEST['txt_palabra_clave'];
			$anio	 			= $_REQUEST['sel_anio'];
			$operador			= $_REQUEST['operador'];

			$componente_add		= $_REQUEST['sel_componente_add'];
			$clausula_add 		= $_REQUEST['sel_clausula_add'];
			$literal_add		= $_REQUEST['txt_literal_add'];
			$descripcion_add	= $_REQUEST['txt_descripcion_add'];
			$obligacion_int_add	= $_REQUEST['sel_obligacion_int_add'];
			$periodicidad_add	= $_REQUEST['sel_periodicidad_add'];
			$criterio_add		= $_REQUEST['txt_criterio_add'];

			$form 			= new CHtmlForm();
			$form->setTitle(AGREGAR_OBLIGACION_CONCESION);
			$form->setId('frm_add_obligacion_concesion');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$componentes = $ocsData->getComponentes('1','oco_nombre');
			$opciones=null;
			foreach($componentes as $s){
				$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
			}

			$form->addEtiqueta(OBLIGACION_COMPONENTE);
			$form->addSelect('select','sel_componente_add','sel_componente_add',$opciones,OBLIGACION_COMPONENTE,$componente_add,'','onkeypress="ocultarDiv(\'error_componente\');"');
			$form->addError('error_componente',ERROR_OBLIGACION_COMPONENTE);

			$periodicidades = $ocsData->getClausulas('1','obc_nombre');

			$opciones=null;
			foreach($periodicidades as $t){
				$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
			}
			$form->addEtiqueta(OBLIGACION_CLAUSULA);
			$form->addSelect('select','sel_clausula_add','sel_clausula_add',$opciones,OBLIGACION_CLAUSULA,$clausula_add,'','onkeypress="ocultarDiv(\'error_clausula\');"');
			$form->addError('error_clausula',ERROR_OBLIGACION_CLAUSULA);

			$form->addEtiqueta(OBLIGACION_LITERAL);
			$form->addInputText('text','txt_literal_add','txt_literal_add','50','50',$literal_add,'','onkeypress="ocultarDiv(\'error_literal\');"');
			$form->addError('error_literal',ERROR_OBLIGACION_LITERAL);

			$form->addEtiqueta(OBLIGACION_DESCRIPCION);
			$form->addTextArea('textarea','txt_descripcion_add','txt_descripcion_add','65','5',$descripcion_add,'','onkeypress="ocultarDiv(\'error_descripcion\');"');
			$form->addError('error_descripcion',ERROR_OBLIGACION_DESCRIPCION);

			/*$obligaciones_int = $ocsData->getObligacionesInterventoria('1','obi_literal');
			$opciones=null;
			foreach($obligaciones_int as $s){
				$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
			}

			$form->addEtiqueta(OBLIGACION_INTERVENTORIA);
			$form->addSelect('select','sel_obligacion_int_add','sel_obligacion_int_add',$opciones,OBLIGACION_INTERVENTORIA,$obligacion_int_add,'','onkeypress="ocultarDiv(\'error_obligacion_int\');"');
			$form->addError('error_obligacion_int',ERROR_OBLIGACION_INTERVENTORIA);
			*/
			$periodicidades = $ocsData->getPeriodicidades('1','obp_nombre');
			$opciones=null;
			foreach($periodicidades as $s){
				$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
			}

			$form->addEtiqueta(OBLIGACION_PERIODICIDAD);
			$form->addSelect('select','sel_periodicidad_add','sel_periodicidad_add',$opciones,OBLIGACION_PERIODICIDAD,$periodicidad_add,'','onkeypress="ocultarDiv(\'error_periodicidad\');"');
			$form->addError('error_periodicidad',ERROR_OBLIGACION_PERIODICIDAD);

			$form->addEtiqueta(OBLIGACION_CRITERIO);
			$form->addTextArea('textarea','txt_criterio_add','txt_criterio_add','65','5',$criterio_add,'','onkeypress="ocultarDiv(\'error_criterio\');"');
			$form->addError('error_criterio',ERROR_OBLIGACION_CRITERIO);

			$form->addInputText('hidden','sel_componente','sel_componente','15','15',$componente,'','');
			$form->addInputText('hidden','sel_periodicidad','sel_periodicidad','15','15',$periodicidad,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			$form->addInputText('hidden','sel_anio','sel_anio','15','15',$anio,'','');
			$form->addInputText('hidden','txt_palabra_clave','txt_palabra_clave','15','15',$palabra_clave,'','');

			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_add_obligacion_concesion();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_add_obligacion_concesion\',\'?mod='.$modulo.'&niv='.$niv.'&sel_periodicidad='.$periodicidad.'&sel_componente='.$componente.'&txt_palabra_clave='.$palabra_clave.'&sel_anio='.$anio.'\');"');

			$form->writeForm();

		break;
		/**
		* la variable saveAdd, permite almacenar el objeto OBLIGACION en la base de datos, ver la clase CObligacionConcesionData
		*/
		case 'saveAdd':
			$componente 		= $_REQUEST['sel_componente'];
			$periodicidad 		= $_REQUEST['sel_periodicidad'];
			$palabra_clave 		= $_REQUEST['txt_palabra_clave'];
			$anio	 			= $_REQUEST['sel_anio'];
			$operador			= $_REQUEST['operador'];

			$componente_add		= $_REQUEST['sel_componente_add'];
			$clausula_add 		= $_REQUEST['sel_clausula_add'];
			$literal_add		= $_REQUEST['txt_literal_add'];
			$descripcion_add	= $_REQUEST['txt_descripcion_add'];
			//$obligacion_int_add	= $_REQUEST['sel_obligacion_int_add'];
			$periodicidad_add	= $_REQUEST['sel_periodicidad_add'];
			$criterio_add		= $_REQUEST['txt_criterio_add'];

			$obligaciones = new CObligacionConcesion('',$componente_add,$clausula_add,$literal_add,$descripcion_add,$periodicidad_add,$criterio_add,$ocsData);
			$m = $obligaciones->saveNewObligacion();

			echo $html->generaAviso($m,"?mod=".$modulo."&niv=1&task=list&sel_periodicidad=".$periodicidad."&sel_componente=".$componente."&txt_palabra_clave=".$palabra_clave."&sel_anio=".$anio);

		break;
		/**
		* la variable delete, permite hacer la carga del objeto OBLIGACION y espera confirmacion de eliminarlo, ver la clase CObligacion
		*/
		case 'delete':
			$id_delete 		= $_REQUEST['id_element'];
			$componente 	= $_REQUEST['sel_componente'];
			$periodicidad 		= $_REQUEST['sel_periodicidad'];
			$palabra_clave 	= $_REQUEST['txt_palabra_clave'];
			$anio	 		= $_REQUEST['sel_anio'];
			$operador		= $_REQUEST['operador'];

			$form = new CHtmlForm();
			$form->setId('frm_delete');
			$form->setMethod('post');
			$form->addInputText('hidden','sel_componente','sel_componente','15','15',$componente,'','');
			$form->addInputText('hidden','sel_periodicidad','sel_periodicidad','15','15',$periodicidad,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			$form->addInputText('hidden','sel_anio','sel_anio','15','15',$anio,'','');
			$form->addInputText('hidden','txt_palabra_clave','txt_palabra_clave','15','15',$palabra_clave,'','');
			$form->writeForm();

			echo $html->generaAdvertencia(OBLIGACION_MSG_BORRADO,'?mod='.$modulo.'&niv=1&task=confirmDelete&id_element='.$id_delete.'&sel_periodicidad='.$periodicidad.'&sel_componente='.$componente.'&txt_palabra_clave='.$palabra_clave.'&sel_anio='.$anio,"cancelarAccion('frm_delete','?mod=".$modulo."&niv=1&sel_periodicidad=".$periodicidad."&sel_componente=".$componente."&txt_palabra_clave=".$palabra_clave."&sel_anio=".$anio."')");

		break;
		/**
		* la variable confirmDelete, permite eliminar el objeto OBLIGACION de la base de datos, ver la clase CObligacionConcesionData
		*/
		case 'confirmDelete':
			$id_delete 		= $_REQUEST['id_element'];
			$componente 	= $_REQUEST['sel_componente'];
			$periodicidad 	= $_REQUEST['sel_periodicidad'];
			$palabra_clave 	= $_REQUEST['txt_palabra_clave'];
			$anio	 		= $_REQUEST['sel_anio'];
			$operador		= $_REQUEST['operador'];

			$obligaciones = new CObligacionConcesion($id_delete,'','','','','','',$ocsData);
			$m = $obligaciones->deleteObligacion();

			echo $html->generaAviso($m,'?mod='.$modulo.'&niv=1&task=list&sel_periodicidad='.$periodicidad.'&sel_componente='.$componente.'&txt_palabra_clave='.$palabra_clave.'&sel_anio='.$anio);

		break;
		/**
		* la variable edit, permite hacer la carga del objeto OBLIGACION y espera confirmacion de edicion, ver la clase CObligacion
		*/
		case 'edit':
			$id_edit 		= $_REQUEST['id_element'];
			$componente 	= $_REQUEST['sel_componente'];
			$periodicidad 	= $_REQUEST['sel_periodicidad'];
			$palabra_clave 	= $_REQUEST['txt_palabra_clave'];
			$anio	 		= $_REQUEST['sel_anio'];
			$operador		= $_REQUEST['operador'];

			$componente_edit 	= $_REQUEST['sel_componente_edit'];
			$clausula_edit		= $_REQUEST['sel_clausula_edit'];
			$literal_edit		= $_REQUEST['txt_literal_edit'];
			$descripcion_edit	= $_REQUEST['txt_descripcion_edit'];
			//$obligacion_int_edit= $_REQUEST['sel_obligacion_int_edit'];
			$periodicidad_edit	= $_REQUEST['sel_periodicidad_edit'];
			$criterio_edit		= $_REQUEST['txt_criterio_edit'];

			$obligaciones = new CObligacionConcesion($id_edit,'','','','','','',$ocsData);

			$obligaciones->loadObligacion();

			if(!isset($_REQUEST['sel_componente_edit'])     || $componente_edit==-1)     $componente_edit     = $obligaciones->getComponente();     else $componente_edit     = $_REQUEST['sel_componente_edit'];
			if(!isset($_REQUEST['sel_clausula_edit'])       || $clausula_edit==-1)       $clausula_edit       = $obligaciones->getClausula();       else $clausula_edit       = $_REQUEST['sel_clausula_edit'];
			if(!isset($_REQUEST['txt_literal_edit'])        || $literal_edit=="")        $literal_edit        = $obligaciones->getLiteral();        else $literal_edit        = $_REQUEST['txt_literal_edit'];
			if(!isset($_REQUEST['txt_descripcion_edit'])    || $descripcion_edit=="")    $descripcion_edit    = $obligaciones->getDescripcion();    else $descripcion_edit    = $_REQUEST['txt_descripcion_edit'];
			//if(!isset($_REQUEST['sel_obligacion_int_edit']) || $obligacion_int_edit==-1) $obligacion_int_edit = $obligaciones->getObligacionInt();  else $obligacion_int_edit = $_REQUEST['sel_obligacion_int_edit'];
			if(!isset($_REQUEST['sel_periodicidad_edit'])   || $periodicidad_edit==-1)   $periodicidad_edit   = $obligaciones->getPeriodicidad();   else $periodicidad_edit   = $_REQUEST['sel_periodicidad_edit'];
			if(!isset($_REQUEST['txt_criterio_edit']) 		|| $criterio_edit==-1) 		 $criterio_edit 	  = $obligaciones->getCriterio();  		else $criterio_edit 	  = $_REQUEST['txt_criterio_edit'];

			$form = new CHtmlForm();

			$form->setTitle(EDITAR_OBLIGACION_CONCESION);
			$form->setId('frm_edit_obligacion_concesion');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$componentes = $ocsData->getComponentes('1','oco_nombre');
			$opciones=null;
			foreach($componentes as $s){
				$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
			}

			$form->addEtiqueta(OBLIGACION_COMPONENTE);
			$form->addSelect('select','sel_componente_edit','sel_componente_edit',$opciones,OBLIGACION_COMPONENTE,$componente_edit,'','onkeypress="ocultarDiv(\'error_componente\');"');
			$form->addError('error_componente',ERROR_OBLIGACION_COMPONENTE);

			$periodicidades = $ocsData->getClausulas('1','obc_nombre');

			$opciones=null;
			foreach($periodicidades as $t){
				$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
			}
			$form->addEtiqueta(OBLIGACION_CLAUSULA);
			$form->addSelect('select','sel_clausula_edit','sel_clausula_edit',$opciones,OBLIGACION_CLAUSULA,$clausula_edit,'','onkeypress="ocultarDiv(\'error_clausula\');"');
			$form->addError('error_clausula',ERROR_OBLIGACION_CLAUSULA);

			$form->addEtiqueta(OBLIGACION_LITERAL);
			$form->addInputText('text','txt_literal_edit','txt_literal_edit','50','50',$literal_edit,'','onkeypress="ocultarDiv(\'error_literal\');"');
			$form->addError('error_literal',ERROR_OBLIGACION_LITERAL);

			$form->addEtiqueta(OBLIGACION_DESCRIPCION);
			$form->addTextArea('textarea','txt_descripcion_edit','txt_descripcion_edit','65','5',$descripcion_edit,'','onkeypress="ocultarDiv(\'error_descripcion\');"');
			$form->addError('error_descripcion',ERROR_OBLIGACION_DESCRIPCION);

			/*$obligaciones_int = $ocsData->getObligacionesInterventoria('1','obi_literal');
			$opciones=null;
			foreach($obligaciones_int as $s){
				$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
			}

			$form->addEtiqueta(OBLIGACION_INTERVENTORIA);
			$form->addSelect('select','sel_obligacion_int_edit','sel_obligacion_int_edit',$opciones,OBLIGACION_INTERVENTORIA,$obligacion_int_edit,'','onkeypress="ocultarDiv(\'error_obligacion_int\');"');
			$form->addError('error_obligacion_int',ERROR_OBLIGACION_INTERVENTORIA);
			*/
			$periodicidades = $ocsData->getPeriodicidades('1','obp_nombre');
			$opciones=null;
			foreach($periodicidades as $s){
				$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
			}

			$form->addEtiqueta(OBLIGACION_PERIODICIDAD);
			$form->addSelect('select','sel_periodicidad_edit','sel_periodicidad_edit',$opciones,OBLIGACION_PERIODICIDAD,$periodicidad_edit,'','onkeypress="ocultarDiv(\'error_periodicidad\');"');
			$form->addError('error_periodicidad',ERROR_OBLIGACION_PERIODICIDAD);

			$form->addEtiqueta(OBLIGACION_CRITERIO);
			$form->addTextArea('textarea','txt_criterio_edit','txt_criterio_edit','65','5',$criterio_edit,'','onkeypress="ocultarDiv(\'error_criterio\');"');
			$form->addError('error_criterio',ERROR_OBLIGACION_CRITERIO);

			$form->addInputText('hidden','sel_componente','sel_componente','15','15',$componente,'','');
			$form->addInputText('hidden','sel_periodicidad','sel_periodicidad','15','15',$periodicidad,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			$form->addInputText('hidden','sel_anio','sel_anio','15','15',$anio,'','');
			$form->addInputText('hidden','txt_palabra_clave','txt_palabra_clave','15','15',$palabra_clave,'','');
			$form->addInputText('hidden','id_element','id_element','15','15',$id_edit,'','');

			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_edit_obligacion_concesion();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_edit_obligacion_concesion\',\'?mod='.$modulo.'&niv='.$niv.'&sel_periodicidad='.$periodicidad.'&sel_componente='.$componente.'&txt_palabra_clave='.$palabra_clave.'&sel_anio='.$anio.'\');"');

			$form->writeForm();

		break;
		/**
		* la variable saveEdit, permite actualizar el objeto OBLIGACION en la base de datos, ver la clase CObligacionConcesionData
		*/
		case 'saveEdit':
			$id_edit 		= $_REQUEST['id_element'];
			$componente 	= $_REQUEST['sel_componente'];
			$periodicidad 		= $_REQUEST['sel_periodicidad'];
			$palabra_clave 	= $_REQUEST['txt_palabra_clave'];
			$anio	 		= $_REQUEST['sel_anio'];
			$operador		= $_REQUEST['operador'];

			$componente_edit 	= $_REQUEST['sel_componente_edit'];
			$clausula_edit		= $_REQUEST['sel_clausula_edit'];
			$literal_edit		= $_REQUEST['txt_literal_edit'];
			$descripcion_edit	= $_REQUEST['txt_descripcion_edit'];
			//$obligacion_int_edit= $_REQUEST['sel_obligacion_int_edit'];
			$periodicidad_edit	= $_REQUEST['sel_periodicidad_edit'];
			$criterio_edit		= $_REQUEST['txt_criterio_edit'];

			$obligaciones = new CObligacionConcesion($id_edit,$componente_edit,$clausula_edit,$literal_edit,$descripcion_edit,$periodicidad_edit,$criterio_edit,$ocsData);

			$m = $obligaciones->saveEditObligacion();
			echo $html->generaAviso($m,'?mod='.$modulo.'&niv=1&task=list&sel_periodicidad='.$periodicidad.'&sel_componente='.$componente.'&txt_palabra_clave='.$palabra_clave.'&sel_anio='.$anio);

		break;

		// **************************************************S O P O R T E S*************************************************************

		/**
		* la variable listTrazabilidad, permite hacer la carga la página con la lista de objetos SOPORTE según los parámetros de entrada
		*/
		case 'listTrazabilidad':
			$id_obligacion_csr = $_REQUEST['id_element'];

			//variables filtro cargadas en el list
			$componente 	= $_REQUEST['sel_componente'];
			$periodicidad 	= $_REQUEST['sel_periodicidad'];
			$palabra_clave 	= $_REQUEST['txt_palabra_clave'];
			$anio	 		= $_REQUEST['sel_anio'];
			$operador		= $_REQUEST['operador'];
			if(!isset($operador)){$operador=1;}
			

			$obligacion_soportes= $ocsData->getObligacionTrazas('oct.ocs_id='.$id_obligacion_csr.' and oct.oct_anio='.$anio,$operador);
			$obligacion_csr 	= $ocsData->getObligacionNombre($id_obligacion_csr);

			$dt = new CHtmlDataTable();
			$titulos = array(OBLIGACION_PERIODO,OBLIGACION_ESTADO,OBLIGACION_EVIDENCIA,OBLIGACION_GESTION,OBLIGACION_RECOMENDACION,OBLIGACION_ARCHIVO);

			$dt->setDataRows($obligacion_soportes);
			$dt->setTitleRow($titulos);

			$dt->setTitleTable(TABLA_TRAZAS."-".$obligacion_csr);

			if($perfil==PERFIL_ADMIN || $perfil==PERFIL_ANALISTA || $perfil==PERFIL_ANALISTA_SENIOR || $perfil==PERFIL_ANALISTA_FINANCIERO){
				$dt->setDeleteLink("?mod=".$modulo."&niv=".$niv."&task=deleteObligacionTraza&id_obligacion_csr=".$id_obligacion_csr."&sel_periodicidad=".$periodicidad."&sel_componente=".$componente."&txt_palabra_clave=".$palabra_clave."&sel_anio=".$anio);
				$dt->setEditLink("?mod=".$modulo."&niv=".$niv."&task=editObligacionTraza&id_obligacion_csr=".$id_obligacion_csr."&sel_periodicidad=".$periodicidad."&sel_componente=".$componente."&txt_palabra_clave=".$palabra_clave."&sel_anio=".$anio);
				$dt->setAddLink("?mod=".$modulo."&niv=".$niv."&task=addObligacionTraza&id_obligacion_csr=".$id_obligacion_csr."&sel_periodicidad=".$periodicidad."&sel_componente=".$componente."&txt_palabra_clave=".$palabra_clave."&sel_anio=".$anio);
			}
			$dt->setType(1);

			$dt->writeDataTable($niv);

			$form = new CHtmlForm();
			$form->setId('frm_soporte_involucrado');
			$form->setMethod('post');

			//--------------------------------------
			//variables cargadas en el list para no perder los filtros
			$form->addInputText('hidden','sel_periodicidad','sel_periodicidad','15','15',$periodicidad,'','');
			$form->addInputText('hidden','sel_componente','sel_componente','15','15',$componente,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			$form->addInputText('hidden','sel_anio','sel_anio','15','15',$anio,'','');
			$form->addInputText('hidden','txt_palabra_clave','txt_palabra_clave','15','15',$palabra_clave,'','');
			//-----------------------------------------

			$form->writeForm();
			$link = "?mod=".$modulo."&task=list&niv=".$niv."&id_element=".$id_obligacion_csr."&sel_periodicidad=".$periodicidad."&sel_componente=".$componente."&txt_palabra_clave=".$palabra_clave."&sel_anio=".$anio;
			$html->generaLink($link,'cancelar.gif',BTN_CANCELAR);

		break;
		/**
		* la variable addObligacionTraza, permite hacer la carga la página con las variables que componen el objeto SOPORTE, ver la clase CSoporte
		*/
		case 'addObligacionTraza':
			$id_obligacion_csr = $_REQUEST['id_obligacion_csr'];

			//variables filtro cargadas en el list
			$periodicidad 	= $_REQUEST['sel_periodicidad'];
			$componente 	= $_REQUEST['sel_componente'];
			$palabra_clave 	= $_REQUEST['txt_palabra_clave'];
			$anio	 		= $_REQUEST['sel_anio'];
			$operador		= $_REQUEST['operador'];

			$anio_add			= $_REQUEST['sel_anio_add'];
			$mes_add 			= $_REQUEST['sel_mes_add'];
			$estado_add 		= $_REQUEST['sel_estado_add'];
			$evidencia_add 		= $_REQUEST['txt_evidencia_add'];
			$gestion_add 		= $_REQUEST['txt_gestion_add'];
			$recomendacion_add 	= $_REQUEST['txt_recomendacion_add'];

			$obligacion_csr 	= $ocsData->getObligacionNombre($id_obligacion_csr);

			$form = new CHtmlForm();
			$form->setTitle(AGREGAR_TRAZA."-".$obligacion_csr);
			$form->setId('frm_add_obligacion_concesion_traza');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$form->addInputText('hidden','id_obligacion_csr','id_obligacion_csr','15','15',$id_obligacion_csr,'','');

			$anios = $ocsData->getAnios('1','oba_id');
			$opciones=null;
			foreach($anios as $s){
				$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
			}

			$form->addEtiqueta(OBLIGACION_ANIO);
			$form->addSelect('select','sel_anio_add','sel_anio_add',$opciones,OBLIGACION_ANIO,$anio_add,'','onChange=submit();');
			$form->addError('error_anio',ERROR_OBLIGACION_ANIO);

			$meses = $ocsData->getMeses('1','obm_id',$anio_add,$id_obligacion_csr);
			$opciones=null;
			foreach($meses as $s){
				$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
			}

			$form->addEtiqueta(OBLIGACION_MES);
			$form->addSelect('select','sel_mes_add','sel_mes_add',$opciones,OBLIGACION_MES,$mes_add,'','onkeypress="ocultarDiv(\'error_mes\');"');
			$form->addError('error_mes',ERROR_OBLIGACION_MES);

			$estados = $ocsData->getEstados('1','obe_id');
			$opciones=null;
			foreach($estados as $s){
				$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
			}

			$form->addEtiqueta(OBLIGACION_ESTADO);
			$form->addSelect('select','sel_estado_add','sel_estado_add',$opciones,OBLIGACION_ESTADO,$estado_add,'','onkeypress="ocultarDiv(\'error_estado\');"');
			$form->addError('error_estado',ERROR_OBLIGACION_ESTADO);

			$form->addEtiqueta(OBLIGACION_EVIDENCIA);
			$form->addTextArea('textarea','txt_evidencia_add','txt_evidencia_add','65','5',$evidencia_add,'','onkeypress="ocultarDiv(\'error_evidencia\');"');
			$form->addError('error_evidencia',ERROR_OBLIGACION_EVIDENCIA);

			$form->addEtiqueta(OBLIGACION_GESTION);
			$form->addTextArea('textarea','txt_gestion_add','txt_gestion_add','65','15',$gestion_add,'','onkeypress="ocultarDiv(\'error_gestion\');"');
			$form->addError('error_gestion',ERROR_OBLIGACION_GESTION);

			$form->addEtiqueta(OBLIGACION_RECOMENDACION);
			$form->addTextArea('textarea','txt_recomendacion_add','txt_recomendacion_add','65','5',$recomendacion_add,'','onkeypress="ocultarDiv(\'error_recomendacion\');"');
			$form->addError('error_recomendacion',ERROR_OBLIGACION_RECOMENDACION);

			$form->addEtiqueta(OBLIGACION_ARCHIVO);
			$form->addInputFile('file','file_archivo','file_archivo','25','file','onChange="ocultarDiv(\'error_archivo\');"');
			$form->addError('error_archivo',ERROR_OBLIGACION_ARCHIVO);

			//--------------------------------------
			//variables cargadas en el list para no perder los filtros
			$form->addInputText('hidden','sel_periodicidad','sel_periodicidad','15','15',$periodicidad,'','');
			$form->addInputText('hidden','sel_componente','sel_componente','15','15',$componente,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			$form->addInputText('hidden','sel_anio','sel_anio','15','15',$anio,'','');
			//-----------------------------------------

			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_add_obligacion_csr_traza();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_add_oblig_conc_traza\',\'?mod='.$modulo.'&niv='.$niv.'&task=listTrazabilidad&id_element='.$id_obligacion_csr.'&sel_periodicidad='.$periodicidad.'&sel_componente='.$componente.'&txt_palabra_clave='.$palabra_clave.'&sel_anio='.$anio.'\');"');

			$form->writeForm();

		break;
		/**
		* la variable saveAddSoporte, permite almacenar el objeto SOPORTE en la base de datos, ver la clase CSoporteData
		*/
		case 'saveAddObligacionTraza':
			$id_obligacion_csr	= $_REQUEST['id_obligacion_csr'];
			$periodicidad 		= $_REQUEST['sel_periodicidad'];
			$componente 		= $_REQUEST['sel_componente'];
			$palabra_clave 		= $_REQUEST['txt_palabra_clave'];
			$anio	 			= $_REQUEST['sel_anio'];
			$operador			= $_REQUEST['operador'];

			$anio_add			= $_REQUEST['sel_anio_add'];
			$mes_add 			= $_REQUEST['sel_mes_add'];
			$estado_add 		= $_REQUEST['sel_estado_add'];
			$evidencia_add 		= $_REQUEST['txt_evidencia_add'];
			$gestion_add 		= $_REQUEST['txt_gestion_add'];
			$recomendacion_add 	= $_REQUEST['txt_recomendacion_add'];
			$archivo_add 		= $_FILES['file_archivo'];

			$traza = new CObligacionTraza('',$id_obligacion_csr,$anio_add,$mes_add,$estado_add,$evidencia_add,$gestion_add,$recomendacion_add,$archivo_add,$ocsData);
			$m = $traza->saveNewTraza($operador);

			echo $html->generaAviso($m,'?mod='.$modulo.'&niv=1&task=listTrazabilidad&id_element='.$id_obligacion_csr."&sel_periodicidad=".$periodicidad."&sel_componente=".$componente."&txt_palabra_clave=".$palabra_clave."&sel_anio=".$anio);

		break;
		/**
		* la variable deleteObligacionTraza, permite hacer la carga del objeto SOPORTE y espera confirmacion de eliminarlo, ver la clase CInvolucradoSoporte
		*/
		case 'deleteObligacionTraza':
			$id_obligacion_csr_traza    = $_REQUEST['id_element'];
			$id_obligacion_csr 			= $_REQUEST['id_obligacion_csr'];

			//variables filtro cargadas en el list
			$periodicidad 	= $_REQUEST['sel_periodicidad'];
			$componente 	= $_REQUEST['sel_componente'];
			$palabra_clave 	= $_REQUEST['txt_palabra_clave'];
			$anio	 		= $_REQUEST['sel_anio'];
			$operador		= $_REQUEST['operador'];

			$form = new CHtmlForm();
			$form->setId('frm_delete_obligacion_csr_soporte');
			$form->setMethod('post');
			$form->addInputText('hidden','id_obligacion_csr_traza','id_obligacion_csr_traza','15','15',$id_obligacion_csr_traza,'','');
			$form->addInputText('hidden','id_obligacion_csr','id_obligacion_csr','15','15',$id_obligacion_csr,'','');

			//--------------------------------------
			//variables cargadas en el list para no perder los filtros
			$form->addInputText('hidden','sel_periodicidad','sel_periodicidad','15','15',$periodicidad,'','');
			$form->addInputText('hidden','sel_componente','sel_componente','15','15',$componente,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			$form->addInputText('hidden','sel_anio','sel_anio','15','15',$anio,'','');
			$form->addInputText('hidden','txt_palabra_clave','txt_palabra_clave','15','15',$palabra_clave,'','');
			//-----------------------------------------
			$form->writeForm();

			echo $html->generaAdvertencia(SOPORTE_MSG_BORRADO,'?mod='.$modulo.'&niv='.$niv.'&task=confirmDeleteSoporte&id_obligacion_csr='.$id_obligacion_csr.'&id_obligacion_csr_traza='.$id_obligacion_csr_traza.'&sel_periodicidad='.$periodicidad.'&sel_componente='.$componente.'&txt_palabra_clave='.$palabra_clave.'&sel_anio='.$anio,"cancelarAccion('frm_delete_obligacion_csr_soporte','?mod=".$modulo."&niv=".$niv."&task=listTrazabilidad&id_element=".$id_obligacion_csr."&sel_periodicidad=".$periodicidad."&sel_componente=".$componente."&txt_palabra_clave=".$palabra_clave."&sel_anio=".$anio."');");

		break;
		/**
		* la variable confirmDeleteSoporte, permite eliminar el objeto SOPORTE de la base de datos, ver la clase CInvolucradoData
		*/
		case 'confirmDeleteSoporte':
			$id_obligacion_csr 		 = $_REQUEST['id_obligacion_csr'];
			$id_obligacion_csr_traza = $_REQUEST['id_obligacion_csr_traza'];

			//variables filtro cargadas en el list
			$periodicidad 	= $_REQUEST['sel_periodicidad'];
			$componente 	= $_REQUEST['sel_componente'];
			$palabra_clave 	= $_REQUEST['txt_palabra_clave'];
			$anio	 		= $_REQUEST['sel_anio'];
			$operador		= $_REQUEST['operador'];

			$obligacion_trazas = new CObligacionTraza($id_obligacion_csr_traza,'','','','','','','','',$ocsData);
			$obligacion_trazas->loadTraza();

			$m = $obligacion_trazas->deleteObligacionTraza();

			echo $html->generaAviso($m,'?mod='.$modulo.'&niv='.$niv.'&task=listTrazabilidad&id_element='.$id_obligacion_csr."&sel_periodicidad=".$periodicidad."&sel_componente=".$componente."&txt_palabra_clave=".$palabra_clave."&sel_anio=".$anio);

		break;
		/**
		* la variable addObligacionTraza, permite hacer la carga la página con las variables que componen el objeto SOPORTE, ver la clase CSoporte
		*/
		case 'editObligacionTraza':
			$id_obligacion_csr 		 = $_REQUEST['id_obligacion_csr'];
			$id_obligacion_csr_traza = $_REQUEST['id_element'];

			//variables filtro cargadas en el list
			$periodicidad 	= $_REQUEST['sel_periodicidad'];
			$componente 	= $_REQUEST['sel_componente'];
			$palabra_clave 	= $_REQUEST['txt_palabra_clave'];
			$anio	 		= $_REQUEST['sel_anio'];
			$operador		= $_REQUEST['operador'];

			$anio_edit			= $_REQUEST['sel_anio_edit'];
			$mes_edit 			= $_REQUEST['sel_mes_edit'];
			$estado_edit 		= $_REQUEST['sel_estado_edit'];
			$evidencia_edit 	= $_REQUEST['txt_evidencia_edit'];
			$gestion_edit 		= $_REQUEST['txt_gestion_edit'];
			$recomendacion_edit = $_REQUEST['txt_recomendacion_edit'];

			$obligacion_csr 	= $ocsData->getObligacionNombre($id_obligacion_csr);

			/**************************/

			$obligaciones = new CObligacionTraza($id_obligacion_csr_traza,'','','','','','','','',$ocsData);
			$obligaciones->loadTraza();

			if(!isset($_REQUEST['sel_anio_edit'])     		|| $anio_edit==-1)     		$anio_edit     		= $obligaciones->getAnio();     	 else $anio_edit     		= $_REQUEST['sel_anio_edit'];
			if(!isset($_REQUEST['sel_mes_edit'])       		|| $mes_edit==-1)       	$mes_edit       	= $obligaciones->getMes();       	 else $mes_edit       		= $_REQUEST['sel_mes_edit'];
			if(!isset($_REQUEST['sel_estado_edit'])        	|| $estado_edit==-1)        $estado_edit        = $obligaciones->getEstado();        else $estado_edit        	= $_REQUEST['sel_estado_edit'];
			if(!isset($_REQUEST['txt_evidencia_edit'])    	|| $evidencia_edit=="")    	$evidencia_edit    	= $obligaciones->getEvidencia();     else $evidencia_edit    	= $_REQUEST['txt_evidencia_edit'];
			if(!isset($_REQUEST['txt_gestion_edit']) 		|| $gestion_edit=="") 		$gestion_edit 		= $obligaciones->getGestion();  	 else $gestion_edit 		= $_REQUEST['txt_gestion_edit'];
			if(!isset($_REQUEST['txt_recomendacion_edit'])	|| $recomendacion_edit=="")	$recomendacion_edit	= $obligaciones->getRecomendacion(); else $recomendacion_edit	= $_REQUEST['txt_recomendacion_edit'];
			$archivo_anterior = $obligaciones->getArchivo();

			$form = new CHtmlForm();

			$form->setTitle(EDITAR_TRAZA."-".$obligacion_csr);
			$form->setId('frm_edit_oblig_conc_traza');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$form->addInputText('hidden','id_obligacion_csr','id_obligacion_csr','15','15',$id_obligacion_csr,'','');
			$form->addInputText('hidden','id_obligacion_csr_traza','id_obligacion_csr_traza','15','15',$id_obligacion_csr_traza,'','');


			/*$anios = $ocsData->getAnios('1','oba_id');
			$opciones=null;
			foreach($anios as $s){
				$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
			}

			$form->addEtiqueta(OBLIGACION_ANIO);
			$form->addSelect('select','sel_anio_edit','sel_anio_edit',$opciones,OBLIGACION_ANIO,$anio_edit,'','onChange=submit();');
			$form->addError('error_anio',ERROR_OBLIGACION_ANIO);

			$meses = $ocsData->getMeses('1','obm_id',$anio_edit,$id_obligacion_csr_traza);
			$opciones=null;
			foreach($meses as $s){
				$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
			}

			$form->addEtiqueta(OBLIGACION_MES);
			$form->addSelect('select','sel_mes_edit','sel_mes_edit',$opciones,OBLIGACION_MES,$mes_edit,'','onkeypress="ocultarDiv(\'error_mes\');"');
			$form->addError('error_mes',ERROR_OBLIGACION_MES);
			*/
			$estados = $ocsData->getEstados('1','obe_id');
			$opciones=null;
			foreach($estados as $s){
				$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
			}

			$form->addEtiqueta(OBLIGACION_ESTADO);
			$form->addSelect('select','sel_estado_edit','sel_estado_edit',$opciones,OBLIGACION_ESTADO,$estado_edit,'','onkeypress="ocultarDiv(\'error_estado\');"');
			$form->addError('error_estado',ERROR_OBLIGACION_ESTADO);

			$form->addEtiqueta(OBLIGACION_EVIDENCIA);
			$form->addTextArea('textarea','txt_evidencia_edit','txt_evidencia_edit','65','5',$evidencia_edit,'','onkeypress="ocultarDiv(\'error_evidencia\');"');
			$form->addError('error_evidencia',ERROR_OBLIGACION_EVIDENCIA);

			$form->addEtiqueta(OBLIGACION_GESTION);
			$form->addTextArea('textarea','txt_gestion_edit','txt_gestion_edit','65','15',$gestion_edit,'','onkeypress="ocultarDiv(\'error_gestion\');"');
			$form->addError('error_gestion',ERROR_OBLIGACION_GESTION);

			$form->addEtiqueta(OBLIGACION_RECOMENDACION);
			$form->addTextArea('textarea','txt_recomendacion_edit','txt_recomendacion_edit','65','5',$recomendacion_edit,'','onkeypress="ocultarDiv(\'error_recomendacion\');"');
			$form->addError('error_recomendacion',ERROR_OBLIGACION_RECOMENDACION);

			$form->addEtiqueta(OBLIGACION_ARCHIVO);
			$form->addInputFile('file','file_archivo','file_archivo','25','file','onChange="ocultarDiv(\'error_archivo\');"');
			$form->addError('error_archivo',ERROR_OBLIGACION_ARCHIVO);

			//--------------------------------------
			//variables cargadas en el list para no perder los filtros
			$form->addInputText('hidden','sel_periodicidad','sel_periodicidad','15','15',$periodicidad,'','');
			$form->addInputText('hidden','sel_componente','sel_componente','15','15',$componente,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			$form->addInputText('hidden','archivo_anterior','archivo_anterior','15','15',$archivo_anterior,'','');
			$form->addInputText('hidden','sel_anio','sel_anio','15','15',$anio,'','');
			$form->addInputText('hidden','sel_anio_edit','sel_anio_edit','15','15',$anio_edit,'','');
			$form->addInputText('hidden','sel_mes_edit','sel_mes_edit','15','15',$mes_edit,'','');
			$form->addInputText('hidden','txt_palabra_clave','txt_palabra_clave','15','15',$palabra_clave,'','');
			//-----------------------------------------

			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_edit_oblig_csr_traza();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_edit_oblig_conc_traza\',\'?mod='.$modulo.'&niv='.$niv.'&task=listTrazabilidad&id_element='.$id_obligacion_csr.'&sel_periodicidad='.$periodicidad.'&sel_componente='.$componente.'&txt_palabra_clave='.$palabra_clave.'&sel_anio='.$anio.'\');"');

			$form->writeForm();

		break;
		/**
		* la variable saveAddSoporte, permite almacenar el objeto SOPORTE en la base de datos, ver la clase CSoporteData
		*/
		case 'saveEditObligacionTraza':
			$id_obligacion_csr		 = $_REQUEST['id_obligacion_csr'];
			$id_obligacion_csr_traza = $_REQUEST['id_obligacion_csr_traza'];

			$periodicidad 		= $_REQUEST['sel_periodicidad'];
			$componente 		= $_REQUEST['sel_componente'];
			$palabra_clave 		= $_REQUEST['txt_palabra_clave'];
			$anio	 			= $_REQUEST['sel_anio'];
			$operador			= $_REQUEST['operador'];

			$anio_edit			= $_REQUEST['sel_anio_edit'];
			$mes_edit 			= $_REQUEST['sel_mes_edit'];
			$estado_edit 		= $_REQUEST['sel_estado_edit'];
			$evidencia_edit 	= $_REQUEST['txt_evidencia_edit'];
			$gestion_edit 		= $_REQUEST['txt_gestion_edit'];
			$recomendacion_edit = $_REQUEST['txt_recomendacion_edit'];
			$archivo_edit 		= $_FILES['file_archivo'];
			$archivo_anterior   = $_REQUEST['archivo_anterior'];

			$traza = new CObligacionTraza($id_obligacion_csr_traza,$id_obligacion_csr,$anio_edit,$mes_edit,$estado_edit,$evidencia_edit,$gestion_edit,$recomendacion_edit,$archivo_edit,$ocsData);
			$m = $traza->saveEditTraza($operador,$archivo_anterior);

			echo $html->generaAviso($m,'?mod='.$modulo.'&niv=1&task=listTrazabilidad&id_element='.$id_obligacion_csr."&sel_periodicidad=".$periodicidad."&sel_componente=".$componente."&txt_palabra_clave=".$palabra_clave."&sel_anio=".$anio);

		break;
		/**
		* la variable listResumenExcel, permite generar en excel el objeto OBLIGACION a partir de la base de datos
		*/
		case 'listResumenExcel':

			$fecha_inicio = $_REQUEST['txt_fecha_inicio'];
			$fecha_fin = $_REQUEST['txt_fecha_fin'];
			$operador=$_REQUEST['operador'];

			$form = new CHtmlForm();
			$form->setTitle('Descarga de Obligaciones por mes');
			$form->setId('frm_excel');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$anios = $ocsData->getAniosObligacion('1','oct_anio');

			$opciones=null;
			foreach($anios as $t){
				$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
			}
			$form->addEtiqueta(OBLIGACION_ANIO);
			$form->addSelect('select','sel_anio','sel_anio',$opciones,OBLIGACION_ANIO,$anio,'','');

			$meses = $ocsData->getMesesTotal();
			$opciones=null;
			foreach($meses as $s){
				$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
			}

			$form->addEtiqueta(OBLIGACION_MES);
			$form->addSelect('select','sel_mes','sel_mes',$opciones,OBLIGACION_MES,$mes,'','');

			$form->addInputText('hidden','operador','operador','45','20',$operador,'','');

			$form->writeForm();

			$form->crearBoton('button','guardar',BTN_ACEPTAR,'onclick="obligaciones_en_excel();"');

		break;/**
		* en caso de que la variable task no este definida carga la página en construcción
		*/
		default:
			include('templates/html/under.html');

		break;
	}
?>
