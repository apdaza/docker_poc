<?php
	/*
	$tokenPath = '/var/www/html/manageFiles/token.json'; //ruta absoluta del token obtenido
	if (file_exists($tokenPath)) {
		include("/var/www/html/manageFiles/client_google.php");
	}*/
/**
* Sistema GPC
*
*<ul>
* <li> MadeOpen <madeopensoftware.com></li>
* <li> Proyecto KBT </li>
*</ul>
*/
	//defined('_VALID_PRY') or die('Restricted access');
	//$archivo 		= new CArchivo();
    $operador       = $_REQUEST['operador'];
	$task 			= $_REQUEST['task'];
	if(empty($task)) $task = 'list';

	switch($task){
        /**
		* la variable list, permite hacer la carga la página para obtener el token
		*/
		case 'list':
            $form = new CHtmlForm();

			$form->setTitle(OBTENCION_TOKEN);
			$form->setId('frm_get_token');
			$form->setMethod('get');
			$form->setClassEtiquetas('td_label');
            $form->writeForm();
			echo "<h6>".GET_CODE."</h6>";
    		var_dump( $_GET["code"] );
        break;
        default:
			include('templates/html/under.html');

		break;
	}

?>
