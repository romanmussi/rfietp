
function init(urlClose){
    jQuery(document).ready(function(){
        jQuery('.ajax-link').click(agregar_datos_anios);

        jQuery(".js-opcional").each(function(index, value) {
            jQuery(".js-opcional").hide();
        });

        function agregar_datos_anios(){
            urlEnvio = jQuery(this).attr('href');
            jQuery('#nueva-data').load(urlEnvio, function() {
              jQuery.blockUI({
                    message: "<div style='height:18px;background-color:#87AEC5'><img style='cursor:pointer;float:right' src='"+urlClose+"' class='cerrar'/></div>" + jQuery('#nueva-data').html(),
                    css: {
                        width:          'auto',
                        top:            '10%',
                        left:           '25%',
                        right:          '25%',
                        textAlign:      'left',
                        cursor:         'auto'
                    }
                });

                jQuery('.blockOverlay').attr('title','Cerrar').click(jQuery.unblockUI);
                jQuery('.cerrar').attr('title','Cerrar').click(jQuery.unblockUI);
            });


            return false;
        }
    });
}

function toogleDatosAnios() {
    if (jQuery("#mostraranios").is(":checked")) {
        jQuery(".js-opcional").each(function(index, value) {
            jQuery(".js-opcional").show();
        });
    }
    else {
        jQuery(".js-opcional").each(function(index, value) {
            jQuery(".js-opcional").hide();
        });
    }
}