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
	// $comData 		= new CCompromisoData($db);
	// $docData 		= new CDocumentoData($db);
	$archivo 		= new CArchivo();
    $operador       = $_REQUEST['operador'];
	$task 			= $_REQUEST['task'];
	if(empty($task)) $task = 'list';

	switch($task){
        /**
		* la variable list, permite hacer la carga la página con la lista de objetos COMPROMISO según los parámetros de entrada
		*/
		case 'list':
            $form = new CHtmlForm();

			$form->setTitle(MANEJO_DE_ARCHIVOS);
			$form->setId('frm_mng_archivos');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');
			$form->addEtiqueta(listar_por_carpeta);
			$form->addInputText('text','txt_archivos','text','30','30','','','');
			$form->addInputButton('submit', '', 'submitlist', 'Listar Por Carpeta', '','');
			$form->addInputButton('submit','','listAll','Listar Todo','','');
			$form->addInputText('text','name_carpeta','carpeta','30','100','','','');
			$form->addInputButton('submit','','createFolder','Crear Carpeta','','');
			$form->addInputFile('file','file','file','30','','');
			$form->addInputButton('submit','','subirArchivo','Subir Archivo','','');
			$form->addInputButton('submit','','borrarArchivo','Borrar Archivo','','');
            $form->writeForm();
            
			echo "<h2> copia el codigo que aparece aqui abajo entre comillas! </h2>";
    		var_dump( $_GET["code"] );
    		
			if( isset( $_POST['submitlist'] ) ){
				echo "<h1> Listando contenidos de ".$_POST['text']." </h1>";
				
				$archivo->get_files_and_folders();
			}
			
			if( isset( $_POST['listAll'] ) ){
				echo "<h1> Listando Todo </h1>";
				
				$archivo->get_files();
			}
			
			if( isset( $_POST['createFolder'] ) ){
				// $ids = $archivo->create_folder($_POST['carpeta'], '1we528c5R_U0EWi6ybDlJApkH2c8zO9ST');
				$ids = $archivo->check_folder_exists_and_get_id($_POST['carpeta']);
				echo "<h6> Folder id: ".$ids[0]."</h6>";
				/*
				foreach( $ids as $i => $folder_id ){

					echo "<h6> Folder id: ".$folder_id."</h6>";
				}*/
				//$archivo->ins_folder_to_folder("testHijo", $_POST['carpeta']);
			}
			
			if( isset( $_POST['subirArchivo'] ) ){
				
				$archivo->ins_file_to_folder2($_FILES['file'], $_POST['carpeta'],'test2', 'test3');
				// $archivo->ins_file_to_folder($_POST['file'], $_POST['carpeta']);
				// echo "<h1> Archivo Subido </h1>";
			}
			if( isset( $_POST['borrarArchivo'] ) ){
				// $archivo->deleteFile($_POST['carpeta']);
				$name_file = $archivo->check_file_exists($_POST['carpeta']);
				echo "<h4> nombre del archivo: ".$name_file['name'];
			}
			
			if( isset( $_GET['list_files_and_folders'] ) ){
    			echo "<h1>Retriving List all files and folders from Google Drive</h1>";
    			
				$archivo->get_files_and_folders();
			}
			
			
        break;
        default:
			include('templates/html/under.html');

		break;
	}

?>
