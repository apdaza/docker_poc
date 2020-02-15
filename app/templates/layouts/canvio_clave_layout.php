<?php

	//no permite el acceso directo
	defined('_VALID_PRY') or die('Restricted access');
	$html = new CHtml(APP_TITLE);
	$html->addEstilo('123sidebar.css');
	$handle=opendir('./templates/scripts/validar/');
	while ($file = readdir($handle)) {
		if ($file != "." && $file != "..") {
			//include($file);
			if(substr($file,strlen($file)-3)=='.js'){
				$html->addScript('validar/'.$file);
			}
		}
	}
	$html->abrirHtml('');
?>
<div class="container-fluid">
		<div class="row align-items-center">
<div class="col-auto pl-0">
		<button class="btn pink-gradient btn-icon" id="left-menu"><i class="material-icons">menu</i></button>
		<a href="#" class="logo"><img src="templates/img/Logo_kbt.png" alt=""><span class="text-hide-xs"><b>Sistema</b> POC</span></a>
</div>
</div>
</div>
	<div id="div_log">
	<div class="row align-items-center">
	<table width="900px" align="center" border="0" cellpadding="0" cellspacing="0" >
		<tr>
			<td class="logi_header"></td>
		</tr>
		<tr>

			<td width="40%" id="loginbox">
				<?php
					if (file_exists( $path_modulo )) include( $path_modulo );
					else die('Error al cargar el módulo <b>'.$modulo.'</b>. No existe el archivo <b>'.$conf[$modulo]['archivo'].'</b>');
				?>
			</td>

		</tr>
		<tr>
			<td class="logi_footer"></td>
		</tr>

	</table>
	</div>
	</div>
<?php
	$html->cerrarHtml();

?>
