(function( $ ) {
	'use strict';


	$('.nav-tab-wrapper a').click(function(event){
		event.preventDefault();
		
		//wp-tab-panel
		// Limit effect to the container element.
		var context = $(this).closest('.nav-tab-wrapper').parent();
		$('.nav-tab-wrapper  a', context).removeClass('nav-tab-active');
		$(this).closest(' a').addClass('nav-tab-active');
		$('.tab-content', context).hide();
		$( $(this).attr('href'), context ).show();
	});

	// Make setting wp-tab-active optional.
	$('.nav-tab-wrapper').each(function(){
		if ( $('.nav-tab-active', this).length )
			$('.nav-tab-active', this).click();
		else
			$('a', this).first().click();
	});


})( jQuery );
