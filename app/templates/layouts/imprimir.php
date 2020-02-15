<?php
/**
*Gestion Interventoria - Gestin
*
*<ul>
* <li> MadeOpen <madeopensoftware.com></li>
* <li> Proyecto KBT </li>
*</ul>
*/

/**
* Imprimir
*
* @package  templates
* @subpackage layouts
* @author Alejandro Daza
* @version 2019.02
* @copyright apdaza
*/
//no permite el acceso directo
	defined('_VALID_FSW') or die('Restricted access');
$uri = "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
?>
<html>
<head>
	<title>Versi�n para Imprimir</title>
</head>
<style type="text/css">
.imprimir {
	margin: 3%;
	border: 2px solid black;
	padding: 2%;
}
#pie {
	font-size: 8pt;
}
</style>
<body>
<div class="imprimir">
<?php
	if (file_exists( $path_modulo )) include( $path_modulo );
	else die('Error al cargar el m�dulo <b>'.$modulo.'</b>. No existe el archivo <b>'.$conf[$modulo]['archivo'].'</b>');
?>
<i id="pie">Este art�culo se puede encontrar en : <a href="<?php echo $uri?>"><?php echo $uri?></a></i>
</div>
</body>
</html>