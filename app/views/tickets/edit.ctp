<?
if(isset($script)){
	echo $script;
}
?>

<h1 align="center"> <?= "Datos" ?></h1>
<div class="anios form">
<?php echo $form->create('Ticket');?>
	<fieldset>
     <div style="float:left;width:48%;clear:none">
          <label>Alta</label>
          <span><?php echo date('d-m-Y',strtotime($this->data['Ticket']['created'])); ?></span>
     </div>
     <div style="float:right;width:48%;clear:none">
          <label>Última Modificacion</label>
          <span><?php echo date('d-m-Y',strtotime($this->data['Ticket']['modified'])); ?></span>
     </div>
	<?php
		echo $form->input('id');

                $gruposConPermisos = array('editores', 'administradores', 'desarrolladores');
                
		echo $form->input('user_name', array(
                    'readonly'  => !in_array($session->read('Auth.User.role'), $gruposConPermisos),
                    'type'      => 'text',
                    'label'     => 'Usuario responsable',
                    'value'     => $user['nombre']." ".$user['apellido']));

		echo $form->input('observacion', array(
                    'readonly'  => !in_array($session->read('Auth.User.role'), $gruposConPermisos),
                            ));

                // grupos que tienen permiso para marcar como "Resuelto" al ticket
		echo $form->input( 'estado' , array(
                    'disabled'  => !in_array($session->read('Auth.User.role'), $gruposConPermisos),
                    'type'      => 'checkbox',
                    'checked'   => false,
                    'label'     => 'Resuelto.',
                    ));
	?>
	</fieldset>
<?php echo $form->end('Guardar');?>
</div>
