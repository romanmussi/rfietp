jQuery.noConflict();
jQuery.fn.outer = function() {
    return jQuery( jQuery('<div></div>').html(this.clone()) ).html();
}
jQuery(document).ready(function () {
    // abrir los menues segun las cookies dejando abiertos los que ya estaban
    openMenues();

    // cuando hay error de permisos en Ajax mostrar un alert
    jQuery(document).ajaxError(function(e, xhr, settings, exception) {
        jQuery.unblockUI;
        if (xhr.status == 401){
            alert('Su usuario no tiene permisos para acceder a esta página');
            if (!jQuery('#authMessageJs')){
        //                            var authMessage = '<div id="authMessageJs" class="message">Usted no tiene permisos para realizar esta operación</div>';
        //                            jQuery('#main-content').prepend(authMessage);
        }
        }

    });

    jQuery('#boxTickets').click(function () {
        if (apretado == false) {
            jQuery('#pendientes').ajaxSubmit(options);
            apretado = true;
        }

        return false;
    });

    jQuery("ul.menu_body li:even").addClass("alt");
    jQuery('#boxInstituciones .menu_body').show();


    // jQuery('.menu_body').show();

    jQuery('.menu_head, .menu_head_open').click(function () {
        if(jQuery(this).hasClass('menu_head')){
            jQuery(this).removeClass('menu_head').addClass('menu_head_open');

            // guarda en cookie para recordar
            Set_Cookie( 'opened_tag', this.id, '', '/', '', '' );
        }else if(jQuery(this).hasClass('menu_head_open')){
            jQuery(this).removeClass('menu_head_open').addClass('menu_head');

            // si existe en cookie borra
            if ( Get_Cookie( 'opened_tag' ) == this.id ) {
                Delete_Cookie('opened_tag', '/', '');
            }
        }
        jQuery('#' + this.id + ' ul.menu_body').slideToggle('medium');


    });

/*jQuery('.slide-out-div').tabSlideOut({
                            tabHandle: '.handle',                     //class of the element that will become your tab
                            pathToTabImage: '<?=$html->url("/img/contact_tab.gif")?>', //path to the image for the tab //Optionally can be set using css
                            imageHeight: '122px',                     //height of tab image           //Optionally can be set using css
                            imageWidth: '40px',                       //width of tab image            //Optionally can be set using css
                            tabLocation: 'left',                      //side of screen where tab lives, top, right, bottom, or left
                            speed: 300,                               //speed of animation
                            action: 'click',                          //options: 'click' or 'hover', action to trigger animation
                            topPos: '200px',                          //position from the top/ use if tabLocation is left or right
                            leftPos: '20px',                          //position from left/ use if tabLocation is bottom or top
                            fixedPosition: false                      //options: true makes it stick(fixed position) on scroll
                    });*/
});


function openMenues() {
    // para cada DIV del menu
    jQuery('#menu > DIV').each(function(k,e){
        if (Get_Cookie( 'opened_tag' ) != null && Get_Cookie( 'opened_tag' ).toString() == e.id) {
            // al H1 le cambio la clase para que aparezca la flechita para arriba            
            jQuery(e.id+' > h1').removeClass('menu_head').addClass('menu_head_open');
            // al UL lo muestro u oculto segun la ocasion
            jQuery(e.id+' > ul').slideToggle('medium');
        }
    });
}

function borrarCookies() {
    // si existe en cookie borra
    if ( Get_Cookie( 'opened_tag' )) {
        Delete_Cookie('opened_tag', '/', '');
    }
}


function Set_Cookie( name, value, expires, path, domain, secure )
{
    // set time, it's in milliseconds
    var today = new Date();
    today.setTime( today.getTime() );

    /*
            if the expires variable is set, make the correct
            expires time, the current script below will set
            it for x number of days, to make it for hours,
            delete * 24, for minutes, delete * 60 * 24
                     */
    if ( expires )
    {
        expires = expires * 1000 * 60 * 60 * 24;
    }
    var expires_date = new Date( today.getTime() + (expires) );

    document.cookie = name + "=" +escape( value ) +
    ( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) +
    ( ( path ) ? ";path=" + path : "" ) +
    ( ( domain ) ? ";domain=" + domain : "" ) +
    ( ( secure ) ? ";secure" : "" );
}

function Get_Cookie( name ) {

    var start = document.cookie.indexOf( name + "=" );
    var len = start + name.length + 1;
    if ( ( !start ) &&
        ( name != document.cookie.substring( 0, name.length ) ) )
        {
        return null;
    }
    if ( start == -1 ) return null;
    var end = document.cookie.indexOf( ";", len );
    if ( end == -1 ) end = document.cookie.length;
    return unescape( document.cookie.substring( len, end ) );
}

// this deletes the cookie when called
function Delete_Cookie( name, path, domain ) {
    if ( Get_Cookie( name ) ) document.cookie = name + "=" +
        ( ( path ) ? ";path=" + path : "") +
        ( ( domain ) ? ";domain=" + domain : "" ) +
        ";expires=Thu, 01-Jan-1970 00:00:01 GMT";
}



function meterCopyPasteDelNombre(urlToFlash){
        var clip = new ZeroClipboard.Client();

        ZeroClipboard.setMoviePath(urlToFlash);

        clip.setText( '' ); // will be set later on mouseDown
        clip.setHandCursor( true );
        clip.addEventListener( 'mouseDown', function(client) {
           client.setText(jQuery("#infoToCopy").val());
        } );

        clip.glue( 'd_clip_button' );
}

function PopularCombo(comboSelector, actionJson,parameters, agregarEmpty, spinner){
    var options = [];
    if(spinner){
        spinner.show();
    }
    comboSelector.html('<option value="0">Cargando...</option>');
    comboSelector.attr('disabled', 'disabled');
    jQuery.getJSON(actionJson, parameters, function(result) {
        if(agregarEmpty){
            options.push('<option value="0">Ninguno</option>');
        }
        for (var i = 0; i < result.length; i++) {
            options.push('<option value="',
              result[i].id, '">',
              result[i].name, '</option>');
        }
        comboSelector.html(options.join(''));
        if(spinner){
            spinner.hide();
        }

        comboSelector.removeAttr('disabled');
    });
}
