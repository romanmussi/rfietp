<div class="titulos form">
<?php echo $form->create('Depurador', array('action'=>'fusionar'));?>
	<fieldset>
            Fusionar y dejar como Título definitivo:
	<?php
            echo $form->input('titulo_definitivo', array('options' => $titulos, 'style'=>'max-width:420px', 'label' => false));
            
            echo $form->input('titulos', array('type' => 'hidden', 'value' => implode(',', array_keys($titulos))));
	?>
        <?php echo $form->end('Fusionar');?>
        </fieldset>
</div>