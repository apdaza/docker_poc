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
* Clase ObligacionTraza
*
* @package  clases
* @subpackage aplicacion
* @author Alejandro Daza
* @version 2020.01
* @copyright apdaza
*/

class CObligacionTraza{
	var $id 		 	= null;
	var $obligacion		= null;
	var $anio 	 		= null;
	var $mes 	 		= null;
	var $estado 		= null;
	var $evidencia 		= null;
	var $gestion 		= null;
	var $recomendacion  = null;
	var $archivo 	 	= null;
	var $obt 		 	= null;

	var $permitidos = array('pdf','doc','xls','docx','xlsx','zip','rar','msg','ppt','ppt');

/**
** Constructor de la clase CObligacionData
**/
	function CObligacionTraza($id,$obligacion,$anio,$mes,$estado,$evidencia,$gestion,$recomendacion,$archivo,$obt){
		$this->id 			= $id;
		$this->obligacion	= $obligacion;
		$this->anio 	 	= $anio;
		$this->mes 	 		= $mes;
		$this->estado 		= $estado;
		$this->evidencia 	= $evidencia;
		$this->gestion 		= $gestion;
		$this->recomendacion= $recomendacion;
		$this->archivo 	 	= $archivo;
		$this->obt	 		= $obt;
	}
	function getId(){			return $this->id;		}
	function getObligacion(){	return $this->obligacion;	}
	function getAnio(){			return $this->anio;	}
	function getMes(){			return $this->mes;	}
	function getEstado(){		return $this->estado;	}
	function getEvidencia(){	return $this->evidencia;	}
	function getGestion(){		return $this->gestion;	}
	function getRecomendacion(){return $this->recomendacion;	}
	function getArchivo(){		return $this->archivo;	}

/**
** carga los valores de un objeto TRAZABILIDAD por su id para ser editados
**/
	function loadTraza(){
		$r = $this->obt->getObligacionTrazaById($this->id);
		if($r != -1){
			$this->obligacion	= $r["ocs_id"];
			$this->anio 	 	= $r["oct_anio"];
			$this->mes 	 		= $r["oct_mes"];
			$this->estado 		= $r["obe_id"];
			$this->evidencia 	= $r["oct_evidencia"];
			$this->gestion 		= $r["oct_gestion"];
			$this->recomendacion= $r["oct_recomendacion"];
			$this->archivo 	 	= $r["oct_archivo"];
		}else{
			$this->obligacion	= "";
			$this->anio 	 	= "";
			$this->mes 	 		= "";
			$this->estado 		= "";
			$this->evidencia 	= "";
			$this->gestion 		= "";
			$this->recomendacion= "";
			$this->archivo 	 	= "";
		}
	}
/**
** almacena un objeto TRAZABILIDAD y retorna un mensaje del resultado del proceso
**/
	function saveNewTraza($operador){
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

					$dirOperador=$this->obt->getDirectorioOperador($operador);
					$ruta = strtolower(RUTA_DOCUMENTOS."/".$dirOperador."obligaciones/");
					//$ruta = RUTA_DOCUMENTOS."/".$dirOperador."obligaciones/";
					$cad = $_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF'];

					mkdir($ruta,0777,true);

					if(!move_uploaded_file($this->archivo['tmp_name'], strtolower($ruta).$this->anio."_".$this->mes."_".$this->obligacion."_".$this->archivo['name'])){
						$r = ERROR_COPIAR_ARCHIVO;
					}else{
						$i = $this->obt->insertObligacionTraza($this->obligacion,$this->anio,$this->mes,$this->estado,$this->evidencia,$this->gestion,$this->recomendacion,$this->anio."_".$this->mes."_".$this->obligacion."_".$this->archivo['name']);
						if($i == "true"){
							$r = TRAZA_AGREGADO;
						}else{
							$r = ERROR_ADD_TRAZA;
						}
					}
				}else{
					$r = ERROR_SIZE_ARCHIVO;
				}
			}else{
				$r = ERROR_FORMATO_ARCHIVO;
			}
		}else{
			$i = $this->obt->insertObligacionTraza($this->obligacion,$this->anio,$this->mes,$this->estado,$this->evidencia,$this->gestion,$this->recomendacion,"");
			if($i == "true"){
				$r = TRAZA_AGREGADO;
			}else{
				$r = ERROR_ADD_TRAZA;
			}
		}
		return $r;

	}
/**
** elimina un objeto TRAZABILIDAD y retorna un mensaje del resultado del proceso
**/
	function deleteObligacionTraza(){
		$dirOperador=$this->obt->getDirectorioOperador($operador);
		$ruta = RUTA_DOCUMENTOS."/".$dirOperador."obligaciones/";
		chmod($ruta, 0777);
		$r = $this->obt->deleteObligacionTraza($this->id);
		if($r=='true'){
			unlink(strtolower($ruta).$this->archivo);
			$msg = TRAZA_BORRADO;
		}else{
			$msg = ERROR_DEL_TRAZA;
		}
		return $msg;
	}
/**
** actualiza un objeto TRAZABILIDAD y retorna un mensaje del resultado del proceso
**/
	function saveEditTraza($operador,$archivo_anterior){
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
					$dirOperador=$this->obt->getDirectorioOperador($this->operador);
					$ruta = strtolower(RUTA_DOCUMENTOS."/".$dirOperador."obligaciones/");
					//$ruta = RUTA_DOCUMENTOS."/".$dirOperador."obligaciones/";
					$cad = $_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF'];

					mkdir($ruta,0777,true);
					//echo ("<br>archivo_anterior:".$archivo_anterior);
					unlink(strtolower($ruta).$archivo_anterior);
					if(!move_uploaded_file($this->archivo['tmp_name'], strtolower($ruta).$this->archivo['name'])){
						$r = ERROR_COPIAR_ARCHIVO;
					}else{
						$i = $this->obt->updateObligacionTrazaArchivo($this->id,$this->obligacion,$this->anio,$this->mes,$this->estado,$this->evidencia,$this->gestion,$this->recomendacion,$this->archivo['name']);
						if($i == "true"){
							$r = TRAZA_EDITADA;
						}else{
							$r = ERROR_EDIT_TRAZA;
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
			$r = $this->obt->updateObligacionTraza($this->id,$this->obligacion,$this->anio,$this->mes,$this->estado,$this->evidencia,$this->gestion,$this->recomendacion);
			if($r=='true'){
				$msg = TRAZA_EDITADA;
			}else{
				$msg = ERROR_EDIT_TRAZA;
			}
			return $msg;
		}
	}

}
?>
