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
                            <div class="x_title border-dark">
                                <div class="col-md-11 col-sm-11">
                                    <h2>Gestión de Canales Electrónicos (Búsquedas)</h2>
                                </div>
                                <div class="col-md-1 col-sm-1">
                                    <!--<a class="collapse-link"><i class="fa fa-chevron-up"></i>-->
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div id="filtros" class="x_content">
                                <div class="col-md-2 col-sm-2">
                                    <label for="txtCanal" ><b>Canal</b></label>
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
                                                    <input type="text" class="form-control has-feedback-left" id="txtFechaInicio" name="txtFechaInicio" aria-describedby="inputSuccess2Status4">
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
                                <div class="col-md-1 col-sm-1">
                                    <br>
                                    <button id="btnBuscar" type="button" class="btn-sm btn-primary">Buscar</button>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 border-dark" id="divLealtad">
                        <div class="x_panel border-dark">
                            <div class="x_title text-dark border-dark">
                                <div class="col-md-11 col-sm-11">
                                    <h2>Bloque - Lealtad</h2>
                                </div>
                                <div class="col-md-1 col-sm-1">
                                    <!--<a class="collapse-link"><i class="fa fa-chevron-up"></i>-->
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content text-center">
                                <div class="col-md-4 col-sm-4 ">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <div class="col-md-1 col-sm-1">
                                                <!--<a class="collapse-link"><i class="fa fa-chevron-up"></i>-->
                                            </div>
                                            <div class="col-md-11 col-sm-11">
                                                <h4>Índice Neto Recomendación(NPS)</h4>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content text-center">
                                            <input id="txtNPS" name="txtNPS" class="knob" data-step=".01" data-width="180" data-height="120" data-angleOffset=-98 data-angleArc=200 data-fgColor="#32A51E" readonly />
                                            <!--                                            <div id="barraNPS" class="progress">
                                                                                            
                                                                                        </div>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <div class="col-md-1 col-sm-1">
                                                <!--<a class="collapse-link"><i class="fa fa-chevron-up"></i>-->
                                            </div>
                                            <div class="col-md-11 col-sm-11">
                                                <h4>Índice Neto de Satisfacción (INS)</h4>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content text-center" id="divINS">
                                            <input id="txtINS" name="txtINS" class="knob" data-step=".01" data-width="180" data-height="120" data-angleOffset=-98 data-angleArc=200 readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 ">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <div class="col-md-1 col-sm-1">
                                                <!--<a class="collapse-link"><i class="fa fa-chevron-up"></i>-->
                                            </div>
                                            <div class="col-md-11 col-sm-11">
                                                <h4>Indicador de Esfuerzo <br>(CES)</h4>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content text-center">
                                            <input id="txtCES" name="txtCES" class="knob" data-step=".01" data-width="180" data-height="120" data-angleOffset=-98 data-angleArc=200 readonly />
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
                                                        <thead  class="text-center">
                                                        <th>Momento</th>
                                                        <th>Muestra</th>
                                                        <th>NPS</th>
                                                        <th>INS</th>
                                                        <th>CES</th>
                                                        <th>Lealtad</th>
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
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"><br></div>
                    <div class="col-md-12 col-sm-12 border-dark" id="divAtributos">
                        <div class="x_panel border-dark">
                            <div class="x_title border-dark">
                                <div class="col-md-11 col-sm-11">
                                    <h2 class="text-dark">Bloque - Atributos: Visión de Experiencia</h2>
                                </div>
                                <div class="col-md-1 col-sm-1">
                                    <!--<a class="collapse-link"><i class="fa fa-chevron-up"></i>-->
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content text-center">
                                <div class="x_content text-center">
                                    <div class="col-md-4 col-sm-4 "><br></div>
                                    <div class="col-md-4 col-sm-4 ">
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <div class="col-md-1 col-sm-1">
                                                    <!--<a class="collapse-link"><i class="fa fa-chevron-up"></i>-->
                                                </div>
                                                <div class="col-md-11 col-sm-11">
                                                    <h4>Visión de experiencia</h4>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content text-center">
                                                <input id="txtVision" name="txtVision" class="knob" data-step=".01" data-width="180" data-height="120" data-angleOffset=-98 data-angleArc=200 readonly />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="x_content fixedHeader-locked">
                                    <div class="x_content">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-12">
                                                <div id="listadoRegistros1" class="table-responsive">
                                                    <table id="tblListado1" class="table table-striped border" style="width:100%">
                                                        <thead class="text-center">
                                                            <tr>
                                                                <th class="border-dark">PILARES</th>
                                                                <th class="text-center border-left border-dark" colspan="3">COMUNICACIÓN</th>
                                                                <th class="text-center border-left border-dark" colspan="3">SERVICIO</th>
                                                                <th class="text-center border-left border-dark" colspan="2">PERSONALIZACIÓN</th>
                                                                <th class="text-center border-left border-dark" colspan="2">PROCESOS</th>
                                                                <th class="text-center border-left border-dark" colspan="2">DIGITAL</th>
                                                                <th class="text-center border-left border-dark">VISION DE EXPERIENCIA</th>
                                                            </tr>
                                                            <tr>
                                                                <th class="border-dark">ATRIBUTOS</th>
                                                                <th class="text-center border-left border-dark">Asesoría</th>
                                                                <th class="text-center border-left border-dark">Claridad de la Información</th>
                                                                <th class="text-center border-left border-dark">Oportunidad</th>
                                                                <th class="text-center border-left border-dark">Actitud</th>
                                                                <th class="text-center border-left border-dark">Empatía</th>
                                                                <th class="text-center border-left border-dark">Efectividad</th>
                                                                <th class="text-center border-left border-dark">Solución</th>
                                                                <th class="text-center border-left border-dark">Proactividad</th>
                                                                <th class="text-center border-left border-dark">Agilidad</th>
                                                                <th class="text-center border-left border-dark">Flexibilidad</th>
                                                                <th class="text-center border-left border-dark">Accesibilidad</th>
                                                                <th class="text-center border-left border-dark">Innovación</th>
                                                                <th class="text-center border-left border-dark"></th>
                                                            </tr>
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
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
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
<script src="scripts/frontGestionCanalesElec.js" type="text/javascript"></script>