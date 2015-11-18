<!DOCTYPE html>
<html lang="en">
    <head>
        <title>SFE Sistema de Facturación Electrónica</title>
        <meta charset="utf-8">

        <script src="js/jquery.js" type="text/javascript"></script>
        <script src="js/jquery-ui.js" type="text/javascript"></script>
        <script src="js/jquery-ui.min.js" type="text/javascript"></script>
        <script src="js/funciones.js" type="text/javascript"></script>

        <link type="text/css" rel="stylesheet"href="css/estilo.css"/>
        <link type="text/css" rel="stylesheet" href="css/jquery-ui.css">
        <link type="text/css" rel="stylesheet" href="css/jquery-ui.structure.css">
        <link type="text/css" rel="stylesheet" href="css/jquery-ui.theme.css">

        <script type="text/javascript">var base_url = "<?= base_url(); ?>";</script>

    </head>
    <header>
        <div id="menu" class="ui-widget-header ui-corner-all centrar" hidden style="text-align: left; margin-bottom: 10px; ">
            <button id="menuinicio">Inicio</button>
            <button id="menuusuarios" onclick="cargar_usuarios();">Usuarios</button>
            <button id="menuclientes" onclick="cargar_clientes();">Clientes</button>
            <button id="menufactura" onclick="cargar_select_clientes();">Facturas</button>
            <button style="float: right" id="menusalir">Cerrar Sesión</button>
        </div>
    </header>
    <body>