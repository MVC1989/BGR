var tabla;

function init() { /* función inicial */
    $('#divTipoCliente').hide();
    $('#divAgencia').hide();
    $('#listadoRegistros').hide();

    $.ajax({
        type: "POST",
        url: '../ajax/monitoreoC.php?action=region',
        success: function (r) {
            $("#txtRegion").html(r);
        }
    });

    $.ajax({
        type: "POST",
        url: '../ajax/monitoreoC.php?action=agencias',
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
            url: '../ajax/monitoreoC.php?action=selectAll',
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

function mostrar_uno(Id) {
    $('#calificacionesModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus');
        $.post("../ajax/monitoreoC.php?action=selectById", {Id: Id}, function (datos, estado) {
            datos = JSON.parse(datos);
            $("#txtEvaluador").val(datos.Evaluador);
            $("#txtUsuario").val(datos.Agent);
            $('#txtEstadoMonitoreo').val(datos.EstadoMonitoreo);
            $('#txtEstadoLlamada').val(datos.Status);
            $('#txtCriterio').val(datos.Criterio);
            $('#txtTMA').val(datos.TMA);
            $('#txtProducto').val(datos.Producto);
            $('#txtFechaInteracion').val(datos.FechaAtencion);
            $('#txtCampania').val(datos.Campania);
            $('#txtIdenticacion').val(datos.Identificacion);
            $('#txtRegion1').val(datos.Region);
            $('#txtAgencias').val(datos.Agencia);
            $('#txtAreas').val(datos.Area);
            $('#txtSeccion1').val(datos.Seccion);
            $('#txtTramite1').val(datos.Transaccion);
            $('#txtSaludo1').val(datos.Saludo1);
            $('#txtSaludo2').val(datos.Saludo2);
            $('#txtSaludo3').val(datos.Saludo3);
            $('#txtCierre1').val(datos.Cierre1);
            $('#txtCierre2').val(datos.Cierre2);
            $('#txtCierre3').val(datos.Cierre3);
            $('#txtPresentacion1').val(datos.Presentacion1);
            $('#txtPresentacion2').val(datos.Presentacion2);
            $('#txtPresentacion3').val(datos.Presentacion3);
            $('#txtComunicacion1').val(datos.Comunicacion1);
            $('#txtComunicacion2').val(datos.Comunicacion2);
            $('#txtComunicacion3').val(datos.Comunicacion3);
            $('#txtComunicacion4').val(datos.Comunicacion4);
            $('#txtComunicacion5').val(datos.Comunicacion5);
            $('#txtErroresCriticos1').val(datos.ErroresCriticos1);
            $('#txtErroresCriticos2').val(datos.ErroresCriticos2);
            $('#txtErroresCriticos3').val(datos.ErroresCriticos3);
            $('#txtErroresCriticos4').val(datos.ErroresCriticos4);
            $('#txtErroresCriticos5').val(datos.ErroresCriticos5);
            $('#txtErroresCriticosCumplimiento1').val(datos.ErroresCriticosCumplimiento1);
            $('#txtErroresCriticosCumplimiento2').val(datos.ErroresCriticosCumplimiento2);
            $('#txtErroresCriticosCumplimiento3').val(datos.ErroresCriticosCumplimiento3);
            $('#txtErroresCriticosCumplimiento4').val(datos.ErroresCriticosCumplimiento4);
            $('#txtErroresCriticosCumplimiento5').val(datos.ErroresCriticosCumplimiento5);
            $('#txtManejoGestion1').val(datos.ManejoGestion);
            $('#txtMejoras1').val(datos.Mejoras);
            $('#txtNota_ECN').val(datos.Nota_ECN);
            $('#txtNota_ECUF').val(datos.Nota_ECUF);
            $('#txtNota_ENC').val(datos.Nota_ENC);
            $('#txtTotal').val(datos.Total);
        });
    });
}

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

function CierraPopup() {
    $("#calificacionesModal").modal('hide');//ocultamos el modal
    $('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
    $('.modal-backdrop').remove();//eliminamos el backdrop del modal
    limpiar_formulario();
}