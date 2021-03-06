<?php
/**
 * Sistema GPC
 *
 * <ul>
 * <li> Madeopen (http://madeopensoftware.com)</li>
 * <li> Proyecto GPC</li>
 * <li> apdaza@gmail.com </li>
 * </ul>
 */
/**
 * @author apdaza
 * @version 2020.01
 * @copyright apdaza
 */
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=comunicados.xls");
require('../../clases/datos/CDocumentoData.php');
require('../../config/conf_reportes.php');
$operador		= $_REQUEST['operador'];
$fecha_inicio 	= $_REQUEST['txt_fecha_inicio'];
$fecha_fin 		= $_REQUEST['txt_fecha_fin'];

function calculardias($fecha1, $fecha2){
	$dato1 = explode("-", $fecha1);
	$dato2 = explode("-", $fecha2);
	//defino fecha 1
	$ano1 = $dato1[0];
	$mes1 = $dato1[1];
	$dia1 = $dato1[2];

	//defino fecha 2
	$ano2 = $dato2[0];
	$mes2 = $dato2[1];
	$dia2 = $dato2[2];

	//calculo timestam de las dos fechas
	$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1);
	/* echo ("$timestamp1"."<br>");  */
	$timestamp2 = mktime(4,12,0,$mes2,$dia2,$ano2);
	/* echo ("$timestamp2"."<br>"); */
	$segundos_diferencia = $timestamp2 - $timestamp1; //resto a una fecha la otra */
	/* echo ("$segundos_diferencia"."<br>"); */
	$dias_diferencia = $segundos_diferencia / (60 * 60 * 24); //convierto segundos en días
	$dias_diferencia = round($dias_diferencia); //obtengo el valor absoulto de los días (quito el posible signo negativo)

	return $dias_diferencia;
}
if ($fecha_inicio =="" || $fecha_inicio =="0000-00-00" ) $fecha_inicio="2013-08-01";
if ($fecha_fin =="" || $fecha_fin =="0000-00-00" ) $fecha_fin=date("Y-m-d");
$sql = "select d.*,    sd.dos_nombre,
					   ad.doa_nombre as autor,
					   dd.doa_nombre as destinatario,
					   us.usu_apellido, us.usu_nombre
				from documento_comunicado d
				inner join documento_subtema 	sd on d.dos_id = sd.dos_id
				inner  join documento_actor 		ad on d.doa_id_autor = ad.doa_id
				inner  join documento_actor 		dd on d.doa_id_dest = dd.doa_id
				left  join usuario 				us on d.usu_id = us.usu_id
				where d.doc_fecha_radicado >= '".$fecha_inicio."' and d.doc_fecha_radicado <= '".$fecha_fin."' order by d.doc_fecha_respuesta";
				//where d.doc_alarma=1 and d.doc_fecha_radicado >= '".$fecha_inicio."' and d.doc_fecha_radicado <= '".$fecha_fin."' order by d.doc_fecha_respuesta";

//echo "<br>".$sql."<br>";

$r = $db->ejecutarConsulta($sql);
echo "<table width='80%' border='1' align='center'>";
//encabezado
echo"<tr><th colspan = '10'><center></center></th></tr>";
echo"<tr><th colspan = '10' bgcolor='#CCCCCC'><center>REPORTE DE TODOS LOS COMUNICADOS SIN RESPONDER SEGUN FECHA DE RADICADO</center></th></tr>";
echo"<tr><th colspan = '10' bgcolor='#ffffff'><center>".($fecha_inicio)."     Y     ".($fecha_fin)."</center></th></tr>";
echo"<tr><th colspan = '10'><center></center></th></tr>";
//titulos
	echo "<tr>";
	echo "
	<th>Subtema de Documento</th>
	<th>Enviado por</th>
	<th>En espera de respuesta de</th>
	<th>Responsable</th>
	<th>Descripcion</th>
	<th>Fecha en que se radico</th>
	<th>Fecha max.para responder</th>
	<th>Referencia</th>
	<th>Archivo</th>
	<th>Estado</th>";
	echo "</tr>";
//datos
while($w = mysqli_fetch_array($r)){
	$fecha=$w['doc_fecha_respuesta'];
	if ($fecha=="0000-00-00") $fecha="";
	if ($w['doc_alarma']==1){
	    $dias = calculardias ($w['doc_fecha_respuesta'],date("Y-m-d"));
		if ($dias <= -1){
			$dias2 = $dias;
			$dias = $dias*(-1);
			$predicado='fes_id >="'.date("Y-m-d").'" and fes_id <="'.$w['doc_fecha_respuesta'].'"';
			$dato = date("Y-m-d");
		}
		else {
			$dias2 = $dias;
			$predicado='fes_id >="'. $w['doc_fecha_respuesta'].'" and fes_id <="'.date("Y-m-d").'"';
			$dato = $w['doc_fecha_respuesta'];
		}
		$tabla='festivos_colombia';
		$campo='count(*)';
		$dias_festivos = $db->recuperarCampo($tabla,$campo,$predicado);
		//$dato = $w['doc_fecha_respuesta'];
		//echo ("<br>dias:".$dias);
		$fin_de_semana=0;
		for($i=0;$i<=$dias;$i++){

			$dato = date("Y-m-d", strtotime("$dato +1 day"));
			//echo ("<br>dato:".$dato);
			$dato_fecha = explode("-", $dato);
			//defino fecha 1
			$year = $dato_fecha[0];
			$mes  = $dato_fecha[1];
			$dia  = $dato_fecha[2];
			//echo ("<br>dia de la semana:".date('D', mktime (0, 0, 0, $mes, $dia, $year)));
			if (date('D', mktime (0, 0, 0, $mes, $dia, $year))=="Sat" || date('D', mktime (0, 0, 0, $mes, $dia, $year)) == "Sun")
				$fin_de_semana++;
		}
		//$dias_habiles=$dias-$dias_festivos-$fin_de_semana+1;
		if($dias2<=-1){
			$dias_habiles=$dias2+$dias_festivos+$fin_de_semana;
		}else{
			$dias_habiles=$dias-$dias_festivos-$fin_de_semana;
		}
		if ($dias_habiles<=0) $respuesta= "Sin responder: van"."(".$dias_habiles.") dias habiles";
		else $respuesta= "ALERTA: Sin responder, van"."(".str_pad($dias_habiles, 3, "0", STR_PAD_LEFT).") dias habiles";
	}
	else{
		if($w['doc_referencia_respondido']!='' && $w['doc_referencia_respondido']!=-1) $respuesta= "Respondido:";
		else $respuesta= "No requiere:";
	}
	echo "<tr>";
	  echo "<td><center>".($w['dos_nombre'])."</center></td>
			<td>".($w['autor'])."</td>
			<td>".($w['destinatario'])."</td>
			<td>".($w['usu_nombre'])."&nbsp;".($w['usu_apellido'])."</td>
			<td>".($w['doc_descripcion'])."</td>
			<td>".($w['doc_fecha_radicado'])."</td>
			<td>".($fecha)."</td>
			<td>".($w['doc_referencia'])."</td>
			<td>".($w['doc_archivo'])."</td>
			<td>".($respuesta)."</td>";
	echo "</tr>";
}
echo "</table>";
?>
