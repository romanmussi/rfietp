
<style>
/* ESTO ES PARA QUE NO ME IMPRIMA EL ENCABEZADO CUANDO MANDO A IMPRIMIR*/
@media print
  {
	  #header {
	   display: none;
	  }
  }
</style>


<div class="ver-solo-para-imprimir logos-header">
				<?php echo $html->image('logo_me_09.JPG',array('style'=>'float:left; height: 80px;'));?>
				<?php echo $html->image('logoinet1.gif',array('style'=>'float: right; height: 70px;'));?>
</div>


<h2 style="clear:both;">Total de Instituciones de Educación Técnica Profesional ingresadas a la Base de Datos del Registro Federal de Instituciones de Educación Técnica Profesional (RFIETP) por ámbito de gestión según división político-territorial.</h2>

<div align="center">
<table width="80%" cellpadding = "0" cellspacing = "0" summary="" 
	style="border-left: 1px solid silver; border-top: 1px solid silver; font-size: 9pt;">

<tr>
	<th class="head_select" rowspan="2">División político-territorial</th>
	<th class="head_select" rowspan="1" colspan="2" style="">
	 	Ámbito de Gestión
	</th>
	<th class="head_select" rowspan="2">Total</th>
</tr>
<tr>
	<th class="head_select">Estatal</th>
	<th class="head_select">Privada</th>
</tr>

<!-- 
<tr class="altrow2">
	<?php foreach ($precols as $key=>$precol): 
		$colspan = ($key==1)? "colspan=2":"";	
		?>		
		<th <?php echo $colspan;?>><?php echo $precol;?></th>
	<?php endforeach; ?>
</tr>
<tr class="altrow2">
	<?php foreach ($cols as $col): ?>
	<th><?php echo $col;?></th>
	<?php endforeach; ?>
</tr>
 -->
 
<?php
$i = 0;
foreach ($queries as $query):
	$class = '';
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<?php 
	$style = ($query[0]['División político-territorial']== 'Total')?' style="background-color: #fff; color: #233e87; font-weight: bolder; border-top: 1px solid silver;':'style="';
	?>
	<tr<?php echo $class;?>>
	   <?php foreach($query[0] as $head=>$line): 
	    $style = $style." border-right: solid silver 1px; border-bottom: solid silver 1px;  ";
	   	if($head == 'División político-territorial') {
	   		$style1 = $style.'text-align:left;"';
	   	}
	   	else {
	   		$style1 = $style.'text-align:right;"';
	   	}
	   ?>
		<td <?php echo $style1?>>
			<?php echo (is_numeric($line))?number_format($line, 0, ',', '.'):$line; ?>
		</td>
		<?php endforeach; ?>
	</tr>
<?php endforeach; ?>
</table>
</div>

<br>

<p style="font-size: 9pt;"><u>Fuente</u>: 
INET-Ministerio de Educación. Unidad de información - 
Área Registro Federal de Instituciones de Educación Profesional. 
Información al <?php echo date("d-m-Y");?>
</p>


<p  style="font-size: 9pt;"><u>Nota</u>: 
<!--  
/**** ESTO POR AHORA NO VA !!! porque el cuadro lo recortamos esperando a la normalizacion de clases de instits ***/
Desde Diciembre de 2007 se adoptó un nuevo criterio de clasificación de las instituciones de ETP ingresadas al Registro 
Federal de Instituciones de ETP. En los casos que la institución oferta más de un nivel de enseñanza se la categorizó de 
acuerdo al mayor nivel que brinda, de forma de evitar contabilizar un mismo establecimiento más de una vez. De ahí las 
diferencias que pueden observarse con los informes trimestrales previamente presentados.<br>
 Se incluyeron por otra parte de forma diferenciada a las instituciones de ETP dependientes de Universidad Nacionales.
 -->
 Se incluyeron de forma diferenciada a las instituciones de ETP dependientes de Universidad Nacionales.
 </p>
 

<p style="text-align:center;display:block;margin-left:198px; float:left;">
	<a href="javascript:print();" class="btn-imprimir no-ver-para-imprimir">Imprimir</a>
	<?php //echo $html->link("Descargar", "/queries/contruye_excel/25", array("class"=>"btn-excel no-ver-para-imprimi"));?>
</p>

