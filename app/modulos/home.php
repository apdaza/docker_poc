<?php
/**
*Gestion Interventoria - Gestin
*
*<ul>
* <li> MadeOpen <madeopensoftware.com></li>
*<li> Proyecto PNCAV</li>
*</ul>
*/

/**
* carga la ventana la vista inicial del sistema
*
* @package  modulos
* @author Alejandro Daza
* @version 2019.02
* @copyright SERTIC - MINTICS
*/
//no permite el acceso directo
    defined('_VALID_PRY') or die('Restricted access to this option');

	$fecha = date("Y-m-d");
	$du->updateUserFecha($id_usuario,$fecha);


?>
        <h1 class="font-weight-light">Bienvenido!</h1>
       <div class="text-center">
            <!--img src="templates/img/inter123.png" class="mw-100 mx-auto mb-3" alt=""><br>
            <img src="templates/img/logo_secretaria_seguridad_color.png" class="mw-100 mx-auto mb-3" alt=""-->
        </div>
