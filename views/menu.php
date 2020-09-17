<?php
session_start();
if ($_SESSION['usu'] == "") {
    session_unset($_SESSION['usu']);
    session_unset($_SESSION['name']);
    header('location: ../views/login.php');
}
?>
<body class="nav-md">
    <div class="container body">
        <div class="main_container">

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <nav class="nav navbar-nav">
                        <ul class=" navbar-right">
                            <li class="nav-item dropdown open" style="padding-left: 15px;">
                                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                                    <img class="img-circle" src="../images/logoBGR.png" width="80" height="70" alt=""/>
                                    <span class="">
                                        <?php echo $_SESSION['name']; ?>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item"  href="#" data-toggle="modal" data-target="#cambioPassModal"> Cambiar contraseña</a>
                                    <a class="dropdown-item"  href="../ajax/logoutC.php"><i class="fa fa-sign-out pull-right"></i> Cerrar sesión</a>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <br>
                    <div class="navbar nav_title text-center">
                        <a href="../views/blank.php" class="site_title">
                            <!--<img class="img-circle" src="../images/logoBGR.png" width="80" height="70" alt=""/>-->
                            <i class="fa fa-bank"></i> <span>BGR</span>
                        </a>
                    </div>

                    <div class="clearfix"></div>
                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <ul class="nav side-menu">
                                <?php if ($_SESSION['workgroup'] == "1") { ?>
                                    <li><a><i class="fa fa-wrench"></i> Administración <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="usuarios.php">Usuarios</a></li>
                                        </ul>
                                    </li>
                                <?php } if ($_SESSION['workgroup'] == "1" || $_SESSION['workgroup'] == "4") { ?>
                                    <li>
                                        <a>
                                            <i class="fa fa-bar-chart-o"></i>Canales Electrónicos <span class="fa fa-chevron-down"></span>
                                        </a>
                                        <ul class="nav child_menu">
                                            <li><a href="frontCanalesElec.php">Gestión Canales Electrónicos</a></li>
                                        </ul>
                                    </li>
                                <?php } if ($_SESSION['workgroup'] >= "1" && $_SESSION['workgroup'] <= "3") { ?>
                                    <li>
                                        <a>
                                            <i class="fa fa-bar-chart-o"></i> Cliente Externo <span class="fa fa-chevron-down"></span>
                                        </a>
                                        <ul class="nav child_menu">
                                            <li><a href="blank.php">Gestión de oficinas</a></li>
                                            <li><a href="frontNegocios.php">Negocios</a></li>
                                            <li><a href="frontServicios.php">Servicios</a></li>
                                        </ul>
                                    </li>
                                    <?php if ($_SESSION['workgroup'] == "1") { ?>
                                        <li>
                                            <a>
                                                <i class="fa fa-headphones"></i>Monitoreo <span class="fa fa-chevron-down"></span>
                                            </a>
                                            <ul class="nav child_menu">
                                                <li><a href="monitoreo.php">Seguimiento a asesores</a></li>
                                            </ul>
                                        </li>
                                    <?php } ?>
                                    <li>
                                        <a>
                                            <i class="fa fa-pie-chart"></i> Reportes <span class="fa fa-chevron-down"></span>
                                        </a>
                                        <ul class="nav child_menu">
                                            <li><a href="reportData.php">Reporte Data</a></li>
                                            <li><a href="reportAgencias.php">Reporte de agencias</a></li>
                                            <?php if ($_SESSION['workgroup'] == "1" || $_SESSION['workgroup'] == "4") { ?>
                                                <li><a href="reportDataCanales.php">Reporte Canales Electrónicos</a></li>
                                                <li><a href="reportResultados.php">Reporte Resultados</a></li>
                                            <?php } ?>
                                            <!--                                            <li><a href="#">Reporte por áreas</a></li>
                                                                                        <li><a href="#">Reporte interacciones</a></li>-->
                                        </ul>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /sidebar menu -->
                </div>
            </div>

            <div class="modal" id="cambioPassModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title">Cambio de contraseña</h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" class="form-control" id="userId" name="userId" value="<?php echo $_SESSION['usu']; ?>" maxlength="80" required/>
                            <div class="item form-group">
                                <label class="col-form-label col-md-5 col-sm-5 label-align" for="oldPassword">Ingrese contraseña actual <span class="required">*</span>
                                </label>
                                <div class="col-md-7 col-sm-7 ">
                                    <input type="password" class="form-control" id="oldPassword" name="oldPassword" maxlength="80" required/>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="col-form-label col-md-5 col-sm-5 label-align" for="newPassword">Ingrese nueva contraseña <span class="required">*</span>
                                </label>
                                <div class="col-md-7 col-sm-7 ">
                                    <input type="password" class="form-control" id="newPassword" name="newPassword" maxlength="80" required/>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="col-form-label col-md-5 col-sm-5 label-align" for="newPassword2">Confirmar nueva contraseña <span class="required">*</span>
                                </label>
                                <div class="col-md-7 col-sm-7 ">
                                    <input type="password" class="form-control" id="newPassword2" name="newPassword2" maxlength="80" required/>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btnGuardar">Guardar</button>
                            <button type="button" class="btn btn-secondary" id="btnCancelar" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $('#cambioPassModal').on('shown.bs.modal', function () {
                    $('#myInput').trigger('focus')
                })
            </script>
            <script src="scripts/actualizarClave.js" type="text/javascript"></script>