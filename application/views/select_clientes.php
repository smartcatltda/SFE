<?php if ($cantidad == 0): ?>
    <option value=""></option>
    <?php
else:
    ?>
    <option  value="0-0">Seleccione</option>
    <?php
    foreach ($clientes as $fila) :
        if ($fila->rut_c != '0-0'):
            ?>
            <option value='<?= $fila->rut_c ?>'><?= $fila->nombre_c; ?></option>
            <?php
        endif;
    endforeach;
endif;
?>