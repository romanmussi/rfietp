<?
if (!$session->check('Auth.User')) {
?>
<h1>Ingresar</h1>
<div id="box_loguin">
<?php
//pr($session->read());
// If the session info hasn't been set...
echo $form->create('User', array('action'=>'login','id'=>'menu_logeo'));
echo $form->input('username',array('label'=>'Usuario'));
echo $form->input('password', array('type'=>'password','label'=>'Contraseña'));
echo $form->end('Entrar');

?>
</div>
<? } ?>