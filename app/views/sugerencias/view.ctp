<div class="sugerencias view">
<h2><?php  __('Sugerencia'); ?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
                <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Asunto'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sugerencia['Sugerencia']['asunto']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Mensaje'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sugerencia['Sugerencia']['mensaje']; ?>
			&nbsp;
		</dd>
                <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('IP'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sugerencia['Sugerencia']['IP']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Fecha Recibido'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php if ($time->isToday($sugerencia['Sugerencia']['created'])) {
                                echo "<b>Hoy</b> ".$time->format('G:i', $sugerencia['Sugerencia']['created'])." hs.";
                            } else {
                                echo $time->format('d/m/Y G:i', $sugerencia['Sugerencia']['created']) .' hs.';
                            } ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Leido'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo ($sugerencia['Sugerencia']['leido'] == 1)?"Sí":"No" ?>
			&nbsp;
		</dd>
                <h2>Remitente</h2>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Username'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sugerencia['User']['username']; ?>
			&nbsp;
		</dd>
                <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Rol'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sugerencia['User']['role']; ?>
			&nbsp;
		</dd>
                <? if (!empty($sugerencia['User']['Jurisdiccion']['name'])) { ?>
                <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Jurisdicción'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sugerencia['User']['Jurisdiccion']['name']; ?>
			&nbsp;
		</dd>
                <?php
                }
                ?>
                <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nombre'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sugerencia['User']['nombre']; ?>
			&nbsp;
		</dd>
                <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Apellido'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sugerencia['User']['apellido']; ?>
			&nbsp;
		</dd>
                <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Mail'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sugerencia['User']['mail']; ?>
			&nbsp;
		</dd>
                <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Oficina'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sugerencia['User']['oficina']; ?>
			&nbsp;
		</dd>
                <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Interno'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sugerencia['User']['interno']; ?>
			&nbsp;
		</dd>
		
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Eliminar Sugerencia', true), array('action' => 'delete', $sugerencia['Sugerencia']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $sugerencia['Sugerencia']['id'])); ?> </li>
		<li><?php echo $html->link(__('Listar Sugerencias', true), array('action' => 'index')); ?> </li>
	</ul>
</div>
