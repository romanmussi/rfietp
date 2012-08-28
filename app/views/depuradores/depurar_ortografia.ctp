<?php
echo $javascript->link(array('activespell/cpaint/cpaint2.inc.compressed.js', 'activespell/js/spell_checker'));
echo $html->css(array('spell_checker.css'));
?>
<script type="text/javascript">
    jQuery(this).ready(function () {
        setInterval('cleanOks()', 2000);
    });

    function cleanOks() {
        jQuery.each(jQuery('.status'), function(key, value) {
            if (jQuery(value).find('img').hasClass('js-correcto')) {
                jQuery(value).closest("tr").remove();
            }
        });
    }
</script>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Página %page% de %pages% (%count% sugerencias en total)', true)
));
?>
</p>
<div class="ortografia form">
<?php echo $form->create('Plan');?>
    <table cellpadding="0" cellspacing="0" style="font-size:9pt;">
        <tr>
                <th><?php echo $paginator->sort('name');?></th>
        </tr>
    <?php
        foreach ($planes as $plan) {
            ?>
        <tr>
            <td>
            <?php
            echo $form->input('tipoinstit_name_'.$plan['Plan']['id'],
                    array(  'value' => $plan['Plan']['perfil'],
                            'label' => false,
                            'title' => 'spellcheck_icons',
                            'after' => '<a href="'.$html->url('/planes/edit/'.$plan['Plan']['id']).'" target="_blank">editar</a>',
                            'style' => 'width: 85%; clear: none;',
                            'accesskey' => $html->url('/js/activespell/').'spell_checker.php'
                    ));
            ?>
                <br /><br />
            </td>
        </tr>
            <?php
        }

        echo $form->end(null);
    ?>
    </table>
</div>
<div>
<?php
echo $paginator->prev('<< '.__('Anterior', true), array(), null, array('class'=>'disabled'));
echo $paginator->numbers(array('modulus'=>13));
echo $paginator->next(__('Siguiente', true).' >>', array('style'=>'float:right;'), null, array('class'=>'disabled'));
?>
</div>