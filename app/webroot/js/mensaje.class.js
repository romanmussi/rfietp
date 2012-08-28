var Mensaje = Class.create();


Mensaje.prototype ={
        
        /**
         * 
         * Le paso como parametro el contenedor donde se van a ir listando los mensajes.
         * el contenedor geeralmente es algo del tipo 'div', o 'p'
         */
          initialize: function(nombre_contenedor_a_actualizar) {        
                  /****************************************************************************************
                   * 
                   *                    Atributos
                   * 
                   */           
                        this.mensaje = ''; //texto del mensaje
                        this.mensajeId = 0; // contenedor del mensaje generado dinamicamente con un random
                        this.contenedorMensajes = null; // es el elemento contenedor de mensajes, por ahora es un UL -> Listadi de nmensajes
        
                        //es el id del contenedor donde se actualizaran y mostraran los mensajes
                        this.contenedor_name = nombre_contenedor_a_actualizar;
                        this.contenedor = null;  // es el contenedor general de TODO y ya tiene que existeir en la DOM, por lo general es un DIV
                        
                        
                        //      ---- Atributos correspondientes al mensaje de loading (cargando)                
                        this.imageLoading = null; //url hacia la ubicacion de la imagen
                        this.loadingID = null; // es el Id del contenedor generado dinamicamente con un random
                        this.loadingDiv = null;// es el Id del contenedordel DIV que contine le loadgin
                                
                        //este indica si fue inicializado y creado correctamente los elementos
                        this.OK = false;
                        
                        
                        /**************************************************************************************/
                        
                         Event.observe(window, 'load', function() 
                         {
                                this.contenedor = $(nombre_contenedor_a_actualizar);                    
                                this.OK = true;
                                
                                // genero el DIV del loading que siempre se muestra arriba de todo
                                if(!this.__crearLoadingDiv()){
                                        this.OK = false;
                                }                               
                                
                                //genero el UL
                                if(!this.__crearUlColaMensajes()){
                                        this.OK = false;
                                }                               
                         }.bind(this));
          },
          
          
          setMensaje: function(mensaje){
                  this.mensaje = mensaje;
          },
          
          setImageLoading: function(imageURL){
                  this.imageLoading = imageURL;
          },
          
          isSetImageLoading: function(){
                  if(this.imageLoading){
                          return true;
                  }else{
                          return false;
                  }
          },
          
          
          /*
           * inserta un mensaje en la cola de mensajes UL
           * lo inserta como LI
           */
          __insertarMensaje: function()
          {
                  if(this.contenedorMensajes){
                          this.mensajeId = this.__generateIdMicrotime();
                          
                          var li = new Element('li', {'id':this.mensajeId});
                          li.update(this.mensaje);
                          this.contenedorMensajes.insertBefore(li, this.contenedorMensajes.firstChild);
                  }
          },
          
          
          show: function(mensaje){
                  this.mensaje = mensaje;
                 
                  if(this.OK) {
                        this.__insertarMensaje();
                  }
                  else{ // hago esperar al mensaje hasta que se termin� de cargar todo
                        Event.observe(window,'load',function(){
                                this.__insertarMensaje();
                        }.bind(this));                    
                  }
          },
          
          
          /**
           * me genera un ID �nico usando el random de javascript
           * @return String un numero random
           */
         __generateIdMicrotime: function () {
                    // Returns either a string or a float containing the current time in seconds and microseconds  
                    // 
                    // version: 812.316
                    // discuss at: http://phpjs.org/functions/microtime
                    // +   original by: Paulo Ricardo F. Santos
                    // *     example 1: timeStamp = microtime(true);
                    // *     results 1: timeStamp > 1000000000 && timeStamp < 2000000000
                    var now = new Date().getTime();
                    
                    return "msg-"+Math.round(Math.random()*10000000000000);
                },

          
          
          error:  function(mensaje){
                  this.mensaje = mensaje;
                  if(this.OK) {
                          this.mensajeId = this.__generateIdMicrotime();
                          var li = new Element('li', {'id':this.mensajeId, 'class':'mensaje-error'});
                          li.update(this.mensaje);
                          this.contenedorMensajes.insertBefore(li, this.contenedor.firstChild);
                  };
          },
          
          
          
          __crearLoadingDiv: function(){
                                // genero el DIV del loading que siempre se muestra arriba de todo
                                this.loadingDiv = new Element('div',{'id': 'mensajes-loading'});
                                this.loadingDiv.hide();                                                   
                                this.loadingDiv.update('....cargando....');
                                if(this.isSetImageLoading())
                                {
                                        var img = new Element('img',{'src':this.imageLoading});
                                        this.loadingDiv.appendChild(img);
                                }
                                
                                this.contenedor.appendChild(this.loadingDiv);
                                return 1;
          },
          
          
          
          /**
           * Me crea el UL qudonde van los mensajes LI que mando a mostrar
           * @return nada
           */
          __crearUlColaMensajes: function(){
                          var ul = new Element('ul', {'id': 'mensaje_superale'});                       
                          this.contenedorMensajes = ul;

                          this.contenedor.appendChild(this.contenedorMensajes);
                          this.OK = true;
                          return 1;
          },
          
          
          playLoading: function(mensaje)
          {
                  if (this.loadingDiv != null) //si est� creado lo muestro
                  {
                          $(this.loadingDiv).show();
                  }
                  
          },
          
          stopLoading: function(mensaje){
                  if(this.loadingDiv != null){
                          $(this.loadingDiv).hide();
                  }
          }
};
