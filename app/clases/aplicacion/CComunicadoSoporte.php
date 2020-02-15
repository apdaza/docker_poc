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
* Clase CComunicadoSoporte
*
* @package  clases
* @subpackage aplicacion
* @author Alejandro Daza
* @version 2019.02
* @copyright apdaza
*/

class CComunicadoSoporte{
	var $id = null;
	var $comunicado = null;
	var $archivo = null;
	var $cs = null;

	var $permitidos = array('pdf','doc','docx','zip', 'rar','xls','xlsx');
/**
** Constructor de la clase CComunicadoSoporteData
**/
	function CComunicadoSoporte($id,$comunicado,$archivo,$cs){
		$this->id 			= $id;
		$this->comunicado 	= $comunicado;
		$this->archivo 		= $archivo;
		$this->cs	 		= $cs;
	}
	function getId(){			return $this->id;		}
	function getComunicado(){	return $this->comunicado;	}
	function getArchivo(){		return $this->archivo;	}

/**
** carga los valores de un objeto SOPORTE por su id para ser editados
**/
	function loadSoporte(){
		$r = $this->cs->getSoporteById($this->id);
		if($r != -1){
			$this->comunicado 	= $r["doc_id"];
			$this->archivo 		= $r["dcs_archivo"];
		}else{
			$this->comunicado 	= "";
			$this->archivo 		= "";
		}
	}
/**
** almacena un objeto SOPORTE y retorna un mensaje del resultado del proceso
**/
	function saveNewSoporte($operador,$tipo,$tema){

		$r = "";
		$extension = explode(".",$this->archivo['name']);
		$num = count($extension)-1;
		$noMatch = 0;
		foreach( $this->permitidos as $p ) {
			if ( strcasecmp( $extension[$num], $p ) == 0 ) $noMatch = 1;
		}
		if($this->archivo['name']!=null){
			if($noMatch==1){
				if($this->archivo['size'] < MAX_SIZE_DOCUMENTOS){

					$dirOperador=$this->cs->getDirectorioOperador($operador);
					$ruta = strtolower(RUTA_DOCUMENTOS."/".$dirOperador.$this->cs->getTipoNombreById ($tipo)."/".$this->cs->getTemaNombreById ($tema)."/");
					mkdir($ruta,0777,true);
					$cad = $_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF'];
					//echo("<br>ruta:".$ruta);

					if(!move_uploaded_file($this->archivo['tmp_name'], strtolower($ruta).$this->comunicado.'_'.$this->archivo['name'])){
						$r = ERROR_COPIAR_ARCHIVO;
					}else{
						$i = $this->cs->insertSoporte('',$this->comunicado,$this->comunicado."_".$this->archivo['name']);
						if($i == "true"){
							$r = COMUNICADO_SOPORTE_AGREGADO;
						}else{
							$r = ERROR_ADD_COMUNICADO_SOPORTE;
						}
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
/**
** elimina un objeto SOPORTE y retorna un mensaje del resultado del proceso
**/
	function deleteSoporte(){
		$dirOperador=$this->cs->getDirectorioOperador($operador);
		$ruta = RUTA_DOCUMENTOS."/".$dirOperador."comunicados/";
		chmod($ruta, 0777);
		$r = $this->cs->deleteSoporte($this->id);
		if($r=='true'){
			unlink(strtolower($ruta).$this->archivo);
			$msg = COMUNICADO_SOPORTE_BORRADO;
		}else{
			$msg = ERROR_DEL_COMUNICADO_SOPORTE;
		}
		return $msg;
	}

}
?>
