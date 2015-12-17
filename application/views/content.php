<div id="msg" class="msg centrar"></div>
<div hidden id="dialog-confirmacion" title="Confirmación">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>
        ¿ Esta seguro que desea Eliminar el registro?
    </p>
</div>
<div hidden id="dialog-rut" title="Error">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>
        El Dígito Verificador No Corresponde al Rut Ingresado!
    </p>
</div>
<div hidden id="dialog-guion" title="Error">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>
        El Rut Ingresado No es Correcto.<br>
        (Ej: 12345678-9)
    </p>
</div>
<!--************LOGIN************-->
<div id="login" class="centrar" hidden>
    <div class="login" style="z-index: -1">
        <div style="font-size: 20px; text-shadow: black 0.1em 0.1em 0.2em;"><h1>Inicio de Sesión</h1></div>
        <hr style="width: 35%;"><br>
        <input class="user_icon rounded" placeholder="Usuario" size="30" id="user" maxlength="10" style="font-size: 20px; text-align: center" autofocus /><br>
        <input class="pass_icon rounded" placeholder="Contraseña" type="password" size="30" id="pass" style="font-size: 20px; text-align: center" required onkeypress="capLock(event), enter_conectar(event)"/><br>
        <br>
        <button id="conectar">Conectar</button>
        <hr style="width: 35%;"><br>
        <h3 id="caplock" style="visibility:hidden; text-shadow: black 0.1em 0.1em 0.2em; color: lightgray; font-size: 18px;">Bloqueo de mayúscula activado</h3>
    </div>
</div>
<div id="contenido" class="centrar" hidden>
    <div id="inicio"></div>

    <!--********************MANTENEDOR CLIENTES*****************-->
    <div id="clientes" class="contenido" hidden="">
        <table width="1024" cellspacing="2">
            <thead>
                <tr>
                    <th colspan="7" style="text-align: center; color: white; font-size: 18px; text-shadow: black 0.1em 0.1em 0.2em;">Mantenedor de Clientes</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="3" style="height: 5px"></td>
                </tr>
                <tr>
            <input type="text"  id="rut_edit" style="width: 1px;" hidden disabled/>
            <td style="color: white;">Rut</td>
            <td style="color: white;">Nombre</td>
            <td style="color: white;">Dirección</td>
            <td style="color: white;">Ciudad</td>
            <td style="color: white;">Comuna</td>
            <td style="color: white;">Telefono</td>
            <td style="color: white;">Giro</td>
            </tr>
            <tr>
                <td><input type="text"  id="mc_rut" placeholder="Ej: 12345678-9" style="width: 140px; text-align: center"class="rounded" maxlength="10" onkeypress="return validar_numero_letra(this.event)"/></td>
                <td><input type="text" id="mc_nombre" placeholder="Nombre" style="width: 140px; text-align: center" class="rounded"/></td>
                <td><input type="text" id="mc_direccion" placeholder="Dirección" style="width: 140px; text-align: center" class="rounded"/></td>
                <td><input type="text" id="mc_ciudad" placeholder="Ciudad" style="width: 140px; text-align: center" class="rounded"/></td>
                <td><input type="text" id="mc_comuna" placeholder="Comuna" style="width: 140px; text-align: center"class="rounded"/></td>
                <td><input type="text" id="mc_telefono" placeholder="Telefono" style="width: 130px; text-align: center"class="rounded"/></td>
                <td><input type="text" id="mc_giro" placeholder="Giro" style="width: 140px; text-align: center" class="rounded"/></td>
            </tr>
            <tr>
                <td colspan="5"></td>
                <td colspan="2" rowspan="2" align="right">
                    <button id="mc_bt_guardar" style="width: 110px; text-align: center">Guardar</button>
                    <button id="mc_bt_editar" style="width: 110px; text-align: center">Editar</button>
                </td>
            </tr>
            <tr>
                <td colspan="2"><input type="text" id="mc_filtro" placeholder="Busqueda" value="" style="width: 290px; text-align: center" class="rounded"/></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="6" style="height: 5px"></td>
            </tr>
            </tbody>
        </table>
        <br>
        <div id="lista_clientes"></div>
        </table>
    </div>
    <!-- ***************MANTENEDOR USUARIO**************-->
    <div id="usuarios" class="contenido" hidden="">
        <table width="1024" cellspacing="2">
            <thead>
                <tr>
                    <th colspan="7" style="text-align: center; color: white; text-shadow: black 0.1em 0.1em 0.2em; font-size: 18px;">Mantenedor de Usuarios</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="3" style="height: 5px"></td>
                </tr>
                <tr>
            <input type="text"  id="id_user" style="width: 1px;" hidden disabled/>
            <input type="text"  id="nombre_user" style="width: 1px;" hidden disabled/>
            <td style="color: white;">Usuario</td>
            <td style="color: white;">Contraseña</td>
            <td style="color: white;">Nombre</td>
            <td style="color: white;">Apellido</td>
            <td style="color: white;">Tipo</td>
            </tr>
            <tr>
                <td><input type="text"  id="mu_user" placeholder="Usario" style="width: 140px; text-align: center"class="rounded" maxlength="10" /></td>
                <td><input type="password" id="mu_pass" placeholder="Contraseña" style="width: 140px; text-align: center" class="rounded"/></td>
                <td><input type="text" id="mu_nombre" placeholder="Nombre" style="width: 140px; text-align: center" class="rounded"/></td>
                <td><input type="text" id="mu_apellido" placeholder="Apellido" style="width: 140px; text-align: center" class="rounded"/></td>
                <td><select class="rounded" id="mu_tipo" style="width: 180px;" >
                        <option value="" selected>Seleccione</option>
                        <option value='0'>Usuario</option>
                        <option value='1'>Administrador</option>
                    </select>
                </td>
                <td align="right"><button id="mu_bt_guardar" style="width: 110px; text-align: center">Guardar</button></td>
                <td align="right"> <button id="mu_bt_editar" style="width: 110px; text-align: center">Editar</button></td>
            </tr>
            <tr>
                <td colspan="2"><input type="text" id="mu_filtro" placeholder="Busqueda" value="" style="width: 290px; text-align: center" class="rounded"/></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="6" style="height: 5px"></td>
            </tr>
            </tbody>
        </table>
        <br>
        <div id="lista_usuarios"></div>
        </table>
    </div>
    <!-- ***************FACTURA**************-->
    <div id="factura" class="contenido" hidden="" >
        <table width="1024">
            <caption style="text-align: center; color: white; text-shadow: black 0.1em 0.1em 0.2em; font-weight: bold; font-size: 18px;">Factura Electrónica</caption>
            <tr> 
                <td id="td_crear_f"><button id="f_bt_crear_factura" style="width: 180px; text-align: center">Crear Factura</button></td>
                <td style="display: none;" id="td_descartar_f"><button disabled id="f_bt_descartar_factura" style=" width: 180px; text-align: center">Descartar Factura</button></td>
                <td style="color: white;">N°<input readonly type="text" id="f_numero"  style="width: 80px; text-align: center" class="rounded"/></td>
                <td><button disabled id="f_bt_cerrar_factura" style="width: 180px; text-align: center">Cerrar Factura</button></td>
            </tr>
        </table>
        <table width="1024" cellspacing="2">
            <tbody>
                <tr>
                    <td colspan="3" style="height: 5px"></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: left; color: white; text-shadow: black 0.1em 0.1em 0.2em; font-weight: bold; font-size: 16px;">DATOS CLIENTE:</td>
                </tr>
                <tr>
                    <td style="color: white;">Rut</td>
                    <td style="color: white;">Nombre</td>
                    <td style="color: white;">Dirección</td>
                    <td style="color: white;">Ciudad</td>
                    <td style="color: white;">Comuna</td>
                    <td style="color: white;">Telefono</td>
                    <td style="color: white;">Giro</td>
                </tr>
                <tr>
                    <td><input type="text" id="fc_rut"  style="width: 140px; text-align: center" class="rounded" readonly maxlength="10" onkeypress="return validar_numero_letra(this.event)"/></td>
                    <td><select disabled class="rounded" id="fc_nombre" style="width: 140px; text-align: center"/></td>                    
                    <td><input type="text" id="fc_direccion" style="width: 140px; text-align: center" class="rounded" readonly/></td>
                    <td><input type="text" id="fc_ciudad"  style="width: 140px; text-align: center" class="rounded" readonly/></td>
                    <td><input type="text" id="fc_comuna" style="width: 140px; text-align: center"class="rounded" readonly/></td>
                    <td><input type="text" id="fc_telefono" style="width: 130px; text-align: center"class="rounded" readonly/></td>
                    <td><input type="text" id="fc_giro" style="width: 140px; text-align: center" class="rounded" readonly/></td>
                </tr>
                <tr>
                    <td colspan="3" style="height: 5px"></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: left; color: white; text-shadow: black 0.1em 0.1em 0.2em; font-weight: bold; font-size: 16px;">DETALLE:</td>
                </tr>
            </tbody>
        </table>
        <table style="width: 1024px">
            <tr>
                <td style="color: white;">Cantidad </td>
                <td style="color: white;">Descripción </td>
                <td style="color: white;">Precio </td>
            </tr>
            <tr>
                <td><input type="text"  id="fd_cantidad" maxlength="11" style="width: 130px; text-align: center"class="rounded" onkeypress="return solo_numeros(event)" onkeyup="formatNumeros(this)" readonly/></td>
                <td><input type="text" id="fd_descripcion"  style="width: 500px; text-align: center" class="rounded" readonly/></td>
                <td><input type="text" id="fd_precio"  maxlength="11" style="width: 140px; text-align: center" class="rounded" onkeypress="return solo_numeros(event)" onkeyup="formatNumeros(this)" readonly/></td>
                <td><button id="f_bt_agregar_detalle" disabled style="width: 180px; text-align: center">Agregar</button></td>
            </tr>
            <tr>
                <td colspan="3" style="height: 4px"></td>
            </tr>
        </table>
        <div style="height: 183px" id="detalle_factura"></div>
        <table style="width: 1024px">
            <td colspan="3" style="height: 4px"></td>
            <tr>
                <td style="color: white">Sub Total:<input type="text" readonly placeholder="0" id="f_subtotal" style="width: 150px; text-align: center" class="rounded" /></td>
                <td style="color: white">Neto:<input type="text" readonly placeholder="0" id="f_neto" style="width: 150px; text-align: center"class="rounded" /></td>
                <td style="color: white">IVA:<input type="text" readonly placeholder="0" id="f_iva" style="width: 150px; text-align: center" class="rounded"  /></td>
                <td style="color: white">Total:<input type="text" readonly placeholder="0" id="f_total" style="width: 150px; text-align: center" class="rounded" /></td>
            </tr>
        </table>
    </div>
    <!--****************************REPORTES***************************-->
    <div id="informe"  class="contenido" hidden="">
        <table style="width: 1024px;">
            <thead>
                <tr>
                    <th colspan="7" style="text-align: center; color: white; font-size: 18px; text-shadow: black 0.1em 0.1em 0.2em;">Informes</th>
                </tr>
            </thead>
        </table>
        <br>
        <table class=" " style="border-radius: 8px; width: 1024px;" border="0">
            <tr>
                <td rowspan="2">Tipo de Informe</td>
                <td rowspan="2">Rango de Tiempo</td>
                <td rowspan="2">Fecha</td>
            </tr>
            <tbody>
                <tr>
                    <td>
                        <select class="rounded" id="r_tipo_select" onchange="cargar_rangos()" style="width: 200px;">
                            <option value="f">Facturas</option>
                            <option value="c">Clientes</option>
                            <option value="u">Usarios</option>
                            <option value="rf">Resumen Factura</option>
                            <option value="rc">Resumen Clientes</option>
                            <option value="ru">Resumen Usuarios</option>
                        </select>
                    </td>
                    <td>
                        <select class="rounded" id="r_rango_select" style="width: 200px;"></select>
                    </td>
                    <td><input type="text" style="text-align: center;" id="r_datepicker" class="rounded"></td>
                    <td><button id="r_generarInforme">Generar Informe</button></td>
                </tr>
            </tbody>
        </table>
        <br>
        <div id="reporte"></div>
    </div>
</div>