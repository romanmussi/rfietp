
function buscarPlanes(formElement)
{   
   var updatecontainer = jQuery('#'+jQuery(formElement).attr('update'));

   var options = {
        target:        updatecontainer,   // target element(s) to be updated with server response
        beforeSubmit:  blockResultConsole,  // pre-submit callback
        success:       unblockResultConsole,  // post-submit callback
        url:  formElement.action     // override for form's 'action' attribute
    };

    jQuery(formElement).ajaxSubmit(options);

    return false;
}

function blockResultConsole(formData, options) {
    //jQuery('.oferta_container').mask('Buscando');
    jQuery(this.target).mask('Buscando');
}

function unblockResultConsole(responseText, statusText, xhr, $form)  {
  //  jQuery('.oferta_container').unmask();
    jQuery(this.target).unmask();
}
    