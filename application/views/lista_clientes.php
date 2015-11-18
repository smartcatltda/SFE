<?php if ($cantidad == 0): ?>
<?php else: ?>
    <table cellspacing="0" cellpadding="0" border="0" style=" padding-left: 2%; width: 983px;">
        <tr>
            <td>
                <table class="table-header" cellspacing="0" cellpadding="1" border="1" width="983" >
                    <tr>
                        <th width="100">RUT</th>
                        <th width="120">NOMBRE</th>
                        <th width="120">DIRECCION</th>
                        <th width="100">CIUDAD</th>
                        <th width="100">COMUNA</th>
                        <th width="100">TELEFONO</th>
                        <th width="100">GIRO</th>
                        <th width="60">CARGAR</th>
                        <?php
                        if ($this->session->userdata('permiso') == 1):
                            ?>
                            <th width="60">ESTADO</th>
                            <?php
                        endif;
                        ?>
                        <th width="60">ELIMINAR</th>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <div style="width:1000px; height:250px; overflow:auto;">
                    <table id="tabla_lista_clientes" class="table-content filterable" cellspacing="0" cellpadding="1" border="1" width="983" style=" font-weight: normal;">
                        <?php
                        foreach ($clientes as $fila):
                            ?>
                            <tr align="center">
                                <?php
                                if ($fila->rut_c != '0-0'):
                                    ?>
                                    <td width="100"><?= $fila->rut_c ?></td>
                                    <td width="120"><?= $fila->nombre_c ?></td>                             
                                    <td width="120"><?= $fila->direccion_c ?></td>  
                                    <td width="100"><?= $fila->ciudad_c ?></td>  
                                    <td width="100"><?= $fila->comuna_c ?></td>  
                                    <td width="100"><?= $fila->telefono_c ?></td>  
                                    <td width="100"><?= $fila->giro_c ?></td>  
                                    <td width="60"><input type="image" src="css/images/arrow-left-icon.png" onclick="seleccionar_cliente('<?= $fila->rut_c ?>')" style="width:20px;"/></td>
                                    <?php
                                    if ($this->session->userdata('permiso') == 1):
                                        ?>
                                        <?php
                                        if ($fila->estado_cliente == 1):
                                            ?>
                                            <td width="60"><input type="image" src="css/images/Accept.png" onclick="estado_cliente('<?= $fila->rut_c ?>', '<?= $fila->estado_cliente ?>')" style="width:20px;"/></td>
                                            <?php
                                        else:
                                            ?>
                                            <td width="60"><input type="image" src="css/images/guion-delete.png" onclick="estado_cliente('<?= $fila->rut_c ?>', '<?= $fila->estado_cliente ?>')" style="width:20px;"/></td>
                                        <?php
                                        endif;
                                    endif;
                                    ?>
                                    <td width="60"><input type="image" src="css/images/eliminar.png" onclick="delete_cliente('<?= $fila->rut_c ?>')"  style="width:20px;"/></td>
                                </tr>
                                <?php
                            endif;
                        endforeach;
                    endif;
                    ?>
                </table>
            </div>
        </td>
    </tr>
</table>
<?php ?>