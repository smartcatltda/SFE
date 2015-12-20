<?php if ($cantidad == 0): ?>
    <option value=""></option>
    <?php
else:
    ?>
    <?php
    foreach ($ciudad as $fila) :
        ?>
        <option value='<?= $fila->id_pr ?>'><?= $fila->str_descripcion_pr ?></option>
        <?php
    endforeach;
endif;
?>