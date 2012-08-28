<h1>Descargas</h1>

<?php
echo $javascript->link('jquery-ui-1.8.5.custom.min.js',false);
echo $html->css('ajaxtabs.css',null, false);
echo $html->css('planes/ui_tabs.css',null, false);
echo $html->css('smoothness/jquery-ui-1.8.6.custom', false);
//echo $html->css('smoothness/jquery-ui-inet.custom.css',null, false);
?>

<style type="text/css">
    .tooltip{
        font-size:13px;
        text-align:center;
        padding-top:30px;
    }    
</style>

<script type="text/javascript">
    jQuery(document).ready(function(){
        
        
        jQuery(".acordiones").accordion({"autoHeight": false});

        jQuery('.acordion .head').click(function() {
		$(this).next().toggle('slow');
		return false;
	}).next().hide();

        jQuery('.js-tabs-ofertas').tabs();

        jQuery('.descarga_mas_info').click(function(){
            var dialog = jQuery('<div id="create_dialog"></div>')
                .html('...Cargando vista previa de la descarga')
		        .dialog({
                    width: 750,
                    height:400,
                    position: 'center',
                    zIndex: 3999,
		            title: 'Vista Previa de la  Descarga',
                    beforeclose: function(event, ui) {
                        jQuery("#create_dialog").remove();
                }
            });

            jQuery.ajax({
              url: jQuery(this).find('a').attr('href'),
              cache: false,
              success: function(data) {
                    dialog.html(data);
              }
            });
            return false;
        });        

        jQuery('.descarga_editar_descripcion a').click(function(){

            
            jQuery("<div id='edit_description_dialog'>Cargando...</div>").dialog({
                title: "Editar Descripción",
                width: 600,
                height:300,
                position: 'center',
                beforeclose: function(event, ui) {
                        jQuery("#edit_description_dialog").remove();
                }
            });
            
            jQuery.ajax({
              url: jQuery(this).attr('href'),
              cache: false,
              success: function(data) {
                    console.debug(data);
                    jQuery('#edit_description_dialog').html(data);
              }, 
              error: function(data) {
                    jQuery('#edit_description_dialog').dialog("close");
              }
            });
            return false;
        })

        jQuery(".tooltip_button[title]").tooltip({
            effect: 'slide',
            offset:[15,10]
        });

    });

</script>
<div>
    <div class="js-tabs-ofertas tabs">
        <ul id="ofertas-tabs" class="horizontal-shadetabs">
            <?php 
            foreach ($categorias as $c) {
                echo '<li>
                <a id="htab-'.$c.'"
                   href="#ver-oferta-'.$c.'">
                   '.$c.'
                </a>
            </li>';
            }
            ?>
        </ul>

        <?php foreach ($queries as $k=>$querin) {?>
        <div id="ver-oferta-<?php echo $k ?>" class="descargas-container" style="">
            <div class="acordiones">
            <?php
            foreach ($querin as $q):
            $i = 0;
            ?>
                    <h3>
                        <a href="#"><?php echo 'Nº' .$q['Query']['id'] . ' - '. $q['Query']['name']?></a>
                    </h3>
                    <div>
                        <div style="border:3px solid #F0F7FC;background-color: #EDEAEA;margin: 1px; padding: 2px;float:right">
                            <span class="descarga_mas_info">
                                <? echo $html->link($html->image("preview.png", 
                                                                 array("class"=>"tooltip_button", 
                                                                       "title"=>"Haga click aqui para previsualizar los primeros 10 resultados de esta descarga")),
                                                    array('action'=>'list_view',$q['Query']['id'],'preview:true'),
                                                    array(),
                                                    null,
                                                    false
                                                   );?>
                            </span>
                            <span>
                                <? echo $html->link($html->image("download.png", 
                                                                 array("class"=>"tooltip_button", 
                                                                       "title"=>"Haga click aqui para bajar el archivo excel de esta descarga")),
                                                    array('action'=>'contruye_excel', 'ext'=>'xls', $q['Query']['id'], ),
                                                    array(),
                                                    null,
                                                    false
                                                   );?>
                            </span>
                            <?php if($q['Query']['ver_online']){?>
                            <span>
                                <? echo $html->link($html->image("view.png", 
                                                                 array("class"=>"tooltip_button", 
                                                                       "title"=>"Haga click aqui para ver online esta descarga sin bajar archivo")),
                                                    array('action'=>'list_view', $q['Query']['id']),
                                                    array(),
                                                    null,
                                                    false
                                                   );?>
                            </span>
                            <?php } ?>
                            <span class="descarga_editar_descripcion">
                                <? echo $html->link($html->image("modify.png", 
                                                                 array("class"=>"tooltip_button", 
                                                                       "title"=>"Haga click aqui para modificar la descripcion de esta descarga")),
                                                    array('action'=>'edit_description', $q['Query']['id']),
                                                    array(),
                                                    null,
                                                    false
                                                   );?>
                            </span>
                        </div>
                        <div>
                            <label style="font-weight: bold">Descripción</label>
                            <span><?php echo strip_tags($q['Query']['description'],'<br />'); ?></span>
                            <label style="font-weight: bold">Variables</label>
                            <span><?php echo $q['Query']['columns']; ?></span>
                        </div>
                    </div>
                    <?php
                    $i++;
            endforeach;
            ?>
            </div>
	</div>
        <?php } ?>
        
    </div>
</div>