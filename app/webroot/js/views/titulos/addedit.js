jQuery(document).ready(function () {
    // deshabilita ENTER
    jQuery('form').keypress(stopRKey);
});

function stopRKey(evt) {
  var evt = (evt) ? evt : ((event) ? event : null);
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
  if (evt.keyCode == 13)  {return false;}
} 

function SearchSimilars(url, name, id) {
    jQuery(document).ready(function() {
       jQuery('#divTituloName').mask('Buscando títulos similares...');
       
       var urlcompleta = '';
       var param = encodeURIComponent(escape(name).replace('/', ' '));
       if (param && id) {
           urlcompleta = url+param+'/'+id;
       }
       else if (param) {
           urlcompleta = url+param;
       }

       if (urlcompleta) {
           jQuery('#similars').load(urlcompleta, function(){
               jQuery('#similars').attr('style', 'display:block');
               jQuery('#divTituloName').unmask();
           });
       }
    });
}

function Validate() {
   if (jQuery('.js-prioridad').is(':checked')) {
        return true;
    }
    else {
        alert('Debe especificar un Sector/Subsector prioritario');
        return false;
    }
}

function agregarSectorySubsector() {
    var cloned = jQuery('#sectores .js-sector').first().clone(true);

    cloned.find('.js-prioridad-hd').val("0");
    cloned.find('.js-prioridad').removeAttr("checked");
    cloned.attr('id','cloned');
    jQuery('#sectores').append(cloned.outer());

}