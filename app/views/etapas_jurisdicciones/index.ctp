<?
echo $javascript->link(array('jquery.multiselect2side','jquery.contextMenu', 'jquery-impromptu.3.1.min'));
echo $html->css(array('jquery.multiselect2side.css','jquery.contextMenu.css'));
?>
<style>
    .etapasJurisdicciones form div{
        clear:none;
    }

    .jqifade{
	position: absolute;
	background-color: #aaaaaa;
    }
    div.jqi{
            width: 400px;
            font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
            position: absolute;
            background-color: #ffffff;
            font-size: 11px;
            text-align: left;
            border: solid 1px #eeeeee;
            border-radius: 10px;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            padding: 7px;
    }
    div.jqi .jqicontainer{
            font-weight: bold;
    }
    div.jqi .jqiclose{
            position: absolute;
            top: 4px; right: -2px;
            width: 18px;
            cursor: default;
            color: #bbbbbb;
            font-weight: bold;
    }
    div.jqi .jqimessage{
            padding: 10px;
            line-height: 20px;
            color: #444444;
    }
    div.jqi .jqibuttons{
            text-align: right;
            padding: 5px 0 5px 0;
            border: solid 1px #eeeeee;
            background-color: #f4f4f4;
    }
    div.jqi button{
            padding: 3px 10px;
            margin: 0 10px;
            background-color: #2F6073;
            border: solid 1px #f4f4f4;
            color: #ffffff;
            font-weight: bold;
            font-size: 12px;
    }
    div.jqi button:hover{
            background-color: #728A8C;
    }
    div.jqi button.jqidefaultbutton{
            background-color: #BF5E26;
    }
    .jqiwarning .jqi .jqibuttons{
            background-color: #BF5E26;
    }
</style>
<script type="text/javascript">
    // inicializacion array de etapas
    var aEtapas = new Array();
    /*for (var i=0; i < <?=(count($etapasSeleccionadas)+count($etapasNoSeleccionadas))?>; i++) {
        aEtapas[i] = new Array('id','edad_desde','edad_hasta');
    }*/


    function saveRange(v,m,f){
            if(v == 'Ok')
            //alert(f.etapa + ": " + f.desde +' - '+ f.hasta);
            setDesdeHasta(f.etapa, f.desde, f.hasta);
    }
    

    jQuery(document).ready(function() {

        jQuery('#etapas').multiselect2side({
				selectedPosition: 'left',
				moveOptions: false,
				labelsx: 'Seleccionadas',
				labeldx: 'Disponibles'
        });
        
        jQuery("select#datams2side__sx option").contextMenu({
                menu: 'myMenu'
        }, function(action, el, pos) {
                if(action=="edades"){
                    var txt = "Ingrese Rango de edad:<br />" +
                                  "Desde:<input type='text' id='desde'" +
                                  " name='desde' value='" + getDesde(jQuery(el).val()) + "' />" +
                                  "Hasta:<input type='text' id='hasta'" +
                                  " name='hasta' value='" + getHasta(jQuery(el).val()) + "' />" +
                                  "<input type='hidden' id='etapa'" +
                                  " name='etapa' value='" + jQuery(el).val() + "' />";

                    jQuery.prompt(txt,{
                            callback: saveRange,
                            buttons: { OK: 'Ok', Cancel: 'Cancelar' }
                    });
                }
                else{
                    jQuery(el).dblclick();
                }
        });

        jQuery("select#datams2side__dx option").contextMenu({
                menu: 'myMenu2'
        }, function(action, el, pos) {
                    jQuery(el).dblclick();
        });

        jQuery("select").change(function(){
                jQuery('select#datams2side__sx option').destroyContextMenu();
                jQuery("select#datams2side__sx option").contextMenu({
                        menu: 'myMenu'
                }, function(action, el, pos) {
                        if(action=="edades"){
                            var txt = "Ingrese Rango de edad:<br />" +
                                  "Desde:<input type='text' id='desde'" +
                                  " name='desde' value='" + getDesde(jQuery(el).val()) + "' />" +
                                  "Hasta:<input type='text' id='hasta'" +
                                  " name='hasta' value='" + getHasta(jQuery(el).val()) + "' />" +
                                  "<input type='hidden' id='etapa'" +
                                  " name='etapa' value='" + jQuery(el).val() + "' />";

                            jQuery.prompt(txt,{
                                    callback: saveRange,
                                    buttons: { OK: 'Ok', Cancel: 'Cancelar' }
                            });
                        }
                        else{
                            jQuery(el).dblclick();
                        }
                });

                jQuery("select#datams2side__dx option").contextMenu({
                        menu: 'myMenu2'
                }, function(action, el, pos) {
                            jQuery(el).dblclick();
                });
        });
    })

    function setDesdeHasta(id, edad_desde, edad_hasta) {
        for (var i=0; i < aEtapas.length; i++) {
            if (!isNaN(aEtapas[i]['id']) && aEtapas[i]['id']==id) {
                if (aEtapas[i]['edad_desde'] && aEtapas[i]['edad_hasta']) {
                    aEtapas[i]['edad_desde'] = edad_desde;
                    aEtapas[i]['edad_hasta'] = edad_hasta;

                    return 1;
                }
            }
        }

        // no existe, lo crea
        var j = aEtapas.length;
        aEtapas[j] = new Array('id','edad_desde','edad_hasta');
        aEtapas[j]['id']=id;
        aEtapas[j]['edad_desde'] = edad_desde;
        aEtapas[j]['edad_hasta'] = edad_hasta;

        return 1;
    }

    function getDesde(id) {
        for (var i=0; i < aEtapas.length; i++) {
            if (!isNaN(aEtapas[i]['id']) && aEtapas[i]['id']==id) {
                 if (aEtapas[i]['edad_desde']) {
                    return aEtapas[i]['edad_desde'];
                }
            }
        }
        return 0;
    }

    function getHasta(id) {
        for (var i=0; i < aEtapas.length; i++) {
            if (!isNaN(aEtapas[i]['id']) && aEtapas[i]['id']==id) {
                 if (aEtapas[i]['edad_hasta']) {
                    return aEtapas[i]['edad_hasta'];
                }
            }
        }
        return 0;
    }

    function onSubmitForm() {
        // recorre el array y completa los campos hidden
        //var text = '';
        for (var i=0; i < aEtapas.length; i++) {
            if (aEtapas[i]['edad_desde'] != '') {
                if (document.getElementById("data[EtapasJurisdiccion]["+aEtapas[i]['id']+"][edad_desde]")) {
                    document.getElementById("data[EtapasJurisdiccion]["+aEtapas[i]['id']+"][edad_desde]").value = aEtapas[i]['edad_desde'];
                }
            }

            if (aEtapas[i]['edad_hasta'] != '') {
                if (document.getElementById("data[EtapasJurisdiccion]["+aEtapas[i]['id']+"][edad_hasta]")) {
                    document.getElementById("data[EtapasJurisdiccion]["+aEtapas[i]['id']+"][edad_hasta]").value = aEtapas[i]['edad_hasta'];
                }
            }

            //text += "Etapa["+i+"]["+aEtapas[i]['id']+"][edad_hasta] = "+aEtapas[i]['edad_hasta']+" \\r\\n";
        }

        return true;
    }
</script>

<div class="etapasJurisdicciones index">

<h2><?php __('Etapas por Jurisdicciones');?></h2>

<?php echo $form->create('EtapasJurisdiccion',array('action' => 'index','name'=>'EtapasJurisdiccionForm', 'onsubmit'=>'Javascript: return(onSubmitForm());'));?>
<div>
<select name="data[EtapasJurisdiccion][etapas_selected][]" id='etapas' multiple='multiple' size='10'>
        <?php
        foreach ($etapasSeleccionadas as $etapaSeleccionada) {?>
            <option value="<?php echo $etapaSeleccionada['Etapa']['id']; ?>" SELECTED><?php echo $etapaSeleccionada['Etapa']['name']; ?></option>
        <?php
        }
        ?>
        <?php
        foreach ($etapasNoSeleccionadas as $etapaNoSeleccionada):?>
            <option value="<?php echo $etapaNoSeleccionada['Etapa']['id'] ?>"><?php echo $etapaNoSeleccionada['Etapa']['name'] ?></option>
        <?php endforeach; ?>

</select>
<input name="data[EtapasJurisdiccion][jurisdiccion_id]" type="hidden" value="<?php echo $jurisdiccion_id?>" />

<?php
foreach ($etapasSeleccionadas as $etapaSeleccionada) {
    ?>
    <input id="data[EtapasJurisdiccion][<?=$etapaSeleccionada['Etapa']['id']?>][edad_desde]" name="data[EtapasJurisdiccion][<?=$etapaSeleccionada['Etapa']['id']?>][edad_desde]" type="hidden" value="" />
    <input id="data[EtapasJurisdiccion][<?=$etapaSeleccionada['Etapa']['id']?>][edad_hasta]" name="data[EtapasJurisdiccion][<?=$etapaSeleccionada['Etapa']['id']?>][edad_hasta]" type="hidden" value="" />

    <script type="text/javascript">
    // inicializa con los existentes
    setDesdeHasta(<?=$etapaSeleccionada['Etapa']['id']?>, 
        <?=(!empty($etapaSeleccionada['EtapasJurisdiccion']['edad_desde']))?$etapaSeleccionada['EtapasJurisdiccion']['edad_desde']:0?>,
        <?=(!empty($etapaSeleccionada['EtapasJurisdiccion']['edad_hasta']))?$etapaSeleccionada['EtapasJurisdiccion']['edad_hasta']:0?>);
    </script>
    <?
}

foreach ($etapasNoSeleccionadas as $etapaNoSeleccionada) {
    ?>
    <input id="data[EtapasJurisdiccion][<?=$etapaNoSeleccionada['Etapa']['id']?>][edad_desde]" name="data[EtapasJurisdiccion][<?=$etapaNoSeleccionada['Etapa']['id']?>][edad_desde]" type="hidden" value="" />
    <input id="data[EtapasJurisdiccion][<?=$etapaNoSeleccionada['Etapa']['id']?>][edad_hasta]" name="data[EtapasJurisdiccion][<?=$etapaNoSeleccionada['Etapa']['id']?>][edad_hasta]" type="hidden" value="" />
    <?
}
?>
</div>
<?php echo $form->end("Guardar"); ?>
</div>

<ul id="myMenu" class="contextMenu">
        <li class="copy"><a href="#edades">Edades</a></li>
        <li class="edit separator"><a href="#asign">Mover</a></li>
</ul>

<ul id="myMenu2" class="contextMenu">
        <li class="edit separator"><a href="#asign">Mover</a></li>
</ul>




