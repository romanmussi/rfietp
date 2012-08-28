<?

	//debug($ruta);
if (!empty($ruta)){?>


	<p id="rutaUrl">
		<?
		foreach ($ruta as $r){		
			echo " > ".$html->link($r['name'],$r['link']);
		}
		
		?>
	</p>

		
<? } ?>