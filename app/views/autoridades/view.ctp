<div class="autoridades view">
<h2><?php  __('Autoridad');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Jurisdiccion'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $autoridad['Jurisdiccion']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nombre'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $autoridad['Autoridad']['titulo'] . ' ' . $autoridad['Autoridad']['nombre'] . ' ' . $autoridad['Autoridad']['apellido']; ?>
			&nbsp;
		</dd>
                <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cargo'); ?></dt>
                <dd<?php if ($i++ % 2 == 0) echo $class;?>>
                    <ul<?php if ($i++ % 2 == 0) echo $class;?>>
                        <?php foreach($autoridad['Cargo'] as $cargo){?>
                        <li><?php echo $cargo['nombre']?></li>
                        <?php
                            }
                        ?>
                            &nbsp;
                    </ul>
                </dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Fecha Asuncion'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $time->format('d/m/Y',$autoridad['Autoridad']['fecha_asuncion']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Telefono Personal'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $autoridad['Autoridad']['telefono_personal']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Telefono Institucional'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $autoridad['Autoridad']['telefono_institucional']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email Personal'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $autoridad['Autoridad']['email_personal']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email Institucional'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $autoridad['Autoridad']['email_institucional']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Direccion'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>

                        <?php if(!empty($autoridad['Autoridad']['localidad_id'])){
                            echo $autoridad['Autoridad']['direccion'] . ' - ' . $autoridad['Localidad']['name'] . ', ' . $autoridad['Departamento']['name'] . ' ( ' . $autoridad['Jurisdiccion']['name'] . ' )';
                        }
                        else{
                            echo $autoridad['Autoridad']['direccion'] . ' - ' . $autoridad['Departamento']['name'] . ' ( ' . $autoridad['Jurisdiccion']['name'] . ' )';
                        }
                        ?>
			&nbsp;
		</dd>
                
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Editar Autoridad', true), array('action' => 'edit', $autoridad['Autoridad']['id'])); ?> </li>
		<li><?php echo $html->link(__('Eliminar Autoridad', true), array('action' => 'delete', $autoridad['Autoridad']['id']), null, sprintf(__('Seguro que quiere eliminar la autoridad?', true), $autoridad['Autoridad']['id'])); ?> </li>
	</ul>
</div>
