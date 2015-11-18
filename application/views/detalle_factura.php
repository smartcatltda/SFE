<?php if ($cantidad == 0): ?>
<?php else: ?>
    <table cellspacing="0" cellpadding="0" border="0" style=" width: 983px; padding-left: 2%;">
        <tr>
            <td>
                <table class="table-header" cellspacing="0" border="1" width="983">
                    <tr>
                        <th width="90">CANTIDAD</th>
                        <th width="220">DETALLE</th>
                        <th width="120">PRECIO</th>
                        <th width="120">TOTAL</th>
                        <th width="60">ELIMINAR</th>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <div style="width:1000px; height:157px; overflow:auto;">
                    <table id="tabla_detalle_fac" class="table-content" cellspacing="0" border="1" width="983" style="font-weight: normal;">
                        <?php
                        foreach ($detalle as $fila):
                            ?>
                            <tr align="center">
                                <td width="90"><?= $fila->cantidad_fac ?></td>
                                <td width="220"><?= $fila->detalle_fac ?></td>
                                <td width="120">$<?= $fila->precio_fac ?></td>
                                <td width="120">$<?= $fila->total_detalle ?></td>
                                <td width="60"><input type="image" src="css/images/eliminar.png" onclick="delete_detalle('<?= $fila->id_detalle_fac ?>', '<?= $fila->num_fac ?>', '<?= $fila->cantidad_fac ?>', '<?= $fila->precio_fac ?>')" style="width:20px;"/></td>
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