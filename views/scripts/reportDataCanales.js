var tabla;

function init() { /* función inicial */
   
}

$("#btnBuscar").click(function () {
    var txtCanal = $("#txtCanal").val();
    if ($("#txtFechaInicio").val() == "") {
        var txtFechaInicio = '';
    } else {
        var txtFechaInicio = obtenerFecha2($("#txtFechaInicio").val());
    }
    if ($("#txtFechaFin").val() == "") {
        var txtFechaFin = '';
    } else {
        var txtFechaFin = obtenerFecha2($("#txtFechaFin").val());
    }

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
            url: '../ajax/reportesC.php?action=selectAllCanales',
            data: {
                txtCanal: txtCanal,
                txtFechaInicio: txtFechaInicio,
                txtFechaFin: txtFechaFin,
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