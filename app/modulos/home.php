<?php
/**
*Gestion Interventoria - Gestin
*
*<ul>
* <li> MadeOpen <madeopensoftware.com></li>
* <li> Proyecto GPC</li>
*</ul>
*/

/**
* carga la ventana la vista inicial del sistema
*
* @package  modulos
* @author Alejandro Daza
* @version 2020.01
* @copyright apdaza
*/
//no permite el acceso directo
    defined('_VALID_PRY') or die('Restricted access to this option');

	$fecha = date("Y-m-d");
	$du->updateUserFecha($id_usuario,$fecha);


?>
       <div class="text-center">
            <img src="templates/img/logo.png" class="mw-100 mx-auto mb-3" alt="">
            <h1 class="font-weight-light">Bienvenido!</h1>
        </div>
