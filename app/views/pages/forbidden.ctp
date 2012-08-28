<p style="text-align: center">
	<? $session->flash('auth');?>
</p>

<p style="text-align: center">
	<? echo $html->image('forbidden.gif'); ?>
</p>

<?php if($this->layout!='popup'){?>
<p style="text-align: center">
<a href="javascript: history.go(-1)">Volver</a>
</p>
<?php }?>

<p style="text-align: center">
<a href="javascript: window.close()">Cerrar Ventana</a>
</p>