<?php if ($cantidad == 0): ?>
<?php else: ?>
    <table cellspacing="0" cellpadding="0" border="0" style=" padding-left: 2%; width: 983px;">
        <tr>
            <td>
                <table class="table-header" cellspacing="0" cellpadding="1" border="1" width="983" >
                    <tr>
                        <th width="100">ID</th>
                        <th width="120">USUARIO</th>
                        <th width="120">NOMBRE</th>
                        <th width="100">APELLIDO</th>
                        <th width="100">TIPO</th>
                        <th width="60">CARGAR</th>
                        <th width="60">ELIMINAR</th>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <div style="width:1000px; height:250px; overflow:auto;">
                    <table id="tabla_lista_usuarios" class="table-content filterable" cellspacing="0" cellpadding="1" border="1" width="983" style=" font-weight: normal;">
                        <?php
                        foreach ($usuarios as $fila):
                            ?>
                            <tr align="center">
                                <td width="100"><?= $fila->id_usuario ?></td>
                                <td width="120"><?= $fila->user ?></td>                             
                                <td width="120"><?= $fila->nombre ?></td>  
                                <td width="100"><?= $fila->apellido ?></td>  
                                <?php
                                if ($fila->tipo_user == 1):
                                    ?>
                                    <td width="100">Administrador</td>
                                    <?php
                                else:
                                    ?>
                                    <td width="100">Usuario</td>
                                <?php
                                endif;
                                ?>
                                <td width="60"><input type="image" src="css/images/arrow-left-icon.png" onclick="seleccionar_usuario('<?= $fila->id_usuario ?>')" style="width:20px;"/></td>
                                <td width="60"><input type="image" src="css/images/eliminar.png" onclick="delete_usuario('<?= $fila->id_usuario ?>')"  style="width:20px;"/></td>
                            </tr>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </table>
            </div>
        </td>
    </tr>
</table>
<?php ?>