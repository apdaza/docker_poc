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
//no permite el acceso directo
defined('_VALID_PRY') or die('Restricted access to this level');
$html = new CHtml(APP_TITLE);
    //Clase General Colores 123 CSS
$html->addEstilo('GPCsidebar.css');
$html->addEstilo('calendar/calendar-blue.css');

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
$html->addScript('calendar/calendar.js');
$html->addScript('calendar/calendar-es.js');
$html->addScript('calendar/calendar-setup.js');
$html->abrirHtml();
?>

<?php
?>
<!-- inicio loader -->
    <div class="loader justify-content-center pink-gradient">
        <div class="align-self-center text-center">
            <div class="logo-img-loader">
                <img src="templates/img/loader-hole.png" alt="" class="logo-image">
                <img src="templates/img/loader-bg.png" alt="" class="logo-bg-image">
            </div>

            <h2 class="mt-3 font-weight-light">Sistema GPC</h2>
            <p class="mt-2 text-white">Gestión de proyectos curriculares</p>
        </div>
    </div>
    <!-- fin de loader  -->
	 <div class="wrapper" id="wrap">
        <!-- inicio header -->
        <header class="main-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-auto pl-0">
                        <button class="btn pink-gradient btn-icon" id="left-menu"><i class="material-icons">menu</i></button>
                        <a href="#" class="logo"><img src="templates/img/logo_sistemas.png" alt=""><span class="text-hide-xs"><b>Sistema</b> GPC</span></a>
                    </div>
                    <div class="col text-center p-xs-0">
                        <ul class="time-day">
                            <li class="text-right">
                                <p class="header-color-primary"><span class="header-color-secondary">&Uacute;ltimo Ingreso</span><small><?php echo $html->traducirTildes($fecha_ultimo_ingreso); ?></small></p>
                            </li>
                        </ul>

                    </div>
                    <div class="col-auto pr-0">
                        <div class="dropdown d-inline-block">
                            <a class="btn header-color-secondary dropdown-toggle username" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <figure class="userpic"><img src="templates/img/user-icon.png" alt=""></figure>
                                <h5 class="text-hide-xs">
                                    <small class="header-color-secondary">Bienvenido,</small>
                                    <span class="header-color-primary"><?php echo $html->traducirTildes($nombre_usuario); ?></span>
                                </h5>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown" aria-labelledby="dropdownMenuLink">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <a href="#">
                                            <figure class="avatar avatar-120 mx-auto my-3">
                                                <img src="templates/img/user1.png" alt="">
                                            </figure>
                                            <h5 class="card-title mb-2 header-color-primary"><?php echo $html->traducirTildes($nombre_usuario); ?></h5>
                                        </a>
                                    </div>
                                </div>

                                <div class="dropdown-divider m-0"></div>
                                <a class="dropdown-item pink-gradient-active" href="?mod=cerrar&niv=1&operador=1">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            Cerrar Sesi&oacute;n
                                        </div>

                                        <div class="col-auto">
                                            <div class="text-danger ml-2"><i class="material-icons vm">exit_to_app</i></div>
                                        </div>
                                    </div>
                                </a>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </header>
        <!-- fin header -->

        <!-- sidebar left -->
        <div class="sidebar sidebar-left">
            <ul class="nav flex-column">
			<li class="nav-item">
			<?php
                $cont = 0;
                while ($row = mysqli_fetch_array($opciones)) {
                    if ($row["opc_variable"] != "_blank") {
                        if ($row["opn_id"] == 0) {
                            if ($cont == 1) {
                                echo "</ul>";
                                $cont--;
                            }
                            echo "<li class='nav-item'>"
                            . "<a href='#' class='nav-link dropdwown-toggle' "
                            . "data-toggle='dropdown' ><i class='material-icons icon'>settings</i><span>" .
                            $html->traducirTildes($row["opc_nombre"]) .
                            "</span><i class='material-icons icon arrow'>expand_more</i></a>";
                        }
                        if ($row["opn_id"] == 1) {
                            if ($cont == 0) {
                                echo "<ul class='nav flex-column'>";
                                $cont++;
                            }
                            echo "<li class='nav-item'><a class='nav-link pink-gradient-active' href='?mod=" . $row["opc_variable"] .
                            "&niv=" . $row["pxo_nivel"] .
                            "&operador=" . $row["ope_id"] .
                            "'>" .
                            $html->traducirTildes($row["opc_nombre"])
                            . "</a>";
                        }
                    } else {
                        if ($row["opn_id"] == 0) {
                            if ($cont == 1) {
                                echo "</ul></li>";
                                $cont--;
                            }
                            echo $html->traducirTildes($row["opc_nombre"]);
                        }
                        if ($row["opn_id"] == 1) {
                            if ($cont == 0) {
                                echo "<ul>";
                                $cont++;
                            }
                            echo "<li><a href='" . $row["opc_url"] . "' target='_blank'>" . $html->traducirTildes($row["opc_nombre"]) . "</a>";
                        }
                    }
                }
                ?>


            </ul>
        </div>
        <!-- sidebar left ends -->


        <!-- content page title -->
        <!--div class="container-fluid bg-light-opac">
            <div class="row">
                <div class="container my-3 main-container">
                    <!div class="row align-items-center">
                        <!div class="col">
                            <h2 class="content-color-primary page-title">Bienvenido</h2>
                            <p class="content-color-secondary page-sub-title">Pagina Inicial</p>
                        </div>

                    </div>
                </div>
            </div>
        </div-->
        <!-- content page title ends -->

        <!-- inicio de contenido -->
        <div class="container mt-4 main-container">
		<!-- MIGA DE PAN -->
			<!--nav aria-label="breadcrumb">
                <ol class="breadcrumb">
					<?php
          /*
					$opcionesData = new COpcionData($db);
					$elementos = $opcionesData->getRutaByVar($modulo);
					foreach ($elementos as $e)
						echo "<li class='breadcrumb-item active'>" . ucwords($html->traducirTildes($e['nombre'])) . "</li>";
            */
					?>
                </ol>

            </nav-->
		<!-- FIN MIGA DE PAN -->
		<!-- CONTENIDO CENTRAL -->
    <!-- div class="d-none d-xl-block col-xl-2 bd-toc">
            <ul class="section-nav">
<li class="toc-entry toc-h2"><a href="#overview">Overview</a></li>
<li class="toc-entry toc-h2"><a href="#classes">Classes</a></li>
<li class="toc-entry toc-h2"><a href="#mixins">Mixins</a></li>
<li class="toc-entry toc-h2"><a href="#responsive">Responsive</a></li>
</ul-->
          </div>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                  <aside><!-- aria-label="breadcrumb"-->

                    <?php
            					while($row = mysqli_fetch_array($subopciones)){
            					?>

            						<a href="?mod=<?php echo $row["opc_variable"];?>&niv=<?php echo $row["pxo_nivel"];?>&operador=<?php echo $row["ope_id"];?>">
                          <img src='./templates/img/siguiente.png' border='0' width="5%"></img>
                          <?php echo $html->traducirTildes($row["opc_nombre"]);?>
            						</a><br>

            					<?php

            					}
            				?>

                </aside>

					<?php
								 //echo "-".$path_modulo."- ".file_exists($path_modulo);
					if (file_exists($path_modulo))
						include( $path_modulo );
					else {
						?>
							<!--div class="error">Error al cargar el modulo <b>'<?php echo $modulo; ?>'</b>. No existe el archivo <b>'<?php echo $conf[$modulo]['archivo']; ?>'</b></div-->
						<?php
						include('templates/html/under.html'); //die('Error al cargar el modulo <b>'.$modulo.'</b>. No existe el archivo <b>'.$conf[$modulo]['archivo'].'</b>');
					}
					?>
                </div>

            </div>
			<!-- FIN CONTENIDO CENTRAL -->
        </div>
        <!-- fin de contenido -->

    </div>


<?php include('templates/html/footer.html'); ?>

    <!-- JavaScript -->
    <!-- jQuery primero, Popper.js, despues Bootstrap JS -->
    <script src="templates/scripts/js/jquery-3.2.1.min.js"></script>
    <script src="templates/scripts/js/popper.min.js"></script>
    <script src="templates/scripts/vendor/bootstrap-4.1.3/js/bootstrap.min.js"></script>

    <!-- Cookie jquery file -->
    <script src="templates/scripts/vendor/cookie/jquery.cookie.js"></script>

    <!-- sparklines chart jquery file -->
    <script src="templates/scripts/vendor/sparklines/jquery.sparkline.min.js"></script>

    <!-- Circular progress gauge jquery file -->
    <script src="templates/scripts/vendor/circle-progress/circle-progress.min.js"></script>

    <!-- Swiper carousel jquery file -->
    <script src="templates/scripts/vendor/swiper/js/swiper.min.js"></script>

    <!-- Chart js jquery file -->
    <script src="templates/scripts/vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="templates/scripts/vendor/chartjs/utils.js"></script>

    <!-- Footable jquery file -->
    <script src="templates/scripts/vendor/footable-bootstrap/js/footable.min.js"></script>

    <!-- datepicker jquery file -->
    <script src="templates/scripts/vendor/bootstrap-daterangepicker-master/moment.js"></script>
    <script src="templates/scripts/vendor/bootstrap-daterangepicker-master/daterangepicker.js"></script>

    <!-- jVector map jquery file -->
    <script src="templates/scripts/vendor/jquery-jvectormap/jquery-jvectormap.js"></script>
    <script src="templates/scripts/vendor/jquery-jvectormap/jquery-jvectormap-world-mill-en.js"></script>

    <!-- Bootstrap tour jquery file -->
    <script src="templates/scripts/vendor/bootstrap_tour/js/bootstrap-tour-standalone.min.js"></script>

    <!-- jquery toast message file -->
    <script src="templates/scripts/vendor/jquery-toast-plugin-master/dist/jquery.toast.min.js"></script>

    <!-- Application main common jquery file -->
    <script src="templates/scripts/js/main.js"></script>

    <!-- page specific script
    <script src="templates/scripts/js/dashboard.js"></script>-->

    <!-- script especificos de cada pagina -->
    <script>
        "use script";
        $(window).on('load', function() {
            var tour = new Tour({
                steps: [{
                    element: "#left-menu",
                    title: "Main Menu",
                    content: "Access the demo pages from sidebar",
                    smartPlacement: true,
                    storage:false
                }, {
                    element: "button[data-target='#createOrder']",
                    title: "Creative Form",
                    content: "See beautifully designed form in modal",
                    smartPlacement: true,
                    placement: "left",
                    storage:false

                }, {
                    element: ".close-sidebar",
                    title: "Customizaton Menu",
                    content: "Customize your Layout style",
                    smartPlacement: true,
                    placement: "left",
                    storage:false

                }]

            });

            // Initialize the tour
            tour.init();

            // Start the tour
            tour.start();
        });

    </script>
<?php
$html->cerrarHtml();
?>
