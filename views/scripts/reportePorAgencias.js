var tabla;

function init() { /* función inicial */
    $('#divTipoCliente').hide();
    $('#divAgencia').hide();
    $('#listadoRegistros').hide();
    
    $('#divTipoCliente1').hide();
    $('#divAgencia1').hide();
    $('#listadoRegistros1').hide();
    
    $('#divTipoCliente2').hide();
    $('#divAgencia2').hide();
    $('#listadoRegistros2').hide();

    $.ajax({
        type: "POST",
        url: '../ajax/reportesC.php?action=region',
        success: function (r) {
            $("#txtRegion").html(r);
            $("#txtRegion1").html(r);
            $("#txtRegion2").html(r);
        }
    });

    $.ajax({
        type: "POST",
        url: '../ajax/reportesC.php?action=agencias',
        success: function (r) {
            $("#txtAgencia").html(r);
            $("#txtAgencia2").html(r);
            $("#txtAgencia4").html(r);
        }
    });
}

$("#txtArea").change(function () {
    var txtArea = $("#txtArea").val();
    if (txtArea == 'Servicios') {
        $("#txtSeccion").append('<option>Front de servicios</option>');
        $("#txtSeccion").append('<option>Cajas</option>');
    } else {
        $("#txtSeccion").append('<option value="">Todas</option>');
    }
});

$("#txtAgencia").change(function () {
    var txtAgencia = $("#txtAgencia").val();
    $("#txtAgencia1").val(txtAgencia);
});

$("#btnBuscar").click(function () {
    var txtRegion = $("#txtRegion").val();
    var txtAgencia = $("#txtAgencia1").val();
    var txtTipoCliente = $("#txtTipoCliente").val();
    if ($("#txtFechaInicio").val() == ""){
        var txtFechaInicio = '';
    }else{
        var txtFechaInicio = obtenerFecha2($("#txtFechaInicio").val());
    }
    if ($("#txtFechaFin").val() == ""){
        var txtFechaFin = '';
    }else{
        var txtFechaFin = obtenerFecha2($("#txtFechaFin").val());
    }
    var txtArea = $("#txtArea").val();
    var txtSeccion = $("#txtSeccion").val();

    $('#listadoRegistros').show();

    tabla = $('#tblListado').dataTable({
        "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
        "aProcessing": true, /* activa el procesamiento de DataTables */
        "aServerSide": true, /* Paginación y filtrado realizado por el servidor */
        dom: '<<>rtip>', //Definimos los elementos del control de tabla
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../ajax/reportesC.php?action=reportAtributos',
            data: {
                txtRegion: txtRegion,
                txtAgencia: txtAgencia,
                txtTipoCliente: txtTipoCliente,
                txtFechaInicio: txtFechaInicio,
                txtFechaFin: txtFechaFin,
                txtArea: txtArea,
                txtSeccion: txtSeccion
            },
            type: "post",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "language": {
            "lengthMenu": "Mostrar : _MENU_ registros",
            "buttons": {
                "copyTitle": "Tabla Copiada",
                "copySuccess": {
                    _: '%d líneas copiadas',
                    1: '1 línea copiada'
                }
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10, /* paginación */
        "order": [[0, "asc"]]
    }).DataTable();

});

/**************************************************REPORTE POR AGENCIAS PILARES***********************************************************/
$("#txtArea1").change(function () {
    var txtArea = $("#txtArea1").val();
    if (txtArea == 'Servicios') {
        $("#txtSeccion1").append('<option>Front de servicios</option>');
        $("#txtSeccion1").append('<option>Cajas</option>');
    } else {
        $("#txtSeccion1").append('<option value="">Todas</option>');
    }
});

$("#txtAgencia2").change(function () {
    var txtAgencia = $("#txtAgencia2").val();
    $("#txtAgencia3").val(txtAgencia);
});

$("#btnBuscar1").click(function () {
    var txtRegion = $("#txtRegion1").val();
    var txtAgencia = $("#txtAgencia3").val();
    var txtTipoCliente = $("#txtTipoCliente1").val();
    if ($("#txtFechaInicio1").val() == ""){
        var txtFechaInicio = '';
    }else{
        var txtFechaInicio = obtenerFecha2($("#txtFechaInicio1").val());
    }
    if ($("#txtFechaFin1").val() == ""){
        var txtFechaFin = '';
    }else{
        var txtFechaFin = obtenerFecha2($("#txtFechaFin1").val());
    }
    var txtArea = $("#txtArea1").val();
    var txtSeccion = $("#txtSeccion1").val();

    $('#listadoRegistros1').show();

    tabla = $('#tblListado1').dataTable({
        "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
        "aProcessing": true, /* activa el procesamiento de DataTables */
        "aServerSide": true, /* Paginación y filtrado realizado por el servidor */
        dom: '<<>rtip>', //Definimos los elementos del control de tabla
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../ajax/reportesC.php?action=reportPilares',
            data: {
                txtRegion: txtRegion,
                txtAgencia: txtAgencia,
                txtTipoCliente: txtTipoCliente,
                txtFechaInicio: txtFechaInicio,
                txtFechaFin: txtFechaFin,
                txtArea: txtArea,
                txtSeccion: txtSeccion
            },
            type: "post",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "language": {
            "lengthMenu": "Mostrar : _MENU_ registros",
            "buttons": {
                "copyTitle": "Tabla Copiada",
                "copySuccess": {
                    _: '%d líneas copiadas',
                    1: '1 línea copiada'
                }
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10, /* paginación */
        "order": [[0, "asc"]]
    }).DataTable();
});

/**************************************************REPORTE POR AGENCIAS PILARES***********************************************************/
$("#txtArea2").change(function () {
    var txtArea = $("#txtArea2").val();
    if (txtArea == 'Servicios') {
        $("#txtSeccion2").append('<option>Front de servicios</option>');
        $("#txtSeccion2").append('<option>Cajas</option>');
    } else {
        $("#txtSeccion2").append('<option value="">Todas</option>');
    }
});

$("#txtAgencia4").change(function () {
    var txtAgencia = $("#txtAgencia4").val();
    $("#txtAgencia5").val(txtAgencia);
});

$("#btnBuscar2").click(function () {
    var txtRegion = $("#txtRegion2").val();
    var txtAgencia = $("#txtAgencia5").val();
    var txtTipoCliente = $("#txtTipoCliente2").val();
    if ($("#txtFechaInicio2").val() == ""){
        var txtFechaInicio = '';
    }else{
        var txtFechaInicio = obtenerFecha2($("#txtFechaInicio2").val());
    }
    if ($("#txtFechaFin2").val() == ""){
        var txtFechaFin = '';
    }else{
        var txtFechaFin = obtenerFecha2($("#txtFechaFin2").val());
    }
    var txtArea = $("#txtArea2").val();
    var txtSeccion = $("#txtSeccion2").val();

    $('#listadoRegistros2').show();

    tabla = $('#tblListado2').dataTable({
        "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
        "aProcessing": true, /* activa el procesamiento de DataTables */
        "aServerSide": true, /* Paginación y filtrado realizado por el servidor */
        dom: '<<f>rtip>', //Definimos los elementos del control de tabla
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../ajax/reportesC.php?action=reportLealtad',
            data: {
                txtRegion: txtRegion,
                txtAgencia: txtAgencia,
                txtTipoCliente: txtTipoCliente,
                txtFechaInicio: txtFechaInicio,
                txtFechaFin: txtFechaFin,
                txtArea: txtArea,
                txtSeccion: txtSeccion
            },
            type: "post",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "language": {
            "lengthMenu": "Mostrar : _MENU_ registros",
            "buttons": {
                "copyTitle": "Tabla Copiada",
                "copySuccess": {
                    _: '%d líneas copiadas',
                    1: '1 línea copiada'
                }
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10, /* paginación */
        "order": [[0, "asc"]]
    }).DataTable();

});

init(); /* ejecuta la función inicial */

function obtenerFecha2(text) {
    var today = new Date(text);
    var dd = today.getDate();
    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();

    if (dd < 10) {
        dd = '0' + dd
    }
    if (mm < 10) {
        mm = '0' + mm
    }

    today = yyyy + '-' + mm + '-' + dd
    return today;
}