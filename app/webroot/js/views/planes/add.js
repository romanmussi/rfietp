function oferta_change(){
  if (jQuery('#PlanOfertaId').val() != '') {
      jQuery('#divPlanTituloName').show();
  }
  else {
       jQuery('#divPlanTituloName').hide();
  }

  if (jQuery('#PlanOfertaId :selected').val() != 3 && jQuery('#PlanOfertaId').val() != 3) {
      jQuery('#PlanEstructura').hide();
      jQuery('#div_hs').show();
  }
  else {
      jQuery('#PlanEstructura').show();
      jQuery('#div_hs').hide();
  }

  //si es FP oculto años
  if (jQuery('#PlanOfertaId :selected').val() == 1 || jQuery('#PlanOfertaId').val() == 1) {
    jQuery('#div_anios').hide();
  }
  else
  {
    jQuery('#div_anios').show();
  }
}


function formatResult(titulo) {
        return titulo.name;
}

function SearchSimilars(url, name, instit_id, id) {
       jQuery('#divTituloName').mask('Buscando títulos similares...');
       
       var urlcompleta = '';
       var param = encodeURIComponent(escape(name).replace('/', ' '));
       if (param && id) {
           urlcompleta = url+'/'+param+'/'+instit_id+'/'+id;
       }
       else if (param) {
           urlcompleta = url+'/'+param+'/'+instit_id;
       }

       if (urlcompleta) {
           jQuery('#similars').load(urlcompleta, function(){
               jQuery('#similars').attr('style', 'display:block');
               jQuery('#divTituloName').unmask();
           });
       }
}

function init(autocomplete_url, searchSimilars_url) {
    jQuery(document).ready(function () {
        // deshabilita ENTER
        jQuery('form').keypress(
            function stopRKey(evt) {
              var evt = (evt) ? evt : ((event) ? event : null);
              var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
              if (evt.keyCode == 13)  {return false;}
            });

        // planes con nombre similar en la institucion
        jQuery("#spell_checker1").live('blur', function() {
            if (jQuery("#PlanId").val()) {    // edit
                SearchSimilars(searchSimilars_url, jQuery("#spell_checker1").val(), jQuery("#PlanInstitId").val(), jQuery("#PlanId").val());
            }
            else {  // add
                SearchSimilars(searchSimilars_url, jQuery("#spell_checker1").val(), jQuery("#PlanInstitId").val());
            }
        });
        
        oferta_change();

        jQuery("#PlanEstructuraPlanId").change(function(){
            jQuery("div[estructura_plan_id]").hide();
            jQuery("div[estructura_plan_id=" + jQuery(this).val() + "]").show();
            jQuery("#PlanTituloName").val('');
            jQuery("#PlanTituloId").val('');
        });


        jQuery("#PlanTituloName").autocomplete(autocomplete_url, {
            dataType: "json",
            delay: 200,
            max:30,
            cacheLength:0,
            extraParams: {
                oferta_id: function() { return jQuery('#PlanOfertaId').val(); },
                sector_id: function() { return jQuery('#sector_id').val(); },
                subsector_id: function() { return jQuery('#PlanSubsectorId').val(); }
            } ,
            parse: function(data) {
                return jQuery.map(data, function(titulo) {
                    return {
                        data: titulo,
                        value: titulo.id,
                        result: formatResult(titulo)
                    }
                });
            },
            formatItem: function(item) {
                return formatResult(item);
            }
        }).result(function(e, item) {
            if(item.type == 'Vacio'){
                jQuery("#PlanTituloName").val('');
                jQuery("#PlanTituloId").val('');
            }
            else{
                jQuery("#PlanTituloId").val(item.id);
            }
        });

        jQuery("#PlanTituloName").attr('autocomplete','off');

        jQuery("#sector_id").change(function(){
            jQuery("#PlanTituloName").val('');
            jQuery("#PlanTituloId").val('');
        });

        jQuery("#PlanSubsectorId").change(function(){
            jQuery("#PlanTituloName").val('');
            jQuery("#PlanTituloId").val('');
        });

        jQuery("#PlanTituloName").change(function(){
            if (jQuery("#PlanTituloName").val() == '')
                jQuery("#PlanTituloId").val('');
        });

    });
}