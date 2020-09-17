<?php require 'header.php'; ?>
<?php require 'menu.php';
?>
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
                                <div class="col-md-11 col-sm-11">
                                    <h2>Negocios (Búsquedas)</h2>
                                </div>
                                <div class="col-md-1 col-sm-1">
                                    <!--<a class="collapse-link"><i class="fa fa-chevron-up"></i>-->
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div id="filtros" class="x_content">
                                <div class="col-md-2 col-sm-2">
                                    <label for="txtRegion">Región</label>
                                    <select id="txtRegion" name="txtRegion" class="form-control">
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-2">
                                    <label class="control-label" for="txtAgencia">Agencia</label>
                                    <!--<input id="txtAgencia" name="txtAgencia" type="text" class="form-control" value="" />-->
                                    <select id="txtAgencia" name="txtAgencia" class="form-control">
                                        <!--<option>Choose option</option>-->
                                    </select>
                                </div>
                                <div id="eAgencia" class="col-md-2 col-sm-2">
                                    <input type="text" class="form-control" id="txtAgencia1" name="txtAgencia1"/>
                                </div>
                                <!--                                <div class="col-md-3 col-sm-3">
                                                                    <label for="txtArea">Área</label>
                                                                    <select id="txtArea" name="txtArea" class="form-control">
                                                                        <option value="">Todas</option>
                                                                        <option>Negocios</option>
                                                                        <option>Servicios</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-3 col-sm-3">
                                                                    <label for="txtSeccion">Sección</label>
                                                                    <select id="txtSeccion" name="txtSeccion" class="form-control">
                                                                        <option value="">Todas</option>
                                                                    </select>
                                                                </div>-->
                                <div id="divTipoCliente" class="col-md-2 col-sm-2">
                                    <label for="txtTipoCliente">Tipo cliente</label>
                                    <select id="txtTipoCliente" name="txtTipoCliente" class="form-control">
                                        <option value="">Todos</option>
                                        <option>Civil</option>
                                        <option>Militar</option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <label for="txtFechaInicio"><b>Fecha desde</b></label>
                                    <!--<div class="daterangepicker dropdown-menu ltr single opensright show-calendar picker_4 xdisplay"><div class="calendar left single" style="display: block;"><div class="daterangepicker_input"><input class="input-mini form-control active" type="text" name="daterangepicker_start" value="" style="display: none;"><i class="fa fa-calendar glyphicon glyphicon-calendar" style="display: none;"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"><table class="table-condensed"><thead><tr><th class="prev available"><i class="fa fa-chevron-left glyphicon glyphicon-chevron-left"></i></th><th colspan="5" class="month">Oct 2016</th><th class="next available"><i class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></i></th></tr><tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr></thead><tbody><tr><td class="weekend off available" data-title="r0c0">25</td><td class="off available" data-title="r0c1">26</td><td class="off available" data-title="r0c2">27</td><td class="off available" data-title="r0c3">28</td><td class="off available" data-title="r0c4">29</td><td class="off available" data-title="r0c5">30</td><td class="weekend available" data-title="r0c6">1</td></tr><tr><td class="weekend available" data-title="r1c0">2</td><td class="available" data-title="r1c1">3</td><td class="available" data-title="r1c2">4</td><td class="available" data-title="r1c3">5</td><td class="available" data-title="r1c4">6</td><td class="available" data-title="r1c5">7</td><td class="weekend available" data-title="r1c6">8</td></tr><tr><td class="weekend available" data-title="r2c0">9</td><td class="available" data-title="r2c1">10</td><td class="available" data-title="r2c2">11</td><td class="available" data-title="r2c3">12</td><td class="available" data-title="r2c4">13</td><td class="available" data-title="r2c5">14</td><td class="weekend available" data-title="r2c6">15</td></tr><tr><td class="weekend available" data-title="r3c0">16</td><td class="available" data-title="r3c1">17</td><td class="today active start-date active end-date available" data-title="r3c2">18</td><td class="available" data-title="r3c3">19</td><td class="available" data-title="r3c4">20</td><td class="available" data-title="r3c5">21</td><td class="weekend available" data-title="r3c6">22</td></tr><tr><td class="weekend available" data-title="r4c0">23</td><td class="available" data-title="r4c1">24</td><td class="available" data-title="r4c2">25</td><td class="available" data-title="r4c3">26</td><td class="available" data-title="r4c4">27</td><td class="available" data-title="r4c5">28</td><td class="weekend available" data-title="r4c6">29</td></tr><tr><td class="weekend available" data-title="r5c0">30</td><td class="available" data-title="r5c1">31</td><td class="off available" data-title="r5c2">1</td><td class="off available" data-title="r5c3">2</td><td class="off available" data-title="r5c4">3</td><td class="off available" data-title="r5c5">4</td><td class="weekend off available" data-title="r5c6">5</td></tr></tbody></table></div></div><div class="calendar right" style="display: none;"><div class="daterangepicker_input"><input class="input-mini form-control" type="text" name="daterangepicker_end" value="" style="display: none;"><i class="fa fa-calendar glyphicon glyphicon-calendar" style="display: none;"></i><div class="calendar-time" style="display: none;"><div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i></div></div><div class="calendar-table"><table class="table-condensed"><thead><tr><th></th><th colspan="5" class="month">Nov 2016</th><th class="next available"><i class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></i></th></tr><tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr></thead><tbody><tr><td class="weekend off available" data-title="r0c0">30</td><td class="off available" data-title="r0c1">31</td><td class="available" data-title="r0c2">1</td><td class="available" data-title="r0c3">2</td><td class="available" data-title="r0c4">3</td><td class="available" data-title="r0c5">4</td><td class="weekend available" data-title="r0c6">5</td></tr><tr><td class="weekend available" data-title="r1c0">6</td><td class="available" data-title="r1c1">7</td><td class="available" data-title="r1c2">8</td><td class="available" data-title="r1c3">9</td><td class="available" data-title="r1c4">10</td><td class="available" data-title="r1c5">11</td><td class="weekend available" data-title="r1c6">12</td></tr><tr><td class="weekend available" data-title="r2c0">13</td><td class="available" data-title="r2c1">14</td><td class="available" data-title="r2c2">15</td><td class="available" data-title="r2c3">16</td><td class="available" data-title="r2c4">17</td><td class="available" data-title="r2c5">18</td><td class="weekend available" data-title="r2c6">19</td></tr><tr><td class="weekend available" data-title="r3c0">20</td><td class="available" data-title="r3c1">21</td><td class="available" data-title="r3c2">22</td><td class="available" data-title="r3c3">23</td><td class="available" data-title="r3c4">24</td><td class="available" data-title="r3c5">25</td><td class="weekend available" data-title="r3c6">26</td></tr><tr><td class="weekend available" data-title="r4c0">27</td><td class="available" data-title="r4c1">28</td><td class="available" data-title="r4c2">29</td><td class="available" data-title="r4c3">30</td><td class="off available" data-title="r4c4">1</td><td class="off available" data-title="r4c5">2</td><td class="weekend off available" data-title="r4c6">3</td></tr><tr><td class="weekend off available" data-title="r5c0">4</td><td class="off available" data-title="r5c1">5</td><td class="off available" data-title="r5c2">6</td><td class="off available" data-title="r5c3">7</td><td class="off available" data-title="r5c4">8</td><td class="off available" data-title="r5c5">9</td><td class="weekend off available" data-title="r5c6">10</td></tr></tbody></table></div></div><div class="ranges" style="display: none;"><div class="range_inputs"><button class="applyBtn btn btn-sm btn-success" type="button">Apply</button> <button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button></div></div></div>-->
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
                                <div class="col-md-2 col-sm-2">
                                    <br>
                                    <button id="btnBuscar" type="button" class="btn-sm btn-primary">Buscar</button>
                                </div>
                                <div class="clearfix"></div>
                                <br>
                            </div>
                        </div>
                    </div>                    
                    <div class="col-md-12 col-sm-12 border-dark">
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
                                            <input id="txtINS" name="txtINS" class="knob" data-step=".01" data-width="180" data-height="120" data-angleOffset=-98 data-angleArc=200 data-fgColor="#AB412A" readonly />
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
                                            <input id="txtCES" name="txtCES" class="knob" data-step=".01" data-width="180" data-height="120" data-angleOffset=-98 data-angleArc=200 data-fgColor="#3459F0"  readonly />
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
                    <div class="col-md-12 col-sm-12 border-dark">
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
                                                                <th class="text-center border-left border-dark" colspan="2">COMUNICACIÓN</th>
                                                                <th class="text-center border-left border-dark" colspan="2">SERVICIO</th>
                                                                <th class="text-center border-left border-dark" colspan="2">PERSONALIZACIÓN</th>
                                                                <th class="text-center border-left border-dark">PROCESOS</th>
                                                                <th class="text-center border-left border-dark">DIGITAL</th>
                                                                <th class="text-center border-left border-dark">VISION DE EXPERIENCIA</th>
                                                            </tr>
                                                            <tr>
                                                                <th class="border-dark">ATRIBUTOS</th>
                                                                <th class="text-center border-left border-dark">Asesoría</th>
                                                                <th class="text-center border-left border-dark">Claridad de la Información</th>
                                                                <th class="text-center border-left border-dark">Amabilidad</th>
                                                                <th class="text-center border-left border-dark">Empatía</th>
                                                                <th class="text-center border-left border-dark">Efectividad</th>
                                                                <th class="text-center border-left border-dark">Personalización</th>
                                                                <th class="text-center border-left border-dark">Agilidad</th>
                                                                <th class="text-center border-left border-dark">Accesibilidad (Empoderamiento al cliente)</th>
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
<script src="scripts/frontGestionNegocios.js" type="text/javascript"></script>