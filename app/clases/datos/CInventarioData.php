
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
* Clase InventarioData
*
* @package  clases
* @subpackage data
* @author Alejandro Daza
* @version 2020.01
* @copyright apdaza
*/

Class CInventarioData{
    var $db = null;

	function CInventarioData($db){
		$this->db = $db;
	}

  function getGrupoNombreById($id) {
      $pre = "ivg_id = " . $id;
      $r = $this->db->recuperarCampo('inventario_grupo', 'ivg_nombre', $pre);
      if ($r)
          return $r;
      else
          return -1;
  }

	function getGrupoInventario($criterio,$orden){
		$salida = null;
		$sql = "SELECT * FROM  inventario_grupo WHERE  ". $criterio ."  order by ".$orden;
		//echo ("<br>getTipoInvolucrados:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$salida[$cont]['id'] 		= $w['ivg_id'];
				$salida[$cont]['nombre'] 	= $w['ivg_nombre'];
				$cont++;
			}
		}
		return $salida;
	}

	function getGruposEquipos($criterio){
		$salida = null;
		$sql = "select g.*, count(i.ini_id) as cantidad from inventario_grupo g
            left join inventario i on g.ivg_id = i.ivg_id
            group by g.ivg_id  ";
		//echo ("<br>getInvolucradosEquipos:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$salida[$cont]['id'] = $w['ivg_id'];
				$salida[$cont]['tipo'] = $w['ivg_nombre'];
				$salida[$cont]['cantidad'] = $w['cantidad'];
				$cont++;
			}
		}
		return $salida;
	}
	function getDirectorioOperador($id){
		$tabla='operador';
		$campo='ope_sigla';
		$predicado='ope_id = '. $id;
		if(!isset($id))
		   $predicado='ope_id=1';
		$r = $this->db->recuperarCampo($tabla,$campo,$predicado);
		$r = $r."/";
		if($r) return $r; else return -1;
	}
	// funciones especificas para gestionar equipos de un involucrado

	function getEquiposGrupo($criterio){
		$salida = null;
		$sql = "SELECT  *
				FROM  inventario ii
				INNER JOIN inventario_grupo	ig  ON  ig.ivg_id = ii.ivg_id
        INNER JOIN inventario_equipo 	iq ON iq.ine_id = ii.ine_id
        INNER JOIN inventario_marca 	im ON im.inm_id = ii.inm_id
        INNER JOIN inventario_estado 	ie ON ie.ies_id = ii.ies_id
        WHERE  ". $criterio;
		//echo ("<br>getEquiposInvolucrado:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$salida[$cont]['id'] 		= $w['ini_id'];
				$salida[$cont]['equipo'] 	= $w['ine_nombre'];
				$salida[$cont]['marca'] 	= $w['inm_nombre'];
				$salida[$cont]['modelo'] 	= $w['ini_modelo'];
				$salida[$cont]['serie'] 	= $w['ini_serie'];
				$salida[$cont]['placa'] 	= $w['ini_placa'];
				$salida[$cont]['fecha'] 	= $w['ini_fecha_compra'];
				$salida[$cont]['estado'] 	= $w['ies_nombre'];
        $salida[$cont]['descripcion'] 	= $w['ini_descripcion'];
				$cont++;
			}
		}
		return $salida;
	}
	function getEquipoById($id){
		$sql = "SELECT *
            FROM inventario iv
				WHERE iv.ini_id= ". $id;
		//echo("<br>getEquipoById:".$sql);
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r) return $r; else return -1;
	}
	function getTipoEquipos($criterio,$orden){
		$salida = null;
		$sql = "SELECT * FROM  inventario_equipo WHERE  ". $criterio ."  order by ".$orden;
		//echo ("<br>getTipoEquipos:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$salida[$cont]['id'] 		= $w['ine_id'];
				$salida[$cont]['nombre'] 	= $w['ine_nombre'];
				$cont++;
			}
		}
		return $salida;
	}
	function getTipoMarcas($criterio,$orden){
		$salida = null;
		$sql = "SELECT * FROM  inventario_marca WHERE  ". $criterio ."  order by ".$orden;
		//echo ("<br>getTipoMarcas:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$salida[$cont]['id'] 		= $w['inm_id'];
				$salida[$cont]['nombre'] 	= $w['inm_nombre'];
				$cont++;
			}
		}
		return $salida;
	}
	function getTipoEstados($criterio,$orden){
		$salida = null;
		$sql = "SELECT * FROM  inventario_estado WHERE  ". $criterio ."  order by ".$orden;
		//echo ("<br>getTipoEstados:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$salida[$cont]['id'] 		= $w['ies_id'];
				$salida[$cont]['nombre'] 	= $w['ies_nombre'];
				$cont++;
			}
		}
		return $salida;
	}
	function insertEquipo($grupo,$equipo,$marca,$modelo,$serie,$placa,$fecha_compra,$estado,$descripcion){
		$tabla = "inventario";
		$campos = "ivg_id,ine_id,inm_id,ini_modelo,ini_serie,ini_placa,ini_fecha_compra,ies_id,ini_descripcion";
		$valores = "'".$grupo."','".$equipo."','".$marca."','".$modelo."','".$serie."','".$placa."','".$fecha_compra."','".$estado."','".$descripcion."'";
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}

	function deleteEquipo($id){
		$tabla = "inventario";
		$predicado = "ini_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
	function updateEquipo($id,$involucrado,$equipo,$marca,$modelo,$serie,$placa,$fecha_compra,$estado,$descripcion){

		$tabla = "inventario";
		$campos = array('ine_id','inm_id','ini_modelo','ini_serie','ini_placa','ini_fecha_compra','ies_id','ini_descripcion');
		$valores = array("'".$equipo."'","'".$marca."'","'".$modelo."'","'".$serie."'","'".$placa."'","'".$fecha_compra."'","'".$estado."'","'".$descripcion."'");
		$condicion = "ini_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		return $r;
	}
	// funciones especificas para gestionar los soportes de una inventario (equipo)

	function getSoportesInventario($criterio,$operador){
		$salida = null;
		$sql = "select * from inventario_soporte ins, inventario_soporte_tipo ist where ins.ist_id=ist.ist_id and ". $criterio ;
		//echo("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		$dirOperador=$this->getDirectorioOperador($operador);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$salida[$cont]['id'] = $w['ins_id'];
				$salida[$cont]['nombre'] = $w['ist_nombre'];
				$salida[$cont]['archivo'] ="<a href='././soportes/".$dirOperador."inventarios/".$w['ins_archivo']."' target='_blank'>{$w['ins_archivo']}</a>";
				$cont++;
			}
		}
		return $salida;
	}
	function getInvolucradoVisita($id){
		$tabla='involucrado i, inventario_involucrado iv';
		$campo='concat(i.ivl_id,"-",iv.ivv_fecha)';
		$predicado='i.ivl_id=iv.ivl_id and iv.ivv_id = '. $id;
		$r = $this->db->recuperarCampo($tabla,$campo,$predicado);

		if($r) return $r; else return -1;
	}
	function getNombreInvolucradoEquipo($id){
		$tabla='involucrado i, inventario_involucrado iv, inventario_equipo ie';
		$campo='concat(i.ivl_nombre,"-equipo:",ie.ine_nombre)';
		$predicado='i.ivl_id=iv.ivl_id and ie.ine_id=iv.ine_id and iv.ini_id = '. $id;
		$r = $this->db->recuperarCampo($tabla,$campo,$predicado);

		if($r) return $r; else return -1;
	}
	function getTipoSoportes($criterio,$orden){
		$salida = null;
		$sql = "SELECT * FROM  inventario_soporte_tipo WHERE  ". $criterio ."  order by ".$orden;
		//echo ("<br>getTipoSoportes:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$salida[$cont]['id'] 		= $w['ist_id'];
				$salida[$cont]['nombre'] 	= $w['ist_nombre'];
				$cont++;
			}
		}
		return $salida;
	}

	function insertSoporte($inventario,$tipo,$archivo){
		$tabla = "inventario_soporte";
		$campos = "ini_id,ist_id,ins_archivo";
		$valores = "'".$inventario."','".$tipo."','".$archivo."'";
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}

	function deleteSoporte($id){
		$tabla = "inventario_soporte";
		$predicado = "ins_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
	function getSoporteById($id){
		$sql = "select *
				from inventario_soporte
				WHERE ins_id=". $id;
		//echo ("<br>getSoporteById:".$sql);
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r) return $r; else return -1;
	}

}
