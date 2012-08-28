<?php
    /* @var $ajax AjaxHelper */
    $ajax;
    /* @var $form FormHelper */
    $form;
    /* @var $html HtmlHelper */
    $html;
    
echo $html->css('planes/view_fp');
echo $html->css('jquery.loadmask');

$divOfertaFP = 'tabs-oferta-fp-'.$ciclo;
$divSpinnerId = "spinner-fp-$ciclo";
$divOfertaContainer = 'oferta-contanier-'.$ciclo;

$paginator->options(array(
    'url'     => $url_conditions,
    'update'  => $divOfertaFP,
    'indicator' => $divSpinnerId,
    ));
?>
<div id="<?php echo $divOfertaFP; ?>" class="oferta-contanier">
    <?php
    if (empty($planes) && !$es_una_busqueda) {
    ?>
    <p class="msg-atencion"><br /><br />La Institución no presenta actualizaciones para este año</p>
    <? 
    }
    else{
        echo $form->create(
                'Plan',
                array(
                    'id'=>'formPlanesViewFp',
                    'url' => '/planes/view_fp/'.$instit_id.'/'.$oferta_id.'/'.$ciclo,
                    'onsubmit' => "return buscarPlanes(this, '$divOfertaFP');",
                    'update' => $divOfertaFP,
                    )
                );
        $busca_plan = !empty($this->data["Plan"]["nombre"]);
        $busca_sector = !empty($this->data["Sector"]["id"]);
        echo $form->input('Plan.nombre', array('label'=>'Nombre', "class"=>$busca_plan?"buscado":""));
        echo $form->input('Sector.id', array('label'=>'Sector',  'options'=> $sectores, 'empty'=>'Todos', "class"=>$busca_sector?"buscado":""));
        echo $form->end('Buscar');

        $sort = '';
       if(isset($this->passedArgs['sort'])){
               $sort = $this->passedArgs['sort'];
       }
       ?>

    <!--
    <h2>Ordenar Por:</h2>
    <ul class="lista_horizontal">
        <li class="<? echo ($sort == 'Plan.nombre')?'marcada':'';?>"><?php echo $paginator->sort('Nombre','Plan.nombre');?></li>
        <li class="<? echo ($sort == 'Sector.name')?'marcada':'';?>"><?php echo $paginator->sort('Sector','Sector.name');?></li>
    </ul>
    -->

    <?php
    if (empty($planes) && $es_una_busqueda) {
    ?>
    <p class="msg-atencion" style="height: 200px"><br /><br />Búsqueda sin resultados</p>
    <?
    }
    ?>
    
    <div class="clear"></div>
    <br>
    <div class="buscador-result">
    <?php
    $i = 0;
    if (!empty($planes)) {
        
        foreach ($planes as $plan):
            //debug($plan);
            $class = '';
            if ($i++ % 2 == 0) {
                $class = 'altrow';
            }
            $ciclo_plan = '';
            $hs_taller = '';
            if ($ciclo == 0) {
                if (!empty($plan['Anio'][0]['ciclo_id'])) {
                    $ciclo_plan =  (!empty($plan['Anio'][0]['ciclo_id'])? $plan['Anio'][0]['ciclo_id']:"") ;
                }                
            }
            if (!empty($plan['Anio'][0]['hs_taller'])) {
                $hs_taller =  $plan['Anio'][0]['hs_taller'];
            }

            echo $this->element('planes/plan_resumen_para_listado', array(
                'class' => $class,
                'plan'  => $plan,
                'ciclo' => $ciclo_plan,
                'hstaller' => $hs_taller,
            ));            
         endforeach;
    ?>
    <div class="navigation"></div>

    <div class="paginator_prev_next_links">
            <?php
            if($paginator->numbers()){
                    echo $paginator->prev('« Anterior ',null, null, array('class' => 'disabled'));
                    echo " | ".$paginator->numbers(array('modulus'=>'9'))." | ";
                    echo $paginator->next(' Siguiente »', null, null, array('class' => 'disabled'));
            }
            ?>
    </div>

    <div id="<?php echo $divSpinnerId ?>" style="display: none; text-align: center; margin-top:10px;">
    <?php
    echo $html->image('loadercircle16x16.gif')
    ?>
    </div>
    
    <?php
            }
    ?>
    </div>
    <?php
    }
    ?>
</div>


