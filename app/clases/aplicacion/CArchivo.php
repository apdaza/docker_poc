<?php
$tokenPath = '/var/www/html/manageFiles/token.json'; //ruta absoluta del token obtenido
if (file_exists($tokenPath)) {
    include("/var/www/html/manageFiles/client_google.php");
}

Class CArchivo{

    function CArchivo(){}

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
    function ins_file_to_folder($archiv, $fParent){
        //if( empty( $_FILES["file_documento_add"]['tmp_name'] ) ){
        if( empty( $_FILES["file"]['tmp_name'] ) ){
            echo "Go back and Select file to upload.";
            exit;
        }
        /*
        $file_tmp  = $_FILES["file_documento_add"]["tmp_name"];
        $file_type = $_FILES["file_documento_add"]["type"];
        $file_name = basename($_FILES["file_documento_add"]["name"]);*/

        $file_tmp  = $_FILES["file"]["tmp_name"];
        $file_type = $_FILES["file"]["type"];
        $file_name = basename($_FILES["file"]["name"]);
        echo "<p>".$file_tmp." - ".$file_type." - ".$file_name;
        // $path = "uploads/".$file_name;
        $path = $_SERVER['DOCUMENT_ROOT']."/".$file_name;

        move_uploaded_file($file_tmp, $path);

        $folder_id = $this->create_folder( $fParent );

        $success = $this->insert_file_to_drive( $path , $file_name, $folder_id);

        if( $success ){
            echo "file uploaded successfully";
        } else { 
            echo "Something went wrong.";
        }
    }
    function ins_file_to_folder2($archiv, $fParent, $fChild, $fGrandson){
        if( empty( $_FILES["file"]['tmp_name'] ) ){
            echo "Go back and Select file to upload.";
            exit;
        }

        $file_tmp  = $_FILES["file"]["tmp_name"];
        $file_type = $_FILES["file"]["type"];
        $file_name = basename($_FILES["file"]["name"]);
        //$path = "uploads/".$fParent."/".$fChild."/".$fGrandson."/".$file_name;
        echo "<p>".$file_tmp." - ".$file_type." - ".$file_name." - sz:".$_FILES["file"]["size"];

        //$path = "uploads/".$fParent."/".$fChild."/".$file_name;
        $path = $_SERVER['DOCUMENT_ROOT']."/".$file_name;


        move_uploaded_file($file_tmp, $path);

        $first_folder = $this->create_folder( $fParent );
        echo "<p> primera carpeta creada!</p>";
        $second_folder = $this->insert_folder_to_drive($fChild, $first_folder);
        echo "<p> segunda carpeta creada!</p>";
        $third_folder = $this->insert_folder_to_drive($fGrandson, $second_folder);

        $success = $this->insert_file_to_drive( $path , $file_name, $third_folder);

        if( $success ){
            echo "file uploaded successfully";
        } else { 
            echo "Something went wrong.";
        }
    }
    function insert_file_to_drive( $file_path, $file_name, $parent_file_id = null ){
        $service = new Google_Service_Drive($GLOBALS['client']);
        $file = new Google_Service_Drive_DriveFile();

        echo "<p> Entro archivo!</p>".$file_path." -name: ".$file_name." - sz:".$_FILES["file"]["size"];


        $file->setName( $file_name );

        if( !empty( $parent_file_id ) ){
            $file->setParents( [ $parent_file_id ] );        
        }
        $result = $service->files->create(
            $file,
            array(
                'data' => file_get_contents($file_path),
                'mimeType' => 'application/octet-stream',
                'uploadType' => 'media'
            )
        );
        $is_success = false;

        if( isset( $result['name'] ) && !empty( $result['name'] ) ){
            $is_success = true;
        }

        return $is_success;
    }
    function insert_folder_to_drive($folder_name, $parent_file_id = null ){
        $folder_list = $this->check_folder_exists( $folder_name );
        if( count( $folder_list ) == 0 ){
            $service = new Google_Service_Drive($GLOBALS['client']);
            $folder = new Google_Service_Drive_DriveFile();

            $folder->setName( $folder_name );
            $folder->setMimeType('application/vnd.google-apps.folder');
            if( !empty( $parent_file_id ) ){
                $folder->setParents( [ $parent_file_id ] );        
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
    function create_folder( $folder_name, $parent_folder_id=null ){
        $folder_list = $this->check_folder_exists( $folder_name );
        
        // if folder does not exists
        if( count( $folder_list ) == 0 ){
            $service = new Google_Service_Drive($GLOBALS['client']);
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
            echo "<li> {$file['name']} - {$file['id']} ---- ".$file['mimeType'];

        }

        return $op;	
    }
    function ins_folder_to_folder($fChild, $fParent){        

        $folder_id = $this->create_folder( $fParent );

        $success = $this->insert_folder_to_drive( $fChild, $folder_id);

        if( $success ){
            echo "folders uploaded successfully";
        } else { 
            echo "Something went wrong.";
        }
    }
    
}
?>