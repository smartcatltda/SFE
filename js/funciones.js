$(document).ready(function () {
//**********LOGIN**********
    $("#login").tabs();
    verificalogin();
    $("#conectar").button().click(function () {
        conectar();
    });
    //******************CONTENIDO***************
    $("#contenido").tabs();
    //******************MENU**********************
    $("#menu").tabs();
    $("#menuinicio").button().click(function () {
        inicio();
    });
    $("#menuusuarios").button().click(function () {
        usuarios();
    });
    $("#menuclientes").button().click(function () {
        clientes();
    });
    $(function () {
        var dialog, form,
                password = $("#password"),
                allFields = $([]).add(password);

        function validar_pass() {
            var pass = $("#password").val();
            $.post(base_url + "controlador/validar_pass", {},
                    function (datos) {
                        if (datos.pass == pass) {
                            dialog.dialog("close");
                            factura();
                        } else {
                            $(function () {
                                $("#dialog-pass").show();
                                $("#dialog-pass").dialog({
                                    modal: true,
                                    buttons: {
                                        Ok: function () {
                                            $(this).dialog("close");
                                            foco('password');
                                        }
                                    }
                                });
                            });
                        }
                    }, "json");
        }

        dialog = $("#dialog-form").dialog({
            autoOpen: false,
            height: 300,
            width: 350,
            modal: true,
            buttons: {
                Validar: function () {
                    validar_pass();
                },
                Cancel: function () {
                    dialog.dialog("close");
                }
            },
            close: function () {
                form[ 0 ].reset();
                allFields.removeClass("ui-state-error");
            }
        });

        form = dialog.find("form").on("submit", function (event) {
            event.preventDefault();
            validar_pass();
        });
        $("#menufactura").button().click(function () {
            dialog.dialog("open");
        });
    });
    $("#menuinformes").button().click(function () {
        informes();
    });
    $("#menusalir").button().click(function () {
        salir();
    });
    //******************MANTENEDOR CLIENTES******************
    $("#mc_bt_guardar").button().click(function () {
        insert_cliente();
    });
    $("#mc_bt_editar").button().click(function () {
        update_clientes();
    });

    $("#mc_ciudad").change(function () {
        var id_ciudad = $("#mc_ciudad").val();
        $.post(base_url + "controlador/cargar_select_comuna_ciudad",
                {id_ciudad: id_ciudad},
        function (ruta, datos) {
            $("#mc_comuna").html(ruta, datos);
        });
    });
    $("#mc_filtro").keyup(function () {
        if ($(this).val() != "")
        {
            $("#tabla_lista_clientes tbody>tr").hide();
            $("#tabla_lista_clientes td:contains-ci('" + $(this).val() + "')").parent("tr").show();
        }
        else
        {
            $("#tabla_lista_clientes tbody>tr").show();
        }
    });
    //******************MANTENEDOR USUARIOS******************
    $("#mu_bt_guardar").button().click(function () {
        insert_usuario();
    });
    $("#mu_bt_editar").button().click(function () {
        update_usuario();
    });
    $("#mu_filtro").keyup(function () {
        if ($(this).val() != "")
        {
            $("#tabla_lista_usuarios tbody>tr").hide();
            $("#tabla_lista_usuarios td:contains-ci('" + $(this).val() + "')").parent("tr").show();
        }
        else
        {
            $("#tabla_lista_usuarios tbody>tr").show();
        }
    });
    //********************FACTURA*****************************
    $("#f_bt_crear_factura").button().click(function () {
        crear_factura();
    });
    $("#f_bt_descartar_factura").button().click(function () {
        descartar_factura();
    });
    $("#f_bt_agregar_detalle").button().click(function () {
        insert_detalle_fac();
    });
    $("#f_bt_cerrar_factura").button().click(function () {
        cerrar_factura();
    });
    $("#fc_nombre").change(function () {
        var rut = $("#fc_nombre").val();
        var num_fac = $("#f_numero").val();
        if (rut != "0-0") {
            if (rut != "") {
                $.post(base_url + "controlador/seleccionar_cliente", {rut: rut},
                function (datos) {
                    if (datos.valor == 1) {
                        $("#fc_rut").val(datos.rut);
                        $("#fc_rut").attr('readonly', true);
                        $("#fc_direccion").val(datos.direccion);
                        $("#fc_ciudad").val(datos.ciudad);
                        $("#fc_comuna").val(datos.comuna);
                        $("#fc_telefono").val(datos.telefono);
                        $("#fc_giro").val(datos.giro);
                    }
                }, "json");
                $.post(base_url + "controlador/update_cliente_fac", {rut: rut, num_fac: num_fac}
                );
            } else {
                $("#fc_rut").val("0-0");
                $("#fc_rut").attr('readonly', false);
                $("#fc_direccion").val("");
                $("#fc_ciudad").val("");
                $("#fc_comuna").val("");
                $("#fc_telefono").val("");
                $("#fc_giro").val("");
            }
        } else {
            $("#fc_rut").val("");
            $("#fc_rut").attr('readonly', false);
            $("#fc_direccion").val("");
            $("#fc_ciudad").val("");
            $("#fc_comuna").val("");
            $("#fc_telefono").val("");
            $("#fc_giro").val("");
        }
        $.post(base_url + "controlador/update_cliente_fac", {rut: rut, num_fac: num_fac}
        );
    });
    //*****************INFORMES***************
    $("#r_datepicker").datepicker({});
//    $("#r_datepicker").datepicker({
//        dateFormat: 'dd/mm/yy'
//    });
    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '<Ant',
        nextText: 'Sig>',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
        weekHeader: 'Sm',
        dateFormat: 'yy/mm/dd',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['es']);
    $("#r_datepicker").datepicker('setDate', '+0');
    $("#r_generarInforme").button().click(function () {
        generar_informe();
    });
    //**********FOOTER**********
    $("#footer").tabs();
});
//**********LOGIN**********

function conectar()
{
    var user = $("#user").val();
    var pass = $("#pass").val();
    if (user != '' && pass != '')
    {
        $.post(base_url + "controlador/conectar",
                {user: user, pass: pass},
        function (datos)
        {
            if (datos.valor == 0)
            {
                $("#msg").hide();
                $("#msg").html("<label>" + datos.mensaje + "</label>");
                $("#msg").css("color", "#FF0000").show('pulsate', 'slow').delay(2000).hide('fade', 'slow');
            }
            else
            {
                $("#login").hide('fast');
                $("#menu").show('fast');
                $("#contenido").show('fast');
                $("#nombrelogin").html('<label>BIENVENIDO :' + " " + datos.nombre + " " + datos.apellido + '.</label>');
                if (datos.permiso == 1) {
                    inicio();
                } else {
                    $("#menuusuarios").hide('fast');
                    inicio();
                }
            }
        },
                'json'
                );
    }
    else
    {
        $("#msg").hide();
        $("#msg").html("<label>Ingresar Usuario y Contraseña</label>");
        $("#msg").css("color", "#FF0000").show('pulsate', 'slow').delay(3000).hide('fade', 'slow');
    }
}

function verificalogin()
{
    $.post(
            base_url + "controlador/verificalogin",
            {},
            function (datos) {
                if (datos.valor == 0)
                {
                    $("#contenido").hide();
                    $("#menu").hide();
                    $("#login").show('fast');
                }
                else
                {
                    $("#login").hide('fast');
                    $("#menu").show('fast');
                    $("#contenido").show('fast');
                    $("#nombrelogin").html('<label>BIENVENIDO :' + " " + datos.nombre + " " + datos.apellido + '.</label>');
                    if (datos.permiso == 1) {
                        inicio();
                    } else {
                        $("#menuusuarios").hide('fast');
                        inicio();
                    }
                }
            },
            'json'
            );
}

function salir()
{
    $.post(base_url + "controlador/salir",
            {},
            function (datos)
            {
                if (datos.valor == 0)
                {
                    descartar_factura();
                    location.reload();
                }
            },
            'json'
            );
}

//********************MENU***********************
function inicio()
{
    $("#inicio").show('fast');
    $("#usuarios").hide('fast');
    $("#clientes").hide('fast');
    $("#factura").hide('fast');
    $("#informe").hide('fast');
}

function usuarios()
{
    $("#inicio").hide('fast');
    $("#usuarios").show('fast');
    $("#clientes").hide('fast');
    $("#factura").hide('fast');
    $("#informe").hide('fast');
}
function clientes()
{
    $("#inicio").hide('fast');
    $("#usuarios").hide('fast');
    $("#clientes").show('fast');
    $("#factura").hide('fast');
    $("#informe").hide('fast');
}

function factura()
{
    mantener_factura();
    $("#inicio").hide('fast');
    $("#usuarios").hide('fast');
    $("#clientes").hide('fast');
    $("#factura").show('fast');
    $("#informe").hide('fast');
}

function informes()
{
    $("#inicio").hide('fast');
    $("#usuarios").hide('fast');
    $("#clientes").hide('fast');
    $("#factura").hide('fast');
    $("#informe").show('fast');
}

//******************************CLIENTES********************************
function cargar_clientes()
{
    $.post(
            base_url + "controlador/cargar_clientes",
            {},
            function (ruta, datos) {
                $("#lista_clientes").html(ruta, datos);
            });
}

function cargar_select_clientes()
{
    $.post(
            base_url + "controlador/cargar_select_clientes",
            {},
            function (ruta, datos) {
                $("#fc_nombre").html(ruta, datos);
            });
}

function cargar_select_ciudad()
{
    $.post(
            base_url + "controlador/cargar_select_ciudad",
            {},
            function (ruta, datos) {
                $("#mc_ciudad").html(ruta, datos);
            });
}

function cargar_select_comuna()
{
    $.post(
            base_url + "controlador/cargar_select_comuna",
            {},
            function (ruta, datos) {
                $("#mc_comuna").html(ruta, datos);
            });
}

function cargar_select_comuna_ciudad(id)
{
    var id_ciudad = id;
    $.post(
            base_url + "controlador/cargar_select_comuna_ciudad",
            {id_ciudad: id_ciudad},
    function (ruta, datos) {
        $("#mc_comuna").html(ruta, datos);
    });
}

function insert_cliente() {
    var rut = $("#mc_rut").val();
    var nombre = $("#mc_nombre").val();
    var direccion = $("#mc_direccion").val();
    var ciudad = $("#mc_ciudad").val();
    var comuna = $("#mc_comuna").val();
    var telefono = $("#mc_telefono").val();
    var giro = $("#mc_giro").val();
    if (nombre != "" && rut != "" && direccion != "" && ciudad != "" && comuna != "" && telefono != "" && giro != "") {
        if (tiene_guion(rut) == true) {
            $.post(base_url + "controlador/validaRut",
                    {rut: rut},
            function (datos) {
                if (datos.return == true) {
                    $.post(base_url + "controlador/insert_cliente", {nombre: nombre, rut: rut, direccion: direccion, ciudad: ciudad, comuna: comuna, telefono: telefono, giro: giro},
                    function (data) {
                        $("#msg").hide();
                        $("#msg").html("<label>" + data.msg + "</label>");
                        if (data.valor == 1) {
                            $("#msg").css("color", "#55FF00").show('fade', 'slow').delay(3000).hide('fade', 'slow');
                            $("#rut_edit").val("");
                            $("#mc_rut").val("");
                            $("#mc_nombre").val("");
                            $("#mc_direccion").val("");
                            $("#mc_telefono").val("");
                            $("#mc_giro").val("");
                            cargar_clientes();
                        } else {
                            $("#msg").css("color", "#FF0000").show('pulsate', 'slow').delay(3000).hide('fade', 'slow');
                        }
                    }, "json"
                            );
                } else {
                    $(function () {
                        $("#dialog-rut").show();
                        $("#dialog-rut").dialog({
                            modal: true,
                            buttons: {
                                Ok: function () {
                                    $(this).dialog("close");
                                    foco('mc_rut');
                                }
                            }
                        });
                    });
                }
            }, "json"
                    );
        } else {
            $(function () {
                $("#dialog-guion").show();
                $("#dialog-guion").dialog({
                    modal: true,
                    buttons: {
                        Ok: function () {
                            $(this).dialog("close");
                            foco('mc_rut');
                        }
                    }
                });
            });
        }
    } else {
        $("#msg").hide();
        $("#msg").html("<label>Complete todos los campos</label>");
        $("#msg").css("color", "#FF0000").show('pulsate', 'slow').delay(3000).hide('fade', 'slow');
    }
}

function update_clientes()
{
    var id_rut = $("#rut_edit").val();
    var rut = $("#mc_rut").val();
    var nombre = $("#mc_nombre").val();
    var direccion = $("#mc_direccion").val();
    var ciudad = $("#mc_ciudad").val();
    var comuna = $("#mc_comuna").val();
    var telefono = $("#mc_telefono").val();
    var giro = $("#mc_giro").val();
    if (id_rut != "") {
        if (nombre != "" && rut != "" && direccion != "" && ciudad != "" && comuna != "" && telefono != "" && giro != "") {
            if (tiene_guion(rut) == true) {
                if (rut.length > 8) {
                    $.post(base_url + "controlador/validaRut",
                            {rut: rut},
                    function (datos) {
                        if (datos.return == true) {
                            $.post(base_url + "controlador/update_clientes", {id_rut: id_rut, nombre: nombre, rut: rut, direccion: direccion, ciudad: ciudad, comuna: comuna, telefono: telefono, giro: giro},
                            function (datos) {
                                if (datos.valor == 1) {
                                    $("#msg").hide();
                                    $("#msg").html("<label>Cliente Modificado!</label>");
                                    $("#msg").css("color", "#40E0D0").show('fade', 'slow').delay(3000).hide('fade', 'slow');
                                    $("#rut_edit").val("");
                                    $("#mc_rut").val("");
                                    $("#mc_nombre").val("");
                                    $("#mc_direccion").val("");
                                    $("#mc_telefono").val("");
                                    $("#mc_giro").val("");
                                    cargar_clientes();
                                } else {
                                    $("#msg").hide();
                                    $("#msg").html("<label>Rut ya Registrado!</label>");
                                    $("#msg").css("color", "#FF0000").show('pulsate', 'slow').delay(3000).hide('fade', 'slow');
                                }
                            }, "json"
                                    );
                        } else {
                            $(function () {
                                $("#dialog-rut").show();
                                $("#dialog-rut").dialog({
                                    modal: true,
                                    buttons: {
                                        Ok: function () {
                                            $(this).dialog("close");
                                            foco('mc_rut');
                                        }
                                    }
                                });
                            });
                        }
                    }, "json"
                            );
                } else {
                    $("#msg").hide();
                    $("#msg").html("<label>Faltan Dígitos en el Rut</label>");
                    $("#msg").css("color", "#FF0000").show('pulsate', 'slow').delay(3000).hide('fade', 'slow');
                }
            } else {
                $(function () {
                    $("#dialog-guion").show();
                    $("#dialog-guion").dialog({
                        modal: true,
                        buttons: {
                            Ok: function () {
                                $(this).dialog("close");
                                foco('mc_rut');
                            }
                        }
                    });
                });
            }
        } else {
            $("#msg").hide();
            $("#msg").html("<label>Complete Todos los Campos</label>");
            $("#msg").css("color", "#FF0000").show('pulsate', 'slow').delay(3000).hide('fade', 'slow');
        }
    } else {
        $("#msg").hide();
        $("#msg").html("<label>Seleccione un cliente para editar</label>");
        $("#msg").css("color", "#FF0000").show('pulsate', 'slow').delay(3000).hide('fade', 'slow');
    }
}
function  delete_cliente(rut)
{
    var rut = rut;
    $("#dialog-confirmacion").dialog({
        resizable: false,
        height: 250,
        minWidth: 250,
        modal: true,
        buttons: {
            "Aceptar": function () {
                $(this).dialog("close");
                $.post(base_url + "controlador/delete_cliente", {rut: rut},
                function (datos) {
                    $("#msg").hide();
                    $("#msg").html("<label>" + datos.msj + "</label>");
                    $("#msg").css("color", "#55FF00").show('fade', 'slow').delay(3000).hide('fade', 'slow');
                    cargar_clientes();
                }, "json"
                        );
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        }
    });
}

function  seleccionar_cliente(rut)
{
    var rut = rut;
    $.post(base_url + "controlador/seleccionar_cliente", {rut: rut},
    function (datos) {
        if (datos.valor == 1) {
            $("#rut_edit").val(datos.rut);
            $("#mc_rut").val(datos.rut);
            $("#mc_nombre").val(datos.nombre);
            $("#mc_direccion").val(datos.direccion);
            $("#mc_ciudad").val(datos.ciudad);
            $("#mc_comuna").val(datos.comuna);
            $("#mc_telefono").val(datos.telefono);
            $("#mc_giro").val(datos.giro);
        }
    }, "json"
            );
}

function  estado_cliente(rut, estado)
{
    var rut = rut;
    var estado = estado;
    $.post(base_url + "controlador/estado_cliente", {rut: rut, estado: estado},
    function (datos) {
        $("#msg").hide();
        $("#msg").html("<label>" + datos.msj + "</label>");
        $("#msg").css("color", "#55FF00").show('fade', 'slow').delay(3000).hide('fade', 'slow');
        cargar_clientes();
    }, "json"
            );
}

//****************************************USUARIOS****************************************
function cargar_usuarios()
{
    $.post(
            base_url + "controlador/cargar_usuarios",
            {},
            function (ruta, datos) {
                $("#lista_usuarios").html(ruta, datos);
            });
}

function insert_usuario() {
    var user = $("#mu_user").val();
    var pass = $("#mu_pass").val();
    var nombre = $("#mu_nombre").val();
    var apellido = $("#mu_apellido").val();
    var tipo = $("#mu_tipo").val();
    if (nombre != "" && user != "" && pass != "" && apellido != "" && tipo != "") {
        $.post(base_url + "controlador/insert_usuario", {nombre: nombre, user: user, pass: pass, apellido: apellido, tipo: tipo},
        function (data) {
            $("#msg").hide();
            $("#msg").html("<label>" + data.msg + "</label>");
            if (data.valor == 1) {
                $("#msg").css("color", "#55FF00").show('fade', 'slow').delay(3000).hide('fade', 'slow');
                $("#id_user").val("");
                $("#nombre_user").val("");
                $("#mu_user").val("");
                $("#mu_pass").val("");
                $("#mu_nombre").val("");
                $("#mu_apellido").val("");
                $("#mu_tipo").val("");
                cargar_usuarios();
            } else {
                $("#msg").css("color", "#FF0000").show('pulsate', 'slow').delay(3000).hide('fade', 'slow');
            }
        }, "json"
                );
    } else {
        $("#msg").hide();
        $("#msg").html("<label>Complete todos los campos</label>");
        $("#msg").css("color", "#FF0000").show('pulsate', 'slow').delay(3000).hide('fade', 'slow');
    }
}

function update_usuario() {
    var id = $("#id_user").val();
    var id_nombre = $("#nombre_user").val();
    var user = $("#mu_user").val();
    var pass = $("#mu_pass").val();
    var nombre = $("#mu_nombre").val();
    var apellido = $("#mu_apellido").val();
    var tipo = $("#mu_tipo").val();
    if (id != "") {
        if (nombre != "" && user != "" && pass != "" && apellido != "" && tipo != "") {
            $.post(base_url + "controlador/update_usuario", {id: id, id_nombre: id_nombre, nombre: nombre, user: user, pass: pass, apellido: apellido, tipo: tipo},
            function (datos) {
                $("#msg").hide();
                $("#msg").html("<label>" + datos.msg + "</label>");
                if (datos.valor == 1) {
                    $("#msg").css("color", "#55FF00").show('fade', 'slow').delay(3000).hide('fade', 'slow');
                    $("#id_user").val("");
                    $("#nombre_user").val("");
                    $("#mu_user").val("");
                    $("#mu_pass").val("");
                    $("#mu_nombre").val("");
                    $("#mu_apellido").val("");
                    $("#mu_tipo").val("");
                    cargar_usuarios();
                } else {
                    $("#msg").hide();
                    $("#msg").html("<label>" + datos.msg + "</label>");
                    $("#msg").css("color", "#FF0000").show('pulsate', 'slow').delay(3000).hide('fade', 'slow');
                }
            }, "json"
                    );
        } else {
            $("#msg").hide();
            $("#msg").html("<label>Complete Todos los Campos</label>");
            $("#msg").css("color", "#FF0000").show('pulsate', 'slow').delay(3000).hide('fade', 'slow');
        }
    } else {
        $("#msg").hide();
        $("#msg").html("<label>Seleccione un Uusario para editar</label>");
        $("#msg").css("color", "#FF0000").show('pulsate', 'slow').delay(3000).hide('fade', 'slow');
    }
}

function  delete_usuario(id)
{
    var id = id;
    $("#dialog-confirmacion").dialog({
        resizable: false,
        height: 250,
        minWidth: 250,
        modal: true,
        buttons: {
            "Aceptar": function () {
                $(this).dialog("close");
                $.post(base_url + "controlador/delete_usuario", {id: id},
                function (datos) {
                    $("#msg").hide();
                    $("#msg").html("<label>" + datos.msj + "</label>");
                    $("#msg").css("color", "#55FF00").show('fade', 'slow').delay(3000).hide('fade', 'slow');
                    cargar_usuarios();
                }, "json"
                        );
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        }
    });
}

function  seleccionar_usuario(id)
{
    var id = id;
    $.post(base_url + "controlador/seleccionar_usuario", {id: id},
    function (datos) {
        if (datos.valor == 1) {
            $("#id_user").val(datos.id);
            $("#nombre_user").val(datos.user);
            $("#mu_user").val(datos.user);
            $("#mu_pass").val(datos.pass);
            $("#mu_nombre").val(datos.nombre);
            $("#mu_apellido").val(datos.apellido);
            $("#mu_tipo").val(datos.tipo);
        }
    }, "json"
            );
}

//*********************************************FACTURA*********************************************
function crear_factura() {
    $.post(base_url + "controlador/crear_factura", {},
            function (datos) {
                $('#f_numero').val(datos.id);
                $("#f_bt_cerrar_factura").removeAttr("disabled");
                $("#f_bt_cerrar_factura").button("refresh");
                $("#f_bt_agregar_detalle").removeAttr("disabled");
                $("#f_bt_agregar_detalle").button("refresh");
                $("#td_crear_f").attr("style", "visibility: hidden");
                $("#td_crear_f").attr("style", "display: none");
                $("#td_descartar_f").attr("style", "visibility: show");
                $("#td_descartar_f").attr("style", "display: block");
                $("#f_bt_descartar_factura").removeAttr("disabled");
                $("#f_bt_descartar_factura").button("refresh");
                $("#f_bt_crear_factura").attr("disabled", true);
                $("#f_bt_crear_factura").button("refresh");
                $('#fc_rut').attr('readonly', false);
                $("#fc_nombre").removeAttr("disabled");
                $("#fd_cantidad").attr('readonly', false);
                $("#fd_descripcion").attr('readonly', false);
                $("#fd_precio").attr('readonly', false);
                cargar_select_clientes();
            }, "json"
            );
}

function insert_detalle_fac() {
    var num_fac = $('#f_numero').val();
    var cantidad = $('#fd_cantidad').val().replace(/\./g, '');
    var desc = $('#fd_descripcion').val();
    var precio = $('#fd_precio').val().replace(/\./g, '');
    var ope = "0";
    if (cantidad != "" && desc != "" && precio != "" && num_fac != "") {
        $.post(base_url + "controlador/insert_detalle_fac",
                {cantidad: cantidad, desc: desc, precio: precio, num_fac: num_fac},
        function (ruta, datos) {
            $("#detalle_factura").html(ruta, datos);
            $("#detalle_factura").attr("style", "visibility: show");
            $("#fd_cantidad").val("");
            $("#fd_descripcion").val("");
            $("#fd_precio").val("");
        }
        );
        $.post(base_url + "controlador/calcular",
                {cantidad: cantidad, precio: precio, num_fac: num_fac, ope: ope},
        function (datos) {
            $("#f_subtotal").val(datos.subtotal);
            $("#f_neto").val(datos.neto);
            $("#f_iva").val(datos.iva);
            $("#f_total").val(datos.total);
        }, "json"
                );
    } else {
        $("#msg").hide();
        $("#msg").html("<label>Complete todos los campos</label>");
        $("#msg").css("color", "#FF0000").show('pulsate', 'slow').delay(3000).hide('fade', 'slow');
    }
}

function delete_detalle(id, num_fac, cantidad, precio) {
    var ope = "1";
    $.post(base_url + "controlador/calcular",
            {cantidad: cantidad, precio: precio, num_fac: num_fac, ope: ope},
    function (datos) {
        $("#f_subtotal").val(datos.subtotal);
        $("#f_neto").val(datos.neto);
        $("#f_iva").val(datos.iva);
        $("#f_total").val(datos.total);
    }, "json"
            );
    $.post(base_url + "controlador/delete_detalle_fac",
            {id: id, num_fac: num_fac},
    function (ruta, datos) {
        $("#detalle_factura").html(ruta, datos);
        $("#msg").hide();
        $("#msg").html("<label>Detalle Eliminado</label>");
        $("#msg").css("color", "#FF0000").show('pulsate', 'slow').delay(3000).hide('fade', 'slow');
    }
    );
}

function mantener_factura() {
    $.post(base_url + "controlador/mantener_factura", {},
            function (datos) {
                if (datos.valor != 0) {
                    $('#f_numero').val(datos.num_fac);
                    $('#f_subtotal').val(datos.subtotal);
                    $('#f_neto').val(datos.neto);
                    $('#f_iva').val(datos.iva);
                    $('#f_total').val(datos.total);
                    $("#td_descartar_f").attr("style", "visibility: show");
                    $("#td_descartar_f").attr("style", "display: block");
                    $("#td_crear_f").attr("style", "visibility: hidden");
                    $("#td_crear_f").attr("style", "display: none");
                    $("#f_bt_descartar_factura").removeAttr("disabled");
                    $("#f_bt_descartar_factura").button("refresh");
                    $("#f_bt_cerrar_factura").removeAttr("disabled");
                    $("#f_bt_cerrar_factura").button("refresh");
                    $("#f_bt_agregar_detalle").removeAttr("disabled");
                    $("#f_bt_agregar_detalle").button("refresh");
                    $("#f_bt_crear_factura").attr("disabled", true);
                    $("#f_bt_crear_factura").button("refresh");
                    $('#fc_rut').attr('readonly', false);
                    $("#fc_nombre").removeAttr("disabled");
                    $("#fd_cantidad").attr('readonly', false);
                    $("#fd_descripcion").attr('readonly', false);
                    $("#fd_precio").attr('readonly', false);
                    $.post(base_url + "controlador/cargar_detalle_fac",
                            {num_fac: datos.num_fac},
                    function (ruta, datos) {
                        $("#detalle_factura").html(ruta, datos);
                    }
                    );
                    if (datos.rut != "0-0") {
                        $.post(base_url + "controlador/seleccionar_cliente",
                                {rut: datos.rut},
                        function (dato) {
                            $("#fc_rut").val(dato.rut);
                            $("#fc_direccion").val(dato.direccion);
                            $("#fc_ciudad").val(dato.ciudad);
                            $("#fc_comuna").val(dato.comuna);
                            $("#fc_telefono").val(dato.telefono);
                            $("#fc_giro").val(dato.giro);
                            $("#fc_nombre").val(dato.rut);
                        }, "json"
                                );
                    }
                }
            }, "json"
            );
}

function descartar_factura() {
    var num_fac = $("#f_numero").val();
    $.post(base_url + "controlador/descartar_factura",
            {num_fac: num_fac},
    function (datos) {
        if (datos.valor == 1) {
            limpiar_factura();
            if (datos.detalle != 0) {
                $("#detalle_factura").attr("style", "visibility: hidden");
            }
            $("#td_descartar_f").attr("style", "visibility: hidden");
            $("#td_descartar_f").attr("style", "display: none");
            $("#td_crear_f").attr("style", "visibility: show");
            $("#td_crear_f").attr("style", "display: block");
            $("#f_bt_descartar_factura").attr("disabled", true);
            $("#f_bt_descartar_factura").button("refresh");
            $("#f_bt_crear_factura").removeAttr("disabled");
            $("#f_bt_crear_factura").button("refresh");
            $("#f_bt_cerrar_factura").attr("disabled", true);
            $("#f_bt_cerrar_factura").button("refresh");
            $("#f_bt_agregar_detalle").attr("disabled", true);
            $("#f_bt_agregar_detalle").button("refresh");
            $('#fc_rut').attr('readonly', true);
            $("#fc_nombre").attr("disabled", true);
            $("#fd_cantidad").attr('readonly', true);
            $("#fd_descripcion").attr('readonly', true);
            $("#fd_precio").attr('readonly', true);
        }
    }, "json"
            );
}

function cerrar_factura() {
    var num_fac = $("#f_numero").val();
    var rut = $("#fc_rut").val();
    var nombre = $("#fc_nombre").val();
    var direccion = $("#fc_direccion").val();
    var ciudad = $("#fc_ciudad").val();
    var comuna = $("#fc_comuna").val();
    var telefono = $("#fc_telefono").val();
    var giro = $("#fc_giro").val();
    if (rut != "" && nombre != "" && direccion != "" && ciudad != "" && comuna != "" && telefono != "" && giro != "") {
        $.post(base_url + "controlador/verf_detalle",
                {num_fac: num_fac},
        function (datos) {
            if (datos.detalle != 0) {
                $.post(base_url + "controlador/cerrar_factura",
                        {num_fac: num_fac},
                function (datos) {
                    if (datos.valor == 0) {
                        $("#msg").hide();
                        $("#msg").html("<label>Error!</label>");
                        $("#msg").css("color", "#55FF00").show('fade', 'slow').delay(3000).hide('fade', 'slow');
                    } else {
                        limpiar_factura();
                        if (datos.detalle != 0) {
                            $("#detalle_factura").attr("style", "visibility: hidden");
                        }
                        $("#td_descartar_f").attr("style", "visibility: hidden");
                        $("#td_descartar_f").attr("style", "display: none");
                        $("#td_crear_f").attr("style", "visibility: show");
                        $("#td_crear_f").attr("style", "display: block");
                        $("#f_bt_descartar_factura").attr("disabled", true);
                        $("#f_bt_descartar_factura").button("refresh");
                        $("#f_bt_crear_factura").removeAttr("disabled");
                        $("#f_bt_crear_factura").button("refresh");
                        $("#f_bt_cerrar_factura").attr("disabled", true);
                        $("#f_bt_cerrar_factura").button("refresh");
                        $("#f_bt_agregar_detalle").attr("disabled", true);
                        $("#f_bt_agregar_detalle").button("refresh");
                        $('#fc_rut').attr('readonly', true);
                        $("#fc_nombre").attr("disabled", true);
                        $("#fd_cantidad").attr('readonly', true);
                        $("#fd_descripcion").attr('readonly', true);
                        $("#fd_precio").attr('readonly', true);
                    }
                }, "json"
                        );
            } else {
                $("#msg").hide();
                $("#msg").html("<label>Debe Ingresar Detalle!</label>");
                $("#msg").css("color", "#FF0000").show('pulsate', 'slow').delay(3000).hide('fade', 'slow');
            }
        }, "json"
                );
    } else {
        $("#msg").hide();
        $("#msg").html("<label>Debe Seleccioner un Cliente!</label>");
        $("#msg").css("color", "#FF0000").show('pulsate', 'slow').delay(3000).hide('fade', 'slow');
    }
}

function limpiar_factura() {
    $("#f_numero").val("");
    $("#fc_rut").val("");
    $("#fc_nombre").val("0");
    $("#fc_direccion").val("");
    $("#fc_ciudad").val("");
    $("#fc_comuna").val("");
    $("#fc_telefono").val("");
    $("#fc_giro").val("");
    $("#fd_cantidad").val("");
    $("#fd_descripcion").val("");
    $("#fd_precio").val("");
    $("#f_subtotal").val("");
    $("#f_neto").val("");
    $("#f_iva").val("");
    $("#f_total").val("");
}

//********************************************INFORMES*************************************************
function cargar_rangos()
//carga el selector de rangos dependiendo de la opción seleccionada en el
//selector de tipos de informe
{
    var tipo = $("#r_tipo_select").val();
//    if (tipo == "f" || tipo == "c" || tipo == "u") {
//        $("#r_rango_select").html("<option value='d'>Diario</option>");
//    } else {
    if (tipo == "f" || tipo == "c" || tipo == "u") {
        $("#r_rango_select").html("<option value='d'>Diario</option><option value='m'>Mensual");
    } else {
        $("#r_rango_select").html("<option value='m'>Mensual</option><option value='a'>Anual</option>");
    }
//    }
}

function generar_informe() {
    var tipo = $("#r_tipo_select").val();
    var rango = $("#r_rango_select").val();
    var fecha = $("#r_datepicker").val();
    if (rango == "d") {
        $.post(base_url + "controlador/reporte_diario", {tipo: tipo, fecha: fecha},
        function (ruta, datos) {
            $("#reporte").html(ruta, datos);
        });
    } else {
        if (rango == "m") {
            $.post(base_url + "controlador/reporte_mensual", {tipo: tipo, fecha: fecha},
            function (ruta, datos) {
                $("#reporte").html(ruta, datos);
            });
        } else {
            $.post(base_url + "controlador/reporte_anual", {tipo: tipo, fecha: fecha},
            function (ruta, datos) {
                $("#reporte").html(ruta, datos);
            });
        }
    }
}

//******************VALIDACIONES*************************

//Mayuscula
function capLock(e) {
    kc = e.keyCode ? e.keyCode : e.which;
    sk = e.shiftKey ? e.shiftKey : ((kc == 16) ? true : false);
    if (((kc >= 65 && kc <= 90) && !sk) || ((kc >= 97 && kc <= 122) && sk))
        document.getElementById('caplock').style.visibility = 'visible';
    else
        document.getElementById('caplock').style.visibility = 'hidden';
}

//Validacion Campo Rut
function validar_numero_letra(myfield, e, dec) {
    var key;
    var keychar;
    if (window.event)
    {
        key = window.event.keyCode;
    }
    else if (e)
    {
        key = e.which;
    }
    else
    {
        return true;
    }
    keychar = String.fromCharCode(key);
    //esto es para permitir las teclas de control como BORRAR(8) entre otras
    if ((key == null) || (key == 0) || (key == 8) || (key == 9) || (key == 13) || (key == 27))
    {
        return true;
    }                 //donde estan los numeros pueden colocar todos los caracteres
// que quieres aceptar por ejemplo: abcd...xyzABCD...XYZ
    else if ((("0123456789k-").indexOf(keychar) > -1))
    {
        return true;
    }                 //no se exactamente para que es pero bueno... xD
    else if (dec && (keychar == "."))// decimal point jump
    {
        myfield.form.elements[dec].focus();
        return false;
    }
    else
    {               //advertencia que da cuando se intenta ingresar un acracter no permitido
        return false;
    }
}

//**Formateo Numeros***
function formatNumeros(input)
{
    var num = input.value.replace(/\./g, '');
    if (!isNaN(num)) {
        num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1.');
        num = num.split('').reverse().join('').replace(/^[\.]/, '');
        input.value = num;
    }
}
//***SOLO NUMEROS*****
function solo_numeros(e)
{
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 8) {
        return true;
    }
    patron = /[0-9]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}
//******************FOCO*********
function foco(e) {
    document.getElementById(e).focus();
}

//***********Enter***********
function enter_conectar(e)
{
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 13)
        conectar();
}
//****Verifica Guiom en input*****
function tiene_guion(texto) {
    var guion = "-";
    for (i = 0; i < texto.length; i++) {
        if (guion.indexOf(texto.charAt(i), 0) != -1) {
            return true;
        }
    }
    return false;
}

function formatNumeros(input)
{
    var num = input.value.replace(/\./g, '');
    if (!isNaN(num)) {
        num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1.');
        num = num.split('').reverse().join('').replace(/^[\.]/, '');
        input.value = num;
    }
}
//Filtro contains CI de las tablas
$.extend($.expr[":"],
        {
            "contains-ci": function (elem, i, match, array)
            {
                return (elem.textContent || elem.innerText || $(elem).text() || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
            }
        }
);
//********************AUTOCOMPLETAR***********************************
//$(function () {
//    $('#fc_nombre').combobox();
//});

//(function ($) {
//    $.widget("ui.combobox", {
//        _create: function () {
//            var input,
//                    that = this, wasOpen = false,
//                    select = this.element.hide(),
//                    selected = select.children(":selected"),
//                    defaultValue = selected.text() || "",
//                    wrapper = this.wrapper = $("<span>").addClass("ui-combobox").insertAfter(select);
//
//            function removeIfInvalid(element) {
//                var value = $(element).val(),
//                        matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(value) + "$", "i"),
//                        valid = false;
//                select.children("option").each(function () {
//                    if ($(this).text().match(matcher)) {
//                        this.selected = valid = true;
//                        return false;
//                    }
//                });
//
//                if (!valid) {         // remove invalid value, as it didn't match anything
//                    $(element).val(defaultValue);
//                    select.val(defaultValue);
//                    input.data("ui-autocomplete").term = "";
//                }
//            }
//
//            input = $("<input>")
//                    .appendTo(wrapper)
//                    .val(defaultValue)
//                    .attr("title", "")
//                    .addClass("ui-state-default ui-combobox-input")
//                    .width(select.width())
//                    .autocomplete({
//                        delay: 0,
//                        minLength: 0,
//                        autoFocus: true,
//                        source: function (request, response) {
//                            var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
//                            response(select.children("option").map(function () {
//                                var text = $(this).text();
//                                if (this.value && (!request.term || matcher.test(text)))
//                                    return {
//                                        label: text.replace(
//                                                new RegExp(
//                                                        "(?![^&;]+;)(?!<[^<>]*)(" +
//                                                        $.ui.autocomplete.escapeRegex(request.term) +
//                                                        ")(?![^<>]*>)(?![^&;]+;)", "gi"
//                                                        ), "<strong>$1</strong>"),
//                                        value: text,
//                                        option: this
//                                    };
//                            }));
//                        },
//                        select: function (event, ui) {
//                            ui.item.option.selected = true;
//                            that._trigger("selected", event, {
//                                item: ui.item.option
//                            });
//                        },
//                        change: function (event, ui) {
//                            if (!ui.item) {
//                                removeIfInvalid(this);
//                            }
//                        }
//                    }).addClass("ui-widget ui-widget-content ui-corner-left");
//
//            input.data("ui-autocomplete")._renderItem = function (ul, item) {
//                return $("<li>")
//                        .append("<a>" + item.label + "</a>")
//                        .appendTo(ul);
//            };
//
//            $("<a>")
//                    .attr("tabIndex", -1)
//                    .appendTo(wrapper).button({
//                icons: {
//                    primary: "ui-icon-triangle-1-s"
//                },
//                text: false
//            })
//                    .removeClass("ui-corner-all")
//                    .addClass("ui-corner-right ui-combobox-toggle")
//                    .mousedown(function () {
//                        wasOpen = input.autocomplete("widget").is(":visible");
//                    })
//                    .click(function () {
//                        input.focus();
//
//                        // close if already visible
//                        if (wasOpen) {
//                            return;
//                        }
//
//                        // pass empty string as value to search for, displaying all results
//                        input.autocomplete("search", "");
//                    });
//        },
//        _destroy: function () {
//            this.wrapper.remove();
//            this.element.show();
//        }
//    });
//})(jQuery);
//
