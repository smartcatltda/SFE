<?php if ($cantidad == 0): ?>
    <div>No hay datos que coincidan con los parametros seleccionados</div>
<?php else:
    ?>
    <table cellspacing="0" cellpadding="0" border="0" style="border-radius: 10px; width: 983px; text-align: center; margin: 20px;">
        <tr>
            <td>
                <table cellspacing="0" cellpadding="1" border="1" width="983">
                    <tr class="table-header" style="font-size: 12px;">
                        <th  width="100">RUT</th>
                        <th  width="100">NOMBRE</th>
                        <th width="120">DIRECCION</th>
                        <th width="100">CIUDAD</th>
                        <th width="100">COMUNA</th>
                        <th width="100">TELEFONO</th>
                        <th width="100">GIRO</th>
                        <th  width="100">FACTURAS</th>                     
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <div style="width:1000px; height:280px; overflow:auto;">
                    <table class="table-content" cellspacing="0" cellpadding="1" border="1" width="983" style="font-weight: normal; font-size: 12px;">
                        <?php
                        foreach ($mensual_c as $fila):
                            ?>
                            <tr>
                                <td  width="100"><?= $fila->rut_c ?></td>
                                <td  width="100"><?= $fila->nombre_c ?></td>
                                <td width="120"><?= $fila->direccion_c ?></td>  
                                <td width="100"><?= $fila->str_descripcion_pr ?></td>  
                                <td width="100"><?= $fila->str_descripcion_co ?></td>  
                                <td width="100"><?= $fila->telefono_c ?></td>  
                                <td width="100"><?= $fila->giro_c ?></td>  
                                <td  width="100"><?= $fila->num_fac ?></td>
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