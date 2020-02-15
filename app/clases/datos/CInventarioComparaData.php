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
* Clase InvolucradoInventarioComparaData
* Usada para la definicion de todas las funciones propias del objeto VISITA_COMPARA
*
* @package  clases
* @subpackage datos
* @author Redcom Ltda
* @version 2013.01.00
* @copyright Ministerio de Transporte
*/
Class CInventarioComparaData{

	var $db = null;

	function CInventarioComparaData($db){
		$this->db = $db;
	}

	function getInventariosReposicion($operador,$fecha_inicio,$fecha_fin){
		$salida = null;
		$sql = "SELECT i.ivl_nombre,it.ivt_nombre,ii.ini_fecha_compra, DATE_ADD(ii.ini_fecha_compra,INTERVAL ie.ine_reposicion YEAR) as reposicion,
						ie.ine_nombre, id.ies_nombre
				FROM  inventario_involucrado ii
				inner join involucrado          i on  i.ivl_id=ii.ivl_id
				inner join involucrado_tipo    it on it.ivt_id=i.ivt_id
				inner join inventario_equipo   ie on ie.ine_id=ii.ine_id
				inner join inventario_estado   id on id.ies_id=ii.ies_id
				WHERE DATE_ADD(ii.ini_fecha_compra,INTERVAL ie.ine_reposicion YEAR) >='".$fecha_inicio."' and DATE_ADD(ii.ini_fecha_compra,INTERVAL ie.ine_reposicion YEAR) <='".$fecha_fin."'";

		//echo "getInventariosReposicion".$sql;

		$r = $this->db->ejecutarConsulta($sql);

		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$salida[$cont]['id']     	= $w['ini_id'];
				$salida[$cont]['tipo'] 		= $w['ivt_nombre'];
				$salida[$cont]['nombre'] 	= $w['ivl_nombre'];
				$salida[$cont]['equipo'] 	= $w['ine_nombre'];
				$salida[$cont]['fecha'] 	= $w['ini_fecha_compra'];
				$salida[$cont]['reposicion']= $w['reposicion'];
				$salida[$cont]['estado'] 	= $w['ies_nombre'];
				$cont++;
			}
		}
		return $salida;
	}

}
?>
