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
* Clase CActividadData
* Usada para la definicion de todas las funciones propias del objeto actividad
*
* @package  clases
* @subpackage datos
* @author Alejandro Daza
* @version 2020.01
* @copyright apdaza
*/
Class CActividadData{
    var $db = null;

	function CActividadData($db){
		$this->db = $db;
	}

	function getActividades($criterio,$orden){
		$salida = null;
		$sql = "select *
				from actividad act
				inner join actividad_estado ace on act.ace_id=ace.ace_id
				inner join actividad_subsistema acs on act.acs_id=acs.acs_id
        inner join usuario usu on act.usu_id=usu.usu_id
				where ". $criterio." order by ".$orden;
		//echo("<br>".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$salida[$cont]['id'] = $w['act_id'];
				$salida[$cont]['descripcion'] = $w['act_descripcion'];
				$salida[$cont]['fecha_inicio'] = $w['act_fecha_inicio'];
				$salida[$cont]['fecha_fin'] = $w['act_fecha_fin'];
				$salida[$cont]['usuario'] = $w['usu_nombre']." ".$w['usu_apellido'];
        $salida[$cont]['estado'] = $w['ace_nombre'];
        $salida[$cont]['inconvenientes'] = $w['act_inconvenientes'];
        $salida[$cont]['subsistema'] = $w['acs_nombre'];
				$cont++;
			}
		}

		return $salida;
	}

	function getEstados($criterio,$orden){
		$salida = null;
		$sql = "select *
				FROM  actividad_estado
				where ". $criterio ." order by ".$orden;
				//echo($sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$salida[$cont]['id'] 	 = $w['ace_id'];
				$salida[$cont]['nombre'] = $w['ace_nombre'];
				$cont++;
			}
		}
		return $salida;
	}
	function getSubsistemas($criterio,$orden){
		$salida = null;
		$sql = "select *
				FROM  actividad_subsistema
				where ". $criterio ." order by ".$orden;
				//echo($sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$salida[$cont]['id'] 	 = $w['acs_id'];
				$salida[$cont]['nombre'] = $w['acs_nombre'];
				$cont++;
			}
		}
		return $salida;
	}
	function insertActividad($descripcion,$fecha_inicio,$fecha_fin,$usuario,$estado,$inconvenientes,$subsistema){
		$tabla = "actividad";
		$campos = "act_descripcion,act_fecha_inicio,act_fecha_fin,usu_id,ace_id,act_inconvenientes,acs_id";
		$valores = "'".$descripcion."','".$fecha_inicio."','".$fecha_fin."','".$usuario."','".$estado."','".$inconvenientes."','".$subsistema."'";

		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}

	function deleteActividad($id){
		//echo $id;
		$tabla = "actividad ";
		$predicado = "act_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}

	function updateActividad($id,$descripcion,$fecha_inicio,$fecha_fin,$usuario,$estado,$inconvenientes,$subsistema){
		$tabla = "actividad";
		$campos = array('act_descripcion','act_fecha_inicio','act_fecha_fin','usu_id','ace_id','act_inconvenientes','acs_id');
		$valores = array("'".$descripcion."'","'".$fecha_inicio."'","'".$fecha_fin."'","'".$usuario."'","'".$estado."'","'".$inconvenientes."'","'".$subsistema."'");

		$condicion = "act_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		return $r;
	}

	function getActividadById($id){
		$opcion = null;
		$sql = "select *
				from actividad act
        inner join actividad_estado ace on act.ace_id=ace.ace_id
				inner join actividad_subsistema acs on act.acs_id=acs.acs_id
        inner join usuario usu on act.usu_id=usu.usu_id
				where   act.act_id = ". $id;
		//echo $sql;
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r){
      $opcion['id'] = $r['act_id'];
      $opcion['descripcion'] = $r['act_descripcion'];
      $opcion['fecha_inicio'] = $r['act_fecha_inicio'];
      $opcion['fecha_fin'] = $r['act_fecha_fin'];
      $opcion['usuario'] = $r['usu_id'];
      $opcion['estado'] = $r['ace_id'];
      $opcion['inconvenientes'] = $r['act_inconvenientes'];
      $opcion['subsistema'] = $r['acs_id'];

			return $opcion;
		}else{
			return -1;
		}
	}
	function getActividadIdByDescripcion($l){
		$pre = "act_descripcion = '". $l ."'";
		$r = $this->db->recuperarCampo('actividad','act_id',$pre);
		if($r) return $r; else return -1;
	}

  function getTiposSoportes(){
    $tipos = null;
		$sql = "select *
				from actividad_tipo_soporte
				order by ats_nombre";
		//echo("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				//echo("----------");
				$tipos[$cont]['id'] = $w['ats_id'];
				$tipos[$cont]['nombre'] = $w['ats_nombre'];

				$cont++;
			}
		}
		return $tipos;
  }

  function getComunicados($criterio,$orden){
		$comunicados = null;
		$sql = "select d.doc_id, d.doc_archivo
				from documento_comunicado d
				where ". $criterio ."
				order by ".$orden;
		//echo("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				//echo("----------");
				$comunicados[$cont]['id'] = $w['doc_id'];
				$comunicados[$cont]['nombre'] = $w['doc_archivo'];

				$cont++;
			}
		}
		return $comunicados;
	}

  function getDocumentos($criterio,$orden){
		$comunicados = null;
		$sql = "select d.doc_id, d.doc_archivo
				from documento d
				where ". $criterio ."
				order by ".$orden;
		//echo("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				//echo("----------");
				$comunicados[$cont]['id'] = $w['doc_id'];
				$comunicados[$cont]['nombre'] = $w['doc_archivo'];

				$cont++;
			}
		}
		return $comunicados;
	}

  function getSoportesByActividadId($id){
    $soportes = null;
    $sql = "SELECT * FROM `actividad_soporte` s
          inner join `actividad_tipo_soporte` t on s.ats_id = t.ats_id
          inner join `actividad` a on s.act_id = a.act_id
          inner join `documento_comunicado` d on s.asp_referencia = d.doc_id
          where s.act_id = ".$id;
      $r = $this->db->ejecutarConsulta($sql);
  		if($r){
  			$cont = 0;
  			while($w = mysqli_fetch_array($r)){
  				//echo("----------");
  				$soportes[$cont]['id'] = $w['asp_id'];
          $soportes[$cont]['actividad'] = $w['act_descripcion'];
          $soportes[$cont]['tipo_soporte'] = $w['ats_nombre'];
  				$soportes[$cont]['nombre'] = $w['doc_archivo'];

  				$cont++;
  			}
  		}
  		return $soportes;
  }
}
?>
