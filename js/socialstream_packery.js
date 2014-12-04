
$(document).ready(function(){
	
	
	
	// init
	$('.socialStream').packery({
	  itemSelector: '.socialItem',
	  gutter: 0
	});
	
	
	
	var intervalpackery = setInterval(function(){
	    $('.socialStream').packery({
		  itemSelector: '.socialItem',
		  gutter: 0
		});
	}, 210); 
	
	//$(".fancybox2").fancybox();
});