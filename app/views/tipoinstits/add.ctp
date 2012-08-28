<?php
echo $javascript->link(array(
        'activespell/cpaint/cpaint2.inc.compressed.js',
        'activespell/js/spell_checker'
    ));
echo $html->css(array('jquery.loadmask', 'spell_checker.css'));
?>
<div class="tipoinstits form">
<?php echo $form->create('Tipoinstit');?>
	<fieldset>
 		<legend><?php __('Add Tipoinstit');?></legend>
	<?php
		echo $form->input('jurisdiccion_id');
		echo $form->input('name', array(
                            'title' => 'spellcheck_icons',
                            'style' => 'width: 85%; clear: none;',
                            ((Configure::read('modo_linux'))? 'accesskey': '') => $html->url('/js/activespell/').'spell_checker.php',
                ));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Tipoinstits', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Jurisdicciones', true), array('controller'=> 'jurisdicciones', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Jurisdiccion', true), array('controller'=> 'jurisdicciones', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Instits', true), array('controller'=> 'instits', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Instit', true), array('controller'=> 'instits', 'action'=>'add')); ?> </li>
	</ul>
</div>
