<?php
echo $html->css('smoothness/jquery-ui-1.8.6.custom', false);
?>
<h1>Depurador de Tipo de institución y Relación con ETP</h1>

<div id="mostrar-help" class="help-text">
    <h2>Ayuda del depurador</h2>
    
    <p>
        Este depurador permite identificar rápidamente aquellas instituciones que han modificado 
        recientemente su oferta educativa y debe ser evaluadas nuevamente respecto de su <cite>Tipo de Institución </cite>
        (Secundario, Superior, Formación Profesional, Con Itinerario Formativo) y su <cite>Relación con la Educación 
        Técnico Profesional</cite> (Institución de ETP ó Institución con Programa de ETP).
    </p>
    <p>
        Recuérdese que el <cite>Tipo de Institución</cite> se determina tomando en cuenta la oferta educativa. 
        Por ejemplo, si una institución dicta sólo cursos de formación profesional entonces su tipo es 
        <cite>"Formación Profesional"</cite>. Si ofrece educación técnica secundaria y además cursos de formación profesional 
        entonces su tipo es <cite>"Secundario"</cite>. Las combinaciones y posibilidades son complejas y por eso la categorización 
        requiere de una evaluación personalizada.
    </p>
    <p>
        Este depurador permite la reevaluación y confirmación de aquellas instituciones cuya oferta haya cambiado 
        recientemente de manera significativa (Puede ser un Secundario que ha incorporado formación profesional ó 
        formación superior ó un Insituto de Formación Profesional que ha incorporado educación secundaria o superior, 
        entre otros casos).
    </p>
</div>

<?php if ( $falta_depurar ) { ?>

<div class="instits form">
<h3>Editando Institución de <?php echo $this->data['Jurisdiccion']['name']?>
    <span style="float: right; color: red">Faltan depurar: <?php echo $falta_depurar?></span>
</h3>
<h4>
    <br />
    Nombre: <?= $html->link($this->data['Instit']['nombre_completo'],'/instits/view/'.$this->data['Instit']['id']);?> <br> CUE: <?= $this->data['Instit']['cue']*100+$this->data['Instit']['anexo'] ?> (id:<?php echo $this->data['Instit']['id']?>)
</h4>


<h2>Planes</h2>

<table>
    <thead>
    <th>Nombre del Plan</th>
    <th>Oferta</th>
    <th>ver más</th>
    </thead>
    
<?php foreach ($planes as $p){ ?>
<?php $div_id = "plan-id-".$p['Plan']['id']; ?>
    <tr>
        <td style="text-align: left">
            <?php echo $html->link($p['Plan']['nombre'],'/Planes/view/'.$p['Plan']['id'], array('target' => '_blank'))?>
            <div id="<? echo $div_id?>" style="display: none">
                    <?php echo $html->link('Ir al Plan','/Planes/view/'.$p['Plan']['id'], array('target' => '_blank', 'style' => 'color: blue'))?>
                    <dl>
                            <dt>Sectores:</dt>				
                                <dd>
                                    <?php 
                                        if(!empty($p['Titulo']['SectoresTitulo'])){
                                            $primero = true;
                                            foreach ($p['Titulo']['SectoresTitulo'] as $sec) { 
                                                if ( !$primero ) {
                                                    echo ", ";
                                                }
                                                $primero = false;
                                                echo $sec['Sector']['name'];
                                                if (!empty($sec['Subsector']['name'])) {
                                                    echo ' / '.$sec['Subsector']['name'];
                                                }
                                            }
                                        }else{
                                            echo "-";
                                        }
                                        ?>
                                    &nbsp;</dd>
                            <dt>Duración:</dt>				
                                <dd><?php echo " - ";?>&nbsp;</dd>
                            <dt>&nbsp;&nbsp;-- Horas:</dt>	
                                <dd><?php echo $p['Plan']['duracion_hs'];?>&nbsp;</dd>
                            <dt>&nbsp;&nbsp;-- Semanas:</dt>
                                <dd><?php echo $p['Plan']['duracion_semanas'];?>&nbsp;</dd>
                            <dt>&nbsp;&nbsp;-- Años:</dt>       
                                <dd><?php echo $p['Plan']['duracion_anios'];?>&nbsp;</dd>
                            <dt>Matrícula:</dt>				
                                <dd><?php echo $p['Plan']['matricula']?>&nbsp;</dd>
                            <dt>Observación:</dt>			
                                <dd><?php echo $p['Plan']['observacion']?>&nbsp;</dd>
                            <dt>Alta:</dt>					
                                <dd><?php echo date('d/m/Y',strtotime($p['Plan']['created']))?>&nbsp;</dd>
                            <dt>Modificación:</dt>			
                                <dd><?php echo date('d/m/Y',strtotime($p['Plan']['modified']))?>&nbsp;</dd>

                            <?php
                            $ciclos = array();
                                    foreach ($p['Anio'] as $anio):
                                            $ciclos[$anio['ciclo_id']] = $anio['ciclo_id'];
                                    endforeach;

                                    $texto = '';
                                    foreach ($ciclos as $c):
                                            $texto .= ($texto?" - ":"").$c;
                                    endforeach;
                            ?>
                            <dt>Ciclos con información</dt>
                                <dd><?php echo $texto?$texto:"-" ?>&nbsp;</dd>

                    </dl> 
            </div>
        </td>
        <td  style="color: OrangeRed; font-size: 12px;">
        <?php echo $p['Oferta']['name']?>
        </td>
        <td>
            <a style="font-size: 10px;" href="#<? echo $div_id?>" onclick="jQuery('#<? echo $div_id?>').dialog({width: 500, height: 380,modal: true, title: '<?php echo $p['Plan']['nombre']?>'}); return false;">Más info del Plan</a>
        </td>	
    </tr>
<?php }?>
        </table>


<?php echo $form->create('Instit',array('url'=>'/depuradores/clases_y_etp','id'=>'InstitDepurarForm'));?>
	<?php
		echo $form->input('id');	
				
		echo $form->input('claseinstit_id',array('label'=>'Seleccione Tipo de Institución de ETP'));
		
		echo $form->input('etp_estado_id',array('label'=>'Seleccione Relación de ETP'));

		/*echo $form->input('tipoinstit_id',array('label'=>'Seleccione Tipo de Establecimiento',
												'after'=>'<br>Este combo lo incorporamos porque Ramiro dijo que aún faltaban depurar alguos tipos de establecimientos',
												  'type'=>'select',
												  'options'=>$tipoinstit
		));
     	*/
         /********************************************************************************/
        

	?>
	<?php echo $form->submit('Guardar', array(
                                     'style'=>' display: block;
                                                width: 100px;
                                                vertical-align: bottom;
                                                margin-top: 7px;
                                                margin-left: 4px;
                                                border-color: #CEE3F6;
                                                background-color: #DBEBF6;
                                                color: #045FB4;
                                                font-weight: bold;'
                                    ));
        ?>
<?php echo $form->end();?>

</div>


<?php } else { ?>

<div>
    <p style="color: green; font-size: large; text-align: center; font-weight: bold; margin-top: 20px;}">
        No hay nada que depurar</h1>
</div>
<?php } ?>