<?php
if (!empty($similars)) {
?>
<b><?php echo $html->image('attention_icon.gif', array('align:absmiddle')); ?> Existen Planes en esta institución con nombre similar:</b>
<div>
    <?php
    $abrio = $identicos = false;
    foreach ($similars as $k=>$plan) {
        if ($plan['Plan']['nombre'] == $name) {
            $identicos = true;
        }
        else {
            $identicos = false;
        }

        if ($k > 5 && !$abrio) {
    ?>
        <a href="#" id="linkmas" onclick="jQuery('#vermas').attr('style', 'display:block'); jQuery(this).hide(); jQuery('#linkmenos').show();">ver más...</a>
        <a href="#" id="linkmenos" style="display:none;" onclick="jQuery('#vermas').attr('style', 'display:none'); jQuery(this).hide(); jQuery('#linkmas').show();">ver menos...</a>
        <div id="vermas" style="display:none;">
    <?php
            $abrio = true;
        }
    ?>
            &bull; <?php if ($identicos) {?><span style="color:red;"><? }?>
                <? echo $html->link($plan['Plan']['nombre'],array('controller'=>"Planes", 'action'=>'view', $plan['Plan']['id']))?>
            <?php if ($identicos) {?></span><? }?><br />
    <?php
    }

    if ($abrio) {
    ?>
        </div>
    <?php
    }
    ?>
</div>
<?php
}
else {
?>
<div><b><?php echo $html->image('check.gif', array('v-align:absmiddle')); ?> No existen Planes en esta Institución con nombre similar</b></div>
<?php
}
?>