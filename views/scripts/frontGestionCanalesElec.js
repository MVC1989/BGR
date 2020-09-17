var tabla;
var tabla1;
function init() { /* función inicial */
    $('#divLealtad').hide();
    $('#divAtributos').hide();
}

$("#btnBuscar").click(function () {
    $('#divLealtad').show();
    $('#divAtributos').show();
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

    tabla = $('#tblListado').dataTable({
        "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
        "aProcessing": true, /* activa el procesamiento de DataTables */
        "aServerSide": true, /* Paginación y filtrado realizado por el servidor */
        dom: '<<>>', //Definimos los elementos del control de tabla
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../ajax/frontCanalesC.php?action=selectAllLealtadFiltros',
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

    tabla1 = $('#tblListado1').dataTable({
        "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
        "aProcessing": true, /* activa el procesamiento de DataTables */
        "aServerSide": true, /* Paginación y filtrado realizado por el servidor */
        dom: '<<>>', //Definimos los elementos del control de tabla
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../ajax/frontCanalesC.php?action=selectAllPilaresFiltros',
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
        "createdRow": function (row, data, dataIndex) {
            // Use empty value in the "Office" column
            // as an indication that grouping with COLSPAN is needed
            if (data[0] === 'TOTAL PILARES') {
                // Hide required number of columns
                // next to the cell with COLSPAN attribute
                $('td:eq(1)', row).css('display', 'none');
                // Add COLSPAN attribute
                $('td:eq(2)', row).attr('colspan', 3);
            }
            if (data[0] === 'TOTAL PILARES') {
                // Hide required number of columns
                // next to the cell with COLSPAN attribute
                $('td:eq(3)', row).css('display', 'none');
                $('td:eq(4)', row).css('display', 'none');
                // Add COLSPAN attribute
                $('td:eq(5)', row).attr('colspan', 3);
            }
            if (data[0] === 'TOTAL PILARES') {
                // Hide required number of columns
                // next to the cell with COLSPAN attribute
                $('td:eq(6)', row).css('display', 'none');
                $('td:eq(7)', row).css('display', 'none');
                // Add COLSPAN attribute
                $('td:eq(8)', row).attr('colspan', 2);
            }
            if (data[0] === 'TOTAL PILARES') {
                // Hide required number of columns
                // next to the cell with COLSPAN attribute
                $('td:eq(9)', row).css('display', 'none');
                
                // Add COLSPAN attribute
                $('td:eq(10)', row).attr('colspan', 2);
            }
            if (data[0] === 'TOTAL PILARES') {
                // Hide required number of columns
                // next to the cell with COLSPAN attribute
                $('td:eq(11)', row).css('display', 'none');
                
                // Add COLSPAN attribute
                $('td:eq(12)', row).attr('colspan', 2);
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

    $.ajax({
        type: "POST",
        url: '../ajax/frontCanalesC.php?action=tacometroNPSFiltros',
        data: {
            txtCanal: txtCanal,
            txtFechaInicio: txtFechaInicio,
            txtFechaFin: txtFechaFin
        },
        success: function (r) {
            if (r >= 85.00 && r <= 100) {
                $("#txtNPS").val(r).trigger("change");
                $('#txtNPS').trigger('configure', {fgColor: "#32A51E"});
                $('#txtNPS').css("color", "#32A51E");
            } else if (r >= 60.00 && r <= 84.99) {
                $("#txtNPS").val(r).trigger("change");
                $('#txtNPS').trigger('configure', {fgColor: "#E7DC03"});
                $('#txtNPS').css("color", "#E7DC03");
            } else if (r <= 59.99) {
                $("#txtNPS").val(r).trigger("change");
                $('#txtNPS').trigger('configure', {fgColor: "#AB412A"});
                $('#txtNPS').css("color", "#AB412A");
            }
        }
    });

    $.ajax({
        type: "POST",
        url: '../ajax/frontCanalesC.php?action=tacometroINSFiltros',
        data: {
            txtCanal: txtCanal,
            txtFechaInicio: txtFechaInicio,
            txtFechaFin: txtFechaFin,
        },
        success: function (r) {
            if (r >= 80.00 && r <= 100) {
                $("#txtINS").val(r).trigger("change");
                $('#txtINS').trigger('configure', {fgColor: "#32A51E"});
                $('#txtINS').css("color", "#32A51E");
            } else if (r >= 60.00 && r <= 79.99) {
                $("#txtINS").val(r).trigger("change");
                $('#txtINS').trigger('configure', {fgColor: "#E7DC03"});
                $('#txtINS').css("color", "#E7DC03");
            } else if (r <= 59.99) {
                $("#txtINS").val(r).trigger("change");
                $('#txtINS').trigger('configure', {fgColor: "#AB412A"});
                $('#txtINS').css("color", "#AB412A");
            }
        }
    });

    $.ajax({
        type: "POST",
        url: '../ajax/frontCanalesC.php?action=tacometroCESFiltros',
        data: {
            txtCanal: txtCanal,
            txtFechaInicio: txtFechaInicio,
            txtFechaFin: txtFechaFin,
        },
        success: function (r) {
            if (r >= 0.00 && r <= 14.99) {
                $("#txtCES").val(r).trigger("change");
                $('#txtCES').trigger('configure', {fgColor: "#32A51E"});
                $('#txtCES').css("color", "#32A51E");
            } else if (r >= 15.00 && r <= 29.99) {
                $("#txtCES").val(r).trigger("change");
                $('#txtCES').trigger('configure', {fgColor: "#E7DC03"});
                $('#txtCES').css("color", "#E7DC03");
            } else if (r >= 30.00) {
                $("#txtCES").val(r).trigger("change");
                $('#txtCES').trigger('configure', {fgColor: "#AB412A"});
                $('#txtCES').css("color", "#AB412A");
            }
        }
    });

    $.ajax({
        type: "POST",
        url: '../ajax/frontCanalesC.php?action=tacometroVisionFiltros',
        data: {
            txtCanal: txtCanal,
            txtFechaInicio: txtFechaInicio,
            txtFechaFin: txtFechaFin,
        },
        success: function (r) {
            if (r >= 80.00 && r <= 100.00) {
                $("#txtVision").val(r).trigger("change");
                $('#txtVision').trigger('configure', {fgColor: "#32A51E"});
                $('#txtVision').css("color", "#32A51E");
            } else if (r >= 60. && r <= 79.99) {
                $("#txtVision").val(r).trigger("change");
                $('#txtVision').trigger('configure', {fgColor: "#E7DC03"});
                $('#txtVision').css("color", "#E7DC03");
            } else if (r <= 59.99) {
                $("#txtVision").val(r).trigger("change");
                $('#txtVision').trigger('configure', {fgColor: "#AB412A"});
                $('#txtVision').css("color", "#AB412A");
            }
        }
    });

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