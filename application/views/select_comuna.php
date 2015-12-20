<?php if ($cantidad == 0): ?>
    <option value=""></option>
    <?php
else:
    ?>
    <?php
    foreach ($comuna as $fila) :
        ?>
        <option value='<?= $fila->id_co ?>'><?= $fila->str_descripcion_co ?></option>
        <?php
    endforeach;
endif;
?>
