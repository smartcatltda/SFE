<?php if ($cantidad == 0): ?>
    <div>No hay datos que coincidan con los parametros seleccionados</div>
<?php else:
    ?>
    <table cellspacing="0" cellpadding="0" border="0" style="border-radius: 10px; width: 983px; text-align: center; margin: 20px;">
        <tr>
            <td>
                <table cellspacing="0" cellpadding="1" border="1" width="983">
                    <tr class="table-header" style="font-size: 12px;">
                        <th  width="100">FACTURAS EMITIDAS</th>
                        <th  width="100">TOTAL NETO</th>
                        <th  width="100">TOTAL IVA</th>
                        <th  width="100">TOTAL FACTURAS</th>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <div style="width:1000px; height:280px; overflow:auto;">
                    <table class="table-content" cellspacing="0" cellpadding="1" border="1" width="983" style="font-weight: normal; font-size: 12px;">
                        <?php
                        foreach ($mensual_f as $fila):
                            $fila->neto_fac = number_format($fila->neto_fac, 0, ",", ".");
                            $fila->iva_fac = number_format($fila->iva_fac, 0, ",", ".");
                            $fila->total_fac = number_format($fila->total_fac, 0, ",", ".");
                            ?>
                            <tr>
                                <td  width="100"><?= $total_fac ?></td>
                                <td  width="100"><?= $fila->neto_fac ?></td>
                                <td  width="100">$<?= $fila->iva_fac ?></td>
                                <td  width="100">$<?= $fila->total_fac ?></td>
                            </tr>
                            <?php
                        endforeach;
                        ?>
                    </table>
                </div>
            </td>
        </tr>
    </table>
<?php
endif;
?>