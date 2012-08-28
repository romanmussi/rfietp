jQuery(document).ready(function() {
    jQuery(".js-opcional").each(function(index, value) {
        jQuery(".js-opcional").hide();
    });
    alert("sads");
});

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