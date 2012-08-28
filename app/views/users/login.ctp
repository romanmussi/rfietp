<h1>Logueo De usuario</h1>
<?php
if($session->check('Message.auth')) $session->flash('auth');

echo $form->create('User', array('action'=>'login'));
echo $form->input('username',array('label'=>'Usuario', 'id'=>'NombreUsuario'));
echo $form->input('password', array('type'=>'password','label'=>'Contraseña','id'=>'Contrasenia'));
echo $form->end('Entrar');

?>
<br><br>
<p>
<b>Si usted no posee cuenta de usuario</b> debe solicitarla en la Unidad de Información, oficina 311. 
</p>

