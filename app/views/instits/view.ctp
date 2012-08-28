<?php
    echo $javascript->link('zeroclipboard/ZeroClipboard.js');
?>
<div class="instits view">
    <div id="escuela_estado" class="<? echo $instit['Instit']['activo']? 'instit_activa':'instit_inactiva';?>"><? echo $instit['Instit']['activo']? 'Institución Ingresada al RFIETP':'Institución NO Ingresada al RFIETP';?></div>
    <?
    $cue_instit = ($instit['Instit']['cue']*100)+$instit['Instit']['anexo'];
    ?>
    <h2><?= $cue_instit ?>
         - <?= $instit['Instit']['nombre_completo']?>
    </h2>
    <div class="tabs">
        <?php 
        echo $this->element('menu_solapas_para_instit', array(
                                            'instit_id' => $instit['Instit']['id'], 
                                            'instit_activo' => $instit['Instit']['activo'], 
                                            'ultimo_ciclo_actualizado' => $ultimo_ciclo_actualizado));
        ?>
        
            <div id="d_clip_button" class="my_clip_button2"></div>
            <input id="infoToCopy" type="hidden" value="<?= ($instit['Instit']['cue']*100)+$instit['Instit']['anexo'] . ' - ' . $instit['Instit']['nombre_completo'] . ' - ' . $instit['Instit']['direccion'] . ' - ' . $instit['Departamento']['name'] . ' - ' . $instit['Localidad']['name'] ?> "/>
            
            <div class="tabs-content">
                    
                    <?php
                    // por ahora no quiero que se muestre porque viene sucio este campo
                    //echo $this->element('div_observaciones', array("observacion" => $instit['Instit']['observacion']));
                    ?>


                    <?php
                    /*---********************************
                         *
                         * 			HISTORIAL DE CUES
                         *
                         ********************************----*/
                    ?><?php if(count($instit['HistorialCue'])>0):?>
                    <p class="cues-anteriores">
                            <?php echo $html->image('cambio_cue.gif')?>
                        <span class="cues-anteriores-title">
                                <?php if(count($instit['HistorialCue']) == 1):?>
                                                                  CUE anterior:
                                <?php else: echo "CUEs anteriores:";?>
                                <?php endif;?>
                        </span>
                        <span class="cues-anteriores-text">
                                <?php $primero = true;?>
                                <?php foreach($instit['HistorialCue'] as $cueant):?>
                                    <?php 	echo ($primero)?"<br>":",";
                                    $primero = false;?>
                                    <?php 	$fechamod = "<cite>(utilizado hasta el: ".date("d/m/y",strtotime($cueant['created'])).")</cite>";?>
                                    <?php   $observacion = $cueant['observaciones'];?>
                                    <?php 	echo "<b title='$observacion' class='msg-info'>".($cueant['cue']*100+$cueant['anexo'])." ".$fechamod."</b>";?>
                    <?php endforeach;?>
                        </span>
                    </p>
                <?php endif;?>





                    <h2>Datos de Institución</h2>
                    <?php if($con_programa_de_etp) {
                        echo "<p class='msg-atencion'>$relacion_etp</p>";
                }?>
                    <dl>

                        <?php
                if(!$con_programa_de_etp) {	?>
                        <b>
                            &nbsp;<?php echo $relacion_etp; ?>

                        </b>
                    <?php }?>

                        <?php
                if($instit['Instit']['claseinstit_id']) {	?>
                        <dt><?php __('Tipo de Institución'); ?></dt>
                        <dd>
	                    <?php 
	                      if(!empty($instit['Claseinstit']['name'])){
	                            echo $instit['Claseinstit']['name'];
	                      }else{
	                	        echo "<i>No declarado</i>";
	                      } ?>
                        </dd>
                    <?php }?>


                        <? if($instit['Orientacion']['name']) {?>
                          <dt ><?php __('Orientación'); ?></dt>
                        <dd>
	                    <?php 
	                      if(!empty($instit['Orientacion']['name'])){
	                            echo $instit['Orientacion']['name'];
	                      }else{
	                	        echo "<i>No declarado</i>";
	                      } ?>
                        </dd>
                        <? } ?>
                        <? if($instit['Modalidad']['name']) {?>
                          <dt ><?php __('Modalidad'); ?></dt>
                        <dd>
	                    <?php 
	                      if(!empty($instit['Modalidad']['name'])){
	                            echo $instit['Modalidad']['name'];
	                      }else{
	                	        echo "<i>No declarado</i>";
	                      } ?>
                        </dd>
                        <? } ?>
                        <dt ><?php __('Ámbito de Gestión'); ?></dt>
                        <dd>
	                    <?php 
	                      if(!empty($instit['Gestion']['name'])){
	                            echo $instit['Gestion']['name'];
	                      }else{
	                	        echo "<i>No declarado</i>";
	                      } ?>
                        </dd>
                        <dt><?php __('Tipo de Dependencia'); ?></dt>
                        <dd>
	                    <?php 
	                      if(!empty($instit['Dependencia']['name'])){
	                            echo $instit['Dependencia']['name'];
	                      }else{
	                	        echo "<i>No declarado</i>";
	                      } ?>
                        </dd>
                <? if($instit['Instit']['nombre_dep']): ?>
                        <dt><?php __('Nombre de la Dependencia'); ?></dt>
                        <dd>
	                    <?php 
	                      if(!empty($instit['Instit']['nombre_dep'])){
	                            echo $instit['Instit']['nombre_dep'];
	                      }else{
	                	        echo "<i>No declarado</i>";
	                      } ?>                       
                        </dd>
                <? endif; ?>
                        <dt><?php __('Jurisdicción'); ?></dt>
                        <dd>
	                    <?php 
	                      if(!empty($instit['Jurisdiccion']['name'])){
	                            echo $instit['Jurisdiccion']['name'];
	                      }else{
	                	        echo "<i>No declarado</i>";
	                      } ?>                   
                        </dd>
                        <dt><?php __('Departamento'); ?></dt>
                        <dd>
	                    <?php 
	                      if(!empty($instit['Departamento']['name'])){
	                            echo $instit['Departamento']['name'];
	                      }else{
	                	        echo "<i>No declarado</i>";
	                      } ?>                   
                        </dd>
                        <dt><?php __('Localidad'); ?></dt>
                        <dd>
	                    <?php 
	                      if(!empty($instit['Localidad']['name'])){
	                            echo $instit['Localidad']['name'];
	                      }else{
	                	        echo "<i>No declarado</i>";
	                      } ?>                   
                        </dd>
                        <dt><?php __('Barrio/Pueblo/Comuna'); ?></dt>
                        <dd>
	                    <?php 
	                      if(!empty($instit['Instit']['lugar'])){
	                            echo $instit['Instit']['lugar'];
	                      }else{
	                	        echo "<i>No declarado</i>";
	                      } ?>                   
                        </dd>
                        <dt><?php __('Domicilio'); ?></dt>
                        <dd>
	                    <?php 
	                      if(!empty($instit['Instit']['direccion'])){
	                            echo $instit['Instit']['direccion'];
	                      }else{
	                	        echo "<i>No declarado</i>";
	                      } ?>                   
                        </dd>
                        <dt><?php __('Código Postal'); ?></dt>
                        <dd>
	                    <?php 
	                      if(!empty($instit['Instit']['cp'])){
	                            echo $instit['Instit']['cp'];
	                      }else{
	                	        echo "<i>No declarado</i>";
	                      } ?>                   
                        </dd>
                <?php if($instit['Instit']['telefono']): ?>
                        <dt><?php __('Teléfono'); ?></dt>
                        <dd>
	                    <?php 
	                      if(!empty($instit['Instit']['telefono'])){
	                            echo $instit['Instit']['telefono'];
	                      }else{
	                	        echo "<i>No declarado</i>";
	                      } ?>                       
                        </dd>
                <?php endif;?>
                <?php if($instit['Instit']['telefono_alternativo']): ?>
                        <dt><?php __('Teléfono Alternativo'); ?></dt>
                        <dd>
	                    <?php 
	                      if(!empty($instit['Instit']['telefono_alternativo'])){
	                            echo $instit['Instit']['telefono_alternativo'];
	                      }else{
	                	        echo "<i>No declarado</i>";
	                      } ?>    
                        </dd>
                <?php endif;?>
                <?php if($instit['Instit']['mail']): ?>
                        <dt><?php __('E-Mail'); ?></dt>
                        <dd>
	                    <?php 
	                      if(!empty($instit['Instit']['mail'])){
	                            echo $instit['Instit']['mail'];
	                      }else{
	                	        echo "<i>No declarado</i>";
	                      } ?>                        
                        </dd>
                <?php endif;?>
                <?php if($instit['Instit']['mail_alternativo']): ?>
                        <dt><?php __('E-Mail Alternativo'); ?></dt>
                        <dd>
	                    <?php 
	                      if(!empty($instit['Instit']['mail_alternativo'])){
	                            echo $instit['Instit']['mail_alternativo'];
	                      }else{
	                	        echo "<i>No declarado</i>";
	                      } ?>
                        </dd>
                <?php endif;?>
                <?php if($instit['Instit']['web']): ?>
                        <dt><?php __('Web'); ?></dt>
                        <dd>
	                    <?php 
	                      if(!empty($instit['Instit']['web'])){
	                            echo $instit['Instit']['web'];
	                      }else{
	                	        echo "<i>No declarado</i>";
	                      } ?>
                        </dd>
                <?php endif;?>
                        <dt><?php __('Año de Creación'); ?></dt>
                        <dd>
                <?php echo ($instit['Instit']['anio_creacion']==0)?'<i>No declarado</i>':$instit['Instit']['anio_creacion']; ?>
                        </dd>
                    </dl>
                    <H2>Datos Director</H2>
                    <dl>
                        <dt><?php __('Nombre y Apellido'); ?></dt>
                        <dd>
                        <?php 
                          if(!empty( $instit['Instit']['dir_nombre'] )){
                                echo $instit['Instit']['dir_nombre']; 
                          }else{
                	            echo "<i>No declarado</i>";
                          } ?>
                        </dd>
                        <dt><?php __('Tipo y Nº de Documento'); ?></dt>
                        <dd>
                            <?php
                            if($instit['Instit']['dir_nrodoc']>0) {
                                echo ' '.$instit['Instit']['dir_tipodoc_name'];
                                echo ' '.$instit['Instit']['dir_nrodoc'];
                            }else{
                	            echo "<i>No declarado</i>";
                            } ?>
                        </dd>

                        <dt><?php __('Teléfono'); ?></dt>
                        <dd>
		                <?php
  		                  if(!empty($instit['Instit']['dir_telefono'])){ 
		                	    echo $instit['Instit']['dir_telefono'];}
		                   else{
		                	    echo "<i>No declarado</i>";
		                  } ?>
                        </dd>

                        <dt><?php __('E-Mail'); ?></dt>
                        <dd>
                        <?php 
                          if(!empty($instit['Instit']['dir_mail'])){
                                echo $instit['Instit']['dir_mail'];}
                          else{
                	            echo "<i>No declarado</i>";
                          } ?>
                        </dd>

                    </dl>

                    <H2>Datos Vice Director</H2>
                    <dl>
                        <dt><?php __('Nombre y Apellido'); ?></dt>
                        <dd>
                        <?php 
                          if(!empty( $instit['Instit']['vice_nombre'] )){
                                echo $instit['Instit']['vice_nombre']; }
                          else {
                      	        echo "<i>No declarado</i>";
                          } ?>
                        </dd>
                        <dt><?php __('Tipo y Nº de Documento'); ?></dt>
                        <dd>
                            <?
                            if($instit['Instit']['vice_nrodoc']>0) {
                                echo ' '.$instit['Instit']['vice_tipodoc_name'];
                                echo ' '.$instit['Instit']['vice_nrodoc'];
                            }else {
                      	        echo "<i>No declarado</i>";
                            }
                            ?>
                        </dd>
                    </dl>

                    <H2>Datos Adicionales</H2>
                    <dl>
                        

                        <?php if(strlen($instit['Instit']['observacion'])){?>
                        <dt><?php __('Observación'); ?></dt>
                        <dd>
                        <?php 
                          if(!empty($instit['Instit']['observacion'])){
                                echo $instit['Instit']['observacion']; 
                          }else {
                      	        echo "<i>No declarado</i>";
                          } ?>
                        </dd>
                        <?php
                        }
                        ?>
                        <dt><?php __('Alta'); ?></dt>
                        <dd>
                        <?php echo ($instit['Instit']['ciclo_alta']>0)?$instit['Instit']['ciclo_alta']:'<i>No declarado</i>'; ?>
                        </dd>

                        <?php
                        if ($session->read('User.group_alias') == 'desarrolladores' ||
                            $session->read('User.group_alias') == 'editores' ||
                            $session->read('User.group_alias') == 'administradores') {
                        ?>
                        <dt><?php __('Modificación'); ?></dt>
                        <dd>
                        <?php 
                            echo ($instit['Instit']['modified']>0)?date("d/m/Y",strtotime($instit['Instit']['modified'])):'<i>Los datos nunca fueron modificados para esta institución</i>';
                        ?>
                        </dd>
                        <? } ?>
                    </dl>
                    <br />

                    <div class="actions">
                        <ul class="acl acl-editores acl-administradores acl-desarrolladores">
                            <li><?php echo $html->link(__('Editar Institución', true), array('action'=>'edit', $instit['Instit']['id'])); ?> </li>
                        </ul>
                        <ul class="acl acl-desarrolladores">
                            <li><?php echo $html->link(__('Eliminar Institución', true), array('action'=>'delete', $instit['Instit']['id']), null, sprintf(__('¿Seguro que desea eliminar la institución? CUE: "%s"', true), $instit['Instit']['cue']. "0".$instit['Instit']['anexo'])); ?></li>
                            <li><?php echo $html->link('ABM CUE Histórico', array('controller'=>'HistorialCues','action'=>'index', $instit['Instit']['id'])); ?></li>
                        </ul>
                    </div>

            </div>
    </div>    
</div>
<script language="JavaScript" type="text/javascript" defer="defer">
    jQuery(document).ready(function(){
        var clip = new ZeroClipboard.Client();

        ZeroClipboard.setMoviePath('<?php echo $html->url("/js/zeroclipboard/ZeroClipboard10.swf"); ?>');

        clip.setText( '' ); // will be set later on mouseDown
        clip.setHandCursor( true );
        clip.addEventListener( 'mouseDown', function(client) {
           client.setText(jQuery("#infoToCopy").val());
        } );

        clip.glue( 'd_clip_button' );
     })
</script>

