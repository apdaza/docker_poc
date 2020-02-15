<?php
/**
*
*
*<ul>
* <li> MadeOpen <madeopensoftware.com></li>
*<li> Proyecto PNCAV</li>
*</ul>
*/

/**
* cierra la sesion para el sistema y carga la ventana del login
*
* @package  modulos
* @author Alejandro Daza
* @version 2019.02
* @copyright SERTIC - MINTICS
*/

//no permite el acceso directo
	defined('_VALID_PRY') or die('Restricted access to this option');
	
	$_SESSION["usuario"]="";
	$_SESSION["clave"]="";
	
	$form = new CHtmlForm();
	
	$form->setId('frm_login');
	$form->setMethod('post');
	$form->setSpaces(1);
	$form->setClassEtiquetas('td_label');
	$form->addEtiqueta(USUARIO_LOGIN);
        $form->setOptions('autoClean', false);
        
	$form->addInputText('text','txt_login_session','txt_login_session','15','15','','','onkeypress="ocultarDiv(\'error_login\');"');
	$form->addError('error_login',ERROR_LOGIN);
	
	$form->addEtiqueta(USUARIO_PASSWORD);
	$form->addInputText('password','txt_password_session','txt_password_session','15','15','','','onkeypress="ocultarDiv(\'error_password\');"');
	$form->addError('error_password',ERROR_PASSWORD);
	
	$usuario = new CUsuario($id_usuario,$du);
	$usuario->loadSeeUser();
	$form->addInputText('hidden','txt_estado','txt_estado','15','15',$usuario->getEstado(),'','');
	
	$form->addInputButton('button','ok','ok',BTN_INGRESAR,'button','onclick="validar_login();"');
	
	$form->writeForm();
        
?>

