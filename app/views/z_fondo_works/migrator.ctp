
<h1>Migrador de Fondo</h1>

<p class="<?= $msg_type; ?>">
    <?php echo "$msg";?>
</p>


<? if (!empty($msg_check)) { ?>
<p class="<?= $msg_check_type; ?>">
    <?php echo $msg_check;?>
</p>
<? } ?>
