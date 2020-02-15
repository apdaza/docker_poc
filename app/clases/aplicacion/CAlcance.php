<?php
/**
*Gestion Interventoria - Fenix
*
*<ul>
*<li> Redcom Ltda <www.redcom.com.co></li>
*<li> Proyecto RUNT</li>
*</ul>
*/

/**
* Clase Alcance
*
* @package  clases
* @subpackage aplicacion
* @author Redcom Ltda
* @version 2013.01.00
* @copyright Ministerio de Transporte
*/

class CAlcance{
	var $id = null;
	var $nombre = null;
	var $fecha_registro = null;
	var $responsable_contratante = null;
	var $responsable_contratista = null;
	var $responsable_interventoria = null;
    var $reunion = null;
	var $estado = null;
	var $observaciones = null;
	var $registro = null;
	var $operador = null;
	var $da = null;
/**
** Constructor de la clase CAlcanceData
**/					
	function CAlcance($id,$nombre,$fecha_registro,$responsable_contratante,$responsable_contratista,$responsable_interventoria,$reunion,$estado,$observaciones,$registro,$operador,$da){
		$this->id 						= $id;
		$this->nombre 					= $nombre;
		$this->fecha_registro 			= $fecha_registro;
		$this->responsable_contratante 	= $responsable_contratante;
		$this->responsable_contratista 	= $responsable_contratista;
		$this->responsable_interventoria= $responsable_interventoria;
		$this->reunion 					= $reunion;
		$this->estado 					= $estado;
		$this->observaciones 			= $observaciones;
		$this->registro					= $registro;
		$this->operador 				= $operador; 
		$this->da 						= $da;
	}
	function getId(){						return $this->id;						}
	function getNombre(){					return $this->nombre;					}
	function getFechaRegistro(){			return $this->fecha_registro;			}
	function getResponsableContratante(){	return $this->responsable_contratante;	}
	function getResponsableContratista(){	return $this->responsable_contratista;	}
	function getResponsableInterventoria(){	return $this->responsable_interventoria;}
	function getReunion(){					return $this->reunion;					}
	function getEstado(){					return $this->estado;					}
	function getObservaciones(){			return $this->observaciones;			}
	function getRegistro(){					return $this->registro;					}
	function getOperador(){					return $this->operador;					}
/**
** carga los valores de un objeto ALCANCE por su id para ser editados
**/				
	function loadAlcance(){
		$r = $this->da->getAlcanceById($this->id);
		if($r != -1){
			$this->nombre 					= $r['nombre'];
			$this->fecha_registro 			= $r['fecha_registro'];
			$this->responsable_contratante 	= $r['contratante'];
			$this->responsable_contratista 	= $r['contratista'];
			$this->responsable_interventoria= $r['interventoria'];
			$this->reunion 					= $r['reunion'];
			$this->estado 					= $r['estado'];
			$this->observaciones 			= $r['observaciones'];
			$this->registro 				= $r['registro'];
			$this->operador 				= "";
		}else{
			$this->nombre 					= "";
			$this->fecha_registro 			= "";
			$this->responsable_contratante 	= "";
			$this->responsable_contratista 	= "";
			$this->responsable_interventoria= "";
			$this->reunion 					= "";
			$this->estado 					= "";
			$this->observaciones 			= "";
			$this->registro 				= "";
			$this->operador 				= "";
		}
	
	}
/**
** carga los valores de un objeto ALCANCE por su id para ser visualizados
**/				
	function loadSeeAlcance(){
		$r = $this->da->getAlcanceSeeById($this->id);
		if($r != -1){
			$this->nombre 					= $r['nombre'];
			$this->fecha_registro 			= $r['fecha_registro'];
			$this->responsable_contratante 	= $r['contratante'];
			$this->responsable_contratista 	= $r['contratista'];
			$this->responsable_interventoria= $r['interventoria'];
			$this->reunion 					= $r['reunion'];
			$this->estado 					= $r['estado'];
			$this->observaciones 			= $r['observaciones'];
			$this->registro		 			= $r['registro'];
			$this->operador 				= "";

		}else{
			$this->nombre 					= "";
			$this->fecha_registro 			= "";
			$this->responsable_contratante 	= "";
			$this->responsable_contratista 	= "";
			$this->responsable_interventoria= "";
			$this->reunion 					= "";
			$this->estado 					= "";
			$this->observaciones 			= "";
			$this->operador 				= "";
		}
	}
/**
** almacena un objeto ALCANCE y retorna un mensaje del resultado del proceso
**/				
	function saveNewAlcance(){
		$valid = $this->da->getAlcanceIdByNombre($this->nombre);
		if($valid!=-1){
			$msg = ALCANCE_EXISTENTE;
		}
		if($valid==-1){
			$r = $this->da->insertAlcance($this->nombre,$this->fecha_registro,$this->responsable_contratante,
											$this->responsable_contratista,$this->responsable_interventoria,$this->reunion,
											$this->estado,$this->observaciones,$this->registro,$this->operador);
			if($r=='true'){
				$this->id = $this->da->getAlcanceIdByNombre($this->nombre);
				$msg = ALCANCE_AGREGADA;
			}else{
				$msg = ERROR_ADD_ALCANCE;
			}
		}
		return $msg;
	}
/**
** elimina un objeto ALCANCE y retorna un mensaje del resultado del proceso
**/				
	function deleteAlcance(){
		$r = $this->da->deleteAlcance($this->id);
		if($r=='true'){
			$msg = ALCANCE_BORRADO;		
		}else{
			$msg = ERROR_DEL_ALCANCE;
		}
		return $msg;
	
	}
/**
** actualiza un objeto ALCANCE y retorna un mensaje del resultado del proceso
**/				
	function saveEditAlcance(){
		$valid = $this->da->getCountAlcancesByNombre($this->nombre);
		if($valid>1){
			$msg = ALCANCE_EXISTENTE;
		}else{
			$r = $this->da->updateAlcance($this->id,$this->nombre,$this->fecha_registro,$this->responsable_contratante,
											$this->responsable_contratista,$this->responsable_interventoria,$this->reunion,
											$this->estado,$this->registro,$this->observaciones);
			if($r=='true'){
				$msg = ALCANCE_EDITADA;
			}else{
				$msg = ERROR_EDIT_ALCANCE;
			}
		}
		return $msg;
	}
}
?>