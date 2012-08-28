

//var FormRia = Class.create();

// properties are directly passed to `create` method
var FormRia = Class.create({

  initialize: function() {
	
  },
  
  
  /**
  * Agrega eventos onload para que detecte el ENTER y que envie el 
  * formulario (hace un submit)
  **/
  agregarOnEnterPressParaElFormulario: function(idformulario) 
  {
    Event.observe(window, 'load', 
		function() {
			Event.observe(document, 'keypress', 
				function (event){
					if (Event.KEY_RETURN == event.keyCode) {
						$(idformulario).submit();
					}
				return;
				}
			);
		}
	);	
  },
  
  /**
   * Cuando un div no es visible desactiva los inputs del formulario
   */
  eliminarInputsCuyoDivEsInvisible: function(){
	  alert("hjasdgkasjg");
	  $('InstitSearchForm').observe('submit',function(){
	  	if(!$('search-ubicacion').visible){
	  		alert("ubicacion visible");
	  		$('DepartamentoId').disable();
	  		$('LocalidadId').disable();
	  		$('InstitDireccion').disable();
	  	}
	  	
	  	if(!$('search-denominacion').visible){
	  		alert("denominacion visible");
	  		$('InstitTipoinstitId').disable();
	  		$('InstitNroinstit').disable();
	  		$('InstitNombre').disable();
	  	}
	  	
	  	if(!$('search-otros').visible){
	  		alert("ubicacion visible");
	  		$('PlanOfertaId').disable();
	  		$('PlanSector').disable();
	  		$('InstitGestionId').disable();
	  		$('InstitDependenciaId').disable();
	  		$('InstitActivo').disable();
	  	}
	  })
  }
  
});
