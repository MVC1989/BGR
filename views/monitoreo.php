<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

<div class="container body">
    <div class="main_container">
        <!-- page content -->
        <div class="right_col" role="main">
            <!-- content -->
            <div class="row">
                <div class="x_panel">
                    <div class="col-md-12 col-sm-12">
                        <div class="x_panel text-dark border-dark">
                            <div class="x_title border-dark  ">
                                <h2>Monitoreo (Búsquedas)</h2>
                                <ul class="nav navbar-right">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div id="filtros" class="x_content">
                                <div class="col-md-2 col-sm-2">
                                    <label for="txtRegion" ><b>Región</b></label>
                                    <select id="txtRegion" name="txtRegion" class="form-control">
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-2">
                                    <label class="control-label" for="txtAgencia"><b>Agencia</b></label>
                                    <!--<input id="txtAgencia" name="txtAgencia" type="text" class="form-control" value="" />-->
                                    <select id="txtAgencia" name="txtAgencia" class="form-control" >
                                        <!--<option>Choose option</option>-->
                                    </select>
                                </div>
                                <div id="divAgencia" class="col-md-2 col-sm-2">
                                    <input type="hidden" class="form-control" id="txtAgencia1" name="txtAgencia1"/>
                                </div>
                                <div class="col-md-2 col-sm-2">
                                    <label for="txtArea"><b>Área</b></label>
                                    <select id="txtArea" name="txtArea" class="form-control">
                                        <option value="">Todas</option>
                                        <option>Negocios</option>
                                        <option>Servicios</option>
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-2">
                                    <label for="txtSeccion"><b>Sección</b></label>
                                    <select id="txtSeccion" name="txtSeccion" class="form-control">
                                        <option value="">Todas</option>
                                    </select>
                                </div>
                                <div id="divTipoCliente" class="col-md-3 col-sm-3">
                                    <label for="txtTipoCliente"><b>Tipo cliente</b></label>
                                    <select id="txtTipoCliente" name="txtTipoCliente" class="form-control">
                                        <option value="">Todos</option>
                                        <option>Civil</option>
                                        <option>Militar</option>
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-2">
                                    <label for="txtFechaInicio"><b>Fecha desde</b></label>
                                    <fieldset class="">
                                        <div class="control-group">
                                            <div class="controls">
                                                <div class="col-md-12 col-sm-12 xdisplay_inputx form-group row has-feedback">
                                                    <input type="text" class="form-control has-feedback-left" id="txtFechaInicio" name="txtFechaInicio">
                                                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                                    <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-md-2 col-sm-2">
                                    <label for="txtFechaFin"><b>Fecha hasta</b></label>
                                    <fieldset>
                                        <div class="control-group">
                                            <div class="controls">
                                                <div class="col-md-12 xdisplay_inputx form-group row has-feedback">
                                                    <input type="text" class="form-control has-feedback-left" id="txtFechaFin" name="txtFechaFin">
                                                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                                    <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-md-5 col-sm-5">
                                    <br>
                                </div>
                                <div class="col-md-2 col-sm-2">
                                    <br>
                                    <button id="btnBuscar" type="button" class="btn-sm btn-primary">Buscar</button>
                                </div>
                                <div class="col-md-5 col-sm-5">
                                    <br>
                                </div>
                                <div class="clearfix"></div>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"><br></div>
                    <div class="x_content fixedHeader-locked">
                        <div class="x_content">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div id="listadoRegistros" class="table-responsive">
                                        <table id="tblListado" class="table table-striped" style="width:100%">
                                            <thead class="text-justify">
                                            <th>ACCIONES</th>
                                            <th>IDENTIFICACION</th>
                                            <th>FECHA ATENCION</th>
                                            <th>REGION</th>
                                            <th>AGENCIA</th>
                                            <th>SECCION</th>
                                            <th>TRANSACCIÓN</th>
                                            <th>USUARIO_KMB</th>
                                            <th>EVALUADOR</th>
                                            <th>ESTADO MONITOREO</th>
                                            <th>CRITERIO</th>
                                            <th>TMA</th>
                                            </thead>
                                            <tbody class="text-center">        
                                            </tbody>
                                            <tfoot>
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
                                            <th></th>
                                            <th></th>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
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
<div class="modal" id="calificacionesModal" tabindex="-1" role="dialog">
    <div class="modal-body scroll-view" role="document" col-md-10 col-sm-10>
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Monitoreo</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="divTable">
                    <div class="divTableBody">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-2 col-sm-2">
                                <label class="col-form-label label-align" for="txtEvaluador">Evaluador:</label>
                                <input type="text" class="form-control" id="txtEvaluador" name="txtEvaluador" readonly/>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <label class="col-form-label label-align" for="txtUsuario">Usuario:</label>
                                <input type="text" class="form-control" id="txtUsuario" name="txtUsuario" readonly/>
                            </div> 
                            <div class="col-md-2 col-sm-2">
                                <label class="col-form-label label-align" for="txtEstadoMonitoreo">Estado monitoreo:</label>
                                <input type="text" class="form-control" id="txtEstadoMonitoreo" name="txtEstadoMonitoreo" readonly/>
                            </div>
                            <div class="col-md-1 col-sm-1">
                                <label class="col-form-label label-align" for="txtEstadoLlamada">Estado llamada:</label>
                                <input type="text" class="form-control" id="txtEstadoLlamada" name="txtEstadoLlamada" readonly/>
                            </div>
                            <div class="col-md-1 col-sm-1">
                                <label class="col-form-label label-align" for="txtCriterio">Criterio llamada:</label>
                                <input type="text" class="form-control" id="txtCriterio" name="txtCriterio" readonly/>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <label class="col-form-label label-align" for="txtTMA">Tiempo Medio Atención (TMA):</label>
                                <input type="text" class="form-control" id="txtTMA" name="txtTMA" readonly/>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <label class="col-form-label label-align" for="txtFechaInteracion">Fecha Atención:</label>
                                <input type="text" class="form-control" id="txtFechaInteracion" name="txtFechaInteracion" readonly/>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-2 col-sm-2">
                                <label class="col-form-label label-align" for="txtCampania">Campaña:</label>
                                <input type="text" class="form-control" id="txtCampania" name="txtCampania" readonly/>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <label class="col-form-label label-align" for="txtProducto">Producto:</label>
                                <input type="text" class="form-control" id="txtProducto" name="txtProducto" readonly/>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <label class="col-form-label label-align" for="txtIdenticacion">Identificación:</label>
                                <input type="text" class="form-control" id="txtIdenticacion" name="txtIdenticacion" readonly/>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <label class="col-form-label label-align" for="txtRegion1">Región:</label>
                                <input type="text" class="form-control" id="txtRegion1" name="txtRegion1" readonly/>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <label class="col-form-label label-align" for="txtAgencias">Agencia:</label>
                                <input type="text" class="form-control" id="txtAgencias" name="txtAgencias" readonly/>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <label class="col-form-label label-align" for="txtAreas">Área:</label>
                                <input type="text" class="form-control" id="txtAreas" name="txtAreas" readonly/>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-2 col-sm-2">
                                <label class="col-form-label label-align" for="txtSeccion1">Sección:</label>
                                <input type="text" class="form-control" id="txtSeccion1" name="txtSeccion1" readonly/>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <label class="col-form-label label-align" for="txtTramite1">Trámite:</label>
                                <input type="text" class="form-control" id="txtTramite1" name="txtTramite1" readonly/>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <label class="col-form-label label-align" for="txtNota_ECN">Nota ECN:</label>
                                <input type="text" class="form-control" id="txtNota_ECN" name="txtNota_ECN" readonly/>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <label class="col-form-label label-align" for="txtNota_ECUF">Nota ECUF:</label>
                                <input type="text" class="form-control" id="txtNota_ECUF" name="txtNota_ECUF" readonly/>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <label class="col-form-label label-align" for="txtNota_ENC">Nota ENC:</label>
                                <input type="text" class="form-control" id="txtNota_ENC" name="txtNota_ENC" readonly/>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <label class="col-form-label label-align" for="txtTotal">Total:</label>
                                <input type="text" class="form-control" id="txtTotal" name="txtTotal" readonly/>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12"><hr></div>
                        <div class="col-md-1 col-sm-1"></div>
                        <div class="col-md-10 col-sm-10 align-middle">
                            <table class="table table-responsive">
                                <thead class="text-center bg-blue-sky">
                                <th>100%</th>
                                <th>ERROR NO CRITICO (ENC)</th>
                                <th>AFECTACIÓN</th>
                                </thead>
                                <tbody class="text-center">
                                    <tr>
                                        <td rowspan="2" class="align-middle"><b>SALUDO 5%</b></td>
                                        <td>Aplica protocolo de Saludos (Nombre y apellido, Asistencia)</td>
                                        <td><input type="text" class="form-control" id="txtSaludo1" name="txtSaludo1" readonly/></td>
                                    </tr>
                                    <tr>
                                        <td>Personalización de la llamada(Dos Nombres Dos Apellidos del cliente)</td>
                                        <td><input type="text" class="form-control" id="txtSaludo2" name="txtSaludo2" readonly/></td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2" class="align-middle"><b>PRESENTACIÓN 35%</b></td>
                                        <td>Presentación completa del Script</td>
                                        <td><input type="text" class="form-control" id="txtPresentacion1" name="txtPresentacion1" readonly/></td>
                                    </tr>
                                    <tr>
                                        <td>Indagar con el cliente para generar vinculos de confianza: (Quién, qué, cómo, cuándo, cuánto)</td>
                                        <td><input type="text" class="form-control" id="txtPresentacion2" name="txtPresentacion2" readonly/></td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle"><b>CIERRE 5%</b></td>
                                        <td>Mantiene la actitiud adecuada al cliente independiente al resultado de la llamada</td>
                                        <td><input type="text" class="form-control" id="txtCierre1" name="txtCierre1" readonly/></td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle" rowspan="5"><b>COMUNICACIÓN 15%</b></td>
                                        <td>Pronunciación y Modulación Utiliza un tono de voz  y ritmo adecuado</td>
                                        <td><input type="text" class="form-control" id="txtComunicacion1" name="txtComunicacion1" readonly/></td>
                                    </tr>
                                    <tr>
                                        <td>No interrumpe</td>
                                        <td><input type="text" class="form-control" id="txtComunicacion2" name="txtComunicacion2" readonly/></td>
                                    </tr>
                                    <tr>
                                        <td>Escucha activa</td>
                                        <td><input type="text" class="form-control" id="txtComunicacion3" name="txtComunicacion3" readonly/></td>
                                    </tr>
                                    <tr>
                                        <td>Demuestra amabilidad y cortesía</td>
                                        <td><input type="text" class="form-control" id="txtComunicacion4" name="txtComunicacion4" readonly/></td>
                                    </tr>
                                    <tr>
                                        <td>Evita el uso de muletillas, interjecciones, diminutivos, dubitativas, refranes o expresiones coloquiales</td>
                                        <td><input type="text" class="form-control" id="txtComunicacion5" name="txtComunicacion5" readonly/></td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle bg-blue-sky" colspan="3">EJECUCIÓN DEL PROCEDIMIENTO - ERRORES CRITICOS 20%</td>
                                    </tr>
                                    <tr>
                                        <td><b>INS</b></td>
                                        <td>CALIFICACIÓN DE MANERA GENERAL</td>
                                        <td><input type="text" class="form-control" id="txtErroresCriticos1" name="txtErroresCriticos1" readonly/></td>
                                    </tr>
                                    <tr>
                                        <td><b>CES</b></td>
                                        <td>CALIFICACIÓN ATENCIÓN DEL ASESOR</td>
                                        <td><input type="text" class="form-control" id="txtErroresCriticos2" name="txtErroresCriticos2" readonly/></td>
                                    </tr>
                                    <tr>
                                        <td><b>NPS</b></td>
                                        <td>CALIFICACIÓN DE MANERA GENERAL </td>
                                        <td><input type="text" class="form-control" id="txtErroresCriticos3" name="txtErroresCriticos3" readonly/></td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle" rowspan="3"><b>ERRORES CRITICOS AL CUMPLIMIENTO 20%</b></td>
                                        <td>Procesa correctamente dentro de herramientas y aplicativos de la asistencia</td>
                                        <td><input type="text" class="form-control" id="txtErroresCriticosCumplimiento1" name="txtErroresCriticosCumplimiento1" readonly/></td>
                                    </tr>
                                    <tr>
                                        <td>Tipifica estados/sub estados/observación</td>
                                        <td><input type="text" class="form-control" id="txtErroresCriticosCumplimiento2" name="txtErroresCriticosCumplimiento2" readonly/></td>
                                    </tr>
                                    <tr>
                                        <td>Evita promover planteamientos negativos del servicio</td>
                                        <td><input type="text" class="form-control" id="txtErroresCriticosCumplimiento3" name="txtErroresCriticosCumplimiento3" readonly/></td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle bg-blue-sky" colspan="3"><b>FINAL</b></td>
                                    </tr>
                                    <tr>
                                        <td><b>¿Qué hizo bien?</b></td>
                                        <td colspan="2"><textarea class="form-control" id="txtManejoGestion1" name="txtManejoGestion1" readonly></textarea></td>
                                    </tr>
                                    <tr>
                                        <td><b>¿Qué puede hacer diferente?</b></td>
                                        <td colspan="2"><textarea type="text" class="form-control" id="txtMejoras1" name="txtMejoras1" readonly></textarea></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="btnGuardar">Guardar</button>
                                <button type="button" class="btn btn-secondary" id="btnCancelar" data-dismiss="modal">Cancelar</button>
                            </div>-->
            </div>
        </div>
    </div>
</div>
<?php require 'footer.php'; ?>
<script src="scripts/calificaciones.js" type="text/javascript"></script>
<script src="scripts/functions.js" type="text/javascript"></script>