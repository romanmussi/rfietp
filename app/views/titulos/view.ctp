<script type="text/javascript">
jQuery(document).ready(function() {

    jQuery("#resumenplanes").hide();

    jQuery("#resumenlink").click(function() {
        jQuery("#resumenplanes").toggle('slow');

        if (jQuery("#arrowlink").attr("src") == "<?php echo $html->url('/img'); ?>/arrow_down.png") {
            jQuery("#arrowlink").attr("src", "<?php echo $html->url('/img'); ?>/arrow_up.png");
        }
        else {
            jQuery("#arrowlink").attr("src", "<?php echo $html->url('/img'); ?>/arrow_down.png");
        }
    });
});
</script>
<div class="titulos view">
<h2><?php  __('Título de Referencia');?></h2>

	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Oferta'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $titulo['Oferta']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nombre'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $titulo['Titulo']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Marco de referencia'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo ($titulo['Titulo']['marco_ref']==1)? "Con marco de referencia":"Sin marco de referencia"; ?>
			&nbsp;
		</dd>
                
                <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Carrera prioritaria'); ?> <a href="#" onmouseout="jQuery('#help_es_bb').hide()" onmouseover="jQuery('#help_es_bb').show()">( * )</a></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo ($titulo['Titulo']['es_bb'])? "Si":"No"; ?>
			&nbsp;
		</dd>
	</dl>

<cite id="help_es_bb" style="display: none; position: absolute; background: white; border: 1px solid #000099; width: 400px; padding: 10px;">Las carreras prioritarias de RFIETP son tecnicaturas consideradas estratégicas 
    para el desarrollo económico y productivo del país, son títulos incorporados 
    al Programa Nacional de Becas Bicentenario para Carreras Científico Técnicas.</cite>

<h2><?php  __('Sectores/Subsectores');?></h2>
    <?php
    foreach ($titulo['SectoresTitulo'] as $sector) {
    ?>
        <div style="margin-top:6px;">
            <?php echo $sector['Sector']['name']; ?>
            <?php echo (!empty($sector['Subsector']['name']) ? '/ '.$sector['Subsector']['name'] : '' ); ?>
        </div>
    <?php
    }
    ?>
    <br />
    <div class="acl actions acl-editores acl-desarrolladores acl-administradores">
            <ul>
                    <li><?php echo $html->link(__('Editar Título', true), array('action'=>'edit', $titulo['Titulo']['id'])); ?> </li>
                    <li><?php echo $html->link(__('Eliminar Título', true), array('action'=>'delete', $titulo['Titulo']['id']), null, sprintf(__('Eliminar %s?', true), $titulo['Titulo']['name'])); ?> </li>
            </ul>
    </div>

<h2><?php  __('Instituciones con Planes de Estudio Asociados');?></h2>
    <div id="tituloPlanes">
        <?php echo $this->requestAction('/titulos/ajax_view_planes_asociados/'.$titulo['Titulo']['id'], array('return')); ?>
    </div>

<h2 id="resumenlink" style="cursor:pointer;"><?php  __('Resumen de Planes de Estudio'); ?> <?php echo $html->image('arrow_down.png', array('id'=>'arrowlink','align'=>'absmiddle')); ?></h2>
    <div id="resumenplanes">
    <?php
    foreach ($planesResumen as $planResumen) {
        $class = '';
        if ($i++ % 2 == 0) {
            $class = 'altrow';
        }
    ?>
    <ul>
        <li><?php echo $html->link($planResumen['Plan']['nombre']." (".$planResumen[0]['count'].")", array('controller'=>'planes','action'=>'index_x_nombre', urlencode($planResumen['Plan']['nombre']), $titulo['Titulo']['id'])); ?></li>
    </ul>
    <?php
    }
    ?>
    </div>
</div>
<br />
<div class="actions">
    <ul>
        <li><?php echo $html->link(__('Volver al Buscador de Títulos de Referencia', true), array('action'=>'index')); ?> </li>
    </ul>
</div>
