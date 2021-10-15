<?php

	$tokenPath = '/var/www/html/manageFiles/token.json'; //ruta absoluta del token obtenido
	if (file_exists($tokenPath)) {
		include("/var/www/html/manageFiles/client_google.php");
	}
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
	// $resData 		= new CCompromisoResponsableData($db);
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
			$form->addInputText('text','name_carpeta','carpeta','30','30','','','');
			$form->addInputButton('submit','','createFolder','Crear Carpeta','','');
			$form->addInputFile('file','file','file','30','','');
			$form->addInputButton('submit','','subirArchivo','Subir Archivo','','');
            $form->writeForm();
            
			echo "<h2> copia el codigo que aparece aqui abajo entre comillas! </h2>";
    		var_dump( $_GET["code"] );
    		
			if( isset( $_POST['submitlist'] ) ){
				echo "<h1> Listando contenidos de ".$_POST['text']." </h1>";
				get_files_and_folders();
			}
			
			if( isset( $_POST['listAll'] ) ){
				echo "<h1> Listando Todo </h1>";
				get_files();
			}
			
			if( isset( $_POST['createFolder'] ) ){
				echo "<h1> Folder Creado </h1>";
				create_folder($_POST['carpeta']);
			}
			
			if( isset( $_POST['subirArchivo'] ) ){
				echo "<h1> Archivo Subido </h1>";
				insert_file_to_drive($_POST['file'],'Prueba subir');
			}
			
			if( isset( $_GET['list_files_and_folders'] ) ){
    			debug_to_console($_GET);
    			//echo "<h1>Retriving List all files and folders from Google Drive</h1>";
    			get_files_and_folders();
			}
			
			
        break;
        default:
			include('templates/html/under.html');

		break;
	}
	function get_files_and_folders(){
			
				$service = new Google_Service_Drive($GLOBALS['client']);
			
				$parameters['q'] = "mimeType='application/vnd.google-apps.folder' and 'root' in parents and trashed=false";
				$files = $service->files->listFiles($parameters);
				echo "<ul>";
				foreach( $files as $k => $file ){
					//echo "<h1> comparando ".$file['name']." con".$_POST['text']."</h1>";
					
					if ($file['name'] == $_POST['text']){
						echo "<li> {$file['name']} - {$file['id']} ---- ".$file['mimeType'];
						try {
							// subfiles
							$sub_files = $service->files->listFiles(array('q' => "'{$file['id']}' in parents"));
							echo "<ul>";
							foreach( $sub_files as $kk => $sub_file ) {
								echo "<li> {$sub_file['name']} - {$sub_file['id']}  ---- ". $sub_file['mimeType'] ." </li>";
							}
							echo "</ul>";
						} catch (\Throwable $th) {            
						}
						
						echo "</li>";
					}
				}
				echo "</ul>";
			
	}
	
	function get_files(){
		$service = new Google_Service_Drive($GLOBALS['client']);

		$parameters['q'] = "mimeType='application/vnd.google-apps.folder' and 'root' in parents and trashed=false";
		$files = $service->files->listFiles($parameters);

		echo "<ul>";
		foreach( $files as $k => $file ){
		    echo "<li> {$file['name']} - {$file['id']} ---- ".$file['mimeType'];
		    try {
		        // subfiles
		        $sub_files = $service->files->listFiles(array('q' => "'{$file['id']}' in parents"));
		        echo "<ul>";
		        foreach( $sub_files as $kk => $sub_file ) {
		            echo "<li> {$sub_file['name']} - {$sub_file['id']}  ---- ". $sub_file['mimeType'] ." </li>";
		        }
		        echo "</ul>";
		    } catch (\Throwable $th) {            
		    }
		    
		    echo "</li>";
		}
		echo "</ul>";
	}
	
	function insert_file_to_drive( $file_path, $file_name, $parent_file_id = null ){
		$service = new Google_Service_Drive( $GLOBALS['client'] );
		$file = new Google_Service_Drive_DriveFile();

		$file->setName( $file_name );

		if( !empty( $parent_file_id ) ){
		    $file->setParents( [ $parent_file_id ] );        
		}

		$result = $service->files->create(
		    $file,
		    array(
		        'data' => file_get_contents($file_path),
		        'mimeType' => 'application/octet-stream',
		    )
		);

		$is_success = false;
		
		if( isset( $result['name'] ) && !empty( $result['name'] ) ){
		    $is_success = true;
		}

		return $is_success;
	}
	
	function create_folder( $folder_name, $parent_folder_id=null ){

		$folder_list = check_folder_exists( $folder_name );

		// if folder does not exists
		if( count( $folder_list ) == 0 ){
		    $service = new Google_Service_Drive( $GLOBALS['client'] );
		    $folder = new Google_Service_Drive_DriveFile();
		
		    $folder->setName( $folder_name );
		    $folder->setMimeType('application/vnd.google-apps.folder');
		    if( !empty( $parent_folder_id ) ){
		        $folder->setParents( [ $parent_folder_id ] );        
		    }

		    $result = $service->files->create( $folder );
		
		    $folder_id = null;
		    
		    if( isset( $result['id'] ) && !empty( $result['id'] ) ){
		        $folder_id = $result['id'];
		    }
		
		    return $folder_id;
		}

		return $folder_list[0]['id'];
		
	}
	
	function check_folder_exists( $folder_name ){
		
		$service = new Google_Service_Drive($GLOBALS['client']);

		$parameters['q'] = "mimeType='application/vnd.google-apps.folder' and name='$folder_name' and trashed=false";
		$files = $service->files->listFiles($parameters);

		$op = [];
		foreach( $files as $k => $file ){
		    $op[] = $file;
		}

		return $op;	
	}

?>
