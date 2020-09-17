<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

<div class="container body">
    <div class="main_container">
        <!-- page content -->
        <div class="right_col" role="main">
            <!-- content -->
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Usuarios</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li>
                                    <button class="btn btn-sm btn-success" id="btnAgregar" onclick="mostrar_formulario(true)">
                                        <i class="fa fa-plus-circle"></i> Agregar
                                    </button>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content fixedHeader-locked">
                            <div class="x_content">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <div id="listadoRegistros" class="table-responsive">
                                            <table id="tblListado" class="table table-striped" style="width:100%">
                                                <thead>
                                                <th>Num</th>
                                                <th>Usuario</th>
                                                <th>Identificación</th>
                                                <th>Primer nombre</th>
                                                <th>Segundo nombre</th>
                                                <th>Primer apellido</th>
                                                <th>Segundo apellido</th>
<!--                                                <th>Fecha de nacimiento</th>
                                                <th>Dirección</th>
                                                <th>Celular</th>
                                                <th>Teléfono convencional</th>
                                                <th>Correo</th>-->
                                                <th>Perfil</th>
                                                <th>Estado</th>
                                                <th>Acciones</th> <!--espacio para botones-->
                                                </thead>
                                                <tbody>        
                                                </tbody>
                                                <tfoot>
<!--                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>-->
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="x_content" id="formularioRegistros">
                                <form name="formulario" id="formulario" method="POST">
                                    <div class="col-md-3 col-sm-2 "><br></div>
                                    <div class="col-md-8 col-sm-8 ">
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="identificacion">Identificación <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input type="text" onkeypress="return onlyNumbers(event)" class="form-control" id="identificacion" name="identificacion" maxlength="10" required />
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="Name1">Primer nombre <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input type="text" class="form-control" id="Name1" name="Name1" maxlength="50" required />
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="Name2">Segundo nombre
                                            </label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input type="text" class="form-control" id="Name2" name="Name2" maxlength="50" />
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="Surname1">Primer apellido <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input type="text" class="form-control" id="Surname1" name="Surname1" maxlength="50" required />
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="Surname2">Segundo apellido
                                            </label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input type="text" class="form-control" id="Surname2" name="Surname2" maxlength="50"  />
                                            </div>
                                        </div>
                                        <div id="ocultar">
                                            <input type="text" class="form-control" id="validar" name="validar" />
                                            <input type="text" class="form-control" id="mensaje" name="mensaje" />
                                        </div>
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="Id">Usuario <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input type="text" class="form-control" id="Id" name="Id" maxlength="120" required/>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="Password">Contraseña <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input type="password" class="form-control" id="Password" name="Password" maxlength="80" required/>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="Password2">Confirmar contraseña <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input type="password" class="form-control" id="Password2" name="Password2" maxlength="80" required/>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="UserGroup">Perfil de usuario <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <select class="form-control" id="UserGroup" name="UserGroup" required>
                                                    <?php
                                                    require '../config/connection.php';
                                                    echo '<option></option>';
                                                    $result = ejecutarConsulta("SELECT Id, Description FROM rol");
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                                                        echo '<option value="' . $row["Id"] . '">' . $row["Description"] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="divRegion" class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="txtRegion">Región
                                            </label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <select class="form-control" id="txtRegion" name="txtRegion">
                                                    <?php
                                                    require '../config/connection.php';
                                                    echo '<option value="">Todas</option>';
                                                    $result = ejecutarConsulta("select distinct(region) 'region' from agencias");
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                                                        echo '<option value="' . $row["region"] . '">' . $row["region"] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="divAgencia" class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="txtAgencia">Agencia
                                            </label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <select class="form-control" id="txtAgencia" multiple="multiple" size="4">
                                                    <?php
                                                    require '../config/connection.php';
                                                    $result = ejecutarConsulta("select distinct(nombre_agencia) 'nombre_agencia' from agencias order by nombre_agencia");
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                                                        echo '<option value="' . $row["nombre_agencia"] . '">' . $row["nombre_agencia"] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="divAgenciaAsign" class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="txtAgenciasAsign">Agencias asignadas
                                            </label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <textarea id="txtAgenciasAsign" name="txtAgenciasAsign" class="form-control" readonly></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 ">
                                            <center>
                                                <button class="btn btn-primary btn-sm" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                                <button class="btn btn-danger btn-sm" onclick="cancelar_formulario()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                            </center>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content -->
        </div>
        <!-- /page content -->
    </div>
</div>
<?php require 'footer.php'; ?>
<script src="scripts/users.js" type="text/javascript"></script>
<script src="scripts/functions.js" type="text/javascript"></script>