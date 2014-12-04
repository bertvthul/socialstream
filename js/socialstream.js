$(document).ready(function(){
	
	$(".fancybox").fancybox();
	
	if (typeof(jQuery.fn.masonry) != 'undefined'){
		
		jQuery('.socialStream').masonry({
		  
		  itemSelector: '.socialItem',
		  gutter: 0
		});

		jQuery('ul.socialStream').show();
		
		var intervalmasonary = setInterval(function(){
		    jQuery('.socialStream').masonry();
		    clearInterval(intervalmasonary);
		    //do whatever here..
		}, 200); 
	    
	    var intervalmasonary2 = setInterval(function(){
		    jQuery('.socialStream').masonry();
		    clearInterval(intervalmasonary2);
		    //do whatever here..
		}, 1500); 
		

		
	}
	
	
	
	
});

