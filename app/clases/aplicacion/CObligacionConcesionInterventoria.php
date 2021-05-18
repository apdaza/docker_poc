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
* Clase CObligacionConcInt
*
* @package  clases
* @subpackage aplicacion
* @author Alejandro Daza
* @version 2020.01
* @copyright apdaza
*/

class CObligacionConcInt{
	var $id 			= null;
	var $obligacion_conc= null;
	var $obligacion_int	= null;
	var $cob 			= null;

/**
** Constructor de la clase CObligacionConcIntData
**/
	function CObligacionConcInt($id,$obligacion_conc,$obligacion_int,$cob){
		$this->id 				= $id;
		$this->obligacion_conc 	= $obligacion_conc;
		$this->obligacion_int	= $obligacion_int;
		$this->cob 				= $cob;
	}
	function getId(){				return $this->id;		}
	function getObligacionConc(){	return $this->obligacion_conc;	}
	function getObligacionInt(){	return $this->obligacion_int;	}


/**
** carga los valores de un objeto OBLIGACION por su id para ser editados
**/
	function loadObligacion(){
		$r = $this->cob->getObligacionById($this->id);
		if($r != -1){
			$this->componente 		= $r['componente'];
			$this->clausula 		= $r['clausula'];
			$this->literal 			= $r['literal'];
			$this->obligacion_conc	= $r['obligacion_conc'];
			$this->obligacion_int 	= $r['obligacion_int'];
		}else{
			$this->componente 		= "";
			$this->clausula 		= "";
			$this->literal 			= "";
			$this->obligacion_conc	= "";
			$this->obligacion_int	= "";
		}
	}
/**
** almacena un objeto OBLIGACION y retorna un mensaje del resultado del proceso
**/
	function saveNewObligacionConcInt(){
		$valid = $this->cob->getObligacionIdByRelacion($this->obligacion_conc,$this->obligacion_int);
		if($valid!=-1){
			$msg = OBLIGACION_EXISTENTE;
		}
		if($valid==-1){
			$r = $this->cob->insertObligacion($this->obligacion_conc,$this->obligacion_int);
			if($r=='true'){
				$msg = OBLIGACION_AGREGADO;
			}else{
				$msg = ERROR_ADD_OBLIGACION;
			}
		}
		return $msg;
	}
/**
** elimina un objeto OBLIGACION y retorna un mensaje del resultado del proceso
**/
	function deleteObligacionConcInt(){
		$r = $this->cob->deleteObligacionConcInt($this->id);
		if($r=='true'){
			$msg = OBLIGACION_BORRADO;
		}else{
			$msg = ERROR_DEL_OBLIGACION;
		}
		return $msg;
	}

}
?>
