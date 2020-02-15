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
* Clase RiesgoAccionData
* Usada para la definicion de todas las funciones propias del objeto RIESGO_ACCION
*
* @package  clases
* @subpackage datos
* @author Alejandro Daza
* @version 2019.02
* @copyright apdaza
*/
Class CRiesgoAccionData{
    var $db = null;

	function CRiesgoAccionData($db){
		$this->db = $db;
	}

	function getAcciones($criterio,$orden){
		$riesgos = null;
		$sql = "select ac.rac_fecha,ac.rac_id, ri.rie_id, ac.rac_descripcion, us.usu_nombre, us.usu_apellido,
				ac.rac_fecha, ac.rim_id, ac.rpr_id, ac.rca_id, imp.rim_nombre,imp.rim_valor,
				pro.rpr_nombre,pro.rpr_valor, cat.rca_nombre, ac.rca_valor
				from riesgo_accion ac
				inner join riesgo ri on ac.rie_id = ri.rie_id
				inner join documento_equipo de on ac.deq_id = de.deq_id
				inner join usuario us on de.usu_id = us.usu_id
				inner join riesgo_impacto imp on imp.rim_id = ac.rim_id
				inner join riesgo_probabilidad pro on pro.rpr_id = ac.rpr_id
				inner join riesgo_categoria cat on cat.rca_id = ac.rca_id
				where  ". $criterio ." order by ".$orden ;
		//echo ("<br>getAcciones:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$tabla='riesgo_accion ac inner join riesgo ri on ac.rie_id = ri.rie_id';
				$campo='ac.rca_valor';
				$predicado= $criterio ." and ac.rac_fecha < '". $w['rac_fecha'] ."' order by ac.rac_fecha DESC LIMIT 1 ";
				$categoria = $this->db->recuperarCampo($tabla,$campo,$predicado);
				$riesgos[$cont]['id'] = $w['rac_fecha'];
				$riesgos[$cont]['rac_fecha'] = $w['rac_fecha'];
				$riesgos[$cont]['nombre'] = $w['usu_nombre'].' '.$w['usu_apellido'];
				$riesgos[$cont]['rac_descripcion'] = $w['rac_descripcion'];
				$riesgos[$cont]['rim_nombre'] = $w['rim_nombre'];
				$riesgos[$cont]['rpr_nombre'] = $w['rpr_nombre'];
				$riesgos[$cont]['rca_valor'] = $w['rca_nombre'].'<br>'.number_format(100*$w['rca_valor']).'%';
				if($categoria!=""){
					$mitigacion = number_format(100*($categoria-$w['rca_valor']));
					if($mitigacion>0){
						$riesgos[$cont]['rca_mitigacion'] = 'Mejoró<br>'.$mitigacion.'%';
					}elseif($mitigacion==0){
						$riesgos[$cont]['rca_mitigacion'] = 'Siguió igual';
					}
					else{
						$riesgos[$cont]['rca_mitigacion'] = 'Empeoró<br>'.abs($mitigacion).'%';
					}
				}else
				{
					$riesgos[$cont]['rca_mitigacion'] = 'No aplica';
				}
                $cont++;
			}
		}
		return $riesgos;
	}

	function getIdAccion($fecha,$riesgo){
		$tabla='riesgo_accion';
		$campo='rac_id';
		$predicado= " rac_fecha = '". $fecha."' and rie_id=".$riesgo;
		$accion = $this->db->recuperarCampo($tabla,$campo,$predicado);
		if($accion) return $accion; else return -1;
	}
	function getUsersEquipo($criterio,$orden,$riesgo){
		$users = null;
		$sql = "select distinct de.deq_id,us.usu_nombre,us.usu_apellido
				from riesgo_responsable rr
				inner join documento_actor  da on da.doa_id = rr.doa_id
				inner join documento_equipo de on da.doa_id = de.doa_id
				inner join usuario          us on de.usu_id = us.usu_id
				where  ". $criterio ." order by ".$orden;
		//echo ($sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$users[$cont]['id'] = $w['deq_id'];
				$users[$cont]['nombre'] = $w['usu_nombre'].' '.$w['usu_apellido'];
				$cont++;
			}
		}
		return $users;
	}

	function getAccionById($id){
		$sql = "select ac.rac_id,ac.rie_id,ac.rac_descripcion,ac.deq_id, ac.rac_fecha,ac.rim_id,ac.rpr_id
				from riesgo_accion ac
				inner join riesgo ri on ac.rie_id = ri.rie_id
				where ac.rac_id= ".$id;
		//echo $sql;
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r) return $r; else return -1;
	}

	function getAccionByIdSee($id){
		$sql = "select ac.rac_id,ac.rac_descripcion, us.usu_nombre, us.usu_apellido,ac.rac_fecha
				from riesgo_accion ac
				inner join riesgo ri on ac.rie_id = ri.rie_id
				inner join documento_actor da on ri.doa_id = da.doa_id
				inner join documento_equipo de on da.doa_id = de.doa_id
				inner join usuario us on de.usu_id = us.usu_id
				where ac.rac_id= ".$id;
		//echo $sql;
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r) return $r; else return -1;

	}

	function insertAccion($riesgo,$accion,$responsable,$impacto,$probabilidad,$categoria,$categoriaNombre,$fecha_accion){
		$tabla = "riesgo_accion";
		$campos = "rie_id,rac_descripcion,deq_id,rac_fecha,rim_id,rpr_id,rca_id,rca_valor";
		$valores = "'".$riesgo."','".$accion."','".$responsable."','".$fecha_accion."','".$impacto."','".$probabilidad."','".$categoria."','".$categoriaNombre."'";
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		//leer la ultima accion por fecha y cargar esos valores en el riesgo
		if($r){
			$x = null;
			$sql = "select *
					from riesgo_accion
					where rie_id=".$riesgo." order by rac_fecha desc limit 1";
			$x = mysqli_fetch_array($this->db->ejecutarConsulta($sql));
			$tabla = "riesgo";
			$campos = array('rim_id','rpr_id','rca_id','rie_fecha_actualizacion');
			$valores = array("'".$x['rim_id']."'","'".$x['rpr_id']."'",
							 "'".$x['rca_id']."'","'".$x['rac_fecha']."'");
			$condicion = "rie_id = ".$riesgo;
			$this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		}
		return $r;
	}

	function updateAccion($id,$riesgo,$accion,$responsable,$fecha_accion,$impacto,$probabilidad,$categoria,$categoriaNombre){
		$tabla = "riesgo_accion";
		$campos = array('rie_id', 'rac_descripcion', 'deq_id','rim_id','rpr_id','rca_id','rca_valor','rac_fecha');
		$valores = array("".$riesgo."","'".$accion."'","".$responsable."",
							"'".$impacto."'","'".$probabilidad."'","'".$categoria."'","'".$categoriaNombre."'","'".$fecha_accion."'");
		$condicion = "rac_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		//leer la ultima accion por fecha y cargar esos valores en el riesgo
		if($r){
			$x = null;
			$sql = "select *
					from riesgo_accion
					where rie_id=".$riesgo." order by rac_fecha desc limit 1";
			$x = mysqli_fetch_array($this->db->ejecutarConsulta($sql));
			$tabla = "riesgo";
			$campos = array('rim_id','rpr_id','rca_id','rie_fecha_actualizacion');
			$valores = array("'".$x['rim_id']."'","'".$x['rpr_id']."'",
							 "'".$x['rca_id']."'","'".$x['rac_fecha']."'");
			$condicion = "rie_id = ".$riesgo;
			$this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		}
		return $r;
	}

	function deleteAccion($id,$riesgo){
		$tabla = "riesgo_accion";
		$predicado = "rac_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		if($r){
			$x = null;
			$sql = "select *
					from riesgo_accion
					where rie_id=".$riesgo." order by rac_fecha desc limit 1";
			$x = mysqli_fetch_array($this->db->ejecutarConsulta($sql));
			$tabla = "riesgo";
			$campos = array('rim_id','rpr_id','rca_id','rie_fecha_actualizacion');
			$valores = array("'".$x['rim_id']."'","'".$x['rpr_id']."'",
							 "'".$x['rca_id']."'","'".$x['rac_fecha']."'");
			$condicion = "rie_id = ".$riesgo;
			$this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		}
		return $r;
	}

}
