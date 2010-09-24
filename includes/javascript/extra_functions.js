/* 
 * agrego aqui varias cuestiones JS adicionales que necesitaremos a lo largo del sitio 
*/

  	
$(document).ready(function() {

	   
	   /* 
	     al buscar desde el text y presionar enter, se hace un submit comun del formulario y no se invoca a la funcion
	     searchPage, que arma la URL completa, a la que le incluye el parametro search_text . Por este motivo, no funcionaba el next/prev 
	     al buscar, pues no existía el param de búsqueda.
	     Capturo el #ENTER e invoco a searchPage con la url del listado de inventario 
	     
	  */  	 
	  	 
	   $("#search_text").keydown(function(event) {
			if (event.keyCode == '13') {
			     event.preventDefault();
			     $("#search_mini_icon").trigger("click");
			   }
			}); 
	

});	  
  	
