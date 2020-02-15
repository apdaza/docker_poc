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
* Clase Inventario
*
* @package  clases
* @subpackage aplicacion
* @author Alejandro Daza
* @version 2019.02
* @copyright apdaza
*/

class CInventario{
	var $id = null;
	var $grupo = null;
	var $equipo = null;
	var $marca = null;
	var $modelo 		=  null;
	var $serie	 		=  null;
	var $placa	 		=  null;
	var $fecha_compra	=  null;
	var $estado 		=  null;
	var $descripcion = null;
	var $ii 			=  null;
/**
** Constructor de la clase CInvolucradoInventarioData
**/
	function CInventario($id,$grupo,$equipo,$marca,$modelo,$serie,$placa,$fecha_compra,$estado,$descripcion,$ii){
		$this->id 			=  $id;
		$this->grupo 	=  $grupo;
		$this->equipo 		=  $equipo;
		$this->marca 		=  $marca;
		$this->modelo		=  $modelo;
		$this->serie		=  $serie;
		$this->placa		=  $placa;
		$this->fecha_compra	=  $fecha_compra;
		$this->estado		=  $estado;
		$this->descripcion = $descripcion;
		$this->ii 			=  $ii;
	}
	function getId(){ 			return	$this->id; }
	function getGrupo(){ 	return	$this->grupo; }
	function getEquipo(){ 		return	$this->equipo; }
	function getMarca(){ 		return	$this->marca; }
	function getModelo(){ 		return	$this->modelo; }
	function getSerie(){ 		return	$this->serie; }
	function getPlaca(){ 		return	$this->placa; }
	function getFechaCompra(){	return	$this->fecha_compra; }
	function getEstado(){ 		return	$this->estado; }
	function getDescripcion(){ 		return	$this->descripcion; }
/**
** carga los valores de un objeto EQUIPO por su id para ser editados
**/
	function loadEquipo(){
			$r = $this->ii->getEquipoById($this->id);
			if($r != -1){
				$this->id 			=  $r['ini_id'];
				$this->grupo 	=  $r['ivg_id'];
				$this->equipo 		=  $r['ine_id'];
				$this->marca 		=  $r['inm_id'];
				$this->modelo		=  $r['ini_modelo'];
				$this->serie		=  $r['ini_serie'];
				$this->placa		=  $r['ini_placa'];
				$this->fecha_compra	=  $r['ini_fecha_compra'];
				$this->estado		=  $r['ies_id'];
				$this->descripcion = $r['ini_descripcion'];
			}else{
				$this->id 			=  "";
				$this->grupo 	=  "";
				$this->equipo 		=  "";
				$this->marca 		=  "";
				$this->modelo		=  "";
				$this->serie		=  "";
				$this->placa		=  "";
				$this->fecha_compra	=  "";
				$this->estado		=  "";
				$this->descripcion = "";
			}
	}
/**
** almacena un objeto VISITA y retorna un mensaje del resultado del proceso
**/
	function saveNewEquipo(){
		$r = $this->ii->insertEquipo($this->grupo,$this->equipo,$this->marca,$this->modelo,$this->serie,$this->placa,$this->fecha_compra,$this->estado,$this->descripcion);
		if($r=='true'){
			$msg = INVENTARIO_AGREGADO;
		}else{
			$msg = ERROR_ADD_INVENTARIO;
		}
		return $msg;
	}
/**
** elimina un objeto VISITA y retorna un mensaje del resultado del proceso
**/
	function deleteEquipo(){
		$r = $this->ii->deleteEquipo($this->id);
		if($r=='true'){
			$msg = INVENTARIO_BORRADO;
		}else{
			$msg = ERROR_DEL_INVENTARIO;
		}

		return $msg;

	}

/**
** actualiza un objeto VISITA y retorna un mensaje del resultado del proceso
**/
	function saveEditEquipo(){
		$r = $this->ii->updateEquipo($this->id,$this->grupo,$this->equipo,$this->marca,$this->modelo,$this->serie,$this->placa,$this->fecha_compra,$this->estado,$this->descripcion);
		if($r=='true'){
			$msg = INVENTARIO_EDITADO;
		}else{
			$msg = ERROR_EDIT_INVENTARIO;
		}
		return $msg;
	}

}
?>
