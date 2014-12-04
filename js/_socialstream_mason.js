
$(document).ready(function(){
	$(".socialStream").mason({
	    itemSelector: ".socialItem",
	    ratio: 1,
	    sizes: [
	        [1,1],
	        [1,2],
	        [2,1],
	        [2,2]
	    ],
	    gutter: 0
	});
	
	$(window).resize(function(){
		$(".socialStream").mason({
	    itemSelector: ".socialItem",
	    ratio: 1,
	    sizes: [
	        [1,1],
	        [1,2],
	        [2,1],
	        [2,2]
	    ],
	    gutter: 0
	});	
	});
	
});