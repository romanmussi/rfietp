<script type="text/javascript">
    function ShowPasswordFields() {
        var div = document.getElementById('change_password');

        if (div.style.display == 'none') {
            div.style.display = 'inline';
            // adapta campo para chequeo automatico de CakePhp
            document.getElementById('UserPasswordNotUsed').name = 'data[User][password]';
            document.getElementById('UserPasswordNotUsed').id = 'UserPassword';
        }
        else {
            div.style.display = 'none';
            // adapta campo para que no se haga el chequeo automatico de CakePhp
            document.getElementById('UserPassword').name = 'data[User][password_notused]';
            document.getElementById('UserPassword').id = 'UserPasswordNotUsed';

        }
    }

    function RefreshRole() {
        jQuery('#role').val(jQuery('#grupo :selected').text());
    }
</script>
<h1>Editar Usuario</h1>
<div class="users form">
<?php echo $form->create('User');?>
	<fieldset>
	<?php
		echo $form->input('id');
		echo $form->input('username',array('label'=>'Usuario'));
		echo $form->input('nombre');
		echo $form->input('apellido');
		//$opciones = array('admin'=>'Administrador', 'editor'=> 'Editor', 'invitado'=>'Usuario de Consulta');
                echo $form->input('grupo', array('options'=>$aros, 'selected'=>$parent_aro_seleced, 'id'=>'grupo', 'onchange'=>'Javascript: RefreshRole();'));
                echo $form->input('jurisdiccion_id', array('empty' => array('0'=>' -- '),'id'=>'jurisdiccion_id','label'=>'Jurisdicción'));

                echo $form->input('role',array('id'=>'role', 'type'=>'hidden'));

                echo "<br />".$form->input('show_password', array('type'=>'checkbox','label'=>'Deseo cambiar la password','onclick'=>'Javascript: ShowPasswordFields();'));
        ?>
                <div id="change_password" style="display:none;">
        <?php
                    echo $form->input('password', array('id'=>'UserPasswordNotUsed','name'=>'data[User][password_notused]', 'value'=>'','type'=>'password'));
                    echo $form->input('password_check',array('label'=>'Reingrese Password','type'=>'password'));
	?>
                </div>
        <?php
		
		?><h2>Información Extra</h2><?
		echo $form->input('mail');
		echo $form->input('oficina');
		echo $form->input('interno');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<script type="text/javascript">
jQuery('#role').val(jQuery('#grupo :selected').text());
</script>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('User.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('User.id'))); ?></li>
		<li><?php echo $html->link(__('List Users', true), array('action'=>'index'));?></li>
	</ul>
</div>
