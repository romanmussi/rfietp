





/*-------------------------*****
 * 
 * 
 *      AJAX RESPONDERS  
 *      
 *      Cuando hay algo Ajax ejecutandose, 
 *      me muestra un cartelito estilo google
 * 
 *-----------------------------*/
Ajax.Responders.register({
          
          onCreate : function(a_request)
          {
                  if (Ajax.activeRequestCount >= 1)
                  {
                         //mostrar_onloading();
                         $('mensajero').show();
                         
                         // esto no funciona en IE por eso lo saque
                        // $('mensajero').scrollTo();

                         mensajero.playLoading();
                  }
          },
          onComplete : function(a_request)
          {
                  if (Ajax.activeRequestCount == 0)
                  {
                        // ocultar_onloading();
                          mensajero.stopLoading();
                          $('mensajero').hide();
                  }
          }
          
        });
