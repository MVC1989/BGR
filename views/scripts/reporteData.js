var tabla;

function init() { /* función inicial */
    $('#divTipoCliente').hide();
    $('#divAgencia').hide();
    $('#listadoRegistros').hide();

    $.ajax({
        type: "POST",
        url: '../ajax/reportesC.php?action=region',
        success: function (r) {
            $("#txtRegion").html(r);
        }
    });

    $.ajax({
        type: "POST",
        url: '../ajax/reportesC.php?action=agencias',
        success: function (r) {
            $("#txtAgencia").html(r);
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
        dom: '<Bl<f>rtip>', //Definimos los elementos del control de tabla
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../ajax/reportesC.php?action=selectAll',
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