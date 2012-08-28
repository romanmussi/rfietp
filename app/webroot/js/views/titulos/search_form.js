    /*
     *
     *      VARIABLES GLOBALES
     *
     *
     */
    
    var enterButton = false;
    var timerid;

    /**
     *  Indica el ID del elemento <form id="">
     * @var string
     */
    var formId = 'TituloSearchForm';

    /**
     *  es el elemento del formulario, se inicializa en en document.ready()
     * @var Dom Object
     */
    var formElement = null;
    



    /*
     *
     *      FUNCIONES
     *
     *
     */


    function iniciarTooltip(){
        jQuery.tools.tooltip.conf.events.input = 'focus,blur';
        jQuery.tools.tooltip.conf.events.tooltip = '';
        jQuery.tools.tooltip.conf.events.widget = 'focus, blur';
        jQuery("#"+formId+" :input[title]").tooltip({ effect: 'slide', offset:[22,0]});
    }

    function blockResultConsole(formData, jqForm, options) {
        jQuery('#consoleResultWrapper').mask('Buscando');
        return true;
    }

// es el que envia el formulario de busqueda ajax
    function autoSubmit(forzar){
        if ( typeof forzar != 'boolean' ) {
            forzar = false;
        }

        if(jQuery("#TituloName").val().length > 1 || forzar){
              clearTimeout(timerid);
              timerid = setTimeout(function() {
                  formElement.submit();
              }, 1000);
          }
    }

    function unblockResultConsole(responseText, statusText, xhr, $form)  {
        jQuery('#consoleResultWrapper').unmask();
    }


    function habilitarFusion() {
        if (jQuery('#consoleResultWrapper :checked').length > 1) {
            jQuery('#fusion').attr('disabled', false);
        }
        else {
            jQuery('#fusion').attr('disabled', true);
        }
    }

    function validarTitulosSeleccionados() {
        var oferta_ant = '';
        var valido = true;
        jQuery.each(jQuery('#consoleResultWrapper :checked'), function(key, value) {
            if (oferta_ant != jQuery('#oferta_'+value.id).val() && oferta_ant != '') {
                valido = false;
            }

            oferta_ant = jQuery('#oferta_'+value.id).val();
        });

        return valido;
    }


    function fusionarTitulos(element) {
        if (!validarTitulosSeleccionados()) {
            alert('No puede fusionar Títulos de distintas ofertas');
            return false;
        }

        var $dialog = jQuery('<div id="create_dialog"></div>')
                .html('... preparando para fusionar Títulos')
		.dialog({
                        width: 500,
                        position: 'top',
                        zIndex: 3999,
			title: 'Fusionar Títulos',
                        beforeclose: function(event, ui) { jQuery(".ui-dialog").remove(); jQuery("#create_dialog").remove(); }
	});

        // ids de titulos a fusionar
        var ids = '';
        jQuery.each(jQuery('#consoleResultWrapper :checked'), function(key, value) {
            ids += '/id'+key+':' + value.id;
        });

        jQuery.ajax({
          url: element.href + ids,
          cache: false,
          success: function(data) {
            $dialog.html(data);
          }
        });

        return false;
    }



    /*
     *
     *  DOCUMENT
     *  ON READY
     *  
     */

    jQuery(document).ready(function() {
        formElement = jQuery('#'+formId);
        
        var options = {
            target:        '#consoleResult',   // target element(s) to be updated with server response
            beforeSubmit:  blockResultConsole,  // pre-submit callback
            success:       unblockResultConsole,  // post-submit callback
            url:  formElement.attr('action')     // override for form's 'action' attribute
        };

        // bind form using 'ajaxForm'
        formElement.ajaxForm(options);

        jQuery("#TituloName").keyup(autoSubmit);

        jQuery("#TituloName").keypress(function(e) {
            if (e.keyCode == 10 || e.keyCode == 13){
                return false;
            }
        });

        jQuery(".autosubmit").change(function() { formElement.submit(); });

        jQuery("#TituloName").bind('paste', function(e){autoSubmit(true)});

        formElement.submit();

        //iniciarTooltip();
    });

