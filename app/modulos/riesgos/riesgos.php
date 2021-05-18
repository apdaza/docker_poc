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
* Modulo Riesgos
* maneja el modulo RIESGOS en union con CRiesgo y CRiesgoData
*
* @see CRiesgo
* @see CRiesgoData
*
* @package  modulos
* @subpackage riesgos
* @author Alejandro Daza
* @version 2020.01
* @copyright apdaza
*/

	//no permite el acceso directo
	defined('_VALID_PRY') or die('Restricted access');
	$rieData 	= new CRiesgoData($db);
	$accData 	= new CRiesgoAccionData($db);
	$resData 	= new CRiesgoResponsableData($db);
	$operador 	= $_REQUEST['operador'];
	$task 		= $_REQUEST['task'];
	if(empty($task)) $task = 'list';

	switch($task){
		/**
		* la variable list, permite hacer la carga la p�gina con la lista de objetos RIESGO seg�n los par�metros de entrada
		*/
		case 'list':
			$perfil 		 = $du->getUserPerfil($id_usuario);
			$alcance         = $_REQUEST['sel_alcance'];
			$categoria       = $_REQUEST['sel_categoria'];
			$estado		     = $_REQUEST['sel_estado'];
			$operador 		 = $_REQUEST['operador'];

			$criterio = '';

			if (isset($alcance) && $alcance!=-1&& $alcance!=''){
				if ($criterio == "")  $criterio .= " a.alc_id = ".$alcance;
				else $criterio .= " and a.alc_id = ".$alcance;
			}
			if (isset($categoria) && $categoria!=-1&& $categoria!=''){
				if ($criterio == "")  $criterio .= " r.rca_id = ".$categoria;
				else $criterio .= " and r.rca_id = ".$categoria;
			}
			if (isset($estado) && $estado!=-1&& $estado!=''){
				if ($criterio == "")  $criterio .= " es.res_id = ".$estado;
				else $criterio .= " and es.res_id = ".$estado;
			}

			$form = new CHtmlForm();

			$form->setTitle(LISTAR_RIESGOS);
			$form->setId('frm_list_riesgos1');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$alcances = $rieData->getAlcances('ope_id='.$operador,'alc_nombre');

			$opciones=null;
			if(isset($alcances)){
				foreach($alcances as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(RIESGOS_ALCANCE);
			$form->addSelect('select','sel_alcance','sel_alcance',$opciones,RIESGOS_ALCANCE,$alcance,'','onChange=submit();');

			$categorias = $rieData->getCategoriasRiesgos('1','rca_id');
			$opciones=null;
			if(isset($categorias)){
				foreach($categorias as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(RIESGOS_CATEGORIA);
			$form->addSelect('select','sel_categoria','sel_categoria',$opciones,RIESGOS_CATEGORIA,$categoria,'','onChange=submit();');

			$estados = $rieData->getEstados('1','res_id');
			$opciones=null;
			if(isset($estados)){
				foreach($estados as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(RIESGOS_ESTADO);
			$form->addSelect('select','sel_estado','sel_estado',$opciones,RIESGOS_ESTADO,$estado,'','onChange=submit();');

			$form->writeForm();

			$riesgos = $rieData->getRiesgos($criterio,' r.rie_fecha_deteccion asc');

			$dt = new CHtmlDataTable();
			$titulos = array(RIESGOS_DESCRIPCION,RIESGOS_ESTRATEGIA,RIESGOS_FECHA_DETEC, RIESGOS_FECHA_ACTUA,
							 RIESGOS_RESPONSABLE,RIESGOS_IMPACTO,RIESGOS_PROBABILIDAD,
							 RIESGOS_CATEGORIA,RIESGOS_ESTADO);
			$dt->setDataRows($riesgos);
			$dt->setTitleRow($titulos);

			$dt->setTitleTable(TABLA_RIESGOS);
			if ($perfil <> PERFIL_ANALISTA_RIESGOS){
			$dt->setDeleteLink("?mod=".$modulo."&niv=".$niv."&task=delete&sel_alcance=".$alcance."&sel_categoria=".$categoria."&sel_estado=".$estado."&operador=".$operador);
			$dt->setEditLink("?mod=".$modulo."&niv=".$niv."&task=edit&sel_alcance=".$alcance."&sel_categoria=".$categoria."&sel_estado=".$estado."&operador=".$operador);
			$dt->setAddLink("?mod=".$modulo."&niv=".$niv."&task=add&sel_alcance=".$alcance."&sel_categoria=".$categoria."&sel_estado=".$estado."&operador=".$operador);
			$otros = array('link'=>"?mod=".$modulo."&niv=".$nivel."&task=listResponsables&sel_alcance=".$alcance."&sel_categoria=".$categoria."&sel_estado=".$estado."&operador=".$operador,'img'=>'responsables.gif','alt'=>ALT_RESPONSABLES);
			$dt->addOtrosLink($otros);
			}
			$dt->setSeeLink("?mod=".$modulo."&niv=".$niv."&task=listAcciones&sel_alcance=".$alcance."&sel_categoria=".$categoria."&sel_estado=".$estado."&orden=1"."&operador=".$operador);


			$dt->setType(1);
			$pag_crit="task=list&sel_alcance=".$alcance."&sel_categoria=".$categoria."&sel_estado=".$estado."&operador=".$operador;
			$dt->setPag(1,$pag_crit);
			$dt->writeDataTable($niv);

		break;
		/**
		* la variable add, permite hacer la carga la p�gina con las variables que componen el objeto RIESGO, ver la clase CRiesgo
		*/
		case 'add':
			$categoria 			= $_REQUEST['sel_categoria'];
			$alcance   			= $_REQUEST['sel_alcance'];
			$estado   			= $_REQUEST['sel_estado'];

			$descripcion 		= $_REQUEST['txt_descripcion'];
			$estrategia 		= $_REQUEST['txt_estrategia'];
			$accion 			= $_REQUEST['txt_accion'];
			$impacto 			= $_REQUEST['sel_impacto'];
			$probabilidad 		= $_REQUEST['sel_probabilidad'];
			$alcance_add 		= $_REQUEST['sel_alcance_add'];
			$estado_add 		= $_REQUEST['sel_estado_add'];
			$fecha_deteccion_add= $_REQUEST['txt_fecha_deteccion_add'];
			$operador 			= $_REQUEST['operador'];

			$form = new CHtmlForm();

			if($descripcion == '') $descripcion='dado que ...  es posible que ... lo que puede ocasionar ......(algun cambio de alcance,tiempo,costo,calidad, etc)';
			if($estrategia == '') $estrategia='por lo que debo hacer ...';
			if($alcance_add == '') $alcance_add=$alcance;

			$form->setTitle(AGREGAR_RIESGOS);
			$form->setId('frm_add_riesgo1');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$alcances = $rieData->getAlcances('ope_id='.$operador,'alc_nombre');
			$opciones=null;
			if(isset($alcances)){
				foreach($alcances as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}

			$form->addEtiqueta(RIESGOS_ALCANCE);
			$form->addSelect('select','sel_alcance_add','sel_alcance_add',$opciones,RIESGOS_ALCANCE,$alcance_add,'','onChange=submit();');
			$form->addError('error_alcance',ERROR_RIESGOS_ALCANCE);

			$form->addEtiqueta(RIESGOS_DESCRIPCION);
			$form->addTextArea('textarea','txt_descripcion','txt_descripcion','65','5',$descripcion,'','onkeypress="ocultarDiv(\'error_descripcion\');"');
			$form->addError('error_descripcion',ERROR_RIESGOS_DESSCRIPCION);

			$form->addEtiqueta(RIESGOS_FECHA_DETEC);
			$form->addInputDate('date','txt_fecha_deteccion_add','txt_fecha_deteccion_add',$fecha_deteccion_add,'%Y-%m-%d','16','16','','');
			$form->addError('error_fecha_deteccion',ERROR_RIESGOS_FECHA_DETEC);

			$form->addEtiqueta(RIESGOS_ESTRATEGIA);
			$form->addTextArea('textarea','txt_estrategia','txt_estrategia','65','5',$estrategia,'','onkeypress="ocultarDiv(\'error_estrategia\');"');
			$form->addError('error_estrategia',ERROR_RIESGOS_ESTRATEGIA);


			$impactos = $rieData->getImpacto('1','rim_id');
			$opciones=null;
			if(isset($impactos)){
				foreach($impactos as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}

			$form->addEtiqueta(RIESGOS_IMPACTO);
			$form->addSelect('select','sel_impacto','sel_impacto',$opciones,RIESGOS_IMPACTO,$impacto,'','onChange=submit();');
			$form->addError('error_impacto',ERROR_RIESGOS_IMPACTO);

			$probabilidades = $rieData->getProbabilidad('1','rpr_id');
			$opciones=null;
			if(isset($probabilidades)){
				foreach($probabilidades as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(RIESGOS_PROBABILIDAD);
			$form->addSelect('select','sel_probabilidad','sel_probabilidad',$opciones,RIESGOS_PROBABILIDAD,$probabilidad,'','onChange=submit();');
			$form->addError('error_probabilidad',ERROR_RIESGOS_PROBABILIDAD);

			$categoria_calculada = $rieData->getCategoriasCalculado($impacto,$probabilidad);
			$categoria_nombre= $categoria_calculada[0]['nombre'];
			$categoria_add = $categoria_calculada[0]['id'];
			$form->addEtiqueta(RIESGOS_CATEGORIA);
			$form->addInputText('text','txt_categoria','txt_categoria','50','100',$categoria_nombre,'','onkeypress="ocultarDiv(\'error_categoria\');" readonly=true');
			$form->addError('error_categoria',ERROR_RIESGOS_CATEGORIA);

			$estados = $rieData->getEstados('1','res_id');
			$opciones=null;
			if(isset($estados)){
				foreach($estados as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(RIESGOS_ESTADO);
			$form->addSelect('select','sel_estado_add','sel_estado_add',$opciones,RIESGOS_ESTADO,$estado_add,'','onkeypress="ocultarDiv(\'error_estado\');"');
			$form->addError('error_estado',ERROR_RIESGOS_ESTADO);

			$form->addInputText('hidden','sel_categoria','sel_categoria','15','15',$categoria,'','');
			$form->addInputText('hidden','sel_estado','sel_estado','15','15',$estado,'','');
			$form->addInputText('hidden','sel_categoria_add','sel_categoria_add','15','15',$categoria_add,'','');
			$form->addInputText('hidden','sel_alcance','sel_alcance','15','15',$alcance,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');

			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_add_riesgo1();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_add_riesgo1\',\'?mod=riesgos&niv=1&sel_alcance='.$alcance.'&sel_categoria='.$categoria.'&sel_estado='.$estado.'&operador='.$operador.'\');"');

			$form->writeForm();

		break;
		/**
		* la variable saveAdd, permite almacenar el objeto RIESGO en la base de datos, ver la clase CRiesgoData
		*/
		case 'saveAdd':
			$categoria 		= $_REQUEST['sel_categoria'];
			$alcance   		= $_REQUEST['sel_alcance'];
			$estado   		= $_REQUEST['sel_estado'];

			$descripcion 	= $_REQUEST['txt_descripcion'];
			$responsable 	= $_REQUEST['sel_responsable'];
			$responsable_add= $_REQUEST['sel_responsable_add'];
			$fecha_deteccion_add = $_REQUEST['txt_fecha_deteccion_add'];
			$estrategia 	= $_REQUEST['txt_estrategia'];
			$accion 		= $_REQUEST['txt_accion'];
			$impacto 		= $_REQUEST['sel_impacto'];
			$probabilidad 	= $_REQUEST['sel_probabilidad'];
			$alcance_add 	= $_REQUEST['sel_alcance_add'];
			$categoria_add 	= $_REQUEST['sel_categoria_add'];
			$estado_add 	= $_REQUEST['sel_estado_add'];
			$operador 		= $_REQUEST['operador'];

			$riesgo = new CRiesgo('',$descripcion,$fecha_deteccion_add,$estrategia,$accion,$impacto,$probabilidad,$categoria_add,$alcance_add,$estado_add,$rieData);

			$m = $riesgo->saveNewRiesgo();

			echo $html->generaAviso($m,"?mod=".$modulo."&niv=".$niv."&task=list&sel_alcance=".$alcance."&sel_categoria=".$categoria."&sel_estado=".$estado."&operador=".$operador);

		break;
		/**
		* la variable delete, permite hacer la carga del objeto RIESGO y espera confirmacion de eliminarlo, ver la clase CRiesgo
		*/
		case 'delete':
			$id_delete 		= $_REQUEST['id_element'];
			$categoria 		= $_REQUEST['sel_categoria'];
			$alcance   		= $_REQUEST['sel_alcance'];
			$estado   		= $_REQUEST['sel_estado'];
			$operador   	= $_REQUEST['operador'];

			$responsable = $_REQUEST['sel_responsable'];
			$fecha_deteccion = $_REQUEST['txt_fecha_deteccion'];

			$form = new CHtmlForm();
			$form->setId('frm_delete_riesgo1');
			$form->setMethod('post');
			$form->addInputText('hidden','id_delete','id_delete','15','15',$id_delete,'','');
			$form->addInputText('hidden','txt_fecha_deteccion','txt_fecha_deteccion','15','15',$fecha_deteccion,'','');
			$form->addInputText('hidden','sel_categoria','sel_categoria','15','15',$categoria,'','');
			$form->addInputText('hidden','sel_alcance','sel_alcance','15','15',$alcance,'','');
			$form->addInputText('hidden','sel_estado','sel_estado','15','15',$estado,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			$form->writeForm();

			echo $html->generaAdvertencia(RIESGO_MSG_BORRADO,'?mod=riesgos&niv=1&task=confirmDelete&id_element='.$id_delete.'&sel_alcance='.$alcance."&sel_categoria=".$categoria."&sel_estado=".$estado."&operador=".$operador,"cancelarAccion('frm_delete_riesgo1','?mod=riesgos&niv=1&sel_alcance=".$alcance."&sel_categoria=".$categoria."&sel_estado=".$estado."&operador=".$operador."')");

		break;
		/**
		* la variable confirmDelete, permite eliminar el objeto RIESGO de la base de datos, ver la clase CRiesgoData
		*/
		case 'confirmDelete':
			$id_delete 		= $_REQUEST['id_element'];
			$categoria 		= $_REQUEST['sel_categoria'];
			$alcance   		= $_REQUEST['sel_alcance'];
			$estado   		= $_REQUEST['sel_estado'];
			$operador   	= $_REQUEST['operador'];

			$fecha_deteccion = $_REQUEST['txt_fecha_deteccion'];

			$riesgo = new CRiesgo($id_delete,'','','','','','','','','',$rieData);
			$riesgo->loadRiesgo();
			$m = $riesgo->deleteRiesgo();
			echo $html->generaAviso($m,"?mod=".$modulo."&niv=".$niv."&task=list&sel_alcance=".$alcance."&sel_categoria=".$categoria."&sel_estado=".$estado."&operador=".$operador);

		break;
		/**
		* la variable edit, permite hacer la carga del objeto RIESGO y espera confirmacion de edicion, ver la clase CRiesgo
		*/
		case 'edit':
			$id_edit   		= $_REQUEST['id_element'];
			$categoria 		= $_REQUEST['sel_categoria'];
			$alcance   		= $_REQUEST['sel_alcance'];
			$estado   		= $_REQUEST['sel_estado'];
			$operador  		= $_REQUEST['operador'];

			$alcance_edit 		= $_REQUEST['sel_alcance_edit'];
			$descripcion 		= $_REQUEST['txt_descripcion'];
			$estrategia 		= $_REQUEST['txt_estrategia'];
			$fecha_deteccion	= $_REQUEST['txt_fecha_deteccion'];
			$estado_edit 		= $_REQUEST['sel_estado_edit'];

			$riesgo = new CRiesgo($id_edit,'','','','','','','','','',$rieData);
			$riesgo->loadRiesgo();

			if(!isset($_REQUEST['sel_alcance_edit'])|| $_REQUEST['sel_alcance_edit'] <= 0) $alcance_edit = $riesgo->getAlcance(); else $alcance_edit = $_REQUEST['sel_alcance_edit'];
			if(!isset($_REQUEST['txt_descripcion'])|| $_REQUEST['txt_descripcion'] != '') $descripcion = $riesgo->getDescripcion(); else $descripcion = $_REQUEST['txt_descripcion'];
			if(!isset($_REQUEST['txt_estrategia'])|| $_REQUEST['txt_estrategia'] != '') $estrategia = $riesgo->getEstrategia(); else $estrategia = $_REQUEST['txt_estrategia'];
			if(!isset($_REQUEST['txt_fecha_deteccion'])) $fecha_deteccion = $riesgo->getFechaDeteccion(); else $fecha_deteccion = $_REQUEST['txt_fecha_deteccion'];
            if(!isset($_REQUEST['sel_estado_edit'])|| $_REQUEST['sel_estado_edit'] <= 0) $estado_edit = $riesgo->getEstado(); else $estado_edit = $_REQUEST['sel_estado_edit'];

			$form = new CHtmlForm();
			$form->setTitle(EDITAR_RIESGOS);

			$form->setId('frm_edit_riesgo1');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$form->addInputText('hidden','txt_id','txt_id','15','15',$riesgo->getId(),'','');

			$alcances = $rieData->getAlcances('ope_id='.$operador,'alc_nombre');
			$opciones=null;
			if(isset($alcances)){
				foreach($alcances as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(RIESGOS_ALCANCE);
			$form->addSelect('select','sel_alcance_edit','sel_alcance_edit',$opciones,RIESGOS_ALCANCE,$alcance_edit,'','');
			$form->addError('error_alcance',ERROR_RIESGOS_ALCANCE);

			$form->addEtiqueta(RIESGOS_DESCRIPCION);
			$form->addTextArea('textarea','txt_descripcion','txt_descripcion','65','5',$descripcion,'','onkeypress="ocultarDiv(\'error_descripcion\');"');
			$form->addError('error_descripcion',ERROR_RIESGOS_DESCRIPCION);

			$form->addEtiqueta(RIESGOS_ESTRATEGIA);
			$form->addTextArea('textarea','txt_estrategia','txt_estrategia','65','5',$estrategia,'','onkeypress="ocultarDiv(\'error_estrategia\');"');
			$form->addError('error_estrategia',ERROR_RIESGOS_ESTRATEGIA);

			$form->addEtiqueta(RIESGOS_FECHA_DETEC);
			$form->addInputDate('date','txt_fecha_deteccion','txt_fecha_deteccion',$fecha_deteccion,'%Y-%m-%d','16','16','','onChange=submit();');
			$form->addError('error_fecha_deteccion',ERROR_RIESGOS_FECHA_DETEC);

			$estados = $rieData->getEstados('1','res_id');
			$opciones=null;
			if(isset($estados)){
				foreach($estados as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(RIESGOS_ESTADO);
			$form->addSelect('select','sel_estado_edit','sel_estado_edit',$opciones,RIESGOS_ESTADO,$estado_edit,'','onkeypress="ocultarDiv(\'error_estado\');"');
			$form->addError('error_estado',ERROR_RIESGOS_ESTADO);

			$form->addInputText('hidden','sel_categoria','sel_categoria','15','15',$categoria,'','');
			$form->addInputText('hidden','sel_alcance','sel_alcance','15','15',$alcance,'','');
			$form->addInputText('hidden','sel_estado','sel_estado','15','15',$estado,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');

			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_edit_riesgo1();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_edit_riesgo1\',\'?mod=riesgos&niv=1\');"');

			$form->writeForm();

		break;
		/**
		* la variable saveEdit, permite actualizar el objeto RIESGO en la base de datos, ver la clase CRiesgoData
		*/
		case 'saveEdit':
			$id_edit   		 = $_REQUEST['txt_id'];
			$categoria 		 = $_REQUEST['sel_categoria'];
			$alcance   		 = $_REQUEST['sel_alcance'];
			$estado   		 = $_REQUEST['sel_estado'];
			$alcance_edit    = $_REQUEST['sel_alcance_edit'];
			$estado_edit     = $_REQUEST['sel_estado_edit'];

			$descripcion 	 = $_REQUEST['txt_descripcion'];
			$estrategia 	 = $_REQUEST['txt_estrategia'];
			$fecha_deteccion = $_REQUEST['txt_fecha_deteccion'];

			$riesgo = new CRiesgo($id_edit,$descripcion,$fecha_deteccion,$estrategia,'','','','',$alcance_edit,$estado_edit,$rieData);

			$m = $riesgo->saveEditRiesgo();

			echo $html->generaAviso($m,"?mod=".$modulo."&niv=".$niv."&task=list&sel_alcance=".$alcance."&sel_categoria=".$categoria."&sel_estado=".$estado."&operador=".$operador);


		break;

// *******************************************************A C C I O N E S ****************************************************************

		/**
		* la variable listAcciones, permite hacer la carga la p�gina con la lista de objetos ACCION seg�n los par�metros de entrada
		*/
		case 'listAcciones':
			$id_edit 		 = $_REQUEST['id_element'];
			$categoria       = $_REQUEST['sel_categoria'];
			$alcance         = $_REQUEST['sel_alcance'];
			$estado   		 = $_REQUEST['sel_estado'];
			$operador		 = $_REQUEST['operador'];

			$acciones = $accData->getAcciones('ri.rie_id='.$id_edit , ' ac.rac_fecha asc ');


			$dt = new CHtmlDataTable();
			$titulos = array(ACCIONES_FECHA,RIESGOS_RESPONSABLE,TABLA_ACCIONES,VALOR_IMPACTO,VALOR_PROBABILIDAD,VALOR_CATEGORIA,VALOR_MITIGACION);

			$dt->setDataRows($acciones);
			$dt->setTitleRow($titulos);

			$dt->setTitleTable(LISTAR_ACCIONES);

			if ($perfil <> PERFIL_ANALISTA_RIESGOS)
				$dt->setDeleteLink("?mod=".$modulo."&niv=".$niv."&task=deleteAccion&id_riesgo=".$id_edit."&sel_alcance=".$alcance."&sel_categoria=".$categoria."&sel_estado=".$estado."&operador=".$operador);
			$dt->setEditLink("?mod=".$modulo."&niv=".$niv."&task=editAccion&id_riesgo=".$id_edit."&sel_alcance=".$alcance."&sel_categoria=".$categoria."&sel_estado=".$estado."&operador=".$operador);

			$dt->setAddLink("?mod=".$modulo."&niv=".$niv."&task=addAccion&id_riesgo=".$id_edit."&sel_alcance=".$alcance."&sel_categoria=".$categoria."&sel_estado=".$estado."&operador=".$operador);

			$dt->setType(1);
			$pag_crit="task=listAcciones&sel_alcance=".$alcance."&sel_categoria=".$categoria."&sel_estado=".$estado."&operador=".$operador;
			$dt->setPag(1,$pag_crit);
			$dt->writeDataTable($niv);

			$link = "?mod=".$modulo."&task=list&niv=".$niv."&sel_alcance=".$alcance."&sel_categoria=".$categoria."&sel_estado=".$estado."&operador=".$operador;
			$html->generaLink($link,'cancelar.gif',BTN_CANCELAR);


		break;
		/**
		* la variable addAccion, permite hacer la carga la p�gina con las variables que componen el objeto ACCION, ver la clase CAccion
		*/
		case 'addAccion':
			$id_riesgo 		= $_REQUEST['id_riesgo'];
			$categoria      = $_REQUEST['sel_categoria'];
			$alcance        = $_REQUEST['sel_alcance'];
			$estado   		= $_REQUEST['sel_estado'];

			$responsable 	= $_REQUEST['sel_responsable'];
			$accion 		= $_REQUEST['txt_accion'];
			$fecha_accion 	= $_REQUEST['txt_fecha_accion'];
			$impacto 		= $_REQUEST['sel_impacto'];
			$probabilidad 	= $_REQUEST['sel_probabilidad'];
			$categoria_add 	= $_REQUEST['sel_categoria_add'];
			$operador 		= $_REQUEST['operador'];

			$form = new CHtmlForm();
			$form->setId('frm_add_accion1');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$form->addInputText('hidden','id_riesgo','id_riesgo','15','15',$id_riesgo,'','');

			$form->addEtiqueta(ACCIONES_FECHA);
			$form->addInputDate('date','txt_fecha_accion','txt_fecha_accion',$fecha_accion,'%Y-%m-%d','16','16','','');
			$form->addError('error_fecha_accion',ERROR_ACCIONES_FECHA);

			$responsables = $accData->getUsersEquipo('rr.rie_id='.$id_riesgo.' and da.ope_id='.$operador,'us.usu_nombre',$id_riesgo);
			$opciones=null;
			if(isset($responsables)){
				foreach($responsables as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(RIESGOS_RESPONSABLE);
			$form->addSelect('select','sel_responsable','sel_responsable',$opciones,RIESGOS_RESPONSABLE,$responsable,'','onChange=submit();');
			$form->addError('error_responsable',ERROR_ACCION_RESPONSABLE);

			$form->addEtiqueta(ACCIONES_DESCRIPCION);
			$form->addTextArea('textarea','txt_accion','txt_accion','65','5',$accion,'','onkeypress="ocultarDiv(\'error_accion\');"');
			$form->addError('error_accion',ERROR_ACCIONES_DESCRIPCION);

			$impactos = $rieData->getImpacto('1','rim_id');
			$opciones=null;
			if(isset($impactos)){
				foreach($impactos as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(RIESGOS_IMPACTO);
			$form->addSelect('select','sel_impacto','sel_impacto',$opciones,RIESGOS_IMPACTO,$impacto,'','onChange=submit();');
			$form->addError('error_impacto',ERROR_RIESGOS_IMPACTO);

			$probabilidades = $rieData->getProbabilidad('1','rpr_id');
			$opciones=null;
			if(isset($probabilidades)){
				foreach($probabilidades as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(RIESGOS_PROBABILIDAD);
			$form->addSelect('select','sel_probabilidad','sel_probabilidad',$opciones,RIESGOS_PROBABILIDAD,$probabilidad,'','onChange=submit();');
			$form->addError('error_probabilidad',ERROR_RIESGOS_PROBABILIDAD);

			$categorias = $rieData->getCategoriasCalculado($impacto,$probabilidad);
			$opciones=null;
			if(isset($categorias)){
				foreach($categorias as $t){
					$categoria_add = $t['id'];
					$categoriaNombre = $t['valor'];
				}
			}
			$form->addEtiqueta(RIESGOS_CATEGORIA);
			$form->addInputText('text','txt_categoria_nombre','txt_categoria_nombre','50','100',$categoriaNombre,'','onkeypress="ocultarDiv(\'error_categoria\');" readonly=true');
			$form->addError('error_categoria',ERROR_RIESGOS_CATEGORIA);

			$form->addInputText('hidden','sel_categoria_add','sel_categoria_add','15','15',$categoria_add,'','');
			$form->addInputText('hidden','sel_categoria','sel_categoria','15','15',$categoria,'','');
			$form->addInputText('hidden','sel_alcance','sel_alcance','15','15',$alcance,'','');
			$form->addInputText('hidden','sel_estado','sel_estado','15','15',$estado,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');

			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_add_accion1();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_add_accion1\',\'?mod='.$modulo.'&niv='.$niv.'&task=listAcciones&id_element='.$id_riesgo.'&sel_alcance='.$alcance.'&sel_categoria='.$categoria.'&sel_estado='.$estado."&operador=".$operador.'\');"');

			$form->writeForm();
		break;
		/**
		* la variable saveAddAccion, permite almacenar el objeto ACCION en la base de datos, ver la clase CAccionData
		*/
		case 'saveAddAccion':
			$riesgo 		 = $_REQUEST['id_riesgo'];
			$categoria       = $_REQUEST['sel_categoria'];
			$alcance         = $_REQUEST['sel_alcance'];
			$estado   		= $_REQUEST['sel_estado'];
			$operador		 = $_REQUEST['operador'];

			$responsable 	 = $_REQUEST['sel_responsable'];
			$accion 		 = $_REQUEST['txt_accion'];
			$fecha_accion 	 = $_REQUEST['txt_fecha_accion'];
			$impacto 		 = $_REQUEST['sel_impacto'];
			$probabilidad 	 = $_REQUEST['sel_probabilidad'];
			$categoria_add 	 = $_REQUEST['sel_categoria_add'];
			$categoriaNombre = $_REQUEST['txt_categoria_nombre'];

			$accionnueva = new CRiesgoAccion('',$riesgo,$accion,$responsable,$fecha_accion,$impacto,$probabilidad,$categoria_add,$categoriaNombre,$accData);
			$m = $accionnueva->saveNewAccion();

			echo $html->generaAviso($m,'?mod='.$modulo.'&niv='.$niv.'&task=listAcciones&id_element='.$riesgo.'&sel_alcance='.$alcance.'&sel_categoria='.$categoria.'&sel_estado='.$estado."&operador=".$operador);

		break;
		/**
		* la variable deleteAccion, permite hacer la carga del objeto ACCION y espera confirmacion de eliminarlo, ver la clase CAccion
		*/
		case 'deleteAccion':
			$id_elemento	 = $_REQUEST['id_element'];
			$categoria       = $_REQUEST['sel_categoria'];
			$alcance         = $_REQUEST['sel_alcance'];
			$estado   		= $_REQUEST['sel_estado'];

			$riesgo          = $_REQUEST['id_riesgo'];
			$id_accion 		 = $accData->getIdAccion($id_elemento,$riesgo);
			$accion = new CRiesgoAccion($id_accion,'','','','','','','','',$accData);
			$accion->loadAccion();

			$form = new CHtmlForm();
			$form->setId('frm_delete_accion1');
			$form->setMethod('post');
			$form->addInputText('hidden','id_accion','id_accion','15','15',$accion->getId(),'','');
			$form->addInputText('hidden','id_riesgo','id_riesgo','15','15',$accion->getRiesgo(),'','');
			$form->addInputText('hidden','sel_categoria','sel_categoria','15','15',$categoria,'','');
			$form->addInputText('hidden','sel_alcance','sel_alcance','15','15',$alcance,'','');
			$form->addInputText('hidden','sel_estado','sel_estado','15','15',$estado,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');

			$form->writeForm();

			echo $html->generaAdvertencia(ACCION_MSG_BORRADO,'?mod='.$modulo.'&niv='.$niv.'&task=confirmDeleteAccion&id_element='.$id_accion.'&id_riesgo='.$riesgo.'&sel_alcance='.$alcance.'&sel_categoria='.$categoria.'&sel_estado='.$estado.'&operador='.$operador,"cancelarAccion('frm_delete_accion1','?mod=".$modulo."&niv=".$niv."&task=listAcciones&id_element=".$accion->getRiesgo()."&sel_alcance=".$alcance."&sel_categoria=".$categoria."&sel_estado=".$estado."&operador=".$operador."')");

		break;
		/**
		* la variable confirmDeleteAccion, permite eliminar el objeto ACCION de la base de datos, ver la clase CAccionData
		*/
		case 'confirmDeleteAccion':
			$id_elemento	 = $_REQUEST['id_element'];
			$categoria       = $_REQUEST['sel_categoria'];
			$alcance         = $_REQUEST['sel_alcance'];
			$estado   		= $_REQUEST['sel_estado'];

			$riesgo          = $_REQUEST['id_riesgo'];
			$accion = new CRiesgoAccion($id_elemento,'','','','','','','','',$accData);
			$accion->loadAccion();

			$m = $accion->deleteAccion($riesgo);

			echo $html->generaAviso($m,'?mod='.$modulo.'&niv=1&task=listAcciones&id_element='.$accion->getRiesgo().'&sel_alcance='.$alcance.'&sel_categoria='.$categoria.'&sel_estado='.$estado.'&operador='.$operador);

		break;
		/**
		* la variable editAccion, permite hacer la carga del objeto ACCION y espera confirmacion de edicion, ver la clase CAccion
		*/
		case 'editAccion':
			$id_elemento	 = $_REQUEST['id_element'];
			$categoria       = $_REQUEST['sel_categoria'];
			$alcance         = $_REQUEST['sel_alcance'];
			$estado   		= $_REQUEST['sel_estado'];

			$riesgo          = $_REQUEST['id_riesgo'];
			$id_edit 		 = $accData->getIdAccion($id_elemento,$riesgo);

			$accion 		 = $_REQUEST['txt_accion'];
			$impacto 		 = $_REQUEST['sel_impacto'];
			$probabilidad 	 = $_REQUEST['sel_probabilidad'];
			$categoria_edit  = $_REQUEST['sel_categoria_edit'];
			$categoriaNombre = $_REQUEST['txt_categoria_nombre'];
			$operador		 = $_REQUEST['operador'];

			$acciones = new CRiesgoAccion($id_edit,'','','','','','','','',$accData);
			$acciones->loadAccion();

			if(!isset($_REQUEST['id_riesgo'])) 			$id_riesgo 		= $acciones->getRiesgo(); 		else $id_riesgo = $_REQUEST['id_riesgo'];
			if(!isset($_REQUEST['txt_accion'])) 		$accion 		= $acciones->getAccion(); 		else $accion = $_REQUEST['txt_accion'];
			if(!isset($_REQUEST['txt_fecha_accion'])) 	$fecha_accion 	= $acciones->getFechaAccion(); 	else $fecha_accion = $_REQUEST['txt_fecha_accion'];
			if(!isset($_REQUEST['sel_responsable'])) 	$responsable 	= $acciones->getResponsable(); 	else $responsable = $_REQUEST['sel_responsable'];
			if(!isset($_REQUEST['sel_impacto'])) 	 	$impacto 		= $acciones->getImpacto(); 		else $impacto = $_REQUEST['sel_impacto'];
			if(!isset($_REQUEST['sel_probabilidad'])) 	$probabilidad 	= $acciones->getProbabilidad(); else $probabilidad = $_REQUEST['sel_probabilidad'];
			if(!isset($_REQUEST['sel_categoria_edit'])) $categoria_edit = $acciones->getCategoria(); 	else $categoria_edit = $_REQUEST['sel_categoria_edit'];

			$form = new CHtmlForm();
			$form->setTitle(EDITAR_RIESGOS);

			$form->setId('frm_edit_accion1');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$form->addInputText('hidden','txt_id','txt_id','15','15',$acciones->getId(),'',' readonly=true');
			$form->addInputText('hidden','id_riesgo','id_riesgo','15','15',$id_riesgo,'',' readonly=true');

			$form->addEtiqueta(ACCIONES_FECHA);
			$form->addInputDate('date','txt_fecha_accion','txt_fecha_accion',$fecha_accion,'%Y-%m-%d','16','16','','onChange=submit();');
			$form->addError('error_fecha_accion',ERROR_ACCIONES_FECHA);

			$responsables = $accData->getUsersEquipo('rr.rie_id='.$id_riesgo.' and da.ope_id='.$operador,'us.usu_nombre',$id_riesgo);
			$opciones=null;
			if(isset($responsables)){
				foreach($responsables as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(RIESGOS_RESPONSABLE);
			$form->addSelect('select','sel_responsable','sel_responsable',$opciones,RIESGOS_RESPONSABLE,$responsable,'','onChange=submit();');
			$form->addError('error_responsable',ERROR_ACCION_RESPONSABLE);

			$form->addEtiqueta(ACCIONES_DESCRIPCION);
			$form->addTextArea('textarea','txt_accion','txt_accion','65','5',$accion,'','onkeypress="ocultarDiv(\'error_accion\');"');
			$form->addError('error_accion',ERROR_ACCIONES_DESCRIPCION);

			$impactos = $rieData->getImpacto('1','rim_id');
			$opciones=null;
			if(isset($impactos)){
				foreach($impactos as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(RIESGOS_IMPACTO);
			$form->addSelect('select','sel_impacto','sel_impacto',$opciones,RIESGOS_IMPACTO,$impacto,'','onChange=submit();');
			$form->addError('error_impacto',ERROR_RIESGOS_IMPACTO);

			$probabilidades = $rieData->getProbabilidad('1','rpr_id');
			$opciones=null;
			if(isset($probabilidades)){
				foreach($probabilidades as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(RIESGOS_PROBABILIDAD);
			$form->addSelect('select','sel_probabilidad','sel_probabilidad',$opciones,RIESGOS_PROBABILIDAD,$probabilidad,'','onChange=submit();');
			$form->addError('error_probabilidad',ERROR_RIESGOS_PROBABILIDAD);


			$categorias = $rieData->getCategoriasCalculado($impacto,$probabilidad);
			$opciones=null;
			if(isset($categorias)){
				foreach($categorias as $t){
					$categoria_edit = $t['id'];
					$categoria1 = $t['nombre'];
					$categoriaNombre = $t['valor'];
				}
			}
			$form->addEtiqueta(RIESGOS_CATEGORIA);
			$form->addInputText('text','txt_categoria_nombre','txt_categoria_nombre','50','100',$categoriaNombre,'','onkeypress="ocultarDiv(\'error_categoria\');" readonly=true');
			$form->addError('error_categoria',ERROR_RIESGOS_CATEGORIA);

			$form->addInputText('hidden','sel_categoria_edit','sel_categoria_edit','15','15',$categoria_edit,'','');
			$form->addInputText('hidden','sel_categoria','sel_categoria','15','15',$categoria,'','');
			$form->addInputText('hidden','sel_alcance','sel_alcance','15','15',$alcance,'','');
			$form->addInputText('hidden','sel_estado','sel_estado','15','15',$estado,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');

			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_edit_accion1();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_edit_accion1\',\'?mod='.$modulo.'&niv='.$niv.'&task=listAcciones&id_element='.$id_riesgo.'&sel_alcance='.$alcance.'&sel_categoria='.$categoria.'&sel_estado='.$estado.'&operador='.$operador.'\');"');

			$form->writeForm();

		break;
		/**
		* la variable saveEditAccion, permite actualizar el objeto ACCION en la base de datos, ver la clase CAccionData
		*/
		case 'saveEditAccion':
			$id_edit 		= $_REQUEST['txt_id'];
			$id_riesgo 		= $_REQUEST['id_riesgo'];
			$categoria  	= $_REQUEST['sel_categoria'];
			$alcance    	= $_REQUEST['sel_alcance'];
			$estado   		= $_REQUEST['sel_estado'];
			$operador		= $_REQUEST['operador'];

			$responsable 	= $_REQUEST['sel_responsable'];
			$accion 		= $_REQUEST['txt_accion'];
			$fecha_accion 	= $_REQUEST['txt_fecha_accion'];
			$impacto 		= $_REQUEST['sel_impacto'];
			$probabilidad 	= $_REQUEST['sel_probabilidad'];
			$categoria_edit = $_REQUEST['sel_categoria_edit'];
			$categoriaNombre= $_REQUEST['txt_categoria_nombre'];
			//echo ("<br>categoria:".$categoria);
			$accion = new CRiesgoAccion($id_edit,$id_riesgo,$accion,$responsable,$fecha_accion,$impacto,$probabilidad,$categoria_edit,$categoriaNombre,$accData);

			$m = $accion->saveEditAccion();

			echo $html->generaAviso($m,"?mod=".$modulo."&niv=".$niv."&task=listAcciones&id_element=".$id_riesgo."&sel_alcance=".$alcance."&sel_categoria=".$categoria."&sel_estado=".$estado."&operador=".$operador);

			break;

// *******************************************************R E S P O N S A B L E S*********************************************************

		/**
		* la variable listResponsables, permite hacer la carga la p�gina con la lista de objetos RESPONSABLE seg�n los par�metros de entrada
		*/
		case 'listResponsables':
			$id_edit 		= $_REQUEST['id_element'];
			$categoria      = $_REQUEST['sel_categoria'];
			$alcance        = $_REQUEST['sel_alcance'];
			$estado   		= $_REQUEST['sel_estado'];
			$operador		= $_REQUEST['operador'];
			//variables filtro cargadas en el list
			$responsable 	= $_REQUEST['sel_responsable'];

			$responsables 	= $rieData->getResponsables('cr.rie_id='.$id_edit. " and r.ope_id=".$operador,'cr.rie_id');

			$dt = new CHtmlDataTable();
			$titulos = array(COMPROMISOS_RESPONSABLE,);

			$row_responsables=null;
			$cont=0;
			if(isset($responsables)){
				foreach($responsables as $a){
					$row_responsables[$cont]['id'] = $a['id'];
					$row_responsables[$cont]['nombre'] = $a['nombre'];
					$cont++;
				}
			}

			$dt->setDataRows($row_responsables);
			$dt->setTitleRow($titulos);

			$dt->setTitleTable(TABLA_RESPONSABLES);

			$dt->setDeleteLink("?mod=".$modulo."&niv=".$niv."&task=deleteResponsable&sel_alcance=".$alcance."&sel_categoria=".$categoria."&sel_estado=".$estado."&operador=".$operador);

			$dt->setAddLink("?mod=".$modulo."&niv=".$niv."&task=addResponsable&id_riesgo=".$id_edit."&sel_alcance=".$alcance."&sel_categoria=".$categoria."&sel_estado=".$estado."&operador=".$operador);

			$dt->setType(1);

			$dt->writeDataTable($niv);
			$form = new CHtmlForm();
			$form->setId('frm_rresponsable_riesgo1');
			$form->setMethod('post');
			//variables cargadas en el list para no perder los filtros
			$form->addInputText('hidden','sel_responsable','sel_responsable','15','15',$responsable,'','');
			$form->writeForm();
			$link = "?mod=".$modulo."&task=list&niv=".$niv."&sel_alcance=".$alcance."&sel_categoria=".$categoria."&sel_estado=".$estado."&operador=".$operador;
			$html->generaLink($link,'cancelar.gif',BTN_CANCELAR);

		break;
		/**
		* la variable addResponsable, permite hacer la carga la p�gina con las variables que componen el objeto RESPONSABLE, ver la clase CRiesgoResponsable
		*/
		case 'addResponsable':
			$id_riesgo 		 = $_REQUEST['id_riesgo'];
			$categoria 		 = $_REQUEST['sel_categoria'];
			$alcance   		 = $_REQUEST['sel_alcance'];
			$estado   		 = $_REQUEST['sel_estado'];
			$operador  		 = $_REQUEST['operador'];

			$responsable_add = $_REQUEST['sel_responsable_add'];
			//variables filtro cargadas en el list
			$responsable 	 = $_REQUEST['sel_responsable'];

			$form = new CHtmlForm();
			$form->setId('frm_add_rresponsable1');
			$form->setMethod('post');
			$form->addInputText('hidden','id_riesgo','id_riesgo','15','15',$id_riesgo,'','');

			$responsables = $rieData->getResponsablesRiesgos('r.ope_id='.$operador,'r.doa_nombre');
			$opciones=null;
			if(isset($responsables)){
				foreach($responsables as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(COMPROMISOS_RESPONSABLE);
			$form->addSelect('select','sel_responsable_add','sel_responsable_add',$opciones,COMPROMISOS_RESPONSABLE,$responsable_add,'','onChange=submit();');
			$form->addError('error_responsable','');

			//variables cargadas en el list para no perder los filtros
			$form->addInputText('hidden','sel_responsable','sel_responsable','15','15',$responsable,'','');
			$form->addInputText('hidden','sel_alcance','sel_alcance','15','15',$alcance,'','');
			$form->addInputText('hidden','sel_categoria','sel_categoria','15','15',$categoria,'','');
			$form->addInputText('hidden','sel_estado','sel_estado','15','15',$estado,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');

			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_add_rresponsable1();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_add_rresponsable1\',\'?mod='.$modulo.'&niv='.$niv.'&task=listResponsables&id_element='.$id_riesgo.'&sel_alcance='.$alcance.'&sel_categoria='.$categoria.'&sel_estado='.$estado.'&operador='.$operador.'\');"');

			$form->writeForm();

		break;
		/**
		* la variable saveAddResponsable, permite almacenar el objeto RESPONSABLE en la base de datos, ver la clase CRiesgoResponsableData
		*/
		case 'saveAddResponsable':
			$riesgo 		 = $_REQUEST['id_riesgo'];
			$categoria       = $_REQUEST['sel_categoria'];
			$alcance         = $_REQUEST['sel_alcance'];
			$estado   		 = $_REQUEST['sel_estado'];
			$operador		 = $_REQUEST['operador'];

			$responsable_add = $_REQUEST['sel_responsable_add'];
			$responsable 	 = $_REQUEST['sel_responsable'];

			$responsablenuevo = new CRiesgoResponsable('',$riesgo,$responsable_add,$resData);

			$m = $responsablenuevo->saveNewResponsable();

			echo $html->generaAviso($m,'?mod='.$modulo.'&niv='.$niv.'&task=listResponsables&id_element='.$riesgo.'&sel_alcance='.$alcance.'&sel_categoria='.$categoria.'&sel_estado='.$estado."&operador=".$operador);

		break;
		/**
		* la variable deleteResponsable, permite hacer la carga del objeto RESPONSABLE y espera confirmacion de eliminarlo, ver la clase CRiesgoResponsable
		*/
		case 'deleteResponsable':
			$id_responsable  = $_REQUEST['id_element'];
			//echo("<br>id_responsable:".$id_responsable);
			$categoria       = $_REQUEST['sel_categoria'];
			$alcance         = $_REQUEST['sel_alcance'];
			$estado   		 = $_REQUEST['sel_estado'];

			$operador		 = $_REQUEST['operador'];

			$responsables = new CRiesgoResponsable($id_responsable,'','',$resData);
			$responsables->loadResponsable();

			$form = new CHtmlForm();
			$form->setId('frm_delete_rresponsable1');
			$form->setMethod('post');
			$form->addInputText('hidden','id_responsable','id_responsable','15','15',$responsables->getId(),'','');
			$form->addInputText('hidden','id_riesgo','id_riesgo','15','15',$responsables->getRiesgo(),'','');
			$form->addInputText('hidden','sel_alcance','sel_alcance','15','15',$alcance,'','');
			$form->addInputText('hidden','sel_estado','sel_estado','15','15',$estado,'','');
			$form->addInputText('hidden','sel_categoria','sel_categoria','15','15',$categoria,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');

			$form->writeForm();

			echo $html->generaAdvertencia(RESPONSABLE_MSG_BORRADO,'?mod=riesgos&niv=1&task=confirmDeleteResponsable&id_element='.$id_responsable.'&sel_alcance='.$alcance.'&sel_categoria='.$categoria.'&sel_estado='.$estado.'&operador='.$operador,"cancelarAccion('frm_delete_rresponsable1','?mod=".$modulo."&niv=1&task=listResponsables&id_element=".$responsables->getRiesgo()."&sel_alcance=".$alcance."&sel_categoria=".$categoria."&sel_estado=".$estado."&operador=".$operador."')");

		break;
		/**
		* la variable confirmDeleteResponsable, permite eliminar el objeto RESPONSABLE de la base de datos, ver la clase CRiesgoResponsableData
		*/
		case 'confirmDeleteResponsable':
			$id_responsable  = $_REQUEST['id_element'];
			$categoria       = $_REQUEST['sel_categoria'];
			$alcance         = $_REQUEST['sel_alcance'];
			$estado   		 = $_REQUEST['sel_estado'];
			$operador		 = $_REQUEST['operador'];
			$responsables = new CRiesgoResponsable($id_responsable,'','',$resData);
			$responsables->loadResponsable();
			$m = $responsables->deleteResponsable();

			echo $html->generaAviso($m,'?mod='.$modulo.'&niv=1&task=listResponsables&id_element='.$responsables->getRiesgo().'&sel_alcance='.$alcance.'&sel_categoria='.$categoria.'&sel_estado='.$estado.'&operador='.$operador);

		break;
		/**
		* la variable listResumenExcel, permite generar en excel los objetos RIESGO a partie de la base de datos
		*/
		case 'listResumenExcel':
			$form = new CHtmlForm();
			$form->setTitle(EXCEL_PROYECTOS);
			$form->setId('frm_excel_riesgos');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');
			$operador		= $_REQUEST['operador'];

			$form->addInputText('hidden','operador','operador','45','20',$operador,'','');
			$form->writeForm();
			$form->crearBoton('button','guardar',BTN_ACEPTAR,'onclick="riesgos_en_excel();"');

		break;
		/**
		* en caso de que la variable task no este definida carga la p�gina en construcci�n
		*/
		default:
			include('templates/html/under.html');

		break;
}
?>
