<?php
/**
 * Gestion Interventoria - Gestin
 *
 * <ul>
 * <li> MadeOpen <madeopensoftware.com></li>
 * <li> Proyecto PNCAV</li>
 * </ul>
 */
/**
 * Login_layout
 *
 * @package  templates
 * @subpackage layouts
 * @author Alejandro Daza
 * @version 2020.01
 * @copyright apdaza
 */
//no permite el acceso directo
defined('_VALID_PRY') or die('Restricted access');
$html = new CHtml(APP_TITLE);
    //Clase General Colores 123 CSS
$html->addEstilo('GPCsidebar.css');

$html->addScript('base/jquery.min.js');
$html->addScript('base/bootstrap.min.js');
$handle = opendir('./templates/scripts/validar/');



while ($file = readdir($handle)) {
    if ($file != "." && $file != "..") {
        //include($file);
        if (substr($file, strlen($file) - 3) == '.js') {
            $html->addScript('validar/' . $file);
        }
    }
}
$html->abrirHtml('');
?>
<!-- inicio loader -->
    <div class="loader justify-content-center pink-gradient">
        <div class="align-self-center text-center">
            <div class="logo-img-loader">
                <img src="templates/img/loader-hole.png" alt="" class="logo-image">
                <img src="templates/img/loader-bg.png" alt="" class="logo-bg-image">
            </div>
            <h2 class="mt-3 font-weight-light">Sistema GPC</h2>
            <p class="mt-2 text-white">Programe, Organice y Controle</p>
        </div>
    </div>
    <!-- fin de loader  -->

    <div class="h-100 justify-content-center h-sm-auto">
        <!-- inicio de contenido -->
        <div class="container-fluid h-100 h-sm-auto">
            <div class="row h-100 h-sm-auto">
                <div class="col-12 col-md-6 h-md-100  h-sm-auto order-2 order-md-1">
                    <div class="row align-items-center h-100 h-sm-auto">
                        <div class="col-10 col-md-10 col-lg-8 col-xl-6 mx-auto">
                            <h1 class="font-weight-light mb-3 mt-4 content-color-secondary text-left">Sistema <span class="font-weight-normal content-color-primary">GPC</span></h1>
                            <h4 class="font-weight-light mb-4 content-color-secondary text-left">Gestión del Proyecto Curricular</h4>
							<form id="frm_login" method="post">
                            <div class="card mb-2">
                                <div class="card-body p-0">
                                    <label for="inputEmail" class="sr-only">Usuario</label>
									<input type="text" class="form-control form-control-lg border-0"
										   placeholder="Nombre de Usuario"
										   pattern="[a-zA-Z]+" title="Introduce solo letras"
										   id="txt_login_session"
										   name="txt_login_session"
										   autofocus required />

                                    <hr class="my-0">
                                    <label for="inputPassword" class="sr-only">Contraseña</label>
									<input type="password" class="form-control form-control-lg border-0"
										   id="txt_password_session"
										   name="txt_password_session"
										   placeholder="Contrase&ntilde;a" required />
                                </div>
                            </div>
                            <small class="form-text text-muted">Digite Nombre de usuario, la clave o contraseña y haga clic en ingresar</small>
                            <!--div class="my-4 row">
                                <div class="col-12 col-md">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1" checked="">
                                        <label class="custom-control-label" for="customCheck1">Recordarme</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md text-right">
                                    <a href="" class="content-color-primary">Olvido su Clave?</a>
                                </div>
                            </div-->
                            <div class="text-left mb-4">
								<input type="hidden" id="txt_estado" name="txt_estado" value="Activo" />
								<button type="submit" class=" btn btn-primary pink-gradient" onclick="validar_login();">Ingresar</button>
                            </div>






							</form>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 h-md-100 order-1 order-md-2 min-height-300 p-0 bg-light ">
                    <div class="carosel swiper-location-carousel h-100 h-sm-auto">
                        <div data-pagination='{"el": ".swiper-pagination"}' data-space-between="0" data-slides-per-view="1" class="swiper-container swiper-init swiper-signin h-100">
                            <div class="swiper-pagination"></div>
                            <div class="swiper-wrapper">
                                <div class="swiper-slide text-center ">
                                    <div class="background-img"><img src="templates/img/blanco.jpg" alt="" class="w-auto float-right"></div>
                                    <div class="row align-items-center h-100 text-white">
                                        <div class="col-10 col-md-8 mx-auto">
                                            <div><img src="templates/img/logo.png" alt="Sistemas UD"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin de contenido -->

    </div>







<?php include('templates/html/footer.html'); ?>



    <!-- JavaScript -->
    <!-- jQuery primero, Popper.js, despues Bootstrap JS -->
    <script src="templates/scripts/js/jquery-3.2.1.min.js"></script>
    <script src="templates/scripts/js/popper.min.js"></script>
    <script src="templates/scripts/vendor/bootstrap-4.1.3/js/bootstrap.min.js"></script>

    <!-- Cookie jquery -->
    <script src="templates/scripts/vendor/cookie/jquery.cookie.js"></script>

    <!-- swiper slider jquery -->
    <script src="templates/scripts/vendor/swiper/js/swiper.min.js"></script>

    <!-- main common jquery -->
    <script src="templates/scripts/js/main.js"></script>

    <!-- script especificos de cada pagina -->
	<script>
        'use strict';
        var mySwiper = new Swiper('.swiper-signin', {
            slidesPerView: 1,
            spaceBetween: 0,
            autoplay: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            }
        });

        $(window).on('resize', function() {
            var mySwiper = new Swiper('.swiper-signin', {
                slidesPerView: 1,
                spaceBetween: 0,
                autoplay: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                }
            });
        });

    </script>

<?php
$html->cerrarHtml();
?>
