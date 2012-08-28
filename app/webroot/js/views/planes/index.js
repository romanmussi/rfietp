
/**
 *
 * inicializar las tabs de JqueryUI
 *
 * los posibles options son:
 *      spinnerImg: '<?php echo $html->image('spinner.gif') ?>'
 *                  es la imagen que quiero mostrar en el spinner
 *                  
 */
function inicializarTabs(options)
{
    imgUrl = options.spinnerImg;

    jQuery('.js-tabs-ofertas').tabs({
        selected: getSelectedOfertaTabIndex()
    });

    jQuery('.js-tabs-ciclos').tabs({
        spinner: imgUrl,
        selected: getSelectedCicloTabIndex()
    });
}

function getSelectedCicloTabIndex() {
    var i = 0;
    if (!Get_Cookie('tab_ciclo')) return 0;
    jQuery("#ciclos-tabs ul li a").not(":hidden").each(function(index, value) {
        if(jQuery(value).attr("id") == Get_Cookie('tab_ciclo')){
            i = index;
        }
    });
    return i;
}

function getSelectedOfertaTabIndex() {
    var i = 0;
    if (!Get_Cookie('tab_oferta')) return 0;
    jQuery("#ofertas-tabs li a").not(":hidden").each(function(index, value) {
        if(jQuery(value).attr("id") == Get_Cookie('tab_oferta')){
            i = index;
        }
    });
    return i;
}



function agregarTabsAUserSession()
{
    //selectTabsInSession(); --deprecated
    PreparaTabsParaSession();
}


function PreparaTabsParaSession() {
    jQuery('#ofertas-tabs a').each(function(index, value) {
        jQuery(value).click(function() {
            Set_Cookie( 'tab_oferta', value.id, '', '/', '', '' );
        });
    });

    jQuery('#ciclos-tabs a').each(function(index, value) {
        jQuery(value).click(function() {
            Set_Cookie( 'tab_ciclo', value.id, '', '/', '', '' );
        });
    });
}


function selectTabsInSession () {
    if (Get_Cookie('tab_oferta')) {
        jQuery('#'+Get_Cookie('tab_oferta')).click();
    }
    if (Get_Cookie('tab_ciclo')) {
        jQuery('#'+Get_Cookie('tab_ciclo')).click();
    }
}


jQuery(function() {
    jQuery("#PlanNombre").live("change", function() {
        if(jQuery(this).val()){
            jQuery(this).addClass("buscado");
        }else{
            jQuery(this).removeClass("buscado");
        }
    });

    jQuery("#SectorId").live("change", function() {
        if(jQuery(this).val()){
            jQuery(this).addClass("buscado");
        }else{
            jQuery(this).removeClass("buscado");
        }
   });
});