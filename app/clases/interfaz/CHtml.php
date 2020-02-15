<?php
/**
 *
 *
 * <ul>
 * <li> MadeOpen <madeopensoftware.com></li>
 * <li> Proyecto PNCAV</li>
 * </ul>
 */

/**
 * Clase Html
 *
 * @package  clases
 * @subpackage interfaz
 * @author Alejandro Daza
 * @version 2019.02
 * @copyright SERTIC - MINTICS
 */
class CHtml {

    var $titulo = null;
    var $estilos = null;
    var $scripts = null;
    var $opciones = null;

    /**
     * Constructor de la clase
     * @param $t titulo de la pagina
     */
    function CHtml($t) {
        $this->titulo = $t;
    }

    /**
     * adciona paginas de estilos al documento html
     * @param $e nombre del archivo que define la pagina de estilos
     */
    function addEstilo($e) {
        $this->estilos[count($this->estilos)] = $e;
    }

    /**
     * adciona archivos de scripts al documento html
     * @param $s nombre del archivo con el codigo javascript
     */
    function addScript($s) {
        $this->scripts[count($this->scripts)] = $s;
    }

    /**
     * genera el inicio del documento html
     */
    function abrirHtml($class = '') {
        ?>
        <html lang="es">
            <head>
              <meta charset="UTF-8">

				      <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover'>
				      <link rel='apple-touch-icon' href='templates/img/favicon-apple.png'>
					    <link rel='icon' href='templates/img/favicon.png'>
					    <!-- Bootstrap CSS -->
  						<link rel="stylesheet" href="templates/scripts/vendor/bootstrap-4.1.3/css/bootstrap.min.css">
  						<!-- Material design icons CSS -->
  						<link rel="stylesheet" href="templates/scripts/vendor/materializeicon/material-icons.css">
  						<!-- aniamte CSS -->
  						<link rel="stylesheet" href="templates/scripts/vendor/animatecss/animate.css">
  						<!-- swiper slider CSS -->
  						<link rel="stylesheet" href="templates/scripts/vendor/swiper/css/swiper.min.css">
  						 <!-- daterange CSS -->
  						<link rel="stylesheet" href="templates/scripts/vendor/bootstrap-daterangepicker-master/daterangepicker.css">

  						<!-- footable CSS -->
  						<link rel="stylesheet" href="templates/scripts/vendor/footable-bootstrap/css/footable.bootstrap.min.css">

  						<!-- Bootstrap tour CSS -->
  						<link rel="stylesheet" href="templates/scripts/vendor/bootstrap_tour/css/bootstrap-tour-standalone.css">

  						<!-- jvector map CSS -->
  						<link rel="stylesheet" href="templates/scripts/vendor/jquery-jvectormap/jquery-jvectormap-2.0.3.css">

                <title><?php echo $this->titulo; ?></title>
                <?php foreach ($this->estilos as $e) { ?>
                    <link href='templates/estilos/<?php echo $e; ?>' rel='stylesheet' type='text/css'>
                <?php } ?>
                <?php foreach ($this->scripts as $s) { ?>
                    <script src='templates/scripts/<?php echo $s; ?>' language='JavaScript1.2'></script>
                <?php } ?>
            </head>
            <?php /*?><body class='<?php echo $class; ?>'><?php */?>
			<body class='fixed-header sidebar-right-close'>
                <?php
            }

            /**
             * cierra el cuerpo del documento html y el documento
             */
            function cerrarHtml() {
                ?>
            </body>
        </html>
        <?php
    }

    /**
     * traduce los caracteres especiales a codigos html
     * @param $t texto a traducir
     */
    function traducirTildes($t) {
      if(mb_detect_encoding($t, 'UTF-8, ISO-8859-1')=='UTF-8'){
        $t = $t;
      } else {
        $t = (utf8_encode($t));
      }
        /*
        $t = str_replace('á', '&aacute;', $t);
        $t = str_replace('é', '&eacute;', $t);
        $t = str_replace('í', '&iacute;', $t);
        $t = str_replace('ó', '&oacute;', $t);
        $t = str_replace('ú', '&uacute;', $t);
        $t = str_replace('ñ', '&ntilde;', $t);
        $t = str_replace('Á', '&Aacute;', $t);
        $t = str_replace('É', '&Eacute;', $t);
        $t = str_replace('Í', '&Iacute;', $t);
        $t = str_replace('Ó', '&Oacute;', $t);
        $t = str_replace('Ú', '&Uacute;', $t);
        $t = str_replace('Ñ', '&Ntilde;', $t);*/
        return $t;
    }

    /**
     * retorna la fecha en formato dia, numero de dia del mes del a�o
     * @param $d arreglo con los nombres de los dias
     * @param $m arreglo con los nombres de los meses
     */
    function fecha($d, $m) {
        $f = null;
        $f = $this->traducirTildes($d[date(w)] . ", " . date(d) . " " . CONCATENADOR_DE . " " . $m[date(n) - 1] . " " . CONCATENADOR_DE . " " . date(Y));
        return $f;
    }

    function ultimoDia($mes, $ano) {
        $ultimo_dia = 28;
        while (checkdate($mes, $ultimo_dia + 1, $ano)) {
            $ultimo_dia++;
        }
        return $ultimo_dia;
    }

    /**
     * muestra un mensaje preformateado dentro de una tabla en un documento html
     */
    function generaAviso($texto, $link) {
        ?>
        <div class="alert alert-success">
            <?php echo $this->traducirTildes($texto) ?>
            <br>
            <a href="<?php echo $link; ?>" class="alert-link">
                <img src="./templates/img/ico/aceptar.gif" border="0" width="20" align="absmiddle" />
                <?php echo $this->traducirTildes(BTN_ACEPTAR) ?>
            </a>
        </div>
        <?php
    }

    /**
     * muestra un mensaje de advertencia preformateado dentro de una tabla en un documento html
     */
    function generaAdvertencia($texto, $link, $script) {
        ?>
        <div class="alert alert alert-warning">
            <?php echo $this->traducirTildes($texto) ?>?
            <br>
            <a href="<?php echo $link; ?>" class="alert-link">
                <img src="./templates/img/ico/aceptar.gif" border="0" width="20" align="absmiddle" />
                <?php echo $this->traducirTildes(BTN_ACEPTAR) ?>
            </a>
            &nbsp; &nbsp;
            <a href="javascript:<?php echo $script; ?>" class="alert-link">
                <img src="./templates/img/ico/cancelar.gif" border="0" width="20" align="absmiddle" />
                <?php echo $this->traducirTildes(BTN_CANCELAR) ?>
            </a>
        </div>
        <?php
    }

    /**
     * muestra un mensaje de advertencia preformateado dentro de una tabla en un documento html
     */
    function generaScriptLink($script) {
        ?>
        <div class="alert alert-warning"><br>
            <a href="javascript:<?php echo $script; ?>">
                <img src="./templates/img/ico/aceptar.gif" border="0" width="20" align="absmiddle" />
                    <?php echo $this->traducirTildes(BTN_ACEPTAR) ?>
            </a>
        </div>
        <?php
    }

    function generaScriptAlertLink($script, $textoAdicional = "") {
        ?>
        <div class="alert alert-warning2"><br>
            <a href="javascript:<?php echo $script; ?>" class="alert-link">
                <img src="./templates/img/ico/alerta.gif" border="0" width="20" align="absmiddle" />
                    <?php echo $this->traducirTildes(ALERTA_ALARMA . $textoAdicional) ?>
            </a>
        </div>
        <?php
    }

    function generaChartLink($link) {
        ?>
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td class="td_right">
                    <a href="<?php echo $link; ?>"><img src="./templates/img/ico/chart.gif" border="0" width="20" align="absmiddle" /><?php echo $this->traducirTildes(BTN_VER_CHART) ?></a>
                </td>
            </tr>
        </table>
        <?php
    }

    function generaLink($link, $img, $text) {
        ?>
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td class="td_right">
                    <a href="<?php echo $link; ?>"><img src="./templates/img/ico/<?php echo $img; ?>" border="0" width="20" align="absmiddle" /><?php echo $this->traducirTildes($text) ?></a>
                </td>
            </tr>
        </table>
        <?php
    }

    function generaImagen($alt, $src, $style, $width, $height) {
        ?>
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td class="td_center">
                    <img alt="<?php echo $this->traducirTildes($alt); ?>"  src="<?php echo $src; ?>" class="<?php echo $style; ?>" width="<?php echo $width ?>" height="<?php echo $height ?>"/>
                </td>
            </tr>
        </table>
        <?php
    }

    function generaImagenTexto($alt, $src, $style, $width, $height, $texto) {
        ?>
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td>
                    <img alt="<?php echo $this->traducirTildes($alt); ?>"  src="<?php echo $src; ?>" class="<?php echo $style; ?>" width="<?php echo $width ?>" height="<?php echo $height ?>"/><?php echo $this->traducirTildes($texto); ?>
                </td>
            </tr>
        </table>
        <?php
    }

    function generaTexto($style, $texto) {
        ?>
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td class="<?php echo $style; ?>">
                    <?php echo $this->traducirTildes($texto); ?>
                </td>
            </tr>
        </table>
        <br>
        <?php
    }

    function generaTextoColumnas($arreglo, $tablecss = "") {
        ?>
        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="<?php echo $tablecss; ?>">
            <tr>
                <?php foreach ($arreglo as $a) { ?>
                    <td class="<?php echo $a['estilo']; ?>" width="<?php echo $a['width']; ?>">
                        <?php echo $this->traducirTildes($a['texto']); ?>
                    </td>
                <?php } ?>
            </tr>
        </table>
        <?php
    }

    function escribirTexto($texto) {
        ?>
        <?php echo $this->traducirTildes($texto); ?>
        <?php
    }

}
?>
