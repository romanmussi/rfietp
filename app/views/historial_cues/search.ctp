
<h1><?= __('Histórico de Cambio de Cue')?></h1>

<? 
$paginator->options(array('url' => $url_conditions));

?>

<? if (sizeof($conditions)>0): ?>
	<H2>Criterios de búsqueda seleccionados</H2>
	<dl class="criterios_busq">
	<?
	
	 foreach($conditions as $key => $value){
		?><dt><?
			echo '- '.$key.': ';
		?></dt><?
		?><dd><?
			echo $value;
		?></dd><?
	}
	
	?>
	</dl>
<? endif; ?>

<? 

if ($paginator->counter(array('format' =>'%count%')) > 0) {?>
	
	<h2>Resultados (<? echo $paginator->counter(array('format' => __('Mostrando %current% Registro de %count% encontrados', true)
	)); ?>)</h2>
	<ul class="listado">
	<?php  
	foreach($instits as $instit){
		if($instit['Instit']['activo']){
			$clase = ' escuela_activa';
		}else{
			$clase = ' escuela_inactiva';
		}
?>
	<li id="lista_instit_<?= $instit['Instit']['id']?>" class="lista_link <?=$clase ?>" 
		onclick="window.location='<?= $html->url(array('controller'=> 'Instits', 'action'=>'view/'.$instit['Instit']['id'])) ?>'"
		onmouseover="jQuery('#lista_instit_<?= $instit['Instit']['id']?>').addClass('lista_link_hover');"
		onmouseout="jQuery('#lista_instit_<?= $instit['Instit']['id']?>').removeClass('lista_link_hover');"
		title="<?= $instit['Instit']['nombre_completo']?>"
		>
		<div class="instit_link_list">
		<?php echo $html->link('+ Info','/instits/view/'.$instit['Instit']['id']);?>
		</div>	

		<div class="instit_data_bs">
			<div class="instit_atributte">
              <?php if (isset($instit['HistorialCue']['cue']) && ($instit['HistorialCue']['cue'] != "")) {?> 
				  <b>El Cue asociado a la institución hasta: </b>
				  <?=date("d/m/y",strtotime($instit['HistorialCue']['created']));?>
				  <b>era: </b><?= str_replace((isset($url_conditions['cue'])?$url_conditions['cue']:""),"<font color='red'>". (isset($url_conditions['cue'])?$url_conditions['cue']:"") . "</font>",($instit['HistorialCue']['cue']*100)+$instit['HistorialCue']['anexo']); ?>
			  <?php } else { ?>					  
                  <b>La institución no ha sufrido cambio de CUE </b>
			  <?php } ?>
			</div>
			<div class="instit_name"><b>
									<?
										$cue_anexo = str_replace((isset($url_conditions['cue'])?$url_conditions['cue']:""),"<font color='red'>". (isset($url_conditions['cue'])?$url_conditions['cue']:"") . "</font>",($instit['Instit']['cue']*100)+$instit['Instit']['anexo'], $count);
										
										if(isset($url_conditions['cue']) && $url_conditions['cue'] != "" && $url_conditions['cue'][0]=="0" && $count==0) {
											$cue_anexo = preg_replace('/'.substr($url_conditions['cue'],1).'/', "<font color='red'>".substr($url_conditions['cue'],1)."</font>", $cue_anexo, 1);
										}
										
										echo $cue_anexo." - " . $instit['Instit']['nombre_completo'];
									?>
									</b></div>
		</div>
	</li>
		<?
	}
	?>
	</ul>
	
	
	<div id="paginator_prev_next_links">
	<?php	
		echo $paginator->prev('« Anterior ',null, null, array('class' => 'disabled'));
		echo " | ".$paginator->numbers(array('modulus'=>'13'))." | ";
		echo $paginator->next(' Siguiente »', null, null, array('class' => 'disabled'));
	?> 
	</div>
	
	<p>
	<h3></h3>
	<? echo $html->image('/css/images/puntoverde.gif',array('title'=>'Ingresados a la Base de Datos')); ?>
	- Institución ingresada al RFIETP<br />
	<? echo $html->image('/css/images/puntorojo.gif',array('title'=>'NO Ingresados a la Base de Datos')); ?>
	- Institución NO ingresada al RFIETP
	<? echo "</p>"?>
	
	<p  class="paginate_msg">
	<?php
	echo $paginator->counter(array(
	'format' => __('Página %page% de %pages%<br />Mostrando %current% registros de %count% encontrados, visualizando registros desde el nº %start%, hasta el %end%', true)
	));
	?>
	</p>
<?
}else{
	?>
	<!--	No hubo resutados, entonces muestro un link que permita agregar uinstituciones -->
	<h2>No Obtuvieron Resultados</h2>
	<? 
}
?>