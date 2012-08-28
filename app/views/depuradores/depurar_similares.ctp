<?php

echo $javascript->link('prototype');
echo $javascript->link('scriptaculous-js-1.8.3/src/scriptaculous');

?>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>



<ul>
<?php 
	
	foreach ($instits_similars as $i) {
		//debug ($i['Error']);
		echo "<li>";
		
		$txt = "";
		foreach ( $i['Error'] as $error) {
			$txt .= (empty($error)) ? "" : $error . " - ";
		}
		echo $html->link($i['Instit']['cue']*100+$i['Instit']['anexo'], '/instits/view/'.$i['Instit']['id']);
		echo "<span style='color: red'>($txt)</span>";
		echo "</li>";
		
		echo "<ul>";
		foreach ( $i['Similares'] as $e ) {
			echo "<li>";
			echo $html->link($e['Instit']['cue']*100+$e['Instit']['anexo'], '/instits/view/'.$e['Instit']['id']);
			echo "</li>";
		}
		echo "<br>";
		echo "</ul>";
	}
?>
</ul>



<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>