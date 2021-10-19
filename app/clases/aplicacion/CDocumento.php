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
* Clase Documento
*
* @package  clases
* @subpackage aplicacion
* @author Alejandro Daza
* @version 2020.01
* @copyright apdaza
*/

Class CDocumento{
	var $id = null;
	var $tipo = null;
	var $tema = null;
	var $subtema = null;
	var $fecha = null;
	var $descripcion = null;
	var $archivo = null;
	var $version = null;
	var $estado = null;
    var $operador = null;
    var $dd = null;

	var $permitidos = array('pdf','doc','xls','ppt','pptx','docx','xlsx','gif','jpg','png','tif','zip','rar');
/**
** Constructor de la clase CDocumentoData
**/
	function CDocumento($id,$tipo,$tema,$subtema,$fecha,$descripcion,$archivo,$version,$estado,$operador,$dd){
		$this->id 					= $id;
		$this->tipo 				= $tipo;
		$this->tema 				= $tema;
		$this->subtema 				= $subtema;
		$this->fecha 				= $fecha;
		$this->descripcion 			= $descripcion;
		$this->archivo 				= $archivo;
		$this->version 				= $version;
		$this->estado 				= $estado;
		$this->operador 			= $operador;
		$this->dd 					= $dd;
	}
	function getId(){					return $this->id;					}
	function getTipo(){ 				return $this->tipo;					}
	function getTema(){ 				return $this->tema;					}
	function getSubtema(){ 				return $this->subtema;				}
	function getFecha(){ 				return $this->fecha;		}
	function getDescripcion(){ 			return $this->descripcion;			}
	function getArchivo(){ 				return $this->archivo;				}
	function getVersion(){ 				return $this->version;				}
	function getEstado(){ 				return $this->estado;				}
	function getOperador(){ 			return $this->operador;				}
/**
** carga los valores de un objeto DOCUMENTO por su id para ser editados
**/
	function loadDocumento(){

		$r = $this->dd->getDocumentoById($this->id);

		if($r != -1){
			$this->tipo 				= $r['dti_id'];
			$this->tema 				= $r['dot_id'];
			$this->subtema 				= $r['dos_id'];
			$this->fecha 				= $r['doc_fecha'];
			$this->descripcion 			= $r['doc_descripcion'];
			$this->archivo 				= $r['doc_archivo'];
			$this->version 				= $r['doc_version'];
			$this->estado 				= $r['doe_id'];
			$this->operador				= $r['ope_id'];
		}else{
			$this->tipo 				= "";
			$this->tema 				= "";
			$this->subtema 				= "";
			$this->fecha 				= "";
			$this->descripcion 			= "";
			$this->archivo 				= "";
			$this->version 				= "";
			$this->estado 				= "";
			$this->operador				= "";
		}
	}
/**
** almacena un objeto DOCUMENTO y retorna un mensaje del resultado del proceso
**/
	function saveNewDocumento($archivo, $url){
		$r = "";
		$extension = explode(".",$archivo['name']);
		$num = count($extension)-1;
		$noMatch = 0;
		foreach( $this->permitidos as $p ) {
			if ( strcasecmp( $extension[$num], $p ) == 0 ) $noMatch = 1;
		}
		if($archivo['name']!=null){
			if($noMatch==1){
				if($archivo['size'] < MAX_SIZE_DOCUMENTOS){
					$tipo = $this->dd->getTipoNombreById ($this->tipo);
					$tema = $this->dd->getTemaNombreById ($this->tema);
					$subtema = $this->dd->getSubtemaNombreById ($this->subtema);
					
					$dirOperador=$this->dd->getDirectorioOperador($this->operador);
					$tipoUn = explode(' ', $tipo);
					$temaUn = explode(' ', $tema);
					$subtemaUn = explode(' ', $subtema);
					$tipoDef = $this->replace_spaces_underline($tipoUn);
					$temaDef = $this->replace_spaces_underline($temaUn);
					$subtemaDef = $this->replace_spaces_underline($subtemaUn);
					$ruta = strtolower($_SERVER['DOCUMENT_ROOT']."/".RUTA_DOCUMENTOS."d/".$dirOperador.$tipoDef."/".$temaDef."/".$subtemaDef."/");
					$cad = $_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF'];
					if (is_dir($ruta)){
						// echo "<p> existe una carpeta</p>";
						$movArchivo = move_uploaded_file($archivo['tmp_name'], $ruta.$archivo['name']);
					}else {						
						// echo "<p> Creando la carpeta en la ruta: ".$ruta."";
						mkdir($ruta,0777,true);
						$movArchivo = move_uploaded_file($archivo['tmp_name'], $ruta.$archivo['name']);
					}
					if($movArchivo == true){
						// $this->archivo=$archivo['name'];
						
						$i = $this->dd->insertDocumento($this->tipo,$this->tema,$this->subtema,$this->fecha,
						$this->descripcion,$url,$this->version,$this->estado,$this->operador);
						if($i == "true"){
							$r = DOCUMENTO_AGREGADO;
						}else{
							$r = ERROR_ADD_DOCUMENTO;
						}
					}else{
						echo "<p> No lo movio: ".$noMatch." and ".$ruta."";
						$r = ERROR_COPIAR_ARCHIVO;
					}
				}else{
					$r = ERROR_SIZE_ARCHIVO;
				}
			}else{
				$r = ERROR_FORMATO_ARCHIVO;
			}
		}else{
			$r = ERROR_CONFIGURACION_RUTA;
		}
		return $r;

	}
	function replace_spaces_underline($nombre){
		$nombreReem = '';
		for ($i=0; $i < count($nombre); $i++) { 
			if ($i == count($nombre) - 1) {
				$nombreReem .= $nombre[$i];
				break;
			}
			$nombreReem .= $nombre[$i].'_';
		}
		return $nombreReem;
	}
/**
** elimina un objeto DOCUMENTO y retorna un mensaje del resultado del proceso
**/
	function deleteDocumento($archivo){
		$tipo = $this->dd->getTipoNombreById ($this->tipo);
		$tema = $this->dd->getTemaNombreById ($this->tema);
		$subtema = $this->dd->getSubtemaNombreById ($this->subtema);
		$dirOperador=$this->dd->getDirectorioOperador($this->operador);
		$ruta = RUTA_DOCUMENTOS."/".$dirOperador.$tipo."/".$tema."/";
		chmod($ruta, 0777);
		$r = $this->dd->deleteDocumento($this->id);
		if($r=='true'){
			unlink(strtolower($ruta).$archivo);
			$msg = DOCUMENTO_BORRADO;
		}else{
			$msg = ERROR_DEL_DOCUMENTO;
		}
		return $msg;
	}
/**
** actualiza un objeto DOCUMENTO y retorna un mensaje del resultado del proceso
**/
	function saveEditDocumento($archivo,$archivo_anterior){

			$r = "";

			$extension = explode(".",$archivo['name']);
			$num = count($extension)-1;

			$noMatch = 0;
			foreach( $this->permitidos as $p ) {
				if ( strcasecmp( $extension[$num], $p ) == 0 ) $noMatch = 1;
			}

			if($archivo['name']!=null){
				if($noMatch==1){
					if($archivo['size'] < MAX_SIZE_DOCUMENTOS){
						$tipo = $this->dd->getTipoNombreById ($this->tipo);
						$tema = $this->dd->getTemaNombreById ($this->tema);
						$subtema = $this->dd->getSubtemaNombreById ($this->subtema);
						$dirOperador=$this->dd->getDirectorioOperador($this->operador);
						$ruta = RUTA_DOCUMENTOS."/".$dirOperador.$tipo."/".$tema."/";
						$carpetas = explode("/",substr($ruta,3,strlen($ruta)-1));
						$cad = $_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF'];
						$ruta_destino = '';
						foreach($carpetas as $c){
							$ruta_destino .= "/".strtolower($c);
							if(!is_dir($ruta_destino)) {
								mkdir($ruta_destino,0777);}
							else {
								chmod($ruta_destino, 0777);
							}
						}
						//echo ("<br>archivo_anterior:".$archivo_anterior);
						unlink(strtolower($ruta).$archivo_anterior);
						if(!move_uploaded_file($archivo['tmp_name'], strtolower($ruta).$archivo['name'])){
							$r = ERROR_COPIAR_ARCHIVO;
						}else{
							$this->archivo=$archivo['name'];
							$i = $this->dd->updateDocumentoArchivo($this->id,$this->tipo,$this->tema,$this->subtema,$this->fecha,
															$this->descripcion,$this->version,$this->archivo,$this->estado);
							if($i == "true"){
								$r = DOCUMENTO_EDITADO;
							}else{
								$r = ERROR_EDIT_DOCUMENTO;
							}
						}
					}else{
						$r = ERROR_SIZE_ARCHIVO;
					}
				}else{
					$r = ERROR_FORMATO_ARCHIVO;
				}
				return $r;
			}else{
				$r = $this->dd->updateDocumento($this->id,$this->tipo,$this->tema,$this->subtema,$this->fecha,
															$this->descripcion,$this->version,$this->estado);
				if($r=='true'){
					$msg = DOCUMENTO_EDITADO;
				}else{
					$msg = ERROR_EDIT_DOCUMENTO;
				}
				return $msg;
			}
	}
}
?>
