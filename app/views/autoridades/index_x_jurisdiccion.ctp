<div class="autoridades index">
    <br />
    <h2>
        <?php echo $jurisdiccion['Jurisdiccion']['name']; ?>
    </h2>

    <div class="tabs">
            <?php echo $this->element('menu_solapas_para_jurisdicciones', array('jurisdiccion_id' => $jurisdiccion['Jurisdiccion']['id'])); ?>

            <div class="tabs-content">
                    <?php
                    if(count($autoridades) > 0){
                        $i = 0;
                        foreach ($autoridades as $autoridad){
                                $class = null;
                                if ($i++ % 2 == 0) {
                                        $class = ' class="altrow"';
                                }
                        ?>
                            <dl><?php $i = 0; $class = ' class="altrow"';?>
                                <h2><?php echo $autoridad['Cargo']['nombre']?></h2>
                                <dt<?php if ($i % 2 == 0) echo $class;?>>Nombre</dt>
                                <dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $autoridad['Autoridad']['titulo'] . ' ' . $autoridad['Autoridad']['nombre'] .  ' ' . $autoridad['Autoridad']['apellido']; ?></dd>
                                
                                <!--<dt<?php if ($i % 2 == 0) echo $class;?>>Fecha Asunción</dt>
                                <dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo isNull($time->format('d/m/Y', $autoridad['Autoridad']['fecha_asuncion']),'<i>Sin Datos</i>') ;?></dd>-->
                                
                                <dt<?php if ($i % 2 == 0) echo $class;?>>Teléfono Institucional</dt>
                                <dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo isNull($autoridad['Autoridad']['telefono_institucional'] ,'<i>Sin Datos</i>')?></dd>
                                
                                <dt class="acl acl-administradores acl-desarrolladores acl-editores">Teléfono Personal</dt>
                                <dd class="acl acl-administradores acl-desarrolladores acl-editores"><?php echo isNull($autoridad['Autoridad']['telefono_personal'],'<i>Sin Datos</i>') ?></dd>
                                                           
                                <dt<?php if ($i % 2 == 0) echo $class;?>>Email Institucional</dt>
                                <dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo isNull($autoridad['Autoridad']['email_institucional'],'<i>Sin Datos</i>') ?></dd>
                                
                                <dt class="acl acl-administradores acl-desarrolladores acl-editores">Email Personal</dt>
                                <dd class="acl acl-administradores acl-desarrolladores acl-editores"><?php echo isNull($autoridad['Autoridad']['email_personal'] ,'<i>Sin Datos</i>')?></dd>
                                
                                <dt<?php if ($i % 2 == 0) echo $class;?>>Dirección</dt>
                                <dd<?php if ($i++ % 2 == 0) echo $class;?>>
                                    <?php
                                    if(!empty($autoridad['Autoridad']['direccion'])){
                                        if(!empty($autoridad['Autoridad']['localidad_id'])){
                                            echo $autoridad['Autoridad']['direccion'] . ' - ' . $autoridad['Autoridad']['Localidad']['name'] . ', ' . $autoridad['Autoridad']['Departamento']['name'] . ' ( ' . $autoridad['Autoridad']['Jurisdiccion']['name'] . ' )';
                                        }
                                        else{
                                            echo $autoridad['Autoridad']['direccion'] . ' - ' . $autoridad['Autoridad']['Departamento']['name'] . ' ( ' . $autoridad['Autoridad']['Jurisdiccion']['name'] . ' )';
                                        }
                                    }
                                    else{
                                        echo '<i>Sin Datos</i>';
                                    }
                                    ?>
                                </dd>
                            </dl>

                        <?php
                        }
                    }
                    else{
                    ?>
                        <br/>
                        <p>No existen datos del equipo técnico de la jurisdicción.</p>
                    <?php
                    }
                    ?>
                    <br />
            </div>
        </div>
</div>

<div class="actions">
	<ul>
                <li><?php echo $html->link(__('Agregar/Modificar Autoridades', true), array('action' => 'index',$jurisdiccion_id), array('class'=>'acl acl-administradores acl-desarrolladores acl-editores')); ?></li>
	</ul>
</div>
