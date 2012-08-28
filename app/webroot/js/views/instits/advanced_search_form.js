
function init__AdvancedSearchFormJs(urlLocalidades, urlTitulos){
    jQuery(document).ready(function() {
        iniciarTooltip();

        jQuery("#InstitJurDepLoc").autocomplete(urlLocalidades, {
            dataType: "json",
            delay: 200,
            max:30,
            cacheLength:1,
            extraParams: {
                jur: function() { return jQuery('#jurisdiccion_id').val(); }
            } ,
            parse: function(data) {
                return jQuery.map(data, function(loc_dep) {
                    return {
                        data: loc_dep,
                        value: loc_dep.id,
                        result: formatResult(loc_dep)
                    }
                });
            },
            formatItem: function(item) {
                return formatResult(item);
            }
        }).result(function(e, item) {
            jQuery("#hiddenLocDepId").remove();
            if(item.type == 'Vacio'){
                jQuery("#InstitJurDepLoc").val('');
            }
            else{
                jQuery("#InstitSearchForm #search-ubicacion").append("<input id='hiddenLocDepId' name='data[Instit][" + item.type.toLowerCase() + "_id]' type='hidden' value='" + item.id + "' />");
            }
        });

        jQuery("#InstitJurDepLoc").bind('paste', function(e){jQuery("#InstitJurDepLoc").change()});

        jQuery("#InstitJurDepLoc").attr('autocomplete','off');

        jQuery("#PlanTituloName").autocomplete(urlTitulos, {
            dataType: "json",
            delay: 200,
            max:30,
            cacheLength:0,
            extraParams: {
                oferta_id: function() { return jQuery('#OfertaId').val(); },
                sector_id: function() { return jQuery('#SectorId').val(); },
                subsector_id: function() { return jQuery('#SubsectorId').val(); }
            } ,
            parse: function(data) {
                return jQuery.map(data, function(titulo) {
                    return {
                        data: titulo,
                        value: titulo.id,
                        result: formatResult2(titulo)
                    }
                });
            },
            formatItem: function(item) {
                return formatResult2(item);
            }
        }).result(function(e, item) {
            if(item.type == 'Vacio'){
                jQuery("#PlanTituloName").val('');
                jQuery("#PlanTituloId").val('');
            }
            else{
                jQuery("#PlanTituloId").val(item.id);
            }
            
            jQuery('.ac_results').bgiframe();
        });

        jQuery("#PlanTituloName").attr('autocomplete','off');

        jQuery("#PlanTituloName").bind('paste', function(e){jQuery("#PlanTituloName").change()});

        jQuery("#OfertaId").change(function(){
            jQuery("#PlanTituloName").val('');
            jQuery("#PlanTituloId").val('');
        });

        jQuery("#SectorId").change(function(){
            jQuery("#PlanTituloName").val('');
            jQuery("#PlanTituloId").val('');
        });

        jQuery("#SubsectorId").change(function(){
            jQuery("#PlanTituloName").val('');
            jQuery("#PlanTituloId").val('');
        });
    });
}



function iniciarTooltip(){
    jQuery.tools.tooltip.conf.events.input = 'focus,blur';
    jQuery.tools.tooltip.conf.events.tooltip = '';
    jQuery.tools.tooltip.conf.events.widget = 'focus, blur';
    jQuery("#InstitSearchForm :input[title]").tooltip({
        effect: 'slide',
        offset:[22,0]
    });

}



function formatResult(loc_dep) {
    if(loc_dep.type == 'Localidad'){
        return loc_dep.localidad + ', ' + loc_dep.departamento + ' (' + loc_dep.jurisdiccion + ')';
    }
    else if(loc_dep.type == 'Departamento'){
        return loc_dep.departamento + ' (' + loc_dep.jurisdiccion + ')';
    }
    else{
        return loc_dep.localidad;
    }

}

function formatResult2(titulo) {
        return titulo.name;
}

function enviar()
{
    //jQuery('#InstitSearchForm input[type=button]').attr('disabled', 'disabled');
    jQuery('#InstitSearchForm').submit();
    jQuery("#hiddenLocDepId").remove();
}

function borrarDatos(nombreElemento){
    jQuery(nombreElemento).css({
        backgroundColor:"#FFFFE0"
    }).animate(

    {
        width:'544px'
    },
    200,
    'linear',
    function(){
        jQuery(nombreElemento).delay(100).animate(
        {
            width:'544px'
        },
        200,
        function(){
            jQuery(nombreElemento).css({
                background:"#FFF"
            });
        });
    });
}


function onSeleccionDeJurisdiccionDo(){

    jQuery("#ajax_indicator").hide();
    jQuery("#InstitTipoinstitId").removeAttr("disabled");

    //console.debug(jQuery('#InstitJurDepLoc').css);

    borrarDatos('#InstitJurDepLoc');
    borrarDatos('#InstitTipoinstitId');

    //jQuery('#InstitJurDepLoc').delay(1900).css({borderColor:"black"});


    //    jQuery("#InstitJurDepLoc").css({borderColor:"#000000",borderWidth:'6px'});
    //    jQuery("#InstitJurDepLoc").delay("99999900").css({borderColor:"#BBBBBB",borderWidth:'1px'});

    jQuery("#hiddenLocDepId").remove();
    jQuery("#InstitJurDepLoc").val("");
    jQuery("#label-tipoinstit").html('Mostrando Tipo de Instituciones de '+jQuery('#jurisdiccion_id :selected').text());
}