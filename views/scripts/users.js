var tabla;
function init() { /* función inicial */
    mostrar_formulario(false);
    mostrar_todos();

    $("#formulario").on("submit", function (e) {
        guardar_datos(e);
    });

    $("#divRegion").hide();
    $("#divAgencia").hide();
    $("#ocultar").hide();
}

function limpiar_formulario() { /* limpia los datos de los formularios */
    $("#Id").val("");
    $("#validar").val("");
    $("#mensaje").val("");
    $("#identificacion").val("");
    $("#Name1").val("");
    $("#Name2").val("");
    $("#Surname1").val("");
    $("#Surname2").val("");
    $("#fecha").val("");
    $("#adress").val("");
    $("#celular").val("");
    $("#telefono").val("");
    $("#correo").val("");
    $("#Password").val("");
    $("#Password2").val("");
    $("#UserGroup").val("");
    $("#divRegion").hide();
    $("#divRegion").attr('required', false);
    $("#divAgencia").hide();
    $("#divAgencia").attr('required', false);
    $("#txtRegion").val("");
    $("#txtAgencia").val("");
    $("#txtAgenciasAsign").val("");
}

function mostrar_formulario(flag) { /* muestra u oculta el formulario segun la validación del bool (flag) */
    limpiar_formulario();
    if (flag) {
        $("#listadoRegistros").hide();
        $("#formularioRegistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnAgregar").hide();
    } else {
        $("#listadoRegistros").show();
        $("#formularioRegistros").hide();
        $("#btnAgregar").show();
    }
}

function cancelar_formulario() { /* función para cancelar la operación */
    limpiar_formulario();
    mostrar_formulario(false);
}

function mostrar_todos() {
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
            url: '../ajax/userC.php?action=selectAll',
            type: "get",
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
        "order": [[5, "asc"]]
    }).DataTable();
    tabla.on('order.dt search.dt', function () {
        tabla.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
}

function mostrar_uno(Id) {
    $.post("../ajax/userC.php?action=selectById", {Id: Id}, function (datos, estado) {
        datos = JSON.parse(datos);
        mostrar_formulario(true);
        var usu = datos.Id;
        if (usu != "") {
            $("#Id").attr('readonly', true);
        } else {
            $("#Id").attr('readonly', false);
        }
        $("#Id").val(datos.Id);
        $("#validar").val(datos.Id);
        $("#mensaje").val("SIN INFO");
        $("#identificacion").val(datos.Identification);
        $("#Name1").val(datos.Name1);
        $("#Name2").val(datos.Name2);
        $("#Surname1").val(datos.Surname1);
        $("#Surname2").val(datos.Surname2);
        $("#fecha").val(datos.dateBirth);
        $("#adress").val(datos.Address);
        $("#celular").val(datos.ContacAddress);
        $("#telefono").val(datos.ContacAddress1);
        $("#correo").val(datos.Email);
        $("#txtRegion").val(datos.Region);
        $("#txtAgenciasAsign").val(datos.Agencias);
        var pass = datos.Password;
        $.ajax({
            type: "POST",
            url: '../ajax/userC.php?action=desencriptar',
            data: {pass: pass},
            success: function (r) {
                $("#Password").val(r);
                $("#Password2").val(r);
            }
        });
        $("#UserGroup").val(datos.UserGroup);
        var UserGroup = datos.UserGroup;
        if (UserGroup == "2") {
            $("#divRegion").show();
            $("#divRegion").attr('required', true);
            $("#divAgencia").hide();
            $("#divAgenciaAsign").hide();
            $("#divAgencia").attr('required', false);
        } else if (UserGroup == "3") {
            $("#divRegion").hide();
            $("#divRegion").attr('required', false);
            $("#divAgencia").show();
            $("#divAgenciaAsign").show();
            $("#divAgencia").attr('required', true);
        } else {
            $("#txtAgenciasAsign").val("");
            $("#divRegion").hide();
            $("#divRegion").attr('required', false);
            $("#divAgencia").hide();
            $("#divAgenciaAsign").hide();
            $("#divAgencia").attr('required', false);
        }
    });
}

function desactivar(Id) { /* desactivar */
    bootbox.confirm("¿Seguro quieres desactivar este usuario?", function (result) {
        if (result) {
            $.post("../ajax/userC.php?action=desactivate", {Id: Id}, function (e) {
                bootbox.alert(e);
                location.reload();
                mostrar_formulario(false);
            });
        }
    });
}

function activar(Id) { /* activar */
    bootbox.confirm("¿Seguro quieres activar este usuario?", function (result) {
        mostrar_formulario(false);
        if (result) {
            $.post("../ajax/userC.php?action=activate", {Id: Id}, function (e) {
                bootbox.alert(e);
                location.reload();
                mostrar_formulario(false);
            });
        }
    });
}

$("#btnAgregar").click(function () {
    limpiar_formulario();
    $("#Id").attr('readonly', false);
    $("#txtAgenciasAsign").val("");
});

$("#Name1").blur(function () {
    var apellido = $("#Surname1").val();
    if ($("#validar").val() == "") {
        var txt = $("#Name1").val().substring(0, 1) + apellido + Math.round(Math.random() * 10);
        $("#Id").val(txt);
        $("#Password").val(txt);
        $("#Password2").val(txt);
        var IdUser = $("#Id").val();
        $.ajax({
            type: "POST",
            url: '../ajax/userC.php?action=validarUsuario',
            data: {IdUser: IdUser},
            success: function (r) {
                $("#mensaje").val(r);
            }
        });
    }
});

$("#Surname1").blur(function () {
    var apellido = $("#Surname1").val();
    if ($("#validar").val() == "") {
        var txt = $("#Name1").val().substring(0, 1) + apellido + Math.round(Math.random() * 10);
        $("#Id").val(txt);
        $("#Password").val(txt);
        $("#Password2").val(txt);
        var IdUser = $("#Id").val();
        $.ajax({
            type: "POST",
            url: '../ajax/userC.php?action=validarUsuario',
            data: {IdUser: IdUser},
            success: function (r) {
                $("#mensaje").val(r);
            }
        });
    }
});

$("#Id").blur(function () {
    var IdUser = $("#Id").val();
    $.ajax({
        type: "POST",
        url: '../ajax/userC.php?action=validarUsuario',
        data: {IdUser: IdUser},
        success: function (r) {
            $("#mensaje").val(r);
        }
    });
});

$("#UserGroup").change(function () {
    var UserGroup = $("#UserGroup").val();
    if (UserGroup == "2") {
        $("#divRegion").show();
//        $("#txtRegion").attr('required', true);
        $("#divAgencia").hide();
        $("#agencia").attr('required', false);
        $("#agencia").val("");
    } else if (UserGroup == "3") {
        $("#divRegion").hide();
        $("#txtRegion").attr('required', false);
        $("#txtRegion").val("");
        $("#divAgencia").show();
        $("#agencia").attr('required', true);
    } else {
        $("#divRegion").hide();
        $("#txtRegion").attr('required', false);
        $("#divAgencia").hide();
        $("#divAgencia").attr('required', false);
        $("#txtRegion").val("");
        $("#agencia").val("");
    }
});

$("#txtRegion").change(function () {
    $("#txtAgenciasAsign").val("");
    var region = $("#txtRegion").val();
    $.ajax({
        type: "GET",
        url: '../ajax/userC.php?action=agencias',
        data: {region: region},
        success: function (r) {
            $('#txtAgenciasAsign').html(r);
        }
    });
});

$("#txtAgencia").change(function () {
    var txtAgencia = $("#txtAgencia").val();
    $("#txtAgenciasAsign").val(txtAgencia);
});

function guardar_datos(e) {
    console.log($("#mensaje").val());
    e.preventDefault(); //No se activará la acción predeterminada del evento
    if ($("#validar").val() == "") {
        if ($("#Password").val() != $("#Password2").val()) {
            bootbox.alert("Las contraseñas no coinciden!");
        } else {
            if ($("#mensaje").val() != "SIN INFO") {
                bootbox.alert("El usuario ya existe!");
            } else {
                var formData = new FormData($("#formulario")[0]);
                $.ajax({
                    url: "../ajax/userC.php?action=save",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (datos) {
                        bootbox.alert(datos);
                        mostrar_formulario(false);
                        tabla.ajax.reload();
                        limpiar_formulario();
                    }
                });
            }
        }
    } else if ($("#Password").val() != $("#Password2").val()) {
        bootbox.alert("Las contraseñas no coinciden!");
    } else {
        var formData = new FormData($("#formulario")[0]);
        $.ajax({
            url: "../ajax/userC.php?action=save",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                bootbox.alert(datos);
                mostrar_formulario(false);
                tabla.ajax.reload();
                limpiar_formulario();
            }
        });
    }
}

init(); /* ejecuta la función inicial */