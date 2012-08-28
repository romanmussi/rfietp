<script type="text/javascript">
    init("<?php echo $html->url('/img/close.png')?>");
</script>

<? echo $javascript->link('jquery.blockUI');?>
<h1><?php  __('Oferta Educativa');?></h1>

<?php 
	echo $this->element('div_observaciones', array("observacion" => $plan['Plan']['observacion']));
?>

<?
$anexo = ($instit['anexo']<10)?'0'.$instit['anexo']:$instit['anexo'];
$cue_instit = $instit['cue'].$anexo;
?>
<h2><?php echo $cue_instit." - ".$instit['nombre_completo']; ?></h2>



<div class="planes view">
	<dl><?php $i = 0; $class = ' class="altrow"';?>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Oferta'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?= $plan['Oferta']['name']; ?>
			&nbsp;
		</dd>
		
                <?php if ($plan['Plan']['oferta_id'] == SEC_TEC_ID && !empty($plan['EstructuraPlan']['Etapa'])) { ?>
                <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Etapa'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?= $plan['EstructuraPlan']['Etapa']['name']; ?>
			&nbsp;
		</dd>
                <?php }?>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Normativa'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $plan['Plan']['norma']; ?>
			&nbsp;
		</dd>

                <? if ( $plan['Titulo']['name'] ) { ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>>
                    <?php __('Título de Referencia'); ?>
                    
                </dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
                  <?php echo $plan['Titulo']['name']; ?>
                  <?php
                    echo ($plan['Titulo']['marco_ref'])?
                        $html->image('certificado.png', array(
                            'height'=>'17px',
                            'align'=>'absmiddle',
                            'style'=>'botom: -5px;',
                            'alt'=>'Con Marco de Referencia',
                            'title'=>'Título con Marco de Referencia'))
                        :'';
                    ?>
                <? if ($plan['Titulo']['marco_ref']) { ?>
                    <span style="font-size:10px; font-style:italic;">(con Marco de Referencia)</span>
                <? } ?>
			&nbsp;
		</dd>
                <? } ?>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nombre'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $plan['Plan']['nombre']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Perfil'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $plan['Plan']['perfil']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sector/Subsector'); ?></dt>
                <dd>
                    <?php
                        $i = 0;
                        if (!empty($plan['Titulo']['SectoresTitulo'])) {
                            $size = count($plan['Titulo']['SectoresTitulo']);
                        }
                        
                        if(isset($plan['Titulo']['SectoresTitulo'])){
                            foreach($plan['Titulo']['SectoresTitulo'] as $sector){
                                if($size == 1){
                    ?>
                        <?php echo (($sector['Sector']['name']) . (($sector['Subsector'])?(" / " . $sector['Subsector']['name']   ):""))?>
                    <?php
                                }
                                else{
                    ?>
                        <div style="<?php echo ($i == 0)? 'font-weight:bold':''?>"><?php echo (($sector['Sector']['name']) . (($sector['Subsector'])?(" / " . $sector['Subsector']['name']   ):""))?></div>
                    <?php       }
                            $i++;
                            }
                        }
                        else{
                    ?>
                        -
                        <?php
                        }
                        ?>
                    &nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Estado'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $plan['PlanEstado']['nombre']; ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Turno'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $plan['PlanTurno']['nombre']; ?>
			&nbsp;
		</dd>


		<?php if ($plan['Plan']['oferta_id'] != FP_ID): //muestro solo la durecion si no es FP?>
			<? if((($plan['Plan']['duracion_hs']+$plan['Plan']['duracion_semanas']+$plan['Plan']['duracion_anios'])>0)){ ?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Duración del plan:'); ?></dt>
			<dd<?php echo $class;?>>
				&nbsp;
			</dd>
			<? } ?>
			
			<? if(($plan['Plan']['duracion_hs']>0)){ ?>
				<dt<?php echo $class;?>><?php __(' - Horas'); ?></dt>
				<dd<?php echo $class;?>>
					<?php echo $plan['Plan']['duracion_hs']; ?>
					&nbsp;
				</dd>
			<? } ?>
			
			<? if ($plan['Plan']['duracion_semanas']>0){ ?>
				<dt<?php $class;?>><?php __(' - Semanas'); ?></dt>
				<dd<?php echo $class;?>>
					<?php echo $plan['Plan']['duracion_semanas']; ?>
					&nbsp;
				</dd>
			<? } ?>
			
			<? if ($plan['Plan']['duracion_anios']>0){ ?>
				<dt<?php $class;?>><?php __(' - Años'); ?></dt>
				<dd<?php echo $class;?>>
					<?php echo $plan['Plan']['duracion_anios']; ?>
					&nbsp;
				</dd>
			<? } ?>
		<?php endif ?>
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Alta'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<? echo $plan['Plan']['ciclo_alta']?$plan['Plan']['ciclo_alta']:''; ?>
			&nbsp;
		</dd>
                <?php
                if ($session->read('User.group_alias') == 'desarrolladores' ||
                    $session->read('User.group_alias') == 'editores' ||
                    $session->read('User.group_alias') == 'administradores') {
                ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modificación'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<? echo $plan['Plan']['modified']?date("d/m/Y",strtotime($plan['Plan']['modified'])):''; ?>
		</dd>
                <?php
                }
                ?>

	</dl>
</div>

<div class="acl actions acl-editores acl-administradores acl-desarrolladores">
	<ul>
		<li><?php echo $html->link(__('Editar Oferta', true), array('action'=>'edit', $plan['Plan']['id'])); ?> </li>
		<li><?php echo $html->link(__('Eliminar Oferta', true), array('controller'=> 'planes', 'action'=>'delete', $plan['Plan']['id']), null, sprintf(__('Seguro que desea eliminar el Plan "%s"?', true), $plan['Plan']['nombre'])); ?></li>
	</ul>
</div>

<h2>Datos Históricos de Matrícula</h2>
	<?  if(isset($plan_tiene_estructura_valida))
            echo ($plan_tiene_estructura_valida !== true)?'<p class="acl acl-editores acl-administradores acl-desarrolladores error">La estructura del Plan es inválida, ejecute el depurador'.$html->link(' haciendo click aquí.','/depuradorPlanes/index/'.$plan['Plan']['instit_id']).'</p>':'';

            /**
             *  Esto renderiza el Element de acuerdo a lo que el controlador diga.
             *  SI el plan es FP, va agenerar una tabla para mostrar FP
             *  Si el plan es otro tipo, renderizará la tabla normal
             */
            echo $this->renderElement($planes_view_tabla['element'], $planes_view_tabla['options']);
	?>

<div id="nueva-data" style="display:none"></div>


<div class="acl actions acl-editores acl-desarrolladores acl-administradores">
    <ul>
<?php //echo $html->link(__('Agregar Nuevo Año', true), array('controller'=> 'anios', 'action'=>'add/'.$plan['Plan']['id']));?>
        <li>
            <?php
            $action = ($plan['Plan']['oferta_id'] == SEC_TEC_ID) ? 'addSecTec' : 'add';
            echo $html->link(
                        'Agregar Datos',
                        "/anios/$action/".$plan['Plan']['id'].'/'.$plan['Plan']['duracion_anios'],
                        array('class'=>'ajax-link')
                    );
            ?>
        </li>
    </ul>
</div>

