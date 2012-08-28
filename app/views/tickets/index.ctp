<?php
echo $javascript->link( 'jquery-ui-1.8.5.custom.min',false);
echo $html->css('smoothness/jquery-ui-1.8.6.custom', false);

$paginator->options(array('url' => $url_conditions));
?>
<div class="tickets index">
<h2><?php __('Pendientes de Actualización. Jurisdicción: ' . $jurisdiccion_name);?></h2>
<p  class="paginate_msg">
	<?php
	echo $paginator->counter(array(
	'format' => __('Página %page% de %pages%<br />Mostrando %current% registros de %count% encontrados, visualizando registros desde el nº %start%, hasta el %end%', true)
	));
	?>
</p>
<div id="tooltip" class="tooltip big"></div>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('Fecha Creación','Ticket.created');?></th>
	<th><?php echo $paginator->sort('Fecha Modificación','Ticket.modified');?></th>
	<th><?php echo $paginator->sort('Usuario','user.nombre');?></th>
	<th><?php echo $paginator->sort('Cue','Instit.cue');?></th>
	<th><?php echo $paginator->sort('Anexo','Instit.anexo');?></th>
	<th><?php echo  __('Nombre');?></th>
	<th class="actions">Ticket</th>
</tr>
<?php
$i = 0;
//debug($tickets);
foreach ($tickets as $ticket):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo date('d/m/y H:i',strtotime($ticket['Ticket']['created']));?>
		</td>
		<td>
			<?php echo date('d/m/y H:i',strtotime($ticket['Ticket']['modified']));?>
		</td>
		<td>
			<?php echo $ticket['User']['nombre'] . " " . $ticket['User']['apellido']; ?>
		</td>
		<td>
			<?php echo $ticket['Instit']['cue']; ?>
		</td>
		<td>
			<?php echo $ticket['Instit']['anexo']; ?>
		</td>
		<td>
		<?php 
			echo $html->link($ticket['Instit']['nombre_completo'],
							 '/instits/view/'.$ticket['Instit']['id']
			);
                        
		?> 
		
		</td>
		<td class="actions">
			<a href="<?= $html->url(array('controller'=> 'tickets', 'action'=>'edit/'.$ticket['Ticket']['id']))?>" onClick="window.open('<?= $html->url(array('controller'=> 'tickets', 'action'=>'edit/'.$ticket['Ticket']['id']))?>','_blank' , 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=310,height=390'); return false;">Editar</a>
                        <?php echo $html->link( $html->image('preview.png'),"/tickets/view/".$ticket['Ticket']['id'],array('class' => 'verTicket', 'escape' => false) ); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>


<div id="paginator_prev_next_links">
	<?php	
		echo $paginator->prev('<< Anterior ',null, null, array('class' => 'disabled'));
		echo " | ".$paginator->numbers(array('modulus'=>'9'))." | ";
		echo $paginator->next(' Siguiente >>', null, null, array('class' => 'disabled'));
	?> 
	</div>

<script language="JavaScript" type="text/javascript" defer="defer">
    jQuery(document).ready(function(){

        jQuery(".verTicket").click(function(){
            jQuery("#tooltip").html('... cargando').load(jQuery(this).attr("href"));
            jQuery("#tooltip").dialog({
                title: "Observación",
                modal:true
            });
            return false;
        });

        //para mantenerlo centrado
        jQuery(document).scroll(function(){
            var dia = jQuery("#tooltip")
            if(dia.is(":visible")){
                dia.dialog({modal:true, position:'center'});
            }
        });
    });

</script>