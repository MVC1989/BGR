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
                                <h2>Reporte Data (Búsquedas)</h2>
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

<!--<div class="daterangepicker dropdown-menu ltr single opensright show-calendar picker_4 xdisplay"><div class="calendar left single" style="display: block;"><div class="daterangepicker_input"><input class="input-mini form-control active" type="text" name="daterangepicker_start" value="" style="display: none;"><i class="fa fa-calendar glyphicon glyphicon-calendar" style="display: none;"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"><table class="table-condensed"><thead><tr><th class="prev available"><i class="fa fa-chevron-left glyphicon glyphicon-chevron-left"></i></th><th colspan="5" class="month">Oct 2016</th><th class="next available"><i class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></i></th></tr><tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr></thead><tbody><tr><td class="weekend off available" data-title="r0c0">25</td><td class="off available" data-title="r0c1">26</td><td class="off available" data-title="r0c2">27</td><td class="off available" data-title="r0c3">28</td><td class="off available" data-title="r0c4">29</td><td class="off available" data-title="r0c5">30</td><td class="weekend available" data-title="r0c6">1</td></tr><tr><td class="weekend available" data-title="r1c0">2</td><td class="available" data-title="r1c1">3</td><td class="available" data-title="r1c2">4</td><td class="available" data-title="r1c3">5</td><td class="available" data-title="r1c4">6</td><td class="available" data-title="r1c5">7</td><td class="weekend available" data-title="r1c6">8</td></tr><tr><td class="weekend available" data-title="r2c0">9</td><td class="available" data-title="r2c1">10</td><td class="available" data-title="r2c2">11</td><td class="available" data-title="r2c3">12</td><td class="available" data-title="r2c4">13</td><td class="available" data-title="r2c5">14</td><td class="weekend available" data-title="r2c6">15</td></tr><tr><td class="weekend available" data-title="r3c0">16</td><td class="available" data-title="r3c1">17</td><td class="today active start-date active end-date available" data-title="r3c2">18</td><td class="available" data-title="r3c3">19</td><td class="available" data-title="r3c4">20</td><td class="available" data-title="r3c5">21</td><td class="weekend available" data-title="r3c6">22</td></tr><tr><td class="weekend available" data-title="r4c0">23</td><td class="available" data-title="r4c1">24</td><td class="available" data-title="r4c2">25</td><td class="available" data-title="r4c3">26</td><td class="available" data-title="r4c4">27</td><td class="available" data-title="r4c5">28</td><td class="weekend available" data-title="r4c6">29</td></tr><tr><td class="weekend available" data-title="r5c0">30</td><td class="available" data-title="r5c1">31</td><td class="off available" data-title="r5c2">1</td><td class="off available" data-title="r5c3">2</td><td class="off available" data-title="r5c4">3</td><td class="off available" data-title="r5c5">4</td><td class="weekend off available" data-title="r5c6">5</td></tr></tbody></table></div></div><div class="calendar right" style="display: none;"><div class="daterangepicker_input"><input class="input-mini form-control" type="text" name="daterangepicker_end" value="" style="display: none;"><i class="fa fa-calendar glyphicon glyphicon-calendar" style="display: none;"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"><table class="table-condensed"><thead><tr><th></th><th colspan="5" class="month">Nov 2016</th><th class="next available"><i class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></i></th></tr><tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr></thead><tbody><tr><td class="weekend off available" data-title="r0c0">30</td><td class="off available" data-title="r0c1">31</td><td class="available" data-title="r0c2">1</td><td class="available" data-title="r0c3">2</td><td class="available" data-title="r0c4">3</td><td class="available" data-title="r0c5">4</td><td class="weekend available" data-title="r0c6">5</td></tr><tr><td class="weekend available" data-title="r1c0">6</td><td class="available" data-title="r1c1">7</td><td class="available" data-title="r1c2">8</td><td class="available" data-title="r1c3">9</td><td class="available" data-title="r1c4">10</td><td class="available" data-title="r1c5">11</td><td class="weekend available" data-title="r1c6">12</td></tr><tr><td class="weekend available" data-title="r2c0">13</td><td class="available" data-title="r2c1">14</td><td class="available" data-title="r2c2">15</td><td class="available" data-title="r2c3">16</td><td class="available" data-title="r2c4">17</td><td class="available" data-title="r2c5">18</td><td class="weekend available" data-title="r2c6">19</td></tr><tr><td class="weekend available" data-title="r3c0">20</td><td class="available" data-title="r3c1">21</td><td class="available" data-title="r3c2">22</td><td class="available" data-title="r3c3">23</td><td class="available" data-title="r3c4">24</td><td class="available" data-title="r3c5">25</td><td class="weekend available" data-title="r3c6">26</td></tr><tr><td class="weekend available" data-title="r4c0">27</td><td class="available" data-title="r4c1">28</td><td class="available" data-title="r4c2">29</td><td class="available" data-title="r4c3">30</td><td class="off available" data-title="r4c4">1</td><td class="off available" data-title="r4c5">2</td><td class="weekend off available" data-title="r4c6">3</td></tr><tr><td class="weekend off available" data-title="r5c0">4</td><td class="off available" data-title="r5c1">5</td><td class="off available" data-title="r5c2">6</td><td class="off available" data-title="r5c3">7</td><td class="off available" data-title="r5c4">8</td><td class="off available" data-title="r5c5">9</td><td class="weekend off available" data-title="r5c6">10</td></tr></tbody></table></div></div><div class="ranges" style="display: none;"><div class="range_inputs"><button class="applyBtn btn btn-sm btn-success" type="button">Apply</button> <button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button></div></div></div>-->
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
                                    <!--<div class="daterangepicker dropdown-menu ltr single opensright show-calendar picker_4 xdisplay"><div class="calendar left single" style="display: block;"><div class="daterangepicker_input"><input class="input-mini form-control active" type="text" name="daterangepicker_start" value="" style="display: none;"><i class="fa fa-calendar glyphicon glyphicon-calendar" style="display: none;"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"><table class="table-condensed"><thead><tr><th class="prev available"><i class="fa fa-chevron-left glyphicon glyphicon-chevron-left"></i></th><th colspan="5" class="month">Oct 2016</th><th class="next available"><i class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></i></th></tr><tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr></thead><tbody><tr><td class="weekend off available" data-title="r0c0">25</td><td class="off available" data-title="r0c1">26</td><td class="off available" data-title="r0c2">27</td><td class="off available" data-title="r0c3">28</td><td class="off available" data-title="r0c4">29</td><td class="off available" data-title="r0c5">30</td><td class="weekend available" data-title="r0c6">1</td></tr><tr><td class="weekend available" data-title="r1c0">2</td><td class="available" data-title="r1c1">3</td><td class="available" data-title="r1c2">4</td><td class="available" data-title="r1c3">5</td><td class="available" data-title="r1c4">6</td><td class="available" data-title="r1c5">7</td><td class="weekend available" data-title="r1c6">8</td></tr><tr><td class="weekend available" data-title="r2c0">9</td><td class="available" data-title="r2c1">10</td><td class="available" data-title="r2c2">11</td><td class="available" data-title="r2c3">12</td><td class="available" data-title="r2c4">13</td><td class="available" data-title="r2c5">14</td><td class="weekend available" data-title="r2c6">15</td></tr><tr><td class="weekend available" data-title="r3c0">16</td><td class="available" data-title="r3c1">17</td><td class="today active start-date active end-date available" data-title="r3c2">18</td><td class="available" data-title="r3c3">19</td><td class="available" data-title="r3c4">20</td><td class="available" data-title="r3c5">21</td><td class="weekend available" data-title="r3c6">22</td></tr><tr><td class="weekend available" data-title="r4c0">23</td><td class="available" data-title="r4c1">24</td><td class="available" data-title="r4c2">25</td><td class="available" data-title="r4c3">26</td><td class="available" data-title="r4c4">27</td><td class="available" data-title="r4c5">28</td><td class="weekend available" data-title="r4c6">29</td></tr><tr><td class="weekend available" data-title="r5c0">30</td><td class="available" data-title="r5c1">31</td><td class="off available" data-title="r5c2">1</td><td class="off available" data-title="r5c3">2</td><td class="off available" data-title="r5c4">3</td><td class="off available" data-title="r5c5">4</td><td class="weekend off available" data-title="r5c6">5</td></tr></tbody></table></div></div><div class="calendar right" style="display: none;"><div class="daterangepicker_input"><input class="input-mini form-control" type="text" name="daterangepicker_end" value="" style="display: none;"><i class="fa fa-calendar glyphicon glyphicon-calendar" style="display: none;"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"><table class="table-condensed"><thead><tr><th></th><th colspan="5" class="month">Nov 2016</th><th class="next available"><i class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></i></th></tr><tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr></thead><tbody><tr><td class="weekend off available" data-title="r0c0">30</td><td class="off available" data-title="r0c1">31</td><td class="available" data-title="r0c2">1</td><td class="available" data-title="r0c3">2</td><td class="available" data-title="r0c4">3</td><td class="available" data-title="r0c5">4</td><td class="weekend available" data-title="r0c6">5</td></tr><tr><td class="weekend available" data-title="r1c0">6</td><td class="available" data-title="r1c1">7</td><td class="available" data-title="r1c2">8</td><td class="available" data-title="r1c3">9</td><td class="available" data-title="r1c4">10</td><td class="available" data-title="r1c5">11</td><td class="weekend available" data-title="r1c6">12</td></tr><tr><td class="weekend available" data-title="r2c0">13</td><td class="available" data-title="r2c1">14</td><td class="available" data-title="r2c2">15</td><td class="available" data-title="r2c3">16</td><td class="available" data-title="r2c4">17</td><td class="available" data-title="r2c5">18</td><td class="weekend available" data-title="r2c6">19</td></tr><tr><td class="weekend available" data-title="r3c0">20</td><td class="available" data-title="r3c1">21</td><td class="available" data-title="r3c2">22</td><td class="available" data-title="r3c3">23</td><td class="available" data-title="r3c4">24</td><td class="available" data-title="r3c5">25</td><td class="weekend available" data-title="r3c6">26</td></tr><tr><td class="weekend available" data-title="r4c0">27</td><td class="available" data-title="r4c1">28</td><td class="available" data-title="r4c2">29</td><td class="available" data-title="r4c3">30</td><td class="off available" data-title="r4c4">1</td><td class="off available" data-title="r4c5">2</td><td class="weekend off available" data-title="r4c6">3</td></tr><tr><td class="weekend off available" data-title="r5c0">4</td><td class="off available" data-title="r5c1">5</td><td class="off available" data-title="r5c2">6</td><td class="off available" data-title="r5c3">7</td><td class="off available" data-title="r5c4">8</td><td class="off available" data-title="r5c5">9</td><td class="weekend off available" data-title="r5c6">10</td></tr></tbody></table></div></div><div class="ranges" style="display: none;"><div class="range_inputs"><button class="applyBtn btn btn-sm btn-success" type="button">Apply</button> <button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button></div></div></div>-->
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
                                            <th>FECHA INTERACCION</th>
                                            <th>NOMBRE CLIENTE</th>
                                            <th>IDENTIFICACION</th>
                                            <th>AGENCIA</th>
                                            <th>SECCION</th>
                                            <th>TRANSACCIÓN</th>
                                            <th>USUARIO_BGR</th>
                                            <th>USUARIO_KMB</th>
                                            <!--<th>Pregunta 1</th>-->
                                            <th> Califique del 1 al 7: El nivel de asesoría demostrado por la persona que lo atendió</th>
                                            <!--<th>Pregunta 1.1</th>-->
                                            <th>¿Cual es el motivo de su calificacion?</th>
                                            <!--<th>Pregunta 2</th>-->
                                            <th>Califique del 1 al 7: Qué tan clara fue la información entregada por el asesor al atender su requerimiento</th>
                                            <!--<th>Pregunta 2.1</th>-->
                                            <th>¿Cual es el motivo de su calificacion?</th>
                                            <!--<th>Pregunta 3</th>-->
                                            <th>Califique del 1 al 7: El ejecutivo que le atendió demostro interes por entender su necesidad</th>
                                            <!--<th>Pregunta 3.1</th>-->
                                            <th>¿Cual es el motivo de su calificacion?</th>
                                            <!--<th>Pregunta 4</th>-->
                                            <th>Califique del 1 al 7: El ejecutivo que le atendió demostro interes por entender su necesidad</th>
                                            <!--<th>Pregunta 4.1</th>-->
                                            <th>¿Cual es el motivo de su calificacion?</th>
                                            <!--<th>Pregunta 5</th>-->
                                            <th>Califique del 1 al 7: La solución brindada por el asesor para cubrir sus expectativas</th>
                                            <!--<th>Pregunta 5.1</th>-->
                                            <th>¿Cual es el motivo de su calificacion?</th>
                                            <!--<th>Pregunta 6</th>-->
                                            <th>Califique del 1 al 7: La respuesta a su requerimiento cumplió con sus expectativas</th>
                                            <!--<th>Pregunta 6.1</th>-->
                                            <th>¿Cual es el motivo de su calificacion?</th>
                                            <!--<th>Pregunta 7</th>-->
                                            <th>Califique del 1 al 7: La agilidad con la que el ejecutivo atendió su requerimiento</th>
                                            <!--<th>Pregunta 7.1</th>-->
                                            <th>¿Cual es el motivo de su calificacion?</th>
                                            <!--<th>Pregunta 8</th>-->
                                            <th>La facilidad para acceder a los servicios a través de nuestra Aplicación movil / Banca en linea / Call Center / Cajeros Automáticos</th>
                                            <!--<th>Pregunta 8.1</th>-->
                                            <th>¿Cual es el motivo de su calificacion?</th>
                                            <!--<th>Pregunta 9</th>-->
                                            <th>Califique del 1 al 10 siendo 1 poco satisfecho y 10 muy satisfecho: Su grado de satisfacción con el servicio recibido en BGR</th>
                                            <!--<th>Pregunta 9.1</th>-->
                                            <th>Qué fue lo que mas le gustó?</th>
                                            <!--<th>Pregunta 10</th>-->
                                            <th>Qué tan fácil o sencillo es para usted gestionar su requerimiento de ... en la agencia ...</th>
                                            <!--<th>Pregunta 10.1</th>-->
                                            <th>Qué lo hizo Muy fácil/ fácil?</th>
                                            <!--<th>Pregunta 11</th>-->
                                            <th>En escala de 0 a 10 siendo 0 no lo recomendaría y 10 si lo recomendaría ¿en qué grado recomendaría BGR a un familiar, amigo o colega de trabajo?, siendo 0 definitivamente no recomendaría y 10 definitivamente sí lo recomendaría</th>
                                            <!--<th>Pregunta 11.1</th>-->
                                            <th>¿Cuál es el motivo de su calificación?</th>
                                            <!--<th>Pregunta 12</th>-->
                                            <th>Si su experiencia con BGR se mantiene como hasta el momento… cuanto tiempo estaría dispuesto a ser cliente de BGR</th>
                                            <!--<th>Pregunta 12.1</th>-->
                                            <th>¿Cuál es el motivo de su calificación?</th>
                                            <!--<th>Pregunta 13</th>-->
                                            <th>Califique del 1 al 7 siendo 1 malo y 7 excelente: como califica las medidas sanitarias aplicadas por BGR en su visita a la Agencia</th>
                                            <!--<th>Pregunta 13.1</th>-->
                                            <th>¿Cuál es el motivo de su calificación?</th>
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
<?php require 'footer.php'; ?>
<script src="scripts/reporteData.js" type="text/javascript"></script>
<script src="scripts/functions.js" type="text/javascript"></script>