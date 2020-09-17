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
                                <h2>Reporte Data Canales Electrónicos (Búsquedas)</h2>
                                <ul class="nav navbar-right">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div id="filtros" class="x_content">
                                <div class="col-md-2 col-sm-2">
                                    <label for="txtCanal" ><b>Canal Electrónico</b></label>
                                    <select id="txtCanal" name="txtCanal" class="form-control">
                                        <option value="">TODOS</option>
                                        <option>BGR MOVIL</option>
                                        <option>BGR NET</option>
                                        <option>CALL CENTER</option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-3">
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
                                <div class="col-md-3 col-sm-3">
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
                                            <th>CANAL</th>
                                            <th>TRANSACCIÓN</th>
                                            <th>USUARIO_BGR</th>
                                            <th>USUARIO_KMB</th>
                                            <!--<th>Pregunta 1</th>-->
                                            <th> Califique del 1 al 7: El nivel de asesoría que recibió del agente que atendió su requerimiento/Los servicios presentados en la banca web o aplicación móvil para la solución de su requerimiento</th>
                                            <!--<th>Pregunta 1.1</th>-->
                                            <th>¿Cual es el motivo de su calificacion?</th>
                                            <!--<th>Pregunta 2</th>-->
                                            <th>Califique del 1 al 7: ¿Qué tan clara fue la información qué recibió?</th>
                                            <!--<th>Pregunta 2.1</th>-->
                                            <th>¿Cual es el motivo de su calificacion?</th>
                                            <!--<th>Pregunta 3</th>-->
                                            <th>Califique del 1 al 7: ¿Qué tan útil fue la información o guía que recibió?</th>
                                            <!--<th>Pregunta 3.1</th>-->
                                            <th>¿Cual es el motivo de su calificacion?</th>
                                            <!--<th>Pregunta 4</th>-->
                                            <th>Califique del 1 al 7: La amabilidad demostrada del agente que atendió su requerimiento</th>
                                            <!--<th>Pregunta 4.1</th>-->
                                            <th>¿Cual es el motivo de su calificacion?</th>
                                            <!--<th>Pregunta 5</th>-->
                                            <th>Califique del 1 al 7: El interés desmostrado por el agente que atendió su requerimiento</th>
                                            <!--<th>Pregunta 5.1</th>-->
                                            <th>¿Cual es el motivo de su calificacion?</th>
                                            <!--<th>Pregunta 6</th>-->
                                            <th>Califique del 1 al 7: El tiempo de espera para ser atendido por un agente</th>
                                            <!--<th>Pregunta 6.1</th>-->
                                            <th>¿Cual es el motivo de su calificacion?</th>
                                            <!--<th>Pregunta 7</th>-->
                                            <th>Califique del 1 al 7: La solución recibida por parte del agente/ Los servicios disponibles en la banca electrónica o aplicación móvil cubren sus necesidades</th>
                                            <!--<th>Pregunta 7.1</th>-->
                                            <th>¿Cual es el motivo de su calificacion?</th>
                                            <!--<th>Pregunta 8</th>-->
                                            <th>Califique del 1 al 7: La iniciativa demostrada por el agente/</th>
                                            <!--<th>Pregunta 8.1</th>-->
                                            <th>¿Cual es el motivo de su calificacion?</th>
                                            <!--<th>Pregunta 9</th>-->
                                            <th>Califique del 1 al 7: La agilidad demostrada por el agente/¿Qué tan rápido pudo realizar su transacción/consulta en la aplicación móvil o banca web?</th>
                                            <!--<th>Pregunta 9.1</th>-->
                                            <th>¿Cuál es el motivo de su calificación?</th>
                                            <!--<th>Pregunta 10</th>-->
                                            <th>Califique del 1 al 7: Las alternativas brindadas por el agente</th>
                                            <!--<th>Pregunta 10.1</th>-->
                                            <th>¿Cuál es el motivo de su calificación?</th>
                                            <!--<th>Pregunta 11</th>-->
                                            <th>Califique del 1 al 7: La facilidad para acceder a los servicios de la Aplicación Móvil o banca web</th>
                                            <!--<th>Pregunta 11.1</th>-->
                                            <th>¿Cuál es el motivo de su calificación?</th>
                                            <!--<th>Pregunta 12</th>-->
                                            <th>Califique del 1 al 7: El nivel de innovación que ve en la aplicación móvil o banca web</th>
                                            <!--<th>Pregunta 12.1</th>-->
                                            <th>¿Cuál es el motivo de su calificación?</th>
                                            <!--<th>Pregunta 13</th>-->
                                            <th>Califique del 1 al 10 siendo 1 poco satisfecho y 10 muy satisfecho: Su grado de satisfacción con el servicio recibido en BGR</th>
                                            <!--<th>Pregunta 13.1</th>-->
                                            <th>¿Cuál es el motivo de su calificación?</th>
                                            <!--<th>Pregunta 14</th>-->
                                            <th>¿Qué tan facil es para usted realizar una transacción/consulta?</th>
                                            <!--<th>Pregunta 14.1</th>-->
                                            <th>¿Cuál es el motivo de su calificación?</th>
                                            <!--<th>Pregunta 15</th>-->
                                            <th>En escala de 0 a 10 siendo 0 no lo recomendaría y 10 si lo recomendaría ¿en qué grado recomendaría BGR a un familiar, amigo o colega de trabajo?, siendo 0 definitivamente no recomendaría y 10 definitivamente sí lo recomendaría</th>
                                            <!--<th>Pregunta 15.1</th>-->
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
<script src="scripts/reportDataCanales.js" type="text/javascript"></script>
<script src="scripts/functions.js" type="text/javascript"></script>