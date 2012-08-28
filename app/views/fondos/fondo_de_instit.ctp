<?php debug($this->passedArgs)?>
<ul>
	<li>
		<?php echo $paginator->sort('Valor asignado','valor_asignado',array('url'=> array("0")));?>
	</li>
	<li>
		<?php echo $paginator->sort('Trimestre','fecha_aprobacion',array('url'=> array("0")));?>
	</li>
</ul>

<p>
<dl>
	<?php
	foreach ($fondos as $f):
	?>	
		<dt>&nbsp;<?php echo $f['LineasDeAccion']['name'];?></dt>
		<dd>&nbsp;<?php echo $f['Fondo']['valor_asignado'].'<br>';?></dd>
	<?php 
	endforeach;
	?>
</dl>
<p>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Inputar un nuevo valor', true), array('action'=>'add_institucion',$instit_id)); ?> </li>		
	</ul>
</div>