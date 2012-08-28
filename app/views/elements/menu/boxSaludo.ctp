
<? 
	// If the session info hasn't been set...
	if ($session->check('Auth.User')){
?>

<div id="box_saludo">
	<?php echo "Hola <b>".$session->read('Auth.User.nombre')."!</b>";?>			
</div>

<?php 
	} 
?>