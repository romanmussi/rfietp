<?php
echo $javascript->link('jquery-ui-1.8.5.custom.min', false);
echo $javascript->link('prettify/prettify', false);
echo $html->css('smoothness/jquery-ui-1.8.6.custom',null, false);
echo $html->css('prettify/prettify',null, false);


?>
<script type="text/javascript">
jQuery(document).ready(function() {
    prettyPrint();
    jQuery("#vigenciaDatePicker").datepicker({ minDate: 1, dateFormat: 'yy-mm-dd' });
    toogleVigencia();
});

function toogleVigencia() {
    if (jQuery("#categoria").val() == '2') {
        jQuery('.vigenciaDatePickerDiv').show();
    }
    else {
        jQuery('.vigenciaDatePickerDiv').hide();
        jQuery("#vigenciaDatePicker").val("");
    }
}
</script>
<h2>Query: "<?php echo $this->data['Query']['name']; ?>"</h2>
<pre class="prettyprint lang-sql" style="width:90%;overflow-y:hidden;overflow-x:scroll;">
    <?php echo $this->data['Query']['query']; ?>
</pre>
<h2><?php __('Editar Descarga');?></h2>
<div class="queries form">
<?php echo $form->create('Query');?>
	<fieldset>
	<?php
		echo $form->input('id');
		echo $form->input('name');
        echo $form->input('filename');
		echo $form->input('description');

                echo $form->input('pquery_category_id', array(
                                            'label' => 'Category',
                                            'type' => 'select',
                                            'id' => 'categoria',
                                            'options' => $pquery_categories,
                                            'style' => 'width:150px; clear:none; float:left;',
                                            'onchange' => 'toogleVigencia();',
                                            'default' => '1'));
                
                echo $form->input('expiration_time', array('id'=>'vigenciaDatePicker',
                                                    'type'=>'text',
                                                    'div' => 'vigenciaDatePickerDiv',
                                                    'style' => 'width:100px; clear:none; float:left;'));

        echo $form->input('query');
	?>
	</fieldset>
<?php echo $form->end('Editar');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Eliminar', true), array('action'=>'delete', $form->value('Query.id')), null, sprintf(__('Seguro deseas eliminar esta Descarga?', true), $form->value('Query.id'))); ?></li>
		<li><?php echo $html->link(__('Listado de Descargas', true), array('action'=>'index'));?></li>
	</ul>
</div>
